# Task 113: INCalGiaTB

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang tinh gia trung binh thang tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INCalGiaTB.dll
- **Chuc nang:** Tinh gia trung binh thang
- **Loai:** Calculation (Tinh toan)
- **Assembly Title:** Tinh gia trung binh thang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (calculation)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INCalGiaTB.dll/README.md`

---

## Form classes

### frmINCalGiaTB (Form tinh toan)
- **Ke thua:** frmCalc

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky tinh gia |
| txtMa_kho | AsTextBox | Ma kho (loc) |
| txtNh_vt | AsTextBox | Nhom vat tu (loc) |
| txtMa_vt | AsTextBox | Ma vat tu (loc) |
| txtMa_tkvt | AsTextBox | TK vat tu (loc) |
| cboKieu_ps | ComboBox | Kieu tao phat sinh chenhlech (0/1/2) |
| txttk_cl | AsTextBox | TK chenhlech (mac dinh 632) |

### Kieu tao phat sinh chenhlech

| Gia tri | Mo ta |
|---------|-------|
| 0 | Khong tao |
| 1 | Chi tao khi sl=0, tien#0 |
| 2 | Tao cho tat ca truong hop co chenhlech |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_CAL_GIA_TB | Tinh gia trung binh thang |

### SP_CAL (reference)

```sql
-- Tinh gia trung binh thang
EXEC SP_IN_CAL_GIA_TB
    @pMa_cty VARCHAR(50),
    @pKyBc VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pNh_vt VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_tkvt VARCHAR(50) = NULL,
    @pKieu_ps INT = 0,
    @pTk_cl VARCHAR(20) = '632'
```

---

## Business Logic

### Calculation Rules

Gia trung binh thang = Tong gia tri / Tong so luong (tinh cuoi ky)

### Business Rules

1. **Tinh cuoi ky**: Tinh gia trung binh sau khi ket thuc ky
2. **Xu ly chenhlech**: Giong INCalGiaBQDD nhung tinh cho ca ky

---

## Mapping PHP

### 1. Livewire Component (Calculation)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Calculations/Tinhgiatrungbinhthang.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Calculations;

class Tinhgiatrungbinhthang extends Component
{
    const MA_CT = 'IN';
    const ACTION = 'CAL_GIA_TB';

    public ?int $pKyBc = null;
    public ?string $pMa_kho = null;
    public ?string $pNh_vt = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_tkvt = null;
    public int $pKieu_ps = 0;
    public ?string $pTk_cl = '632';

    public function execute(): void
    {
        // Goi SP tinh gia trung binh thang
    }

    public function render(): View
    {
        return view('catalog::in.calculations.tinh-gia-trung-binh-thang');
    }
}
```

### 2. Routes

```php
Route::get('/tinh-gia-trung-binh-thang', [Tinhgiatrungbinhthang::class, 'render'])
    ->name('catalog.in.calculations.gia-tb');
```

---

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINCalGiaTB.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINCalGiaTB extends StoredProcedure
{
    protected $procedure = 'SP_IN_CAL_GIA_TB';
    protected $params = ['pMa_cty', 'pKyBc', 'pMa_kho', 'pNh_vt', 'pMa_vt', 'pMa_tkvt', 'pKieu_ps', 'pTk_cl'];
}
```

### 3. Views

```
resources/views/catalog/in/calculations/
└── tinh-gia-trung-binh-thang.blade.php   (Calculation form)
```

### 4. Routes

```php
Route::prefix('catalog/in/calculations')
    ->name('catalog.in.calculations.')
    ->group(function () {
        Route::get('/tinh-gia-trung-binh-thang', [Tinhgiatrungbinhthang::class, 'render'])
            ->name('gia-tb');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | Tinhgiatrungbinhthang.php | Calculation form |
| SP | laravel-simba | AsINCalGiaTB.php | Tinh gia TB thang |
| Model | laravel-simba | DMKHO.php | Lookup kho |
| Model | laravel-simba | DMVT.php | Lookup vat tu |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_CAL_GIA_TB
- [ ] Tao Livewire Tinhgiatrungbinhthang
- [ ] Tao View tinh-gia-trung-binh-thang.blade.php
- [ ] Them Routes
- [ ] Test cac kieu phat sinh chenhlech
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
