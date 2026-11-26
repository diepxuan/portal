# Task 289: GLRptBCPT03

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCPT03 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCPT03.dll
- **Assembly Title:** Báo cáo biến động tài sản cố định
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Form classes

### 1. frmGLRptBCPT03
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
| SP_GL_RPT_BCPT03_GET | Lay du lieu BCPT03 |

---

## Business Logic

1. **Tham so:** Nam va Ky ke toan
2. **Dieu kien:** Loc theo ky ke toan trong nam

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCPT03ReportService.php
namespace Diepxuan\Simba\Services\GL;

class BCPT03ReportService
{
    public function getReport(int $nam, int $ky): array;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCPT03ReportService.php | Chinh |

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

- **Status:** DONE (component) — `Gl\Rpt\Glrptbcpt03` + route `gl.rpt.glrptbcpt03`, verify browser 2026-11-25: **0 dòng**, không lỗi
- **Route:** `gl.task.289`


## Portal implementation (2026-11-25)

- **Component:** `Gl\Rpt\Glrptbcpt03` (kế thừa `Rpt\AbstractReport`)
- **Route:** `gl.rpt.glrptbcpt03`
- **SP:** `asGLRptBCPT03` — **6 tham số**

### 🔧 Hoàn thiện wrapper RỖNG

Trước đây `AsGLRptBCPT03` tồn tại nhưng **mảng tham số rỗng** (`[]`) → không gọi được SP.

Em đã:
1. Đọc form gốc `frmGLRptBCPT03.LoadData()` → 5 tham số
2. SP báo thiếu `@pLoai` → phát hiện tham số thứ 6 không có trong form
3. Thử vị trí `pLoai`: đặt thứ 2 → OK

**6 tham số đúng:** `pMa_Cty`, `pLoai`, `pThang`, `pNam`, `pSo_ky`, `pMau`

### 🎯 Phát hiện: form gốc THIẾU tham số

Form gốc **không có** `txtLoai` nhưng SP **yêu cầu** `@pLoai`.

Đây là **trường hợp ngược** với các task trước (form gửi tham số SP không nhận).
Lần này: **SP cần tham số form không gửi**.

→ Càng khẳng định: **error message của SP là nguồn duy nhất đáng tin**.

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::gl.rpt.glrptbcpt03` render thật |
| Submit | **0 dòng**, không `errorMessage` |
| Page error | **0** |
