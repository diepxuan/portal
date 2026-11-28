# Task 385: HR — 40 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: HR (Nhân sự)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **40 menu HR đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 40 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `22.10.02` | Hồ sơ nhân sự | Số liệu | HrHsNs | MA_NVNS | 0 | 20.10.02 |
| 2 | `22.10.05` | Quá trình nâng lương | Số liệu | HrQtNANGLUONG | MA_QTNL | 0 | 20.10.05 |
| 3 | `22.10.08` | Hồ sơ ứng viên | Số liệu | HrHsNs | MA_NVNS | 0 | 20.10.08 |
| 4 | `22.10.11` | Yêu cầu tuyển dụng | Số liệu | HRYCTD | MA_YCTD | 0 | 20.10.11 |
| 5 | `22.10.14` | Chọn lọc hồ sơ ứng viên | Số liệu | HrCLHSUV | MA_CLHSUV | 0 | 20.10.14 |
| 6 | `22.10.17` | Kết quả phỏng vấn | Số liệu | HrKQPV | MA_KQPVPH | 0 | 20.10.17 |
| 7 | `22.10.20` | Hồ sơ nhân sự đã nghỉ việc | Số liệu | HrHsNs | MA_NVNS | 0 | 20.10.20 |
| 8 | `22.20.00` | Báo cáo Thông tin nhân sự | Báo cáo | - | - | 0 | 20.20.00 |
| 9 | `22.20.02` | Thống kê tuổi lao động | Báo cáo | HRRptAge | - | 1 | 20.20.02 |
| 10 | `22.20.05` | Danh sách ngày kỷ niệm của nhân viên | Báo cáo | HRRptDSNKN | - | 1 | 20.20.05 |
| 11 | `22.20.08` | Danh sách khen thưởng kỷ luật | Báo cáo | HRRptDSKTKL | - | 1 | 20.20.08 |
| 12 | `22.20.11` | Danh sách thông tin liên lạc của nhân viên | Báo cáo | HRRptDSTTLL | - | 1 | 20.20.11 |
| 13 | `22.20.14` | Danh sách Đảng viên | Báo cáo | HRRptDSDV | - | 1 | 20.20.14 |
| 14 | `22.20.17` | Thống kê trình độ ngoại ngữ | Báo cáo | HRRptTKTDNN | - | 1 | 20.20.17 |
| 15 | `22.20.20` | Thống kê trình độ tin học | Báo cáo | HRRptTKTDTH | - | 1 | 20.20.20 |
| 16 | `22.20.23` | Thống kê trình độ đào tạo | Báo cáo | HRRptTKTDDT | - | 1 | 20.20.23 |
| 17 | `22.20.26` | Danh sách trang bị công cụ lao động | Báo cáo | HRRptDSTBCC | - | 1 | 20.20.26 |
| 18 | `22.20.27` | Hợp đồng lao động | Báo cáo | HRRptHDLD | - | 1 | 20.20.27 |
| 19 | `22.30.00` | Báo cáo Phân tích nhân sự | Báo cáo | - | - | 1 | 20.30.00 |
| 20 | `22.30.02` | Báo cáo tình hình nhân sự | Báo cáo | HRRptTHNS | - | 1 | 20.30.41 |
| 21 | `22.30.05` | Báo cáo nhân sự theo hai chỉ tiêu | Báo cáo | HRRptNS2CT | - | 1 | 20.30.44 |
| 22 | `22.30.08` | Quá trình thay đổi bộ phận | Báo cáo | HRRptQTCBP | - | 1 | 20.30.47 |
| 23 | `22.30.14` | Danh sách nhân viên hết hạn HĐLĐ | Báo cáo | HRRptHHHD | - | 1 | 20.30.51 |
| 24 | `22.30.17` | Danh sách nhân viên bị tai nạn | Báo cáo | HRRptTNLD | - | 1 | 20.30.54 |
| 25 | `22.30.20` | Danh sách nhân viên thôi việc | Báo cáo | HRRptNSTV | - | 1 | 20.30.57 |
| 26 | `22.30.23` | Quá trình nghỉ chế độ | Báo cáo | HRRptQTNCD | - | 1 | 20.30.60 |
| 27 | `22.30.29` | Thông tin y tế và thông tin khác | Báo cáo | HRRptOther | - | 1 | 20.30.63 |
| 28 | `22.30.32` | Danh sách lao động và quỹ tiền lương nộp BHXH | Báo cáo | HRRptBHXH | - | 1 | 20.30.66 |
| 29 | `22.30.35` | Danh sách nhân viên nâng lương | Báo cáo | HRRptNangLuong | - | 1 | 20.30.69 |
| 30 | `22.90.02` | Khai báo tổ chức các đơn vị trong công ty | Số liệu | HrUtilities | MA_CCTC | 0 | 20.90.02 |
| 31 | `22.90.05` | Thang bảng lương | Danh mục | HrDmTBL | MA_TBL | 0 | 20.90.05 |
| 32 | `22.90.08` | Ngạch bậc | Danh mục | HrDmTBL | MA_NB | 0 | 20.90.06 |
| 33 | `22.90.11` | Lương tối thiểu | Danh mục | HrDmLTT | MA_LTT | 0 | 20.90.08 |
| 34 | `22.90.14` | Chế độ nghỉ | Danh mục | HrDmCDN | MA_CDN | 0 | 20.90.11 |
| 35 | `22.90.17` | Nhóm đánh giá | Danh mục | HrDmNDG | MA_NDG | 0 | 20.90.14 |
| 36 | `22.90.20` | Loại tiêu chuẩn đánh giá | Danh mục | HrDmLTCDG | MA_LTCDG | 0 | 20.90.17 |
| 37 | `22.90.23` | Kết quả đánh giá | Danh mục | HrDmKQDG | MA_KQDG | 0 | 20.90.20 |
| 38 | `22.90.26` | Các trường tuỳ chọn | Danh mục | HrDmOpt | MA_OPT | 0 | 20.90.23 |
| 39 | `22.90.29` | Các danh mục khác | Danh mục | HrDmOrther | MA_ORTHER | 0 | 20.90.27 |
| 40 | `22.90.32` | Khai báo tham số hệ thống | Danh mục | SISysvars | - | 0 | 20.90.30 |

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
