# Task 003: ARDMPLKH

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang danh muc phan loai khach hang tu .NET sang PHP Laravel, ho tro phan loai 3 cap (PL1, PL2, PL3).

## Chi tiet
- **DLL:** ARDMPLKH.dll
- **Chuc nang:** Quan ly danh muc phan loai khach hang
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (danh muc AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARDMPLKH.dll/README.md`

---

## Cau truc du lieu

### Bang: DMPLKH (Danh muc phan loai khach hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_plkh | varchar | 50 | Ma phan loai KH (khoa chinh) |
| ten_plkh | nvarchar | 200 | Ten phan loai KH |
| loai | int | 4 | Loai phan loai (1, 2, 3) |
| ghi_chu | nvarchar | 500 | Ghi chu |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

### Phan loai theo cap do

| Loai | Y nghia | Vi du |
|------|---------|-------|
| 1 | Phan loai chinh | Nganh nghe, linh vuc kinh doanh |
| 2 | Phan loai phu | Khu vuc dia ly, thi truong |
| 3 | Phan loai bo sung | Muc do quan trong, danh gia |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_plkh1/2/3 -> DMPLKH.ma_plkh |
| ARRptBCCN* | Cac bao cao cong no | Lookup ma_plkh |

---

## Form classes

### 1. frmARDMPLKH (Form xem danh sach)
- **Ke thua:** frmDmView
- **Chuc nang:** Hien thi danh sach phan loai KH, loc theo loai
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| cboLoai | ComboBox | loai | Loc theo loai phan loai |
| txtSearch | TextBox | - | Tim kiem theo ma/ten |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmARDMPLKHEdit (Form them/sua)
- **Ke thua:** frmDmEdit
- **Chuc nang:** Nhap, sua thong tin phan loai KH
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_PlKh | AsTextBox | ma_plkh | Ma phan loai KH (AutoLookup) |
| txtTen_PlKh | TextBox | ten_plkh | Ten phan loai KH |
| cboLoai | ComboBox | loai | Loai phan loai (1, 2, 3) |
| txtGhi_Chu | TextBox | ghi_chu | Ghi chu |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_DMPLKH_GET | Lay danh sach phan loai KH |
| SP_AR_DMPLKH_GETBYID | Lay chi tiet 1 phan loai KH |
| SP_AR_DMPLKH_INSERT | Them phan loai KH moi |
| SP_AR_DMPLKH_UPDATE | Cap nhat phan loai KH |
| SP_AR_DMPLKH_DELETE | Xoa phan loai KH |
| SP_AR_DMPLKH_FIND | Tim kiem phan loai KH |
| SP_AR_DMPLKH_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach phan loai KH
EXEC SP_AR_DMPLKH_GET
    @pMa_cty VARCHAR(50) = '001',
    @pLoai INT = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
-- Lay chi tiet 1 phan loai KH
EXEC SP_AR_DMPLKH_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pMa_plkh VARCHAR(50)
```

### SP_INSERT (reference)

```sql
-- Them phan loai KH moi
EXEC SP_AR_DMPLKH_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_plkh VARCHAR(50),
    @pTen_plkh NVARCHAR(200),
    @pLoai INT,
    @pGhi_chu NVARCHAR(500),
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_plkh | 'Ma phan loai khach hang khong duoc trong' |
| Max length 50 | ma_plkh | 'Ma phan loai khach hang toi da 50 ky tu' |
| Unique | ma_plkh + loai | 'Ma phan loai da ton tai trong loai nay' |
| Required | ten_plkh | 'Ten phan loai khach hang khong duoc trong' |
| Max length 200 | ten_plkh | 'Ten phan loai khach hang toi da 200 ky tu' |
| Required | loai | 'Loai phan loai khong duoc trong' |
| In range | loai | 'Loai phan loai phai la 1, 2 hoac 3' |
| Max length 500 | ghi_chu | 'Ghi chu toi da 500 ky tu' |

### Business Rules

1. **Ma phan loai KH**:
   - AutoGenerate neu de trong (PL + stt_rec)
   - Khong cho phep sua khi da co khach hang su dung

2. **Loai phan loai**:
   - Bat buoc chon 1, 2 hoac 3
   - Khong cho phep trung ma trong cung loai

3. **Ten phan loai KH**:
   - Bat buoc nhap
   - Khong phan biet hoa/thuong

4. **Khoa su dung (ksd)**:
   - Mac dinh = 0 (hoat dong)
   - Khi ksd = 1, phan loai KH khong hien thi trong danh sach chon

5. **Xoa phan loai KH**:
   - Kiem tra khong co khach hang thuoc phan loai
   - Neu co khach hang -> khong cho xoa

### Lookup Integration

- Duoc goi tu form ARDMKH (khach hang)
- Tra ve danh sach phan loai KH co ksd = 0 theo loai
- Su dung AutoLookupControl cho txtMa_PlKh

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/DMPLKH.php
namespace Diepxuan\Simba\Models\AR;

class DMPLKH extends Model
{
    protected $table = 'DMPLKH';
    protected $primaryKey = 'ma_plkh';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_plkh',
        'ten_plkh',
        'loai',
        'ghi_chu',
        'ksd',
    ];

    protected $casts = [
        'loai' => 'integer',
        'ksd' => 'boolean',
    ];

    // Relationships
    public function khachHangs1()
    {
        return $this->hasMany(DMKH::class, 'ma_plkh1', 'ma_plkh');
    }

    public function khachHangs2()
    {
        return $this->hasMany(DMKH::class, 'ma_plkh2', 'ma_plkh');
    }

    public function khachHangs3()
    {
        return $this->hasMany(DMKH::class, 'ma_plkh3', 'ma_plkh');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeByLoai($query, $loai)
    {
        return $query->where('loai', $loai);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_plkh', 'like', "%{$search}%")
              ->orWhere('ten_plkh', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetDMPLKH.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetDMPLKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_DMPLKH_GET';
    protected $params = [
        'pMa_cty',
        'pLoai',
        'pSearch',
        'pPageIndex',
        'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARInsDMPLKH.php
class AsARInsDMPLKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_DMPLKH_INSERT';
    protected $params = [
        'pMa_cty',
        'ma_plkh',
        'ten_plkh',
        'loai',
        'ghi_chu',
        'ksd',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARUpdDMPLKH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARDelDMPLKH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARChkDMPLKH.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Danhmuc/Phanloaikhachhang.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Danhmuc;

class Phanloaikhachhang extends Component
{
    const MA_CT = 'AR';

    public Collection $pPhanLoaiKhs;
    public ?int $pLoai = null;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaPlkh = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
        'pLoai' => 'nullable|integer|in:1,2,3',
    ];

    public function mount(): void
    {
        $this->loadPhanLoaiKH();
    }

    public function loadPhanLoaiKH(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::ar.danhmuc.phanloaikhachhang');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Danhmuc/PhanloaikhachhangEdit.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Danhmuc;

class PhanloaikhachhangEdit extends Component
{
    public ?string $pMa_Plkh = null;
    public string $pTen_Plkh = '';
    public int $pLoai = 1;
    public string $pGhi_Chu = '';
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Plkh' => 'required|string|max:50',
        'pTen_Plkh' => 'required|string|max:200',
        'pLoai' => 'required|integer|in:1,2,3',
        'pGhi_Chu' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'pMa_Plkh.required' => 'Ma phan loai khach hang khong duoc trong',
        'pTen_Plkh.required' => 'Ten phan loai khach hang khong duoc trong',
        'pLoai.in' => 'Loai phan loai phai la 1, 2 hoac 3',
    ];

    public function mount(?string $maPlkh = null): void
    {
        if ($maPlkh) {
            $this->pMa_Plkh = $maPlkh;
            $this->loadPhanLoaiKH();
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::ar.danhmuc.phanloaikhachhang-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/ar/danhmuc/
├── phanloaikhachhang.blade.php           (List page)
├── phanloaikhachhang-edit.blade.php      (Modal edit)
└── _phanloaikhachhang-row.blade.php      (Component row)
```

### 6. Routes

```php
// routes/web.php hoac routes/catalog.php
Route::prefix('catalog/ar/danhmuc')
    ->name('catalog.ar.danhmuc.')
    ->group(function () {
        Route::get('/phan-loai-khach-hang', [Phanloaikhachhang::class, 'render'])
            ->name('phanloaikhachhang');
        Route::get('/phan-loai-khach-hang/edit/{maPlkh?}', [PhanloaikhachhangEdit::class, 'render'])
            ->name('phanloaikhachhang.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMPLKH.php | Chinh |
| Model | laravel-simba | DMKH.php | Lien quan (FK) |
| SP | laravel-simba | AsARGetDMPLKH.php | Chinh |
| SP | laravel-simba | AsARInsDMPLKH.php | Insert |
| SP | laravel-simba | AsARUpdDMPLKH.php | Update |
| SP | laravel-simba | AsARDelDMPLKH.php | Delete |
| SP | laravel-simba | AsARChkDMPLKH.php | Check trung |
| Component | laravel-catalog | Phanloaikhachhang.php | List |
| Component | laravel-catalog | PhanloaikhachhangEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMPLKH
- [ ] Tao Livewire Phanloaikhachhang (list)
- [ ] Tao Livewire PhanloaikhachhangEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMKH (3 cap phan loai)