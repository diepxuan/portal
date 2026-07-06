# Task 029: CA - Voucher bao no ngan hang

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CAVchCA3.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Voucher |
| **Trang thai** | Da phan tich |
| **Ma CT** | CA3 |

## Mo ta chuc nang

Nhap chung tu bao no ngan hang (Uy nhiem chi).

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCaVchCA3 | frmVoucher | Form nhap lieu chinh |
| frmCaVchCA3Find | - | Form tim kiem |

## Controls - Header

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | Ma_Kh | Ma khach hang |
| txtTk_No | AsTextBox | tk_no | TK no (NH) |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| txtT_Tien | AsTextNumeric | t_tien | Tong tien |

## CSDL

| Bang | Mo ta |
|------|-------|
| CA3PH | Bao no NH header |
| CA3CT | Bao no NH chi tiet |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CA3PH | Báo nợ NH header | Header |
| CA3CT | Báo nợ NH chi tiết | Detail |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA3PH_Get` | Lấy danh sách báo nợ |
| `CA3PH_Insert` | Thêm báo nợ header |
| `CA3PH_Update` | Cập nhật báo nợ header |
| `CA3PH_Delete` | Xóa báo nợ header |
| `CA3CT_Insert` | Thêm dòng chi tiết |
| `CA3CT_Delete` | Xóa dòng chi tiết |

## Business Logic

1. **Báo nợ NH**: Nhận thông báo nợ từ ngân hàng (ứng với CA1 - thu tiền)
2. **Tỷ giá**: Tự động load theo mã ngoại tệ
3. **Đối tượng**: TK Nợ = TK ngân hàng nhận

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Vouchers/BaonoNganhang.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Vouchers;

class BaonoNganhang extends Component
{
    const MA_CT = 'CA3';

    public function render(): View
    {
        return view('catalog::ca.vouchers.bao-no-ngan-hang');
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
- [ ] Tao Model CA3PH, CA3CT
- [ ] Tao Livewire BaonoNganhang
- [ ] Tao View
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
\n## Portal implementation status\n\n- **Status:** DONE (route/component exists)\n- **Source:** SimbaRouteRegistry voucher mapping CA1/CA2/CA4 and existing Cash Livewire screens.\n
