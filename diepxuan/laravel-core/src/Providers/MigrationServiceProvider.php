<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-04-21 08:48:27
 */

namespace Diepxuan\Core\Providers;

use Diepxuan\Core\Models\Package;

class MigrationServiceProvider extends AbstractServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        // parent::boot();
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->packages()->map(function (string $package, string $code): void {
            $this->loadMigrationsFrom(Package::path($package, 'database/migrations'));
        });
    }
}
