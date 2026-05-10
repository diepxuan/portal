# Task 233: INRptTHN02

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang tong hop hang nhap kho tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptTHN02.dll
- **Chuc nang:** Tong hop hang nhap kho
- **Loai:** Bao cao (Report)
- **Assembly Title:** Tong hop hang nhap kho
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Công ty phần mềm Asia
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptTHN02.dll/README.md`

---

## Form classes

### frmINRptTHN02 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao tong hop nhap kho

### Filter Controls (nhieu tieu chi)

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nh_vt | AsTextBox | Ma nhom vat tu |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtTK_vt | AsTextBox | TK vat tu |
| txtTK_du | AsTextBox | TK doi ung |
| txtMa_nx | AsTextBox | Ma dang nhap xuat |
| txtMa_bp | AsTextBox | Ma bo phan |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_ncc | AsTextBox | Ma nha cung cap |
| txtMa_nh_ncc | AsTextBox | Ma nhom NCC |
| txtPl_ncc1 | AsTextBox | Phan loai NCC 1 |
| txtPl_ncc2 | AsTextBox | Phan loai NCC 2 |
| txtPl_ncc3 | AsTextBox | Phan loai NCC 3 |
| txtMa_spct | AsTextBox | Ma san pham chi tiet |
| txtMa_Phi | AsTextBox | Ma phi |
| txtMa_lo | AsTextBox | Ma lo |
| txtSo_Ct1 | TextBox | So chung tu tu |
| txtSo_Ct2 | TextBox | So chung tu den |
| cboNhom_theo | ComboBox | Nhom theo |
| cboChitiet | ComboBox | Chi tiet |
| cboLoai_pn | ComboBox | Loai phieu nhap |
| cboLoai_gd | ComboBox | Loai giao dich |
| cboDVT | ComboBox | Don vi tinh |
| chkPS_dc | AsCheckBox | Hien thi PS dieu chinh |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_THN02_GET | Lay du lieu bao cao tong hop nhap kho |

---

## Business Logic

### Business Rules

1. **Tong hop nhap kho**:
   - Nhom va tong hop theo nhieu tieu chi
   - Chi tiet hoa theo nhieu cap

2. **Loc NCC**:
   - 3 cap phan loai NCC (pl_ncc1, pl_ncc2, pl_ncc3)
   - Nhom NCC

3. **Nhom va chi tiet**:
   - Nhom theo: Kho, nhom VT, NCC, bo phan, hop dong...
   - Chi tiet: Muc do chi tiet bao cao

4. **Phat sinh dieu chinh**:
   - Tuy chon tinh phat sinh dieu chinh

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/TongHopNhapKho.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class TongHopNhapKho extends Component
{
    const MA_CT = 'IN';

    public string $pMa_Vt = '';
    public string $pMa_Nh_vt = '';
    public string $pMa_Kho = '';
    public string $pMa_Vitri = '';
    public string $pTk_vt = '';
    public string $pTk_du = '';
    public string $pMa_nx = '';
    public string $pMa_bp = '';
    public string $pMa_hd = '';
    public string $pMa_ncc = '';
    public string $pMa_nh_ncc = '';
    public string $pPl_ncc1 = '';
    public string $pPl_ncc2 = '';
    public string $pPl_ncc3 = '';
    public string $pMa_spct = '';
    public string $pMa_Phi = '';
    public string $pMa_lo = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public int $pNhom_theo = 0;
    public int $pChitiet = 0;
    public string $pLoai_pn = '';
    public string $pLoai_gd = '';
    public int $pDvt = 0;
    public bool $pPs_dc = false;

    public function render(): View
    {
        return view('catalog::in.baocao.tong-hop-nhap-kho');
    }
}
```

### 2. Views

```
resources/views/catalog/in/baocao/
├── tong-hop-nhap-kho.blade.php
└── tong-hop-nhap-kho-report.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/in/baocao')
    ->name('catalog.in.baocao.')
    ->group(function () {
        Route::get('/tong-hop-nhap-kho', [TongHopNhapKho::class, 'render'])
            ->name('tong-hop-nhap-kho');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | TongHopNhapKho.php | Filter form |
| SP | laravel-simba | AsINRptTHN02.php | Data source |
| View | laravel-catalog | tong-hop-nhap-kho.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire TongHopNhapKho (filter form)
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test nhieu tieu chi loc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
