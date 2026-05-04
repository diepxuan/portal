# Task 044: SO - Bao cao ban hang theo chi tieu

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | SORptBCPT06.dll |
| **Module** | SO (Sales Order) |
| **Loai** | Report (Bao cao) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang bao cao ban hang 2 chieu tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| DMBHCT | Bán hàng chi tiết | Transaction |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmSORptBCPT06 | frmReport | Form bao cao |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `SO_BCPT06_GET` | Lay du lieu bao cao ban hang theo 2 chieu |

## Business Logic

1. **Bao cao 2 chieu**: Cot = Nhóm theo, Dong = Chi tiet theo (6 tuy chon)
2. **Loc nhieu tieu chi**: KH, nhom KH, HD, HTTT, kho, BP, NVKD, VT, nhom VT
3. **Tru hang tra lai**: Loai bo hang ban tra, chiet khau, khuyen mai
4. **Drill-down**: F4 de xem chi tiet

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Reports/BaocaobanhangChitieu.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Reports;

class BaocaobanhangChitieu extends Component
{
    const MA_CT = 'SO';
    const REPORT_TYPE = 'BCPT06';

    public function render(): View
    {
        return view('catalog::so.reports.bao-cao-ban-hang-chi-tieu');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | SO | Module ban hang |
| diepxuan/reporting | CrystalReport | Xem bao cao |
| diepxuan/system | Commons | Lookup KH, VT |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP SO_BCPT06_GET
- [ ] Tao Livewire BaocaobanhangChitieu
- [ ] Tao View
- [ ] Test drill-down
