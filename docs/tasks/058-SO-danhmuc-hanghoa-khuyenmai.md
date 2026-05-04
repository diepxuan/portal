# Task 058: SODMHHKM

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc hang hoa khuyen mai tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SODMHHKM.dll
- **Chuc nang:** Quan ly danh muc hang hoa khuyen mai
- **Loai:** Danh muc (DM)
- **Assembly Title:** SODMHHKM
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** HHKM (Hang hoa khuyen mai)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMHHKM.dll/README.md`

---

## Cau truc du lieu

### Bang: DMHHKM (Danh muc hang hoa khuyen mai)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_km | varchar | 20 | Ma khuyen mai (khoa chinh) |
| ten_km | nvarchar | 255 | Ten chuong trinh khuyen mai |
| ma_vt | varchar | 20 | Ma vat tu khuyen mai |
| so_luong | decimal | 18,2 | So luong khuyen mai |
| dieu_kien | nvarchar | 500 | Dieu kien ap dung |
| ngay_bd | datetime | 8 | Ngay bat dau |
| ngay_kt | datetime | 8 | Ngay ket thuc |
| loai_km | varchar | 10 | Loai hinh khuyen mai |
| gia_tri | decimal | 18,2 | Gia tri chiet khau |
| ksd | bit | 1 | Khoa su dung |

---

## Form classes

### 1. frmSODMHHKM (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Chuc nang:** Hien thi danh sach hang hoa KM
- **DataGridView Columns:**

| Column | Mo ta |
|--------|-------|
| dgvcMa_Km | Ma khuyen mai |
| dgvcTen_Km | Ten chuong trinh |
| dgvcMa_Vt | Ma vat tu |
| dgvcTen_Vt | Ten vat tu |
| dgvcSo_Luong | So luong KM |
| dgvcDieu_Kien | Dieu kien ap dung |

### 2. frmSODMHHKMEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Km | AsTextBox | ma_km | Ma khuyen mai |
| txtTen_Km | TextBox | ten_km | Ten chuong trinh |
| txtMa_Vt | AsTextBox | ma_vt | Ma vat tu (lookup) |
| lblTen_Vt | Label | ten_vt | Ten vat tu |
| txtSo_Luong | AsTextNumeric | so_luong | So luong KM |
| txtDieu_Kien | TextBox | dieu_kien | Dieu kien (mota) |
| txtNgay_Bd | AsMaskedTextBox | ngay_bd | Ngay bat dau |
| txtNgay_Kt | AsMaskedTextBox | ngay_kt | Ngay ket thuc |
| cboLoai_Km | ComboBox | loai_km | Loai hinh KM |
| txtGia_Tri | AsTextNumeric | gia_tri | Gia tri chiet khau |
| btnSave | Button | - | Nut luu |

---

## Loai hinh khuyen mai

| Loai | Mo ta |
|------|-------|
| TANG_HANG | Mua X tang Y |
| GIAM_GIA | Giam gia % hoac so tien |
| COMBO | Mua combo gia uu dai |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_HHKM_GET | Lay danh sach HHKM |
| SP_SO_HHKM_GETBYID | Lay chi tiet |
| SP_SO_HHKM_INSERT | Them moi |
| SP_SO_HHKM_UPDATE | Cap nhat |
| SP_SO_HHKM_DELETE | Xoa |
| SP_SO_HHKM_FIND | Tim kiem |
| SP_SO_HHKM_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_km | 'Ma khuyen mai khong duoc trong' |
| Required | ten_km | 'Ten khuyen mai khong duoc trong' |
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Numeric | so_luong | 'So luong phai la so' |
| Positive | so_luong | 'So luong phai > 0' |
| Date | ngay_bd | 'Ngay bat dau khong hop le' |
| Date | ngay_kt | 'Ngay ket thuc phai >= ngay bat dau' |

### Business Rules

1. **Tu dong dien thong tin VT**:
   - Sau khi chon ma_vt, tu dong hien thi ten_vt

2. **Kiem tra thoi gian**:
   - Ngay BD < Ngay KT
   - Khuyen mai con han khi ngay_hien_tai <= ngay_kt

3. **Gia tri khuyen mai**:
   - Theo % hoac theo so tien tuy loai_km

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMHHKM.php
namespace Diepxuan\Simba\Models\SO;

class DMHHKM extends Model
{
    protected $table = 'DMHHKM';
    protected $primaryKey = 'ma_km';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_km', 'ten_km', 'ma_vt', 'so_luong',
        'dieu_kien', 'ngay_bd', 'ngay_kt',
        'loai_km', 'gia_tri', 'ksd',
    ];

    protected $casts = [
        'so_luong' => 'decimal:2',
        'gia_tri' => 'decimal:2',
        'ngay_bd' => 'date',
        'ngay_kt' => 'date',
        'ksd' => 'boolean',
    ];

    // Relationships
    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeCurrent($query)
    {
        $today = now()->toDateString();
        return $query->where('ngay_bd', '<=', $today)
            ->where(function($q) use ($today) {
                $q->whereNull('ngay_kt')
                  ->orWhere('ngay_kt', '>=', $today);
            });
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Hanghoakhuyenmai.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Hanghoakhuyenmai extends Component
{
    const MA_CT = 'HHKM';

    public Collection $pHangHoas;
    public string $pSearch = '';

    public function render(): View
    {
        return view('catalog::so.danhmuc.hanghoakhuyenmai');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/HanghoakhuyenmaiEdit.php
class HanghoakhuyenmaiEdit extends Component
{
    public ?string $pMa_Km = null;
    public string $pTen_Km = '';
    public ?string $pMa_Vt = null;
    public string $pTen_Vt = '';
    public float $pSo_Luong = 0;
    public string $pDieu_Kien = '';
    public ?string $pNgay_Bd = null;
    public ?string $pNgay_Kt = null;
    public string $pLoai_Km = 'TANG_HANG';
    public float $pGia_Tri = 0;
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Km' => 'required|string|max:20',
        'pTen_Km' => 'required|string|max:255',
        'pMa_Vt' => 'required|string|max:20',
        'pSo_Luong' => 'required|numeric|min:0',
    ];

    public function updatedPMaVt($value): void
    {
        // Lookup ten vat tu
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.hanghoakhuyenmai-edit');
    }
}
```

### 3. Views & Routes

```
resources/views/catalog/so/danhmuc/
├── hanghoakhuyenmai.blade.php
├── hanghoakhuyenmai-edit.blade.php
```

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/hang-hoa-khuyen-mai', [Hanghoakhuyenmai::class, 'render'])->name('hanghoakhuyenmai');
        Route::get('/hang-hoa-khuyen-mai/edit/{maKm?}', [HanghoakhuyenmaiEdit::class, 'render'])->name('hanghoakhuyenmai.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMHHKM.php | Chinh |
| Model | laravel-simba | DMVT.php | Vat tu (lookup) |
| Component | laravel-catalog | Hanghoakhuyenmai.php | List |
| Component | laravel-catalog | HanghoakhuyenmaiEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMHHKM
- [ ] Tao Livewire Hanghoakhuyenmai
- [ ] Tao Livewire HanghoakhuyenmaiEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Lookup VT
- [ ] Test Integration voi DonHangBan