<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-04-21 08:47:59
 */

namespace Diepxuan\Core\Providers;

use Diepxuan\Core\Models\Package;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * @var Collection
     */
    protected $packages;

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // @todo
        // dd(Diepxuan::test());
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // @todo
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

    /**
     * List packages.
     */
    protected function packages(): Collection
    {
        if ($this->packages) {
            return $this->packages;
        }
        $this->packages = Package::list();

        return $this->packages;
    }
}
