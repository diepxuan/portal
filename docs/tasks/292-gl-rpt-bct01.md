# Task 292: GLRptBCT01

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCT01 (Bang can doi phat sinh) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCT01.dll
- **Assembly Title:** Bang can doi phat sinh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Form classes

### 1. frmGLRptBCT01
- **Ke thua:** frmReport
- **Loai:** Bao cao Drilldown

---

## Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan |
| txtBac | AsTextNumeric | Bac tai khoan (default = 9) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCT01_GET | Lay du lieu BCT01 |
| SP_GL_RPT_BCT01_DRILL | Lay chi tiet drilldown |

---

## Business Logic

1. **Tai khoan:** Nhap tai khoan can xem
2. **Bac:** So bac hien thi (default = 9 hien thi tat ca)
3. **Drilldown:** Click vao tai khoan de xem chi tiet

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCT01ReportService.php
namespace Diepxuan\Simba\Services\GL;

class BCT01ReportService
{
    public function getReport(string $tk, int $bac = 9): array;
    public function getDrilldown(string $tk, int $nam, int $ky): array;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCT01ReportService.php | Chinh |

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

- **Status:** DONE — component `Gl\Rpt\Glrptbct01` + route `gl.rpt.glrptbct01`, verify browser 2026-11-25
- **Route:** `gl.rpt.glrptbct01`
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `Diepxuan\Catalog\Http\Livewire\Gl\Rpt\Glrptbct01` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptbct01.blade.php` + filter `gl/rpt/filters/glrptbct01.blade.php`
- **Route:** `gl.rpt.glrptbct01` (auto-registration)
- **SP:** `asGLRptBCT01` qua wrapper `AsGLRptBCT01` (**8 tham số** khớp docs)
- **Menu:** `02.40.02` — "Bảng kê hoá đơn, chứng từ HHDV mua vào"

### Đối chiếu form gốc `frmGLRptBCT01.LoadData()`

| Tham số SP | Nguồn từ form gốc |
|---|---|
| `pMa_cty` | `CompanyInformations.CompanyID` |
| `pNgay1` / `pNgay2` | `txtNgay1.Value` / `txtNgay2.Value` |
| `pThue_suat` | `txtThue_suat.Value` |
| `pTk_thue` | `txtTk.Text` ("Tài khoản thuế") |
| `pTk_du` | `txtTk_Du.Text` ("Tài khoản đ/ư") |
| `pMa_bp` | `txtMa_Bp.Text` ("Mã bộ phận") |
| `pMau_bc` | `cboMau_bc.SelectedIndex` |

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| `/simba/gl/rpt/glrptbct01` | **HTTP 200**, title "Bảng kê hoá đơn, chứng từ HHDV mua vào [SimbaERP]" |
| Số field lọc | **6** |
| Bấm "Thực hiện" | SP gọi **thành công**, không `errorMessage` |
| Số dòng | **0** — công ty 001 không có dữ liệu kế toán |
| Page error | **0** |

> Component **63 dòng** nhờ `AbstractReport`.
