# Task 344: CO - Bao cao Gia thanh 01 (CORptGt01)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 344 |
| **DLL** | CORptGt01.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Report |
| **Assembly Title** | So cai |
| **Version** | 9.1.0.0 |
| **GUID** | 2b77c71e-b8d4-4512-9c4a-843e2824a429 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Bao cao Gia thanh 01 - Bao cao tong hop chi phi gia thanh, phan tich chi phi theo tai khoan va san pham chi tiet (SPCT). Day la bao cao chi tiet nhat trong 3 bao cao gia thanh, co tuy chon xem chi tiet vat tu.

## Form classes

### 1. frmCORptGt01 (Form bao cao)
- **Ke thua:** `frmReport`
- **Chuc nang:** Bao cao Gia thanh 01
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Ma tai khoan (AutoLookup) |
| lblTen_Tk | Label | Ten tai khoan |
| lblTk | Label | Nhan "Tai khoan" |
| txtNam | AsTextNumeric | Nam bao cao |
| txtThang1 | AsTextNumeric | Thang bat dau |
| txtThang2 | AsTextNumeric | Thang ket thuc |
| txtMA_SPCT | AsTextBox | Ma san pham chi tiet (AutoLookup) |
| chkCt_vt | CheckBox | Chi tiet vat tu |
| Label1-4 | Label | Cac nhan phu |

## Data structures

### Du lieu tra ve tu SP

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_spct | varchar | Ma SPCT |
| ten_spct | nvarchar | Ten SPCT |
| tk | varchar | Tai khoan |
| ten_tk | nvarchar | Ten tai khoan |
| thang | int | Thang |
| nam | int | Nam |
| tong_chi_phi | decimal | Tong chi phi |
| chi_phi_vat_tu | decimal | Chi phi vat tu (chi tiet) |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asCORptGt01 | Lay du lieu bao cao gia thanh 01 |

## Business Logic

### Validation Rules
| Rule | Field | Message |
|------|-------|---------|
| Required | txtNam | Nam khong duoc trong |
| Required | txtThang1 | Thang bat dau khong duoc trong |
| Required | txtThang2 | Thang ket thuc khong duoc trong |

### Business Rules
1. **AutoLookup TK**: Lookup tu danh muc tai khoan
2. **AutoLookup SPCT**: Lookup tu danh muc san pham chi tiet
3. **Chi tiet VT**: Khi chkCt_vt = true, hien thi chi tiet vat tu
4. **Khoang thang**: Thang2 >= Thang1
5. **Nam tai chinh**: Lay nam tai chinh hien tai lam mac dinh

## Mapping PHP

### 1. Model

```php
// app/Models/CO/RptGt01.php
namespace Diepxuan\Simba\Models\CO;

class RptGt01 extends Model
{
    protected $table = 'RPT_GT01';
    protected $connection = 'simba';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ma_cty', 'ma_spct', 'ten_spct', 'tk', 'ten_tk',
        'thang', 'nam', 'tong_chi_phi', 'chi_phi_vat_tu',
    ];

    protected $casts = [
        'thang' => 'integer',
        'nam' => 'integer',
        'tong_chi_phi' => 'decimal:2',
        'chi_phi_vat_tu' => 'decimal:2',
    ];
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCORptGt01.php
class AsCORptGt01 extends StoredProcedure
{
    protected $procedure = 'asCORptGt01';
    protected $params = [
        'pMa_cty', 'pTk', 'pMa_spct', 'pNam',
        'pThang1', 'pThang2', 'pCt_vt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/BaocaoGt01.php
namespace Diepxuan\Catalog\Http\Livewire\CO;

class BaocaoGt01 extends Component
{
    const MA_CT = 'CO';

    public Collection $pData;
    public ?string $pTk = null;
    public ?string $pMaSpct = null;
    public ?int $pNam = null;
    public ?int $pThang1 = null;
    public ?int $pThang2 = null;
    public bool $pCtVt = false;

    protected $rules = [
        'pNam' => 'required|integer',
        'pThang1' => 'required|integer|min:1|max:12',
        'pThang2' => 'required|integer|min:1|max:12',
    ];

    public function mount(): void
    {
        $this->pNam = date('Y');
        $this->pThang1 = 1;
        $this->pThang2 = 12;
    }

    public function xemBaoCao(): void
    {
        $this->validate();
        // Goi SP asCORptGt01
    }

    public function xuatExcel(): void
    {
        // Xuat Excel
    }

    public function render(): View
    {
        return view('catalog::co.baocao-gt01');
    }
}
```

### 4. Views

```
resources/views/catalog/co/
├── baocao-gt01.blade.php    (Form bao cao)
└── _gt01-result.blade.php   (Ket qua bao cao)
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        Route::get('/baocao-gt01', [BaocaoGt01::class, 'render'])
            ->name('baocao-gt01');
        Route::post('/baocao-gt01/xem', [BaocaoGt01::class, 'xemBaoCao'])
            ->name('baocao-gt01.xem');
    });
```

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptGt01.php | Bao cao |
| SP | laravel-simba | AsCORptGt01.php | Lay du lieu |
| Component | laravel-catalog | BaocaoGt01.php | Bao cao |
| DM | System | DSTK | Lookup TK |
| DM | CO | DMSPCT | Lookup SPCT |

## Progress Checklist

- [ ] Phan tich yeu cau & review task
- [ ] Tao Stored Procedure class AsCORptGt01
- [ ] Tao Model RptGt01
- [ ] Tao Livewire BaocaoGt01
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao voi cac filter
- [ ] Test xuat Excel

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
