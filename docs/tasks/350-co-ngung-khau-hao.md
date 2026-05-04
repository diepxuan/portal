# Task 350: CO - Ngung khau hao chi phi tap trung (CoNgungKHCPTT)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 350 |
| **DLL** | CoNgungKHCPTT.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Master/Danh muc |
| **Assembly Title** | FADMCC |
| **Version** | 1.0.0.0 |
| **GUID** | b71f3569-e439-4607-b511-60dc5628362c |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly viec ngung phan bo (ngung khau hao) cho cac chi phi tap trung. Cho pheu danh dau thoi diem ngung phan bo va tuy chon phan bo not so du vao thang cuoi.

## Form classes

### 1. frmCoNgungKhCPTT (Form danh sach)
- **Ke thua:** `frmDMComplexView`
- **Chuc nang:** Hien thi danh sach chi phi TT da ngung KH
- **GetData:** `[CompanyID, "", true]` (mode = true: lay data ngung KH)
- **Delete:** Goi `COPBDAO.CoDelNgungKH_CPTT([CompanyID, ma_cptt, id])`

### 2. frmCoNgungKhCPTTEdit (Form chinh sua)
- **Ke thua:** `frmDMComplexEdit`
- **Chuc nang:** Them/sua thong tin ngung KH
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_cptt | AsTextBox | ma_cptt | Ma chi phi (AutoLookup) |
| lblTen_cptt | Label | - | Ten chi phi (lookup) |
| txtNguyen_gia | AsTextNumeric | ng_gia | Nguyen gia (readonly) |
| txtNgay_bd_kh | AsMaskedTextBox | ngay_bdkh | Ngay bat dau KH (readonly) |
| txtNgay_tkh | DateTimePicker | ngay_tkh | Thang ngung KH |
| chkKh_so_du | CheckBox | kh_so_du | Phan bo not so du |
| txtID | AsTextNumeric | id | ID (hidden) |

### Data Access
- **COPBDAO** (Interface): `CoUpdNgungKH_CPTT`, `CoDelNgungKH_CPTT`
- **MsSqlCOPBDAO**: SQL Server implementation
- **SP:** `asCoUpdNgungKH_CPTT` (Insert/Update), `asCoDelNgungKH_CPTT` (Delete)

### Parameters cho asCoUpdNgungKH_CPTT
```
[pMa_cty, pMa_cptt, pNgay_tkh, pKh_so_du, pIsUpd, pRet]
```
- pIsUpd = false: Insert, true: Update

## Cau truc du lieu

### Bang: CONGUNGCPTT (Ngung phan bo CPTT)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| id | int | ID (PK) |
| ma_cty | varchar | Ma cong ty |
| ma_cptt | varchar | Ma chi phi |
| ngay_tkh | datetime | Thang ngung KH |
| kh_so_du | bit | Phan bo not so du |
| ng_gia | decimal | Nguyen gia (tham chieu) |
| ngay_bdkh | datetime | Ngay bat dau KH (tham chieu) |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| CoNgungKH_CPTT_Get | Lay danh sach ngung KH |
| asCoUpdNgungKH_CPTT | Insert/Update thong tin ngung KH |
| asCoDelNgungKH_CPTT | Xoa thong tin ngung KH |

## Business Logic

### Validation
1. **ma_cptt:** Khong duoc trong
2. **ngay_tkh:** Khong duoc la 01/01/1900

### Business Rules
1. **Lookup:** Khi chon ma_cptt, tu dong load ten, ng_gia, ngay_bdkh
2. **Readonly:** Nguyen_gia va Ngay_bd_kh chi doc
3. **DateTimePicker:** Ngay_tkh format MM/yyyy (thang/ngung)
4. **Phan bo not so du:** chkKh_so_du = true => phan bo het so du vang thang cuoi

## Mapping PHP

### 1. Model

```php
// app/Models/CO/CoNgungKHCPTT.php
class CoNgungKHCPTT extends Model
{
    protected $table = 'CONGUNGCPTT';
    protected $primaryKey = 'id';
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'ma_cptt', 'ngay_tkh', 'kh_so_du',
    ];

    protected $casts = [
        'kh_so_du' => 'boolean',
        'ngay_tkh' => 'date',
    ];

    public function chiPhiTapTrung()
    {
        return $this->belongsTo(DMCPTT::class, 'ma_cptt', 'ma_cptt');
    }
}
```

### 2. SP Classes

```php
class AsCoGetNgungKHCPTT extends StoredProcedure
{
    protected $procedure = 'CoNgungKH_CPTT_Get';
    protected $params = ['pMa_cty', 'pSearch'];
}

class AsCoUpdNgungKHCPTT extends StoredProcedure
{
    protected $procedure = 'asCoUpdNgungKH_CPTT';
    protected $params = ['pMa_cty', 'pMa_cptt', 'pNgay_tkh', 'pKh_so_du', 'pIsUpd'];
}

class AsCoDelNgungKHCPTT extends StoredProcedure
{
    protected $procedure = 'asCoDelNgungKH_CPTT';
    protected $params = ['pMa_cty', 'pMa_cptt', 'pId'];
}
```

### 3. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Ngungkhauhao.php
class Ngungkhauhao extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'CONGUNGCPTT';

    public function render(): View
    {
        return view('catalog::co.ngung-khau-hao');
    }
}
```

### 4. Views & Routes

```
resources/views/catalog/co/
├── ngung-khau-hao.blade.php
```

```php
Route::get('/co/ngung-khau-hao', [Ngungkhauhao::class, 'render'])
    ->name('co.ngung-khau-hao');
```

## Dependencies

| Loai | Package | File |
|------|---------|------|
| Model | laravel-simba | CoNgungKHCPTT.php |
| Model | laravel-simba | DMCPTT.php |
| SP | laravel-simba | AsCoGetNgungKHCPTT.php |
| SP | laravel-simba | AsCoUpdNgungKHCPTT.php |
| SP | laravel-simba | AsCoDelNgungKHCPTT.php |
| Lookup | CO | DMCPTT |

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao SP classes
- [ ] Tao Model CoNgungKHCPTT
- [ ] Tao Livewire Ngungkhauhao
- [ ] Tao View
- [ ] Test CRUD
