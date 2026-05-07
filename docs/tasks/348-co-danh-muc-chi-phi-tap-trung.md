# Task 348: CO - Danh muc chi phi cong trinh (CoDMCPTT)

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

Quan ly danh muc chi phi tap trung (CPTT). Cho phep khai bao, them, sua, xoa cac khoan chi phi tap trung, tinh toan tu dong nguyen gia, gia tri con lai, gia tri phan bo 1 ky, va theo doi qua trinh phan bo.

## Form classes

### 1. frmCoDMCPTT (Form xem danh sach)
- **Ke thua:** `frmDMComplexView`
- **Chuc nang:** Hien thi danh sach chi phi tap trung
- **Controls:**
  - `cmdChgCode` - An (Visible = false)
  - `cmdSearch` - An (Visible = false)
  - `cmdPrint` - An (Visible = false)
  - `txtValue` - An (Visible = false)
  - `cboFilter` - An (Visible = false)
  - `lblTen` - An (Visible = false)

### 2. frmCoDMCPTTEdit (Form them/sua)
- **Ke thua:** `frmDMComplexEdit`
- **Chuc nang:** Nhap, sua thong tin chi phi tap trung
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_cptt | AsTextBox | ma_cptt | Ma chi phi tap trung (AutoLookup) |
| txtTen_cptt | AsTextBox | ten_cptt | Ten chi phi tap trung |
| txtDvt | AsTextBox | dvt | Don vi tinh |
| txtSo_ct | AsTextBox | so_ct | So chung tu |
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay chung tu |
| txtSo_luong | AsTextNumeric | so_luong | So luong |
| txtDon_gia | AsTextNumeric | don_gia | Don gia |
| txtSo_ky_BP | AsTextNumeric | so_ky | So ky phan bo |
| txtNguyen_gia | AsTextNumeric | ng_gia | Nguyen gia (readonly) |
| txtGia_tri_da_pb | AsTextNumeric | gt_da_kh | Gia tri da phan bo (readonly) |
| txtGiatri_pn_con_lai | AsTextNumeric | gt_cl | Gia tri con lai (readonly) |
| txtGiatri_pb_1ky | AsTextNumeric | kh_ky | Gia tri PB 1 ky (readonly) |
| txtNgay_bdau_bp | AsMaskedTextBox | ngay_bdkh | Ngay bat dau phan bo |
| txtNgay_gtcl | AsMaskedTextBox | ngay_gt_cl | Ngay gia tri con lai |
| Chk_Giatri_pb1ky | CheckBox | sua_kh | Cho phep sua phan bo |
| txtTK_pb | AsTextBox | tk_cptt | TK phan bo (AutoLookup) |
| txtTK_chiphi | AsTextBox | tk_cp | TK chi phi (AutoLookup) |
| txtMa_bpsd | AsTextBox | ma_bpsd | Ma bo phan su dung (AutoLookup) |
| txtMa_spct | AsTextBox | ma_spct | Ma SPCT (AutoLookup) |
| txtMa_phi | AsTextBox | MA_PHI | Ma phi (AutoLookup) |

## Data structures

### Bang: CODMCPTT (Danh muc chi phi tap trung)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| id | int | Khoa chinh |
| ma_cptt | varchar | Ma chi phi tap trung |
| ten_cptt | nvarchar | Ten chi phi tap trung |
| dvt | varchar | Don vi tinh |
| so_ct | varchar | So chung tu |
| ngay_ct | datetime | Ngay chung tu |
| so_luong | decimal | So luong |
| don_gia | decimal | Don gia |
| so_ky | int | So ky phan bo |
| ng_gia | decimal | Nguyen gia |
| gt_da_kh | decimal | Gia tri da phan bo |
| gt_cl | decimal | Gia tri con lai |
| kh_ky | decimal | Gia tri PB 1 ky |
| ngay_bdkh | datetime | Ngay bat dau PB |
| ngay_gt_cl | datetime | Ngay gia tri con lai |
| sua_kh | bit | Cho phep sua PB |
| tk_cptt | varchar | TK phan bo |
| tk_cp | varchar | TK chi phi |
| ma_bpsd | varchar | Ma bo phan su dung |
| ma_spct | varchar | Ma SPCT |
| MA_PHI | varchar | Ma phi |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| CoGetDmCPTT | Lay danh sach chi phi tap trung |
| InsCPTT | Them chi phi tap trung moi |
| UpdCPTT | Cap nhat chi phi tap trung |
| DelCPTT | Xoa chi phi tap trung |

## Business Logic

### Validation Rules
| Rule | Field | Message |
|------|-------|---------|
| Required | ma_cptt | Ma chi phi khong duoc trong |
| Required | ten_cptt | Ten chi phi khong duoc trong |
| Positive | so_luong | So luong phai > 0 |
| Positive | so_ky | So ky PB phai > 0 |
| Required | tk_cptt | TK phan bo khong duoc trong |
| Required | tk_cp | TK chi phi khong duoc trong |

### Business Rules
1. **Tinh nguyen gia**: `ng_gia = so_luong * don_gia`
2. **Tinh gia tri con lai**: `gt_cl = ng_gia - gt_da_kh`
3. **Tinh gia tri PB 1 ky**: `kh_ky = ng_gia / so_ky`
4. **Tinh toan tu dong**: Khi thay đổi so_luong/don_gia → tinh lai ng_gia
5. **Lookup**: ma_cptt, tk_cptt, tk_cp, ma_bpsd, ma_spct, ma_phi deu co AutoLookup
6. **Readonly**: ng_gia, gt_da_kh, gt_cl, kh_ky la truong tinh toan (readonly)
7. **Ngay GTCL >= Ngay bat dau PB**

## Mapping PHP

### 1. Model

```php
// app/Models/CO/DMCPTT.php
namespace Diepxuan\Simba\Models\CO;

class DMCPTT extends Model
{
    protected $table = 'CODMCPTT';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'ma_cptt', 'ten_cptt', 'dvt',
        'so_ct', 'ngay_ct', 'so_luong', 'don_gia',
        'so_ky', 'ng_gia', 'gt_da_kh', 'gt_cl', 'kh_ky',
        'ngay_bdkh', 'ngay_gt_cl', 'sua_kh',
        'tk_cptt', 'tk_cp', 'ma_bpsd', 'ma_spct', 'MA_PHI',
    ];

    protected $casts = [
        'so_luong' => 'decimal:4',
        'don_gia' => 'decimal:2',
        'so_ky' => 'integer',
        'ng_gia' => 'decimal:2',
        'gt_da_kh' => 'decimal:2',
        'gt_cl' => 'decimal:2',
        'kh_ky' => 'decimal:2',
        'sua_kh' => 'boolean',
    ];

    // Computed
    public static function tinhNguyenGia($soLuong, $donGia)
    {
        return $soLuong * $donGia;
    }

    public static function tinhGiaTriConLai($ngGia, $gtDaKh)
    {
        return $ngGia - $gtDaKh;
    }

    public static function tinhGiaTriPB1Ky($ngGia, $soKy)
    {
        return $soKy > 0 ? $ngGia / $soKy : 0;
    }

    public function boPhanSuDung()
    {
        return $this->belongsTo(DMBO::class, 'ma_bpsd', 'ma_bpsd');
    }

    public function scopeByCompany($query, $maCty)
    {
        return $query->where('ma_cty', $maCty);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_cptt', 'like', "%{$search}%")
              ->orWhere('ten_cptt', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCoGetDmCPTT.php
class AsCoGetDmCPTT extends StoredProcedure
{
    protected $procedure = 'CoGetDmCPTT';
    protected $params = ['pMa_cty', 'pSearch'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoInsCPTT.php
class AsCoInsCPTT extends StoredProcedure
{
    protected $procedure = 'InsCPTT';
    protected $params = [
        'pMa_cty', 'pMa_cptt', 'pTen_cptt', 'pDvt',
        'pSo_ct', 'pNgay_ct', 'pSo_luong', 'pDon_gia',
        'pSo_ky', 'pTk_cptt', 'pTk_cp', 'pMa_bpsd',
        'pMa_spct', 'pMA_PHI',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoUpdCPTT.php
class AsCoUpdCPTT extends StoredProcedure
{
    protected $procedure = 'UpdCPTT';
    protected $params = [
        'pMa_cty', 'pId', 'pMa_cptt', 'pTen_cptt', 'pDvt',
        'pSo_ct', 'pNgay_ct', 'pSo_luong', 'pDon_gia',
        'pSo_ky', 'pTk_cptt', 'pTk_cp', 'pMa_bpsd',
        'pMa_spct', 'pMA_PHI',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoDelCPTT.php
class AsCoDelCPTT extends StoredProcedure
{
    protected $procedure = 'DelCPTT';
    protected $params = ['pMa_cty', 'pId'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Danhmuccpchicongtrinh.php
namespace Diepxuan\Catalog\Http\Livewire\CO;

class Danhmuccpchicongtrinh extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'DMCPTT';

    public function render(): View
    {
        return view('catalog::co.danh-muc-cp-cong-trinh');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/CO/DanhmuccpchicongtrinhEdit.php
class DanhmuccpchicongtrinhEdit extends Component
{
    public ?int $pId = null;
    public string $pMaCptt = '';
    public string $pTenCptt = '';
    public string $pDvt = '';
    public string $pSoCt = '';
    public ?string $pNgayCt = null;
    public float $pSoLuong = 0;
    public float $pDonGia = 0;
    public int $pSoKy = 0;
    public float $pNgGia = 0;
    public float $pGtDaKh = 0;
    public float $pGtCl = 0;
    public float $pKhKy = 0;
    public ?string $pNgayBdkh = null;
    public ?string $pNgayGtCl = null;
    public bool $pSuaKh = false;
    public ?string $pTkCptt = null;
    public ?string $pTkCp = null;
    public ?string $pMaBpsd = null;
    public ?string $pMaSpct = null;
    public ?string $pMaPhi = null;
    public string $pMode = 'create';

    protected $rules = [
        'pMaCptt' => 'required|string|max:20',
        'pTenCptt' => 'required|string|max:200',
        'pSoLuong' => 'required|numeric|min:0',
        'pSoKy' => 'required|integer|min:1',
        'pTkCptt' => 'required|string',
        'pTkCp' => 'required|string',
    ];

    public function tinhToan(): void
    {
        $this->pNgGia = $this->pSoLuong * $this->pDonGia;
        $this->pGtCl = $this->pNgGia - $this->pGtDaKh;
        $this->pKhKy = $this->pSoKy > 0 ? $this->pNgGia / $this->pSoKy : 0;
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->loadChiPhi($id);
        }
    }

    public function submit(): void
    {
        $this->validate();
        $this->tinhToan();
        // Goi SP Insert/Update
    }

    public function render(): View
    {
        return view('catalog::co.danh-muc-cp-cong-trinh-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/co/
├── danh-muc-cp-cong-trinh.blade.php        (List)
├── danh-muc-cp-cong-trinh-edit.blade.php   (Edit modal)
└── _cptt-row.blade.php                     (Row component)
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        Route::get('/danh-muc-cp-cong-trinh', [Danhmuccpchicongtrinh::class, 'render'])
            ->name('danh-muc-cp-cong-trinh');
        Route::get('/danh-muc-cp-cong-trinh/edit/{id?}', [DanhmuccpchicongtrinhEdit::class, 'render'])
            ->name('danh-muc-cp-cong-trinh.edit');
    });
```

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMCPTT.php | Chinh |
| SP | laravel-simba | AsCoGetDmCPTT.php | Get |
| SP | laravel-simba | AsCoInsCPTT.php | Insert |
| SP | laravel-simba | AsCoUpdCPTT.php | Update |
| SP | laravel-simba | AsCoDelCPTT.php | Delete |
| Component | laravel-catalog | Danhmuccpchicongtrinh.php | List |
| Component | laravel-catalog | DanhmuccpchicongtrinhEdit.php | Edit |
| DM | System | DSTK | Lookup TK |
| DM | CO | DMSPCT | Lookup SPCT |
| DM | CO | DMBO | Lookup BP |

## Progress Checklist

- [ ] Phan tich yeu cau & review task
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete)
- [ ] Tao Model DMCPTT
- [ ] Tao Livewire Danhmuccpchicongtrinh (list + edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test tinh toan tu dong (ng_gia, gt_cl, kh_ky)
