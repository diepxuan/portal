<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-24 11:47:21
 */

namespace Diepxuan\Simba\SModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SysLanguage extends SModel
{
    public const DEFAULT = 'vi-VN';

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
    protected $table = 'sysLanguage';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Name';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     * @deprecated
     */
    public static function updateCurrentCultureInfoOld(string $name): bool
    {
        $name     = $name ?: self::DEFAULT;
        $affected = DB::affectingStatement('CALL asUpdCurentCultureInfo(:pName)', [
            'pName' => $name,
        ]);

        return 0 !== $affected;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // @TODO: check if this is needed
    }
}
