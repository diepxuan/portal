# Task 107: INRptBK01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu ton kho tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptBK01.dll
- **Chuc nang:** Bang ke chung tu ton kho
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bang ke chung tu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptBK01.dll/README.md`

---

## Form classes

### frmINRptBK01 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau_bc | ComboBox | Mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| txtMonth | TextBox | Thang bao cao |
| txtYear | TextBox | Nam bao cao |
| txtMa_vt | AsTextBox | Ma vat tu (loc) |
| txtMa_kho | AsTextBox | Ma kho (loc) |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Hien thi VND |
| optNt | RadioButton | Hien thi ngoai te |
| crvReportViewer | CrystalReportViewer | Xem va in bao cao |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Range 1-12 | month | 'Thang phai tu 1 den 12' |
| Positive | year | 'Nam phai lon hon 0' |

### Business Rules

1. **Mac dinh**: Thang/nam hien tai
2. **Loai tien**: Chon hien thi VND hoac ngoai te
3. **Loc theo thang/nam**: Hien thi chung tu trong thang

---

## Mapping PHP

### 1. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/Bangkechungtutonkho.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class Bangkechungtutonkho extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'BK01';

    public int $pMonth;
    public int $pYear;
    public ?string $pMa_vt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_nt = 'VND';
    public bool $pIsVND = true;

    public function mount(): void
    {
        $this->pMonth = (int) now()->format('m');
        $this->pYear = (int) now()->format('Y');
    }

    public function render(): View
    {
        return view('catalog::in.reports.bang-ke-chung-tu-ton-kho');
    }
}
```

### 2. Views

```
resources/views/catalog/in/reports/
└── bang-ke-chung-tu-ton-kho.blade.php
```

### 3. Routes

```php
Route::get('/bang-ke-chung-tu-ton-kho', [Bangkechungtutonkho::class, 'render'])
    ->name('catalog.in.reports.bang-ke-chung-tu');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | Bangkechungtutonkho.php | Report viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_BK01_GET
- [ ] Tao Livewire Bangkechungtutonkho
- [ ] Tao View bang-ke-chung-tu-ton-kho.blade.php
- [ ] Them Routes
- [ ] Test loc theo thang/nam
- [ ] Test chon VND/Ngoai te