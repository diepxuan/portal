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

class PohnmModel extends Model
{
    public $incrementing  = false;
    public $timestamps    = false;
    protected $table      = 'POHMN';
    protected $primaryKey = 'stt_rec';
    protected $keyType    = 'string';

    protected $fillable = [
        'stt_rec', 'ma_cty', 'ma_ct', 'ngay_ct', 'so_ct',
        'so_hd', 'ngay_hd', 'ma_kh', 'nguoi_gd',
        'dia_chi', 'ma_so_thue', 'dien_giai',
        'ma_httt', 'ma_nt', 'ty_gia',
        't_tien_nt0', 't_tien0', 't_cp_nt', 't_cp',
        't_thue_nt', 't_thue', 't_ck_nt', 't_ck',
        't_tt_nt', 't_tt', 'tk_pt', 'tk_thue',
        'trang_thai', 'nguoi_lap',
    ];

    protected $casts = [
        'ngay_ct'    => 'datetime',
        'ngay_hd'    => 'datetime',
        'ty_gia'     => 'decimal:8',
        't_tien_nt0' => 'decimal:2',
        't_tien0'    => 'decimal:2',
        't_cp_nt'    => 'decimal:2',
        't_cp'       => 'decimal:2',
        't_thue_nt'  => 'decimal:2',
        't_thue'     => 'decimal:2',
        't_ck_nt'    => 'decimal:2',
        't_ck'       => 'decimal:2',
        't_tt_nt'    => 'decimal:2',
        't_tt'       => 'decimal:2',
    ];
}
