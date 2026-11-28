# Task 388: SA — 18 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: SA (Tiền lương)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **18 menu SA đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 18 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `24.10.02` | Bảng lương | Số liệu | SABangLuong | - | 0 | 22.10.02 |
| 2 | `24.10.05` | Quỹ lương bộ phận | Số liệu | SAQuyLuongBP | - | 0 | 22.10.04 |
| 3 | `24.20.02` | Bảng thanh toán tiền lương | Báo cáo | SARptBangLuong | - | 1 | 22.20.02 |
| 4 | `24.20.05` | Phiếu lương | Báo cáo | SARptPhieuLuong | - | 1 | 22.20.04 |
| 5 | `24.20.08` | Bảng thanh toán tạm ứng | Báo cáo | SARptTamUng | - | 1 | 22.20.06 |
| 6 | `24.20.11` | Bảng lương thêm giờ | Báo cáo | SARptThemGio | - | 1 | 22.20.08 |
| 7 | `24.20.14` | Bảng trích nộp thuế thu nhập cá nhân | Báo cáo | SARptThueTNCN | - | 1 | 22.20.10 |
| 8 | `24.20.17` | Trích nộp bảo hiểm xã hội | Báo cáo | SARptPhiBHXH | - | 1 | 22.20.12 |
| 9 | `24.20.20` | Trích nộp đoàn phí công đoàn | Báo cáo | SARptPhiCongDoan | - | 1 | 22.20.14 |
| 10 | `24.20.23` | Bảng tổng hợp tiền lương | Báo cáo | SARptTongQuyLuong | - | 1 | 22.20.16 |
| 11 | `24.20.26` | Bảng lương (tùy chọn) | Báo cáo | SARptDynBangLuong | - | 1 | 22.20.18 |
| 12 | `24.90.02` | Xếp loại | Danh mục | SADmXepLoai | MA_XEPLOAI | 0 | 22.30.02 |
| 13 | `24.90.05` | Sản phẩm | Danh mục | SADmSanPham | MA_SANPHAM | 0 | 22.30.04 |
| 14 | `24.90.08` | Công đoạn | Danh mục | SADmSanPham | MA_CONGDOAN | 0 | 22.30.06 |
| 15 | `24.90.11` | Đơn giá sản phẩm | Danh mục | SADonGiaSP | MA_DONGIASP | 0 | 22.30.08 |
| 16 | `24.90.14` | Thuế TNCN | Danh mục | SaDmThueTNCN | MA_THUETNCN | 0 | 22.30.10 |
| 17 | `24.90.17` | Số người phụ thuộc | Danh mục | SaDmNguoiPhuThuoc | MA_NPT | 0 | 22.30.11 |
| 18 | `24.90.20` | Khai báo tham số hệ thống | Danh mục | SISysvars | - | 0 | 22.30.12 |

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
