# Task 290: GLRptBCPT04

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCPT04 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCPT04.dll
- **Assembly Title:** Báo cáo biến động tài sản cố định
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Form classes

### 1. frmGLRptBCPT04
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
| SP_GL_RPT_BCPT04_GET | Lay du lieu BCPT04 |

---

## Business Logic

1. **Tham so:** Nam va Ky ke toan
2. **Dieu kien:** Loc theo ky ke toan trong nam

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCPT04ReportService.php
namespace Diepxuan\Simba\Services\GL;

class BCPT04ReportService
{
    public function getReport(int $nam, int $ky): array;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCPT04ReportService.php | Chinh |

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

- **Status:** DONE — component `Gl\Rpt\Glrptbcpt04` + route `gl.rpt.glrptbcpt04`, verify browser 2026-11-25
- **Route:** `gl.rpt.glrptbcpt04`

## Portal implementation (2026-11-25)

- **Component:** `Diepxuan\Catalog\Http\Livewire\Gl\Rpt\Glrptbcpt04` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptbcpt04.blade.php` + filter `gl/rpt/filters/glrptbcpt04.blade.php`
- **Route:** `gl.rpt.glrptbcpt04` (auto-registration theo convention)
- **SP:** `asGLRptBCPT04` qua wrapper `AsGLRptBCPT04` (**7 tham số** khớp docs)
- **Menu:** `02.60.11` — "Kết quả hoạt động kinh doanh theo kỳ"

### Đối chiếu form gốc `frmGLRptBCPT04.LoadData()`

| Tham số SP | Nguồn từ form gốc |
|---|---|
| `pMa_Cty` | `CompanyInformations.CompanyID` |
| `pNam` | `SystemInformations.FinancialYear` (năm tài chính) |
| `pThang1` | `Conversions.ToInteger(cboThang1.Text)` |
| `pThang2` | `Conversions.ToInteger(cboThang2.Text)` |
| `pQuyThang` | `cboQuy_Thang.SelectedIndex + 1` → **1 = Theo quý, 2 = Theo tháng** |
| `pMau` | `MyReportInfo.ma_mau` (mẫu báo cáo) |
| `pMa_bp` | `txtMa_bp.Text` |

Nhãn UI lấy từ `lbl*.Text`: "Kỳ này", "Từ tháng", "đến tháng", "Mã bộ phận".

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| `/simba/gl/rpt/glrptbcpt04` | **HTTP 200**, title "Kết quả hoạt động kinh doanh theo kỳ [SimbaERP]" |
| Số field lọc | **5** (Năm, Từ tháng, Đến tháng, Kỳ báo cáo, Mã bộ phận) |
| Combo "Kỳ báo cáo" | 2 option **khớp form gốc**: Theo quý / Theo tháng |
| Bấm "Thực hiện" | SP gọi **thành công**, không `errorMessage` |
| Số dòng | **0** — công ty 001 không có dữ liệu kế toán |

> Component chỉ **59 dòng** nhờ kế thừa `AbstractReport` (so với ~250 dòng nếu viết độc lập).
