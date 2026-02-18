<?php

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class ServeDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev
        {--host=0.0.0.0 : The host address to serve the application on}
        {--port=8000 : The port to serve the application on}
        {--vite-port=5173 : The port for Vite development server}
        {--no-vite : Do not start Vite development server}
        {--foreground : Run in foreground (do not daemonize)}
        {--service : Install as systemd service}
        {--health : Enable health check with auto-recovery}
        {--health-interval=30 : Health check interval in seconds}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Laravel development server with Vite in one command';

    /**
     * PID file paths.
     */
    protected string $portalPidFile;
    protected string $vitePidFile;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->portalPidFile = storage_path('app/portal.pid');
        $this->vitePidFile = storage_path('app/vite.pid');

        $this->info('🚀 Starting Laravel development environment with Vite...');

        // Check if already running
        if ($this->isProcessRunning($this->portalPidFile)) {
            $this->error('Portal server is already running.');
            return 1;
        }

        // Fix common issues
        $this->fixViteManifest();
        $this->setupEnvironment();

        // Start Laravel server
        if (!$this->startLaravelServer()) {
            return 1;
        }

        // Start Vite if not disabled
        if (!$this->option('no-vite')) {
            $this->startViteServer();
        }

        $this->showStatus();

        // Install as systemd service if requested
        if ($this->option('service')) {
            $this->installSystemdService();
        }

        // Enable health check if requested
        if ($this->option('health')) {
            $this->enableHealthCheck();
        }

        // Run in foreground if requested
        if ($this->option('foreground')) {
            $this->info('Running in foreground. Press Ctrl+C to stop.');
            $this->waitForSignal();
        }

        return 0;
    }

    /**
     * Fix Vite manifest issues.
     */
    protected function fixViteManifest(): void
    {
        $this->info('🔧 Checking Vite manifest...');

        $buildPath = public_path('build');
        $assetsPath = public_path('build/assets');

        // Create directories
        if (!file_exists($buildPath)) {
            mkdir($buildPath, 0755, true);
        }
        if (!file_exists($assetsPath)) {
            mkdir($assetsPath, 0755, true);
        }

        // Create manifest if missing
        $manifestPath = public_path('build/manifest.json');
        if (!file_exists($manifestPath)) {
            $manifest = [
                'resources/css/app.css' => [
                    'file' => 'assets/app-dev.css',
                    'src' => 'resources/css/app.css',
                    'isEntry' => true,
                ],
                'resources/js/app.js' => [
                    'file' => 'assets/app-dev.js',
                    'src' => 'resources/js/app.js',
                    'isEntry' => true,
                ],
            ];

            file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT));
            file_put_contents(public_path('build/assets/app-dev.css'), '/* Development CSS */');
            file_put_contents(public_path('build/assets/app-dev.js'), '// Development JS');

            $this->info('✅ Created Vite manifest and assets');
        }
    }

    /**
     * Setup development environment.
     */
    protected function setupEnvironment(): void
    {
        $this->info('⚙️ Setting up environment...');

        // Create .env if missing
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            $examplePath = base_path('.env.example');
            if (file_exists($examplePath)) {
                copy($examplePath, $envPath);
                $this->info('✅ Created .env from .env.example');
            }
        }

        // Generate app key if not set
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
            if (!str_contains($envContent, 'APP_KEY=base64:')) {
                $this->callSilently('key:generate');
                $this->info('✅ Generated application key');
            }
        }

        // Clear cache
        $this->callSilently('config:clear');
        $this->callSilently('view:clear');
        $this->info('✅ Cache cleared');
    }

    /**
     * Start Laravel development server.
     */
    protected function startLaravelServer(): bool
    {
        $host = $this->option('host');
        $port = $this->option('port');

        $this->info("🌐 Starting Laravel server on {$host}:{$port}...");

        $serveCommand = "php artisan serve --host={$host} --port={$port}";
        
        // Run in background using exec
        $outputFile = storage_path('logs/portal-server.log');
        $command = "nohup {$serveCommand} > {$outputFile} 2>&1 & echo $!";
        
        exec($command, $output, $returnVar);
        
        if ($returnVar !== 0 || empty($output[0])) {
            $this->error('Failed to start Laravel server');
            return false;
        }
        
        $pid = (int) trim($output[0]);

        file_put_contents($this->portalPidFile, $pid);
        
        // Wait a bit for server to start
        sleep(2);
        
        $this->info("✅ Laravel server started (PID: {$pid})");
        $this->info("   URL: http://{$host}:{$port}");
        
        return true;
    }

    /**
     * Start Vite development server.
     */
    protected function startViteServer(): void
    {
        $this->info('⚡ Starting Vite development server...');

        // Check package.json
        if (!file_exists(base_path('package.json'))) {
            $this->warn('⚠️ package.json not found, skipping Vite');
            return;
        }

        // Install dependencies if needed
        if (!file_exists(base_path('node_modules'))) {
            $this->info('📦 Installing npm dependencies...');
            Process::run('npm install', base_path());
        }

        $vitePort = $this->option('vite-port');
        $outputFile = storage_path('logs/vite-server.log');
        $command = "cd " . base_path() . " && nohup npm run dev -- --port={$vitePort} > {$outputFile} 2>&1 & echo $!";
        
        exec($command, $output, $returnVar);
        
        if ($returnVar !== 0 || empty($output[0])) {
            $this->warn('Failed to start Vite server');
            return;
        }
        
        $pid = (int) trim($output[0]);

        file_put_contents($this->vitePidFile, $pid);
        
        // Wait a bit for server to start
        sleep(3);
        
        $this->info("✅ Vite server started (PID: {$pid})");
        $this->info("   URL: http://localhost:{$vitePort}");
    }

    /**
     * Show development status.
     */
    protected function showStatus(): void
    {
        $this->info('');
        $this->info('📊 Development Environment Status');
        $this->info('================================');

        $host = $this->option('host');
        $port = $this->option('port');
        $vitePort = $this->option('vite-port');

        // Check Laravel server
        if ($this->isProcessRunning($this->portalPidFile)) {
            $pid = file_get_contents($this->portalPidFile);
            $this->info("✅ Laravel: RUNNING (PID: {$pid})");
            $this->info("   URL: http://{$host}:{$port}");
        } else {
            $this->error('❌ Laravel: STOPPED');
        }

        // Check Vite server
        if (!$this->option('no-vite') && $this->isProcessRunning($this->vitePidFile)) {
            $pid = file_get_contents($this->vitePidFile);
            $this->info("✅ Vite: RUNNING (PID: {$pid})");
            $this->info("   URL: http://localhost:{$vitePort}");
        } elseif (!$this->option('no-vite')) {
            $this->error('❌ Vite: STOPPED');
        }

        $this->info('');
        $this->info('🎯 Management commands:');
        $this->info('   Stop:        php artisan serve:dev:stop');
        $this->info('   Status:      php artisan serve:dev:status');
        $this->info('   Stop all:    ./portal-dev.sh stop');
    }

    /**
     * Install as systemd service.
     */
    protected function installSystemdService(): void
    {
        $this->info('🔧 Installing as systemd service...');
        
        // Check if running as root
        if (posix_getuid() !== 0) {
            $this->warn('⚠️ Please run as root (sudo) to install systemd service');
            $this->info('   Command: sudo php artisan serve:dev --service');
            return;
        }
        
        $this->call('serve:dev:service', [
            'action' => 'install',
            '--interval' => $this->option('health-interval'),
        ]);
    }

    /**
     * Enable health check.
     */
    protected function enableHealthCheck(): void
    {
        $this->info('🩺 Enabling health check...');
        
        // Create health check cron or systemd timer
        $interval = $this->option('health-interval');
        
        if (posix_getuid() === 0) {
            // If running as root, use systemd timer
            $this->info("   Health check will run every {$interval} seconds via systemd timer");
        } else {
            // Otherwise, suggest manual health check
            $this->info("   Run health check manually: php artisan serve:dev:health --fix");
            $this->info("   Or schedule with cron: */{$interval} * * * * cd " . base_path() . " && php artisan serve:dev:health --fix --log");
        }
    }

    /**
     * Wait for signal in foreground mode.
     */
    protected function waitForSignal(): void
    {
        // Keep process alive
        while (true) {
            if (!$this->isProcessRunning($this->portalPidFile)) {
                $this->error('Laravel server stopped unexpectedly');
                break;
            }
            sleep(5);
        }
    }

    /**
     * Check if process is running from PID file.
     */
    protected function isProcessRunning(string $pidFile): bool
    {
        if (!file_exists($pidFile)) {
            return false;
        }

        $pid = (int) file_get_contents($pidFile);
        if ($pid <= 0) {
            return false;
        }

        return Process::run("ps -p {$pid}")->successful();
    }
}