# Task 020: ApVchAP4

## Nhom: AP (Accounts Payable - Cong no phai tra)

## Muc tieu
Chuyen doi chuc nang nhap chung tu bu tru cong no phai tra tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** ApVchAP4.dll
- **Chuc nang:** Nhap chung tu bu tru cong no phai tra - bu tru cong no giua cac tai khoan
- **Loai:** Voucher
- **Assembly Title:** Bù trừ công nợ phải trả
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AP4

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ApVchAP4.dll/README.md`

---

## Cau truc du lieu

### Bang: AP4PH (Chung tu bu tru header)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | So thu tu record |
| ma_cty | varchar | 50 | Ma cong ty |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |
| ngay_lct | datetime | 8 | Ngay lap chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 50 | So chung tu |
| t_tien | decimal | 18,2 | Tong tien VND |
| t_tien_nt | decimal | 18,2 | Tong tien NT |
| nt_pq | bit | 1 | Ngoai te phan quy (0/1) |
| chi_ke | bit | 1 | Chi ke, khong hach toan |
| dien_giai | nvarchar | 500 | Dien giai |

### Bang: AP4CT (Chung tu bu tru chi tiet)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | So thu tu header |
| stt_rec0 | varchar | 50 | So thu tu chi tiet |
| tk | varchar | 20 | Tai khoan |
| ma_kh | varchar | 50 | Ma khach hang |
| ps_no_nt | decimal | 18,2 | Phat sinh no NT |
| ps_co_nt | decimal | 18,2 | Phat sinh co NT |
| ps_no | decimal | 18,2 | Phat sinh no VND |
| ps_co | decimal | 18,2 | Phat sinh co VND |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_bp | varchar | 50 | Ma bo phan |
| ma_phi | varchar | 50 | Ma phi |
| ma_hd | varchar | 50 | Ma hop dong |
| ma_spct | varchar | 50 | Ma san pham CT |
| nh_dk | varchar | 50 | Nhom dinh khoan |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk |
| DMKH | Danh muc khach hang | FK ma_kh |
| DMBP | Danh muc bo phan | FK ma_bp |
| DMHD | Danh muc hop dong | FK ma_hd |

---

## Form classes

### 1. frmApVchAP4 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap, sua, xoa chung tu bu tru
- **Controls - Header:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtNgay_lct | AsMaskedTextBox | ngay_lct | Ngay lap CT |
| txtNgay_Ct | AsMaskedTextBox | ngay_ct | Ngay CT |
| txtSo_Ct | TextBox | so_ct | So CT |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| txtT_Tien | AsTextNumeric | t_tien | Tong tien VND |
| txtT_tien_Nt | AsTextNumeric | t_tien_nt | Tong tien NT |
| chkNt_Ph | AsCheckBox | nt_pq | Ngoai te chung |
| AsCheckBox2 | AsCheckBox | chi_ke | Chi ke, khong hach toan |

- **Controls - Detail Grid:**

| Column | Type | DataField | Mo ta |
|--------|------|-----------|-------|
| dgvcTk | DataGridViewAsTextBoxColumn | tk | Tai khoan |
| dgvcTen_tk | DataGridViewTextBoxColumn | ten_tk | Ten tai khoan |
| dgvcMa_kh | DataGridViewAsTextBoxColumn | ma_kh | Ma NCC |
| dgvcMa_nt | DataGridViewComboBoxColumn | ma_nt | Ma ngoai te |
| dgvcTy_gia | DataGridViewAsTextNumericColumn | ty_gia | Ty gia |
| dgvcPs_no_nt | DataGridViewAsTextNumericColumn | ps_no_nt | PS no NT |
| dgvcPs_co_nt | DataGridViewAsTextNumericColumn | ps_co_nt | PS co NT |
| dgvcPs_no | DataGridViewAsTextNumericColumn | ps_no | PS no VND |
| dgvcPs_co | DataGridViewAsTextNumericColumn | ps_co | PS co VND |
| dgvcDien_giai | DataGridViewTextBoxColumn | dien_giai | Dien giai |
| dgvcMa_bp | DataGridViewAsTextBoxColumn | ma_bp | Ma bo phan |
| dgvcMa_phi | DataGridViewAsTextBoxColumn | ma_phi | Ma phi |
| dgvcMa_hd | DataGridViewAsTextBoxColumn | ma_hd | Ma hop dong |
| dgvcMa_spct | DataGridViewAsTextBoxColumn | ma_spct | Ma SPCT |
| dgvcNh_dk | DataGridViewTextBoxColumn | nh_dk | Nhom dinh khoan |

### 2. frmApVchAP4Find (Form tim kiem)
- **Ke thua:** frmVoucherFind
- **Chuc nang:** Tim kiem chung tu theo nhieu tieu chi

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AP_AP4PH_GET | Lay danh sach chung tu |
| SP_AP_AP4PH_GETBYID | Lay chi tiet 1 chung tu |
| SP_AP_AP4PH_INSERT | Them chung tu |
| SP_AP_AP4PH_UPDATE | Cap nhat chung tu |
| SP_AP_AP4PH_DELETE | Xoa chung tu |
| SP_AP_AP4PH_FIND | Tim kiem chung tu |
| SP_AP_AP4CT_GET | Lay chi tiet chung tu |
| SP_AP_AP4CT_INSERT | Chen chi tiet |
| SP_AP_AP4CT_UPDATE | Cap nhat chi tiet |
| SP_AP_AP4CT_DELETE | Xoa chi tiet |

### SP_PH_GET (reference)

```sql
-- Lay danh sach chung tu AP4
EXEC SP_AP_AP4PH_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_CT_INSERT (reference)

```sql
-- Chen chi tiet chung tu
EXEC SP_AP_AP4CT_INSERT
    @pStt_rec VARCHAR(50),
    @pStt_rec0 VARCHAR(50),
    @pTk VARCHAR(20),
    @pMa_kh VARCHAR(50) = NULL,
    @pPs_no_nt DECIMAL(18,2) = 0,
    @pPs_co_nt DECIMAL(18,2) = 0,
    @pDien_giai NVARCHAR(500) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_phi VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL,
    @pNh_dk VARCHAR(50) = NULL,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Required | so_ct | 'So chung tu khong duoc trong' |
| Required | tk | 'Tai khoan khong duoc trong' |
| ValidAccount | tk | 'Tai khoan phai la tai khoan chi tiet' |

### Business Rules

1. **Ngoai te**:
   - Neu chkNt_Ph = true: Ap dung ty gia chung cho tat ca
   - Neu khong: Moi dong co ty gia rieng
   - Hien thi cot NT/VND tuy thuoc ma_nt

2. **Tinh toan tu dong**:
   - Tinh tong ps_no = ps_co (can dong)
   - Chuyen doi NT sang VND theo ty gia

3. **Kiem tra tai khoan**:
   - TK phai la chi tiet (chi_tiet = 1)
   - TK phai la TK cong no (tk_cn = 1)

4. **Kiem tra nhom dinh khoan**:
   - Can bang no/co theo nhóm định khoản

---

## Mapping PHP

### 1. Model

```php
// app/Models/AP/AP4PH.php
namespace Diepxuan\Simba\Models\AP;

class AP4PH extends Model
{
    protected $table = 'AP4PH';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec',
        'ma_cty',
        'ma_nt',
        'ty_gia',
        'ngay_lct',
        'ngay_ct',
        'so_ct',
        't_tien',
        't_tien_nt',
        'nt_pq',
        'chi_ke',
        'dien_giai',
    ];

    protected $casts = [
        'ty_gia' => 'decimal:4',
        't_tien' => 'decimal:2',
        't_tien_nt' => 'decimal:2',
        'nt_pq' => 'boolean',
        'chi_ke' => 'boolean',
        'ngay_lct' => 'datetime',
        'ngay_ct' => 'datetime',
    ];

    // Relationships
    public function chiTiets()
    {
        return $this->hasMany(AP4CT::class, 'stt_rec', 'stt_rec');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereNull('ngay_ps');
    }
}

// app/Models/AP/AP4CT.php
namespace Diepxuan\Simba\Models\AP;

class AP4CT extends Model
{
    protected $table = 'AP4CT';
    protected $primaryKey = ['stt_rec', 'stt_rec0'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec',
        'stt_rec0',
        'tk',
        'ma_kh',
        'ps_no_nt',
        'ps_co_nt',
        'ps_no',
        'ps_co',
        'dien_giai',
        'ma_bp',
        'ma_phi',
        'ma_hd',
        'ma_spct',
        'nh_dk',
    ];

    protected $casts = [
        'ps_no_nt' => 'decimal:2',
        'ps_co_nt' => 'decimal:2',
        'ps_no' => 'decimal:2',
        'ps_co' => 'decimal:2',
    ];

    // Relationships
    public function header()
    {
        return $this->belongsTo(AP4PH::class, 'stt_rec', 'stt_rec');
    }

    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'tk', 'tk');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPGetAP4PH.php
namespace Diepxuan\Simba\StoredProcedures;

class AsAPGetAP4PH extends StoredProcedure
{
    protected $procedure = 'SP_AP_AP4PH_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsAPInsAP4PH.php
class AsAPInsAP4PH extends StoredProcedure
{
    protected $procedure = 'SP_AP_AP4PH_INSERT';
    protected $params = [
        'pMa_cty', 'pStt_rec', 'ma_nt', 'ty_gia',
        'ngay_lct', 'ngay_ct', 'so_ct', 'nt_pq', 'chi_ke', 'dien_giai',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsAPInsAP4CT.php
class AsAPInsAP4CT extends StoredProcedure
{
    protected $procedure = 'SP_AP_AP4CT_INSERT';
    protected $params = [
        'pStt_rec', 'pStt_rec0', 'tk', 'ma_kh',
        'ps_no_nt', 'ps_co_nt', 'dien_giai',
        'ma_bp', 'ma_phi', 'ma_hd', 'ma_spct', 'nh_dk',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsAPUpdAP4PH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPDelAP4PH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPUpdAP4CT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPDelAP4CT.php
```

### 3. Livewire Component (Voucher)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AP/Voucher/ButruCongno.php
namespace Diepxuan\Catalog\Http\Livewire\AP\Voucher;

class ButruCongno extends Component
{
    const MA_CT = 'AP4';

    public ?string $pSttRec = null;
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public ?Carbon $pNgayLct = null;
    public ?Carbon $pNgayCt = null;
    public string $pSoCt = '';
    public float $pTTienNt = 0;
    public float $pTTien = 0;
    public bool $pNtPq = false;
    public bool $pChiKe = false;
    public string $pDienGiai = '';
    public Collection $pChiTiets;

    protected $rules = [
        'pNgayCt' => 'required|date',
        'pSoCt' => 'required|string|max:50',
    ];

    public function mount(?string $sttRec = null): void
    {
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadChungTu();
        } else {
            $this->pNgayLct = now();
            $this->pNgayCt = now();
        }
    }

    public function loadChungTu(): void
    {
        // Load tu Stored Procedure
    }

    public function updatedTyGia(): void
    {
        // Tinh lai ps_no, ps_co theo ty gia
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::ap.voucher.butru-congno');
    }
}
```

### 4. Views

```
resources/views/catalog/ap/voucher/
├── butru-congno.blade.php            (Form chinh)
├── butru-congno-edit.blade.php       (Modal edit)
└── _butru-congno-row.blade.php       (Component row)
```

### 5. Routes

```php
Route::prefix('catalog/ap/voucher')
    ->name('catalog.ap.voucher.')
    ->group(function () {
        Route::get('/but-ru-cong-no', [ButruCongno::class, 'render'])
            ->name('butrucongn');
        Route::get('/but-ru-cong-no/edit/{sttRec?}', [ButruCongno::class, 'render'])
            ->name('butrucongn.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | AP4PH.php | Header |
| Model | laravel-simba | AP4CT.php | Chi tiet |
| Model | laravel-simba | DMTK.php | Tai khoan |
| Model | laravel-simba | DMKH.php | Khach hang |
| SP | laravel-simba | AsAPGetAP4PH.php | Get PH |
| SP | laravel-simba | AsAPInsAP4PH.php | Insert PH |
| SP | laravel-simba | AsAPInsAP4CT.php | Insert CT |
| SP | laravel-simba | AsAPUpdAP4PH.php | Update PH |
| SP | laravel-simba | AsAPDelAP4PH.php | Delete PH/CT |
| Component | laravel-catalog | ButruCongno.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model AP4PH, AP4CT
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire ButruCongno
- [ ] Tao Views (voucher + edit)
- [ ] Them Routes
- [ ] Test CRUD voucher
- [ ] Test tinh toan NT/VND
- [ ] Test integration voi DMTK, DMKH
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
