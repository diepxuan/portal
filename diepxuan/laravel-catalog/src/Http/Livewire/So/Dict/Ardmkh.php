<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-08-02 00:00:00
 */

namespace Diepxuan\Catalog\Http\Livewire\So\Dict;

use Diepxuan\Catalog\Http\Livewire\Po\Dict\Ardmkh as BaseArdmkh;
use Diepxuan\Simba\SModel\SModel;
use Diepxuan\Simba\StoredProcedures\AsARGetDMKH;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\View\View;

/**
 * SO ARDMKH khách hàng — canonical namespace.
 */
class Ardmkh extends BaseArdmkh
{
    public function deleteDoiTuong(string $maKh): void
    {
        $khachHang = \Diepxuan\Catalog\Models\Simba\ArDmKh::withoutGlobalScopes()
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

        try {
            \Diepxuan\Simba\StoredProcedures\AsARDelDMKH::call([
                'pMa_cty' => SModel::CTY,
                'pMa_kh'  => $maKh,
            ]);

            $this->dispatch('success', message: 'Đã xóa khách hàng ' . $maKh);
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Không thể xóa khách hàng: ' . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('catalog::so.dict.ardmkh', [
            'arDmKhs' => $this->getCustomersPaginated(),
        ])->layout('catalog::layouts.app');
    }

    protected function getCustomersPaginated(): LengthAwarePaginatorContract
    {
        $results = AsARGetDMKH::getCustomers(
            maCty: SModel::CTY,
            search: '' !== $this->search ? $this->search : null,
        );

        $results = $this->normalizeRows($results);

        if ('' !== $this->search) {
            $results = $this->filterSearchResults($results);
        }

        return $this->paginateCollection($results);
    }
}
