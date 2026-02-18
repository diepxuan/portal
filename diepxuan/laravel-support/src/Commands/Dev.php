<?php

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class Dev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev
        {action : Action to perform (start|stop|status|vite|build|fix|setup|cleanup)}
        {--port=8000 : Port to run the development server}
        {--host=0.0.0.0 : Host to bind the server}
        {--no-vite : Do not start Vite server}
        {--force : Force action without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Portal development environment management';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $method = 'handle' . Str::studly($action);

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        $this->error("Unknown action: {$action}");
        $this->showHelp();
        
        return 1;
    }

    /**
     * Start development server.
     */
    protected function handleStart()
    {
        $this->info('🚀 Starting Portal development environment...');
        
        // Fix Vite manifest
        $this->callSilently('dev:fix');
        
        // Setup environment
        $this->callSilently('dev:setup');
        
        // Start PHP server
        $port = $this->option('port');
        $host = $this->option('host');
        
        $this->info("Starting server on {$host}:{$port}...");
        
        // Check if already running
        if ($this->isPortInUse($port)) {
            $this->warn("Port {$port} is already in use.");
            if (!$this->option('force') && !$this->confirm('Stop existing server and continue?')) {
                return 1;
            }
            $this->callSilently('dev:stop');
        }
        
        // Start server in background
        $artisan = base_path('artisan');
        $command = "php {$artisan} serve --host={$host} --port={$port}";
        
        $process = Process::start($command);
        $pid = $process->id();
        
        file_put_contents($this->getPidFile('portal'), $pid);
        
        $this->info("✅ Portal server started (PID: {$pid})");
        $this->info("🌐 URL: http://{$host}:{$port}");
        
        // Start Vite if not disabled
        if (!$this->option('no-vite')) {
            if ($this->confirm('Start Vite development server?')) {
                $this->callSilently('dev:vite');
            }
        }
        
        $this->newLine();
        $this->info('Development environment ready!');
        $this->line('Manage with: php artisan dev:status');
        $this->line('Stop with: php artisan dev:stop');
        
        return 0;
    }

    /**
     * Stop development server.
     */
    protected function handleStop()
    {
        $this->info('🛑 Stopping development environment...');
        
        // Stop Vite
        $vitePidFile = $this->getPidFile('vite');
        if (file_exists($vitePidFile)) {
            $pid = file_get_contents($vitePidFile);
            if ($this->killProcess($pid)) {
                $this->info("✅ Vite server stopped (PID: {$pid})");
            }
            unlink($vitePidFile);
        }
        
        // Stop Portal
        $portalPidFile = $this->getPidFile('portal');
        if (file_exists($portalPidFile)) {
            $pid = file_get_contents($portalPidFile);
            if ($this->killProcess($pid)) {
                $this->info("✅ Portal server stopped (PID: {$pid})");
            }
            unlink($portalPidFile);
        }
        
        // Kill any remaining processes
        Process::run('pkill -f "artisan serve"');
        Process::run('pkill -f "vite"');
        
        $this->info('✅ All development services stopped');
        
        return 0;
    }

    /**
     * Show development status.
     */
    protected function handleStatus()
    {
        $this->info('📊 Development Environment Status');
        $this->line('================================');
        
        // Check Portal server
        $portalPidFile = $this->getPidFile('portal');
        if (file_exists($portalPidFile)) {
            $pid = file_get_contents($portalPidFile);
            if ($this->isProcessRunning($pid)) {
                $this->info("✅ Portal: RUNNING (PID: {$pid})");
                
                $port = $this->option('port');
                $host = $this->option('host');
                $this->line("   URL: http://{$host}:{$port}");
                
                // Check if responding
                if ($this->checkServerResponse($host, $port)) {
                    $this->line('   Status: ✅ Responding');
                } else {
                    $this->line('   Status: ❌ Not responding');
                }
            } else {
                $this->error("❌ Portal: STOPPED (stale PID: {$pid})");
                unlink($portalPidFile);
            }
        } else {
            $this->error('❌ Portal: STOPPED');
        }
        
        // Check Vite server
        $vitePidFile = $this->getPidFile('vite');
        if (file_exists($vitePidFile)) {
            $pid = file_get_contents($vitePidFile);
            if ($this->isProcessRunning($pid)) {
                $this->info("✅ Vite: RUNNING (PID: {$pid})");
                $this->line('   URL: http://localhost:5173');
            } else {
                $this->error("❌ Vite: STOPPED (stale PID: {$pid})");
                unlink($vitePidFile);
            }
        } else {
            $this->error('❌ Vite: STOPPED');
        }
        
        // Check ports
        $this->newLine();
        $this->info('🌐 Port Status:');
        
        $port = $this->option('port');
        if ($this->isPortInUse($port)) {
            $this->line("   Port {$port}: ✅ LISTENING");
        } else {
            $this->line("   Port {$port}: ❌ NOT LISTENING");
        }
        
        if ($this->isPortInUse(5173)) {
            $this->line('   Port 5173: ✅ LISTENING (Vite)');
        } else {
            $this->line('   Port 5173: ❌ NOT LISTENING');
        }
        
        return 0;
    }

    /**
     * Start Vite development server.
     */
    protected function handleVite()
    {
        $this->info('⚡ Starting Vite development server...');
        
        // Check package.json
        if (!file_exists(base_path('package.json'))) {
            $this->error('package.json not found');
            return 1;
        }
        
        // Install dependencies if needed
        if (!file_exists(base_path('node_modules'))) {
            $this->warn('node_modules not found, installing dependencies...');
            Process::run('npm install', base_path());
        }
        
        // Start Vite
        $process = Process::start('npm run dev', base_path());
        $pid = $process->id();
        
        file_put_contents($this->getPidFile('vite'), $pid);
        
        $this->info("✅ Vite server started (PID: {$pid})");
        $this->info("🌐 URL: http://localhost:5173");
        $this->line('Logs: tail -f storage/logs/vite.log');
        
        return 0;
    }

    /**
     * Build production assets.
     */
    protected function handleBuild()
    {
        $this->info('🏗️ Building production assets...');
        
        if (!file_exists(base_path('package.json'))) {
            $this->error('package.json not found');
            return 1;
        }
        
        // Install dependencies if needed
        if (!file_exists(base_path('node_modules'))) {
            $this->warn('Installing dependencies...');
            Process::run('npm install', base_path());
        }
        
        $result = Process::run('npm run build', base_path());
        
        if ($result->successful()) {
            $this->info('✅ Assets built successfully');
            $this->line('Location: public/build/');
            
            // Create manifest if missing
            $manifestPath = public_path('build/manifest.json');
            if (!file_exists($manifestPath)) {
                $this->warn('Creating simple manifest...');
                file_put_contents($manifestPath, json_encode([
                    'resources/css/app.css' => [
                        'file' => 'assets/app.css',
                        'src' => 'resources/css/app.css',
                    ],
                    'resources/js/app.js' => [
                        'file' => 'assets/app.js',
                        'src' => 'resources/js/app.js',
                    ],
                ], JSON_PRETTY_PRINT));
            }
        } else {
            $this->error('Build failed');
            $this->line($result->errorOutput());
            return 1;
        }
        
        return 0;
    }

    /**
     * Fix Vite manifest error.
     */
    protected function handleFix()
    {
        $this->info('🔧 Fixing Vite manifest error...');
        
        $buildPath = public_path('build');
        $assetsPath = public_path('build/assets');
        
        // Create directories
        if (!file_exists($buildPath)) {
            mkdir($buildPath, 0755, true);
        }
        if (!file_exists($assetsPath)) {
            mkdir($assetsPath, 0755, true);
        }
        
        // Create manifest
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
        
        file_put_contents(
            public_path('build/manifest.json'),
            json_encode($manifest, JSON_PRETTY_PRINT)
        );
        
        // Create dummy assets
        file_put_contents(public_path('build/assets/app-dev.css'), '/* Development CSS */');
        file_put_contents(public_path('build/assets/app-dev.js'), '// Development JS');
        
        $this->info('✅ Vite manifest fixed');
        $this->line('Created: public/build/manifest.json');
        $this->line('Created: public/build/assets/app-dev.css');
        $this->line('Created: public/build/assets/app-dev.js');
        
        return 0;
    }

    /**
     * Setup development environment.
     */
    protected function handleSetup()
    {
        $this->info('⚙️ Setting up development environment...');
        
        // Create .env if missing
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            $examplePath = base_path('.env.example');
            if (file_exists($examplePath)) {
                copy($examplePath, $envPath);
                $this->info('✅ Created .env from .env.example');
            } else {
                $this->warn('.env.example not found, using defaults');
            }
        }
        
        // Generate app key if not set
        $envContent = file_get_contents($envPath);
        if (!str_contains($envContent, 'APP_KEY=base64:')) {
            $this->callSilently('key:generate');
            $this->info('✅ Generated application key');
        }
        
        // Setup SQLite if configured
        if (str_contains($envContent, 'DB_CONNECTION=sqlite')) {
            $dbPath = database_path('database.sqlite');
            if (!file_exists($dbPath)) {
                touch($dbPath);
                $this->info('✅ Created SQLite database');
                
                // Run migrations
                $this->callSilently('migrate', ['--force' => true]);
            }
        }
        
        // Clear cache
        $this->callSilently('config:clear');
        $this->callSilently('view:clear');
        $this->info('✅ Cache cleared');
        
        $this->info('✅ Development environment setup complete');
        
        return 0;
    }

    /**
     * Clean up development files.
     */
    protected function handleCleanup()
    {
        $this->info('🧹 Cleaning up development files...');
        
        // Stop services
        $this->callSilently('dev:stop');
        
        // Remove PID files
        $files = ['portal.pid', 'vite.pid'];
        foreach ($files as $file) {
            $path = storage_path("app/{$file}");
            if (file_exists($path)) {
                unlink($path);
            }
        }
        
        // Remove development assets
        $buildPath = public_path('build');
        if (file_exists($buildPath)) {
            $this->deleteDirectory($buildPath);
            $this->info('✅ Removed development assets');
        }
        
        // Clear cache
        $this->callSilently('config:clear');
        $this->callSilently('view:clear');
        $this->info('✅ Cache cleared');
        
        $this->info('✅ Cleanup complete');
        
        return 0;
    }

    /**
     * Show help information.
     */
    protected function showHelp()
    {
        $this->info('Portal Development Commands');
        $this->line('===========================');
        $this->newLine();
        
        $this->line('Available actions:');
        $this->line('  start     Start development server');
        $this->line('  stop      Stop development server');
        $this->line('  status    Check development status');
        $this->line('  vite      Start Vite development server');
        $this->line('  build     Build production assets');
        $this->line('  fix       Fix Vite manifest error');
        $this->line('  setup     Setup development environment');
        $this->line('  cleanup   Clean up development files');
        $this->newLine();
        
        $this->line('Examples:');
        $this->line('  php artisan dev start');
        $this->line('  php artisan dev status');
        $this->line('  php artisan dev build');
        $this->newLine();
        
        $this->line('Development URLs:');
        $this->line('  Portal: http://localhost:8000');
        $this->line('  Vite:   http://localhost:5173');
    }

    /**
     * Get PID file path.
     */
    private function getPidFile(string $service): string
    {
        return storage_path("app/{$service}.pid");
    }

    /**
     * Check if process is running.
     */
    private function isProcessRunning(int $pid): bool
    {
        return Process::run("ps -p {$pid}")->successful();
    }

    /**
     * Kill a process.
     */
    private function killProcess(int $pid): bool
    {
        return Process::run("kill {$pid} 2>/dev/null")->successful();
    }

    /**
     * Check if port is in use.
     */
    private function isPortInUse(int $port): bool
    {
        $result = Process::run("lsof -ti:{$port}");
        return $result->successful() && !empty(trim($result->output()));
    }

    /**
     * Check server response.
     */
    private function checkServerResponse(string $host, int $port): bool
    {
        $result = Process::run("curl -s -o /dev/null -w '%{http_code}' http://{$host}:{$port}");
        $code = trim($result->output());
        return in_array($code, ['200', '301', '302', '304']);
    }

    /**
     * Delete directory recursively.
     */
    private function deleteDirectory(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }
        
        $files = array_diff(scandir($path), ['.', '..']);
        foreach ($files as $file) {
            $filePath = "{$path}/{$file}";
            is_dir($filePath) ? $this->deleteDirectory($filePath) : unlink($filePath);
        }
        
        rmdir($path);
    }
}