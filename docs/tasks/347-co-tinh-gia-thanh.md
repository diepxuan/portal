# Task 347: CO - Tinh gia thanh (CoCalcCost)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 347 |
| **DLL** | CoCalcCost.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Report/Utility |
| **Assembly Title** | CoCalcCost |
| **Version** | 1.0.0.0 |
| **GUID** | dd7585f2-adc7-4e59-9b0f-0caea88b302c |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Tinh toan gia thanh san pham cho cac SPCT. Bao gom 2 chuc nang chinh: cap nhat gia thanh (btnUpdate) va xoa cap nhat gia thanh (btnDelUpdate). Hien thi bao cao 2 cap (master-detail) tren DataGridView va Crystal Report.

## Form classes

### 1. frmCoCalcCost
- **Ke thua:** `frmReport2DGV` (form bao cao 2 DataGridView)
- **Chuc nang:** Tinh gia thanh
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtTK | AsTextBox | Tai khoan do dang (AutoLookup "TK") |
| lblTK | Label | Ten TK (hien thi tu lookup) |
| lblTK | Label | Nhan "TK do dang" |
| btnUpdate | Button | Nut "Cap nhat GT" |
| btnDelUpdate | Button | Nut "Xoa cap nhat" |
| crvReportViewer | CrystalReportViewer | Crystal Report viewer |
| Label3 | Label | Nhan "TK do dang" |

- **Thua ke tu frmReport2DGV:**
  - `dgvBCPh` - DataGridView master (bao cao tong)
  - `dgvBCCt` - DataGridView detail (bao cao chi tiet)
  - `cboKyBc`, `txtNgay1`, `txtNgay2` - Ky tinh toan
  - `cmdOk`, `cmdCancel`, `cmdExcel`

### Events
| Event | Handler | Mo ta |
|-------|---------|-------|
| Form.Load | frmCOGDBGT_Load | Thiet lập ky bao cao, mac dinh TK tu par1 |
| btnUpdate.Click | btnUpdate_Click | Cap nhat gia thanh |
| btnDelUpdate.Click | btnDelUpdate_Click | Xoa cap nhat gia thanh |
| dgvBCPh.CurrentCellChanged | dgv_CurrentCellChanged | Loc detail theo master |

### LoadData Parameters
```
[CompanyID, Ngay1, Ngay2, TK]
```

### btnUpdate_Click
```
Commons.ExecuteStoredProcedure(MyMenuInfo.par2, CompanyID, Ngay1, Ngay2, TK)
```

### btnDelUpdate_Click
```
Commons.ExecuteStoredProcedure(MyMenuInfo.par3, CompanyID, Ngay1, Ngay2, TK)
```

## Cau truc du lieu

### Bang: COCALCCOST (Ket qua tinh gia thanh)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_spct | varchar | Ma san pham chi tiet |
| ten_spct | nvarchar | Ten SPCT |
| tk_dd | varchar | TK do dang |
| gia_von | decimal | Gia von |
| chi_phi_truc_tiep | decimal | CP truc tiep |
| chi_phi_gian_tiep | decimal | CP gian tiep |
| tong_gia_thanh | decimal | Tong gia thanh |
| don_gia | decimal | Don gia |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| CoCalcCost_Get | Lay du lieu tinh gia thanh |
| (par2) | Stored procedure cap nhat gia thanh (lay tu menu) |
| (par3) | Stored procedure xoa cap nhat gia thanh (lay tu menu) |

## Business Logic

### Validation
1. **Ngay khoa so:** Ngay2 phai sau ngay khoa so (ngay_ks)
2. **Bat buoc:** TK do dang (txtTK) khong duoc trong
3. **Loi 50136:** Neu ngay ky <= ngay khoa so

### Business Rules
1. **Cap nhat GT:** Goi SP tu par2 de tinh toan gia thanh
2. **Xoa cap nhat:** Goi SP tu par3 de xoa ket qua tinh gia thanh
3. **Master-Detail:** dgvBCPh hien thi tong, dgvBCCt hien thi chi tiet theo ma_spct
4. **Filter:** Khi chon dong master, detail filter theo ma_spct
5. **Ky tinh toan:** Load tu GetKyBaoCao (loai "11100")
6. **Mac dinh:** txtTK lay tu MyMenuInfo.par1

## Mapping PHP

### 1. Model

```php
// app/Models/CO/CoCalcCost.php
class CoCalcCost extends Model
{
    protected $table = 'COCALCCOST';
    protected $connection = 'simba';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $casts = [
        'gia_von' => 'decimal:2',
        'chi_phi_truc_tiep' => 'decimal:2',
        'chi_phi_gian_tiep' => 'decimal:2',
        'tong_gia_thanh' => 'decimal:2',
        'don_gia' => 'decimal:2',
    ];
}
```

### 2. SP Classes

```php
class AsCoCalcCostGet extends StoredProcedure
{
    protected $procedure = 'CoCalcCost_Get';
    protected $params = ['pMa_cty', 'pNgay1', 'pNgay2', 'pTK'];
}

class AsCoCalcCostUpdate extends StoredProcedure
{
    protected $procedure = ''; // Lay tu menu par2
    protected $params = ['pMa_cty', 'pNgay1', 'pNgay2', 'pTK'];
}

class AsCoCalcCostDelete extends StoredProcedure
{
    protected $procedure = ''; // Lay tu menu par3
    protected $params = ['pMa_cty', 'pNgay1', 'pNgay2', 'pTK'];
}
```

### 3. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Tinhgiathanh.php
class Tinhgiathanh extends Component
{
    const MA_CT = 'CO';
    public string $pTk = '';
    public string $pTenTk = '';
    public Collection $pMasterData;
    public Collection $pDetailData;

    public function capNhatGiaThanh(): void
    {
        // Goi SP par2
    }

    public function xoaCapNhat(): void
    {
        // Goi SP par3
    }

    public function render(): View
    {
        return view('catalog::co.tinh-gia-thanh');
    }
}
```

### 4. Views & Routes

```
resources/views/catalog/co/
├── tinh-gia-thanh.blade.php
```

```php
Route::get('/co/tinh-gia-thanh', [Tinhgiathanh::class, 'render'])
    ->name('co.tinh-gia-thanh');
```

## Dependencies

| Loai | Package | File |
|------|---------|------|
| Model | laravel-simba | CoCalcCost.php |
| SP | laravel-simba | AsCoCalcCostGet.php |
| Lookup | System | DSTK |
| Framework | CO | GetKyBaoCao |

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao SP classes (Get, Update, Delete)
- [ ] Tao Model CoCalcCost
- [ ] Tao Livewire Tinhgiathanh
- [ ] Tao View (master-detail + Crystal Report)
- [ ] Test cap nhat / xoa gia thanh
