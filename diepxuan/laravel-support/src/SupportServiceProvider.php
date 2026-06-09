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
        if (!app()->runningInConsole()) {
            URL::forceScheme('https');
        }

        $this->commands([
            GenerateDockerfileSqlsrvCommand::class,
        ]);
    }
}
