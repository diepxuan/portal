# Task 087: SIDMNT

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc ngoai te tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMNT.dll
- **Chuc nang:** Danh muc ngoai te
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc ngoai te
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIDMNT

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMNT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNT (Danh muc ngoai te)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_nt | varchar | Ma ngoai te (khoa chinh, 3 ky tu) |
| ten_nt | nvarchar | Ten ngoai te |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmSIDMNT (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSIDMNTEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_nt | AsTextBox | ma_nt | Ma ngoai te (3 ky tu) |
| txtTen_nt | TextBox | ten_nt | Ten ngoai te |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_DMNT_GET | Lay danh sach |
| SP_SI_DMNT_GETBYID | Lay chi tiet |
| SP_SI_DMNT_INSERT | Them moi |
| SP_SI_DMNT_UPDATE | Cap nhat |
| SP_SI_DMNT_DELETE | Xoa |
| SP_SI_DMNT_FIND | Tim kiem |
| SP_SI_DMNT_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required, 3 ky tu | ma_nt | 'Ma ngoai te 3 ky tu' |
| Unique | ma_nt | 'Ma da ton tai' |
| Required | ten_nt | 'Ten khong duoc trong' |

### Business Rules

1. **Ma ngoai te**:
   - Toi da 3 ky tu
   - VD: USD, EUR, JPY

2. **Refresh cau hinh**:
   - Sau cap nhat -> Refresh cau hinh

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMNT.php
namespace Diepxuan\Simba\Models\SI;

class DMNT extends Model
{
    protected $table = 'DMNT';
    protected $primaryKey = 'ma_nt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nt',
        'ten_nt',
        'ksd',
    ];

    protected $casts = [
        'ksd' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeVND($query)
    {
        return $query->where('ma_nt', 'VND');
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Ngoaite.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Ngoaite extends Component
{
    const MA_CT = 'SIDMNT';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.ngoaite');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── ngoaite.blade.php
├── ngoaite-edit.blade.php
└── _ngoaite-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/ngoai-te', [Ngoaite::class, 'render'])
            ->name('ngoaite');
        Route::get('/ngoai-te/edit/{ma_nt?}', [NgoaiteEdit::class, 'render'])
            ->name('ngoaite.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMNT.php | Chinh |
| Component | laravel-catalog | Ngoaite.php | List |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMNT
- [ ] Tao Livewire Ngoaite
- [ ] Tao Livewire NgoaiteEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
