# Task 359: AP - Sổ chi tiết công nợ một nhà cung cấp (menu 10.30.23)

## Nhom
AP (Accounts Payable - Cong no phai tra)

## Muc tieu
Chuyen doi chuc nang **Sổ chi tiết công nợ một nhà cung cấp - có số lượng** tu Simba .NET `ARRptBCCN01.dll` sang Livewire report moi, dung route source Simba va stored procedure that `asARRptBCCN01SL`.

## Trang thai hien tai

- **Status:** DONE - merged PR #247 (squash commit 12c1ae27d)
- **Ngay tao:** 2026-07-13
- **Nguoi tao:** Bot (Portal Agent)
- **Branch:** chua tao
- **Canonical URL (ky vong):** `/simba/po/rpt/arrptbccn01103023` (slug sinh theo SimbaMenuRouteMetadata, hau to compact theo task 358)
- **Source route:** `/_simba-source/po/rpt/arrptbccn01103023`
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

### Controls chinh (theo DLL goc)

| Control | Portal field | Mo ta |
|---------|--------------|-------|
| `txtTk` | `pTk` | Ma tai khoan (tk_cn=1) |
| `txtMa_Kh` | `pMa_kh` | Ma nha cung cap trong ngu canh AP; DLL dung chung ten control/param `ma_kh` |
| `txtNgay1` | `pNgay1` | Tu ngay |
| `txtNgay2` | `pNgay2` | Den ngay |
| `cboKyBc` | `pKyBc` | Ky bao cao |
| `cboMau_bc` | `pMa_mau` | Mau bao cao (`02` cho SL) |
| `optVND` | `pVND` | Hien thi VND |
| `optNt` | `pNgoai_te` | Hien thi ngoai te |
| `dgvBC` | grid | Du lieu bao cao |
| `btnIn` | `submit` | Nut in bao cao |
| `btnXuat` | `exportExcel` | Nut xuat Excel |

### Thu tu tham so `LoadData()` / `asARRptBCCN01SL`

Theo DLL decompile `frmARRptBCCN01.LoadData()`, form goi SP bang 6 tham so theo thu tu:

| Thu tu | Gia tri DLL | Portal/SP param |
|--------|-------------|-----------------|
| 1 | `CompanyInformations.CompanyID` | `ma_cty` |
| 2 | `txtNgay1.Value` | `Ngay1` |
| 3 | `txtNgay2.Value` | `Ngay2` |
| 4 | `txtTk.Text` | `Tk` |
| 5 | `txtMa_Kh.Text` | `ma_kh` |
| 6 | `txtMa_Nt.Text` | `ma_nt` |

Khong giu alias `pSysMsg*`; wrapper chi normalize ve dung 6 tham so SP tren.

## Portal mapping du kien

| Loai | File | Noi dung |
|------|------|----------|
| Component | `diepxuan/laravel-catalog/src/Http/Livewire/Po/Rpt/Arrptbccn01Sl.php` | Form filter, submit SP, grid ket qua, select row, export CSV |
| View | `diepxuan/laravel-catalog/resources/views/po/rpt/arrptbccn01sl.blade.php` | UI report theo `x-nav-tabs`, reuse `input-taikhoan` va `input-khachhang mode="nhacungcap"` |
| Route | `diepxuan/laravel-catalog/routes/web.php` | `po.rpt.arrptbccn01103023` -> `Po\Rpt\Arrptbccn01Sl` |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsARRptBCCN01SL.php` | Wrapper goi `asARRptBCCN01SL` voi 6 tham so chinh xac tu DLL |
| Matrix | `docs/project/simba-router-menu-matrix.md` | `10.30.23` -> `ap.rpt.bccn01sl` (slug cu theo matrix; slug thuc te se la `arrptbccn01103023` theo task 358) |

## Data Access Map

| UI/data action | Code name | Simba table | Source | GET SP/wrapper |
|---|---|---|---|---|
| Lookup nha cung cap | `ma_kh` trong DLL/SP, hien thi la NCC o AP | `ARDMKH` (mode NCC) | `sysDictionaryInfo` + `sysDAOInfo` | `asARGetDMKH` (mode AP) - da co trong `InputKhachhang` |
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

- [x] Doc source: `sysMenu`, `sysReportInfo`, `ARRptBCCN01.dll`, doi chieu SP class `AsARRptBCCN01SL`
- [x] Xac nhan wrapper `AsARRptBCCN01SL` dung 6 tham so theo DLL: `ma_cty`, `Ngay1`, `Ngay2`, `Tk`, `ma_kh`, `ma_nt`
- [x] Tao Livewire `Po\Rpt\Arrptbccn01Sl` voi filter + grid + export
- [x] Tao view `po/rpt/arrptbccn01sl.blade.php` theo `x-nav-tabs`
- [x] Mo source route `_simba-source/po/rpt/arrptbccn01103023` trong `diepxuan/laravel-catalog/routes/web.php`
- [x] Them route vao `SourceRouteCoverageTest`
- [x] Them unit test cho `AsARRptBCCN01SL::procedureParams()`
- [x] Dich token tong hop Simba trong ket qua report: `#ARRptBCCN_DDK`, `#ARRptBCCN_TPS`, `#ARRptBCCN_DCK`
- [x] Chuyen field `pTieu_de` sang display-only, khong cho sua bang textbox
- [x] Chuan hoa cot ket qua: gop `ngay_ct`/`so_ct`/`stt_rec`, format ngay `dd/mm/YYYY`, an cot raw thua, uu tien cot tien VND hoac ngoai te theo `pMa_nt`
- [x] `php -l` + phpunit lien quan
- [x] Kiem tra local URL tren `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023`

## Khong thuoc pham vi

- Khong tao bang/SP/field moi.
- Khong sua `SimbaMenuRouteMetadata` (da sua trong task 358).
- Khong mo task con cho `10.30.11` (`ap.rpt.bccn01`) hoac `10.30.14` (`ap.rpt.bccn01a`) trong task nay.

## Tieu chi hoan thanh

- URL `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023` tra ve report shell theo `SimbaPage` (metadata it nhat: menuid `10.30.23`, report `ARBCCN012.rpt`, command `AsiaErp.UserInterface.frmARRptBCCN01`).
- Component `Po\Rpt\Arrptbccn01Sl` render dung SP `asARRptBCCN01SL` voi filter TK/NCC/ky bao cao.
- Tests pass, lint pass, route coverage test pass.

## Ghi chu ky thuat

- Slug su dung theo task 358: `arrptbccn01103023` (compact, khong co `-`).
- Matrix dang de slug `bccn01sl` nhu chi tham khao, slug thuc te trong route registry se la `arrptbccn01103023`. Can cap nhat matrix neu Sếp dong y.
- Wrapper `AsARRptBCCN01SL.php` khong dung `pSysMsg*`; wrapper normalize ve 6 tham so chinh xac theo DLL. `pMa_cty`, `pNgay1`, `pNgay2`, `pTk`, `pMa_kh`, `pMa_nt` chi la alias UI noi bo de tuong thich Livewire property hien co.
- Cac token ngon ngu Simba trong cot dien giai duoc dich khi hien thi/export: `#ARRptBCCN_DDK` -> `Dư đầu kỳ`, `#ARRptBCCN_TPS` -> `Tổng phát sinh trong kỳ`, `#ARRptBCCN_DCK` -> `Dư cuối kỳ`.
- `pTieu_de` giu la property noi bo cua component de hien thi tieu de report; view render thanh text readonly, khong bind `wire:model`.
- Bang ket qua khong render raw toan bo column SP. View chi render cac nhom cot: Chung tu, Dien giai, So luong, Gia, Tien, PS No, PS Co. Thong tin vat tu (`ma_vt`, `ten_vt`, `dvt`) duoc gop vao cot Dien giai bang dong phu nho/mo. `stt_rec` duoc gop vao cot Chung tu voi style nho/mo. Khi `pMa_nt` trong/VND thi dung cot VND (`gia`, `tien`, `ps_no`, `ps_co`); khi chon ngoai te thi uu tien cot `*_nt`.
- Format so trong CSV/UI: `so_luong` luon 4 chu so thap phan; `gia`/`tien`/`ps_no`/`ps_co` lam tron theo `pMa_nt` - VND (hoac trong) thi 0 chu so le, ngoai te (USD/EUR/...) thi 4 chu so le de khong mat do chinh xac khi loc theo ngoai te.
- Phan biet dong chung tu/dong san pham: dong chi tiet vat tu (co `ma_vt` trong row) duoc lui 1 tab bang class `ps-4 text-gray-500` (Tailwind logical property, dong bo voi navigation-menu); dong tong hop (token `#ARRptBCCN_DDK`/`#ARRptBCCN_TPS`/`#ARRptBCCN_DCK`) giu style mac dinh (khong in dam); dong chung tu thuong giu style `text-gray-800`. CSV export prefix ky tu `\t` cho dong san pham de Excel giu indent khi mo.

## Audit Status
- **Status:** DONE - merged PR #247 (squash commit 12c1ae27d)
- **Ngay tao:** 2026-07-13
- **Nguoi tao:** Bot (Portal Agent)
- **Ly do:** Sếp yeu cau viet task tham khao task 008/117 cho chuc nang So chi tiet cong no mot nha cung cap (SL), su dung lai phase framework tu task 358.
- **Kiem chung:** wrapper unit test pass; report label/column presentation unit test pass; route coverage pass; SimbaMenuRouteMetadataTest pass; URL local `portal.diepxuan.corp` tra ve 200 voi metadata menuid `10.30.23`, `spname=asARRptBCCN01SL`, `rptname=ARBCCN012.rpt`, component `Po\Rpt\Arrptbccn01Sl`.
