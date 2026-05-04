# Task 031: CA - Voucher khe uoc vay

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CAVchCA5.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Voucher |
| **Trang thai** | Da phan tich |
| **Ma CT** | CA5 (CA51, CA52, CA53) |

## Mo ta chuc nang

Nhap chung tu khe uoc vay - giai ngan, tra goc, tra lai.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCaVchCA5 | frmVoucher | Form nhap lieu chinh |
| frmCaVchCA5Find | - | Form tim kiem |
| frmCaVchCA5FindCA2 | - | Form tim lien ket PC |
| frmCaVchCA5Print | - | Form in |

## Loai chung tu

| Ma CT | Mo ta |
|-------|-------|
| CA51 | Giai ngan vay |
| CA52 | Tra goc vay |
| CA53 | Tra lai vay |

## Controls - Header

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | Ma_Kh | Ma ngan hang |
| txtTk_Co | AsTextBox | tk_co | TK co (NH) |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtT_Tien | AsTextNumeric | t_tien | Tong tien |

## CSDL

| Bang | Mo ta |
|------|-------|
| CA5PH | Khế ước header |
| CA5CT | Khế ước chi tiết |
| CA5TAIN | Thuế đầu vào |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CA5PH | Khế ước header | Header |
| CA5CT | Khế ước chi tiết | Detail |
| CA5TAIN | Thuế đầu vào | Tax |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA5PH_Get` | Lấy danh sách chứng từ KHU |
| `CA5PH_Insert` | Thêm header |
| `CA5PH_Update` | Cập nhật header |
| `CA5PH_Delete` | Xóa header |
| `CA5CT_Insert` | Thêm dòng chi tiết |
| `CA5CT_Delete` | Xóa dòng chi tiết |

## Business Logic

1. **CA51 - Giải ngân**: Ghi nhận số tiền vay từ KHU, TK Nợ = TK NH, TK Có = TK vay
2. **CA52 - Trả gốc**: Giảm dư nợ KHU, TK Nợ = TK vay, TK Có = TK NH
3. **CA53 - Trả lãi**: Thanh toán lãi KHU, TK Nợ = TK chi phí, TK Có = TK NH
4. **Cập nhật CADKU**: Giảm dư nợ khi trả gốc/lãi

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Vouchers/Kheuocvay.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Vouchers;

class Kheuocvay extends Component
{
    const MA_CT = 'CA5';

    public string $pLoai = 'CA51'; // CA51/CA52/CA53

    public function render(): View
    {
        return view('catalog::ca.vouchers.khe-uoc-vay');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/catalog | DMKU | Lookup khế ước |
| diepxuan/catalog | CADKU | Cập nhật công nợ KHU |
| diepxuan/system | Commons | AutoCode, FormatDate |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CA5PH, CA5CT
- [ ] Tao Livewire Kheuocvay
- [ ] Tao View (3 loại CT)
- [ ] Test CRUD & cap nhat CADKU