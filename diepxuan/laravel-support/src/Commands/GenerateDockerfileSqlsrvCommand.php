<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-22 16:12:31
 */

namespace Diepxuan\Support\Commands;

use Diepxuan\Support\Utils\DockerfileGenerator;
use Illuminate\Console\Command;

class GenerateDockerfileSqlsrvCommand extends Command
{
    protected $signature = 'sail:dockerfile-sqlsrv
                            {--source= : Path to original Dockerfile}
                            {--dest= : Path to output Dockerfile_sqlsrv}
                            {--force : Overwrite existing file}';

    protected $description = 'Generate Dockerfile_sqlsrv with SQL Server PHP drivers from original Sail Dockerfile';

    public function handle(DockerfileGenerator $generator): int
    {
        if ($this->option('source')) {
            $generator = new DockerfileGenerator(
                $this->option('source'),
                $this->option('dest')
            );
        }

        $dest = $generator->getDestinationPath();

        if (file_exists($dest) && !$this->option('force')) {
            if (!$this->confirm("File {$dest} already exists. Overwrite?")) {
                $this->info('Skipped.');

                return self::SUCCESS;
            }
        }

        $this->info("Source: {$generator->getSourcePath()}");
        $this->info("Destination: {$dest}");
        $this->newLine();

        try {
            $generator->generate();
            $this->info('Dockerfile_sqlsrv generated successfully.');

            return self::SUCCESS;
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
