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

## Business Logic

### Khac biet voi SOND51mchhd

| Dac diem | SOND51mchhd | SOND51xoahd |
|----------|-------------|-------------|
| Kieu xu ly | (trong) | XOA |
| Label kieu_xl | Khong co | "XOA" |
| Ly do | "Ly do mat, chay, hong" | "Ly do xoa" |
| Messages | 50153, 50154, 50155, 50156 | 50157, 50182, 50183, 50184 |

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

### 2. Livewire Component

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

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ND51Xoahd.php | Chinh |
| Model | laravel-simba | ND51XoahdCt.php | Chi tiet |
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