# Task 204: SO-Bao-Cao-Tong-Hop-Ban-Hang-02

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop ban hang theo ky (thang/quy/nam) tu .NET sang PHP Laravel, dat ket qua tuong duong SORptTH02.

## Chi tiet
- **DLL:** SORptTH02.dll
- **Chuc nang:** Bao cao tong hop ban hang theo ky (Thang/Quy/Nam)
- **Loai:** Report (RPT)
- **Assembly Title:** Asia Enterprise
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptTH02.dll/README.md`

---

## Cau truc du lieu

### Du lieu bao cao theo ky

#### Bang: Data (Tong hop theo ky)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ky | int | Ky (thang/quy/nam) |
| nam | int | Nam |
| tong_tien | decimal | Tong tien |
| tong_thue | decimal | Tong thue |
| tong_thanh_toan | decimal | Tong thanh toan |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| SO3 | Hoa don ban hang | Filter theo ngay_ct |

---

## Form classes

### frmSORptTH02 (Form bao cao chinh)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao tong hop ban hang theo ky

#### TabFilter Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau_bc | ComboBox | Chon mau bao cao |
| cboKyBc | ComboBox | Chon ky bao cao (an) |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau (an) |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc (an) |
| txtTieu_De | TextBox | Tieu de bao cao |
| cboLoai | ComboBox | Loai xem (Theo thang/Quy/Nam) |
| cboLoai_CT | ComboBox | Loai chung tu (SO1-SO5) |
| txtTu_Thang | AsTextNumeric | Tu thang/quy/nam |
| txtSo_Ky | AsTextNumeric | So ky hien thi |
| txtNam | AsTextNumeric | Nam |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Hien thi VND |
| optNt | RadioButton | Hien thi NT |
| crvReportViewer | CrystalReportViewer | Viewer bao cao |

#### Labels

| Label | Mo ta |
|-------|-------|
| lblTu_Thang | Tu thang/quy/nam |
| lblSo_Ky | So ky |

### Cac hang so

```csharp
private const string THANG = "THANG";
private const string QUY = "QUY";
private const string NAM = "NAM";
```

### Cac gia tri cboLoai

- "Theo thang"
- "Theo Quy"
- "Theo Nam"

---

## Business Logic

### cboLoai_SelectedIndexChanged()

```csharp
private void cboLoai_SelectedIndexChanged(object sender, EventArgs e)
{
    string text = cboLoai.SelectedItem.ToString();
    if (text.Equals("Theo thang"))
    {
        lblTu_Thang.Text = "Từ tháng";
        lblSo_Ky.Text = "Số tháng";
        txtTu_Thang.MaxLength = 2;
        txtSo_Ky.MaxLength = 2;
    }
    else if (text.Equals("Theo Quý"))
    {
        lblTu_Thang.Text = "Từ quý";
        lblSo_Ky.Text = "Số quý";
        txtTu_Thang.MaxLength = 1;
        txtSo_Ky.MaxLength = 2;
    }
    else if (text.Equals("Theo Năm"))
    {
        lblTu_Thang.Text = "Năm";
        lblSo_Ky.Text = "Số năm";
        txtTu_Thang.MaxLength = 4;
        txtSo_Ky.MaxLength = 2;
    }
}
```

### LoadData()

```csharp
ArrayList arrayList = new ArrayList();
arrayList.Add(CompanyInformations.CompanyID);
arrayList.Add(cboLoai_CT.SelectedValue);
arrayList.Add(txtNam.Value);
arrayList.Add(txtTu_Thang.Value);
arrayList.Add(txtSo_Ky.Value);
arrayList.Add(cboLoai.SelectedItem.ToString());
arrayList.Add(txtMa_Nt.Text);

DataSet dataSet = MyController.GetDataSet(arrayList.ToArray());
```

### InitOtherComponents()

```csharp
ArrayList arrayList = new ArrayList();
arrayList.Add(CompanyInformations.CompanyID);
arrayList.Add(MyMenuInfo.moduleid);
arrayList.Add("0");
arrayList.Add(SystemInformations.CurrentCultureName);

ArrayList arrayList2 = CBO<lstVoucherInfo>.FillCollection(
    Commons.GetDataReader("asSIGetDmSo_ct", arrayList.ToArray()));
arrayList2.Add(new lstVoucherInfo("", AsiaErp.Framework.Environment.getLangSysMessageResX("#SYS_ALL").value));
cboLoai_CT.DataSource = arrayList2;
cboLoai_CT.DisplayMember = "TEN_CT";
cboLoai_CT.ValueMember = "MA_CT";
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/SORptTH02.php
namespace Diepxuan\Simba\Models\SO;

class SORptTH02 extends Model
{
    protected $connection = 'simba';

    public const LOAI_THANG = 'THANG';
    public const LOAI_QUY = 'QUY';
    public const LOAI_NAM = 'NAM';

    public static function getTongHop(array $params): array
    {
        // Goi SP lay du lieu
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetRptTH02.php
class AsSOGetRptTH02 extends StoredProcedure
{
    protected $procedure = 'SP_SO_TH02_GET';
    protected $params = [
        'pMa_cty',
        'pMa_ct_list',    // Comma-separated: SO1,SO2,SO3,SO4,SO5
        'pNam',
        'pTu_ky',
        'pSo_ky',
        'pLoai',          // THANG/QUY/NAM
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Baocaotonghopbanhang02.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Baocaotonghopbanhang02;

class Baocaotonghopbanhang02 extends Component
{
    public const LOAI_THANG = 'THANG';
    public const LOAI_QUY = 'QUY';
    public const LOAI_NAM = 'NAM';

    public string $pTieuDe = 'Bao cao tong hop ban hang theo ky';
    public string $pLoai = self::LOAI_THANG; // THANG/QUY/NAM
    public string $pLoaiCt = ''; // Tat ca loai CT
    public int $pNam = 2024;
    public int $pTuKy = 1;
    public int $pSoKy = 12;
    public string $pMaNt = 'VND';
    public bool $pIsNt = false;

    public Collection $pDataList;
    public array $pKyLabels = [];

    protected $rules = [
        'pNam' => 'required|integer|min:2000|max:2100',
        'pTuKy' => 'required|integer|min:1',
        'pSoKy' => 'required|integer|min:1|max:12',
    ];

    public function mount(): void
    {
        $this->pNam = (int)date('Y');
        $this->loadData();
    }

    public function updatedPLoai(string $value): void
    {
        // Cap nhat nhan cua cac control
        switch ($value) {
            case self::LOAI_THANG:
                $this->pLabelTuKy = 'Từ tháng';
                $this->pLabelSoKy = 'Số tháng';
                $this->pTuKyMax = 12;
                $this->pSoKyMax = 12;
                break;
            case self::LOAI_QUY:
                $this->pLabelTuKy = 'Từ quý';
                $this->pLabelSoKy = 'Số quý';
                $this->pTuKyMax = 4;
                $this->pSoKyMax = 4;
                break;
            case self::LOAI_NAM:
                $this->pLabelTuKy = 'Năm';
                $this->pLabelSoKy = 'Số năm';
                $this->pTuKyMax = 9999;
                $this->pSoKyMax = 10;
                break;
        }
    }

    public function loadData(): void
    {
        $params = [
            'pMa_cty' => auth()->user()->ma_cty,
            'pMa_ct_list' => $this->pLoaiCt,
            'pNam' => $this->pNam,
            'pTu_ky' => $this->pTuKy,
            'pSo_ky' => $this->pSoKy,
            'pLoai' => $this->pLoai,
            'pMa_nt' => $this->pMaNt,
        ];

        $data = AsSOGetRptTH02::execute($params);
        $this->pDataList = collect($data);
        $this->buildLabels();
    }

    protected function buildLabels(): void
    {
        $this->pKyLabels = [];
        for ($i = 0; $i < $this->pSoKy; $i++) {
            $ky = $this->pTuKy + $i;
            switch ($this->pLoai) {
                case self::LOAI_THANG:
                    $this->pKyLabels[] = "T{$ky}";
                    break;
                case self::LOAI_QUY:
                    $this->pKyLabels[] = "Q{$ky}";
                    break;
                case self::LOAI_NAM:
                    $this->pKyLabels[] = (string)($this->pNam + $i);
                    break;
            }
        }
    }

    public function render(): View
    {
        return view('catalog::so.baocaotonghopbanhang02');
    }
}
```

### 4. Views

```html
<!-- resources/views/catalog/so/baocaotonghopbanhang02.blade.php -->
<div>
    <!-- Filters -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <label>Loai xem</label>
                    <select wire:model="pLoai" wire:change="updatedPLoai($event.target.value)"
                        class="form-select">
                        <option value="THANG">Theo thang</option>
                        <option value="QUY">Theo Quy</option>
                        <option value="NAM">Theo Nam</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>{{ $pLabelTuKy ?? 'Tu ky' }}</label>
                    <input type="number" wire:model="pTuKy"
                        min="1" max="{{ $pTuKyMax ?? 12 }}"
                        class="form-control">
                </div>
                <div class="col-md-2">
                    <label>{{ $pLabelSoKy ?? 'So ky' }}</label>
                    <input type="number" wire:model="pSoKy"
                        min="1" max="{{ $pSoKyMax ?? 12 }}"
                        class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Nam</label>
                    <input type="number" wire:model="pNam"
                        min="2000" max="2100"
                        class="form-control">
                </div>
                <div class="col-md-2">
                    <label>Loai chung tu</label>
                    <select wire:model="pLoaiCt" class="form-select">
                        <option value="">Tat ca</option>
                        <option value="SO1">Phieu xuat ban le</option>
                        <option value="SO3">Hoa don ban hang</option>
                        <option value="SO5">Hoa don dich vu</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Tien</label>
                    <div class="btn-group w-100">
                        <button class="btn btn-sm {{ !$pIsNt ? 'btn-primary' : 'btn-outline-secondary' }}"
                            wire:click="$set('pIsNt', false)">VND</button>
                        <button class="btn btn-sm {{ $pIsNt ? 'btn-primary' : 'btn-outline-secondary' }}"
                            wire:click="$set('pIsNt', true)">NT</button>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-primary" wire:click="loadData">Xem bao cao</button>
                    <button class="btn btn-secondary" wire:click="exportExcel">Export Excel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Chi tieu</th>
                    @foreach($pKyLabels as $label)
                    <th class="text-center">{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tong so luong</td>
                    @foreach($pKyLabels as $i => $label)
                    <td class="text-right">
                        {{ number_format($pDataList[$i]['tong_so_luong'] ?? 0, 2) }}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Tong tien hang</td>
                    @foreach($pKyLabels as $i => $label)
                    <td class="text-right">
                        {{ number_format($pDataList[$i]['tong_tien'] ?? 0) }}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Thue GTGT</td>
                    @foreach($pKyLabels as $i => $label)
                    <td class="text-right">
                        {{ number_format($pDataList[$i]['tong_thue'] ?? 0) }}
                    </td>
                    @endforeach
                </tr>
                <tr class="table-primary">
                    <td><strong>Thanh toan</strong></td>
                    @foreach($pKyLabels as $i => $label)
                    <td class="text-right">
                        <strong>{{ number_format($pDataList[$i]['tong_thanh_toan'] ?? 0) }}</strong>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

### 5. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/bao-cao-tong-hop-02', [Baocaotonghopbanhang02::class, 'render'])
            ->name('baocaotonghopbanhang02');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SORptTH02.php | Data transfer |
| SP | laravel-simba | AsSOGetRptTH02.php | Get data |
| Component | laravel-catalog | Baocaotonghopbanhang02.php | Report component |
| View | laravel-catalog | baocaotonghopbanhang02.blade.php | View |
| Filter | laravel-catalog | LoaiKySelect.php | Filter component |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure class AsSOGetRptTH02
- [ ] Tao Livewire Baocaotonghopbanhang02 component
- [ ] Implement cap nhat labels khi doi loai (thang/quy/nam)
- [ ] Tao View voi bang bao cao theo ky
- [ ] Them Routes
- [ ] Test xem bao cao theo thang/quy/nam
- [ ] Test export Excel