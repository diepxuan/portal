# Task 228: INVchIN5

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang phieu xuat cong cu dung cu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INVchIN5.dll
- **Chuc nang:** Phieu xuat cong cu dung cu (CCDC)
- **Loai:** Chung tu (Voucher)
- **Assembly Title:** Phieu xuat cong cu dung cu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN5 (Phieu xuat CCDC)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INVchIN5.dll/README.md`

---

## Cau truc du lieu

### Bang: INPHIEUXCC (Phieu xuat CCDC - Header)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| ma_kh | varchar | 50 | Ma khach hang/nhan vien |
| ten_kh | nvarchar | 200 | Ten |
| dia_chi | nvarchar | 500 | Dia chi |
| nguoi_gd | nvarchar | 200 | Nguoi giao dich |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,6 | Ty gia |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| tien | decimal | 18,2 | Tien VND |
| stt_rec | varchar | 50 | STT record |

### Bang: INCTXCC (Chi tiet xuat CCDC)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | STT header |
| stt_rec0 | varchar | 50 | STT detail |
| ma_cc | varchar | 50 | Ma cong cu dung cu |
| ten_cc | nvarchar | 200 | Ten CCDC |
| dvt | varchar | 20 | Don vi tinh |
| ma_kho | varchar | 50 | Ma kho xuat |
| so_luong | decimal | 18,6 | So luong xuat |
| so_ky | int | 4 | So ky phan bo |
| gia_nt | decimal | 18,6 | Gia ngoai te |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| gia | decimal | 18,2 | Gia VND |
| tien | decimal | 18,2 | Tien VND |
| tk_pb | varchar | 20 | TK phan bo |
| tk_cp | varchar | 20 | TK chi phi |
| tk_cc | varchar | 20 | TK cong cu |
| ma_bpsd | varchar | 50 | Ma bo phan su dung |
| ma_bp | varchar | 50 | Ma bo phan |
| ma_spct | varchar | 50 | Ma san pham chi tiet |
| ma_phi | varchar | 50 | Ma phi |
| ma_lo | varchar | 50 | Ma lo |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMCC | Danh muc cong cu | FK ma_cc |
| DMKHO | Danh muc kho | FK ma_kho |

---

## Form classes

### 1. frmInVchIN5 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap phieu xuat CCDC
- **Controls:** Tuong tu INVchIN2 nhung bo sung so_ky phan bo

### 2. frmInVchIN5Find (Form tim kiem)

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_VCHIN5_GET | Lay danh sach phieu xuat CCDC |
| SP_IN_VCHIN5_GETBYID | Lay chi tiet 1 phieu |
| SP_IN_VCHIN5_INSERT | Them phieu xuat CCDC |
| SP_IN_VCHIN5_UPDATE | Cap nhat phieu xuat CCDC |
| SP_IN_VCHIN5_DELETE | Xoa phieu xuat CCDC |
| SP_IN_VCHIN5_FIND | Tim kiem phieu xuat CCDC |

---

## Business Logic

### Business Rules

1. **Phan bo CCDC**:
   - CCDC duoc phan bo theo ky (so_ky)
   - Tinh chi phi phan bo = Tien / so_ky

2. **Tai khoan**:
   - TK phan bo (tk_pb): tai khoan ghi nhan chi phi phan bo
   - TK chi phi (tk_cp): tai khoan chi phi chinh
   - TK cong cu (tk_cc): tai khoan cong cu

3. **Bo phan su dung**:
   - Theo doi bo phan su dung CCDC
   - Phan bo chi phi theo bo phan

---

## Mapping PHP

### 1. Models

```php
// app/Models/IN/INPHIEUXCC.php
namespace Diepxuan\Simba\Models\IN;

class INPHIEUXCC extends Model
{
    protected $table = 'INPHIEUXCC';
    protected $primaryKey = 'stt_rec';
    public $incrementing = false;
    protected $connection = 'simba';

    public function chiTiets()
    {
        return $this->hasMany(INCTXCC::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetXuatCC.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetXuatCC extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN5_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsXuatCC.php
class AsINInsXuatCC extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN5_INSERT';
    protected $params = [
        'pMa_cty', 'stt_rec', 'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh',
        'dia_chi', 'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia',
        'tien_nt', 'tien',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdXuatCC.php
class AsINUpdXuatCC extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN5_UPDATE';
    protected $params = [
        'pMa_cty', 'stt_rec', 'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh',
        'dia_chi', 'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia',
        'tien_nt', 'tien',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelXuatCC.php
class AsINDelXuatCC extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN5_DELETE';
    protected $params = ['pMa_cty', 'stt_rec'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChkXuatCC.php
class AsINChkXuatCC extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN5_CHECK';
    protected $params = ['pMa_cty', 'so_ct'];
}
```

### 3. Models

```php
// app/Models/IN/INPHIEUXCC.php
namespace Diepxuan\Simba\Models\IN;

class INPHIEUXCC extends Model
{
    protected $table = 'INPHIEUXCC';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh', 'dia_chi',
        'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia', 'tien_nt', 'tien',
        'stt_rec',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:6',
        'tien_nt' => 'decimal:2',
        'tien' => 'decimal:2',
    ];

    public function chiTiets()
    {
        return $this->hasMany(INCTXCC::class, 'stt_rec', 'stt_rec');
    }
}

// app/Models/IN/INCTXCC.php
class INCTXCC extends Model
{
    protected $table = 'INCTXCC';
    protected $primaryKey = 'stt_rec0';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'stt_rec0', 'ma_cc', 'ten_cc', 'dvt', 'ma_kho',
        'so_luong', 'so_ky', 'gia_nt', 'tien_nt', 'gia', 'tien',
        'tk_pb', 'tk_cp', 'tk_cc', 'ma_bpsd', 'ma_bp', 'ma_spct',
        'ma_phi', 'ma_lo',
    ];

    protected $casts = [
        'so_luong' => 'decimal:6',
        'so_ky' => 'integer',
        'gia_nt' => 'decimal:6',
        'tien_nt' => 'decimal:2',
        'gia' => 'decimal:2',
        'tien' => 'decimal:2',
    ];

    public function phieu()
    {
        return $this->belongsTo(INPHIEUXCC::class, 'stt_rec', 'stt_rec');
    }

    public function congCu()
    {
        return $this->belongsTo(DMCC::class, 'ma_cc', 'ma_cc');
    }

    public function kho()
    {
        return $this->belongsTo(DMKHO::class, 'ma_kho', 'ma_kho');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Chungtu/XuatCongcuEdit.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Chungtu;

class XuatCongcuEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pSoCt = '';
    public ?Carbon $pNgayCt = null;
    public ?string $pMaKh = null;
    public string $pTenKh = '';
    public string $pDienGiai = '';
    public ?string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public float $pTienNt = 0;
    public float $pTien = 0;
    public Collection $pChiTiets;
    public ?string $pMode = 'create';

    protected $rules = [
        'pSoCt' => 'required|string|max:50',
        'pNgayCt' => 'required|date',
        'pChiTiets' => 'required|min:1',
    ];

    public function mount(?string $sttRec = null): void
    {
        $this->pNgayCt = now();
        $this->pChiTiets = collect([]);
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadPhieu();
        }
    }

    public function tinhPhanBo(): float
    {
        // Chi phi phan bo = Tien / so_ky
        return 0;
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::in.chungtu.xuat-congcu-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/in/chungtu/
├── xuat-congcu.blade.php              (List page)
├── xuat-congcu-edit.blade.php         (Edit modal + detail grid)
├── xuat-congcu-find.blade.php         (Search form)
└── _xuat-congcu-row.blade.php         (Component row)
```

### 6. Routes

```php
Route::prefix('catalog/in/chungtu')
    ->name('catalog.in.chungtu.')
    ->group(function () {
        Route::get('/xuat-congcu', [XuatCongcu::class, 'render'])
            ->name('xuat-congcu');
        Route::get('/xuat-congcu/edit/{sttRec?}', [XuatCongcuEdit::class, 'render'])
            ->name('xuat-congcu.edit');
        Route::get('/xuat-congcu/search', [XuatCongcuFind::class, 'render'])
            ->name('xuat-congcu.search');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | INPHIEUXCC.php | Header |
| Model | laravel-simba | INCTXCC.php | Detail |
| Model | laravel-simba | DMCC.php | Cong cu (FK) |
| Model | laravel-simba | DMKHO.php | Kho (FK) |
| SP | laravel-simba | AsINGetXuatCC.php | Get |
| SP | laravel-simba | AsINInsXuatCC.php | Insert |
| SP | laravel-simba | AsINUpdXuatCC.php | Update |
| SP | laravel-simba | AsINDelXuatCC.php | Delete |
| SP | laravel-simba | AsINChkXuatCC.php | Check trung |
| Component | laravel-catalog | XuatCongcu.php | List |
| Component | laravel-catalog | XuatCongcuEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Models INPHIEUXCC, INCTXCC
- [ ] Tao Livewire XuatCongcu (list)
- [ ] Tao Livewire XuatCongcuEdit (form nhap lieu + detail grid)
- [ ] Tao Livewire XuatCongcuFind (search)
- [ ] Tao Views (list + edit + search)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test phan bo ky & tai khoan