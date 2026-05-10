# Task 032-038: CA - Bao cao tien mat ngan hang

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CARptTMNH01.dll - CARptTMNH07.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Bao cao |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Nhom 7 bao cao tien mat/ngân hang - hien thi cac so chi tiet, so quy, bao cao vay no.

## Form classes

| DLL | Class | Muc dich |
|-----|-------|----------|
| CARptTMNH01.dll | frmCARptTMNH01 | So chi tiet TM/NH |
| CARptTMNH02.dll | frmCARptTMNH02 | So quy TM/NH |
| CARptTMNH03.dll | frmCARptTMNH03 | So chi tiet vay theo khe uoc |
| CARptTMNH04.dll | frmCARptTMNH04 | Tong hop theo nhan vien/nhom KH |
| CARptTMNH05.dll | frmCARptTMNH05 | Tinh hinh vay no theo khe uoc |
| CARptTMNH06.dll | frmCARptTMNH06 | So chi tiet vay (Crystal Report) |
| CARptTMNH07.dll | frmCARptTMNH07 | Tong hop vay no TK va khe uoc |

## Controls chung

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan (bat buoc) |
| lblTen_Tk | Label | Ten tai khoan |
| txtNgay1/txtNgay2 | AsMaskedTextBox | Khoang thoi gian |
| cboMau_bc | ComboBox | Mau bao cao |
| optVND/optNt | RadioButton | Loai tien |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CARptTMNH01-07 | Báo cáo TM/NH | Reports |

## Stored Procedures

| DLL | SP Name | Mô tả |
|-----|---------|-------|
| CARptTMNH01.dll | `CA_TMNH01_GET` | Sổ chi tiết TM/NH |
| CARptTMNH02.dll | `CA_TMNH02_GET` | Sổ quỹ TM/NH |
| CARptTMNH03.dll | `CA_TMNH03_GET` | Sổ chi tiết vay theo KHU |
| CARptTMNH04.dll | `CA_TMNH04_GET` | Tổng hợp NV/KH |
| CARptTMNH05.dll | `CA_TMNH05_GET` | Tình hình vay theo KHU |
| CARptTMNH06.dll | `CA_TMNH06_GET` | Sổ chi tiết vay (CR) |
| CARptTMNH07.dll | `CA_TMNH07_GET` | Tổng hợp vay TK & KHU |

## Business Logic

1. **Bắt buộc TK**: Phải chọn ít nhất 1 TK để xem báo cáo
2. **Loại tiền**: VND hoặc Ngoại tệ (tùy chọn)
3. **Khoảng thời gian**: Từ ngày - Đến ngày
4. **Drill-down**: F4 để xem chi tiết từng dòng

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Reports/BaocaoTienmatNganhang.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Reports;

class BaocaoTienmatNganhang extends Component
{
    public int $pReportType = 1; // 1-7
    public ?string $pMa_tk = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pLoai_tien = 'VND';

    public function render(): View
    {
        return view('catalog::ca.reports.bao-cao-tien-mat-ngan-hang');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/system | Commons | Lookup TK |
| diepxuan/reporting | CrystalReport | Xem báo cáo |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP cho 7 bao cao
- [ ] Tao Livewire BaocaoTienmatNganhang
- [ ] Tao View (7 tab/loai)
- [ ] Test drill-down
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
