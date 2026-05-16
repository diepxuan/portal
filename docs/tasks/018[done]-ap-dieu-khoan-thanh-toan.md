# Task 018: APTT

## Nhom: AP (Accounts Payable - Cong no phai tra)

## Muc tieu
Chuyen doi chuc nang quan ly dieu khoan thanh toan tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** APTT.dll
- **Chuc nang:** Quan ly so du dau ky hoa don phai tra - thong tin han thanh toan, ti le chiet khau, lai suat qua han
- **Loai:** Open Balance (OB)
- **Assembly Title:** So du dau ky cac hoa don phai tra
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AP (danh muc AP)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/APTT.dll/README.md`

---

## Cau truc du lieu

### Bang: APTT (So du dau ky hoa don phai tra)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | So thu tu record |
| ma_cty | varchar | 50 | Ma cong ty |
| ma_ncc | varchar | 50 | Ma nha cung cap |
| tk_pt | varchar | 20 | TK phai tra |
| ma_tt_po | varchar | 50 | Ma dieu khoan thanh toan |
| ma_hd | varchar | 50 | Ma hop dong |
| so_ct | varchar | 50 | So hoa don |
| ngay_ct | datetime | 8 | Ngay hoa don |
| han_ck | int | 4 | Han chiet khau (ngay) |
| han_tt | int | 4 | Han thanh toan (ngay) |
| tl_ck | decimal | 18,4 | Ty le chiet khau |
| ls_qh | decimal | 18,4 | Lai suat qua han |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |
| tien_hang_nt | decimal | 18,2 | Tien hang NT |
| tien_hang | decimal | 18,2 | Tien hang |
| tien_thue_nt | decimal | 18,2 | Tien thue NT |
| tien_thue | decimal | 18,2 | Tien thue |
| tong_tt_nt | decimal | 18,2 | Tong thanh toan NT |
| tong_tt | decimal | 18,2 | Tong thanh toan |
| tien_tt_nt | decimal | 18,2 | Da thanh toan NT |
| tien_tt | decimal | 18,2 | Da thanh toan |
| du_hd_nt | decimal | 18,2 | Con phai tra NT |
| du_hd | decimal | 18,2 | Con phai tra |
| dien_giai | nvarchar | 500 | Dien giai |
| ngay_ct_tt | datetime | 8 | Ngay thanh toan |
| so_ct_tt | varchar | 50 | So CT thanh toan |
| ksd | bit | 1 | Khoa su dung |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMNCC | Danh muc nha cung cap | FK ma_ncc |
| DMTT | Danh muc dieu khoan TT | FK ma_tt_po |
| DMHD | Danh muc hop dong | FK ma_hd |

---

## Form classes

### 1. frmAPTT (Form xem danh sach)
- **Ke thua:** frmOBView
- **Chuc nang:** Hien thi danh sach so du dau ky, tim kiem, phan trang
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem theo ma/ten |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmAPTTEdit (Form them/sua)
- **Ke thua:** frmOBEdit
- **Chuc nang:** Nhap, sua thong tin so du dau ky
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_NCC | AsTextBox | ma_ncc | Ma nha cung cap |
| txtTK_pt | AsTextBox | tk_pt | TK phai tra |
| txtMa_tt_po | AsTextBox | ma_tt_po | Ma dieu khoan TT |
| txtMa_hd | AsTextBox | ma_hd | Ma hop dong |
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay chung tu |
| txtSo_ct | TextBox | so_ct | So chung tu |
| txtHan_ck | AsTextNumeric | han_ck | Han chiet khau |
| txtHan_tt | AsTextNumeric | han_tt | Han thanh toan |
| txttl_ck | AsTextNumeric | tl_ck | Ty le chiet khau |
| txtls_qh | AsTextNumeric | ls_qh | Lai suat qua han |
| txtdien_giai | TextBox | dien_giai | Dien giai |
| cboNgoai_te | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtty_gia | AsTextNumeric | ty_gia | Ty gia |
| txtTien_hang_nt | AsTextNumeric | tien_hang_nt | Tien hang NT |
| txtTien_hang | AsTextNumeric | tien_hang | Tien hang |
| txtTien_thue_nt | AsTextNumeric | tien_thue_nt | Tien thue NT |
| txtTien_thue | AsTextNumeric | tien_thue | Tien thue |
| txtTong_tt_nt | AsTextNumeric | tong_tt_nt | Tong TT NT |
| txtTong_tt | AsTextNumeric | tong_tt | Tong TT |
| txtTien_tt_nt | AsTextNumeric | tien_tt_nt | Da thanh toan NT |
| txtTien_tt | AsTextNumeric | tien_tt | Da thanh toan |
| txtDu_hd_nt | AsTextNumeric | du_hd_nt | Con phai tra NT |
| txtDu_hd | AsTextNumeric | du_hd | Con phai tra |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AP_APTT_GET | Lay danh sach so du dau ky |
| SP_AP_APTT_GETBYID | Lay chi tiet 1 so du |
| SP_AP_APTT_INSERT | Them so du dau ky |
| SP_AP_APTT_UPDATE | Cap nhat so du |
| SP_AP_APTT_DELETE | Xoa so du |
| SP_AP_APTT_FIND | Tim kiem so du |
| SP_AP_APTT_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach so du dau ky
EXEC SP_AP_APTT_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
-- Them so du dau ky
EXEC SP_AP_APTT_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(50),
    @pMa_ncc VARCHAR(50),
    @pTk_pt VARCHAR(20),
    @pMa_tt_po VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pSo_ct VARCHAR(50),
    @pNgay_ct DATETIME,
    @pHan_ck INT = 0,
    @pHan_tt INT = 0,
    @pTl_ck DECIMAL(18,4) = 0,
    @pLs_qh DECIMAL(18,4) = 0,
    @pMa_nt VARCHAR(10) = 'VND',
    @pTy_gia DECIMAL(18,4) = 1,
    @pTien_hang DECIMAL(18,2) = 0,
    @pTien_thue DECIMAL(18,2) = 0,
    @pDien_giai NVARCHAR(500) = NULL,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ncc | 'Ma nha cung cap khong duoc trong' |
| Required | tk_pt | 'TK phai tra khong duoc trong' |
| Required | so_ct | 'So chung tu khong duoc trong' |
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Positive | tong_tt | 'Tong thanh toan phai lon hon 0' |

### Business Rules

1. **Tinh toan tu dong**:
   - Tong thanh toan = Tien hang + Tien thue
   - Du HD = Tong TT - Da thanh toan
   - Chuyen doi NT sang VND theo ty gia

2. **Lai suat qua han**:
   - Tinh theo so ngay qua han
   - Ap dung khi qua han thanh toan

3. **Chiet khau**:
   - Tinh theo ty le va thoi han
   - Ap dung truoc han

4. **Kiem tra ngay**:
   - Ngay khong duoc truoc ngay khoa so

---

## Mapping PHP

### 1. Model

```php
// app/Models/AP/APTT.php
namespace Diepxuan\Simba\Models\AP;

class APTT extends Model
{
    protected $table = 'APTT';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec',
        'ma_cty',
        'ma_ncc',
        'tk_pt',
        'ma_tt_po',
        'ma_hd',
        'so_ct',
        'ngay_ct',
        'han_ck',
        'han_tt',
        'tl_ck',
        'ls_qh',
        'ma_nt',
        'ty_gia',
        'tien_hang',
        'tien_thue',
        'tong_tt',
        'tien_tt',
        'du_hd',
        'dien_giai',
        'ksd',
    ];

    protected $casts = [
        'han_ck' => 'integer',
        'han_tt' => 'integer',
        'tl_ck' => 'decimal:4',
        'ls_qh' => 'decimal:4',
        'ty_gia' => 'decimal:4',
        'tong_tt' => 'decimal:2',
        'du_hd' => 'decimal:2',
        'ksd' => 'boolean',
    ];

    // Relationships
    public function nhaCungCap()
    {
        return $this->belongsTo(DMNCC::class, 'ma_ncc', 'ma_ncc');
    }

    public function hopDong()
    {
        return $this->belongsTo(DMHD::class, 'ma_hd', 'ma_hd');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeUnpaid($query)
    {
        return $query->whereColumn('du_hd', '>', 0);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPGetAPTT.php
namespace Diepxuan\Simba\StoredProcedures;

class AsAPGetAPTT extends StoredProcedure
{
    protected $procedure = 'SP_AP_APTT_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsAPInsAPTT.php
class AsAPInsAPTT extends StoredProcedure
{
    protected $procedure = 'SP_AP_APTT_INSERT';
    protected $params = [
        'pMa_cty', 'pStt_rec', 'ma_ncc', 'tk_pt', 'ma_tt_po',
        'ma_hd', 'so_ct', 'ngay_ct', 'han_ck', 'han_tt',
        'tl_ck', 'ls_qh', 'ma_nt', 'ty_gia', 'tien_hang',
        'tien_thue', 'dien_giai',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsAPUpdAPTT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPDelAPTT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPChkAPTT.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AP/Danhmuc/Dieukhoanthanhtoan.php
namespace Diepxuan\Catalog\Http\Livewire\AP\Danhmuc;

class Dieukhoanthanhtoan extends Component
{
    const MA_CT = 'AP';

    public Collection $pDanhSach;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadDanhSach();
    }

    public function loadDanhSach(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::ap.danhmuc.dieukhoanthanhtoan');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AP/Danhmuc/DieukhoanthanhtoanEdit.php
namespace Diepxuan\Catalog\Http\Livewire\AP\Danhmuc;

class DieukhoanthanhtoanEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pMaNcc = '';
    public string $pTkPt = '';
    public string $pMaTtPo = '';
    public string $pMaHd = '';
    public string $pSoCt = '';
    public ?Carbon $pNgayCt = null;
    public int $pHanCk = 0;
    public int $pHanTt = 0;
    public float $pTlCk = 0;
    public float $pLsQh = 0;
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public float $pTienHangNt = 0;
    public float $pTienHang = 0;
    public float $pTienThueNt = 0;
    public float $pTienThue = 0;
    public bool $pKsd = false;

    protected $rules = [
        'pMaNcc' => 'required|string|max:50',
        'pTkPt' => 'required|string|max:20',
        'pSoCt' => 'required|string|max:50',
        'pNgayCt' => 'required|date',
    ];

    public function tinhTongTT(): void
    {
        $this->pTongTtNt = $this->pTienHangNt + $this->pTienThueNt;
        $this->pTongTt = $this->pTienHang + $this->pTienThue;
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::ap.danhmuc.dieukhoanthanhtoan-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/ap/danhmuc/
├── dieukhoanthanhtoan.blade.php        (List page)
├── dieukhoanthanhtoan-edit.blade.php   (Modal edit)
└── _dieukhoanthanhtoan-row.blade.php    (Component row)
```

### 6. Routes

```php
Route::prefix('catalog/ap/danhmuc')
    ->name('catalog.ap.danhmuc.')
    ->group(function () {
        Route::get('/dieu-khoan-thanh-toan', [Dieukhoanthanhtoan::class, 'render'])
            ->name('dieukhoanthanhtoan');
        Route::get('/dieu-khoan-thanh-toan/edit/{sttRec?}', [DieukhoanthanhtoanEdit::class, 'render'])
            ->name('dieukhoanthanhtoan.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | APTT.php | Chinh |
| Model | laravel-simba | DMNCC.php | Lien quan (FK) |
| Model | laravel-simba | DMHD.php | Lien quan (FK) |
| SP | laravel-simba | AsAPGetAPTT.php | Chinh |
| SP | laravel-simba | AsAPInsAPTT.php | Insert |
| SP | laravel-simba | AsAPUpdAPTT.php | Update |
| SP | laravel-simba | AsAPDelAPTT.php | Delete |
| Component | laravel-catalog | Dieukhoanthanhtoan.php | List |
| Component | laravel-catalog | DieukhoanthanhtoanEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model APTT
- [ ] Tao Livewire Dieukhoanthanhtoan (list)
- [ ] Tao Livewire DieukhoanthanhtoanEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMNCC, DMHD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.018`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
