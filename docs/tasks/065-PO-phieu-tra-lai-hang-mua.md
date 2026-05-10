# Task 065: POVchPO1

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang phieu tra lai hang mua (PO1) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** POVchPO1.dll
- **Chuc nang:** Don dat hang mua
- **Loai:** Voucher (VCH)
- **Assembly Title:** Voucher don dat hang mua
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PO1 (Don dat hang)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/POVchPO1.dll/README.md`

---

## Cau truc du lieu

### Bang: POMH (Phieu dat hang mua)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | So thu tu ban ghi (PK) |
| ma_ct | varchar | 10 | Ma chung tu (PO1) |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 50 | So chung tu |
| ma_kh | varchar | 50 | Ma nha cung cap |
| nguoi_gd | nvarchar | 100 | Nguoi giao dich |
| dia_chi | nvarchar | 200 | Dia chi NCC |
| ma_so_thue | varchar | 50 | Ma so thue |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,8 | Ty gia |
| t_tien_nt0 | decimal | 18,8 | Tong tien NT |
| t_tien0 | decimal | 18,8 | Tong tien |
| t_thue_nt | decimal | 18,8 | Tong thue NT |
| t_thue | decimal | 18,8 | Tong thue |
| t_tt_nt | decimal | 18,8 | Tong thanh toan NT |
| t_tt | decimal | 18,8 | Tong thanh toan |
| t_ck_nt | decimal | 18,8 | Tong chiet khau NT |
| t_ck | decimal | 18,8 | Tong chiet khau |
| trang_thai | int | 4 | Trang thai |

### Bang: POMHCT (Chi tiet don dat hang)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ten_vt | nvarchar | Ten vat tu |
| dvt | varchar | Don vi tinh |
| ma_kho | varchar | Ma kho |
| ma_vitri | varchar | Ma vi tri |
| ton | decimal | Ton kho |
| so_luong | decimal | So luong dat |
| gia_nt0 | decimal | Gia NT |
| tien_nt0 | decimal | Tien NT |
| ts_gtgt | decimal | Thue suat GTGT |
| thue_gtgt_nt | decimal | Thue GTGT NT |
| gia0 | decimal | Gia |
| tien0 | decimal | Tien |
| thue_gtgt | decimal | Thue GTGT |
| ma_bp | varchar | Ma bo phan |
| ma_phi | varchar | Ma phi |
| ma_spct | varchar | Ma SP chi tiet |
| ma_lo | varchar | Ma lo |
| gia_dd | bit | Gia da dinh |

### Bang: POMHCN (Chi phi)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_chiphi | varchar | Ma chi phi |
| tien_cp_nt | decimal | Tien chi phi NT |
| ts_gtgt_cp | decimal | Thue suat |
| thue_gtgt_nt_cp | decimal | Thue GTGT NT |
| tien_cp | decimal | Tien chi phi |

---

## Form classes

### 1. frmPOVchPO1 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap lieu don dat hang mua
- **Controls Header:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | ma_kh | Ma NCC (AutoLookup) |
| lblTen_Kh | Label | ten_kh | Ten NCC |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi giao dich |
| txtDia_chi | TextBox | dia_chi | Dia chi |
| txtMa_so_thue | TextBox | ma_so_thue | MST |
| txtDien_giai | TextBox | dien_giai | Dien giai |
| cboMa_NT | ComboBox | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| cmdChon_dh | Button | - | Chon don hang |

- **Tab Pages:**

| Tab | Mo ta |
|-----|-------|
| Chi tiet | Chi tiet vat tu |
| Hach_toan | Hach toan ke toan |

- **Controls Footer:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtT_tien_nt0 | AsTextNumeric | Tong tien NT (readonly) |
| txtT_tien0 | AsTextNumeric | Tong tien (readonly) |
| txtT_thue_nt | AsTextNumeric | Tong thue NT (readonly) |
| txtT_thue | AsTextNumeric | Tong thue (readonly) |
| txtT_tt_nt | AsTextNumeric | Tong thanh toan NT (readonly) |
| txtT_tt | AsTextNumeric | Tong thanh toan (readonly) |

### 2. frmPOVchPO1Find (Form tim kiem)
- **Ke thua:** frmVoucherFind
- **Chuc nang:** Tim kiem chung tu

### 3. frmPOVchPO1FindPO0 / frmPOVchPO1SeachPO0 (Form chon don hang goc)
- **Chuc nang:** Tim va chon don hang goc

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_POH_GET | Lay danh sach PO1 |
| SP_PO_POH_GETBYID | Lay chi tiet 1 chung tu |
| SP_PO_POH_INSERT | Them chung tu |
| SP_PO_POH_UPDATE | Cap nhat chung tu |
| SP_PO_POH_DELETE | Xoa chung tu |
| SP_PO_POH_FIND | Tim kiem |
| SP_PO_POH_CHECK | Kiem tra trung so ct |

### SP_GET (reference)

```sql
EXEC SP_PO_POH_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_ct VARCHAR(10) = 'PO1',
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Nha cung cap khong duoc trong' |
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Required | ma_nt | 'Ngoai te khong duoc trong' |
| Required | ma_kho | 'Kho khong duoc trong' |
| Min 0 | so_luong | 'So luong >= 0' |
| Min 0 | gia_nt0 | 'Gia >= 0' |

### Business Rules

1. **Tu dong tinh toan**:
   - Tien = So luong * Gia
   - Thue GTGT = Tien * Thue suat
   - Tong tien = Tien + Thue
   - Chuyen doi ngoai te theo ty gia

2. **Lenh dat hang**:
   - Tu dong sinh ma lenh (PO1 + stt_rec)
   - Chon tu don hang goc (PO0)

3. **Hach toan**:
   - Tu dong tao dong hach toan theo cau hinh

4. **Ton kho**:
   - Hien thi ton kho hien tai
   - Khong cho phep dat lon hon ton

### Lookup Integration

- Tu DMNCC: Chon nha cung cap, dien thong tin
- Tu DMVT: Chon vat tu, dien ten, DVT
- Tu DMHTTT: Chon hinh thuc thanh toan
- Tu DMKHO: Chon kho, kiem tra ton
- Tu POVchPO7: Lookup don hang (PO7)

---

## Mapping PHP

### 1. Models

```php
// app/Models/PO/POMH.php
namespace Diepxuan\Simba\Models\PO;

class POMH extends Model
{
    protected $table = 'POMH';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec',
        'ma_ct',
        'ngay_ct',
        'so_ct',
        'ma_kh',
        'nguoi_gd',
        'dia_chi',
        'ma_so_thue',
        'dien_giai',
        'ma_nt',
        'ty_gia',
        't_tien_nt0',
        't_tien0',
        't_thue_nt',
        't_thue',
        't_tt_nt',
        't_tt',
        't_ck_nt',
        't_ck',
        'trang_thai',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:8',
        't_tien_nt0' => 'decimal:8',
        't_tien0' => 'decimal:8',
        't_thue_nt' => 'decimal:8',
        't_thue' => 'decimal:8',
        't_tt_nt' => 'decimal:8',
        't_tt' => 'decimal:8',
        't_ck_nt' => 'decimal:8',
        't_ck' => 'decimal:8',
        'trang_thai' => 'integer',
    ];

    public function chiTiets()
    {
        return $this->hasMany(POMHCT::class, 'stt_rec', 'stt_rec');
    }

    public function chiPhis()
    {
        return $this->hasMany(POMHCN::class, 'stt_rec', 'stt_rec');
    }

    public function nhaCungCap()
    {
        return $this->belongsTo(DMNCC::class, 'ma_kh', 'ma_kh');
    }
}
```

### 2. Livewire Component (Form nhap lieu)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/DonDatHang.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Voucher;

class DonDatHang extends Component
{
    const MA_CT = 'PO1';

    public ?string $pStt_rec = null;
    public string $pMa_ct = 'PO1';
    public ?string $pNgay_ct = null;
    public string $pSo_ct = '';
    public ?string $pMa_kh = null;
    public string $pNguoi_gd = '';
    public string $pDia_chi = '';
    public string $pMa_so_thue = '';
    public string $pDien_giai = '';
    public ?string $pMa_nt = 'VND';
    public float $pTy_gia = 1;
    public float $pT_tien_nt0 = 0;
    public float $pT_tien0 = 0;
    public float $pT_thue_nt = 0;
    public float $pT_thue = 0;
    public float $pT_tt_nt = 0;
    public float $pT_tt = 0;
    public int $pTrang_thai = 0;

    public Collection $pChiTiets;

    protected $rules = [
        'pMa_kh' => 'required|string',
        'pNgay_ct' => 'required|date',
        'pMa_nt' => 'required|string',
    ];

    public function mount(?string $stt_rec = null): void
    {
        $this->pChiTiets = collect([]);
        if ($stt_rec) {
            $this->loadChungTu($stt_rec);
        }
    }

    public function tinhTong(): void
    {
        // Tinh toan tong tien, thue, thanh toan
    }

    public function render(): View
    {
        return view('catalog::po.voucher.dondathang');
    }
}
```

### 3. Views

```
resources/views/catalog/po/voucher/
├── dondathang.blade.php
├── dondathang-find.blade.php
└── _dondathang-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/voucher')
    ->name('catalog.po.voucher.')
    ->group(function () {
        Route::get('/don-dat-hang', [DonDatHang::class, 'render'])
            ->name('dondathang');
        Route::get('/don-dat-hang/{stt_rec}', [DonDatHang::class, 'render'])
            ->name('dondathang.show');
        Route::get('/don-dat-hang/find', [DonDatHangFind::class, 'render'])
            ->name('dondathang.find');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | POMH.php | Phieu dat hang |
| Model | laravel-simba | POMHCT.php | Chi tiet |
| Model | laravel-simba | POMHCN.php | Chi phi |
| Model | laravel-simba | DMNCC.php | Nha cung cap |
| Component | laravel-catalog | DonDatHang.php | Form nhap |
| Component | laravel-catalog | DonDatHangFind.php | Form tim kiem |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes
- [ ] Tao Model POMH, POMHCT, POMHCN
- [ ] Tao Livewire DonDatHang (form)
- [ ] Tao Livewire DonDatHangFind (tim kiem)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test tinh toan tu dong
- [ ] Test Integration voi PO0
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
