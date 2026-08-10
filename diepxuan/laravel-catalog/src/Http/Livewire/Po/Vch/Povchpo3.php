<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-07-18
 */

namespace Diepxuan\Catalog\Http\Livewire\Po\Vch;

use Diepxuan\Simba\StoredProcedures\AsPOFilt3;
use Diepxuan\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Danh sách hóa đơn mua hàng (PO3).
 *
 * Mapping:
 * - menuID   : `10.10.14` (sysMenu).
 * - DLL      : `POVchPO3.dll` (form `frmPOVchPO3`).
 * - SP       : `asPOFilt3` (danh sách header + chi tiết) + `asPOGetPO3` (mở edit).
 * - Route    : `_simba-source/po/vch/povchpo3` (slug khong suffix menuid vi PO3 la 1-1 sysMenu).
 *
 * Refactor tu `Muahang\Hoadonmua` (dead code) sang pattern chuan `Po\Vch\Povchpo3`
 * (giong `So\Vch\Sovchso3`). Bind SP `asPOFilt3` thay vi Eloquent `PoPh3`.
 */
class Povchpo3 extends Component
{
    public const MA_CT = 'PO3';

    public string $pSearch = '';

    public ?string $pMa_kh = null;

    public int $pPageIndex = 1;

    public int $pPageSize = 50;

    public int $timerKey = 0;

    protected $invoices;

    public function mount(): void
    {
        $this->loadData();
    }

    public function updated($property): void
    {
        if (str_starts_with((string) $property, 'p')) {
            $this->pPageIndex = 1;
            $this->loadData();
        }
    }

    public function loadData(): void
    {
        $maCty = (string) \CatalogService::company()->id;
        $sets = AsPOFilt3::callWithDataSets([
            'pKeyPh' => AsPOFilt3::keyPh(
                $maCty,
                self::MA_CT,
                \CatalogService::timerFrom(),
                \CatalogService::timerTo(),
                $this->pMa_kh,
                $this->pSearch
            ),
            'pKeyCt' => AsPOFilt3::keyCt($maCty),
        ]);

        $this->invoices = $sets['ph']
            ->map(static fn (mixed $row): array => (array) $row);
    }

    public function resetFilters(): void
    {
        $this->pSearch    = '';
        $this->pMa_kh     = null;
        $this->pPageIndex = 1;

        \CatalogService::timer(['id' => 't' . str_pad((string) now()->month, 2, '0', STR_PAD_LEFT)]);
        $this->timerKey++;

        $this->loadData();
    }

    public function exportCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $rows = $this->invoices ?? collect();
        $filename = 'po3-hoa-don-mua-hang-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(static function () use ($rows): void {
            $handle = fopen('php://output', 'wb');
            if (false === $handle) {
                return;
            }

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Số CT', 'Số HĐ', 'Ngày CT', 'Ngày HĐ', 'Mã NCC', 'Diễn giải', 'Tổng tiền']);
            foreach ($rows as $row) {
                fputcsv($handle, [
                    (string) ($row['so_ct'] ?? ''),
                    (string) ($row['so_hd'] ?? ''),
                    (string) ($row['ngay_ct'] ?? ''),
                    (string) ($row['ngay_hd'] ?? ''),
                    (string) ($row['ma_kh'] ?? ''),
                    (string) ($row['dien_giai'] ?? ''),
                    (string) ($row['t_tt'] ?? 0),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function render(): View
    {
        return view('catalog::po.vch.povchpo3', [
            'invoices' => $this->invoices,
        ])->layout('catalog::layouts.app');
    }
}
