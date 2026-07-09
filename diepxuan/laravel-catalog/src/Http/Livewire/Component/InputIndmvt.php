<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-07-09
 */

namespace Diepxuan\Catalog\Http\Livewire\Component;

use Diepxuan\Simba\StoredProcedures\AsINGetDMVT;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class InputIndmvt extends Component
{
    #[Modelable]
    public $pMa_vt;
    protected $inDmVts;

    public function boot(): void
    {
        $this->inDmVts = AsINGetDMVT::call([
            'pMa_cty'   => \CatalogService::company()->id,
            'pMa_vt'    => null,
            'pStruct'   => null,
            'pLanguage' => null,
        ]);
    }

    public function mount(): void {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        return view('catalog::components.input-indmvt', [
            'inDmVts' => $this->inDmVts,
        ]);
    }
}
