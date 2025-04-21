<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-04-21 08:48:38
 */

namespace Diepxuan\Core\Providers;

use Diepxuan\Core\Models\Package;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends AbstractServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->packages()->map(static function (string $package, string $code) {
            if ((new \SplFileInfo($file = Package::path($package, '/routes/web.php')))->isFile()) {
                Route::middleware('web')->group($file);
            }
            if ((new \SplFileInfo($file = Package::path($package, '/routes/api.php')))->isFile()) {
                Route::middleware('api')->prefix('api')->group($file);
            }

            // Lấy tất cả các file phù hợp với pattern
            $files = glob(Package::path($package, '/routes/*.php'));

            // Loại bỏ các file không mong muốn
            $files = array_filter($files, static fn ($file) => !\in_array(basename($file), ['web.php', 'api.php'], true));

            // Duyệt qua các file còn lại
            foreach ($files as $file) {
                if ((new \SplFileInfo($file))->isFile()) {
                    Route::middleware('web')->group($file);
                }
            }

            return $package;
        });
    }
}
