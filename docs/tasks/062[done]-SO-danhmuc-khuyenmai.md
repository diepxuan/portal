# Task 062: SODMTKM

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc tra khuyen mai tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SODMTKM.dll
- **Chuc nang:** Quan ly danh muc tra khuyen mai (Danh muc tra tien khuyen mai cho dai ly)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc tra khuyen mua
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** TKM (Tra khuyen mai)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMTKM.dll/README.md`

---

## Cau truc du lieu

### Bang: DMTKM (Danh muc tra khuyen mai)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_km | varchar | 20 | Ma khuyen mai (FK - khoa chinh) |
| ma_vt | varchar | 20 | Ma vat tu (FK - khoa chinh) |
| sl_km | decimal | 18,2 | So luong khuyen mai |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |
| tien_km_nt | decimal | 18,2 | Tien KM ngoai te |
| tien_km | decimal | 18,2 | Tien KM VND |
| ksd | bit | 1 | Khoa su dung |

---

## Form classes

### 1. frmSODMTKM (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach tra KM, tim kiem, phan trang
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmSODMTKMEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin tra KM
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_km | AsTextBox | ma_km | Ma khuyen mai (lookup) |
| lblTen_km | Label | ten_km | Ten khuyen mai |
| txtMa_vt | AsTextBox | ma_vt | Ma vat tu (lookup) |
| lblTen_vt | Label | ten_vt | Ten vat tu |
| txtSo_luong | AsTextNumeric | sl_km | So luong KM |
| cboMa_Nt | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtTien_km_NT | AsTextNumeric | tien_km_nt | Tien KM ngoai te |
| txtTien_km | AsTextNumeric | tien_km | Tien KM VND |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_TKM_GET | Lay danh sach tra KM |
| SP_SO_TKM_GETBYID | Lay chi tiet |
| SP_SO_TKM_INSERT | Them moi |
| SP_SO_TKM_UPDATE | Cap nhat |
| SP_SO_TKM_DELETE | Xoa |
| SP_SO_TKM_FIND | Tim kiem |
| SP_SO_TKM_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
EXEC SP_SO_TKM_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_km VARCHAR(20),
    @pMa_vt VARCHAR(20),
    @pSl_km DECIMAL(18,2),
    @pMa_nt VARCHAR(3) = 'VND',
    @pTy_gia DECIMAL(18,4) = 1,
    @pTien_km_nt DECIMAL(18,2) = 0,
    @pTien_km DECIMAL(18,2) = 0,
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_km | 'Ma khuyen mai khong duoc trong' |
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Required | sl_km | 'So luong khuyen mai khong duoc trong' |
| Numeric | sl_km | 'So luong phai la so' |
| Positive | sl_km | 'So luong phai > 0' |
| Lookup valid | ma_km | 'Ma khuyen mai khong ton tai' |
| Lookup valid | ma_vt | 'Ma vat tu khong ton tai' |

### Business Rules

1. **Ma khuyen mai (ma_km)**:
   - Lookup tu bang MA_KM (danh muc chinh sach KM)
   - Tu dong hien thi ten_km khi nhap ma
   - Khong cho phep sua khi da co du lieu lien quan

2. **Ma vat tu (ma_vt)**:
   - Lookup tu bang DMVT (danh muc vat tu)
   - Tu dong hien thi ten_vt khi nhap ma
   - Khong cho phep sua khi da co du lieu lien quan

3. **Tinh toan tien KM**:
   - Tien_Km_Nt = So_luong * Gia_Km_Nt (neu co)
   - Tien_Km = Tien_Km_Nt * Ty_Gia

4. **Khoa sua dung (ksd)**:
   - Mac dinh = 0 (hoat dong)
   - Khi ksd = 1, khong hien thi trong danh sach chon

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMTKM.php
namespace Diepxuan\Simba\Models\SO;

class DMTKM extends Model
{
    protected $table = 'DMTKM';
    protected $primaryKey = ['ma_km', 'ma_vt'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_km',
        'ma_vt',
        'sl_km',
        'ma_nt',
        'ty_gia',
        'tien_km_nt',
        'tien_km',
        'ksd',
    ];

    protected $casts = [
        'sl_km' => 'decimal:2',
        'ty_gia' => 'decimal:4',
        'tien_km_nt' => 'decimal:2',
        'tien_km' => 'decimal:2',
        'ksd' => 'boolean',
    ];

    // Relationships
    public function khuyenMai()
    {
        return $this->belongsTo(DMTKMChinh::class, 'ma_km', 'ma_km');
    }

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    // Auto-calculate
    public function setSlKmAttribute($value): void
    {
        $this->attributes['sl_km'] = $value;
        $this->calculateTienKm();
    }

    public function setTienKmNtAttribute($value): void
    {
        $this->attributes['tien_km_nt'] = $value;
        $this->calculateTienKm();
    }

    public function setTyGiaAttribute($value): void
    {
        $this->attributes['ty_gia'] = $value;
        $this->calculateTienKm();
    }

    protected function calculateTienKm(): void
    {
        $tienNt = $this->tien_km_nt ?? 0;
        $tyGia = $this->ty_gia ?? 1;
        $this->attributes['tien_km'] = $tienNt * $tyGia;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoGetDMTKM.php
namespace Diepxuan\Simba\StoredProcedures;

class SoGetDMTKM extends StoredProcedure
{
    protected $procedure = 'SP_SO_TKM_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoInsDMTKM.php
class SoInsDMTKM extends StoredProcedure
{
    protected $procedure = 'SP_SO_TKM_INSERT';
    protected $params = [
        'pMa_cty', 'ma_km', 'ma_vt', 'sl_km',
        'ma_nt', 'ty_gia', 'tien_km_nt', 'tien_km', 'ksd',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoUpdDMTKM.php
// diepxuan/laravel-simba/src/StoredProcedures/SoDelDMTKM.php
// diepxuan/laravel-simba/src/StoredProcedures/SoChkDMTKM.php
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/TraKhuyenmai.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class TraKhuyenmai extends Component
{
    const MA_CT = 'TKM';

    public Collection $pTraKMs;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaKm = null;
    public ?string $pEditingMaVt = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadTraKM();
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.trakhuyenmai');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/TraKhuyenmaiEdit.php
class TraKhuyenmaiEdit extends Component
{
    public ?string $pMa_Km = null;
    public string $pTen_Km = '';
    public ?string $pMa_Vt = null;
    public string $pTen_Vt = '';
    public float $pSl_Km = 0;
    public string $pMa_Nt = 'VND';
    public float $pTy_Gia = 1;
    public float $pTien_Km_Nt = 0;
    public float $pTien_Km = 0;
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Km' => 'required|string|max:20',
        'pMa_Vt' => 'required|string|max:20',
        'pSl_Km' => 'required|numeric|min:0',
    ];

    public function updatedPMaKm($value): void
    {
        // Lookup ten khuyen mai
    }

    public function updatedPMaVt($value): void
    {
        // Lookup ten vat tu
    }

    public function updatedPSlKm($value): void
    {
        $this->calculate();
    }

    public function updatedPTienKmNt($value): void
    {
        $this->calculate();
    }

    public function updatedPTyGia($value): void
    {
        $this->calculate();
    }

    protected function calculate(): void
    {
        $this->pTien_Km = $this->pTien_Km_Nt * $this->pTy_Gia;
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.trakhuyenmai-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/so/danhmuc/
├── trakhuyenmai.blade.php        (List page)
├── trakhuyenmai-edit.blade.php   (Modal edit)
```

### 5. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/tra-khuyen-mai', [TraKhuyenmai::class, 'render'])
            ->name('trakhuyenmai');
        Route::get('/tra-khuyen-mai/edit/{maKm}/{maVt?}', [TraKhuyenmaiEdit::class, 'render'])
            ->name('trakhuyenmai.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMTKM.php | Chinh |
| Model | laravel-simba | DMTKMChinh.php | Chinh sach KM (lookup) |
| Model | laravel-simba | DMVT.php | Vat tu (lookup) |
| SP | laravel-simba | SoGetDMTKM.php | Get list |
| SP | laravel-simba | SoInsDMTKM.php | Insert |
| SP | laravel-simba | SoUpdDMTKM.php | Update |
| SP | laravel-simba | SoDelDMTKM.php | Delete |
| SP | laravel-simba | SoChkDMTKM.php | Check trung |
| Component | laravel-catalog | TraKhuyenmai.php | List |
| Component | laravel-catalog | TraKhuyenmaiEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMTKM
- [ ] Tao Livewire TraKhuyenmai (list)
- [ ] Tao Livewire TraKhuyenmaiEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTKMChinh, DMVT
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell)
- **Route:** `so.dict.tkm`
- **Note:** Shell metadata only; no SP/write until source wrapper and payload are audited.
