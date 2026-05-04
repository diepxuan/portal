# Task 084: SIDMNHHD

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc nhom hop dong tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMNHHD.dll
- **Chuc nang:** Danh muc nhom hop dong
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc nhom hop dong
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIDMNHHD

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMNHHD.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNHHD (Danh muc nhom hop dong)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_nhhd | varchar | Ma nhom (khoa chinh) |
| ten_nhhd | nvarchar | Ten nhom |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmSIDMNHHD (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSIDMNHHDEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_nhhd | AsTextBox | ma_nhhd | Ma nhom |
| txtTen_nhhd | TextBox | ten_nhhd | Ten nhom |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_NHHD_GET | Lay danh sach |
| SP_SI_NHHD_GETBYID | Lay chi tiet |
| SP_SI_NHHD_INSERT | Them moi |
| SP_SI_NHHD_UPDATE | Cap nhat |
| SP_SI_NHHD_DELETE | Xoa |
| SP_SI_NHHD_FIND | Tim kiem |
| SP_SI_NHHD_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_nhhd | 'Ma nhom khong duoc trong' |
| Unique | ma_nhhd | 'Ma da ton tai' |
| Required | ten_nhhd | 'Ten nhom khong duoc trong' |

### Business Rules

1. **Phan nhom hop dong**:
   - Mua, Ban, Dich vu...

2. **Lien ket voi hop dong**:
   - Su dung trong SIDMHD

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMNHHD.php
namespace Diepxuan\Simba\Models\SI;

class DMNHHD extends Model
{
    protected $table = 'DMNHHD';
    protected $primaryKey = 'ma_nhhd';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nhhd',
        'ten_nhhd',
        'ksd',
    ];

    protected $casts = [
        'ksd' => 'boolean',
    ];

    public function hopDongs()
    {
        return $this->hasMany(DMHD::class, 'ma_nhhd', 'ma_nhhd');
    }

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Nhomhd.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Nhomhd extends Component
{
    const MA_CT = 'SIDMNHHD';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.nhomhd');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── nhomhd.blade.php
├── nhomhd-edit.blade.php
└── _nhomhd-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/nhom-hd', [Nhomhd::class, 'render'])
            ->name('nhomhd');
        Route::get('/nhom-hd/edit/{ma_nhhd?}', [NhomhdEdit::class, 'render'])
            ->name('nhomhd.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMNHHD.php | Chinh |
| Model | laravel-simba | DMHD.php | Lien quan |
| Component | laravel-catalog | Nhomhd.php | List |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMNHHD
- [ ] Tao Livewire Nhomhd
- [ ] Tao Livewire NhomhdEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD