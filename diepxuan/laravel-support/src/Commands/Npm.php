<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-21 11:13:09
 */

namespace Diepxuan\Catalog\Commands;

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
        $this->output->writeln('[i] Running npm install');
        if (null === shell_exec('which npm')) {
            $this->error('npm is not installed on this system.');

            return;
        }

        exec('npm install', $outputInstall, $returnVarInstall);
        if (0 !== $returnVarInstall) {
            $this->error('npm install failed.');

            return;
        }
        $this->output->writeln('[i] Running npm run dev');
    }

    public static function schedule(Schedule $schedule): void
    {
        $schedule->command(static::class)->everyMinute();
    }
}
