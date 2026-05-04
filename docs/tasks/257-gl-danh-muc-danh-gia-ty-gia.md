# Task 257: GLDMDGTG

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module khai bao but toan danh gia ty gia tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLDMDGTG.dll
- **Assembly Title:** Khai bao cac but toan danh gia ty gia
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: DMDGTG (Danh muc but toan danh gia ty gia)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt | int | - | So thu tu |
| ten_bt | nvarchar | 200 | Ten but toan |
| so_ct | varchar | 50 | So chung tu mac dinh |
| loai_dg | varchar | 10 | Loai danh gia |
| tk_dgtg | varchar | 20 | TK danh gia ty gia |
| tk_lai_cltg | varchar | 20 | TK lai chen le ty gia |
| tk_lo_cltg | varchar | 20 | TK lo chen le ty gia |
| tk_cltg_cn | varchar | 20 | TK CLTG cong no |
| dg_bp | bit | 1 | Danh gia theo bo phan |
| dg_phi | bit | 1 | Danh gia theo phi |
| dg_hd | bit | 1 | Danh gia theo hop dong |
| dg_spct | bit | 1 | Danh gia theo SPCT |
| dg_kh | bit | 1 | Danh gia theo khach hang |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk_dgtg, tk_lai_cltg, tk_lo_cltg, tk_cltg_cn -> DMTK.tk |

---

## Form classes

### 1. frmGLDMDGTG (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach but toan danh gia ty gia
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDanhMuc | DataGridView | Luoi hien thi |
| txtSearch | TextBox | Tim kiem |

### 2. frmGLDMDGTGEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua but toan danh gia ty gia
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtStt | AsTextNumeric | stt | So thu tu (auto) |
| txtTen_Bt | TextBox | ten_bt | Ten but toan |
| txtSo_Ct | TextBox | so_ct | So chung tu mac dinh |
| cboLoai_Dg | ComboBox | loai_dg | Loai danh gia |
| txtTk_Dgtg | AsTextBox | tk_dgtg | TK danh gia TG (lookup TK) |
| txtTk_Lai_Cltg | AsTextBox | tk_lai_cltg | TK lai CLTG |
| txtTk_Lo_Cltg | AsTextBox | tk_lo_cltg | TK lo CLTG |
| txtTk_Cltg_Cn | AsTextBox | tk_cltg_cn | TK CLTG cong no |
| chkDg_Bp | CheckBox | dg_bp | Danh gia theo BP |
| chkDg_Phi | CheckBox | dg_phi | Danh gia theo phi |
| chkDg_Hd | CheckBox | dg_hd | Danh gia theo HD |
| chkDg_Spct | CheckBox | dg_spct | Danh gia theo SPCT |
| chkDg_Kh | CheckBox | dg_kh | Danh gia theo KH |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_DMDGTG_GET | Lay danh sach but toan DGTG |
| SP_GL_DMDGTG_GETBYID | Lay chi tiet 1 but toan |
| SP_GL_DMDGTG_INSERT | Them but toan DGTG |
| SP_GL_DMDGTG_UPDATE | Cap nhat but toan DGTG |
| SP_GL_DMDGTG_DELETE | Xoa but toan DGTG |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ten_bt | 'Ten but toan khong duoc trong' |
| Required | tk_dgtg | 'TK danh gia ty gia khong duoc trong' |
| Required | tk_lai_cltg | 'TK lai CLTG khong duoc trong' |
| Required | tk_lo_cltg | 'TK lo CLTG khong duoc trong' |

### Business Rules

1. **Loai danh gia:**
   - Chon mot hoac nhieu loai: BP, phi, HD, SPCT, KH
   - Mac dinh khong chon (tat ca = 0)

2. **Tai khoan:**
   - TK danh gia ty gia: bat buoc nhap
   - TK lai CLTG: bat buoc nhap
   - TK lo CLTG: bat buoc nhap
   - TK CLTG cong no: tuy chon

3. **So thu tu:**
   - Tu dong tang theo thu tu lon nhat + 1

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/DMDGTG.php
namespace Diepxuan\Simba\Models\GL;

class DMDGTG extends Model
{
    protected $table = 'DMDGTG';
    protected $primaryKey = 'stt';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = [
        'stt', 'ten_bt', 'so_ct', 'loai_dg',
        'tk_dgtg', 'tk_lai_cltg', 'tk_lo_cltg', 'tk_cltg_cn',
        'dg_bp', 'dg_phi', 'dg_hd', 'dg_spct', 'dg_kh',
    ];

    protected $casts = [
        'dg_bp' => 'boolean', 'dg_phi' => 'boolean',
        'dg_hd' => 'boolean', 'dg_spct' => 'boolean', 'dg_kh' => 'boolean',
    ];
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Danhmuc/Danhgiatygia.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Danhmuc;

class Danhgiatygia extends Component
{
    const MA_CT = 'GL';

    public Collection $pDanhMuc;
    public string $pSearch = '';
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMDGTG.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |
| Component | laravel-catalog | GL/Danhmuc/Danhgiatygia.php | List |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMDGTG
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations