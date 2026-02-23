<?php

namespace Diepxuan\Laravel\Support;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Commands are auto-registered by Diepxuan\Core\Providers\ServiceProvider
        // via Package::getCommands() mechanism
        // No need for manual registration here
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