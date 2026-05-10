# Task 347: CO - Tinh gia thanh (CoCalcCost)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 347 |
| **DLL** | CoCalcCost.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Utility/Calculation |
| **Assembly Title** | CoCalcCost |
| **Version** | 1.0.0.0 |
| **GUID** | dd7585f2-adc7-4e59-9b0f-0caea88b302c |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Module tinh gia thanh san pham. Cho phep tinh toan va cap nhat gia thanh cho cac san pham chi tiet (SPCT) dua tren tai khoan do dang, theo ky tinh toan. Ho tro cap nhat va xoa ket qua tinh gia thanh.

## Form classes

### 1. frmCoCalcCost (Form chinh)
- **Ke thua:** `frmReport2DGV`
- **Chuc nang:** Tinh gia thanh san pham, bao cao 2 cap (master-detail)
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvBCPh | AsDataGridView | DataGridView bao cao phan header (master) |
| dgvBCCt | AsDataGridView | DataGridView bao cao phan chi tiet (detail) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao/tinh toan |
| txtTK | AsTextBox | Tai khoan do dang (AutoLookup) |
| lblTK | Label | Label hien thi ten tai khoan |
| btnUpdate | Button | Nut "Cap nhat GT" - Cap nhat gia thanh |
| btnDelUpdate | Button | Nut "Xoa cap nhat" - Xoa cap nhat gia thanh |
| crvReportViewer | CrystalReportViewer | Crystal Report viewer |
| cmdOk | Button | Nut OK |
| cmdCancel | Button | Nut Cancel |
| cmdExcel | Button | Nut xuat Excel |

## Data structures

### Du lieu master (dgvBCPh)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_spct | varchar | Ma SPCT |
| ten_spct | nvarchar | Ten SPCT |
| tong_chi_phi | decimal | Tong chi phi |
| so_luong | decimal | So luong |
| gia_thanh | decimal | Gia thanh don vi |

### Du lieu detail (dgvBCCt)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_spct | varchar | Ma SPCT |
| tk | varchar | Tai khoan |
| ten_tk | nvarchar | Ten tai khoan |
| tien_chi_phi | decimal | Tien chi phi |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asCoCalcCost | Tinh toan va cap nhat gia thanh |
| asCoDelCalcCost | Xoa cap nhat gia thanh |
| asCoGetCalcCostReport | Lay du lieu bao cao tinh gia thanh (master-detail) |

## Business Logic

### Validation Rules
| Rule | Field | Message |
|------|-------|---------|
| Required | txtTK | Tai khoan do dang khong duoc trong |
| Required | cboKyBc | Phai chon ky tinh toan |
| Date check | txtNgay2 | Ngay ket thuc phai sau ngay khoa so |

### Business Rules
1. **TK do dang**: Bat buoc nhap, AutoLookup tu danh muc tai khoan
2. **Khoa so**: Kiem tra ngay ket thuc phai sau ngay khoa so (ngay_ks)
3. **Cap nhat GT**: Goi SP asCoCalcCost de tinh toan gia thanh
4. **Xoa cap nhat**: Goi SP asCoDelCalcCost de xoa ket qua da tinh
5. **Master-Detail**: Khi chon dong trong dgvBCPh, dgvBCCt loc chi tiet theo SPCT
6. **Crystal Report**: Ho tro in bao cao

### Quy trinh thuc hien
1. Chon ky tinh toan → Tu dong dien ngay1/ngay2
2. Nhap tai khoan do dang
3. Nhan "Cap nhat GT" → Goi SP tinh gia thanh
4. Ket qua hien thi tren 2 DataGridView (master-detail)
5. Co the in bao cao qua Crystal Report
6. Neu can tinh lai → Nhan "Xoa cap nhat"

## Mapping PHP

### 1. Model

```php
// app/Models/CO/CalcCost.php
namespace Diepxuan\Simba\Models\CO;

class CalcCost extends Model
{
    protected $table = 'CALC_COST';
    protected $connection = 'simba';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ma_cty', 'ma_spct', 'ten_spct', 'tk_dd',
        'ky_bc', 'ngay1', 'ngay2',
        'tong_chi_phi', 'so_luong', 'gia_thanh',
    ];

    protected $casts = [
        'tong_chi_phi' => 'decimal:2',
        'so_luong' => 'decimal:4',
        'gia_thanh' => 'decimal:2',
    ];

    public function chiTiet()
    {
        return $this->hasMany(CalcCostDetail::class, 'ma_spct', 'ma_spct');
    }

    public function scopeByCompany($query, $maCty)
    {
        return $query->where('ma_cty', $maCty);
    }

    public function scopeByKyBc($query, $kyBc)
    {
        return $query->where('ky_bc', $kyBc);
    }
}
```

```php
// app/Models/CO/CalcCostDetail.php
namespace Diepxuan\Simba\Models\CO;

class CalcCostDetail extends Model
{
    protected $table = 'CALC_COST_DETAIL';
    protected $connection = 'simba';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ma_cty', 'ma_spct', 'tk', 'ten_tk', 'tien_chi_phi',
    ];

    protected $casts = [
        'tien_chi_phi' => 'decimal:2',
    ];

    public function master()
    {
        return $this->belongsTo(CalcCost::class, 'ma_spct', 'ma_spct');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCoCalcCost.php
class AsCoCalcCost extends StoredProcedure
{
    protected $procedure = 'asCoCalcCost';
    protected $params = ['pMa_cty', 'pKy_bc', 'pTk_dd', 'pNgay1', 'pNgay2'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoDelCalcCost.php
class AsCoDelCalcCost extends StoredProcedure
{
    protected $procedure = 'asCoDelCalcCost';
    protected $params = ['pMa_cty', 'pKy_bc', 'pTk_dd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoGetCalcCostReport.php
class AsCoGetCalcCostReport extends StoredProcedure
{
    protected $procedure = 'asCoGetCalcCostReport';
    protected $params = ['pMa_cty', 'pKy_bc', 'pTk_dd', 'pNgay1', 'pNgay2'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Tinhgiathanh.php
namespace Diepxuan\Catalog\Http\Livewire\CO;

class Tinhgiathanh extends Component
{
    const MA_CT = 'CO';

    public Collection $pMasterData;
    public Collection $pDetailData;
    public ?string $pKyBc = null;
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public ?string $pTkDd = null;
    public string $pTenTk = '';
    public ?string $pSelectedMaSpct = null;

    protected $rules = [
        'pTkDd' => 'required|string',
        'pKyBc' => 'required|string',
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date|after_or_equal:pNgay1',
    ];

    public function mount(): void
    {
        $this->loadKyBaoCaoMacDinh();
    }

    public function capNhatGiaThanh(): void
    {
        $this->validate();
        // Goi SP asCoCalcCost
    }

    public function xoaCapNhat(): void
    {
        $this->validate();
        // Goi SP asCoDelCalcCost
    }

    public function selectRow(string $maSpct): void
    {
        $this->pSelectedMaSpct = $maSpct;
        $this->loadDetail();
    }

    public function render(): View
    {
        return view('catalog::co.tinh-gia-thanh');
    }
}
```

### 4. Views

```
resources/views/catalog/co/
├── tinh-gia-thanh.blade.php     (Form chinh)
├── _master-table.blade.php      (Bang master)
└── _detail-table.blade.php      (Bang detail)
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        Route::get('/tinh-gia-thanh', [Tinhgiathanh::class, 'render'])
            ->name('tinh-gia-thanh');
        Route::post('/tinh-gia-thanh/cap-nhat', [Tinhgiathanh::class, 'capNhatGiaThanh'])
            ->name('tinh-gia-thanh.cap-nhat');
        Route::post('/tinh-gia-thanh/xoa', [Tinhgiathanh::class, 'xoaCapNhat'])
            ->name('tinh-gia-thanh.xoa');
    });
```

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | CalcCost.php | Master |
| Model | laravel-simba | CalcCostDetail.php | Detail |
| SP | laravel-simba | AsCoCalcCost.php | Tinh gia thanh |
| SP | laravel-simba | AsCoDelCalcCost.php | Xoa cap nhat |
| SP | laravel-simba | AsCoGetCalcCostReport.php | Bao cao |
| Component | laravel-catalog | Tinhgiathanh.php | Form chinh |
| DM | System | DSTK | Lookup TK do dang |
| DM | CO | DMSPCT | Lookup SPCT |

## Progress Checklist

- [ ] Phan tich yeu cau & review task
- [ ] Tao Stored Procedure classes (CalcCost, DelCalcCost, GetReport)
- [ ] Tao Model CalcCost + CalcCostDetail
- [ ] Tao Livewire Tinhgiathanh
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test tinh gia thanh
- [ ] Test xoa cap nhat
- [ ] Test master-detail view

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
