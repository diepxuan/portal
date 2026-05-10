# Task 092: SIDMOpt9

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc tuy chon 9 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMOpt9.dll
- **Chuc nang:** Danh muc tuy chon 9
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc tuy chon 9
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** SIDMOpt9

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMOpt9.dll/README.md`

---

## Cau truc du lieu

### Bang: DMOpt9 (Danh muc tuy chon 9)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_opt | varchar | Ma tuy chon (khoa chinh) |
| ten_opt | nvarchar | Ten tuy chon |
| ten_opt2 | nvarchar | Ten tieng Anh |
| ghi_chu | nvarchar | Ghi chu |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmSIDMOpt9 (Form xem danh sach)
- **Ke thua:** frmAsiaRoot

### 2. frmSIDMOpt9Edit (Form them/sua)
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa | TextBox | ma_opt | Ma tuy chon |
| txtTen | TextBox | ten_opt | Ten |
| txtTen2 | TextBox | ten_opt2 | Ten tieng Anh |
| txtGhiChu | TextBox | ghi_chu | Ghi chu |
| chkStatus | CheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_OPT9_GET | Lay danh sach |
| SP_SI_OPT9_GETBYID | Lay chi tiet |
| SP_SI_OPT9_INSERT | Them moi |
| SP_SI_OPT9_UPDATE | Cap nhat |
| SP_SI_OPT9_DELETE | Xoa |
| SP_SI_OPT9_FIND | Tim kiem |
| SP_SI_OPT9_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_opt | 'Ma khong duoc trong' |
| Unique | ma_opt | 'Ma da ton tai' |
| Required | ten_opt | 'Ten khong duoc trong' |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMOpt9.php
namespace Diepxuan\Simba\Models\SI;

class DMOpt9 extends Model
{
    protected $table = 'DMOpt9';
    protected $primaryKey = 'ma_opt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_opt',
        'ten_opt',
        'ten_opt2',
        'ghi_chu',
        'ksd',
    ];

    protected $casts = [
        'ksd' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Tuychon9.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Tuychon9 extends Component
{
    const MA_CT = 'SIDMOpt9';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.tuychon9');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── tuychon9.blade.php
├── tuychon9-edit.blade.php
└── _tuychon9-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/tuy-chon-9', [Tuychon9::class, 'render'])
            ->name('tuychon9');
        Route::get('/tuy-chon-9/edit/{ma_opt?}', [Tuychon9Edit::class, 'render'])
            ->name('tuychon9.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMOpt9.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMOpt9
- [ ] Tao Livewire Tuychon9
- [ ] Tao Livewire Tuychon9Edit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
