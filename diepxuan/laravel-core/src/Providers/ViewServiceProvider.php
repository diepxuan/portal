<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-04-22 15:24:26
 */

namespace Diepxuan\Core\Providers;

use Diepxuan\Core\Models\Package;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        Package::list()->map(static function (string $package, string $code): void {
            Package::livewireComponentNamespace($code);
        });
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        Package::list()->map(function (string $package, string $code): void {
            $viewPath   = resource_path('views/modules/' . $code);
            $sourcePath = Package::path($package, 'resources/views');

            $this->publishes([$sourcePath => $viewPath], ['views', $code . '-module-views']);

            $this->loadViewsFrom(array_merge($this->getPublishableViewPaths($code), [$sourcePath]), $code);

            $componentNamespace = config("{$code}.namespace");
            Blade::componentNamespace("{$componentNamespace}\\View\\Components", $code);
        });
    }

    /**
     * @param mixed $moduleCode
     *
     * @return array<string>
     */
    private function getPublishableViewPaths($moduleCode = ''): array
    {
        $paths      = [];
        $moduleCode = "/{$moduleCode}";
        foreach (config('view.paths') as $path) {
            if (is_dir("{$path}/diepxuan{$moduleCode}")) {
                $paths[] = "{$path}/diepxuan{$moduleCode}";
            }
        }

        return $paths;
    }
}
