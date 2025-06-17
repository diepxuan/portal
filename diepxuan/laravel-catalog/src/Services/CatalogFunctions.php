<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-05 16:58:33
 */

namespace Diepxuan\Catalog\Services;

use Diepxuan\Catalog\Models\GlCdTk;
use Diepxuan\Catalog\Models\GlCt;
use Diepxuan\Catalog\Models\Params;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CatalogFunctions
{
    public function afDuDauTk(array|Params $params)
    {
        $params = \is_array($params) ? new Params($params) : $params;
        $params->pMaCty ??= \CatalogService::company()->ma_cty;
        $params->pTk ??= '111';
        $params->pNgay ??= '2020-01-01';
        $params->pMaNt ??= \CatalogService::ma_Nt();
        $params->pNamTc ??= static::afNamTC($params);
        $params->pNgayDnTc ??= static::afNgay_DNTC($params);
        \Debugbar::info($params);

        // Theo đồng tiền hạch toán
        $du_dau_nam = GlCdTk::afDuDauTk([
            'pMa_Cty' => $params->pMaCty,
            'pTk'     => $params->pTk,
            'pNgay'   => $params->pNgay,
            'pMa_Nt'  => $params->pMaNt,
            'pNam'    => $params->pNamTc,
        ]);

        $ps_dau_ky = GlCt::afDuDauTk([
            'pMaCty'    => $params->pMaCty,
            'pTk'       => $params->pTk,
            'pNgay'     => $params->pNgay,
            'pMaNt'     => $params->pMaNt,
            'pNam'      => $params->pNamTc,
            'pNgayDnTc' => $params->pNgayDnTc,
        ]);

        $rows = $ps_dau_ky->toBase()->unionAll($du_dau_nam->toBase())
        // ->select('ma_cty', 'tk', 'ma_nt', DB::raw('SUM(du_no) as du_no'), DB::raw('SUM(du_co) as du_co'), DB::raw('SUM(du_no_nt) as du_no_nt'), DB::raw('SUM(du_co_nt) as du_co_nt'))
        // ->where(static function ($q): void {
        //     $q->where('du_no', '<>', 0)->orWhere('du_no_nt', '<>', 0);
        // })
        // ->groupBy('ma_cty', 'tk', 'ma_nt')
            ->get()
        ;
        // dd($rows->get());

        // Xử lý dư có/dư nợ âm chuyển đổi
        foreach ($rows as $row) {
            if ($row->du_no < 0) {
                $row->du_co = -$row->du_no;
                $row->du_no = 0;
            }
            if ($row->du_no_nt < 0) {
                $row->du_co_nt = -$row->du_no_nt;
                $row->du_no_nt = 0;
            }
            $result[] = (array) $row;
        }

        return $rows;
    }

    public function afNamTC(array|Params $params)
    {
        $params = \is_array($params) ? new Params($params) : $params;
        $params->pNam ??= $params->pNgay->year;
        $params->pNgayDnTc ??= $this->afNgay_DNTC($params);
        // \Debugbar::info($params, $pNam);

        return $params->pNgay->lt($params->pNgayDnTc) ? $params->pNgay->year - 1 : $params->pNgay->year;
    }

    public function afNgay_DNTC(array|Params $params): Carbon
    {
        $params = \is_array($params) ? new Params($params) : $params;

        return \CatalogService::company()->siSetup->ngay_dntc->setYear($params->pNam);
    }
}
