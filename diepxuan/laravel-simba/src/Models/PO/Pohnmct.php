<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-13 11:29:54
 */

namespace Diepxuan\Simba\Models\PO;

use Diepxuan\Simba\Models\GlDmTk;
use Diepxuan\Simba\Models\InDmKho;
use Diepxuan\Simba\Models\InDmVt;
use Diepxuan\Simba\SModel\PohnmctModel as Model;

/**
 * Class Pohnmct — Chi tiết hóa đơn mua hàng (PO3).
 *
 * Chi tiết vật tư trong hóa đơn mua hàng.
 */
class Pohnmct extends Model
{
    /** Quan hệ với header hóa đơn */
    public function pohnm()
    {
        return $this->belongsTo(Pohnm::class, 'stt_rec', 'stt_rec');
    }

    /** Quan hệ với vật tư */
    public function inDmVt()
    {
        return $this->belongsTo(InDmVt::class, 'ma_vt', 'ma_vt');
    }

    /** Quan hệ với kho */
    public function inDmKho()
    {
        return $this->belongsTo(InDmKho::class, 'ma_kho', 'ma_kho');
    }

    /** Quan hệ với tài khoản vật tư */
    public function glDmTkVt()
    {
        return $this->belongsTo(GlDmTk::class, 'tk_vt', 'tk');
    }

    /** Quan hệ với tài khoản thuế */
    public function glDmTkThue()
    {
        return $this->belongsTo(GlDmTk::class, 'tk_thue', 'tk');
    }

    /** Tính tiền từ số lượng và giá */
    public function calculateAmounts(): void
    {
        $this->tien_nt0     = $this->so_luong * $this->gia_nt0;
        $this->tien0        = $this->so_luong * $this->gia0;
        $this->thue_gtgt_nt = $this->tien_nt0 * ($this->ts_gtgt / 100);
        $this->thue_gtgt    = $this->tien0 * ($this->ts_gtgt / 100);
    }
}
