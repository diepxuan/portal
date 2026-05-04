# Task 121: FARptBCPT02

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 02 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT02.dll
- **Chuc nang:** Bao cao phan tich tai san 02
- **Loai:** Report (Bao cao)
- **Assembly Title:** FARptBCPT02
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT02.dll/README.md`

---

## Form classes

### frmFARptBCPT02 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_ts | AsTextBox | Ma tai san (MA_TS) |
| txtMa_Nhts1 | AsTextBox | Ma nhom TS1 (MA_NHTS, loai_nh=1) |
| txtMa_Nhts2 | AsTextBox | Ma nhom TS2 (MA_NHTS, loai_nh=2) |
| txtMa_Nhts3 | AsTextBox | Ma nhom TS3 (MA_NHTS, loai_nh=3) |
| txtMa_BPSD | AsTextBox | Ma bo phan su dung (MA_BPSD) |
| txtMa_Phi | AsTextBox | Ma phi (MA_PHI) |
| txtMa_SPCT | AsTextBox | Ma SPCT (MA_SPCT) |
| cboTheo_nhom | ComboBox | Theo nhom (BP su dung, Ma phi, Ma SPCT) |

### Lookup Conditions

| Control | LookupCode | WhereCondition |
|---------|------------|----------------|
| txtMa_Nhts1 | MA_NHTS | loai_nh='1' |
| txtMa_Nhts2 | MA_NHTS | loai_nh='2' |
| txtMa_Nhts3 | MA_NHTS | loai_nh='3' |

---

## Business Logic

### Business Rules

1. **Loc theo nhom TS 3 cap**: Nhom theo nhieu cap de phan tich chi tiet
2. **Loc theo BPSD/Phi/SPCT**: Cac tieu chi bo sung
3. **Hien thi nguon von**: Lay ten nguon von tu Commons.FAGetTenNguonVon()

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/Baocaophantich02.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class Baocaophantich02 extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'BCPT02';

    public ?string $pMa_ts = null;
    public ?string $pMa_Nhts1 = null;
    public ?string $pMa_Nhts2 = null;
    public ?string $pMa_Nhts3 = null;
    public ?string $pMa_BPSD = null;
    public ?string $pMa_Phi = null;
    public ?string $pMa_SPCT = null;
    public string $pTheo_nhom = 'BP su dung';
    public array $pNguonVon = [];

    public function mount(): void
    {
        // Lay ten nguon von
        $this->pNguonVon = $this->getTenNguonVon();
    }

    public function render(): View
    {
        return view('catalog::fa.reports.baocao-phan-tich-02');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-phan-tich-02', [Baocaophantich02::class, 'render'])
    ->name('catalog.fa.reports.phan-tich-02');
```

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_BCPT02_GET` | Lay du lieu phan tich 02 |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCPT02_GET
- [ ] Tao Livewire Baocaophantich02
- [ ] Tao View baocao-phan-tich-02.blade.php
- [ ] Them Routes
- [ ] Test hien thi nguon von