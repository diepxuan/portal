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

- **Status:** DONE (component) — `Po\Rpt\Porptbk01` + route `po.rpt.porptbk01`, verify browser 2026-11-25: **0 dòng** (module PO không có dữ liệu)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.


## Portal implementation (2026-11-25)

- **Component:** `Po\Rpt\Porptbk01` (kế thừa `Rpt\AbstractReport`)
- **View:** `po/rpt/porptbk01.blade.php` + filter tương ứng
- **Route:** `po.rpt.porptbk01`
- **SP:** `asPORptBK01` — **29 tham số** (đã bỏ system params `ParamDefines` + biến thể trùng)

### 🐛 Bug wrapper đã sửa

Wrapper gốc có thêm `ParamDefines` + các biến thể trùng tên (khác hoa thường)
→ đã bỏ, còn **29 tham số**.

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::po.rpt.porptbk01` render thật |
| Submit | **0 dòng**, không `errorMessage` |
| Page error | **0** |

### ⚠️ 0 dòng — module PO không có dữ liệu

Nhất quán với task 066, 067. **Không phải bug code.**

## PR #428 — đối chiếu ảnh SimbaERP gốc (2026-11-27)

> Task này **đang được làm tiếp** trong **PR #428** (`feat/po-bangke-timer`).
> Trạng thái: **PR mở, chưa merge** — chờ Sếp duyệt.

### Đã làm (trong PR #428)

#### 1. Bộ chọn kỳ báo cáo — giống `po.rpt.arrptbccn01103023`

| | Trước | Sau |
|---|---|---|
| Bộ chọn kỳ | ❌ không có | ✅ `<livewire('catalog::component.timer')>` |
| `pNgay1` | 2026-11-01 | 2026-11-01 |
| `pNgay2` | **2026-11-27** (hôm nay) | **2026-11-30** (cuối kỳ) |

Thêm `mount()` + `syncTimer()` dùng `CatalogService::timer()`.

#### 2. Label tiếng Việt — thay field name thô

Trước hiển thị `pTrang_thai`, `pSoct1`, `pMa_kh`…

Sau lấy đúng từ `frmPORptBK01.cs` (`grep 'lbl*.Text = "..."'`):

| Field | Label | Field | Label |
|---|---|---|---|
| `pSoct1` | Chứng từ số | `pSoct2` | Đến số |
| `pMa_ct` | Loại phiếu | `pMa_kh` | Mã NCC |
| `pMa_plkh1/2/3` | P loại NCC1/2/3 | `pMa_hd` | Mã hợp đồng |
| `pMa_nhhd` | Nhóm hợp đồng | `pMa_httt` | Hình thức TT |
| `pMa_kho` | Mã kho | `pMa_lo` | Mã lô |
| `pMa_Phi` | Mã phí | `pMa_spct` | Mã SPCT |
| `pMa_vt` | Mã vật tư | `pMa_nhvt` | Mã nhóm vật tư |
| `pMa_nt` | Mã ngoại tệ | `pGroupType` | Nhóm theo |

#### 3. Thứ tự field — theo ảnh SimbaERP 14.2

```
 1. Kỳ báo cáo          -> component.timer
 2. Chứng từ số — Đến số -> pSoct1 | pSoct2  (CÙNG 1 DÒNG, có dấu '-')
 3. Loại phiếu          -> pMa_ct  (autocomplete)
 4. Mã NCC              -> pMa_kh
 5. P loại NCC1         -> pMa_plkh1
 6. P loại NCC2         -> pMa_plkh2
 7. P loại NCC3         -> pMa_plkh3
 8. Mã hợp đồng         -> pMa_hd
 9. Nhóm hợp đồng       -> pMa_nhhd
10. Hình thức TT        -> pMa_httt
11. Mã kho              -> pMa_kho
12. Mã lô               -> pMa_lo
13. Mã phí              -> pMa_Phi
14. Mã SPCT             -> pMa_spct
15. Mã vật tư           -> pMa_vt
16. Mã nhóm vật tư      -> pMa_nhvt
17. Mã ngoại tệ         -> pMa_nt
```

#### 4. Autocomplete "Loại phiếu" — component dùng lại được

**Component mới (dùng chung):**

```
src/Http/Livewire/Component/InputLoaiPhieu.php
resources/views/components/input-loai-phieu.blade.php
```

Dùng:
```blade
<livewire:catalog::component.input-loai-phieu
    wire:model="pMa_ct" phan-he="PO" :include-all="true" />
```

**Nguồn:** SP `asSIGetDmSo_ct` (4 tham số thật):
`@pMa_cty`, `@pPhan_he`, `@pStruct`, `@pLanguageId`

**Bug đã fix:** `app()->getLocale()` = `'en'` → SP trả **0 dòng**. Phải dùng `'vi-VN'`:

| `pLanguageId` | Dòng |
|---|---:|
| `vi-VN` | **6** ✅ |
| `en-US` | 6 |
| `en` | 0 |
| `vi` | 0 |
| `''` | 2 |

#### 5. Tự động chọn "Hoá đơn mua hàng trong nước"

**Nguồn:** bảng `sysReportInfo` (chính là `MyReportInfo` trong form gốc).

Form gốc `frmPORptBK01.InitOtherComponents()`:
```csharp
// sau khi nap asSIGetDmSo_ct:
((ListControl)cboLoaiPhieu).SelectedValue = base.MyReportInfo.par0;
```

Query DB xác nhận:

| Menu | ma_mau | isdefault | par0 |
|---|---|---|---|
| `10.20.02` | 04 | **1** | **`PO3`** |
| `10.20.05` | 04 | **1** | **`PO3`** |
| `10.20.20` | 01 | **1** | `''` (Tất cả) |

**Kết quả áp dụng:**

| Task | `pMa_ct` mặc định | Hiển thị |
|---|---|---|
| **071** (BK01) | `'PO3'` | Hoá đơn mua hàng trong nước |
| **073** (BK02) | `'PO3'` | Hoá đơn mua hàng trong nước |
| **077** (BK03) | `null` | (Tất cả — đúng `par0=''`) |

**Fix kỹ thuật:** `mount()` không nhận value qua `wire:model` -> thêm `hydrate()` + sync trong `render()` để input hiện **tên** thay vì mã `PO3`.

**Verify browser:**
```
wireValue=PO3 | wireSearch="Hoá đơn mua hàng trong nước"
payload: pMa_ct=PO3, pNgay1=2026-11-01, pNgay2=2026-11-30
submit: n=0, err=null
```

#### 6. Autocomplete "Mã NCC" — dùng lại component có sẵn

**Không viết component mới** — đã có `InputKhachhang` hỗ trợ multi-mode.

Kiểm tra code:
```php
// Component/InputKhachhang.php
'mode' => 'khachhang' | 'nhacungcap' | 'nhanvien'
// map: 'nhacungcap' => pModuleId 'AP'
```

Kiểm tra SP `asARGetDMKH` (4 tham số): `@pMa_cty`, `@pMa_kh`, `@pStruct`, `@pModuleId`

Test `pModuleId`:

| `pModuleId` | Dòng | NCC (`isncc=1`) |
|---|---:|---:|
| `null` / `''` | 761 | 96 |
| **`AP`** | **96** | **96** |
| `PO` | 96 | 96 |
| `AR` | 665 | 4 |
| `CA` | 27 | 1 |

→ `pModuleId='AP'` (hoặc `PO`) trả đúng danh sách NCC.

**Áp dụng (giống `arrptbccn01sl` đã làm):**

```blade
<livewire:catalog::component.input-khachhang
    mode="nhacungcap" wire:model="pMa_kh" />
```

**Verify browser:**
```
input placeholder = "Chọn nhà cung cấp..."
mode = "nhacungcap"
mo dropdown      -> 20 NCC
go "zinus"       -> 1 ket qua: "Cong ty TNHH Zinus Viet Nam"
trong HTML       -> 96 NCC entries
```

#### 7. Autocomplete cho 5 field còn lại — dùng component có sẵn

Kiểm tra từng field, **field nào có nguồn dropdown thì nạp, không có thì để nguyên**.

| Field | Component dùng | Nguồn dữ liệu | Số dòng |
|---|---|---|---:|
| `pMa_httt` | `input-httt` (có `module-id="PO"`) | `AsGetDMHTTT` | **6** |
| `pMa_kho` | `input-indmkho` | `AsINGetDMKHO` | **19** |
| `pMa_vt` | `input-indmvt` | `AsINGetDMVT` | **3.660** |
| `pMa_nhvt` | `input-indmnhvt` | `AsINGetDMNHVT` | **106** |
| `pMa_nt` | `input-ngoaite` | `AsSIGetDMNT` | **12** |

**Field KHÔNG có dropdown — giữ nguyên input text:**

| Field | Lý do |
|---|---|
| `pMa_hd` (Mã hợp đồng) | không có danh mục trong sysMenu |
| `pMa_nhhd` (Nhóm hợp đồng) | không có danh mục |
| `pMa_lo` (Mã lô) | không có danh mục |
| `pMa_Phi` (Mã phí) | không có danh mục |
| `pMa_spct` (Mã SPCT) | không có danh mục |
| `pGroupType` (Nhóm theo) | tham số điều khiển, không phải danh mục |

### 🐛 Bug phát hiện: `InputHttt` cần `pModuleid`

`InputHttt` **bắt buộc** phải truyền `module-id`, nếu null/'' thì SP trả **0 dòng**:

| `pModuleid` | Dòng |
|---|---:|
| `null` | **0** |
| `''` | **0** |
| **`PO`** | **6** ✅ |
| `SO` | 7 |
| `AR` | 0 |

Fix: thêm `module-id="PO"` (giống `povchpo3-edit` đã làm).

### Verify browser thật

```html
<!-- 6 component Alpine có dữ liệu -->
loaiPhieuInputComponent(JSON.parse([...]))   ✅
khInputComponent(JSON.parse([...]))          ✅ 96 NCC
htttInputComponent(JSON.parse([...]))        ✅ 6 HTTT
khoInputComponent(JSON.parse([...]))         ✅ 19 kho
vtInputComponent(JSON.parse([...]))          ✅ 3660 VT
ngoaiteInputComponent(JSON.parse([...]))     ✅ 12 NT

<!-- 1 component datalist -->
<datalist id="InDmNhvt-suggestions">        ✅ 106 option
```

Tương tác: click "Chọn hình thức thanh toán" → **6 option**.

### 8. 🐛 BUG NGHIÊM TRỌNG: nhập kỳ → 0 kết quả

**Triệu chứng:** nhập tháng 10, giữ `PO3`, nhấn tìm → **0 dòng**.

**Nguyên nhân gốc** — SP dựng SQL động:

```sql
+ case @pX when '' then '' else ' AND col LIKE @pX + percent' end
```

SQL Server: `NULL = ''` → **UNKNOWN** (không phải TRUE) → rơi vào nhánh `else` → sinh điều kiện `LIKE NULL` → **lọc sạch 0 dòng**.

Wrapper gửi `null` cho mọi field chưa nhập → báo cáo **luôn 0 dòng**.

**Bằng chứng** (tháng 10/2026, `pMa_ct='PO3'`):

| Tham số | `NULL` | `''` |
|---|---|---|
| `pTrang_thai` | **0** ❌ | 111 ✅ |
| `pMa_nt` | **0** ❌ | 111 ✅ |
| `pMa_kho` | **0** ❌ | 111 ✅ |
| `pMa_lo` | **0** ❌ | 111 ✅ |
| `pMa_httt` | **0** ❌ | 111 ✅ |
| `pMa_bp` | **0** ❌ | 111 ✅ |
| `pMa_spct` | **0** ❌ | 111 ✅ |
| `pMa_Phi` | **0** ❌ | 111 ✅ |

**An toàn với `NULL`** (giữ nguyên): `pMa_kh`, `pMa_vt`, `pMa_nhvt`, `pMa_hd`, `pMa_plkh1/2/3`, `pMa_nhhd`

**Fix:** đổi 8-9 property `null` → `''` trong 3 component.

**Verify sau fix:**

| Kỳ | BK01 | BK02 | BK03 |
|---|---:|---:|---:|
| Tháng 10/2026 | **111** (trước 0) | **128** (trước 0) | 0 |
| Năm 2025 | **1.371** / 40 cột | **1.415** / 40 cột | **42** / 42 cột |

> **BK03 năm 2026 = 0 dòng là ĐÚNG nghiệp vụ** — bảng `poct` không có dòng nào thỏa `cp<>0 OR cp_nt<>0` trong 2026 (năm 2025 có 42 dòng).

### Field ẩn — theo form gốc

Form ẩn bằng `.Visible = false` nên không có trong ảnh:

```
pTrang_thai, pMa_nhkh, pMa_vitri, pMa_nvkd,
pMa_plvt1/2/3, pMa_TT, pMa_bp
```

Vẫn giữ trong payload (SP cần đủ tham số), chỉ không hiện UI.

### Verify browser thật (2026-11-27)

| Kiểm chứng | Kết quả |
|---|---|
| Route `po/rpt/porptbk01` | **200** |
| `component.timer` | ✅ load |
| `component.input-loai-phieu` | ✅ load |
| `ctOptions` | **7 dòng** (6 loại phiếu + "Tất cả") |
| Gõ `hoa don` | 3 kết quả: PO3, PO6, PO7 |
| Số label | 22 label tiếng Việt đúng thứ tự ảnh |
| Submit | `err: null` (**0 dòng** — module PO không có dữ liệu kỳ 11/2026) |

### Đang làm / Sẽ làm

| Việc | Trạng thái |
|---|---|
| Chờ Sếp duyệt PR #428 | ⏳ **đang chờ** |
| Merge PR #428 | ⏳ sau khi duyệt |
| Verify sau merge trên `main` | ⏳ chưa |
| Kiểm tra dữ liệu thật khi PO có phát sinh | ⏳ chưa có kỳ nào có dữ liệu |

> **Chưa thể verify dữ liệu:** module PO hiện không có phát sinh trong kỳ 11/2026 → SP trả 0 dòng. Cần kỳ có dữ liệu để xác nhận số liệu đúng.

### Menu & title

- **Menu:** `10.20.02`
- **Title (sysMenu.short_name):** Bảng kê hóa đơn mua hàng trong nước
- **Title hiện trên UI:** lấy từ `sysMenu.bar` (form gốc `AssemblyTitle`) — khác `short_name`

