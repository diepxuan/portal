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
use Illuminate\Support\Facades\Process;

/**
 * Check documentation watcher status.
 */
class DocsWatchStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:watch:status
        {--verbose : Show detailed output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check documentation watcher status';

    /**
     * PID file path.
     */
    protected string $pidFile;

    /**
     * Log file path.
     */
    protected string $logFile;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->pidFile = storage_path('app/docs-watch.pid');
        $this->logFile = storage_path('logs/docs-sync.log');

        $this->info('👁️ Documentation Watcher Status');
        $this->info('================================');

        // Check systemd service first
        $this->checkSystemService();

        // Check standalone process
        $this->checkStandaloneProcess();

        // Show recent logs
        $this->showLogs();

        return 0;
    }

    /**
     * Check systemd service status.
     */
    protected function checkSystemService(): void
    {
        $this->info('');
        $this->info('🔧 Systemd Service:');

        // Check if service exists
        $result = Process::run('systemctl list-unit-files portal-docs-watch.service');

        if (!str_contains($result->output(), 'portal-docs-watch.service')) {
            $this->line('  Service not installed');

            return;
        }

        // Check service status
        $result = Process::run('systemctl is-active portal-docs-watch.service');
        $status = trim($result->output());

        if ('active' === $status) {
            $this->line('  Status: ✅ Active');

            // Get detailed status
            if ($this->option('verbose')) {
                $result = Process::run('systemctl status portal-docs-watch.service --no-pager');
                $this->line('');
                $this->line($result->output());
            }
        } elseif ('inactive' === $status) {
            $this->line('  Status: ⚪ Inactive');
        } else {
            $this->line("  Status: ❌ {$status}");
        }

        // Check if enabled
        $result  = Process::run('systemctl is-enabled portal-docs-watch.service');
        $enabled = trim($result->output());

        if ('enabled' === $enabled) {
            $this->line('  Enabled: ✅ Yes (auto-start on boot)');
        } else {
            $this->line("  Enabled: ❌ {$enabled}");
        }
    }

    /**
     * Check standalone process status.
     */
    protected function checkStandaloneProcess(): void
    {
        $this->info('');
        $this->info('📄 Standalone Process:');

        if (!file_exists($this->pidFile)) {
            $this->line('  PID file: Not found (not running in standalone mode)');

            return;
        }

        $pid = (int) file_get_contents($this->pidFile);

        if ($pid <= 0) {
            $this->line('  PID: ❌ Invalid');
            unlink($this->pidFile);

            return;
        }

        $this->line("  PID file: {$this->pidFile}");
        $this->line("  PID: {$pid}");

        // Check if process is running
        $result = Process::run("ps -p {$pid} -o pid,ppid,user,%cpu,%mem,etime,command");

        if ($result->successful() && !empty(trim($result->output()))) {
            $this->line('  Status: ✅ Running');
            $this->line('');
            $this->line($result->output());
        } else {
            $this->line('  Status: ❌ Not running');
            $this->warn('Stale PID file detected. Cleaning up...');
            unlink($this->pidFile);
        }
    }

    /**
     * Show recent logs.
     */
    protected function showLogs(): void
    {
        $this->info('');
        $this->info('📋 Recent Logs:');

        // Try journalctl first (for systemd service)
        $result = Process::run('journalctl -u portal-docs-watch.service --no-pager -n 10');

        if ($result->successful() && !empty(trim($result->output()))) {
            $this->line('');
            $this->line($result->output());

            return;
        }

        // Fallback to log file
        if (!file_exists($this->logFile)) {
            $this->line('  Log file: Not found');

            return;
        }

        $this->line("  Log file: {$this->logFile}");
        $this->line('');

        $lines = file($this->logFile);
        $lines = \array_slice($lines, -10);

        foreach ($lines as $line) {
            $this->line(trim($line));
        }
    }
}
