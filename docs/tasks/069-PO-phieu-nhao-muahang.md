# Task 069: POVchPO3

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang hoa don mua hang (PO3) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** POVchPO3.dll
- **Chuc nang:** Hoa don mua hang
- **Loai:** Voucher (VCH)
- **Assembly Title:** Voucher hoa don mua hang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PO3 (Hoa don mua)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/POVchPO3.dll/README.md`

---

## Cau truc du lieu

### Bang: POHMN (Hoa don mua hang)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (PK) |
| ma_ct | varchar | Ma chung tu (PO3) |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| so_hd | varchar | So hoa don |
| ngay_hd | datetime | Ngay hoa don |
| ma_kh | varchar | Ma NCC |
| nguoi_gd | nvarchar | Nguoi giao dich |
| dia_chi | nvarchar | Dia chi |
| ma_so_thue | varchar | MST |
| dien_giai | nvarchar | Dien giai |
| ma_httt | varchar | Hinh thuc TT |
| ma_nt | varchar | Ma ngoai te |
| ty_gia | decimal | Ty gia |
| t_tien_nt0 | decimal | Tong tien NT |
| t_tien0 | decimal | Tong tien |
| t_cp_nt | decimal | Tong chi phi NT |
| t_cp | decimal | Tong chi phi |
| t_thue_nt | decimal | Tong thue NT |
| t_thue | decimal | Tong thue |
| t_ck_nt | decimal | Tong chiet khau NT |
| t_ck | decimal | Tong chiet khau |
| t_tt_nt | decimal | Tong thanh toan NT |
| t_tt | decimal | Tong thanh toan |
| tk_pt | varchar | TK phai tra |
| tk_thue | varchar | TK thue |

---

## Form classes

### 1. frmPOVchPO3 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Controls Header:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma NCC |
| lblTen_Kh | Label | Ten NCC |
| txtNguoi_Gd | TextBox | Nguoi giao dich |
| txtDia_chi | TextBox | Dia chi |
| txtMa_so_thue | TextBox | MST |
| txtSo_hd | TextBox | So hoa don |
| txtNgay_hd | DateTimePicker | Ngay hoa don |
| txtDien_giai | TextBox | Dien giai |
| cboMa_NT | ComboBox | Ma ngoai te |
| txtTy_gia | AsTextNumeric | Ty gia |
| txtMa_Httt | AsTextBox | Hinh thuc TT |

- **Tab Pages:**

| Tab | Mo ta |
|-----|-------|
| Chi tiet | Chi tiet vat tu |
| Chi_phi | Chi phi mua hang |
| Hach_toan | Hach toan ke toan |
| TaIn | Thue dau vao |

- **Controls Footer:**

| Control | Mo ta |
|---------|-------|
| txtT_tien_nt0 | Tong tien NT |
| txtT_cp_nt | Tong chi phi NT |
| txtT_thue_nt | Tong thue NT |
| txtT_tt_nt | Tong thanh toan NT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_HDMH_GET | Lay danh sach PO3 |
| SP_PO_HDMH_GETBYID | Lay chi tiet |
| SP_PO_HDMH_INSERT | Them chung tu |
| SP_PO_HDMH_UPDATE | Cap nhat |
| SP_PO_HDMH_DELETE | Xoa |
| SP_PO_HDMH_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Nha cung cap khong duoc trong' |
| Required | so_hd | 'So hoa don khong duoc trong' |
| Required | ngay_hd | 'Ngay hoa don khong duoc trong' |

### Business Rules

1. **Hoa don mua**:
   - Chon tu don dat hang (PO1)
   - Tu dong lay thong tin NCC

2. **Chi phi mua hang**:
   - Tab chi phi rieng
   - Phan bo chi phi cho mat hang

3. **Thue dau vao**:
   - Control ctlTaIn
   - Theo doi thue GTGT mua vao

4. **Hach toan**:
   - TK phai tra (tk_pt)
   - TK thue (tk_thue)

### Lookup Integration

- Tu DMNCC: Chon nha cung cap, dien thong tin
- Tu DMVT: Chon vat tu, dien ten, DVT
- Tu DMHTTT: Chon hinh thuc thanh toan
- Tu DMKHO: Chon kho, kiem tra ton

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/POHMN.php
namespace Diepxuan\Simba\Models\PO;

class POHMN extends Model
{
    protected $table = 'POHMN';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct',
        'so_hd', 'ngay_hd', 'ma_kh', 'nguoi_gd',
        'dia_chi', 'ma_so_thue', 'dien_giai',
        'ma_httt', 'ma_nt', 'ty_gia',
        't_tien_nt0', 't_tien0', 't_cp_nt', 't_cp',
        't_thue_nt', 't_thue', 't_ck_nt', 't_ck',
        't_tt_nt', 't_tt', 'tk_pt', 'tk_thue',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ngay_hd' => 'datetime',
        'ty_gia' => 'decimal:8',
    ];

    public function chiTiets()
    {
        return $this->hasMany(POHMNCT::class, 'stt_rec', 'stt_rec');
    }

    public function chiPhis()
    {
        return $this->hasMany(POHMNCP::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/Hoadonmh.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Voucher;

class Hoadonmh extends Component
{
    const MA_CT = 'PO3';

    public ?string $pStt_rec = null;
    public string $pSo_hd = '';
    public ?string $pNgay_hd = null;
    public ?string $pMa_kh = null;
    public string $pSo_ct = '';
    public ?string $pNgay_ct = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_nt = 'VND';
    public float $pTy_gia = 1;
    public Collection $pChiTiets;
    public Collection $pChiPhis;

    public function mount(?string $stt_rec = null): void
    {
        $this->pChiTiets = collect([]);
        $this->pChiPhis = collect([]);
    }

    public function render(): View
    {
        return view('catalog::po.voucher.hoadonmh');
    }
}
```

### 3. Views

```
resources/views/catalog/po/voucher/
├── hoadonmh.blade.php
└── _hoadonmh-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/voucher')
    ->name('catalog.po.voucher.')
    ->group(function () {
        Route::get('/hoa-don-mh', [Hoadonmh::class, 'render'])
            ->name('hoadonmh');
        Route::get('/hoa-don-mh/{stt_rec}', [Hoadonmh::class, 'render'])
            ->name('hoadonmh.show');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | POHMN.php | Hoa don |
| Model | laravel-simba | POHMNCT.php | Chi tiet |
| Model | laravel-simba | POHMNCP.php | Chi phi |
| Component | laravel-catalog | Hoadonmh.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Models POHMN, POHMNCT, POHMNCP
- [ ] Tao Livewire Hoadonmh
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test tinh toan
- [ ] Test Integration PO1
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
