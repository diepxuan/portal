<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-24 12:41:09
 */

namespace Diepxuan\Simba\Models;

use Diepxuan\Simba\SModel\SysCompany as Model;

class SysCompany extends Model
{
    public function userRights()
    {
        return $this->hasMany(SysUserCompanyRight::class, 'Ma_cty', 'ma_cty');
    }

    public function users()
    {
        return $this->belongsToMany(
            SysUserInfo::class,
            'sysUserCompanyRight',
            'Ma_cty',      // Foreign key on pivot (trỏ tới company)
            'Username',    // Foreign key on pivot (trỏ tới user)
            'ma_cty',      // Local key on this model
            'username'     // Local key on SysUserInfo
        );
    }
}
