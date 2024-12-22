<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-22 11:51:58
 */

namespace Diepxuan\Database\Eloquent;

use Diepxuan\Database\Eloquent\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class CompositeModel extends Model
{
    use HasCompositePrimaryKey;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = ['id'];
}
