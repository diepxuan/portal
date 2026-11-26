# Task 102: INRptTHN01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop nhap 01 tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** INRptTHN01.dll
- **Chuc nang:** Bao cao tong hop nhap 01
- **Loai:** Report (Bao cao)
- **Assembly Title:** INRptTHN01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia
- **Ma_ct:** IN (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptTHN01.dll/README.md`

---

## Cau truc du lieu

### Bang: INRptTHN01 (Report - Khong co bang goc)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_cty | varchar | Ma cong ty |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | Lookup ma_vt |
| DMKHO | Danh muc kho | Lookup ma_kho |
| DMNHVT | Nhom vat tu | Lookup ma_nh_vt |

---

## Form classes

### 1. frmINRptTHN01 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao tong hop nhap kho voi nhieu tieu chi loc
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_vt | AsTextBox | Ma vat tu (loc) |
| txtMa_nh_vt | AsTextBox | Ma nhom vat tu (loc) |
| txtMa_kho | AsTextBox | Ma kho (loc) |
| txtMa_vitri | AsTextBox | Ma vi tri (loc) |
| txtTK_vt | AsTextBox | TK vat tu (loc) |
| txtTK_du | AsTextBox | TK du (loc) |
| txtMa_nx | AsTextBox | Ma dang NX (loc) |
| txtMa_bp | AsTextBox | Ma bo phan (loc) |
| txtMa_hd | AsTextBox | Ma hop dong (loc) |
| txtMa_ncc | AsTextBox | Ma nha cung cap (loc) |
| txtSo_CT1 | TextBox | So chung tu tu |
| txtSo_CT2 | TextBox | So chung tu den |
| cboLoai_pn | ComboBox | Loai phieu nhap |
| cboDVT | ComboBox | Don vi tinh |
| chkPS_dc | AsCheckBox | Hien thi phat sinh dieu chinh |
| crvReportViewer | CrystalReportViewer | Xem va in bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPTTHN01_GET | Lay du lieu bao cao tong hop nhap |

### SP_GET (reference)

```sql
-- Lay du lieu bao cao tong hop nhap 01
EXEC SP_IN_RPTTHN01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nh_vt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_vitri VARCHAR(50) = NULL,
    @pTK_vt VARCHAR(50) = NULL,
    @pTK_du VARCHAR(50) = NULL,
    @pMa_nx VARCHAR(50) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pLoai_pn INT = NULL,
    @pDVT INT = 0,
    @pPS_dc BIT = 0,
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Date range | ngay1, ngay2 | 'Ngay khong hop le' |

### Business Rules

1. **Loc nhieu tieu chi**: Ket hop nhieu tieu chi loc cung luc
2. **Lookup tu dong**: Hien thi ten khi nhap ma (txtMa_vt -> lblTen_vt)
3. **Loai phieu nhap**: Loc theo loai phieu nhap (1=thanh pham, 2=khac)
4. **Don vi tinh**: Chon DVT hien thi (0=kho, 1=mua, 2=ban)
5. **Phat sinh dieu chinh**: Hien thi hoac an phat sinh dieu chinh

---

## Mapping PHP

### 1. Model (Report - Khong co Model chinh)

```php
// Report, su dung View/Query truc tiep
```

### 2. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/Baocaotonghopnhap.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class Baocaotonghopnhap extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'THN01';

    public ?string $pMa_cty = '001';
    public ?string $pMa_vt = null;
    public ?string $pMa_nh_vt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_vitri = null;
    public ?string $pTK_vt = null;
    public ?string $pTK_du = null;
    public ?string $pMa_nx = null;
    public ?string $pMa_bp = null;
    public ?string $pMa_hd = null;
    public ?string $pMa_ncc = null;
    public ?string $pSo_ct1 = null;
    public ?string $pSo_ct2 = null;
    public ?int $pLoai_pn = null;
    public int $pDVT = 0;
    public bool $pPS_dc = false;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now()->endOfMonth();
    }

    public function render(): View
    {
        return view('catalog::in.reports.baocao-tong-hop-nhap');
    }
}
```

### 3. Views

```
resources/views/catalog/in/reports/
├── baocao-tong-hop-nhap.blade.php   (Form loc + CrystalViewer)
```

### 4. Routes

```php
Route::prefix('catalog/in/reports')
    ->name('catalog.in.reports.')
    ->group(function () {
        Route::get('/bao-cao-tong-hop-nhap', [Baocaotonghopnhap::class, 'render'])
            ->name('tong-hop-nhap');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMVT.php | Lookup vat tu |
| Model | laravel-simba | DMKHO.php | Lookup kho |
| Component | laravel-catalog | Baocaotonghopnhap.php | Report viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_RPTTHN01_GET
- [ ] Tao Livewire Baocaotonghopnhap (report viewer)
- [ ] Tao View baocao-tong-hop-nhap.blade.php
- [ ] Them Routes
- [ ] Implement Lookup controls (AutoLookup)
- [ ] Implement Crystal Report viewer integration
- [ ] Test cac tieu chi loc
- [ ] Test export Excel / Print
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE — component `In\Rpt\Inrptthn01` + route `in.rpt.inrptthn01`, verify browser 2026-11-25 (**1163 dòng dữ liệu thật**)
- **Route:** `in.rpt.inrptthn01`
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `In\Rpt\Inrptthn01` (kế thừa `Rpt\AbstractReport`)
- **View:** `in/rpt/inrptthn01.blade.php` + filter tương ứng
- **Route:** `in.rpt.inrptthn01` — **KHÔNG có suffix** (xem ghi chú bên dưới)
- **SP:** `asINRptTHN01` — 27 tham số
- **Menu:** `14.20.17` — "Tổng hợp hàng nhập"

### ⚠️ Bài học: `sysMenu.md` KHÔNG khớp DB thật về số menu cùng DLL

`simba-docs/data/sysMenu.md` ghi **3 menu** cùng DLL `INRptTHN01` (14.20.17, 18.20.17, 20.30.11)
→ suy ra route phải có suffix `142017`.

Nhưng **DB `sysMenu` thật chỉ có 1 menu active** → route **KHÔNG suffix**: `in.rpt.inrptthn01`.

**Cách đúng để biết route thật:** đọc link từ menu trái trên Portal (dữ liệu từ DB),
**không suy từ file md**.

### 🐛 Bug wrapper `AsINRptTHN01` — đã sửa

Wrapper gửi **6 tham số không tồn tại**:

| Tham số thừa | Loại |
|---|---|
| `pSysMsg1` | Tham số thông báo .NET |
| `pMa_nt` | Trùng `pMa_NT` (khác hoa thường) |
| `pMa_hd` | Trùng `pMa_Hd` |
| `ParamDefines` | Cấu hình .NET |
| `pGroup`, `pDetail` | Không có trong docs |

→ SP báo: `Procedure or function asINRptTHN01 has too many arguments specified`

**Fix:** bỏ 6 tham số, giữ đúng 27 theo `procedures.md`.

### 🎉 Verify browser thật — dữ liệu thật

| Kỳ test | Số dòng | Số cột |
|---|---:|---:|
| **2026-01-01 → 2026-12-31** | **556** | **14** |
| 2020-01-01 → 2020-12-31 | **1.163** | 14 |

| Kiểm chứng khác | Kết quả |
|---|---|
| Livewire component | ✅ `catalog::in.rpt.inrptthn01` render thật |
| Sub-component | ✅ `input-khachhang`, `input-indmvt`, `input-indmkho` |
| Tab + nút Thực hiện | ✅ có |
| Page error | **0** |

> Component 27 tham số nhưng chỉ **~120 dòng** nhờ `AbstractReport`.
