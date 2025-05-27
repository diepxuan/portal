<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-27 18:07:12
 */

namespace Diepxuan\Simba\Models;

use Diepxuan\Simba\SModel\GlDmTk as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GlDmTk extends Model
{
    protected function tenTk(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $value, array $attributes) => str_repeat(' ', max(0, ($attributes['bac_tk'] - 1) * 3)) . $attributes['tk'],
        );
    }

    protected function bold(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $value, array $attributes) => !$attributes['chi_tiet'],
        );
    }

    /**
     * Get the Simba status.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $value, array $attributes) => !$attributes['ksd'],
        );
    }
}
