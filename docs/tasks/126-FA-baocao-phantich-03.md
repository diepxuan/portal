# Task 126: FARptBCPT03

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 03 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT03.dll
- **Chuc nang:** Bao cao phan tich tai san 03
- **Loai:** Report (Bao cao)
- **Assembly Title:** FARptBCPT03
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT03.dll/README.md`

---

## Form classes

### frmFARptBCPT03 (Form bao cao)
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

---

## Business Logic

### Business Rules

1. **Loc theo nhom TS 3 cap**: Nhom theo nhieu cap
2. **Hien thi nguon von**: Lay ten nguon von tu FAGetTenNguonVon()

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/Baocaophantich03.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class Baocaophantich03 extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'BCPT03';

    public ?string $pMa_ts = null;
    public ?string $pMa_Nhts1 = null;
    public ?string $pMa_Nhts2 = null;
    public ?string $pMa_Nhts3 = null;
    public ?string $pMa_BPSD = null;
    public ?string $pMa_Phi = null;
    public ?string $pMa_SPCT = null;
    public array $pNguonVon = [];

    public function render(): View
    {
        return view('catalog::fa.reports.baocao-phan-tich-03');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-phan-tich-03', [Baocaophantich03::class, 'render'])
    ->name('catalog.fa.reports.phan-tich-03');
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
| `FA_BCPT03_GET` | Lay du lieu phan tich 03 |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCPT03_GET
- [ ] Tao Livewire Baocaophantich03
- [ ] Tao View baocao-phan-tich-03.blade.php
- [ ] Them Routes