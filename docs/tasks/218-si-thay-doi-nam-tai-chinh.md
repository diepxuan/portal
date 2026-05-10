# Task 218: SI-Thay-Doi-Nam-Tai-Chinh

## Nhom: SI (System Integration)

## Muc tieu
Chuyen doi chuc nang thay doi nam tai chinh tu .NET sang PHP Laravel, dat ket qua tuong duong SiChangeFY.

## Chi tiet
- **DLL:** SiChangeFY.dll
- **Chuc nang:** Thay doi nam tai chinh (Change Fiscal Year)
- **Loai:** Utility (UTL)
- **Assembly Title:** SiChangeFY
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asiasoft
- **Product:** AsiaERP

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SiChangeFY.dll/README.md`

---

## Form classes

### frmSiChangeFY (Form chinh)
- **Ke thua:** frmCalc
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboFinanceYear | AsComboBox | Chon nam tai chinh |
| lblFinancialYear | Label | Nhan "Nam tai chinh" |
| cmdOK | Button | Nut xac nhan |
| cmdCancel | Button | Nut huy |

---

## Business Logic

### Khoi tao danh sach nam

```csharp
// Danh sach nam: (nam hien tai - 10) den (nam hien tai + 10)
for (int i = Now.Year - 10; i <= Now.Year + 10; i++)
{
    cboFinanceYear.Items.Add(i);
}
```

### Xu ly khi nhan OK

```csharp
private void cmdOK_Click(object sender, EventArgs e)
{
    // Cap nhat SystemInformations.FinancialYear
    SystemInformations.FinancialYear = cboFinanceYear.SelectedItem;
    this.Close();
}
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/SystemInfo.php
namespace Diepxuan\Simba\Models\SI;

class SystemInfo extends Model
{
    protected $connection = 'simba';

    public static function getFinancialYear(): ?string
    {
        return session('financial_year');
    }

    public static function setFinancialYear(string $year): void
    {
        session(['financial_year' => $year]);
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Thaydoinamtaichinh.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Thaydoinamtaichinh;

class Thaydoinamtaichinh extends Component
{
    public int $pSelectedYear;

    public function mount(): void
    {
        $this->pSelectedYear = (int)(SystemInfo::getFinancialYear() ?? date('Y'));
    }

    public function getYearsProperty(): array
    {
        $currentYear = (int)date('Y');
        $years = [];
        for ($i = $currentYear - 10; $i <= $currentYear + 10; $i++) {
            $years[] = $i;
        }
        return $years;
    }

    public function submit(): void
    {
        SystemInfo::setFinancialYear((string)$this->pSelectedYear);
        $this->emit('fiscalYearChanged', $this->pSelectedYear);
        $this->emit('closeModal');
    }

    public function render(): View
    {
        return view('catalog::si.thaydoinamtaichinh');
    }
}
```

### 3. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/thay-doi-nam-tai-chinh', [Thaydoinamtaichinh::class, 'render'])
            ->name('thaydoinamtaichinh');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire component
- [ ] Tao View
- [ ] Them Routes
- [ ] Test chuyen doi nam tai chinh
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
