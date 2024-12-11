<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-11 23:39:39
 */

namespace Diepxuan\DisableRegistration\Providers;

use Diepxuan\DisableRegistration\Middleware\DisableRegistrationMiddleware;
use Illuminate\Support\ServiceProvider;

class DisableRegistrationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void {}

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app['router']->aliasMiddleware('disable.register', DisableRegistrationMiddleware::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [];
    }
}
