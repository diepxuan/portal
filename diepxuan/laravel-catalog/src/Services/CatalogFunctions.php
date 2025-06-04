<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-04 16:00:37
 */

namespace Diepxuan\Catalog\Services;

use Illuminate\Support\Carbon;

class CatalogFunctions
{
    public function afNamTC(array $params)
    {
        $pMa_cty = $params['ma_cty'] ?? '111';
        $pNgay   = Carbon::parse($params['ngay'] ?? '2020-01-01');
        $pNam    = $pNgay->year;

        // \Debugbar::info($params, $pNam);

        $pNgay_dntc = $this->afNgay_DNTC([
            'ma_cty' => $pMa_cty ?? CatalogService::company()->ma_cty,
            'nam'    => $pNam,
        ]);

        return $pNgay->lt($pNgay_dntc) ? $pNgay->year - 1 : $pNgay->year;
    }

    public function afNgay_DNTC(array $params): Carbon
    {
        $pMa_cty = $params['ma_cty'] ?? CatalogService::company()->ma_cty;
        $pNam    = $params['nam'] ??  CatalogService::year();

        return \CatalogService::company()->siSetup->ngay_dntc->setYear($pNam);
    }
}
