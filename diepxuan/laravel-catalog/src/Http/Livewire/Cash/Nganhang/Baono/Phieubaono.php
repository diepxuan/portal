<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-01-16 14:21:40
 */

namespace Diepxuan\Catalog\Http\Livewire\Cash\Nganhang\Baono;

use Diepxuan\Catalog\Models\ArDmKh;
use Diepxuan\Simba\StoredProcedures\AsGetSoCt;
use Diepxuan\Simba\StoredProcedures\AsPostCaph3_glct;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Phieubaono extends Component
{
    public $pMa_Kh;
    public $pKh;
    public $pDien_Giai;
    public $pTk_Co = 11217;
    public $pNgay_Ct;
    public $pSo_Ct;
    public $pNgay_Lap;
    public $pDia_Chi = '';
    public $pNguoi_Gd = '';
    public $pMa_Nt = 'VND';
    public $pTy_Gia = 1;
    public $pT_Tien_Nt = 0;
    public $pT_Thue = 0;
    public $pT_TT = 0;
    public $pT_Thue_Nt = 0;
    public $pT_TT_Nt = 0;
    public $pTrang_Thai = '1';
    public $pPost2Gl = '0';
    public Collection $pCts;
    public $pSoDu;
    public $pTong_Ps_No = 0;

    protected $rules = [
        'pMa_Kh'       => 'required',
        'pTk_Co'       => 'required',
        'pNgay_Ct'     => 'required|date',
        'pNgay_Lap'    => 'required|date',
        'pDia_Chi'     => 'nullable|string|max:255',
        'pNguoi_Gd'    => 'nullable|string|max:30',
        'pMa_Nt'       => 'required|string|size:3',
        'pTy_Gia'      => 'required|numeric|min:0',
        'pCts.*.ma_tk' => 'required',
        'pCts.*.ps_no' => 'required|numeric|min:0',
        'pCts.*.ps_co' => 'nullable|numeric|min:0',
        'pCts.*.ps_no_nt' => 'nullable|numeric|min:0',
        'pCts.*.ps_co_nt' => 'nullable|numeric|min:0',
        'pCts.*.ma_kh' => 'nullable|string|max:20',
        'pCts.*.ma_hd' => 'nullable|string|max:20',
        'pCts.*.ma_bp' => 'nullable|string|max:20',
        'pCts.*.ma_phi' => 'nullable|string|max:20',
        'pCts.*.ma_spct' => 'nullable|string|max:20',
        'pCts.*.ma_lo' => 'nullable|string|max:20',
        'pCts.*.ma_ku' => 'nullable|string|max:20',
    ];

    public function mount(): void
    {
        $this->pNgay_Ct  = now()->toDateString();
        $this->pNgay_Lap = now()->toDateString();
        $this->pNguoi_Gd = \Auth::user()->name ?? '';
        $this->pCts      = collect();
        $this->addRow();
        
        $this->pSo_Ct    = AsGetSoCt::call([
            'pMa_ct'   => 'CA4',
            'pNgay_Ct' => $this->pNgay_Ct,
        ]);
        \Debugbar::info('mount');
    }

    public function updated($property): void
    {
        if ($property == 'pMa_Kh') {
            $this->updateKhachHang();
        }

        if ($property == 'pDien_Giai') {
            $this->pCts = $this->pCts->map(function ($row) {
                $row['dien_giai'] = $this->pDien_Giai;
                return $row;
            });
        }

        if (str_contains($property, 'pCts')) {
            $this->calculateTotal();
            $this->calculateForeignCurrency();
        }

        if (in_array($property, ['pTong_Ps_No', 'pTy_Gia', 'pT_Thue'])) {
            $this->calculateForeignCurrency();
        }
        
        \Debugbar::info('updated');
        \Debugbar::info($property);
    }

    public function calculateTotal(): void
    {
        $this->pTong_Ps_No = $this->pCts->sum(function ($item) {
            return (float) ($item['ps_no'] ?? 0);
        });
        
        // Tính tổng thanh toán = Tổng phát sinh nợ + Thuế
        $this->pT_TT = $this->pTong_Ps_No + $this->pT_Thue;
    }

    public function calculateForeignCurrency(): void
    {
        // Tính tiền ngoại tệ
        $this->pT_Tien_Nt = $this->pTong_Ps_No * $this->pTy_Gia;
        $this->pT_Thue_Nt = $this->pT_Thue * $this->pTy_Gia;
        $this->pT_TT_Nt = $this->pT_TT * $this->pTy_Gia;
        
        // Cập nhật ps_no_nt và ps_co_nt cho từng dòng
        $this->pCts = $this->pCts->map(function ($row) {
            $row['ps_no_nt'] = ($row['ps_no'] ?? 0) * $this->pTy_Gia;
            $row['ps_co_nt'] = ($row['ps_co'] ?? 0) * $this->pTy_Gia;
            return $row;
        });
    }

    public function submit(): void
    {
        $this->validate();

        if ($this->pTong_Ps_No <= 0) {
            $this->addError('pCts', 'Tổng phát sinh nợ phải lớn hơn 0');
            return;
        }

        // Generate So Ct if empty
        if (empty($this->pSo_Ct)) {
             $this->pSo_Ct = AsGetSoCt::call([
                'pMa_ct'   => 'CA4',
                'pNgay_Ct' => $this->pNgay_Ct,
            ]);
        }

        $stt_rec = \Str::uuid()->toString(); // Or generate appropriate ID

        // Create Header
        $caPh3 = new \Diepxuan\Catalog\Models\CaPh3();
        // Assume model has fillable or we set attributes directly
        // Mapping based on CaPh3 table structure (inferred)
        
        // Transaction to ensure atomicity
        \DB::transaction(function () use ($stt_rec) {
            $user = \Auth::user();
            
            // 1. Save Header (CaPh3)
            $caPh3 = new \Diepxuan\Catalog\Models\CaPh3();
            $caPh3->stt_rec     = $stt_rec;
            $caPh3->ma_ct       = 'CA4';
            $caPh3->so_ct       = $this->pSo_Ct;
            $caPh3->ngay_ct     = $this->pNgay_Ct;
            $caPh3->ngay_lct    = $this->pNgay_Lap;
            $caPh3->kht_tain    = 0; // Default
            $caPh3->ma_kh       = $this->pMa_Kh;
            $caPh3->dia_chi     = $this->pDia_Chi;
            $caPh3->nguoi_gd    = $this->pNguoi_Gd;
            $caPh3->dien_giai   = $this->pDien_Giai;
            $caPh3->tk_co       = $this->pTk_Co;
            $caPh3->ma_nt       = $this->pMa_Nt;
            $caPh3->ty_gia      = $this->pTy_Gia;
            $caPh3->t_tien_nt   = $this->pT_Tien_Nt;
            $caPh3->t_tien      = $this->pTong_Ps_No;
            $caPh3->t_thue      = $this->pT_Thue;
            $caPh3->t_tt        = $this->pT_TT;
            $caPh3->t_thue_nt   = $this->pT_Thue_Nt;
            $caPh3->t_tt_nt     = $this->pT_TT_Nt;
            $caPh3->trang_thai  = $this->pTrang_Thai;
            $caPh3->post2gl     = $this->pPost2Gl;
            $caPh3->cdate       = now();
            $caPh3->cuser       = \Auth::user()->name ?? '';
            $caPh3->ldate       = now();
            $caPh3->luser       = \Auth::user()->name ?? '';
            $caPh3->ma_cty      = \CatalogService::company()->id ?? '001';
            $caPh3->save();

            // 2. Save Details (CaCt3)
            foreach ($this->pCts as $index => $row) {
                if (empty($row['ma_tk']) || empty($row['ps_no'])) continue;

                $caCt3 = new \Diepxuan\Catalog\Models\CaCt3();
                $caCt3->stt_rec      = $stt_rec;
                $caCt3->stt_rec0     = str_pad((string)($index + 1), 3, '0', STR_PAD_LEFT); 
                $caCt3->stt_rec_pc   = '';
                $caCt3->stt_rec0_pc  = '';
                $caCt3->so_pc        = '';
                $caCt3->ma_cty       = $caPh3->ma_cty;
                $caCt3->tk           = $row['ma_tk'];
                $caCt3->ps_no        = $row['ps_no'] ?? 0;
                $caCt3->ps_co        = $row['ps_co'] ?? 0;
                $caCt3->ps_no_nt     = $row['ps_no_nt'] ?? 0;
                $caCt3->ps_co_nt     = $row['ps_co_nt'] ?? 0;
                $caCt3->dien_giai    = $row['dien_giai'] ?? $this->pDien_Giai;
                $caCt3->ma_kh        = $row['ma_kh'] ?? $this->pMa_Kh;
                $caCt3->ma_hd        = $row['ma_hd'] ?? '';
                $caCt3->ma_bp        = $row['ma_bp'] ?? '';
                $caCt3->ma_phi       = $row['ma_phi'] ?? '';
                $caCt3->ma_spct      = $row['ma_spct'] ?? '';
                $caCt3->ma_lo        = $row['ma_lo'] ?? '';
                $caCt3->ma_ku        = $row['ma_ku'] ?? '';
                $caCt3->save();
            }

            // 3. Post to GL
            // Executing stored procedure using stored procedure class
            AsPostCaph3_glct::call([
                'pMa_cty' => $caPh3->ma_cty,
                'pStt_rec' => $stt_rec,
            ]);
        });

        session()->flash('message', 'Phiếu báo nợ đã được lưu thành công.');
        
        // Reset form
        $this->reset([
            'pDien_Giai', 'pCts', 'pSo_Ct', 'pTong_Ps_No',
            'pDia_Chi', 'pNguoi_Gd', 'pMa_Nt', 'pTy_Gia',
            'pT_Tien_Nt', 'pT_Thue', 'pT_TT', 'pT_Thue_Nt', 'pT_TT_Nt'
        ]);
        $this->mount();
    }

    public function updateKhachHang(): void
    {
        $this->pKh = ArDmKh::where('ma_kh', $this->pMa_Kh)->first();
        if ($this->pKh) {
            $this->pDien_Giai = 'Thu tiền khách hàng ' . $this->pKh->ten_kh;
            $this->pDia_Chi = $this->pKh->dia_chi ?? '';
            
            // Auto-fill mã khách hàng vào các dòng chi tiết
            $this->pCts = $this->pCts->map(function ($row) {
                $row['ma_kh'] = $this->pMa_Kh;
                return $row;
            });
            
            // Update So Du if needed
            // $this->pSoDu = ...
        }
        \Debugbar::info('updateKhachHang');
    }

    public function updateCt(): void
    {
        // This seems unused or redundant if we use valid Livewire binding
    }

    public function addRow(): void
    {
        $this->pCts->push([
            'ma_tk'      => '',
            'dien_giai'  => $this->pDien_Giai,
            'ps_no'      => 0,
            'ps_co'      => 0,
            'ps_no_nt'   => 0,
            'ps_co_nt'   => 0,
            'ma_kh'      => $this->pMa_Kh ?? '',
            'ma_hd'      => '',
            'ma_bp'      => '',
            'ma_phi'     => '',
            'ma_spct'    => '',
            'ma_lo'      => '',
            'ma_ku'      => '',
        ]);
    }

    public function removeRow($index): void
    {
        $this->pCts->forget($index);
        $this->pCts = $this->pCts->values(); // Re-index
        
        if ($this->pCts->isEmpty()) {
            $this->addRow();
        }
        
        $this->calculateTotal();
    }

    public function render()
    {
        \Debugbar::info('render');

        // diepxuan/laravel-catalog/resources/views/cash/nganhang/baono/phieubaono.blade.php
        return view('catalog::cash.nganhang.baono.phieubaono', [
            'arDmKhs' => ArDmKh::all(),
        ]);
    }
}
