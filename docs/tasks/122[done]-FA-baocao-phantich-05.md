# Task 122: FARptBCPT05

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 05 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT05.dll
- **Chuc nang:** Bao cao phan tich tai san 05
- **Loai:** Report (Bao cao)
- **Assembly Title:** FARptBCPT05
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT05.dll/README.md`

---

## Form classes

### frmFARptBCPT05 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_BPSD | AsTextBox | Ma bo phan su dung (MA_BPSD) |
| txtMa_Phi | AsTextBox | Ma phi (MA_PHI) |
| txtMa_SPCT | AsTextBox | Ma SPCT (MA_SPCT) |
| cboTheo_nhom | ComboBox | Theo nhom (an) |

---

## Business Logic

### Business Rules

1. **Nhom theo BPSD/Phi/SPCT**: Chon tieu chi nhom bao cao
2. **Controls an**: cboTheo_nhom hien dang an trong UI

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/Baocaophantich05.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class Baocaophantich05 extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'BCPT05';

    public ?string $pMa_BPSD = null;
    public ?string $pMa_Phi = null;
    public ?string $pMa_SPCT = null;
    public string $pTheo_nhom = 'BP su dung'; // Mac dinh

    public function render(): View
    {
        return view('catalog::fa.reports.baocao-phan-tich-05');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-phan-tich-05', [Baocaophantich05::class, 'render'])
    ->name('catalog.fa.reports.phan-tich-05');
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
| `FA_BCPT05_GET` | Lay du lieu phan tich 05 |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCPT05_GET
- [ ] Tao Livewire Baocaophantich05
- [ ] Tao View baocao-phan-tich-05.blade.php
- [ ] Them Routes
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `fa.rpt shell`
- **Note:** Calculation/transfer/voucher shell chưa execute side-effect khi chưa audit payload.
