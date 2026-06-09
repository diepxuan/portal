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

namespace Diepxuan\Support;

use Diepxuan\Support\Commands\GenerateDockerfileSqlsrvCommand;
use Diepxuan\Support\Utils\DockerfileGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DockerfileGenerator::class, static fn ($app) => new DockerfileGenerator());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole() && !$this->isAllowedCorpHttpTarget(request())) {
            URL::forceScheme('https');
        }

        $this->commands([
            GenerateDockerfileSqlsrvCommand::class,
        ]);
    }

    private function isAllowedCorpHttpTarget(Request $request): bool
    {
        $host = strtolower($request->getHost());
        $serverAddress = (string) $request->server('SERVER_ADDR', '');

        return str_ends_with($host, '.diepxuan.corp')
            && $serverAddress === '10.0.0.122';
    }
}
