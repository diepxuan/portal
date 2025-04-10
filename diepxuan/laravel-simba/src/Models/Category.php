<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-20 22:40:33
 */

namespace Diepxuan\Simba\Models;

use Diepxuan\Simba\SModel\InDmNhvt;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends InDmNhvt
{
    /**
     * Get the Simba Category Id.
     */
    protected function id(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => implode('_', [$this->ma_cty, $this->ma_nhvt]),
        );
    }

    /**
     * Get the Simba Category Sku.
     */
    protected function sku(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->ma_nhvt,
        );
    }

    /**
     * Get the Simba Category parent.
     */
    protected function parent(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $value, array $attributes) => $attributes['nhom_me'] ?: '',
        );
    }

    /**
     * Get the Simba Category name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->ten_nhvt,
        );
    }
}
