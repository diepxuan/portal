# Task 098: SIDMHD

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc hop dong tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMHD.dll
- **Chuc nang:** Danh muc hop dong
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc hop dong
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIDMHD

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMHD.dll/README.md`

---

## Cau truc du lieu

### Bang: DMHD (Danh muc hop dong)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_hd | varchar | Ma hop dong (khoa chinh) |
| ten_hd | nvarchar | Ten hop dong |
| loai | int | Loai (1: Ban, 2: Mua) |
| so_hd | varchar | So hop dong |
| ma_nhhd | varchar | Ma nhom hop dong |
| ma_kh | varchar | Ma khach hang |
| ten_kh | nvarchar | Ten khach hang |
| ma_bp | varchar | Ma phong/bo phan |
| ten_bp | nvarchar | Ten phong |
| ngay_hd | datetime | Ngay hop dong |
| ngay_hh | datetime | Ngay het han |
| ma_nt | varchar | Ma ngoai te |
| tien | decimal | Tien hop dong (VND) |
| tien_nt | decimal | Tien hop dong (NT) |
| noi_dung | nvarchar | Noi dung |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmSIDMHD (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSIDMHDEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| cboLoai | ComboBox | loai | Loai HD (Mua/Ban) |
| txtMa_hd | AsTextBox | ma_hd | Ma hop dong |
| txtTen_hd | TextBox | ten_hd | Ten hop dong |
| txtSo_hd | TextBox | so_hd | So hop dong |
| txtMa_nhhd | AsTextBox | ma_nhhd | Nhom hop dong |
| txtMa_kh | AsTextBox | ma_kh | Khach hang |
| lblTen_kh | Label | - | Ten KH |
| txtMa_bp | AsTextBox | ma_bp | Bo phan |
| lblTen_bp | Label | - | Ten BP |
| txtNgay_hd | DateTimePicker | ngay_hd | Ngay HD |
| txtNgay_hh | DateTimePicker | ngay_hh | Ngay het han |
| cboMa_nt | ComboBox | ma_nt | Ngoai te |
| txtTien | AsTextNumeric | tien | Tien VND |
| txtTien_nt | AsTextNumeric | tien_nt | Tien NT |
| txtNoi_dung | TextBox | noi_dung | Noi dung |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_DMHD_GET | Lay danh sach |
| SP_SI_DMHD_GETBYID | Lay chi tiet |
| SP_SI_DMHD_INSERT | Them moi |
| SP_SI_DMHD_UPDATE | Cap nhat |
| SP_SI_DMHD_DELETE | Xoa |
| SP_SI_DMHD_FIND | Tim kiem |
| SP_SI_DMHD_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_hd | 'Ma hop dong khong duoc trong' |
| Unique | ma_hd | 'Ma da ton tai' |
| Required | ten_hd | 'Ten hop dong khong duoc trong' |
| ngay_hh > ngay_hd | ngay_hh | 'Ngay het han phai lon hon ngay HD' |

### Business Rules

1. **Loai hop dong**:
   - 1: Ban (AR)
   - 2: Mua (PO)

2. **Gia tri**:
   - Tien VND va NT
   - Ty gia tu dong

3. **Han hop dong**:
   - Canh bao hop dong het han

4. **Lien ket**:
   - Nhom hop dong (SIDMNHHD)
   - Khach hang (DMKH)

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMHD.php
namespace Diepxuan\Simba\Models\SI;

class DMHD extends Model
{
    protected $table = 'DMHD';
    protected $primaryKey = 'ma_hd';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_hd',
        'ten_hd',
        'loai',
        'so_hd',
        'ma_nhhd',
        'ma_kh',
        'ten_kh',
        'ma_bp',
        'ten_bp',
        'ngay_hd',
        'ngay_hh',
        'ma_nt',
        'tien',
        'tien_nt',
        'noi_dung',
        'ksd',
    ];

    protected $casts = [
        'loai' => 'integer',
        'ngay_hd' => 'datetime',
        'ngay_hh' => 'datetime',
        'tien' => 'decimal:8',
        'tien_nt' => 'decimal:8',
        'ksd' => 'boolean',
    ];

    public function nhomHd()
    {
        return $this->belongsTo(DMNHHD::class, 'ma_nhhd', 'ma_nhhd');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeBan($query)
    {
        return $query->where('loai', 1);
    }

    public function scopeMua($query)
    {
        return $query->where('loai', 2);
    }

    public function scopeExpired($query)
    {
        return $query->where('ngay_hh', '<', now());
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Hopdong.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Hopdong extends Component
{
    const MA_CT = 'SIDMHD';

    public Collection $pDanhSach;
    public ?int $pLoai = null;

    protected $rules = [
        'pLoai' => 'nullable|integer|in:1,2',
    ];

    public function render(): View
    {
        return view('catalog::si.danhmuc.hopdong');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/HopdongEdit.php
class HopdongEdit extends Component
{
    public ?string $pMa_hd = null;
    public string $pTen_hd = '';
    public int $pLoai = 1;
    public string $pSo_hd = '';
    public ?string $pMa_nhhd = null;
    public ?string $pMa_kh = null;
    public string $pTen_kh = '';
    public ?string $pMa_bp = null;
    public string $pTen_bp = '';
    public ?string $pNgay_hd = null;
    public ?string $pNgay_hh = null;
    public ?string $pMa_nt = 'VND';
    public float $pTien = 0;
    public float $pTien_nt = 0;
    public string $pNoi_dung = '';
    public bool $pKsd = false;

    protected $rules = [
        'pMa_hd' => 'required|string|max:50|unique:DMHD,ma_hd',
        'pTen_hd' => 'required|string|max:200',
        'pNgay_hh' => 'nullable|date|after:pNgay_hd',
    ];

    public function render(): View
    {
        return view('catalog::si.danhmuc.hopdong-edit');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── hopdong.blade.php
├── hopdong-edit.blade.php
└── _hopdong-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/hop-dong', [Hopdong::class, 'render'])
            ->name('hopdong');
        Route::get('/hop-dong/edit/{ma_hd?}', [HopdongEdit::class, 'render'])
            ->name('hopdong.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMHD.php | Chinh |
| Model | laravel-simba | DMNHHD.php | Nhom HD |
| Model | laravel-simba | DMKH.php | Khach hang |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMHD
- [ ] Tao Livewire Hopdong
- [ ] Tao Livewire HopdongEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test canh bao het han
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `si.dict.hopdong`
- **Note:** Route đã có hoặc shell metadata; write/transfer execute chỉ mở khi payload/side effect được audit.
