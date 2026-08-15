# Task 069: POVchPO3 — Phiếu nhập mua hàng (Hóa đơn mua hàng PO3)

## Nhóm: PO (Purchase Order - Mua hàng)

## Mục tiêu

Chuyển đổi chứng từ **Phiếu nhập mua hàng (PO3)** từ Simba .NET `POVchPO3.dll` sang Livewire voucher mới, đặt theo pattern `Po/Rpt/Arrptbccn01Sl` (PR #247) — namespace path `Po/Vch/Povchpo3`, view `po/vch/povchpo3.blade.php`, bind SP `asPOGetPO3` / `asPOSavePO3` / `asPODeletePO3`.

## Trạng thái hiện tại

- **Status:** DONE — refactor Phase A-E hoàn tất, push lên PR #251 ngày 2026-07-18
- **Ngày audit/cập nhật:** 2026-07-21 (đồng bộ convention Input* + reset HTTT khi đổi NCC + flash khi SP empty)
- **Branch:** `task/251-po3-doc-rewrite`
- **URL public (server thật):** `http://portal.diepxuan.corp/simba/po/vch/povchpo3` — render component `Po\Vch\Povchpo3`
- **URL source (route binding):** `/_simba-source/po/vch/povchpo3`
- **DLL:** `POVchPO3.dll` (form `frmPOVchPO3`, namespace `AsiaErp.UserInterface`)
- **Route name (server thật):** `po.vch.povchpo3` (KHÔNG có suffix menuid — helper `SimbaMenuRouteMetadata::routeNameFor()` chỉ append `menuIdSuffix()` khi trùng tên)
- **Slug:** `povchpo3`
- **Path/namespace (sau refactor):** `Diepxuan\Catalog\Http\Livewire\Po\Vch\Povchpo3` (KHÔNG dùng shell `Muahang\Hoadonmua*` cũ)
- **View (sau refactor):** `diepxuan/laravel-catalog/resources/views/po/vch/povchpo3.blade.php`
- **Template tham chiếu:** `diepxuan/laravel-catalog/src/Http/Livewire/Po/Rpt/Arrptbccn01Sl.php` + `resources/views/po/rpt/arrptbccn01sl.blade.php` + `routes/web.php` dòng 243

## Phát hiện audit (2026-07-18)

### P1. Shell cũ `Muahang\Hoadonmua*` là dead code

| File | Trạng thái | Bằng chứng |
|------|-----------|-----------|
| `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/Hoadonmua.php` | 81 dòng, dùng `Eloquent PoPh3` cho list | KHÔNG có route bind nào trỏ vào |
| `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/HoadonmuaEdit.php` | 403 dòng, đã gọi SP `asPOGetPO3` + `asPOSavePO3` + `AsGetSttRec` | KHÔNG có route bind |
| `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua.blade.php` | 99 dòng | Dùng `route('muahang.hoadonmua.create')` — không có route name |
| `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua-edit.blade.php` | 350 dòng, có 3 tab giống form PO3 | Dùng `route('muahang.hoadonmua')` — không có route name |

Kiểm chứng: `grep -n "muahang.hoadonmua" diepxuan/laravel-catalog/routes/web.php` → 0 kết quả. Toàn bộ shell cũ đã chết, không user nào truy cập được qua Portal. **Đã xóa sạch ở Phase A ngày 2026-07-18.**

### P2. Server thật trước đó đang render shell metadata, không phải form thật

Wire:snapshot data từ `curl http://portal.diepxuan.corp/simba/po/vch/povchpo3` ngày 2026-07-18:

```
{"data":{"module":"po","kind":"vch","slug":"povchpo3","id":null,
 "target":[{"routeName":"po.vch.povchpo3",
            "metadata":[{"module":"PO","menuid":"10.10.14",
                         "source_type":"voucher",
                         "title":"Hoá đơn mua hàng trong nước",
                         "dll_name":"POVchPO3",
                         "command":"AsiaErp.UserInterface.frmPOVchPO3",
                         "code_name":"PO3","ma_ct":"PO3"}],
            "menuid":"10.10.14","component":null}], ...}
```

Component đang render: `catalog::system.simba-page` + `catalog::system.simba-page-metadata` (fallback khi route chưa uncomment component thật).

### P3. Route name trên server: `po.vch.povchpo3` (KHÔNG suffix menuid)

Trích `SimbaMenuRouteMetadata::routeNameFor()` (`diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php:198-217`):

```php
$route = "{$module}.{$kind}.{$slug}";        // 'po.vch.povchpo3'
if (!isset($existing[$route])) {
    return $route;                            // không append suffix vì chưa trùng
}
return "{$route}{$this->menuIdSuffix((string) $menu->menuid)}"; // chỉ append khi trùng
```

PO3 (menuid `10.10.14`, slug `povchpo3`) là duy nhất → không append → `po.vch.povchpo3`. Đúng theo task 358 logic. Task 069 viết "không suffix menuid vì vch 1-1 sysMenu" là chính xác, KHÔNG phải bỏ qua task 358.

### P4. Khớp với review PR #251

Anh SẾP nhận xét ngày 2026-07-18:

> "Muahang/Hoadonmua phai chuyen ve struct dung, tuong tu po/rpt/arrptbccn01sl.blade.php da lam. Route la po.vch.povchpo3, Muahang/Hoadonmua.php nen chuyen thanh po/vch/povchpo3.php."

Tương ứng:
- `Muahang/Hoadonmua.php` → `Po/Vch/Povchpo3.php`
- `Muahang/HoadonmuaEdit.php` → `Po/Vch/Povchpo3Edit.php`
- `muahang/hoadonmua.blade.php` → `po/vch/povchpo3.blade.php`
- `muahang/hoadonmua-edit.blade.php` → `po/vch/povchpo3-edit.blade.php`
- `web.php`: uncomment dòng 261, đổi component từ `SimbaPage::class` → `Povchpo3::class`/`Povchpo3Edit::class`
- Matrix `simba-router-menu-matrix.md`: dòng 70 + 262, đổi mapping `muahang.hoadonmua` → `po.vch.povchpo3`

## Đối chiếu DLL ↔ Code cũ ↔ Code mới

### Header fields (POVchPO3.md §3.1)

| Control (DLL) | DataBinding | Portal field | Code cũ `HoadonmuaEdit` | Code mới `Po\Vch\Povchpo3Edit` (đề xuất) |
|---|---|---|---|---|
| `txtMa_Kh` | `Ma_Kh` | `pMa_kh` | ✅ có (input-khachhang mode=nhacungcap) | giữ nguyên |
| `lblTen_Kh` | `Ten_Kh` | `pTen_kh` | ✅ có (autofill từ ArDmKh) | giữ nguyên |
| `txtDia_chi` | `Dia_chi` | `pDia_chi` | ✅ có | giữ nguyên |
| `txtMa_so_thue` | `Ma_so_thue` | `pMa_so_thue` | ✅ có | giữ nguyên |
| `txtNguoi_Gd` | `Nguoi_Gd` | `pNguoi_gd` | ✅ có | giữ nguyên |
| `txtDien_giai` | `Dien_giai` | `pDien_giai` | ✅ có | giữ nguyên |
| `txtNgay_lct` | `Ngay_lct` | `pNgay_lct` | ⚠️ thiếu (code cũ chỉ có `pNgay_ct`) | thêm `pNgay_lct` — đã có |
| `cboMa_NT` | `Ma_NT` | `pMa_nt` | ✅ có (select hardcode) | đổi sang Livewire component `input-ngoaite` (deferred: dùng plain input) |
| `txtTy_gia` | `Ty_gia` | `pTy_gia` | ✅ có | giữ nguyên |
| `txtSo_hd` | `So_hd` | `pSo_hd` | ✅ có | giữ nguyên |
| `txtNgay_hd` | `Ngay_hd` | `pNgay_hd` | ✅ có | giữ nguyên |
| `txtMa_Httt` | `Ma_Httt` | `pMa_httt` | ⚠️ thiếu input lookup | thêm input lookup (deferred: dùng plain input) |
| `txtTk_pt` | `Tk_pt` | `pTk_pt` | ⚠️ thiếu input lookup | Livewire `input-taikhoan` — đã có |
| `txtTk_thue` | `Tk_thue` | `pTk_thue` | ⚠️ thiếu input lookup | Livewire `input-taikhoan` — đã có |

### Tab Chi tiết (adgvDetail)

| Column (DLL) | Portal field | Code cũ | Code mới |
|---|---|---|---|
| `Ma_vt` | `pCt_ma_vt` | ✅ có (input hàng hóa) | giữ nguyên — dùng `input-indmvt` |
| `Ten_vt` | `pCt_ten_vt` | ✅ có | giữ nguyên |
| `Dvt` | `pCt_dvt` | ✅ có | giữ nguyên |
| `Ma_kho` | `pCt_ma_kho` | ⚠️ thiếu input lookup | thêm `input-indmkho` — đã có |
| `Ton_so_luong` | `pCt_ton_so_luong` | ❌ thiếu (code cũ không load tồn kho) | deferred (cần xác minh SP `AsGetTonKho` hoặc field từ `asPOGetCT3`) |
| `So_luong`, `Gia_nt0`, `Tien_nt0`, `Tl_ck`, `Ck_nt`, `Tien_cp_nt`, `Ts_gtgt`, `Thue_gtgt_nt` | tương ứng | ✅ có | giữ nguyên |
| `Gia0`, `Tien0`, `Ck`, `Tien_cp`, `Thue_gtgt` | readonly | ✅ có | giữ nguyên |

### Tab Chi phí (adgvChi_phi)

Code cũ đã có đầy đủ field (`ma_chiphi`, `ten_chi_phi`, `tien_cp_nt`, `ts_gtgt_cp`, ...). ⚠️ chưa có lookup input cho `ma_chiphi`. Giữ nguyên logic, bổ sung lookup (deferred: dùng plain input).

### Tab Hạch toán (adgvHach_toan)

❌ Code cũ KHÔNG có tab hạch toán (chỉ có `pActiveTab=0,1` cho Chi tiết + Chi phí). ⚠️ POVchPO3.md §6.3 nói rõ có tab Hạch toán với `tk_no`, `tk_co`, `tien`, `tien_nt`. Phase này mới thêm tab shell (deferred auto-gen logic).

### Tab Thuế (ctlTaIn / Tain)

❌ Code cũ KHÔNG có tab Tain. DLL có `cmdThanh_toan` + `ctlTaIn` (tax invoice input). **Defer** — phần phức tạp (tax input control riêng), xử lý task tiếp theo nếu Sếp yêu cầu.

## Cấu trúc dữ liệu

Theo schema Simba ERP (`simba-docs/decompiled/.../dbo/Tables/PoPh3.sql, PoCt3.sql, PoCp3.sql`):

### Bảng PoPh3 (Header)

**PK:** `ma_cty`, `stt_rec`. Trường chính: `ma_ct`='PO3', `ma_kh`, `dia_chi`, `nguoi_gd`, `ma_httt`, `tk_pt`, `tk_thue`, `dien_giai`, `so_seri`, `so_ct`, `ngay_ct`, `ngay_lct`, `kht_tain`, `so_pn`, `ngay_pn`, `so_hd`, `ngay_hd`, `ma_tt_po`, `han_ck`, `tl_ck`, `han_tt`, `ls_qh`, `ma_nt`, `ty_gia`, `t_tien_nt0`, `t_tien0`, `t_cp_nt`, `t_cp`, `t_thue_nt`, `t_thue`, `t_tt_nt`, `t_tt`, `t_so_luong`, `ck_st`, `sua_*`, `tao_tu_*`, `trang_thai`, `ghi_chu`, `post2gl`, `post2in`, `cdate/luser`.

### Bảng PoCt3 (Chi tiết VT)

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`. Trường chính: `ma_vt`, `ten_vt`, `tk_vt`, `tk_thue`, `ma_kho`, `ma_vitri`, `ma_lo`, `so_luong`, `so_luong_qd`, `gia_nt0`, `gia0`, `tien_nt0`, `tien0`, `tl_ck`, `ck_nt`, `ck`, `ts_gtgt`, `thue_gtgt_nt`, `thue_gtgt`, `tien_cp_nt`, `tien_cp`, `ma_bp`, `ma_phi`, `ma_spct`.

### Bảng PoCp3 (Chi phí)

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`. Trường chính: `ma_cp`, `ten_cp`, `tt_pb` (1=theo SL, 2=theo tiền), `tien_cp_nt`, `tien_cp`, `ts_gtgt`, `thue_gtgt_nt`, `thue_gtgt`, `tt_nt`, `tt`, `ma_bp`, `ma_phi`, `ma_spct`, `ma_lo`.

## SP wrappers đã có (laravel-simba)

| Wrapper | SP | Params chính | Mục đích |
|---------|----|----|--------|
| `AsPOGetPO3` | `asPOGetPO3` | `pMa_cty`, `pStt_rec` | Lấy header + detail + chi phí + hạch toán |
| `AsPOSavePO3` | `asPOSavePO3` | 50+ params bao gồm `pChiTiet`, `pChiPhi` | Lưu đầy đủ PO3 |
| `AsPODeletePO3` | `asPODeletePO3` | `pMa_cty`, `pStt_rec` | Xóa PO3 |
| `AsPOChkRightStatusPO3` | `asPOChkRightStatusPO3` | | Quyền + trạng thái |
| `AsReCalPO3` | `asReCalPO3` | | Recalc |
| `AsReCalPO34Relate` | `asReCalPO34Relate` | | Recalc related |
| `AsAPUpdTt_SoDuPo3` | `asAPUpdTt_SoDuPo3` | | Cập nhật AP balance |
| `AsPOGetPH3/Ins/Upd/Del` | CRUD `PoPh3` | | Header CRUD |
| `AsPOGetCT3/Ins/Del` | CRUD `PoCt3` | | Detail CRUD |
| `AsPOGetCP3/Ins/Del` | CRUD `PoCp3` | | Chi phí CRUD |
| `AsPOGetChiPhi` | `asPOGetChiPhi` | | Lấy chi phí |
| `AsPOGetHachToan` | `asPOGetHachToan` | | Lấy hạch toán |
| `AsChkSoCt` / `AsGetSoCt` / `AsGetSttRec` | chung | `pMa_ct='PO3'` | Sinh + check so_ct, stt_rec |

## Data Access Map

| UI/data action | Code name | Simba table | Source | SP wrapper |
|---|---|---|---|---|
| List header | filter range | `PoPh3` | `sysMenu 10.10.14` + `sysVoucherInfo` | `AsPOGetPH3` (list) hoặc Eloquent `PoPh3` (đề xuất mặc định) |
| Get 1 header | `pStt_rec` | `PoPh3` | | `asPOGetPO3` |
| Get chi tiết VT | `pStt_rec` | `PoCt3` | | `asPOGetCT3` (trả nhiều dòng) |
| Get chi phí | `pStt_rec` | `PoCp3` | | `asPOGetCP3` |
| Get hạch toán | `pStt_rec` | (sinh) | | `asPOGetHachToan` |
| Lookup NCC | `MA_NCC` isNcc=1 | `ARDMKH` | `sysDictionaryInfo` | `asARGetDMKH` |
| Lookup VT | `MA_VT` | `INDMVT` | `sysDictionaryInfo` | `asINGetDMVT` |
| Lookup Kho | `MA_KHO` | `INDMKHO` | `sysDictionaryInfo` | `asINGetDMKHO` |
| Lookup HTTT | `MA_HTTT` | `SIDMHTTT` | `sysDictionaryInfo` | `asSIGetDMHTTT` |
| Lookup Chi phí | `MA_CHIPHI` | `PODMCP` | `sysDictionaryInfo` | `asPOGetDMCP` |
| Lookup TK | `MA_TK` | `GLDMTK` | `sysDictionaryInfo` | `asGLGetDMTK` |
| Lookup NT | `MA_NT` | `SIDMNT` | `sysDictionaryInfo` | `asSIGetDMNT` |
| Lookup Lô | `MA_LO` | `INDMLO` | `sysDictionaryInfo` | `asINGetDMLO` |
| Lookup BP | `MA_BP` | `GLDMBP` | `sysDictionaryInfo` | `asGLGetDMBP` |
| Lookup Phí | `MA_PHI` | `GLDMPHI` | `sysDictionaryInfo` | `asGLGetDMPHI` |
| Lookup SPCT | `MA_SPCT` | `INDMSPCT` | `sysDictionaryInfo` | `asINGetDMSPCT` |
| Sinh stt_rec | | | | `AsGetSttRec::call(pMa_ct: 'PO3')` |
| Sinh so_ct | | | | `AsGetSoCt::call(pMa_ct: 'PO3', pNgay_Ct)` |
| Check trùng so_ct | | | | `AsChkSoCt::call(pMa_ct, pStt_rec, pSo_ct, pNgay_Ct)` |
| Save full | | `PoPh3` + `PoCt3` + `PoCp3` | | `asPOSavePO3` |
| Recalc | | | | `AsReCalPO3` |
| Delete | | | | `asPODeletePO3` |

## Verification checklist

### Phase A — Xóa shell cũ (DONE 2026-07-18)
- [x] Xóa `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/Hoadonmua.php` (-81 dòng)
- [x] Xóa `diepxuan/laravel-catalog/src/Http/Livewire/Muahang/HoadonmuaEdit.php` (-403 dòng)
- [x] Xóa `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua.blade.php` (-99 dòng)
- [x] Xóa `diepxuan/laravel-catalog/resources/views/muahang/hoadonmua-edit.blade.php` (-350 dòng)
- [x] Grep toàn project `muahang.hoadonmua` → 0 kết quả
- [x] Grep toàn project `Muahang\\Hoadonmua` → 0 kết quả

### Phase B — Livewire component mới (DONE 2026-07-18)
- [x] Tạo `diepxuan/laravel-catalog/src/Http/Livewire/Po/Vch/Povchpo3.php` (103 dòng, list)
- [x] Tạo `diepxuan/laravel-catalog/src/Http/Livewire/Po/Vch/Povchpo3Edit.php` (port + sửa, 415 dòng)
- [x] Component list: dùng `AsPOGetPH3` (SP wrapper)
- [x] Component edit: dùng `AsPOGetPO3` (full 4 dataset) thay vì 4 SP riêng
- [x] `php -l` pass cho cả 2 file

### Phase C — View theo pattern arrptbccn01sl (DONE 2026-07-18, việt hóa 2026-07-19)
- [x] Tạo `diepxuan/laravel-catalog/resources/views/po/vch/povchpo3.blade.php` (126 dòng, việt hóa)
- [x] Tạo `diepxuan/laravel-catalog/resources/views/po/vch/povchpo3-edit.blade.php` (211 dòng, việt hóa)
- [x] Tạo partial `_grid-chitiet.blade.php` (47 dòng, việt hóa)
- [x] Tạo partial `_grid-chiphi.blade.php` (45 dòng, việt hóa)
- [x] Tuân thủ `docs/DESIGN.md` (x-nav-tabs, grid spacing, focus ring, button style)
- [x] Dùng component có sẵn: `input-khachhang`, `input-indmvt`, `input-indmkho`, `input-taikhoan`
- [x] Deferred: `input-httt`, `input-chiphi`, `input-ngoaite` lookup (dùng plain input tạm)

### Phase D — Routes + Matrix (DONE 2026-07-18)
- [x] `routes/web.php` dòng 263-265: uncomment + thêm 3 routes (`po.vch.povchpo3`, `.create`, `.edit`) với `Povchpo3::class`/`Povchpo3Edit::class`
- [x] `docs/project/simba-router-menu-matrix.md` dòng 70 + 262: cập nhật mapping `po.vch.povchpo3` + `Po\Vch\Povchpo3`
- [x] Slug: KHÔNG có suffix `101014` (PO3 là 1-1 sysMenu → helper `routeNameFor()` không append)

### Phase E — Validation & Business Logic (DONE 2026-07-19, việt hóa)
- [x] Validate required: `ma_kh`, `so_hd`, `ngay_hd`, `ngay_ct` (4 message việt hóa)
- [x] Auto-calc tiền hàng: `tien_nt0 = so_luong * gia_nt0`
- [x] Auto-calc chiết khấu: `ck_nt = tien_nt0 * tl_ck / 100`
- [x] Auto-calc thuế GTGT: `thue_gtgt_nt = (tien_nt0 - ck_nt + tien_cp_nt) * ts_gtgt / 100`
- [x] Auto-fill NCC info (ten_kh, dia_chi, ma_so_thue) khi chọn `ma_kh`
- [x] Sinh `stt_rec` qua `AsGetSttRec::call(pMa_ct: 'PO3')` khi tạo mới
- [x] Sinh `so_ct` qua `AsGetSoCt::call(pMa_ct: 'PO3', pNgay_Ct)` (Vietnamese flash messages)
- [x] Auto-fill `tk_pt`, `tk_thue` từ `ma_httt` lookup (PR #251: InputHttt component + `updatedPMaHttt` hook qua `AsGetDMHTTT`)
- [ ] Phân bổ chi phí theo `tt_pb`: 1 = theo số lượng, 2 = theo tiền hàng (button "Phân bổ") — phase sau
- [ ] Check trùng so_ct qua `AsChkSoCt` trước khi save
- [ ] Recalc sau save: gọi `AsReCalPO3`

### Phase F — Testing (DONE 2026-07-20, PR #255)
- [x] Unit test `AsPOGetPO3Test` (4 tests, reflection-based param mapping, DB skip khi không có sqlsrv)
- [x] Unit test `AsPOSavePO3Test` (10 tests, kiểm tra 50+ parameters + defaults + `pRet` output)
- [x] Unit test `AsPODeletePO3Test` (phủ signature + DB skip)

Xem: `diepxuan/laravel-simba/tests/Unit/As*Test.php`
- [ ] Test route `po.vch.povchpo3` trả 200, render component `Po\Vch\Povchpo3`
- [ ] Test route `_simba-source/po/vch/povchpo3` redirect → `/simba/po/vch/povchpo3`
- [ ] Test list filter, tạo mới header + detail + chi phí, sửa, xóa, cảnh báo trùng so_ct
- [ ] Test phân bổ chi phí

## Không thuộc phạm vi (giai đoạn sau)

- Tab Thuế GTGT (`ctlTaIn` / Tain) — vì tax control phức tạp, xử lý riêng nếu Sếp yêu cầu
- Auto-gen logic tab Hạch toán (debit TK vt + thuế, credit TK pt) — defer
- Button `cmdChon_dh` (chọn PO1 liên kết) — phụ thuộc PO1, làm sau khi PO1 sẵn sàng
- Form `frmPOVchPO3Find` (tìm kiếm PO3) + `frmPoVchPo3FindPO1` (tìm PO1)
- Button `cmdThanh_toan` (thanh toán công nợ) — làm riêng với phase AP
- Post vào GL/Inventory (xử lý trong `asPOSavePO3` qua `AsPostPoPh3_*`) — đã xử lý trong SP
- Print/In PDF hóa đơn mua (defer sang task riêng, cần template chung)
- Phân quyền xem/sửa/xóa PO3 (defer, cần framework chung)
- Workflow trạng thái (Draft/Approved/Posted) — defer

## Tiêu chí hoàn thành

- [x] 4 file shell cũ `Muahang/Hoadonmua*` đã xóa (Phase A)
- [x] 4 file mới `Po/Vch/Povchpo3*` + 2 partial đã tạo (Phase B + C)
- [x] Route `_simba-source/po/vch/povchpo3` đã uncomment + bind `Povchpo3::class` (Phase D)
- [x] Matrix dòng 70 + 262 đã cập nhật mapping mới (Phase D)
- [x] CI: 14/14 jobs SUCCESS trên PR #251
- [x] UI việt hóa (có dấu) trên view + message PHP ngày 2026-07-19
- [ ] Unit tests + E2E (deferred Phase F)

## Ghi chú kỹ thuật

### Slug theo task 358 + SimbaMenuRouteMetadata
- PO3 menuid `10.10.14` → `menuIdSuffix('10.10.14') = '101014'`
- Helper `routeNameFor()` chỉ append suffix khi `$existing[$route]` trùng → vì PO3 là duy nhất → route name giữ `po.vch.povchpo3`
- URL slug giữ `povchpo3` (không suffix)
- KHÔNG tự ý thêm suffix `101014` vì sẽ lệch với server thật và helper sinh tự động

### Path/namespace quy ước
- Pattern: `Po\<Kind>\<SlugCamelCase>` với dấu chấm phân tách module/level
- File: `diepxuan/laravel-catalog/src/Http/Livewire/Po/Vch/Povchpo3.php`
- FQCN: `Diepxuan\Catalog\Http\Livewire\Po\Vch\Povchpo3`
- View path: `resources/views/po/vch/povchpo3.blade.php`
- Naming: `povchpo3` slug giữ phân thường (không camel), class `Povchpo3` (CamelCase class, slug gốc là như thế)

### Bind SP thay vì Eloquent
- List: `AsPOGetPH3` (wrapper có sẵn) trả Collection PoPh3 (giống task 008, 117)
- Edit load: `AsPOGetPO3` trả 4 dataset (header, detail, chi phí, hạch toán) trong 1 lần gọi
- Edit save: `AsPOSavePO3` với `pChiTiet` + `pChiPhi` dạng JSON
- Không dùng Eloquent `PoPh3::query()` vì task 008/117 đã chuyển qua SP wrappers

### Currency precision
- VND → 0 decimals (round to integer)
- Ngoại tệ (USD/EUR/JPY...) → 4 decimals (`decimals=4`)
- Pattern: helper `formatMoney($value, $maNt)` từ `CatalogService` (nếu có) hoặc Livewire component `input-currency`

### UI tiếng Việt có dấu (2026-07-19)
- View blade (label, button, placeholder, message): tiếng Việt có dấu đầy đủ
- PHP `session()->flash()` message: tiếng Việt có dấu
- Laravel validation messages (`'pMa_kh.required' => 'Nhà cung cấp không được trống'`): tiếng Việt có dấu
- PHP identifier / class member / DB field / slug / route name: giữ nguyên ASCII (theo quy ước codebase)

### Form tabs
- `x-nav-tabs` standard từ design system, mỗi tab là 1 section riêng (dùng Livewire `pActiveTab`)
- 3 tab: Thông tin chung + Chi tiết / Chi phí / Hạch toán (deferred)

### Phase bỏ (defer)
- Tab Tain (4th tab) → cần xác định logic tax input (NET/GROSS, declaration period) trước khi implement
- Hạch toán tab → cần xác định auto-gen logic (debit TK vt + thuế, credit TK pt) trước khi implement
- Lookup `input-httt`, `input-chiphi`, `input-ngoaite` → cần tạo Livewire component riêng trong task khác

### Audit Status
- **Audit 1:** 2026-05-13 — spec từ simba-docs, sub-tasks chi tiết 8 phases
- **Audit 2:** 2026-05-14 — đối chiếu PO3.md vs code thật, sửa bảng CSDL từ PO3/PO3CT/PO3CP/PO3HT → PoPh3/PoCt3/PoCp3
- **Audit 3:** 2026-05-14 07:44 — Sếp chỉ đạo: dùng schema Simba ERP .NET, xóa POHMN đoán bừa
- **Audit 4:** 2026-07-18 — đổi tên file sang format phase 1 (`069-po-hoadon-mua-hang.md`), viết lại theo cấu trúc phase 1 (008, 117, 358, 359), confirm SP wrappers PO3 đã có sẵn
- **Audit 5:** 2026-07-18 — fetch server thật `povchpo3` xác nhận (1) shell metadata đang render, (2) route name thật là `po.vch.povchpo3` không suffix, (3) shell cũ `Muahang\Hoadonmua*` là dead code không có route bind, (4) đối chiếu DLL ↔ code cũ ↔ code mới, lập Phase A-F checklist theo PR review #251
- **Audit 6:** 2026-07-18 — Phase A-E refactor code: xóa shell cũ, tạo `Po/Vch/Povchpo3*` + view + partial, uncomment route, update matrix. Push lên PR #251 commit `6f58a66fc`. CI 14/14 SUCCESS.
- **Audit 7:** 2026-07-21 — Đồng bộ convention InputHttt/Chiphi/Ngoaite dùng `#[Modelable]` + `HasKsdFilter` trait; reset `pMa_httt/pTk_pt/pTk_thue` khi clear NCC; flash warning khi `fillTaiKhoanFromHttt` trả empty; đánh tick `[x]` Phase E auto-fill HTTT + Phase F tests đã làm ở PR #255.
