# Task 265: GLMAUBCTCTMV11

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh V11 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMV11.dll
- **Assembly Title:** GLBCTC07V11
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMV11 (Chi tieu mau BCTC V11)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| tk_01 | varchar | 20 | Tai khoan |
| ma_spct | varchar | 50 | Ma cong trinh/san pham chi tiet |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

---

## Form classes

### 1. frmGLMAUBCTCTMV11 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMV11Edit (Form them/sua)
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
| txtCongTrinh | AsTextBox | ma_spct | Ma cong trinh (lookup MA_SPCT) |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MV11_GET | Lay danh sach chi tieu V11 |
| SP_GL_BCTC_MV11_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MV11_INSERT | Them chi tieu V11 |
| SP_GL_BCTC_MV11_UPDATE | Cap nhat chi tieu V11 |
| SP_GL_BCTC_MV11_DELETE | Xoa chi tieu V11 |

---

## Business Logic

### Business Rules

1. **Tai khoan:** 1 tai khoan, Lookup tu DMTK
2. **Cong trinh:** LookupCodeName = "MA_SPCT", LookupWhereCondition = "SAN_PHAM <> '1'"
3. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
4. **Mac dinh:** IsPrint = true khi them moi
5. **Dac diem:** Co truong ma_spct de theo doi theo cong trinh

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMV11.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMV11 extends Model
{
    protected $table = 'BCTCCTMV11';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'cach_tinh', 'tk_01', 'ma_spct', 'IsPrint', 'IsItalic', 'bold'];
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMV11.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |
| Model | laravel-simba | DMSPCT.php | Cong trinh/SPCT |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMV11
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
