# Task 023: CA - Cong no phan cap

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CACDPC.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | So du dau ky (OB) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly so du dau ky phieu chi phan cap - thong tin tien PC, da thanh toan.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCACDPC | frmOBView | Form xem danh sach |
| frmCACDPCEdit | frmOBEdit | Form them/sua |

## Controls chinh

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay phieu chi |
| txtMa_kh | AsTextBox | ma_kh | Ma khach hang |
| txtTk_tu | AsTextBox | tk_tu | TK tam ung |
| cboNt | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTien_pc_nt | AsTextNumeric | tien_pc_nt | Tien PC NT |
| txtDa_tt_nt | AsTextNumeric | tien_da_tt_nt | Da TT NT |
| txtSo_du_nt | AsTextNumeric | so_du_nt | So du NT |

## CSDL

| Bang | Mo ta |
|------|-------|
| CADPC | Cong no dau ky phieu chi |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CADPC | Công nợ đầu kỳ phiếu chi phân cấp | Open Balance |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CADPC_Get` | Lấy danh sách công nợ đầu kỳ PC |
| `CADPC_Insert` | Thêm công nợ đầu kỳ PC |
| `CADPC_Update` | Cập nhật công nợ đầu kỳ PC |
| `CADPC_Delete` | Xóa công nợ đầu kỳ PC |

## Business Logic

1. **Ngoại tệ**: Hiển thị/hide cột NT tùy loại tiền
2. **Số dư**: Số dư = Tiền PC - Đã thanh toán
3. **Validate**: Mã KH, TK tạm ứng bắt buộc nhập

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/OpenBalances/Congnophancap.php
namespace Diepxuan\Catalog\Http\Livewire\CA\OpenBalances;

class Congnophancap extends Component
{
    const MA_CT = 'CA';
    const LIST_TYPE = 'CDPC';

    public function render(): View
    {
        return view('catalog::ca.open-balances.cong-no-phan-cap');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/system | Commons | Lookup KH, TK |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CADPC
- [ ] Tao Livewire Congnophancap
- [ ] Tao View
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.023`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
