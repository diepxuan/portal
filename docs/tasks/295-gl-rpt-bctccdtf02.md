# Task 295: GLRptBCTCCDTF02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCTCCDTF02 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCTCCDTF02.dll
- **Assembly Title:** Bao cao tai chinh tong hop
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Form classes

### 1. frmGLRptBCTCCDTF02
- **Ke thua:** frmReport

---

## Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau | ComboBox | Mau bao cao |
| cboNam | ComboBox | Nam bao cao |
| cboKy | ComboBox | Ky bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CCDTF02_GET | Lay du lieu CCDTF02 |

---

## Business Logic

1. **Mau:** Chon mau bao cao
2. **Nam/Ky:** Thoi gian bao cao

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/CCDTF02ReportService.php
namespace Diepxuan\Simba\Services\GL;

class CCDTF02ReportService
{
    public function getReport(string $mau, int $nam, int $ky): array;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | CCDTF02ReportService.php | Chinh |

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
