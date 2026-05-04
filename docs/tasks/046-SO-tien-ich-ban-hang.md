# Task 046: SO - Tien ich ban hang

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | SOUtilities.dll |
| **Module** | SO (Sales Order) |
| **Loai** | Utility Library |
| **Trang thai** | Da phan tich |

## Muc tieu
Su dung thu vien tien ich SO cho cac chuc nang ban hang.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| SO | Don hang ban | Transaction |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| (Library class) | - | Cac ham tien ich |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| (Library) | Ham tien ich goi noi bo | Utility |

## Business Logic

1. **Shared functions**: Cac ham dung chung cho module SO
2. **Validation helpers**: Ham kiem tra du lieu ban hang
3. **Format helpers**: Ham dinh dang so lieu ban hang

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Services/SO/TienichBanhang.php
namespace Diepxuan\Catalog\Services\SO;

class TienichBanhang
{
    public static function tinhGiaTriDonHang(array $items): float;
    public static function kiemTraHangTra(string $ma_vt): bool;
    public static function tinhChietKhau(float $tong_tien, float $ty_le): float;
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | SO | Module ban hang |
| diepxuan/system | Commons | Ham chung |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Xac dinh cac ham tien ich can dung
- [ ] Tao PHP helper class
- [ ] Tich hop vao cac Livewire SO