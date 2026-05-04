# Task 105: INRptCTVT01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bao cao chi tiet vat tu 01 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptCTVT01.dll
- **Chuc nang:** Bao cao chi tiet vat tu 01
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bao cao chi tiet vat tu 01
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptCTVT01.dll/README.md`

---

## Form classes

### frmINRptCTVT01 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao chi tiet vat tu theo vat tu va kho

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky bao cao |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| txtMa_vt | AsTextBox | Ma vat tu (bat buoc) |
| txtMa_kho | AsTextBox | Ma kho (bat buoc) |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtTK_VT | AsTextBox | TK vat tu |
| cboDVT | ComboBox | Don vi tinh (0=kho, 1=mua, 2=ban) |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cboMau_bc | ComboBox | Mau bao cao |
| crvReportViewer | CrystalReportViewer | Xem va in bao cao |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Required | ma_kho | 'Ma kho khong duoc trong' |

### Business Rules

1. **Bat buoc**: ma_vt va ma_kho bat buoc nhap
2. **Tu dong fill**: Khi nhap ma_vt -> tu dong hien thi ten_vt, dvt
3. **DVT**: Chon cach hien thi don vi tinh
4. **Ton dau/cuoi**: Tinh ton dau ky, phat sinh, ton cuoi ky

---

## Mapping PHP

### 1. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/Baocaochitietvattu.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class Baocaochitietvattu extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'CTVT01';

    public ?string $pMa_cty = '001';
    public ?int $pKyBc = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public ?string $pMa_vt = null;  // Bat buoc
    public ?string $pMa_kho = null; // Bat buoc
    public ?string $pMa_vitri = null;
    public ?string $pTK_VT = null;
    public int $pDVT = 0;
    public ?string $pMa_nt = 'VND';

    protected $rules = [
        'pMa_vt' => 'required|string|max:50',
        'pMa_kho' => 'required|string|max:50',
    ];

    public function updatedPMaVt($value): void
    {
        // Auto-fill ten_vt, dvt
    }

    public function render(): View
    {
        return view('catalog::in.reports.baocao-chi-tiet-vat-tu');
    }
}
```

### 2. Views

```
resources/views/catalog/in/reports/
└── baocao-chi-tiet-vat-tu.blade.php
```

### 3. Routes

```php
Route::get('/bao-cao-chi-tiet-vat-tu', [Baocaochitietvattu::class, 'render'])
    ->name('catalog.in.reports.chi-tiet-vat-tu');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMVT.php | Vat tu |
| Component | laravel-catalog | Baocaochitietvattu.php | Report viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_CTVT01_GET
- [ ] Tao Livewire Baocaochitietvattu
- [ ] Tao View baocao-chi-tiet-vat-tu.blade.php
- [ ] Them Routes
- [ ] Validate bat buoc ma_vt, ma_kho
- [ ] Test Crystal Report integration