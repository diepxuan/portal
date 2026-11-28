# Task 387: GL — 28 menu đang TẮT trên SimbaERP cần dựng màn hình

## Nhóm: GL (Tổng hợp)

- **Status:** PENDING — menu `active = 0` trên SimbaERP gốc, chưa có màn hình Portal
- **Phát hiện:** 2026-11-25, khi rà `simba-docs/data/sysMenu.md` cột `active`
- **Nguồn:** `simba-docs/data/sysMenu.md` — toàn bộ menu dưới đây có `active = 0`

## Bối cảnh

Portal hiển thị **toàn bộ** menu SimbaERP trong sidebar `SimbaERP Menus` (`/simba`), kèm chấm màu trạng thái:

- 🟢 **xanh** = `active = 1` — đang hoạt động trên SimbaERP gốc
- 🔴 **đỏ** = `active = 0` — đang tắt trên SimbaERP gốc, **chưa có màn hình Portal**

Task này gom **28 menu GL đang tắt**. Trước khi dựng màn hình phải xác nhận với Sếp module/menu này có được bật trên SimbaERP hay không — nếu không dùng thì đóng task, nếu dùng thì bật `active = 1` trước.

## Danh sách 28 menu cần xử lý

| # | menuid | Tên menu | Loại | DLL | Code name | Báo cáo | Cha |
|---:|---|---|---|---|---|---|---|
| 1 | `02.10.08` | Phân bổ chi phí tự động | Số liệu | COPB | - | 0 | 02.10.29 |
| 2 | `02.10.11` | Đánh giá tỷ giá cuối kỳ | Số liệu | GLPost2DGTG | - | 0 | 02.10.04 |
| 3 | `02.10.23` | Chuyển số liệu vào sổ cái | Số liệu | GLPost2GL | - | 0 | 02.10.26 |
| 4 | `02.25.32` | Sổ cái (In tất cả) | Báo cáo | GLRptNKC01All | - | 1 | 02.21.03 |
| 5 | `02.30.00` | Báo cáo Nhật ký chứng từ | Báo cáo | - | - | 0 | 02.25.00 |
| 6 | `02.30.02` | Sổ cái | Báo cáo | DynamicReport | - | 1 | 02.25.01 |
| 7 | `02.30.05` | Nhật ký chứng từ 1-5,9 | Báo cáo | DynamicReport | - | 1 | 02.25.10 |
| 8 | `02.30.08` | Nhật ký chứng từ 8 | Báo cáo | DynamicReport | - | 1 | 02.25.15 |
| 9 | `02.30.11` | Bảng kê 1,2 | Báo cáo | DynamicReport | - | 1 | 02.25.20 |
| 10 | `02.30.14` | Bảng kê số 4 | Báo cáo | DynamicReport | - | 1 | 02.25.25 |
| 11 | `02.30.17` | Bảng kê số 5 | Báo cáo | DynamicReport | - | 1 | 02.25.26 |
| 12 | `02.30.20` | Bảng kê số 11 | Báo cáo | DynamicReport | - | 1 | 02.25.35 |
| 13 | `02.50.14` | Báo cáo lưu chuyển tiền tệ (PP gián tiếp) | Báo cáo | GLRPTBCTC05 | BCTC05 | 1 | 02.22.12 |
| 14 | `02.50.23` | Khai báo công thức bảng cân đối kế toán | Danh mục | GLMauBS01 | - | 0 | 02.22.17 |
| 15 | `02.50.26` | Khai báo công thức bảng kết quả hoạt động sản xuất kinh doan | Danh mục | GLMauPL01 | - | 0 | 02.22.20 |
| 16 | `02.50.29` | Khai báo công thức bảng lưu chuyển tiền tệ (PP trực tiếp) | Danh mục | GLMauCF01 | - | 0 | 02.22.23 |
| 17 | `02.60.17` | Bảng kê tình hình hàng nhập kho | Báo cáo | GLRptBCPT06 | - | 1 | 02.23.17 |
| 18 | `02.60.20` | Bảng kê tình hình hàng xuất kho | Báo cáo | GLRptBCPT07 | - | 1 | 02.23.20 |
| 19 | `02.60.23` | Báo cáo phân tích chỉ tiêu tài chính | Báo cáo | GLRptBCPT08 | GLPL_MA_SO08 | 1 | 02.23.21 |
| 20 | `02.65.00` | Hợp nhất báo cáo tài chính | Báo cáo | - | - | 0 | 24.05.00 |
| 21 | `02.65.02` | Bút toán điều chỉnh | Số liệu | GLVchCR1 | CR1 | 0 | 24.05.05 |
| 22 | `02.65.08` | Bảng cân đối số phát sinh | Báo cáo | GLRptBCTCCR01 | - | 1 | 24.05.10 |
| 23 | `02.65.11` | Bảng cân đối kế toán | Báo cáo | GLRptBCTCCR02 | GLBS_MA_SO | 1 | 24.05.15 |
| 24 | `02.65.14` | Báo cáo kết quả hoạt động kinh doanh | Báo cáo | GLRptBCTCCR03 | GLPL_MA_SO | 1 | 24.05.20 |
| 25 | `02.65.17` | Báo cáo lưu chuyển tiền tệ - PP trực tiếp | Báo cáo | GLRptBCTCCR04 | GLCF_MA_SO | 1 | 24.05.25 |
| 26 | `02.90.08` | Khai báo bút toán đánh giá tỷ giá | Danh mục | GLDMDGTG | GLDMDGTG | 0 | 02.90.43 |
| 27 | `02.90.11` | Khai báo bút toán phân bổ tự động | Danh mục | CODMPB | MA_PB | 0 | 02.90.46 |
| 28 | `02.90.14` | Khai báo màn hình chứng từ | Danh mục | SIDMCT | SIDMCT | 0 | - |

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
