# Task 235: INCalGiaNTXT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang tinh gia nhap truoc xuat truoc (FIFO) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INCalGiaNTXT.dll
- **Chuc nang:** Tinh gia nhap truoc xuat truoc (FIFO)
- **Loai:** Tinh toan (Calculator)
- **Assembly Title:** Tinh gia nhap truoc xuat truoc
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** IN (Calculator)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INCalGiaNTXT.dll/README.md`

---

## Form classes

### frmINCalGiaNTXT (Form tinh gia FIFO)
- **Ke thua:** frmCalc
- **Chuc nang:** Tinh gia xuat kho theo FIFO

### Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| cboKyBc | AsComboBox | - | Ky bao cao/tinh gia |
| txtMa_kho | AsTextBox | MA_KHO | Ma kho |
| lblTen_kho | Label | - | Ten kho |
| txtMa_nhvt | AsTextBox | MA_NHVT | Ma nhom vat tu |
| lblTen_nhvt | Label | - | Ten nhom VT |
| txtMa_vt | AsTextBox | MA_VT | Ma vat tu |
| lblTen_vt | Label | - | Ten vat tu |
| bgWorker | BackgroundWorker | - | Xu ly background |
| cmdOK | Button | - | Nut thuc hien tinh gia |
| cmdCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_CAL_FIFO | Tinh gia xuat kho FIFO |

### SP_CAL (reference)

```sql
-- Tinh gia xuat kho FIFO
EXEC SP_IN_CAL_FIFO
    @pMa_cty VARCHAR(50),
    @pKy_bc VARCHAR(50),
    @pFinancialYear INT,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nhvt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Tinh gia FIFO**:
   - First In First Out - Nhap truoc xuat truoc
   - Gia tri xuat = gia tri nhap cu nhat con ton

2. **Loc theo dieu kien**:
   - Tat ca cac kho
   - Theo kho cu the
   - Theo nhom vat tu
   - Theo vat tu cu the

3. **Kiem tra khoa so**:
   - Khong cho tinh gia cho ky da khoa so
   - Ngay ket thuc ky > ngay khoa so

4. **Xu ly background**:
   - Su dung BackgroundWorker de tranh treo UI
   - Hien thi tien trinh tinh toan

---

## Mapping PHP

### 1. Calculator Service

```php
// diepxuan/laravel-catalog/src/Services/Calculators/IN/FIFOCalculatorService.php
namespace Diepxuan\Catalog\Services\Calculators\IN;

class FIFOCalculatorService
{
    public function calculate(
        string $ma_cty,
        string $ky_bc,
        int $financial_year,
        ?string $ma_vt = null,
        ?string $ma_nhvt = null,
        ?string $ma_kho = null
    ): array {
        // Goi SP tinh gia FIFO
        // Tra ve ket qua tinh toan
    }

    public function validateLockedPeriod(string $ky_bc): bool
    {
        // Kiem tra ngay khoa so
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Calculator/TinhGiaFIFO.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Calculator;

class TinhGiaFIFO extends Component
{
    const MA_CT = 'IN';

    public string $pKyBc = '';
    public string $pMa_Kho = '';
    public string $pMa_Nhvt = '';
    public string $pMa_Vt = '';
    public bool $pIsProcessing = false;
    public ?string $pError = null;

    public function calculate(): void
    {
        // Validate & goi calculator service
        // Cap nhat progress
    }

    public function render(): View
    {
        return view('catalog::in.calculator.tinh-gia-fifo');
    }
}
```

### 3. Views

```
resources/views/catalog/in/calculator/
├── tinh-gia-fifo.blade.php      (Main form)
└── _tinh-gia-fifo-progress.blade.php (Progress indicator)
```

### 4. Routes

```php
Route::get('/catalog/in/calculator/tinh-gia-fifo', [TinhGiaFIFO::class, 'render'])
    ->name('catalog.in.calculator.tinh-gia-fifo');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Calculator Service | laravel-catalog | FIFOCalculatorService.php | Logic tinh toan |
| Component | laravel-catalog | TinhGiaFIFO.php | UI |
| SP | laravel-simba | AsINCalFIFO.php | Data source |
| View | laravel-catalog | tinh-gia-fifo.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Calculator Service FIFOCalculatorService
- [ ] Tao Livewire TinhGiaFIFO
- [ ] Tao View filter form
- [ ] Them Routes
- [ ] Test calculator execution
- [ ] Test background processing
- [ ] Test locked period validation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `in.vch.in5`
- **Note:** Shell/voucher; write blocked until payload audit.
