# Task 377: Sổ nhật ký chung (GLRptNKC02)

## Nhom: GL (General Ledger)

- **Status:** DONE — component `Gl\Rpt\Glrptnkc02` + route `gl.rpt.glrptnkc02`, verify browser 2026-11-25 (**109 dòng dữ liệu thật, 24 cột**)
- **Route:** `gl.rpt.glrptnkc02`
- **Loai:** Báo cáo (Report)
- **DLL:** GLRptNKC02.dll
- **Menu:** `02.10.02` — "Sổ nhật ký chung"

## Tham số

`asGLRptNKC02` — **4 tham số**, cả 3 nguồn khớp:

| Nguồn | Tham số |
|---|---|
| `procedures.md` | pMa_cty, pNgay_ct1, pNgay_ct2, pMa_Nt |
| Wrapper `AsGLRptNKC02` | pMa_cty, pNgay_ct1, pNgay_ct2, pMa_Nt |
| Component payload | pMa_cty, pNgay_ct1, pNgay_ct2, pMa_Nt |

→ Không cần sửa wrapper.

## Portal implementation (2026-11-25)

- **Component:** `Gl\Rpt\Glrptnkc02` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptnkc02.blade.php` + filter `gl/rpt/filters/glrptnkc02.blade.php`
- **Route:** `gl.rpt.glrptnkc02` — 1 menu, không suffix

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::gl.rpt.glrptnkc02` render thật |
| Submit | **109 dòng, 24 cột** |
| Tab + nút Thực hiện | có |
| Page error | **0** |

**24 cột:** `bold`, `ngay_ct`, `ngay_lct`, `ma_ct`, `stt_nkc`, `so_ct`, `stt_rec`,
`stt_rec0`, `dien_giai`, `ma_kh`, `ten_kh`, `ten_tk`, `tk`, `tk_du`, `ps_no`, `ps_co`,
`ps_no_nt`, `ps_co_nt`, `ma_nt`, `ty_gia`, `nhom_dk`, `fsort`, `has_sysmsg`, `Stt_dong_nkc`

### Bài học kỹ thuật

Script test đọc `$wire.get('rows')` **quá sớm** (trước khi Livewire xử lý xong)
→ trả `n=0, err=null` gây hiểu nhầm là không có dữ liệu.

**Đúng:** đợi request Livewire hoàn tất (12-14s) rồi mới đọc state.
