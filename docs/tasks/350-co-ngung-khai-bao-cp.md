# Task 350: CO - Ngung khai bao chi phi cong trinh (CoNgungKHCPTT)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 350 |
| **DLL** | CoNgungKHCPTT.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Master/Danh muc |
| **Assembly Title** | Ngung khai bao chi phi cong trinh |
| **Version** | 1.0.0.0 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly viec ngung khai bao chi phi tap trung (CPTT). Cho phep khai bao ngay ngung phan bo cho cac khoan chi phi tap trung, tuy chon phan bo not so du vao thang ngung phan bo.

## Form classes

### 1. frmCoNgungKhCPTT (Form xem danh sach)
- **Ke thua:** `frmDMComplexView`
- **Chuc nang:** Hien thi danh sach ngung khai bao CPTT
- **Controls:**
  - `cmdChgCode` - An (Visible = false)
  - `txtValue` - An (Visible = false)
  - `cboFilter` - An (Visible = false)
  - `cmdSearch` - An (Visible = false)
  - `lblTen` - An (Visible = false)
  - `cmdPrint` - An (Visible = false)
  - `cmdAdd`, `cmdDel`, `cmdEdit` - Dieu chinh vi tri
- **GetData override:**
  ```
  base.GetData(CompanyID, "", true);
  ```

### 2. frmCoNgungKhCPTTEdit (Form them/sua)
- **Ke thua:** `frmDMComplexEdit`
- **Chuc nang:** Nhap, sua thong tin ngung khai bao
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_cptt | AsTextBox | ma_cptt | Ma chi phi tap trung (AutoLookup) |
| lblTen_cptt | Label | ten_cptt | Ten chi phi tap trung |
| txtNguyen_gia | AsTextNumeric | ng_gia | Nguyen gia (readonly) |
| txtNgay_bd_kh | AsMaskedTextBox | ngay_bdkh | Ngay bat dau khai bao |
| txtNgay_tkh | DateTimePicker | ngay_tkh | Ngay ngung khai bao |
| chkKh_so_du | CheckBox | kh_so_du | Phan bo not so du vao thang ngung |
| txtID | AsTextNumeric | id | ID (hidden) |
| Label1 | Label | - | Nhan "Ma chi phi" |
| Label2 | Label | - | Nhan "Ngay bat dau" |
| Label5 | Label | - | Nhan "Nguyen gia" |
| Label16 | Label | - | Nhan "Dung phan bo tai cuoi thang" |
| cmdSave | Button | - | Nut luu |
| cmdCancel | Button | - | Nut huy |

## Data structures

### Bang: CONGUNGKHCPTT (Ngung khai bao CPTT)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| id | int | Khoa chinh |
| ma_cptt | varchar | Ma chi phi tap trung |
| ten_cptt | nvarchar | Ten chi phi tap trung |
| ng_gia | decimal | Nguyen gia |
| ngay_bdkh | datetime | Ngay bat dau khai bao |
| ngay_tkh | datetime | Ngay ngung khai bao |
| kh_so_du | bit | Phan bo not so du |
| thang_tkh | varchar | Thang ngung (text) |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| CoGetNgungKH_CPTT | Lay danh sach ngung khai bao |
| CoUpdNgungKH_CPTT | Them/Cap nhat ngung khai bao |
| CoDelNgungKH_CPTT | Xoa ngung khai bao |

## Business Logic

### Validation Rules
| Rule | Field | Message |
|------|-------|---------|
| Required | ma_cptt | Ma chi phi khong duoc trong |
| Required | ngay_tkh | Ngay ngung phai hop le (khac 01/01/1900) |

### Business Rules
1. **Lookup ma_cptt**: Sau khi chon → tu dien dien ten_cptt, ng_gia, ngay_bdkh
2. **Ngay_tkh**: Format MM/YYYY, chuyen thanh ngay 1 cua thang do
3. **Xoa**: Khi xoa → cap nhat ngay_tkh = 01/01/1900 (danh dau con hieu luc)
4. **Confirm xoa**: Hien thi hop thoai xac nhan truoc khi xoa
5. **IsUpd flag**: Phuong thuc UpdateNgungKH xu ly ca Insert va Update

## Mapping PHP

### 1. Model

```php
// app/Models/CO/NgungKHCPTT.php
namespace Diepxuan\Simba\Models\CO;

class NgungKHCPTT extends Model
{
    protected $table = 'CONGUNGKHCPTT';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'ma_cptt', 'ten_cptt', 'ng_gia',
        'ngay_bdkh', 'ngay_tkh', 'kh_so_du', 'thang_tkh',
    ];

    protected $casts = [
        'ng_gia' => 'decimal:2',
        'kh_so_du' => 'boolean',
    ];

    public function chiPhiTapTrung()
    {
        return $this->belongsTo(DMCPTT::class, 'ma_cptt', 'ma_cptt');
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
// diepxuan/laravel-simba/src/StoredProcedures/AsCoGetNgungKH_CPTT.php
class AsCoGetNgungKH_CPTT extends StoredProcedure
{
    protected $procedure = 'CoGetNgungKH_CPTT';
    protected $params = ['pMa_cty', 'pSearch'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoUpdNgungKH_CPTT.php
class AsCoUpdNgungKH_CPTT extends StoredProcedure
{
    protected $procedure = 'CoUpdNgungKH_CPTT';
    protected $params = ['pMa_cty', 'pMa_cptt', 'pNgay_tkh', 'pKh_so_du', 'pIsUpd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoDelNgungKH_CPTT.php
class AsCoDelNgungKH_CPTT extends StoredProcedure
{
    protected $procedure = 'CoDelNgungKH_CPTT';
    protected $params = ['pMa_cty', 'pMa_cptt', 'pId'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Ngungkhaibaocpchicongtrinh.php
namespace Diepxuan\Catalog\Http\Livewire\CO;

class Ngungkhaibaocpchicongtrinh extends Component
{
    const MA_CT = 'CO';

    public Collection $pData;
    public ?int $pEditingId = null;
    public string $pMaCptt = '';
    public string $pTenCptt = '';
    public float $pNgGia = 0;
    public ?string $pNgayBdkh = null;
    public ?string $pNgayTkh = null;
    public bool $pKhSoDu = false;

    protected $rules = [
        'pMaCptt' => 'required|string',
        'pNgayTkh' => 'required|date',
    ];

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        // Goi SP CoGetNgungKH_CPTT
    }

    public function edit(int $id): void
    {
        // Load record de edit
    }

    public function delete(int $id, string $maCptt): void
    {
        // Goi SP CoDelNgungKH_CPTT
    }

    public function submit(): void
    {
        $this->validate();
        $isUpd = $this->pEditingId !== null;
        // Goi SP CoUpdNgungKH_CPTT
    }

    public function render(): View
    {
        return view('catalog::co.ngung-khai-bao-cp-cong-trinh');
    }
}
```

### 4. Views

```
resources/views/catalog/co/
├── ngung-khai-bao-cp-cong-trinh.blade.php     (List + Form)
└── _ngung-cptt-row.blade.php                   (Row component)
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        Route::get('/ngung-khai-bao-cp-cong-trinh', [Ngungkhaibaocpchicongtrinh::class, 'render'])
            ->name('ngung-khai-bao-cp-cong-trinh');
        Route::post('/ngung-khai-bao-cp-cong-trinh/submit', [Ngungkhaibaocpchicongtrinh::class, 'submit'])
            ->name('ngung-khai-bao-cp-cong-trinh.submit');
        Route::post('/ngung-khai-bao-cp-cong-trinh/delete', [Ngungkhaibaocpchicongtrinh::class, 'delete'])
            ->name('ngung-khai-bao-cp-cong-trinh.delete');
    });
```

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | NgungKHCPTT.php | Chinh |
| SP | laravel-simba | AsCoGetNgungKH_CPTT.php | Get |
| SP | laravel-simba | AsCoUpdNgungKH_CPTT.php | Insert/Update |
| SP | laravel-simba | AsCoDelNgungKH_CPTT.php | Delete |
| Component | laravel-catalog | Ngungkhaibaocpchicongtrinh.php | List + Edit |
| DM | CO | DMCPTT | Lookup CPTT |

## Progress Checklist

- [ ] Phan tich yeu cau & review task
- [ ] Tao Stored Procedure classes (Get, Upd, Del)
- [ ] Tao Model NgungKHCPTT
- [ ] Tao Livewire Ngungkhaibaocpchicongtrinh
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test xoa (update ngay_tkh = 01/01/1900)

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
