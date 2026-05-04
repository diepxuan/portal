# Task 101: IN - Cong no dinh muc FIFO

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | INCDFIFO.dll |
| **Module** | IN (Inventory) |
| **Loai** | Report (Bao cao) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang tinh gia FIFO tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| INVENTORY | Ton kho | Transaction |
| INLO | Lo nhap | Transaction |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmINCDFIFO | frmReport | Form bao cao |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `IN_CD_FIFO_GET` | Lay du lieu FIFO |

## Business Logic

1. **FIFO**: Hang nhap truoc xuat truoc, gia tri ton = gia nhap cu
2. **Loc nhieu tieu chi**: VT, nhom VT, kho, ngay
3. **Drill-down**: Xem chi tiet phieu nhap/xuat

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Reports/CongnoDinhmucFifo.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Reports;

class CongnoDinhmucFifo extends Component
{
    const MA_CT = 'IN';
    const REPORT_TYPE = 'CD_FIFO';

    public function render(): View
    {
        return view('catalog::in.reports.cong-no-dinh-muc-fifo');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | IN | Module ton kho |
| diepxuan/reporting | CrystalReport | Xem bao cao |
| diepxuan/system | Commons | Lookup VT, kho |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP IN_CD_FIFO_GET
- [ ] Tao Livewire CongnoDinhmucFifo
- [ ] Tao View
- [ ] Test drill-down
