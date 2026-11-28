# Task 393: CO — 10 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: CO (Giá thành)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **10 menu CO đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 10 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `18.30.02` | Nhập sản phẩm dở dang cuối kỳ | Xử lý | CODD1 | MA_SPCT_DD | 0 | 16.20.01 |
| 2 | `18.30.05` | Bảng giá thành sản phẩm | Báo cáo | COGDBGT | - | 1 | 16.20.10 |
| 3 | `18.40.02` | Nhập sản phẩm dở dang cuối kỳ | Xử lý | CODD1 | MA_SPCT_DD | 0 | 16.30.05 |
| 4 | `18.40.05` | Bảng giá thành kế hoạch | Báo cáo | - | - | 0 | 16.30.10 |
| 5 | `18.40.08` | Bảng giá thành sản phẩm | Báo cáo | CODMBGT | - | 0 | 16.30.15 |
| 6 | `18.50.02` | Số dư đầu kỳ công trình | Xử lý | - | - | 0 | 16.40.01 |
| 7 | `18.50.05` | Số lũy kế từ khi khởi công công trình | Xử lý | - | - | 0 | 16.40.05 |
| 8 | `18.50.08` | Sổ giá thành công trình xây lắp | Báo cáo | - | - | 0 | 16.40.10 |
| 9 | `18.50.11` | Bảng kê phát sinh theo công trình xây lắp | Báo cáo | - | - | 0 | 16.40.15 |
| 10 | `18.50.14` | Bảng cân đối phát sinh công trình và khách hàng | Báo cáo | - | - | 0 | 16.40.20 |

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
