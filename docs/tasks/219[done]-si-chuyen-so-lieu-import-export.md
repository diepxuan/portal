# Task 219: SI-Chuyen-So-Lieu-Import-Export

## Nhom: SI (System Integration)

## Muc tieu
Chuyen doi chuc nang chuyen so lieu (import/export) tu .NET sang PHP Laravel, dat ket qua tuong duong SiImExData.

## Chi tiet
- **DLL:** SiImExData.dll
- **Chuc nang:** Chuyen so lieu vao so cai (Import/Export Data)
- **Loai:** Utility (UTL)
- **Assembly Title:** Chuyen so lieu vao so cai
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Product:** AsiaERP

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SiImExData.dll/README.md`

---

## Form classes

### frmSiImExData (Form chinh)
- **Ke thua:** frmCalc
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| rbImport | RadioButton | Che do nhap du lieu |
| rbExport | RadioButton | Che do xuat du lieu |
| txtPath | TextBox | Duong dan file/folder |
| btnOpen | Button | Mo dialog chon file |
| txtVersion | TextBox | Phien ban |
| txtWsId | TextBox | Ma tram |
| cboKyBc | ComboBox | Ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Khoang ngay CT |
| cboCreateDate | ComboBox | Ky tao |
| txtNgay3, txtNgay4 | AsMaskedTextBox | Khoang ngay tao |
| dgvSoLieu | AsDataGridView | Grid chung tu |
| dgvDanhMuc | AsDataGridView | Grid danh muc |
| chkCheckCTAll | CheckBox | Chon tat ca CT |
| chkDmAll | CheckBox | Chon tat ca DM |
| ProgressBar1 | ProgressBar | Thanh tien trinh |

---

## Business Logic

### Quy trinh Export

```csharp
// Ten file: v{version}_{companyID}_{wsId}_{date1}_{date2}.xls
string fileName = $"v{version}_{companyID}_{wsId}_{startDate}_{endDate}.xls";
```

### Quy trinh Import

```csharp
// Kiem tra: ma cong ty, phien ban, ws_id
// Doc Excel -> DataSet
// Import vao database voi transaction
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/ImExData.php
namespace Diepxuan\Simba\Models\SI;

class ImExData extends Model
{
    protected $connection = 'simba';

    public static function getVersion(): string
    {
        return config('simba.version', '9.1.0.0');
    }

    public static function getWsId(): string
    {
        return config('simba.ws_id', 'WS01');
    }

    public static function export(array $params): string
    {
        // Export data to Excel file
    }

    public static function import(string $filePath): bool
    {
        // Import data from Excel file
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/ChuyensoLieu.php
namespace Diepxuan\Catalog\Http\Livewire\SI\ChuyensoLieu;

class ChuyensoLieu extends Component
{
    public string $pMode = 'export'; // export | import
    public string $pPath = '';
    public ?string $pKyBc = null;
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public ?string $pCboCreateDate = null;
    public ?string $pNgay3 = null;
    public ?string $pNgay4 = null;

    public array $pChungTuList = [];
    public array $pDanhMucList = [];

    public float $pProgress = 0;

    public function mount(): void
    {
        $this->loadDanhMucList();
    }

    public function export(): void
    {
        // Export to Excel
    }

    public function import(): void
    {
        // Import from Excel
    }

    public function render(): View
    {
        return view('catalog::si.chuyensolieu');
    }
}
```

### 3. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/chuyen-so-lieu', [ChuyensoLieu::class, 'render'])
            ->name('chuyensolieu');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire component
- [ ] Tao View voi import/export forms
- [ ] Tao Excel processing service
- [ ] Them Routes
- [ ] Test export data
- [ ] Test import data
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `si.tool.importexport`
- **Note:** Shell hoặc route hiện hữu; side-effect blocked nếu chưa audit payload.
