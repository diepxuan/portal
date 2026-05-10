# Task 210: SO-Danh-Muc-Nhan-Vien-Kinh-Doanh

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc nhan vien kinh doanh tu .NET sang PHP Laravel, dat ket qua tuong duong SODMNVKD.

## Chi tiet
- **DLL:** SODMNVKD.dll
- **Chuc nang:** Danh muc nhan vien kinh doanh (Salesperson Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMNVKD.dll/README.md`

---

## Cau truc du lieu

### Bang: dmnvkd (Danh muc nhan vien kinh doanh)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_nvkd | varchar | 20 | Ma NVKD (khoa chinh) |
| ten_nvkd | nvarchar | 255 | Ten NVKD |
| ma_bp | varchar | 20 | Ma bo phan (lookup) |
| dien_thoai | varchar | 20 | So dien thoai |
| email | varchar | 100 | Email |
| dia_chi | nvarchar | 500 | Dia chi |
| hoat_dong | bit | 1 | Trang thai hoat dong |
| ma_user | varchar | 50 | Lien ket user he thong |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMBP | Bo phan | FK ma_bp -> DMBP.ma_bp |
| SO3 | Chung tu ban hang | FK ma_nvkd -> SO3 |

---

## Form classes

### 1. frmSODMNVKD (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvcMa_Nvkd | DataGridViewColumn | Ma NVKD |
| dgvcTen_Nvkd | DataGridViewColumn | Ten NVKD |
| dgvcMa_Bp | DataGridViewColumn | Ma bo phan |
| dgvcTen_Bp | DataGridViewColumn | Ten bo phan |
| dgvcDien_Thoai | DataGridViewColumn | Dien thoai |
| dgvcEmail | DataGridViewColumn | Email |

### 2. frmSODMNVKDEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Nvkd | AsTextBox | ma_nvkd | Ma NVKD |
| txtTen_Nvkd | TextBox | ten_nvkd | Ten NVKD |
| txtMa_Bp | AsTextBox | ma_bp | Ma bo phan (AutoLookup) |
| lblTen_Bp | Label | - | Ten bo phan hien thi |
| txtDien_Thoai | TextBox | dien_thoai | Dien thoai |
| txtEmail | TextBox | email | Email |
| txtDia_Chi | TextBox | dia_chi | Dia chi |
| chkHoat_Dong | AsCheckBox | hoat_dong | Trang thai |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMNVKD_GET | Lay danh sach |
| SP_SO_DMNVKD_GETBYID | Lay chi tiet |
| SP_SO_DMNVKD_INSERT | Them moi |
| SP_SO_DMNVKD_UPDATE | Cap nhat |
| SP_SO_DMNVKD_DELETE | Xoa |
| SP_SO_DMNVKD_FIND | Tim kiem |
| SP_SO_DMNVKD_CHECK | Kiem tra trung |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMNVKD_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_nvkd VARCHAR(20),
    @pTen_nvkd NVARCHAR(255),
    @pMa_bp VARCHAR(20),
    @pDien_thoai VARCHAR(20),
    @pEmail VARCHAR(100),
    @pDia_chi NVARCHAR(500),
    @pHoat_dong BIT,
    @pMa_user VARCHAR(50),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_nvkd | 'Ma NVKD khong duoc trong' |
| Unique | ma_nvkd | 'Ma NVKD da ton tai' |
| Required | ten_nvkd | 'Ten NVKD khong duoc trong' |
| Email format | email | 'Email khong dung dinh dang' |
| Phone format | dien_thoai | 'So dien thoai khong dung dinh dang' |

### Business Rules

1. **Ma_Bp Lookup**:
   - Lookup tu bang dmbp
   - Tu dong dien ten bo phan

2. **Lien ket user**:
   - NVKD co the lien ket voi user he thong (auth)
   - Khi login bang user nay, tu dong gan ma_nvkd

3. **Phan quyen xem du lieu**:
   - NVKD chi xem duoc don hang cua minh
   - Quan ly xem duoc don hang cua team

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMnvkd.php
namespace Diepxuan\Simba\Models\SO;

class DMnvkd extends Model
{
    protected $table = 'dmnvkd';
    protected $primaryKey = 'ma_nvkd';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nvkd', 'ten_nvkd', 'ma_bp',
        'dien_thoai', 'email', 'dia_chi',
        'hoat_dong', 'ma_user',
    ];

    protected $casts = [
        'hoat_dong' => 'boolean',
    ];

    public function boPhan()
    {
        return $this->belongsTo(DMBP::class, 'ma_bp', 'ma_bp');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ma_user', 'ma_user');
    }

    public function chungTus()
    {
        return $this->hasMany(SO3::class, 'ma_nvkd', 'ma_nvkd');
    }

    public function scopeActive($query)
    {
        return $query->where('hoat_dong', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_nvkd', 'like', "%{$search}%")
              ->orWhere('ten_nvkd', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetDMnvkd.php
class AsSOGetDMnvkd extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMNVKD_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsDMnvkd.php
class AsSOInsDMnvkd extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMNVKD_INSERT';
    protected $params = [
        'pMa_cty', 'pMa_nvkd', 'pTen_nvkd', 'pMa_bp',
        'pDien_thoai', 'pEmail', 'pDia_chi',
        'pHoat_dong', 'pMa_user',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdDMnvkd.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelDMnvkd.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Nhanvienkinhdoanh.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Nhanvienkinhdoanh;

class Nhanvienkinhdoanh extends Component
{
    public Collection $pList;
    public string $pSearch = '';

    public function mount(): void
    {
        $this->loadList();
    }

    public function render(): View
    {
        return view('catalog::so.nhanvienkinhdoanh');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/NhanvienkinhdoanhEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\NhanvienkinhdoanhEdit;

class NhanvienkinhdoanhEdit extends Component
{
    public ?string $pMaNvkd = null;
    public string $pTenNvkd = '';
    public string $pMaBp = '';
    public string $pTenBp = '';
    public string $pDienThoai = '';
    public string $pEmail = '';
    public string $pDiaChi = '';
    public bool $pHoatDong = true;
    public ?string $pMaUser = null;

    protected $rules = [
        'pMaNvkd' => 'required|string|max:20',
        'pTenNvkd' => 'required|string|max:255',
        'pEmail' => 'nullable|email|max:100',
    ];

    public function mount(?string $maNvkd = null): void
    {
        if ($maNvkd) {
            $this->pMaNvkd = $maNvkd;
            $this->loadData();
        }
    }

    public function updatedPMaBp($value): void
    {
        $bp = DMBP::find($value);
        $this->pTenBp = $bp->ten_bp ?? '';
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.nhanvienkinhdoanh-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── nhanvienkinhdoanh/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/nhan-vien-kinh-doanh', [Nhanvienkinhdoanh::class, 'render'])
            ->name('nhanvienkinhdoanh');
        Route::get('/nhan-vien-kinh-doanh/edit/{maNvkd?}', [NhanvienkinhdoanhEdit::class, 'render'])
            ->name('nhanvienkinhdoanh.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMnvkd.php | Chinh |
| Model | laravel-simba | DMBP.php | Bo phan |
| Model | App | User::class | User auth |
| SP | laravel-simba | AsSOGetDMnvkd.php | Get list |
| SP | laravel-simba | AsSOInsDMnvkd.php | Insert |
| SP | laravel-simba | AsSOUpdDMnvkd.php | Update |
| Component | laravel-catalog | Nhanvienkinhdoanh.php | List |
| Component | laravel-catalog | NhanvienkinhdoanhEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMnvkd
- [ ] Tao Livewire Nhanvienkinhdoanh (list)
- [ ] Tao Livewire NhanvienkinhdoanhEdit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Lookup bo phan
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
