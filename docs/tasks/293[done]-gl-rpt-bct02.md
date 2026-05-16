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

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
