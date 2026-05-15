# Task 042: CO - Danh muc but toan phan bo tu dong

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CODMPB.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Danh muc (DM) |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly danh muc but toan phan bo tu dong - cau hinh phan bo chi phi tu dong.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCODMPB | frmDMView | Form quan ly |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CODMPB | Bút toán phân bổ tự động | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CODMPB_Get` | Lấy danh sách bút toán PB |
| `CODMPB_Insert` | Thêm bút toán PB |
| `CODMPB_Update` | Cập nhật bút toán PB |
| `CODMPB_Delete` | Xóa bút toán PB |

## Business Logic

1. **Phân bổ tự động**: Cấu hình phân bổ chi phí cho các đối tượng
2. **Tiêu chí PB**: Theo sản phẩm, theo BP, theo doanh thu
3. **Validate**: TK nguồn, TK đích, tỷ lệ phân bổ bắt buộc

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Catalogs/ButtoanPhanboTudong.php
namespace Diepxuan\Catalog\Http\Livewire\CO\Catalogs;

class ButtoanPhanboTudong extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'CODMPB';

    public function render(): View
    {
        return view('catalog::co.catalogs.but-toan-phan-bo-tu-dong');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CO | Module sản xuất |
| diepxuan/system | Commons | Lookup TK |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CODMPB
- [ ] Tao Livewire ButtoanPhanboTudong
- [ ] Tao View
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Implementation Update 2026-05-15

- Da co route anchor `co.rpt.codmpb` qua generic `simba.report` theo `sysReportInfo`.
- Chua mo CRUD/execute vi dictionary metadata CODMPB con thieu/lẹch carry fields trong `simba-docs`; khong goi SQL/SP/function.
