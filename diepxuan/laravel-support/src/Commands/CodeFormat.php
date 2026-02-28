<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-03-01 00:00:00
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class CodeFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:format
                            {paths?* : Paths to format (default: all PHP files in project)}
                            {--dry-run : Show which files would be formatted without making changes}
                            {--diff : Show diff of changes}
                            {--cache : Use cache (default: true)}
                            {--no-cache : Disable cache}
                            {--config= : Custom config file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Format PHP code using PHP-CS-Fixer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running PHP-CS-Fixer...');

        // Build command
        $command = ['./vendor/bin/php-cs-fixer', 'fix'];

        // Add paths
        $paths = $this->argument('paths');
        if (empty($paths)) {
            $command[] = '.';
        } else {
            foreach ($paths as $path) {
                $command[] = $path;
            }
        }

        // Options
        if ($this->option('dry-run')) {
            $command[] = '--dry-run';
        }

        if ($this->option('diff')) {
            $command[] = '--diff';
        }

        if ($this->option('no-cache')) {
            $command[] = '--no-cache';
        } elseif ($this->option('cache') || true) {
            $command[] = '--cache-file=' . base_path('.php-cs-fixer.cache.php');
        }

        if ($this->option('config')) {
            $command[] = '--config=' . $this->option('config');
        } else {
            $command[] = '--config=' . base_path('.php-cs-fixer.dist.php');
        }

        // Verbose output
        $command[] = '-v';

        $this->info('Command: ' . implode(' ', $command));

        // Run
        $result = Process::run($command);

        if ($result->successful()) {
            $output = $result->output();
            if (empty(trim($output))) {
                $this->info('No files needed formatting.');
            } else {
                $this->info($output);
            }

            if (str_contains($result->output(), 'Fixed all files')) {
                $this->info('✅ All files formatted successfully.');
            } elseif (str_contains($result->output(), 'No files found')) {
                $this->warn('No PHP files found to format.');
            }

            return 0;
        }

        $this->error('PHP-CS-Fixer failed:');
        $this->error($result->errorOutput());
        $this->error($result->output());

        return 1;
    }
}
