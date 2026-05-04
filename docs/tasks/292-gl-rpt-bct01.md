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