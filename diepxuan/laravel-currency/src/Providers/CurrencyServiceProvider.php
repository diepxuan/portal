<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-24 22:07:20
 */

namespace Diepxuan\Currency\Providers;

use Diepxuan\Currency\Formatter;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        Blade::directive('currency', static function ($price) {
            $price = Formatter::format($price);

            return "<?php echo {$price}; ?>";
        });
    }

    /**
     * Register the service provider.
     */
    public function register(): void {}

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
