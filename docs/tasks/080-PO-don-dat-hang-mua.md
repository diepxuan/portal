# Task 080: POVchPO7

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang phieu nhap kho noi bo (PO7) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** POVchPO7.dll
- **Chuc nang:** Phieu nhap kho noi bo
- **Loai:** Voucher (VCH)
- **Assembly Title:** Voucher nhap kho noi bo
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PO7 (Nhap kho noi bo)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/POVchPO7.dll/README.md`

---

## Cau truc du lieu

### Bang: PONB (Phieu nhap kho noi bo)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (PK) |
| ma_ct | varchar | Ma chung tu (PO7) |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| ngay_lct | datetime | Ngay lap CT |
| ma_kh | varchar | Ma NCC |
| nguoi_ban | nvarchar | Nguoi ban |
| dia_chi | nvarchar | Dia chi |
| ma_so_thue | varchar | MST |
| dien_giai | nvarchar | Dien giai |
| so_hd | varchar | So hoa don |
| ngay_hd | datetime | Ngay hoa don |
| mau_hd | varchar | Mau hoa don |
| ma_httt | varchar | Hinh thuc TT |
| ma_nt | varchar | Ma ngoai te |
| ty_gia | decimal | Ty gia |
| t_tien_nt0 | decimal | Tong tien NT |
| t_tien0 | decimal | Tong tien |
| tien_cp_nt | decimal | Tong chi phi NT |
| tien_cp | decimal | Tong chi phi |
| thue_nk | decimal | Thue NK |
| thue_ttdb | decimal | Thue TTDB |
| thue_gtgt | decimal | Thue GTGT |
| t_tt_nt | decimal | Tong thanh toan NT |
| t_tt | decimal | Tong thanh toan |
| tk_vt | varchar | TK vat tu |
| tk_pt | varchar | TK phai tra |
| tk_thue_nk | varchar | TK thue NK |
| tk_thue_ttdb | varchar | TK thue TTDB |

### Bang: PONBCT (Chi tiet nhap kho noi bo)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | FK |
| stt_rec0 | varchar | So tt chi tiet |
| ma_vt | varchar | Ma vat tu |
| ten_vt | nvarchar | Ten vat tu |
| dvt | varchar | Don vi tinh |
| ma_kho | varchar | Ma kho |
| ton | decimal | Ton kho |
| so_luong | decimal | So luong |
| gia_nt0 | decimal | Gia NT |
| tien_nt0 | decimal | Tien NT |
| gia0 | decimal | Gia VND |
| tien0 | decimal | Tien VND |
| cp_nt | decimal | Chi phi NT |
| cp | decimal | Chi phi VND |
| p_nk | decimal | % NK |
| thue_nk | decimal | Thue NK |
| p_ttdb | decimal | % TTDB |
| thue_ttdb | decimal | Thue TTDB |
| p_gtgt | decimal | % GTGT |
| thue_gtgt | decimal | Thue GTGT |

---

## Form classes

### frmPOVchPO7 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Controls Header:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma NCC |
| lblTen_Kh | Label | Ten NCC |
| txtNguoi_ban | TextBox | Nguoi ban |
| txtDia_chi | TextBox | Dia chi |
| txtMa_so_thue | TextBox | MST |
| txtSo_hd | TextBox | So HD |
| txtNgay_hd | DateTimePicker | Ngay HD |
| txtMau_hd | TextBox | Mau HD |
| txtDien_giai | TextBox | Dien giai |
| cboMa_NT | ComboBox | Ma ngoai te |
| txtTy_gia | AsTextNumeric | Ty gia |

- **Tab Pages:**

| Tab | Mo ta |
|-----|-------|
| Chi tiet | Chi tiet vat tu |
| Chi phi NK | Chi phi nhap khau |
| Hach_toan | Hach toan |
| Thue GTGT | Thong tin thue |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_PONB_GET | Lay danh sach PO7 |
| SP_PO_PONB_GETBYID | Lay chi tiet |
| SP_PO_PONB_INSERT | Them chung tu |
| SP_PO_PONB_UPDATE | Cap nhat |
| SP_PO_PONB_DELETE | Xoa |
| SP_PO_PONB_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Nha cung cap khong duoc trong' |
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Min 0 | so_luong | 'So luong >= 0' |

### Business Rules

1. **Nhap kho noi bo**:
   - Nhap tu nha cung cap nuoc ngoai
   - Quan ly thue NK, thue TTDB

2. **Chi phi nhap khau**:
   - Tab rieng cho chi phi NK
   - Phan bo cho mat hang

3. **Tinh gia nhap**:
   - Gia nhap = Gia mua + CP NK + Thue NK + Thue TTDB + Thue GTGT

4. **Ton kho**:
   - Tang ton kho khi nhap

### Lookup Integration

- Tu DMNCC: Chon nha cung cap, dien thong tin
- Tu DMVT: Chon vat tu, dien ten, DVT
- Tu DMKHO: Chon kho
- Tu DMHTTT: Chon hinh thuc thanh toan

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/PONB.php
namespace Diepxuan\Simba\Models\PO;

class PONB extends Model
{
    protected $table = 'PONB';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct',
        'ngay_lct', 'ma_kh', 'nguoi_ban', 'dia_chi',
        'ma_so_thue', 'dien_giai', 'so_hd', 'ngay_hd',
        'mau_hd', 'ma_httt', 'ma_nt', 'ty_gia',
        't_tien_nt0', 't_tien0', 'tien_cp_nt', 'tien_cp',
        'thue_nk', 'thue_ttdb', 'thue_gtgt',
        't_tt_nt', 't_tt',
        'tk_vt', 'tk_pt', 'tk_thue_nk', 'tk_thue_ttdb',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ngay_lct' => 'datetime',
        'ngay_hd' => 'datetime',
    ];

    public function chiTiets()
    {
        return $this->hasMany(PONBCT::class, 'stt_rec', 'stt_rec');
    }

    public function nhaCungCap()
    {
        return $this->belongsTo(DMNCC::class, 'ma_kh', 'ma_kh');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/NhapkhoNbo.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Voucher;

class NhapkhoNbo extends Component
{
    const MA_CT = 'PO7';

    public ?string $pStt_rec = null;
    public ?string $pMa_kh = null;
    public ?string $pNgay_ct = null;
    public ?string $pSo_hd = null;
    public ?string $pNgay_hd = null;
    public ?string $pMau_hd = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_nt = 'VND';
    public float $pTy_gia = 1;
    public Collection $pChiTiets;

    public function mount(?string $stt_rec = null): void
    {
        $this->pChiTiets = collect([]);
    }

    public function render(): View
    {
        return view('catalog::po.voucher.nhapkhonbo');
    }
}
```

### 3. Views

```
resources/views/catalog/po/voucher/
├── nhapkhonbo.blade.php
└── _nhapkhonbo-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/voucher')
    ->name('catalog.po.voucher.')
    ->group(function () {
        Route::get('/nhap-kho-nb', [NhapkhoNbo::class, 'render'])
            ->name('nhapkhonbo');
        Route::get('/nhap-kho-nb/{stt_rec}', [NhapkhoNbo::class, 'render'])
            ->name('nhapkhonbo.show');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | PONB.php | Phieu NKB |
| Model | laravel-simba | PONBCT.php | Chi tiet |
| Model | laravel-simba | DMNCC.php | NCC |
| Component | laravel-catalog | NhapkhoNbo.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Models PONB, PONBCT
- [ ] Tao Livewire NhapkhoNbo
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test tinh thue NK/TTDB/GTGT
- [ ] Test tich hop PO4
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
