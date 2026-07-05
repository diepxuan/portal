# Task 021: CA - Danh muc khe uoc

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CADMKU.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Danh muc (DM) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly danh muc khe uoc vay - thong tin khe uoc, lai suat, ky thanh toan.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCADMKU | frmDMView | Form xem danh sach |
| frmCADMKUEdit | frmDMEdit | Form them/sua |

## Controls chinh

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_KU | TextBox | Ma_Ku | Ma khe uoc |
| txtTen_KU | TextBox | Ten_Ku | Ten khe uoc |
| txtSo_KU | TextBox | So_Ku | So khe uoc |
| txtNgay_ky | AsMaskedTextBox | Ngay_Ky | Ngay ky |
| txtNgay_vay | AsMaskedTextBox | Ngay_vay | Ngay vay |
| txtNgay_Dh | AsMaskedTextBox | Ngay_Dh | Ngay dao han |
| txtthoi_han | AsTextNumeric | Thoi_han | Thoi gian vay |
| cboTinh_theo | ComboBox | Tinh_theo | Tinh theo thang/nam |
| txtLai_Suat | AsTextNumeric | Lai_Suat | Lai suat |
| txtTk_Vay | AsTextBox | Tk_Vay | TK vay |
| txtTk_Cp | AsTextBox | Tk_Cp | TK chi phi |
| txtTien_Nt | AsTextNumeric | Tien_Nt | Tien vay NT |
| txtTien | AsTextNumeric | Tien | Tien vay |

## CSDL

| Bang | Mo ta |
|------|-------|
| DMKU | Danh muc khe uoc |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| DMKU | Danh mục khế ước vay | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `DMKU_Get` | Lấy danh sách khế ước |
| `DMKU_Insert` | Thêm khế ước |
| `DMKU_Update` | Cập nhật khế ước |
| `DMKU_Delete` | Xóa khế ước |

## Business Logic

1. **Tính ngày đáo hạn**: Ngày đáo hạn = Ngày vay + Thời hạn (theo tháng/năm)
2. **Phương pháp tính lãi**: 1-Dư nợ giảm dần, 2-Lãi kép đều, 3-Lãi đơn đều, 4-Dư nợ giảm dần hàng tháng
3. **Kỳ thanh toán**: Hàng tháng / Hàng quý / Hàng năm / 1 lần cuối kỳ
4. **Validate**: Mã KU, Tên KU, Số KU, Ngày vay bắt buộc

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Catalogs/Danhmucheuoc.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Catalogs;

class Danhmucheuoc extends Component
{
    const MA_CT = 'CA';
    const LIST_TYPE = 'DMKU';

    public function render(): View
    {
        return view('catalog::ca.catalogs.danh-muc-khe-uoc');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/system | Commons | Lookup TK, ngoại tệ |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model DMKU
- [ ] Tao Livewire Danhmucheuoc
- [ ] Tao View
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
