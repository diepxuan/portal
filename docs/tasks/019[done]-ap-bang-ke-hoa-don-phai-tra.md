# Task 019: APRptBK

## Nhom: AP (Accounts Payable - Cong no phai tra)

## Muc tieu
Chuyen doi chuc nang bao cao bang ke hoa don phai tra tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** APRptBK01.dll, APRptBK02.dll, APRptBK03.dll
- **Chuc nang:** Bang ke chi tiet cac hoa don phai tra theo nhieu tieu chi loc
- **Loai:** Report (RPT)
- **Assembly Title:** Bảng kê hóa đơn phải trả
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/APRptBK01.dll/README.md`

---

## Cau truc du lieu

### Bang: AP (Hoa don phai tra)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | So thu tu record |
| ma_kh | varchar | 50 | Ma nha cung cap |
| so_ct | varchar | 50 | So hoa don |
| ngay_ct | datetime | 8 | Ngay hoa don |
| tk_pt | varchar | 20 | TK phai tra |
| ma_nt | varchar | 10 | Ma ngoai te |
| t_tien | decimal | 18,2 | Tong tien |
| t_thue | decimal | 18,2 | Tien thue |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| DMVT | Danh muc vat tu | Lookup ma_vt |
| DMNhVT | Nhom vat tu | Lookup ma_nhvt |
| DMKHO | Danh muc kho | Lookup ma_kho |
| DMBP | Bo phan | Lookup ma_bp |
| DMHD | Hop dong | Lookup ma_hd |

---

## Form classes

### 1. APRptBK01 - Bang ke hoa don phai tra

**Kế thừa:** frmReport

**Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma nha cung cap |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Nhom vat tu |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_Bp | AsTextBox | Ma bo phan |
| txtMa_Hd | AsTextBox | Ma hop dong |
| txtMa_plkh1 | AsTextBox | Phan loai KH 1 |
| txtMa_plkh2 | AsTextBox | Phan loai KH 2 |
| txtMa_plkh3 | AsTextBox | Phan loai KH 3 |
| txtSo_PX | AsTextBox | So phieu nhap |
| txtSo_Ct1 | TextBox | So chung tu tu |
| txtSo_Ct2 | TextBox | So chung tu den |
| txtMa_lo | AsTextBox | Ma lo |
| txtMa_phi | AsTextBox | Ma phi |
| txtma_spct | AsTextBox | Ma SPCT |

### 2. APRptBK02 - Bang ke theo han thanh toan

**Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay_Ss | AsMaskedTextBox | Ngay so sanh |
| txtHan_ky1 | AsTextNumeric | Han ky 1 |
| txtHan_ky2 | AsTextNumeric | Han ky 2 |
| txtHan_ky3 | AsTextNumeric | Han ky 3 |
| txtMa_Kh | AsTextBox | Ma NCC |
| txtMa_NhKh | AsTextBox | Nhom NCC |

### 3. APRptBK03 - Bang ke phieu chi thanh toan

**Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboGiao_dich | ComboBox | Loai giao dich (hoa don/don hang) |
| cboChi_xem | ComboBox | Chi xem (tat toan/chua/tat ca) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AP_RPTBK01_GET | Lay du lieu bang ke hoa don |
| SP_AP_RPTBK02_GET | Lay du lieu bang ke theo han |
| SP_AP_RPTBK03_GET | Lay du lieu bang ke phieu chi |

### SP_RPTBK01_GET (reference)

```sql
-- Lay du lieu bang ke hoa don phai tra
EXEC SP_AP_RPTBK01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nhvt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND',
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ngay1, ngay2 | 'Khoang thoi gian khong hop le' |

### Business Rules

1. **Loc du lieu**:
   - Loc theo nhieu tieu chi cung luc
   - Neu khong nhap -> lay tat ca

2. **Tinh toan**:
   - Tinh so luong, don gia, thanh tien
   - Tinh tong cong theo nhom

3. **Hien thi bao cao**:
   - Tong hop theo nhom KH, VT, kho
   - Chi tiet tung hoa don

---

## Mapping PHP

### 1. Model

```php
// app/Models/AP/APRptBK.php
namespace Diepxuan\Simba\Models\AP;

class APRptBK extends Model
{
    protected $table = 'APTT'; // Lien ket voi bang APTT
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    // Khong co fillable vi chi doc
    protected $casts = [
        't_tien' => 'decimal:2',
        't_thue' => 'decimal:2',
        'ngay_ct' => 'datetime',
    ];
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPGetRptBK01.php
namespace Diepxuan\Simba\StoredProcedures;

class AsAPGetRptBK01 extends StoredProcedure
{
    protected $procedure = 'SP_AP_RPTBK01_GET';
    protected $params = [
        'pMa_cty', 'pMa_kh', 'pMa_vt', 'pMa_nhvt',
        'pMa_kho', 'pMa_bp', 'pMa_hd', 'pSo_ct1',
        'pSo_ct2', 'pMa_nt', 'pNgay1', 'pNgay2',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsAPGetRptBK02.php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPGetRptBK03.php
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AP/Baocao/Bangkhoadon.php
namespace Diepxuan\Catalog\Http\Livewire\AP\Baocao;

class Bangkhoadon extends Component
{
    const MA_CT = 'AP';

    public ?string $pMaKh = null;
    public ?string $pMaVt = null;
    public ?string $pMaNhvt = null;
    public ?string $pMaKho = null;
    public ?string $pMaBp = null;
    public ?string $pMaHd = null;
    public ?string $pSoCt1 = null;
    public ?string $pSoCt2 = null;
    public string $pMaNt = 'VND';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public Collection $pDuLieu;

    protected $rules = [
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date|after_or_equal:pNgay1',
    ];

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
    }

    public function loadData(): void
    {
        $this->validate();
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::ap.baocao.bangkhoadon');
    }
}
```

### 4. Views

```
resources/views/catalog/ap/baocao/
├── bangkhoadon.blade.php            (Form loc & hien thi)
└── _bangkhoadon-row.blade.php       (Component row)
```

### 5. Routes

```php
Route::prefix('catalog/ap/bao-cao')
    ->name('catalog.ap.baocao.')
    ->group(function () {
        Route::get('/bang-ke-hoa-don', [Bangkhoadon::class, 'render'])
            ->name('bangkehoadon');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | APRptBK.php | Chinh (read-only) |
| Model | laravel-simba | APTT.php | Lien quan |
| SP | laravel-simba | AsAPGetRptBK01.php | BK01 |
| SP | laravel-simba | AsAPGetRptBK02.php | BK02 |
| SP | laravel-simba | AsAPGetRptBK03.php | BK03 |
| Component | laravel-catalog | Bangkhoadon.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model APRptBK (read-only)
- [ ] Tao Livewire Bangkhoadon
- [ ] Tao Views (form + report)
- [ ] Them Routes
- [ ] Test lay du lieu
- [ ] Test loc nhieu tieu chi
- [ ] Test in bao cao
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
\n## Portal implementation status\n\n- **Status:** DONE (route shell exists)\n- **Note:** Shell/route đã map, chưa execute SP ngoài scope nếu chưa đủ payload/side effect.\n
