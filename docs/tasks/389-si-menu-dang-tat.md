# Task 389: SI — 16 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: SI (Hệ thống)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **16 menu SI đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 16 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `90.10.08` | Khai báo tham số kết nối | Số liệu | - | - | 0 | 90.10.08 |
| 2 | `90.10.14` | Danh mục nhóm hợp đồng | Số liệu | SIDMNHHD | MA_NHHD | 0 | 90.10.14 |
| 3 | `90.10.17` | Danh mục hợp đồng | Số liệu | SIDMHD | MA_HD | 0 | 90.10.17 |
| 4 | `90.10.35` | Danh mục các trường tự do | Số liệu | OptFieldInfo | - | 0 | 90.10.35 |
| 5 | `90.10.38` | Khai báo các trường tự do cho các ctừ | Số liệu | OptFieldSetup | - | 0 | 90.10.38 |
| 6 | `90.10.41` | Danh mục tự do 9 (OPT9) | Số liệu | SIDMOpt9 | MA_OPT9 | 0 | 90.10.41 |
| 7 | `90.10.44` | Danh mục tự do 10 (OPT10) | Số liệu | SIDMOpt10 | MA_OPT10 | 0 | 90.10.44 |
| 8 | `90.30.08` | Bảo trì và kiểm tra dữ liệu | Số liệu | SIMaintain | - | 0 | 90.30.07 |
| 9 | `90.30.23` | Thông tin update | Số liệu | SiUpdateLog | SIUPDLOG | 0 | 90.30.32 |
| 10 | `90.30.29` | Thông tin chương trình | Số liệu | SIAbout | - | 0 | 90.30.11 |
| 11 | `90.40.02` | Cập nhật các chỉnh sửa | Số liệu | SIUPDATETOOL | - | 0 | 90.40.14 |
| 12 | `90.40.05` | Khai báo kiểu menu và màu hệ thống | Số liệu | SITheme | - | 0 | 90.40.09 |
| 13 | `90.40.08` | Khai báo menu báo cáo | Số liệu | SiTools_2 | TOOLS | 0 | 90.40.87 |
| 14 | `90.40.11` | Công cụ hỗ trợ triển khai | Số liệu | SiTools | TOOLS | 0 | 90.40.84 |
| 15 | `90.40.20` | Danh mục đơn vị | 3 | - | - | 0 | 90.30.01 |
| 16 | `90.40.23` | Đăng ký bản quyền | Số liệu | - | - | 0 | - |

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
