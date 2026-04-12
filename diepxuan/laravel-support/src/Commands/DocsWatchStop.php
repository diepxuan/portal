<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-12 23:52:31
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

/**
 * Stop documentation watcher.
 */
class DocsWatchStop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:watch:stop
        {--force : Force kill the process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop documentation watcher';

    /**
     * PID file path.
     */
    protected string $pidFile;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->pidFile = storage_path('app/docs-watch.pid');

        $this->info('🛑 Stopping documentation watcher...');

        if (!file_exists($this->pidFile)) {
            // Check if running as systemd service
            $result = Process::run('systemctl is-active portal-docs-watch.service');

            if ($result->successful() && 'active' === trim($result->output())) {
                $this->info('Watcher is running as systemd service. Stopping service...');
                Process::run('sudo systemctl stop portal-docs-watch.service');
                $this->info('✅ Service stopped');

                return 0;
            }

            $this->warn('Watcher is not running (no PID file found)');

            return 0;
        }

        $pid = (int) file_get_contents($this->pidFile);

        if ($pid <= 0) {
            $this->error('Invalid PID in file');
            unlink($this->pidFile);

            return 1;
        }

        // Check if process is running
        $result = Process::run("ps -p {$pid}");

        if (!$result->successful()) {
            $this->warn('Process is not running. Cleaning up PID file...');
            unlink($this->pidFile);

            return 0;
        }

        // Stop process
        $signal     = $this->option('force') ? SIGKILL : SIGTERM;
        $signalName = $this->option('force') ? 'SIGKILL (force)' : 'SIGTERM';

        $this->info("Sending {$signalName} to PID {$pid}...");
        posix_kill($pid, $signal);

        // Wait for process to stop
        $maxWait = 10;
        $waited  = 0;

        while ($waited < $maxWait) {
            $result = Process::run("ps -p {$pid}");

            if (!$result->successful()) {
                $this->info('✅ Process stopped');
                unlink($this->pidFile);

                return 0;
            }

            sleep(1);
            ++$waited;
            $this->line("Waiting... ({$waited}s)");
        }

        // Force kill if still running
        if (!$this->option('force')) {
            $this->warn('Process did not stop gracefully. Use --force to kill.');

            return 1;
        }

        posix_kill($pid, SIGKILL);
        $this->info('✅ Process killed');
        unlink($this->pidFile);

        return 0;
    }
}
