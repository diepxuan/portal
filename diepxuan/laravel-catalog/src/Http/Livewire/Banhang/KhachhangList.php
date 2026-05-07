<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-07 10:15:08
 */

namespace Diepxuan\Catalog\Http\Livewire\Banhang;

use Diepxuan\Catalog\Models\ArDmKh;
use Diepxuan\Simba\SModel\SModel;
use Diepxuan\Simba\StoredProcedures\AsARDelDMKH;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Component KhachhangList.
 *
 * Hiển thị danh sách khách hàng với tìm kiếm và phân trang.
 */
class KhachhangList extends Component
{
    use WithPagination;

    /**
     * Từ khóa tìm kiếm.
     */
    public string $search = '';

    /**
     * Số lượng items mỗi trang.
     */
    protected int $perPage = 50;

    /**
     * Reset page khi search thay đổi.
     *
     * @var array<string, string>
     */
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    /**
     * Reset pagination về trang 1 khi search thay đổi.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Xóa khách hàng theo mã qua Stored Procedure.
     *
     * @param string $maKh mã khách hàng
     */
    public function deleteKhachHang(string $maKh): void
    {
        $khachHang = ArDmKh::withoutGlobalScopes()
            ->where('ma_kh', $maKh)
            ->first()
        ;

        if (!$khachHang) {
            $this->dispatch('error', message: 'Không tìm thấy khách hàng.');

            return;
        }

        if ($khachHang->hasTransactions()) {
            $this->dispatch('error', message: 'Không thể xóa khách hàng đã có giao dịch.');

            return;
        }

        // Đánh dấu ksd = false qua Stored Procedure
        try {
            AsARDelDMKH::call([
                'pMa_cty' => SModel::CTY,
                'pMa_kh'  => $maKh,
            ]);

            $this->dispatch('success', message: 'Đã xóa khách hàng ' . $maKh);
            $this->dispatch('khachhang-saved');
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Không thể xóa khách hàng: ' . $e->getMessage());
        }
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        $query = ArDmKh::laKhachHang();

        if ('' !== $this->search) {
            $search = $this->search;
            $query->where(static function ($q) use ($search): void {
                $q->where('ma_kh', 'like', "%{$search}%")
                    ->orWhere('ten_kh', 'like', "%{$search}%")
                    ->orWhere('dia_chi', 'like', "%{$search}%")
                    ->orWhere('tel', 'like', "%{$search}%")
                ;
            });
        }

        $khachhangs = $query->paginate($this->perPage);

        return view('catalog::banhang.khachhang', [
            'khachhangs' => $khachhangs,
        ])->layout('catalog::layouts.app');
    }
}
