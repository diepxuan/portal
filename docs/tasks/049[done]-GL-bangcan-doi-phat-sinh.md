# Task 049: GL - Bang can doi phat sinh

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | GLRptBCPT01.dll |
| **Module** | GL (General Ledger) |
| **Loai** | Report (Bao cao) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang bang can doi phat sinh tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| GL1 | Chứng từ GL | Transaction |
| GLMD | Mã đối tượng | Reference |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmGLRptBCPT01 | frmReport | Form bao cao |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `GL_BCPT01_GET` | Lay du lieu bang can doi phat sinh |

## Business Logic

1. **Chon TK tong hop**: Hien thi cac tieu tai khoan thuoc TK da chon
2. **So du dau/cuoi ky**: Tinh toan so du dau, PS No/Co, so du cuoi
3. **Loc theo ngay**: Bao cao trong khoang thoi gian

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Reports/BangcandoiPhatsinh.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Reports;

class BangcandoiPhatsinh extends Component
{
    const MA_CT = 'GL';
    const REPORT_TYPE = 'BCPT01';

    public function render(): View
    {
        return view('catalog::gl.reports.bang-can-doi-phat-sinh');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | GL | Module so cai |
| diepxuan/reporting | CrystalReport | Xem bao cao |
| diepxuan/system | Commons | Lookup TK |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP GL_BCPT01_GET
- [ ] Tao Livewire BangcandoiPhatsinh
- [ ] Tao View
- [ ] Test xuat Excel

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.049`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
