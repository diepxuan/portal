# Task 093: SIDMPHI

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc phi tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMPHI.dll
- **Chuc nang:** Danh muc phi
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc phi
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIDMPHI

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMPHI.dll/README.md`

---

## Cau truc du lieu

### Bang: DMPHI (Danh muc phi)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_phi | varchar | Ma phi (khoa chinh) |
| ten_phi | nvarchar | Ten phi |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmSIDMPHI (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSIDMPHIEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_phi | AsTextBox | ma_phi | Ma phi |
| txtTen_phi | TextBox | ten_phi | Ten phi |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_DMPHI_GET | Lay danh sach |
| SP_SI_DMPHI_GETBYID | Lay chi tiet |
| SP_SI_DMPHI_INSERT | Them moi |
| SP_SI_DMPHI_UPDATE | Cap nhat |
| SP_SI_DMPHI_DELETE | Xoa |
| SP_SI_DMPHI_FIND | Tim kiem |
| SP_SI_DMPHI_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_phi | 'Ma phi khong duoc trong' |
| Unique | ma_phi | 'Ma da ton tai' |
| Required | ten_phi | 'Ten phi khong duoc trong' |

### Business Rules

1. **Loai phi**:
   - Phi van chuyen
   - Phi bao bi
   - Phi bung ke...

2. **Su dung trong chung tu**:
   - PO3: Chi phi mua hang
   - SIDMCT: Cau hinh su dung ma_phi

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMPHI.php
namespace Diepxuan\Simba\Models\SI;

class DMPHI extends Model
{
    protected $table = 'DMPHI';
    protected $primaryKey = 'ma_phi';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_phi',
        'ten_phi',
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
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Danhmucphi.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Danhmucphi extends Component
{
    const MA_CT = 'SIDMPHI';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.danhmucphi');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── danhmucphi.blade.php
├── danhmucphi-edit.blade.php
└── _danhmucphi-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/danh-muc-phi', [Danhmucphi::class, 'render'])
            ->name('danhmucphi');
        Route::get('/danh-muc-phi/edit/{ma_phi?}', [DanhmucphiEdit::class, 'render'])
            ->name('danhmucphi.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMPHI.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMPHI
- [ ] Tao Livewire Danhmucphi
- [ ] Tao Livewire DanhmucphiEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
