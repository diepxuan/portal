# Task 343: CO - Phieu bao (COPB)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 343 |
| **DLL** | COPB.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Utility/Calculation |
| **Assembly Title** | BUT TOAN PHAN BO TU DONG |
| **Version** | 1.0.0.0 |
| **GUID** | 5951a517-8a01-41ab-b0b9-87635fe2f2fd |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Thuc hien but toan phan bo chi phi tu dong. Module cho phep chon ky bao cao, xem danh sach cac but toan phan bo da cau hinh, thuc hien phan bo hoac xoa phan bo chi phi gian tiep ve cac doi tuong chi phí.

## Form classes

### 1. frmCOPB (Form chinh)
- **Ke thua:** `frmAsiaRoot`
- **Chuc nang:** Thuc hien but toan phan bo chi phi tu dong
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| GrB_KBC | GroupBox | GroupBox ky bao cao |
| cboKyBc | AsComboBox | Chon ky bao cao (thang/quy/nam) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| chk_CheckAll | CheckBox | Chon tat ca |
| dgvDMPB | AsInputDGV | DataGridView danh muc phan bo 1 (master) |
| dgvDMPB2 | AsInputDGV | DataGridView danh muc phan bo 2 (detail) |
| btn_PB | Button | Nut thuc hien phan bo |
| btn_XPB | Button | Nut xoa phan bo |
| btn_exit | Button | Nut thoat |
| sbtn_DHS | SplitButton | Dieu kien he so |
| lblDien_hs | Label | Dien giai he so |

#### dgvDMPB Columns (Master)

| Column | Type | Mo ta |
|--------|------|-------|
| dgvcID_ | DataGridViewTextBoxColumn | ID |
| dgvcTag | DataGridViewCheckBoxColumn | Chon |
| dgvcTen_bt | DataGridViewAsTextBoxColumn | Ten but toan |
| dgvcTheoSPCT | DataGridViewCheckBoxColumn | Theo SPCT |
| dgvcTheoBP | DataGridViewCheckBoxColumn | Theo bo phan |
| dgvcTheoTKDU | DataGridViewCheckBoxColumn | Theo TK doi ung |
| dgvcTk_pb | DataGridViewTextBoxColumn | TK phan bo |
| dgvcTien_Pb | DataGridViewAsTextNumericColumn | Tien phan bo |

#### dgvDMPB2 Columns (Detail)

| Column | Type | Mo ta |
|--------|------|-------|
| dgvcID | DataGridViewTextBoxColumn | ID |
| dgvThang | DataGridViewTextBoxColumn | Thang |
| dgvcTk | DataGridViewTextBoxColumn | Tai khoan |
| dgvcTen_tk | DataGridViewTextBoxColumn | Ten tai khoan |
| dgvcMa_spct | DataGridViewTextBoxColumn | Ma SPCT |
| dgvcTen_spct | DataGridViewTextBoxColumn | Ten SPCT |
| dgvcMa_bo | DataGridViewTextBoxColumn | Ma bo phan |
| dgvcTen_Bp | DataGridViewTextBoxColumn | Ten bo phan |
| dgvcTk_du | DataGridViewTextBoxColumn | TK doi ung |
| dgvcTen_tk_du | DataGridViewTextBoxColumn | Ten TK doi ung |
| dgvcHe_so | DataGridViewAsTextNumericColumn | He so |
| dgvTien_nhan | DataGridViewAsTextNumericColumn | Tien nhan |

## Data structures

### Bang: CODMPB (Danh muc phan bo - Master)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ID | int | Khoa chinh |
| ten_bt | nvarchar | Ten but toan phan bo |
| theoSPCT | bit | Phan bo theo SPCT |
| theoBP | bit | Phan bo theo bo phan |
| theoTKDU | bit | Phan bo theo TK doi ung |
| tk_pb | varchar | Tai khoan phan bo |
| tien_pb | decimal | Tien phan bo |

### Bang: CODMPB2 (Chi tiet phan bo - Detail)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ID | int | FK toi CODMPB |
| thang | int | Thang |
| tk | varchar | Tai khoan |
| ten_tk | nvarchar | Ten tai khoan |
| ma_spct | varchar | Ma san pham chi tiet |
| ten_spct | nvarchar | Ten SPCT |
| ma_bo | varchar | Ma bo phan |
| ten_bp | nvarchar | Ten bo phan |
| tk_du | varchar | Tai khoan doi ung |
| ten_tk_du | nvarchar | Ten TK doi ung |
| he_so | decimal | He so phan bo |
| tien_nhan | decimal | Tien nhan phan bo |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asCOCalcPb | Tinh toan phan bo chi phi |
| asCOCalcHsPb | Tinh he so phan bo |
| asCOGetDMPB | Lay danh muc phan bo |
| asCODelPb | Xoa phan bo |

## Business Logic

### Validation Rules
| Rule | Field | Message |
|------|-------|---------|
| Required | cboKyBc | Phai chon ky bao cao |
| Required | txtNgay1 | Tu ngay khong duoc trong |
| Required | txtNgay2 | Den ngay khong duoc trong |

### Business Rules
1. **Phan loai phan bo**: Theo SPCT, theo bo phan, hoac theo TK doi ung
2. **He so phan bo**: Tinh tuong theo ti le chi phi
3. **Tien nhan**: = He so x Tong tien can phan bo
4. **Xoa phan bo**: Kiem tra ky bao cao chua khoa so
5. **Lookup**: TK lookup tu danh muc tai khoan
6. **Lookup**: SPCT lookup tu danh muc san pham chi tiet
7. **Lookup**: BP lookup tu danh muc bo phan

### Quy trinh thuc hien
1. Chon ky bao cao → Tu dong dien ngay1/ngay2
2. Load danh sach but toan phan bo vao dgvDMPB
3. Tick chon cac but toan can thuc hien
4. Nhan "Phan bo" → Goi SP asCOCalcPb
5. Ket qua hien thi trong dgvDMPB2
6. Neu can xoa → Nhan "Xoa phan bo" → Goi SP asCODelPb

## Mapping PHP

### 1. Model

```php
// app/Models/CO/CODMPB.php
namespace Diepxuan\Simba\Models\CO;

class CODMPB extends Model
{
    protected $table = 'CODMPB';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty',
        'ten_bt',
        'theoSPCT',
        'theoBP',
        'theoTKDU',
        'tk_pb',
        'tien_pb',
    ];

    protected $casts = [
        'theoSPCT' => 'boolean',
        'theoBP' => 'boolean',
        'theoTKDU' => 'boolean',
        'tien_pb' => 'decimal:2',
    ];

    public function chiTiet()
    {
        return $this->hasMany(CODMPB2::class, 'id', 'id');
    }

    public function scopeByCompany($query, $maCty)
    {
        return $query->where('ma_cty', $maCty);
    }
}
```

```php
// app/Models/CO/CODMPB2.php
namespace Diepxuan\Simba\Models\CO;

class CODMPB2 extends Model
{
    protected $table = 'CODMPB2';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'id', 'thang', 'tk', 'ten_tk',
        'ma_spct', 'ten_spct', 'ma_bo', 'ten_bp',
        'tk_du', 'ten_tk_du', 'he_so', 'tien_nhan',
    ];

    protected $casts = [
        'thang' => 'integer',
        'he_so' => 'decimal:6',
        'tien_nhan' => 'decimal:2',
    ];

    public function master()
    {
        return $this->belongsTo(CODMPB::class, 'id', 'id');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCoCalcPb.php
class AsCoCalcPb extends StoredProcedure
{
    protected $procedure = 'asCOCalcPb';
    protected $params = ['pMa_cty', 'pKy_bc', 'pNgay1', 'pNgay2'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoCalcHsPb.php
class AsCoCalcHsPb extends StoredProcedure
{
    protected $procedure = 'asCOCalcHsPb';
    protected $params = ['pMa_cty', 'pKy_bc'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoGetDMPB.php
class AsCoGetDMPB extends StoredProcedure
{
    protected $procedure = 'asCOGetDMPB';
    protected $params = ['pMa_cty', 'pKy_bc'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCODelPb.php
class AsCODelPb extends StoredProcedure
{
    protected $procedure = 'asCODelPb';
    protected $params = ['pMa_cty', 'pKy_bc'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Phieubao.php
namespace Diepxuan\Catalog\Http\Livewire\CO;

class Phieubao extends Component
{
    const MA_CT = 'CO';

    public Collection $pDanhMucPB;
    public Collection $pChiTietPB;
    public ?string $pKyBc = null;
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public array $pSelectedIds = [];
    public bool $pCheckAll = false;

    protected $rules = [
        'pKyBc' => 'required|string',
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date|after_or_equal:pNgay1',
    ];

    public function mount(): void
    {
        $this->loadKyBaoCaoMacDinh();
        $this->loadDanhMucPB();
    }

    public function loadDanhMucPB(): void
    {
        // Goi SP asCOGetDMPB
    }

    public function thucHienPhanBo(): void
    {
        $this->validate();
        // Goi SP asCOCalcPb
    }

    public function xoaPhanBo(): void
    {
        $this->validate();
        // Goi SP asCODelPb
    }

    public function render(): View
    {
        return view('catalog::co.phieu-bao');
    }
}
```

### 4. Views

```
resources/views/catalog/co/
├── phieu-bao.blade.php           (Form phan bo chi phi)
├── _danh-muc-pb-row.blade.php    (Row master)
└── _chi-tiet-pb-row.blade.php    (Row detail)
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        Route::get('/phieu-bao', [Phieubao::class, 'render'])
            ->name('phieu-bao');
        Route::post('/phieu-bao/thuc-hien', [Phieubao::class, 'thucHienPhanBo'])
            ->name('phieu-bao.thuc-hien');
        Route::post('/phieu-bao/xoa', [Phieubao::class, 'xoaPhanBo'])
            ->name('phieu-bao.xoa');
    });
```

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | CODMPB.php | Master |
| Model | laravel-simba | CODMPB2.php | Detail |
| SP | laravel-simba | AsCoCalcPb.php | Tinh phan bo |
| SP | laravel-simba | AsCoCalcHsPb.php | Tinh he so |
| SP | laravel-simba | AsCoGetDMPB.php | Lay danh muc |
| SP | laravel-simba | AsCODelPb.php | Xoa phan bo |
| Component | laravel-catalog | Phieubao.php | Form chinh |
| DM | CO | DMSPCT | Lookup SPCT |
| DM | System | DSTK | Lookup TK |
| DM | CO | DMBO | Lookup bo phan |

## Progress Checklist

- [ ] Phan tich yeu cau & review task
- [ ] Tao Stored Procedure classes (Get, CalcPb, CalcHsPb, DelPb)
- [ ] Tao Model CODMPB + CODMPB2
- [ ] Tao Livewire Phieubao
- [ ] Tao Views (form + rows)
- [ ] Them Routes
- [ ] Test tinh toan phan bo
- [ ] Test xoa phan bo
