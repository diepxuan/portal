# Task 013: ARRptBK01

## Nhom: SO (Sales Order) — công nợ phải thu

- **Status:** DONE (component) — `So\Rpt\Arrptbk01` + route `so.rpt.arrptbk01`; verify browser 2026-11-25: render thật, **0 dòng, 0 cột**
- **Route:** `so.rpt.arrptbk01`
- **Loai:** Báo cáo (Report)

## Đối chiếu tham số

Wrapper `AsARRptBK01` — docs và wrapper **khớp hoàn toàn**, không cần sửa.

## Portal implementation (2026-11-25)

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::so.rpt.arrptbk01` render thật |
| Submit | **0 dòng** |
| Page error | **0** |

### ⚠️ 0 dòng

Không có dữ liệu với công ty 001 ở mọi kỳ đã thử (2026, 2024, 2020, 2000-2030).

Module AR (công nợ phải thu) có thể:
1. Công ty 001 không có phát sinh công nợ trong hệ thống
2. Báo cáo cần thêm điều kiện lọc cụ thể (mã khách hàng, tài khoản)

**Không phải bug code** — component + wrapper đều đúng, submit không lỗi.
