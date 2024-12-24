<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-24 22:03:08
 */

namespace Diepxuan\Currency;

class Formatter
{
    public static function format($amount, $currency = 'VND')
    {
        $formatter = new \NumberFormatter('vi_VN', \NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($amount, 'VND');
    }
}
