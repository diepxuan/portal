# Task 230: INRptBKX04

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bang ke phieu xuat tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptBKX04.dll
- **Chuc nang:** Bang ke phieu xuat
- **Loai:** Bao cao (Report)
- **Assembly Title:** Bang ke phieu xuat
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Công ty phần mềm Asia
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptBKX04.dll/README.md`

---

## Form classes

### frmINRptBKX04 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao bang ke phieu xuat

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_kho | AsTextBox | MA_KHO | Ma kho |
| txtMa_vt | AsTextBox | MA_VT | Ma vat tu |
| txtMa_nhvt | AsTextBox | MA_NHVT | Ma nhom vat tu |
| txtMa_kh | AsTextBox | MA_KH | Ma khach hang |
| txtMa_BP | AsTextBox | MA_BP | Ma bo phan |
| txtMa_hd | AsTextBox | MA_HD | Ma hop dong |
| txtMa_Phi | AsTextBox | MA_PHI | Ma phi |
| txtMa_SPCT | AsTextBox | MA_SPCT | Ma san pham chi tiet |
| txtMa_lo | AsTextBox | MA_LO | Ma lo |
| txtTK | AsTextBox | TK | Tai khoan |
| txtTK_DU | AsTextBox | TK | TK doi ung |
| txtSo_ct1 | TextBox | - | So chung tu tu |
| txtSo_ct2 | TextBox | - | So chung tu den |
| cboNhom_theo | AsComboBox | - | Nhom theo |
| cboTheo_DVT | AsComboBox | - | Theo don vi tinh |
| cboLoai_phieu | AsComboBox | - | Loai phieu |
| cboLoai_gd | ComboBox | - | Loai giao dich |
| crvReportViewer | CrystalReportViewer | - | Xem bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_BKX04_GET | Lay du lieu bao cao bang ke phieu xuat |

---

## Business Logic

### Business Rules

1. **Loc du lieu**: Theo khoang ngay va nhieu tieu chi loc
2. **Nhom theo**: Theo kho, nhom VT, KH, bo phan, hop dong, phi, SPCT, lo, TK
3. **Don vi tinh**: Kho, mua, ban
4. **Loai phieu xuat**: Loc theo ma_gd

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/BangKePhieuXuat.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class BangKePhieuXuat extends Component
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
    public string $pMa_Tk = '';
    public string $pMa_Tkdu = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public int $pNhom_theo = 0;
    public int $pTheo_dvt = 0;
    public string $pLoai_phieu = '';
    public string $pLoai_gd = '';

    public function render(): View
    {
        return view('catalog::in.baocao.bang-ke-phieu-xuat');
    }
}
```

### 2. Views

```
resources/views/catalog/in/baocao/
├── bang-ke-phieu-xuat.blade.php      (Filter form)
└── bang-ke-phieu-xuat-report.blade.php (Report viewer)
```

### 3. Routes

```php
Route::prefix('catalog/in/baocao')
    ->name('catalog.in.baocao.')
    ->group(function () {
        Route::get('/bang-ke-phieu-xuat', [BangKePhieuXuat::class, 'render'])
            ->name('bang-ke-phieu-xuat');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | BangKePhieuXuat.php | Filter form |
| SP | laravel-simba | AsINRptBKX04.php | Data source |
| View | laravel-catalog | bang-ke-phieu-xuat.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire BangKePhieuXuat (filter form)
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test multi-filter combinations