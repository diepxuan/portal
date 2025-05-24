<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-24 18:42:29
 */

namespace Diepxuan\Simba\SModel;

use Illuminate\Database\Eloquent\Model;

class SysCompanyResx extends SModel
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sysCompanyResx';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // @TODO: check if this is needed
    }
}
