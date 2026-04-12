<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-12 23:52:30
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

/**
 * Watch docs changes and auto-sync.
 *
 * Sử dụng: php artisan docs:watch --foreground
 */
class DocsWatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:watch
        {--source=/root/.openclaw/workspace/projects/SimbaSql/docs : Source directory}
        {--dest=/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/docs : Destination directory}
        {--foreground : Run in foreground (do not daemonize)}
        {--service : Install as systemd service}
        {--interval=5 : Debounce interval in seconds (default 5)}
        {--log : Log to storage/logs/docs-sync.log}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watch documentation changes and auto-sync';

    /**
     * Log file path.
     */
    protected string $logFile;

    /**
     * PID file path.
     */
    protected string $pidFile;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->logFile  = storage_path('logs/docs-sync.log');
        $this->pidFile  = storage_path('app/docs-watch.pid');
        $source         = $this->option('source');
        $dest           = $this->option('dest');
        $foreground     = $this->option('foreground');
        $installService = $this->option('service');

        $this->info('👁️ Documentation Watcher');
        $this->info('========================');

        // Check requirements
        if (!$this->checkRequirements()) {
            return 1;
        }

        // Validate directories
        if (!is_dir($source)) {
            $this->error("Lỗi: Source directory not found: {$source}");

            return 1;
        }

        if (!is_dir($dest)) {
            $this->info("Creating destination directory: {$dest}");
            mkdir($dest, 0755, true);
        }

        // Install service if requested
        if ($installService) {
            return $this->installService();
        }

        // Initial sync
        $this->info('');
        $this->info('🔄 Running initial sync...');
        $this->call('docs:sync', [
            '--source' => $source,
            '--dest'   => $dest,
        ]);

        // Run in foreground or background
        if ($foreground) {
            $this->info('');
            $this->info('▶️  Starting watcher in foreground...');
            $this->log('Starting docs watcher in foreground');
            $this->savePid();
            $this->watchLoop($source, $dest);
        } else {
            $this->info('▶️  Starting watcher in background...');
            $this->startBackground($source, $dest);
        }

        return 0;
    }

    /**
     * Check and install requirements.
     */
    protected function checkRequirements(): bool
    {
        $this->info('');
        $this->info('📦 Checking requirements...');

        // Check inotify-tools
        $result = Process::run('which inotifywait');

        if (!$result->successful()) {
            $this->warn('inotifywait not found. Installing inotify-tools...');

            if (!$this->installInotifyTools()) {
                $this->error('Failed to install inotify-tools. Please install manually:');
                $this->line('  Ubuntu/Debian: sudo apt-get install inotify-tools');
                $this->line('  CentOS/RHEL: sudo yum install inotify-tools');

                return false;
            }

            $this->info('OK: inotify-tools installed');
        } else {
            $this->info('OK: inotifywait found');
        }

        // Check rsync (optional but recommended)
        $result = Process::run('which rsync');
        if ($result->successful()) {
            $this->info('OK: rsync found');
        } else {
            $this->warn('rsync not found. Will use cp as fallback.');
        }

        return true;
    }

    /**
     * Install inotify-tools package.
     */
    protected function installInotifyTools(): bool
    {
        // Detect package manager
        $commands = [
            'apt-get install -y inotify-tools',
            'yum install -y inotify-tools',
            'dnf install -y inotify-tools',
            'apk add inotify-tools',
        ];

        foreach ($commands as $cmd) {
            $this->line("Trying: {$cmd}");
            $result = Process::run("sudo {$cmd}");

            if ($result->successful()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Install systemd service.
     */
    protected function installService(): int
    {
        $this->info('');
        $this->info('🔧 Installing systemd service...');

        // Check if running as root
        if (0 !== posix_getuid()) {
            $this->error('Lỗi: Please run with sudo to install service');
            $this->line('Usage: sudo php artisan docs:watch --service');

            return 1;
        }

        $serviceDir  = '/etc/systemd/system';
        $serviceName = 'portal-docs-watch';

        // Create service file
        $serviceContent = $this->getServiceTemplate();
        $serviceFile    = "{$serviceDir}/{$serviceName}.service";

        if (!file_put_contents($serviceFile, $serviceContent)) {
            $this->error("Lỗi: Failed to create service file: {$serviceFile}");

            return 1;
        }
        $this->info("Đã Service file created: {$serviceFile}");

        // Reload systemd
        $this->info('🔄 Reloading systemd...');
        Process::run('systemctl daemon-reload');

        // Enable service
        $this->info('⚙️ Enabling service...');
        Process::run("systemctl enable {$serviceName}.service");

        // Start service
        $this->info('▶️  Starting service...');
        $result = Process::run("systemctl start {$serviceName}.service");

        if ($result->successful()) {
            $this->info('');
            $this->info('✅ Service installed and started successfully!');
            $this->info('');
            $this->info('Management commands:');
            $this->info("  sudo systemctl status {$serviceName}.service");
            $this->info("  sudo systemctl stop {$serviceName}.service");
            $this->info("  sudo systemctl restart {$serviceName}.service");
            $this->info("  journalctl -u {$serviceName}.service -f");

            return 0;
        }

        $this->error('Failed to start service');

        return 1;
    }

    /**
     * Get systemd service template.
     */
    protected function getServiceTemplate(): string
    {
        $source = $this->option('source');
        $dest   = $this->option('dest');
        $php    = Process::run('which php')->output();

        return <<<EOT
            [Unit]
            Description=Portal Documentation Sync Watcher
            After=network.target

            [Service]
            Type=simple
            User=root
            Group=root
            WorkingDirectory=/root/.openclaw/workspace/projects/portal
            Environment="PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"
            Environment="SOURCE={$source}"
            Environment="DEST={$dest}"
            ExecStart={$php}artisan docs:watch --foreground --source={$source} --dest={$dest}
            Restart=always
            RestartSec=10
            KillMode=process
            KillSignal=SIGTERM
            TimeoutStopSec=30
            SyslogIdentifier=portal-docs-watch
            StandardOutput=journal
            StandardError=journal

            [Install]
            WantedBy=multi-user.target
            EOT;
    }

    /**
     * Start watcher in background.
     */
    protected function startBackground(string $source, string $dest): void
    {
        $outputFile = $this->logFile;
        $php        = Process::run('which php')->output();

        $command = "nohup {$php} artisan docs:watch --foreground --source={$source} --dest={$dest} > {$outputFile} 2>&1 & echo \$!";

        exec($command, $output, $returnVar);

        if (0 !== $returnVar || empty($output[0])) {
            $this->error('Failed to start watcher in background');

            return;
        }

        $pid = (int) trim($output[0]);
        file_put_contents($this->pidFile, $pid);

        $this->info("Watcher started (PID: {$pid})");
        $this->info("Log file: {$this->logFile}");
        $this->info('');
        $this->info('Management commands:');
        $this->info('  Stop:  php artisan docs:watch:stop');
        $this->info('  Status: php artisan docs:watch:status');
    }

    /**
     * Main watch loop using inotifywait.
     */
    protected function watchLoop(string $source, string $dest): void
    {
        $interval = (int) $this->option('interval');
        $lastSync = 0;
        $debounce = [];

        $this->info("Watching: {$source}");
        $this->info("Destination: {$dest}");
        $this->info("Debounce interval: {$interval}s");
        $this->info('');
        $this->info('Press Ctrl+C to stop');
        $this->info('');

        // Declare ticks for signal handling
        declare(ticks=1);

        // Setup signal handlers
        pcntl_signal(SIGTERM, function () use (&$running): void {
            $this->info("\n🛑 Received SIGTERM, stopping...");
            $this->cleanup();

            exit(0);
        });

        pcntl_signal(SIGINT, function () use (&$running): void {
            $this->info("\n🛑 Received SIGINT, stopping...");
            $this->cleanup();

            exit(0);
        });

        while (true) {
            pcntl_signal_dispatch();

            // Run inotifywait with timeout to allow signal handling
            $result = Process::timeout(5)->run([
                'inotifywait',
                '-r',
                '-e', 'modify,create,delete,move',
                '--format', '%w%f %e',
                '--timeout', '5',
                $source,
            ]);

            if ($result->successful() && !empty(trim($result->output()))) {
                $output = trim($result->output());
                $lines  = explode("\n", $output);

                foreach ($lines as $line) {
                    if (empty(trim($line))) {
                        continue;
                    }

                    [$filePath, $event] = explode(' ', $line, 2);
                    $relativePath       = str_replace(rtrim($source, '/') . '/', '', $filePath);

                    $this->info("📄 Detected: {$relativePath} - {$event}");
                    $this->log("Detected: {$relativePath} - {$event}");

                    // Debounce: wait for interval before syncing
                    $debounce[$relativePath] = time();
                }

                // Check if debounce interval has passed
                $now = time();
                if ($now - $lastSync >= $interval) {
                    $this->syncNow($source, $dest);
                    $lastSync = $now;
                    $debounce = [];
                }
            }

            // Sync if debounce interval has passed
            if (!empty($debounce) && (time() - $lastSync >= $interval)) {
                $this->syncNow($source, $dest);
                $lastSync = time();
                $debounce = [];
            }
        }
    }

    /**
     * Sync files now.
     */
    protected function syncNow(string $source, string $dest): void
    {
        $this->info('🔄 Syncing...');

        $result = $this->call('docs:sync', [
            '--source' => $source,
            '--dest'   => $dest,
        ]);

        if (0 === $result) {
            $this->info('✅ Sync completed');
            $this->log('Sync completed successfully');
        } else {
            $this->error('❌ Sync failed');
            $this->log('Sync failed with exit code: ' . $result);
        }
    }

    /**
     * Save PID file.
     */
    protected function savePid(): void
    {
        $pid = getmypid();
        file_put_contents($this->pidFile, $pid);
        $this->log("Watcher started with PID: {$pid}");
    }

    /**
     * Cleanup on exit.
     */
    protected function cleanup(): void
    {
        if (file_exists($this->pidFile)) {
            unlink($this->pidFile);
        }
        $this->log('Watcher stopped');
    }

    /**
     * Log message.
     */
    protected function log(string $message): void
    {
        if ($this->option('log')) {
            $logMessage = '[' . now()->format('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
            file_put_contents($this->logFile, $logMessage, FILE_APPEND);
        }

        Log::info('[DocsWatch] ' . $message);
    }
}
