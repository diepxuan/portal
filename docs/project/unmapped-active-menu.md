# Unmapped Active Simba Menus

Ngay cap nhat: 2026-05-15

Danh sach nay la 57 active menu con lai sau khi `SimbaRouteRegistry` da map tat ca menu actionable co metadata report/dictionary/voucher, co DLL/command/code_name, hoac co route he thong hien huu.

Quy tac doc:

- Cac dong co `dllName`, `command`, hoac `code_name` rong khong duoc tao process route.
- Cac dong nay la root/group/section menu hoac dong trong cua `sysMenu`.
- Neu `simba-docs` sau nay bo sung anchor ky thuat/metadata cho bat ky dong nao, test `SimbaRouteRegistryTest::testEveryActionableActiveMenuHasRouteAnchor` se bat buoc them route.
- Test `SimbaRouteRegistryTest::testRemainingActiveMenusWithoutRoutesAreNonActionableContainers` khoa so 57 dong va dam bao khong dong nao co DLL/command/code_name.
- `90.40.14` da duoc map vao route hien huu `system.balance.index`; do do khong con trong danh sach nay.
- `90.40.17` da duoc map vao route hien huu `system.company`; route nay chi cap nhat session don vi dang chon.

| menuid | module | type | label | dllName | command | code_name |
|---|---|---:|---|---|---|---|
| 02.00.00 | GL | 5 | Tổng hợp |  |  |  |
| 02.10.00 | GL | blank | Số liệu |  |  |  |
| 02.20.00 | GL | 4 | Báo cáo Chứng từ ghi sổ |  |  |  |
| 02.25.00 | GL | 4 | Báo cáo Nhật ký chung |  |  |  |
| 02.40.00 | GL | 4 | Báo cáo Thuế |  |  |  |
| 02.50.00 | GL | 4 | Báo cáo Tài chính - Doanh nghiệp |  |  |  |
| 02.55.00 | GL | 4 | Báo cáo Tài chính - Chủ đầu tư |  |  |  |
| 02.60.00 | GL | 4 | Báo cáo Phân tích |  |  |  |
| 02.90.00 | GL | blank | Danh mục & Tham số |  |  |  |
| 04.00.00 | CA | 5 | Tiền mặt, Ngân hàng |  |  |  |
| 04.10.00 | CA | blank | Số liệu |  |  |  |
| 04.20.00 | CA | 4 | Báo cáo Tiền mặt, ngân hàng |  |  |  |
| 04.90.00 | CA | blank | Danh mục & Tham số |  |  |  |
| 06.00.00 | SO | 5 | Bán hàng |  |  |  |
| 06.10.00 | SO | blank | Số liệu |  |  |  |
| 06.20.00 | SO | 4 | Báo cáo Bán hàng |  |  |  |
| 06.30.00 | SO | 4 | Báo cáo Công nợ phải thu |  |  |  |
| 06.90.00 | SO | blank | Danh mục & Tham số |  |  |  |
| 10.00.00 | PO | 5 | Mua hàng |  |  |  |
| 10.10.00 | PO | blank | Số liệu |  |  |  |
| 10.20.00 | PO | 4 | Báo cáo Mua hàng |  |  |  |
| 10.30.00 | PO | 4 | Báo cáo Công nợ phải trả |  |  |  |
| 10.90.00 | PO | blank | Danh mục & Tham số |  |  |  |
| 14.00.00 | IN | 5 | Hàng tồn kho |  |  |  |
| 14.10.00 | IN | blank | Số liệu |  |  |  |
| 14.20.00 | IN | 4 | Báo cáo Tồn kho |  |  |  |
| 14.90.00 | IN | blank | Danh mục & Tham số |  |  |  |
| 17.00.00 | CO | 5 | Chi phí |  |  |  |
| 17.15.00 | CO | blank | Số liệu |  |  |  |
| 17.60.00 | CO | 4 | Báo cáo Chi phí |  |  |  |
| 17.90.00 | CO | blank | Danh mục & tham số |  |  |  |
| 18.00.00 | CO | 5 | Giá thành |  |  |  |
| 18.10.00 | CO | blank | Số liệu |  |  |  |
| 18.15.00 | CO | blank | Chi phí trả trước |  |  |  |
| 18.20.00 | CO | 4 | Báo cáo Giá thành sản phẩm |  |  |  |
| 18.25.00 | CO | 4 | Báo cáo Giá thành công trình |  |  |  |
| 18.60.00 | CO | 4 | Báo cáo Chi phí |  |  |  |
| 18.90.00 | CO | blank | Danh mục & tham số |  |  |  |
| 20.00.00 | FA | 5 | Tài sản, Công cụ |  |  |  |
| 20.10.00 | FA | blank | Số liệu - Tài sản |  |  |  |
| 20.10.20 | FA | blank |  |  |  |  |
| 20.10.32 | FA | blank |  |  |  |  |
| 20.10.41 | FA | blank |  |  |  |  |
| 20.15.00 | FA | blank | Số liệu - Công cụ |  |  |  |
| 20.20.00 | FA | 4 | Báo cáo Tài sản |  |  |  |
| 20.20.23 | FA | blank |  |  |  |  |
| 20.20.50 | FA | blank |  |  |  |  |
| 20.30.00 | FA | 4 | Báo cáo Công cụ |  |  |  |
| 20.90.00 | FA | blank | Danh mục |  |  |  |
| 20.90.14 | FA | blank |  |  |  |  |
| 90.00.00 | SI | 5 | Hệ thống |  |  |  |
| 90.10.00 | SI | blank | Tham số và danh mục dùng chung |  |  |  |
| 90.10.11 | SI | blank |  |  |  |  |
| 90.10.32 | SI | blank |  |  |  |  |
| 90.20.00 | SI | blank | Quản lý người sử dụng |  |  |  |
| 90.30.00 | SI | blank | Bảo trì dữ liệu và cập nhật |  |  |  |
| 90.40.00 | SI | blank | Quản trị và cấu hình hệ thống |  |  |  |
