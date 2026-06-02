# Task 234: INRptTHX02

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang tong hop hang xuat kho tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptTHX02.dll
- **Chuc nang:** Tong hop hang xuat kho
- **Loai:** Bao cao (Report)
- **Assembly Title:** Tong hop hang xuat kho
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Công ty phần mềm Asia
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptTHX02.dll/README.md`

---

## Form classes

### frmINRptTHX02 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao tong hop xuat kho

### Filter Controls (nhieu tieu chi)

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Ma nhom vat tu |
| txtMa_Kh | AsTextBox | Ma khach hang |
| txtMa_nhkh | AsTextBox | Ma nhom khach hang |
| txtMa_kho_xuat | AsTextBox | Ma kho xuat |
| txtKho_nhap | AsTextBox | Ma kho nhap (chuyen kho) |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtTk_vt | AsTextBox | TK vat tu |
| txtTk_Du | AsTextBox | TK doi ung |
| txtMa_NX | AsTextBox | Ma dang NX |
| txtMa_Bp | AsTextBox | Ma bo phan |
| txtMa_Hd | AsTextBox | Ma hop dong |
| txtMa_spct | AsTextBox | Ma san pham chi tiet |
| txtMa_Phi | AsTextBox | Ma phi |
| txtMa_lo | AsTextBox | Ma lo |
| txtSo_Ct1 | TextBox | So chung tu tu |
| txtSo_Ct2 | TextBox | So chung tu den |
| cboNhom | ComboBox | Nhom |
| cboChi_tiet | ComboBox | Chi tiet |
| cboLoai_px | ComboBox | Loai phieu xuat |
| cboLoai_gd | ComboBox | Loai giao dich |
| cboDVT | ComboBox | Don vi tinh |
| ChkTinh_Ps | AsCheckBox | Tinh phat sinh |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_THX02_GET | Lay du lieu bao cao tong hop xuat kho |

---

## Business Logic

### Business Rules

1. **Tong hop xuat kho**:
   - Nhom va tong hop theo nhieu tieu chi
   - Chi tiet hoa theo nhieu cap

2. **Kho xuat/nhap**:
   - Theo doi kho xuat va kho nhap (chuyen kho)

3. **Nhom KH**:
   - Theo doi theo nhom khach hang

4. **Tinh phat sinh**:
   - Tuy chon tinh phat sinh

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/TongHopXuatKho.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class TongHopXuatKho extends Component
{
    const MA_CT = 'IN';

    public string $pMa_Vt = '';
    public string $pMa_Nhvt = '';
    public string $pMa_Kh = '';
    public string $pMa_nhkh = '';
    public string $pMa_kho_xuat = '';
    public string $pKho_nhap = '';
    public string $pMa_Vitri = '';
    public string $pTk_vt = '';
    public string $pTk_Du = '';
    public string $pMa_Nx = '';
    public string $pMa_Bp = '';
    public string $pMa_Hd = '';
    public string $pMa_spct = '';
    public string $pMa_Phi = '';
    public string $pMa_lo = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public int $pNhom = 0;
    public int $pChi_tiet = 0;
    public string $pLoai_px = '';
    public string $pLoai_gd = '';
    public int $pDvt = 0;
    public bool $pTinh_ps = false;

    public function render(): View
    {
        return view('catalog::in.baocao.tong-hop-xuat-kho');
    }
}
```

### 2. Views

```
resources/views/catalog/in/baocao/
├── tong-hop-xuat-kho.blade.php
└── tong-hop-xuat-kho-report.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/in/baocao')
    ->name('catalog.in.baocao.')
    ->group(function () {
        Route::get('/tong-hop-xuat-kho', [TongHopXuatKho::class, 'render'])
            ->name('tong-hop-xuat-kho');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | TongHopXuatKho.php | Filter form |
| SP | laravel-simba | AsINRptTHX02.php | Data source |
| View | laravel-catalog | tong-hop-xuat-kho.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire TongHopXuatKho (filter form)
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test nhieu tieu chi loc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
