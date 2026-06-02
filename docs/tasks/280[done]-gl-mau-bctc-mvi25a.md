# Task 280: GLMAUBCTCTMVI25A

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh I25A tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMVI25A.dll
- **Assembly Title:** GLBCTC07V09
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMVI25A (Chi tieu mau BCTC I25A)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| tk_01 - tk_12 | varchar | 20 | Tai khoan 1-12 |
| loai_ps | varchar | 20 | Loai phat sinh |
| nam_ps | varchar | 20 | Nam phat sinh |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

---

## Form classes

### 1. frmGLMAUBCTCTMVI25A (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMVI25AEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung |
| txtCach_tinh | TextBox | cach_tinh | Cach tinh |
| txtMauQD | TextBox | mau | Mau quyet dinh |
| txtTk1 - txtTk12 | AsTextBox | tk_01 - tk_12 | TK 1-12 (lookup TK) |
| cboLoai_ps | AsComboBox | loai_ps | Loai phat sinh |
| cboNam_ps | AsComboBox | nam_ps | Nam phat sinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MVI25A_GET | Lay danh sach chi tieu I25A |
| SP_GL_BCTC_MVI25A_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MVI25A_INSERT | Them chi tieu I25A |
| SP_GL_BCTC_MVI25A_UPDATE | Cap nhat chi tieu I25A |
| SP_GL_BCTC_MVI25A_DELETE | Xoa chi tieu I25A |

---

## Business Logic

1. **12 tai khoan:** Lookup tu DMTK
2. **Loai PS:** ComboBox voi 6 gia tri
3. **Nam PS:** ComboBox chon nam
4. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
5. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMVI25A.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMVI25A extends Model
{
    protected $table = 'BCTCCTMVI25A';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = array_merge(
        ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'cach_tinh', 'loai_ps', 'nam_ps'],
        ['tk_01', 'tk_02', 'tk_03', 'tk_04', 'tk_05', 'tk_06', 'tk_07', 'tk_08', 'tk_09', 'tk_10', 'tk_11', 'tk_12'],
        ['IsPrint', 'IsItalic', 'bold']
    );
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMVI25A.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMVI25A
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
- **Route:** `gl.task.280`
