# Task 284: GLNB

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module nghiệp vụ ngân hàng tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLNB.dll
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: GLNB (Danh muc nghiệp vụ ngân hàng)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| so_ct | varchar | 20 | So chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| tk | varchar | 20 | Tai khoan (chi_tiet=1) |
| ngoai_te | varchar | 20 | Ngoai te |
| ty_gia | float | 8 | Ty gia |
| ty_gia_nt | float | 8 | Ty gia noi te |

---

## Form classes

### 1. frmGLNB (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmGLNBEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_ct | TextBox | so_ct | So chung tu |
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay chung tu (dd/MM/yyyy) |
| txtTK | AsTextBox | tk | Tai khoan (lookup DMTK, chi_tiet=1) |
| lblTen_tk | Label | - | Ten tai khoan |
| cboNgoai_te | AsComboBoxNT | ngoai_te | Ngoai te |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_NB_GET | Lay danh sach nghiệp vụ ngân hàng |
| SP_GL_NB_GETBYID | Lay chi tiet 1 nghiệp vụ |
| SP_GL_NB_INSERT | Them nghiệp vụ ngân hàng |
| SP_GL_NB_UPDATE | Cap nhat nghiệp vụ ngân hàng |
| SP_GL_NB_DELETE | Xoa nghiệp vụ ngân hàng |

---

## Business Logic

1. **Tai khoan:** Chi tiết, lookup tu DMTK voi chi_tiet=1
2. **Ngoai te:** ComboBoxNT, hien thi ten ngoai te
3. **Ty gia:** Tu dong lay tu ty_gia ngan hang

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/GLNB.php
namespace Diepxuan\Simba\Models\GL;

class GLNB extends Model
{
    protected $table = 'GLNB';
    protected $primaryKey = 'so_ct';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['so_ct', 'ngay_ct', 'tk', 'ngoai_te', 'ty_gia', 'ty_gia_nt'];
    protected $casts = ['ngay_ct' => 'datetime', 'ty_gia' => 'float', 'ty_gia_nt' => 'float'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | GLNB.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model GLNB
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
