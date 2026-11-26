# Task 288: GLRptBCPT02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCPT02 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCPT02.dll
- **Assembly Title:** Báo cáo biến động tài sản cố định
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Form classes

### 1. frmGLRptBCPT02
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
| SP_GL_RPT_BCPT02_GET | Lay du lieu BCPT02 |

---

## Business Logic

1. **Tham so:** Nam va Ky ke toan
2. **Dieu kien:** Loc theo ky ke toan trong nam

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCPT02ReportService.php
namespace Diepxuan\Simba\Services\GL;

class BCPT02ReportService
{
    public function getReport(int $nam, int $ky): array;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCPT02ReportService.php | Chinh |

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

- **Status:** DONE — component `Gl\Rpt\Glrptbcpt02` + route `gl.rpt.glrptbcpt02`, verify browser 2026-11-25
- **Route:** `gl.rpt.glrptbcpt02`

## Portal implementation (2026-11-25)

- **Component:** `Gl\Rpt\Glrptbcpt02` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptbcpt02.blade.php` + filter `gl/rpt/filters/glrptbcpt02.blade.php`
- **Route:** `gl.rpt.glrptbcpt02` (auto-registration)
- **SP:** `asGLRptBCPT02` qua wrapper `AsGLRptBCPT02`
- **Menu:** `02.60.05` — "Bảng cân đối phát sinh một TK theo ngày"

### ⚠️ procedures.md ghi SP "Không có tham số" — SAI

`simba-docs/procedures/GL/procedures.md` mục `asGLRptBCPT02` ghi:

> | *Không có* | - | - | - |

Nhưng **form gốc + wrapper đều có 5 tham số**. Em lấy từ `frmGLRptBCPT02.LoadData()`:

| Tham số SP | Nguồn từ form gốc |
|---|---|
| `pMa_Cty` | `CompanyInformations.CompanyID` |
| `pTk` | `txtTk.Text` |
| `pNgay1` / `pNgay2` | `txtNgay1/2.Value` |
| `pMa_Nt` | `txtMa_Nt.Text` |

→ **Bài học:** `procedures.md` có thể ghi thiếu/sai. Form gốc decompiled là nguồn đáng tin hơn khi docs mâu thuẫn.

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| `/simba/gl/rpt/glrptbcpt02` | **HTTP 200**, title "Bảng cân đối phát sinh một TK theo ngày [SimbaERP]" |
| Số field lọc | **4** |
| Bấm "Thực hiện" | SP gọi **thành công**, không `errorMessage` (kể cả kỳ rộng 2010-2026, TK 1111) |
| Số dòng | **0** |
| Page error | **0** |
