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
use Diepxuan\Simba\SModel\PohnmcpModel as Model;

/**
 * Class Pohnmcp — Chi phí hóa đơn mua hàng (PO3).
 *
 * Chi phí mua hàng kèm theo hóa đơn.
 */
class Pohnmcp extends Model
{
    /** Quan hệ với header hóa đơn */
    public function pohnm()
    {
        return $this->belongsTo(Pohnm::class, 'stt_rec', 'stt_rec');
    }

    /** Quan hệ với tài khoản chi phí */
    public function glDmTkCp()
    {
        return $this->belongsTo(GlDmTk::class, 'tk_cp', 'tk');
    }

    /** Tính tiền từ số lượng và đơn giá */
    public function calculateAmounts(): void
    {
        $this->tien_nt      = $this->so_luong * $this->don_gia_nt;
        $this->tien         = $this->so_luong * $this->don_gia;
        $this->thue_gtgt_nt = $this->tien_nt * ($this->ts_gtgt / 100);
        $this->thue_gtgt    = $this->tien * ($this->ts_gtgt / 100);
    }
}
