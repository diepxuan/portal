# Task 107: INRptBK01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu ton kho tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptBK01.dll
- **Chuc nang:** Bang ke chung tu ton kho
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bang ke chung tu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptBK01.dll/README.md`

---

## Form classes

### frmINRptBK01 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau_bc | ComboBox | Mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| txtMonth | TextBox | Thang bao cao |
| txtYear | TextBox | Nam bao cao |
| txtMa_vt | AsTextBox | Ma vat tu (loc) |
| txtMa_kho | AsTextBox | Ma kho (loc) |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Hien thi VND |
| optNt | RadioButton | Hien thi ngoai te |
| crvReportViewer | CrystalReportViewer | Xem va in bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_BK01_GET | Lay du lieu bang ke chung tu ton kho |

### SP_GET (reference)

```sql
-- Lay du lieu bang ke chung tu ton kho
EXEC SP_IN_RPT_BK01_GET
    @pMa_cty VARCHAR(50),
    @pMonth INT,
    @pYear INT,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_Nt VARCHAR(10) = 'VND',
    @pIsVND BIT = 1
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Range 1-12 | month | 'Thang phai tu 1 den 12' |
| Positive | year | 'Nam phai lon hon 0' |

### Business Rules

1. **Mac dinh**: Thang/nam hien tai
2. **Loai tien**: Chon hien thi VND hoac ngoai te
3. **Loc theo thang/nam**: Hien thi chung tu trong thang

---

## Mapping PHP

### 1. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/Bangkechungtutonkho.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class Bangkechungtutonkho extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'BK01';

    public int $pMonth;
    public int $pYear;
    public ?string $pMa_vt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_nt = 'VND';
    public bool $pIsVND = true;

    public function mount(): void
    {
        $this->pMonth = (int) now()->format('m');
        $this->pYear = (int) now()->format('Y');
    }

    public function render(): View
    {
        return view('catalog::in.reports.bang-ke-chung-tu-ton-kho');
    }
}
```

### 2. Views

```
resources/views/catalog/in/reports/
└── bang-ke-chung-tu-ton-kho.blade.php
```

### 3. Routes

```php
Route::get('/bang-ke-chung-tu-ton-kho', [Bangkechungtutonkho::class, 'render'])
    ->name('catalog.in.reports.bang-ke-chung-tu');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | Bangkechungtutonkho.php | Report viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_BK01_GET
- [ ] Tao Livewire Bangkechungtutonkho
- [ ] Tao View bang-ke-chung-tu-ton-kho.blade.php
- [ ] Them Routes
- [ ] Test loc theo thang/nam
- [ ] Test chon VND/Ngoai te
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE — component `In\Rpt\Inrptbk01` + route `in.rpt.inrptbk01`, verify browser 2026-11-25 (component render thật)
- **Route:** `in.rpt.inrptbk01`
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `In\Rpt\Inrptbk01` (kế thừa `Rpt\AbstractReport`)
- **View:** `in/rpt/inrptbk01.blade.php` + filter `in/rpt/filters/inrptbk01.blade.php`
- **Route:** `in.rpt.inrptbk01` (1 menu duy nhất → không suffix)
- **SP:** `asINRptBK01` qua wrapper `AsINRptBK01` (5 tham số)
- **Menu:** `14.20.26` — "Thông tin tính giá NTXT / Bảng kê chứng từ tồn kho"

### 🐛 BUG WRAPPER đã sửa: tham số trùng tên khác hoa thường

Wrapper `AsINRptBK01` cũ gửi **6 tham số** trong đó có cả:

```php
'pma_cty' => ...,   // theo docs
'pMa_cty' => ...,   // ← TRÙNG, khác hoa thường
```

SQL Server coi `pma_cty` và `pMa_cty` là **2 tham số khác nhau** → báo:

```
SQLSTATE[42000]: Procedure or function asINRptBK01 has too many arguments specified
```

**Triệu chứng:** năm hiện tại (2026) không lỗi nhưng đổi sang 2025/2024/2010 thì lỗi
(khác nhau ở đường cache/param binding của SQLSRV).

**Fix:** bỏ dòng `'pMa_cty'` trùng, giữ `'pma_cty'` theo `procedures.md`.

→ Sau fix: submit không lỗi với **mọi năm** (2026, 2025, 2024, 2010).

### Verify browser thật — component render

| Kiểm chứng | Kết quả |
|---|---|
| `/simba/in/rpt/inrptbk01` | **HTTP 200** |
| **Livewire component** | ✅ `catalog::in.rpt.inrptbk01` **render thật** |
| Sub-component | ✅ `catalog::component.input-indmvt`, `input-indmkho` |
| Tab + nút "Thực hiện" | ✅ có |
| Submit năm 2026/2025/2024/2010 | ✅ **không lỗi** (sau fix wrapper) |
| Số dòng | 0 — công ty 001 không có dữ liệu tồn kho kỳ này |
| Page error | **0** |
