# Task 022: CA - Cong no khe uoc

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CACDKU.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | So du dau ky (OB) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly so du dau ky khe uoc vay - thong tin da vay, da thanh toan.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCACDKU | frmOBView | Form xem danh sach |
| frmCACDKUEdit | frmOBEdit | Form them/sua |

## Controls chinh

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtYear | AsTextNumeric | nam | Nam tai chinh |
| txtMa_ku | AsTextBox | ma_ku | Ma khe uoc |
| txtMa_tk | AsTextBox | tk | Tai khoan vay |
| txtTiendvNT | AsTextNumeric | da_vay_nt | Da vay NT |
| txtTiendvVND | AsTextNumeric | da_vay | Da vay VND |
| txtTiendattNT | AsTextNumeric | da_tt_nt | Da TT NT |
| txtTiendattVND | AsTextNumeric | da_tt | Da TT VND |

## CSDL

| Bang | Mo ta |
|------|-------|
| CADKU | Cong no dau ky khe uoc |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CADKU | Công nợ đầu kỳ khế ước | Open Balance |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CADKU_Get` | Lấy danh sách công nợ đầu kỳ KU |
| `CADKU_Insert` | Thêm công nợ đầu kỳ KU |
| `CADKU_Update` | Cập nhật công nợ đầu kỳ KU |
| `CADKU_Delete` | Xóa công nợ đầu kỳ KU |

## Business Logic

1. **Ngoại tệ**: Nếu mã NT khác VND → hiển thị cả cột NT và VND
2. **Load thông tin KU**: Khi chọn mã KU → tự động load ngày vay, TK vay, mã NT
3. **Validate bắt buộc**: Mã KU, Mã TK phải nhập

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/OpenBalances/Congnokhe uoc.php
namespace Diepxuan\Catalog\Http\Livewire\CA\OpenBalances;

class Congnokhe uoc extends Component
{
    const MA_CT = 'CA';
    const LIST_TYPE = 'CDKU';

    public function render(): View
    {
        return view('catalog::ca.open-balances.cong-no-khe-uoc');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/catalog | DMKU | Lookup khế ước |
| diepxuan/system | Commons | Lookup TK |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CADKU
- [ ] Tao Livewire Congnokhe uoc
- [ ] Tao View
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.022`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
