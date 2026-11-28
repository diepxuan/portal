# Task 390: IN — 12 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: IN (Tồn kho)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **12 menu IN đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 12 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `14.10.17` | Điều chỉnh kiểm kê cuối kỳ | Số liệu | INVchIN9 | IN9 | 0 | 14.10.34 |
| 2 | `14.10.35` | Chuyển số liệu vào sổ cái | Số liệu | GLPost2GL | - | 0 | 14.10.38 |
| 3 | `14.20.35` | Nhập xuất tồn: Số lượng - cộng theo nhóm | Báo cáo | INRptCD01 | - | 1 | 14.20.08 |
| 4 | `14.20.38` | Nhập xuất tồn: Cộng theo phân loại 1/2/3 | Báo cáo | INRptCD01 | - | 1 | 14.20.08 |
| 5 | `14.20.41` | Nhập xuất tồn: Cộng theo tài khoản | Báo cáo | INRptCD01 | - | 1 | 14.20.08 |
| 6 | `14.20.44` | Nhập xuất tồn: Cộng theo kho và vị trí | Báo cáo | INRptCD01 | - | 1 | 14.20.08 |
| 7 | `14.20.47` | Nhập xuất tồn: Cộng theo theo lô | Báo cáo | INRptCD01 | - | 1 | 14.20.08 |
| 8 | `14.90.08` | Phân loại hàng hóa, vật tư | Danh mục | INDMPLVT | MA_PLVT | 0 | 14.90.08 |
| 9 | `14.90.11` | Nhóm hàng VAT | Danh mục | INDMNHVAT | MA_NHVAT | 0 | 14.90.11 |
| 10 | `14.90.17` | Vị trí | Danh mục | INDMVITRI | MA_VITRI | 0 | 14.90.17 |
| 11 | `14.90.32` | Dạng nhập xuất | Danh mục | SIDMHTTT | MA_NX | 0 | 14.90.32 |
| 12 | `14.90.41` | Khai báo màn hình chứng từ | Danh mục | SIDMCT | SIDMCT | 0 | 14.90.41 |

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
