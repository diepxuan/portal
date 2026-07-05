# Task 117: INRptCD02

## Nhom: IN (Inventory - Ton kho)

## Muc tieu

Chuyen doi chuc nang **Bao cao ton kho** tu Simba .NET `INRptCD02.dll` sang Livewire report moi, dung route source Simba va stored procedure that `asINRptCD02`.

## Trang thai hien tai

- **Status:** IMPLEMENTED - can review/CI
- **Ngay audit/cap nhat:** 2026-07-05
- **Branch:** `task/117-inrptcd02-report`
- **Canonical URL:** `/simba/in/rpt/inrptcd02`
- **Source route:** `/_simba-source/in/rpt/inrptcd02`
- **Route name:** `in.rpt.inrptcd02`

## Source of truth tu Simba

### sysMenu

| MenuID | Module | Tieu de | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `14.20.11` | IN | Bao cao ton kho | `INRptCD02` | `AsiaErp.UserInterface.frmINRptCD02` | `1` |

### sysReportInfo

| MenuID | Mau | SP | Report |
|--------|-----|----|--------|
| `14.20.11` | `01` | `asINRptCD02` | `INCD021.rpt` |
| `14.20.11` | `02` | `asINRptCD02` | `INCD022.rpt` |

Ghi chu audit: cung `MenuID 14.20.11` co cac dong mau `03 asINRptCD04` va `05 asINRptCD07`, nhung task nay chi mo dung bao cao `INRptCD02/asINRptCD02` theo command/form cua menu.

### Menu lien quan khong mo trong task nay

| MenuID | Tieu de | Active | Ly do |
|--------|---------|--------|-------|
| `14.20.50` | Bao cao ton kho (in so luong) | `0` | Inactive/duplicate command `INRptCD02` |
| `14.20.53` | Bao cao ton kho theo kho | `0` | Inactive/duplicate command `INRptCD02` |

## DLL audit

File: `simba-docs/decompiled/asia/INRptCD02.dll/AsiaERP.UserInterface/frmINRptCD02.cs`

### Controls chinh

| Control | Portal field | Mo ta |
|---------|--------------|-------|
| `txtMa_vt` | `pMa_vt` | Ma vat tu |
| `txtMa_kho` | `pMa_kho` | Ma kho |
| `txtMa_vitri` | `pMa_vitri` | Ma vi tri |
| `txtMa_tkvt` | `pTk_vt` | Tai khoan vat tu |
| `txtNh_vt` | `pMa_nhvt` | Nhom vat tu |
| `txtNgay` | `pNgay` | Ngay bao cao |
| `cboDVT` | `pDVT` | `0` kho, `1` mua, `2` ban |
| `optNt` | `pNgoai_te` | Co ngoai te: `1`, khong: `0` |
| `rbCk` | `pDk_Ck` | `true` = cuoi ky, `false` = dau ky |
| `txtMa_lo` | `pMa_lo` | Ma lo |
| `ChkQuaToiThieu` | `pQuaToiThieu` | Loc ton nho hon muc toi thieu |
| `ChkQuaToiDa` | `pQuaToiDa` | Loc ton lon hon muc toi da |

### Thu tu tham so `LoadData()`

1. `CompanyInformations.CompanyID`
2. `txtMa_vt.Text.Trim()`
3. `txtMa_kho.Text.Trim()`
4. `txtMa_vitri.Text.Trim()`
5. `txtMa_tkvt.Text.Trim()`
6. `txtNh_vt.Text.Trim()`
7. `txtNgay.Value`
8. `cboDVT.SelectedValue`
9. `optNt.Checked ? "1" : "0"`
10. `rbCk.Checked`
11. `txtMa_lo.Text.Trim()`
12. `ChkQuaToiThieu.Checked`
13. `ChkQuaToiDa.Checked`

Formula fields tu DLL:

- `strSubTitle = GetFilterTitle()`
- `KIEU_DU = rbCk.Checked`

## Audit code cu

Da loai bo struct cu:

- `diepxuan/laravel-catalog/src/Http/Livewire/In/Baocao/Tonkho.php`
- `diepxuan/laravel-catalog/resources/views/in/baocao/tonkho.blade.php`

Ly do:

- Khong co route source/canonical dung cho `in.rpt.inrptcd02`.
- UI cu bind `Don vi tinh` vao `pMa_lo`, lam ghi de ma lo.
- UI cu bind ngoai te vao `pMa_Nt`, trong khi component dung `pNgoai_te` va DLL can co `0/1`.
- Component cu goi model helper `InDmVt::getAsINRptCD02()` truc tiep thay vi wrapper SP chuan `AsINRptCD02`.

## Portal mapping moi

| Loai | File | Noi dung |
|------|------|----------|
| Component | `diepxuan/laravel-catalog/src/Http/Livewire/In/Rpt/Inrptcd02.php` | Form filter, submit SP, grid ket qua, select row, export CSV |
| View | `diepxuan/laravel-catalog/resources/views/in/rpt/inrptcd02.blade.php` | UI report theo `x-nav-tabs`, lookup kho/vat tu/nhom VT/tai khoan |
| Route | `diepxuan/laravel-catalog/routes/web.php` | `in.rpt.inrptcd02` -> `In\Rpt\Inrptcd02` |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsINRptCD02.php` | `procedureParams()` dung 13 tham so Simba |
| Matrix | `docs/project/simba-router-menu-matrix.md` | `14.20.11` -> `in.rpt.inrptcd02` |

## Verification checklist

- [x] Simba source audit: `sysMenu`, `sysReportInfo`, DLL `LoadData()`
- [x] Chuyen struct cu sang `In\Rpt\Inrptcd02`
- [x] Sua binding DVT/ngoai te/DK-CK theo DLL
- [x] Mo route `in.rpt.inrptcd02`
- [x] Them test route coverage
- [x] Them test wrapper `AsINRptCD02::procedureParams()`
- [x] Them test helper UI report grid/export
- [ ] Chay lint/test/route-list truoc khi PR

## Ghi chu ky thuat

- Khong tao bang/SP/field moi.
- Khong dung ten SP cu `SP_IN_CD02_GET`; ten dung tu Simba docs la `asINRptCD02`.
- Wrapper SP van chap nhan alias legacy `pMa_Cty`, nhung call chuan chi truyen `pMa_cty` cung 12 tham so con lai.
