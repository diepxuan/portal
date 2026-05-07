<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-07 11:55:25
 */

namespace Diepxuan\Catalog\Http\Livewire\Banhang;

use Diepxuan\Simba\SModel\SModel;
use Diepxuan\Simba\StoredProcedures\AsARGetDMKH;
use Diepxuan\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Component Khachhang.
 *
 * Hiển thị danh sách khách hàng.
 * Sử dụng Stored Procedure asARGetDMKH thay vì Eloquent query.
 */
class Khachhang extends Component
{
    public $pTk_List   = '';
    public $pTkdu_List = '111';
    public $pMa_Nt     = 'VND';
    public $pMa_Bp;
    protected $arDmKhs;

    /**
     * Khởi tạo: Lấy danh sách khách hàng từ SP.
     */
    public function mount(): void
    {
        // Gọi SP asARGetDMKH với module AR, lọc theo công ty hiện tại
        $this->arDmKhs = AsARGetDMKH::getCustomers(maCty: SModel::CTY);
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
        $this->arDmKhs = $this->arDmKhs instanceof Collection
            ? $this->arDmKhs
            : Collection::make($this->arDmKhs->all());

        return view('catalog::banhang.khachhang', [
            'arDmKhs' => $this->arDmKhs,
        ])->layout('catalog::layouts.app');
    }
}
