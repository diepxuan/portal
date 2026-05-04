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

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| INVENTORY | Tồn kho | Transaction |
| INVT | Vật tư | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `IN_CAL_GIA_TB` | Tính giá trung bình tháng |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | IN | Module tồn kho |
| diepxuan/catalog | DMVT | Lookup vật tư |
| diepxuan/system | Commons | Ngày tháng, số dư |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_CAL_GIA_TB
- [ ] Tao Livewire Tinhgiatrungbinhthang
- [ ] Tao View tinh-gia-trung-binh-thang.blade.php
- [ ] Them Routes
- [ ] Test cac kieu phat sinh chenhlech