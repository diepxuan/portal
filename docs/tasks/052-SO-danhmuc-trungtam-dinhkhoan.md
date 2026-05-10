# Task 052: SODMTD

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc tram dinh khoan tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SODMTD.dll
- **Chuc nang:** Quan ly danh muc tram dinh khoan (Tuyen duong)
- **Loai:** Danh muc (DM)
- **Assembly Title:** SODMTD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** TD (Tram dinh khoan)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMTD.dll/README.md`

---

## Cau truc du lieu

### Bang: DMTD (Danh muc tram dinh khoan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_td | varchar | 8 | Ma tram dinh khoan (khoa chinh) |
| ten_td | nvarchar | 50 | Ten tram dinh khoan |
| km | decimal | 10,2 | Khoang cach (km) |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

---

## Form classes

### 1. frmSODMTD (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach tram, tim kiem, phan trang
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem theo ma/ten |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmSODMTDEDIT (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin tram dinh khoan
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Td | AsTextBox | ma_td | Ma tram (CharacterCasing=Upper) |
| txtTen_Td | TextBox | ten_td | Ten tram |
| txtKm | AsTextNumeric | km | Khoang cach (km) |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMTD_GET | Lay danh sach tram |
| SP_SO_DMTD_GETBYID | Lay chi tiet 1 tram |
| SP_SO_DMTD_INSERT | Them tram moi |
| SP_SO_DMTD_UPDATE | Cap nhat tram |
| SP_SO_DMTD_DELETE | Xoa tram |
| SP_SO_DMTD_FIND | Tim kiem |
| SP_SO_DMTD_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMTD_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_td VARCHAR(8),
    @pTen_td NVARCHAR(50),
    @pKm DECIMAL(10,2) = 0,
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_td | 'Ma tram dinh khoan khong duoc trong' |
| Max length 8 | ma_td | 'Ma tram dinh khoan toi da 8 ky tu' |
| Required | ten_td | 'Ten tram dinh khoan khong duoc trong' |
| Max length 50 | ten_td | 'Ten tram dinh khoan toi da 50 ky tu' |
| Numeric | km | 'Khoang cach phai la so' |

### Business Rules

1. **Ma tram (ma_td)**:
   - Max length: 8 ky tu
   - CharacterCasing: Upper
   - AutoGenerate neu de trong

2. **Khoang cach (km)**:
   - Don vi: km (kilomet)
   - Format: `### ### ### ###` (decimal)
   - Gia tri mac dinh: 0

3. **Khoa su dung (ksd)**:
   - Mac dinh = 0 (hoat dong)
   - Khi ksd = 1, tram khong hien thi trong danh sach chon

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMTD.php
namespace Diepxuan\Simba\Models\SO;

class DMTD extends Model
{
    protected $table = 'DMTD';
    protected $primaryKey = 'ma_td';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_td',
        'ten_td',
        'km',
        'ksd',
    ];

    protected $casts = [
        'km' => 'decimal:2',
        'ksd' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_td', 'like', "%{$search}%")
              ->orWhere('ten_td', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoGetDMTD.php
namespace Diepxuan\Simba\StoredProcedures;

class SoGetDMTD extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMTD_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoInsDMTD.php
class SoInsDMTD extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMTD_INSERT';
    protected $params = ['pMa_cty', 'ma_td', 'ten_td', 'km', 'ksd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoUpdDMTD.php
// diepxuan/laravel-simba/src/StoredProcedures/SoDelDMTD.php
// diepxuan/laravel-simba/src/StoredProcedures/SoChkDMTD.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Tramdinhkhoan.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Tramdinhkhoan extends Component
{
    const MA_CT = 'TD';

    public Collection $pTrams;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaTd = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadTram();
    }

    public function loadTram(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.tramdinhkhoan');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/TramdinhkhoanEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class TramdinhkhoanEdit extends Component
{
    public ?string $pMa_Td = null;
    public string $pTen_Td = '';
    public float $pKm = 0;
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Td' => 'required|string|max:8',
        'pTen_Td' => 'required|string|max:50',
        'pKm' => 'nullable|numeric|min:0',
    ];

    protected $messages = [
        'pMa_Td.required' => 'Ma tram dinh khoan khong duoc trong',
        'pMa_Td.max' => 'Ma tram dinh khoan toi da 8 ky tu',
        'pTen_Td.required' => 'Ten tram dinh khoan khong duoc trong',
        'pTen_Td.max' => 'Ten tram dinh khoan toi da 50 ky tu',
    ];

    public function mount(?string $maTd = null): void
    {
        if ($maTd) {
            $this->pMa_Td = $maTd;
            $this->loadTram();
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.tramdinhkhoan-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/danhmuc/
├── tramdinhkhoan.blade.php        (List page)
├── tramdinhkhoan-edit.blade.php   (Modal edit)
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/tram-dinh-khoan', [Tramdinhkhoan::class, 'render'])
            ->name('tramdinhkhoan');
        Route::get('/tram-dinh-khoan/edit/{maTd?}', [TramdinhkhoanEdit::class, 'render'])
            ->name('tramdinhkhoan.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMTD.php | Chinh |
| SP | laravel-simba | SoGetDMTD.php | Get list |
| SP | laravel-simba | SoInsDMTD.php | Insert |
| SP | laravel-simba | SoUpdDMTD.php | Update |
| SP | laravel-simba | SoDelDMTD.php | Delete |
| SP | laravel-simba | SoChkDMTD.php | Check trung |
| Component | laravel-catalog | Tramdinhkhoan.php | List |
| Component | laravel-catalog | TramdinhkhoanEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMTD
- [ ] Tao Livewire Tramdinhkhoan (list)
- [ ] Tao Livewire TramdinhkhoanEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi van chuyen
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
