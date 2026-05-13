<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-13 11:29:53
 */

namespace Diepxuan\Simba\Models\PO;

use Diepxuan\Simba\Models\ArDmKh;
use Diepxuan\Simba\Models\MmHttt;
use Diepxuan\Simba\SModel\PohnmModel as Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Pohnm — Hóa đơn mua hàng (PO3).
 *
 * Header của chứng từ hóa đơn mua hàng.
 */
class Pohnm extends Model
{
    /** Lọc theo mã công ty */
    public function scopeFilterByMaCty(Builder $query, ?string $maCty): Builder
    {
        if (!empty($maCty)) {
            return $query->where('ma_cty', $maCty);
        }

        return $query;
    }

    /** Lọc theo mã nhà cung cấp */
    public function scopeFilterByMaKh(Builder $query, ?string $maKh): Builder
    {
        if (!empty($maKh)) {
            return $query->where('ma_kh', $maKh);
        }

        return $query;
    }

    /** Lọc theo ngày chứng từ */
    public function scopeFilterByNgayCt(Builder $query, ?string $fromDate, ?string $toDate): Builder
    {
        if (!empty($fromDate)) {
            $query->whereDate('ngay_ct', '>=', $fromDate);
        }
        if (!empty($toDate)) {
            $query->whereDate('ngay_ct', '<=', $toDate);
        }

        return $query;
    }

    /** Lọc theo số hóa đơn */
    public function scopeFilterBySoHd(Builder $query, ?string $soHd): Builder
    {
        if (!empty($soHd)) {
            return $query->where('so_hd', 'like', '%' . $soHd . '%');
        }

        return $query;
    }

    /** Lọc theo tìm kiếm tổng quát */
    public function scopeFilterBySearch(Builder $query, ?string $search): Builder
    {
        if (!empty($search)) {
            return $query->where(static function ($q) use ($search): void {
                $q->where('so_hd', 'like', '%' . $search . '%')
                    ->orWhere('so_ct', 'like', '%' . $search . '%')
                    ->orWhere('ma_kh', 'like', '%' . $search . '%')
                    ->orWhere('dien_giai', 'like', '%' . $search . '%')
                ;
            });
        }

        return $query;
    }

    /** Quan hệ với chi tiết vật tư */
    public function chiTiets()
    {
        return $this->hasMany(Pohnmct::class, 'stt_rec', 'stt_rec');
    }

    /** Quan hệ với chi phí mua hàng */
    public function chiPhis()
    {
        return $this->hasMany(Pohnmcp::class, 'stt_rec', 'stt_rec');
    }

    /** Quan hệ với nhà cung cấp */
    public function nhaCungCap()
    {
        return $this->belongsTo(ArDmKh::class, 'ma_kh', 'ma_kh');
    }

    /** Quan hệ với hình thức thanh toán */
    public function hinhThucTt()
    {
        return $this->belongsTo(MmHttt::class, 'ma_httt', 'ma_httt');
    }

    /** Tính lại tổng tiền từ chi tiết */
    public function recalculateTotals(): void
    {
        $chiTiets = $this->chiTiets;
        $chiPhis  = $this->chiPhis;

        $tTienNt0 = $chiTiets->sum('tien_nt0');
        $tTien0   = $chiTiets->sum('tien0');
        $tThueNt  = $chiTiets->sum('thue_gtgt_nt');
        $tThue    = $chiTiets->sum('thue_gtgt');
        $tCpNt    = $chiPhis->sum('tien_nt');
        $tCp      = $chiPhis->sum('tien');

        $this->t_tien_nt0 = $tTienNt0;
        $this->t_tien0    = $tTien0;
        $this->t_thue_nt  = $tThueNt;
        $this->t_thue     = $tThue;
        $this->t_cp_nt    = $tCpNt;
        $this->t_cp       = $tCp;
        $this->t_tt_nt    = $tTienNt0 + $tThueNt + $tCpNt;
        $this->t_tt       = $tTien0 + $tThue + $tCp;
    }
}
