# Task 024: CA - Tinh lai khe uoc

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CACalLaiKu.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Tinh toan (Calc) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Tinh lai khe uoc vay theo thang/năm.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCACalLaiKu | frmCalc | Form tinh lai |

## Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtThang | AsTextNumeric | Thang tinh lai |
| txtMa_ku | AsTextBox | Ma khe uoc |
| lblTen_TS | Label | Ten khe uoc |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| DMKU | Danh mục khế ước | Reference |
| CALAIKU | Lãi khế ước (output) | Table |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA_CAL_LAI_KU` | Tính lãi khế ước theo tháng |

**Parameters:** CompanyID, Nam, Thang, Ma_KU

## Business Logic

1. **Tháng hợp lệ**: Chỉ cho phép tháng 1-12
2. **Gọi SP tính lãi**: Tính lãi theo phương pháp đã khai báo trong DMKU
3. **Thông báo kết quả**: Hiển thị thông báo sau khi tính xong

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Calculations/Tinhlaikheuoc.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Calculations;

class Tinhlaikheuoc extends Component
{
    const MA_CT = 'CA';
    const ACTION = 'CAL_LAI_KU';

    public int $pThang;
    public ?string $pMa_ku = null;
    public bool $pIsProcessing = false;

    public function mount(): void
    {
        $this->pThang = (int) now()->format('m');
    }

    public function execute(): void
    {
        $this->pIsProcessing = true;
        // DB::executeStoredProcedure('CA_CAL_LAI_KU', [...])
        $this->pIsProcessing = false;
        session()->flash('message', 'Tinh lai thanh cong');
    }

    public function render(): View
    {
        return view('catalog::ca.calculations.tinh-lai-khe-uoc');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/catalog | DMKU | Lookup khế ước |
| diepxuan/system | Commons | Ngày tháng năm |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP CA_CAL_LAI_KU
- [ ] Tao Livewire Tinhlaikheuoc
- [ ] Tao View
- [ ] Test tinh lai theo thang
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.024`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
