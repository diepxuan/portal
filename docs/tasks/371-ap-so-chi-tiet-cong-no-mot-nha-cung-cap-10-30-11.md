# Task 371: AP/ARBCCN01 — Sổ chi tiết công nợ một nhà cung cấp (menu 10.30.11)

## Nhóm
AP (Accounts Payable — Công nợ phải trả) / Module PO

## Mục tiêu

Chuyển đổi chức năng **Sổ chi tiết công nợ một nhà cung cấp** (không số lượng) từ Simba .NET `ARRptBCCN01.dll` sang Livewire report mới, dùng route source Simba và stored procedure `asARRptBCCN01`.

## Trạng thái hiện tại

- **Status:** PENDING
- **Ngày tạo:** 2026-07-23
- **Người tạo:** Bot (Portal Agent)
- **Canonical URL (kỳ vọng):** `/simba/po/rpt/arrptbccn01103011` (slug compact theo task 358)
- **Source route:** `/_simba-source/po/rpt/arrptbccn01103011`
- **DLL:** ARRptBCCN01.dll (form dùng chung cho AR và AP, menuid phân biệt)
- **Route name:** `po.rpt.arrptbccn01103011`

## Source of truth từ Simba

### sysMenu

| MenuID | Module | Tiêu đề | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `10.30.11` | PO | Sổ chi tiết công nợ một nhà cung cấp | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |
| `10.30.23` | PO | Sổ chi tiết công nợ một nhà cung cấp — có số lượng | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |

Form gốc `frmARRptBCCN01` dùng chung cho cả AR và AP; phân biệt bằng menuid.

### sysReportInfo

| MenuID | Mẫu | SP | Report |
|--------|-----|----|--------|
| `10.30.11` | `01` | `asARRptBCCN01` | `ARBCCN011.rpt` |
| `10.30.23` | `02` | `asARRptBCCN01SL` | `ARBCCN012.rpt` |

### Menu liên quan không mở trong task này

| MenuID | Tiêu đề | Active | Lý do |
|--------|---------|--------|-------|
| `10.30.23` | Sổ chi tiết công nợ một nhà cung cấp — có số lượng | `1` | Task 359 (`359-ap-so-chi-tiet-cong-no-mot-nha-cung-cap-10-30-23.md`) ✅ DONE |
| `06.30.14` | SO - Sổ chi tiết công nợ một khách hàng | `1` | Task 008 ✅ DONE |
| `06.30.38` | SO - Sổ chi tiết công nợ một khách hàng — có số lượng | `1` | Task 370 ✅ DONE |

## DLL audit

File: `simba-docs/decompiled/asia/ARRptBCCN01.dll/AsiaErp.UserInterface/frmARRptBCCN01.cs`

Form dùng chung với task 008 (AR view), task 359 (AP SL), task 370 (SO SL). Tham số `LoadData()` giống nhau, nhưng nguồn dữ liệu AR/AP/SO tuỳ theo menuid và connection.

### Controls chính (theo DLL gốc)

| Control | Portal field | Mô tả |
|---------|--------------|-------|
| `txtTk` | `pTk` | Mã tài khoản (tk_cn=1) |
| `txtMa_Kh` | `pMa_kh` | Mã nhà cung cấp trong ngữ cảnh AP; DLL dùng chung tên control/param `ma_kh` |
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
| Component | `diepxuan/laravel-catalog/src/Http/Livewire/Po/Rpt/Arrptbccn01.php` | Form filter, submit SP, grid kết quả, select row, export CSV |
| View | `diepxuan/laravel-catalog/resources/views/po/rpt/arrptbccn01.blade.php` | UI report theo `x-nav-tabs`, reuse `input-taikhoan` và `input-khachhang mode="nhacungcap"` |
| Route | `diepxuan/laravel-catalog/routes/web.php` | `po.rpt.arrptbccn01103011` → `Po\\Rpt\\Arrptbccn01` |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsARRptBCCN01.php` | Wrapper gọi `asARRptBCCN01` với 6 tham số chính xác từ DLL (**đã có sẵn từ task 008**) |

## Data Access Map

| UI/data action | Code name | Simba table | Source | GET SP/wrapper |
|---|---|---|---|---|
| Lookup nhà cung cấp | `ma_kh` trong DLL/SP, hiển thị là NCC ở AP | `ARDMKH` (mode NCC) | `sysDictionaryInfo` + `sysDAOInfo` | `asARGetDMKH` (mode AP) — đã có trong `InputKhachhang` |
| Lookup tài khoản | `MA_TK` | `GLDMTK` | `sysDictionaryInfo` + `sysDAOInfo` | `asGLGetDMTK` qua `CatalogService::glDmTks()` |
| Lọc báo cáo công nợ NCC | `ARRptBCCN01` | `AP4CT`, `DMKH`, `DMTK` | `sysReportInfo` row `10.30.11` | `asARRptBCCN01` / `StoredProcedures\\AsARRptBCCN01` |

## Checklist triển khai

### Phase framework (theo task 358)

- [x] `SimbaMenuRouteMetadata::routeNameFor()` đổi hậu tố slug trùng tên thành `menuIdSuffix()` (nối ký tự alphanumeric của menuid, không thêm `-`)
- [x] Thêm helper `menuIdSuffix()` trong `SimbaMenuRouteMetadata`
- [x] Thêm unit test `testRouteNameSuffixAppendsCompactMenuId` pin behavior
- [x] `php -l` pass cho `SimbaMenuRouteMetadata.php` và `SimbaMenuRouteMetadataTest.php`
- [x] phpunit `SimbaMenuRouteMetadataTest` 9 tests / 20 assertions pass

### Phase AP report (task này)

- [ ] Đọc source: `sysMenu`, `sysReportInfo`, `ARRptBCCN01.dll`, đối chiếu SP class `AsARRptBCCN01`
- [ ] Xác nhận wrapper `AsARRptBCCN01` (`diepxuan/laravel-simba/src/StoredProcedures/AsARRptBCCN01.php`) đã có sẵn, dùng 6 tham số theo DLL
- [ ] Tạo Livewire `Po\\Rpt\\Arrptbccn01` với filter + grid + export, tham khảo `So\\Rpt\\Arrptbccn01` (task 008) + `Po\\Rpt\\Arrptbccn01Sl` (task 359)
  - `pTk` default `'331'`
  - `pMa_kh` bind với `input-khachhang mode="nhacungcap"`
  - `presentationColumns()` chỉ có document/dien_giai/PS Nợ/PS Có (không SL columns)
  - Dùng SP `AsARRptBCCN01`
- [ ] Tạo view `po/rpt/arrptbccn01.blade.php` theo `x-nav-tabs`, tham khảo `so/rpt/arrptbccn01.blade.php` (task 008)
- [ ] Mở source route `_simba-source/po/rpt/arrptbccn01103011` trong `diepxuan/laravel-catalog/routes/web.php`
- [ ] Thêm route vào `SourceRouteCoverageTest`
- [ ] Dịch token tổng hợp Simba trong kết quả report: `#ARRptBCCN_DDK`, `#ARRptBCCN_TPS`, `#ARRptBCCN_DCK`
- [ ] Chuyển field `pTieu_de` sang display-only, không cho sửa bằng textbox
- [ ] Chuẩn hóa cột kết quả: gộp `ngay_ct`/`so_ct`/`stt_rec`, format ngày `dd/mm/YYYY`, ẩn cột raw thừa, ưu tiên cột tiền VND hoặc ngoại tệ theo `pMa_nt`
- [ ] `php -l` + phpunit liên quan
- [ ] Kiểm tra local URL trên `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103011`

## Không thuộc phạm vi

- Không tạo bảng/SP/field mới.
- Không sửa `SimbaMenuRouteMetadata` (đã sửa trong task 358).
- Không mở task con cho `10.30.23` (SL — task 359 đã DONE) hoặc `06.30.x` (SO) trong task này.
- SP wrapper `AsARRptBCCN01` **đã có sẵn** từ task 008 — không cần tạo mới.

## Tiêu chí hoàn thành

- URL `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103011` trả về report shell theo `SimbaPage` (metadata ít nhất: menuid `10.30.11`, report `ARBCCN011.rpt`, command `AsiaErp.UserInterface.frmARRptBCCN01`).
- Component `Po\\Rpt\\Arrptbccn01` render đúng SP `asARRptBCCN01` với filter TK/NCC/kỳ báo cáo.
- Tests pass, lint pass, route coverage test pass.

## Ghi chú kỹ thuật

- Slug sử dụng theo task 358: `arrptbccn01103011` (compact, không có `-`).
- SP wrapper `AsARRptBCCN01.php` **đã có sẵn** từ task 008 — không cần tạo mới.
- Wrapper không dùng `pSysMsg*`; wrapper normalize về 6 tham số chính xác theo DLL. `pMa_cty`, `pNgay1`, `pNgay2`, `pTk`, `pMa_kh`, `pMa_nt` chỉ là alias UI nội bộ để tương thích Livewire property hiện có.
- Các token ngôn ngữ Simba trong cột diễn giải được dịch khi hiển thị/export: `#ARRptBCCN_DDK` → `Dư đầu kỳ`, `#ARRptBCCN_TPS` → `Tổng phát sinh trong kỳ`, `#ARRptBCCN_DCK` → `Dư cuối kỳ`.
- `pTieu_de` giữ là property nội bộ của component để hiển thị tiêu đề report; view render thành text readonly, không bind `wire:model`.
- Bảng kết quả không render raw toàn bộ column SP. View chỉ render các nhóm cột: Chứng từ, Diễn giải, PS Nợ, PS Có. `stt_rec` được gộp vào cột Chứng từ với style nhỏ/mờ. Khi `pMa_nt` trống/VND thì dùng cột VND (`ps_no`, `ps_co`); khi chọn ngoại tệ thì ưu tiên cột `*_nt`.
- Format số trong CSV/UI: `ps_no`/`ps_co` làm tròn theo `pMa_nt` — VND (hoặc trống) thì 0 chữ số lẻ, ngoại tệ (USD/EUR/...) thì 4 chữ số lẻ.
- Phân biệt dòng chứng từ/dòng tổng hợp: dòng tổng hợp (token `#ARRptBCCN_DDK`/`#ARRptBCCN_TPS`/`#ARRptBCCN_DCK`) giữ style mặc định; dòng chứng từ thường giữ style `text-gray-800`.
- **Tham khảo:**
  - `So\\Rpt\\Arrptbccn01` (task 008) — pattern component non-SL, view `so/rpt/arrptbccn01.blade.php`
  - `Po\\Rpt\\Arrptbccn01Sl` (task 359) — pattern component AP SL, view `po/rpt/arrptbccn01sl.blade.php`
