<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-05 14:58:52
 */

namespace Diepxuan\Catalog\Services;

use Diepxuan\Catalog\Models\GlCdTk;
use Diepxuan\Catalog\Models\Params;
use Illuminate\Support\Carbon;

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
        $params->pNgayDnTc ??= $this->afNgay_DNTC($params);
        \Debugbar::info($params);

        $result = [];
        dd(GlCdTk::afDuDauTk([
            'pMa_Cty' => $params->pMaCty,
            'pTk'     => $params->pTk,
            'pNgay'   => $params->pNgay,
            'pMa_Nt'  => $params->pMaNt,
            'pNam'    => $params->pNamTc,
        ])->get());

        if ($params->pMaNt === \CatalogService::ma_Nt()) {
            // Theo đồng tiền hạch toán
            $du_dau_nam = DB::table('glcdtk')
                ->select(
                    'ma_cty',
                    'tk',
                    DB::raw("{$params->pMaNt} as ma_nt"),
                    DB::raw('SUM(du_no-du_co) as du_no'),
                    DB::raw('0 as du_co'),
                    DB::raw('SUM(du_no_nt-du_co_nt) as du_no_nt'),
                    DB::raw('0 as du_co_nt')
                )
                ->where('ma_cty', $pMa_cty)
                ->where('nam', $Nam_TC)
                ->when('' !== $pTk, static function ($q) use ($pTk): void {
                    $q->where('tk', 'like', $pTk . '%');
                })
                ->groupBy('ma_cty', 'tk')
            ;

            $ps_dau_ky = DB::table('glct')
                ->select(
                    'ma_cty',
                    'tk',
                    DB::raw("{$pMa_Nt} as ma_nt"),
                    DB::raw('SUM(ps_no-ps_co) as du_no'),
                    DB::raw('0 as du_co'),
                    DB::raw('SUM(ps_no_nt-ps_co_nt) as du_no_nt'),
                    DB::raw('0 as du_co_nt')
                )
                ->where('ma_cty', $pMa_cty)
                ->whereBetween('Ngay_ct', [$Ngay_DNTC, $pNgay])
                ->where('Ngay_ct', '<', $pNgay)
                ->when('' !== $pTk, static function ($q) use ($pTk): void {
                    $q->where('tk', 'like', $pTk . '%');
                })
                ->groupBy('ma_cty', 'tk')
            ;

            // UNION ALL 2 query lại
            $rows = DB::table(DB::raw("({$du_dau_nam->toSql()} UNION ALL {$ps_dau_ky->toSql()}) as dutmp"))
                ->mergeBindings($du_dau_nam)->mergeBindings($ps_dau_ky)
                ->select('ma_cty', 'tk', 'ma_nt', DB::raw('SUM(du_no) as du_no'), DB::raw('SUM(du_co) as du_co'), DB::raw('SUM(du_no_nt) as du_no_nt'), DB::raw('SUM(du_co_nt) as du_co_nt'))
                ->where(static function ($q): void {
                    $q->where('du_no', '<>', 0)->orWhere('du_no_nt', '<>', 0);
                })
                ->groupBy('ma_cty', 'tk', 'ma_nt')
                ->get()
            ;
        } else {
            // Theo mã ngoại tệ
            $du_dau_nam = DB::table('glcdtk')
                ->select(
                    'ma_cty',
                    'tk',
                    'ma_nt',
                    DB::raw('SUM(du_no00-du_co00) as du_no'),
                    DB::raw('0 as du_co'),
                    DB::raw('SUM(du_no_nt00-du_co_nt00) as du_no_nt'),
                    DB::raw('0 as du_co_nt')
                )
                ->where('ma_cty', $pMa_cty)
                ->where('nam', $Nam_TC)
                ->when('' !== $pTk, static function ($q) use ($pTk): void {
                    $q->where('tk', 'like', $pTk . '%');
                })
                ->where('ma_nt', 'like', $pMa_Nt . '%')
                ->groupBy('ma_cty', 'tk', 'ma_nt')
            ;

            $ps_dau_ky = DB::table('glct')
                ->select(
                    'ma_cty',
                    'tk',
                    'ma_nt',
                    DB::raw('SUM(ps_no-ps_co) as du_no'),
                    DB::raw('0 as du_co'),
                    DB::raw('SUM(ps_no_nt-ps_co_nt) as du_no_nt'),
                    DB::raw('0 as du_co_nt')
                )
                ->where('ma_cty', $pMa_cty)
                ->where('nam', $Nam_TC)
                ->whereBetween('Ngay_ct', [$Ngay_DNTC, $pNgay])
                ->where('Ngay_ct', '<', $pNgay)
                ->when('' !== $pTk, static function ($q) use ($pTk): void {
                    $q->where('tk', 'like', $pTk . '%');
                })
                ->where('ma_nt', 'like', $pMa_Nt . '%')
                ->groupBy('ma_cty', 'tk', 'ma_nt')
            ;

            // UNION ALL 2 query lại
            $rows = DB::table(DB::raw("({$du_dau_nam->toSql()} UNION ALL {$ps_dau_ky->toSql()}) as dutmp"))
                ->mergeBindings($du_dau_nam)->mergeBindings($ps_dau_ky)
                ->select('ma_cty', 'tk', 'ma_nt', DB::raw('SUM(du_no) as du_no'), DB::raw('SUM(du_co) as du_co'), DB::raw('SUM(du_no_nt) as du_no_nt'), DB::raw('SUM(du_co_nt) as du_co_nt'))
                ->where(static function ($q): void {
                    $q->where('du_no', '<>', 0)->orWhere('du_no_nt', '<>', 0);
                })
                ->groupBy('ma_cty', 'tk', 'ma_nt')
                ->get()
            ;
        }

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

        return $result;
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
