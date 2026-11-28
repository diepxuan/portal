# Task 386: PO — 36 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: PO (Mua hàng)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **36 menu PO đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 36 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `10.10.02` | Đề nghị mua hàng | Số liệu | POVchPO0 | PO0 | 0 | 10.10.02 |
| 2 | `10.10.08` | Phiếu nhập mua hàng | Số liệu | POVchPO2 | PO2 | 0 | 10.10.08 |
| 3 | `10.10.11` | Phiếu nhập mua xuất thẳng | Số liệu | POVchPO8 | PO8 | 0 | 10.10.10 |
| 4 | `10.10.29` | Phiếu chi tiền hàng | Số liệu | APVchAP1 | AP1 | 0 | 12.10.02 |
| 5 | `10.10.32` | Phiếu chi tiền hàng qua ngân hàng | Số liệu | APVchAP2 | AP2 | 0 | 12.10.05 |
| 6 | `10.10.35` | Phiếu điều chỉnh công nợ phải trả | Số liệu | APVchAP3 | AP3 | 0 | 12.10.08 |
| 7 | `10.10.41` | Phân bổ các phiếu thanh toán khác cho hóa đơn mua hàng | Số liệu | APPost2TT | APPost2TT | 0 | 12.10.30 |
| 8 | `10.10.47` | Số dư đầu kỳ các hóa đơn phải trả | Xử lý | APTT | MA_APTT | 0 | 12.10.20 |
| 9 | `10.10.50` | Tính lại số dư nhà cung cấp | Số liệu | ARRecalCustBalance | - | 0 | 12.10.23 |
| 10 | `10.10.56` | Chuyển số liệu vào sổ cái | Số liệu | GLPost2GL | - | 0 | 10.10.32 |
| 11 | `10.20.14` | Tình hình thực hiện đơn hàng | Báo cáo | PORptBCPT01 | - | 1 | 10.20.21 |
| 12 | `10.20.17` | Tình hình thực hiện phiếu nhập mua hàng | Báo cáo | PORptBCPT02 | - | 1 | 10.20.24 |
| 13 | `10.20.29` | Báo cáo chiết khấu mua hàng | Báo cáo | PORptBCPT04 | - | 1 | 10.20.44 |
| 14 | `10.20.35` | Bảng kê hóa đơn mua hàng nhập khẩu | Báo cáo | PORptBK01 | - | 1 | 10.20.01 |
| 15 | `10.20.38` | Bảng kê hóa đơn mua hàng dịch vụ | Báo cáo | PORptBK01 | - | 1 | 10.20.01 |
| 16 | `10.20.41` | Bảng kê phiếu chi phí mua hàng | Báo cáo | PORptBK01 | - | 1 | 10.20.01 |
| 17 | `10.20.44` | Bảng kê phiếu xuất trả lại nhà cung cấp | Báo cáo | PORptBK01 | - | 1 | 10.20.01 |
| 18 | `10.20.47` | Bảng kê hóa đơn mua hàng nhập khẩu nhóm theo chỉ tiêu | Báo cáo | PORptBK02 | - | 1 | 10.20.04 |
| 19 | `10.20.50` | Bảng kê hóa đơn mua hàng dịch vụ nhóm theo chỉ tiêu | Báo cáo | PORptBK02 | - | 1 | 10.20.04 |
| 20 | `10.20.53` | Bảng kê phiếu chi phí mua hàng nhóm theo chỉ tiêu | Báo cáo | PORptBK02 | - | 1 | 10.20.04 |
| 21 | `10.20.56` | Bảng kê phiếu xuất trả lại nhà cung cấp nhóm theo chỉ tiêu | Báo cáo | PORptBK02 | - | 1 | 10.20.04 |
| 22 | `10.20.59` | Tổng hợp hóa đơn mua hàng nhập khẩu | Báo cáo | PORptTH01 | - | 1 | 10.20.11 |
| 23 | `10.20.62` | Tổng hợp hóa đơn mua hàng dịch vụ | Báo cáo | PORptTH01 | - | 1 | 10.20.11 |
| 24 | `10.20.65` | Tổng hợp phiếu chi phí mua hàng | Báo cáo | PORptTH01 | - | 1 | 10.20.11 |
| 25 | `10.20.68` | Tổng hợp phiếu xuất trả lại nhà cung cấp | Báo cáo | PORptTH01 | - | 1 | 10.20.11 |
| 26 | `10.20.71` | Tổng hợp hóa đơn mua hàng nhập khẩu theo kỳ | Báo cáo | PORptTH02 | - | 1 | 10.20.14 |
| 27 | `10.20.74` | Tổng hợp hóa đơn mua hàng dịch vụ theo kỳ | Báo cáo | PORptTH02 | - | 1 | 10.20.14 |
| 28 | `10.20.77` | Tổng hợp chi phí mua hàng theo kỳ | Báo cáo | PORptTH02 | - | 1 | 10.20.14 |
| 29 | `10.20.80` | Tổng hợp phiếu xuất trả lại nhà cung cấp theo kỳ | Báo cáo | PORptTH02 | - | 1 | 10.20.14 |
| 30 | `10.20.83` | Tình hình thực hiện phiếu nhập/hóa đơn theo đơn hàng | Báo cáo | PORptBCPT01 | - | 1 | 10.20.21 |
| 31 | `10.20.86` | Tình hình thực hiện hóa đơn theo phiếu nhập mua hàng | Báo cáo | PORptBCPT02 | - | 1 | 10.20.24 |
| 32 | `10.30.05` | Bảng kê hóa đơn theo hạn thanh toán | Báo cáo | APRptBK02 | - | 1 | 12.20.05 |
| 33 | `10.30.08` | Bảng kê phiếu chi thanh toán tiền hàng | Báo cáo | APRptBK03 | - | 1 | 12.20.08 |
| 34 | `10.90.05` | Điều khoản thanh toán | Danh mục | PODMDKTT | MA_TT_PO | 0 | 10.90.05 |
| 35 | `10.90.28` | Phân nhóm nhà cung cấp | Danh mục | ARDMNHKH | MA_NHKH | 0 | 12.90.08 |
| 36 | `10.90.83` | Khai báo màn hình chứng từ | Danh mục | SIDMCT | SIDMCT | 0 | 10.90.83 |

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
