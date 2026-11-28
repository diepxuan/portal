# Task 392: CA — 11 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: CA (Tiền mặt - Ngân hàng)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **11 menu CA đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 11 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `04.10.14` | Phiếu thanh toán | Số liệu | CAVchCA5 | CA5 | 0 | 04.10.14 |
| 2 | `04.10.20` | Số dư đầu các phiếu chi | Xử lý | CACDPC | MA_CATTHU | 0 | 04.10.20 |
| 3 | `04.10.23` | Số dư đầu kỳ của khế ước | Xử lý | CACDKU | MA_CACDKU | 0 | 04.10.23 |
| 4 | `04.10.29` | Tính lãi khế ước | Số liệu | CACalLaiKu | - | 0 | 04.10.29 |
| 5 | `04.10.32` | Điều chỉnh lãi khế ước | Số liệu | CALAIKU | MA_LAI | 0 | 04.10.32 |
| 6 | `04.10.69` | Chuyển số liệu vào sổ cái | Số liệu | GLPost2GL | - | 0 | 04.10.69 |
| 7 | `04.20.17` | Bảng dự tính lãi vay | Báo cáo | CARptTMNH05 | - | 1 | 04.20.17 |
| 8 | `04.20.23` | Bảng cân đối phát sinh khế ước | Báo cáo | CARptTMNH07 | - | 1 | 04.20.23 |
| 9 | `04.20.26` | Bảng theo dõi tạm ứng | Báo cáo | CARptTMNH04 | - | 1 | 04.20.26 |
| 10 | `04.90.02` | Khế ước | Danh mục | CADMKU | MA_KU | 0 | 04.90.02 |
| 11 | `04.90.14` | Khai báo màn hình chứng từ | Danh mục | SIDMCT | SIDMCT | 0 | - |

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
