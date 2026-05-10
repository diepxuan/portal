# Task 104: INVchIN6

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang phieu lap rap/thao do tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** INVchIN6.dll
- **Chuc nang:** Phieu lap rap/thao do
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Phieu lap rap/thao do
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN6 (phieu lap rap/thao do)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INVchIN6.dll/README.md`

---

## Cau truc du lieu

### Bang: IN6 (Phieu lap rap/thao do - Header)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_cty | varchar | 50 | Ma cong ty |
| stt_rec | varchar | 50 | So thu tu record (khoa chinh) |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | (18,8) | Ty gia |
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | - | Ngay chung tu |
| ma_kh | varchar | 50 | Ma khach hang |
| ten_kh | nvarchar | 200 | Ten khach hang |
| dia_chi | nvarchar | 200 | Dia chi |
| nguoi_gd | nvarchar | 100 | Nguoi giao dich |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_gd | varchar | 50 | Ma giao dich (1=lap rap, 2=thao do) |
| tien_nt | decimal | (18,8) | Tong tien ngoai te |
| tien | decimal | (18,8) | Tong tien VND |

### Bang: IN6CT (Phieu lap rap/thao do - Detail Master)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu record master |
| ma_vt | varchar | Ma vat tu (bo/thanh pham) |
| ten_vt | nvarchar | Ten vat tu |
| dvt | nvarchar | Don vi tinh |
| ma_kho | varchar | Ma kho |
| so_luong | decimal | So luong |
| gia_nt | decimal | Gia ngoai te |
| tien_nt | decimal | Thanh tien ngoai te |
| gia | decimal | Gia VND |
| tien | decimal | Thanh tien VND |
| tk_vt | varchar | TK kho |
| ma_nx | varchar | Ma nhap xuat |
| ma_bp | varchar | Ma bo phan |
| ma_phi | varchar | Ma phi |
| ma_hd | varchar | Ma hop dong |
| ma_spct | varchar | Ma san pham chi tiet |

### Bang: IN6CTD (Phieu lap rap/thao do - Detail Chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu record master (FK) |
| stt_rec1 | varchar | So thu tu record detail |
| ma_vt | varchar | Ma vat tu chi tiet |
| ten_vt | nvarchar | Ten vat tu chi tiet |
| dvt | nvarchar | Don vi tinh |
| ma_kho | varchar | Ma kho |
| so_luong | decimal | So luong |
| gia_nt | decimal | Gia ngoai te |
| tien_nt | decimal | Thanh tien ngoai te |
| gia | decimal | Gia VND |
| tien | decimal | Thanh tien VND |
| tk_vt | varchar | TK kho |
| ma_nx | varchar | Ma nhap xuat |
| ma_bp | varchar | Ma bo phan |
| ma_phi | varchar | Ma phi |
| ma_hd | varchar | Ma hop dong |
| ma_spct | varchar | Ma san pham chi tiet |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_vt -> DMVT.ma_vt |
| DMBOM | Danh muc dinh muc (BOM) | Lookup ma_vt -> DMBOM.ma_vt |

---

## Form classes

### 1. frmInVchIN6 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap, sua, xoa phieu lap rap/thao do
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_CT | AsTextBox | so_ct | So phieu |
| dtpNgay_CT | DateTimePicker | ngay_ct | Ngay phieu |
| txtMa_KH | AsTextBox | ma_kh | Ma khach hang |
| txtTen_KH | TextBox | ten_kh | Ten khach hang |
| cboMa_GD | ComboBox | ma_gd | Loai giao dich (1=lap rap, 2=thao do) |
| cboMa_NT | ComboBox | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtTien_NT | AsTextNumeric | tien_nt | Tong tien NT |
| txtTien | AsTextNumeric | tien | Tong tien VND |
| dgvCTMaster | DataGridView | IN6CT | Luoi chi tiet master (bo) |
| dgvCTDetail | DataGridView | IN6CTD | Luoi chi tiet thanh phan |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_IN6_GET | Lay danh sach phieu lap rap/thao do |
| SP_IN_IN6_GETBYID | Lay chi tiet 1 phieu lap rap/thao do |
| SP_IN_IN6_INSERT | Them phieu lap rap/thao do |
| SP_IN_IN6_UPDATE | Cap nhat phieu lap rap/thao do |
| SP_IN_IN6_DELETE | Xoa phieu lap rap/thao do |
| SP_IN_IN6_FIND | Tim kiem |
| SP_IN_IN6_CHECK | Kiem tra trung so chung tu |

### SP_GET (reference)

```sql
-- Lay danh sach phieu lap rap/thao do
EXEC SP_IN_IN6_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | so_ct | 'So phieu khong duoc trong' |
| Required | ngay_ct | 'Ngay phieu khong duoc trong' |
| Required | ma_gd | 'Loai giao dich khong duoc trong' |
| Required | detail master | 'Phai co it nhat 1 bo san pham' |
| Required | detail chi tiet | 'Phai co it nhat 1 thanh phan' |

### Business Rules

1. **Lap rap (ma_gd=1)**:
   - Xuat chi tiet tu kho
   - Nhap thanh pham vao kho
   - Tu dong lay chi tiet tu BOM khi nhap ma_vt master

2. **Thao do (ma_gd=2)**:
   - Xuat thanh pham tu kho
   - Nhap chi tiet vao kho
   - Phan bo gia thanh pham cho cac chi tiet

3. **Tinh gia tri**:
   - Gia thanh pham = SUM(gia chi tiet) khi lap rap
   - Gia chi tiet = Gia thanh pham / so luong chi tiet khi thao do

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/IN6.php
namespace Diepxuan\Simba\Models\IN;

class IN6 extends Model
{
    protected $table = 'IN6';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'stt_rec', 'ma_nt', 'ty_gia', 'so_ct', 'ngay_ct',
        'ma_kh', 'ten_kh', 'dia_chi', 'nguoi_gd', 'dien_giai',
        'ma_gd', 'tien_nt', 'tien',
    ];

    public function chiTietMaster()
    {
        return $this->hasMany(IN6CT::class, 'stt_rec', 'stt_rec');
    }
}

// app/Models/IN/IN6CT.php
class IN6CT extends Model
{
    protected $table = 'IN6CT';
    protected $primaryKey = 'stt_rec0';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    public function phieu()
    {
        return $this->belongsTo(IN6::class, 'stt_rec', 'stt_rec');
    }

    public function chiTiet()
    {
        return $this->hasMany(IN6CTD::class, 'stt_rec0', 'stt_rec0');
    }
}

// app/Models/IN/IN6CTD.php
class IN6CTD extends Model
{
    protected $table = 'IN6CTD';
    protected $primaryKey = 'stt_rec1';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetIN6.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetIN6 extends StoredProcedure
{
    protected $procedure = 'SP_IN_IN6_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsIN6.php
class AsINInsIN6 extends StoredProcedure
{
    protected $procedure = 'SP_IN_IN6_INSERT';
    protected $params = [
        'pMa_cty', 'stt_rec', 'ma_nt', 'ty_gia', 'so_ct', 'ngay_ct',
        'ma_kh', 'ten_kh', 'dia_chi', 'nguoi_gd', 'dien_giai',
        'ma_gd', 'tien_nt', 'tien',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdIN6.php
class AsINUpdIN6 extends StoredProcedure
{
    protected $procedure = 'SP_IN_IN6_UPDATE';
    protected $params = [
        'pMa_cty', 'stt_rec', 'ma_nt', 'ty_gia', 'so_ct', 'ngay_ct',
        'ma_kh', 'ten_kh', 'dia_chi', 'nguoi_gd', 'dien_giai',
        'ma_gd', 'tien_nt', 'tien',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelIN6.php
class AsINDelIN6 extends StoredProcedure
{
    protected $procedure = 'SP_IN_IN6_DELETE';
    protected $params = ['pMa_cty', 'stt_rec'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChkIN6.php
class AsINChkIN6 extends StoredProcedure
{
    protected $procedure = 'SP_IN_IN6_CHECK';
    protected $params = ['pMa_cty', 'so_ct'];
}
```

### 3. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/LaprapthaodoEdit.php
namespace Diepxuan\Catalog\Http\Livewire\IN;

class LaprapthaodoEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pSoCT = '';
    public Carbon $pNgayCT;
    public ?string $pMaKH = null;
    public ?string $pMaGD = '1'; // 1=lap rap, 2=thao do
    public ?string $pMaNT = 'VND';
    public float $pTyGia = 1;
    public Collection $pChiTietMaster; // Bo/Thanh pham
    public Collection $pChiTietDetail; // Chi tiet
    public ?string $pMode = 'create';

    public function updatedPChiTietMaster($value, $key): void
    {
        // Khi chon ma_vt master, tu dong load chi tiet tu BOM
        if (isset($value['ma_vt'])) {
            $this->loadBOM($value['ma_vt'], $key);
        }
    }

    public function tinhGiaTri(): void
    {
        // Lap rap: Gia master = SUM(Gia chi tiet)
        // Thao do: Gia chi tiet = Gia master / so luong
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE (PH + CT + CTD)
    }

    public function render(): View
    {
        return view('catalog::in.lap-rap-thao-do-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/in/
├── lap-rap-thao-do.blade.php           (List page)
├── lap-rap-thao-do-edit.blade.php      (Edit modal + 2 grid)
```

### 6. Routes

```php
Route::prefix('catalog/in')
    ->name('catalog.in.')
    ->group(function () {
        Route::get('/lap-rap-thao-do', [Laprapthaodo::class, 'render'])
            ->name('lap-rap-thao-do');
        Route::get('/lap-rap-thao-do/edit/{sttRec?}', [LaprapthaodoEdit::class, 'render'])
            ->name('lap-rap-thao-do.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | IN6.php | Header |
| Model | laravel-simba | IN6CT.php | Detail Master |
| Model | laravel-simba | IN6CTD.php | Detail Chi tiet |
| Model | laravel-simba | DMVT.php | Vat tu (FK) |
| Model | laravel-simba | DMBOM.php | BOM (Lookup) |
| SP | laravel-simba | AsINGetIN6.php | Get |
| SP | laravel-simba | AsINInsIN6.php | Insert |
| SP | laravel-simba | AsINUpdIN6.php | Update |
| SP | laravel-simba | AsINDelIN6.php | Delete |
| SP | laravel-simba | AsINChkIN6.php | Check trung |
| Component | laravel-catalog | Laprapthaodo.php | List |
| Component | laravel-catalog | LaprapthaodoEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model IN6, IN6CT, IN6CTD
- [ ] Tao Livewire LaprapthaodoEdit (modal + 2 grids)
- [ ] Tao Views (list + edit voi 2 grid)
- [ ] Them Routes
- [ ] Test lap rap (Load BOM)
- [ ] Test thao do (Phan bo gia)
- [ ] Test tinh gia tri tu dong
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
