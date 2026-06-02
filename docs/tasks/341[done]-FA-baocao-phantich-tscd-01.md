# Task 051: FA - Bao cao phan tich tai san 01

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | FARptBCPT01.dll |
| **Module** | FA (Fixed Assets) |
| **Loai** | Report (Bao cao) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang bao cao phan tich TSCD 01 tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmFARptBCPT01 | frmReport | Form bao cao |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_BCPT01_GET` | Lay du lieu phan tich TSCD |

## Business Logic

1. **Loc nhieu tieu chi**: MA_TS, MA_NHTS1/2/3, MA_BPSD, MA_PHI, MA_SPCT
2. **Nhom bao cao**: Theo BP su dung, Ma phi, Ma SPCT
3. **Gia tri con lai**: Nguyen gia - Hao mon luy ke

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/BaocaophantichTsod01.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class BaocaophantichTsod01 extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'BCPT01';

    public function render(): View
    {
        return view('catalog::fa.reports.bao-cao-phan-tich-tscd-01');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |
| diepxuan/system | Commons | Lookup TS, NHTS |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP FA_BCPT01_GET
- [ ] Tao Livewire BaocaophantichTsod01
- [ ] Tao View
- [ ] Test xuat Excel

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.341`
