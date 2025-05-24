<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-24 21:19:49
 */

namespace Diepxuan\Simba\Models;

use Diepxuan\Simba\SModel\SysLanguage as Model;

class SysLanguage extends Model
{
    /**
     * is Enable scope.
     *
     * @param mixed $query
     */
    public function scopeIsEnable($query)
    {
        return $query->where('ksd', 0);
    }

    /**
     * Current scope.
     *
     * @param mixed $query
     */
    public function scopeCurrent($query)
    {
        return $query->where('Selected', 1);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    public static function updateCurrentCultureInfo(string $name): bool
    {
        $name ??= self::DEFAULT;

        if (self::where('Name', $name)->exists()) {
            self::where('Name', '!=', $name)->update(['selected' => 0]);
            self::where('Name', $name)->update(['selected' => 1]);
        } else {
            return false;
        }

        return true;
    }
}
