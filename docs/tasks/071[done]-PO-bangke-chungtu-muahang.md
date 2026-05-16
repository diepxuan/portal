# Task 071: PORptBK01

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu mua hang tu .NET sang PHP Laravel, dat ket qua tuong duong bang ke chung tu mua voi 2 DataGridView (Master-Detail).

## Chi tiet
- **DLL:** PORptBK01.dll
- **Chuc nang:** Bang ke chung tu mua hang
- **Loai:** Report (RPT)
- **Assembly Title:** Bang ke chung tu mua hang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PORptBK01

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptBK01.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| POMH | Phieu mua hang | Header chung tu mua |
| POMHCT | Chi tiet phieu mua | Detail chung tu mua |
| DMNCC | Danh muc nha cung cap | FK ma_ncc |
| DMVAT TU | Danh muc vat tu | FK ma_vt |
| DMKHO | Danh muc kho | FK ma_kho |
| DMHD | Danh muc hop dong | FK ma_hd |
| DMHTTT | Hinh thuc thanh toan | FK ma_httt |

### Table Navigation

| Bang | Mo ta |
|------|-------|
| POMH | Lay danh sach chung tu mua |
| POMHCT | Lay chi tiet chung tu |

---

## Form classes

### frmPORptBK01 (Form bao cao)
- **Ke thua:** frmReport2DGV
- **Chuc nang:** Bang ke chung tu mua voi 2 DataGridView (Master-Detail)

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| cboLoaiPhieu | ComboBox | asSIGetDmSo_ct | Loai phieu |
| cboTrang_Thai | ComboBox | - | Trang thai |
| txtCT1 | TextBox | - | So CT tu |
| txtCT2 | TextBox | - | So CT den |
| txtNv_kd | TextBox | - | Nhan vien KD |
| chkNh_Ncc | CheckBox | - | Nhom theo NCC |
| txtMa_bp | AsTextBox | MA_BP | Ma BP |
| txtMa_nhhd | AsTextBox | MA_NHHD | Nhom HD |
| txtMa_hd | AsTextBox | MA_HD | Hop dong |
| txtMA_DKTT | AsTextBox | MA_TT_PO | Dieu khoan TT |
| txtMA_HTTT | AsTextBox | MA_HTTT | Hinh thuc TT |
| txtMa_nh_vt | AsTextBox | MA_NHVT | Nhom VT |
| txtMa_vt | AsTextBox | MA_VT | Vat tu |
| txtMaLo | AsTextBox | MA_LO | Lo |
| txtMa_kho | AsTextBox | MA_KHO | Kho |
| txtMa_nh_ncc | AsTextBox | MA_NHKH | Nhom NCC |
| txtMa_ncc | AsTextBox | MA_NCC (isncc=1) | NCC |
| txtMa_vtri | AsTextBox | MA_VITRI | Vi tri |
| txtMaPhi | AsTextBox | MA_PHI | Phi |
| txtMa_spct | AsTextBox | MA_SPCT | SPCT |
| txtPl_ncc1 | AsTextBox | MA_PLKH (loai=1) | PL NCC 1 |
| txtPl_ncc2 | AsTextBox | MA_PLKH (loai=2) | PL NCC 2 |
| txtPl_ncc3 | AsTextBox | MA_PLKH (loai=3) | PL NCC 3 |
| txtMa_Plvt1 | AsTextBox | MA_PLVT (loai=1) | PL VT 1 |
| txtMa_Plvt2 | AsTextBox | MA_PLVT (loai=2) | PL VT 2 |
| txtMa_plvt3 | AsTextBox | MA_PLVT (loai=3) | PL VT 3 |
| cboMau_bc | ComboBox | - | Mau bao cao |
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
| SP_PO_RPTBK01_GET | Lay du lieu bang ke |
| SP_PO_RPTBK01_GETBYID | Lay chi tiet chung tu |
| SP_PO_RPTBK01_FIND | Tim kiem bang ke |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTBK01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pLoai_phieu VARCHAR(100) = NULL,
    @pTrang_thai VARCHAR(50) = NULL,
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pNv_kd VARCHAR(50) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_nhhd VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_dktt VARCHAR(50) = NULL,
    @pMa_httt VARCHAR(50) = NULL,
    @pMa_nh_vt VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_lo VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_nh_ncc VARCHAR(50) = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pMa_vtri VARCHAR(50) = NULL,
    @pMa_phi VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL,
    @pNh_ncc BIT = 0
```

### SP_GETBYID (reference)

```sql
EXEC SP_PO_RPTBK01_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pStt_rec VARCHAR(50)
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| So_ct1 <= So_ct2 | so_ct1, so_ct2 | 'So chung tu tu phai nho hon den' |
| Tu_ngay <= Den_ngay | tu_ngay, den_ngay | 'Tu ngay phai nho hon den ngay' |

### Business Rules

1. **2 DataGridView (Master-Detail)**:
   - Master: Chung tu tong hop (POMH)
   - Detail: Chi tiet chung tu (POMHCT)
   - Click row master -> Hien thi detail

2. **Nhieu tieu chi loc**:
   - Theo NCC, VT, kho, HD, BP...
   - Theo ngay, so CT
   - Theo nhan vien KD

3. **Nhom theo NCC**:
   - Checkbox nhom theo NCC
   - Group header theo ma_ncc

4. **Xuat bao cao**:
   - Crystal Report
   - Excel
   - In trực tiếp

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

    public function scopeFiltered($query, array $filters)
    {
        return $query->when($filters['loai_phieu'], fn($q, $v) => $q->where('loai_phieu', $v))
            ->when($filters['tu_ngay'], fn($q, $v) => $q->where('ngay_ct', '>=', $v))
            ->when($filters['den_ngay'], fn($q, $v) => $q->where('ngay_ct', '<=', $v))
            ->when($filters['ma_ncc'], fn($q, $v) => $q->where('ma_ncc', $v));
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptBK01.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptBK01 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTBK01_GET';
    protected $params = [
        'pMa_cty',
        'pLoai_phieu',
        'pTrang_thai',
        'pTu_ngay',
        'pDen_ngay',
        'pSo_ct1',
        'pSo_ct2',
        'pNv_kd',
        'pMa_bp',
        'pMa_nhhd',
        'pMa_hd',
        'pMa_dktt',
        'pMa_httt',
        'pMa_nh_vt',
        'pMa_vt',
        'pMa_lo',
        'pMa_kho',
        'pMa_nh_ncc',
        'pMa_ncc',
        'pMa_vtri',
        'pMa_phi',
        'pMa_spct',
        'pNh_ncc',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptBK01ById.php
class AsPOGetRptBK01ById extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTBK01_GETBYID';
    protected $params = ['pMa_cty', 'pStt_rec'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/BangkeMua01.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class BangkeMua01 extends Component
{
    public ?string $pLoai_phieu = null;
    public ?string $pTrang_thai = null;
    public ?string $pTu_ngay = null;
    public ?string $pDen_ngay = null;
    public ?string $pSo_ct1 = null;
    public ?string $pSo_ct2 = null;
    public ?string $pNv_kd = null;
    public ?string $pMa_bp = null;
    public ?string $pMa_nhhd = null;
    public ?string $pMa_hd = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_dktt = null;
    public ?string $pMa_nh_vt = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_lo = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_nh_ncc = null;
    public ?string $pMa_ncc = null;
    public ?string $pMa_vtri = null;
    public ?string $pMa_phi = null;
    public ?string $pMa_spct = null;
    public bool $pNh_ncc = false;
    public ?string $pMau_bc = null;

    public Collection $pMasterData;
    public ?array $pDetailData = null;
    public ?string $pSelectedSttRec = null;

    protected $rules = [
        'pTu_ngay' => 'nullable|date',
        'pDen_ngay' => 'nullable|date|after_or_equal:pTu_ngay',
        'pSo_ct1' => 'nullable|string|max:50',
        'pSo_ct2' => 'nullable|string|max:50',
    ];

    public function mount(): void
    {
        $this->pMasterData = collect([]);
        $this->pDetailData = null;
    }

    public function loadData(): void
    {
        $result = AsPOGetRptBK01::run([
            'pMa_cty' => '001',
            'pLoai_phieu' => $this->pLoai_phieu,
            'pTrang_thai' => $this->pTrang_thai,
            'pTu_ngay' => $this->pTu_ngay,
            'pDen_ngay' => $this->pDen_ngay,
            'pSo_ct1' => $this->pSo_ct1,
            'pSo_ct2' => $this->pSo_ct2,
            'pNv_kd' => $this->pNv_kd,
            'pMa_bp' => $this->pMa_bp,
            'pMa_nhhd' => $this->pMa_nhhd,
            'pMa_hd' => $this->pMa_hd,
            'pMa_dktt' => $this->pMa_dktt,
            'pMa_httt' => $this->pMa_httt,
            'pMa_nh_vt' => $this->pMa_nh_vt,
            'pMa_vt' => $this->pMa_vt,
            'pMa_lo' => $this->pMa_lo,
            'pMa_kho' => $this->pMa_kho,
            'pMa_nh_ncc' => $this->pMa_nh_ncc,
            'pMa_ncc' => $this->pMa_ncc,
            'pMa_vtri' => $this->pMa_vtri,
            'pMa_phi' => $this->pMa_phi,
            'pMa_spct' => $this->pMa_spct,
            'pNh_ncc' => $this->pNh_ncc ? 1 : 0,
        ]);
        $this->pMasterData = collect($result);
    }

    public function selectRow(string $sttRec): void
    {
        $this->pSelectedSttRec = $sttRec;
        $this->loadDetail($sttRec);
    }

    public function loadDetail(string $sttRec): void
    {
        $result = AsPOGetRptBK01ById::run([
            'pMa_cty' => '001',
            'pStt_rec' => $sttRec,
        ]);
        $this->pDetailData = $result;
    }

    public function exportExcel(): void
    {
        // Xuat Excel
    }

    public function render(): View
    {
        return view('catalog::po.report.bangke01');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── bangke01.blade.php           (Master-Detail layout)
├── _bangke01-master.blade.php    (Master grid)
└── _bangke01-detail.blade.php   (Detail grid)
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/bang-ke-mua-01', [BangkeMua01::class, 'render'])
            ->name('bangke01');
        Route::get('/bang-ke-mua-01/export', [BangkeMua01::class, 'exportExcel'])
            ->name('bangke01.export');
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
| SP | laravel-simba | AsPOGetRptBK01.php | Get Master data |
| SP | laravel-simba | AsPOGetRptBK01ById.php | Get Detail data |
| Component | laravel-catalog | BangkeMua01.php | Form bang ke Master-Detail |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, GetById, Find)
- [ ] Tao Model POMH, POMHCT
- [ ] Tao Livewire BangkeMua01 (Master-Detail)
- [ ] Tao Views (Master + Detail grids)
- [ ] Them Routes
- [ ] Test xem bang ke
- [ ] Test click row -> hien thi detail
- [ ] Test xuat Excel
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
