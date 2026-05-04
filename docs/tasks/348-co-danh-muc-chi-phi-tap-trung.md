# Task 348: CO - Danh muc chi phi tap trung (CoDMCPTT)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 348 |
| **DLL** | CoDMCPTT.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Master/Danh muc |
| **Assembly Title** | FADMCC |
| **Version** | 1.0.0.0 |
| **GUID** | b71f3569-e439-4607-b511-60dc5628362c |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly danh muc chi phi tap trung (CPTT). Cho pheu khai bao cac khoan chi phi tap trung voi thong tin: ma, ten, don vi tinh, so luong, don gia, so ky phan bo, tai khoan, bo phan su dung, ma phi, ma SPCT.

## Form classes

### 1. frmCoDMCPTT (Form danh sach)
- **Ke thua:** `frmDMComplexView`
- **Chuc nang:** Hien thi danh sach chi phi tap trung
- **Controls:** Hien thi list view (an search, filter, print, chgcode)
- **GetData:** `[CompanyID, "", 0]`
- **Delete:** Goi `CODMCPTTDAO.DelCPTT([Ma_cptt, ID])`

### 2. frmCoDMCPTTEdit (Form nhap lieu)
- **Ke thua:** `frmDMComplexEdit`
- **Chuc nang:** Them/sua chi phi tap trung
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_cptt | TextBox | ma_cptt | Ma chi phi (MaxLength=20) |
| txtTen_cptt | TextBox | ten_cptt | Ten chi phi (MaxLength=50) |
| txtDvt | TextBox | dvt | Don vi tinh (MaxLength=10) |
| txtSo_luong | AsTextNumeric | so_luong | So luong |
| txtDon_gia | AsTextNumeric | don_gia | Don gia |
| txtSo_ky_BP | AsTextNumeric | so_ky | So thang phan bo |
| txtNguyen_gia | AsTextNumeric | ng_gia | Nguyen gia (readonly=false) |
| txtGia_tri_da_pb | AsTextNumeric | gt_da_kh | Gia tri da phan bo |
| txtGiatri_pn_con_lai | AsTextNumeric | gt_cl | Gia tri con lai (readonly) |
| txtGiatri_pb_1ky | AsTextNumeric | kh_ky | GT phan bo 1 ky (readonly) |
| txtTK_pb | AsTextBox | tk_cptt | TK phan bo (AutoLookup "TK", chi_tiet=1) |
| txtTK_chiphi | AsTextBox | tk_cp | TK chi phi (AutoLookup "TK", chi_tiet=1) |
| txtSo_ct | TextBox | so_ct | So chung tu |
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay chung tu |
| txtNgay_bdau_bp | AsMaskedTextBox | ngay_bdkh | Ngay bat dau PB |
| txtNgay_gtcl | AsMaskedTextBox | ngay_gt_cl | Ngay GTCL |
| txtMa_phi | AsTextBox | MA_PHI | Ma phi (AutoLookup "MA_PHI") |
| txtMa_bpsd | AsTextBox | ma_bpsd | Ma BPSD (AutoLookup "MA_BPSD") |
| txtMa_spct | AsTextBox | ma_spct | Ma SPCT (AutoLookup "Ma_SPCT") |
| Chk_Giatri_pb1ky | CheckBox | sua_kh | Cho phep sua phan bo |
| txtID | AsTextNumeric | ID | ID (hidden) |

### Data Access
- **CODMCPTTDAO** (Interface): DAO interface
- **MsSqlCODMCPTTDAO**: SQL Server implementation
- **Methods:** `InsCPTT`, `UpdCPTT`, `DelCPTT`

### Auto-Calculation Events
| Event | Logic |
|-------|-------|
| So_luong changed | Nguyen_gia = So_luong * Don_gia; GTCL = Nguyen_gia - GT_da_pb |
| Don_gia changed | Nguyen_gia = So_luong * Don_gia; GTCL = Nguyen_gia - GT_da_pb |
| GT_da_pb changed | GTCL = Nguyen_gia - GT_da_pb |
| So_ky changed | GT_phan_bo_1ky = Nguyen_gia / So_ky |
| GTCL changed | GT_phan_bo_1ky = Nguyen_gia / So_ky |
| Chk_Giatri_pb1ky | Neu checked: cho phep sua GT_pb_1ky; Neu unchecked: tu dong tinh |

## Cau truc du lieu

### Bang: DMCPTT (Danh muc chi phi tap trung)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ID | int | ID (PK) |
| ma_cptt | varchar(20) | Ma chi phi |
| ten_cptt | nvarchar(50) | Ten chi phi |
| dvt | varchar(10) | Don vi tinh |
| so_luong | decimal | So luong |
| don_gia | decimal | Don gia |
| so_ky | int | So thang phan bo |
| ng_gia | decimal | Nguyen gia |
| gt_da_kh | decimal | Gia tri da phan bo |
| gt_cl | decimal | Gia tri con lai |
| kh_ky | decimal | Gia tri phan bo 1 ky |
| tk_cptt | varchar | TK phan bo |
| tk_cp | varchar | TK chi phi |
| so_ct | varchar(12) | So chung tu |
| ngay_ct | datetime | Ngay chung tu |
| ngay_bdkh | datetime | Ngay bat dau PB |
| ngay_gt_cl | datetime | Ngay GTCL |
| MA_PHI | varchar | Ma phi |
| ma_bpsd | varchar | Ma bo phan SD |
| ma_spct | varchar | Ma SPCT |
| sua_kh | bit | Cho phep sua phan bo |
| ma_cty | varchar | Ma cong ty |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| DMCPTT_Get | Lay danh sach CPTT |
| DMCPTT_Insert | Them moi CPTT |
| DMCPTT_Update | Cap nhat CPTT |
| DMCPTT_Delete | Xoa CPTT |

## Business Logic

### Validation
| Rule | Field | Message Code |
|------|-------|-------------|
| Required | ma_cptt | 50002 |
| Required | ten_cptt | 50002 |
| > 0 | so_luong | 50034 |
| > 0 | so_ky | 50034 |
| Required | tk_cptt | 50002 |
| Required | tk_cp | 50002 |
| != 1900-01-01 | ngay_ct | 50034 |
| != 1900-01-01 | ngay_bdkh | 50034 |
| != 1900-01-01 | ngay_gt_cl | 50034 |
| >= | ngay_gt_cl >= ngay_bdkh | 50144 |
| > 0 | ng_gia | 50034 |

### Business Rules
1. **Auto-calc:** Nguyen_gia = So_luong * Don_gia
2. **Auto-calc:** GTCL = Nguyen_gia - GT_da_pb
3. **Auto-calc:** GT_phan_bo_1ky = Nguyen_gia / So_ky
4. **Sua phan bo:** Khi chk_Giatri_pb1ky checked, cho phep sua GT_phan_bo_1ky
5. **Lookup:** TK (chi_tiet=1), MA_BPSD, Ma_SPCT, MA_PHI
6. **ma_cty:** Ma chi phi khong cho phep sua sau khi tao

## Mapping PHP

### 1. Model

```php
// app/Models/CO/DMCPTT.php
class DMCPTT extends Model
{
    protected $table = 'DMCPTT';
    protected $primaryKey = 'ID';
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'ma_cptt', 'ten_cptt', 'dvt', 'so_luong', 'don_gia',
        'so_ky', 'ng_gia', 'gt_da_kh', 'gt_cl', 'kh_ky',
        'tk_cptt', 'tk_cp', 'so_ct', 'ngay_ct', 'ngay_bdkh',
        'ngay_gt_cl', 'MA_PHI', 'ma_bpsd', 'ma_spct', 'sua_kh',
    ];

    protected $casts = [
        'so_luong' => 'decimal:2',
        'don_gia' => 'decimal:2',
        'so_ky' => 'integer',
        'ng_gia' => 'decimal:2',
        'gt_da_kh' => 'decimal:2',
        'gt_cl' => 'decimal:2',
        'kh_ky' => 'decimal:2',
        'sua_kh' => 'boolean',
        'ngay_ct' => 'date',
        'ngay_bdkh' => 'date',
        'ngay_gt_cl' => 'date',
    ];

    public static function autoCalcNguyenGia($soLuong, $donGia)
    {
        return $soLuong * $donGia;
    }

    public static function autoCalcGTCL($nguyenGia, $gtDaKh)
    {
        return $nguyenGia - $gtDaKh;
    }

    public static function autoCalcGT1Ky($nguyenGia, $soKy)
    {
        return $soKy > 0 ? $nguyenGia / $soKy : 0;
    }
}
```

### 2. SP Classes

```php
class AsCoGetDMCPTT extends StoredProcedure
{
    protected $procedure = 'DMCPTT_Get';
    protected $params = ['pMa_cty', 'pSearch', 'pMode'];
}

class AsCoInsDMCPTT extends StoredProcedure
{
    protected $procedure = 'DMCPTT_Insert';
    protected $params = [
        'pMa_cptt', 'pSo_ct', 'pNgay_ct', 'pTen_cptt', 'pDvt',
        'pSo_luong', 'pDon_gia', 'pNg_gia', 'pGt_da_kh', 'pGt_cl',
        'pKh', 'pSo_ky', 'pKh_ky', 'pNgay_bdkh', 'pNgay_gt_cl',
        'pTk_cptt', 'pTk_cp', 'pMa_bpsd', 'pMa_spct', 'pMa_phi',
        'pIsNew', 'pSua_kh',
    ];
}

class AsCoUpdDMCPTT extends StoredProcedure
{
    protected $procedure = 'DMCPTT_Update';
    protected $params = [
        'pMa_cty', 'pID', 'pMa_cptt', 'pSo_ct', 'pNgay_ct',
        'pTen_cptt', 'pDvt', 'pSo_luong', 'pDon_gia', 'pNg_gia',
        'pGt_da_kh', 'pGt_cl', 'pKh', 'pSo_ky', 'pKh_ky',
        'pNgay_bdkh', 'pNgay_gt_cl', 'pTk_cptt', 'pTk_cp',
        'pMa_bpsd', 'pMa_spct', 'pMa_phi', 'pIsNew', 'pSua_kh',
    ];
}

class AsCoDelDMCPTT extends StoredProcedure
{
    protected $procedure = 'DMCPTT_Delete';
    protected $params = ['pMa_cptt', 'pID'];
}
```

### 3. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Chiphitaptrung.php
class Chiphitaptrung extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'DMCPTT';

    public function render(): View
    {
        return view('catalog::co.chi-phi-tap-trung');
    }
}
```

### 4. Views & Routes

```
resources/views/catalog/co/
├── chi-phi-tap-trung.blade.php
```

```php
Route::get('/co/chi-phi-tap-trung', [Chiphitaptrung::class, 'render'])
    ->name('co.chi-phi-tap-trung');
```

## Dependencies

| Loai | Package | File |
|------|---------|------|
| Model | laravel-simba | DMCPTT.php |
| SP | laravel-simba | AsCoGetDMCPTT.php |
| SP | laravel-simba | AsCoInsDMCPTT.php |
| SP | laravel-simba | AsCoUpdDMCPTT.php |
| SP | laravel-simba | AsCoDelDMCPTT.php |
| Component | laravel-catalog | Chiphitaptrung.php |
| Lookup | System | DSTK |
| Lookup | CO | DMSPCT, DMBPSD, DMPHI |

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao SP classes
- [ ] Tao Model DMCPTT
- [ ] Tao Livewire Chiphitaptrung
- [ ] Tao View (edit form voi auto-calc)
- [ ] Test CRUD + auto-calculation
