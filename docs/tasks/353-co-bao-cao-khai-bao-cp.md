# Task 353: CO - Bao cao khai bao chi phi tap trung (CoRptKHCPTT)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 353 |
| **DLL** | CoRptKHCPTT.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Report |
| **Assembly Title** | Bao cao ton kho cuoi ky |
| **Version** | 1.0.0.0 |
| **GUID** | 6cf0aa81-5a68-42ff-8764-7956a0ff3a07 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Bao cao khai bao chi phi tap trung - Hien thi danh sach cac chi phi tap trung da khai bao, co the loc theo bo phan su dung. Bao gom tuy chon tien VND va ngoai te.

## Form classes

### 1. frmCoRptKHCPTT (ten class: frmCoRptCTPBCPTT)
- **Ke thua:** `frmReport`
- **Chuc nang:** Bao cao khai bao chi phi tap trung
- **Controls:**

| Control | Type | DataField/Tag | Mo ta |
|---------|------|---------------|-------|
| txtMa_bpsd | AsTextBox | @pMa_bpsd | Ma bo phan SD (Lookup MA_BPSD) |
| lblTen_bpsd | Label | - | Ten bo phan |
| lblMa_bpsd | Label | - | Nhan "Ma BPSD" |

- **Thua ke tu frmReport:**
  - `cboKyBc`, `txtNgay1`, `txtNgay2` - Ky bao cao
  - `cboMau_bc`, `txtTieu_De` - Mau bao cao
  - `cmdOk`, `cmdCancel`, `cmdExcel`, `cmdModifyReport`
  - `optVND`, `optNt` - Tien VND / Ngoai te
  - `txtMa_Nt` - Ma ngoai te

### LoadData Parameters
```
[CompanyID, Ngay1, Ngay2, Ma_bpsd]
```

### GetFilterTitle
Tao chuoi mo ta dieu kien loc theo bo phan su dung.

### Error Handling
- Try-Catch khi load du lieu
- Hien thong bao "Loi loc du lieu" neu co loi

## Cau truc du lieu

### Bang: CORPTKHCPTT (Du lieu bao cao)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_cptt | varchar | Ma chi phi |
| ten_cptt | nvarchar | Ten chi phi |
| ma_bpsd | varchar | Ma bo phan SD |
| ten_bpsd | nvarchar | Ten bo phan |
| dvt | varchar | Don vi tinh |
| so_luong | decimal | So luong |
| don_gia | decimal | Don gia |
| ng_gia | decimal | Nguyen gia |
| gt_da_kh | decimal | GT da phan bo |
| gt_cl | decimal | GT con lai |
| kh_ky | decimal | GT phan bo 1 ky |
| so_ky | int | So ky phan bo |
| tk_cptt | varchar | TK phan bo |
| tk_cp | varchar | TK chi phi |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| CoRptKHCPTT_Get | Lay du lieu bao cao khai bao CPTT |

## Business Logic

### Validation
- Ma_bpsd la optional (co the de trong)

### Business Rules
1. **Loc theo BPSD:** Chi hien thi CPTT cua bo phan da chon
2. **Tien VND/NT:** Ho tro xem theo VND hoac ngoai te
3. **Xuat Excel:** Ho tro xuat du lieu
4. **Ky bao cao:** Tu dong tinh ngay tu ky

## Mapping PHP

### 1. Model

```php
// app/Models/CO/CoRptKHCPTT.php
class CoRptKHCPTT extends Model
{
    protected $table = 'CORPTKHCPTT';
    protected $connection = 'simba';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $casts = [
        'so_luong' => 'decimal:2',
        'don_gia' => 'decimal:2',
        'ng_gia' => 'decimal:2',
        'gt_da_kh' => 'decimal:2',
        'gt_cl' => 'decimal:2',
        'kh_ky' => 'decimal:2',
        'so_ky' => 'integer',
    ];
}
```

### 2. SP Class

```php
class AsCoRptKHCPTTGet extends StoredProcedure
{
    protected $procedure = 'CoRptKHCPTT_Get';
    protected $params = ['pMa_cty', 'pNgay1', 'pNgay2', 'pMa_bpsd'];
}
```

### 3. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Baocaokhaibaocp.php
class Baocaokhaibaocp extends Component
{
    const MA_CT = 'CO';
    public string $pMaBpsd = '';
    public string $pTenBpsd = '';
    public bool $pIsNT = false;
    public string $pMaNt = 'VND';
    public Collection $pData;

    public function render(): View
    {
        return view('catalog::co.bao-cao-khai-bao-cp');
    }
}
```

### 4. Views & Routes

```
resources/views/catalog/co/
├── bao-cao-khai-bao-cp.blade.php
```

```php
Route::get('/co/bao-cao-khai-bao-cp', [Baocaokhaibaocp::class, 'render'])
    ->name('co.bao-cao-khai-bao-cp');
```

## Dependencies

| Loai | Package | File |
|------|---------|------|
| SP | laravel-simba | AsCoRptKHCPTTGet.php |
| Lookup | CO | DMBPSD |
| Lookup | System | DSTK |

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao SP class
- [ ] Tao Livewire Baocaokhaibaocp
- [ ] Tao View
- [ ] Test report + filter + xuat Excel
