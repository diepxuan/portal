# Task 011: ARRptBCCN05

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang in giay doi chieu cong no gui khach hang xac nhan tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBCCN05.

## Chi tiet
- **DLL:** ARRptBCCN05.dll
- **Chuc nang:** In giay doi chieu cong no gui khach hang xac nhan - theo doi cong no giua so sach cong ty va xac nhan cua khach hang
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBCCN05.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| DMTK | Danh muc tai khoan | FK ma_tk |
| AR4PH | Chung tu header | Phat sinh theo KH |
| AR4CT | Chung tu chi tiet | Chi tiet ps_no/ps_co |
| DMCTY | Thong tin cong ty | Ten cong ty, dia chi |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ten_kh, dia_chi, dien_thoai |
| DMCTY | Cong ty | Lookup ten_cty, dia_chi, dien_thoai |

---

## Form classes

### 1. frmARRptBCCN05 (Giay doi chieu cong no)
- **Ke thua:** frmReport
- **Chuc nang:** Nhap thong tin, loc du lieu, in giay doi chieu
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Tk | AsTextBox | Ma tai khoan (AutoLookup) |
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup, bat buoc) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| txtNgay_lp | AsMaskedTextBox | Ngay lap doi chieu |
| lblTen_Cty | Label | Ten cong ty |
| lblDia_chi | Label | Dia chi cong ty |
| lblTen_Kh | Label | Ten khach hang |
| lblDia_chi_Kh | Label | Dia chi khach hang |
| btnIn | Button | Nut in giay doi chieu |
| btnXuat | Button | Nut xuat Excel |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BC05_GET | Lay du lieu doi chieu |
| SP_AR_BC05_GETHEADER | Lay thong tin header (cty + kh) |
| SP_AR_BC05_REPORT | Lay du lieu in bao cao |
| SP_AR_BC05_EXPORT | Xuat Excel |

### SP_GET (reference)

```sql
-- Lay du lieu doi chieu cong no
EXEC SP_AR_BC05_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_tk VARCHAR(50) = NULL,
    @pMa_kh VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pNgay_lp DATETIME,
    @pMa_nt VARCHAR(10) = 'VND'
```

### SP_REPORT (reference)

```sql
-- Lay du lieu in giay doi chieu
EXEC SP_AR_BC05_REPORT
    @pMa_cty VARCHAR(50),
    @pMa_kh VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pNgay_lp DATETIME
```

---

## Business Logic

### Cau truc giay doi chieu

1. **Phan header**:
   | Thong tin | Nguon |
   |-----------|-------|
   | Ten cong ty | DMCTY.ten_cty |
   | Dia chi | DMCTY.dia_chi |
   | Dien thoai | DMCTY.dien_thoai |
   | Ten khach hang | DMKH.ten_kh |
   | Dia chi khach hang | DMKH.dia_chi |
   | Ngay lap | @pNgay_lp |

2. **Phan chi tiet**:
   | Cot | Mo ta |
   |-----|-------|
   | ngay_ct | Ngay chung tu |
   | so_ct | So chung tu |
   | dien_giai | Diễn giải |
   | ps_no | Phat sinh no |
   | ps_co | Phat sinh co |
   | du_cuoi | So du cuoi |

3. **Phan xac nhan**:
   - Ngay xac nhan
   - Chu ky xac nhan cua khach hang
   - Y kien khach hang (neu co)

### Tinh toan so du

```
So du dau ky = Sum(ps_no - ps_co) truoc ngay1
So du cuoi ky = So du dau ky + Sum(ps_no) + Sum(ps_co)
```

### Validate

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Vui long chon khach hang' |
| Valid date | ngay1, ngay2 | 'Ngay khong hop le' |
| Valid date | ngay_lp | 'Ngay lap phai nam trong khoang doi chieu' |

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBCCN05.php
namespace Diepxuan\Simba\Models\AR;

class RptBCCN05 extends Model
{
    protected $table = 'VW_AR_BC05'; // View doi chieu
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $casts = [
        'du_dk' => 'decimal:2',
        'ps_no' => 'decimal:2',
        'ps_co' => 'decimal:2',
        'du_ck' => 'decimal:2',
        'ngay_ct' => 'date',
        'ngay_lp' => 'date',
    ];

    // Relationships
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'ma_tk', 'ma_tk');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN05.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBCCN05 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC05_GET';
    protected $params = [
        'pMa_cty',
        'pMa_tk',
        'pMa_kh',
        'pNgay1',
        'pNgay2',
        'pNgay_lp',
        'pMa_nt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN05Report.php
class AsARGetBCCN05Report extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC05_REPORT';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pNgay1',
        'pNgay2',
        'pNgay_lp',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN05Header.php
class AsARGetBCCN05Header extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC05_GETHEADER';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/DoiChieuCongNo.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class DoiChieuCongNo extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BCCN05';

    public ?string $pMaTk = null;
    public ?string $pMaKh = null;
    public ?string $pTenKh = null;
    public ?string $pDiaChiKh = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public ?Carbon $pNgayLp = null;
    public string $pMaNt = 'VND';
    public ?string $pTenCty = null;
    public ?string $pDiaChiCty = null;
    public ?string $pDienThoaiCty = null;
    public Collection $pData;
    public array $pSummary = [];

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
        $this->pNgayLp = now();
        $this->loadCompanyInfo();
    }

    public function updatedPMaKh($value): void
    {
        if ($value) {
            $kh = DMKH::find($value);
            $this->pTenKh = $kh?->ten_kh;
            $this->pDiaChiKh = $kh?->dia_chi;
        }
    }

    public function loadCompanyInfo(): void
    {
        $cty = DMCTY::first();
        $this->pTenCty = $cty?->ten_cty;
        $this->pDiaChiCty = $cty?->dia_chi;
        $this->pDienThoaiCty = $cty?->dien_thoai;
    }

    public function loadReport(): void
    {
        $this->validate([
            'pMaKh' => 'required|string',
            'pNgay1' => 'required|date',
            'pNgay2' => 'required|date|after_or_equal:pNgay1',
            'pNgayLp' => 'required|date',
        ]);

        $sp = new AsARGetBCCN05();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pMa_tk' => $this->pMaTk,
            'pMa_kh' => $this->pMaKh,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pNgay_lp' => $this->pNgayLp,
            'pMa_nt' => $this->pMaNt,
        ]);
        $this->calculateSummary();
    }

    public function calculateSummary(): void
    {
        $this->pSummary = [
            'du_dk' => $this->pData->first()?->du_dk ?? 0,
            'tong_ps_no' => $this->pData->sum('ps_no'),
            'tong_ps_co' => $this->pData->sum('ps_co'),
            'du_ck' => $this->pData->last()?->du_ck ?? 0,
        ];
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.doi-chieu-cong-no');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── doi-chieu-cong-no.blade.php        (Form nhap thong tin)
├── doi-chieu-cong-no-print.blade.php  (Mau in giay doi chieu)
├── _doi-chieu-cong-no-header.blade.php (Header: cty + kh)
├── _doi-chieu-cong-no-detail.blade.php (Chi tiet phat sinh)
└── _doi-chieu-cong-no-footer.blade.php (Footer: xac nhan)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/doi-chieu-cong-no', [DoiChieuCongNo::class, 'render'])
            ->name('doi-chieu-cong-no');
        Route::get('/doi-chieu-cong-no/print', [DoiChieuCongNo::class, 'printReport'])
            ->name('doi-chieu-cong-no.print');
        Route::get('/doi-chieu-cong-no/export', [DoiChieuCongNo::class, 'exportExcel'])
            ->name('doi-chieu-cong-no.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBCCN05.php | View doi chieu |
| Model | laravel-simba | DMKH.php | Thong tin KH |
| Model | laravel-simba | DMCTY.php | Thong tin cty |
| SP | laravel-simba | AsARGetBCCN05.php | Lay du lieu |
| SP | laravel-simba | AsARGetBCCN05Report.php | Lay in bao cao |
| SP | laravel-simba | AsARGetBCCN05Header.php | Lay header |
| Component | laravel-catalog | DoiChieuCongNo.php | Form nhap lieu |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBCCN05 (View)
- [ ] Tao Livewire DoiChieuCongNo
- [ ] Tao Views (form + print template)
- [ ] Them Routes
- [ ] Implement layout giay doi chieu
- [ ] Test in giay doi chieu