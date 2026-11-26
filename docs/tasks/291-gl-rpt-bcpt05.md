# Task 291: GLRptBCPT05

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCPT05 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCPT05.dll
- **Assembly Title:** Báo cáo biến động tài sản cố định
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Form classes

### 1. frmGLRptBCPT05
- **Ke thua:** frmReport
- **Loai:** Bao cao BCTC (Drilldown)

---

## Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboNam | ComboBox | Nam bao cao |
| cboKy | ComboBox | Ky ke toan |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCPT05_GET | Lay du lieu BCPT05 |

---

## Business Logic

1. **Tham so:** Nam va Ky ke toan
2. **Dieu kien:** Loc theo ky ke toan trong nam

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCPT05ReportService.php
namespace Diepxuan\Simba\Services\GL;

class BCPT05ReportService
{
    public function getReport(int $nam, int $ky): array;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCPT05ReportService.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test report generation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE — component `Gl\Rpt\Glrptbcpt05` + route `gl.rpt.glrptbcpt05`, verify browser 2026-11-25
- **Route:** `gl.rpt.glrptbcpt05`

## Portal implementation (2026-11-25)

- **Component:** `Diepxuan\Catalog\Http\Livewire\Gl\Rpt\Glrptbcpt05` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptbcpt05.blade.php` + filter `gl/rpt/filters/glrptbcpt05.blade.php`
- **Route:** `gl.rpt.glrptbcpt05` (auto-registration)
- **SP:** `asGLRptBCPT05` qua wrapper `AsGLRptBCPT05` (**12 tham số** khớp docs)
- **Menu:** `02.60.14` — "So sánh tình hình thực hiện ngân sách"

### Đối chiếu form gốc `frmGLRptBCPT05.LoadData()`

| Tham số SP | Nguồn từ form gốc |
|---|---|
| `pMa_cty` | `CompanyInformations.CompanyID` |
| `pNam` | `DateAndTime.Year(txtNgay1.Value)` — **năm lấy từ ngày bắt đầu** |
| `pTK` | `txtTk.Text` |
| `pMa_phi` | `txtMa_phi.Text` |
| `pMa_BP` | `txtMa_bp.Text` |
| `pMa_spct` | `txtMa_spct.Text` |
| `pNgay1` / `pNgay2` | `txtNgay1.Value` / `txtNgay2.Value` |
| `pGroup1..pGroup4` | 4 combo nhóm cấp (`cboNhom_cap1..4` → `.SelectedItem.Key`) |

### Combo nhóm cấp — đúng `DataSource4CBO` gốc

| Key | Nhãn |
|---|---|
| `''` | Tất cả |
| `TK` | Tài khoản |
| `ma_bo` | Mã bộ phận |
| `ma_phi` | Mã phí |
| `ma_spct` | Mã sản phẩm công trình |

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| `/simba/gl/rpt/glrptbcpt05` | **HTTP 200**, title "So sánh tình hình thực hiện ngân sách [SimbaERP]" |
| Số field lọc | **10** (2 ngày + 4 mã + 4 nhóm cấp) |
| Combo nhóm cấp | 5 option **khớp form gốc** |
| Bấm "Thực hiện" | SP gọi **thành công**, không `errorMessage` |
| Số dòng | **0** — công ty 001 không có dữ liệu kế toán |

> Component **85 dòng** nhờ `AbstractReport`.
