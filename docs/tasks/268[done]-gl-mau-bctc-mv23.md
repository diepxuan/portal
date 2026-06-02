# Task 268: GLMAUBCTCTMV23

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh V23 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMV23.dll
- **Assembly Title:** GLBCTC07V23
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMV23 (Chi tieu mau BCTC V23)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| tk_01 | varchar | 20 | Tai khoan |
| loai_ps | varchar | 20 | Loai phat sinh |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

### Loai phat sinh

| Gia tri | Y nghia |
|---------|---------|
| NODK | Du no dau ky |
| CODK | Du co dau ky |
| NOCK | Du no cuoi ky |
| COCK | Du co cuoi ky |
| PSNO | Phat sinh no |
| PSCO | Phat sinh co |

---

## Form classes

### 1. frmGLMAUBCTCTMV23 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMV23Edit (Form them/sua)
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
| cboLoai_ps | AsComboBox | loai_ps | Loai phat sinh |
| txtMauQD | TextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MV23_GET | Lay danh sach chi tieu V23 |
| SP_GL_BCTC_MV23_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MV23_INSERT | Them chi tieu V23 |
| SP_GL_BCTC_MV23_UPDATE | Cap nhat chi tieu V23 |
| SP_GL_BCTC_MV23_DELETE | Xoa chi tieu V23 |

---

## Business Logic

1. **Loai PS:** ComboBox voi 6 gia tri
2. **Tai khoan:** Lookup tu DMTK (LookupCodeName = "TK")
3. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
4. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMV23.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMV23 extends Model
{
    protected $table = 'BCTCCTMV23';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'cach_tinh', 'tk_01', 'loai_ps', 'IsPrint', 'IsItalic', 'bold'];
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMV23.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMV23
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (GL route/report shell)
- **Route:** `gl.task.268`
