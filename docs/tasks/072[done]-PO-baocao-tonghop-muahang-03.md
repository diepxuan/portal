# Task 072: PORptTH03

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop chi phi mua hang tu .NET sang PHP Laravel, dat ket qua tuong duong bao cao tong hop chi phi mua hang.

## Chi tiet
- **DLL:** PORptTH03.dll
- **Chuc nang:** Bao cao tong hop chi phi mua hang
- **Loai:** Report (RPT)
- **Assembly Title:** Tong hop chi phi mua hang
- **Version:** 14.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Cong ty phan mem Asia
- **Ma_ct:** PORptTH03

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptTH03.dll/README.md`

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
| DMPHI | Danh muc phi | FK ma_phi |
| DMLO | Danh muc lo | FK ma_lo |
| DMVITRI | Danh muc vi tri | FK ma_vtri |

### Table Navigation

| Bang | Mo ta |
|------|-------|
| POMH | Lay du lieu chung tu |
| POMHCT | Lay chi tiet vat tu/phi |

---

## Form classes

### frmPORptTH03 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Tong hop chi phi mua hang

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtCT1 | AsTextBox | - | So CT tu |
| txtCT2 | AsTextBox | - | So CT den |
| txtMa_ncc | AsTextBox | MA_NCC (isncc=1) | Ma NCC |
| txtMa_nh_ncc | AsTextBox | MA_NHKH | Nhom NCC |
| txtPl_ncc1 | AsTextBox | MA_PLKH (loai=1) | PL NCC 1 |
| txtPl_ncc2 | AsTextBox | MA_PLKH (loai=2) | PL NCC 2 |
| txtPl_ncc3 | AsTextBox | MA_PLKH (loai=3) | PL NCC 3 |
| txtMa_vt | AsTextBox | MA_VT | Ma VT |
| txtMa_nh_vt | AsTextBox | MA_NHVT | Nhom VT |
| txtMa_Plvt1 | AsTextBox | MA_PLVT (loai=1) | PL VT 1 |
| txtMa_Plvt2 | AsTextBox | MA_PLVT (loai=2) | PL VT 2 |
| txtMa_plvt3 | AsTextBox | MA_PLVT (loai=3) | PL VT 3 |
| txtMa_hd | AsTextBox | MA_HD | Hop dong |
| txtMa_nhhd | AsTextBox | MA_NHHD | Nhom HD |
| txtMA_HTTT | AsTextBox | MA_HTTT (moduleid=po) | Hinh thuc TT |
| txtMA_DKTT | AsTextBox | MA_TT | Dieu khoan TT |
| txtMa_kho | AsTextBox | MA_KHO | Kho |
| txtMa_vtri | AsTextBox | MA_VITRI | Vi tri |
| txtMaLo | AsTextBox | MA_LO | Lo |
| txtMaPhi | AsTextBox | MA_PHI | Phi |
| txtMa_spct | AsTextBox | MA_SPCT | SPCT |
| txtMa_Nt | AsTextBox | MA_NT | Ma ngoai te |
| optVND | RadioButton | - | Tien VND |
| optNt | RadioButton | - | Tien ngoai te |
| cmdExcel | Button | - | Xuat Excel |
| cmdPrint | Button | - | In bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_RPTTH03_GET | Lay du lieu bao cao |
| SP_PO_RPTTH03_FIND | Tim kiem bao cao |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTTH03_GET
    @pMa_cty VARCHAR(50) = '001',
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pMa_nh_ncc VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nh_vt VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_phi VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND'
```

### SP_FIND (reference)

```sql
EXEC SP_PO_RPTTH03_FIND
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(200) = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| So_ct1 <= So_ct2 | so_ct1, so_ct2 | 'So chung tu tu phai nho hon den' |
| Tu_ngay <= Den_ngay | tu_ngay, den_ngay | 'Tu ngay phai nho hon den ngay' |

### Business Rules

1. **Tong hop chi phi**:
   - Tong hop theo nhieu chieu: NCC, VT, kho, HD, phi...
   - Tinh tong chi phi theo cac mat hang

2. **Drill-down (F5)**:
   - Click vao dong -> Hien thi chi tiet
   - Truyen tham so: ma_vt, ma_ncc, tu_ngay, den_ngay

3. **Tien te**:
   - VND: Hien thi tien VND
   - NT: Hien thi ngoai te

4. **Loc nhieu chieu**:
   - Theo NCC, VT, kho, HD, phi...

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
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptTH03.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptTH03 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTTH03_GET';
    protected $params = [
        'pMa_cty',
        'pTu_ngay',
        'pDen_ngay',
        'pSo_ct1',
        'pSo_ct2',
        'pMa_ncc',
        'pMa_nh_ncc',
        'pMa_vt',
        'pMa_nh_vt',
        'pMa_hd',
        'pMa_kho',
        'pMa_phi',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/TonghopChiphi.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class TonghopChiphi extends Component
{
    public ?string $pTu_ngay = null;
    public ?string $pDen_ngay = null;
    public ?string $pSo_ct1 = null;
    public ?string $pSo_ct2 = null;
    public ?string $pMa_ncc = null;
    public ?string $pMa_nh_ncc = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_nh_vt = null;
    public ?string $pMa_hd = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_dktt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_vtri = null;
    public ?string $pMa_lo = null;
    public ?string $pMa_phi = null;
    public ?string $pMa_spct = null;
    public ?string $pMa_bp = null;
    public ?string $pMa_nt = 'VND';
    public bool $pOpt_vnd = true;

    public Collection $pData;
    public array $pColumns = [];

    protected $rules = [
        'pTu_ngay' => 'nullable|date',
        'pDen_ngay' => 'nullable|date|after_or_equal:pTu_ngay',
    ];

    public function mount(): void
    {
        $this->pData = collect([]);
        $this->pColumns = ['stt_rec', 'so_ct', 'ngay_ct', 'ma_ncc', 'ten_ncc', 'tien'];
    }

    public function loadData(): void
    {
        $result = AsPOGetRptTH03::run([
            'pMa_cty' => '001',
            'pTu_ngay' => $this->pTu_ngay,
            'pDen_ngay' => $this->pDen_ngay,
            'pSo_ct1' => $this->pSo_ct1,
            'pSo_ct2' => $this->pSo_ct2,
            'pMa_ncc' => $this->pMa_ncc,
            'pMa_nh_ncc' => $this->pMa_nh_ncc,
            'pMa_vt' => $this->pMa_vt,
            'pMa_nh_vt' => $this->pMa_nh_vt,
            'pMa_hd' => $this->pMa_hd,
            'pMa_kho' => $this->pMa_kho,
            'pMa_phi' => $this->pMa_phi,
            'pMa_nt' => $this->pMa_nt,
        ]);
        $this->pData = collect($result);
    }

    public function drilldown(string $sttRec): RedirectResponse
    {
        return redirect()->route('catalog.po.report.tonghopf5', [
            'stt_rec' => $sttRec,
            'tu_ngay' => $this->pTu_ngay,
            'den_ngay' => $this->pDen_ngay,
        ]);
    }

    public function render(): View
    {
        return view('catalog::po.report.tonghopchiphi');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── tonghopchiphi.blade.php
└── _tonghopchiphi-row.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/tong-hop-chi-phi', [TonghopChiphi::class, 'render'])
            ->name('tonghopchiphi');
        Route::get('/tong-hop-chi-phi/export', [TonghopChiphi::class, 'exportExcel'])
            ->name('tonghopchiphi.export');
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
| Model | laravel-simba | DMPHI.php | Phi |
| Model | laravel-simba | DMLO.php | Lo |
| Model | laravel-simba | DMVITRI.php | Vi tri |
| SP | laravel-simba | AsPOGetRptTH03.php | Get report data |
| Component | laravel-catalog | TonghopChiphi.php | Form bao cao |
| Component | laravel-catalog | TonghopF5.php | Drill-down form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Find)
- [ ] Tao Model POMH, POMHCT
- [ ] Tao Livewire TonghopChiphi
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test xem bao cao
- [ ] Test drill-down (F5)
- [ ] Test xuat Excel
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
