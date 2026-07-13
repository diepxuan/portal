# Task 359: AP - Sổ chi tiết công nợ một nhà cung cấp (menu 10.30.23)

## Nhom
AP (Accounts Payable - Cong no phai tra)

## Muc tieu
Chuyen doi chuc nang **Sổ chi tiết công nợ một nhà cung cấp - có số lượng** tu Simba .NET `ARRptBCCN01.dll` sang Livewire report moi, dung route source Simba va stored procedure that `asARRptBCCN01SL`.

## Trang thai hien tai

- **Status:** PENDING - moi tao, chua implement
- **Ngay tao:** 2026-07-13
- **Nguoi tao:** Bot (Portal Agent)
- **Branch:** chua tao
- **Canonical URL (ky vong):** `/simba/po/rpt/arrptbccn01103023` (slug sinh theo SimbaMenuRouteMetadata, hau to compact theo task 358)
- **Source route:** chua mo
- **DLL:** ARRptBCCN01.dll (form dung chung cho AR va AP, menuid phan biet)
- **Route name:** `po.rpt.arrptbccn01103023`

## Source of truth tu Simba

### sysMenu

| MenuID | Module | Tieu de | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `10.30.11` | PO | So chi tiet cong no mot nha cung cap | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |
| `10.30.23` | PO | So chi tiet cong no mot nha cung cap - co so luong | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |

Form goc `frmARRptBCCN01` dung chung cho ca AR va AP; phan biet bang menuid.

### sysReportInfo

| MenuID | Mau | SP | Report |
|--------|-----|----|--------|
| `10.30.11` | `01` | `asARRptBCCN01` | `ARBCCN011.rpt` |
| `10.30.23` | `02` | `asARRptBCCN01SL` | `ARBCCN012.rpt` |

### Menu lien quan khong mo trong task nay

| MenuID | Tieu de | Active | Ly do |
|--------|---------|--------|-------|
| `10.30.11` | So chi tiet cong no mot nha cung cap | `1` | Tao task rieng neu Sếp yeu cau (matrix dang de slug `ap.rpt.bccn01`) |
| `10.30.14` | So chi tiet cong no nhieu nha cung cap | `1` | Tao task rieng khac neu Sếp yeu cau |

## DLL audit

File: `simba-docs/decompiled/asia/ARRptBCCN01.dll/AsiaErp.UserInterface/frmARRptBCCN01.cs`

Form dung chung voi task 008 (AR view). Tham so `LoadData()` giong task 008, nhung nguon du lieu AP thay vi AR (bang AR4CT/AP4CT tuy theo menuid va connection).

### Controls chinh (gia dinh theo DLL goc)

| Control | Portal field | Mo ta |
|---------|--------------|-------|
| `txtMa_Tk` | `pTk` | Ma tai khoan (tk_cn=1) |
| `txtMa_Ncc` | `pMa_ncc` | Ma nha cung cap |
| `txtNgay1` | `pNgay1` | Tu ngay |
| `txtNgay2` | `pNgay2` | Den ngay |
| `cboKyBc` | `pKyBc` | Ky bao cao |
| `cboMau_bc` | `pMa_mau` | Mau bao cao (`02` cho SL) |
| `optVND` | `pVND` | Hien thi VND |
| `optNt` | `pNgoai_te` | Hien thi ngoai te |
| `dgvBC` | grid | Du lieu bao cao |
| `btnIn` | `submit` | Nut in bao cao |
| `btnXuat` | `exportExcel` | Nut xuat Excel |

### Thu tu tham so `LoadData()`

Theo `asARRptBCCN01SL` (tham so `pSysMsg1/2/3` trong wrapper hien tai can bo sung mapping day du theo simba-docs/procedures/AR/procedures.md).

## Portal mapping du kien

| Loai | File | Noi dung |
|------|------|----------|
| Component | `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/ApReportIndex.php` (chua co, can tao) | Form filter, submit SP, grid ket qua, select row, export CSV |
| View | `diepxuan/laravel-catalog/resources/views/muahang/rpt/ap-report-index.blade.php` (chua co) | UI report theo `x-nav-tabs`, reuse input-taikhoan va input-khachhang (mode NCC) |
| Route | `diepxuan/laravel-catalog/routes/web.php` | `po.rpt.arrptbccn01103023` -> `Muahang\ApReportIndex` |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsARRptBCCN01SL.php` | Da co, can xac nhan tham so theo procedures.md |
| Matrix | `docs/project/simba-router-menu-matrix.md` | `10.30.23` -> `ap.rpt.bccn01sl` (slug cu theo matrix; slug thuc te se la `arrptbccn01103023` theo task 358) |

## Data Access Map

| UI/data action | Code name | Simba table | Source | GET SP/wrapper |
|---|---|---|---|---|
| Lookup nha cung cap | `MA_NCC` | `ARDMKH` (mode NCC) | `sysDictionaryInfo` + `sysDAOInfo` | `asARGetDMKH` (mode AP) - da co trong `InputKhachhang` |
| Lookup tai khoan | `MA_TK` | `GLDMTK` | `sysDictionaryInfo` + `sysDAOInfo` | `asGLGetDMTK` qua `CatalogService::glDmTks()` |
| Loc bao cao cong no NCC SL | `ARRptBCCN01SL` | `AP4CT`, `DMKH`, `DMTK` | `sysReportInfo` row `10.30.23` | `asARRptBCCN01SL` / `StoredProcedures\AsARRptBCCN01SL` |

## Checklist trien khai

### Phase framework (theo task 358)

- [x] `SimbaMenuRouteMetadata::routeNameFor()` doi hau to slug trung ten thanh `menuIdSuffix()` (noi ky tu alphanumeric cua menuid, khong them `-`)
- [x] Them helper `menuIdSuffix()` trong `SimbaMenuRouteMetadata`
- [x] Them unit test `testRouteNameSuffixAppendsCompactMenuId` pin behavior
- [x] `php -l` pass cho `SimbaMenuRouteMetadata.php` va `SimbaMenuRouteMetadataTest.php`
- [x] phpunit `SimbaMenuRouteMetadataTest` 9 tests / 20 assertions pass

### Phase AP report (task nay)

- [ ] Doc source: `sysMenu` row 327, `sysReportInfo` row 297, `ARRptBCCN01.dll`, `procedures/AR/procedures.md` cho `asARRptBCCN01SL`
- [ ] Xac nhan wrapper `AsARRptBCCN01SL` da co du tham so theo procedures.md (hien tai wrapper chi expose `pSysMsg1/2/3`)
- [ ] Tao Livewire `Muahang\ApReportIndex` voi filter + grid + export
- [ ] Tao view `muahang/rpt/ap-report-index.blade.php` theo `x-nav-tabs`
- [ ] Mo source route `_simba-source/po/rpt/arrptbccn01103023` trong `diepxuan/laravel-catalog/routes/web.php`
- [ ] Them route vao `SourceRouteCoverageTest`
- [ ] Them unit test cho `AsARRptBCCN01SL::procedureParams()` neu wrapper duoc chinh
- [ ] `php -l` + phpunit lien quan
- [ ] Browser E2E tren `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023`

## Khong thuoc pham vi

- Khong tao bang/SP/field moi.
- Khong sua `SimbaMenuRouteMetadata` (da sua trong task 358).
- Khong mo task con cho `10.30.11` (`ap.rpt.bccn01`) hoac `10.30.14` (`ap.rpt.bccn01a`) trong task nay.

## Tieu chi hoan thanh

- URL `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023` tra ve report shell theo `SimbaPage` (metadata it nhat: menuid `10.30.23`, report `ARBCCN012.rpt`, command `AsiaErp.UserInterface.frmARRptBCCN01`).
- Component `Muahang\ApReportIndex` render dung SP `asARRptBCCN01SL` voi filter TK/NCC/ky bao cao.
- Tests pass, lint pass, route coverage test pass.

## Ghi chu ky thuat

- Slug su dung theo task 358: `arrptbccn01103023` (compact, khong co `-`).
- Matrix dang de slug `bccn01sl` nhu chi tham khao, slug thuc te trong route registry se la `arrptbccn01103023`. Can cap nhat matrix neu Sếp dong y.
- Wrapper `AsARRptBCCN01SL.php` hien tai chi expose `pSysMsg1/2/3`; can bo sung day du tham so theo procedures.md de su dung cho AP view. Viec nay co the tach thanh task con neu Sếp muon.

## Audit Status
- **Status:** PENDING
- **Ngay tao:** 2026-07-13
- **Nguoi tao:** Bot (Portal Agent)
- **Ly do:** Sếp yeu cau viet task tham khao task 008/117 cho chuc nang So chi tiet cong no mot nha cung cap (SL), su dung lai phase framework tu task 358.
