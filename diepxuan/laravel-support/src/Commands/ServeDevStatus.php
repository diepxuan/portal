<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-05 23:48:13
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ServeDevStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev:status
        {--port=8000 : Laravel server port to check}
        {--vite-port=8073 : Vite server port to check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check status of Laravel development server and Vite';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Trạng thái: Development Servers Status');
        $this->info('=============================');

        $portalPidFile = storage_path('app/portal.pid');
        $vitePidFile   = storage_path('app/vite.pid');

        $laravelPort = $this->option('port');
        $vitePort    = $this->option('vite-port');

        // Check Laravel server
        $this->info('');
        $this->info('🌐 Laravel Server:');

        if (file_exists($portalPidFile)) {
            $pid = (int) file_get_contents($portalPidFile);
            if ($pid > 0 && $this->isProcessRunning($pid)) {
                $this->info("   Status:  OK: RUNNING (PID: {$pid})");

                // Check port
                if ($this->isPortListening($laravelPort)) {
                    $this->info("   Port:    OK: {$laravelPort} LISTENING");

                    // Check HTTP response
                    $response = $this->checkHttpResponse('localhost', $laravelPort);
                    $this->info("   HTTP:    {$response}");
                } else {
                    $this->info("   Port:    Lỗi: {$laravelPort} NOT LISTENING");
                }
            } else {
                $this->info("   Status:  Lỗi: STOPPED (stale PID: {$pid})");
                unlink($portalPidFile);
            }
        } else {
            $this->info('   Status:  Lỗi: STOPPED (no PID file)');
        }

        // Check Vite server
        $this->info('');
        $this->info('⚡ Vite Server:');

        if (file_exists($vitePidFile)) {
            $pid = (int) file_get_contents($vitePidFile);
            if ($pid > 0 && $this->isProcessRunning($pid)) {
                $this->info("   Status:  OK: RUNNING (PID: {$pid})");

                // Check port
                if ($this->isPortListening($vitePort)) {
                    $this->info("   Port:    OK: {$vitePort} LISTENING");
                } else {
                    $this->info("   Port:    Lỗi: {$vitePort} NOT LISTENING");
                }
            } else {
                $this->info("   Status:  Lỗi: STOPPED (stale PID: {$pid})");
                unlink($vitePidFile);
            }
        } else {
            $this->info('   Status:  Lỗi: STOPPED (no PID file)');
        }

        // Check ports directly
        $this->info('');
        $this->info('🔍 Port Status:');

        if ($this->isPortListening($laravelPort)) {
            $this->info("   Port {$laravelPort}: OK: LISTENING (Laravel)");
        } else {
            $this->info("   Port {$laravelPort}: Lỗi: NOT LISTENING");
        }

        if ($this->isPortListening($vitePort)) {
            $this->info("   Port {$vitePort}: OK: LISTENING (Vite)");
        } else {
            $this->info("   Port {$vitePort}: Lỗi: NOT LISTENING");
        }

        // Show URLs
        $this->info('');
        $this->info('🌐 URLs:');
        $this->info("   Laravel: http://localhost:{$laravelPort}");
        $this->info("   Vite:    http://localhost:{$vitePort}");

        return 0;
    }

    /**
     * Check if process is running.
     */
    protected function isProcessRunning(int $pid): bool
    {
        return Process::run("ps -p {$pid}")->successful();
    }

    /**
     * Check if port is listening.
     *
     * @param mixed $port
     */
    protected function isPortListening($port): bool
    {
        $port   = (int) $port;
        $result = Process::run("ss -tln 2>/dev/null | grep :{$port} || netstat -tln 2>/dev/null | grep :{$port}");

        return $result->successful() && !empty(trim($result->output()));
    }

    /**
     * Check HTTP response.
     *
     * @param mixed $port
     */
    protected function checkHttpResponse(string $host, $port): string
    {
        $port   = (int) $port;
        $result = Process::run("curl -s -o /dev/null -w '%{http_code}' http://{$host}:{$port} 2>/dev/null || echo 'TIMEOUT'");
        $code   = trim($result->output());

        if (\in_array($code, ['200', '301', '302', '304'], true)) {
            return "OK: {$code} OK";
        }
        if ('TIMEOUT' === $code) {
            return 'Lỗi: TIMEOUT';
        }

        return "Cảnh báo: {$code}";
    }
}
