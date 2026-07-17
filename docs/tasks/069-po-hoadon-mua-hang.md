# Task 069: POVchPO3 — Phiếu nhập mua hàng (Hóa đơn mua hàng PO3)

## Nhom: PO (Purchase Order - Mua hàng)

## Muc tieu

Chuyen doi chuc tu **Phieu nhap mua hang (PO3)** tu Simba .NET `POVchPO3.dll` sang Livewire voucher moi, dung route source Simba va stored procedure that `asPOGetPO3` / `asPOSavePO3` / `asPODeletePO3`.

## Trang thai hien tai

- **Status:** PENDING — code shell co, can refactor + bo sung route
- **Ngay audit/cap nhat:** 2026-07-18
- **Branch:** chua tao
- **Canonical URL (ky vong):** `/simba/po/vch/povchpo3101014` (slug compact theo task 358)
- **Source route:** `/_simba-source/po/vch/povchpo3101014`
- **DLL:** POVchPO3.dll
- **Route name:** `po.vch.povchpo3101014`

## Source of truth tu Simba

### sysMenu

| MenuID | Module | Tieu de | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `10.10.14` | PO | Hoa don mua hang trong nuoc | `POVchPO3` | `AsiaErp.UserInterface.frmPOVchPO3` | `1` |

### sysVoucherInfo

| MenuID | Ma_ct | Loai | SP chinh |
|--------|-------|------|----------|
| `10.10.14` | `PO3` | Voucher | `asPOGetPO3` / `asPOSavePO3` / `asPODeletePO3` |

### Menu lien quan khong mo trong task nay

| MenuID | Tieu de | Active | Ly do |
|--------|---------|--------|-------|
| `10.10.05` | Don hang mua (PO1) | `1` | Task rieng (PO1 → Don hang mua) |
| `10.10.08` | Phieu nhap mua hang (PO2) | `1` | Task rieng (PO2 → Phieu nhap) |
| `10.10.20` | Phieu chi phi mua hang (PO4) | `1` | Task rieng |
| `10.10.26` | Hoa don mua dich vu (PO6) | `1` | Task rieng (task 217) |

## DLL audit

File: `simba-docs/decompiled/asia/POVchPO3.dll/AsiaErp.UserInterface/frmPOVchPO3.cs`

Form goc co 4 tab: Detail (chi tiet vat tu), Chi_phi (chi phi mua hang), Hach_toan (but toan), Tain (thue GTGT dau vao qua control `ctlTaIn`).

### Controls chinh (Header — theo simba-docs/asia/po/vouchers/POVchPO3.md)

| Control | Portal field | Mo ta |
|---------|--------------|-------|
| `txtMa_Kh` | `pMa_kh` | Ma NCC (lookup `MA_NCC`, isNcc=1) |
| `lblTen_Kh` | `pTen_kh` | Ten NCC (auto-fill) |
| `txtDia_chi` | `pDia_chi` | Dia chi NCC |
| `txtMa_so_thue` | `pMa_so_thue` | Ma so thue |
| `txtNguoi_Gd` | `pNguoi_gd` | Nguoi giao dich |
| `txtDien_giai` | `pDien_giai` | Dien giai |
| `txtNgay_lct` | `pNgay_lct` | Ngay lap CT |
| `cboMa_NT` | `pMa_nt` | Ma ngoai te |
| `txtTy_gia` | `pTy_gia` | Ty gia |
| `txtSo_hd` | `pSo_hd` | So hoa don |
| `txtNgay_hd` | `pNgay_hd` | Ngay hoa don |
| `txtMa_Httt` | `pMa_httt` | Hinh thuc thanh toan (lookup `MA_HTTT`) |
| `txtTk_pt` | `pTk_pt` | TK phai tra |
| `txtTk_thue` | `pTk_thue` | TK thue |

### Tab Chi tiet (adgvDetail)

| Column | Portal field | Mo ta |
|--------|--------------|-------|
| `Ma_vt` | `pCt_ma_vt` | Ma vat tu (lookup `MA_VT`) |
| `Ten_vt` | `pCt_ten_vt` | Ten vat tu |
| `Dvt` | `pCt_dvt` | Don vi tinh |
| `Ma_kho` | `pCt_ma_kho` | Ma kho (lookup `MA_KHO`) |
| `Ton_so_luong` | `pCt_ton_so_luong` | Ton kho (readOnly) |
| `So_luong` | `pCt_so_luong` | So luong |
| `Gia_nt0` | `pCt_gia_nt0` | Don gia NT |
| `Tien_nt0` | `pCt_tien_nt0` | Thanh tien NT |
| `Tl_ck` | `pCt_tl_ck` | Ty le CK (%) |
| `Ck_nt` | `pCt_ck_nt` | Tien CK NT |
| `Tien_cp_nt` | `pCt_tien_cp_nt` | Chi phi NT |
| `Ts_gtgt` | `pCt_ts_gtgt` | Thue suat GTGT |
| `Thue_gtgt_nt` | `pCt_thue_gtgt_nt` | Tien thue NT |
| `Gia0` | `pCt_gia0` | Don gia VND (readOnly) |
| `Tien0` | `pCt_tien0` | Thanh tien VND (readOnly) |
| `Ck` | `pCt_ck` | Tien CK VND (readOnly) |
| `Tien_cp` | `pCt_tien_cp` | Chi phi VND (readOnly) |
| `Thue_gtgt` | `pCt_thue_gtgt` | Tien thue VND (readOnly) |

### Tab Chi phi (adgvChi_phi)

| Column | Portal field |
|--------|--------------|
| `Ma_chiphi` | `pCp_ma_chiphi` |
| `Ten_chi_phi` | `pCp_ten_chi_phi` |
| `Tien_cp_nt_cp` | `pCp_tien_cp_nt` |
| `Ts_gtgt_cp` | `pCp_ts_gtgt_cp` |
| `Thue_gtgt_nt_cp` | `pCp_thue_gtgt_nt_cp` |
| `Tt_nt_cp` | `pCp_tt_nt_cp` (readOnly) |
| `Ma_bp_cp` | `pCp_ma_bp` |
| `Ma_spct_cp` | `pCp_ma_spct` |
| `Ma_phi_cp` | `pCp_ma_phi` |
| `Ma_lo_cp` | `pCp_ma_lo` |

### Tab Hach toan (adgvHach_toan)

| Column | Portal field |
|--------|--------------|
| `tk_no` | `pHt_tk_no` |
| `tk_co` | `pHt_tk_co` |
| `ma_vt` | `pHt_ma_vt` |
| `ten_vt` | `pHt_ten_vt` |
| `tien` | `pHt_tien` |
| `tien_nt` | `pHt_tien_nt` |

### Tab Thue (ctlTaIn)

Footer totals: `t_so_luong`, `t_tien0`, `t_tien_nt0`, `t_cp`, `t_cp_nt`, `t_thue`, `t_thue_nt`, `t_tt`, `t_tt_nt`, `tl_ck_hd`, `t_ck`, `t_ck_nt`.

## Cau truc du lieu

Theo schema Simba ERP (simba-docs/decompiled/.../dbo/Tables/PoPh3.sql, PoCt3.sql, PoCp3.sql):

### Bang PoPh3 (Header) — table name trong DB

**PK:** `ma_cty`, `stt_rec`

| Truong | Kieu | Mo ta |
| --- | --- | --- |
| `ma_cty` | NVARCHAR(3) | Ma cong ty |
| `stt_rec` | NVARCHAR(20) | So thu tu record (PK) |
| `ma_ct` | NVARCHAR(3) | Ma chung tu (= 'PO3') |
| `ma_kh` | NVARCHAR(20) | Ma NCC |
| `dia_chi` | NVARCHAR(255) | Dia chi |
| `nguoi_gd` | NVARCHAR(30) | Nguoi giao dich |
| `ma_httt` | NVARCHAR(20) | Hinh thuc thanh toan |
| `tk_pt` | NVARCHAR(20) | TK phai tra |
| `tk_thue` | NVARCHAR(20) | TK thue |
| `dien_giai` | NVARCHAR(255) | Dien giai |
| `so_seri` | NVARCHAR(12) | So seri |
| `so_ct` | NVARCHAR(12) | So chung tu |
| `ngay_ct` | SMALLDATETIME | Ngay chung tu |
| `ngay_lct` | SMALLDATETIME | Ngay lap chung tu |
| `kht_tain` | BIT | Khach thue dau vao |
| `ngay_pn` | SMALLDATETIME | Ngay nhap |
| `so_pn` | NVARCHAR(12) | So phieu nhap |
| `ngay_hd` | SMALLDATETIME | Ngay hoa don |
| `so_hd` | NVARCHAR(12) | So hoa don |
| `ma_tt_po` | NVARCHAR(8) | Ma thanh toan PO |
| `han_ck` | DECIMAL(19,4) | Han chiet khau |
| `tl_ck` | DECIMAL(19,4) | Ty le chiet khau |
| `han_tt` | DECIMAL(19,4) | Han thanh toan |
| `ls_qh` | DECIMAL(19,4) | Lai suat qua han |
| `ma_nt` | NVARCHAR(3) | Ma ngoai te |
| `ty_gia` | DECIMAL(19,4) | Ty gia |
| `t_tien_nt0` | DECIMAL(19,4) | Tong tien NT (truoc thue) |
| `t_tien0` | DECIMAL(19,4) | Tong tien VND (truoc thue) |
| `t_cp_nt` | DECIMAL(19,4) | Tong chi phi NT |
| `t_cp` | DECIMAL(19,4) | Tong chi phi VND |
| `t_tien_nt` | DECIMAL(19,4) | Tong tien NT |
| `t_tien` | DECIMAL(19,4) | Tong tien VND |
| `t_thue_nt` | DECIMAL(19,4) | Tong thue NT |
| `t_thue` | DECIMAL(19,4) | Tong thue VND |
| `tl_ck_hd` | DECIMAL(19,4) | Ty le CK hoa don |
| `t_ck` | DECIMAL(19,4) | Tong CK VND |
| `t_ck_nt` | DECIMAL(19,4) | Tong CK NT |
| `t_tt` | DECIMAL(19,4) | Tong thanh toan VND |
| `t_tt_nt` | DECIMAL(19,4) | Tong thanh toan NT |
| `t_so_luong` | DECIMAL(19,4) | Tong so luong |
| `ck_st` | BIT | Chiet khau truoc thue |
| `sua_tien` / `sua_thue` / `sua_thue_nk` / `sua_thue_ttdb` / `sua_tt` | BIT | Co sua tien khong |
| `tao_tu_pn` / `tao_tu_dh` | BIT | Tao tu phieu nhap / don hang |
| `trang_thai` | NVARCHAR(1) | Trang thai |
| `ghi_chu` | NVARCHAR(255) | Ghi chu |
| `post2gl` / `post2in` | BIT | Post vao GL / Inventory |
| `cdate` / `ldate` | SMALLDATETIME | Ngay tao / sua |
| `cuser` / `luser` | NVARCHAR(20) | Nguoi tao / sua |

### Bang PoCt3 (Chi tiet vat tu) — table name trong DB

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`

| Truong chinh | Mo ta |
| --- | --- |
| `stt_rec` | FK → PoPh3 |
| `stt_rec0` | So dong |
| `ma_vt` | Ma vat tu |
| `ten_vt` | Ten vat tu |
| `tk_vt` | TK vat tu |
| `tk_thue` | TK thue GTGT |
| `tk_thue_nk` | TK thue NK |
| `tk_thue_ttdb` | TK thue TTDB |
| `ma_kho` / `ma_vitri` / `ma_lo` | Kho / vi tri / lo |
| `so_luong` / `so_luong_qd` | So luong / SL quy doi |
| `gia_nt0` / `gia0` | Don gia NT / VND (truoc thue) |
| `tien_nt0` / `tien0` | Thanh tien NT / VND |
| `tl_ck` / `ck_nt` / `ck` | Ty le CK + tien CK |
| `ts_gtgt` / `thue_gtgt_nt` / `thue_gtgt` | Thue suat + tien thue |
| `tien_cp_nt` / `tien_cp` | Chi phan bo NT / VND |
| `ma_bp` / `ma_phi` / `ma_spct` | Bo phan / phi / SPCT |

### Bang PoCp3 (Chi phi) — table name trong DB

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`

| Truong chinh | Mo ta |
| --- | --- |
| `stt_rec` | FK → PoPh3 |
| `stt_rec0` | So dong |
| `ma_cp` | Ma chi phi |
| `ten_cp` | Ten chi phi |
| `tt_pb` | Cach phan bo: `1` theo so luong, `2` theo tien hang |
| `tien_cp_nt` / `tien_cp` | Tien chi phi NT / VND |
| `ts_gtgt` / `thue_gtgt_nt` / `thue_gtgt` | Thue suat + tien thue |
| `tt_nt` / `tt` | Tong NT / VND |
| `ma_bp` / `ma_phi` / `ma_spct` / `ma_lo` | BP / Phi / SPCT / Lo |

## SP wrappers da co (laravel-simba)

| Wrapper | SP | Muc dich | Params |
|---------|----|----|--------|
| `AsPOGetPO3` | `asPOGetPO3` | Lay header + detail + chi phi + hach toan theo stt_rec | `pMa_cty`, `pStt_rec` |
| `AsPOSavePO3` | `asPOSavePO3` | Luu PO3 (header + detail + chi phi + hach toan) | tu tham so header |
| `AsPODeletePO3` | `asPODeletePO3` | Xoa PO3 | `pMa_cty`, `pStt_rec` |
| `AsPOChkRightStatusPO3` | `asPOChkRightStatusPO3` | Check quyen + trang thai | |
| `AsReCalPO3` | `asReCalPO3` | Recalculate PO3 | |
| `AsReCalPO34Relate` | `asReCalPO34Relate` | Recalculate related objects | |
| `AsAPUpdTt_SoDuPo3` | `asAPUpdTt_SoDuPo3` | Update AP balance for PO3 | |
| `AsPOGetPH3` / `AsPOInsPH3` / `AsPOUpdPH3` / `AsPODelPH3` | PoPh3 CRUD | |
| `AsPOGetCT3` / `AsPOInsCT3` / `AsPODelCT3` | PoCt3 CRUD | |
| `AsPOGetCP3` / `AsPOInsCP3` / `AsPODelCP3` | PoCp3 CRUD | |
| `AsPOGetChiPhi` | `asPOGetChiPhi` | Lay chi phi mua hang | |
| `AsPOGetHachToan` | `asPOGetHachToan` | Lay hach toan | |
| `AsChkSoCt` / `AsGetSoCt` / `AsGetSttRec` | Sinh + check so_ct, stt_rec | dung chung |

## Portal mapping

| Loai | File | Noi dung |
|------|------|----------|
| Component List | `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/Hoadonmua.php` | Da co, can refactor de bind SP `asPOGetPH3` thay vi Eloquent `PoPh3` model truc tiep |
| Component Edit | `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/HoadonmuaEdit.php` | Da co, can hoan thien submit() goi `asPOSavePO3` |
| View List | `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua.blade.php` | Da co, can refactor theo design system phase 1 |
| View Edit | `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua-edit.blade.php` | Da co, can refactor de co 4 tab: Detail, Chi phi, Hach toan, Tain |
| Route | `diepxuan/laravel-catalog/routes/web.php` | `po.vch.povchpo3101014` (slug compact) → `Po\Vch\Povchpo3` chua co, can tao |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsPOGetPO3.php` | Da co |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsPOSavePO3.php` | Da co |
| SP wrapper | `diepxuan/laravel-simba/src/StoredProcedures/AsPODeletePO3.php` | Da co |
| Matrix | `docs/project/simba-router-menu-matrix.md` | `10.10.14` → `po.vch.povchpo3101014` |

## Data Access Map

| UI/data action | Code name | Simba table | Source | SP wrapper |
|---|---|---|---|---|
| List header | `pMa_cty`, filter | `PoPh3` | `sysMenu 10.10.14` + `sysVoucherInfo` | `asPOGetPO3` (with empty stt_rec) hoac Eloquent `PoPh3` |
| Get 1 header | `pMa_cty`, `pStt_rec` | `PoPh3` | | `asPOGetPO3` |
| Get chi tiet VT | `pMa_cty`, `pStt_rec` | `PoCt3` | | `asPOGetCT3` (tra ve nhieu dong) |
| Get chi phi | `pMa_cty`, `pStt_rec` | `PoCp3` | | `asPOGetCP3` |
| Get hach toan | `pMa_cty`, `pStt_rec` | (sinh tu SP) | | `asPOGetHachToan` |
| Lookup NCC | `MA_NCC` isNcc=1 | `ARDMKH` | `sysDictionaryInfo` | `asARGetDMKH` (mode NCC) |
| Lookup VT | `MA_VT` | `INDMVT` | `sysDictionaryInfo` | `asINGetDMVT` |
| Lookup Kho | `MA_KHO` | `INDMKHO` | `sysDictionaryInfo` | `asINGetDMKHO` |
| Lookup HTTT | `MA_HTTT` | `SIDMHTTT` | `sysDictionaryInfo` | `asSIGetDMHTTT` |
| Lookup Chi phi | `MA_CHIPHI` | `PODMCP` | `sysDictionaryInfo` | `asPOGetDMCP` |
| Lookup TK | `MA_TK` | `GLDMTK` | `sysDictionaryInfo` | `asGLGetDMTK` |
| Sinh stt_rec | | | | `asGetSttRec(pMa_ct: 'PO3')` |
| Sinh so_ct | | | | `asGetSoCt(pMa_ct: 'PO3', pNgay_Ct)` |
| Check trung so_ct | | | | `asChkSoCt(pMa_ct, pStt_rec, pSo_ct, pNgay_Ct)` |
| Save full | | `PoPh3` + `PoCt3` + `PoCp3` | | `asPOSavePO3` |
| Delete | | | | `asPODeletePO3` |

## Verification checklist

### Phase SP wrappers (laravel-simba) — DANG CO, can verify

- [x] `AsPOGetPO3` wrapper co 2 tham so `pMa_cty`, `pStt_rec`
- [x] `AsPOSavePO3` wrapper (decompile xac nhan so params)
- [x] `AsPODeletePO3` wrapper
- [x] `AsPOChkRightStatusPO3`, `AsReCalPO3`, `AsReCalPO34Relate`, `AsAPUpdTt_SoDuPo3`
- [x] CRUD `AsPOGetPH3/Ins/Upd/Del`, `AsPOGetCT3/Ins/Del`, `AsPOGetCP3/Ins/Del`
- [ ] Unit test `AsPOGetPO3::procedureParams()` (chua co file test)
- [ ] Unit test `AsPOSavePO3::procedureParams()` (chua co file test)
- [ ] Unit test `AsPODeletePO3::procedureParams()` (chua co file test)

### Phase Livewire + View (laravel-catalog)

- [ ] Refactor `Muahang\Hoadonmua` de bind SP `asPOGetPO3` (with empty stt_rec → list) thay vi Eloquent `PoPh3` model
- [ ] Refactor `Muahang\HoadonmuaEdit` de load 4 dataset tu `asPOGetPO3` (header, detail, chi phi, hach toan) thay vi nhieu SP rieng
- [ ] Hoan thien `submit()` goi `asPOSavePO3` (header + detail + chi phi + hach toan)
- [ ] Them `Muahang\HoadonmuaFind` (form tim kiem theo `frmPOVchPO3Find`)
- [ ] Them `Muahang\ChonPO1` (form chon don hang PO1 lien ket)
- [ ] Refactor view `hoadonmua.blade.php` theo design system phase 1
- [ ] Refactor view `hoadonmua-edit.blade.php` de co 4 tab (Detail / Chi phi / Hach toan / Tain)
- [ ] Tao partial `_grid-chitiet.blade.php`, `_grid-chiphi.blade.php`, `_grid-hachtoan.blade.php`
- [ ] Tao partial `_tax-control.blade.php` (Tab Tain) + `_footer-totals.blade.php`
- [ ] Tao partial `_lookup-ncc.blade.php`

### Phase Routes + Menu

- [ ] Mo source route `po.vch.povchpo3101014` (slug compact theo task 358) trong `routes/web.php`
- [ ] Component `Po\Vch\Povchpo3` (route can tao moi, khong dung shell `Muahang\Hoadonmua` cu)
- [ ] Them tham chieu menuid 10.10.14 vao `simba-router-menu-matrix.md`
- [ ] Them route vao `SourceRouteCoverageTest`

### Phase Validation & Business Logic

- [ ] Validate required: ma_kh, so_hd, ngay_hd
- [ ] Auto-calc tien hang: `tien_nt0 = so_luong * gia_nt0`
- [ ] Auto-calc chiet khau: `ck_nt = tien_nt0 * tl_ck / 100`
- [ ] Auto-calc thue GTGT: `thue_gtgt_nt = (tien_nt0 - ck_nt + tien_cp_nt) * ts_gtgt / 100`
- [ ] Auto-fill NCC info (ten_kh, dia_chi, ma_so_thue)
- [ ] Auto-fill TK khi chon HTTT (tk_pt, tk_thue)
- [ ] Phan bo chi phi theo `tt_pb`: 1 = theo so luong, 2 = theo tien hang
- [ ] Sinh `stt_rec` qua `AsGetSttRec::call(pMa_ct: 'PO3')` khi tao moi
- [ ] Sinh `so_ct` qua `AsGetSoCt::call(pMa_ct: 'PO3', pNgay_Ct)`
- [ ] Check trung so_ct qua `AsChkSoCt` truoc khi save
- [ ] Gọi `AsReCalPO3` sau khi save de tinh lai tong

### Phase Testing

- [ ] Test load danh sach + filter
- [ ] Test tao moi (header + detail + chi phi + hach toan)
- [ ] Test chinh sua
- [ ] Test xoa
- [ ] Test phan bo chi phi
- [ ] Test canh bao trung so_ct

## Khong thuoc pham vi

- Print/In PDF hoa don mua (defer sang task rieng, can template chung)
- Phan quyen xem/sua/xoa PO3 (defer, can framework chung)
- Workflow trang thai (Draft/Approved/Posted) — defer, can spec tu Simba goc
- Post vao GL/Inventory (xu ly trong `asPOSavePO3` qua `AsPostPoPh3_*`)

## Tieu chi hoan thanh

- Route `po.vch.povchpo3101014` hoat dong, mo form PO3 theo simba-docs.
- Component `Po\Vch\Povchpo3` load du 4 dataset (header, detail, chi phi, hach toan) tu `asPOGetPO3`.
- View co 4 tab (Detail, Chi phi, Hach toan, Tain) render theo design system phase 1.
- `submit()` goi `asPOSavePO3` thanh cong voi day du header + detail + chi phi + hach toan.
- Validation required fields pass, auto-calc tien/chiet khau/thue chinh xac.
- Tests pass, lint pass, route coverage pass.

## Ghi chu ky thuat

- Slug theo task 358: `povchpo3101014` (compact menuid suffix, khong co `-`).
- Dung schema `PoPh3` / `PoCt3` / `PoCp3` (Simba ERP legacy) — KHONG dung `POHMN` / `POHMNCT` / `POHMNCP` (doan bừa, khong co trong SimbaSql schema).
- Bind SP thay vi Eloquent cho header (giong task 008, 117, 358, 359).
- Form 4 tab: giu pattern `x-nav-tabs` cua design system, moi tab la 1 section rieng.
- Footer totals (Tab Tain) bind readonly voi `t_*` fields tu SP.
- Phan bo chi phi: command `cmdPhan_bo` goc — implement thanh 1 button Livewire goi service tinh toan local hoac 1 SP rieng (can xac minh).
- Currency precision: VND → 0 decimals, foreign → 4 decimals (giong task 359).
- `pStt_rec` sinh qua `AsGetSttRec` theo MA_CT = 'PO3'.

## Audit Status

- **Ngay audit 1:** 2026-05-13 — spec tu simba-docs, sub-tasks chi tiet 8 phases
- **Ngay audit 2:** 2026-05-14 — doi chieu PO3.md vs code that, sua bảng CSDL tu PO3/PO3CT/PO3CP/PO3HT → PoPh3/PoCt3/PoCp3
- **Ngay audit 3:** 2026-05-14 07:44 — Sep chi dao: dung schema Simba ERP .NET, xoa POHMN doan bừa
- **Ngay audit 4 (nay):** 2026-07-18 — doi ten file sang format phase 1 (`069-po-hoadon-mua-hang.md`), viet lai theo cau truc phase 1 (008, 117, 358, 359), confirm SP wrappers PO3 da co san (chi can them unit test).
- **Kiem chung:** SP wrappers PO3 da co (`AsPOGetPO3`, `AsPOSavePO3`, `AsPODeletePO3`, 8 CRUD PH3/CT3/CP3, helpers `AsPOGetChiPhi`, `AsPOGetHachToan`, status check, recalc, AP update). 2 view + 2 component da co trong `Muahang/` can refactor.
