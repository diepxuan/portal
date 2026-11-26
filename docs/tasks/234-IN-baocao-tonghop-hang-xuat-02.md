# Task 234: Tổng hợp hàng xuất theo hai chỉ tiêu (INRptTHX02)

## Nhom: IN (Inventory)

- **Status:** DONE (component) — `In\Rpt\Inrptthx02` + route `in.rpt.inrptthx02`; verify browser 2026-11-25: component render thật, submit không lỗi, **1 dòng header**
- **Route:** `in.rpt.inrptthx02`
- **Loai:** Báo cáo (Report)
- **DLL:** INRptTHX02.dll
- **Menu:** `14.20.24` — "Tổng hợp hàng xuất theo hai chỉ tiêu"

## Tham số — 28 (sau khi bỏ pSysMsg1)

`asINRptTHX02`: `pMa_cty`, `pNgay1`, `pNgay2`, `pCtu1`, `pCtu2`, `pLoai_px`,
`pLoai_gd`, `pGroup`, `pDetail`, `pMa_kh`, `pMa_nhkh`, `pMa_Hd`, `pMa_dangnx`,
`pMa_kho`, `pMa_khon`, `pMa_vitri`, `pMa_vt`, `pNhom_VT`, `pTK_VT`, `pMa_bp`,
`pPSDC`, `pMa_NT`, `pTk_Du`, `pMa_lo`, `pMa_phi`, `pNgoai_te`, `pMa_spct`, `pDVT`

### 🐛 Bug wrapper đã sửa

Wrapper cũ 29 tham số, thừa `pSysMsg1` → đã bỏ, còn **28**.

## Portal implementation (2026-11-25)

- **Component:** `In\Rpt\Inrptthx02` (kế thừa `Rpt\AbstractReport`)
- **View:** `in/rpt/inrptthx02.blade.php` + filter tương ứng
- **Route:** `in.rpt.inrptthx02`

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::in.rpt.inrptthx02` render thật |
| Submit | **1 dòng, 11 cột** |
| 11 cột | `bold`, `has_sysmsg`, `ma_group`, `ten_group`, `ma_detail`, ... |
| Page error | **0** |

### ⚠️ Cùng hiện tượng với task 233 (THN02)

Chỉ 1 dòng header (`ten_group` là tiêu đề). Cả 2 báo cáo "hai chỉ tiêu" đều vậy.

**Giả thuyết mạnh nhất:** `pGroup`/`pDetail` cần giá trị cụ thể từ danh mục
(VD mã nhóm chỉ tiêu thật) chứ không phải tên field. Em đã thử
`TK`/`ma_vt`/`ma_kh` — chưa đúng.

**Cần:** người dùng quen SimbaERP xác nhận cách chọn "hai chỉ tiêu" trên form gốc.
