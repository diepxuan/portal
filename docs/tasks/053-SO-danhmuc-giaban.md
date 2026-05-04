# Task 053: SODMGIABAN

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc gia ban tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SODMGIABAN.dll
- **Chuc nang:** Quan ly danh muc gia ban
- **Loai:** Danh muc (DM)
- **Assembly Title:** SODMGIABAN
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GB (Gia ban)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMGIABAN.dll/README.md`

---

## Cau truc du lieu

### Bang: DMGIABAN (Danh muc gia ban)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_vt | varchar | 20 | Ma vat tu (khoa chinh) |
| ma_kh | varchar | 20 | Ma khach hang (NULL = gia chung) |
| ma_nh_kh | varchar | 20 | Nhom khach hang (NULL) |
| ngay_ap | datetime | 8 | Ngay ap dung |
| ngay_hh | datetime | 8 | Ngay het han |
| gia_nt2 | decimal | 18,2 | Gia ban ngoai te |
| gia2 | decimal | 18,2 | Gia ban VND |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |

---

## Form classes

### 1. frmSODMGIABAN (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Chuc nang:** Hien thi danh sach gia ban
- **DataGridView Columns:**

| Column | Mo ta |
|--------|-------|
| dgvcMa_Vt | Ma vat tu |
| dgvcTen_Vt | Ten vat tu |
| dgvcMa_Kh | Ma khach hang |
| dgvcTen_Kh | Ten khach hang |
| dgvcGia_Nt2 | Gia ngoai te |
| dgvcGia2 | Gia VND |
| dgvcMa_Nt | Ma ngoai te |
| dgvcNgay_Ap | Ngay ap dung |

### 2. frmSODMGIABANEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Vt | AsTextBox | ma_vt | Ma vat tu (lookup) |
| lblTen_Vt | Label | ten_vt | Ten vat tu |
| txtMa_Kh | AsTextBox | ma_kh | Ma KH (lookup, optional) |
| lblTen_Kh | Label | ten_kh | Ten khach hang |
| txtGia_Nt2 | AsTextNumeric | gia_nt2 | Gia ngoai te |
| txtGia2 | AsTextNumeric | gia2 | Gia VND |
| cboMa_Nt | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtNgay_Ap | AsMaskedTextBox | ngay_ap | Ngay ap dung |
| txtNgay_Hh | AsMaskedTextBox | ngay_hh | Ngay het han |

---

## Loai gia ban

| Loai | Mo ta | ma_kh | ma_nh_kh |
|------|-------|-------|----------|
| Gia chung | Gia cho tat ca KH | NULL | NULL |
| Gia rieng | Gia cho 1 KH cu the | Not NULL | NULL |
| Gia nhom | Gia cho nhom KH | NULL | Not NULL |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_GIABAN_GET | Lay danh sach gia ban |
| SP_SO_GIABAN_GETBYID | Lay chi tiet |
| SP_SO_GIABAN_INSERT | Them gia ban |
| SP_SO_GIABAN_UPDATE | Cap nhat gia ban |
| SP_SO_GIABAN_DELETE | Xoa gia ban |
| SP_SO_GIABAN_FIND | Tim kiem |
| SP_SO_GIABAN_CHECK | Kiem tra trung ma |
| SP_SO_GIABAN_GETPRICE | Lay gia ban (thong ke lookup) |

---

## Business Logic

### Tinh toan gia

```php
// Quy doi gia theo ty gia
Gia2 = Gia_Nt2 * Ty_Gia
```

### Uu tien lay gia

1. Gia rieng cua KH + VT
2. Gia theo nhom KH + VT
3. Gia chung cua VT
4. Gia tu bang gia mac dinh

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Required | ngay_ap | 'Ngay ap dung khong duoc trong' |
| Numeric | gia_nt2 | 'Gia phai la so' |
| Numeric | gia2 | 'Gia VND phai la so' |
| Positive | gia_nt2 | 'Gia phai > 0' |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMGIABAN.php
namespace Diepxuan\Simba\Models\SO;

class DMGIABAN extends Model
{
    protected $table = 'DMGIABAN';
    protected $primaryKey = ['ma_vt', 'ma_kh', 'ngay_ap'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_vt', 'ma_kh', 'ma_nh_kh',
        'ngay_ap', 'ngay_hh',
        'gia_nt2', 'gia2', 'ma_nt', 'ty_gia',
    ];

    protected $casts = [
        'ngay_ap' => 'date',
        'ngay_hh' => 'date',
        'gia_nt2' => 'decimal:2',
        'gia2' => 'decimal:2',
        'ty_gia' => 'decimal:4',
    ];

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function scopeEffective($query)
    {
        $today = now()->toDateString();
        return $query->where('ngay_ap', '<=', $today)
            ->where(function($q) use ($today) {
                $q->whereNull('ngay_hh')
                  ->orWhere('ngay_hh', '>=', $today);
            });
    }

    public function scopeGeneral($query)
    {
        return $query->whereNull('ma_kh')->whereNull('ma_nh_kh');
    }
}
```

### 2. Price Service

```php
// diepxuan/laravel-catalog/src/Services/SalesPriceService.php
namespace Diepxuan\Catalog\Services;

class SalesPriceService
{
    public function getPrice(
        string $maVt,
        ?string $maKh = null,
        ?string $maNt = 'VND',
        ?string $ngayAp = null
    ): ?array {
        // 1. Tim gia rieng KH
        // 2. Tim gia theo nhom KH
        // 3. Tim gia chung
        // Tra ve gia_nt2, gia2, ma_nt, ty_gia
    }
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Giaban.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Giaban extends Component
{
    const MA_CT = 'GB';

    public Collection $pGiaBans;
    public string $pSearch = '';

    public function render(): View
    {
        return view('catalog::so.danhmuc.giaban');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/GiabanEdit.php
class GiabanEdit extends Component
{
    public ?string $pMa_Vt = null;
    public ?string $pMa_Kh = null;
    public ?string $pNgay_Ap = null;
    public float $pGia_Nt2 = 0;
    public float $pGia2 = 0;
    public string $pMa_Nt = 'VND';
    public float $pTy_Gia = 1;

    protected $rules = [
        'pMa_Vt' => 'required|string|max:20',
        'pNgay_Ap' => 'required|date',
        'pGia_Nt2' => 'required|numeric|min:0',
    ];

    public function updatedPGiaNt2($value): void
    {
        $this->pGia2 = $value * $this->pTy_Gia;
    }

    public function updatedPTyGia($value): void
    {
        $this->pGia2 = $this->pGia_Nt2 * $value;
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.giaban-edit');
    }
}
```

### 4. Views & Routes

```
resources/views/catalog/so/danhmuc/
├── giaban.blade.php
├── giaban-edit.blade.php
```

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/gia-ban', [Giaban::class, 'render'])->name('giaban');
        Route::get('/gia-ban/edit', [GiabanEdit::class, 'render'])->name('giaban.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMGIABAN.php | Chinh |
| Model | laravel-simba | DMVT.php | Vat tu (lookup) |
| Model | laravel-simba | DMKH.php | Khach hang (lookup) |
| Service | laravel-catalog | SalesPriceService.php | Lay gia |
| Component | laravel-catalog | Giaban.php | List |
| Component | laravel-catalog | GiabanEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMGIABAN
- [ ] Tao SalesPriceService
- [ ] Tao Livewire Giaban
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Priority logic
- [ ] Test Integration voi DMVT