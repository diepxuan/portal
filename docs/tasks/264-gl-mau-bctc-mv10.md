# Task 264: GLMAUBCTCTMV10

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh V10 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMV10.dll
- **Assembly Title:** GLBCTC07V09
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMV10 (Chi tieu mau BCTC V10)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Mau quyet dinh |
| ma_so | varchar | 50 | Ma so chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh |
| tk_01 - tk_07 | varchar | 20 | Tai khoan 1-7 |
| loai_ps | varchar | 20 | Loai phat sinh |
| IsPrint | bit | 1 | Co in |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

---

## Form classes

### 1. frmGLMAUBCTCTMV10 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMV10Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung |
| txtCach_tinh | TextBox | cach_tinh | Cach tinh |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| txtTk1 - txtTk7 | AsTextBox | tk_01 - tk_07 | TK 1-7 (lookup TK) |
| cboLoai_ps | AsComboBox | loai_ps | Loai phat sinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MV10_GET | Lay danh sach chi tieu V10 |
| SP_GL_BCTC_MV10_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MV10_INSERT | Them chi tieu V10 |
| SP_GL_BCTC_MV10_UPDATE | Cap nhat chi tieu V10 |
| SP_GL_BCTC_MV10_DELETE | Xoa chi tieu V10 |

---

## Business Logic

### Business Rules

1. **Tai khoan:** 7 tai khoan, Lookup tu DMTK
2. **Loai PS:** ComboBox NODK/CODK/NOCK/COCK/PSNO/PSCO
3. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
4. **Mac dinh:** IsPrint = true khi them moi
5. **Luu y:** Metadata (Title/GUID) giong V09, co the la bien the cua V09

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMV10.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMV10 extends Model
{
    protected $table = 'BCTCCTMV10';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = array_merge(
        ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'cach_tinh', 'loai_ps'],
        ['tk_01', 'tk_02', 'tk_03', 'tk_04', 'tk_05', 'tk_06', 'tk_07'],
        ['IsPrint', 'IsItalic', 'bold']
    );
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMV10.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMV10
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations