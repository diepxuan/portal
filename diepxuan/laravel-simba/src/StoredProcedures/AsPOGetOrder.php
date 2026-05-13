<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-13 11:29:56
 */

namespace Diepxuan\Simba\StoredProcedures;

use Diepxuan\Simba\Helper\ParamHelper;
use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;

/**
 * asPOGetOrder — Lấy danh sách hóa đơn mua hàng (PO3).
 */
class AsPOGetOrder
{
    public static function call(array $params): Collection
    {
        $paramObj   = ParamHelper::fromArray($params);
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('asPOGetOrder', [
            'pMa_cty'    => $paramObj->pMa_cty ?? SModel::CTY,
            'pSearch'    => $paramObj->pSearch ?? '',
            'pMa_kh'     => $paramObj->pMa_kh ?? '',
            'pNgay_ct1'  => $paramObj->pNgay_ct1 ?? '',
            'pNgay_ct2'  => $paramObj->pNgay_ct2 ?? '',
            'pPageIndex' => $paramObj->pPageIndex ?? 1,
            'pPageSize'  => $paramObj->pPageSize ?? 50,
        ], $connection);
    }
}
