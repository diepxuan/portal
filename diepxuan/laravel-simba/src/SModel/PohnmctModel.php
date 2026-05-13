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

class PohnmctModel extends Model
{
    public $incrementing  = false;
    public $timestamps    = false;
    protected $table      = 'POHMNCT';
    protected $primaryKey = 'stt_rec0';
    protected $keyType    = 'string';

    protected $fillable = [
        'stt_rec', 'stt_rec0', 'ma_vt', 'ten_vt',
        'dvt', 'ma_kho', 'so_luong',
        'gia_nt0', 'gia0', 'tien_nt0', 'tien0',
        'ts_gtgt', 'thue_gtgt_nt', 'thue_gtgt',
        'tk_vt', 'tk_thue', 'dien_giai',
        'ma_ct_pnh', 'stt_rec_pnh',
    ];

    protected $casts = [
        'so_luong'     => 'decimal:8',
        'gia_nt0'      => 'decimal:8',
        'gia0'         => 'decimal:8',
        'tien_nt0'     => 'decimal:2',
        'tien0'        => 'decimal:2',
        'ts_gtgt'      => 'decimal:4',
        'thue_gtgt_nt' => 'decimal:2',
        'thue_gtgt'    => 'decimal:2',
    ];
}
