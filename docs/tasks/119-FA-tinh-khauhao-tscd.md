# Task 119: FA - Tinh khau hao tai san co dinh

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | FACalKHTS.dll |
| **Module** | FA (Fixed Assets) |
| **Loai** | Calculation (Tinh toan) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang tinh khau hao TSCD tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmFACalKHTS | frmCalc | Form tinh khau hao |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_CAL_KHTS` | Tính khấu hao TSCĐ |

## Business Logic

1. **Phuong phap deu thang**: Gia tri khau hao = (Nguyen gia - GTCL) / So thang con lai
2. **Phuong phap giam dan**: Gia tri KH giam dan theo he so
3. **Hao mon luy ke**: Tong hop khau hao da trich tu dau ky
4. **Gia tri con lai**: Nguyen gia - Hao mon luy ke

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Calculations/Tinhkhauhao.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Calculations;

class Tinhkhauhao extends Component
{
    const MA_CT = 'FA';
    const ACTION = 'CAL_KHTS';

    public int $pKyBc;
    public bool $pIsProcessing = false;

    public function mount(): void
    {
        $this->pKyBc = (int) now()->format('m');
    }

    public function execute(): void
    {
        $this->pIsProcessing = true;
        DB::executeStoredProcedure('FA_CAL_KHTS', [...]);
        $this->pIsProcessing = false;
    }

    public function render(): View
    {
        return view('catalog::fa.calculations.tinh-khau-haotai-san');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/system | Commons | Ngày tháng, số dư |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP FA_CAL_KHTS
- [ ] Tao Livewire Tinhkhauhao
- [ ] Tao View
- [ ] Test cac phuong phap khau hao

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
