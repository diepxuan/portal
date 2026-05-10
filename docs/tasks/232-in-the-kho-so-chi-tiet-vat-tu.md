# Task 232: INRptCTVT02

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang the kho - so chi tiet vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptCTVT02.dll
- **Chuc nang:** The kho - So chi tiet vat tu (in tat ca)
- **Loai:** Bao cao (Report)
- **Assembly Title:** The kho-so chi tiet vat tu (in tat ca)
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Công ty phần mềm Asia
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptCTVT02.dll/README.md`

---

## Form classes

### frmINRptCTVT02 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in the kho/so chi tiet vat tu (in tat ca)

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_vt | AsTextBox | MA_VT | Ma vat tu |
| txtMa_nhvt | AsTextBox | MA_NHVT | Ma nhom vat tu |
| txtMa_tkvt | AsTextBox | TK_VT | Ma TK vat tu |
| txtMa_kho | AsTextBox | MA_KHO | Ma kho |
| txtMa_vitri | AsTextBox | MA_VTRI | Ma vi tri |
| cboDVT | ComboBox | - | Don vi tinh |
| chkPS_dc | AsCheckBox | - | Hien thi phat sinh dieu chinh |
| crvReportViewer | CrystalReportViewer | - | Xem bao cao |

### Label hien thi ten

| Label | Mo ta |
|-------|-------|
| lblMa_vt | Ma vat tu |
| lblTen_vt | Ten vat tu |
| lblNhom_vt | Nhom vat tu |
| lblTen_nhvt | Ten nhom VT |
| lblMa_tkvt | Ma TKVT |
| lblTen_tkvt | Ten TKVT |
| lblMa_kho | Ma kho |
| lblTen_kho | Ten kho |
| lblMa_vitri | Ma vi tri |
| lblTen_vitri | Ten vi tri |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_CTVT02_GET | Lay du lieu the kho - so chi tiet vat tu (in tat ca) |

---

## Business Logic

### Business Rules

1. **The kho / So chi tiet vat tu**:
   - Chi tiet nhap/xuat/ton cua tung vat tu
   - In tat ca cac vat tu theo tieu chi loc

2. **Tinh nang in tat ca**:
   - In theo dõi cho tất cả vật tư
   - Không cần chọn từng vật tư riêng lẻ

3. **Don vi tinh**:
   - Chon don vi tinh hien thi

4. **Phat sinh dieu chinh**:
   - Tuy chon hien thi phat sinh dieu chinh

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/TheKhoSoChiTiet.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class TheKhoSoChiTiet extends Component
{
    const MA_CT = 'IN';

    public string $pMa_Vt = '';
    public string $pMa_Nhvt = '';
    public string $pMa_Tkvt = '';
    public string $pMa_Kho = '';
    public string $pMa_Vitri = '';
    public int $pDvt = 0;
    public bool $pPs_dc = false;

    public function render(): View
    {
        return view('catalog::in.baocao.the-kho-so-chi-tiet');
    }
}
```

### 2. Views

```
resources/views/catalog/in/baocao/
├── the-kho-so-chi-tiet.blade.php
└── the-kho-so-chi-tiet-report.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/in/baocao')
    ->name('catalog.in.baocao.')
    ->group(function () {
        Route::get('/the-kho-so-chi-tiet', [TheKhoSoChiTiet::class, 'render'])
            ->name('the-kho-so-chi-tiet');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | TheKhoSoChiTiet.php | Filter form |
| SP | laravel-simba | AsINRptCTVT02.php | Data source |
| View | laravel-catalog | the-kho-so-chi-tiet.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire TheKhoSoChiTiet (filter form)
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test in tat ca
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
