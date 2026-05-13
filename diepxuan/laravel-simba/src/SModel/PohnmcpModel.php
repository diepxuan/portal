<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-13 11:29:55
 */

namespace Diepxuan\Simba\SModel;

use Illuminate\Database\Eloquent\Model;

class PohnmcpModel extends Model
{
    public $incrementing  = false;
    public $timestamps    = false;
    protected $table      = 'POHMNCP';
    protected $primaryKey = 'stt_rec0';
    protected $keyType    = 'string';

    protected $fillable = [
        'stt_rec', 'stt_rec0', 'ma_cp', 'ten_cp',
        'dvt', 'so_luong', 'don_gia_nt',
        'don_gia', 'tien_nt', 'tien',
        'ts_gtgt', 'thue_gtgt_nt', 'thue_gtgt',
        'tk_cp', 'dien_giai',
    ];

    protected $casts = [
        'so_luong'     => 'decimal:8',
        'don_gia_nt'   => 'decimal:8',
        'don_gia'      => 'decimal:8',
        'tien_nt'      => 'decimal:2',
        'tien'         => 'decimal:2',
        'ts_gtgt'      => 'decimal:4',
        'thue_gtgt_nt' => 'decimal:2',
        'thue_gtgt'    => 'decimal:2',
    ];
}
