# Task 026: CA - Lai khe uoc

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CALAIKU.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Danh muc (DM) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly lai khe uoc theo thang - xem, sua lai thong tin lai.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCALAIKU | frmDMComplexView | Form xem danh sach |
| frmCALAIKUEdit | frmDMComplexEdit | Form sua |

## Controls chinh

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtNgay_tra | AsMaskedTextBox | Ngay_tra | Ngay tra |
| txtMa_ku | TextBox | Ma_ku | Ma khe uoc (readonly) |
| txtTien_lai_tk | AsTextNumeric | Tien_lai_tk | Lai trong ky |
| txtTien_goc_tk | AsTextNumeric | Tien_goc_tk | Goc trong ky |
| txtTien_lai_qh | AsTextNumeric | Tien_lai_qh | Lai qua han |
| txtTien_goc_qh | AsTextNumeric | Tien_goc_qh | Goc qua han |
| chkSua_lai | AsCheckBox | Sua_lai | Cho phep sua lai |
| chkSua_goc | AsCheckBox | Sua_goc | Cho phep sua goc |

## CSDL

| Bang | Mo ta |
|------|-------|
| CALAIKU | Lai khe uoc |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CALAIKU | Lãi khế ước | Master |
| DMKU | Danh mục khế ước | Reference |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CALAIKU_Get` | Lấy danh sách lãi khế ước |
| `CALAIKU_Insert` | Thêm lãi khế ước |
| `CALAIKU_Update` | Cập nhật lãi khế ước |
| `CALAIKU_Delete` | Xóa lãi khế ước |

## Business Logic

1. **Lãi trong kỳ**: Tiền lãi và gốc phải trả trong kỳ hiện tại
2. **Lãi quá hạn**: Tiền lãi và gốc quá hạn chưa thanh toán
3. **Sửa lại**: Nếu chkSua_lai=1 → cho phép điều chỉnh lãi quá hạn
4. **Sửa gốc**: Nếu chkSua_goc=1 → cho phép điều chỉnh gốc quá hạn

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Catalogs/Laikheuoc.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Catalogs;

class Laikheuoc extends Component
{
    const MA_CT = 'CA';
    const LIST_TYPE = 'LAIKU';

    public function render(): View
    {
        return view('catalog::ca.catalogs.lai-khe-uoc');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/catalog | DMKU | Lookup khế ước |
| diepxuan/system | Commons | Ngày tháng |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CALAIKU
- [ ] Tao Livewire Laikheuoc
- [ ] Tao View
- [ ] Test CRUD