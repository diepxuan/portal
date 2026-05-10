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

### frmSORptBCPT06 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao ban hang theo 2 chieu (nhieu tieu chi loc)
- **Controls tren tabFilter:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky bao cao (Thang/Quy/Nam) |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc |
| txtMa_Kh | AsTextBox | Ma khach hang |
| txtMa_NhKh | AsTextBox | Nhom khach hang |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_httt | AsTextBox | Hinh thuc thanh toan |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_bp | AsTextBox | Ma bo phan |
| txtMa_nvkd | AsTextBox | Ma NVKD |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Nhom vat tu |
| txtMa_plkh1 | AsTextBox | Phan loai KH 1 |
| txtMa_plkh2 | AsTextBox | Phan loai KH 2 |
| txtMa_plkh3 | AsTextBox | Phan loai KH 3 |
| txtMa_plvt1 | AsTextBox | Phan loai VT 1 |
| txtMa_plvt2 | AsTextBox | Phan loai VT 2 |
| txtMa_plvt3 | AsTextBox | Phan loai VT 3 |
| ChkTra_lai | AsCheckBox | Tru hang tra lai |
| ChkTra_ck | AsCheckBox | Tru chiet khau |
| ChkKhuyen_mai | AsCheckBox | Tru khuyen mai |
| ChkHang_ban | AsCheckBox | Hang ban |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |

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

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Reports/BaocaobanhangChitieu.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Reports;

class BaocaobanhangChitieu extends Component
{
    const MA_CT = 'SO';
    const REPORT_TYPE = 'BCPT06';

    public ?DateTime $pNgay1 = null;
    public ?DateTime $pNgay2 = null;
    public ?string $pMa_Kh = null;
    public ?string $pMa_NhKh = null;
    public ?string $pMa_hd = null;
    public ?string $pMa_httt = null;
    public ?string $pMa_kho = null;
    public ?string $pMa_bp = null;
    public ?string $pMa_nvkd = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_nhvt = null;
    public bool $pTra_lai = false;
    public bool $pTra_ck = false;
    public bool $pKhuyen_mai = false;
    public bool $pHang_ban = true;
    public bool $pVnd = true;

    public function loadData(): void { /* Call SP SO_BCPT06_GET */ }
    public function render(): View
    {
        return view('catalog::so.reports.bao-cao-ban-hang-chi-tieu');
    }
}
```

### 2. Views

```
resources/views/catalog/so/reports/
├── bao-cao-ban-hang-chi-tieu.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/so/reports')
    ->name('catalog.so.reports.')
    ->group(function () {
        Route::get('/bao-cao-ban-hang-chi-tieu', [BaocaobanhangChitieu::class, 'render'])
            ->name('baocaobanhang.chitieu');
    });
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

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
