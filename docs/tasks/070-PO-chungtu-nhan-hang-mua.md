# Task 070: POVchPO4

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang phieu nhap kho mua (PO4) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** POVchPO4.dll
- **Chuc nang:** Phieu nhap kho
- **Loai:** Voucher (VCH)
- **Assembly Title:** Voucher phieu nhap kho
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PO4 (Phieu nhap kho)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/POVchPO4.dll/README.md`

---

## Cau truc du lieu

### Bang: POHN (Phieu nhap kho mua)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (PK) |
| ma_ct | varchar | Ma chung tu (PO4) |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
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
| tien_cp_pb_nt | decimal | CP phan bo NT |
| tien_cp_pb | decimal | CP phan bo |
| t_thue_nt | decimal | Tong thue NT |
| t_thue | decimal | Tong thue |
| t_tt_nt | decimal | Tong thanh toan NT |
| t_tt | decimal | Tong thanh toan |
| tk_pt | varchar | TK phai tra |
| tk_thue | varchar | TK thue |

---

## Form classes

### frmPOVchPO4 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Controls Header:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma NCC |
| lblTen_Kh | Label | Ten NCC |
| txtNguoi_Gd | TextBox | Nguoi giao dich |
| txtDia_chi | TextBox | Dia chi |
| txtMa_so_thue | TextBox | MST |
| txtDien_giai | TextBox | Dien giai |
| cboMa_NT | ComboBox | Ma ngoai te |
| txtTy_gia | AsTextNumeric | Ty gia |
| txtMa_Httt | AsTextBox | Hinh thuc TT |
| cmdChon_dh | Button | Chon don hang |

- **Tab Pages:**

| Tab | Mo ta |
|-----|-------|
| Chi tiet | Chi tiet vat tu nhap kho |
| Chi_phi | Chi phi nhap kho |
| Hach_toan | Hach toan ke toan |
| TaIn | Thue dau vao |

- **Controls Footer:**

| Control | Mo ta |
|---------|-------|
| txtT_tien_nt0 | Tong tien NT |
| txtT_cp_nt | Tong chi phi NT |
| txtTien_cp_pb_nt | CP phan bo NT |
| txtT_thue_nt | Tong thue NT |
| txtT_tt_nt | Tong thanh toan NT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_PNK_GET | Lay danh sach PO4 |
| SP_PO_PNK_GETBYID | Lay chi tiet |
| SP_PO_PNK_INSERT | Them chung tu |
| SP_PO_PNK_UPDATE | Cap nhat |
| SP_PO_PNK_DELETE | Xoa |
| SP_PO_PNK_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Nha cung cap khong duoc trong' |
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |

### Business Rules

1. **Chon tu don hang/hd**:
   - PO1: Don dat hang
   - PO3: Hoa don mua
   - PO7: Nhap kho noi bo

2. **Chi phi nhap kho**:
   - Phan bo chi phi cho mat hang
   - Tinh gia nhap thuc te

3. **Ton kho**:
   - Tang ton kho khi nhap

4. **Hach toan**:
   - TK kho (tu dong)
   - TK phai tra
   - TK thue

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/POHN.php
namespace Diepxuan\Simba\Models\PO;

class POHN extends Model
{
    protected $table = 'POHN';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct',
        'ma_kh', 'nguoi_gd', 'dia_chi', 'ma_so_thue',
        'dien_giai', 'ma_httt', 'ma_nt', 'ty_gia',
        't_tien_nt0', 't_tien0', 't_cp_nt', 't_cp',
        'tien_cp_pb_nt', 'tien_cp_pb',
        't_thue_nt', 't_thue', 't_tt_nt', 't_tt',
        'tk_pt', 'tk_thue',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:8',
    ];

    public function chiTiets()
    {
        return $this->hasMany(POHNCT::class, 'stt_rec', 'stt_rec');
    }

    public function chiPhis()
    {
        return $this->hasMany(POHNCP::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/Phieunhapkho.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Voucher;

class Phieunhapkho extends Component
{
    const MA_CT = 'PO4';

    public ?string $pStt_rec = null;
    public ?string $pMa_kh = null;
    public ?string $pNgay_ct = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_nt = 'VND';
    public float $pTy_gia = 1;
    public Collection $pChiTiets;
    public Collection $pChiPhis;

    protected $rules = [
        'pMa_kh' => 'required|string',
        'pNgay_ct' => 'required|date',
    ];

    public function mount(?string $stt_rec = null): void
    {
        $this->pChiTiets = collect([]);
        $this->pChiPhis = collect([]);
    }

    public function render(): View
    {
        return view('catalog::po.voucher.phieunhapkho');
    }
}
```

### 3. Views

```
resources/views/catalog/po/voucher/
├── phieunhapkho.blade.php
└── _phieunhapkho-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/voucher')
    ->name('catalog.po.voucher.')
    ->group(function () {
        Route::get('/phieu-nhap-kho', [Phieunhapkho::class, 'render'])
            ->name('phieunhapkho');
        Route::get('/phieu-nhap-kho/{stt_rec}', [Phieunhapkho::class, 'render'])
            ->name('phieunhapkho.show');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | POHN.php | Phieu nhap |
| Model | laravel-simba | POHNCT.php | Chi tiet |
| Model | laravel-simba | POHNCP.php | Chi phi |
| Component | laravel-catalog | Phieunhapkho.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Models POHN, POHNCT, POHNCP
- [ ] Tao Livewire Phieunhapkho
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test phan bo chi phi
- [ ] Test Integration PO1/PO3/PO7