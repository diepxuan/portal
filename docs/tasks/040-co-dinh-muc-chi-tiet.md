# Task 040: CO - Dinh muc chi tiet

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CODD1.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Danh muc (DM) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Khai bao cac but toan ket chuyen tu dong - dinh muc chi phi theo san pham.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCoDD1 | frmDMComplexView | Form quan ly dinh muc |
| frmCoDD1Edit | frmDMComplexEdit | Form nhap lieu |
| frmCoDD1Filter | frmDMComplexFilter | Form loc |

## Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Spct | AsTextBox | Ma san pham chi tiet |
| txtTK | AsTextBox | Tai khoan |
| txtSo_luong | AsTextNumeric | So luong |
| txtTien | AsTextNumeric | Gia tri dinh muc |

## CSDL

| Bang | Mo ta |
|------|-------|
| CODMD1 | Dinh muc chi tiet |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CODMD1 | Định mức chi tiết | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CODMD1_Get` | Lấy danh sách định mức |
| `CODMD1_Insert` | Thêm định mức |
| `CODMD1_Update` | Cập nhật định mức |
| `CODMD1_Delete` | Xóa định mức |

## Business Logic

1. **Kết chuyển tự động**: Bút toán kết chuyển chi phí theo định mức
2. **Lọc phức tạp**: Có nhiều tiêu chí lọc (sản phẩm, BP, VT)
3. **Validate**: Mã SPCT, TK bắt buộc nhập

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Catalogs/Dinhmuclchitiet.php
namespace Diepxuan\Catalog\Http\Livewire\CO\Catalogs;

class Dinhmuclchitiet extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'CODMD1';

    public function render(): View
    {
        return view('catalog::co.catalogs.dinh-muc-chi-tiet');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CO | Module sản xuất |
| diepxuan/system | Commons | Lookup SP, TK |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CODMD1
- [ ] Tao Livewire Dinhmuclchitiet
- [ ] Tao View
- [ ] Test CRUD