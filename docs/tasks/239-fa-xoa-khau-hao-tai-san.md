# Task 239: FADelKHTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang xoa khau hao tai san co dinh tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADelKHTS.dll
- **Chuc nang:** Xoa khau hao tai san co dinh
- **Loai:** Tinh toan (Calculator)
- **Assembly Title:** Xoa khau hao tai san co dinh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Calculator)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADelKHTS.dll/README.md`

---

## Form classes

### frmFADelKHTS (Form xoa khau hao)
- **Ke thua:** frmCalc
- **Chuc nang:** Xoa khau hao tai san cu the

### Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| cboKyBc | AsComboBox | - | Chon thang bao cao |
| txtMa_Ts | AsTextBox | MA_TS | Ma tai san |
| lblThang | Label | - | Nhan "Thang" |
| lblMa_ts | Label | - | Nhan "Ma tai san" |
| lblTen_TS | Label | - | Ten tai san (auto) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_DEL_KHTS | Xoa khau hao tai san |

---

## Business Logic

### Business Rules

1. **Xoa khau hao**:
   - Chon thang va nhap ma tai san
   - Xoa du lieu khau hao cua TS trong thang do

2. **Kiem tra khoa so**:
   - Khong cho xoa neu thang da khoa so

3. **AutoLookup**:
   - Hien thi ten tai san khi nhap ma

---

## Mapping PHP

### 1. Calculator Service

```php
// diepxuan/laravel-catalog/src/Services/Calculators/FA/DelKHTService.php
namespace Diepxuan\Catalog\Services\Calculators\FA;

class DelKHTService
{
    public function delete(
        string $ma_cty,
        int $nam,
        string $thang,
        string $ma_ts,
        string $par1 = ''
    ): array {
        // Goi SP xoa khau hao
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Calculator/XoaKhauHao.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Calculator;

class XoaKhauHao extends Component
{
    const MA_CT = 'FA';

    public string $pKyBc = '';
    public string $pMa_Ts = '';
    public string $pTen_Ts = '';
    public bool $pIsProcessing = false;

    public function updatedPMaTs(string $value): void
    {
        // AutoLookup ten tai san
    }

    public function execute(): void
    {
        // Xoa khau hao
    }

    public function render(): View
    {
        return view('catalog::fa.calculator.xoa-khau-hao');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Calculator Service | laravel-catalog | DelKHTService.php | Logic |
| Component | laravel-catalog | XoaKhauHao.php | UI |
| SP | laravel-simba | AsFADelKHTS.php | Data source |
| View | laravel-catalog | xoa-khau-hao.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Calculator Service DelKHTService
- [ ] Tao Livewire XoaKhauHao
- [ ] Tao View form
- [ ] Them Routes
- [ ] Test delete execution
- [ ] Test locked period validation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `fa.vch.xoakh`
- **Note:** Shell/voucher; write blocked until payload audit.
