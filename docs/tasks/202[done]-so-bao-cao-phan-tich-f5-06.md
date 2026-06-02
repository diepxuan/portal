# Task 202: SO-Bao-Cao-Phan-Tich-F5-06

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich F5 06 (drill-down) tu .NET sang PHP Laravel, dat ket qua tuong duong SORptF5BCPT06.

## Chi tiet
- **DLL:** SORptF5BCPT06.dll
- **Chuc nang:** Bao cao phan tich F5 06 (Drill-down tu bao cao SO ban hang 2 chi tieu)
- **Loai:** Report (RPT) - DrillDown
- **Assembly Title:** Asia Enterprise
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptF5BCPT06.dll/README.md`

---

## Cau truc du lieu

### Du lieu tu bao cao cha (SORptBCPT06)

Du lieu duoc truyen vao tu bao cao mẹ khi nguoi dung nhan F4 de drill-down.

### Bang: Data from Parent Report

| Truong | Kieu | Mo ta |
|--------|------|-------|
| drilldown_menuid | string | Menu ID cua bao cao drill-down |
| formular_fields | AsDictionary | Cac truong loc tu bao cao cha |
| is_nt | bool | Hien thi tien ngoai te |
| nhan_in | string | Nhan in |
| filter4_title | string | Chuoi loc cho title |
| formated_col_list | string | Danh sach cot da format |
| datasource | object | DataSet tu bao cao cha |
| arg | object[] | Tham so them |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| SO3 (SO1-SO5) | Chung tu ban hang | Filter theo stt_rec |

---

## Form classes

### frmSORptF5BCPT06 (Form bao cao chinh)
- **Ke thua:** frmDrilldownReport
- **Chuc nang:** Hien thi chi tiet drill-down tu bao cao SO phan tich ban hang 2 chi tieu

#### Constructors

```csharp
// Constructor chinh - goi tu bao cao mẹ
public frmSORptF5BCPT06(
    ReportInformation motherReportInfo,     // Thong tin bao cao mẹ
    string drilldown_menuid,               // Menu ID drill-down
    AsDictionary formularFields,           // Cac truong loc
    bool isNT,                             // Hien thi NT
    string nhan_in,                        // Nhan in
    string filter4Title,                   // Filter title
    string formatedColList,               // Danh sach cot
    object datasource,                    // Data tu bao cha
    params object[] arg)                  // Tham so them

// Constructor mac dinh
public frmSORptF5BCPT06()
```

#### Thanh phan UI

| Control | Mo ta |
|---------|-------|
| Container (from base frmDrilldownReport) | Chua DataGridView |

---

## Business Logic

### InitializeComponent()

```csharp
private void InitializeComponent()
{
    components = new Container();
    // Base class frmDrilldownReport xu ly phan lon
}
```

### Drill-down flow

1. Nguoi dung xem bao cao SORptBCPT06 (phan tich ban hang 2 chi tieu)
2. Nguoi dung nhan F4 tren mot o chua gia tri
3. He thong goi frmSORptF5BCPT06 voi tham so:
   - `motherReportInfo`: Thong tin bao cao mẹ
   - `drilldown_menuid`: Menu ID cho drill-down
   - `formularFields`: Cac truong loc tu bao cao mẹ
   - `isNT`: Co hien thi ngoai te khong
   - `filter4Title`: Tieu de loc
   - `formatedColList`: Danh sach cot
   - `datasource`: DataSet tu bao cao mẹ
4. frmSORptF5BCPT06 hien thi chi tiet cua gia tri duoc drill-down

### Ke thua tu frmDrilldownReport

| Method | Mo ta |
|--------|-------|
| CreateDrilldownArgument() | Tao tham so drill-down |
| GetData() | Lay du lieu chi tiet |
| RenderReport() | Ve bao cao |

---

## Mapping PHP

### 1. Model (Data Transfer)

```php
// app/Models/SO/SORptF5BCPT06.php
namespace Diepxuan\Simba\Models\SO;

class SORptF5BCPT06 extends Model
{
    protected $connection = 'simba';

    public static function getDrilldownData(array $params): array
    {
        // Lay du lieu chi tiet tu bao cao cha
        // filter theo tham so tu bao cao cha
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetRptF5BCPT06.php
class AsSOGetRptF5BCPT06 extends StoredProcedure
{
    protected $procedure = 'SP_SO_F5BCPT06_GET';
    protected $params = [
        'pMa_cty',
        'pMa_ct',
        'pNgay1',
        'pNgay2',
        'pMa_kh',
        'pMa_nvkd',
        'pMa_vt',
        'pMa_kho',
        'pFilter_fields', // JSON tu formularFields
    ];
}
```

### 3. Livewire Component (Drill-down Report)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/BaocaophantichF506.php
namespace Diepxuan\Catalog\Http\Livewire\SO\BaocaophantichF506;

class BaocaophantichF506 extends Component
{
    // Data tu bao cao cha
    public ?string $pDrilldownMenuId = null;
    public array $pFormularFields = [];
    public bool $pIsNt = false;
    public string $pNhanIn = '';
    public string $pFilter4Title = '';
    public string $pFormatedColList = '';
    public array $pParentData = [];

    public Collection $pDataList;
    public array $pColumns = [];
    public string $pTitle = 'Bao cao phan tich ban hang';

    public function mount(
        ?string $drilldownMenuId = null,
        array $formularFields = [],
        bool $isNt = false,
        string $nhanIn = '',
        string $filter4Title = '',
        string $formatedColList = '',
        array $parentData = [],
        array $arg = []
    ): void {
        $this->pDrilldownMenuId = $drilldownMenuId;
        $this->pFormularFields = $formularFields;
        $this->pIsNt = $isNt;
        $this->pNhanIn = $nhanIn;
        $this->pFilter4Title = $filter4Title;
        $this->pFormatedColList = $formatedColList;
        $this->pParentData = $parentData;

        $this->loadData();
    }

    public function loadData(): void
    {
        // Lay du lieu tu bao cao cha
        // Filter theo formularFields
        $params = $this->buildParams();

        if (!empty($this->pParentData)) {
            // Su dung data tu bao cao cha
            $this->pDataList = collect($this->pParentData);
        } else {
            // Lay tu database
            $this->pDataList = AsSOGetRptF5BCPT06::execute($params);
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
            'pMa_nvkd' => $this->pFormularFields['ma_nvkd'] ?? null,
            'pMa_vt' => $this->pFormularFields['ma_vt'] ?? null,
            'pMa_kho' => $this->pFormularFields['ma_kho'] ?? null,
            'pFilter_fields' => json_encode($this->pFormularFields),
        ];
    }

    protected function parseColumns(): void
    {
        // Parse formatedColList de xac dinh cot hien thi
        $cols = explode(',', $this->pFormatedColList);
        foreach ($cols as $col) {
            $this->pColumns[] = [
                'field' => trim($col),
                'header' => $this->translateColumn(trim($col)),
            ];
        }
    }

    protected function translateColumn(string $field): string
    {
        $translations = [
            'stt_rec' => 'STT Record',
            'so_ct' => 'So chung tu',
            'ngay_ct' => 'Ngay CT',
            'ten_kh' => 'Khach hang',
            'ten_vt' => 'Vat tu',
            'so_luong' => 'So luong',
            'tien_nt2' => 'Tien NT',
            'tien2' => 'Tien VND',
            'thue_gtgt_nt' => 'Thue NT',
            'thue_gtgt' => 'Thue VND',
        ];
        return $translations[$field] ?? $field;
    }

    public function drilldown(string $field, mixed $value): void
    {
        // Cho phep drill-down tiep tu 1 o
        $newFields = $this->pFormularFields;
        $newFields[$field] = $value;

        $this->emit('drilldown', [
            'menuId' => $this->pDrilldownMenuId,
            'formularFields' => $newFields,
            'isNt' => $this->pIsNt,
            'parentData' => $this->pDataList->toArray(),
        ]);
    }

    public function render(): View
    {
        return view('catalog::so.baocaophantich-f506');
    }
}
```

### 4. Views

```html
<!-- resources/views/catalog/so/baocaophantich-f506.blade.php -->
<div>
    <!-- Title -->
    <div class="mb-3">
        <h5>{{ $pTitle }}</h5>
        <small class="text-muted">{{ $pFilter4Title }}</small>
    </div>

    <!-- Data Table -->
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
                    style="{{ is_numeric($row[$col['field']]) ? 'cursor:pointer' : '' }}"
                    @if(is_numeric($row[$col['field']]))
                    wire:click="drilldown('{{ $col['field'] }}', {{ $row[$col['field']] }})"
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

    <!-- Actions -->
    <div class="mt-3">
        <button class="btn btn-sm btn-secondary" wire:click="goBack">Quay lai</button>
        <button class="btn btn-sm btn-primary" wire:click="exportExcel">Export Excel</button>
    </div>
</div>
```

### 5. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/bao-cao-f506', [BaocaophantichF506::class, 'render'])
            ->name('baocaophantichf506');

        // Route voi query params cho drill-down
        Route::get('/bao-cao-f506/drill', [BaocaophantichF506::class, 'render'])
            ->name('baocaophantichf506.drill')
            ->defaults('isDrill', true);
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SORptF5BCPT06.php | Data transfer |
| SP | laravel-simba | AsSOGetRptF5BCPT06.php | Get data |
| Component | laravel-catalog | BaocaophantichF506.php | Drill-down component |
| Component | laravel-catalog | BaocaophantichF506Parent.php | Parent report trigger |
| View | laravel-catalog | baocaophantich-f506.blade.php | Drill-down view |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure class AsSOGetRptF5BCPT06
- [ ] Tao Livewire BaocaophantichF506 component
- [ ] Nhan data tu bao cao cha (parent report)
- [ ] Hien thi bang data voi cot dong
- [ ] Implement drilldown function
- [ ] Tao View voi bang data
- [ ] Them Routes
- [ ] Test drill-down tu bao cao cha
- [ ] Test drill-down tiep (multi-level)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `so.rpt F5 shell`
- **Note:** Voucher/report/dictionary route shell; write execute chỉ mở khi payload audit đủ.
