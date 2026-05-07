# Task 110: INCalGiaBQDD

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang tinh gia binh quan di dong tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INCalGiaBQDD.dll
- **Chuc nang:** Tinh gia binh quan di dong (Moving Average)
- **Loai:** Calculation (Tinh toan)
- **Assembly Title:** Tinh gia binh quan di dong
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (calculation)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INCalGiaBQDD.dll/README.md`

---

## Form classes

### frmINCalGiaBQDD (Form tinh toan)
- **Ke thua:** frmCalc

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky tinh gia |
| txtMa_kho | AsTextBox | Ma kho (loc) |
| txtMa_NhVt | AsTextBox | Nhom vat tu (loc) |
| txtMa_vt | AsTextBox | Ma vat tu (loc) |
| txtMa_tkvt | AsTextBox | TK vat tu (loc) |
| cboKieu_ps | ComboBox | Kieu tao phat sinh chenh lech (0/1/2) |
| txttk_cl | AsTextBox | TK chenh lech (mac dinh 632) |

### Kieu tao phat sinh chenh lech

| Gia tri | Mo ta |
|---------|-------|
| 0 | Khong tao |
| 1 | Chi tao khi sl=0, tien#0 |
| 2 | Tao cho tat ca truong hop co chenh lech |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_CAL_GIA_BQDD | Tinh gia binh quan di dong |

### SP_CAL (reference)

```sql
-- Tinh gia binh quan di dong
EXEC SP_IN_CAL_GIA_BQDD
    @pMa_cty VARCHAR(50),
    @pKyBc VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_NhVt VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_tkvt VARCHAR(50) = NULL,
    @pKieu_ps INT = 0,
    @pTk_cl VARCHAR(20) = '632'
```

---

## Business Logic

### Calculation Rules

Gia binh quan di dong = (Ton hien tai * Gia cu + Nhap moi * Gia nhap) / Tong so luong

### Business Rules

1. **Tinh sau moi lan nhap**: Cap nhat lien tuc theo phat sinh
2. **Xu ly chenh lech**:
   - TK chenh lech mac dinh = 632 (Gia von hang ban)
   - Tao phat sinh dieu chinh khi co chenh lech gia
3. **Loc theo ky**: Chi tinh cho vat tu phat sinh trong ky

---

## Mapping PHP

### 1. Livewire Component (Calculation)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Calculations/Tinhgiabinhquandidong.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Calculations;

class Tinhgiabinhquandidong extends Component
{
    const MA_CT = 'IN';
    const ACTION = 'CAL_GIA_BQDD';

    public ?int $pKyBc = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_NhVt = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_tkvt = null;
    public int $pKieu_ps = 0;
    public ?string $pTk_cl = '632';
    public bool $pIsProcessing = false;

    public function execute(): void
    {
        $this->pIsProcessing = true;
        // Goi SP tinh gia binh quan di dong
        $this->pIsProcessing = false;
    }

    public function render(): View
    {
        return view('catalog::in.calculations.tinh-gia-binh-quan-di-dong');
    }
}
```

### 2. Routes

```php
Route::get('/tinh-gia-binh-quan-di-dong', [Tinhgiabinhquandidong::class, 'render'])
    ->name('catalog.in.calculations.gia-bqdd');
```

---

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINCalGiaBQDD.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINCalGiaBQDD extends StoredProcedure
{
    protected $procedure = 'SP_IN_CAL_GIA_BQDD';
    protected $params = ['pMa_cty', 'pKyBc', 'pMa_kho', 'pMa_NhVt', 'pMa_vt', 'pMa_tkvt', 'pKieu_ps', 'pTk_cl'];
}
```

### 3. Views

```
resources/views/catalog/in/calculations/
└── tinh-gia-binh-quan-di-dong.blade.php   (Calculation form)
```

### 4. Routes

```php
Route::prefix('catalog/in/calculations')
    ->name('catalog.in.calculations.')
    ->group(function () {
        Route::get('/tinh-gia-binh-quan-di-dong', [Tinhgiabinhquandidong::class, 'render'])
            ->name('gia-bqdd');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | Tinhgiabinhquandidong.php | Calculation form |
| SP | laravel-simba | AsINCalGiaBQDD.php | Tinh gia BQDD |
| Model | laravel-simba | DMKHO.php | Lookup kho |
| Model | laravel-simba | DMVT.php | Lookup vat tu |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_CAL_GIA_BQDD
- [ ] Tao Livewire Tinhgiabinhquandidong
- [ ] Tao View tinh-gia-binh-quan-di-dong.blade.php
- [ ] Them Routes
- [ ] Test cac kieu phat sinh chenh lech