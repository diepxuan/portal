<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-21 12:04:57
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class Npm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dev:npm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run npm install and npm run dev';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->output->writeln('[i] Checking if node_modules exists');

        if (!is_dir('node_modules')) {
            $this->output->writeln('[i] node_modules not found, running npm install');

            if (null === shell_exec('which npm')) {
                $this->error('npm is not installed on this system.');

                return;
            }

            exec('npm install', $outputInstall, $returnVarInstall);
            if (0 !== $returnVarInstall) {
                $this->error('npm install failed.');

                return;
            }
        } else {
            $this->output->writeln('[i] node_modules already exists, skipping npm install');
        }

        // === Check if watch.pid exists and process is still running ===
        $pidFile = storage_path('watch.pid');
        if (file_exists($pidFile)) {
            $pid = trim(file_get_contents($pidFile));
            if (is_numeric($pid) && posix_kill((int) $pid, 0)) {
                $this->output->writeln("[i] npm run watch is already running with PID {$pid}. Skipping.");

                return;
            }
            $this->output->writeln('[i] Stale PID file found. Removing.');
            unlink($pidFile);
        }

        // === Run npm run watch in background with nohup ===
        $this->output->writeln('[i] Starting npm run watch in background');

        $cmd = 'nohup npm run watch > watch.log 2>&1 & echo $!';
        exec($cmd, $outputWatch, $returnVarWatch);

        if (0 !== $returnVarWatch || empty($outputWatch[0])) {
            $this->error('Failed to start npm run watch in background.');

            return;
        }

        // Save the PID
        file_put_contents($pidFile, trim($outputWatch[0]));
        $this->output->writeln("[✓] npm run watch started with PID {$outputWatch[0]}");
    }

    public static function schedule(Schedule $schedule): void
    {
        $schedule->command(static::class)->everyMinute();
    }
}
