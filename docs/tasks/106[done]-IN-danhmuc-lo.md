# Task 106: INDMLO

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang danh muc lo tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** INDMLO.dll
- **Chuc nang:** Danh muc lo
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc lo
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMLO.dll/README.md`

---

## Cau truc du lieu

### Bang: DMLO (Danh muc lo)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_lo | varchar | 50 | Ma lo (khoa chinh) |
| ten_lo | nvarchar | 200 | Ten lo |
| han_dung | datetime | - | Han dung |
| trang_thai | nvarchar | 100 | Trang thai |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| INCDVT | So ton dau ky | FK ma_lo -> DMLO.ma_lo |
| IN1CT | Chi tiet phieu nhap | FK ma_lo -> DMLO.ma_lo |

---

## Form classes

### 1. frmINDMLO (Form xem danh sach)
- **Ke thua:** frmDMView
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem theo ma/ten |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmINDMLOEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Lo | TextBox | ma_lo | Ma lo |
| txtTen_Lo | TextBox | ten_lo | Ten lo |
| txtHan_dung | AsMaskedTextBox | han_dung | Han dung (dd/MM/yyyy) |
| txtTrang_thai | TextBox | trang_thai | Trang thai |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_DMLO_GET | Lay danh sach lo |
| SP_IN_DMLO_GETBYID | Lay chi tiet 1 lo |
| SP_IN_DMLO_INSERT | Them lo moi |
| SP_IN_DMLO_UPDATE | Cap nhat lo |
| SP_IN_DMLO_DELETE | Xoa lo |
| SP_IN_DMLO_FIND | Tim kiem lo |
| SP_IN_DMLO_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_lo | 'Ma lo khong duoc trong' |
| Max length 50 | ma_lo | 'Ma lo toi da 50 ky tu' |
| Unique | ma_lo | 'Ma lo da ton tai' |
| Required | ten_lo | 'Ten lo khong duoc trong' |
| Date format | han_dung | 'Ngay han dung khong dung dinh dang' |

### Business Rules

1. **Ma lo**: Khong cho phep sua khi da co phieu lien quan
2. **Han dung**: Su dung masked input dd/MM/yyyy
3. **Khoa su dung**: Mac dinh = 0, ksd=1 an khoi danh sach chon

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/DMLO.php
namespace Diepxuan\Simba\Models\IN;

class DMLO extends Model
{
    protected $table = 'DMLO';
    protected $primaryKey = 'ma_lo';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_lo', 'ten_lo', 'han_dung', 'trang_thai', 'ksd',
    ];

    protected $casts = [
        'han_dung' => 'datetime:d/m/Y',
        'ksd' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_lo', 'like', "%{$search}%")
              ->orWhere('ten_lo', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetDMLO.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetDMLO extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMLO_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsDMLO.php
class AsINInsDMLO extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMLO_INSERT';
    protected $params = ['pMa_cty', 'ma_lo', 'ten_lo', 'han_dung', 'trang_thai', 'ksd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdDMLO.php
class AsINUpdDMLO extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMLO_UPDATE';
    protected $params = ['pMa_cty', 'ma_lo', 'ten_lo', 'han_dung', 'trang_thai', 'ksd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelDMLO.php
class AsINDelDMLO extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMLO_DELETE';
    protected $params = ['pMa_cty', 'ma_lo'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChkDMLO.php
class AsINChkDMLO extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMLO_CHECK';
    protected $params = ['pMa_cty', 'ma_lo'];
}
```

### 3. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/Lo.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class Lo extends Component
{
    const MA_CT = 'IN';

    public Collection $pLos;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    public function render(): View
    {
        return view('catalog::in.danhmuc.lo');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/LoEdit.php
class LoEdit extends Component
{
    public ?string $pMaLo = null;
    public string $pTenLo = '';
    public ?Carbon $pHanDung = null;
    public string $pTrangThai = '';
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMaLo' => 'required|string|max:50|unique:DMLO,ma_lo',
        'pTenLo' => 'required|string|max:200',
    ];

    public function render(): View
    {
        return view('catalog::in.danhmuc.lo-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/in/danhmuc/
├── lo.blade.php
└── lo-edit.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/lo', [Lo::class, 'render'])->name('lo');
        Route::get('/lo/edit/{maLo?}', [LoEdit::class, 'render'])->name('lo.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMLO.php | Chinh |
| SP | laravel-simba | AsINGetDMLO.php | Get |
| SP | laravel-simba | AsINInsDMLO.php | Insert |
| SP | laravel-simba | AsINUpdDMLO.php | Update |
| SP | laravel-simba | AsINDelDMLO.php | Delete |
| SP | laravel-simba | AsINChkDMLO.php | Check trung |
| Component | laravel-catalog | Lo.php | List |
| Component | laravel-catalog | LoEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMLO
- [ ] Tao Livewire Lo (list)
- [ ] Tao Livewire LoEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test han dung date format
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `in.dict.lo`
- **Note:** Route đã có hoặc shell metadata; write/transfer execute chỉ mở khi payload/side effect được audit.
