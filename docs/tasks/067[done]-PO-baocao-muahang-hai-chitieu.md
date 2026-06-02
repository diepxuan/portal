# Task 067: PORptBCPT03

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich mua hang theo 2 chieu (nhom theo + chi tiet theo) tu .NET sang PHP Laravel, dat ket qua tuong duong bao cao phan tich mua hang hai chi tieu.

## Chi tiet
- **DLL:** PORptBCPT03.dll
- **Chuc nang:** Bao cao phan tich mua hang theo 2 chi tieu
- **Loai:** Report (RPT)
- **Assembly Title:** Bao cao mua hang theo hai chi tieu
- **Version:** 14.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Cong ty phan mem Asia
- **Ma_ct:** PORptBCPT03

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptBCPT03.dll/README.md`

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

### Table Navigation

| Bang | Mo ta |
|------|-------|
| POMH | Lay du lieu chung tu mua |
| POMHCT | Lay chi tiet hang mua |

---

## Form classes

### frmPORptBCPT03 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Phan tich mua hang theo 2 chieu (Matrix report)

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| cboNhom_Theo | ComboBox | - | Nhom theo (row) |
| cboChi_Tiet_Theo | ComboBox | - | Chi tiet theo (column) |
| txtMa_kh | AsTextBox | MA_KH (isncc=1) | Ma NCC |
| txtMa_Nhkh | AsTextBox | MA_NHKH | Ma nhom NCC |
| txtMa_Plkh1 | AsTextBox | MA_PLKH (loai=1) | PL NCC 1 |
| txtMa_Plkh2 | AsTextBox | MA_PLKH (loai=2) | PL NCC 2 |
| txtMa_Plkh3 | AsTextBox | MA_PLKH (loai=3) | PL NCC 3 |
| txtMa_vt | AsTextBox | MA_VT | Ma VT |
| txtMa_nhvt | AsTextBox | MA_NHVT | Nhom VT |
| txtMa_Plvt1 | AsTextBox | MA_PLVT (loai=1) | PL VT 1 |
| txtMa_Plvt2 | AsTextBox | MA_PLVT (loai=2) | PL VT 2 |
| txtMa_plvt3 | AsTextBox | MA_PLVT (loai=3) | PL VT 3 |
| txtMa_hd | AsTextBox | MA_HD | Hop dong |
| txtMa_nhhd | AsTextBox | MA_NHHD | Nhom HD |
| txtMa_HTTT | AsTextBox | MA_HTTT (moduleid=po) | Hinh thuc TT |
| txtMa_DKTT | AsTextBox | MA_TT_PO | Dieu khoan TT |
| txtMa_kho | AsTextBox | MA_KHO | Kho |
| txtMa_vitri | AsTextBox | MA_VITRI | Vi tri |
| txtMa_lo | AsTextBox | MA_LO | Lo |
| txtMa_phi | AsTextBox | MA_PHI | Phi |
| txtMa_spct | AsTextBox | MA_SPCT | SPCT |
| txtMa_Nt | AsTextBox | MA_NT | Ma ngoai te |
| ChkTra_lai | CheckBox | - | Bao gom tra lai |
| optVND | RadioButton | - | Tien VND |
| optNt | RadioButton | - | Tien ngoai te |
| cmdExcel | Button | - | Xuat Excel |
| cmdPrint | Button | - | In bao cao |

### Nhom theo / Chi tiet theo

| Gia tri | Mo ta |
|---------|-------|
| MA_KH | Nha cung cap |
| MA_BP | Bo phan |
| MA_HD | Hop dong |
| MA_HTTT | Hinh thuc thanh toan |
| MA_VT | Vat tu |
| MA_KHO | Kho |
| MA_LO | Lo |
| MA_PHI | Phi |
| STT_REC | Chung tu |
| MA_SPCT | San pham CT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_RPTBCPT03_GET | Lay du lieu bao cao |
| SP_PO_RPTBCPT03_FIND | Tim kiem |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTBCPT03_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNhom_theo VARCHAR(50) = 'MA_KH',
    @pChi_tiet_theo VARCHAR(50) = 'MA_VT',
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pMa_nh_ncc VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nh_vt VARCHAR(50) = NULL,
    @pTra_lai BIT = 0,
    @pMa_nt VARCHAR(10) = 'VND'
```

### SP_FIND (reference)

```sql
EXEC SP_PO_RPTBCPT03_FIND
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(200) = NULL,
    @pNhom_theo VARCHAR(50) = 'MA_KH',
    @pChi_tiet_theo VARCHAR(50) = 'MA_VT'
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid nhom_theo | nhom_theo | 'Nhom theo khong hop le' |
| Valid chi_tiet_theo | chi_tiet_theo | 'Chi tiet theo khong hop le' |
| Tu_ngay <= Den_ngay | tu_ngay, den_ngay | 'Tu ngay phai nho hon den ngay' |

### Business Rules

1. **Hai chieu phan tich (Matrix)**:
   - Row: Nhom theo
   - Column: Chi tiet theo
   - Value: Tong tien
   - Pivot table format

2. **Drill-down (F5)**:
   - Click vao o -> Hien thi chi tiet
   - Truyen tham so: nhom_theo, chi_tiet_theo, ma_row, ma_col

3. **Hang tra lai**:
   - Co the bao gom/exclude hang tra lai NCC
   - Co phieu xuat tra lai (loai_phieu = 'XTRNCC')

4. **Tien te**:
   - VND: Hien thi tien VND
   - NT: Hien thi ngoai te

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
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptBCPT03.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptBCPT03 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTBCPT03_GET';
    protected $params = [
        'pMa_cty',
        'pNhom_theo',
        'pChi_tiet_theo',
        'pTu_ngay',
        'pDen_ngay',
        'pMa_ncc',
        'pMa_nh_ncc',
        'pMa_vt',
        'pMa_nh_vt',
        'pTra_lai',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/MuaHangHaiChiTieu.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class MuaHangHaiChiTieu extends Component
{
    public string $pNhom_theo = 'MA_KH';
    public string $pChi_tiet_theo = 'MA_VT';
    public ?string $pTu_ngay = null;
    public ?string $pDen_ngay = null;
    public ?string $pMa_ncc = null;
    public ?string $pMa_nh_ncc = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_nh_vt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_hd = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_dktt = null;
    public ?string $pMa_phi = null;
    public ?string $pMa_spct = null;
    public ?string $pMa_lo = null;
    public ?string $pMa_vtri = null;
    public bool $pChk_tra_lai = false;
    public string $pMa_nt = 'VND';
    public bool $pOpt_vnd = true;

    public Collection $pData;
    public array $pRows = [];
    public array $pCols = [];
    public array $pMatrix = [];

    public array $pGroupOptions = [
        'MA_KH' => 'Nha cung cap',
        'MA_BP' => 'Bo phan',
        'MA_HD' => 'Hop dong',
        'MA_HTTT' => 'Hinh thuc TT',
        'MA_VT' => 'Vat tu',
        'MA_KHO' => 'Kho',
        'MA_LO' => 'Lo',
        'MA_PHI' => 'Phi',
        'STT_REC' => 'Chung tu',
        'MA_SPCT' => 'San pham CT',
    ];

    protected $rules = [
        'pTu_ngay' => 'nullable|date',
        'pDen_ngay' => 'nullable|date|after_or_equal:pTu_ngay',
    ];

    public function mount(): void
    {
        $this->pData = collect([]);
        $this->pRows = [];
        $this->pCols = [];
        $this->pMatrix = [];
    }

    public function loadData(): void
    {
        $result = AsPOGetRptBCPT03::run([
            'pMa_cty' => '001',
            'pNhom_theo' => $this->pNhom_theo,
            'pChi_tiet_theo' => $this->pChi_tiet_theo,
            'pTu_ngay' => $this->pTu_ngay,
            'pDen_ngay' => $this->pDen_ngay,
            'pMa_ncc' => $this->pMa_ncc,
            'pMa_nh_ncc' => $this->pMa_nh_ncc,
            'pMa_vt' => $this->pMa_vt,
            'pMa_nh_vt' => $this->pMa_nh_vt,
            'pTra_lai' => $this->pChk_tra_lai ? 1 : 0,
            'pMa_nt' => $this->pMa_nt,
        ]);

        $this->pData = collect($result);
        $this->buildMatrix();
    }

    public function buildMatrix(): void
    {
        // Build row/column/value matrix
        $this->pRows = $this->pData->pluck($this->pNhom_theo)->unique()->values()->toArray();
        $this->pCols = $this->pData->pluck($this->pChi_tiet_theo)->unique()->values()->toArray();
        // Matrix building logic...
    }

    public function drilldown(string $rowValue, string $colValue): RedirectResponse
    {
        return redirect()->route('catalog.po.report.tonghopf5', [
            'nhom_theo' => $this->pNhom_theo,
            'chi_tiet_theo' => $this->pChi_tiet_theo,
            'ma_row' => $rowValue,
            'ma_col' => $colValue,
        ]);
    }

    public function render(): View
    {
        return view('catalog::po.report.muahanghai Chitieu');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── muahanghai Chitieu.blade.php      (Matrix grid)
└── _muahanghai Chitieu-matrix.blade.php (Row/Col)
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/mua-hang-hai-chi-tieu', [MuaHangHaiChiTieu::class, 'render'])
            ->name('muahanghai Chitieu');
        Route::get('/mua-hang-hai-chi-tieu/export', [MuaHangHaiChiTieu::class, 'exportExcel'])
            ->name('muahanghai Chitieu.export');
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
| SP | laravel-simba | AsPOGetRptBCPT03.php | Get report data |
| Component | laravel-catalog | MuaHangHaiChiTieu.php | Form bao cao matrix |
| Component | laravel-catalog | TonghopF5.php | Drill-down form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Find)
- [ ] Tao Model POMH, POMHCT, DMNCC, DMVAT TU
- [ ] Tao Livewire MuaHangHaiChiTieu (Matrix report)
- [ ] Tao Views (Matrix layout)
- [ ] Them Routes
- [ ] Test xem bao cao matrix
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
