# Task 111: INRptTHX01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop hang xuat kho 01 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptTHX01.dll
- **Chuc nang:** Tong hop hang xuat kho
- **Loai:** Report (Bao cao)
- **Assembly Title:** Tong hop hang xuat kho
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptTHX01.dll/README.md`

---

## Form classes

### frmINRptTHX01 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_vt | AsTextBox | Ma vat tu (loc) |
| txtMa_nhvt | AsTextBox | Ma nhom vat tu (loc) |
| txtMa_Kh | AsTextBox | Ma khach hang (loc) |
| txtMa_kho_xuat | AsTextBox | Ma kho xuat (loc) |
| txtMa_Kho_nhap | AsTextBox | Ma kho nhap (chuyen kho) |
| txtTk_vt | AsTextBox | TK vat tu (loc) |
| txtTk_Du | AsTextBox | TK du (loc) |
| txtMa_NX | AsTextBox | Ma dang NX (loc) |
| txtMa_Bp | AsTextBox | Ma bo phan (loc) |
| txtMa_Hd | AsTextBox | Ma hop dong (loc) |
| txtMa_lo | AsTextBox | Ma lo (loc) |
| txtSo_Ct1 | TextBox | So chung tu tu |
| txtSo_Ct2 | TextBox | So chung tu den |
| cboLoai_px | ComboBox | Loai phieu xuat |
| ChkPsdc | AsCheckBox | Hien thi phat sinh dieu chinh |
| crvReportViewer | CrystalReportViewer | Xem va in bao cao |

---

## Business Logic

### Business Rules

1. **Loc nhieu tieu chi**: Ket hop nhieu tieu chi loc cung luc
2. **Kho xuat/nhap**: Dung cho chuyen kho noi bo
3. **Loai phieu xuat**: Loc theo loai phieu xuat

---

## Mapping PHP

### 1. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/Baocaotonghophangxuat.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class Baocaotonghophangxuat extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'THX01';

    public ?string $pMa_cty = '001';
    public ?string $pMa_vt = null;
    public ?string $pMa_nhvt = null;
    public ?string $pMa_Kh = null;
    public ?string $pMa_kho_xuat = null;
    public ?string $pMa_Kho_nhap = null;
    public ?string $pTk_vt = null;
    public ?string $pTk_Du = null;
    public ?string $pMa_NX = null;
    public ?string $pMa_Bp = null;
    public ?string $pMa_Hd = null;
    public ?string $pMa_lo = null;
    public ?string $pSo_ct1 = null;
    public ?string $pSo_ct2 = null;
    public ?int $pLoai_px = null;
    public bool $pPS_dc = false;

    public function render(): View
    {
        return view('catalog::in.reports.baocao-tong-hop-hang-xuat');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-tong-hop-hang-xuat', [Baocaotonghophangxuat::class, 'render'])
    ->name('catalog.in.reports.tong-hop-hang-xuat');
```

---

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINRptTHX01.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINRptTHX01 extends StoredProcedure
{
    protected $procedure = 'SP_IN_RPT_THX01_GET';
    protected $params = [
        'pMa_cty', 'pMa_vt', 'pMa_nhvt', 'pMa_Kh', 'pMa_kho_xuat',
        'pMa_Kho_nhap', 'pTk_vt', 'pTk_Du', 'pMa_NX', 'pMa_Bp',
        'pMa_Hd', 'pMa_lo', 'pSo_ct1', 'pSo_ct2', 'pLoai_px', 'pPS_dc',
        'pNgay1', 'pNgay2',
    ];
}
```

### 3. Views

```
resources/views/catalog/in/reports/
├── baocao-tong-hop-hang-xuat.blade.php   (Form loc + CrystalViewer)
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | Baocaotonghophangxuat.php | Report viewer |
| SP | laravel-simba | AsINRptTHX01.php | Data source |
| Model | laravel-simba | DMVT.php | Lookup vat tu |
| Model | laravel-simba | DMKHO.php | Lookup kho |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_THX01_GET
- [ ] Tao Livewire Baocaotonghophangxuat
- [ ] Tao View baocao-tong-hop-hang-xuat.blade.php
- [ ] Them Routes
- [ ] Test Crystal Report integration
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE — component `In\Rpt\Inrptthx01` + route `in.rpt.inrptthx01`, verify browser 2026-11-25 (**1130 dòng dữ liệu thật**)
- **Route:** `in.rpt.inrptthx01`
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `In\Rpt\Inrptthx01` (kế thừa `Rpt\AbstractReport`)
- **View:** `in/rpt/inrptthx01.blade.php` + filter tương ứng
- **Route:** `in.rpt.inrptthx01` — không suffix
- **SP:** `asINRptTHX01` — **21 tham số** (theo form gốc, không phải 23 như docs)
- **Menu:** `14.20.23` — "Tổng hợp hàng xuất"

### Bài học quan trọng: form gốc > `procedures.md`

`procedures.md` ghi **23 tham số**, wrapper cũ gửi 23 + 5 tham số hệ thống = 28
→ SP báo `has too many arguments specified`.

Em đọc **`frmINRptTHX01.LoadData()`** (decompiled) — form gốc gửi **21 tham số**:

| # | Nguồn từ form gốc |
|---:|---|
| 1-3 | `CompanyInformations.CompanyID`, `txtNgay1.Value`, `txtNgay2.Value` |
| 4-5 | `txtSo_Ct1.Text`, `txtSo_Ct2.Text` |
| 6 | `cboLoai_px.SelectedIndex` |
| 7-11 | `txtMa_Kh`, `txtMa_Hd`, `txtMa_NX`, `txtMa_kho_xuat`, `txtMa_Kho_nhap` |
| 12-14 | `txtMa_lo`, `txtMa_vt`, `txtMa_nhvt` |
| 15-16 | `txtTk_vt`, `txtMa_Bp` |
| 17 | `ChkPsdc.TextValue` |
| 18-19 | `txtMa_Nt`, `txtTk_Du` |
| 20-21 | `"0"`, `"1"` (giá trị cứng — tương ứng `pNgoai_te`, `pDVT`) |

→ Docs liệt kê thêm `pMa_phi`, `pMa_spct` mà form **không gửi**.

**Quy tắc:** khi wrapper báo "too many arguments", đọc `LoadData()` của form gốc
trong `simba-docs/decompiled/asia/<DLL>/` để lấy **đúng tham số form thật gửi**.

### Verify browser thật

| Kỳ test | Số dòng | Số cột |
|---|---:|---:|
| **2026-01-01 → 2026-12-31** | **1.005** | **14** |
| 2020-01-01 → 2020-12-31 | **1.130** | 14 |

| Kiểm chứng khác | Kết quả |
|---|---|
| Livewire component | `catalog::in.rpt.inrptthx01` render thật |
| Sub-component | `input-khachhang`, `input-indmvt`, `input-indmkho` x2 |
| Tab + nút Thực hiện | có |
| Page error | **0** |

> Component 21 tham số, ~105 dòng nhờ `AbstractReport`.
