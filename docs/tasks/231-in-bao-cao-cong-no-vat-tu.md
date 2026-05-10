# Task 231: INRptCD01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bao cao cong no vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptCD01.dll
- **Chuc nang:** Bao cao cong no vat tu 01
- **Loai:** Bao cao (Report)
- **Assembly Title:** Bao cao cong no 01
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptCD01.dll/README.md`

---

## Form classes

### frmINRptCD01 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao cong no vat tu

### Filter Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky bao cao |
| txtNgay1 | DateTimePicker | Ngay bat dau |
| txtNgay2 | DateTimePicker | Ngay ket thuc |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_tkvt | AsTextBox | Ma TK vat tu |
| txtMa_nhvt | AsTextBox | Ma nhom vat tu |
| txtMa_vitri | AsTextBox | Ma vi tri |
| cboDVT | ComboBox | Don vi tinh |
| ChkPsdc | CheckBox | Tinh phat sinh dieu chinh |
| txtMa_plvt1 | AsTextBox | Phan loai VT 1 |
| txtMa_plvt2 | AsTextBox | Phan loai VT 2 |
| txtMa_plvt3 | AsTextBox | Phan loai VT 3 |
| txtOrder1 | TextBox | Thu tu phan loai 1 |
| txtOrder2 | TextBox | Thu tu phan loai 2 |
| txtOrder3 | TextBox | Thu tu phan loai 3 |

### Don vi tinh options

| Gia tri | Mo ta |
|---------|-------|
| 0 | Don vi tinh Kho |
| 1 | Don vi tinh Mua |
| 2 | Don vi tinh Ban |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_CD01_GET | Lay du lieu bao cao cong no vat tu |

---

## Business Logic

### Business Rules

1. **Bao cao cong no**:
   - Ton dau ky
   - Phat sinh nhap trong ky
   - Phat sinh xuat trong ky
   - Ton cuoi ky

2. **Tinh phat sinh dieu chinh**:
   - Khi chkPsdc = true, tinh ca phat sinh dieu chinh

3. **Phan loai VT**:
   - 3 cap phan loai (plvt1, plvt2, plvt3)
   - Thu tu phan loai (order1, order2, order3)

4. **Drilldown (F5)**:
   - Cho phep xem chi tiet vat tu

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/CongNoVatTu.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class CongNoVatTu extends Component
{
    const MA_CT = 'IN';

    public string $pKyBc = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pMa_Kho = '';
    public string $pMa_Vt = '';
    public string $pMa_Tkvt = '';
    public string $pMa_Nhvt = '';
    public string $pMa_Vitri = '';
    public int $pDvt = 0;
    public bool $pPsdc = false;
    public string $pMa_Plvt1 = '';
    public string $pMa_Plvt2 = '';
    public string $pMa_Plvt3 = '';
    public int $pOrder1 = 0;
    public int $pOrder2 = 0;
    public int $pOrder3 = 0;

    public function render(): View
    {
        return view('catalog::in.baocao.cong-no-vat-tu');
    }
}
```

### 2. Views

```
resources/views/catalog/in/baocao/
├── cong-no-vat-tu.blade.php
└── cong-no-vat-tu-report.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/in/baocao')
    ->name('catalog.in.baocao.')
    ->group(function () {
        Route::get('/cong-no-vat-tu', [CongNoVatTu::class, 'render'])
            ->name('cong-no-vat-tu');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | CongNoVatTu.php | Filter form |
| SP | laravel-simba | AsINRptCD01.php | Data source |
| View | laravel-catalog | cong-no-vat-tu.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire CongNoVatTu (filter form)
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test drilldown F5
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
