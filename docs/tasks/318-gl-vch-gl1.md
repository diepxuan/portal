# Task 318: GLVchGL1

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Chung tu ghi so GL1 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLVchGL1.dll
- **Assembly Title:** UI.GlVouchers
- **Version:** 1.0.5921.28605
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Chon TK no/co |
| DMCP | Danh muc cong trinh | Lookup ma_cp |
| DMKH | Danh muc khach hang | Lookup ma_kh |
| DMVT | Danh muc vat tu | Lookup ma_vt |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay_ct | Ngay chung tu |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGLVchGL1
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap chung tu ghi so

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay_ct | AsMaskedTextBox | Ngay chung tu |
| txtSo_ct | TextBox | So chung tu |
| dgvDetail | DataGridView | Luoi chi tiet (tk, du, ps_no, ps_co) |
| txtMa_nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te |
| txtTy_gia | AsNumericBox | Ty gia |
| cmdSave, cmdCancel, cmdDelete | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_VCHGL1_GET | Lay danh sach CT |
| SP_GL_VCHGL1_GETBYID | Lay chi tiet 1 CT |
| SP_GL_VCHGL1_INSERT | Them CT |
| SP_GL_VCHGL1_UPDATE | Cap nhat CT |
| SP_GL_VCHGL1_DELETE | Xoa CT |

### Parameters reference (INSERT)

```sql
EXEC SP_GL_VCHGL1_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(50),
    @pNgay_ct DATETIME,
    @pSo_ct VARCHAR(50),
    @pMa_nt VARCHAR(50),
    @pTy_gia DECIMAL(18, 3),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Required | so_ct | 'So chung tu khong duoc trong' |
| Required | Chi tiet | 'Phai co it nhat 1 dong chi tiet' |
| Check | Du no = Du co | 'Tong du no phai bang tong du co' |

### Business Rules

1. **Chi tiet**: Nhieu dong (tk, tk_du, ps_no, ps_co)
2. **Cong no = Cong co**: Tong phat sinh no = tong phat sinh co
3. **Ngoai te**: Ho tro nhieu ngoai te, ty gia
4. **Tu dong sinh so**: Sinh so CT tu dong

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/VchGL1.php
namespace Diepxuan\Simba\Models\GL;

class VchGL1 extends Model
{
    protected $table = 'VCHGL1';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_cty', 'ngay_ct', 'so_ct', 'ma_nt', 'ty_gia',
    ];
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Chungtu/Vchgl1.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Chungtu;

class Vchgl1 extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay_ct = null;
    public ?string $so_ct = null;
    public ?string $ma_nt = null;
    public float $ty_gia = 1;
    public array $details = [];
}
```

### 3. Views

```
resources/views/catalog/gl/chungtu/
├── vchgl1-list.blade.php
└── vchgl1-edit.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/gl/chungtu')
    ->name('catalog.gl.chungtu.')
    ->group(function () {
        Route::get('/vchgl1', [Vchgl1::class, 'render'])->name('vchgl1');
        Route::get('/vchgl1/edit/{stt_rec?}', [Vchgl1Edit::class, 'render'])->name('vchgl1.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | VchGL1.php | Chinh |
| Model | laravel-simba | VchGL1Ct.php | Chi tiet |
| Component | laravel-catalog | Vchgl1.php | List |
| Component | laravel-catalog | Vchgl1Edit.php | Edit |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Model VchGL1 & VchGL1Ct
- [ ] Tao Livewire Vchgl1 (list)
- [ ] Tao Livewire Vchgl1Edit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test validate
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
