# Task 346: CO - Bao cao Gia thanh 03 (CORptGt03)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 346 |
| **DLL** | CORptGt03.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Report |
| **Assembly Title** | So cai |
| **Version** | 9.1.0.0 |
| **GUID** | 2b77c71e-b8d4-4512-9c4a-843e2824a429 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Bao cao Gia thanh 03 - Bao cao phan tich gia thanh nang cao, tong hop chi phi theo tai khoan va san pham theo nhieu goc do. Hien thi ten SPCT day du. Cau truc giong GT02 nhung dinh dang bao cao khac.

## Form classes

### 1. frmCORptGt03 (Form bao cao)
- **Ke thua:** `frmReport`
- **Chuc nang:** Bao cao Gia thanh 03
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Ma tai khoan (AutoLookup) |
| lblTen_Tk | Label | Ten tai khoan |
| lblTk | Label | Nhan "Tai khoan" |
| Label1 | Label | Nhan phu |
| txtNam | AsTextNumeric | Nam bao cao |
| txtThang1 | AsTextNumeric | Thang bat dau |
| txtThang2 | AsTextNumeric | Thang ket thuc |
| txtMA_SPCT | AsTextBox | Ma san pham chi tiet (AutoLookup) |
| lblMa_SPCT | Label | Nhan "Ma SPCT" |
| lblTen_SPCT | Label | Ten san pham chi tiet |

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
| gia_thanh_thuc_te | decimal | Gia thanh thuc te |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asCORptGt03 | Lay du lieu bao cao gia thanh 03 |

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
3. **Hien thi ten SPCT**: Tu dong hien thi ten khi chon ma SPCT
4. **Khoang thang**: Thang2 >= Thang1
5. **Nam tai chinh**: Lay nam tai chinh hien tai lam mac dinh

## Mapping PHP

### 1. Model

```php
// app/Models/CO/RptGt03.php
namespace Diepxuan\Simba\Models\CO;

class RptGt03 extends Model
{
    protected $table = 'RPT_GT03';
    protected $connection = 'simba';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ma_cty', 'ma_spct', 'ten_spct', 'tk', 'ten_tk',
        'thang', 'nam', 'tong_chi_phi', 'gia_thanh_thuc_te',
    ];

    protected $casts = [
        'thang' => 'integer',
        'nam' => 'integer',
        'tong_chi_phi' => 'decimal:2',
        'gia_thanh_thuc_te' => 'decimal:2',
    ];
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCORptGt03.php
class AsCORptGt03 extends StoredProcedure
{
    protected $procedure = 'asCORptGt03';
    protected $params = [
        'pMa_cty', 'pTk', 'pMa_spct', 'pNam',
        'pThang1', 'pThang2',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/BaocaoGt03.php
namespace Diepxuan\Catalog\Http\Livewire\CO;

class BaocaoGt03 extends Component
{
    const MA_CT = 'CO';

    public Collection $pData;
    public ?string $pTk = null;
    public ?string $pMaSpct = null;
    public string $pTenSpct = '';
    public ?int $pNam = null;
    public ?int $pThang1 = null;
    public ?int $pThang2 = null;

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
        // Goi SP asCORptGt03
    }

    public function xuatExcel(): void
    {
        // Xuat Excel
    }

    public function render(): View
    {
        return view('catalog::co.baocao-gt03');
    }
}
```

### 4. Views

```
resources/views/catalog/co/
├── baocao-gt03.blade.php    (Form bao cao)
└── _gt03-result.blade.php   (Ket qua bao cao)
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        Route::get('/baocao-gt03', [BaocaoGt03::class, 'render'])
            ->name('baocao-gt03');
        Route::post('/baocao-gt03/xem', [BaocaoGt03::class, 'xemBaoCao'])
            ->name('baocao-gt03.xem');
    });
```

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptGt03.php | Bao cao |
| SP | laravel-simba | AsCORptGt03.php | Lay du lieu |
| Component | laravel-catalog | BaocaoGt03.php | Bao cao |
| DM | System | DSTK | Lookup TK |
| DM | CO | DMSPCT | Lookup SPCT |

## Progress Checklist

- [ ] Phan tich yeu cau & review task
- [ ] Tao Stored Procedure class AsCORptGt03
- [ ] Tao Model RptGt03
- [ ] Tao Livewire BaocaoGt03
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao voi cac filter
- [ ] Test xuat Excel

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
