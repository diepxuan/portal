# Task 041: CO - Danh muc nhom san pham

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CODMNHSPCT.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Danh muc (DM) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly danh muc nhom san pham cong trinh - phan loai san pham de bao cao gia thanh.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCODMNHSPCT | frmDMView | Form xem danh sach |
| frmCODMNHSPCTEdit | - | Form sua |

## CSDL

| Bang | Mo ta |
|------|-------|
| DMNHSPCT | Nhom san pham cong trinh |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| DMNHSPCT | Nhóm sản phẩm công trình | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `DMNHSPCT_Get` | Lấy danh sách nhóm SP |
| `DMNHSPCT_Insert` | Thêm nhóm SP |
| `DMNHSPCT_Update` | Cập nhật nhóm SP |
| `DMNHSPCT_Delete` | Xóa nhóm SP |

## Business Logic

1. **Phân loại SP**: Nhóm sản phẩm phục vụ báo cáo giá thành
2. **Hierarchical**: Có thể có cấp cha/con
3. **Validate**: Mã nhóm, Tên nhóm bắt buộc

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Catalogs/NhomsanphamCongtrinh.php
namespace Diepxuan\Catalog\Http\Livewire\CO\Catalogs;

class NhomsanphamCongtrinh extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'DMNHSPCT';

    public function render(): View
    {
        return view('catalog::co.catalogs.nhom-san-pham');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CO | Module sản xuất |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model DMNHSPCT
- [ ] Tao Livewire NhomsanphamCongtrinh
- [ ] Tao View
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
