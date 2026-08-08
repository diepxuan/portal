<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-08-08
 */

namespace Diepxuan\Catalog\Http\Livewire\Component;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Input chọn năm làm việc trên header.
 *
 * Danh sách năm theo DLL gốc `frmSiChangeFY`: hiện tại - 10 -> hiện tại + 10.
 * Không truy vấn bảng dữ liệu mua/bán/xuất/nhập kho.
 */
class InputYearWorked extends Component
{
    public const YEAR_RANGE = 10;

    public bool $open = false;

    public int $selectedYear;

    public ?string $statusMessage = null;

    public function mount(): void
    {
        $this->selectedYear = catalog()->year();
    }

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function selectYear(int $year): void
    {
        $currentYear = (int) now()->year;
        if ($year < $currentYear - self::YEAR_RANGE || $year > $currentYear + self::YEAR_RANGE) {
            $this->addError('selectedYear', __('Năm làm việc không hợp lệ.'));

            return;
        }

        $this->selectedYear  = catalog()->year($year);
        $this->statusMessage = __('Đã chọn năm làm việc :year.', ['year' => $this->selectedYear]);
        $this->open          = false;
        $this->redirect(request()->url(), navigate: true);
    }

    public function render(): View
    {
        return view('catalog::components.input-year-worked', [
            'years' => self::availableYears(),
        ]);
    }

    /**
     * Build the selectable year range: current - 10 -> current + 10.
     *
     * @return Collection<int, int>
     */
    public static function availableYears(?int $currentYear = null): Collection
    {
        $currentYear ??= (int) now()->year;

        return collect(range($currentYear - self::YEAR_RANGE, $currentYear + self::YEAR_RANGE));
    }
}
