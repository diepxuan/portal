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

namespace Diepxuan\Catalog\Http\Livewire\Si\Vch;

use Illuminate\View\View;
use Livewire\Component;

class YearSelector extends Component
{
    public int $selectedYear;

    public ?string $statusMessage = null;

    public function mount(): void
    {
        $this->selectedYear = catalog()->year();
    }

    public function selectYear(int $year): void
    {
        if ($year < 2_006 || $year > 2_100) {
            $this->addError('selectedYear', __('Năm làm việc không hợp lệ.'));

            return;
        }

        $this->selectedYear  = catalog()->year($year);
        $this->statusMessage = __('Đã chọn năm làm việc :year.', ['year' => $this->selectedYear]);
    }

    public function render(): View
    {
        // Match DLL frmSiChangeFY: range = (current - 10) -> (current + 10)
        $currentYear = (int) now()->year;
        $from        = $currentYear - 10;
        $to          = $currentYear + 10;

        return view('catalog::si.vch.year-selector', [
            'years' => range($from, $to),
        ])->layout('catalog::layouts.app');
    }
}
