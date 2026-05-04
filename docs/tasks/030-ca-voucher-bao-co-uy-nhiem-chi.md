# Task 030: CA - Voucher bao co uy nhiem chi

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CAVchCA4.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Voucher |
| **Trang thai** | Da phan tich |
| **Ma CT** | CA4 |

## Mo ta chuc nang

Nhap chung tu bao co (Uy nhiem chi) - chi tra tien qua ngan hang.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCaVchCA4 | frmVoucher | Form nhap lieu chinh |
| frmCaVchCA4Find | frmVoucherFind | Form tim kiem |
| frmCaVchCA4Print | frmVoucherPrint | Form in |

## Controls - Header

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | Ma_Kh | Ma khach hang |
| txtDien_giai | TextBox | Dien_Giai | Dien giai |
| txtTk_No | AsTextBox | tk_no | TK nợ (NH) |

## CSDL

| Bang | Mo ta |
|------|-------|
| CA4PH | Bao co header |
| CA4CT | Bao co chi tiet |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CA4PH | Báo có header | Header |
| CA4CT | Báo có chi tiết | Detail |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA4PH_Get` | Lấy danh sách báo có |
| `CA4PH_Insert` | Thêm báo có header |
| `CA4PH_Update` | Cập nhật báo có header |
| `CA4PH_Delete` | Xóa báo có header |
| `CA4CT_Insert` | Thêm dòng chi tiết |
| `CA4CT_Delete` | Xóa dòng chi tiết |

## Business Logic

1. **Báo có UNC**: Nhận thông báo có tiền từ ngân hàng (ứng với CA2 - chi tiền)
2. **Tỷ giá**: Tự động load theo mã ngoại tệ
3. **TK Nợ**: TK ngân hàng trả tiền

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Vouchers/Baocouynhiemchi.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Vouchers;

class Baocouynhiemchi extends Component
{
    const MA_CT = 'CA4';

    public function render(): View
    {
        return view('catalog::ca.vouchers.bao-co-uy-nhiem-chi');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/system | Commons | AutoCode, FormatDate |
| diepxuan/system | Lookup | Tra cứu TK |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CA4PH, CA4CT
- [ ] Tao Livewire Baocouynhiemchi
- [ ] Tao View
- [ ] Test CRUD