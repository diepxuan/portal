# Task 226: INVchIN2

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang phieu xuat kho tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INVchIN2.dll
- **Chuc nang:** Phieu xuat kho
- **Loai:** Chung tu (Voucher)
- **Assembly Title:** Phieu xuat kho
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN2 (Phieu xuat kho)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INVchIN2.dll/README.md`

---

## Cau truc du lieu

### Bang: INPHIEUX (Phieu xuat kho - Header)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| ma_kh | varchar | 50 | Ma khach hang |
| ten_kh | nvarchar | 200 | Ten khach hang |
| dia_chi | nvarchar | 500 | Dia chi |
| nguoi_gd | nvarchar | 200 | Nguoi giao dich |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,6 | Ty gia |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| tien | decimal | 18,2 | Tien VND |
| ma_gd | varchar | 50 | Ma giao dich/loai phieu |
| so_ct_goc | varchar | 50 | So chung tu goc |
| stt_rec | varchar | 50 | STT record |

### Bang: INCTX (Chi tiet xuat kho)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | STT header |
| stt_rec0 | varchar | 50 | STT detail |
| ma_vt | varchar | 50 | Ma vat tu |
| ten_vt | nvarchar | 200 | Ten vat tu |
| dvt | varchar | 20 | Don vi tinh |
| ma_kho | varchar | 50 | Ma kho xuat |
| so_luong | decimal | 18,6 | So luong xuat |
| gia_nt | decimal | 18,6 | Gia ngoai te |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| gia | decimal | 18,2 | Gia VND |
| tien | decimal | 18,2 | Tien VND |
| tk_no | varchar | 20 | TK noi |
| tk_vt | varchar | 20 | TK co (vat tu) |
| ma_bp | varchar | 50 | Ma bo phan |
| ma_spct | varchar | 50 | Ma san pham chi tiet |
| ma_phi | varchar | 50 | Ma phi |
| ma_hd | varchar | 50 | Ma hop dong |
| ma_lo | varchar | 50 | Ma lo |
| gia_dich_danh | bit | 1 | Xuat gia dich danh (FIFO/LIFO) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_vt |
| DMKHO | Danh muc kho | FK ma_kho |
| DMKH | Danh muc khach hang | FK ma_kh |

---

## Form classes

### 1. frmInVchIN2 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap phieu xuat kho
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_Ct | TextBox | so_ct | So chung tu |
| txtNgay_Ct | DateTimePicker | ngay_ct | Ngay chung tu |
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang |
| txtTen_Kh | TextBox | ten_kh | Ten khach hang |
| txtDia_Chi | TextBox | dia_chi | Dia chi |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi giao dich |
| txtDien_Giai | TextBox | dien_giai | Dien giai |
| cboMa_Nt | ComboBox | ma_nt | Ma ngoai te |
| txtTy_Gia | NumericTextBox | ty_gia | Ty gia |
| txtTien_Nt | NumericTextBox | tien_nt | Tien ngoai te |
| txtTien | NumericTextBox | tien | Tien VND |
| dgvDetails | DataGridView | - | Luoi chi tiet |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

### 2. frmInVchIN2Find (Form tim kiem)
- **Ke thua:** frmVoucherFind
- **Chuc nang:** Tim kiem phieu xuat kho
- **Controls:** Loc theo kho, vat tu, khach hang, TK, hop dong, SPCT, phi, bo phan, lo

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_VCHIN2_GET | Lay danh sach phieu xuat kho |
| SP_IN_VCHIN2_GETBYID | Lay chi tiet 1 phieu |
| SP_IN_VCHIN2_INSERT | Them phieu xuat kho |
| SP_IN_VCHIN2_UPDATE | Cap nhat phieu xuat kho |
| SP_IN_VCHIN2_DELETE | Xoa phieu xuat kho |
| SP_IN_VCHIN2_FIND | Tim kiem phieu xuat kho |
| SP_IN_VCHIN2_CHECK | Kiem tra trung so ct |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | so_ct | 'So chung tu khong duoc trong' |
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Numeric > 0 | ty_gia | 'Ty gia phai lon hon 0' |

### Business Rules

1. **Tinh toan tu dong**:
   - Tien_nt = sum(so_luong * gia_nt) cho tung dong
   - Tien = Tien_nt * ty_gia
   - Tien VND = Tien_nt * ty_gia

2. **Kiem tra ton kho**:
   - Truoc khi luu, kiem tra so luong ton kho
   - Khong cho xuat vuot ton kho

3. **Gia dich danh (FIFO/LIFO)**:
   - Khi gia_dich_danh = 1, xuat theo gia cu the
   - Theo doi lo hang xuat

4. **Xoa phieu**:
   - Kiem tra trang thai phieu da hach toan chua
   - Cap nhat lai ton kho neu da xuat

---

## Mapping PHP

### 1. Models

```php
// app/Models/IN/INPHIEUX.php
namespace Diepxuan\Simba\Models\IN;

class INPHIEUX extends Model
{
    protected $table = 'INPHIEUX';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh', 'dia_chi',
        'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia', 'tien_nt', 'tien',
        'ma_gd', 'so_ct_goc', 'stt_rec',
    ];

    public function chiTiets()
    {
        return $this->hasMany(INCTX::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetPhieuXuat.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetPhieuXuat extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN2_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsPhieuXuat.php
class AsINInsPhieuXuat extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN2_INSERT';
    protected $params = [
        'pMa_cty', 'stt_rec', 'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh',
        'dia_chi', 'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia',
        'tien_nt', 'tien', 'ma_gd', 'so_ct_goc',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdPhieuXuat.php
class AsINUpdPhieuXuat extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN2_UPDATE';
    protected $params = [
        'pMa_cty', 'stt_rec', 'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh',
        'dia_chi', 'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia',
        'tien_nt', 'tien', 'ma_gd', 'so_ct_goc',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelPhieuXuat.php
class AsINDelPhieuXuat extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN2_DELETE';
    protected $params = ['pMa_cty', 'stt_rec'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChkPhieuXuat.php
class AsINChkPhieuXuat extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN2_CHECK';
    protected $params = ['pMa_cty', 'so_ct'];
}
```

### 3. Models

```php
// app/Models/IN/INPHIEUX.php
namespace Diepxuan\Simba\Models\IN;

class INPHIEUX extends Model
{
    protected $table = 'INPHIEUX';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh', 'dia_chi',
        'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia', 'tien_nt', 'tien',
        'ma_gd', 'so_ct_goc', 'stt_rec',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:6',
        'tien_nt' => 'decimal:2',
        'tien' => 'decimal:2',
    ];

    public function chiTiets()
    {
        return $this->hasMany(INCTX::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
}

// app/Models/IN/INCTX.php
class INCTX extends Model
{
    protected $table = 'INCTX';
    protected $primaryKey = 'stt_rec0';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'stt_rec0', 'ma_vt', 'ten_vt', 'dvt', 'ma_kho',
        'so_luong', 'gia_nt', 'tien_nt', 'gia', 'tien',
        'tk_no', 'tk_vt', 'ma_bp', 'ma_spct', 'ma_phi', 'ma_hd', 'ma_lo',
        'gia_dich_danh',
    ];

    protected $casts = [
        'so_luong' => 'decimal:6',
        'gia_nt' => 'decimal:6',
        'tien_nt' => 'decimal:2',
        'gia' => 'decimal:2',
        'tien' => 'decimal:2',
        'gia_dich_danh' => 'boolean',
    ];

    public function phieu()
    {
        return $this->belongsTo(INPHIEUX::class, 'stt_rec', 'stt_rec');
    }

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function kho()
    {
        return $this->belongsTo(DMKHO::class, 'ma_kho', 'ma_kho');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Chungtu/PhieuxuatEdit.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Chungtu;

class PhieuxuatEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pSoCt = '';
    public ?Carbon $pNgayCt = null;
    public ?string $pMaKh = null;
    public string $pTenKh = '';
    public string $pDiaChi = '';
    public string $pNguoiGd = '';
    public string $pDienGiai = '';
    public ?string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public float $pTienNt = 0;
    public float $pTien = 0;
    public ?string $pMaGd = null;
    public string $pSoCtGoc = '';
    public Collection $pChiTiets;
    public ?string $pMode = 'create';

    protected $rules = [
        'pSoCt' => 'required|string|max:50',
        'pNgayCt' => 'required|date',
        'pMaKh' => 'required|string|max:50',
        'pChiTiets' => 'required|min:1',
    ];

    public function mount(?string $sttRec = null): void
    {
        $this->pNgayCt = now();
        $this->pChiTiets = collect([]);
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadPhieu();
        }
    }

    public function updatedPMaKh($value): void
    {
        // Auto-fill ten_kh, dia_chi, nguoi_gd
    }

    public function tinhTien(): void
    {
        $this->pTienNt = $this->pChiTiets->sum('tien_nt');
        $this->pTien = $this->pTienNt * $this->pTyGia;
    }

    public function checkTonKho(): bool
    {
        // Kiem tra ton kho truoc khi luu
        return true;
    }

    public function submit(): void
    {
        $this->validate();
        if (!$this->checkTonKho()) {
            session()->flash('error', 'So luong vuot ton kho');
            return;
        }
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::in.chungtu.phieu-xuat-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/in/chungtu/
├── phieu-xuat.blade.php              (List page)
├── phieu-xuat-edit.blade.php         (Edit modal + detail grid)
├── phieu-xuat-find.blade.php         (Search form)
└── _phieu-xuat-row.blade.php         (Component row)
```

### 6. Routes

```php
Route::prefix('catalog/in/chungtu')
    ->name('catalog.in.chungtu.')
    ->group(function () {
        Route::get('/phieu-xuat', [Phieuxuat::class, 'render'])
            ->name('phieu-xuat');
        Route::get('/phieu-xuat/edit/{sttRec?}', [PhieuxuatEdit::class, 'render'])
            ->name('phieu-xuat.edit');
        Route::get('/phieu-xuat/search', [PhieuxuatFind::class, 'render'])
            ->name('phieu-xuat.search');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | INPHIEUX.php | Header |
| Model | laravel-simba | INCTX.php | Detail |
| Model | laravel-simba | DMVT.php | Vat tu (FK) |
| Model | laravel-simba | DMKHO.php | Kho (FK) |
| Model | laravel-simba | DMKH.php | Khach hang (FK) |
| SP | laravel-simba | AsINGetPhieuXuat.php | Get |
| SP | laravel-simba | AsINInsPhieuXuat.php | Insert |
| SP | laravel-simba | AsINUpdPhieuXuat.php | Update |
| SP | laravel-simba | AsINDelPhieuXuat.php | Delete |
| SP | laravel-simba | AsINChkPhieuXuat.php | Check trung |
| Component | laravel-catalog | Phieuxuat.php | List |
| Component | laravel-catalog | PhieuxuatEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Models INPHIEUX, INCTX
- [ ] Tao Livewire Phieuxuat (list)
- [ ] Tao Livewire PhieuxuatEdit (form nhap lieu + detail grid)
- [ ] Tao Livewire PhieuxuatFind (search)
- [ ] Tao Views (list + edit + search)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Inventory check & gia dich danh
- [ ] Test tinh tien tu dong (NT * TyGia)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `in.vch.in2`
- **Note:** Shell/voucher; write blocked until payload audit.
