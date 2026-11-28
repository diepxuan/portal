# Task 384: SO — 48 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: SO (Bán hàng)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **48 menu SO đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 48 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `06.10.05` | Phiếu xuất bán hàng | Số liệu | SOVchSO2 | SO2 | 0 | 06.10.06 |
| 2 | `06.10.20` | Phiếu thu tiền hàng | Số liệu | ARVchAR1 | AR1 | 0 | 08.10.02 |
| 3 | `06.10.23` | Phiếu thu tiền hàng qua ngân hàng | Số liệu | ARVchAR2 | AR2 | 0 | 08.10.05 |
| 4 | `06.10.26` | Phiếu điều chỉnh công nợ phải thu | Số liệu | ARVchAR3 | AR3 | 0 | 08.10.08 |
| 5 | `06.10.32` | Phân bổ các phiếu thanh toán khác cho hóa đơn bán hàng | Số liệu | ARPost2TT | ARPost2TT | 0 | 08.10.30 |
| 6 | `06.10.43` | Số dư đầu kỳ các hóa đơn phải thu | Xử lý | ARTT | MA_ARTT | 0 | 08.10.20 |
| 7 | `06.10.46` | Tính số dư tức thời khách hàng | Số liệu | ARRecalCustBalance | - | 0 | 08.10.23 |
| 8 | `06.10.80` | Chuyển số liệu vào sổ cái | Số liệu | GLPost2GL | - | 0 | 06.10.26 |
| 9 | `06.20.14` | Tình hình thực hiện đơn hàng | Báo cáo | SORptBCPT01 | - | 1 | 06.20.21 |
| 10 | `06.20.17` | Tình hình thực hiện phiếu xuất bán hàng | Báo cáo | SORptBCPT02 | - | 1 | 06.20.24 |
| 11 | `06.20.29` | Báo cáo bán hàng theo ba chỉ tiêu | Báo cáo | SORptBCPT07 | - | 1 | 06.20.40 |
| 12 | `06.20.32` | Báo cáo chiết khấu bán hàng | Báo cáo | SORptBCPT08 | - | 1 | 06.20.43 |
| 13 | `06.20.35` | Báo cáo chiết khấu thương mại | Báo cáo | SORptBCPT09 | - | 1 | 06.20.46 |
| 14 | `06.20.38` | Báo cáo chiết khấu thanh toán | Báo cáo | SORptBCPT10 | - | 1 | 06.20.49 |
| 15 | `06.20.41` | Bảng kê tính cước vận tải | Báo cáo | SORptCVT01 | - | 1 | 06.20.61 |
| 16 | `06.20.44` | Tổng hợp tính cước vận tải | Báo cáo | SORptCVT02 | - | 1 | 06.20.64 |
| 17 | `06.20.53` | Bảng kê phiếu nhập hàng bán bị trả lại | Báo cáo | SORptBK01 | - | 1 | 06.20.01 |
| 18 | `06.20.56` | Bảng kê hóa đơn dịch vụ | Báo cáo | SORptBK01 | - | 1 | 06.20.01 |
| 19 | `06.20.59` | Bảng kê phiếu nhập hàng bán bị trả lại nhóm theo chỉ tiêu | Báo cáo | SORptBK02 | - | 1 | 06.20.04 |
| 20 | `06.20.62` | Bảng kê hóa đơn dịch vụ nhóm theo chỉ tiêu | Báo cáo | SORptBK02 | - | 1 | 06.20.04 |
| 21 | `06.20.65` | Tổng hợp phiếu nhập hàng bán bị trả lại | Báo cáo | SORptTH01 | - | 1 | 06.20.11 |
| 22 | `06.20.68` | Tổng hợp hóa đơn dịch vụ | Báo cáo | SORptTH01 | - | 1 | 06.20.11 |
| 23 | `06.20.71` | Tổng hợp phiếu nhập hàng bán bị trả lại theo kỳ | Báo cáo | SORptTH02 | - | 1 | 06.20.14 |
| 24 | `06.20.74` | Tổng hợp hóa đơn dịch vụ theo kỳ | Báo cáo | SORptTH02 | - | 1 | 06.20.14 |
| 25 | `06.20.77` | Tình hình thực hiện xuất hàng/hóa đơn theo đơn hàng | Báo cáo | SORptBCPT01 | - | 1 | 06.20.21 |
| 26 | `06.20.80` | Tình hình thực hiện xuất hóa đơn theo phiếu xuất hàng | Báo cáo | SORptBCPT02 | - | 1 | 06.20.24 |
| 27 | `06.30.05` | Bảng kê hóa đơn theo hạn thanh toán | Báo cáo | ARRptBK02 | - | 1 | 08.20.05 |
| 28 | `06.30.08` | Bảng kê phiếu thu thanh toán tiền hàng | Báo cáo | ARRptBK03 | - | 1 | 08.20.08 |
| 29 | `06.30.32` | Bảng cân đối công nợ theo hạn thanh toán | Báo cáo | ARRptBCCN06 | - | 1 | 08.20.24 |
| 30 | `06.90.08` | Điều khoản thanh toán | Danh mục | SODMDKTT | MA_TT | 0 | 06.90.05 |
| 31 | `06.90.14` | Nhóm khách hàng | Danh mục | ARDMNHKH | MA_NHKH | 0 | 08.90.08 |
| 32 | `06.90.17` | Chiết khấu | Danh mục | SODMCK | MA_DMCK | 0 | 06.90.08 |
| 33 | `06.90.20` | Khuyến mại | Danh mục | SODMKM | MA_KM | 0 | 06.90.09 |
| 34 | `06.90.23` | Hàng trả khuyến mại | Danh mục | SODMTKM | MA_TKM | 0 | 06.90.39 |
| 35 | `06.90.26` | Hàng hóa khuyến mại | Danh mục | SODMHHKM | MA_HHKM | 0 | 06.90.40 |
| 36 | `06.90.41` | Các tuyến đường | Danh mục | SODMTD | MA_TD | 0 | 06.90.23 |
| 37 | `06.90.44` | Phương tiện vận tải | Danh mục | SODMPTVT | MA_PT | 0 | 06.90.26 |
| 38 | `06.90.47` | Giá vận tải | Danh mục | SODMDGVT | MA_GIAVANTAI | 0 | 06.90.29 |
| 39 | `06.90.53` | Khai báo màn hình chứng từ | Danh mục | SIDMCT | SIDMCT | 0 | 06.90.38 |
| 40 | `06.95.01` | Quyết định in hoá đơn tự in | Báo cáo | SOND51dmqdadhd | SOND51dmqdadhd | 1 | 06.95.01 |
| 41 | `06.95.02` | Khai báo mẫu hoá đơn tự in | Báo cáo | SOND51dmmhd | MAU_SO | 1 | 06.95.02 |
| 42 | `06.95.03` | Phát hành mẫu hoá đơn tự in | Báo cáo | SOND51phhd | SOND51phhd | 1 | 06.95.03 |
| 43 | `06.95.04` | Bảng kê hoá đơn tự in | Báo cáo | SOND51bkhd | SOND51bkhd | 1 | 06.95.04 |
| 44 | `06.95.05` | Thông báo huỷ hoá đơn tự in | Báo cáo | SOND51huyhd | SOND51huyhd | 1 | 06.95.05 |
| 45 | `06.95.06` | Thông báo mất, cháy, hỏng hoá đơn tự in | Báo cáo | SOND51mathd | SOND51mathd | 1 | 06.95.06 |
| 46 | `06.95.07` | Thông báo xoá hoá đơn tự in | Báo cáo | SOND51xoahd | SOND51xoahd | 1 | 06.95.07 |
| 47 | `06.95.08` | Bảo mật hoá đơn tự in | Báo cáo | SOND51bmhd | SOND51bmhd | 1 | 06.95.08 |
| 48 | `06.95.09` | Tình hình sử dụng hoá đơn tự in | Báo cáo | SOND51tkhd | SOND51tkhd | 1 | 06.95.09 |

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
