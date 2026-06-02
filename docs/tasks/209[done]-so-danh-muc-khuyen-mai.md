# Task 209: SO-Danh-Muc-Khuyen-Mai

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc khuyen mai tu .NET sang PHP Laravel, dat ket qua tuong duong SODMKM.

## Chi tiet
- **DLL:** SODMKM.dll
- **Chuc nang:** Danh muc khuyen mai (Promotion Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMKM.dll/README.md`

---

## Cau truc du lieu

### Bang: dmkm (Danh muc khuyen mai)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_ct | varchar | 20 | Ma chuong trinh KM (khoa chinh) |
| ten_ct | nvarchar | 255 | Ten chuong trinh |
| ngay_bd | date | 8 | Ngay bat dau |
| ngay_kt | date | 8 | Ngay ket thuc |
| loai_km | varchar | 10 | Loai khuyen mai |
| gia_tri | decimal | 18,2 | Gia tri KM |
| dieu_kien | nvarchar | 500 | Dieu kien ap dung |
| hoat_dong | bit | 1 | Trang thai hoat dong |
| ma_nh_kh | varchar | 20 | Nhom KH ap dung |
| gia_tri_min | decimal | 18,2 | Gia tri don hang toi thieu |

### Bang: dmkmct (Chi tiet khuyen mai - VT ap dung)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_ct | varchar | Ma chuong trinh KM (FK) |
| ma_vt | varchar | Ma vat tu ap dung |
| tl_km | decimal | Ty le KM (%) |
| gia_tri_km | decimal | Gia tri KM cu the |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMNHKH | Nhom khach hang | FK ma_nh_kh -> DMNHKH |

---

## Form classes

### 1. frmSODMKM (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvcMa_Ct | DataGridViewColumn | Ma chuong trinh |
| dgvcTen_Ct | DataGridViewColumn | Ten chuong trinh |
| dgvcNgay_Bd | DataGridViewColumn | Ngay bat dau |
| dgvcNgay_Kt | DataGridViewColumn | Ngay ket thuc |
| dgvcTrang_Thai | DataGridViewColumn | Trang thai |
| dgvcLoai_Km | DataGridViewColumn | Loai KM |

### 2. frmSODMKMEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Ct | AsTextBox | ma_ct | Ma chuong trinh |
| txtTen_Ct | TextBox | ten_ct | Ten chuong trinh |
| txtNgay_Bd | AsMaskedTextBox | ngay_bd | Ngay bat dau |
| txtNgay_Kt | AsMaskedTextBox | ngay_kt | Ngay ket thuc |
| cboLoai_Km | ComboBox | loai_km | Loai khuyen mai |
| txtGia_Tri | AsTextNumeric | gia_tri | Gia tri KM |
| txtDieu_Kien | TextBox | dieu_kien | Dieu kien ap dung |
| chkHoat_Dong | AsCheckBox | hoat_dong | Trang thai |
| txtMa_Nh_Kh | AsTextBox | ma_nh_kh | Nhom KH ap dung |
| txtGia_Tri_Min | AsTextNumeric | gia_tri_min | Gia tri don hang min |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMKM_GET | Lay danh sach |
| SP_SO_DMKM_GETBYID | Lay chi tiet |
| SP_SO_DMKM_INSERT | Them moi |
| SP_SO_DMKM_UPDATE | Cap nhat |
| SP_SO_DMKM_DELETE | Xoa |
| SP_SO_DMKM_FIND | Tim kiem |
| SP_SO_DMKM_CHECK | Kiem tra trung |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMKM_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_ct VARCHAR(20),
    @pTen_ct NVARCHAR(255),
    @pNgay_bd DATE,
    @pNgay_kt DATE,
    @pLoai_km VARCHAR(10),
    @pGia_tri DECIMAL(18,2),
    @pDieu_kien NVARCHAR(500),
    @pHoat_dong BIT,
    @pMa_nh_kh VARCHAR(20),
    @pGia_tri_min DECIMAL(18,2),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Cac loai khuyen mai

| Ma | Ten | Mo ta |
|----|-----|-------|
| CK | Chiet khau | Chiet khau % tren don hang |
| TIEN | Giam tien | Giam so tien co dinh |
| TANG | Tang hang | Tang san pham |
| FREE_SHIP | Mien phi VC | Mien phi van chuyen |
| COMBO | Combo | Gia combo uu dai |

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ct | 'Ma chuong trinh khong duoc trong' |
| Unique | ma_ct | 'Ma da ton tai' |
| Required | ten_ct | 'Ten chuong trinh khong duoc trong' |
| Date range | ngay_bd, ngay_kt | 'Ngay BD < Ngay KT' |
| Positive | gia_tri | 'Gia tri phai lon hon 0' |

### Business Rules

1. **Dieu kien ap dung**:
   - Theo gia tri don hang toi thieu
   - Theo nhom khach hang
   - Theo thoi gian (ngay_bd - ngay_kt)

2. **Tinh khuyen mai**:
   - CK: Giam = Tong_tien * gia_tri / 100
   - TIEN: Giam = gia_tri (co dinh)
   - TANG: Tang them san pham
   - FREE_SHIP: Mien phi van chuyen

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMkm.php
namespace Diepxuan\Simba\Models\SO;

class DMkm extends Model
{
    protected $table = 'dmkm';
    protected $primaryKey = 'ma_ct';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const LOAI_CK = 'CK';
    const LOAI_TIEN = 'TIEN';
    const LOAI_TANG = 'TANG';
    const LOAI_FREE_SHIP = 'FREE_SHIP';
    const LOAI_COMBO = 'COMBO';

    protected $fillable = [
        'ma_ct', 'ten_ct', 'ngay_bd', 'ngay_kt',
        'loai_km', 'gia_tri', 'dieu_kien',
        'hoat_dong', 'ma_nh_kh', 'gia_tri_min',
    ];

    protected $casts = [
        'ngay_bd' => 'date',
        'ngay_kt' => 'date',
        'gia_tri' => 'decimal:2',
        'hoat_dong' => 'boolean',
    ];

    public function chiTiets()
    {
        return $this->hasMany(DMkmct::class, 'ma_ct', 'ma_ct');
    }

    public function nhomKhachHang()
    {
        return $this->belongsTo(DMNHKH::class, 'ma_nh_kh', 'ma_nhkh');
    }

    public function scopeActive($query)
    {
        return $query->where('hoat_dong', true)
            ->where('ngay_bd', '<=', now())
            ->where('ngay_kt', '>=', now());
    }

    public function scopeApDung($query, float $tongTien, ?string $maNhKh = null)
    {
        return $query->where('hoat_dong', true)
            ->where('ngay_bd', '<=', now())
            ->where('ngay_kt', '>=', now())
            ->where(function($q) use ($tongTien) {
                $q->whereNull('gia_tri_min')
                  ->orWhere('gia_tri_min', '<=', $tongTien);
            });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetDMkm.php
class AsSOGetDMkm extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMKM_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsDMkm.php
class AsSOInsDMkm extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMKM_INSERT';
    protected $params = [
        'pMa_cty', 'pMa_ct', 'pTen_ct', 'pNgay_bd', 'pNgay_kt',
        'pLoai_km', 'pGia_tri', 'pDieu_kien', 'pHoat_dong',
        'pMa_nh_kh', 'pGia_tri_min',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdDMkm.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelDMkm.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Khuyenmai.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Khuyenmai;

class Khuyenmai extends Component
{
    public Collection $pList;
    public string $pSearch = '';

    public function mount(): void
    {
        $this->loadList();
    }

    public function render(): View
    {
        return view('catalog::so.khuyenmai');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/KhuyenmaiEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\KhuyenmaiEdit;

class KhuyenmaiEdit extends Component
{
    public ?string $pMaCt = null;
    public string $pTenCt = '';
    public ?string $pNgayBd = null;
    public ?string $pNgayKt = null;
    public string $pLoaiKm = 'CK';
    public float $pGiaTri = 0;
    public string $pDieuKien = '';
    public bool $pHoatDong = true;
    public ?string $pMaNhKh = null;
    public float $pGiaTriMin = 0;

    protected $rules = [
        'pMaCt' => 'required|string|max:20',
        'pTenCt' => 'required|string|max:255',
        'pNgayBd' => 'required|date',
        'pNgayKt' => 'required|date|after_or_equal:pNgayBd',
    ];

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.khuyenmai-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── khuyenmai/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/khuyen-mai', [Khuyenmai::class, 'render'])
            ->name('khuyenmai');
        Route::get('/khuyen-mai/edit/{maCt?}', [KhuyenmaiEdit::class, 'render'])
            ->name('khuyenmai.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMkm.php | Chinh |
| Model | laravel-simba | DMkmct.php | Chi tiet VT |
| SP | laravel-simba | AsSOGetDMkm.php | Get list |
| SP | laravel-simba | AsSOInsDMkm.php | Insert |
| Component | laravel-catalog | Khuyenmai.php | List |
| Component | laravel-catalog | KhuyenmaiEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMkm
- [ ] Tao Livewire Khuyenmai (list)
- [ ] Tao Livewire KhuyenmaiEdit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test tinh khuyen mai theo loai
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `so.dict.km`
- **Note:** Voucher/report/dictionary route shell; write execute chỉ mở khi payload audit đủ.
