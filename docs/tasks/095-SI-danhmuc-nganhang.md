# Task 095: SIDMNGH

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc ngan hang tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMNGH.dll
- **Chuc nang:** Danh muc ngan hang
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc ngan hang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIDMNGH

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMNGH.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNGH (Danh muc ngan hang)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_ngh | varchar | Ma ngan hang (khoa chinh) |
| ten_ngh | nvarchar | Ten ngan hang |
| ghi_chu | nvarchar | Ghi chu |
| sd | bit | Su dung |

---

## Form classes

### 1. frmSIDMNGH (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSIDMNGHEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_ngh | AsTextBox | ma_ngh | Ma ngan hang |
| txtTen_ngh | TextBox | ten_ngh | Ten ngan hang |
| txtGhi_chu | TextBox | ghi_chu | Ghi chu |
| chkSd | AsCheckBox | sd | Su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_DMNGH_GET | Lay danh sach |
| SP_SI_DMNGH_GETBYID | Lay chi tiet |
| SP_SI_DMNGH_INSERT | Them moi |
| SP_SI_DMNGH_UPDATE | Cap nhat |
| SP_SI_DMNGH_DELETE | Xoa |
| SP_SI_DMNGH_FIND | Tim kiem |
| SP_SI_DMNGH_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ngh | 'Ma ngan hang khong duoc trong' |
| Unique | ma_ngh | 'Ma da ton tai' |
| Required | ten_ngh | 'Ten ngan hang khong duoc trong' |

### Business Rules

1. **Su dung trong**:
   - Chuyen khoan ngan hang
   - Thanh toan CA4

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMNGH.php
namespace Diepxuan\Simba\Models\SI;

class DMNGH extends Model
{
    protected $table = 'DMNGH';
    protected $primaryKey = 'ma_ngh';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_ngh',
        'ten_ngh',
        'ghi_chu',
        'sd',
    ];

    protected $casts = [
        'sd' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('sd', true);
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Nganhang.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Nganhang extends Component
{
    const MA_CT = 'SIDMNGH';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.nganhang');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── nganhang.blade.php
├── nganhang-edit.blade.php
└── _nganhang-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/ngan-hang', [Nganhang::class, 'render'])
            ->name('nganhang');
        Route::get('/ngan-hang/edit/{ma_ngh?}', [NganhangEdit::class, 'render'])
            ->name('nganhang.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMNGH.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMNGH
- [ ] Tao Livewire Nganhang
- [ ] Tao Livewire NganhangEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD