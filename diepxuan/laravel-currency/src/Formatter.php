<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-25 18:01:23
 */

namespace Diepxuan\Currency;

use Illuminate\Support\Facades\App;

class Formatter
{
    /**
     * format.
     *
     * @param mixed $amount
     * @param mixed $currency VND/USD...
     */
    public static function format($amount, $currency = 'VND')
    {
        // $locale = App::getLocale();
        $formatter = new \NumberFormatter('vi_VN', \NumberFormatter::CURRENCY);

        return $formatter->formatCurrency((float) $amount, $currency);
    }
}
