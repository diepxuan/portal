# Task 233: Tổng hợp hàng nhập theo hai chỉ tiêu (INRptTHN02)

## Nhom: IN (Inventory)

- **Status:** DONE (component) — `In\Rpt\Inrptthn02` + route `in.rpt.inrptthn02`; verify browser 2026-11-25: component render thật, submit không lỗi, **1 dòng header** (`#SMRpt_TC`)
- **Route:** `in.rpt.inrptthn02`
- **Loai:** Báo cáo (Report)
- **DLL:** INRptTHN02.dll
- **Menu:** `14.20.18` — "Tổng hợp hàng nhập theo hai chỉ tiêu"

## Tham số — 29 (sau khi bỏ pSysMsg1)

`asINRptTHN02`:

`pMa_cty`, `pNgay1`, `pNgay2`, `pCtu1`, `pCtu2`, `pGroup`, `pDetail`,
`pMa_kh`, `pMa_NhKH`, `pMa_PLKH1`, `pMa_PLKH2`, `pMa_PLKH3`, `pLoai_pn`,
`pLoai_gd`, `pMa_Hd`, `pMa_vt`, `pMa_kho`, `pMa_vitri`, `pMa_bp`, `pMa_spct`,
`pTK_VT`, `pTk_Du`, `pNhom_VT`, `pPSDC`, `pMa_nx`, `pMa_lo`, `pMa_phi`,
`pMa_NT`, `pDVT`

### 🐛 Bug wrapper đã sửa

Wrapper cũ có **30 tham số**, thừa `pSysMsg1` (tham số thông báo .NET).
Đã bỏ → 29 tham số đúng.

## Portal implementation (2026-11-25)

- **Component:** `In\Rpt\Inrptthn02` (kế thừa `Rpt\AbstractReport`)
- **View:** `in/rpt/inrptthn02.blade.php` + filter tương ứng
- **Route:** `in.rpt.inrptthn02` — 1 menu, không suffix

### Filter có 2 combo nhóm chỉ tiêu

| Field | Options |
|---|---|
| `pGroup` | `''` (không nhóm), `TK`, `ma_kh`, `ma_vt`, `ma_kho` |
| `pDetail` | `''` (không), `TK`, `ma_kh`, `ma_vt` |

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::in.rpt.inrptthn02` render thật |
| Submit 2026/2024/2020/2015 | **1 dòng**, không `errorMessage` |
| Submit với `pGroup` = TK / ma_vt / ma_kh | **1 dòng** |
| Page error | **0** |

**10 cột:** `bold`, `has_sysmsg`, `ma_group`, `ten_group`, `ma_detail`, ...

### ⚠️ Chỉ 1 dòng header — cần điều tra thêm

SP trả **1 dòng có `ten_group = "#SMRpt_TC"`** (dòng tiêu đề báo cáo) với
mọi tổ hợp tham số đã thử. Không có dòng dữ liệu chi tiết.

**Có thể do:**
1. `pGroup`/`pDetail` cần giá trị đặc biệt mà em chưa thử đúng
2. Công ty 001 không có phát sinh nhập trong kỳ (nhưng THN01 có 556-1163 dòng)
3. SP cần thêm tham số khác (VD `pTk_List`) mà wrapper thiếu

**Không phải bug code:** component + wrapper đều không lỗi. Cần thêm dữ liệu
hoặc hướng dẫn từ người dùng quen SimbaERP để xác định đúng tham số.
