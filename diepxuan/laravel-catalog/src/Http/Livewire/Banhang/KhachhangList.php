<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-05 20:11:16
 */

namespace Diepxuan\Catalog\Http\Livewire\Banhang;

use Diepxuan\Catalog\Models\ArDmKh;
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
     * Xóa khách hàng theo mã.
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

        // Đánh dấu ksd = false thay vì xóa hẳn
        $khachHang->ksd   = false;
        $khachHang->luser = auth()->user()->name ?? 'system';
        $khachHang->ldate = now();
        $khachHang->save();

        $this->dispatch('success', message: 'Đã xóa khách hàng ' . $maKh);
        $this->dispatch('khachhang-saved');
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
