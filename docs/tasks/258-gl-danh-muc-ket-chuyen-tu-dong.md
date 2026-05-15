# Task 258: GLDMKC

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module khai bao but toan ket chuyen tu dong tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLDMKC.dll
- **Assembly Title:** Khai bao cac but toan ket chuyen tu dong
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: DMKC (Danh muc but toan ket chuyen)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt | int | - | So thu tu |
| ma_cty | varchar | 50 | Ma cong ty |
| tk_no | varchar | 20 | Tai khoan noi |
| tk_co | varchar | 20 | Tai khoan co (doi ung) |
| ten_bt | nvarchar | 200 | Ten but toan |
| so_ct | varchar | 50 | So chung tu mac dinh |
| loai_kc | varchar | 20 | Loai ket chuyen |
| par1 | varchar | 50 | Tham so 1 (loai ket chuyen) |
| theo_bp | bit | 1 | Theo bo phan |
| theo_phi | bit | 1 | Theo phi |
| theo_hd | bit | 1 | Theo hop dong |
| theo_spct | bit | 1 | Theo SPCT |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk_no, tk_co -> DMTK.tk |

---

## Form classes

### 1. frmGLDMKC (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach but toan ket chuyen
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDanhMuc | DataGridView | Luoi hien thi |
| txtSearch | TextBox | Tim kiem |

### 2. frmGLDMKCEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua but toan ket chuyen
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtStt | AsTextNumeric | stt | So thu tu (auto) |
| txtTen_Bt | TextBox | ten_bt | Ten but toan |
| txtSo_Ct | TextBox | so_ct | So chung tu mac dinh |
| txtTk_No | AsTextBox | tk_no | TK noi (lookup TK) |
| txtTk_Co | AsTextBox | tk_co | TK co (lookup TK) |
| txtLoai_Kc | TextBox | loai_kc | Loai ket chuyen |
| txtPar1 | AsTextBox | par1 | Tham so 1 |
| chkTheo_Bp | CheckBox | theo_bp | Theo bo phan |
| chkTheo_Phi | CheckBox | theo_phi | Theo phi |
| chkTheo_Hd | CheckBox | theo_hd | Theo hop dong |
| chkTheo_Spct | CheckBox | theo_spct | Theo SPCT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_DMKC_GET | Lay danh sach but toan KC |
| SP_GL_DMKC_GETBYID | Lay chi tiet 1 but toan |
| SP_GL_DMKC_INSERT | Them but toan KC |
| SP_GL_DMKC_UPDATE | Cap nhat but toan KC |
| SP_GL_DMKC_DELETE | Xoa but toan KC |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ten_bt | 'Ten but toan khong duoc trong' |
| Required | tk_no | 'TK noi khong duoc trong' |
| Required | tk_co | 'TK co khong duoc trong' |

### Business Rules

1. **Loai ket chuyen:**
   - Su dung tham so par1 de phan loai ket chuyen
   - Cac loai: ket chuyen cuoi ky, ket chuyen loi nhuan, ...

2. **Tai khoan noi/co:**
   - TK noi: bat buoc nhap, phai ton tai trong DMTK
   - TK co: bat buoc nhap, phai ton tai trong DMTK

3. **Phan tich ket chuyen:**
   - Theo bo phan (theo_bp)
   - Theo phi (theo_phi)
   - Theo hop dong (theo_hd)
   - Theo SPCT (theo_spct)

4. **So thu tu:**
   - Tu dong tang: SttMax + 1

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/DMKC.php
namespace Diepxuan\Simba\Models\GL;

class DMKC extends Model
{
    protected $table = 'DMKC';
    protected $primaryKey = 'stt';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = [
        'stt', 'ma_cty', 'tk_no', 'tk_co', 'ten_bt', 'so_ct',
        'loai_kc', 'par1', 'theo_bp', 'theo_phi', 'theo_hd', 'theo_spct',
    ];

    protected $casts = [
        'theo_bp' => 'boolean', 'theo_phi' => 'boolean',
        'theo_hd' => 'boolean', 'theo_spct' => 'boolean',
    ];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKC.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |
| Component | laravel-catalog | GL/Danhmuc/Ketchuyen.php | List |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMKC
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Implementation Update 2026-05-15

- Da co route anchor `gl.dict.gldmkc` cho menu `02.90.05` qua generic `simba.dictionary`.
- Route la alias theo `sysDictionaryInfo.table_name = GLDMKC`; source menuid trong dictionary metadata bi blank nen duoc ghi ro bang `source_menuid`.
- Chua mo CRUD ghi/xoa vi can audit du payload/validate/side effect; khong goi SQL/SP/function.
