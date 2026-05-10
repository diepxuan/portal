# Task 100: IN - Danh muc kho

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | INDMKHO.dll |
| **Module** | IN (Inventory) |
| **Loai** | Danh muc (DM) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang danh muc kho tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| DMKHO | Danh muc kho | Master |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmINDMKHO | frmDMView | Form xem danh sach |
| frmINDMKHOEdit | frmDMEdit | Form them/sua |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `DMKHO_Get` | Lay danh sach kho |
| `DMKHO_Insert` | Them kho |
| `DMKHO_Update` | Cap nhat kho |
| `DMKHO_Delete` | Xoa kho |

## Business Logic

1. **Ma kho duy nhat**: Khong trung lap tren cung cong ty
2. **Kho mac dinh**: Chi 1 kho mac dinh trong he thong
3. **Phan quyen**: Gan quyen truy cap kho cho nguoi dung

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Catalogs/Danhmuckho.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Catalogs;

class Danhmuckho extends Component
{
    const MA_CT = 'IN';
    const LIST_TYPE = 'DMKHO';

    public function render(): View
    {
        return view('catalog::in.catalogs.danh-muc-kho');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | IN | Module ton kho |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model DMKHO
- [ ] Tao Livewire Danhmuckho
- [ ] Tao View
- [ ] Test CRUD

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
