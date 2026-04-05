<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-05 23:27:19
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ServeDevService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev:service
        {action : install|uninstall|start|stop|restart|status|enable|disable}
        {--name=portal : Service name}
        {--user=root : Service user}
        {--group=root : Service group}
        {--interval=30 : Health check interval in seconds}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage systemd service for development servers';

    /**
     * Service template.
     *
     * SYSTEMD SERVICE FIXES - 2026-04-05:
     *
     * Issue: Service failed to start properly, causing restart loops and zombie processes.
     *
     * Root Causes:
     * 1. Type=simple with daemonizing command: The `serve:dev` command spawns child processes
     *    (php artisan serve, npm run vite) and the main process exits. With Type=simple,
     *    systemd thinks the service died when main process exits.
     *
     * 2. KillMode=process: Only kills the main process, leaving child processes (node, vite,
     *    esbuild) running as zombies. These accumulate over time and cause port conflicts.
     *
     * 3. ExecStartPost health check: Can cause transaction conflicts when stopping/restarting
     *    because systemd queues conflicting jobs (stop health check vs stop main service).
     *
     * Solutions Applied:
     * 1. Type=forking: Tells systemd to expect the main process to fork and exit, while
     *    children continue running. Matches actual behavior of serve:dev command.
     *
     * 2. KillMode=control-group: Kills ALL processes in the cgroup, ensuring no zombies.
     *
     * 3. Integrated --health flag: Health check is now part of main command, eliminating
     *    ExecStartPost conflicts.
     *
     * 4. TimeoutStopSec=60: Extended timeout for graceful shutdown of all child processes.
     */
    protected $serviceTemplate = <<<'EOT'
        [Unit]
        Description=Portal Development Service (PHP + Vite)
        After=network.target
        Requires=network.target

        [Service]
        Type=forking
        User={user}
        Group={group}
        WorkingDirectory={working_dir}
        Environment="PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"
        Environment="NODE_ENV=development"
        Environment="APP_ENV=local"

        # Main command - start serve:dev
        ExecStart=/usr/bin/php artisan serve:dev --foreground --health

        # Restart configuration
        Restart=always
        RestartSec=10
        StartLimitInterval=60
        StartLimitBurst=5

        # Health check

        # Logging
        StandardOutput=journal
        StandardError=journal
        SyslogIdentifier={service_name}

        # Process management
        KillMode=control-group
        KillSignal=SIGTERM
        TimeoutStopSec=60
        SendSIGKILL=yes

        [Install]
        WantedBy=multi-user.target
        EOT;

    /**
     * Timer template.
     */
    protected $timerTemplate = <<<'EOT'
        [Unit]
        Description={service_name} Health Check Timer
        Requires={service_name}.service
        After={service_name}.service

        [Timer]
        OnUnitActiveSec={interval}s
        OnBootSec=60s
        OnUnitInactiveSec={interval}s
        Persistent=true

        [Install]
        WantedBy=timers.target
        EOT;

    /**
     * Health service template.
     */
    protected $healthServiceTemplate = <<<'EOT'
        [Unit]
        Description={service_name} Health Check Service
        Requires={service_name}.service
        After={service_name}.service

        [Service]
        Type=oneshot
        User={user}
        Group={group}
        WorkingDirectory={working_dir}
        Environment="PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"

        # Run health check
        ExecStart=/usr/bin/php artisan serve:dev:health --fix --log

        # Logging
        StandardOutput=journal
        StandardError=journal
        SyslogIdentifier={service_name}-health
        EOT;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action      = $this->argument('action');
        $serviceName = $this->option('name');

        $this->info("🔧 Development Service: {$serviceName}");

        switch ($action) {
            case 'install':
                return $this->installService();

            case 'uninstall':
                return $this->uninstallService();

            case 'start':
                return $this->startService();

            case 'stop':
                return $this->stopService();

            case 'restart':
                return $this->restartService();

            case 'status':
                return $this->statusService();

            case 'enable':
                return $this->enableService();

            case 'disable':
                return $this->disableService();

            default:
                $this->error("Unknown action: {$action}");
                $this->info('Available actions: install, uninstall, start, stop, restart, status, enable, disable');

                return 1;
        }
    }

    /**
     * Install systemd service.
     */
    protected function installService(): int
    {
        $serviceName = $this->option('name');
        $serviceDir  = '/etc/systemd/system';

        $this->info("📦 Installing {$serviceName} service...");

        // Check if running as root
        if (0 !== posix_getuid()) {
            $this->error('❌ Please run as root (sudo)');

            return 1;
        }

        // Create service file
        $serviceContent = $this->renderTemplate($this->serviceTemplate);
        $serviceFile    = "{$serviceDir}/{$serviceName}.service";

        if (!file_put_contents($serviceFile, $serviceContent)) {
            $this->error("❌ Failed to create service file: {$serviceFile}");

            return 1;
        }
        $this->info("✅ Service file created: {$serviceFile}");

        // Create health service file
        $healthServiceContent = $this->renderTemplate($this->healthServiceTemplate);
        $healthServiceFile    = "{$serviceDir}/{$serviceName}-health.service";

        if (!file_put_contents($healthServiceFile, $healthServiceContent)) {
            $this->error("❌ Failed to create health service file: {$healthServiceFile}");

            return 1;
        }
        $this->info("✅ Health service file created: {$healthServiceFile}");

        // Create timer file
        $timerContent = $this->renderTemplate($this->timerTemplate);
        $timerFile    = "{$serviceDir}/{$serviceName}-health.timer";

        if (!file_put_contents($timerFile, $timerContent)) {
            $this->error("❌ Failed to create timer file: {$timerFile}");

            return 1;
        }
        $this->info("✅ Timer file created: {$timerFile}");

        // Reload systemd
        $this->info('🔄 Reloading systemd...');
        Process::run('systemctl daemon-reload');

        // Enable services
        $this->info('⚙️ Enabling services...');
        Process::run("systemctl enable {$serviceName}.service");
        Process::run("systemctl enable {$serviceName}-health.timer");

        $this->info('');
        $this->info('✅ Service installed successfully!');
        $this->info('');
        $this->info('🔧 Management commands:');
        $this->info("   sudo systemctl start {$serviceName}.service");
        $this->info("   sudo systemctl stop {$serviceName}.service");
        $this->info("   sudo systemctl restart {$serviceName}.service");
        $this->info("   sudo systemctl status {$serviceName}.service");
        $this->info('');
        $this->info('🩺 Health check:');
        $this->info("   Runs every {$this->option('interval')} seconds");
        $this->info('   Logs: journalctl -u portal.service -f');

        return 0;
    }

    /**
     * Uninstall systemd service.
     */
    protected function uninstallService(): int
    {
        $serviceName = $this->option('name');

        $this->info("🗑️ Uninstalling {$serviceName} service...");

        // Check if running as root
        if (0 !== posix_getuid()) {
            $this->error('❌ Please run as root (sudo)');

            return 1;
        }

        // Stop services
        Process::run("systemctl stop {$serviceName}-health.timer 2>/dev/null || true");
        Process::run("systemctl stop {$serviceName}.service 2>/dev/null || true");

        // Disable services
        Process::run("systemctl disable {$serviceName}.service 2>/dev/null || true");
        Process::run("systemctl disable {$serviceName}-health.timer 2>/dev/null || true");

        // Remove files
        $serviceDir = '/etc/systemd/system';
        $files      = [
            "{$serviceDir}/{$serviceName}.service",
            "{$serviceDir}/{$serviceName}-health.service",
            "{$serviceDir}/{$serviceName}-health.timer",
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
                $this->info("✅ Removed: {$file}");
            }
        }

        // Reload systemd
        Process::run('systemctl daemon-reload');
        Process::run('systemctl reset-failed');

        $this->info('✅ Service uninstalled successfully!');

        return 0;
    }

    /**
     * Start service.
     */
    protected function startService(): int
    {
        $serviceName = $this->option('name');

        $this->info("🚀 Starting {$serviceName} service...");

        $result = Process::run("systemctl start {$serviceName}.service");

        if ($result->successful()) {
            $this->info('✅ Service started');

            // Also start timer
            Process::run("systemctl start {$serviceName}-health.timer");
            $this->info('✅ Health timer started');

            return 0;
        }
        $this->error('❌ Failed to start service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Stop service.
     */
    protected function stopService(): int
    {
        $serviceName = $this->option('name');

        $this->info("🛑 Stopping {$serviceName} service...");

        $result = Process::run("systemctl stop {$serviceName}.service");

        if ($result->successful()) {
            $this->info('✅ Service stopped');

            // Also stop timer
            Process::run("systemctl stop {$serviceName}-health.timer");
            $this->info('✅ Health timer stopped');

            return 0;
        }
        $this->error('❌ Failed to stop service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Restart service.
     */
    protected function restartService(): int
    {
        $serviceName = $this->option('name');

        $this->info("🔄 Restarting {$serviceName} service...");

        $result = Process::run("systemctl restart {$serviceName}.service");

        if ($result->successful()) {
            $this->info('✅ Service restarted');

            return 0;
        }
        $this->error('❌ Failed to restart service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Check service status.
     */
    protected function statusService(): int
    {
        $serviceName = $this->option('name');

        $this->info("📊 {$serviceName} Service Status");
        $this->info('==============================');

        // Main service
        $this->info('');
        $this->info('🌐 Main Service:');
        $result = Process::run("systemctl status {$serviceName}.service --no-pager");
        $this->line($result->output());

        // Timer
        $this->info('');
        $this->info('🩺 Health Timer:');
        $result = Process::run("systemctl status {$serviceName}-health.timer --no-pager");
        $this->line($result->output());

        return 0;
    }

    /**
     * Enable service.
     */
    protected function enableService(): int
    {
        $serviceName = $this->option('name');

        $this->info("⚙️ Enabling {$serviceName} service...");

        $result = Process::run("systemctl enable {$serviceName}.service");

        if ($result->successful()) {
            $this->info('✅ Service enabled');

            // Also enable timer
            Process::run("systemctl enable {$serviceName}-health.timer");
            $this->info('✅ Health timer enabled');

            return 0;
        }
        $this->error('❌ Failed to enable service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Disable service.
     */
    protected function disableService(): int
    {
        $serviceName = $this->option('name');

        $this->info("⚙️ Disabling {$serviceName} service...");

        $result = Process::run("systemctl disable {$serviceName}.service");

        if ($result->successful()) {
            $this->info('✅ Service disabled');

            // Also disable timer
            Process::run("systemctl disable {$serviceName}-health.timer");
            $this->info('✅ Health timer disabled');

            return 0;
        }
        $this->error('❌ Failed to disable service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Render template with variables.
     */
    protected function renderTemplate(string $template): string
    {
        $variables = [
            '{service_name}' => $this->option('name'),
            '{user}'         => $this->option('user'),
            '{group}'        => $this->option('group'),
            '{working_dir}'  => base_path(),
            '{interval}'     => $this->option('interval'),
        ];

        return str_replace(array_keys($variables), array_values($variables), $template);
    }
}
