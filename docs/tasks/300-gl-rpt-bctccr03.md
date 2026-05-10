# Task 300: GLRptBCTCCR03

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bao cao Ket qua hoat dong kinh doanh (BCTCCR03) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCTCCR03.dll
- **Assembly Title:** Bao cao ket qua hoat dong kinh doanh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| GLMauPL01 | Mau bao cao PL | Chua cong thuc tinh chi tieu |
| DMTK | Danh muc tai khoan | Drilldown theo tk_no, tk_co |
| DMBP | Danh muc bo phan | Loc theo ma_bp |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| FinancialYear | Nam tai chinh |
| ngay1, ngay2 | Ngay ky hien tai |
| ngay01, ngay02 | Ngay ky truoc |
| ma_bp | Ma bo phan |
| ma_nt | Ma ngoai te |
| ma_mau | Ma mau bao cao |

---

## Form classes

### 1. frmGLRptBCTCCR03
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao Ket qua hoat dong kinh doanh

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cmdPL | Button | Mo form KB Cong thuc (frmGLMauPL01) |
| cboKyBc | ComboBox | Chon ky bao cao hien tai |
| cboKyTruoc | ComboBox | Chon ky bao cao truoc de so sanh |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay ky hien tai |
| txtNgay01, txtNgay02 | AsMaskedTextBox | Ngay ky truoc |
| txtMa_Bp | AsTextBox | Ma bo phan |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| optVND, optNt | RadioButton | Tuy chon tien te |

### 2. frmGLMauPL01
- **Ke thua:** frmDMView
- **Chuc nang:** Quan ly mau phu luc 01 (cong thuc PL)

### 3. frmGLMauPL01Edit
- **Ke thua:** frmDMEdit
- **Chuc nang:** Sua mau phu luc 01

### Controls (frmGLMauPL01Edit)

| Control | Type | Mo ta |
|---------|------|-------|
| txtStt | TextBox | So thu tu |
| txtMa_so | TextBox | Ma so chi tieu |
| txtChi_tieu | TextBox | Ten chi tieu |
| txtTm | TextBox | Thuyet minh |
| chkIn_ck | AsCheckBox | In/Khong in |
| chkBold | AsCheckBox | Dam/Khong dam |
| chkCach_tinh | AsCheckBox | Tinh theo SD TK / Tinh theo cong thuc |
| txtDsTk_no | AsTextBox | Danh sach TK no |
| txtDsTK_co | AsTextBox | Danh sach TK co |
| chkgiam_tru | AsCheckBox | Tinh/Khong tinh giam tru |
| txtCach_tinh | TextBox | Cong thuc tinh |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCTCCR03_GET | Lay du lieu KQ HDKD |
| SP_GL_MAUPL01_GET | Lay danh sach mau PL |
| SP_GL_MAUPL01_GETBYID | Lay chi tiet mau PL |
| SP_GL_MAUPL01_INSERT | Them mau PL |
| SP_GL_MAUPL01_UPDATE | Cap nhat mau PL |
| SP_GL_MAUPL01_DELETE | Xoa mau PL |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ky_bc | 'Chon ky bao cao' |
| Required | cboKyTruoc | 'Chon ky truoc de so sanh' |

### Business Rules

1. **Hai che do tinh toan**:
   - Tinh theo SD TK: Nhap DSTK no/co, tinh so du
   - Tinh theo cong thuc: Cong/tru cac chi tieu khac
2. **So sanh ky**: Hien thi so sanh ky hien tai vs ky truoc
3. **Drill-down**:
   - F5: Chi tiet cong thuc / So chu T
   - Drilldown theo tk_no, tk_co
4. **Quan ly mau**: Tich hop frmGLMauPL01

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTCCR03Service.php
namespace Diepxuan\Simba\Services\GL;

class BCTCCR03Service
{
    public function getReport(array $params): array;
    public function getMauPL(): Collection;
}
```

### 2. Livewire Components

```php
// Bao cao KQ HDKD
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctccr03.php

// Quan ly mau PL
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Quanlymau/MauPL01.php
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTCCR03Service.php | Chinh |
| Model | laravel-simba | GLMauPL01.php | Mau KQ HDKD |
| Component | laravel-catalog | Bctccr03.php | BC chinh |
| Component | laravel-catalog | MauPL01.php | Quan ly mau |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao KQ HDKD
- [ ] Test quan ly mau PL
- [ ] Test drill-down
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
