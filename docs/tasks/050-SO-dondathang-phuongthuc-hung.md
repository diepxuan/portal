# Task 050: SOND51phhd

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc phat hanh hoa don GTGT tu .NET/Crystal Reports sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SOND51phhd.dll
- **Chuc nang:** Quan ly danh muc phat hanh hoa don
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PH (Phat hanh hoa don)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51phhd.dll/README.md`

---

## Cau truc du lieu

### Bang: DMPHHĐ (Danh muc phat hanh hoa don)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_tb | varchar | 20 | Ma to bao cao (khoa chinh) |
| ma_cty | varchar | 50 | Ma cong ty |
| ngay_ph | datetime | 8 | Ngay phat hanh |
| so_hd | int | 4 | So hoa don |
| mau_so | varchar | 50 | Mau so hoa don |
| so_seri | varchar | 50 | So seri |
| tu_so | int | 4 | Tu so |
| den_so | int | 4 | Den so |
| so_luong | int | 4 | So luong hoa don |
| lien_hd | int | 2 | So lien hoa don |
| ma_hd | varchar | 20 | Ma hoa don |
| ten_hd | nvarchar | 200 | Ten loai hoa don |
| tinh_trang | varchar | 20 | Tinh trang |
| ghi_chu | nvarchar | 500 | Ghi chu |
| ksd | bit | 1 | Khoa su dung |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| SOND51mhd | Mau hoa don | FK ma_mhd -> SOND51mhd.ma_mhd |
| SOND51mathd | Ma hoa don | FK ma_tb -> SOND51mathd.ma_tb |

---

## Form classes

### 1. frmSOND51phhd (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach phat hanh, tim kiem, phan trang
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |
| btnPrint | Button | Nut in bao cao |

### 2. frmSOND51phhdEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin phat hanh hoa don
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_tb | AsTextBox | ma_tb | Ma to bao cao |
| txtNgay_ph | AsMaskedTextBox | ngay_ph | Ngay phat hanh |
| txtMa_hd | AsTextBox | ma_hd | Ma hoa don (lookup) |
| lblTen_hd | Label | ten_hd | Ten loai hoa don |
| txtMau_so | TextBox | mau_so | Mau so |
| txtSo_seri | TextBox | so_seri | So seri |
| txtTu_so | AsTextNumeric | tu_so | Tu so |
| txtDen_so | AsTextNumeric | den_so | Den so |
| txtSo_luong | AsTextNumeric | so_luong | So luong (auto) |
| txtLien_hd | AsTextNumeric | lien_hd | So lien |
| cboTinh_trang | ComboBox | tinh_trang | Tinh trang |
| txtGhi_chu | TextBox | ghi_chu | Ghi chu |
| btnSave | Button | - | Nut luu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_PHHĐ_GET | Lay danh sach phat hanh |
| SP_SO_PHHĐ_GETBYID | Lay chi tiet 1 phat hanh |
| SP_SO_PHHĐ_INSERT | Them phat hanh moi |
| SP_SO_PHHĐ_UPDATE | Cap nhat phat hanh |
| SP_SO_PHHĐ_DELETE | Xoa phat hanh |
| SP_SO_PHHĐ_FIND | Tim kiem |
| SP_SO_PHHĐ_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
EXEC SP_SO_PHHĐ_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_tb VARCHAR(20),
    @pNgay_ph DATETIME,
    @pMa_hd VARCHAR(20),
    @pMau_so VARCHAR(50),
    @pSo_seri VARCHAR(50),
    @pTu_so INT,
    @pDen_so INT,
    @pSo_luong INT = NULL,
    @pLien_hd INT,
    @pTinh_trang VARCHAR(20),
    @pGhi_chu NVARCHAR(500),
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_tb | 'Ma to bao cao khong duoc trong' |
| Required | ma_hd | 'Ma hoa don khong duoc trong' |
| Required | ngay_ph | 'Ngay phat hanh khong duoc trong' |
| Required | mau_so | 'Mau so khong duoc trong' |
| Required | so_seri | 'So seri khong duoc trong' |
| Numeric | tu_so | 'Tu so phai la so nguyen' |
| Numeric | den_so | 'Den so phai la so nguyen' |
| Range | tu_so <= den_so | 'Tu so phai nho hon hoac bang den so' |

### Business Rules

1. **Tu dong tinh so luong**:
   - So_luong = Den_so - Tu_so + 1
   - Tu dong cap nhat khi thay doi tu_so hoac den_so

2. **Tinh trang hoa don**:
   - "Da phat hanh": Da su dung
   - "Con lai": Chua su dung
   - "Huy": Da huy

3. **In bao cao**:
   - Crystal Reports integration
   - Truyen tham so: ma_tb, CompanyInformations

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMPHHD.php
namespace Diepxuan\Simba\Models\SO;

class DMPHHD extends Model
{
    protected $table = 'DMPHHD';
    protected $primaryKey = 'ma_tb';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_tb', 'ma_cty', 'ngay_ph', 'so_hd',
        'mau_so', 'so_seri', 'tu_so', 'den_so',
        'so_luong', 'lien_hd', 'ma_hd', 'ten_hd',
        'tinh_trang', 'ghi_chu', 'ksd',
    ];

    protected $casts = [
        'ngay_ph' => 'date',
        'tu_so' => 'integer',
        'den_so' => 'integer',
        'so_luong' => 'integer',
        'lien_hd' => 'integer',
        'ksd' => 'boolean',
    ];

    // Auto-calculate so_luong
    public function setTuSoAttribute($value): void
    {
        $this->attributes['tu_so'] = $value;
        $this->calculateSoLuong();
    }

    public function setDenSoAttribute($value): void
    {
        $this->attributes['den_so'] = $value;
        $this->calculateSoLuong();
    }

    protected function calculateSoLuong(): void
    {
        if ($this->tu_so && $this->den_so) {
            $this->attributes['so_luong'] = $this->den_so - $this->tu_so + 1;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Phathanhhoadon.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Phathanhhoadon extends Component
{
    const MA_CT = 'PH';

    public Collection $pPhatHanhs;
    public string $pSearch = '';

    public function mount(): void
    {
        $this->loadPhatHanh();
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.phathanhhoadon');
    }
}
```

### 3. Views

```
resources/views/catalog/so/danhmuc/
├── phathanhhoadon.blade.php
├── phathanhhoadon-edit.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/pha-t-hanh-hoa-don', [Phathanhhoadon::class, 'render'])
            ->name('phathanhhoadon');
        Route::get('/pha-t-hanh-hoa-don/edit/{maTb?}', [PhathanhhoadonEdit::class, 'render'])
            ->name('phathanhhoadon.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMPHHD.php | Chinh |
| Model | laravel-simba | DMMHD.php | Mau hoa don |
| SP | laravel-simba | SoGetDMPHHD.php | Get list |
| SP | laravel-simba | SoInsDMPHHD.php | Insert |
| Component | laravel-catalog | Phathanhhoadon.php | List |
| Component | laravel-catalog | PhathanhhoadonEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMPHHD
- [ ] Tao Livewire Phathanhhoadon
- [ ] Tao Livewire PhathanhhoadonEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Auto-calculate so_luong
- [ ] Test Integration voi DMMHD