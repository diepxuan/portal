# Task 259: GLMAUBCTCTMIX

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh IX tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMIX.dll
- **Assembly Title:** GLBCTC071234
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMIX (Chi tieu mau BCTC IX)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

---

## Form classes

### 1. frmGLMAUBCTCTMIX (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chi tieu BCTC IX
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDanhMuc | DataGridView | Luoi hien thi |
| txtSearch | TextBox | Tim kiem |

### 2. frmGLMAUBCTCTMIXEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MIX_GET | Lay danh sach chi tieu IX |
| SP_GL_BCTC_MIX_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MIX_INSERT | Them chi tieu IX |
| SP_GL_BCTC_MIX_UPDATE | Cap nhat chi tieu IX |
| SP_GL_BCTC_MIX_DELETE | Xoa chi tieu IX |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_so | 'Ma chi tieu khong duoc trong' |
| Required | chi_tieu | 'Ten chi tieu khong duoc trong' |

### Business Rules

1. **Ma chi tieu:** Uppercase, AutoComplete
2. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt` neu de trong
3. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMIX.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMIX extends Model
{
    protected $table = 'BCTCCTMIX';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'IsPrint', 'IsItalic', 'bold'];
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

### 2. Views

```
resources/views/catalog/gl/baocaotc/
├── mau-bctc-mix.blade.php
└── mau-bctc-mix-edit.blade.php
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMIX.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMIX
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
- **Route:** `gl.task.259`
