# Task 357: Chuẩn hóa Livewire input component dùng chung

## Trạng thái

Open - 2026-07-06.

Task này được tạo sau audit `./docs/`: hiện chỉ có tài liệu **sử dụng lại** `input-khachhang`, `input-taikhoan`, `input-date`, chưa có task riêng định nghĩa cách tạo, viết, code và chuẩn hóa các Livewire input component dùng chung.

## Mục tiêu

Chuẩn hóa nhóm component nhập liệu/lookup dùng chung cho các form SimbaERP trong Portal, ưu tiên nguồn dữ liệu từ Stored Procedure wrapper theo `simba-docs`.

Các component trong phạm vi đầu tiên:

| Component | Mục đích | Tình trạng cần audit |
|---|---|---|
| `input-khachhang` / `InputKhachhang` | Chọn khách hàng, nhà cung cấp, nhân viên theo mode | Đang có code, cần kiểm tra SP-first |
| `input-taikhoan` / `InputTaikhoan` | Chọn tài khoản GL | Đang có code, cần kiểm tra SP-first |
| `input-indmvt` / `InputIndmvt` | Chọn vật tư | Đang có code, cần bỏ Eloquent trực tiếp nếu có SP |
| `input-indmkho` / `InputIndmkho` | Chọn kho | Đang có code, đã có wrapper `AsINGetDMKHO` |
| `input-indmnhvt` / `InputIndmnhvt` | Chọn nhóm vật tư | Đang có code, đã có wrapper `AsINGetDMNHVT` |
| `input-donvi` / `InputDonVi` | Chọn đơn vị/công ty/đơn vị tính theo context | Đang có code, cần xác minh đúng dictionary/table/SP trước khi sửa |

## Nguồn tài liệu phải đọc trước khi code

- `docs/tasks/README.md`: quy định Data Access Map và ưu tiên Stored Procedure.
- `docs/SIMBA-DOCS.md`: quy trình tra nguồn Simba.
- `simba-docs/data/sysDictionaryInfo.md`: xác định code name, table, form, fields.
- `simba-docs/data/sysDAOInfo.md`: xác định GET/INS/UPD/DEL SP chính thức nếu có.
- `simba-docs/reference/CODE_REFERENCE.md`: đối chiếu các SP wrapper đã biết.
- `simba-docs/decompiled/asia/{DLL}.dll/README.md`: đối chiếu form gốc và lookup behavior khi cần.
- `docs/tasks/030-ca-voucher-bao-co-uy-nhiem-chi.md`: ví dụ đang dùng `input-khachhang`, `input-taikhoan`.
- `docs/tasks/CA4-PHIEU-BAONO-SPEC.md`: ví dụ yêu cầu re-use component.
- `docs/tasks/114-IN-danhmuc-vattu.md`: nguồn tham chiếu vật tư và wrapper `InDmVt::getAsINGetDMVT` / `AsINGetDMVT`.
- `docs/reports/simba-in-dict-dmnhvt-flow.md`: nguồn tham chiếu nhóm vật tư và wrapper `AsINGetDMNHVT`.

## Data Access Map

Mọi thao tác hiển thị danh sách, search, lookup, validate selected value trong các input component phải ưu tiên Stored Procedure wrapper. Eloquent/model chỉ dùng khi đã tra `simba-docs` nhưng chưa có SP phù hợp, và phải ghi rõ nguồn tra cứu + lý do fallback ngay trong code hoặc tài liệu task liên quan.

| UI/data action | Code name | Simba table | Source | GET SP/wrapper ưu tiên | CRUD SP liên quan | Eloquent/model fallback |
|---|---|---|---|---|---|---|
| Lookup khách hàng | `MA_KH` | `ARDMKH` | `sysDictionaryInfo` + `sysDAOInfo` | `asARGetDMKH` / `StoredProcedures\AsARGetDMKH` | `asARInsDMKH`, `asARUpdDMKH`, `asARDelDMKH` | Chỉ sau khi tra nguồn và ghi lý do |
| Lookup nhà cung cấp | `MA_NCC` | `ARDMKH` | `sysDictionaryInfo` + `sysDAOInfo` | `asARGetDMKH` / `StoredProcedures\AsARGetDMKH` với mode/cờ NCC | `asARInsDMKH`, `asARUpdDMKH`, `asARDelDMKH` | Chỉ sau khi tra nguồn và ghi lý do |
| Lookup tài khoản | `TK` / `MA_TK` | `GLDMTK` | `sysDictionaryInfo` + `sysDAOInfo` + `CODE_REFERENCE` | `asGLGetDMTK` / `StoredProcedures\AsGLGetDMTK` | `asGLInsDMTK`, `asGLUpdDMTK`, `asGLDelDMTK` | Chỉ sau khi tra nguồn và ghi lý do |
| Lookup kho | `MA_KHO` | `INDMKHO` | `sysDictionaryInfo` + `sysDAOInfo` | `asINGetDMKHO` / `StoredProcedures\AsINGetDMKHO` | `asINInsDMKHO`, `asINUpdDMKHO`, `asINDelDMKHO` | Chỉ sau khi tra nguồn và ghi lý do |
| Lookup vật tư | `MA_VT` | `INDMVT` | `sysDictionaryInfo` + `sysDAOInfo` | `asINGetDMVT` / `StoredProcedures\AsINGetDMVT` | `asINInsDMVT`, `asINUpdDMVT`, `asINDelDMVT` | Chỉ sau khi tra nguồn và ghi lý do |
| Lookup nhóm vật tư | `MA_NHVT` | `INDMNHVT` | `sysDictionaryInfo` + wrapper hiện có | `asINGetDMNHVT` / `StoredProcedures\AsINGetDMNHVT` | Phải đối chiếu thêm `simba-docs` trước khi mở rộng thêm/sửa/xóa | Chỉ sau khi tra nguồn và ghi lý do |
| Lookup đơn vị | `MA_DV` hoặc code theo context | `SICompany` hoặc bảng theo context | `sysDictionaryInfo` | Chưa chốt; phải tra `sysDAOInfo`, DLL và code hiện hữu trước khi sửa | Chưa chốt; không tự đặt tên SP/table | Chỉ sau khi tra nguồn và ghi lý do |

## Phạm vi kỹ thuật

### Audit hiện trạng

- Tìm toàn bộ component trong `diepxuan/laravel-catalog/src/Http/Livewire/Component/`.
- Ghi rõ component nào đang dùng Stored Procedure wrapper, component nào còn dùng Eloquent/query trực tiếp.
- Kiểm tra view Blade tương ứng và các nơi đang gọi component trong `diepxuan/` và `docs/tasks/`.
- Kiểm tra props đang có: `mode`, `wire:model`, selected value, label hiển thị, placeholder, debounce/search.

### Chuẩn hóa behavior

- Component phải hỗ trợ search theo mã và tên nếu SP trả đủ field.
- Component phải validate selected value qua cùng nguồn SP/wrapper, không validate bằng query khác khi đã có SP.
- Component phải giữ contract `wire:model` hiện tại để không phá các form đang dùng.
- Component phải có empty state, loading state và clear value nếu UI hiện tại hỗ trợ.
- Component không được tự tạo tên bảng, tên field, tên SP mới.

### SP-first implementation

- `InputIndmkho` dùng trực tiếp `StoredProcedures\AsINGetDMKHO`, không qua hàm wrapper trung gian tự đặt như `getAsINGetDMKHO`.
- `InputIndmvt` dùng trực tiếp `StoredProcedures\AsINGetDMVT` cho danh sách/lookup vật tư.
- `InputIndmnhvt` dùng trực tiếp `StoredProcedures\AsINGetDMNHVT` cho danh sách/lookup nhóm vật tư.
- `InputKhachhang` dùng `StoredProcedures\AsARGetDMKH` và map mode khách hàng/nhà cung cấp/nhân viên theo nguồn `ARDMKH`.
- `InputTaikhoan` dùng `\CatalogService::glDmTks()`; `CatalogService::glDmTks()` là điểm tích hợp `StoredProcedures\AsGLGetDMTK` theo code `TK` / `MA_TK` để các nơi dùng chung không gọi SP lặp lại.
- `InputDonVi` chưa được đổi khi chưa xác minh đúng dictionary/table/SP theo context sử dụng.

## Không thuộc phạm vi

- Không tạo bảng mới.
- Không ALTER/CREATE/INSERT SQL.
- Không đổi route/menu nghiệp vụ.
- Không rewrite toàn bộ form gọi component nếu contract hiện tại vẫn dùng được.
- Không mở rộng thêm/sửa/xóa danh mục từ input component; input component chỉ lookup/chọn dữ liệu. CRUD danh mục thuộc task nghiệp vụ riêng.

## Checklist triển khai

| # | Công việc | Trạng thái |
|---|---|---|
| 1 | Audit toàn bộ `Input*` component hiện có | TODO |
| 2 | Lập Data Access Map thực tế từ `simba-docs` cho từng component | TODO |
| 3 | Thay Eloquent/query trực tiếp bằng SP wrapper khi có SP phù hợp | TODO |
| 4 | Giữ tương thích `wire:model`, props, event, view đang dùng | TODO |
| 5 | Bổ sung validate selected value theo cùng SP/wrapper | TODO |
| 6 | Kiểm tra các màn hình đang dùng component, tối thiểu CA4 và các form IN liên quan | TODO |
| 7 | Chạy `php -l` cho file PHP sửa đổi | TODO |
| 8 | Chạy test/lint liên quan hoặc ghi rõ lý do chưa chạy được | TODO |
| 9 | Cập nhật task docs/PR body với bằng chứng SP wrapper đã dùng | TODO |

## Tiêu chí hoàn thành

- Không còn component lookup dùng Eloquent trực tiếp khi `simba-docs` đã có GET SP/wrapper phù hợp.
- Mỗi component có mapping rõ: code name, table, source, GET SP/wrapper, fallback nếu có.
- Các form đang dùng `input-khachhang`, `input-taikhoan`, `input-indmvt`, `input-indmkho`, `input-indmnhvt`, `input-donvi` không bị đổi contract ngoài ý muốn.
- Không có tên bảng/SP/field tự đặt ngoài `simba-docs`.
- Báo cáo cuối phải liệt kê file sửa, SP wrapper dùng, kiểm chứng đã chạy và phần còn chưa xác minh nếu có.

## Audit Status

- **Status:** IN_PROGRESS — audit/refactor input components, cap nhat 2026-07-09
- **Nguoi audit:** Bột (Portal Agent)

### Cap nhat 2026-07-09 — InputTaikhoan/GLDMTK

- `CatalogService::glDmTks()` da duoc chuyen sang SP-first qua `StoredProcedures\AsGLGetDMTK`, cache theo `ma_cty|pTk|pStruct` trong lifecycle service.
- `InputTaikhoan` khong goi `AsGLGetDMTK` truc tiep nua; component dung `\CatalogService::glDmTks()` (tra Collection) de tai su dung cache/service chung.
- `Phieubaono.php` da bo import `GlDmTk`, bo property `$glDmTks`, bo load datalist cu vi `phieubaono.blade.php` da dung `input-taikhoan` cho TK Co va TK No.
- `Gl\Taikhoan.php` giu nguyen dung `GlDmTk::all()` theo chi dao cua Sep.
- `php -l` pass cho `CatalogService.php`, `InputTaikhoan.php`, `Phieubaono.php`, `Gl\Taikhoan.php`.
