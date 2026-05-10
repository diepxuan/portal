# Task 074: POVchPO5

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang phieu thanh toan mua hang (PO5) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** POVchPO5.dll
- **Chuc nang:** Phieu tra lai hang mua
- **Loai:** Voucher (VCH)
- **Assembly Title:** Voucher tra lai hang mua
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PO5 (Tra lai hang mua)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/POVchPO5.dll/README.md`

---

## Cau truc du lieu

### Bang: POTL (Phieu tra lai mua)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (PK) |
| ma_ct | varchar | Ma chung tu (PO5) |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| so_seri | varchar | So seri |
| so_seri_mhd | varchar | So seri mua HD goc |
| ma_kh | varchar | Ma NCC |
| nguoi_gd | nvarchar | Nguoi giao dich |
| dia_chi | nvarchar | Dia chi |
| ma_so_thue | varchar | MST |
| dien_giai | nvarchar | Dien giai |
| ma_httt | varchar | Hinh thuc TT |
| ma_nt | varchar | Ma ngoai te |
| ty_gia | decimal | Ty gia |
| t_tien_nt | decimal | Tong tien NT |
| t_tien | decimal | Tong tien |
| t_thue_nt | decimal | Tong thue NT |
| t_thue | decimal | Tong thue |
| t_tt_nt | decimal | Tong thanh toan NT |
| t_tt | decimal | Tong thanh toan |
| t_so_luong | decimal | Tong so luong tra |
| tk_thue | varchar | TK thue |
| tk_pt | varchar | TK phai tra |
| gia_dd | bit | Gia da dinh |

---

## Form classes

### frmPOVchPO5 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Controls Header:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma NCC |
| lblTen_Kh | Label | Ten NCC |
| txtNguoi_Gd | TextBox | Nguoi giao dich |
| txtDia_chi | TextBox | Dia chi |
| txtMa_so_thue | TextBox | MST |
| txtSo_Seri | TextBox | So seri |
| txtSo_seri_mhd | TextBox | So seri HD goc |
| txtDien_giai | TextBox | Dien giai |
| cboMa_NT | ComboBox | Ma ngoai te |
| txtTy_gia | AsTextNumeric | Ty gia |
| cmdChon_Pn | Button | Chon phieu nhap |

- **Tab Pages:**

| Tab | Mo ta |
|-----|-------|
| Hach_toan | Hach toan ke toan |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_POTL_GET | Lay danh sach PO5 |
| SP_PO_POTL_GETBYID | Lay chi tiet |
| SP_PO_POTL_INSERT | Them chung tu |
| SP_PO_POTL_UPDATE | Cap nhat |
| SP_PO_POTL_DELETE | Xoa |
| SP_PO_POTL_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Nha cung cap khong duoc trong' |
| Valid so_luong | so_luong | 'So luong tra <= so luong mua' |

### Business Rules

1. **Chon tu phieu nhap/hd**:
   - Chon tu PO3 (Hoa don)
   - Chon tu PO4 (Phieu nhap)

2. **Giam tru cong no**:
   - Giam so no phai tra NCC
   - Giam thue GTGT

3. **Giam ton kho**:
   - Giam ton kho khi tra hang

### Lookup Integration

- Tu DMVT: Chon vat tu tra lai
- Tu POVchPO1: Lookup phieu nhap goc
- Tu DMKHO: Chon kho

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/POTL.php
namespace Diepxuan\Simba\Models\PO;

class POTL extends Model
{
    protected $table = 'POTL';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct',
        'so_seri', 'so_seri_mhd', 'ma_kh', 'nguoi_gd',
        'dia_chi', 'ma_so_thue', 'dien_giai',
        'ma_httt', 'ma_nt', 'ty_gia',
        't_tien_nt', 't_tien', 't_thue_nt', 't_thue',
        't_tt_nt', 't_tt', 't_so_luong',
        'tk_thue', 'tk_pt', 'gia_dd',
    ];

    public function chiTiets()
    {
        return $this->hasMany(POTLCT::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/Phieutrallah.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Voucher;

class Phieutrallah extends Component
{
    const MA_CT = 'PO5';

    public ?string $pStt_rec = null;
    public ?string $pMa_kh = null;
    public ?string $pSo_seri = null;
    public ?string $pSo_seri_mhd = null;
    public ?string $pMa_nt = 'VND';
    public float $pTy_gia = 1;
    public Collection $pChiTiets;

    public function render(): View
    {
        return view('catalog::po.voucher.phieutrallah');
    }
}
```

### 3. Views

```
resources/views/catalog/po/voucher/
├── phieutrallah.blade.php
└── _phieutrallah-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/voucher')
    ->name('catalog.po.voucher.')
    ->group(function () {
        Route::get('/phieu-tra-la', [Phieutrallah::class, 'render'])
            ->name('phieutrallah');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | POTL.php | Phieu tra lai |
| Model | laravel-simba | POTLCT.php | Chi tiet |
| Component | laravel-catalog | Phieutrallah.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Models POTL, POTLCT
- [ ] Tao Livewire Phieutrallah
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test Integration PO3/PO4
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
