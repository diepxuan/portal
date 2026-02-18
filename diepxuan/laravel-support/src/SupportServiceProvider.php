<?php

namespace Diepxuan\Laravel\Support;

use Diepxuan\Support\Commands\Dev;
use Diepxuan\Support\Commands\Npm;
use Diepxuan\Support\Commands\ServeDev;
use Diepxuan\Support\Commands\ServeDevStop;
use Diepxuan\Support\Commands\ServeDevStatus;
use Diepxuan\Support\Commands\ServeDevHealth;
use Diepxuan\Support\Commands\ServeDevService;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register commands
        $this->commands([
            Dev::class,
            Npm::class,
            ServeDev::class,
            ServeDevStop::class,
            ServeDevStatus::class,
            ServeDevHealth::class,
            ServeDevService::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration if needed
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/support.php' => config_path('support.php'),
            ], 'support-config');
        }
    }
}