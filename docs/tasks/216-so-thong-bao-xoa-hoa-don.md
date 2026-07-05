# Task 216: SO-Thong-Bao-Xoa-Hoa-Don

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang thong bao xoa hoa don tu .NET sang PHP Laravel, dat ket qua tuong duong SOND51xoahd.

## Chi tiet
- **DLL:** SOND51xoahd.dll
- **Chuc nang:** Thong bao xoa hoa don (Invoice Deletion Notice)
- **Loai:** Voucher (VCH)
- **Assembly Title:** SOMCHHD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** ND51

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51xoahd.dll/README.md`

---

## Cau truc du lieu

### Bang: nd51 (Thong bao xoa - Phan dau)

Giong nhu SOND51mchhd, bo sung them:

| Truong | Kieu | Mo ta |
|--------|------|-------|
| kieu_xl | varchar | Kieu xu ly (XOA) |

### Bang: nd51ct (Chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_chung | varchar | Ma chung tu (an) |
| ten_loai | nvarchar | Ten loai hoa don |
| mau_so | varchar | Mau so |
| ky_hieu | varchar | Ky hieu (so_seri) |
| tu_so | varchar | Tu so |
| den_so | varchar | Den so |
| so_luong | int | So luong |
| lien_hd | int | Lien hoa don |
| ghi_chu | nvarchar | Ghi chu |

---

## Form classes

### frmSOND51xoahd (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### frmSOND51xoahdEdit (Form nhap lieu)
- **Ke thua:** frmDMComplexEdit
- **Controls:** Giong nhu SOND51mchhd nhung co them `lblKieu_xl` hien thi "XOA"

---

## Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| SOND51mhd | Mau hoa don | FK ma_tb -> SOND51mhd.ma_tb |
| SOND51phhd | Phat hanh hoa don | FK ma_tb -> SOND51phhd.ma_tb |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_ND51XOA_GET | Lay danh sach thong bao xoa |
| SP_SO_ND51XOA_GETBYID | Lay chi tiet 1 thong bao |
| SP_SO_ND51XOA_INSERT | Them thong bao moi |
| SP_SO_ND51XOA_UPDATE | Cap nhat thong bao |
| SP_SO_ND51XOA_DELETE | Xoa thong bao |
| SP_SO_ND51XOA_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
EXEC SP_SO_ND51XOA_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20),
    @pMa_ct VARCHAR(10),
    @pNgay_tb DATETIME,
    @pMa_tb VARCHAR(20),
    @pNoi_nhan NVARCHAR(500),
    @pTen_tc NVARCHAR(200),
    @pDai_dien NVARCHAR(100),
    @pDia_chi NVARCHAR(500),
    @pMa_thue VARCHAR(20),
    @pGhi_chu NVARCHAR(500),
    @pKieu_xl VARCHAR(10),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Khac biet voi SOND51mchhd

| Dac diem | SOND51mchhd | SOND51xoahd |
|----------|-------------|-------------|
| Kieu xu ly | (trong) | XOA |
| Label kieu_xl | Khong co | "XOA" |
| Ly do | "Ly do mat, chay, hong" | "Ly do xoa" |
| Messages | 50153, 50154, 50155, 50156 | 50157, 50182, 50183, 50184 |

### Lookup Integration

- Tu SOND51mhd: Chon mau hoa don
- Tu SOND51phhd: Chon to bao cao phat hanh

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/ND51Xoahd.php
namespace Diepxuan\Simba\Models\SO;

class ND51Xoahd extends Model
{
    protected $table = 'nd51';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const MA_CT = 'ND51';
    const KIEU_XL_XOA = 'XOA';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_tb', 'ma_tb', 'noi_nhan',
        'ten_tc', 'dai_dien', 'dia_chi', 'ma_thue',
        'ghi_chu', 'gio_xl', 'phut_xl', 'ngay_xl',
        'gui_cqt', 'ngay_guicqt', 'kieu_xl',
    ];

    public function chiTiets()
    {
        return $this->hasMany(ND51XoahdCt::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoGetND51Xoahd.php
class SoGetND51Xoahd extends StoredProcedure
{
    protected $procedure = 'SP_SO_ND51XOA_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoInsND51Xoahd.php
// diepxuan/laravel-simba/src/StoredProcedures/SoUpdND51Xoahd.php
// diepxuan/laravel-simba/src/StoredProcedures/SoDelND51Xoahd.php
// diepxuan/laravel-simba/src/StoredProcedures/SoChkND51Xoahd.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Thongbaoxoahoadon.php
namespace Diepxuan\Catalog\Http\Livewire\SO;

class Thongbaoxoahoadon extends Component
{
    const MA_CT = 'ND51';

    public Collection $pThongBaos;
    public string $pSearch = '';

    public function mount(): void { $this->loadData(); }
    public function render(): View { return view('catalog::so.thongbaoxoahoadon'); }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/ThongbaoxoahoadonEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\ThongbaoxoahoadonEdit;

class ThongbaoxoahoadonEdit extends Component
{
    public string $pKieuXl = 'XOA';

    public function render(): View
    {
        return view('catalog::so.thongbaoxoahoadon-edit');
    }
}
```

### 3. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/thong-bao-xoa-hoa-don', [Thongbaoxoahoadon::class, 'render'])
            ->name('thongbaoxoahoadon');
        Route::get('/thong-bao-xoa-hoa-don/edit/{sttRec?}', [ThongbaoxoahoadonEdit::class, 'render'])
            ->name('thongbaoxoahoadon.edit');
    });
```

### 4. Views

```
resources/views/catalog/so/
├── thongbaoxoahoadon.blade.php        (List page)
├── thongbaoxoahoadon-edit.blade.php   (Edit form)
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ND51Xoahd.php | Chinh |
| Model | laravel-simba | ND51XoahdCt.php | Chi tiet |
| SP | laravel-simba | SoGetND51Xoahd.php | Get list |
| SP | laravel-simba | SoInsND51Xoahd.php | Insert |
| SP | laravel-simba | SoUpdND51Xoahd.php | Update |
| SP | laravel-simba | SoDelND51Xoahd.php | Delete |
| Component | laravel-catalog | Thongbaoxoahoadon.php | List |
| Component | laravel-catalog | ThongbaoxoahoadonEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model ND51Xoahd, ND51XoahdCt
- [ ] Tao Livewire components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `so.notice.xoahd`
- **Note:** Shell hoặc route hiện hữu; side-effect blocked nếu chưa audit payload.
