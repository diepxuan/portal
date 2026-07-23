# Task 370: SO/ARBCCN01SL — Sổ chi tiết công nợ một khách hàng - có số lượng (menu 06.30.38)

## Nhóm: SO (Sales Order — Bán hàng)

## Mục tiêu

Chuyển đổi chức năng **Sổ chi tiết công nợ một khách hàng — có số lượng** từ Simba .NET `ARRptBCCN01.dll` sang Livewire report mới, dùng route source Simba và stored procedure `asARRptBCCN01SL`.

## Trạng thái hiện tại

- **Status:** ❌ PENDING — chưa implement
- **Ngày tạo:** 2026-07-13
- **Người tạo:** Bot (Portal Agent)
- **Branch:** chưa tạo
- **Canonical URL (ký vọng):** `/simba/so/rpt/arrptbccn01063038` (slug sinh theo SimbaMenuRouteMetadata, hậu tố compact theo task 358)
- **Source route:** `/_simba-source/so/rpt/arrptbccn01063038`
- **DLL:** ARRptBCCN01.dll (form dùng chung cho AR và AP, menuid phân biệt)
- **Route name:** `so.rpt.arrptbccn01063038`

## Source of truth từ Simba

### sysMenu

| MenuID | Module | Tiêu đề | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `06.30.14` | SO | Sổ chi tiết công nợ một khách hàng | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |
| `06.30.38` | SO | Sổ chi tiết công nợ một khách hàng — có số lượng | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |

Form gốc `frmARRptBCCN01` dùng chung cho cả AR và AP; phân biệt bằng menuid.

### sysReportInfo

| MenuID | Mẫu | SP | Report |
|--------|-----|----|--------|
| `06.30.14` | `01` | `asARRptBCCN01` | `ARBCCN011.rpt` |
| `06.30.38` | `02` | `asARRptBCCN01SL` | `ARBCCN012.rpt` |

### Menu liên quan không mở trong task này

| MenuID | Tiêu đề | Active | Lý do |
|--------|---------|--------|-------|
| `06.30.14` | Sổ chi tiết công nợ một khách hàng | `1` | Task 008 (AR version, không SL) |
| `10.30.11` | Sổ chi tiết công nợ một nhà cung cấp | `1` | Task riêng (AP version) |
| `10.30.23` | Sổ chi tiết công nợ một nhà cung cấp — có số lượng | `1` | Task 359 (AP version SL, code mẫu) |

## DLL audit

File: `simba-docs/decompiled/asia/ARRptBCCN01.dll/AsiaErp.UserInterface/frmARRptBCCN01.cs`

Form dùng chung với task 008 (AR view) và task 359 (AP SL). Tham số `LoadData()` giống task 008, nhưng nguồn dữ liệu AR (SO module) thay vì AP.

### Controls chính (theo DLL gốc)

| Control | Portal field | Mô tả |
|---------|--------------|-------|
| `txtTk` | `pTk` | Mã tài khoản (tk_cn=1) |
| `txtMa_Kh` | `pMa_kh` | Mã khách hàng (AR context); DLL dùng chung tên control/param `ma_kh` |
| `txtNgay1` | `pNgay1` | Từ ngày |
| `txtNgay2` | `pNgay2` | Đến ngày |
| `cboKyBc` | `pKyBc` | Kỳ báo cáo |
| `cboMau_bc` | `pMa_mau` | Mẫu báo cáo (`02` cho SL) |
| `optVND` | `pVND` | Hiển thị VND |
| `optNt` | `pNgoai_te` | Hiển thị ngoại tệ |
| `dgvBC` | grid | Dữ liệu báo cáo |
| `btnIn` | `submit` | Nút in báo cáo |
| `btnXuat` | `exportExcel` | Nút xuất Excel |

### Thứ tự tham số `LoadData()` / `asARRptBCCN01SL`

Theo DLL decompile `frmARRptBCCN01.LoadData()`, form gọi SP bằng 6 tham số theo thứ tự:

| Thứ tự | Giá trị DLL | Portal/SP param |
|--------|-------------|-----------------|
| 1 | `CompanyInformations.CompanyID` | `ma_cty` |
| 2 | `txtNgay1.Value` | `Ngay1` |
| 3 | `txtNgay2.Value` | `Ngay2` |
| 4 | `txtTk.Text` | `Tk` |
| 5 | `txtMa_Kh.Text` | `ma_kh` |
| 6 | `txtMa_Nt.Text` | `ma_nt` |

Không giữ alias `pSysMsg*`; wrapper chỉ normalize về đúng 6 tham số SP trên.

## Portal mapping dự kiến

| Loại | File | Nội dung |
|------|------|----------|
| Component | `diepxuan/laravel-catalog/src/Http/Livewire/So/Rpt/Arrptbccn01Sl.php` | Form filter, submit SP, grid kết quả, select row, export CSV |
| View | `diepxuan/laravel-catalog/resources/views/so/rpt/arrptbccn01sl.blade.php` | UI report theo `x-nav-tabs`, reuse `input-taikhoan` và `input-khachhang mode="khachhang"` |
| Route | `diepxuan/laravel-catalog/routes/web.php` | `so.rpt.arrptbccn01063038` → `So\\Rpt\\Arrptbccn01Sl` |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsARRptBCCN01SL.php` | Wrapper gọi `asARRptBCCN01SL` với 6 tham số chính xác từ DLL |
| Matrix | `docs/project/simba-router-menu-matrix.md` | `06.30.38` → `so.rpt.bccn01sl` (slug cũ theo matrix; slug thực tế sẽ là `arrptbccn01063038` theo task 358) |

## Data Access Map

| UI/data action | Code name | Simba table | Source | GET SP/wrapper |
|---|---|---|---|---|
| Lookup khách hàng | `ma_kh` trong DLL/SP, hiển thị là KH ở SO | `ARDMKH` (mode KH) | `sysDictionaryInfo` + `sysDAOInfo` | `asARGetDMKH` (mode AR) — đã có trong `InputKhachhang` |
| Lookup tài khoản | `MA_TK` | `GLDMTK` | `sysDictionaryInfo` + `sysDAOInfo` | `asGLGetDMTK` qua `CatalogService::glDmTks()` |
| Lọc báo cáo công nợ KH có SL | `ARRptBCCN01SL` | `AR4CT`, `DMKH`, `DMTK` | `sysReportInfo` row `06.30.38` | `asARRptBCCN01SL` / `StoredProcedures\\AsARRptBCCN01SL` |

## Khác biệt với Task 008 (ARRptBCCN01, 06.30.14)

| Thuộc tính | Task 008 | Task 370 (nay) |
|------------|----------|----------------|
| MenuID | `06.30.14` | `06.30.38` |
| Tên menu | Sổ chi tiết công nợ một khách hàng | Sổ chi tiết công nợ một khách hàng — có số lượng |
| SP | `asARRptBCCN01` | `asARRptBCCN01SL` |
| Report | `ARBCCN011.rpt` | `ARBCCN012.rpt` |
| Có số lượng | Không | **Có** |
| Slug | `arrptbccn01` (không menuIdSuffix) | `arrptbccn01063038` (có menuIdSuffix `063038`) |

Các cột số lượng bổ sung: `so_luong`, `gia`, `tien` (so_luong * gia = tien).

## Checklist triển khai

### Phase framework (theo task 358) — đã hoàn thành ở task 358

- [x] `SimbaMenuRouteMetadata::routeNameFor()` đổi hậu tố slug trùng tên thành `menuIdSuffix()` (nối ký tự alphanumeric của menuid, không thêm `-`)
- [x] Thêm helper `menuIdSuffix()` trong `SimbaMenuRouteMetadata`
- [x] Thêm unit test `testRouteNameSuffixAppendsCompactMenuId` pin behavior
- [x] `php -l` pass cho `SimbaMenuRouteMetadata.php` và `SimbaMenuRouteMetadataTest.php`
- [x] phpunit `SimbaMenuRouteMetadataTest` 9 tests / 20 assertions pass

### Phase SO report (task này)

- [ ] Đọc source: `sysMenu`, `sysReportInfo`, `ARRptBCCN01.dll`, đối chiếu SP class `AsARRptBCCN01SL`
- [ ] Xác nhận wrapper `AsARRptBCCN01SL` dùng 6 tham số theo DLL: `ma_cty`, `Ngay1`, `Ngay2`, `Tk`, `ma_kh`, `ma_nt`
- [ ] Tạo Livewire `So\\Rpt\\Arrptbccn01Sl` với filter + grid + export
- [ ] Tạo view `so/rpt/arrptbccn01sl.blade.php` theo `x-nav-tabs`
- [ ] Mở source route `_simba-source/so/rpt/arrptbccn01063038` trong `diepxuan/laravel-catalog/routes/web.php`
- [ ] Thêm route vào `SourceRouteCoverageTest`
- [ ] Thêm unit test cho `AsARRptBCCN01SL::procedureParams()`
- [ ] Dịch token tổng hợp Simba trong kết quả report: `#ARRptBCCN_DDK`, `#ARRptBCCN_TPS`, `#ARRptBCCN_DCK`
- [ ] Chuyển field `pTieu_de` sang display-only, không cho sửa bằng textbox
- [ ] Chuẩn hóa cột kết quả: gộp `ngay_ct`/`so_ct`/`stt_rec`, format ngày `dd/mm/YYYY`, ẩn cột raw thừa, ưu tiên cột tiền VND hoặc ngoại tệ theo `pMa_nt`
- [ ] `php -l` + phpunit liên quan
- [ ] Kiểm tra local URL trên `http://portal.diepxuan.corp/simba/so/rpt/arrptbccn01063038`

## Không thuộc phạm vi

- Không tạo bảng/SP/field mới.
- Không sửa `SimbaMenuRouteMetadata` (đã sửa trong task 358).
- Không mở task con cho `06.30.14` (`so.rpt.arrptbccn01`) hoặc `10.30.x` (AP) trong task này.

## Tiêu chí hoàn thành

- URL `http://portal.diepxuan.corp/simba/so/rpt/arrptbccn01063038` trả về report shell theo `SimbaPage` (metadata ít nhất: menuid `06.30.38`, report `ARBCCN012.rpt`, command `AsiaErp.UserInterface.frmARRptBCCN01`).
- Component `So\\Rpt\\Arrptbccn01Sl` render đúng SP `asARRptBCCN01SL` với filter TK/KH/kỳ báo cáo.
- Các cột số lượng (`so_luong`, `gia`, `tien`) hiển thị đúng precision.
- Tests pass, lint pass, route coverage test pass.

## Ghi chú kỹ thuật

- Slug sử dụng theo task 358: `arrptbccn01063038` (compact, không có `-`).
- Matrix đang để slug `bccn01sl` nhưng chỉ tham khảo; slug thực tế trong route registry sẽ là `arrptbccn01063038`. Cần cập nhật matrix nếu Sếp đồng ý.
- Wrapper `AsARRptBCCN01SL.php` không dùng `pSysMsg*`; wrapper normalize về 6 tham số chính xác theo DLL. `pMa_cty`, `pNgay1`, `pNgay2`, `pTk`, `pMa_kh`, `pMa_nt` chỉ là alias UI nội bộ để tương thích Livewire property hiện có.
- Các token ngôn ngữ Simba trong cột diễn giải được dịch khi hiển thị/export: `#ARRptBCCN_DDK` → `Dư đầu kỳ`, `#ARRptBCCN_TPS` → `Tổng phát sinh trong kỳ`, `#ARRptBCCN_DCK` → `Dư cuối kỳ`.
- `pTieu_de` giữ là property nội bộ của component để hiển thị tiêu đề report; view render thành text readonly, không bind `wire:model`.
- Bảng kết quả không render raw toàn bộ column SP. View chỉ render các nhóm cột: Chứng từ, Diễn giải, Số lượng, Giá, Tiền, PS Nợ, PS Có. Thông tin vật tư (`ma_vt`, `ten_vt`, `dvt`) được gộp vào cột Diễn giải bằng dòng phụ nhỏ/mờ. `stt_rec` được gộp vào cột Chứng từ với style nhỏ/mờ. Khi `pMa_nt` trống/VND thì dùng cột VND (`gia`, `tien`, `ps_no`, `ps_co`); khi chọn ngoại tệ thì ưu tiên cột `*_nt`.
- Format số trong CSV/UI: `so_luong` luôn 4 chữ số thập phân; `gia`/`tien`/`ps_no`/`ps_co` làm tròn theo `pMa_nt` — VND (hoặc trống) thì 0 chữ số lẻ, ngoại tệ (USD/EUR/...) thì 4 chữ số lẻ để không mất độ chính xác khi lọc theo ngoại tệ.
- Phân biệt dòng chứng từ/dòng sản phẩm: dòng chi tiết vật tư (có `ma_vt` trong row) được lùi 1 tab bằng class `ps-4 text-gray-500` (Tailwind logical property, đồng bộ với navigation-menu); dòng tổng hợp (token `#ARRptBCCN_DDK`/`#ARRptBCCN_TPS`/`#ARRptBCCN_DCK`) giữ style mặc định (không in đậm); dòng chứng từ thường giữ style `text-gray-800`. CSV export prefix ký tự `\t` cho dòng sản phẩm để Excel giữ indent khi mở.

## Kế thừa code mẫu

Task này có thể tái sử dụng code từ:
- **Task 359** (`So/Rpt/Arrptbccn01Sl` ở PO/AP context): Cùng SP `AsARRptBCCN01SL`, chỉ khác ở module SO và lookup KH thay vì NCC.
- **Task 008** (`So/Rpt/Arrptbccn01`): Cùng form/component structure, cùng module SO, chỉ thêm cột số lượng và đổi SP thành `AsARRptBCCN01SL`.

## Audit Status

- **Status:** ❌ PENDING — chưa implement
- **Ngày audit:** 2026-07-23
- **Kết quả:** PENDING — cần implement dựa trên code mẫu task 359 và task 008
- **Route:** `/simba/so/rpt/arrptbccn01063038`
- **Website verification URL:** `http://portal.diepxuan.corp/simba/so/rpt/arrptbccn01063038`
- **Menu:** `06.30.38`
- **SP:** `asARRptBCCN01SL`
- **Report:** `ARBCCN012.rpt`
- **Template tham chiếu:** `diepxuan/laravel-catalog/src/Http/Livewire/Po/Rpt/Arrptbccn01Sl.php` (task 359) + `resources/views/po/rpt/arrptbccn01sl.blade.php`
