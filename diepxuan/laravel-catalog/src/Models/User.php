<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-21 17:09:58
 */

namespace Diepxuan\Catalog\Models;

use App\Models\User as Model;
use Diepxuan\Simba\Models\SysUserInfo;
use Diepxuan\Simba\Models\UserLink;

class User extends Model
{
    public function simbaLink()
    {
        return $this->hasOne(UserLink::class, 'laravel_user_id');
    }

    public function simbaUser()
    {
        return $this->hasOneThrough(
            SysUserInfo::class,
            UserLink::class,
            'laravel_user_id',   // Foreign key on UserLink
            'username',            // Foreign key on SysUserInfo
            'id',                // Local key on User
            'simba_user_id'      // Local key on UserLink
        );
    }
}
