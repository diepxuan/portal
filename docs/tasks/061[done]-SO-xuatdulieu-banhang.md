# Task 061: SOTaOut

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang xuat du lieu ban hang (Hoa don dau ra / Thue dau ra) tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SOTaOut.dll
- **Chuc nang:** Xuat du lieu ban hang - Hoa don dau ra (Tax output)
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Vao cac hoa don dau ra
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SOUT (Ban hang dau ra)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOTaOut.dll/README.md`

---

## Cau truc du lieu

### Bang: SOUT1 (Ban hang dau ra - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So trace (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (SOUT) |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 20 | So chung tu |
| ngay_lap | datetime | 8 | Ngay lap |
| so_seri | varchar | 50 | So seri |
| so_seri_mhd | varchar | 50 | Ky hieu mau hoa don |
| ma_kh | varchar | 20 | Ma khach hang |
| ten_kh | nvarchar | 200 | Ten khach hang |
| ma_so_thue | varchar | 20 | Ma so thue |
| dia_chi | nvarchar | 200 | Dia chi |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |
| t_tien_nt | decimal | 18,2 | Tong tien ngoai te |
| t_tien | decimal | 18,2 | Tong tien VND |
| t_thue_nt | decimal | 18,2 | Tong thue ngoai te |
| t_thue | decimal | 18,2 | Tong thue VND |
| tk_thue | varchar | 20 | Tai khoan thue |
| tk_du | varchar | 20 | Tai khoan doi ung |
| ma_bp | varchar | 20 | Ma bo phan |
| ma_hd | varchar | 20 | Ma hoa don |
| ma_spct | varchar | 20 | Ma san pham chi tiet |
| ghi_chu | nvarchar | 500 | Ghi chu |

### Bang: SOUT2 (Ban hang dau ra - Chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So trace (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ten_vt | nvarchar | Ten vat tu |
| dvt | varchar | Don vi tinh |
| so_luong | decimal | So luong |
| gia | decimal | Don gia |
| tien_nt | decimal | Tien ngoai te |
| tien | decimal | Tien VND |
| ma_thue | varchar | Ma thue |
| thue_suat | decimal | Thue suat (%) |

---

## Form classes

### 1. frmSOTaOut (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach hoa don dau ra
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmSOTAOutEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua hoa don dau ra
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_ct | TextBox | so_ct | So chung tu |
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay chung tu |
| txtSo_seri | TextBox | so_seri | So seri |
| txtSo_seri_mhd | TextBox | so_seri_mhd | Ky hieu mau HD |
| cboNgoai_te | AsComboBoxNT | ma_nt | Ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| txtMa_kh | AsTextBox | ma_kh | Ma KH (lookup) |
| lblTen_kh | Label | ten_kh | Ten KH |
| txtMa_so_thue | TextBox | ma_so_thue | MST |
| txtDia_chi | TextBox | dia_chi | Dia chi |
| dgvDetail | DataGridView | - | Chi tiet hang hoa |
| txtTong_NT | AsTextNumeric | t_tien_nt | Tong tien NT |
| txtTong | AsTextNumeric | t_tien | Tong tien |
| txtTien_thue_NT | AsTextNumeric | t_thue_nt | Tien thue NT |
| txtTien_thue | AsTextNumeric | t_thue | Tien thue |
| txtTk_thue | AsTextBox | tk_thue | TK thue |
| txtTk_du | AsTextBox | tk_du | TK doi ung |
| txtMa_bp | AsTextBox | ma_bp | Ma bo phan |
| txtMa_hd | AsTextBox | ma_hd | Ma hoa don |
| txtGhi_chu | TextBox | ghi_chu | Ghi chu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_SOUT_GET | Lay danh sach |
| SP_SO_SOUT_GETBYID | Lay chi tiet |
| SP_SO_SOUT_INSERT | Them moi |
| SP_SO_SOUT_UPDATE | Cap nhat |
| SP_SO_SOUT_DELETE | Xoa |
| SP_SO_SOUT_FIND | Tim kiem |

---

## Business Logic

### Tinh toan

```php
// Tien hang
Tien_Nt = So_Luong * Gia

// Tong tien
T_Tien_Nt = Sum(Tien_Nt)

// Thue
T_Thue_Nt = T_Tien_Nt * Thue_Suat / 100

// Quy doi VND
T_Tien = T_Tien_Nt * Ty_Gia
T_Thue = T_Thue_Nt * Ty_Gia
```

### Events

| Event | Mo ta |
|-------|-------|
| txtSo_luong_ValueChanged | Tinh lai tien, thue |
| txtGia_ValueChanged | Tinh lai tien, thue |
| txtThue_suat_ValueChanged | Tinh lai thue |
| txtTy_gia_ValueChanged | Quy doi VND |
| cboNgoai_te_SelectedIndexChanged | Cap nhat mask, lay ty gia |

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Date | ngay_ct | 'Ngay chung tu phai trong nam tai chinh' |
| Date | ngay_ct > ngay_ks | 'Ngay chung tu phai lon hon ngay khoa so' |
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Required | tk_thue | 'Tai khoan thue khong duoc trong' |
| Positive | so_luong | 'So luong phai >= 0' |
| Positive | gia | 'Don gia phai >= 0' |

### Warnings

- Canh bao dieu chinh gia/trị khi chenh lech vuot nguong cau hinh

---

## Mapping PHP

### 1. Models

```php
// app/Models/SO/SOUT1.php
namespace Diepxuan\Simba\Models\SO;

class SOUT1 extends Model
{
    protected $table = 'SOUT1';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct', 'ngay_lap',
        'so_seri', 'so_seri_mhd',
        'ma_kh', 'ten_kh', 'ma_so_thue', 'dia_chi',
        'ma_nt', 'ty_gia',
        't_tien_nt', 't_tien',
        't_thue_nt', 't_thue',
        'tk_thue', 'tk_du',
        'ma_bp', 'ma_hd', 'ma_spct', 'ghi_chu',
    ];

    protected $casts = [
        'ngay_ct' => 'date',
        'ngay_lap' => 'date',
        'ty_gia' => 'decimal:4',
        't_tien_nt' => 'decimal:2',
        't_tien' => 'decimal:2',
        't_thue_nt' => 'decimal:2',
        't_thue' => 'decimal:2',
    ];

    public function chiTiet()
    {
        return $this->hasMany(SOUT2::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
}

// app/Models/SO/SOUT2.php
class SOUT2 extends Model
{
    protected $table = 'SOUT2';
    protected $primaryKey = ['stt_rec', 'stt_rec0'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'stt_rec0',
        'ma_vt', 'ten_vt', 'dvt',
        'so_luong', 'gia',
        'tien_nt', 'tien',
        'ma_thue', 'thue_suat',
    ];
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Voucher/BanHangDauRa.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Voucher;

class BanHangDauRa extends Component
{
    const MA_CT = 'SOUT';

    public ?string $sttRec = null;
    public array $header = [];
    public array $details = [];
    public string $mode = 'view';

    protected $rules = [
        'header.ngay_ct' => 'required|date',
        'header.ma_kh' => 'required|string|max:20',
        'header.tk_thue' => 'required|string|max:20',
    ];

    public function mount(?string $sttRec = null): void
    {
        $this->sttRec = $sttRec;
        if ($sttRec) {
            $this->loadHoaDon();
        } else {
            $this->initNew();
        }
    }

    public function calculate(): void
    {
        // Tinh tong tien, thue
    }

    public function save(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.voucher.ban-hang-dau-ra');
    }
}
```

### 3. Views & Routes

```
resources/views/catalog/so/voucher/
├── ban-hang-dau-ra.blade.php
├── ban-hang-dau-ra-find.blade.php
```

```php
Route::prefix('catalog/so/voucher')
    ->name('catalog.so.voucher.')
    ->group(function () {
        Route::get('/ban-hang-dau-ra', [BanHangDauRa::class, 'render'])
            ->name('banhangdaua');
        Route::get('/ban-hang-dau-ra/{sttRec}', [BanHangDauRa::class, 'render'])
            ->name('banhangdaua.view');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SOUT1.php | Header |
| Model | laravel-simba | SOUT2.php | Detail |
| Model | laravel-simba | DMKH.php | Khach hang |
| Model | laravel-simba | DMVT.php | Vat tu |
| Component | laravel-catalog | BanHangDauRa.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model SOUT1, SOUT2
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire BanHangDauRa
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Calculate logic
- [ ] Test Multi-currency
- [ ] Test Integration voi DMKH
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.061`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
