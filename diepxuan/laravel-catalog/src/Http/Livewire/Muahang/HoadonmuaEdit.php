<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-13 18:05:32
 */

namespace Diepxuan\Catalog\Http\Livewire\Muahang;

use Diepxuan\Simba\Models\ArDmKh;
use Diepxuan\Simba\Models\PO\POHMN;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Form nhập/sửa hóa đơn mua hàng (PO3).
 */
class HoadonmuaEdit extends Component
{
    const MA_CT = 'PO3';

    // Header
    public ?string $pStt_rec   = null;
    public string $pMode       = 'create';
    public ?string $pNgay_ct   = null;
    public string $pSo_ct      = '';
    public string $pSo_hd      = '';
    public ?string $pNgay_hd   = null;
    public ?string $pMa_kh     = null;
    public string $pTen_kh     = '';
    public string $pNguoi_gd   = '';
    public string $pDia_chi    = '';
    public string $pMa_so_thue = '';
    public string $pDien_giai  = '';
    public ?string $pMa_httt   = null;
    public string $pMa_nt      = 'VND';
    public float $pTy_gia      = 1;
    public string $pTk_pt      = '';
    public string $pTk_thue    = '';

    // Totals
    public float $pT_tien_nt0 = 0;
    public float $pT_tien0    = 0;
    public float $pT_cp_nt    = 0;
    public float $pT_cp       = 0;
    public float $pT_thue_nt  = 0;
    public float $pT_thue     = 0;
    public float $pT_ck_nt    = 0;
    public float $pT_ck       = 0;
    public float $pT_tt_nt    = 0;
    public float $pT_tt       = 0;

    // Details & Costs
    public array $pChiTiet = [];
    public array $pChiPhi  = [];

    // UI state
    public int $pActiveTab = 0; // 0=Chi tiết, 1=Chi phí, 2=Hạch toán

    public function mount(?string $stt_rec = null): void
    {
        $this->pNgay_ct = now()->format('Y-m-d');

        if ($stt_rec) {
            $this->pMode = 'edit';
            $this->loadInvoice($stt_rec);
        }
    }

    public function loadInvoice(string $stt_rec): void
    {
        $invoice = POHMN::with(['chiTiets', 'chiPhis', 'nhaCungCap'])->find($stt_rec);

        if (!$invoice) {
            session()->flash('error', 'Không tìm thấy hóa đơn.');
            $this->redirectRoute('muahang.hoadonmua');

            return;
        }

        $this->pStt_rec    = $invoice->stt_rec;
        $this->pNgay_ct    = optional($invoice->ngay_ct)->format('Y-m-d');
        $this->pSo_ct      = $invoice->so_ct ?? '';
        $this->pSo_hd      = $invoice->so_hd ?? '';
        $this->pNgay_hd    = optional($invoice->ngay_hd)->format('Y-m-d');
        $this->pMa_kh      = $invoice->ma_kh;
        $this->pTen_kh     = $invoice->nhaCungCap?->ten_kh ?? '';
        $this->pNguoi_gd   = $invoice->nguoi_gd ?? '';
        $this->pDia_chi    = $invoice->dia_chi ?? '';
        $this->pMa_so_thue = $invoice->ma_so_thue ?? '';
        $this->pDien_giai  = $invoice->dien_giai ?? '';
        $this->pMa_httt    = $invoice->ma_httt;
        $this->pMa_nt      = $invoice->ma_nt ?? 'VND';
        $this->pTy_gia     = (float) ($invoice->ty_gia ?? 1);
        $this->pTk_pt      = $invoice->tk_pt ?? '';
        $this->pTk_thue    = $invoice->tk_thue ?? '';

        $this->pT_tien_nt0 = (float) ($invoice->t_tien_nt0 ?? 0);
        $this->pT_tien0    = (float) ($invoice->t_tien0 ?? 0);
        $this->pT_cp_nt    = (float) ($invoice->t_cp_nt ?? 0);
        $this->pT_cp       = (float) ($invoice->t_cp ?? 0);
        $this->pT_thue_nt  = (float) ($invoice->t_thue_nt ?? 0);
        $this->pT_thue     = (float) ($invoice->t_thue ?? 0);
        $this->pT_ck_nt    = (float) ($invoice->t_ck_nt ?? 0);
        $this->pT_ck       = (float) ($invoice->t_ck ?? 0);
        $this->pT_tt_nt    = (float) ($invoice->t_tt_nt ?? 0);
        $this->pT_tt       = (float) ($invoice->t_tt ?? 0);

        $this->pChiTiet = $invoice->chiTiets->map(static fn ($ct) => [
            'stt_rec0'     => $ct->stt_rec0 ?? '',
            'ma_vt'        => $ct->ma_vt ?? '',
            'ten_vt'       => $ct->ten_vt ?? '',
            'dvt'          => $ct->dvt ?? '',
            'ma_kho'       => $ct->ma_kho ?? '',
            'so_luong'     => (float) ($ct->so_luong ?? 0),
            'gia_nt0'      => (float) ($ct->gia_nt0 ?? 0),
            'gia0'         => (float) ($ct->gia0 ?? 0),
            'tien_nt0'     => (float) ($ct->tien_nt0 ?? 0),
            'tien0'        => (float) ($ct->tien0 ?? 0),
            'ts_gtgt'      => (float) ($ct->ts_gtgt ?? 0),
            'thue_gtgt_nt' => (float) ($ct->thue_gtgt_nt ?? 0),
            'thue_gtgt'    => (float) ($ct->thue_gtgt ?? 0),
            'tk_vt'        => $ct->tk_vt ?? '',
            'tk_thue'      => $ct->tk_thue ?? '',
            'dien_giai'    => $ct->dien_giai ?? '',
        ])->toArray();

        $this->pChiPhi = $invoice->chiPhis->map(static fn ($cp) => [
            'stt_rec0'     => $cp->stt_rec0 ?? '',
            'ma_cp'        => $cp->ma_cp ?? '',
            'ten_cp'       => $cp->ten_cp ?? '',
            'dvt'          => $cp->dvt ?? '',
            'so_luong'     => (float) ($cp->so_luong ?? 0),
            'don_gia_nt'   => (float) ($cp->don_gia_nt ?? 0),
            'don_gia'      => (float) ($cp->don_gia ?? 0),
            'tien_nt'      => (float) ($cp->tien_nt ?? 0),
            'tien'         => (float) ($cp->tien ?? 0),
            'ts_gtgt'      => (float) ($cp->ts_gtgt ?? 0),
            'thue_gtgt_nt' => (float) ($cp->thue_gtgt_nt ?? 0),
            'thue_gtgt'    => (float) ($cp->thue_gtgt ?? 0),
            'tk_cp'        => $cp->tk_cp ?? '',
            'dien_giai'    => $cp->dien_giai ?? '',
        ])->toArray();
    }

    public function updatedPMaKh($value): void
    {
        if (empty($value)) {
            $this->pTen_kh     = '';
            $this->pDia_chi    = '';
            $this->pMa_so_thue = '';
            $this->pNguoi_gd   = '';

            return;
        }

        $ncc = ArDmKh::find($value);
        if ($ncc) {
            $this->pTen_kh     = $ncc->ten_kh ?? '';
            $this->pDia_chi    = $ncc->dia_chi ?? '';
            $this->pMa_so_thue = $ncc->ma_so_thue ?? '';
            $this->pNguoi_gd   = $ncc->nguoi_gd ?? '';
            if ($ncc->ma_httt_po) {
                $this->pMa_httt = $ncc->ma_httt_po;
            }
        }
    }

    public function addChiTietRow(): void
    {
        $this->pChiTiet[] = [
            'stt_rec0'     => '',
            'ma_vt'        => '',
            'ten_vt'       => '',
            'dvt'          => '',
            'ma_kho'       => '',
            'so_luong'     => 0,
            'gia_nt0'      => 0,
            'gia0'         => 0,
            'tien_nt0'     => 0,
            'tien0'        => 0,
            'ts_gtgt'      => 0,
            'thue_gtgt_nt' => 0,
            'thue_gtgt'    => 0,
            'tk_vt'        => '',
            'tk_thue'      => '',
            'dien_giai'    => '',
        ];
    }

    public function removeChiTietRow(int $index): void
    {
        unset($this->pChiTiet[$index]);
        $this->pChiTiet = array_values($this->pChiTiet);
        $this->recalculateTotals();
    }

    public function addChiPhiRow(): void
    {
        $this->pChiPhi[] = [
            'stt_rec0'     => '',
            'ma_cp'        => '',
            'ten_cp'       => '',
            'dvt'          => '',
            'so_luong'     => 0,
            'don_gia_nt'   => 0,
            'don_gia'      => 0,
            'tien_nt'      => 0,
            'tien'         => 0,
            'ts_gtgt'      => 0,
            'thue_gtgt_nt' => 0,
            'thue_gtgt'    => 0,
            'tk_cp'        => '',
            'dien_giai'    => '',
        ];
    }

    public function removeChiPhiRow(int $index): void
    {
        unset($this->pChiPhi[$index]);
        $this->pChiPhi = array_values($this->pChiPhi);
        $this->recalculateTotals();
    }

    public function calculateChiTietRow(int $index): void
    {
        $row                 = &$this->pChiTiet[$index];
        $row['tien_nt0']     = round($row['so_luong'] * $row['gia_nt0'], 2);
        $row['tien0']        = round($row['so_luong'] * $row['gia0'], 2);
        $row['thue_gtgt_nt'] = round($row['tien_nt0'] * ($row['ts_gtgt'] / 100), 2);
        $row['thue_gtgt']    = round($row['tien0'] * ($row['ts_gtgt'] / 100), 2);
        $this->recalculateTotals();
    }

    public function calculateChiPhiRow(int $index): void
    {
        $row                 = &$this->pChiPhi[$index];
        $row['tien_nt']      = round($row['so_luong'] * $row['don_gia_nt'], 2);
        $row['tien']         = round($row['so_luong'] * $row['don_gia'], 2);
        $row['thue_gtgt_nt'] = round($row['tien_nt'] * ($row['ts_gtgt'] / 100), 2);
        $row['thue_gtgt']    = round($row['tien'] * ($row['ts_gtgt'] / 100), 2);
        $this->recalculateTotals();
    }

    public function recalculateTotals(): void
    {
        $this->pT_tien_nt0 = round(array_sum(array_column($this->pChiTiet, 'tien_nt0')), 2);
        $this->pT_tien0    = round(array_sum(array_column($this->pChiTiet, 'tien0')), 2);
        $this->pT_thue_nt  = round(array_sum(array_column($this->pChiTiet, 'thue_gtgt_nt')), 2);
        $this->pT_thue     = round(array_sum(array_column($this->pChiTiet, 'thue_gtgt')), 2);
        $this->pT_cp_nt    = round(array_sum(array_column($this->pChiPhi, 'tien_nt')), 2);
        $this->pT_cp       = round(array_sum(array_column($this->pChiPhi, 'tien')), 2);
        $this->pT_tt_nt    = round($this->pT_tien_nt0 + $this->pT_thue_nt + $this->pT_cp_nt, 2);
        $this->pT_tt       = round($this->pT_tien0 + $this->pT_thue + $this->pT_cp, 2);
    }

    public function submit(): void
    {
        $this->validate([
            'pMa_kh'   => 'required|string',
            'pSo_hd'   => 'required|string',
            'pNgay_hd' => 'required|date',
            'pNgay_ct' => 'required|date',
        ], [
            'pMa_kh.required'   => 'Nhà cung cấp không được trống',
            'pSo_hd.required'   => 'Số hóa đơn không được trống',
            'pNgay_hd.required' => 'Ngày hóa đơn không được trống',
            'pNgay_ct.required' => 'Ngày chứng từ không được trống',
        ]);

        // TODO: Call stored procedures to save
        // AsPOInsOrder / AsPOUpdOrder
        // AsPOInsCt1 / AsPOUpdCt1
        // AsPOInsCP / AsPOUpdCP

        session()->flash('success', 'Đã lưu hóa đơn mua hàng.');
        $this->redirectRoute('muahang.hoadonmua');
    }

    public function render(): View
    {
        return view('catalog::muahang.hoadonmua-edit', [
            'mode' => $this->pMode,
        ])->layout('catalog::layouts.app');
    }
}
