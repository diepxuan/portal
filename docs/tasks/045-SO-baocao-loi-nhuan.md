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

### frmSORptLaiLo (Form bao cao loi nhuan)
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao loi nhuan theo hop dong
- **Controls tren tabFilter:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky bao cao |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_nhhd | AsTextBox | Nhom hop dong |
| txtMa_Kh | AsTextBox | Ma khach hang |
| txtMa_vt | AsTextBox | Ma vat tu |
| optNo | RadioButton | Phat sinh No (Doanh thu) |
| optCo | RadioButton | Phat sinh Co (Chi phi) |

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

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Reports/Baocaoloinhuan.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Reports;

class Baocaoloinhuan extends Component
{
    const MA_CT = 'SO';
    const REPORT_TYPE = 'LAILO';

    public ?DateTime $pNgay1 = null;
    public ?DateTime $pNgay2 = null;
    public ?string $pMa_hd = null;
    public ?string $pMa_Kh = null;
    public ?string $pMa_vt = null;
    public bool $pPhatSinhNo = true;

    public function loadData(): void { /* Call SP SO_LAILO_GET */ }
    public function render(): View
    {
        return view('catalog::so.reports.bao-cao-loi-nhuan');
    }
}
```

### 2. Views

```
resources/views/catalog/so/reports/
├── bao-cao-loi-nhuan.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/so/reports')
    ->name('catalog.so.reports.')
    ->group(function () {
        Route::get('/bao-cao-loi-nhuan', [Baocaoloinhuan::class, 'render'])
            ->name('baocaoloinhuan');
    });
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

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
