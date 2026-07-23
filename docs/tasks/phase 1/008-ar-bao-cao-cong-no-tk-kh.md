# Task 008: AR/ARBCCN01 — Sổ chi tiết công nợ một khách hàng (menu 06.30.14)

## Nhóm: AR (Accounts Receivable — Công nợ phải thu) / Module SO

## Mục tiêu

Chuyển đổi chức năng **Sổ chi tiết công nợ một khách hàng** từ Simba .NET `ARRptBCCN01.dll` sang Livewire report mới, dùng route source Simba va stored procedure `asARRptBCCN01`.

## Trạng thái hiện tại

- **Status:** DONE — merged PR phase 1
- **Ngày tạo:** 2026-05-10
- **Ghi chú:** Đây là task gốc đầu tiên của dòng `ARRptBCCN01`, được implement trước khi có task 358 (slug convention) và task 359 (AP version).
- **Nguồn:** simba-docs/decompiled
- **Canonical URL (hiện tại):** `/simba/so/rpt/arrptbccn01`
- **Source route:** `/_simba-source/so/rpt/arrptbccn01`
- **DLL:** ARRptBCCN01.dll, ARRptBCCN01a.dll
- **Route name:** `so.rpt.arrptbccn01`

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
| `06.30.38` | Sổ chi tiết công nợ một khách hàng — có số lượng | `1` | Task 370 (file `370-so-chi-tiet-cong-no-khach-hang-co-so-luong-06-30-38.md`, đổi ID từ 361 ở PR #261 vì trùng SMUserInfo) |
| `10.30.11` | Sổ chi tiết công nợ một nhà cung cấp | `1` | Task riêng (AP version) |
| `10.30.23` | Sổ chi tiết công nợ một nhà cung cấp — có số lượng | `1` | Task 359 (AP version SL, `359-ap-so-chi-tiet-cong-no-mot-nha-cung-cap-10-30-23.md`) |

## DLL audit

File: `simba-docs/decompiled/asia/ARRptBCCN01.dll/AsiaErp.UserInterface/frmARRptBCCN01.cs`

Form dùng chung cho task 008 (AR view), task 359 (AP SL), và task 370 (SO SL, đổi ID từ 361 ở PR #261). Tham số `LoadData()` giống nhau, nhưng nguồn dữ liệu AR/AP/SO tuỳ theo menuid và connection.

### Controls chính (theo DLL gốc)

| Control | Portal field | Mô tả |
|---------|--------------|-------|
| `txtTk` | `pTk` | Mã tài khoản (tk_cn=1) |
| `txtMa_Kh` | `pMa_kh` | Mã khách hàng (AR) hoặc nhà cung cấp (AP); DLL dùng chung tên control/param `ma_kh` |
| `txtNgay1` | `pNgay1` | Từ ngày |
| `txtNgay2` | `pNgay2` | Đến ngày |
| `cboKyBc` | `pKyBc` | Kỳ báo cáo |
| `cboMau_bc` | `pMa_mau` | Mẫu báo cáo (`01` cho BCCN01, `02` cho SL) |
| `optVND` | `pVND` | Hiển thị VND |
| `optNt` | `pNgoai_te` | Hiển thị ngoại tệ |
| `dgvBC` | grid | Dữ liệu báo cáo |
| `btnIn` | `submit` | Nút in báo cáo |
| `btnXuat` | `exportExcel` | Nút xuất Excel |

### Thứ tự tham số `LoadData()` / `asARRptBCCN01`

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
| Component | `diepxuan/laravel-catalog/src/Http/Livewire/So/Rpt/Arrptbccn01.php` | Form filter, submit SP, grid kết quả, select row, export CSV |
| View | `diepxuan/laravel-catalog/resources/views/so/rpt/arrptbccn01.blade.php` | UI report theo `x-nav-tabs`, reuse `input-taikhoan` và `input-khachhang mode="khachhang"` |
| Route | `diepxuan/laravel-catalog/routes/web.php` | `so.rpt.arrptbccn01` → `So\\Rpt\\Arrptbccn01` |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsARRptBCCN01.php` | Wrapper gọi `asARRptBCCN01` với 6 tham số chính xác từ DLL |

## Data Access Map

| UI/data action | Code name | Simba table | Source | GET SP/wrapper |
|---|---|---|---|---|
| Lookup khách hàng | `ma_kh` trong DLL/SP, hiển thị là KH ở AR | `ARDMKH` (mode KH) | `sysDictionaryInfo` + `sysDAOInfo` | `asARGetDMKH` (mode AR) — đã có trong `InputKhachhang` |
| Lookup tài khoản | `MA_TK` | `GLDMTK` | `sysDictionaryInfo` + `sysDAOInfo` | `asGLGetDMTK` qua `CatalogService::glDmTks()` |
| Lọc báo cáo công nợ KH | `ARRptBCCN01` | `AR4CT`, `DMKH`, `DMTK` | `sysReportInfo` row `06.30.14` | `asARRptBCCN01` / `StoredProcedures\\AsARRptBCCN01` |

## Checklist triển khai

### Phase framework (theo task 358)

- [x] `SimbaMenuRouteMetadata::routeNameFor()` đổi hậu tố slug trùng tên thành `menuIdSuffix()` (nối ký tự alphanumeric của menuid, không thêm `-`)
- [x] Thêm helper `menuIdSuffix()` trong `SimbaMenuRouteMetadata`
- [x] Thêm unit test `testRouteNameSuffixAppendsCompactMenuId` pin behavior
- [x] `php -l` pass cho `SimbaMenuRouteMetadata.php` và `SimbaMenuRouteMetadataTest.php`
- [x] phpunit `SimbaMenuRouteMetadataTest` 9 tests / 20 assertions pass

### Phase AR report (task này)

- [x] Đọc source: `sysMenu`, `sysReportInfo`, `ARRptBCCN01.dll`, đối chiếu SP class `AsARRptBCCN01`
- [x] Xác nhận wrapper `AsARRptBCCN01` dùng 6 tham số theo DLL: `ma_cty`, `Ngay1`, `Ngay2`, `Tk`, `ma_kh`, `ma_nt`
- [x] Tạo Livewire `So\\Rpt\\Arrptbccn01` với filter + grid + export
- [x] Tạo view `so/rpt/arrptbccn01.blade.php` theo `x-nav-tabs`
- [x] Mở source route `_simba-source/so/rpt/arrptbccn01` trong `diepxuan/laravel-catalog/routes/web.php`
- [x] Thêm route vào `SourceRouteCoverageTest`
- [x] Thêm unit test cho `AsARRptBCCN01::procedureParams()`
- [x] Dịch token tổng hợp Simba trong kết quả report: `#ARRptBCCN_DDK`, `#ARRptBCCN_TPS`, `#ARRptBCCN_DCK`
- [x] Chuyển field `pTieu_de` sang display-only, không cho sửa bằng textbox
- [x] Chuẩn hóa cột kết quả: gộp `ngay_ct`/`so_ct`/`stt_rec`, format ngày `dd/mm/YYYY`, ẩn cột raw thừa, ưu tiên cột tiền VND hoặc ngoại tệ theo `pMa_nt`
- [x] `php -l` + phpunit liên quan
- [x] Kiểm tra local URL trên `http://portal.diepxuan.corp/simba/so/rpt/arrptbccn01`

## Không thuộc phạm vi

- Không tạo bảng/SP/field mới.
- Không sửa `SimbaMenuRouteMetadata` (đã sửa trong task 358).
- Không mở task con cho `06.30.38` (`so.rpt.arrptbccn01sl`) hoặc `10.30.x` (AP) trong task này.

## Tiêu chí hoàn thành

- URL `http://portal.diepxuan.corp/simba/so/rpt/arrptbccn01` trả về report shell theo `SimbaPage` (metadata ít nhất: menuid `06.30.14`, report `ARBCCN011.rpt`, command `AsiaErp.UserInterface.frmARRptBCCN01`).
- Component `So\\Rpt\\Arrptbccn01` render đúng SP `asARRptBCCN01` với filter TK/KH/kỳ báo cáo.
- Tests pass, lint pass, route coverage test pass.

## Ghi chú kỹ thuật

- Slug sử dụng theo task 358: `arrptbccn01` (hiện tại không có menuIdSuffix, giữ tên cũ).
- Wrapper `AsARRptBCCN01.php` không dùng `pSysMsg*`; wrapper normalize về 6 tham số chính xác theo DLL. `pMa_cty`, `pNgay1`, `pNgay2`, `pTk`, `pMa_kh`, `pMa_nt` chỉ là alias UI nội bộ để tương thích Livewire property hiện có.
- Các token ngôn ngữ Simba trong cột diễn giải được dịch khi hiển thị/export: `#ARRptBCCN_DDK` → `Dư đầu kỳ`, `#ARRptBCCN_TPS` → `Tổng phát sinh trong kỳ`, `#ARRptBCCN_DCK` → `Dư cuối kỳ`.
- `pTieu_de` giữ là property nội bộ của component để hiển thị tiêu đề report; view render thành text readonly, không bind `wire:model`.
- Bảng kết quả không render raw toàn bộ column SP. View chỉ render các nhóm cột: Chứng từ, Diễn giải, PS Nợ, PS Có. Thông tin vật tư (`ma_vt`, `ten_vt`, `dvt`) được gộp vào cột Diễn giải bằng dòng phụ nhỏ/mờ. `stt_rec` được gộp vào cột Chứng từ với style nhỏ/mờ. Khi `pMa_nt` trống/VND thì dùng cột VND (`ps_no`, `ps_co`); khi chọn ngoại tệ thì ưu tiên cột `*_nt`.
- Format số trong CSV/UI: `ps_no`/`ps_co` làm tròn theo `pMa_nt` — VND (hoặc trống) thì 0 chữ số lẻ, ngoại tệ (USD/EUR/...) thì 4 chữ số lẻ để không mất độ chính xác khi lọc theo ngoại tệ.
- Phân biệt dòng chứng từ/dòng tổng hợp: dòng tổng hợp (token `#ARRptBCCN_DDK`/`#ARRptBCCN_TPS`/`#ARRptBCCN_DCK`) giữ style mặc định (không in đậm); dòng chứng từ thường giữ style `text-gray-800`.

## Audit Status
- **Status:** DONE — merged PR phase 1
- **Ngày audit:** 2026-07-23
- **Người tạo:** Bot (Portal Agent)
- **Kiểm chứng:** wrapper unit test pass; route coverage pass; URL local `portal.diepxuan.corp` trả về 200 với metadata menuid `06.30.14`, `spname=asARRptBCCN01`, `rptname=ARBCCN011.rpt`, component `So\\Rpt\\Arrptbccn01`.
