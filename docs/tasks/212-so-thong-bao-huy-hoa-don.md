# Task 212: SO-Thong-Bao-Huy-Hoa-Don

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang thong bao huy hoa don tu .NET sang PHP Laravel, dat ket qua tuong duong SOND51HuyHD.

## Chi tiet
- **DLL:** SOND51HuyHD.dll
- **Chuc nang:** Thong bao huy hoa don (Invoice Cancellation Notice)
- **Loai:** Voucher (VCH) - Complex View
- **Assembly Title:** SOHuyHD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** ND51

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51HuyHD.dll/README.md`

---

## Cau truc du lieu

### Bang: nd51 (Thong bao huy hoa don - Phan dau)

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
| ghi_chu | nvarchar | 500 | Phuong phap huy hoa don |
| gio_xl | int | 4 | Gio xu ly (0-23) |
| phut_xl | int | 4 | Phut xu ly (0-59) |
| ngay_xl | datetime | 8 | Ngay xu ly |
| gui_cqt | bit | 1 | Da gui co quan thue |
| ngay_guicqt | datetime | 8 | Ngay gui CQ thue |
| kieu_xl | varchar | 10 | Kieu xu ly (HUY) |

### Bang: nd51ct (Chi tiet hoa don huy)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_chung | varchar | Ma chung tu (an) |
| ten_loai | nvarchar | Ten loai hoa don |
| mau_so | varchar | Mau so |
| so_seri | varchar | Ky hieu (so seri) |
| tu_so | varchar | Tu so |
| den_so | varchar | Den so |
| so_luong | int | So luong |
| lien_hd | int | Lien hoa don |
| ghi_chu | nvarchar | Ghi chu |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| dmloaihd | Loai hoa don | Lookup ten_loai |
| dmmauhd | Mau hoa don | Lookup mau_so, so_seri |

---

## Form classes

### 1. frmSOND51HuyHD (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Controls:**

| Control | Mo ta |
|---------|-------|
| dgvHuyHD | DataGridView hien thi danh sach |

### 2. frmSOND51HuyHDEdit (Form nhap lieu)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

#### Thong tin thong bao

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtNgay_tb | AsMaskedTextBox | ngay_tb | Ngay thong bao |
| txtMa_tb | AsTextBox | ma_tb | So thong bao |
| txtNoi_nhan | TextBox | noi_nhan | Noi nhan thong bao |

#### Thong tin to chuc

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTen_tc | TextBox | ten_tc | Ten to chuc, ca nhan |
| txtDai_dien | TextBox | dai_dien | Nguoi dai dien |
| txtDia_chi | TextBox | dia_chi | Dia chi |
| txtMa_thue | TextBox | ma_thue | Ma so thue |

#### Thong tin xu ly

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtGhi_chu | TextBox | ghi_chu | Phuong phap huy HD |
| txtGio_xl | AsTextNumeric | gio_xl | Gio xu ly |
| txtPhut_xl | AsTextNumeric | phut_xl | Phut xu ly |
| txtNgay_xl | AsMaskedTextBox | ngay_xl | Ngay xu ly |
| chkKsd | AsCheckBox | gui_cqt | Da gui CQ thue |
| txtNgay_guicqt | AsMaskedTextBox | ngay_guicqt | Ngay gui CQ thue |
| lblKieu_xl | Label | kieu_xl | Kieu xu ly (HUY) |

#### DataGridView

| Control | Type | Mo ta |
|---------|------|-------|
| adgvHD | AsInputDGV | Danh sach hoa don can huy |
| btnChon_hd | Button | Chon hoa don |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_ND51_HUYHD_GET | Lay danh sach |
| SP_ND51_HUYHD_GETBYID | Lay chi tiet |
| SP_ND51_HUYHD_INSERT | Them moi |
| SP_ND51_HUYHD_UPDATE | Cap nhat |
| SP_ND51_HUYHD_DELETE | Xoa |
| SP_ND51_HUYHD_FIND | Tim kiem |

### SP_INSERT (reference)

```sql
EXEC SP_ND51_HUYHD_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20) OUTPUT,
    @pMa_ct VARCHAR(10) = 'ND51',
    @pNgay_tb DATETIME,
    @pMa_tb VARCHAR(20),
    @pNoi_nhan NVARCHAR(255),
    @pTen_tc NVARCHAR(255),
    @pDai_dien NVARCHAR(100),
    @pDia_chi NVARCHAR(500),
    @pMa_thue VARCHAR(20),
    @pGhi_chu NVARCHAR(500),
    @pGio_xl INT,
    @pPhut_xl INT,
    @pNgay_xl DATETIME,
    @pGui_cqt BIT,
    @pNgay_guicqt DATETIME,
    @pKieu_xl VARCHAR(10) = 'HUY',
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ngay_tb | 'Ngay thong bao khong duoc trong' |
| Required | ma_tb | 'So thong bao khong duoc trong' |
| Required | ma_tb >= 1 | 'So thong bao phai >= 1' |
| Required | noi_nhan | 'Noi nhan khong duoc trong' |
| Required | ten_tc | 'Ten to chuc khong duoc trong' |
| Required | dai_dien | 'Nguoi dai dien khong duoc trong' |
| Required | dia_chi | 'Dia chi khong duoc trong' |
| Required | ma_thue | 'Ma so thue khong duoc trong' |
| Date >= | ngay_xl >= ngay_tb | 'Ngay xu ly >= ngay thong bao' |
| Range 0-23 | gio_xl | 'Gio 0-23' |
| Range 0-59 | phut_xl | 'Phut 0-59' |
| Required rows | adgvHD | 'Phai co it nhat 1 hoa don' |
| Required | lien_hd | 'Lien so khong duoc trong' |

### Business Rules

1. **So thong bao**:
   - Format: padding 8 chu so (VD: 00000001)
   - Auto-increment tu so lon nhat

2. **Chon hoa don (frmChonHD)**:
   - Hien thi danh sach hoa don da phat hanh
   - Cho phep chon nhieu hoa don
   - Dong thoi dien vao grid

3. **Xoa hoa don khoi danh sach**:
   - Phim F8 de xoa dong trong grid

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/ND51HuyHD.php
namespace Diepxuan\Simba\Models\SO;

class ND51HuyHD extends Model
{
    protected $table = 'nd51';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const MA_CT = 'ND51';
    const KIEU_XL_HUY = 'HUY';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_tb', 'ma_tb', 'noi_nhan',
        'ten_tc', 'dai_dien', 'dia_chi', 'ma_thue',
        'ghi_chu', 'gio_xl', 'phut_xl', 'ngay_xl',
        'gui_cqt', 'ngay_guicqt', 'kieu_xl',
    ];

    protected $casts = [
        'ngay_tb' => 'datetime',
        'ngay_xl' => 'datetime',
        'ngay_guicqt' => 'datetime',
        'gui_cqt' => 'boolean',
    ];

    public function chiTiets()
    {
        return $this->hasMany(ND51HuyHDCt::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetND51HuyHD.php
class AsSOGetND51HuyHD extends StoredProcedure
{
    protected $procedure = 'SP_ND51_HUYHD_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsND51HuyHD.php
class AsSOInsND51HuyHD extends StoredProcedure
{
    protected $procedure = 'SP_ND51_HUYHD_INSERT';
    protected $params = [
        'pMa_cty', 'pStt_rec', 'pMa_ct', 'pNgay_tb', 'pMa_tb',
        'pNoi_nhan', 'pTen_tc', 'pDai_dien', 'pDia_chi', 'pMa_thue',
        'pGhi_chu', 'pGio_xl', 'pPhut_xl', 'pNgay_xl',
        'pGui_cqt', 'pNgay_guicqt', 'pKieu_xl',
    ];
}
```

### 3. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/ThongbaohuyhoadonEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\ThongbaohuyhoadonEdit;

class ThongbaohuyhoadonEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pMaCt = 'ND51';
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
    public string $pKieuXl = 'HUY';

    public array $pChiTiets = [];

    protected $rules = [
        'pNgayTb' => 'required|date',
        'pMaTb' => 'required|string|max:20',
        'pNoiNhan' => 'required|string|max:255',
        'pTenTc' => 'required|string|max:255',
        'pDaiDien' => 'required|string|max:100',
        'pDiaChi' => 'required|string|max:500',
        'pMaThue' => 'required|string|max:20',
    ];

    public function mount(?string $sttRec = null): void
    {
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadData();
        } else {
            $this->pNgayTb = now()->format('Y-m-d');
            $this->pMaTb = $this->generateMaTb();
        }
    }

    protected function generateMaTb(): string
    {
        $max = ND51HuyHD::max('ma_tb') ?? 0;
        return str_pad((int)$max + 1, 8, '0', STR_PAD_LEFT);
    }

    public function openChonHD(): void
    {
        // Mo modal chon hoa don
        $this->emit('openChonHDModal');
    }

    public function addHoaDon(array $hoaDon): void
    {
        $this->pChiTiets[] = [
            'stt_rec0' => str_pad(count($this->pChiTiets) + 1, 5, '0', STR_PAD_LEFT),
            'ten_loai' => $hoaDon['ten_loai'],
            'mau_so' => $hoaDon['mau_so'],
            'so_seri' => $hoaDon['so_seri'],
            'tu_so' => $hoaDon['tu_so'],
            'den_so' => $hoaDon['den_so'],
            'so_luong' => $hoaDon['so_luong'],
            'lien_hd' => $hoaDon['lien_hd'] ?? 1,
            'ghi_chu' => '',
        ];
    }

    public function removeHoaDon(int $index): void
    {
        array_splice($this->pChiTiets, $index, 1);
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP INSERT
    }

    public function render(): View
    {
        return view('catalog::so.thongbaohuyhoadon-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/so/
├── thongbaohuyhoadon/
│   ├── index.blade.php
│   ├── edit.blade.php
│   ├── _chon-hoa-don-modal.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/thong-bao-huy-hoa-don', [Thongbaohuyhoadon::class, 'render'])
            ->name('thongbaohuyhoadon');
        Route::get('/thong-bao-huy-hoa-don/edit/{sttRec?}', [ThongbaohuyhoadonEdit::class, 'render'])
            ->name('thongbaohuyhoadon.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ND51HuyHD.php | Chinh |
| Model | laravel-simba | ND51HuyHDCt.php | Chi tiet |
| SP | laravel-simba | AsSOGetND51HuyHD.php | Get list |
| SP | laravel-simba | AsSOInsND51HuyHD.php | Insert |
| Component | laravel-catalog | Thongbaohuyhoadon.php | List |
| Component | laravel-catalog | ThongbaohuyhoadonEdit.php | Edit |
| Component | laravel-catalog | Chonhoadond51.php | Modal chon HD |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model ND51HuyHD, ND51HuyHDCt
- [ ] Tao Livewire Thongbaohuyhoadon (list)
- [ ] Tao Livewire ThongbaohuyhoadonEdit (edit)
- [ ] Tao modal Chonhoadond51
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test chon hoa don vao grid
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `so.notice.huyhd`
- **Note:** Shell hoặc route hiện hữu; side-effect blocked nếu chưa audit payload.
