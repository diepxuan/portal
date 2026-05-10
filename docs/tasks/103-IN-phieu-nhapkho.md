# Task 103: INVchIN1

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang phieu nhap kho tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** INVchIN1.dll
- **Chuc nang:** Phieu nhap kho
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Phieu nhap kho
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN1 (phieu nhap kho)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INVchIN1.dll/README.md`

---

## Cau truc du lieu

### Bang: IN1 (Phieu nhap kho - Header)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_cty | varchar | 50 | Ma cong ty |
| stt_rec | varchar | 50 | So thu tu record (khoa chinh) |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | (18,8) | Ty gia |
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | - | Ngay chung tu |
| ma_kh | varchar | 50 | Ma khach hang |
| ten_kh | nvarchar | 200 | Ten khach hang |
| dia_chi | nvarchar | 200 | Dia chi |
| nguoi_gd | nvarchar | 100 | Nguoi giao dich |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_gd | varchar | 50 | Ma giao dich (1=thanh pham, 2=khac) |
| tien_nt | decimal | (18,8) | Tong tien ngoai te |
| tien | decimal | (18,8) | Tong tien VND |

### Bang: IN1CT (Phieu nhap kho - Detail)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu record detail |
| ma_vt | varchar | Ma vat tu |
| ten_vt | nvarchar | Ten vat tu |
| dvt | nvarchar | Don vi tinh |
| ma_kho | varchar | Ma kho nhap |
| so_luong | decimal | So luong |
| gia_nt | decimal | Gia ngoai te |
| tien_nt | decimal | Thanh tien ngoai te |
| gia | decimal | Gia VND |
| tien | decimal | Thanh tien VND |
| tk_no | varchar | TK no |
| tk_co | varchar | TK co |
| ma_lo | varchar | Ma lo |
| ma_bp | varchar | Ma bo phan |
| ma_phi | varchar | Ma phi |
| ma_hd | varchar | Ma hop dong |
| ma_spct | varchar | Ma san pham chi tiet |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_vt -> DMVT.ma_vt |
| DMKHO | Danh muc kho | FK ma_kho -> DMKHO.ma_kho |
| DMLO | Danh muc lo | FK ma_lo -> DMLO.ma_lo |

---

## Form classes

### 1. frmInVchIN1 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap, sua, xoa phieu nhap kho
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_CT | AsTextBox | so_ct | So phieu nhap |
| dtpNgay_CT | DateTimePicker | ngay_ct | Ngay phieu nhap |
| txtMa_KH | AsTextBox | ma_kh | Ma khach hang |
| txtTen_KH | TextBox | ten_kh | Ten khach hang |
| txtDia_Chi | TextBox | dia_chi | Dia chi |
| txtNguoi_GD | TextBox | nguoi_gd | Nguoi giao dich |
| txtDien_Giai | TextBox | dien_giai | Dien giai |
| cboMa_GD | ComboBox | ma_gd | Loai phieu nhap |
| cboMa_NT | ComboBox | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtTien_NT | AsTextNumeric | tien_nt | Tong tien NT |
| txtTien | AsTextNumeric | tien | Tong tien VND |
| dgvCT | DataGridView | IN1CT | Luoi chi tiet phieu |

### 2. frmInVchIN1Find (Form tim kiem)
- **Ke thua:** frmVoucherFind
- **Chuc nang:** Tim kiem phieu nhap kho

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_IN1_GET | Lay danh sach phieu nhap kho |
| SP_IN_IN1_GETBYID | Lay chi tiet 1 phieu nhap kho |
| SP_IN_IN1_INSERT | Them phieu nhap kho |
| SP_IN_IN1_UPDATE | Cap nhat phieu nhap kho |
| SP_IN_IN1_DELETE | Xoa phieu nhap kho |
| SP_IN_IN1_FIND | Tim kiem phieu nhap kho |
| SP_IN_IN1_CHECK | Kiem tra trung so chung tu |

### SP_GET (reference)

```sql
-- Lay danh sach phieu nhap kho
EXEC SP_IN_IN1_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
-- Them phieu nhap kho
EXEC SP_IN_IN1_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(50) OUTPUT,
    @pMa_nt VARCHAR(10),
    @pTy_gia DECIMAL(18,8),
    @pSo_ct VARCHAR(50),
    @pNgay_ct DATETIME,
    @pMa_kh VARCHAR(50),
    @pTen_kh NVARCHAR(200),
    @pDia_chi NVARCHAR(200),
    @pNguoi_gd NVARCHAR(100),
    @pDien_giai NVARCHAR(500),
    @pMa_gd VARCHAR(50),
    @pTien_nt DECIMAL(18,8),
    @pTien DECIMAL(18,8),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | so_ct | 'So phieu khong duoc trong' |
| Required | ngay_ct | 'Ngay phieu khong duoc trong' |
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Required | ma_kho (detail) | 'Ma kho khong duoc trong' |
| Required | ma_vt (detail) | 'Ma vat tu khong duoc trong' |
| Required | so_luong (detail) | 'So luong phai lon hon 0' |
| Positive | ty_gia | 'Ty gia phai lon hon 0' |

### Business Rules

1. **Ma chung tu**: AutoGenerate (IN1 + stt_rec) hoac nhap tay
2. **Ngay chung tu**: Mac dinh ngay hien tai, kiem tra khoa so
3. **Ty gia**:
   - Tu dong lay tu bang ty gia
   - VND co ty_gia = 1
4. **Tinh tien tu dong**:
   - tien_nt = so_luong * gia_nt
   - tien = tien_nt * ty_gia
   - Tong tien = SUM(tien) detail
5. **Loai phieu nhap**:
   - 1: Phieu nhap thanh pham
   - 2: Phieu nhap khac
6. **Ton kho**: Kiem tra ton kho khi nhap (neu co yeu cau)

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/IN1.php
namespace Diepxuan\Simba\Models\IN;

class IN1 extends Model
{
    protected $table = 'IN1';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'stt_rec', 'ma_nt', 'ty_gia', 'so_ct', 'ngay_ct',
        'ma_kh', 'ten_kh', 'dia_chi', 'nguoi_gd', 'dien_giai',
        'ma_gd', 'tien_nt', 'tien',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:8',
        'tien_nt' => 'decimal:8',
        'tien' => 'decimal:8',
    ];

    public function chiTiet()
    {
        return $this->hasMany(IN1CT::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
}

// app/Models/IN/IN1CT.php
class IN1CT extends Model
{
    protected $table = 'IN1CT';
    protected $primaryKey = 'stt_rec0';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'stt_rec0', 'ma_vt', 'ten_vt', 'dvt', 'ma_kho',
        'so_luong', 'gia_nt', 'tien_nt', 'gia', 'tien',
        'tk_no', 'tk_co', 'ma_lo', 'ma_bp', 'ma_phi', 'ma_hd', 'ma_spct',
    ];

    public function phieu()
    {
        return $this->belongsTo(IN1::class, 'stt_rec', 'stt_rec');
    }

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }
}
```

### 2. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Phieunhapkho.php
namespace Diepxuan\Catalog\Http\Livewire\IN;

class Phieunhapkho extends Component
{
    const MA_CT = 'IN1';

    public Collection $pPhieuNhaps;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingSttRec = null;

    public function loadPhieuNhap(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::in.phieu-nhap-kho');
    }
}
```

### 3. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/PhieunhapkhoEdit.php
namespace Diepxuan\Catalog\Http\Livewire\IN;

class PhieunhapkhoEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pSoCT = '';
    public Carbon $pNgayCT;
    public ?string $pMaKH = null;
    public string $pTenKH = '';
    public string $pDiaChi = '';
    public string $pNguoiGD = '';
    public string $pDienGiai = '';
    public ?string $pMaGD = '1';
    public ?string $pMaNT = 'VND';
    public float $pTyGia = 1;
    public float $pTienNT = 0;
    public float $pTien = 0;
    public Collection $pChiTiet;
    public ?string $pMode = 'create';

    protected $rules = [
        'pSoCT' => 'required|string|max:50',
        'pNgayCT' => 'required|date',
        'pMaKH' => 'required|string|max:50',
        'pChiTiet' => 'required|min:1',
    ];

    public function mount(?string $sttRec = null): void
    {
        $this->pNgayCT = now();
        $this->pChiTiet = collect([]);
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadPhieuNhap();
        }
    }

    public function updatedPMaKH($value): void
    {
        // Auto-fill ten, dia chi, nguoi GD
    }

    public function tinhTien(): void
    {
        $this->pTienNT = $this->pChiTiet->sum('tien_nt');
        $this->pTien = $this->pTienNT * $this->pTyGia;
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::in.phieu-nhap-kho-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/in/
├── phieu-nhap-kho.blade.php        (List page)
├── phieu-nhap-kho-edit.blade.php   (Modal edit + chi tiet grid)
└── _phieu-nhap-kho-row.blade.php   (Component row)
```

### 5. Routes

```php
Route::prefix('catalog/in')
    ->name('catalog.in.')
    ->group(function () {
        Route::get('/phieu-nhap-kho', [Phieunhapkho::class, 'render'])
            ->name('phieu-nhap-kho');
        Route::get('/phieu-nhap-kho/edit/{sttRec?}', [PhieunhapkhoEdit::class, 'render'])
            ->name('phieu-nhap-kho.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | IN1.php | Header |
| Model | laravel-simba | IN1CT.php | Detail |
| Model | laravel-simba | DMVT.php | Vat tu (FK) |
| Model | laravel-simba | DMKHO.php | Kho (FK) |
| Model | laravel-simba | DMLO.php | Lo (FK) |
| Model | laravel-simba | DMKH.php | Khach hang (FK) |
| Component | laravel-catalog | Phieunhapkho.php | List |
| Component | laravel-catalog | PhieunhapkhoEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model IN1 va IN1CT
- [ ] Tao Livewire Phieunhapkho (list)
- [ ] Tao Livewire PhieunhapkhoEdit (modal + detail grid)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations voi chi tiet
- [ ] Test tinh tien tu dong (NT * TyGia)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
