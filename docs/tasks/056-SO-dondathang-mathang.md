# Task 056: SOND51mathd

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc ma hoa don tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SOND51mathd.dll
- **Chuc nang:** Quan ly danh muc ma hoa don (Seri hoa don)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.DataAccess`
- **Company:** Asia Software Development JSC
- **Ma_ct:** MHD (Ma hoa don)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51mathd.dll/README.md`

---

## Cau truc du lieu

### Bang: DMMATHD (Danh muc ma hoa don)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_tb | varchar | 20 | Ma to bao cao (khoa chinh) |
| ma_chung | varchar | 50 | Ma chung |
| ten_loai | nvarchar | 200 | Ten loai hoa don |
| mau_so | varchar | 50 | Mau so hoa don |
| so_seri | varchar | 50 | So seri hoa don |
| tu_so | int | 4 | Tu so |
| den_so | int | 4 | Den so |
| so_luong | int | 4 | So luong hoa don |
| lien_hd | int | 2 | So lien hoa don |
| ghi_chu | nvarchar | 500 | Ghi chu |
| ksd | bit | 1 | Khoa su dung |

---

## DAO Interface

### SOND51mathdDAO Methods

| Method | Parameters | Return | Mo ta |
|--------|------------|--------|-------|
| `GetData` | `string ma_tb` | DataTable | Lay du lieu theo ma to bao cao |
| `GetData` | `string ngay1, string ngay2` | DataTable | Lay du lieu theo khoang thoi gian |
| `Insert` | `ma_tb, ma_chung, ten_loai, mau_so, so_seri, tu_so, den_so, so_luong, lien_hd, ghi_chu` | int | Them moi ma hoa don |
| `Delete` | `string ma_tb` | int | Xoa ma hoa don |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_MATHD_GET | Lay danh sach ma hoa don |
| SP_SO_MATHD_GETBYID | Lay chi tiet 1 ma hoa don |
| SP_SO_MATHD_INSERT | Them ma hoa don moi |
| SP_SO_MATHD_UPDATE | Cap nhat ma hoa don |
| SP_SO_MATHD_DELETE | Xoa ma hoa don |
| SP_SO_MATHD_FIND | Tim kiem |
| SP_SO_MATHD_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
EXEC SP_SO_MATHD_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_tb VARCHAR(20),
    @pMa_chung VARCHAR(50) = NULL,
    @pTen_loai NVARCHAR(200),
    @pMau_so VARCHAR(50),
    @pSo_seri VARCHAR(50),
    @pTu_so INT,
    @pDen_so INT,
    @pSo_luong INT = NULL,
    @pLien_hd INT = 2,
    @pGhi_chu NVARCHAR(500) = NULL,
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_tb | 'Ma to bao cao khong duoc trong' |
| Required | ten_loai | 'Ten loai hoa don khong duoc trong' |
| Required | mau_so | 'Mau so khong duoc trong' |
| Required | so_seri | 'So seri khong duoc trong' |
| Required | tu_so | 'Tu so khong duoc trong' |
| Required | den_so | 'Den so khong duoc trong' |
| Range | tu_so <= den_so | 'Tu so phai nho hon hoac bang den so' |
| Min | so_luong | 'So luong phai >= 1' |

### Auto-calculate

```php
// So luong = Den_so - Tu_so + 1
So_luong = Den_so - Tu_so + 1
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMMATHD.php
namespace Diepxuan\Simba\Models\SO;

class DMMATHD extends Model
{
    protected $table = 'DMMATHD';
    protected $primaryKey = 'ma_tb';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_tb', 'ma_chung', 'ten_loai', 'mau_so',
        'so_seri', 'tu_so', 'den_so',
        'so_luong', 'lien_hd', 'ghi_chu', 'ksd',
    ];

    protected $casts = [
        'tu_so' => 'integer',
        'den_so' => 'integer',
        'so_luong' => 'integer',
        'lien_hd' => 'integer',
        'ksd' => 'boolean',
    ];

    // Auto-calculate so_luong
    public function setTuSoAttribute($value): void
    {
        $this->attributes['tu_so'] = $value;
        $this->calculateSoLuong();
    }

    public function setDenSoAttribute($value): void
    {
        $this->attributes['den_so'] = $value;
        $this->calculateSoLuong();
    }

    protected function calculateSoLuong(): void
    {
        if ($this->tu_so && $this->den_so) {
            $this->attributes['so_luong'] = $this->den_so - $this->tu_so + 1;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Mahoadon.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Mahoadon extends Component
{
    const MA_CT = 'MHD';

    public Collection $pMaHoadons;
    public string $pSearch = '';

    public function render(): View
    {
        return view('catalog::so.danhmuc.mahoadon');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/MahoadonEdit.php
class MahoadonEdit extends Component
{
    public ?string $pMa_Tb = null;
    public string $pMa_Chung = '';
    public string $pTen_Loai = '';
    public string $pMau_So = '';
    public string $pSo_Seri = '';
    public int $pTu_So = 0;
    public int $pDen_So = 0;
    public int $pSo_Luong = 0;
    public int $pLien_Hd = 2;
    public string $pGhi_Chu = '';
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Tb' => 'required|string|max:20',
        'pTen_Loai' => 'required|string|max:200',
        'pMau_So' => 'required|string|max:50',
        'pSo_Seri' => 'required|string|max:50',
        'pTu_So' => 'required|integer|min:0',
        'pDen_So' => 'required|integer|gte:pTu_So',
    ];

    public function updatedPTuSo($value): void { $this->calculate(); }
    public function updatedPDenSo($value): void { $this->calculate(); }

    protected function calculate(): void
    {
        $this->pSo_Luong = max(0, $this->pDen_So - $this->pTu_So + 1);
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.mahoadon-edit');
    }
}
```

### 3. Views & Routes

```
resources/views/catalog/so/danhmuc/
├── mahoadon.blade.php
├── mahoadon-edit.blade.php
```

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/ma-hoa-don', [Mahoadon::class, 'render'])->name('mahoadon');
        Route::get('/ma-hoa-don/edit/{maTb?}', [MahoadonEdit::class, 'render'])->name('mahoadon.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMMATHD.php | Chinh |
| SP | laravel-simba | SoGetDMMATHD.php | Get list |
| SP | laravel-simba | SoInsDMMATHD.php | Insert |
| Component | laravel-catalog | Mahoadon.php | List |
| Component | laravel-catalog | MahoadonEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMMATHD
- [ ] Tao Livewire Mahoadon
- [ ] Tao Livewire MahoadonEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Auto-calculate so_luong
- [ ] Test Integration voi SOND51phhd