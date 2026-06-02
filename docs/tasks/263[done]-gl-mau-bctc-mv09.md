# Task 263: GLMAUBCTCTMV09

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh V09 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMV09.dll
- **Assembly Title:** GLBCTC07V09
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMV09 (Chi tieu mau BCTC V09)

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

### 1. frmGLMAUBCTCTMV09 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMV09Edit (Form them/sua)
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
| lblTK1 - lblTK7 | Label | - | Hien thi ten TK |
| cboLoai_ps | AsComboBox | loai_ps | Loai phat sinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MV09_GET | Lay danh sach chi tieu V09 |
| SP_GL_BCTC_MV09_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MV09_INSERT | Them chi tieu V09 |
| SP_GL_BCTC_MV09_UPDATE | Cap nhat chi tieu V09 |
| SP_GL_BCTC_MV09_DELETE | Xoa chi tieu V09 |

---

## Business Logic

### Business Rules

1. **Tai khoan:** 7 tai khoan, Lookup tu DMTK (LookupCodeName = "TK")
2. **Loai PS:** ComboBox voi 6 gia tri
3. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt` neu trong
4. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMV09.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMV09 extends Model
{
    protected $table = 'BCTCCTMV09';
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
| Model | laravel-simba | BCTCCTMV09.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMV09
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
- **Route:** `gl.task.263`
