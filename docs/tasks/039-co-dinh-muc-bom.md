# Task 039: CO - Dinh muc nguyen vat lieu (BOM)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CODMBOM.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Danh muc (DM) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly dinh muc nguyen vat lieu theo cau truc san pham (Bill of Materials).

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCODMBOM | frmAsiaRoot | Form quan ly BOM |

## Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_sp | AsTextBox | Ma san pham |
| txtSDate/txtEDate | AsMaskedTextBox | Ngay hieu luc |
| txtDon_gia_luong | AsTextNumeric | Don gia nhan cong |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtSo_luong | AsTextNumeric | So luong dinh muc |
| chkVt_chinh | AsCheckBox | Vat tu chinh |
| dgvCTVT | DataGridView | Chi tiet vat tu |
| dgvListVt | DataGridView | Danh sach vat tu |

## CSDL

| Bang | Mo ta |
|------|-------|
| DMBOMPH | BOM master |
| DMBOMCT | BOM chi tiet |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| DMBOMPH | BOM master | Master |
| DMBOMCT | BOM chi tiết vật tư | Detail |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `DMBOMPH_Get` | Lấy danh sách BOM |
| `DMBOMPH_Insert` | Thêm BOM header |
| `DMBOMPH_Update` | Cập nhật BOM header |
| `DMBOMPH_Delete` | Xóa BOM header |
| `DMBOMCT_Insert` | Thêm dòng vật tư |
| `DMBOMCT_Update` | Cập nhật dòng vật tư |
| `DMBOMCT_Delete` | Xóa dòng vật tư |

## Business Logic

1. **Hiệu lực**: BOM có ngày bắt đầu và ngày kết thúc
2. **Vật tư chính**: Chỉ 1 vật tư chính (vt_chinh=1) cho mỗi BOM
3. **Cấu trúc đệ quy**: Có thể lồng BOM (BOM trong BOM)

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Catalogs/Dinhmuclom.php
namespace Diepxuan\Catalog\Http\Livewire\CO\Catalogs;

class Dinhmuclom extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'DMBOM';

    public function render(): View
    {
        return view('catalog::co.catalogs.dinh-muc-bom');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CO | Module sản xuất |
| diepxuan/catalog | DMVT | Lookup vật tư |
| diepxuan/system | Commons | Lookup đơn giá |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model DMBOMPH, DMBOMCT
- [ ] Tao Livewire Dinhmuclom
- [ ] Tao View (2 lưới)
- [ ] Test CRUD