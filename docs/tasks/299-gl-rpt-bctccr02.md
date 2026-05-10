# Task 299: GLRptBCTCCR02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bao cao Bang can doi ke toan (BCTCCR02) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCTCCR02.dll
- **Assembly Title:** Bang can doi ke toan
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| GLMauBS01 | Mau bang can doi | Chua cong thuc tinh cac chi tieu |
| DMTK | Danh muc tai khoan | Drilldown theo tk |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| FinancialYear | Nam tai chinh |
| ngay_bc | Ngay lap bao cao (txtNgay2) |
| chi_tieu_co_solieu | Chi hien thi chi tieu co so lieu |
| ma_mau | Ma mau bao cao |

---

## Form classes

### 1. frmGLRptBCTCCR02
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao Bang can doi ke toan

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cmdBS | Button | Mo form KB Cong thuc (frmGLMauBS01) |
| chkChiTieuCoSoLieu | CheckBox | Chi hien thi chi tieu co so lieu |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te |

### 2. frmGLMauBS01
- **Ke thua:** frmDMView
- **Chuc nang:** Quan ly mau Bang can doi

### 3. frmGLMauBS01Edit
- **Ke thua:** frmDMEdit
- **Chuc nang:** Sua mau Bang can doi

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCTCCR02_GET | Lay du lieu Bang can doi ke toan |
| SP_GL_MAUBS01_GET | Lay danh sach mau BS |
| SP_GL_MAUBS01_GETBYID | Lay chi tiet mau BS |
| SP_GL_MAUBS01_INSERT | Them mau BS |
| SP_GL_MAUBS01_UPDATE | Cap nhat mau BS |
| SP_GL_MAUBS01_DELETE | Xoa mau BS |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ky_bc | 'Chon ky bao cao' |
| Optional | chi_tieu_co_solieu | Loc chi tieu co so lieu |

### Business Rules

1. **Quan ly mau BC**: Tich hop form frmGLMauBS01 de khai bao cong thuc
2. **Cong thuc tinh**: Moi chi tieu co the tinh theo SD TK hoac cong thuc
3. **Drill-down**:
   - F5: Chi tiet cong thuc / So chu T
   - Ctrl+F5: So chi tiet
   - Shift+F5: Can doi PS cong no
4. **So sanh ky**: Hien thi so sanh voi ky truoc (neu co)

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTCBN02Service.php
namespace Diepxuan\Simba\Services\GL;

class BCTCBN02Service
{
    public function getReport(array $params): array;
    public function getMauBS(): Collection;
}
```

### 2. Livewire Components

```php
// Bang can doi
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctccr02.php

// Quan ly mau
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Quanlymau/MauBS01.php
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bctccr02.blade.php
└── _bctccr02-form.blade.php

resources/views/catalog/gl/quanlymau/
├── mau-bs01-list.blade.php
└── mau-bs01-edit.blade.php
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTCBN02Service.php | Chinh |
| Model | laravel-simba | GLMauBS01.php | Mau BC |
| Component | laravel-catalog | Bctccr02.php | BC chinh |
| Component | laravel-catalog | MauBS01.php | Quan ly mau |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao BCTC
- [ ] Test quan ly mau (frmGLMauBS01)
- [ ] Test drill-down
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
