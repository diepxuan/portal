# Task 045: SO - Bao cao loi nhuan ban hang

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | SORptLaiLo.dll |
| **Module** | SO (Sales Order) |
| **Loai** | Report (Bao cao) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang bao cao loi nhuan theo hop dong tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| GL1 | Chứng từ GL | Transaction |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmSORptLaiLo | frmReport | Form bao cao loi nhuan |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `SO_LAILO_GET` | Lay du lieu loi nhuan theo hop dong |

## Business Logic

1. **Tinh loi nhuan**: Doanh thu (TK 5xx) - Chi phi (TK 6xx)
2. **Theo hop dong**: Chi tinh cho hop dong duoc chon
3. **Chon phat sinh No/Co**: Xac dinh ben nao la doanh thu/chi phi
4. **Drill-down**: F4 de xem chi tiet TK

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Reports/Baocaoloinhuan.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Reports;

class Baocaoloinhuan extends Component
{
    const MA_CT = 'SO';
    const REPORT_TYPE = 'LAILO';

    public function render(): View
    {
        return view('catalog::so.reports.bao-cao-loi-nhuan');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | SO | Module ban hang |
| diepxuan/catalog | GL | So cai - lay doanh thu/chi phi |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP SO_LAILO_GET
- [ ] Tao Livewire Baocaoloinhuan
- [ ] Tao View
- [ ] Test drill-down
