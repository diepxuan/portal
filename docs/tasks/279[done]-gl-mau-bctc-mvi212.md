# Task 279: GLMAUBCTCTMVI212

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module mau bao cao tai chinh I212 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLMAUBCTCTMVI212.dll
- **Assembly Title:** GLBCTC07V09
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: BCTCCTMVI212 (Chi tieu mau BCTC I212)

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

### 1. frmGLMAUBCTCTMVI212 (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmGLMAUBCTCTMVI212Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| lblID | Label | - | Nhan ID |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_BCTC_MVI212_GET | Lay danh sach chi tieu I212 |
| SP_GL_BCTC_MVI212_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_BCTC_MVI212_INSERT | Them chi tieu I212 |
| SP_GL_BCTC_MVI212_UPDATE | Cap nhat chi tieu I212 |
| SP_GL_BCTC_MVI212_DELETE | Xoa chi tieu I212 |

---

## Business Logic

1. **Khong co TK:** Module khong su dung tai khoan
2. **Khong co cach_tinh:** Chi tieu khong co cong thuc tinh
3. **Mau QD:** Tu dong lay tu `CompanyInformations.Qd_cdkt`
4. **Mac dinh:** IsPrint = true khi them moi

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/BCTCCTMVI212.php
namespace Diepxuan\Simba\Models\GL;

class BCTCCTMVI212 extends Model
{
    protected $table = 'BCTCCTMVI212';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['mau', 'ma_so', 'chi_tieu', 'nd_chtieu', 'IsPrint', 'IsItalic', 'bold'];
    protected $casts = ['IsPrint' => 'boolean', 'IsItalic' => 'boolean', 'bold' => 'boolean'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | BCTCCTMVI212.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model BCTCCTMVI212
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
- **Route:** `gl.task.279`
