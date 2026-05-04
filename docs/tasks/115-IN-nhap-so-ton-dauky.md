# Task 115: INCDVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang nhap so ton dau ky tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INCDVT.dll
- **Chuc nang:** Nhap so ton kho dau ky
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Nhap so ton kho dau ky
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** IN (opening balance)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INCDVT.dll/README.md`

---

## Cau truc du lieu

### Bang: INCDVT (So ton dau ky vat tu)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| nam | int | Nam tai chinh |
| ma_vt | varchar | Ma vat tu |
| tk_vt | varchar | TK vat tu |
| ma_kho | varchar | Ma kho |
| ma_lo | varchar | Ma lo |
| ma_nt | varchar | Ma ngoai te |
| so_luong | decimal | So luong |
| tien_nt | decimal | Tien ngoai te |
| tien | decimal | Tien VND |

---

## Form classes

### 1. frmINCDVT (Form xem danh sach)
- **Ke thua:** frmOBView
- **Controls:** btn_SDTK (chuyen so du sang tai khoan), dgvDM, cmdAdd, cmdEdit, cmdDel, cmdClose

### 2. frmINCDVTEdit (Form nhap lieu)
- **Ke thua:** frmOBEdit
- **Controls:** txtYear (nam, readonly), txtMa_vt, txtTk_vt, txtMa_kho, txtMa_lo, cboMa_Nt, txtSo_luong, txtTien_nt, txtTien_vnd, chkKsd

### 3. frmINCDVTFilter (Form loc)
- **Ke thua:** frmOBFilter
- **Controls:** txtYear (nam, readonly), txtMa_kho, txtMa_vt, txtMa_tkvt

---

## Business Logic

### Business Rules

1. **Khong sua/xoa**: Voi vat tu co gia_ton = "2" (tinh gia NTXT)
2. **Chuyen so du**: btn_SDTK chuyen ton kho sang tai khoan GL
3. **Tien VND**: Tinh tu tien_nt * ty_gia hoac nhap truc tiep

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/INCDVT.php
namespace Diepxuan\Simba\Models\IN;

class INCDVT extends Model
{
    protected $table = 'INCDVT';
    protected $primaryKey = ['nam', 'ma_vt', 'ma_kho', 'ma_lo'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'nam', 'ma_vt', 'tk_vt', 'ma_kho', 'ma_lo',
        'ma_nt', 'so_luong', 'tien_nt', 'tien',
    ];

    protected $casts = [
        'nam' => 'integer',
        'so_luong' => 'decimal:8',
        'tien_nt' => 'decimal:8',
        'tien' => 'decimal:8',
    ];
}
```

### 2. Routes

```php
Route::prefix('catalog/in')
    ->name('catalog.in.')
    ->group(function () {
        Route::get('/ton-dau-ky', [Tondauky::class, 'render'])->name('ton-dau-ky');
        Route::post('/ton-dau-ky/chuyen-so-du', [Tondauky::class, 'chuyenSoDu'])->name('ton-dau-ky.chuyen-so-du');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model INCDVT
- [ ] Tao Livewire Tondauky va TondaukyEdit
- [ ] Tao View ton-dau-ky.blade.php
- [ ] Tao View ton-dau-ky-edit.blade.php
- [ ] Them Routes
- [ ] Test chuc nang chuyen so du (btn_SDTK)
- [ ] Test kiem tra gia_ton=2 khong cho sua/xoa