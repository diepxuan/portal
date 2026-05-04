# Task 115: INCDVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang nhap so ton dau ky tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INCDVT.dll
- **Chuc nang:** Nhap so ton kho dau ky
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Nhap so ton kho dau ky
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** IN (opening balance)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INCDVT.dll/README.md`

---

## Cau truc du lieu

### Bang: INCDVT (So ton dau ky vat tu)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| nam | int | Nam tai chinh |
| ma_vt | varchar | Ma vat tu |
| tk_vt | varchar | TK vat tu |
| ma_kho | varchar | Ma kho |
| ma_lo | varchar | Ma lo |
| ma_nt | varchar | Ma ngoai te |
| so_luong | decimal | So luong |
| tien_nt | decimal | Tien ngoai te |
| tien | decimal | Tien VND |

---

## Form classes

### 1. frmINCDVT (Form xem danh sach)
- **Ke thua:** frmOBView
- **Controls:** btn_SDTK (chuyen so du sang tai khoan), dgvDM, cmdAdd, cmdEdit, cmdDel, cmdClose

### 2. frmINCDVTEdit (Form nhap lieu)
- **Ke thua:** frmOBEdit
- **Controls:** txtYear (nam, readonly), txtMa_vt, txtTk_vt, txtMa_kho, txtMa_lo, cboMa_Nt, txtSo_luong, txtTien_nt, txtTien_vnd, chkKsd

### 3. frmINCDVTFilter (Form loc)
- **Ke thua:** frmOBFilter
- **Controls:** txtYear (nam, readonly), txtMa_kho, txtMa_vt, txtMa_tkvt

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_INCDVT_GET | Lay danh sach so ton dau ky |
| SP_IN_INCDVT_GETBYID | Lay chi tiet 1 ban ghi |
| SP_IN_INCDVT_INSERT | Them so ton dau ky |
| SP_IN_INCDVT_UPDATE | Cap nhat so ton dau ky |
| SP_IN_INCDVT_DELETE | Xoa so ton dau ky |
| SP_IN_INCDVT_FIND | Tim kiem so ton dau ky |
| SP_IN_INCDVT_CHECK | Kiem tra trung |
| SP_IN_INCDVT_CHUYEN_SO_DU | Chuyen so du ton kho sang tai khoan GL |

### SP_GET (reference)

```sql
-- Lay danh sach so ton dau ky
EXEC SP_IN_INCDVT_GET
    @pNam INT,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_tkvt VARCHAR(50) = NULL
```

### SP_CHUYEN_SO_DU (reference)

```sql
-- Chuyen so du ton kho sang tai khoan GL
EXEC SP_IN_INCDVT_CHUYEN_SO_DU
    @pNam INT,
    @pMa_kho VARCHAR(50) = NULL,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | nam | 'Nam tai chinh khong duoc trong' |
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Required | ma_kho | 'Ma kho khong duoc trong' |
| Numeric >= 0 | so_luong | 'So luong phai >= 0' |
| Not editable | gia_ton=2 | 'Khong sua/xoa vat tu tinh gia NTXT' |

### Business Rules

1. **Khong sua/xoa**: Voi vat tu co gia_ton = "2" (tinh gia NTXT)
2. **Chuyen so du**: btn_SDTK chuyen ton kho sang tai khoan GL
3. **Tien VND**: Tinh tu tien_nt * ty_gia hoac nhap truc tiep

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/INCDVT.php
namespace Diepxuan\Simba\Models\IN;

class INCDVT extends Model
{
    protected $table = 'INCDVT';
    protected $primaryKey = ['nam', 'ma_vt', 'ma_kho', 'ma_lo'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'nam', 'ma_vt', 'tk_vt', 'ma_kho', 'ma_lo',
        'ma_nt', 'so_luong', 'tien_nt', 'tien',
    ];

    protected $casts = [
        'nam' => 'integer',
        'so_luong' => 'decimal:8',
        'tien_nt' => 'decimal:8',
        'tien' => 'decimal:8',
    ];

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function kho()
    {
        return $this->belongsTo(DMKHO::class, 'ma_kho', 'ma_kho');
    }

    public function lo()
    {
        return $this->belongsTo(DMLO::class, 'ma_lo', 'ma_lo');
    }

    public function scopeByNam($query, int $nam)
    {
        return $query->where('nam', $nam);
    }

    public function scopeByKho($query, string $ma_kho)
    {
        return $query->where('ma_kho', $ma_kho);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetINCDVT.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetINCDVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDVT_GET';
    protected $params = ['pNam', 'pMa_kho', 'pMa_vt', 'pMa_tkvt'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsINCDVT.php
class AsINInsINCDVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDVT_INSERT';
    protected $params = ['pNam', 'ma_vt', 'tk_vt', 'ma_kho', 'ma_lo', 'ma_nt', 'so_luong', 'tien_nt', 'tien'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdINCDVT.php
class AsINUpdINCDVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDVT_UPDATE';
    protected $params = ['pNam', 'ma_vt', 'tk_vt', 'ma_kho', 'ma_lo', 'ma_nt', 'so_luong', 'tien_nt', 'tien'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelINCDVT.php
class AsINDelINCDVT extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDVT_DELETE';
    protected $params = ['pNam', 'ma_vt', 'ma_kho', 'ma_lo'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChuyenSoDu.php
class AsINChuyenSoDu extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDVT_CHUYEN_SO_DU';
    protected $params = ['pNam', 'pMa_kho'];
}
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Tondauky.php
namespace Diepxuan\Catalog\Http\Livewire\IN;

class Tondauky extends Component
{
    const MA_CT = 'IN';

    public Collection $pDanhSach;
    public int $pNam;
    public ?string $pMa_Kho = null;
    public ?string $pMa_Vt = null;
    public ?string $pMa_Tkvt = null;

    public function mount(): void
    {
        $this->pNam = (int) date('Y');
        $this->loadDanhSach();
    }

    public function loadDanhSach(): void
    {
        // Load tu SP_IN_INCDVT_GET
    }

    public function chuyenSoDu(): void
    {
        // Goi SP_IN_INCDVT_CHUYEN_SO_DU
    }

    public function render(): View
    {
        return view('catalog::in.ton-dau-ky');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/TondaukyEdit.php
class TondaukyEdit extends Component
{
    public int $pNam;
    public ?string $pMa_Vt = null;
    public string $pTen_Vt = '';
    public ?string $pTk_Vt = null;
    public ?string $pMa_Kho = null;
    public string $pTen_Kho = '';
    public ?string $pMa_Lo = null;
    public string $pTen_Lo = '';
    public ?string $pMa_Nt = 'VND';
    public float $pTyGia = 1;
    public float $pSo_Luong = 0;
    public float $pTien_Nt = 0;
    public float $pTien = 0;
    public bool $pKsd = false;
    public bool $pGiaTon_NTXT = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Vt' => 'required|string|max:50',
        'pMa_Kho' => 'required|string|max:50',
        'pSo_Luong' => 'required|numeric|min:0',
    ];

    public function mount(int $nam, ?string $maVt = null, ?string $maKho = null, ?string $maLo = null): void
    {
        $this->pNam = $nam;
        if ($maVt) {
            $this->pMa_Vt = $maVt;
            $this->pMa_Kho = $maKho;
            $this->loadRecord();
        }
    }

    public function submit(): void
    {
        if ($this->pGiaTon_NTXT) {
            session()->flash('error', 'Khong sua/xoa vat tu tinh gia NTXT');
            return;
        }
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::in.ton-dau-ky-edit');
    }
}
```

### 5. Livewire Component (Filter)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/TondaukyFilter.php
class TondaukyFilter extends Component
{
    public int $pNam;
    public ?string $pMa_Kho = null;
    public ?string $pMa_Vt = null;
    public ?string $pMa_Tkvt = null;

    public function applyFilter(): void
    {
        $this->emit('filterApplied', [
            'nam' => $this->pNam,
            'ma_kho' => $this->pMa_Kho,
            'ma_vt' => $this->pMa_Vt,
            'ma_tkvt' => $this->pMa_Tkvt,
        ]);
    }

    public function render(): View
    {
        return view('catalog::in.ton-dau-ky-filter');
    }
}
```

### 6. Views

```
resources/views/catalog/in/
├── ton-dau-ky.blade.php              (List page)
├── ton-dau-ky-edit.blade.php         (Modal edit)
├── ton-dau-ky-filter.blade.php       (Filter form)
└── _ton-dau-ky-row.blade.php         (Component row)
```

### 7. Routes

```php
Route::prefix('catalog/in')
    ->name('catalog.in.')
    ->group(function () {
        Route::get('/ton-dau-ky', [Tondauky::class, 'render'])
            ->name('ton-dau-ky');
        Route::get('/ton-dau-ky/edit/{nam}/{maVt?}/{maKho?}/{maLo?}', [TondaukyEdit::class, 'render'])
            ->name('ton-dau-ky.edit');
        Route::post('/ton-dau-ky/chuyen-so-du', [Tondauky::class, 'chuyenSoDu'])
            ->name('ton-dau-ky.chuyen-so-du');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | INCDVT.php | Chinh |
| Model | laravel-simba | DMVT.php | Lien quan (FK) |
| Model | laravel-simba | DMKHO.php | Lien quan (FK) |
| Model | laravel-simba | DMLO.php | Lien quan (FK) |
| SP | laravel-simba | AsINGetINCDVT.php | Get |
| SP | laravel-simba | AsINInsINCDVT.php | Insert |
| SP | laravel-simba | AsINUpdINCDVT.php | Update |
| SP | laravel-simba | AsINDelINCDVT.php | Delete |
| SP | laravel-simba | AsINChuyenSoDu.php | Chuyen so du |
| Component | laravel-catalog | Tondauky.php | List |
| Component | laravel-catalog | TondaukyEdit.php | Edit |
| Component | laravel-catalog | TondaukyFilter.php | Filter |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check, ChuyenSoDu)
- [ ] Tao Model INCDVT
- [ ] Tao Livewire Tondauky (list)
- [ ] Tao Livewire TondaukyEdit (modal)
- [ ] Tao Livewire TondaukyFilter (filter)
- [ ] Tao Views (list + edit + filter)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test chuc nang chuyen so du (btn_SDTK)
- [ ] Test kiem tra gia_ton=2 khong cho sua/xoa