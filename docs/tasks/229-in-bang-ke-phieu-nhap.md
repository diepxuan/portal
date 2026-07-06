# Task 229: INRptBKN04

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bang ke phieu nhap tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptBKN04.dll
- **Chuc nang:** Bang ke phieu nhap
- **Loai:** Bao cao (Report)
- **Assembly Title:** Bang ke phieu nhap
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Công ty phần mềm Asia
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptBKN04.dll/README.md`

---

## Form classes

### frmINRptBKN04 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao bang ke phieu nhap

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_kho | AsTextBox | MA_KHO | Ma kho |
| txtMa_vt | AsTextBox | MA_VT | Ma vat tu |
| txtMa_nhvt | AsTextBox | MA_NHVT | Ma nhom vat tu |
| txtMa_kh | AsTextBox | MA_KH | Ma khach hang |
| txtMa_d_nx | AsTextBox | MA_D_NX | Ma dang nhap xuat |
| txtMa_bp | AsTextBox | MA_BP | Ma bo phan |
| txtMa_hd | AsTextBox | MA_HD | Ma hop dong |
| txtMa_Phi | AsTextBox | MA_PHI | Ma phi |
| txtMa_spct | AsTextBox | MA_SPCT | Ma san pham chi tiet |
| txtMa_lo | AsTextBox | MA_LO | Ma lo |
| txtMa_vtri | AsTextBox | MA_VTRI | Ma vi tri |
| txtMa_TKVT | AsTextBox | TK | Ma TK vat tu |
| txtTK_du | AsTextBox | TK | TK doi ung |
| txtSo_Ct1 | TextBox | - | So chung tu tu |
| txtSo_Ct2 | TextBox | - | So chung tu den |
| cboTheo_nhom | ComboBox | - | Nhom theo |
| cboTheo_dvt | ComboBox | - | Theo don vi tinh |
| cboLoai_pn | ComboBox | - | Loai phieu nhap |
| cboLoai_gd | ComboBox | - | Loai giao dich |
| crvReportViewer | CrystalReportViewer | - | Xem bao cao |

### Label hien thi ten

| Label | Mo ta |
|-------|-------|
| lblTen_kho | Ten kho |
| lblTen_vt | Ten vat tu |
| lblTen_Nhvt | Ten nhom vat tu |
| lblTen_KH | Ten khach hang |
| lblTen_Ma_d_nx | Ten dang NX |
| lblTen_bp | Ten bo phan |
| lblTen_hd | Ten hop dong |
| lblTenPhi | Ten phi |
| lblTen_spct | Ten SPCT |
| lblTen_lo | Ten lo |
| lblTen_vtri | Ten vi tri |
| lblTen_TKVT | Ten TKVT |
| lblTen_TKdu | Ten TK doi ung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_BKN04_GET | Lay du lieu bao cao bang ke phieu nhap |

### SP_GET (reference)

```sql
-- Lay du lieu bang ke phieu nhap
EXEC SP_IN_RPT_BKN04_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nhvt VARCHAR(50) = NULL,
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_d_nx VARCHAR(50) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_Phi VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL,
    @pMa_lo VARCHAR(50) = NULL,
    @pMa_vtri VARCHAR(50) = NULL,
    @pMa_TKVT VARCHAR(50) = NULL,
    @pTK_du VARCHAR(50) = NULL,
    @pSo_Ct1 VARCHAR(50) = NULL,
    @pSo_Ct2 VARCHAR(50) = NULL,
    @pTheo_nhom INT = 0,
    @pTheo_dvt INT = 0,
    @pLoai_pn VARCHAR(50) = NULL,
    @pLoai_gd VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Loc du lieu**:
   - Theo khoang ngay (ngay1 - ngay2)
   - Theo nhieu tieu chi: kho, vat tu, nhom VT, KH, bo phan, hop dong, phi, SPCT, lo, vi tri, TK

2. **Nhom theo**:
   - 0: Khong nhom
   - 1: Theo kho
   - 2: Theo nhom vat tu
   - 3: Theo khach hang
   - ...

3. **Don vi tinh**:
   - Theo don vi tinh kho
   - Theo don vi tinh mua
   - Theo don vi tinh ban

4. **Loai phieu nhap**:
   - Loc theo ma_gd (loai phieu)

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-catalog/src/Services/Reports/IN/BangKePhieuNhapService.php
namespace Diepxuan\Catalog\Services\Reports\IN;

class BangKePhieuNhapService
{
    public function getReportData(array $filters): array
    {
        // Goi SP lay du lieu
        // Tra ve data cho report
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/BangKePhieuNhap.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class BangKePhieuNhap extends Component
{
    const MA_CT = 'IN';

    public string $pMa_Kho = '';
    public string $pMa_Vt = '';
    public string $pMa_Nhvt = '';
    public string $pMa_Kh = '';
    public string $pMa_Bp = '';
    public string $pMa_Hd = '';
    public string $pMa_Phi = '';
    public string $pMa_Spct = '';
    public string $pMa_Lo = '';
    public string $pMa_Vtri = '';
    public string $pMa_Tkvt = '';
    public string $pTk_Du = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public int $pTheo_nhom = 0;
    public int $pTheo_dvt = 0;
    public string $pLoai_pn = '';
    public string $pLoai_gd = '';

    public function render(): View
    {
        return view('catalog::in.baocao.bang-ke-phieu-nhap');
    }
}
```

### 3. Views

```
resources/views/catalog/in/baocao/
├── bang-ke-phieu-nhap.blade.php      (Filter form)
└── bang-ke-phieu-nhap-report.blade.php (Report viewer)
```

### 4. Routes

```php
Route::get('/catalog/in/baocao/bang-ke-phieu-nhap', [BangKePhieuNhap::class, 'render'])
    ->name('catalog.in.baocao.bang-ke-phieu-nhap');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Report Service | laravel-catalog | BangKePhieuNhapService.php | Logic |
| Component | laravel-catalog | BangKePhieuNhap.php | Filter form |
| SP | laravel-simba | AsINRptBKN04.php | Data source |
| View | laravel-catalog | bang-ke-phieu-nhap.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Report Service
- [ ] Tao Livewire BangKePhieuNhap (filter form)
- [ ] Tao View filter form
- [ ] Integrate Crystal Reports / PDF viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test multi-filter combinations
- [ ] Test export Excel/PDF
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
