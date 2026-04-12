<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-12 23:52:31
 */

namespace Diepxuan\Support;

use Diepxuan\Support\Commands\CodeFormat;
use Diepxuan\Support\Commands\Dev;
use Diepxuan\Support\Commands\DocsSync;
use Diepxuan\Support\Commands\DocsWatch;
use Diepxuan\Support\Commands\DocsWatchStatus;
use Diepxuan\Support\Commands\DocsWatchStop;
use Diepxuan\Support\Commands\Npm;
use Diepxuan\Support\Commands\ServeDev;
use Diepxuan\Support\Commands\ServeDevHealth;
use Diepxuan\Support\Commands\ServeDevLogs;
use Diepxuan\Support\Commands\ServeDevService;
use Diepxuan\Support\Commands\ServeDevStatus;
use Diepxuan\Support\Commands\ServeDevStop;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // Dev server commands
                Dev::class,
                ServeDev::class,
                ServeDevStop::class,
                ServeDevStatus::class,
                ServeDevHealth::class,
                ServeDevService::class,
                ServeDevLogs::class,

                // Documentation sync commands
                DocsSync::class,
                DocsWatch::class,
                DocsWatchStop::class,
                DocsWatchStatus::class,

                // Other commands
                Npm::class,
                CodeFormat::class,
            ]);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            URL::forceScheme('https');
        }
    }
}
