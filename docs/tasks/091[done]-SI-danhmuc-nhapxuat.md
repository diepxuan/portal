# Task 091: SIDMNHHD (Danh muc nhap xuat)

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc nhap xuat (chung) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMNHHD.dll
- **Chuc nang:** Danh muc nhap xuat
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc nhap xuat
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIDMNHHD

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMNHHD.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNHX (Danh muc nhap xuat)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_nhx | varchar | Ma nhap xuat (khoa chinh) |
| ten_nhx | nvarchar | Ten nhap xuat |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmSIDMNHX (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSIDMNHXEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_nhx | AsTextBox | ma_nhx | Ma nhap xuat |
| txtTen_nhx | TextBox | ten_nhx | Ten nhap xuat |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_NHX_GET | Lay danh sach |
| SP_SI_NHX_GETBYID | Lay chi tiet |
| SP_SI_NHX_INSERT | Them moi |
| SP_SI_NHX_UPDATE | Cap nhat |
| SP_SI_NHX_DELETE | Xoa |
| SP_SI_NHX_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_nhx | 'Ma khong duoc trong' |
| Unique | ma_nhx | 'Ma da ton tai' |
| Required | ten_nhx | 'Ten khong duoc trong' |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMNHX.php
namespace Diepxuan\Simba\Models\SI;

class DMNHX extends Model
{
    protected $table = 'DMNHX';
    protected $primaryKey = 'ma_nhx';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nhx',
        'ten_nhx',
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
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Nhapxuat.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Nhapxuat extends Component
{
    const MA_CT = 'SIDMNHHD';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.nhapxuat');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── nhapxuat.blade.php
├── nhapxuat-edit.blade.php
└── _nhapxuat-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/nhap-xuat', [Nhapxuat::class, 'render'])
            ->name('nhapxuat');
        Route::get('/nhap-xuat/edit/{ma_nhx?}', [NhapxuatEdit::class, 'render'])
            ->name('nhapxuat.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMNHX.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMNHX
- [ ] Tao Livewire Nhapxuat
- [ ] Tao Livewire NhapxuatEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell)
- **Route:** `si.dict.nx`
- **Note:** Shell metadata only; execute/write blocked until source wrapper/payload is audited.
