# Task 116: INRptF5CD01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bao cao F5 chi dao 01 (drill-down) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptF5CD01.dll
- **Chuc nang:** Bao cao F5 chi dao 01 (drill-down)
- **Loai:** Report (Bao cao)
- **Assembly Title:** GLRptF5CTGS01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia
- **Ma_ct:** IN (drill-down report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptF5CD01.dll/README.md`

---

## Form classes

### frmINRptF5CD01 (Form drill-down)
- **Ke thua:** frmDrilldownReport
- **Chuc nang:** Hien thi chi tiet khi nhan F5 tu bao cao tong hop

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| dgvReport | DataGridView | Hien thi du lieu chi tiet |

### Constructor

```csharp
.ctor(ReportInformation motherReportInfo, string drilldownMenuId, 
      AsDictionary formularFields, bool isNT, string nhan_in,
      string filter4Tilte, string formatedColList,
      object datasource, params object[] arg)
```

---

## Business Logic

### Business Rules

1. **Drill-down**: Hien thi chi tiet tu bao cao tong hop
2. **Nhan du lieu**: Duoc goi tu form cha voi datasource
3. **Khong co nhap lieu**: Chi hien thi, khong co controls loc

---

## Mapping PHP

### 1. Livewire Component (Drill-down)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/DrilldownCongno01.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class DrilldownCongno01 extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'F5CD01';

    public array $pMotherReportInfo = [];
    public array $pFormularFields = [];
    public bool $pIsNT = false;
    public string $pNhanIn = '';
    public string $pFilterTitle = '';
    public array $pFormatedColList = [];
    public array $pDatasource = [];
    public array $pArgs = [];

    public function mount(
        array $motherReportInfo = [],
        array $formularFields = [],
        bool $isNT = false,
        string $nhanIn = '',
        string $filterTitle = '',
        array $formatedColList = [],
        array $datasource = [],
        array $args = []
    ): void {
        $this->pMotherReportInfo = $motherReportInfo;
        $this->pFormularFields = $formularFields;
        $this->pIsNT = $isNT;
        $this->pNhanIn = $nhanIn;
        $this->pFilterTitle = $filterTitle;
        $this->pFormatedColList = $formatedColList;
        $this->pDatasource = $datasource;
        $this->pArgs = $args;
    }

    public function render(): View
    {
        return view('catalog::in.reports.drilldown-cong-no-01');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINRptF5CD01.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINRptF5CD01 extends StoredProcedure
{
    protected $procedure = 'SP_IN_RPT_F5CD01_GET';
    protected $params = ['pMa_cty', 'pMotherReportInfo', 'pDrilldownMenuId', 'pFormularFields', 'pIsNT', 'pNhanIn'];
}
```

### 3. Views

```
resources/views/catalog/in/reports/
├── drilldown-cong-no-01.blade.php    (Drill-down viewer)
```

### 4. Routes

```php
Route::prefix('catalog/in/reports')
    ->name('catalog.in.reports.')
    ->group(function () {
        Route::get('/drilldown-cong-no-01', [DrilldownCongno01::class, 'render'])
            ->name('drilldown-cong-no-01');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | DrilldownCongno01.php | Drill-down viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire DrilldownCongno01
- [ ] Tao View drilldown-cong-no-01.blade.php (hien thi DataGridView)
- [ ] Them Routes
- [ ] Test tuong tac voi bao cao cha