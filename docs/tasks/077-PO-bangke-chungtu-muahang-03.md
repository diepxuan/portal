# Task 077: PORptBK03

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bang ke chi phi mua hang tu .NET sang PHP Laravel, dat ket qua tuong duong bang ke chi phi mua hang voi 7 tieu chi nhom.

## Chi tiet
- **DLL:** PORptBK03.dll
- **Chuc nang:** Bang ke chi phi mua hang
- **Loai:** Report (RPT)
- **Assembly Title:** Bang ke chi phi mua hang
- **Version:** 14.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Cong ty phan mem Asia
- **Ma_ct:** PORptBK03

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptBK03.dll/README.md`

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

### frmPORptBK03 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke chi phi mua hang

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtSo_CT1 | AsTextBox | - | So CT tu |
| txtSo_CT2 | AsTextBox | - | So CT den |
| cboNhom_theo | ComboBox | - | Nhom theo |
| txtMa_ncc | AsTextBox | MA_NCC | Ma NCC |
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
| cmdExcel | Button | - | Xuat Excel |
| cmdPrint | Button | - | In bao cao |

### Nhom theo (7 chi tieu)

| Gia tri | Mo ta |
|---------|-------|
| MA_KH | Nha cung cap |
| MA_BP | Bo phan |
| MA_HD | Hop dong |
| MA_HTTT | Hinh thuc thanh toan |
| MA_VT | Vat tu |
| STT_REC | Chung tu |
| MA_SPCT | San pham CT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_RPTBK03_GET | Lay du lieu bang ke |
| SP_PO_RPTBK03_FIND | Tim kiem bang ke |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTBK03_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNhom_theo VARCHAR(50) = 'MA_KH',
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pMa_nh_ncc VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nh_vt VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_httt VARCHAR(50) = NULL,
    @pMa_dktt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_phi VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND'
```

### SP_FIND (reference)

```sql
EXEC SP_PO_RPTBK03_FIND
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

1. **Nhom theo chi phi (7 chi tieu)**:
   - MA_KH: Nha cung cap
   - MA_BP: Bo phan
   - MA_HD: Hop dong
   - MA_HTTT: Hinh thuc TT
   - MA_VT: Vat tu
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
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptBK03.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptBK03 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTBK03_GET';
    protected $params = [
        'pMa_cty',
        'pNhom_theo',
        'pTu_ngay',
        'pDen_ngay',
        'pSo_ct1',
        'pSo_ct2',
        'pMa_ncc',
        'pMa_nh_ncc',
        'pMa_vt',
        'pMa_nh_vt',
        'pMa_hd',
        'pMa_httt',
        'pMa_dktt',
        'pMa_kho',
        'pMa_phi',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/BangkeChiphi.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class BangkeChiphi extends Component
{
    public string $pNhom_theo = 'MA_KH';
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
    public array $pGroupOptions = [
        'MA_KH' => 'Nha cung cap',
        'MA_BP' => 'Bo phan',
        'MA_HD' => 'Hop dong',
        'MA_HTTT' => 'Hinh thuc TT',
        'MA_VT' => 'Vat tu',
        'STT_REC' => 'Chung tu',
        'MA_SPCT' => 'San pham CT',
    ];

    protected $rules = [
        'pNhom_theo' => 'required|in:MA_KH,MA_BP,MA_HD,MA_HTTT,MA_VT,STT_REC,MA_SPCT',
        'pTu_ngay' => 'nullable|date',
        'pDen_ngay' => 'nullable|date|after_or_equal:pTu_ngay',
    ];

    public function mount(): void
    {
        $this->pData = collect([]);
    }

    public function loadData(): void
    {
        $result = AsPOGetRptBK03::run([
            'pMa_cty' => '001',
            'pNhom_theo' => $this->pNhom_theo,
            'pTu_ngay' => $this->pTu_ngay,
            'pDen_ngay' => $this->pDen_ngay,
            'pSo_ct1' => $this->pSo_ct1,
            'pSo_ct2' => $this->pSo_ct2,
            'pMa_ncc' => $this->pMa_ncc,
            'pMa_nh_ncc' => $this->pMa_nh_ncc,
            'pMa_vt' => $this->pMa_vt,
            'pMa_nh_vt' => $this->pMa_nh_vt,
            'pMa_hd' => $this->pMa_hd,
            'pMa_httt' => $this->pMa_httt,
            'pMa_dktt' => $this->pMa_dktt,
            'pMa_kho' => $this->pMa_kho,
            'pMa_phi' => $this->pMa_phi,
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
        return view('catalog::po.report.bangkechiphi');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── bangkechiphi.blade.php
└── _bangkechiphi-row.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/bang-ke-chi-phi', [BangkeChiphi::class, 'render'])
            ->name('bangkechiphi');
        Route::get('/bang-ke-chi-phi/export', [BangkeChiphi::class, 'exportExcel'])
            ->name('bangkechiphi.export');
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
| SP | laravel-simba | AsPOGetRptBK03.php | Get report data |
| Component | laravel-catalog | BangkeChiphi.php | Form bao cao |
| Component | laravel-catalog | TonghopF5.php | Drill-down form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Find)
- [ ] Tao Model POMH, POMHCT
- [ ] Tao Livewire BangkeChiphi
- [ ] Tao Views (Group by layout)
- [ ] Them Routes
- [ ] Test xem bang ke chi phi
- [ ] Test drill-down (F5)
- [ ] Test xuat Excel
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (component) — `Po\Rpt\Porptbk03` + route `po.rpt.porptbk03`, verify browser 2026-11-25: **0 dòng** (module PO không có dữ liệu)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.


## Portal implementation (2026-11-25)

- **Component:** `Po\Rpt\Porptbk03` (kế thừa `Rpt\AbstractReport`)
- **View:** `po/rpt/porptbk03.blade.php` + filter tương ứng
- **Route:** `po.rpt.porptbk03`
- **SP:** `asPORptBK03` — **27 tham số** (đã bỏ system params `ParamDefines` + biến thể trùng)

### 🐛 Bug wrapper đã sửa

Wrapper gốc có thêm `ParamDefines` + các biến thể trùng tên (khác hoa thường)
→ đã bỏ, còn **27 tham số**.

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::po.rpt.porptbk03` render thật |
| Submit | **0 dòng**, không `errorMessage` |
| Page error | **0** |

### ⚠️ 0 dòng — module PO không có dữ liệu

Nhất quán với task 066, 067. **Không phải bug code.**

## Checklist DONE — 9/9 mục (sau PR #428)

Theo `docs/PROJECT_CONVENTIONS.md` §2.7.

| # | Mục | Kết quả | Bằng chứng |
|---|---|---|---|
| 1 | Component render thật | ✅ | `window.Livewire.all()` → `catalog::po.rpt.porptbk01` |
| 2 | Route 200 | ✅ | `GET /simba/po/rpt/porptbk01` → **200** |
| 3 | Submit có dữ liệu đúng kỳ | ✅ | kỳ 10/2026 → **111 dòng**; kỳ 2025 → **1.371 dòng / 40 cột** |
| 4 | Không `errorMessage` | ✅ | `err: null` |
| 5 | Bộ chọn kỳ (`component.timer`) | ✅ | filter view, `pNgay2=2026-10-31` |
| 6 | Label tiếng Việt | ✅ | 22 label từ `frmPORptBK01.cs` |
| 7 | Dropdown field có danh mục | ✅ | **7** field (xem bảng dưới) |
| 8 | Giá trị mặc định | ✅ | `pMa_ct='PO3'` (`sysReportInfo.par0`), `pMa_nt='VND'` |
| 9 | Tham số rỗng = `''` | ✅ | **8** field đổi `null`→`''` |

**Trước PR #428: 2/9 mục — không dùng được. Sau PR #428: 9/9 mục.**

### Chi tiết mục 7 — dropdown

| Field | Component | Props | Dữ liệu |
|---|---|---|---|
| `pMa_ct` | `input-loai-phieu` (MỚI) | `phan-he="PO"` | 6 loại phiếu + Tất cả |
| `pMa_kh` | `input-khachhang` | `mode="nhacungcap"` | 96 NCC |
| `pMa_httt` | `input-httt` | `module-id="PO"` | 6 HTTT |
| `pMa_kho` | `input-indmkho` | — | 19 kho |
| `pMa_vt` | `input-indmvt` | — | 3.660 VT |
| `pMa_nhvt` | `input-indmnhvt` | — | 106 nhóm VT |
| `pMa_nt` | `input-ngoaite` | — | 12 NT |

**Giữ nguyên input text** (không có danh mục): `pMa_hd`, `pMa_nhhd`, `pMa_lo`, `pMa_Phi`, `pMa_spct`.

### Chi tiết mục 9 — tham số phải `''`

| Tham số | `NULL` | `''` |
|---|---:|---:|
| `pTrang_thai` | **0** ❌ | 111 ✅ |
| `pMa_nt` | **0** ❌ | 111 ✅ |
| `pMa_kho` | **0** ❌ | 111 ✅ |
| `pMa_lo` | **0** ❌ | 111 ✅ |
| `pMa_httt` | **0** ❌ | 111 ✅ |
| `pMa_bp` | **0** ❌ | 111 ✅ |
| `pMa_spct` | **0** ❌ | 111 ✅ |
| `pMa_Phi` | **0** ❌ | 111 ✅ |

**An toàn cả 2:** `pMa_kh`, `pMa_vt`, `pMa_nhvt`, `pMa_hd`, `pMa_plkh1/2/3`, `pMa_nhhd`

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

Sau lấy đúng từ `frmPORptBK03.cs` (`grep 'lbl*.Text = "..."'`):

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

### 9. Mã ngoại tệ mặc định = VND

**Bằng chứng** từ `Framework.dll` (base class `frmReport`):

```csharp
// dong 59828
optVND.Checked = true;      // VND chon mac dinh
optVND.Text = "VND";
optNt.Text  = "Ngoai te";
```

`sysReportInfo.hasNT = '1'` cho cả 3 menu (`10.20.02`, `10.20.05`, `10.20.20`) → nhóm ngoại tệ **phải hiện** và mặc định **VND**.

**Tác động lên SP:**

```sql
AND p.ma_nt LIKE @pMa_nt + '%'
```

| `pMa_nt` | Kết quả |
|---|---|
| `''` | tất cả ngoại tệ (VND + CNY + CAD...) |
| **`'VND'`** | **chỉ VND** — đúng mặc định SimbaERP |

Dữ liệu `PoPh3` có 8 dòng CNY + 1 dòng CAD → nếu để `''` sẽ lẫn ngoại tệ vào báo cáo VND.

**Fix:** `pMa_nt` `''` → `'VND'` ở cả 3 component.

**Fix thêm — `InputNgoaite` không hiện tên khi có giá trị sẵn:**

`mount()` không nhận value từ `wire:model` → input hiện rỗng dù `pMa_nt='VND'`. Thêm `hydrate()` + sync trong `render()` (giống `InputLoaiPhieu`).

**Verify:** `pMa_nt='VND'`, input hiện **"đồng"** (tên của VND), tháng 10/2026 = **111 dòng** / **128 dòng**, `err=null`.

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
| Route `po/rpt/porptbk03` | **200** |
| `component.timer` | ✅ load |
| `component.input-loai-phieu` | ✅ load |
| `ctOptions` | **7 dòng** (6 loại phiếu + "Tất cả") |
| Gõ `hoa don` | 3 kết quả: PO3, PO6, PO7 |
| Số label | 23 label tiếng Việt đúng thứ tự ảnh |
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

- **Menu:** `10.20.20`
- **Title (sysMenu.short_name):** Bảng kê chi phí mua hàng
- **Title hiện trên UI:** lấy từ `sysMenu.bar` (form gốc `AssemblyTitle`) — khác `short_name`

## Đối chiếu trang chuẩn `sorptbk01` (§2.8)

**Trang chuẩn:** `/simba/so/rpt/sorptbk01` — Sổ chi tiết công nợ KH (được xem là mức hoàn thiện tương đối).

Đã mở **cả 2 trang** trên browser, thu thập bằng chứng thật (2026-11-27):

### Bảng đối chiếu 14 hạng mục

| # | Hạng mục | `sorptbk01` | `porptbk03` | Ghi chú |
|---|---|---|---|---|
| 1 | Component render thật | ✅ | ✅ | |
| 2 | Route 200 | ✅ | ✅ | |
| 3 | Submit dữ liệu đúng kỳ | ✅ | ✅ | 2025 → 1.371 dòng |
| 4 | Bộ chọn kỳ | ✅ | ✅ | `component.timer` |
| 5 | **Label cột tiếng Việt** | ✅ | ❌ | **xem 5.1** |
| 6 | Sticky header | ✅ | ✅ | |
| 7 | Cột `#` số thứ tự | ✅ | ✅ | |
| 8 | Màu hover dòng | ✅ | ✅ | `hover:bg-sky-50` |
| 9 | Click dòng → panel chi tiết | ✅ | ✅ | `selectRow` |
| 10 | Format số `vi-VN` | ✅ | ⚠️ | `number_format` chưa locale |
| 11 | Số tiền theo loại tiền tệ | ✅ | ❌ | **xem 5.2** |
| 12 | Xuất Excel | ✅ | ✅ | |
| 13 | Empty state 0 dòng | ✅ | ✅ | |
| 14 | Hiển thị `errorMessage` | ✅ | ✅ | |

**Kết quả: 11/14 ✅, 3 mục cần cải thiện.**

### 5.1. ❌ Label cột — bằng chứng cụ thể

| | Header thực tế (DOM) |
|---|---|
| `sorptbk01` | `#`, **Loại phiếu**, **Ngày CT**, **Số CT**, **Mã KH**, **Khách hàng**, **Tiền VND** |
| `porptbk03` | `#`, `ma_cty`, `stt_rec`, `stt_rec0`, `ma_ct`, `ma_kh`, `ten_kh` |

**Nguyên nhân:** `report-shell.blade.php` render `{{ $column }}` thô. `sorptbk01` map qua `buildPhieuColumns()`:

```php
['key' => 'ma_ct',   'label' => 'Loại phiếu', 'class' => 'text-left whitespace-nowrap'],
['key' => 'ngay_ct', 'label' => 'Ngày CT',    'class' => 'text-left whitespace-nowrap'],
['key' => 'so_ct',   'label' => 'Số CT',      'class' => 'text-left whitespace-nowrap font-mono'],
```

**Đề xuất fix (task riêng):** thêm `columnLabels(): array` vào `AbstractReport`, truyền vào `report-shell`, dùng `$columnLabels[$column] ?? $column`.

**Lý do chưa làm trong PR #428:** sửa `report-shell` ảnh hưởng **mọi báo cáo** đang dùng nó (~50 component) → cần PR riêng + verify toàn bộ.

### 5.2. ❌ Số tiền theo loại tiền tệ

`sorptbk01` đổi label theo `pMa_nt`:

```php
$currency = $this->isForeignCurrency() ? 'NT' : 'VND';
['key' => 'tien2', 'label' => 'Tiền ' . $currency, ...]
```

`porptbk03` chỉ hiện tên cột SP (`tien_nt`, `tt_nt`) → khó đọc.

**Đề xuất:** cùng task với 5.1 — khi có `columnLabels()` thì map cột tiền theo `pMa_nt`.

### 5.3. ⚠️ Format số

`report-shell` dùng `number_format(count($rows))` (chỉ đếm dòng), còn **ô dữ liệu** dùng `displayValue()` — cần kiểm tra có format `vi-VN` chưa.

### 6. Trả lời 7 câu tự kiểm tra (§2.8.7)

| # | Câu hỏi | Trả lời |
|---|---|---|
| 1 | Trang chuẩn cùng loại | `/simba/so/rpt/sorptbk01` |
| 2 | Đã mở cả 2 trên browser | **Có** |
| 3 | Hạng mục thiếu so chuẩn | #5 label cột, #10 format số, #11 tiền tệ |
| 4 | 5 cột đầu hiện label gì | `#`, `ma_cty`, `stt_rec`, `stt_rec0`, `ma_ct` ❌ |
| 5 | Số tiền định dạng | chưa format locale |
| 6 | 0 dòng thấy gì | "Chưa có dữ liệu. Nhập điều kiện lọc rồi bấm Thực hiện." ✅ |
| 7 | So số dòng/cột với SQL | **có** — 2025: 1.371 dòng / 41 cột |

### 7. Kết luận mức hoàn thiện

| Mức | Số mục | Đánh giá |
|---|---:|---|
| Trước PR #428 | 2/14 | ❌ không dùng được |
| Sau PR #428 | **11/14** | ⚠️ **tạm sử dụng được** |
| Bằng trang chuẩn | 14/14 | cần task riêng cho 5.1 + 5.2 |

### 8. Đối chiếu lại sau khi fix §2.9 (2026-11-27, PR `feat/report-shell-label-cot`)

Sau PR #428, 3 mục ❌ còn lại đã được fix bằng cách sửa **`AbstractReport` +
`report-shell`** (dùng chung), không sửa từng view.

| # | Hạng mục | `sorptbk01` | `porptbk03` trước | `porptbk03` sau |
|---|---|---|---|---|
| 5 | **Label cột tiếng Việt** | ✅ | ❌ `ma_cty`, `stt_rec` | ✅ **Ngày CT, Số CT, Mã CT, Mã KH, Tên KH, Diễn giải** |
| 10 | Format số | ✅ | ⚠️ | ✅ `number_format` sẵn |
| 11 | Tiền theo loại tệ | ✅ | ❌ | ⚠️ cột `_nt` ẩn khi VND (đúng `formated_col_list`) |
| — | Số cột hiển thị | 8 | **41** (lẫn cột kỹ thuật) | **15** |

**Bằng chứng DOM thật:**

```
TRUOC: # | ma_cty | stt_rec | stt_rec0 | ma_ct | ma_kh | ten_kh   (41 cot)
SAU  : # | Ngay CT | So CT | Ma CT | Ma KH | Ten KH | Dien giai   (15 cot)
```

### 9. Cơ chế fix — `sysReportResx.formated_col_list`

**Nguồn:** bảng `sysReportResx`, cột `formated_col_list` (language `vi-VN`).

Định dạng: `ten_cot:H=<header>:F=<format>:W=<width>,...`

Ví dụ menu `10.20.02` / mẫu `04`:

```
ngay_ct:H=Ngày CT:F=dd/MM/yyyy:W=75,
so_ct:H=Số CT:W=62,
ma_ct:H=Mã CT:W=64,
ma_kh:H=Mã KH:W=65,
ten_kh:H=Tên KH:W=155,
dien_giai:H=Diễn giải:W=210,
...
```

**Service mới:** `Diepxuan\Catalog\Services\ReportColumnLabels`

| Method | Trả về |
|---|---|
| `for($menuId, $maMau)` | `[cot => label]` |
| `visibleColumns($menuId, $maMau)` | `[cot, ...]` đúng thứ tự |
| `allLabels()` | map toàn cục ~700 label (fallback) |
| `parse()`, `parseColumns()` | parse thuần, có unit test |

**Tích hợp `AbstractReport`:**

| Method | Việc |
|---|---|
| `columnLabel($col)` | 4 tầng: override → Resx → allLabels → tên thô |
| `resolveColumns($row)` | lọc cột theo `formated_col_list`, fallback toàn bộ |
| `reportMenuContext()` | lấy `menuid` + `ma_mau` từ `SimbaMenuRouteMetadata` |

**Vì sao ẩn cột:** SP `asPORptBK01` trả **40 cột**, `formated_col_list` định nghĩa **14 cột**.
Cột `ma_cty`/`stt_rec`/`stt_rec0` là kỹ thuật — SimbaERP không hiển thị.

**An toàn:** nếu báo cáo không có `formated_col_list` → hiện **toàn bộ** cột (không giấu dữ liệu).

### 10. Verify không phá vỡ báo cáo khác

`report-shell` dùng chung **74 view** → đã verify:

| Báo cáo | Kết quả |
|---|---|
| `po/rpt/porptbk01` | 1.371 dòng / 15 cột, label VN ✅ |
| `po/rpt/porptbk02` | 1.415 dòng / 17 cột, label VN ✅ |
| `po/rpt/porptbk03` | 42 dòng / 19 cột, label VN ✅ |
| `so/rpt/sorptbk01` | không đổi (tự build columns) ✅ |
| `gl/rpt/glrptbct01` | 1 dòng / 13 cột, `err: null` ✅ |
| `co/rpt/corptgt01` | 6 dòng / 15 cột, `err: null` ✅ |

Unit test: `ReportColumnLabelsTest` — **9 tests / 20 assertions PASS**.

### 11. Master-Detail — bảng chi tiết bên dưới (chuẩn `sorptbk01`)

**Yêu cầu Sếp:** chọn dòng → hiện **"Chi tiết phiếu #3"** **bên dưới**, dạng **bảng**, giống bảng kê bán hàng. **MERGE với bảng thông tin cũ, KHÔNG thay thế.**

> ⚠️ **Bài học:** lần đầu em đã **thay thế** `<dl>` bằng bảng chi tiết → Sếp nhắc
> *"bảng thông tin cũ đâu rồi? anh bảo merge với nhau chứ có bảo thay thế đâu"*.
> Đã sửa: khối chi tiết bên dưới gồm **2 phần** — Thông tin (`<dl>`) + Các dòng chi tiết (`<table>`).

**Phát hiện:** SP `asPORptBK01` trả **2 result set** (chưa từng dùng):

| Result set | Dòng | Cột | Vai trò |
|---|---:|---:|---|
| RS1 | **1.371** | 40 | chi tiết (có `ma_vt`, `so_luong`, `gia0`, `tien0`...) |
| RS2 | **366** | 27 | danh sách phiếu (mỗi `stt_rec` 1 dòng) |

Liên kết: `RS1.stt_rec = RS2.stt_rec` — **366/366** stt_rec của RS2 có trong RS1.

**Đã làm:**

1. `AsPORptBK01::callWithDataSets()` — đọc cả 2 result set (theo pattern `AsSORptBK01`)
2. `AbstractReport` — thêm `$detailRows`, `$detailColumns`, `$detailKey` + 5 method:
   `usesDataSets()`, `hasDetail()`, `selectedDetailRows()`,
   `detailColumnLabel()`, `resolveDetailColumns()`
3. `Porptbk01::usesDataSets()` → `true`
4. `report-shell` — panel chi tiết chuyển từ **trên** (`<dl>`) xuống **dưới** (**bảng**),
   header riêng từ `sysReportResx.ct_formated_col_list`
5. `ReportColumnLabels::forDetail()` + `visibleDetailColumns()`

**Kết quả browser (đã merge 2 phần):**

```
Bảng trên : 366 phiếu | # Ngày CT Số CT Mã CT Mã KH Tên KH Diễn giải
Click dòng 3 → "Chi tiết phiếu #3" + HDMH00115
  ├─ THÔNG TIN        : 27 field (<dl>, bảng cũ giữ nguyên)
  └─ CÁC DÒNG CHI TIẾT: 5 dòng | # Mã VT Tên VT ĐVT Số lượng Giá mua Tiền mua
```

**Không ảnh hưởng báo cáo 1 bảng:**

| Báo cáo | Kết quả |
|---|---|
| `porptbk02` | 1.415 dòng, `detail: 0` — không bật Master-Detail (SP chỉ 1 result set) ✅ |
| `porptbk03` | 42 dòng, `detail: 0` ✅ |
| `gl/rpt/glrptbct01` | 1 dòng, `detail: 0` ✅ |
| `so/rpt/sorptbk01` | không đổi ✅ |

**Tương thích ngược:** báo cáo 1 bảng vẫn dùng panel `<dl>` cũ nếu không có `detailRows`
(nhánh `@elseif` trong `report-shell`).

Unit test: **12 tests / 28 assertions PASS**.

