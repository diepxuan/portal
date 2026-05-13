<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-13 18:05:31
 */

namespace Diepxuan\Catalog\Http\Livewire\Muahang;

use Diepxuan\Simba\Models\PO\POHMN;
use Diepxuan\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Danh sách hóa đơn mua hàng (PO3).
 */
class Hoadonmua extends Component
{
    public string $pSearch   = '';
    public ?string $pMa_Kh   = null;
    public ?string $pNgayCt1 = null;
    public ?string $pNgayCt2 = null;
    public int $pPageIndex   = 1;
    public int $pPageSize    = 50;

    protected $pohnms;

    public function mount(): void
    {
        $this->loadData();
    }

    public function updated($property): void
    {
        if (str_starts_with($property, 'p')) {
            $this->pPageIndex = 1;
            $this->loadData();
        }
    }

    public function loadData(): void
    {
        $this->pohnms = POHMN::filterBySearch($this->pSearch)
            ->filterByMaKh($this->pMa_Kh)
            ->filterByNgayCt($this->pNgayCt1, $this->pNgayCt2)
            ->orderByDesc('ngay_ct')
            ->orderByDesc('so_ct')
            ->paginate($this->pPageSize, ['*'], 'page', $this->pPageIndex)
        ;
    }

    public function render(): View
    {
        $invoices = $this->pohnms instanceof Collection
            ? $this->pohnms
            : Collection::make($this->pohnms->items() ?? []);

        return view('catalog::muahang.hoadonmua', [
            'invoices'  => $invoices,
            'paginator' => $this->pohnms,
        ])->layout('catalog::layouts.app');
    }
}
