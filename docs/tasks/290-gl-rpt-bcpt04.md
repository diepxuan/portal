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

- **Status:** DONE (GL route/report shell)
- **Route:** `gl.task.290`
