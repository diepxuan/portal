# Task 049: SOVchSO1

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang phieu xuat ban le tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SOVchSO1.dll
- **Chuc nang:** Phieu xuat ban le (Don hang ban)
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Don hang ban
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO1 (Don hang ban)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO1.dll/README.md`

---

## Cau truc du lieu

### Bang: SO1 (Don hang ban - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So trace (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (SO1) |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 20 | So chung tu |
| ma_kh | varchar | 20 | Ma khach hang |
| ma_nvkd | varchar | 20 | Ma nhan vien kinh doanh |
| ma_httt | varchar | 20 | Hinh thuc thanh toan |
| ma_tt | varchar | 20 | Dieu khoan thanh toan |
| ngay_hh | datetime | 8 | Ngay het han giao hang |
| dia_chi | nvarchar | 200 | Dia chi giao hang |
| nguoi_gd | nvarchar | 100 | Nguoi giao dich |
| dien_giai | nvarchar | 500 | Dien giai |
| t_tien_nt2 | decimal | 18,2 | Tong tien ngoai te |
| t_tien_ck_nt | decimal | 18,2 | Tong tien chiet khau NT |
| t_thue_gtgt_nt | decimal | 18,2 | Tong thue GTGT NT |
| t_tt_nt | decimal | 18,2 | Tong thanh toan NT |
| t_tien | decimal | 18,2 | Tong tien VND |
| t_tien_ck | decimal | 18,2 | Tong tien chiet khau |
| t_thue_gtgt | decimal | 18,2 | Tong thue GTGT |
| t_tt | decimal | 18,2 | Tong thanh toan VND |
| trang_thai | varchar | 1 | Trang thai |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |

### Bang: SO2 (Don hang ban - Chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So trace (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ten_vt | nvarchar | Ten vat tu |
| dvt | varchar | Don vi tinh |
| ma_kho | varchar | Ma kho |
| ton | decimal | Ton kho |
| so_luong | decimal | So luong |
| gia_nt2 | decimal | Gia ban ngoai te |
| tien_nt2 | decimal | Tien hang ngoai te |
| tl_ck | decimal | Ty le chiet khau (%) |
| tien_ck_nt | decimal | Tien chiet khau NT |
| thue_gtgt_nt | decimal | Thue GTGT NT |
| ma_nvkd | varchar | NVKD phu trac chi tiet |
| tk_dt | varchar | Tai khoan doanh thu |
| tk_ck | varchar | Tai khoan chiet khau |

---

## Form classes

### 1. frmSoVchSO1 (Form chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap, sua, xem don hang ban
- **Controls (Phan thong tin chung):**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang (lookup) |
| lblTen_Kh | Label | ten_kh | Ten khach hang |
| txtDia_Chi | TextBox | dia_chi | Dia chi giao hang |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi giao dich |
| txtMa_Nvkd | AsTextBox | ma_nvkd | Ma NVKD (lookup) |
| lblTen_Nvkd | Label | ten_nvkd | Ten NVKD |
| txtMa_Httt | AsTextBox | ma_httt | Hinh thuc thanh toan |
| txtMa_Tt | AsTextBox | ma_tt | Dieu khoan thanh toan |
| txtNgay_Hh | AsMaskedTextBox | ngay_hh | Ngay het han |
| txtDien_Giai | TextBox | dien_giai | Dien giai |

- **Tab Chi tiet:** DataGridView nhap chi tiet hang hoa
- **Tab Hach toan:** Thong tin hach toan ke toan

### 2. frmSoVchSO1Find (Form tim kiem)
- **Ke thua:** frmVoucherFind
- **Chuc nang:** Tim kiem don hang ban

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Tim theo ma KH |
| txtMa_Vt | AsTextBox | Tim theo ma VT |
| txtMa_Kho | AsTextBox | Tim theo ma kho |
| txtMa_Nvkd | AsTextBox | Tim theo NVKD |
| txtNgay_hh1/2 | AsMaskedTextBox | Tim theo ngay het han |
| cboTrang_Thai | AsComboBoxTT | Trang thai don hang |

---

## Trang thai don hang

| Gia tri | Mo ta |
|---------|-------|
| 0 | Nhap |
| 1 | Cho duyet |
| 2 | Da duyet |
| 3 | Dang giao hang |
| 4 | Hoan thanh |
| 5 | Huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_SO1_GET | Lay danh sach don hang |
| SP_SO_SO1_GETBYID | Lay chi tiet 1 don hang |
| SP_SO_SO1_INSERT | Them don hang moi |
| SP_SO_SO1_UPDATE | Cap nhat don hang |
| SP_SO_SO1_DELETE | Xoa don hang |
| SP_SO_SO1_FIND | Tim kiem don hang |
| SP_SO_SO1_APPROVE | Duyet don hang |

### SP_GET (reference)

```sql
EXEC SP_SO_SO1_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_ct VARCHAR(10) = 'SO1',
    @pSearch NVARCHAR(100) = NULL,
    @pTrang_thai VARCHAR(1) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

---

## Business Logic

### Tinh toan chi tiet

```php
// Tien hang
Tien_Nt2 = So_Luong * Gia_Nt2

// Tien chiet khau
Tien_Ck_Nt = Tien_Nt2 * Tl_Ck / 100

// Thue GTGT
Thue_Gtgt_Nt = (Tien_Nt2 - Tien_Ck_Nt) * Ts_Gtgt / 100

// Tong thanh toan
T_Tt_Nt = Tien_Nt2 - Tien_Ck_Nt + Thue_Gtgt_Nt
```

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Required | ma_httt | 'Hinh thuc thanh toan khong duoc trong' |
| Required | chi_tiet | 'Phai co it nhat 1 dong hang hoa' |
| Numeric | so_luong | 'So luong phai > 0' |
| Numeric | gia_nt2 | 'Gia ban phai > 0' |
| Check stock | ma_vt, ma_kho, so_luong | 'Ton kho khong du' |

### Business Rules

1. **Tu dong dien thong tin KH**:
   - Sau khi chon ma_kh, tu dong dien ten_kh, dia_chi, nguoi_gd
   - Lay thong tin tu bang DMKH

2. **Kiem tra ton kho**:
   - Khi nhap so_luong, kiem tra ton kho trong bang VTON
   - Neu ton < so_luong -> canh bao nhung cho phep nhap

3. **Tinh toan tu dong**:
   - Khi thay doi so_luong hoac gia -> tu dong tinh tien
   - Khi thay doi tl_ck -> tu dong tinh tien ck
   - Khi thay doi thue_suat -> tu dong tinh thue

4. **Cap nhat trang thai**:
   - Moi tao: trang_thai = 0 (Nhap)
   - Duyet: trang_thai = 2 (Da duyet)
   - Xuat kho: trang_thai = 3 (Dang giao)
   - Hoan thanh: trang_thai = 4 (Hoan thanh)

---

## Mapping PHP

### 1. Models

```php
// app/Models/SO/SO1.php
namespace Diepxuan\Simba\Models\SO;

class SO1 extends Model
{
    protected $table = 'SO1';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct',
        'ma_kh', 'ma_nvkd', 'ma_httt', 'ma_tt',
        'ngay_hh', 'dia_chi', 'nguoi_gd', 'dien_giai',
        't_tien_nt2', 't_tien_ck_nt', 't_thue_gtgt_nt', 't_tt_nt',
        't_tien', 't_tien_ck', 't_thue_gtgt', 't_tt',
        'trang_thai', 'ma_nt', 'ty_gia',
    ];

    protected $casts = [
        'ngay_ct' => 'date',
        'ngay_hh' => 'date',
        't_tien_nt2' => 'decimal:2',
        't_tien' => 'decimal:2',
    ];

    public function chiTiet()
    {
        return $this->hasMany(SO2::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function scopeActive($query)
    {
        return $query->where('trang_thai', '<>', '5');
    }
}

// app/Models/SO/SO2.php
namespace Diepxuan\Simba\Models\SO;

class SO2 extends Model
{
    protected $table = 'SO2';
    protected $primaryKey = ['stt_rec', 'stt_rec0'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'stt_rec0', 'ma_vt', 'ten_vt', 'dvt',
        'ma_kho', 'ton', 'so_luong', 'gia_nt2', 'tien_nt2',
        'tl_ck', 'tien_ck_nt', 'thue_gtgt_nt', 'ma_nvkd',
    ];
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Voucher/DonHangBan.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Voucher;

class DonHangBan extends Component
{
    const MA_CT = 'SO1';

    public ?string $sttRec = null;
    public array $header = [];
    public array $details = [];
    public string $mode = 'view'; // view | create | edit

    protected $rules = [
        'header.ma_kh' => 'required|string|max:20',
        'header.ma_httt' => 'required|string|max:20',
        'header.ngay_ct' => 'required|date',
    ];

    public function mount(?string $sttRec = null): void
    {
        $this->sttRec = $sttRec;
        if ($sttRec) {
            $this->loadOrder();
        } else {
            $this->initNew();
        }
    }

    public function calculate(): void
    {
        // Tinh toan tien, thue...
    }

    public function save(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::so.voucher.don-hang-ban');
    }
}
```

### 3. Views

```
resources/views/catalog/so/voucher/
├── don-hang-ban.blade.php        (Form chinh)
├── don-hang-ban-find.blade.php   (Form tim kiem)
└── _don-hang-ban-detail-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/so/voucher')
    ->name('catalog.so.voucher.')
    ->group(function () {
        Route::get('/don-hang-ban', [DonHangBan::class, 'render'])
            ->name('donhangban');
        Route::get('/don-hang-ban/{sttRec}', [DonHangBan::class, 'render'])
            ->name('donhangban.view');
        Route::get('/don-hang-ban/find', [DonHangBanFind::class, 'render'])
            ->name('donhangban.find');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SO1.php | Header |
| Model | laravel-simba | SO2.php | Detail |
| Model | laravel-simba | DMKH.php | Khach hang (lookup) |
| Model | laravel-simba | DMVT.php | Vat tu (lookup) |
| Model | laravel-simba | VTON.php | Ton kho |
| SP | laravel-simba | SoGetSO1.php | Get list |
| SP | laravel-simba | SoInsSO1.php | Insert |
| SP | laravel-simba | SoUpdSO1.php | Update |
| Component | laravel-catalog | DonHangBan.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model SO1, SO2
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire DonHangBan
- [ ] Tao Views (form + find)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Calculate logic
- [ ] Test Integration voi Kho, KH