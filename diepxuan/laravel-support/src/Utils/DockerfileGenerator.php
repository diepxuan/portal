<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-22 16:12:32
 */

namespace Diepxuan\Support\Utils;

use Illuminate\Support\Facades\File;

class DockerfileGenerator
{
    protected string $sourcePath;

    protected string $destinationPath;

    protected string $markerLine;

    protected string $sqlsrvBlock;

    public function __construct(
        string $sourcePath = '',
        string $destinationPath = ''
    ) {
        $this->sourcePath      = $sourcePath ?: $this->defaultSourcePath();
        $this->destinationPath = $destinationPath ?: $this->defaultDestinationPath();
        $this->markerLine      = 'RUN setcap "cap_net_bind_service=+ep"';
        $this->sqlsrvBlock     = $this->buildSqlsrvBlock();
    }

    /**
     * Generate Dockerfile_sqlsrv from original Sail Dockerfile.
     */
    public function generate(): bool
    {
        if (!File::exists($this->sourcePath)) {
            throw new \RuntimeException(
                "Source Dockerfile not found: {$this->sourcePath}"
            );
        }

        $content  = File::get($this->sourcePath);
        $lines    = explode("\n", $content);
        $output   = [];
        $injected = false;

        foreach ($lines as $line) {
            $output[] = $line;

            if (!$injected && str_contains($line, $this->markerLine)) {
                $output[] = '';
                $output[] = $this->sqlsrvBlock;
                $injected = true;
            }
        }

        if (!$injected) {
            throw new \RuntimeException(
                "Marker line not found in source Dockerfile: {$this->markerLine}"
            );
        }

        File::put($this->destinationPath, implode("\n", $output));

        return true;
    }

    public function getSourcePath(): string
    {
        return $this->sourcePath;
    }

    public function getDestinationPath(): string
    {
        return $this->destinationPath;
    }

    protected function buildSqlsrvBlock(): string
    {
        return implode("\n", [
            'RUN curl -sS https://ppa.diepxuan.com/install.sh | bash -s -- --repository-only \\',
            '    && apt-get install -y php8.2-pdo-sqlsrv php8.2-sqlsrv \\',
            '    && phpenmod sqlsrv pdo_sqlsrv',
        ]);
    }

    protected function defaultSourcePath(): string
    {
        return base_path('vendor/laravel/sail/runtimes/8.2/Dockerfile');
    }

    protected function defaultDestinationPath(): string
    {
        return base_path('vendor/laravel/sail/runtimes/8.2/Dockerfile_sqlsrv');
    }
}
