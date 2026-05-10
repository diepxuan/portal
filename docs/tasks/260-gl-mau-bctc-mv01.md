# Task 260: GLMAUBCTCTMV01

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh V01 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMV01.dll
- **Assembly Title:** GLBCTC07V01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMV01 (Chi tieu mau BCTC V01)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| tk_01 | varchar | 20 | Tai khoan 1 |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

---

## Form classes

### 1. frmGLMAUBCTCTMV01 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMV01Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu (lookup TK) |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu |
| txtCong_thuc | TextBox | cach_tinh | Cong thuc tinh |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (lookup TK) |
| lblTK | Label | - | Hien thi ten TK |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MV01_GET | Lay danh sach chi tieu V01 |
| SP_GL_BCTC_MV01_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MV01_INSERT | Them chi tieu V01 |
| SP_GL_BCTC_MV01_UPDATE | Cap nhat chi tieu V01 |
| SP_GL_BCTC_MV01_DELETE | Xoa chi tieu V01 |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_so | 'Ma chi tieu khong duoc trong' |
| Required | chi_tieu | 'Ten chi tieu khong duoc trong' |

### Business Rules

1. **Tai khoan:** Lookup tu bang DMTK (LookupCodeName = "TK")
2. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
3. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMV01.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMV01 extends Model
{
    protected $table = 'BCTCCTMV01';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'cach_tinh', 'tk_01', 'IsPrint', 'IsItalic', 'bold'];
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

### 2. Views

```
resources/views/catalog/gl/baocaotc/
├── mau-bctc-mv01.blade.php
└── mau-bctc-mv01-edit.blade.php
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMV01.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMV01
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
