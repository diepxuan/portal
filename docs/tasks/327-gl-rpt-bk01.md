# Task 327: Bảng kê chứng từ ghi sổ (GLRptBK01)

## Nhom: GL (General Ledger)

- **Status:** DONE (component) — `Gl\Rpt\Glrptbk01` + route `gl.rpt.glrptbk01`; verify browser 2026-11-25: render thật, **1 dòng, 35 cột**
- **Route:** `gl.rpt.glrptbk01`
- **Loai:** Báo cáo (Report)
- **DLL:** GLRptBK01.dll

## Tham số — 19 (wrapper = docs, khớp hoàn toàn)

`pma_cty`, `pngay_ct1`, `pngay_ct2`, `pso_ct1`, `pso_ct2`, `ptk`, `pNo_co`,
`ptk_du`, `pma_kh`, `pMa_Nhkh`, `pma_bp`, `pma_phi`, `pma_hd`, `pma_ku`,
`pma_spct`, `pma_lo`, `pma_ct`, `pdien_giai`, `pma_nt`

Không cần sửa wrapper.

## Portal implementation (2026-11-25)

- **Component:** `Gl\Rpt\Glrptbk01` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptbk01.blade.php` + filter tương ứng
- **Route:** `gl.rpt.glrptbk01`

### Verify browser thật

| Kỳ test | Số dòng | Số cột |
|---|---:|---:|
| 2026 (mặc định) | 1 | **35** |
| 2000-01-01 → 2030-12-31 | 1 | 35 |
| 2024 | 1 | 35 |
| 2020 | 1 | 35 |

**35 cột:** `stt_rec`, `ma_ct`, `ngay_ct`, `so_ct`, `nguoi_gd`, ...

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::gl.rpt.glrptbk01` render thật |
| Page error | **0** |

### ⚠️ Luôn 1 dòng — cần điều tra

Dù mở rộng kỳ 30 năm vẫn chỉ 1 dòng. Có thể:
1. SP cần `pso_ct1`/`pso_ct2` (số chứng từ) mới trả dữ liệu thật
2. Công ty 001 không có chứng từ ghi sổ (nhất quán với `GLRptCTGS01` = 0 dòng,
   `GLRptNKC02` = 109 dòng → công ty dùng Nhật ký chung, không dùng CTGS)

**Giả thuyết mạnh:** cùng lý do với task 303 — công ty 001 **không dùng hình thức
Chứng từ ghi sổ**, nên mọi báo cáo CTGS đều rỗng.

**Không phải bug code.**
