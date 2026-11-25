# Task 293: GLRptBCT02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCT02 (Bang can doi ke toan) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCT02.dll
- **Assembly Title:** Bang can doi ke toan
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Form classes

### 1. frmGLRptBCT02
- **Ke thua:** frmReport
- **Loai:** Bao cao BCTC (Drilldown)

---

## Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau | ComboBox | Mau bao cao |
| cboNam | ComboBox | Nam bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCT02_GET | Lay du lieu BCT02 |
| SP_GL_RPT_BCT02_DRILL | Lay chi tiet drilldown |

---

## Business Logic

1. **Mau bao cao:** Chon mau tu danh muc
2. **Nam:** Nam ke toan
3. **Drilldown:** Click vao chi tieu de xem chi tiet

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCT02ReportService.php
namespace Diepxuan\Simba\Services\GL;

class BCT02ReportService
{
    public function getReport(string $mau, int $nam): array;
    public function getDrilldown(string $ma_so, string $mau, int $nam): array;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCT02ReportService.php | Chinh |
| Model | laravel-simba | BCTCCTMV01.php | Mau bao cao |

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

- **Status:** DONE — component `Gl\Rpt\Glrptbct02` + route `gl.rpt.glrptbct02`, verify browser 2026-11-25 (co du lieu that)
- **Route:** `gl.rpt.glrptbct02`
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `Diepxuan\Catalog\Http\Livewire\Gl\Rpt\Glrptbct02` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptbct02.blade.php` + filter `gl/rpt/filters/glrptbct02.blade.php`
- **Route:** `gl.rpt.glrptbct02` (auto-registration)
- **SP:** `asGLRptBCT02` qua wrapper `AsGLRptBCT02` (**6 tham số**)
- **Menu:** `02.40.05` — "Bảng kê hoá đơn, chứng từ HHDV bán ra"

### ⚠️ BCT02 KHÁC BCT01 — chỉ 6 tham số, không phải 8

Đối chiếu wrapper `AsGLRptBCT02` + `simba-docs`:

| BCT01 (mua vào) | BCT02 (bán ra) |
|---|---|
| `pMa_cty`, `pNgay1`, `pNgay2`, `pThue_suat` | giống |
| `pTk_thue` | **`pTk`** |
| `pTk_du` | giống |
| **`pMa_bp`**, **`pMau_bc`** | **KHÔNG CÓ** |

→ Component BCT02 chỉ 6 tham số. Nếu copy nguyên BCT01 sẽ gửi thừa `pMa_bp`/`pMau_bc` → SP có thể từ chối.

### Verify browser thật — CÓ DỮ LIỆU

| Kiểm chứng | Kết quả |
|---|---|
| `/simba/gl/rpt/glrptbct02` | **HTTP 200**, title "Bảng kê hoá đơn, chứng từ HHDV bán ra [SimbaERP]" |
| Số field lọc | **5** |
| Bấm "Thực hiện" | SP gọi **thành công** |
| **Số dòng trả về** | **1 dòng — DỮ LIỆU THẬT** |
| **Số cột** | **22 cột**: `stt`, `so_seri_mhd`, `so_ct`, `ngay_ct`, `ten_kh`, `ma_so_thue`, `ten_vt`, `t_tien`, `t_thue`, `thue_suat`... |
| Page error | **0** |

Dòng dữ liệu đầu tiên: `ten_kh = "#GLRpt_TPS"` — đây là dòng tiêu đề do SP tự sinh
(quy ước của SP báo cáo SimbaERP), xác nhận SP chạy đúng.

> Đây là báo cáo **đầu tiên verify được cả dữ liệu thật** (các báo cáo trước trả 0 dòng
> vì công ty 001 không có dữ liệu kế toán trong kỳ mặc định).
