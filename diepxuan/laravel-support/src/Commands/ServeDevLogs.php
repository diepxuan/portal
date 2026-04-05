<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-05 23:48:12
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ServeDevLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev:logs
                            {type? : Type of logs to view (laravel, vite, health, all)}
                            {--f|follow : Follow log output (tail -f)}
                            {--l|lines=50 : Number of lines to show}
                            {--c|clear : Clear log file after viewing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View development server logs in real-time';

    /**
     * Log file paths.
     */
    protected array $logPaths = [
        'laravel' => 'storage/logs/laravel.log',
        'vite'    => 'storage/logs/vite-server.log',
        'health'  => 'storage/logs/health-check.log',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type   = $this->argument('type') ?? 'all';
        $follow = $this->option('follow');
        $lines  = (int) $this->option('lines');
        $clear  = $this->option('clear');

        $this->info('Logs: Development Server Logs');
        $this->info('==========================');

        if ('all' === $type) {
            foreach ($this->logPaths as $logType => $path) {
                $this->showLog($logType, $path, $follow, $lines, $clear);
            }
        } elseif (isset($this->logPaths[$type])) {
            $this->showLog($type, $this->logPaths[$type], $follow, $lines, $clear);
        } else {
            $this->error("Invalid log type: {$type}");
            $this->line('Available types: laravel, vite, health, all');

            return 1;
        }

        return 0;
    }

    /**
     * Show log file content.
     */
    protected function showLog(string $type, string $path, bool $follow, int $lines, bool $clear): void
    {
        $fullPath = base_path($path);

        if (!file_exists($fullPath)) {
            $this->warn("Cảnh báo:  Log file not found: {$path}");
            $this->line('   Creating empty log file...');
            file_put_contents($fullPath, '');
        }

        $fileSize = filesize($fullPath);
        $this->info("\n📄 {$type} Log: {$path} (" . $this->formatBytes($fileSize) . ')');
        $this->line(str_repeat('─', 60));

        if ($follow) {
            $this->followLog($fullPath, $lines);
        } else {
            $this->tailLog($fullPath, $lines);
        }

        if ($clear) {
            $this->clearLog($fullPath);
        }
    }

    /**
     * Tail log file (show last N lines).
     */
    protected function tailLog(string $path, int $lines): void
    {
        if (0 === filesize($path)) {
            $this->line('(empty log file)');

            return;
        }

        $command = "tail -n {$lines} \"{$path}\"";
        $output  = Process::run($command)->output();

        if (empty(trim($output))) {
            $this->line('(no recent log entries)');
        } else {
            $this->output->write($output);
        }
    }

    /**
     * Follow log file (tail -f).
     */
    protected function followLog(string $path, int $lines): void
    {
        $this->info('Following log file (Ctrl+C to stop)...');

        // Show last N lines first
        if ($lines > 0) {
            $this->tailLog($path, $lines);
        }

        // Follow the log
        $command = "tail -f \"{$path}\"";

        try {
            Process::forever()
                ->tty(true)
                ->run($command, function (string $type, string $output): void {
                    $this->output->write($output);
                })
            ;
        } catch (\Exception $e) {
            $this->info("\nStopped following log.");
        }
    }

    /**
     * Clear log file.
     */
    protected function clearLog(string $path): void
    {
        file_put_contents($path, '');
        $this->info("OK: Log file cleared: {$path}");
    }

    /**
     * Format bytes to human readable format.
     */
    protected function formatBytes(int $bytes): string
    {
        if (0 === $bytes) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $i     = floor(log($bytes, 1_024));

        return round($bytes / 1_024 ** $i, 2) . ' ' . $units[$i];
    }
}
