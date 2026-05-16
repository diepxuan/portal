# Task 352: CO - Bao cao chi tiet phan bo chi phi tap trung (CoRptCTPBCPTT)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 352 |
| **DLL** | CoRptCTPBCPTT.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Report |
| **Assembly Title** | Bao cao ton kho cuoi ky |
| **Version** | 1.0.0.0 |
| **GUID** | 6cf0aa81-5a68-42ff-8764-7956a0ff3a07 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Bao cao chi tiet phan bo chi phi tap trung. Cho phep loc da chieu theo bo phan su dung, chi phi, tai khoan phan bo, tai khoan chi phi, ma phi, va SPCT.

## Form classes

### 1. frmCoRptCTPBCPTT
- **Ke thua:** `frmReport`
- **Chuc nang:** Bao cao chi tiet phan bo CPTT
- **Controls:**

| Control | Type | DataField/Tag | Mo ta |
|---------|------|---------------|-------|
| txtMa_bpsd | AsTextBox | @pMa_bpsd | Ma bo phan SD (Lookup MA_BPSD) |
| lblTen_bpsd | Label | - | Ten bo phan |
| lblMa_bpsd | Label | - | Nhan "Ma BPSD" |
| txtMa_cp | AsTextBox | @pMa_cp | Ma chi phi (Lookup MA_CPTT, MODULEID='CO') |
| lblTen_cp | Label | - | Ten chi phi |
| lblMa_cp | Label | - | Nhan "Ma chi phi" |
| txtTk_pb | AsTextBox | @pTk_pb | TK phan bo (Lookup TK) |
| lblTen_tkpb | Label | - | Ten TK phan bo |
| lblTk_pb | Label | - | Nhan "TK phan bo" |
| txtTk_cp | AsTextBox | @pTk_cp | TK chi phi (Lookup TK) |
| lblTen_tkcp | Label | - | Ten TK chi phi |
| lblTk_cp | Label | - | Nhan "TK chi phi" |
| txtMa_phi | AsTextBox | @pMa_phi | Ma phi (Lookup MA_PHI) |
| lblTen_phi | Label | - | Ten phi |
| lblMa_phi | Label | - | Nhan "Ma phi" |
| txtMa_spct | AsTextBox | @pMa_spct | Ma SPCT (Lookup MA_SPCT) |
| lblTen_spct | Label | - | Ten SPCT |
| lblMa_spct | Label | - | Nhan "Ma SPCT" |

- **Thua ke tu frmReport:**
  - `cboKyBc`, `txtNgay1`, `txtNgay2` - Ky bao cao
  - `cboMau_bc`, `txtTieu_De` - Mau bao cao
  - `cmdOk`, `cmdCancel`, `cmdExcel`, `cmdModifyReport`

### LoadData Parameters
```
[CompanyID, Ngay1, Ngay2, Ma_bpsd, Ma_cp, Tk_pb, Tk_cp, Ma_phi, Ma_spct]
```

### GetFilterTitle
Tao chuoi mo ta dieu kien loc tu cac tham so.

## Cau truc du lieu

### Bang: CORPTCTPBCPTT (Du lieu bao cao)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| thang | int | Thang |
| ma_bpsd | varchar | Ma bo phan SD |
| ten_bpsd | nvarchar | Ten bo phan |
| ma_cp | varchar | Ma chi phi |
| ten_cp | nvarchar | Ten chi phi |
| tk_pb | varchar | TK phan bo |
| ten_tk_pb | nvarchar | Ten TK PB |
| tk_cp | varchar | TK chi phi |
| ten_tk_cp | nvarchar | Ten TK CP |
| ma_phi | varchar | Ma phi |
| ten_phi | nvarchar | Ten phi |
| ma_spct | varchar | Ma SPCT |
| ten_spct | nvarchar | Ten SPCT |
| tien_pb | decimal | Tien phan bo |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| CoRptCTPBCPTT_Get | Lay du lieu bao cao chi tiet PB |

## Business Logic

### Validation
- Tat ca cac filter la optional (co the de trong)

### Business Rules
1. **Loc da chieu:** Co the ket hop nhieu dieu kien
2. **AutoLookup:** Tat ca cac truong ma co lookup tuong ung
3. **Xuat Excel:** Ho tro xuat du lieu ra Excel
4. **Ky bao cao:** Tu dong tinh ngay tu ky

## Mapping PHP

### 1. Model

```php
// app/Models/CO/CoRptCTPBCPTT.php
class CoRptCTPBCPTT extends Model
{
    protected $table = 'CORPTCTPBCPTT';
    protected $connection = 'simba';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $casts = [
        'thang' => 'integer',
        'tien_pb' => 'decimal:2',
    ];
}
```

### 2. SP Class

```php
class AsCoRptCTPBCPTTGet extends StoredProcedure
{
    protected $procedure = 'CoRptCTPBCPTT_Get';
    protected $params = [
        'pMa_cty', 'pNgay1', 'pNgay2',
        'pMa_bpsd', 'pMa_cp', 'pTk_pb', 'pTk_cp',
        'pMa_phi', 'pMa_spct',
    ];
}
```

### 3. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Baoctpbcp.php
class Baoctpbcp extends Component
{
    const MA_CT = 'CO';
    public string $pMaBpsd = '';
    public string $pMaCp = '';
    public string $pTkPb = '';
    public string $pTkCp = '';
    public string $pMaPhi = '';
    public string $pMaSpct = '';
    public Collection $pData;

    public function render(): View
    {
        return view('catalog::co.bao-cao-chi-tiet-pb');
    }
}
```

### 4. Views & Routes

```
resources/views/catalog/co/
├── bao-cao-chi-tiet-pb.blade.php
```

```php
Route::get('/co/bao-cao-chi-tiet-pb', [Baoctpbcp::class, 'render'])
    ->name('co.bao-cao-chi-tiet-pb');
```

## Dependencies

| Loai | Package | File |
|------|---------|------|
| SP | laravel-simba | AsCoRptCTPBCPTTGet.php |
| Lookup | CO | DMBPSD, DMCPTT, DMPHI, DMSPCT |
| Lookup | System | DSTK |

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao SP class
- [ ] Tao Livewire Baoctpbcp
- [ ] Tao View
- [ ] Test report + filter + xuat Excel

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.352`
