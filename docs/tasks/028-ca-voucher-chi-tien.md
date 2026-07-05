# Task 028: CA - Voucher chi tien

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CAVchCA2.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Voucher |
| **Trang thai** | Da phan tich |
| **Ma CT** | CA2 |

## Mo ta chuc nang

Nhap chung tu chi tien mat/chuyen khoan (Phieu chi).

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCaVchCA2 | frmVoucher | Form nhap lieu chinh |
| frmCaVchCA2Find | - | Form tim kiem |

## Controls - Header

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | Ma_Kh | Ma khach hang |
| txtDien_giai | TextBox | Dien_Giai | Dien giai |
| txtTk_Co | AsTextBox | tk_co | TK co (TM/NH) |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| txtT_tien_Nt | AsTextNumeric | t_tien_nt | Tong tien NT |
| txtT_tt_Nt | AsTextNumeric | t_tt_nt | Tong TT NT |
| tabTax | TabPage | - | Tab thue |

## Controls - Detail Grid

| Column | Type | Mo ta |
|--------|------|-------|
| dgvcTk | DataGridViewAsTextBoxColumn | TK no |
| dgvcPs_no_nt | DataGridViewAsTextNumericColumn | PS no NT |
| dgvcPs_no | DataGridViewAsTextNumericColumn | PS no VND |
| dgvcMa_kh | DataGridViewAsTextBoxColumn | Ma KH |

## CSDL

| Bang | Mo ta |
|------|-------|
| CA2PH | Phieu chi header |
| CA2CT | Phieu chi chi tiet |
| CA2TAIN | Thuế đầu vào |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CA2PH | Phiếu chi header | Header |
| CA2CT | Phiếu chi chi tiết | Detail |
| CA2TAIN | Thuế đầu vào | Tax |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA2PH_Get` | Lấy danh sách phiếu chi |
| `CA2PH_Insert` | Thêm phiếu chi header |
| `CA2PH_Update` | Cập nhật phiếu chi header |
| `CA2PH_Delete` | Xóa phiếu chi header |
| `CA2CT_Insert` | Thêm dòng chi tiết |
| `CA2CT_Delete` | Xóa dòng chi tiết |

## Business Logic

1. **Cân đối**: Tổng PS Nợ = Tổng phát sinh Có trên lưới
2. **Thuế đầu vào**: Tab thuế để nhập thông tin khấu trừ thuế GTGT
3. **Tỷ giá**: Tự động load theo mã ngoại tệ
4. **Validate**: Bắt buộc nhập TK Có, số tiền > 0

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Vouchers/Phieuchi.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Vouchers;

class Phieuchi extends Component
{
    const MA_CT = 'CA2';

    public function render(): View
    {
        return view('catalog::ca.vouchers.phieu-chi');
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
- [ ] Tao Model CA2PH, CA2CT
- [ ] Tao Livewire Phieuchi
- [ ] Tao View (có tab thuế)
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
\n## Portal implementation status\n\n- **Status:** DONE (route/component exists)\n- **Source:** SimbaRouteRegistry voucher mapping CA1/CA2/CA4 and existing Cash Livewire screens.\n
