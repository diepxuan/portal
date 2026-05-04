# Task 002: ARDMNHKH

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang danh muc nhom khach hang tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** ARDMNHKH.dll
- **Chuc nang:** Quan ly danh muc nhom khach hang
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (danh muc AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARDMNHKH.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNHKH (Danh muc nhom khach hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_nhkh | varchar | 50 | Ma nhom KH (khoa chinh) |
| ten_nhkh | nvarchar | 200 | Ten nhom KH |
| ghi_chu | nvarchar | 500 | Ghi chu |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_nhkh -> DMNHKH.ma_nhkh |
| ARRptBCCN* | Cac bao cao cong no | Lookup ma_nhkh |

---

## Form classes

### 1. frmARDMNHKH (Form xem danh sach)
- **Ke thua:** frmDmView
- **Chuc nang:** Hien thi danh sach nhom KH, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma/ten |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmARDMNHKHEdit (Form them/sua)
- **Ke thua:** frmDmEdit
- **Chuc nang:** Nhap, sua thong tin nhom KH
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_NhKh | AsTextBox | ma_nhkh | Ma nhom KH (AutoLookup) |
| txtTen_NhKh | TextBox | ten_nhkh | Ten nhom KH |
| txtGhi_Chu | TextBox | ghi_chu | Ghi chu |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_DMNHKH_GET | Lay danh sach nhom KH |
| SP_AR_DMNHKH_GETBYID | Lay chi tiet 1 nhom KH |
| SP_AR_DMNHKH_INSERT | Them nhom KH moi |
| SP_AR_DMNHKH_UPDATE | Cap nhat nhom KH |
| SP_AR_DMNHKH_DELETE | Xoa nhom KH |
| SP_AR_DMNHKH_FIND | Tim kiem nhom KH |
| SP_AR_DMNHKH_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach nhom KH
EXEC SP_AR_DMNHKH_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
-- Lay chi tiet 1 nhom KH
EXEC SP_AR_DMNHKH_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pMa_nhkh VARCHAR(50)
```

### SP_INSERT (reference)

```sql
-- Them nhom KH moi
EXEC SP_AR_DMNHKH_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_nhkh VARCHAR(50),
    @pTen_nhkh NVARCHAR(200),
    @pGhi_chu NVARCHAR(500),
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_nhkh | 'Ma nhom khach hang khong duoc trong' |
| Max length 50 | ma_nhkh | 'Ma nhom khach hang toi da 50 ky tu' |
| Unique | ma_nhkh | 'Ma nhom khach hang da ton tai' |
| Required | ten_nhkh | 'Ten nhom khach hang khong duoc trong' |
| Max length 200 | ten_nhkh | 'Ten nhom khach hang toi da 200 ky tu' |
| Max length 500 | ghi_chu | 'Ghi chu toi da 500 ky tu' |

### Business Rules

1. **Ma nhom KH**:
   - AutoGenerate neu de trong (AR + stt_rec)
   - Khong cho phep sua khi da co khach hang thuoc nhom

2. **Ten nhom KH**:
   - Bat buoc nhap
   - Khong phan biet hoa/thuong

3. **Khoa su dung (ksd)**:
   - Mac dinh = 0 (hoat dong)
   - Khi ksd = 1, nhom KH khong hien thi trong danh sach chon

4. **Xoa nhom KH**:
   - Kiem tra khong co khach hang thuoc nhom
   - Neu co khach hang -> khong cho xoa

### Lookup Integration

- Duoc goi tu form ARDMKH (khach hang)
- Tra ve danh sach nhom KH co ksd = 0
- Su dung AutoLookupControl cho txtMa_NhKh

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/DMNHKH.php
namespace Diepxuan\Simba\Models\AR;

class DMNHKH extends Model
{
    protected $table = 'DMNHKH';
    protected $primaryKey = 'ma_nhkh';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nhkh',
        'ten_nhkh',
        'ghi_chu',
        'ksd',
    ];

    protected $casts = [
        'ksd' => 'boolean',
    ];

    // Relationships
    public function khachHangs()
    {
        return $this->hasMany(DMKH::class, 'ma_nhkh', 'ma_nhkh');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_nhkh', 'like', "%{$search}%")
              ->orWhere('ten_nhkh', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetDMNHKH.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetDMNHKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_DMNHKH_GET';
    protected $params = [
        'pMa_cty',
        'pSearch',
        'pPageIndex',
        'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARInsDMNHKH.php
class AsARInsDMNHKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_DMNHKH_INSERT';
    protected $params = [
        'pMa_cty',
        'ma_nhkh',
        'ten_nhkh',
        'ghi_chu',
        'ksd',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARUpdDMNHKH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARDelDMNHKH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARChkDMNHKH.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Danhmuc/Nhomkhachhang.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Danhmuc;

class Nhomkhachhang extends Component
{
    const MA_CT = 'AR';

    public Collection $pNhomKhs;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaNhkh = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadNhomKH();
    }

    public function loadNhomKH(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::ar.danhmuc.nhomkhachhang');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Danhmuc/NhomkhachhangEdit.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Danhmuc;

class NhomkhachhangEdit extends Component
{
    public ?string $pMa_Nhkh = null;
    public string $pTen_Nhkh = '';
    public string $pGhi_Chu = '';
    public bool $pKsd = false;
    public ?string $pMode = 'create'; // 'create' | 'edit'

    protected $rules = [
        'pMa_Nhkh' => 'required|string|max:50|unique:DMNHKH,ma_nhkh',
        'pTen_Nhkh' => 'required|string|max:200',
        'pGhi_Chu' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'pMa_Nhkh.required' => 'Ma nhom khach hang khong duoc trong',
        'pMa_Nhkh.unique' => 'Ma nhom khach hang da ton tai',
        'pTen_Nhkh.required' => 'Ten nhom khach hang khong duoc trong',
    ];

    public function mount(?string $maNhkh = null): void
    {
        if ($maNhkh) {
            $this->pMa_Nhkh = $maNhkh;
            $this->loadNhomKH();
        }
    }

    public function updatedPMaNhkh($value): void
    {
        // Validate & auto-fill
    }

    public function submit(): void
    {
        $this->validate();

        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function delete(): void
    {
        // Kiem tra rang buoc & goi SP_DELETE
    }

    public function render(): View
    {
        return view('catalog::ar.danhmuc.nhomkhachhang-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/ar/danhmuc/
├── nhomkhachhang.blade.php      (List page)
├── nhomkhachhang-edit.blade.php (Modal edit)
└── _nhomkhachhang-row.blade.php (Component row)
```

### 6. Routes

```php
// routes/web.php hoac routes/catalog.php
Route::prefix('catalog/ar/danhmuc')
    ->name('catalog.ar.danhmuc.')
    ->group(function () {
        Route::get('/nhom-khach-hang', [Nhomkhachhang::class, 'render'])
            ->name('nhomkhachhang');
        Route::get('/nhom-khach-hang/edit/{maNhkh?}', [NhomkhachhangEdit::class, 'render'])
            ->name('nhomkhachhang.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMNHKH.php | Chinh |
| Model | laravel-simba | DMKH.php | Lien quan (FK) |
| SP | laravel-simba | AsARGetDMNHKH.php | Chinh |
| SP | laravel-simba | AsARInsDMNHKH.php | Insert |
| SP | laravel-simba | AsARUpdDMNHKH.php | Update |
| SP | laravel-simba | AsARDelDMNHKH.php | Delete |
| SP | laravel-simba | AsARChkDMNHKH.php | Check trung |
| Component | laravel-catalog | Nhomkhachhang.php | List |
| Component | laravel-catalog | NhomkhachhangEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMNHKH
- [ ] Tao Livewire Nhomkhachhang (list)
- [ ] Tao Livewire NhomkhachhangEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMKH
