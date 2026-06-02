# Task 277: GLMAUBCTCTMVI12

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh I12 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMVI12.dll
- **Assembly Title:** GLBCTC07V09
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMVI12 (Chi tieu mau BCTC I12)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| tk_01 | varchar | 20 | Tai khoan |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

---

## Form classes

### 1. frmGLMAUBCTCTMVI12 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMVI12Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung |
| txtCach_tinh | TextBox | cach_tinh | Cach tinh |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (lookup TK) |
| lblTK | Label | - | Hien thi ten TK |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MVI12_GET | Lay danh sach chi tieu I12 |
| SP_GL_BCTC_MVI12_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MVI12_INSERT | Them chi tieu I12 |
| SP_GL_BCTC_MVI12_UPDATE | Cap nhat chi tieu I12 |
| SP_GL_BCTC_MVI12_DELETE | Xoa chi tieu I12 |

---

## Business Logic

1. **Tai khoan:** 1 tai khoan, Lookup tu DMTK
2. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
3. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMVI12.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMVI12 extends Model
{
    protected $table = 'BCTCCTMVI12';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'cach_tinh', 'tk_01', 'IsPrint', 'IsItalic', 'bold'];
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMVI12.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMVI12
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
- **Route:** `gl.task.277`
