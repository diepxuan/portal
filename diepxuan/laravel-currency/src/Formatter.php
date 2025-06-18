<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-19 00:15:49
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
        if (null === $amount || !is_numeric($amount)) {
            return '';
        }

        // $locale = App::getLocale();
        $formatter = new \NumberFormatter('vi_VN', \NumberFormatter::CURRENCY);

        return $formatter->formatCurrency((float) $amount, $currency);
    }
}
