<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-02-28 14:48:11
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ServeDevStop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev:stop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop Laravel development server and Vite';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Stopping development servers...');

        try {
            $this->stopPortal();
        } catch (\Throwable $th) {
            $this->info('Portal server gặp lỗi khi stop');
        }

        try {
            $this->stopVite();
        } catch (\Throwable $th) {
            $this->info('Vite server gặp lỗi khi stop');
        }

        try {
            $this->stopAnotherProcess();
        } catch (\Throwable $th) {
            $this->info('Tắt các process khác gặp lỗi khi stop');
        }

        return 0;
    }

    // Stop Laravel server
    public function stopPortal(): void
    {
        $portalPidFile = storage_path('app/portal.pid');
        if (file_exists($portalPidFile)) {
            $pid = (int) file_get_contents($portalPidFile);
            if ($pid > 0 && $this->isProcessAlive($pid)) {
                // Graceful shutdown: SIGTERM
                Process::run("kill {$pid} 2>/dev/null");
                $this->info("Sent SIGTERM to Laravel server (PID: {$pid})");
                // Wait up to 3 seconds for process to exit
                $killed = $this->waitForProcessExit($pid, 3);
                if (!$killed) {
                    // Force kill if still alive
                    Process::run("kill -9 {$pid} 2>/dev/null");
                    $this->info("Force killed Laravel server (PID: {$pid})");
                } else {
                    $this->info("Laravel server stopped gracefully (PID: {$pid})");
                }
            } else {
                $this->warn("Laravel server PID {$pid} not found or already dead");
            }
            unlink($portalPidFile);
        }
    }

    // Stop Vite server - kill entire process group
    public function stopVite(): void
    {
        $vitePidFile = storage_path('app/vite.pid');
        if (file_exists($vitePidFile)) {
            $pid = (int) file_get_contents($vitePidFile);
            if ($pid > 0 && $this->isProcessAlive($pid)) {
                // Graceful shutdown: SIGTERM to process group
                Process::run("kill -TERM -{$pid} 2>/dev/null");
                $this->info("Sent SIGTERM to Vite process group (PGID: {$pid})");
                // Wait up to 3 seconds
                $killed = $this->waitForProcessExit($pid, 3);
                if (!$killed) {
                    // Force kill entire process group
                    Process::run("kill -9 -{$pid} 2>/dev/null");
                    $this->info("Force killed Vite process group (PGID: {$pid})");
                } else {
                    $this->info("Vite server stopped gracefully (PGID: {$pid})");
                }
            } else {
                $this->warn("Vite server PID {$pid} not found or already dead");
            }
            unlink($vitePidFile);
        }
    }

    // Kill any remaining processes - aggressive cleanup
    public function stopAnotherProcess(): void
    {
        Process::run('pkill -f "artisan serve" 2>/dev/null');
        Process::run('pkill -9 -f "vite" 2>/dev/null');
        Process::run('pkill -9 -f "npm run dev" 2>/dev/null');
        Process::run('pkill -9 -f "esbuild" 2>/dev/null');
        Process::run('pkill -9 node 2>/dev/null');

        $this->info('All development servers stopped');

        // Check if ports are still in use
        $this->checkPortsAfterStop();
    }

    /**
     * Check if a process is still alive.
     */
    private function isProcessAlive(int $pid): bool
    {
        $result = Process::run("ps -p {$pid} -o pid= 2>/dev/null");

        return '' !== trim($result->output());
    }

    /**
     * Wait for process to exit, with timeout in seconds.
     * Returns true if process exited, false if timeout.
     */
    private function waitForProcessExit(int $pid, int $timeoutSeconds): bool
    {
        $start = time();
        while (time() - $start < $timeoutSeconds) {
            if (!$this->isProcessAlive($pid)) {
                return true;
            }
            usleep(100_000); // 100ms
        }

        return false;
    }

    /**
     * Check if development ports are still in use after stop.
     */
    private function checkPortsAfterStop(): void
    {
        $ports = [
            8_000 => 'Laravel development server',
            8_073 => 'Vite HMR default setting',
            5_173 => 'Vite dev server',
            5_174 => 'Vite HMR (optional)',
        ];

        foreach ($ports as $port => $service) {
            $result = Process::run("ss -tuln 2>/dev/null | grep ':{$port}'");
            if ('' !== trim($result->output())) {
                $this->warn("Port {$port} ({$service}) is still in use after stop command.");
                // Show which process is using it
                $lsof = Process::run("lsof -ti:{$port} 2>/dev/null | head -5");
                if ('' !== trim($lsof->output())) {
                    $pids = trim($lsof->output());
                    $this->warn("  PIDs still holding port: {$pids}");
                }
            } else {
                $this->info("Port {$port} ({$service}) is free.");
            }
        }
    }
}
