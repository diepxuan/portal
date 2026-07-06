# Task 221: SI-Sap-Xep-Lai-So-Chung-Tu

## Nhom: SI (System Integration)

## Muc tieu
Chuyen doi chuc nang sap xep lai so chung tu tu .NET sang PHP Laravel, dat ket qua tuong duong SiReOrderVoucherNumber.

## Chi tiet
- **DLL:** SiReOrderVoucherNumber.dll
- **Chuc nang:** Sap xep lai so chung tu (Reorder Voucher Number)
- **Loai:** Utility (UTL)
- **Assembly Title:** Ket chuyen tu dong
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Product:** AsiaERP

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SiReOrderVoucherNumber.dll/README.md`

---

## Form classes

### frmSiReOrderVoucherNumber (Form chinh)
- **Ke thua:** frmAsiaRoot
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | AsComboBox | Ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Khoang ngay |
| chkSelectAll | AsCheckBox | Chon tat ca |
| dgvDmKC | AsDataGridView | Danh sach but toan |
| cmdKc | Button | Thuc hien |
| cmdCancel | Button | Huy |
| prbExecute | ProgressBar | Tien trinh |
| bgwk | BackgroundWorker | Xu ly nen |

### DataGridView Columns

| Column | DataField | Mo ta |
|--------|-----------|-------|
| colSelect | Select | Checkbox chon |
| colTT_BT | TT_BT | So thu tu |
| dgvcMa_ct_me | Ma_ct_me | Ma chung tu me |
| colTenBT | TenBT | Ten but toan |
| dgvcVn_prefix | Vn_prefix | Prefix |
| dgvcVn_pattern | Vn_pattern | Pattern |
| dgvcVn_width | Vn_width | Do rong so |
| dgvcKieuTrung | KieuTrung | Kieu trung |
| dgvcSoctMax | SoctMax | So CT max |
| dgvcSo_ct | So_ct | So CT hien tai |

---

## Business Logic

### Xu ly background

```csharp
// Use BackgroundWorker de xu ly nen
// Update ProgressBar
// Ho tro huy bo (cmdCancel)
```

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Sapxeploisochungtu.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Sapxeploisochungtu;

class Sapxeploisochungtu extends Component
{
    public ?string $pKyBc = null;
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public bool $pSelectAll = false;

    public Collection $pDmKcList;
    public float $pProgress = 0;
    public bool $pIsProcessing = false;

    public function mount(): void
    {
        $this->loadDmKcList();
    }

    public function loadDmKcList(): void
    {
        // Load tu SP
    }

    public function execute(): void
    {
        $this->pIsProcessing = true;
        $this->pProgress = 0;

        // Process trong queue/job
        // Update progress

        $this->pIsProcessing = false;
    }

    public function cancel(): void
    {
        // Huy xu ly
    }

    public function render(): View
    {
        return view('catalog::si.sapxeploisochungtu');
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/sap-xep-lai-so-chung-tu', [Sapxeploisochungtu::class, 'render'])
            ->name('sapxeploisochungtu');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire component
- [ ] Tao View
- [ ] Implement background processing
- [ ] Them Routes
- [ ] Test sap xep lai so chung tu
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `si.tool.sortno`
- **Note:** Shell hoặc route hiện hữu; side-effect blocked nếu chưa audit payload.
