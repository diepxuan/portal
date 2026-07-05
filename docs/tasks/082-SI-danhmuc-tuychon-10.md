# Task 082: SIDMOpt10

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc tuy chon 10 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMOpt10.dll
- **Chuc nang:** Danh muc tuy chon 10
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc tuy chon 10
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** SIDMOpt10

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMOpt10.dll/README.md`

---

## Cau truc du lieu

### Bang: DMOpt10 (Danh muc tuy chon 10)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_opt | varchar | Ma tuy chon (khoa chinh) |
| ten_opt | nvarchar | Ten tuy chon |
| ten_opt2 | nvarchar | Ten tieng Anh |
| ghi_chu | nvarchar | Ghi chu |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmSIDMOpt10 (Form xem danh sach)
- **Ke thua:** frmAsiaRoot
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvOpt | DataGridView | Luoi danh sach |
| btnAdd/Edit/Delete | Button | CRUD |

### 2. frmSIDMOpt10Edit (Form them/sua)
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
| SP_SI_OPT10_GET | Lay danh sach |
| SP_SI_OPT10_GETBYID | Lay chi tiet |
| SP_SI_OPT10_INSERT | Them moi |
| SP_SI_OPT10_UPDATE | Cap nhat |
| SP_SI_OPT10_DELETE | Xoa |
| SP_SI_OPT10_FIND | Tim kiem |
| SP_SI_OPT10_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_opt | 'Ma khong duoc trong' |
| Max length 50 | ma_opt | 'Ma toi da 50 ky tu' |
| Unique | ma_opt | 'Ma da ton tai' |
| Required | ten_opt | 'Ten khong duoc trong' |

### Business Rules

1. **Ma tuy chon**:
   - Khong cho phep trung ma

2. **Ho tro da ngon ngu**:
   - ten_opt: Tieng Viet
   - ten_opt2: Tieng Anh

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMOpt10.php
namespace Diepxuan\Simba\Models\SI;

class DMOpt10 extends Model
{
    protected $table = 'DMOpt10';
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
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Tuychon10.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Tuychon10 extends Component
{
    const MA_CT = 'SIDMOpt10';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.tuychon10');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── tuychon10.blade.php
├── tuychon10-edit.blade.php
└── _tuychon10-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/tuy-chon-10', [Tuychon10::class, 'render'])
            ->name('tuychon10');
        Route::get('/tuy-chon-10/edit/{ma_opt?}', [Tuychon10Edit::class, 'render'])
            ->name('tuychon10.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMOpt10.php | Chinh |
| Component | laravel-catalog | Tuychon10.php | List |
| Component | laravel-catalog | Tuychon10Edit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMOpt10
- [ ] Tao Livewire Tuychon10
- [ ] Tao Livewire Tuychon10Edit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell)
- **Route:** `si.dict.option10`
- **Note:** Shell metadata only; execute/write blocked until source wrapper/payload is audited.
