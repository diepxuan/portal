# Task 391: MM — 14 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: MM (Sản xuất)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **14 menu MM đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 14 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `16.10.05` | Lệnh sản xuất | Số liệu | MMVchMM3 | MM3 | 0 | 15.10.05 |
| 2 | `16.10.10` | Phiếu xuất nguyên vật liệu | Số liệu | INVchIN2 | IN2 | 0 | 15.10.10 |
| 3 | `16.10.15` | Phiếu nhập thành phẩm | Số liệu | INVchIN1 | IN1 | 0 | 15.10.15 |
| 4 | `16.20.00` | Báo cáo Sản xuất | Báo cáo | - | - | 0 | 15.20.00 |
| 5 | `16.20.02` | Báo cáo nhu cầu NVL phục vụ sản xuất | Báo cáo | MMRptBCPT01 | - | 1 | 15.20.02 |
| 6 | `16.20.05` | Báo cáo tình hình thực hiện lệnh sản xuất | Báo cáo | MMRptBCPT02 | - | 1 | 15.20.04 |
| 7 | `16.20.08` | Bảng kê phiếu nhập | Báo cáo | INRptBKN04 | - | 1 | 15.20.05 |
| 8 | `16.20.11` | Tổng hợp hàng nhập | Báo cáo | INRptTHN02 | - | 1 | 15.20.09 |
| 9 | `16.20.14` | Bảng kê phiếu xuất | Báo cáo | INRptBKX04 | - | 1 | 15.20.11 |
| 10 | `16.20.17` | Tổng hợp hàng xuất | Báo cáo | INRptTHX02 | - | 1 | 15.20.13 |
| 11 | `16.90.02` | Lô thành phẩm | Danh mục | MMDMLOTP | MA_LO_TP | 0 | 15.90.01 |
| 12 | `16.90.05` | Tạo lô thành phẩm | Danh mục | MMTaoLoTP | - | 0 | 15.90.03 |
| 13 | `16.90.08` | Sản phẩm | Danh mục | CODMSPCT | MA_SP | 0 | 15.90.05 |
| 14 | `16.90.11` | Định mức sản phẩm | Danh mục | CODMBOM | - | 0 | 15.90.07 |

## Điều kiện DONE (theo `docs/PROJECT_CONVENTIONS.md` §2.7)

1. Xác nhận menu **cần dùng** (Sếp duyệt) → bật `active = 1` trên SimbaERP gốc.
2. Đọc `simba-docs` cho đúng bảng/SP/field của từng menu.
3. Dựng Livewire component + route theo convention module.
4. Đối chiếu trang chuẩn 14 mục (§2.8).
5. Verify bằng browser thật trên `http://portal.diepxuan.corp/simba`.
6. Cập nhật task doc này + `_index.md`.

## Ghi chú

- Chấm đỏ trong sidebar **không phải lỗi Portal** — Portal đọc đúng `active` từ `sysMenu`.
- Muốn bật: cập nhật `active = 1` cho menuid tương ứng trong bảng `sysMenu` trên SimbaERP gốc (không sửa trực tiếp qua Portal).
- Sau khi bật, `SimbaMetadataService` cần refresh cache để sidebar nhận thay đổi.
