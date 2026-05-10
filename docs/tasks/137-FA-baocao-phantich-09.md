# Task 137: FARptBCPT09

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 09 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT09.dll
- **Chuc nang:** Bao cao phan tich tai san 09
- **Loai:** Report (Bao cao)
- **Assembly Title:** FARptBCPT09
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT09.dll/README.md`

---

## Form classes

### frmFARptBCPT09 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboTheo_nhom | ComboBox | Theo nhom (BP su dung/Ma phi/Ma SPCT) |
| txtMa_BPSD | AsTextBox | Ma bo phan su dung (MA_BPSD) |
| txtMa_Phi | AsTextBox | Ma phi (MA_PHI) |
| txtMa_SPCT | AsTextBox | Ma SPCT (MA_SPCT) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao |
| cboMau_bc | ComboBox | Mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |

### ComboBox Items (cboTheo_nhom)

| Index | Gia tri | Mo ta |
|-------|---------|-------|
| 0 | "BP su dung" | Nhom theo bo phan su dung |
| 1 | "Ma phi" | Nhom theo ma phi |
| 2 | "Ma SPCT" | Nhom theo san pham cong trinh |

---

## Business Logic

### Business Rules

1. **Nhom theo 3 tieu chi**: BP su dung, Ma phi, Ma SPCT
2. **Controls an**: cboTheo_nhom hien dang an (mac dinh nhom theo "BP su dung")

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/Baocaophantich09.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class Baocaophantich09 extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'BCPT09';

    public string $pTheo_nhom = 'BP su dung';
    public ?string $pMa_BPSD = null;
    public ?string $pMa_Phi = null;
    public ?string $pMa_SPCT = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public ?int $pKyBc = null;
    public ?int $pMau_bc = null;
    public string $pTieuDe = '';

    public function render(): View
    {
        return view('catalog::fa.reports.baocao-phan-tich-09');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-phan-tich-09', [Baocaophantich09::class, 'render'])
    ->name('catalog.fa.reports.phan-tich-09');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | Baocaophantich09.php | Report viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCPT09_GET
- [ ] Tao Livewire Baocaophantich09
- [ ] Tao View baocao-phan-tich-09.blade.php
- [ ] Them Routes
- [ ] Test nhom theo 3 tieu chi
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
