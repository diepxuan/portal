# Task 203: SO-Bao-Cao-Tong-Hop-F5

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop F5 (drill-down) tu .NET sang PHP Laravel, dat ket qua tuong duong SORptF5TH0.

## Chi tiet
- **DLL:** SORptF5TH0.dll
- **Chuc nang:** Bao cao tong hop F5 (Drill-down tu bao cao SO tong hop)
- **Loai:** Report (RPT) - DrillDown
- **Assembly Title:** Asia Enterprise
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptF5TH0.dll/README.md`

---

## Cau truc du lieu

### Du lieu tu bao cao cha

| Truong | Kieu | Mo ta |
|--------|------|-------|
| motherReportInfo | ReportInformation | Thong tin bao cao mẹ |
| drilldown_menuid | string | Menu ID drill-down |
| formularFields | AsDictionary | Cac truong loc tu bao cao cha |
| is_nt | bool | Hien thi tien ngoai te |
| nhan_in | string | Nhan in |
| filter4Title | string | Filter title |
| formatedColList | string | Danh sach cot |
| datasource | ref object | DataSet (reference) |

---

## Form classes

### frmSORptF5TH0 (Form bao cao chinh)
- **Ke thua:** frmDrilldownReport
- **Chuc nang:** Hien thi chi tiet tong hop tu bao cao SO tong hop

#### Constructors

```csharp
// Constructor chinh
public frmSORptF5TH0(
    ReportInformation motherReportInfo,
    string drilldown_menuid,
    AsDictionary formularFields,
    bool isNT,
    string nhan_in,
    string filter4Title,
    string formatedColList,
    ref object datasource,
    params object[] arg)

// Constructor mac dinh
public frmSORptF5TH0()
```

#### Phuong thuc

| Method | Mo ta |
|--------|-------|
| CreateDrilldownArgument() | Override base, ho tro drill-down tiep |

### Dac diem khac biet voi SORptF5BCPT06

| Dac diem | SORptF5BCPT06 | SORptF5TH0 |
|----------|---------------|------------|
| datasource | value | ref (co the thay doi) |
| CreateDrilldownArgument() | base | override (ho tro drill-down tiep) |

---

## Business Logic

### CreateDrilldownArgument()

```csharp
protected override ArrayList CreateDrilldownArgument(
    ReportDrillDownInfo drilldownInfo,
    ref string sDrilldownMenuId,
    Keys keycode,
    Keys modifierKeys,
    ref string filterCondition4title,
    ref object datasource)
{
    // Goi base nhung co the modify datasource
    return base.CreateDrilldownArgument(
        drilldownInfo, ref sDrilldownMenuId, keycode, modifierKeys,
        ref filterCondition4title, ref datasource);
}
```

### Drill-down Flow

1. Nguoi dung xem bao cao tong hop SO (SORptTH0x)
2. Nguoi dung nhan F4 tren mot gia tri
3. He thong goi frmSORptF5TH0 voi:
   - `formularFields`: Cac dieu kien loc
   - `datasource`: DataSet (reference)
   - `sDrilldownMenuId`: Menu ID cho drill-down tiep
4. frmSORptF5TH0 hien thi chi tiet, co kha nang drill-down tiep

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/SORptF5TH0.php
namespace Diepxuan\Simba\Models\SO;

class SORptF5TH0 extends Model
{
    protected $connection = 'simba';

    public static function getDrilldownData(array $params): array
    {
        // Lay du lieu tu bao cao cha
    }

    public static function updateData(array $filters, array $newData): void
    {
        // Cap nhat datasource (ref parameter)
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetRptF5TH0.php
class AsSOGetRptF5TH0 extends StoredProcedure
{
    protected $procedure = 'SP_SO_F5TH0_GET';
    protected $params = [
        'pMa_cty',
        'pMa_ct',
        'pNgay1',
        'pNgay2',
        'pMa_kh',
        'pMa_vt',
        'pFilter_fields',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/BaocaotonghopF5.php
namespace Diepxuan\Catalog\Http\Livewire\SO\BaocaotonghopF5;

class BaocaotonghopF5 extends Component
{
    public ?string $pDrilldownMenuId = null;
    public array $pFormularFields = [];
    public bool $pIsNt = false;
    public string $pFilter4Title = '';
    public string $pFormatedColList = '';
    public array $pDataList = [];
    public array $pColumns = [];

    public function mount(
        ?string $drilldownMenuId = null,
        array $formularFields = [],
        bool $isNt = false,
        string $filter4Title = '',
        string $formatedColList = '',
        array $dataList = [],
        array $arg = []
    ): void {
        $this->pDrilldownMenuId = $drilldownMenuId;
        $this->pFormularFields = $formularFields;
        $this->pIsNt = $isNt;
        $this->pFilter4Title = $filter4Title;
        $this->pFormatedColList = $formatedColList;
        $this->pDataList = $dataList;

        $this->loadData();
    }

    public function loadData(): void
    {
        if (!empty($this->pDataList)) {
            $this->pDataList = $this->pDataList;
        } else {
            $params = $this->buildParams();
            $this->pDataList = AsSOGetRptF5TH0::execute($params);
        }

        $this->parseColumns();
    }

    protected function buildParams(): array
    {
        return [
            'pMa_cty' => $this->pFormularFields['ma_cty'] ?? auth()->user()->ma_cty,
            'pMa_ct' => $this->pFormularFields['ma_ct'] ?? 'SO3',
            'pNgay1' => $this->pFormularFields['ngay1'] ?? null,
            'pNgay2' => $this->pFormularFields['ngay2'] ?? null,
            'pMa_kh' => $this->pFormularFields['ma_kh'] ?? null,
            'pMa_vt' => $this->pFormularFields['ma_vt'] ?? null,
            'pFilter_fields' => json_encode($this->pFormularFields),
        ];
    }

    public function drilldown(string $field, mixed $value): void
    {
        $newFields = $this->pFormularFields;
        $newFields[$field] = $value;

        // Drill-down tiep
        $this->emit('drilldown', [
            'menuId' => $this->pDrilldownMenuId,
            'formularFields' => $newFields,
            'isNt' => $this->pIsNt,
            'dataList' => $this->pDataList,
        ]);
    }

    public function render(): View
    {
        return view('catalog::so.baocaotonghop-f5');
    }
}
```

### 4. Views

```html
<!-- resources/views/catalog/so/baocaotonghop-f5.blade.php -->
<div>
    <div class="mb-3">
        <h5>Bao cao tong hop - Chi tiet</h5>
        <small>{{ $pFilter4Title }}</small>
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                @foreach($pColumns as $col)
                <th>{{ $col['header'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($pDataList as $row)
            <tr>
                @foreach($pColumns as $col)
                <td class="{{ is_numeric($row[$col['field']]) ? 'text-right' : '' }}"
                    @if(is_numeric($row[$col['field']]))
                    wire:click="drilldown('{{ $col['field'] }}', {{ $row[$col['field']] }})"
                    style="cursor:pointer"
                    @endif
                >
                    @if(is_numeric($row[$col['field']]))
                        {{ number_format($row[$col['field']], 2) }}
                    @else
                        {{ $row[$col['field']] }}
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <button class="btn btn-sm btn-secondary" wire:click="goBack">Quay lai</button>
        <button class="btn btn-sm btn-primary" wire:click="exportExcel">Export</button>
    </div>
</div>
```

### 5. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/bao-cao-tong-hop-f5', [BaocaotonghopF5::class, 'render'])
            ->name('baocaotonghopf5');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SORptF5TH0.php | Data transfer |
| SP | laravel-simba | AsSOGetRptF5TH0.php | Get data |
| Component | laravel-catalog | BaocaotonghopF5.php | Drill-down component |
| View | laravel-catalog | baocaotonghop-f5.blade.php | View |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure class AsSOGetRptF5TH0
- [ ] Tao Livewire BaocaotonghopF5 component
- [ ] Xu ly ref datasource (update data)
- [ ] Implement drilldown tiep (multi-level)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test drill-down tu bao cao tong hop
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
