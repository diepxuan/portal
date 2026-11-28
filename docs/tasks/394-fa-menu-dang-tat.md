# Task 394: FA — 10 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: FA (Tài sản cố định)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **10 menu FA đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 10 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `20.10.08` | Chuyển tài sản cố định | Số liệu | FAChuyenTS | FAChuyenTS | 0 | 18.10.10 |
| 2 | `20.20.26` | Báo cáo tài sản cố định theo hai chỉ tiêu | Báo cáo | FARptBCPT01 | - | 1 | 18.20.26 |
| 3 | `20.20.29` | *Báo cáo tài sản hai chỉ tiêu theo nguồn vốn | Báo cáo | FARptBCPT02 | - | 1 | 18.20.29 |
| 4 | `20.20.32` | *Bảng tính khấu hao tài sản theo nguồn vốn | Báo cáo | FARptBCPT03 | - | 1 | 18.20.32 |
| 5 | `20.20.35` | *Bảng phân bổ khấu hao theo nhóm tài sản | Báo cáo | FARptBCPT04 | - | 1 | 18.20.35 |
| 6 | `20.20.38` | Bảng phân bổ khấu hao theo hai chỉ tiêu | Báo cáo | FARptBCPT05 | - | 1 | 18.20.38 |
| 7 | `20.20.41` | *Bảng phân bổ khấu hao theo nguồn vốn | Báo cáo | FARptBCPT06 | - | 1 | 18.20.41 |
| 8 | `20.20.44` | *Báo cáo tăng giảm tài sản hai chỉ tiêu theo nguồn vốn | Báo cáo | FARptBCPT07 | - | 1 | 18.20.44 |
| 9 | `20.20.47` | *Báo cáo chi tiết kiểm kê tài sản theo nguồn vốn | Báo cáo | FARptBCPT08 | - | 1 | 18.20.47 |
| 10 | `20.30.05` | *Tổng hợp phân bổ công cụ dụng cụ theo hai chỉ tiêu | Báo cáo | FARptBCPT09 | - | 1 | 18.20.53 |

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
