# Task 005: ARTT

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang quan ly so du dau ky hoa don phai thu tu .NET sang PHP Laravel, dat ket qua tuong duong ARTT.

## Chi tiet
- **DLL:** ARTT.dll
- **Chuc nang:** Quan ly so du dau ky cac hoa don phai thu - thong tin han thanh toan, ti le chiet khau, lai suat qua han
- **Loai:** So du dau ky (OB)
- **Assembly Title:** ARTT
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIA
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARTT.dll/README.md`

---

## Cau truc du lieu

### Bang: ARTT (So du dau ky hoa don phai thu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_kh | varchar | 50 | Ma khach hang (khoa ngoai) |
| tk_pt | varchar | 50 | Tai khoan phai thu |
| ma_hd | varchar | 50 | Ma hop dong |
| ma_tt | varchar | 50 | Ma dieu khoan thanh toan |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 50 | So chung tu |
| tien_hang_nt | numeric | 18,2 | Tien hang ngoai te |
| tien_thue_nt | numeric | 18,2 | Tien thue ngoai te |
| tong_tt_nt | numeric | 18,2 | Tong thanh toan NT |
| tien_tt_nt | numeric | 18,2 | Da thanh toan NT |
| du_hd_nt | numeric | 18,2 | Con phai thu NT |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | numeric | 18,4 | Ty gia |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh -> DMKH.ma_kh |
| ARDTK | Dieu khoan thanh toan | FK ma_tt -> ARDTK.ma_tt |

---

## Form classes

### 1. frmARTT (Form xem danh sach)
- **Ke thua:** frmOBView
- **Chuc nang:** Hien thi danh sach so du dau ky, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvOB | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma/ten |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmARTTEdit (Form them/sua)
- **Ke thua:** frmOBEdit
- **Chuc nang:** Nhap, sua thong tin so du dau ky
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_kh | AsTextBox | ma_kh | Ma khach hang (AutoLookup) |
| txtTK_pt | AsTextBox | tk_pt | TK phai thu (AutoLookup) |
| txtMa_hd | AsTextBox | ma_hd | Ma hop dong (AutoLookup) |
| txtMa_tt | AsTextBox | ma_tt | Ma thanh toan (AutoLookup) |
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay chung tu |
| txtSo_ct | TextBox | so_ct | So chung tu |
| txtTien_hang_nt | AsTextNumeric | tien_hang_nt | Tien hang NT |
| txtTien_thue_nt | AsTextNumeric | tien_thue_nt | Tien thue NT |
| txtTong_tt_nt | AsTextNumeric | tong_tt_nt | Tong thanh toan NT |
| txtTien_tt_nt | AsTextNumeric | tien_tt_nt | Da thanh toan NT |
| txtDu_hd_nt | AsTextNumeric | du_hd_nt | Con phai thu NT |
| cboNgoai_te | AsComboBoxNT | ma_nt | Ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_TT_GET | Lay danh sach so du dau ky |
| SP_AR_TT_GETBYID | Lay chi tiet 1 so du |
| SP_AR_TT_INSERT | Them so du dau ky moi |
| SP_AR_TT_UPDATE | Cap nhat so du dau ky |
| SP_AR_TT_DELETE | Xoa so du dau ky |
| SP_AR_TT_FIND | Tim kiem so du dau ky |
| SP_AR_TT_CHECK | Kiem tra rang buoc |

### SP_GET (reference)

```sql
-- Lay danh sach so du dau ky
EXEC SP_AR_TT_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
-- Lay chi tiet 1 so du dau ky
EXEC SP_AR_TT_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50),
    @pMa_hd VARCHAR(50) = NULL
```

### SP_INSERT (reference)

```sql
-- Them so du dau ky moi
EXEC SP_AR_TT_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_kh VARCHAR(50),
    @pTK_pt VARCHAR(50),
    @pMa_hd VARCHAR(50),
    @pMa_tt VARCHAR(50),
    @pNgay_ct DATETIME,
    @pSo_ct VARCHAR(50),
    @pTien_hang_nt DECIMAL(18,2),
    @pTien_thue_nt DECIMAL(18,2),
    @pTien_tt_nt DECIMAL(18,2),
    @pMa_nt VARCHAR(10) = 'VND',
    @pTy_gia DECIMAL(18,4) = 1,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Required | tk_pt | 'Tai khoan phai thu khong duoc trong' |
| Valid customer | ma_kh | 'Ma khach hang khong ton tai' |
| Valid account | tk_pt | 'Tai khoan khong hop le hoac khong phai tai khoan cong no' |
| Non-negative | tien_hang_nt | 'Tien hang phai lon hon hoac bang 0' |
| Non-negative | tien_thue_nt | 'Tien thue phai lon hon hoac bang 0' |
| Non-negative | tien_tt_nt | 'Da thanh toan phai lon hon hoac bang 0' |

### Business Rules

1. **Tinh toan tu dong**:
   - Tong thanh toan NT = Tien hang NT + Tien thue NT
   - Con phai thu NT = Tong thanh toan NT - Da thanh toan NT

2. **Chon ma_tt tu dong**:
   - Khi chon ma_tt, tu dong lay:
     - han_tt (han thanh toan)
     - han_ck (han chiet khau)
     - tl_ck (ti le chiet khau)
     - ls_qh (lai suat qua han)

3. **Tinh ngay thanh toan**:
   - ngay_tt = ngay_ct + han_tt (so ngay)

4. **Doi ngoai te**:
   - VND = NT x Ty gia
   - Ty gia mac dinh = 1 (neu VND)

5. **Kiem tra khoa so**:
   - Khong cho phep nhap truoc ngay khoa so

### Lookup Integration

- Tu dong goi y khi nhap ma_kh
- Hien thi thong tin khach hang (ten_kh, dia_chi)
- Kiem tra trang thai khach hang (ksd)

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/ARTT.php
namespace Diepxuan\Simba\Models\AR;

class ARTT extends Model
{
    protected $table = 'ARTT';
    protected $primaryKey = ['ma_kh', 'ma_hd']; // Composite key
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_kh',
        'tk_pt',
        'ma_hd',
        'ma_tt',
        'ngay_ct',
        'so_ct',
        'tien_hang_nt',
        'tien_thue_nt',
        'tong_tt_nt',
        'tien_tt_nt',
        'du_hd_nt',
        'ma_nt',
        'ty_gia',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'tien_hang_nt' => 'decimal:2',
        'tien_thue_nt' => 'decimal:2',
        'tong_tt_nt' => 'decimal:2',
        'tien_tt_nt' => 'decimal:2',
        'du_hd_nt' => 'decimal:2',
        'ty_gia' => 'decimal:4',
    ];

    // Computed attribute
    public function getTongTtVndAttribute()
    {
        return ($this->tien_hang_nt + $this->tien_thue_nt) * $this->ty_gia;
    }

    public function getDuHdVndAttribute()
    {
        return $this->du_hd_nt * $this->ty_gia;
    }

    // Relationships
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function dieuKhoanTT()
    {
        return $this->belongsTo(ARDTK::class, 'ma_tt', 'ma_tt');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetTT.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetTT extends StoredProcedure
{
    protected $procedure = 'SP_AR_TT_GET';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pSearch',
        'pPageIndex',
        'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARInsTT.php
class AsARInsTT extends StoredProcedure
{
    protected $procedure = 'SP_AR_TT_INSERT';
    protected $params = [
        'pMa_cty',
        'ma_kh',
        'tk_pt',
        'ma_hd',
        'ma_tt',
        'ngay_ct',
        'so_ct',
        'tien_hang_nt',
        'tien_thue_nt',
        'tien_tt_nt',
        'ma_nt',
        'ty_gia',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARUpdTT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARDelTT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARCHkTT.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Sodudaukhoi/ARTT.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Sodudaukhoi;

class ARTT extends Component
{
    const MA_CT = 'AR';

    public Collection $pList;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaKh = null;

    public function loadList(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::ar.sodudaukhoi.artt');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Sodudaukhoi/ARTTEdit.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Sodudaukhoi;

class ARTTEdit extends Component
{
    public ?string $pMaKh = null;
    public ?string $pTK_pt = null;
    public ?string $pMaHd = null;
    public ?string $pMaTt = null;
    public ?Carbon $pNgayCt = null;
    public string $pSoCt = '';
    public float $pTienHangNt = 0;
    public float $pTienThueNt = 0;
    public float $pTienTtNt = 0;
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;

    // Computed
    public float getTongTtNtAttribute(): float
    {
        return $this->pTienHangNt + $this->pTienThueNt;
    }

    public float getDuHdNtAttribute(): float
    {
        return $this->getTongTtNtAttribute() - $this->pTienTtNt;
    }

    public float getTongTtVndAttribute(): float
    {
        return $this->getTongTtNtAttribute() * $this->pTyGia;
    }

    protected $rules = [
        'pMaKh' => 'required|string|max:50',
        'pTK_pt' => 'required|string|max:50',
        'pTienHangNt' => 'required|numeric|min:0',
        'pTienThueNt' => 'nullable|numeric|min:0',
        'pTienTtNt' => 'nullable|numeric|min:0',
        'pMaNt' => 'required|string|max:10',
        'pTyGia' => 'required|numeric|min:0',
    ];

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::ar.sodudaukhoi.artt-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/ar/sodudaukhoi/
├── artt.blade.php           (List page)
├── artt-edit.blade.php     (Modal edit)
└── _artt-row.blade.php     (Component row)
```

### 6. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/sodudaukhoi')
    ->name('catalog.ar.sodudaukhoi.')
    ->group(function () {
        Route::get('/dieu-khoan-thanh-toan', [ARTT::class, 'render'])
            ->name('artt');
        Route::get('/dieu-khoan-thanh-toan/edit/{maKh?}', [ARTTEdit::class, 'render'])
            ->name('artt.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ARTT.php | Chinh |
| Model | laravel-simba | DMKH.php | Lookup KH |
| Model | laravel-simba | ARDTK.php | Lookup DTK |
| SP | laravel-simba | AsARGetTT.php | Lay danh sach |
| SP | laravel-simba | AsARInsTT.php | Insert |
| SP | laravel-simba | AsARUpdTT.php | Update |
| SP | laravel-simba | AsARDelTT.php | Delete |
| SP | laravel-simba | AsARCHkTT.php | Check rang buoc |
| Component | laravel-catalog | ARTT.php | List |
| Component | laravel-catalog | ARTTEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model ARTT
- [ ] Tao Livewire ARTT (list)
- [ ] Tao Livewire ARTTEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Implement tinh toan tu dong (tong_tt_nt, du_hd_nt)
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.005`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
