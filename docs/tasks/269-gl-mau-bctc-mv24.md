# Task 269: GLMAUBCTCTMV24

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh V24 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMV24.dll
- **Assembly Title:** GLBCTC07V24
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMV24 (Chi tieu mau BCTC V24)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| loai_ps_dk | varchar | 20 | Loai du dau ky |
| loai_ps_ck | varchar | 20 | Loai du cuoi ky |
| tk_01 | varchar | 20 | Tai khoan |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

### Loai du (loai_ps_dk / loai_ps_ck)

| Gia tri | Y nghia |
|---------|---------|
| NODK | Du no |
| CODK | Du co |

---

## Form classes

### 1. frmGLMAUBCTCTMV24 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMV24Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung |
| txtCach_tinh | TextBox | cach_tinh | Cach tinh |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (lookup TK) |
| lblTK | Label | - | Hien thi ten TK |
| cboLoai_ps_dk | AsComboBox | loai_ps_dk | Loai du dau ky |
| cboLoai_ps_ck | AsComboBox | loai_ps_ck | Loai du cuoi ky |
| txtMauQD | TextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MV24_GET | Lay danh sach chi tieu V24 |
| SP_GL_BCTC_MV24_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MV24_INSERT | Them chi tieu V24 |
| SP_GL_BCTC_MV24_UPDATE | Cap nhat chi tieu V24 |
| SP_GL_BCTC_MV24_DELETE | Xoa chi tieu V24 |

---

## Business Logic

1. **Loai du:** Chi NODK/CODK (2 gia tri, khong ho tro cong no)
2. **Tai khoan:** Lookup tu DMTK
3. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
4. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMV24.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMV24 extends Model
{
    protected $table = 'BCTCCTMV24';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'cach_tinh', 'loai_ps_dk', 'loai_ps_ck', 'tk_01', 'IsPrint', 'IsItalic', 'bold'];
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMV24.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMV24
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
