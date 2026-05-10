# Task 025: CA - Xoa lai khe uoc

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CADelLaiKu.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Tinh toan (Calc) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Xoa lai khe uoc da tinh - dung khi can tinh lai lai.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCADelLaiKu | frmCalc | Form xoa lai |

## Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtThang | AsTextNumeric | Thang can xoa lai |
| txtMa_ku | AsTextBox | Ma khe uoc (trong de xoa tat ca) |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CALAIKU | Lãi khế ước (xóa) | Table |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA_DEL_LAI_KU` | Xóa lãi khế ước đã tính |

**Parameters:** CompanyID, Nam, Thang, Ma_KU (null = xóa tất cả)

## Business Logic

1. **Xóa tất cả**: Nếu Ma_KU rỗng → xóa toàn bộ lãi trong tháng
2. **Xóa theo khế ước**: Nếu có Ma_KU → chỉ xóa lãi của khế ước đó
3. **Confirm trước khi xóa**: Cảnh báo người dùng xác nhận

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Calculations/Xoalaikheuoc.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Calculations;

class Xoalaikheuoc extends Component
{
    const MA_CT = 'CA';
    const ACTION = 'DEL_LAI_KU';

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
        DB::executeStoredProcedure('CA_DEL_LAI_KU', [...]);
        $this->pIsProcessing = false;
    }

    public function render(): View
    {
        return view('catalog::ca.calculations.xoa-lai-khe-uoc');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/catalog | CALAIKU | Bảng lãi khế ước |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP CA_DEL_LAI_KU
- [ ] Tao Livewire Xoalaikheuoc
- [ ] Tao View
- [ ] Test xoa lai
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
