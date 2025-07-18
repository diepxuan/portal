<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-09 09:40:31
 */

namespace Diepxuan\Simba\SModel;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

abstract class SModel extends Model
{
    use HasFactory;

    public const CTY = '001';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Create a new Eloquent model instance.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('simba.connection');
    }

    /**
     * The scope check this model is enable.
     *
     * @param mixed $query
     *
     * @return mixed
     */
    public function scopeIsEnable($query)
    {
        return $query;

        return $query->where('ksd', 0);
    }

    /**
     * Scope a query to only include the last n days records.
     *
     * @param Builder $query
     * @param mixed   $fromDate
     * @param mixed   $toDate
     * @param mixed   $fieldName
     */
    public function scopeWhereDateBetween($query, $fromDate, $toDate, string $fieldName = 'ngay_ct'): Builder
    {
        // return $query->whereBetween($fieldName, [$fromDate, $toDate]);

        return $query->whereDate($fieldName, '>=', $fromDate)->whereDate($fieldName, '<=', $toDate);
    }

    /** Filter theo khoảng ngày */
    public function scopeFilterByNgayCt(Builder $query, string $from, string $to): Builder
    {
        return $query->whereDateBetween($from, $to, 'ngay_ct');
    }

    public function scopeFilterLikeList(Builder $query, string $column, string $csv): Builder
    {
        $items = array_filter(array_map('trim', explode(',', $csv)));

        if (0 === \count($items)) {
            return $query;
        }

        if (1 === \count($items)) {
            return $query->where('tk', 'like', $items[0] . '%');
        }

        return \count($items) > 1 ? $query->where(static function ($q) use ($items, $column): void {
            foreach ($items as $item) {
                $q->orWhere($column, 'like', $item . '%');
            }
        }) : $query;
    }

    /** Filter theo mã công ty */
    public function scopeFilterByMaCty(Builder $query, ?string $maCty = null, string $fieldName = 'ma_cty'): Builder
    {
        if (null === $maCty) {
            $maCty = \CatalogService::company()->ma_cty ?? static::CTY;
        }

        return $query->where($fieldName, $maCty);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('onlyFirstCompany', static function (Builder $builder): void {
            $tableName  = (new static())->getTable();
            $connection = (new static())->getConnectionName() ?? config('database.default');

            if (!Schema::connection($connection)->hasColumn($tableName, 'ma_cty')) {
                return; // Không có cột ma_cty thì không thêm where
            }

            $column = $tableName ? $tableName . '.ma_cty' : 'ma_cty';
            $maCty  = static::CTY;

            if (class_exists(\CatalogService::class) && method_exists(\CatalogService::class, 'company')) {
                $maCty = \CatalogService::company()?->ma_cty ?? $maCty;
            }

            if (null !== $maCty) {
                $builder->where($column, $maCty);
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        // return $this->casts;
        return array_merge(parent::casts(), $this->casts);
    }
}
