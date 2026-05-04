# Task 213: SO-Bang-Ke-Hoa-Don

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bang ke hoa don (hết giá trị & gia hạn) tu .NET sang PHP Laravel, dat ket qua tuong duong SOND51bkhd.

## Chi tiet
- **DLL:** SOND51bkhd.dll
- **Chuc nang:** Bang ke hoa don het gia tri va gia han (Invoice Register - Expired & Extended)
- **Loai:** Voucher (VCH) - Complex View
- **Assembly Title:** SOND51bkhd
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** ND51

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51bkhd.dll/README.md`

---

## Cau truc du lieu

### Bang: nd51 (Bang ke - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu record (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (ND51) |
| ngay_tb | datetime | 8 | Ngay thong bao |
| ma_tb | varchar | 20 | So thong bao |
| ma_thue | varchar | 20 | Ma so thue |
| ten_cty | nvarchar | 255 | Ten cong ty |
| dai_dien | nvarchar | 100 | Nguoi dai dien |

### Bang: nd51ct (Chi tiet hoa don - 2 grid)

#### Grid 1: adgvHDHetHan (Hoa don het gia tri)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_ph | varchar | Ma phieu (an) |
| loai | varchar | Loai bang ke (an) |
| ten_loai | nvarchar | Ten loai hoa don |
| mau_so | varchar | Mau so |
| so_seri | varchar | Ky hieu |
| tu_so | varchar | Tu so |
| den_so | varchar | Den so |
| so_luong | int | So luong |
| so_hdin | int | So HD in (an) |
| so_hdph | int | So HD phat hanh (an) |

#### Grid 2: adgvHDGiaHan (Hoa don gia han)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_ph | varchar | Ma phieu (an) |
| loai | varchar | Loai bang ke (an) |
| ten_loai | nvarchar | Ten loai hoa don |
| mau_so | varchar | Mau so |
| so_seri | varchar | Ky hieu |
| tu_so | varchar | Tu so |
| den_so | varchar | Den so |
| so_luong | int | So luong |
| so_hdin | int | So HD in (an) |
| so_hdph | int | So HD phat hanh (an) |

---

## Form classes

### 1. frmSOND51bkhd (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmSOND51bkhdEdit (Form nhap lieu)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_tb | AsTextBox | ma_tb | So thong bao |
| txtNgay_tb | AsMaskedTextBox | ngay_tb | Ngay thong bao |
| txtMa_thue | TextBox | ma_thue | Ma so thue |
| txtTen_cty | TextBox | ten_cty | Ten cong ty |
| txtDai_dien | TextBox | dai_dien | Nguoi dai dien |

#### DataGridViews

| Control | Type | Mo ta |
|---------|------|-------|
| adgvHDHetHan | AsInputDGV | Grid hoa don het han |
| adgvHDGiaHan | AsInputDGV | Grid hoa don gia han |

#### Buttons

| Control | Mo ta |
|---------|-------|
| btnChonHD1 | Chon HD het gia tri |
| btnXoaHD1 | Xoa HD het gia tri |
| btnChonHD2 | Chon HD gia han |
| btnXoaHD2 | Xoa HD gia han |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_ND51_BKHD_GET | Lay danh sach |
| SP_ND51_BKHD_GETBYID | Lay chi tiet |
| SP_ND51_BKHD_INSERT | Them moi |
| SP_ND51_BKHD_UPDATE | Cap nhat |
| SP_ND51_BKHD_DELETE | Xoa |

### SP_INSERT (reference)

```sql
EXEC SP_ND51_BKHD_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20) OUTPUT,
    @pMa_ct VARCHAR(10) = 'ND51',
    @pNgay_tb DATETIME,
    @pMa_tb VARCHAR(20),
    @pMa_thue VARCHAR(20),
    @pTen_cty NVARCHAR(255),
    @pDai_dien NVARCHAR(100),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_tb | 'So thong bao khong duoc trong' |
| Required | ma_tb >= 1 | 'So thong bao phai >= 1' |
| Required | ten_cty | 'Ten cong ty khong duoc trong' |
| Required | dai_dien | 'Nguoi dai dien khong duoc trong' |
| Required | ma_thue | 'Ma so thue khong duoc trong' |

### Chi tiet validation (tu_so, den_so)

| Rule | Message |
|------|---------|
| Not empty | 'Tu so, den so khong duoc trong' |
| tu_so <= den_so | 'Tu so <= den so' |
| den_so <= so_hdph | 'Den so <= so HD phat hanh' |
| tu_so >= so_hdin | 'Tu so >= so HD in' |

### Tinh so luong

```csharp
So_luong = den_so - tu_so + 1
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/ND51Bkhd.php
namespace Diepxuan\Simba\Models\SO;

class ND51Bkhd extends Model
{
    protected $table = 'nd51';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const MA_CT = 'ND51';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_tb', 'ma_tb',
        'ma_thue', 'ten_cty', 'dai_dien',
    ];

    protected $casts = [
        'ngay_tb' => 'datetime',
    ];

    public function chiTiets()
    {
        return $this->hasMany(ND51BkhdCt::class, 'stt_rec', 'stt_rec');
    }

    public function chiTietsHetHan()
    {
        return $this->chiTiets()->where('loai', 'HET_HAN');
    }

    public function chiTietsGiaHan()
    {
        return $this->chiTiets()->where('loai', 'GIA_HAN');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/BangkhoadonEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\BangkhoadonEdit;

class BangkhoadonEdit extends Component
{
    public ?string $pSttRec = null;
    public ?string $pNgayTb = null;
    public string $pMaTb = '';
    public string $pMaThue = '';
    public string $pTenCty = '';
    public string $pDaiDien = '';

    public array $pChiTietsHetHan = [];
    public array $pChiTietsGiaHan = [];

    protected $rules = [
        'pMaTb' => 'required|string|max:20',
        'pTenCty' => 'required|string|max:255',
        'pDaiDien' => 'required|string|max:100',
        'pMaThue' => 'required|string|max:20',
    ];

    public function addHoaDonHetHan(array $hd): void
    {
        $this->pChiTietsHetHan[] = [
            'loai' => 'HET_HAN',
            'ten_loai' => $hd['ten_loai'],
            'mau_so' => $hd['mau_so'],
            'so_seri' => $hd['so_seri'],
            'tu_so' => $hd['tu_so'],
            'den_so' => $hd['den_so'],
            'so_luong' => (int)$hd['den_so'] - (int)$hd['tu_so'] + 1,
            'so_hdin' => $hd['so_hdin'],
            'so_hdph' => $hd['so_hdph'],
        ];
    }

    public function addHoaDonGiaHan(array $hd): void
    {
        $this->pChiTietsGiaHan[] = [
            'loai' => 'GIA_HAN',
            'ten_loai' => $hd['ten_loai'],
            'mau_so' => $hd['mau_so'],
            'so_seri' => $hd['so_seri'],
            'tu_so' => $hd['tu_so'],
            'den_so' => $hd['den_so'],
            'so_luong' => (int)$hd['den_so'] - (int)$hd['tu_so'] + 1,
            'so_hdin' => $hd['so_hdin'],
            'so_hdph' => $hd['so_hdph'],
        ];
    }

    public function render(): View
    {
        return view('catalog::so.bangkhoadon-edit');
    }
}
```

### 3. Views

```
resources/views/catalog/so/
├── bangkhoadon/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/bang-ke-hoa-don', [Bangkhoadon::class, 'render'])
            ->name('bangkhoadon');
        Route::get('/bang-ke-hoa-don/edit/{sttRec?}', [BangkhoadonEdit::class, 'render'])
            ->name('bangkhoadon.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ND51Bkhd.php | Chinh |
| Model | laravel-simba | ND51BkhdCt.php | Chi tiet |
| Component | laravel-catalog | Bangkhoadon.php | List |
| Component | laravel-catalog | BangkhoadonEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model ND51Bkhd, ND51BkhdCt
- [ ] Tao Livewire Bangkhoadon (list)
- [ ] Tao Livewire BangkhoadonEdit (edit)
- [ ] Tao Views voi 2 grids
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test chon hoa don cho 2 grids