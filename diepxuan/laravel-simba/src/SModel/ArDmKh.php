<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-01 16:54:02
 */

namespace Diepxuan\Simba\SModel;

class ArDmKh extends SModel
{
    public const CREATED_AT = 'cdate';
    public const UPDATED_AT = 'ldate';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ArDmKh';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ma_kh';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tinh_dt_nb' => 'boolean',
        'isKh'       => 'boolean',
        'isNcc'      => 'boolean',
        'isNv'       => 'boolean',
        'ksd'        => 'boolean',
    ];

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';
}
