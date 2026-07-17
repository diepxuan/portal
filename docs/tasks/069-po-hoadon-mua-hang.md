# Task 069: POVchPO3 — Phiếu nhập mua hàng (Hóa đơn mua hàng PO3)

## Nhom: PO (Purchase Order - Mua hàng)

## Muc tieu

Chuyen doi chuc tu **Phieu nhap mua hang (PO3)** tu Simba .NET `POVchPO3.dll` sang Livewire voucher moi, dat theo pattern `Po/Rpt/Arrptbccn01Sl` (PR #247) — namespace path `Po/Vch/Povchpo3`, view `po/vch/povchpo3.blade.php`, bind SP `asPOGetPO3` / `asPOSavePO3` / `asPODeletePO3`.

## Trang thai hien tai

- **Status:** PENDING — code shell cu `Muahang/Hoadonmua*` ton tai nhung KHONG co route bind, khong user nao truy cap duoc
- **Ngay audit/cap nhat:** 2026-07-18 (audit struct path/namespace theo DLL + server that + DESIGN.md + PR review #251)
- **Branch:** `task/251-po3-doc-rewrite`
- **URL public (server that):** `http://portal.diepxuan.corp/simba/po/vch/povchpo3` — dang render shell `catalog::system.simba-page` vi route `web.php` chua uncomment component thuc
- **URL source (ky vong refactor):** `/_simba-source/po/vch/povchpo3`
- **DLL:** `POVchPO3.dll` (form `frmPOVchPO3`, namespace `AsiaErp.UserInterface`)
- **Route name (server that):** `po.vch.povchpo3` (KHONG co suffix menuid — helper `SimbaMenuRouteMetadata::routeNameFor()` chi append `menuIdSuffix()` khi trung ten)
- **Slug:** `povchpo3`
- **Path/namespace (sau refactor):** `Diepxuan\Catalog\Http\Livewire\Po\Vch\Povchpo3` (KHONG dung shell `Muahang\Hoadonmua*` cu)
- **View (sau refactor):** `diepxuan/laravel-catalog/resources/views/po/vch/povchpo3.blade.php`
- **Template tham chieu:** `diepxuan/laravel-catalog/src/Http/Livewire/Po/Rpt/Arrptbccn01Sl.php` + `resources/views/po/rpt/arrptbccn01sl.blade.php` + `routes/web.php` dong 243

## Phat hien audit moi (2026-07-18)

### P1. Shell cu `Muahang\Hoadonmua*` la dead code

| File | Trang thai | Bang chung |
|------|-----------|-----------|
| `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/Hoadonmua.php` | 81 dong, dung `Eloquent PoPh3` cho list | KHONG co route bind nao tro vao |
| `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/HoadonmuaEdit.php` | 403 dong, da goi SP `asPOGetPO3` + `asPOSavePO3` + `AsGetSttRec` | KHONG co route bind |
| `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua.blade.php` | 99 dong | Dung `route('muahang.hoadonmua.create')` — khong co route name |
| `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua-edit.blade.php` | 350 dong, co 3 tab giong form PO3 | Dung `route('muahang.hoadonmua')` — khong co route name |

Kiem chung: `grep -n "muahang.hoadonmua" diepxuan/laravel-catalog/routes/web.php` → 0 ket qua. Toan bo shell cu dang chet, khong user nao truy cap duoc qua Portal.

### P2. Server that dang render shell metadata, khong phai form that

Wire:snapshot data tu `curl http://portal.diepxuan.corp/simba/po/vch/povchpo3`:

```
{"data":{"module":"po","kind":"vch","slug":"povchpo3","id":null,
 "target":[{"routeName":"po.vch.povchpo3",
            "metadata":[{"module":"PO","menuid":"10.10.14",
                         "source_type":"voucher",
                         "title":"Ho\u00e1 \u0111\u01a1n mua h\u00e0ng trong n\u01b0\u1edbc",
                         "dll_name":"POVchPO3",
                         "command":"AsiaErp.UserInterface.frmPOVchPO3",
                         "code_name":"PO3","ma_ct":"PO3"}],
            "menuid":"10.10.14","component":null}], ...}
```

Component dang render: `catalog::system.simba-page` + `catalog::system.simba-page-metadata` (fallback khi route chua uncomment component that).

### P3. Route name tren server: `po.vch.povchpo3` (KHONG suffix menuid)

Trich `SimbaMenuRouteMetadata::routeNameFor()` (`diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php:198-217`):

```php
$route = "{$module}.{$kind}.{$slug}";        // 'po.vch.povchpo3'
if (!isset($existing[$route])) {
    return $route;                            // khong append suffix vi chua trung
}
return "{$route}{$this->menuIdSuffix((string) $menu->menuid)}"; // chi append khi trung
```

PO3 (menuid `10.10.14`, slug `povchpo3`) la duy nhat → khong append → `po.vch.povchpo3`. Dung theo task 358 logic. Task 069 viet "khong suffix menuid vi vch 1-1 sysMenu" la chinh xac, KHONG phai bo qua task 358.

### P4. PR review #251 yeu cau chinh

Anh SẾP nhan xet:

> "Muahang/Hoadonmua phai chuyen ve struct dung, tuong tu po/rpt/arrptbccn01sl.blade.php da lam. Route la po.vch.povchpo3, Muahang/Hoadonmua.php nen chuyen thanh po/vch/povchpo3.php."

Tuong ung:
- `Muahang/Hoadonmua.php` → `Po/Vch/Povchpo3.php`
- `Muahang/HoadonmuaEdit.php` → `Po/Vch/Povchpo3Edit.php`
- `muahang/hoadonmua.blade.php` → `po/vch/povchpo3.blade.php`
- `muahang/hoadonmua-edit.blade.php` → `po/vch/povchpo3-edit.blade.php`
- `web.php`: uncomment dong 261, doi component tu `SimbaPage::class` → `Povchpo3::class`
- Matrix `simba-router-menu-matrix.md`: dong 70 + 262, doi mapping `muahang.hoadonmua` → `po.vch.povchpo3`

## Doi chieu DLL ↔ Code cu ↔ Code moi

### Header fields (POVchPO3.md §3.1)

| Control (DLL) | DataBinding | Portal field | Code cu `HoadonmuaEdit` | Code moi `Po\Vch\Povchpo3Edit` (de xuat) |
|---|---|---|---|---|
| `txtMa_Kh` | `Ma_Kh` | `pMa_kh` | ✅ co (input-khachhang mode=nhacungcap) | giu nguyen |
| `lblTen_Kh` | `Ten_Kh` | `pTen_kh` | ✅ co (autofill tu ArDmKh) | giu nguyen |
| `txtDia_chi` | `Dia_chi` | `pDia_chi` | ✅ co | giu nguyen |
| `txtMa_so_thue` | `Ma_so_thue` | `pMa_so_thue` | ✅ co | giu nguyen |
| `txtNguoi_Gd` | `Nguoi_Gd` | `pNguoi_gd` | ✅ co | giu nguyen |
| `txtDien_giai` | `Dien_giai` | `pDien_giai` | ✅ co | giu nguyen |
| `txtNgay_lct` | `Ngay_lct` | `pNgay_lct` | ⚠️ thieu (code cu chi co `pNgay_ct`) | them `pNgay_lct` |
| `cboMa_NT` | `Ma_NT` | `pMa_nt` | ✅ co (select hardcode) | chuyen sang Livewire component `input-ngoaite` |
| `txtTy_gia` | `Ty_gia` | `pTy_gia` | ✅ co | giu nguyen |
| `txtSo_hd` | `So_hd` | `pSo_hd` | ✅ co | giu nguyen |
| `txtNgay_hd` | `Ngay_hd` | `pNgay_hd` | ✅ co | giu nguyen |
| `txtMa_Httt` | `Ma_Httt` | `pMa_httt` | ⚠️ chua co input lookup (code cu de trong) | them Livewire `input-httt` |
| `txtTk_pt` | `Tk_pt` | `pTk_pt` | ⚠️ chua co input lookup | them Livewire `input-taikhoan` |
| `txtTk_thue` | `Tk_thue` | `pTk_thue` | ⚠️ chua co input lookup | them Livewire `input-taikhoan` |

### Tab Chi tiet (adgvDetail)

| Column (DLL) | Portal field | Code cu | Code moi |
|---|---|---|---|
| `Ma_vt` | `pCt_ma_vt` | ✅ co (input hang hoa) | giu nguyen |
| `Ten_vt` | `pCt_ten_vt` | ✅ co | giu nguyen |
| `Dvt` | `pCt_dvt` | ✅ co | giu nguyen |
| `Ma_kho` | `pCt_ma_kho` | ⚠️ thieu input lookup | them `input-kho` |
| `Ton_so_luong` | `pCt_ton_so_luong` | ❌ thieu (code cu khong load ton kho) | them (readonly, lay tu SP `AsGetTonKho` hoac field tu `asPOGetCT3`) |
| `So_luong`, `Gia_nt0`, `Tien_nt0`, `Tl_ck`, `Ck_nt`, `Tien_cp_nt`, `Ts_gtgt`, `Thue_gtgt_nt` | tuong ung | ✅ co | giu nguyen |
| `Gia0`, `Tien0`, `Ck`, `Tien_cp`, `Thue_gtgt` | readonly | ✅ co | giu nguyen |

### Tab Chi phi (adgvChi_phi)

Code cu da co day du field (`ma_chiphi`, `ten_chi_phi`, `tien_cp_nt`, `ts_gtgt_cp`, ...). ⚠️ chua co lookup input cho `ma_chiphi`. Giu nguyen logic, bo sung lookup.

### Tab Hach toan (adgvHach_toan)

❌ Code cu KHONG co tab hach toan (chi co `pActiveTab=0,1` cho Chi tiet + Chi phi). ⚠️ POVchPO3.md §6.3 noi ro co tab Hach toan voi `tk_no`, `tk_co`, `tien`, `tien_nt`. Phase nay moi them.

### Tab Thue (ctlTaIn / Tain)

❌ Code cu KHONG co tab Tain. DLL co `cmdThanh_toan` + `ctlTaIn` (tax invoice input). Task 069 phien truoc ghi "Them tab Tain" → de xuat tam hoan, vi day la phan phuc tap (tax input control rieng), xu ly rieng task tiep theo neu can.

## Cau truc du lieu

Theo schema Simba ERP (`simba-docs/decompiled/.../dbo/Tables/PoPh3.sql, PoCt3.sql, PoCp3.sql`):

### Bang PoPh3 (Header)

**PK:** `ma_cty`, `stt_rec`. Trg chinh: `ma_ct`='PO3', `ma_kh`, `dia_chi`, `nguoi_gd`, `ma_httt`, `tk_pt`, `tk_thue`, `dien_giai`, `so_seri`, `so_ct`, `ngay_ct`, `ngay_lct`, `kht_tain`, `so_pn`, `ngay_pn`, `so_hd`, `ngay_hd`, `ma_tt_po`, `han_ck`, `tl_ck`, `han_tt`, `ls_qh`, `ma_nt`, `ty_gia`, `t_tien_nt0`, `t_tien0`, `t_cp_nt`, `t_cp`, `t_thue_nt`, `t_thue`, `t_tt_nt`, `t_tt`, `t_so_luong`, `ck_st`, `sua_*`, `tao_tu_*`, `trang_thai`, `ghi_chu`, `post2gl`, `post2in`, `cdate/luser`.

### Bang PoCt3 (Chi tiet VT)

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`. Trg chinh: `ma_vt`, `ten_vt`, `tk_vt`, `tk_thue`, `ma_kho`, `ma_vitri`, `ma_lo`, `so_luong`, `so_luong_qd`, `gia_nt0`, `gia0`, `tien_nt0`, `tien0`, `tl_ck`, `ck_nt`, `ck`, `ts_gtgt`, `thue_gtgt_nt`, `thue_gtgt`, `tien_cp_nt`, `tien_cp`, `ma_bp`, `ma_phi`, `ma_spct`.

### Bang PoCp3 (Chi phi)

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`. Trg chinh: `ma_cp`, `ten_cp`, `tt_pb` (1=theo SL, 2=theo tien), `tien_cp_nt`, `tien_cp`, `ts_gtgt`, `thue_gtgt_nt`, `thue_gtgt`, `tt_nt`, `tt`, `ma_bp`, `ma_phi`, `ma_spct`, `ma_lo`.

## SP wrappers da co (laravel-simba)

| Wrapper | SP | Params chinh | Muc dich |
|---------|----|----|--------|
| `AsPOGetPO3` | `asPOGetPO3` | `pMa_cty`, `pStt_rec` | Lay header + detail + chi phi + hach toan |
| `AsPOSavePO3` | `asPOSavePO3` | 50+ params bao gom `pChiTiet`, `pChiPhi` | Luu day du PO3 |
| `AsPODeletePO3` | `asPODeletePO3` | `pMa_cty`, `pStt_rec` | Xoa PO3 |
| `AsPOChkRightStatusPO3` | `asPOChkRightStatusPO3` | | Quyen + trang thai |
| `AsReCalPO3` | `asReCalPO3` | | Recalc |
| `AsReCalPO34Relate` | `asReCalPO34Relate` | | Recalc related |
| `AsAPUpdTt_SoDuPo3` | `asAPUpdTt_SoDuPo3` | | Cap nhat AP balance |
| `AsPOGetPH3/Ins/Upd/Del` | CRUD `PoPh3` | | Header CRUD |
| `AsPOGetCT3/Ins/Del` | CRUD `PoCt3` | | Detail CRUD |
| `AsPOGetCP3/Ins/Del` | CRUD `PoCp3` | | Chi phi CRUD |
| `AsPOGetChiPhi` | `asPOGetChiPhi` | | Lay chi phi |
| `AsPOGetHachToan` | `asPOGetHachToan` | | Lay hach toan |
| `AsChkSoCt` / `AsGetSoCt` / `AsGetSttRec` | chung | `pMa_ct='PO3'` | Sinh + check so_ct, stt_rec |

## Data Access Map

| UI/data action | Code name | Simba table | Source | SP wrapper |
|---|---|---|---|---|
| List header | filter range | `PoPh3` | `sysMenu 10.10.14` + `sysVoucherInfo` | `AsPOGetPH3` (list) hoac Eloquent `PoPh3` (de xuat mac dinh) |
| Get 1 header | `pStt_rec` | `PoPh3` | | `asPOGetPO3` |
| Get chi tiet VT | `pStt_rec` | `PoCt3` | | `asPOGetCT3` (tra nhieu dong) |
| Get chi phi | `pStt_rec` | `PoCp3` | | `asPOGetCP3` |
| Get hach toan | `pStt_rec` | (sinh) | | `asPOGetHachToan` |
| Lookup NCC | `MA_NCC` isNcc=1 | `ARDMKH` | `sysDictionaryInfo` | `asARGetDMKH` |
| Lookup VT | `MA_VT` | `INDMVT` | `sysDictionaryInfo` | `asINGetDMVT` |
| Lookup Kho | `MA_KHO` | `INDMKHO` | `sysDictionaryInfo` | `asINGetDMKHO` |
| Lookup HTTT | `MA_HTTT` | `SIDMHTTT` | `sysDictionaryInfo` | `asSIGetDMHTTT` |
| Lookup Chi phi | `MA_CHIPHI` | `PODMCP` | `sysDictionaryInfo` | `asPOGetDMCP` |
| Lookup TK | `MA_TK` | `GLDMTK` | `sysDictionaryInfo` | `asGLGetDMTK` |
| Lookup NT | `MA_NT` | `SIDMNT` | `sysDictionaryInfo` | `asSIGetDMNT` |
| Lookup Lo | `MA_LO` | `INDMLO` | `sysDictionaryInfo` | `asINGetDMLO` |
| Lookup BP | `MA_BP` | `GLDMBP` | `sysDictionaryInfo` | `asGLGetDMBP` |
| Lookup Phi | `MA_PHI` | `GLDMPHI` | `sysDictionaryInfo` | `asGLGetDMPHI` |
| Lookup SPCT | `MA_SPCT` | `INDMSPCT` | `sysDictionaryInfo` | `asINGetDMSPCT` |
| Sinh stt_rec | | | | `AsGetSttRec::call(pMa_ct: 'PO3')` |
| Sinh so_ct | | | | `AsGetSoCt::call(pMa_ct: 'PO3', pNgay_Ct)` |
| Check trung so_ct | | | | `AsChkSoCt::call(pMa_ct, pStt_rec, pSo_ct, pNgay_Ct)` |
| Save full | | `PoPh3` + `PoCt3` + `PoCp3` | | `asPOSavePO3` |
| Recalc | | | | `AsReCalPO3` |
| Delete | | | | `asPODeletePO3` |

## Verification checklist

### Phase A — Xoa shell cu (cleanup dead code)
- [ ] Xoa `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/Hoadonmua.php`
- [ ] Xoa `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/HoadonmuaEdit.php`
- [ ] Xoa `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua.blade.php`
- [ ] Xoa `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua-edit.blade.php`
- [ ] Xoa `diepxuan/laravel-catalog/resources/views/po/dict/po-dmcp-index.blade.php` (neu khong ai dung) — kiem tra truoc
- [ ] Grep toan project `muahang.hoadonmua` → 0 ket qua
- [ ] Grep toan project `Muahang\\Hoadonmua` → 0 ket qua

### Phase B — Tao Livewire component moi
- [ ] Tao `diepxuan/laravel-catalog/src/Http/Livewire/Po/Vch/Povchpo3.php` (list page)
- [ ] Tao `diepxuan/laravel-catalog/src/Http/Livewire/Po/Vch/Povchpo3Edit.php` (edit form) — port logic tu `HoadonmuaEdit` + them field thieu (`pNgay_lct`, lookup `Ma_Httt`, `Tk_pt`, `Tk_thue`, `Ma_kho`, `Ton_so_luong`)
- [ ] Component list: dung `AsPOGetPH3` (wrapper co san) thay vi Eloquent `PoPh3` (giong task 008, 117)
- [ ] Component edit: dung `AsPOGetPO3` (full 4 dataset) thay vi 4 SP rieng

### Phase C — Tao view theo pattern arrptbccn01sl
- [ ] Tao `diepxuan/laravel-catalog/resources/views/po/vch/povchpo3.blade.php` (list, 2 tab: Filter + Content, dung `x-nav-tabs`)
- [ ] Tao `diepxuan/laravel-catalog/resources/views/po/vch/povchpo3-edit.blade.php` (4 tab: Header, Detail, Chi phi, Hach toan — Tain tam hoan phase sau)
- [ ] Tao partial `_grid-chitiet.blade.php`
- [ ] Tao partial `_grid-chiphi.blade.php`
- [ ] Tao partial `_grid-hachtoan.blade.php`
- [ ] Tao partial `_lookup-ncc.blade.php`
- [ ] Tao partial `_lookup-httt.blade.php`
- [ ] Tao partial `_lookup-taikhoan.blade.php`
- [ ] Tao partial `_lookup-kho.blade.php`
- [ ] Tao partial `_lookup-vt.blade.php`
- [ ] Tuân thủ `docs/DESIGN.md` (x-nav-tabs, grid spacing, focus ring, button style)

### Phase D — Routes + Matrix
- [ ] Uncomment `routes/web.php` dong 261, doi `component` tu `SimbaPage::class` → `Povchpo3::class`
- [ ] Them route name source: `_simba-source/po/vch/povchpo3` → component `Diepxuan\Catalog\Http\Livewire\Po\Vch\Povchpo3`
- [ ] Cap nhat `docs/project/simba-router-menu-matrix.md` dong 70 + 262: `muahang.hoadonmua` → `po.vch.povchpo3`; `Muahang\Hoadonmua` → `Po\Vch\Povchpo3`
- [ ] Them assertion vao `SourceRouteCoverageTest` (neu co) cho `po.vch.povchpo3`
- [ ] Kiem chung slug: KHONG co suffix `101014` vi PO3 la 1-1 sysMenu (helper `routeNameFor` tu dong khong append khi ten chua ton tai)

### Phase E — Validation & Business Logic
- [ ] Validate required: `ma_kh`, `so_hd`, `ngay_hd`, `ngay_ct`
- [ ] Auto-calc tien hang: `tien_nt0 = so_luong * gia_nt0`
- [ ] Auto-calc chiet khau: `ck_nt = tien_nt0 * tl_ck / 100`
- [ ] Auto-calc thue GTGT: `thue_gtgt_nt = (tien_nt0 - ck_nt + tien_cp_nt) * ts_gtgt / 100`
- [ ] Auto-fill NCC info (ten_kh, dia_chi, ma_so_thue) khi chon `ma_kh`
- [ ] Auto-fill `tk_pt`, `tk_thue` tu `ma_httt` lookup
- [ ] Phan bo chi phi theo `tt_pb`: 1 = theo so luong, 2 = theo tien hang (button "Phan bo")
- [ ] Sinh `stt_rec` qua `AsGetSttRec::call(pMa_ct: 'PO3')` khi tao moi
- [ ] Sinh `so_ct` qua `AsGetSoCt::call(pMa_ct: 'PO3', pNgay_Ct)`
- [ ] Check trung so_ct qua `AsChkSoCt` truoc khi save
- [ ] Recalc sau save: goi `AsReCalPO3`

### Phase F — Testing
- [ ] Unit test `AsPOGetPO3::procedureParams()` (chua co file test)
- [ ] Unit test `AsPOSavePO3::procedureParams()` (chua co file test)
- [ ] Unit test `AsPODeletePO3::procedureParams()` (chua co file test)
- [ ] Test route `po.vch.povchpo3` tra 200, render component `Po\Vch\Povchpo3`
- [ ] Test route `_simba-source/po/vch/povchpo3` redirect → `/simba/po/vch/povchpo3`
- [ ] Test list filter, tao moi header + detail + chi phi, sua, xoa, canh bao trung so_ct

## Khong thuoc pham vi (giai doan sau)

- Tab Thue GTGT (`ctlTaIn` / Tain) — vi tax control phuc tap, xu ly rieng neu Sếp yeu cau
- Button `cmdChon_dh` (chon PO1 lien ket) — phu thuoc PO1, lam sau khi PO1 san sang
- Form `frmPOVchPO3Find` (tim kiem PO3) + `frmPoVchPo3FindPO1` (tim PO1)
- Button `cmdThanh_toan` (thanh toan cong no) — lam rieng voi phase AP
- Post vao GL/Inventory (xu ly trong `asPOSavePO3` qua `AsPostPoPh3_*`) — da xu ly trong SP
- Print/In PDF hoa don mua (defer sang task rieng, can template chung)
- Phan quyen xem/sua/xoa PO3 (defer, can framework chung)
- Workflow trang thai (Draft/Approved/Posted) — defer

## Tieu chi hoan thanh

- 4 file shell cu `Muahang/Hoadonmua*` da xoa
- 4 file moi `Po/Vch/Povchpo3*` da tao + 8 partial views
- Route `_simba-source/po/vch/povchpo3` da uncomment trong `routes/web.php`, bind `Povchpo3::class`
- URL public `http://portal.diepxuan.corp/simba/po/vch/povchpo3` render component `Po\Vch\Povchpo3` thay vi `SimbaPage` shell
- Component list load tu `AsPOGetPH3` (khong Eloquent), co filter theo ngay_ct + pMa_kh
- Component edit load full 4 dataset tu `AsPOGetPO3`, co 3 tab (Header + Detail + Chi phi), auto-calc tien/CK/thue chinh xac
- Submit goi `AsPOSavePO3` thanh cong voi `pChiTiet` + `pChiPhi` JSON
- Matrix dong 70 + 262 da cap nhat mapping moi
- Tests pass, lint pass (`php -l` + `php-cs-fixer`), `SourceRouteCoverageTest` pass

## Ghi chu ky thuat

### Slug theo task 358 + SimbaMenuRouteMetadata
- PO3 menuid `10.10.14` → `menuIdSuffix('10.10.14') = '101014'`
- Helper `routeNameFor()` chi append suffix khi `$existing[$route]` trung → vi PO3 la duy nhat → route name giu `po.vch.povchpo3`
- URL slug giu `povchpo3` (khong suffix)
- KHONG tu y them suffix `101014` vi se lech voi server that va helper sinh tu dong

### Path/namespace quy uoc
- Pattern: `Po\<Kind>\<SlugCamelCase>` vi dau cham phan tach module/level
- File: `diepxuan/laravel-catalog/src/Http/Livewire/Po/Vch/Povchpo3.php`
- FQCN: `Diepxuan\Catalog\Http\Livewire\Po\Vch\Povchpo3`
- View path: `resources/views/po/vch/povchpo3.blade.php`
- Naming: `povchpo3` slug giu phan thuong (khong camel), class `Povchpo3` (CamelCase class, slug goc la nhu the)

### Bind SP thay vi Eloquent
- List: `AsPOGetPH3` (wrapper co san) tra Collection PoPh3 (giong task 008, 117)
- Edit load: `AsPOGetPO3` tra 4 dataset (header, detail, chi phi, hach toan) trong 1 lan goi
- Edit save: `AsPOSavePO3` voi `pChiTiet` + `pChiPhi` dang JSON
- Khong dung Eloquent `PoPh3::query()` vi task 008/117 da chuyen qua SP wrappers

### Currency precision
- VND → 0 decimals (round to integer)
- Foreign (USD/EUR/JPY...) → 4 decimals (`decimals=4`)
- Pattern: helper `formatMoney($value, $maNt)` tu `CatalogService` (neu co) hoac Livewire component `input-currency`

### Form tabs
- `x-nav-tabs` standard tu design system, moi tab la 1 section rieng (dung Livewire `pActiveTab`)
- Footer totals (Tab Header cuoi): bind readonly voi `t_*` fields, format theo `ma_nt`

### Phase bo (defer)
- Tab Tain (4th tab) → can xac dinh logic tax input (NET/GROSS, declaration period) truoc khi implement
- Hachtoan tab → can xac dinh auto-gen logic (debit TK vt + thue, credit TK pt) truoc khi implement

### Audit Status
- **Audit 1:** 2026-05-13 — spec tu simba-docs, sub-tasks chi tiet 8 phases
- **Audit 2:** 2026-05-14 — doi chieu PO3.md vs code that, sua bảng CSDL tu PO3/PO3CT/PO3CP/PO3HT → PoPh3/PoCt3/PoCp3
- **Audit 3:** 2026-05-14 07:44 — Sep chi dao: dung schema Simba ERP .NET, xoa POHMN doan bừa
- **Audit 4:** 2026-07-18 — doi ten file sang format phase 1 (`069-po-hoadon-mua-hang.md`), viet lai theo cau truc phase 1 (008, 117, 358, 359), confirm SP wrappers PO3 da co san
- **Audit 5 (nay):** 2026-07-18 — fetch server that `povchpo3` xac nhan (1) shell metadata dang render, (2) route name that la `po.vch.povchpo3` khong suffix, (3) shell cu `Muahang\Hoadonmua*` la dead code khong co route bind, (4) doi chieu DLL ↔ code cu ↔ code moi, lap Phase A-F checklist theo PR review #251
