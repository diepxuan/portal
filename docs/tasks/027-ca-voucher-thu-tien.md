# Task 027: CA - Voucher thu tien

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CAVchCA1.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Voucher |
| **Trang thai** | Da phan tich |
| **Ma CT** | CA1 |

## Mo ta chuc nang

Nhap chung tu thu tien mat/chuyen khoan (Phieu thu).

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCaVchCA1 | frmVoucher | Form nhap lieu chinh |
| frmCAVchCA1Find | - | Form tim kiem |

## Controls - Header

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | Ma_Kh | Ma khach hang |
| txtDien_giai | TextBox | Dien_Giai | Dien giai |
| txtTk_No | AsTextBox | tk_no | TK no (TM/NH) |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| txtT_tien_Nt | AsTextNumeric | t_tien_nt | Tong tien NT |
| txtT_Tien | AsTextNumeric | t_tien | Tong tien |

## Controls - Detail Grid

| Column | Type | Mo ta |
|--------|------|-------|
| dgvcTk | DataGridViewAsTextBoxColumn | TK co |
| dgvcPs_co_nt | DataGridViewAsTextNumericColumn | PS co NT |
| dgvcPs_co | DataGridViewAsTextNumericColumn | PS co VND |
| dgvcMa_kh | DataGridViewAsTextBoxColumn | Ma KH |
| dgvcDien_giai | DataGridViewTextBoxColumn | Dien giai |

## CSDL

| Bang | Mo ta |
|------|-------|
| CA1PH | Phieu thu header |
| CA1CT | Phieu thu chi tiet |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CA1PH | Phiếu thu header | Header |
| CA1CT | Phiếu thu chi tiết | Detail |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA1PH_Get` | Lấy danh sách phiếu thu |
| `CA1PH_Insert` | Thêm phiếu thu header |
| `CA1PH_Update` | Cập nhật phiếu thu header |
| `CA1PH_Delete` | Xóa phiếu thu header |
| `CA1CT_Insert` | Thêm dòng chi tiết |
| `CA1CT_Update` | Cập nhật dòng chi tiết |
| `CA1CT_Delete` | Xóa dòng chi tiết |

## Business Logic

1. **Cân đối**: Tổng PS Có = Tổng phát sinh Nợ trên lưới
2. **Tỷ giá**: Tự động load tỷ giá theo mã ngoại tệ
3. **Tính VND**: Tổng VND = Tổng NT × Tỷ giá
4. **Validate**: Bắt buộc nhập TK Nợ, số tiền > 0

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Vouchers/Phieuthu.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Vouchers;

class Phieuthu extends Component
{
    const MA_CT = 'CA1';

    public function render(): View
    {
        return view('catalog::ca.vouchers.phieu-thu');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/system | Commons | AutoCode, FormatDate |
| diepxuan/system | Lookup | Tra cứu TK, KH |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CA1PH, CA1CT
- [ ] Tao Livewire Phieuthu
- [ ] Tao View
- [ ] Test CRUD