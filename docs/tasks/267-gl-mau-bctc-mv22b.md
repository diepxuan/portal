# Task 267: GLMAUBCTCTMV22b

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh V22b tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMV22b.dll
- **Assembly Title:** GLBCTC07V22b
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMV22b (Chi tieu mau BCTC V22b)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| loai_ps_dk | varchar | 20 | Loai PS dau ky |
| loai_ps_ck | varchar | 20 | Loai PS cuoi ky |
| tk_01 | varchar | 20 | Tai khoan |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

### Loai phat sinh dau ky (loai_ps_dk)

| Gia tri | Y nghia |
|---------|---------|
| NODK | Du no dau ky |
| CODK | Du co dau ky |
| NODKCN | Du no dau ky cong no |
| CODKCN | Du co dau ky cong no |

### Loai phat sinh cuoi ky (loai_ps_ck)

| Gia tri | Y nghia |
|---------|---------|
| NOCK | Du no cuoi ky |
| COCK | Du co cuoi ky |
| NOCKCN | Du no cuoi ky cong no |
| COCKCN | Du co cuoi ky cong no |

---

## Form classes

### 1. frmGLMAUBCTCTMV22b (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMV22bEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung |
| txtCach_tinh | TextBox | cach_tinh | Cach tinh |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (lookup TK) |
| cboLoai_ps_dk | AsComboBox | loai_ps_dk | Loai PS dau ky |
| cboLoai_ps_ck | AsComboBox | loai_ps_ck | Loai PS cuoi ky |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MV22B_GET | Lay danh sach chi tieu V22b |
| SP_GL_BCTC_MV22B_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MV22B_INSERT | Them chi tieu V22b |
| SP_GL_BCTC_MV22B_UPDATE | Cap nhat chi tieu V22b |
| SP_GL_BCTC_MV22B_DELETE | Xoa chi tieu V22b |

---

## Business Logic

1. **Loai PS dau/cuoi ky:** Moi truong co 4 gia tri, ho tro cong no
2. **Tai khoan:** 1 tai khoan, Lookup tu DMTK
3. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
4. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMV22b.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMV22b extends Model
{
    protected $table = 'BCTCCTMV22b';
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
| Model | laravel-simba | BCTCCTMV22b.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMV22b
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations