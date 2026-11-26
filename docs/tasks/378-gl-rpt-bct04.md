# Task 378: Tờ khai thuế TNDN tạm tính (GLRptBCT04)

## Nhom: GL (General Ledger)

- **Status:** DONE — component `Gl\Rpt\Glrptbct04` + route `gl.rpt.glrptbct04`, verify browser 2026-11-25 (**28 dòng dữ liệu thật, 12 cột**)
- **Route:** `gl.rpt.glrptbct04`
- **Loai:** Báo cáo (Report)
- **DLL:** GLRptBCT04.dll
- **Menu:** `02.40.14` — "Tờ khai thuế thu nhập doanh nghiệp tạm tính"

## Tham số

`asGLRptBCT04` — **4 tham số**:

| Name | Type | Default | Ghi chú |
|---|---|---|---|
| `pMa_Cty` | NVARCHAR(3) | — | Mã công ty |
| `pNgay1` | SMALLDATETIME | — | Từ ngày |
| `pNgay2` | SMALLDATETIME | — | Đến ngày |
| `pMau` | **CHAR(3)** | **'01'** | Mẫu báo cáo — **KIỂU CHUỖI**, không phải số |

## 🐛 Bug tìm ra: `pMau` sai kiểu dữ liệu

Component ban đầu khai báo `public int $pMau = 0;` → gửi số `0` cho SP.

SP khai báo `pMau` là `CHAR(3)` với default `'01'`. Khi nhận `0`:

| Kỳ test | `pMau = 0` (int) | `pMau = '01'` (string) |
|---|---:|---:|
| 2026-01-01 → 2026-12-31 | 0 dòng | 0 dòng |
| **2024-01-01 → 2024-12-31** | **0 dòng** | **28 dòng** |
| **2020-01-01 → 2020-12-31** | **0 dòng** | **28 dòng** |
| **2015-01-01 → 2015-12-31** | **0 dòng** | **28 dòng** |

→ Sai kiểu làm SP **trả rỗng mà không báo lỗi** — rất khó phát hiện.

## Portal implementation (2026-11-25)

- **Component:** `Gl\Rpt\Glrptbct04` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptbct04.blade.php` + filter `gl/rpt/filters/glrptbct04.blade.php`
- **Route:** `gl.rpt.glrptbct04` — 1 menu, không suffix

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::gl.rpt.glrptbct04` render thật |
| Submit 2024/2020/2015 | **28 dòng, 12 cột** |
| Tab + nút Thực hiện | có |
| Page error | **0** |

**12 cột:** `stt`, `chi_tieu`, `ma_so`, `tien`, `in_ck`, ...

### Bài học: kiểm tra KIỂU dữ liệu tham số, không chỉ tên

Khi SP trả 0 dòng mà **không lỗi**, nguyên nhân thường là:
1. Sai kiểu tham số (int vs char)
2. Sai giá trị default
3. Điều kiện lọc quá hẹp

Đối chiếu `Type` của tham số trong `procedures.md` — không chỉ đọc tên.
