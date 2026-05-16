# Task 215: SO-Thong-Bao-Mat-Chay-Hong-Hoa-Don

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang thong bao mat, chay, hong hoa don tu .NET sang PHP Laravel, dat ket qua tuong duong SOND51mchhd.

## Chi tiet
- **DLL:** SOND51mchhd.dll
- **Chuc nang:** Thong bao mat, chay, hong hoa don (Invoice Lost/Damaged Notice)
- **Loai:** Voucher (VCH)
- **Assembly Title:** SOMCHHD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** ND51

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51mchhd.dll/README.md`

---

## Cau truc du lieu

### Bang: nd51 (Thong bao - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu record (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (ND51) |
| ngay_tb | datetime | 8 | Ngay thong bao |
| ma_tb | varchar | 20 | So thong bao |
| noi_nhan | nvarchar | 255 | Noi nhan thong bao |
| ten_tc | nvarchar | 255 | Ten to chuc, ca nhan |
| dai_dien | nvarchar | 100 | Nguoi dai dien |
| dia_chi | nvarchar | 500 | Dia chi |
| ma_thue | varchar | 20 | Ma so thue |
| ghi_chu | nvarchar | 500 | Ly do mat/chay/hong |
| gio_xl | int | 4 | Gio xu ly |
| phut_xl | int | 4 | Phut xu ly |
| ngay_xl | datetime | 8 | Ngay xu ly |
| gui_cqt | bit | 1 | Da gui co quan thue |
| ngay_guicqt | datetime | 8 | Ngay gui CQ thue |

### Bang: nd51ct (Chi tiet hoa don)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| stt_rec | varchar | So thu tu chung tu (an) |
| loai_hd | nvarchar | Ten loai hoa don |
| mau_so | varchar | Mau so |
| ky_hieu | varchar | Ky hieu (so_seri) |
| tu_so | varchar | Tu so |
| den_so | varchar | Den so |
| so_luong | int | So luong |
| lien_so | int | Lien so |
| ghi_chu | nvarchar | Ghi chu |

---

## Form classes

### 1. frmSOND51mchhd (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSOND51mchhdEdit (Form nhap lieu)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtNgay_tb | AsMaskedTextBox | ngay_tb | Ngay thong bao |
| txtMa_tb | AsTextBox | ma_tb | So thong bao |
| txtNoi_nhan | TextBox | noi_nhan | Noi nhan |
| txtTen_tc | TextBox | ten_tc | Ten to chuc |
| txtDai_dien | TextBox | dai_dien | Nguoi dai dien |
| txtDia_chi | TextBox | dia_chi | Dia chi |
| txtMa_thue | TextBox | ma_thue | Ma so thue |
| txtGhi_chu | TextBox | ghi_chu | Ly do |
| txtGio_xl | AsTextNumeric | gio_xl | Gio xu ly |
| txtPhut_xl | AsTextNumeric | phut_xl | Phut xu ly |
| txtNgay_xl | AsMaskedTextBox | ngay_xl | Ngay xu ly |
| chkKsd | AsCheckBox | gui_cqt | Da gui CQ thue |
| txtNgay_guicqt | AsMaskedTextBox | ngay_guicqt | Ngay gui CQ |
| adgvHD | AsInputDGV | Danh sach HD |
| btnChon_hd | Button | Chon hoa don |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_ND51_MCHHD_GET | Lay danh sach |
| SP_ND51_MCHHD_GETBYID | Lay chi tiet |
| SP_ND51_MCHHD_INSERT | Them moi |
| SP_ND51_MCHHD_UPDATE | Cap nhat |
| SP_ND51_MCHHD_DELETE | Xoa |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ngay_tb | 'Ngay thong bao khong duoc trong' |
| Required | ma_tb | 'So thong bao khong duoc trong' |
| Required | noi_nhan | 'Noi nhan khong duoc trong' |
| Required | ten_tc | 'Ten to chuc khong duoc trong' |
| Required | dai_dien | 'Nguoi dai dien khong duoc trong' |
| Required | dia_chi | 'Dia chi khong duoc trong' |
| Required | ma_thue | 'Ma so thue khong duoc trong' |
| Date >= | ngay_xl >= ngay_tb | 'Ngay xu ly >= ngay thong bao' |
| Required | lien_so | 'Lien so khong duoc trong' |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/ND51Mchhd.php
namespace Diepxuan\Simba\Models\SO;

class ND51Mchhd extends Model
{
    protected $table = 'nd51';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const MA_CT = 'ND51';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_tb', 'ma_tb', 'noi_nhan',
        'ten_tc', 'dai_dien', 'dia_chi', 'ma_thue',
        'ghi_chu', 'gio_xl', 'phut_xl', 'ngay_xl',
        'gui_cqt', 'ngay_guicqt',
    ];

    protected $casts = [
        'ngay_tb' => 'datetime',
        'ngay_xl' => 'datetime',
        'ngay_guicqt' => 'datetime',
        'gui_cqt' => 'boolean',
    ];

    public function chiTiets()
    {
        return $this->hasMany(ND51MchhdCt::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/ThongbaomatchayhongEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\ThongbaomatchayhongEdit;

class ThongbaomatchayhongEdit extends Component
{
    public ?string $pSttRec = null;
    public ?string $pNgayTb = null;
    public string $pMaTb = '';
    public string $pNoiNhan = '';
    public string $pTenTc = '';
    public string $pDaiDien = '';
    public string $pDiaChi = '';
    public string $pMaThue = '';
    public string $pGhiChu = '';
    public int $pGioXl = 0;
    public int $pPhutXl = 0;
    public ?string $pNgayXl = null;
    public bool $pGuiCqt = false;
    public ?string $pNgayGuicqt = null;

    public array $pChiTiets = [];

    public function mount(?string $sttRec = null): void
    {
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadData();
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.thongbaomatchayhong-edit');
    }
}
```

### 3. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/thong-bao-mat-chay-hong', [Thongbaomatchayhong::class, 'render'])
            ->name('thongbaomatchayhong');
        Route::get('/thong-bao-mat-chay-hong/edit/{sttRec?}', [ThongbaomatchayhongEdit::class, 'render'])
            ->name('thongbaomatchayhong.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ND51Mchhd.php | Chinh |
| Model | laravel-simba | ND51MchhdCt.php | Chi tiet |
| Component | laravel-catalog | Thongbaomatchayhong.php | List |
| Component | laravel-catalog | ThongbaomatchayhongEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model ND51Mchhd, ND51MchhdCt
- [ ] Tao Livewire components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `so.notice.mchhd`
- **Note:** Shell hoặc route hiện hữu; side-effect blocked nếu chưa audit payload.
