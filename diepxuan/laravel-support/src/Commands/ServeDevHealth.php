<?php

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class ServeDevHealth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev:health
        {--fix : Auto-fix if server is down}
        {--interval=30 : Health check interval in seconds}
        {--once : Run once and exit}
        {--log : Log to storage/logs/health-check.log}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Health check for development servers with auto-recovery';

    /**
     * PID file paths.
     */
    protected $portalPidFile;
    protected $vitePidFile;
    protected $logFile;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->portalPidFile = storage_path('app/portal.pid');
        $this->vitePidFile = storage_path('app/vite.pid');
        $this->logFile = storage_path('logs/health-check.log');

        $this->info('🔍 Development Servers Health Check');
        $this->info('====================================');

        $laravelOk = $this->checkLaravel();
        $viteOk = $this->checkVite();

        if ($laravelOk && $viteOk) {
            $this->info('✅ All servers healthy');
            return 0;
        }

        if ($this->option('fix')) {
            $this->autoFix($laravelOk, $viteOk);
        } else {
            $this->warn('⚠️  Some servers are down. Use --fix to auto-repair.');
        }

        return $laravelOk && $viteOk ? 0 : 1;
    }

    /**
     * Check Laravel server.
     */
    protected function checkLaravel(): bool
    {
        $this->info('');
        $this->info('🌐 Laravel Server:');

        // Check port
        if (!$this->isPortListening(8000)) {
            $this->error('   Port:    ❌ 8000 NOT LISTENING');
            return false;
        }
        $this->info('   Port:    ✅ 8000 LISTENING');

        // Check HTTP response
        $response = $this->checkHttpResponse(8000);
        $this->info("   HTTP:    {$response}");

        // Check process
        if (!file_exists($this->portalPidFile)) {
            $this->error('   Process: ❌ NO PID FILE');
            return false;
        }

        $pid = (int) file_get_contents($this->portalPidFile);
        if (!$this->isProcessRunning($pid)) {
            $this->error("   Process: ❌ STOPPED (PID: {$pid})");
            unlink($this->portalPidFile);
            return false;
        }

        $this->info("   Process: ✅ RUNNING (PID: {$pid})");
        return true;
    }

    /**
     * Check Vite server.
     */
    protected function checkVite(): bool
    {
        $this->info('');
        $this->info('⚡ Vite Server:');

        // Check port
        if (!$this->isPortListening(5173)) {
            $this->error('   Port:    ❌ 5173 NOT LISTENING');
            return false;
        }
        $this->info('   Port:    ✅ 5173 LISTENING');

        // Check process
        if (!file_exists($this->vitePidFile)) {
            $this->error('   Process: ❌ NO PID FILE');
            return false;
        }

        $pid = (int) file_get_contents($this->vitePidFile);
        if (!$this->isProcessRunning($pid)) {
            $this->error("   Process: ❌ STOPPED (PID: {$pid})");
            unlink($this->vitePidFile);
            return false;
        }

        $this->info("   Process: ✅ RUNNING (PID: {$pid})");
        return true;
    }

    /**
     * Auto-fix servers.
     */
    protected function autoFix(bool $laravelOk, bool $viteOk): void
    {
        $this->info('');
        $this->info('🔧 Auto-fix Mode');

        if (!$laravelOk && !$viteOk) {
            $this->warn('🚨 Both servers down - restarting entire service...');
            $this->call('serve:dev:stop');
            sleep(2);
            $this->call('serve:dev');
            return;
        }

        if (!$laravelOk) {
            $this->warn('⚠️ Laravel server down - restarting...');
            $this->restartLaravel();
        }

        if (!$viteOk) {
            $this->warn('⚠️ Vite server down - restarting...');
            $this->restartVite();
        }
    }

    /**
     * Restart Laravel server.
     */
    protected function restartLaravel(): void
    {
        // Stop if running
        if (file_exists($this->portalPidFile)) {
            $pid = (int) file_get_contents($this->portalPidFile);
            if ($this->isProcessRunning($pid)) {
                Process::run("kill {$pid}");
            }
            unlink($this->portalPidFile);
        }

        // Start Laravel
        $process = Process::start('php artisan serve --host=0.0.0.0 --port=8000');
        file_put_contents($this->portalPidFile, $process->id());

        $this->info("✅ Laravel restarted (PID: {$process->id()})");
        sleep(3); // Wait for server to start
    }

    /**
     * Restart Vite server.
     */
    protected function restartVite(): void
    {
        // Stop if running
        if (file_exists($this->vitePidFile)) {
            $pid = (int) file_get_contents($this->vitePidFile);
            if ($this->isProcessRunning($pid)) {
                Process::run("kill {$pid}");
            }
            unlink($this->vitePidFile);
        }

        // Start Vite
        $process = Process::start('npm run dev');
        file_put_contents($this->vitePidFile, $process->id());

        $this->info("✅ Vite restarted (PID: {$process->id()})");
        sleep(3); // Wait for server to start
    }

    /**
     * Check if port is listening.
     */
    protected function isPortListening(int $port): bool
    {
        $result = Process::run("ss -tln 2>/dev/null | grep :{$port} || netstat -tln 2>/dev/null | grep :{$port}");
        return $result->successful() && !empty(trim($result->output()));
    }

    /**
     * Check HTTP response.
     */
    protected function checkHttpResponse(int $port): string
    {
        $result = Process::run("curl -s -o /dev/null -w '%{http_code}' http://localhost:{$port} 2>/dev/null || echo 'TIMEOUT'");
        $code = trim($result->output());
        
        if (in_array($code, ['200', '301', '302', '304'])) {
            return "✅ {$code} OK";
        } elseif ($code === 'TIMEOUT') {
            return "❌ TIMEOUT";
        } else {
            return "⚠️ {$code}";
        }
    }

    /**
     * Check if process is running.
     */
    protected function isProcessRunning(int $pid): bool
    {
        return Process::run("ps -p {$pid}")->successful();
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
    }
}