# Task 073: PORptBK02

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu mua hang nhom theo chi tieu tu .NET sang PHP Laravel, dat ket qua tuong duong bang ke mua hang voi 10 tieu chi nhom.

## Chi tiet
- **DLL:** PORptBK02.dll
- **Chuc nang:** Bang ke mua hang nhom theo chi tieu
- **Loai:** Report (RPT)
- **Assembly Title:** Bang ke mua hang nhom theo chi tieu
- **Version:** 14.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Cong ty phan mem Asia
- **Ma_ct:** PORptBK02

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptBK02.dll/README.md`

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
| DMBP | Danh muc bo phan | FK ma_bp |
| DMPHI | Danh muc phi | FK ma_phi |

### Table Navigation

| Bang | Mo ta |
|------|-------|
| POMH | Lay danh sach chung tu |
| POMHCT | Lay chi tiet chung tu |

---

## Form classes

### frmPORptBK02 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke voi nhieu tieu chi nhom

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtSo_CT1 | TextBox | - | So CT tu |
| txtSo_CT2 | TextBox | - | So CT den |
| cboLoaiPhieu | ComboBox | asSIGetDmSo_ct | Loai phieu |
| cboTrang_thai | ComboBox | - | Trang thai |
| cboNhom_theo | ComboBox | - | Nhom theo |
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
| txtMA_DKTT | AsTextBox | MA_TT_PO | Dieu khoan TT |
| txtMa_kho | AsTextBox | MA_KHO | Kho |
| txtMa_vtri | AsTextBox | MA_VITRI | Vi tri |
| txtMaLo | AsTextBox | MA_LO | Lo |
| txtMaPhi | AsTextBox | MA_PHI | Phi |
| txtMa_spct | AsTextBox | MA_SPCT | SPCT |
| txtMa_bp | AsTextBox | MA_BP | Bo phan |
| txtMa_Nt | AsTextBox | MA_NT | Ma ngoai te |
| optVND | RadioButton | - | Tien VND |
| optNt | RadioButton | - | Tien ngoai te |
| cboMau_bc | ComboBox | - | Mau bao cao |
| cmdExcel | Button | - | Xuat Excel |
| cmdPrint | Button | - | In bao cao |

### Nhom theo (10 chi tieu)

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
| SP_PO_RPTBK02_GET | Lay du lieu bang ke |
| SP_PO_RPTBK02_FIND | Tim kiem bang ke |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTBK02_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNhom_theo VARCHAR(50) = 'MA_KH',
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pLoai_phieu VARCHAR(100) = NULL,
    @pTrang_thai VARCHAR(50) = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pMa_nh_ncc VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nh_vt VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND'
```

### SP_FIND (reference)

```sql
EXEC SP_PO_RPTBK02_FIND
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(200) = NULL,
    @pNhom_theo VARCHAR(50) = 'MA_KH'
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid nhom_theo | nhom_theo | 'Nhom theo khong hop le' |
| So_ct1 <= So_ct2 | so_ct1, so_ct2 | 'So chung tu tu phai nho hon den' |

### Business Rules

1. **Nhieu tieu chi nhom (10 tieu chi)**:
   - MA_KH: Nha cung cap
   - MA_BP: Bo phan
   - MA_HD: Hop dong
   - MA_HTTT: Hinh thuc TT
   - MA_VT: Vat tu
   - MA_KHO: Kho
   - MA_LO: Lo
   - MA_PHI: Phi
   - STT_REC: Chung tu
   - MA_SPCT: San pham CT

2. **Drill-down (F5)**:
   - Click vao nhom -> Hien thi chi tiet
   - Truyen tham so: nhom_theo, ma_nhom

3. **Tien te**:
   - VND hoac ngoai te

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
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptBK02.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptBK02 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTBK02_GET';
    protected $params = [
        'pMa_cty',
        'pNhom_theo',
        'pTu_ngay',
        'pDen_ngay',
        'pLoai_phieu',
        'pTrang_thai',
        'pSo_ct1',
        'pSo_ct2',
        'pMa_ncc',
        'pMa_nh_ncc',
        'pMa_vt',
        'pMa_nh_vt',
        'pMa_hd',
        'pMa_kho',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/BangkeMua02.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class BangkeMua02 extends Component
{
    public string $pNhom_theo = 'MA_KH';
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
    public ?string $pMa_hd = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_dktt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_vtri = null;
    public ?string $pMa_lo = null;
    public ?string $pMa_phi = null;
    public ?string $pMa_spct = null;
    public ?string $pMa_bp = null;
    public ?string $pMau_bc = null;
    public ?string $pMa_nt = 'VND';
    public bool $pOpt_vnd = true;

    public Collection $pData;
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
        'pNhom_theo' => 'required|in:MA_KH,MA_BP,MA_HD,MA_HTTT,MA_VT,MA_KHO,MA_LO,MA_PHI,STT_REC,MA_SPCT',
        'pTu_ngay' => 'nullable|date',
        'pDen_ngay' => 'nullable|date|after_or_equal:pTu_ngay',
    ];

    public function mount(): void
    {
        $this->pData = collect([]);
    }

    public function loadData(): void
    {
        $result = AsPOGetRptBK02::run([
            'pMa_cty' => '001',
            'pNhom_theo' => $this->pNhom_theo,
            'pTu_ngay' => $this->pTu_ngay,
            'pDen_ngay' => $this->pDen_ngay,
            'pLoai_phieu' => $this->pLoai_phieu,
            'pTrang_thai' => $this->pTrang_thai,
            'pSo_ct1' => $this->pSo_ct1,
            'pSo_ct2' => $this->pSo_ct2,
            'pMa_ncc' => $this->pMa_ncc,
            'pMa_nh_ncc' => $this->pMa_nh_ncc,
            'pMa_vt' => $this->pMa_vt,
            'pMa_nh_vt' => $this->pMa_nh_vt,
            'pMa_hd' => $this->pMa_hd,
            'pMa_kho' => $this->pMa_kho,
            'pMa_nt' => $this->pMa_nt,
        ]);
        $this->pData = collect($result);
    }

    public function drilldown(string $groupValue): RedirectResponse
    {
        return redirect()->route('catalog.po.report.tonghopf5', [
            'nhom_theo' => $this->pNhom_theo,
            'ma_nhom' => $groupValue,
        ]);
    }

    public function render(): View
    {
        return view('catalog::po.report.bangke02');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── bangke02.blade.php
└── _bangke02-group.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/bang-ke-mua-02', [BangkeMua02::class, 'render'])
            ->name('bangke02');
        Route::get('/bang-ke-mua-02/export', [BangkeMua02::class, 'exportExcel'])
            ->name('bangke02.export');
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
| Model | laravel-simba | DMBP.php | Bo phan |
| Model | laravel-simba | DMPHI.php | Phi |
| SP | laravel-simba | AsPOGetRptBK02.php | Get report data |
| Component | laravel-catalog | BangkeMua02.php | Form bao cao |
| Component | laravel-catalog | TonghopF5.php | Drill-down form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Find)
- [ ] Tao Model POMH, POMHCT
- [ ] Tao Livewire BangkeMua02
- [ ] Tao Views (Group by layout)
- [ ] Them Routes
- [ ] Test xem bang ke
- [ ] Test drill-down (F5)
- [ ] Test xuat Excel