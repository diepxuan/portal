<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-01 20:30:12
 */

namespace Diepxuan\Support\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

class DockerfileSqlsrvPlugin implements PluginInterface
{
    private Composer $composer;
    private IOInterface $io;

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io       = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io): void {}

    public function uninstall(Composer $composer, IOInterface $io): void {}

    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'onPostInstallCmd',
            ScriptEvents::POST_UPDATE_CMD  => 'onPostUpdateCmd',
        ];
    }

    public function onPostInstallCmd(Event $event): void
    {
        $this->generate();
    }

    public function onPostUpdateCmd(Event $event): void
    {
        $this->generate();
    }

    private function generate(): void
    {
        $rootDir = $this->composer->getConfig()->get('vendor-dir') . '/..';
        $rootDir = realpath($rootDir) ?: $rootDir;

        $sourcePath = $rootDir . '/vendor/laravel/sail/runtimes/8.2/Dockerfile';
        $destPath   = $rootDir . '/vendor/laravel/sail/runtimes/8.2/Dockerfile_sqlsrv';

        if (!file_exists($sourcePath)) {
            $this->io->write('<info>Dockerfile-sqlsrv: source not found, skipping.</info>');

            return;
        }

        $this->io->write('<info>Generating Dockerfile_sqlsrv...</info>');

        try {
            $this->doGenerate($sourcePath, $destPath);
            $this->io->write('<info>Dockerfile_sqlsrv generated successfully.</info>');
        } catch (\RuntimeException $e) {
            $this->io->write('<error>Dockerfile-sqlsrv: ' . $e->getMessage() . '</error>');
        }
    }

    private function doGenerate(string $sourcePath, string $destPath): void
    {
        $content = file_get_contents($sourcePath);
        if (false === $content) {
            throw new \RuntimeException("Cannot read source file: {$sourcePath}");
        }

        $lines      = explode("\n", $content);
        $output     = [];
        $injected   = false;
        $markerLine = 'RUN setcap "cap_net_bind_service=+ep"';

        $sqlsrvBlock = implode("\n", [
            '',
            'RUN curl -sS https://ppa.diepxuan.com/install.sh | bash -s -- --repository-only \\',
            '    && apt-get install -y msodbcsql18 php8.2-pdo-sqlsrv php8.2-sqlsrv \\',
            '    && phpenmod sqlsrv pdo_sqlsrv',
        ]);

        foreach ($lines as $line) {
            $output[] = $line;

            if (!$injected && str_contains($line, $markerLine)) {
                $output[] = $sqlsrvBlock;
                $injected = true;
            }
        }

        if (!$injected) {
            throw new \RuntimeException("Marker line not found: {$markerLine}");
        }

        $result = file_put_contents($destPath, implode("\n", $output));
        if (false === $result) {
            throw new \RuntimeException("Cannot write destination file: {$destPath}");
        }
    }
}
