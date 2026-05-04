# Task 075: POUtilities

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang tien ich mua hang tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** POUtilities.dll
- **Chuc nang:** Tien ich mua hang - Thanh toan chung tu PO
- **Loai:** Utilities (UTIL)
- **Assembly Title:** Purchase Order Utilities
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.POUtilities`
- **Company:** Asia Software Development JSC
- **Ma_ct:** CA2/CA4 (Thanh toan)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/POUtilities.dll/README.md`

---

## Cau truc du lieu

### Bang: CAPT (Chung tu thanh toan PO)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (PK) |
| ma_ct | varchar | Ma chung tu (CA2/CA4) |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| ma_kh | varchar | Ma NCC |
| tk_co | varchar | TK co (tk_thanhtoan) |
| nguoi_gd | nvarchar | Nguoi giao dich |
| dien_giai | nvarchar | Dien giai |
| ma_nt | varchar | Ma ngoai te |
| ty_gia | decimal | Ty gia |
| t_tien_nt | decimal | Tong tien NT |
| t_tien | decimal | Tong tien |
| loai_ct | varchar | Loai chung tu (CA2/CA4) |
| da_chi | bit | Da chi (trang thai) |

---

## Form classes

### frmCA4PO (Form thanh toan PO)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Tao chung tu thanh toan cho PO

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtSo_ct | TextBox | So chung tu |
| txtNgay_ct | DateTimePicker | Ngay chung tu |
| cboLoai_ct | ComboBox | Loai chung tu (CA2: Phieu chi, CA4: Bao no) |
| cboMa_nt | ComboBox | Ma ngoai te |
| txtTy_gia | AsTextNumeric | Ty gia |
| cboTk_co | ComboBox | TK co |
| txtNguoi_gd | TextBox | Nguoi giao dich |
| txtDien_giai | TextBox | Dien giai |
| dgvDetails | DataGridView | Chi tiet hach toan |
| txtT_tien_nt | AsTextNumeric | Tong tien NT |
| txtT_tien | AsTextNumeric | Tong tien |
| chkDa_chi | CheckBox | Da chi |
| cmdSave | Button | Nut luu |
| cmdPrint | Button | Nut in |

### Loai chung tu thanh toan

| Gia tri | Loai | Mo ta |
|---------|------|-------|
| CA2 | Phieu chi | Chi tien mat |
| CA4 | Bao no | Bao nợ ngân hàng |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_CAPT_GET | Lay danh sach thanh toan |
| SP_PO_CAPT_GETBYID | Lay chi tiet |
| SP_PO_CAPT_INSERT | Them thanh toan |
| SP_PO_CAPT_UPDATE | Cap nhat |
| SP_PO_CAPT_DELETE | Xoa |
| SP_PO_CAPT_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Nha cung cap khong duoc trong' |
| Required | tk_co | 'Tai khoan co khong duoc trong' |
| Min 0 | t_tien | 'So tien >= 0' |

### Business Rules

1. **Thanh toan**:
   - Chon HD de thanh toan
   - Nhap so tien thanh toan
   - Tao chung tu CA2 (Phieu chi) hoac CA4 (Bao no)

2. **Loai thanh toan**:
   - CA2: Phieu chi tien mat
   - CA4: Bao nợ ngân hàng

3. **Chap nhan thanh toan**:
   - Mot phan thanh toan
   - Toan bo thanh toan

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/CAPT.php
namespace Diepxuan\Simba\Models\PO;

class CAPT extends Model
{
    protected $table = 'CAPT';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct',
        'ma_kh', 'tk_co', 'nguoi_gd', 'dien_giai',
        'ma_nt', 'ty_gia', 't_tien_nt', 't_tien',
        'loai_ct', 'da_chi',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:8',
        't_tien_nt' => 'decimal:8',
        't_tien' => 'decimal:8',
        'da_chi' => 'boolean',
    ];

    public function chiTiets()
    {
        return $this->hasMany(CAPTCT::class, 'stt_rec', 'stt_rec');
    }

    public function nhaCungCap()
    {
        return $this->belongsTo(DMNCC::class, 'ma_kh', 'ma_kh');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/ThanhtoanPo.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Voucher;

class ThanhtoanPo extends Component
{
    const LOAI_CA2 = 'CA2';
    const LOAI_CA4 = 'CA4';

    public ?string $pStt_rec = null;
    public string $pLoai_ct = 'CA2';
    public ?string $pNgay_ct = null;
    public ?string $pMa_kh = null;
    public ?string $pTk_co = null;
    public string $pNguoi_gd = '';
    public string $pDien_giai = '';
    public ?string $pMa_nt = 'VND';
    public float $pTy_gia = 1;
    public float $pT_tien_nt = 0;
    public float $pT_tien = 0;
    public bool $pDa_chi = false;
    public Collection $pChiTiets;

    public function mount(): void
    {
        $this->pChiTiets = collect([]);
    }

    public function render(): View
    {
        return view('catalog::po.voucher.thanhtoanpo');
    }
}
```

### 3. Views

```
resources/views/catalog/po/voucher/
├── thanhtoanpo.blade.php
└── _thanhtoanpo-detail.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/voucher')
    ->name('catalog.po.voucher.')
    ->group(function () {
        Route::get('/thanh-toan-po', [ThanhtoanPo::class, 'render'])
            ->name('thanhtoanpo');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | CAPT.php | Chung tu thanh toan |
| Model | laravel-simba | CAPTCT.php | Chi tiet |
| Model | laravel-simba | POHMN.php | HD can thanh toan |
| Component | laravel-catalog | ThanhtoanPo.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Models CAPT, CAPTCT
- [ ] Tao Livewire ThanhtoanPo
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test tao chung tu CA2
- [ ] Test tao chung tu CA4
- [ ] Test Integration POHMN