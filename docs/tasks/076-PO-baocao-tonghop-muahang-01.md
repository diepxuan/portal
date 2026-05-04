# Task 076: PORptTH01

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop mua hang 01 tu .NET sang PHP Laravel, dat ket qua tuong duong bao cao tong hop mua hang theo nhieu tieu chi.

## Chi tiet
- **DLL:** PORptTH01.dll
- **Chuc nang:** Bao cao tong hop mua hang 01
- **Loai:** Report (RPT)
- **Assembly Title:** Bao cao tong hop mua hang 01
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PORptTH01

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptTH01.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| POMH | Phieu mua hang | Header chung tu |
| POMHCT | Chi tiet phieu mua | Detail chung tu |
| DMNCC | Danh muc nha cung cap | FK ma_ncc |
| DMVAT TU | Danh muc vat tu | FK ma_vt |
| DMKHO | Danh muc kho | FK ma_kho |
| DMHD | Danh muc hop dong | FK ma_hd |
| DMHTTT | Hinh thuc thanh toan | FK ma_httt |

### Table Navigation

| Bang | Mo ta |
|------|-------|
| POMH | Lay danh sach chung tu |
| POMHCT | Lay chi tiet chung tu |

---

## Form classes

### frmPORptTH01 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Tong hop mua hang theo nhieu tieu chi

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| cboLoaiPhieu | ComboBox | asSIGetDmSo_ct | Loai phieu |
| cboTrang_Thai | ComboBox | - | Trang thai |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtMA_DKTT | AsTextBox | MA_TT_PO | Dieu khoan TT |
| txtMA_HTTT | AsTextBox | MA_HTTT | Hinh thuc TT |
| txtMaLo | AsTextBox | MA_LO | Lo |
| txtMa_nhhd | AsTextBox | MA_NHHD | Nhom HD |
| txtMa_vtri | AsTextBox | MA_VITRI | Vi tri |
| txtMa_kho | AsTextBox | MA_KHO | Kho |
| txtMa_nh_vt | AsTextBox | MA_NHVT | Nhom VT |
| txtMa_vt | AsTextBox | MA_VT | Vat tu |
| txtMa_hd | AsTextBox | MA_HD | Hop dong |
| txtMa_nh_ncc | AsTextBox | MA_NHKH | Nhom NCC |
| txtMa_ncc | AsTextBox | MA_NCC (isncc=1) | NCC |
| txtMa_spct | AsTextBox | MA_SPCT | SPCT |
| txtMaPhi | AsTextBox | MA_PHI | Phi |
| txtPl_ncc1 | AsTextBox | MA_PLKH (loai=1) | PL NCC 1 |
| txtPl_ncc2 | AsTextBox | MA_PLKH (loai=2) | PL NCC 2 |
| txtPl_ncc3 | AsTextBox | MA_PLKH (loai=3) | PL NCC 3 |
| txtMa_Plvt1 | AsTextBox | MA_PLVT (loai=1) | PL VT 1 |
| txtMa_Plvt2 | AsTextBox | MA_PLVT (loai=2) | PL VT 2 |
| txtMa_plvt3 | AsTextBox | MA_PLVT (loai=3) | PL VT 3 |
| cmdExcel | Button | - | Xuat Excel |
| cmdPrint | Button | - | In bao cao |

### Loai phieu ho tro

| Gia tri | Mo ta |
|---------|-------|
| PNMH | Phieu nhap mua |
| HDMUA | Hoa don mua hang |
| PYC | Phieu yeu cau mua |
| DHMUA | Don dat mua |
| PCMH | Phieu chi phi mua |
| XTRNCC | Xuat tra lai NCC |
| HDDV | Hoa don mua dich vu |
| HDNHK | Hoa don mua hang nhap khau |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_RPTTH01_GET | Lay du lieu bao cao |
| SP_PO_RPTTH01_FIND | Tim kiem bao cao |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTTH01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pLoai_phieu VARCHAR(100) = NULL,
    @pTrang_thai VARCHAR(50) = NULL,
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pMa_nh_ncc VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nh_vt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_httt VARCHAR(50) = NULL,
    @pMa_dktt VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND'
```

### SP_FIND (reference)

```sql
EXEC SP_PO_RPTTH01_FIND
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(200) = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Tu_ngay <= Den_ngay | tu_ngay, den_ngay | 'Tu ngay phai nho hon den ngay' |

### Business Rules

1. **Tong hop theo nhieu tieu chi**:
   - NCC, VT, kho, HD...
   - Theo ngay, loai phieu, trang thai

2. **Drill-down (F5)**:
   - Click vao dong -> Chi tiet
   - Truyen tham so: stt_rec, ma_vt, ma_ncc

3. **Xuat bao cao**:
   - Crystal Report
   - Excel

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/PO/POMH.php
namespace Diepxuan\Simba\Models\PO;

class POMH extends Model
{
    protected $table = 'POMH';
    protected $primaryKey = 'stt_rec';
    public $incrementing = false;
    protected $connection = 'simba';

    public function chiTiet()
    {
        return $this->hasMany(POMHCT::class, 'stt_rec', 'stt_rec');
    }

    public function nhaCungCap()
    {
        return $this->belongsTo(DMNCC::class, 'ma_ncc', 'ma_ncc');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptTH01.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptTH01 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTTH01_GET';
    protected $params = [
        'pMa_cty',
        'pLoai_phieu',
        'pTrang_thai',
        'pTu_ngay',
        'pDen_ngay',
        'pSo_ct1',
        'pSo_ct2',
        'pMa_ncc',
        'pMa_nh_ncc',
        'pMa_vt',
        'pMa_nh_vt',
        'pMa_kho',
        'pMa_hd',
        'pMa_httt',
        'pMa_dktt',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/TonghopMua01.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class TonghopMua01 extends Component
{
    public ?string $pLoai_phieu = null;
    public ?string $pTrang_thai = null;
    public ?string $pTu_ngay = null;
    public ?string $pDen_ngay = null;
    public ?string $pSo_ct1 = null;
    public ?string $pSo_ct2 = null;
    public ?string $pMa_ncc = null;
    public ?string $pMa_nh_ncc = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_nh_vt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_hd = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_dktt = null;
    public ?string $pMa_lo = null;
    public ?string $pMa_vtri = null;
    public ?string $pMa_nhhd = null;
    public ?string $pMa_phi = null;
    public ?string $pMa_spct = null;
    public ?string $pMau_bc = null;
    public ?string $pMa_nt = 'VND';

    public Collection $pData;
    public array $pColumns = [];

    protected $rules = [
        'pTu_ngay' => 'nullable|date',
        'pDen_ngay' => 'nullable|date|after_or_equal:pTu_ngay',
    ];

    public function mount(): void
    {
        $this->pData = collect([]);
        $this->pColumns = ['stt_rec', 'so_ct', 'ngay_ct', 'ma_ncc', 'ten_ncc', 't_tien', 't_thue', 't_tt'];
    }

    public function loadData(): void
    {
        $result = AsPOGetRptTH01::run([
            'pMa_cty' => '001',
            'pLoai_phieu' => $this->pLoai_phieu,
            'pTrang_thai' => $this->pTrang_thai,
            'pTu_ngay' => $this->pTu_ngay,
            'pDen_ngay' => $this->pDen_ngay,
            'pSo_ct1' => $this->pSo_ct1,
            'pSo_ct2' => $this->pSo_ct2,
            'pMa_ncc' => $this->pMa_ncc,
            'pMa_nh_ncc' => $this->pMa_nh_ncc,
            'pMa_vt' => $this->pMa_vt,
            'pMa_nh_vt' => $this->pMa_nh_vt,
            'pMa_kho' => $this->pMa_kho,
            'pMa_hd' => $this->pMa_hd,
            'pMa_httt' => $this->pMa_httt,
            'pMa_dktt' => $this->pMa_dktt,
            'pMa_nt' => $this->pMa_nt,
        ]);
        $this->pData = collect($result);
    }

    public function drilldown(string $sttRec): RedirectResponse
    {
        return redirect()->route('catalog.po.report.tonghopf5', [
            'stt_rec' => $sttRec,
        ]);
    }

    public function exportExcel(): void
    {
        // Xuat Excel
    }

    public function render(): View
    {
        return view('catalog::po.report.tonghopmua01');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── tonghopmua01.blade.php
└── _tonghopmua01-row.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/tong-hop-mua-01', [TonghopMua01::class, 'render'])
            ->name('tonghopmua01');
        Route::get('/tong-hop-mua-01/export', [TonghopMua01::class, 'exportExcel'])
            ->name('tonghopmua01.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | POMH.php | Chung tu mua |
| Model | laravel-simba | POMHCT.php | Chi tiet chung tu |
| Model | laravel-simba | DMNCC.php | Nha cung cap |
| Model | laravel-simba | DMVAT TU.php | Vat tu |
| Model | laravel-simba | DMKHO.php | Kho |
| Model | laravel-simba | DMHD.php | Hop dong |
| Model | laravel-simba | DMHTTT.php | Hinh thuc TT |
| SP | laravel-simba | AsPOGetRptTH01.php | Get report data |
| Component | laravel-catalog | TonghopMua01.php | Form bao cao |
| Component | laravel-catalog | TonghopF5.php | Drill-down form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Find)
- [ ] Tao Model POMH, POMHCT
- [ ] Tao Livewire TonghopMua01
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test xem bao cao
- [ ] Test drill-down (F5)
- [ ] Test xuat Excel