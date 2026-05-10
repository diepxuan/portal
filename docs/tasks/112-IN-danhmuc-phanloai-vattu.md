# Task 112: INDMPLVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang danh muc phan loai vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INDMPLVT.dll
- **Chuc nang:** Danh muc phan loai vat tu
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc phan loai vat tu - IN input
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMPLVT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMPLVT (Danh muc phan loai vat tu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_plvt | varchar | 50 | Ma phan loai VT (khoa chinh) |
| ten_plvt | nvarchar | 200 | Ten phan loai VT |
| loai | int | - | Kieu phan loai (1/2/3) |
| ksd | bit | 1 | Khoa su dung |

---

## Form classes

### 1. frmINDMPLVT (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmINDMPLVTEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Plvt | TextBox | ma_plvt | Ma phan loai |
| txtTen_Plvt | TextBox | ten_plvt | Ten phan loai |
| cboLoai | ComboBox | loai | Kieu (1/2/3) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_DMPLVT_GET | Lay danh sach phan loai VT |
| SP_IN_DMPLVT_GETBYID | Lay chi tiet 1 phan loai VT |
| SP_IN_DMPLVT_INSERT | Them phan loai VT moi |
| SP_IN_DMPLVT_UPDATE | Cap nhat phan loai VT |
| SP_IN_DMPLVT_DELETE | Xoa phan loai VT |
| SP_IN_DMPLVT_FIND | Tim kiem phan loai VT |
| SP_IN_DMPLVT_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_plvt | 'Ma phan loai VT khong duoc trong' |
| Max length 50 | ma_plvt | 'Ma phan loai VT toi da 50 ky tu' |
| Unique | ma_plvt | 'Ma phan loai VT da ton tai' |
| Required | ten_plvt | 'Ten phan loai VT khong duoc trong' |
| In 1,2,3 | loai | 'Kieu phan loai phai la 1, 2 hoac 3' |

### Business Rules

1. **3 kieu phan loai**: Loai 1, 2, 3 (phan cap nhom vat tu)
2. **Khoa su dung**: An khi ksd = 1
3. **Xoa phan loai VT**: Khong cho xoa neu co vat tu thuoc phan loai

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/DMPLVT.php
namespace Diepxuan\Simba\Models\IN;

class DMPLVT extends Model
{
    protected $table = 'DMPLVT';
    protected $primaryKey = 'ma_plvt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_plvt', 'ten_plvt', 'loai', 'ksd'];

    protected $casts = [
        'ksd' => 'boolean',
        'loai' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeByLoai($query, int $loai)
    {
        return $query->where('loai', $loai);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_plvt', 'like', "%{$search}%")
              ->orWhere('ten_plvt', 'like', "%{$search}%");
        });
    }

    public function vatTus()
    {
        return $this->hasMany(DMVT::class, 'ma_plvt', 'ma_plvt');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetDMPLVT.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetDMPLVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMPLVT_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsDMPLVT.php
class AsINInsDMPLVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMPLVT_INSERT';
    protected $params = ['pMa_cty', 'ma_plvt', 'ten_plvt', 'loai', 'ksd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdDMPLVT.php
class AsINUpdDMPLVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMPLVT_UPDATE';
    protected $params = ['pMa_cty', 'ma_plvt', 'ten_plvt', 'loai', 'ksd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelDMPLVT.php
class AsINDelDMPLVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMPLVT_DELETE';
    protected $params = ['pMa_cty', 'ma_plvt'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChkDMPLVT.php
class AsINChkDMPLVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMPLVT_CHECK';
    protected $params = ['pMa_cty', 'ma_plvt'];
}
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/Phanloaivattu.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class Phanloaivattu extends Component
{
    const MA_CT = 'IN';

    public Collection $pDanhSach;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?int $pLoai = null;

    public function render(): View
    {
        return view('catalog::in.danhmuc.phan-loai-vat-tu');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/PhanloaivattuEdit.php
class PhanloaivattuEdit extends Component
{
    public ?string $pMa_Plvt = null;
    public string $pTen_Plvt = '';
    public int $pLoai = 1;
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Plvt' => 'required|string|max:50|unique:DMPLVT,ma_plvt',
        'pTen_Plvt' => 'required|string|max:200',
        'pLoai' => 'required|integer|in:1,2,3',
    ];

    public function mount(?string $maPlvt = null): void
    {
        if ($maPlvt) {
            $this->pMa_Plvt = $maPlvt;
            $this->loadRecord();
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::in.danhmuc.phan-loai-vat-tu-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/in/danhmuc/
├── phan-loai-vat-tu.blade.php
├── phan-loai-vat-tu-edit.blade.php
└── _phan-loai-vat-tu-row.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/phan-loai-vat-tu', [Phanloaivattu::class, 'render'])
            ->name('phan-loai-vat-tu');
        Route::get('/phan-loai-vat-tu/edit/{maPlvt?}', [PhanloaivattuEdit::class, 'render'])
            ->name('phan-loai-vat-tu.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMPLVT.php | Chinh |
| Model | laravel-simba | DMVT.php | Lien quan (FK) |
| SP | laravel-simba | AsINGetDMPLVT.php | Get |
| SP | laravel-simba | AsINInsDMPLVT.php | Insert |
| SP | laravel-simba | AsINUpdDMPLVT.php | Update |
| SP | laravel-simba | AsINDelDMPLVT.php | Delete |
| SP | laravel-simba | AsINChkDMPLVT.php | Check trung |
| Component | laravel-catalog | Phanloaivattu.php | List |
| Component | laravel-catalog | PhanloaivattuEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMPLVT
- [ ] Tao Livewire Phanloaivattu (list)
- [ ] Tao Livewire PhanloaivattuEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
