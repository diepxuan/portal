# Task 117: INRptCD02

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bao cao ton kho 02 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptCD02.dll
- **Chuc nang:** Bao cao ton kho 02
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bao cao ton kho
- **Version:** 14.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Cong ty phan mem Asia
- **Ma_ct:** IN (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptCD02.dll/README.md`

---

## Form classes

### frmINRptCD02 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_vt | AsTextBox | Ma vat tu (loc) |
| txtNh_vt | AsTextBox | Nhom vat tu (loc) |
| txtMa_kho | AsTextBox | Ma kho (loc) |
| txtMa_vitri | AsTextBox | Ma vi tri (loc) |
| txtMa_tkvt | AsTextBox | TK vat tu (loc) |
| txtMa_lo | AsTextBox | Ma lo (loc) |
| txtNgay | AsMaskedTextBox | Ngay bao cao |
| cboDVT | ComboBox | Don vi tinh |
| rbDK | RadioButton | Ton dau ky |
| rbCk | RadioButton | Ton cuoi ky |
| ChkQuaToiDa | CheckBox | Hien thi vuot ton toi da |
| ChkQuaToiThieu | CheckBox | Hien thi vuot ton toi thieu |
| crvReportViewer | CrystalReportViewer | Xem va in bao cao |

---

## Business Logic

### Business Rules

1. **Ton dau/cuoi ky**: Chon hien thi ton dau hoac cuoi ky
2. **Canh bao ton kho**: Hien thi vat tu vuot gioi han
3. **Loc theo ngay**: Bao cao tai thoi diem ngay duoc chon

---

## Mapping PHP

### 1. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/Baocaotonkho02.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class Baocaotonkho02 extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'CD02';

    public ?string $pMa_cty = '001';
    public ?string $pMa_vt = null;
    public ?string $pNh_vt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_vitri = null;
    public ?string $pMa_tkvt = null;
    public ?string $pMa_lo = null;
    public ?Carbon $pNgay = null;
    public int $pDVT = 0;
    public string $pLoaiTon = 'DK'; // DK hoac CK
    public bool $pQuaToiDa = false;
    public bool $pQuaToiThieu = false;

    public function mount(): void
    {
        $this->pNgay = now();
    }

    public function render(): View
    {
        return view('catalog::in.reports.baocao-ton-kho-02');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-ton-kho-02', [Baocaotonkho02::class, 'render'])
    ->name('catalog.in.reports.ton-kho-02');
```

---

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINRptCD02.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINRptCD02 extends StoredProcedure
{
    protected $procedure = 'SP_IN_CD02_GET';
    protected $params = [
        'pMa_cty', 'pMa_vt', 'pNh_vt', 'pMa_kho', 'pMa_vitri',
        'pMa_tkvt', 'pMa_lo', 'pNgay', 'pDVT', 'pLoaiTon',
        'pQuaToiDa', 'pQuaToiThieu',
    ];
}
```

### 3. Views

```
resources/views/catalog/in/reports/
├── baocao-ton-kho-02.blade.php   (Form loc + CrystalViewer)
```

### 4. Routes

```php
Route::prefix('catalog/in/reports')
    ->name('catalog.in.reports.')
    ->group(function () {
        Route::get('/bao-cao-ton-kho-02', [Baocaotonkho02::class, 'render'])
            ->name('ton-kho-02');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | Baocaotonkho02.php | Report viewer |
| SP | laravel-simba | AsINRptCD02.php | Data source |
| Model | laravel-simba | DMVT.php | Lookup vat tu |
| Model | laravel-simba | DMKHO.php | Lookup kho |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_CD02_GET
- [ ] Tao Livewire Baocaotonkho02
- [ ] Tao View baocao-ton-kho-02.blade.php
- [ ] Them Routes
- [ ] Test chon DK/CK
- [ ] Test loc qua ton toi da/thieu
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
