# Task 301: GLRptBCTCCR04

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bao cao Luu chuyen tien te - Phuong phap truc tiep (BCTCCR04) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCTCCR04.dll
- **Assembly Title:** Bao cao luu chuyen tien te theo phuong phap truc tiep
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| GLMauCF01 | Mau bao cao CF | Chua cong thuc tinh luu chuyen tien te |
| DMTK | Danh muc tai khoan | Drilldown theo tk_no, tk_co |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| FinancialYear | Nam tai chinh |
| ngay1, ngay2 | Ngay ky hien tai |
| ngay01, ngay02 | Ngay ky truoc |
| ma_nt | Ma ngoai te |
| ma_mau | Ma mau bao cao |

---

## Form classes

### 1. frmGLRptBCTCCR04
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao Lưu chuyển tiền tệ (Direct Method)

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cmdCF | Button | Mo form KB Cong thuc (frmGLMauCF01) |
| cboKyBc | ComboBox | Chon ky bao cao |
| cboKyTruoc | ComboBox | Chon ky truoc de so sanh |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay ky hien tai |
| txtNgay01, txtNgay02 | AsMaskedTextBox | Ngay ky truoc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te |

### 2. frmGLMauCF01
- **Ke thua:** frmDMView
- **Chuc nang:** Quan ly mau cash flow

### 3. frmGLMauCF01Edit
- **Ke thua:** frmDMEdit
- **Chuc nang:** Sua mau cash flow

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCTCCR04_GET | Lay du lieu LCTT (Direct) |
| SP_GL_MAUCF01_GET | Lay danh sach mau CF |
| SP_GL_MAUCF01_GETBYID | Lay chi tiet mau CF |
| SP_GL_MAUCF01_INSERT | Them mau CF |
| SP_GL_MAUCF01_UPDATE | Cap nhat mau CF |
| SP_GL_MAUCF01_DELETE | Xoa mau CF |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ky_bc | 'Chon ky bao cao' |

### Business Rules

1. **Phuong phap truc tiep**: Theo doi truc tiep cac khoan thu/chi tien mat
2. **So sanh ky**: Ky hien tai vs ky truoc
3. **Drill-down**:
   - F5: Chi tiet cong thuc / So chu T
   - Drilldown theo tk_no, tk_co
4. **Quan ly mau CF**: Tich hop frmGLMauCF01

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTCCR04Service.php
namespace Diepxuan\Simba\Services\GL;

class BCTCCR04Service
{
    public function getReport(array $params): array;
    public function getMauCF(): Collection;
}
```

### 2. Livewire Components

```php
// Bao cao LCTT
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctccr04.php

// Quan ly mau CF
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Quanlymau/MauCF01.php
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTCCR04Service.php | Chinh |
| Model | laravel-simba | GLMauCF01.php | Mau LCTT |
| Component | laravel-catalog | Bctccr04.php | BC chinh |
| Component | laravel-catalog | MauCF01.php | Quan ly mau |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao LCTT
- [ ] Test quan ly mau CF
- [ ] Test drill-down
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
