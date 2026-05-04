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

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| INVENTORY | Tồn kho | Transaction |
| INVT | Vật tư | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `IN_CAL_GIA_BQDD` | Tính giá bình quân di động |

**Parameters:** CompanyID, KyBc, Ma_kho, Ma_NhVt, Ma_vt, Ma_tkvt, Kieu_ps, Tk_cl

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | IN | Module tồn kho |
| diepxuan/catalog | DMVT | Lookup vật tư |
| diepxuan/system | Commons | Ngày tháng, số dư |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_CAL_GIA_BQDD
- [ ] Tao Livewire Tinhgiabinhquandidong
- [ ] Tao View tinh-gia-binh-quan-di-dong.blade.php
- [ ] Them Routes
- [ ] Test cac kieu phat sinh chenh lech