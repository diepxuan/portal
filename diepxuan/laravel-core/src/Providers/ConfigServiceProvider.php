<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-04-21 08:48:16
 */

namespace Diepxuan\Core\Providers;

use Diepxuan\Core\Models\Package;

class ConfigServiceProvider extends AbstractServiceProvider
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
            if ((new \SplFileInfo(Package::path($package, '/config/config.php')))->isFile()) {
                $this->publishes([Package::path($package, 'config/config.php') => config_path($code . '.php')], 'config');
                $this->mergeConfigFrom(Package::path($package, 'config/config.php'), $code);
            }
        });
    }
}
