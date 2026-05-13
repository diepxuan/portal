<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-13 11:29:57
 */

namespace Diepxuan\Simba\StoredProcedures;

use Diepxuan\Simba\Helper\ParamHelper;
use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;

/**
 * asPOInsOrder — Insert hóa đơn mua hàng (PO3 header).
 *
 * Dùng chung cho POVchPO3-7 (các voucher PO).
 */
class AsPOInsOrder
{
    public static function call(array $params): Collection
    {
        $paramObj   = ParamHelper::fromArray($params);
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('asPOInsOrder', [
            'pMa_cty'     => $paramObj->pMa_cty ?? SModel::CTY,
            'pStt_rec'    => $paramObj->pStt_rec ?? '',
            'pMa_ct'      => $paramObj->pMa_ct ?? 'PO3',
            'pNgay_ct'    => $paramObj->pNgay_ct ?? null,
            'pSo_ct'      => $paramObj->pSo_ct ?? '',
            'pSo_hd'      => $paramObj->pSo_hd ?? '',
            'pNgay_hd'    => $paramObj->pNgay_hd ?? null,
            'pMa_kh'      => $paramObj->pMa_kh ?? '',
            'pNguoi_gd'   => $paramObj->pNguoi_gd ?? '',
            'pDia_chi'    => $paramObj->pDia_chi ?? '',
            'pMa_so_thue' => $paramObj->pMa_so_thue ?? '',
            'pDien_giai'  => $paramObj->pDien_giai ?? '',
            'pMa_httt'    => $paramObj->pMa_httt ?? '',
            'pMa_nt'      => $paramObj->pMa_nt ?? 'VND',
            'pTy_gia'     => $paramObj->pTy_gia ?? 1,
            'pT_tien_nt0' => $paramObj->pT_tien_nt0 ?? 0,
            'pT_tien0'    => $paramObj->pT_tien0 ?? 0,
            'pT_cp_nt'    => $paramObj->pT_cp_nt ?? 0,
            'pT_cp'       => $paramObj->pT_cp ?? 0,
            'pT_thue_nt'  => $paramObj->pT_thue_nt ?? 0,
            'pT_thue'     => $paramObj->pT_thue ?? 0,
            'pT_ck_nt'    => $paramObj->pT_ck_nt ?? 0,
            'pT_ck'       => $paramObj->pT_ck ?? 0,
            'pT_tt_nt'    => $paramObj->pT_tt_nt ?? 0,
            'pT_tt'       => $paramObj->pT_tt ?? 0,
            'pTk_pt'      => $paramObj->pTk_pt ?? '',
            'pTk_thue'    => $paramObj->pTk_thue ?? '',
            'pStatus'     => $paramObj->pStatus ?? null,
        ], $connection);
    }
}
