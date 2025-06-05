<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-05 09:33:16
 */

namespace Diepxuan\Catalog\Models;

use Diepxuan\Simba\Models\GlCdTk as Model;

class GlCdTk extends Model
{
    /**
     * Gọi function afDuDauTk để lấy dữ liệu đầu kỳ.
     *
     * @return array
     */
    public function scopeAfDuDauTk(Builder $query, array $params): Builder
    {
        $params = [
            'pMa_Cty' => $params['ma_Cty'] ?? '111',
            'pTk'     => $params['tk'] ?? '111',
            'pNgay'   => $params['ngay'] ?? '2020-01-01',
            'pMa_Nt'  => $params['ma_Nt'] ?? 'VND',
            'pNam'    => $params['nam'] ?? \CatalogService::afNamTC([
                'ma_cty' => $pMa_cty,
                'ngay'   => $params['ngay'] ?? '2020-01-01',
            ]),
        ];

        return $query
            ->selectRaw('SUM(du_no - du_co) as du_no')
            ->selectRaw('0 as du_co')
            ->selectRaw('SUM(du_no_nt - du_co_nt) as du_no_nt')
            ->selectRaw('0 as du_co_nt')
            ->filterByMaCty($params['pMa_Cty'])
            ->filterByTkList($params['pTk'] ?? '')
            ->filterByMaNt($params['pMa_Nt'] ?? '')
            ->where('nam', $params['pNam'])
            ->groupBy('ma_cty', 'tk')
        ;
    }
}
