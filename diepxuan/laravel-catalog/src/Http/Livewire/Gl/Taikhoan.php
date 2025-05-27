<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-05-27 19:43:13
 */

namespace Diepxuan\Catalog\Http\Livewire\Gl;

use Illuminate\View\View;
use Livewire\Component;

class Taikhoan extends Component
{
    public function mount(): void
    {
        // \Debugbar::info($this->timer);
    }

    public function updated($property): void
    {
        // \Debugbar::info($property);
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render()
    {
        // diepxuan/laravel-catalog/resources/views/cash/tienmat/phieuthu/dashboard.blade.php
        return view('catalog::gl.taikhoan')->layout('catalog::layouts.app');
    }
}
