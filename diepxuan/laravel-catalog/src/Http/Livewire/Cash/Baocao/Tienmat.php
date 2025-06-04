<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-06-04 11:35:42
 */

namespace Diepxuan\Catalog\Http\Livewire\Cash\Baocao;

use Diepxuan\Catalog\Models\GlCt;
use Illuminate\View\View;
use Livewire\Component;

class Tienmat extends Component
{
    public $pTk    = '111';
    public $pMa_Nt = 'VND';
    protected $glCts;

    public function mount(): void
    {
        // \Debugbar::info(\CatalogService::timerFrom());
        // \Debugbar::info(\CatalogService::timerTo());
        // \Debugbar::info(\CatalogService::company()->siSetup->ngay_dntc);
        \Debugbar::info(\CatalogFunctions::afNamTC([
            'ma_cty' => \CatalogService::company()->ma_cty,
            'ngay'   => \CatalogService::timerFrom(),
        ]));
    }

    public function updated($property): void
    {
        // \Debugbar::info($property);
    }

    public function submit(): void
    {
        $this->glCts = GlCt::getCARptTMNH([
            'ma_Cty'   => \CatalogService::company()->id,
            'ngay_Ct1' => \CatalogService::timerFrom(),
            'ngay_Ct2' => \CatalogService::timerTo(),
            'tk'       => $this->pTk,
            'ma_Nt'    => \CatalogService::ma_Nt(),
        ])->get();
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render()
    {
        // diepxuan/laravel-catalog/resources/views/cash/baocao/tienmat.blade.php
        return view('catalog::cash.baocao.tienmat', [
            'glCts' => $this->glCts,
        ])->layout('catalog::layouts.app');
    }
}
