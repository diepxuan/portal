<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-30 13:31:59
 */

namespace Diepxuan\Simba\Models;

use Diepxuan\Simba\SModel\GlCt as Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class GlCt.
 *
 * This class represents the model for the general ledger transactions.
 * It provides methods to interact with the stored procedure for generating reports.
 */
class GlCt extends Model
{
    /**
     * Gọi stored procedure asGLRptNKC03 để lấy dữ liệu sổ nhật ký thu/chi.
     */
    public static function getNKC03Report(array $params): Collection
    {
        return collect(DB::select('EXEC asGLRptNKC03
            @pMa_Cty = :pMa_Cty,
            @pNgay_Ct1 = :pNgay_Ct1,
            @pNgay_Ct2 = :pNgay_Ct2,
            @pTk_List = :pTk_List,
            @pTkdu_List = :pTkdu_List,
            @pMa_Bp = :pMa_Bp,
            @pMa_Nt = :pMa_Nt
        ', [
            'pMa_Cty'    => $params['ma_cty'] ?? '',
            'pNgay_Ct1'  => $params['ngay_ct1'] ?? '2000-01-01',
            'pNgay_Ct2'  => $params['ngay_ct2'] ?? now(),
            'pTk_List'   => $params['tk_list'] ?? '111,112',
            'pTkdu_List' => $params['tkdu_list'] ?? '',
            'pMa_Bp'     => $params['ma_bp'] ?? '',
            'pMa_Nt'     => $params['ma_nt'] ?? 'VND',
        ]));
    }
}
