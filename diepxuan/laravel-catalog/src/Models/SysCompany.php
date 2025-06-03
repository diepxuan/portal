<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-03 22:45:23
 */

namespace Diepxuan\Catalog\Models;

use Diepxuan\Simba\Models\SysCompany as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SysCompany extends Model
{
    public function siSetup(): HasOne
    {
        return $this->hasOne(SiSetup::class, 'ma_cty', 'ma_cty');
    }

    protected function id(): Attribute
    {
        return Attribute::get(
            static fn ($value, array $attributes) => $attributes['ma_cty'] ?? ''
        );
    }
}
