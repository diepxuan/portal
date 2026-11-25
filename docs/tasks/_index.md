# Tasks Index

> Tự động sinh bởi `scripts/gen-tasks-index.php`. **Không sửa tay** — sửa script rồi chạy lại.

**Lưu ý:** Task đã xong phase port được tách riêng trong `phase 1/` — xem [`phase 1/_index.md`](phase%201/_index.md)
(giai đoạn phát triển thêm chức năng cho Portal).

Task **hạ tầng/công cụ nội bộ Portal** (đăng nhập, dashboard, task board...) nằm riêng trong
[`portaltask/_index.md`](portaltask/_index.md), không trộn với task port SimbaERP.

## Tổng quan

| Module | Files | DONE | SHELL_ONLY | PENDING | Khác |
|---|---:|---:|---:|---:|---:|
| AP — Công nợ phải trả | 5 | 1 | 4 | 0 | 0 |
| AR — Công nợ phải thu | 14 | 3 | 11 | 0 | 0 |
| CA — Tiền mặt & Ngân hàng | 16 | 3 | 12 | 0 | 1 |
| CO — Sản xuất | 19 | 0 | 19 | 0 | 0 |
| FA — Tài sản cố định | 39 | 0 | 39 | 0 | 0 |
| GL — Sổ cái tổng hợp | 104 | 13 | 90 | 1 | 0 |
| IN — Tồn kho | 30 | 3 | 27 | 0 | 0 |
| PO — Đơn hàng mua | 17 | 7 | 10 | 0 | 0 |
| SI — System Integration | 33 | 0 | 25 | 4 | 4 |
| SO — Đơn hàng bán | 44 | 6 | 37 | 1 | 0 |
| System — Framework & cross-link | 3 | 2 | 0 | 0 | 1 |
| **Tổng** | **324** | **38** | **274** | **6** | **6** |

> **SHELL_ONLY** = có route anchor/metadata shell nhưng **chưa có màn hình CRUD**, không tính là DONE.

## AP — Công nợ phải trả

| ID | File | DLL | Status |
|---|---|---|---|
| 017 | `017-ap-phan-bo-thanh-toan.md` | APPost2TT.dll | SHELL_ONLY |
| 018 | `018-ap-dieu-khoan-thanh-toan.md` | APTT.dll | SHELL_ONLY |
| 019 | `019-ap-bang-ke-hoa-don-phai-tra.md` | APRptBK01.dll, APRptBK02.dll, APRptBK03.dll | SHELL_ONLY |
| 020 | `020-ap-bu-tru-cong-no-phai-tra.md` | ApVchAP4.dll | SHELL_ONLY |
| 371 | `371-ap-so-chi-tiet-cong-no-mot-nha-cung-cap-10-30-11.md` | ARRptBCCN01.dll (form dùng chung cho AR và AP, menuid phân biệt) | DONE |

## AR — Công nợ phải thu

| ID | File | DLL | Status |
|---|---|---|---|
| 002 | `002-ar-danh-muc-nhom-khach-hang.md` | ARDMNHKH.dll | SHELL_ONLY |
| 004 | `004-ar-bao-cao-cong-no-khach-hang.md` | ARCDKH.dll | SHELL_ONLY |
| 005 | `005-ar-dieu-khoan-thanh-toan.md` | ARTT.dll | SHELL_ONLY |
| 006 | `006-ar-phan-bo-thanh-toan.md` | ARPost2TT.dll | SHELL_ONLY |
| 007 | `007-ar-tinh-lai-so-du-khach-hang.md` | ARRecalCustBalance.dll | SHELL_ONLY |
| 009 | `009-ar-bao-cao-cong-no-phan-loai.md` | ARRptBCCN02.dll, ARRptBCCN03.dll | SHELL_ONLY |
| 010 | `010-ar-bao-cao-cong-no-nhom-chi-tiet.md` | ARRptBCCN04.dll | DONE |
| 011 | `011-ar-bao-cao-doi-chieu-cong-no.md` | ARRptBCCN05.dll | DONE |
| 012 | `012-ar-bao-cao-cong-no-han-ky.md` | ARRptBCCN06.dll | SHELL_ONLY |
| 013 | `013-ar-bang-ke-chung-tu-ban-hang.md` | ARRptBK01.dll | DONE |
| 014 | `014-ar-bang-ke-cong-no-han.md` | ARRptBK02.dll | SHELL_ONLY |
| 015 | `015-ar-bang-ke-chung-tu-thanh-toan.md` | ARRptBK03.dll | SHELL_ONLY |
| 016 | `016-ar-chung-tu-hach-toan-cong-no.md` | ARVchAR4.dll | SHELL_ONLY |
| 158 | `158-ar-rpt-f5-bccn01a-drilldown.md` | ArRptF5BCCN01a.dll | SHELL_ONLY |

## CA — Tiền mặt & Ngân hàng

| ID | File | DLL | Status |
|---|---|---|---|
| 021 | `021-ca-danh-muc-khe-uoc.md` | CADMKU.dll | SHELL_ONLY |
| 022 | `022-ca-cong-no-khe-uoc.md` | CACDKU.dll | SHELL_ONLY |
| 023 | `023-ca-cong-no-phan-cap.md` | CACDPC.dll | SHELL_ONLY |
| 024 | `024-ca-tinh-lai-khe-uoc.md` | CACalLaiKu.dll | SHELL_ONLY |
| 025 | `025-ca-xoa-lai-khe-uoc.md` | CADelLaiKu.dll | SHELL_ONLY |
| 026 | `026-ca-lai-khe-uoc.md` | CALAIKU.dll | SHELL_ONLY |
| 027 | `027-ca-voucher-thu-tien.md` | CAVchCA1.dll | SHELL_ONLY |
| 028 | `028-ca-voucher-chi-tien.md` | CAVchCA2.dll | SHELL_ONLY |
| 029 | `029-ca-voucher-bao-no-ngan-hang.md` | CAVchCA3.dll | NOT A TASK (meta/doc file, skipped) |
| 030 | `030-ca-voucher-bao-co-uy-nhiem-chi.md` | CAVchCA4.dll | SHELL_ONLY |
| 031 | `031-ca-voucher-khe-uoc-vay.md` | CAVchCA5.dll | SHELL_ONLY |
| 032-038 | `032-038-ca-bao-cao-tien-mat-ngan-hang.md` | CARptTMNH01.dll - CARptTMNH07.dll | SHELL_ONLY |
| 159-165 | `159-165-ca-rpt-tmnh-bao-cao-tien-mat-ngan-hang.md` | CARptTMNH01.dll - CARptTMNH07.dll | SHELL_ONLY |
| 332 | `332-ca-rpt-tmnh06.md` | CARptTMNH06.dll | DONE |
| 335 | `335-ca-rpt-nkc03-042008.md` | GlRptNkc03.dll | DONE |
| 336 | `336-ca-rpt-nkc03-042011.md` | GlRptNkc03.dll | DONE |

## CO — Sản xuất

| ID | File | DLL | Status |
|---|---|---|---|
| 039 | `039-co-dinh-muc-bom.md` | CODMBOM.dll | SHELL_ONLY |
| 040 | `040-co-dinh-muc-chi-tiet.md` | CODD1.dll | SHELL_ONLY |
| 041 | `041-co-danh-muc-nhom-san-pham.md` | CODMNHSPCT.dll | SHELL_ONLY |
| 042 | `042-co-danh-muc-but-toan-phan-bo.md` | CODMPB.dll | SHELL_ONLY |
| 166 | `166-co-dmbom-dinh-muc-nguyen-vat-lieu.md` | CODMBOM_.dll | SHELL_ONLY |
| 167 | `167-co-dmspct-danh-muc-san-pham-cong-trinh.md` | CODMSPCT.dll | SHELL_ONLY |
| 168-180 | `168-180-co-ky-thuat-san-xuat.md` | COGDBGT, COLK, COPB, CORptGt01-03, CoCalcCost, CoDMCPTT, CoDelPostCP2GL, CoNgungKHCPTT, CoPostCPTT2GL, CoRptCTPBCPTT, CoRptKHCPTT | SHELL_ONLY |
| 342 | `342-co-lien-ket-ket-chuyen.md` | COLK.dll | SHELL_ONLY |
| 343 | `343-co-phieu-bao.md` | COPB.dll | SHELL_ONLY |
| 344 | `344-co-rpt-gt01.md` | CORptGt01.dll | SHELL_ONLY |
| 345 | `345-co-rpt-gt02.md` | CORptGt02.dll | SHELL_ONLY |
| 346 | `346-co-rpt-gt03.md` | CORptGt03.dll | SHELL_ONLY |
| 347 | `347-co-tinh-gia-thanh.md` | CoCalcCost.dll | SHELL_ONLY |
| 348 | `348-co-danh-muc-chi-phi-tap-trung.md` | CoDMCPTT.dll | SHELL_ONLY |
| 349 | `349-co-xoa-post-cp-sang-gl.md` | CoDelPostCP2GL.dll | SHELL_ONLY |
| 350 | `350-co-ngung-khai-bao-cp.md` | CoNgungKHCPTT.dll | SHELL_ONLY |
| 351 | `351-co-post-chi-phi-tap-trung-sang-gl.md` | CoPostCPTT2GL.dll | SHELL_ONLY |
| 352 | `352-co-bao-cao-chi-tiet-pb.md` | CoRptCTPBCPTT.dll | SHELL_ONLY |
| 353 | `353-co-bao-cao-khai-bao-cp.md` | CoRptKHCPTT.dll | SHELL_ONLY |

## FA — Tài sản cố định

| ID | File | DLL | Status |
|---|---|---|---|
| 118 | `118-FA-baocao-BCTS09.md` | FARptBCTS09.dll | SHELL_ONLY |
| 119 | `119-FA-tinh-khauhao-tscd.md` | FACalKHTS.dll | SHELL_ONLY |
| 120 | `120-FA-baocao-BCTS07.md` | FARptBCTS07.dll | SHELL_ONLY |
| 121 | `121-FA-baocao-phantich-02.md` | FARptBCPT02.dll | SHELL_ONLY |
| 122 | `122-FA-baocao-phantich-05.md` | FARptBCPT05.dll | SHELL_ONLY |
| 123 | `123-FA-so-tscd.md` | FARptSoTSCD.dll | SHELL_ONLY |
| 124 | `124-FA-dinhgia-tscd.md` | FADGTS.dll | SHELL_ONLY |
| 125 | `125-FA-bangphanbo-khauhao-nhomts.md` | FABHCC.dll | SHELL_ONLY |
| 126 | `126-FA-baocao-phantich-03.md` | FARptBCPT03.dll | SHELL_ONLY |
| 127 | `127-FA-baocao-tanggiam-tscd.md` | FARptBCTS06.dll | SHELL_ONLY |
| 128 | `128-FA-the-tscd.md` | FARptBCTS01.dll | SHELL_ONLY |
| 129 | `129-FA-danhmuc-bophan-sudung.md` | FADMBPSD.dll | SHELL_ONLY |
| 130 | `130-FA-baocao-BCTS08.md` | FARptBCTS08.dll | SHELL_ONLY |
| 131 | `131-FA-baoho-chieucu.md` | FADGTS.dll (shared voi task 124) | SHELL_ONLY |
| 132 | `132-FA-danhmuc-nhom-taisan.md` | FADMNHTS.dll | SHELL_ONLY |
| 133 | `133-FA-thoikhoan-khauhao-tscd.md` | FAThoiKHTS.dll | SHELL_ONLY |
| 134 | `134-FA-giam-tscd.md` | FAGiamTS.dll | SHELL_ONLY |
| 135 | `135-FA-xoa-chungtu-fa-gl.md` | FADelTS2GL.dll | SHELL_ONLY |
| 136 | `136-FA-xoa-tscd-sang-gl.md` | FADelCC2GL.dll | SHELL_ONLY |
| 137 | `137-FA-baocao-phantich-09.md` | FARptBCPT09.dll | SHELL_ONLY |
| 236 | `236-fa-phan-bo-cong-cu-dung-cu.md` | FAPostCC2GL.dll | SHELL_ONLY |
| 237 | `237-fa-phan-bo-tai-san-co-dinh.md` | FAPostTS2GL.dll | SHELL_ONLY |
| 238 | `238-fa-chuyen-tai-san.md` | FAChuyenTS.dll | SHELL_ONLY |
| 239 | `239-fa-xoa-khau-hao-tai-san.md` | FADelKHTS.dll | SHELL_ONLY |
| 240 | `240-fa-dieu-chinh-khau-hao-tai-san.md` | FAAdjustKHTS.dll | SHELL_ONLY |
| 241 | `241-fa-danh-muc-cong-cu-dung-cu.md` | FADMCC.dll | SHELL_ONLY |
| 242 | `242-fa-danh-muc-ly-do-tang-giam-ts.md` | FADMLDTS.dll | SHELL_ONLY |
| 243 | `243-fa-danh-muc-nguon-von.md` | FADMNV.dll | SHELL_ONLY |
| 244 | `244-fa-danh-muc-tai-san-co-dinh.md` | FADMTS.dll | SHELL_ONLY |
| 245 | `245-fa-bao-cao-phan-tich-ts-01.md` | FARptBCPT01.dll | SHELL_ONLY |
| 246 | `246-fa-bao-cao-phan-tich-ts-06.md` | FARptBCPT06.dll | SHELL_ONLY |
| 247 | `247-fa-bao-cao-phan-tich-ts-07.md` | FARptBCPT07.dll | SHELL_ONLY |
| 248 | `248-fa-bao-cao-phan-tich-ts-08.md` | FARptBCPT08.dll | SHELL_ONLY |
| 249 | `249-fa-bao-cao-phan-tich-ts-cc-10.md` | FARptBCPT10.dll | SHELL_ONLY |
| 250 | `250-fa-bao-cao-bien-dong-ts-04.md` | FARptBCTS04.dll | SHELL_ONLY |
| 251 | `251-fa-bao-cao-bien-dong-ts-05.md` | FARptBCTS05.dll | SHELL_ONLY |
| 252 | `252-fa-so-theo-doi-tscd-ccdc.md` | FARptSoSD.dll | SHELL_ONLY |
| 253 | `253-fa-kiem-ke-tai-san.md` | Fakkts.dll | SHELL_ONLY |
| 341 | `341-FA-baocao-phantich-tscd-01.md` | FARptBCPT01.dll | SHELL_ONLY |

## GL — Sổ cái tổng hợp

| ID | File | DLL | Status |
|---|---|---|---|
| 049 | `049-GL-bangcan-doi-phat-sinh.md` | GLRptBCPT01.dll | SHELL_ONLY |
| 138 | `138-GL-chuyen-so-lieu-so-cai.md` | GLPost2GL.dll | SHELL_ONLY |
| 139 | `139-GL-baocao-BCTCCDTB02.md` | GLRptBCTCCDTB02.dll | SHELL_ONLY |
| 140 | `140-GL-bieumau-BCTC-CTMV02.md` | GLMAUBCTCTMV02.dll | SHELL_ONLY |
| 141 | `141-GL-baocao-F5-CTGS03.md` | GLRptF5CTGS03.dll | SHELL_ONLY |
| 142 | `142-GL-baocao-BCTCCDTF03B.md` | GLRptBCTCCDTF03B.dll | SHELL_ONLY |
| 143 | `143-GL-bieumau-BCTC-MVI211.md` | GLMAUBCTCTMVI211.dll | SHELL_ONLY |
| 144 | `144-GL-baocao-tonghop-01.md` | GLRptTH01.dll | SHELL_ONLY |
| 145 | `145-GL-bieumau-BCTC-MV21.md` | GLMAUBCTCTMV21.dll | SHELL_ONLY |
| 147 | `147-GL-sodu-dauky-taikhoan.md` | GLCDTK.dll | SHELL_ONLY |
| 148 | `148-GL-bieumau-BCTC-MV22c.md` | GLMAUBCTCTMV22c.dll | SHELL_ONLY |
| 149 | `149-GL-baocao-BCT03.md` | GLRptBCT03.dll | SHELL_ONLY |
| 150 | `150-GL-bieumau-BCTC-MV22d.md` | GLMAUBCTCTMV22d.dll | SHELL_ONLY |
| 151 | `151-GL-bieumau-BCTC-CTMI.md` | GLMAUBCTCTMI.dll | SHELL_ONLY |
| 152 | `152-GL-bieumau-BCTC-MV13.md` | GLMAUBCTCTMV13.dll | SHELL_ONLY |
| 153 | `153-GL-bieumau-BCTC-MV20C.md` | GLMAUBCTCTMV20C.dll | SHELL_ONLY |
| 154 | `154-GL-baocao-F5-BCTCCR01.md` | GLRptBCTCCR01.dll | SHELL_ONLY |
| 157 | `157-GL-bieumau-BCTC-MV22A.md` | GLMAUBCTCTMV22A.dll | SHELL_ONLY |
| 254 | `254-gl-danh-muc-du-toan-ngan-sach.md` | GLBudget.dll | SHELL_ONLY |
| 255 | `255-gl-dang-ky-chung-tu-ghi-so.md` | GLDKCTGS.dll | SHELL_ONLY |
| 256 | `256-gl-danh-muc-chung-tu-ghi-so.md` | GLDMCTGS.dll | SHELL_ONLY |
| 257 | `257-gl-danh-muc-danh-gia-ty-gia.md` | GLDMDGTG.dll | SHELL_ONLY |
| 258 | `258-gl-danh-muc-ket-chuyen-tu-dong.md` | GLDMKC.dll | SHELL_ONLY |
| 259 | `259-gl-mau-bctc-mix.md` | GLMAUBCTCTMIX.dll | SHELL_ONLY |
| 260 | `260-gl-mau-bctc-mv01.md` | GLMAUBCTCTMV01.dll | SHELL_ONLY |
| 261 | `261-gl-mau-bctc-mv03.md` | GLMAUBCTCTMV03.dll | SHELL_ONLY |
| 262 | `262-gl-mau-bctc-mv08.md` | GLMAUBCTCTMV08.dll | SHELL_ONLY |
| 263 | `263-gl-mau-bctc-mv09.md` | GLMAUBCTCTMV09.dll | SHELL_ONLY |
| 264 | `264-gl-mau-bctc-mv10.md` | GLMAUBCTCTMV10.dll | SHELL_ONLY |
| 265 | `265-gl-mau-bctc-mv11.md` | GLMAUBCTCTMV11.dll | SHELL_ONLY |
| 266 | `266-gl-mau-bctc-mv12.md` | GLMAUBCTCTMV12.dll | SHELL_ONLY |
| 267 | `267-gl-mau-bctc-mv22b.md` | GLMAUBCTCTMV22b.dll | SHELL_ONLY |
| 268 | `268-gl-mau-bctc-mv23.md` | GLMAUBCTCTMV23.dll | SHELL_ONLY |
| 269 | `269-gl-mau-bctc-mv24.md` | GLMAUBCTCTMV24.dll | SHELL_ONLY |
| 270 | `270-gl-mau-bctc-mvi.md` | GLMAUBCTCTMVI.dll | SHELL_ONLY |
| 271 | `271-gl-mau-bctc-mvi02b.md` | GLMAUBCTCTMVI02B.dll | SHELL_ONLY |
| 272 | `272-gl-mau-bctc-mvi02a.md` | GLMAUBCTCTMVI02a.dll | SHELL_ONLY |
| 273 | `273-gl-mau-bctc-mvi02c.md` | GLMAUBCTCTMVI02c.dll | SHELL_ONLY |
| 274 | `274-gl-mau-bctc-mvi09.md` | GLMAUBCTCTMVI09.dll | SHELL_ONLY |
| 275 | `275-gl-mau-bctc-mvi10.md` | GLMAUBCTCTMVI10.dll | SHELL_ONLY |
| 276 | `276-gl-mau-bctc-mvi11.md` | GLMAUBCTCTMVI11.dll | SHELL_ONLY |
| 277 | `277-gl-mau-bctc-mvi12.md` | GLMAUBCTCTMVI12.dll | SHELL_ONLY |
| 278 | `278-gl-mau-bctc-mvi15c.md` | GLMAUBCTCTMVI15c.dll | SHELL_ONLY |
| 279 | `279-gl-mau-bctc-mvi212.md` | GLMAUBCTCTMVI212.dll | SHELL_ONLY |
| 280 | `280-gl-mau-bctc-mvi25a.md` | GLMAUBCTCTMVI25A.dll | SHELL_ONLY |
| 281 | `281-gl-mau-bctc-mvi29b.md` | GLMAUBCTCTMVI29B.dll | SHELL_ONLY |
| 282 | `282-gl-mau-bctc-mvii.md` | GLMAUBCTCTMVII.dll | SHELL_ONLY |
| 283 | `283-gl-mau-bctc-mviii.md` | GLMAUBCTCTMVIII.dll | SHELL_ONLY |
| 284 | `284-gl-nb.md` | GLNB.dll | SHELL_ONLY |
| 285 | `285-gl-post2dgtg.md` | GLPost2DGTG.dll | SHELL_ONLY |
| 286 | `286-gl-post2glkc.md` | GLPost2GLKC.dll | SHELL_ONLY |
| 287 | `287-gl-rpt-bcpt01.md` | GLRptBCPT01.dll | SHELL_ONLY |
| 288 | `288-gl-rpt-bcpt02.md` | GLRptBCPT02.dll | SHELL_ONLY |
| 289 | `289-gl-rpt-bcpt03.md` | GLRptBCPT03.dll | SHELL_ONLY |
| 290 | `290-gl-rpt-bcpt04.md` | GLRptBCPT04.dll | SHELL_ONLY |
| 291 | `291-gl-rpt-bcpt05.md` | GLRptBCPT05.dll | SHELL_ONLY |
| 292 | `292-gl-rpt-bct01.md` | GLRptBCT01.dll | SHELL_ONLY |
| 293 | `293-gl-rpt-bct02.md` | GLRptBCT02.dll | SHELL_ONLY |
| 294 | `294-gl-rpt-bctccdtb03.md` | GLRptBCTCCDTB03.dll | SHELL_ONLY |
| 295 | `295-gl-rpt-bctccdtf02.md` | GLRptBCTCCDTF02.dll | SHELL_ONLY |
| 296 | `296-gl-rpt-bctccdtf03a.md` | GLRptBCTCCDTF03A.dll | SHELL_ONLY |
| 297 | `297-gl-rpt-bctccdtf03c.md` | GLRptBCTCCDTF03C.dll | SHELL_ONLY |
| 298 | `298-gl-rpt-bctccdtf03d.md` | GLRptBCTCCDTF03D.dll | SHELL_ONLY |
| 299 | `299-gl-rpt-bctccr02.md` | GLRptBCTCCR02.dll | SHELL_ONLY |
| 300 | `300-gl-rpt-bctccr03.md` | GLRptBCTCCR03.dll | SHELL_ONLY |
| 301 | `301-gl-rpt-bctccr04.md` | GLRptBCTCCR04.dll | SHELL_ONLY |
| 302 | `302-gl-rpt-bk02.md` | GLRptBk02.dll | SHELL_ONLY |
| 303 | `303-gl-rpt-ctgs01.md` | GLRptCTGS01.dll | SHELL_ONLY |
| 304 | `304-gl-rpt-ctgs02.md` | GLRptCTGS02.dll | DONE |
| 305 | `305-gl-rpt-ctgs03.md` | GLRptCTGS03.dll | SHELL_ONLY |
| 306 | `306-gl-rpt-ctgs05.md` | GLRptCTGS05.dll | SHELL_ONLY |
| 307 | `307-gl-rpt-f5bcpt08.md` | GLRptF5BCPT08.dll | SHELL_ONLY |
| 308 | `308-gl-rpt-f5bctc02.md` | GLRptF5BCTC02.dll | SHELL_ONLY |
| 309 | `309-gl-rpt-f5bctc02ct.md` | GLRptF5BCTC02CT.dll | SHELL_ONLY |
| 310 | `310-gl-rpt-f5bctc03ct.md` | GLRptF5BCTC03CT.dll | SHELL_ONLY |
| 311 | `311-gl-rpt-f5ctgs01.md` | GLRptF5CTGS01.dll | SHELL_ONLY |
| 312 | `312-gl-rpt-f5ctgs02.md` | GLRptF5CTGS02.dll | SHELL_ONLY |
| 313 | `313-gl-rpt-nkc08.md` | GLRptNKC08.dll | SHELL_ONLY |
| 314 | `314-gl-rpt-nkctnk1.md` | GLRptNKCTNK1.dll | SHELL_ONLY |
| 315 | `315-gl-rpt-nkctsocai.md` | GLRptNKCTSoCai.dll | SHELL_ONLY |
| 316 | `316-gl-rpt-tmbctc.md` | GLRptTMBCTC.dll | SHELL_ONLY |
| 317 | `317-gl-transfer-glcdtk.md` | GLTransferGLCDTK.dll | SHELL_ONLY |
| 318 | `318-gl-vch-gl1.md` | GLVchGL1.dll | SHELL_ONLY |
| 319 | `319-gl-rpt-bct04.md` | GlRptBCT04.dll | SHELL_ONLY |
| 320 | `320-gl-rpt-bct05.md` | GlRptBCT05.dll | SHELL_ONLY |
| 321 | `321-gl-rpt-bct06.md` | GlRptBCT06.dll | SHELL_ONLY |
| 322 | `322-gl-rpt-bcpt08.md` | GlRptBcpt08.dll | DONE |
| 323 | `323-gl-rpt-bctc01.md` | GlRptBctc01.dll | DONE |
| 324 | `324-gl-rpt-bctc02.md` | GlRptBctc02.dll | DONE |
| 325 | `325-gl-rpt-bctc03.md` | GlRptBctc03.dll | DONE |
| 326 | `326-gl-rpt-bctc04.md` | GlRptBctc04.dll | DONE |
| 327 | `327-gl-rpt-bk01.md` | GLRptBK01.dll | DONE |
| 328 | `328-gl-rpt-f5bctc03.md` | GlRptF5Bctc03.dll | SHELL_ONLY |
| 329 | `329-gl-rpt-f5bctc04.md` | GlRptF5Bctc04.dll | SHELL_ONLY |
| 330 | `330-gl-rpt-nkc01all.md` | GlRptNKC01All.dll | SHELL_ONLY |
| 331 | `331-gl-rpt-nkc01.md` | GlRptNkc01.dll | SHELL_ONLY |
| 332 | `332-gl-rpt-nkc02.md` | GlRptNkc02.dll | SHELL_ONLY |
| 333 | `333-gl-rpt-nkc03.md` | GlRptNkc03.dll | DONE |
| 334 | `334-gl-rpt-nkc03-022511.md` | GlRptNkc03.dll | DONE |
| 334 | `334-gl-rpt-nkc04.md` | GlRptNkc04.dll | DONE |
| 335 | `335-gl-rpt-nkc05.md` | GlRptNkc05.dll | DONE |
| 336 | `336-gl-rpt-nkc06.md` | GlRptNkc06.dll | DONE |
| 337 | `337-gl-rpt-nkc07.md` | GlRptNkc07.dll | DONE |
| 366 | `366-gl-balance-so-du-ban-dau.md` |  | PENDING |

## IN — Tồn kho

| ID | File | DLL | Status |
|---|---|---|---|
| 100 | `100-IN-danhmuc-kho.md` | INDMKHO.dll | SHELL_ONLY |
| 101 | `101-IN-congno-dinhmuc-fifo.md` | INCDFIFO.dll | SHELL_ONLY |
| 102 | `102-IN-baocao-tonghop-nhap-01.md` | INRptTHN01.dll | SHELL_ONLY |
| 103 | `103-IN-phieu-nhapkho.md` | INVchIN1.dll | SHELL_ONLY |
| 104 | `104-IN-phieu-laprap-thaodo.md` | INVchIN6.dll | SHELL_ONLY |
| 105 | `105-IN-baocao-chitiet-vattu-01.md` | INRptCTVT01.dll | SHELL_ONLY |
| 106 | `106-IN-danhmuc-lo.md` | INDMLO.dll | SHELL_ONLY |
| 107 | `107-IN-bangke-chungtu-tonkho.md` | INRptBK01.dll | SHELL_ONLY |
| 108 | `108-IN-chuyendoi-tonkho.md` | INTransferINCDVT.dll | SHELL_ONLY |
| 109 | `109-IN-danhmuc-nhomhang-vat.md` | INDMNHVAT.dll | SHELL_ONLY |
| 110 | `110-IN-tinh-gia-binhquan-didong.md` | INCalGiaBQDD.dll | SHELL_ONLY |
| 111 | `111-IN-tonghop-hangxuat-kho.md` | INRptTHX01.dll | SHELL_ONLY |
| 112 | `112-IN-danhmuc-phanloai-vattu.md` | INDMPLVT.dll | SHELL_ONLY |
| 113 | `113-IN-tinh-gia-trungbinh-thang.md` | INCalGiaTB.dll | SHELL_ONLY |
| 115 | `115-IN-nhap-so-ton-dauky.md` | INCDVT.dll | SHELL_ONLY |
| 116 | `116-IN-baocao-f5-chidao-01.md` | INRptF5CD01.dll | SHELL_ONLY |
| 226 | `226-in-phieu-xuat-kho.md` | INVchIN2.dll | SHELL_ONLY |
| 227 | `227-in-phieu-chuyen-kho.md` | INVchIN3.dll | SHELL_ONLY |
| 228 | `228-in-phieu-xuat-cong-cu-dung-cu.md` | INVchIN5.dll | SHELL_ONLY |
| 229 | `229-in-bang-ke-phieu-nhap.md` | INRptBKN04.dll | SHELL_ONLY |
| 230 | `230-in-bang-ke-phieu-xuat.md` | INRptBKX04.dll | DONE |
| 231 | `231-in-bao-cao-cong-no-vat-tu.md` | INRptCD01.dll | SHELL_ONLY |
| 232 | `232-in-the-kho-so-chi-tiet-vat-tu.md` | INRptCTVT02.dll | SHELL_ONLY |
| 233 | `233-IN-baocao-tonghop-hang-nhap-02.md` | INRptTHN02.dll | DONE |
| 233 | `233-in-tong-hop-hang-nhap-kho.md` | INRptTHN02.dll | SHELL_ONLY |
| 234 | `234-IN-baocao-tonghop-hang-xuat-02.md` | INRptTHX02.dll | DONE |
| 234 | `234-in-tong-hop-hang-xuat-kho.md` | INRptTHX02.dll | SHELL_ONLY |
| 235 | `235-in-tinh-gia-nhap-truoc-xuat-truoc.md` | INCalGiaNTXT.dll | SHELL_ONLY |
| 354 | `354-IN-hang-ton-kho.md` |  | SHELL_ONLY |
| 355 | `355-in-danh-muc-vattu-bom.md` | INDMVT_.dll | SHELL_ONLY |

## PO — Đơn hàng mua

| ID | File | DLL | Status |
|---|---|---|---|
| 064 | `064-PO-danhmuc-dieukhoan-thanhtoan.md` | PODMDKTT.dll | SHELL_ONLY |
| 065 | `065-PO-phieu-tra-lai-hang-mua.md` | POVchPO1.dll | SHELL_ONLY |
| 066 | `066-PO-baocao-tonghop-muahang-02.md` | PORptTH02.dll | DONE |
| 067 | `067-PO-baocao-muahang-hai-chitieu.md` | PORptBCPT03.dll | DONE |
| 068 | `068-PO-danhmuc-hinhthuc-thanhtoan.md` | PODMHTTT.dll | SHELL_ONLY |
| 070 | `070-PO-chungtu-nhan-hang-mua.md` | POVchPO4.dll | SHELL_ONLY |
| 071 | `071-PO-bangke-chungtu-muahang.md` | PORptBK01.dll | DONE |
| 072 | `072-PO-baocao-tonghop-muahang-03.md` | PORptTH03.dll | DONE |
| 073 | `073-PO-bangke-chungtu-muahang-02.md` | PORptBK02.dll | DONE |
| 074 | `074-PO-phieu-thanhtoan-muahang.md` | POVchPO5.dll | SHELL_ONLY |
| 075 | `075-PO-tien-ich-muahang.md` | POUtilities.dll | SHELL_ONLY |
| 076 | `076-PO-baocao-tonghop-muahang-01.md` | PORptTH01.dll | DONE |
| 077 | `077-PO-bangke-chungtu-muahang-03.md` | PORptBK03.dll | DONE |
| 078 | `078-PO-baocao-f5-tonghop-muahang.md` | PORptF5TH0.dll | SHELL_ONLY |
| 079 | `079-PO-bangke-thue-dauvao.md` | POTAIN.dll | SHELL_ONLY |
| 080 | `080-PO-don-dat-hang-mua.md` | POVchPO7.dll | SHELL_ONLY |
| 217 | `217-po-hoa-don-mua-dich-vu.md` | PoVchPO6.dll | SHELL_ONLY |

## SI — System Integration

| ID | File | DLL | Status |
|---|---|---|---|
| 081 | `081-SI-congcu-dongbo-hethong.md` | SIUPDATETOOL.dll | SHELL_ONLY |
| 082 | `082-SI-danhmuc-tuychon-10.md` | SIDMOpt10.dll | SHELL_ONLY |
| 083 | `083-SI-thongtin-chuongtrinh.md` | SIAbout.dll | SHELL_ONLY |
| 084 | `084-SI-danhmuc-bophan.md` | SIDMNHHD.dll | SHELL_ONLY |
| 085 | `085-SI-khaibao-thamso-hethong.md` | SISysvars.dll | SHELL_ONLY |
| 086 | `086-SI-baotri-hethong.md` | SIMaintain.dll | SHELL_ONLY |
| 087 | `087-SI-danhmuc-ngoaite.md` | SIDMNT.dll | SHELL_ONLY |
| 088 | `088-SI-danhmuc-nhom-hopdong.md` | SIGroupInfo.dll | SHELL_ONLY |
| 089 | `089-SI-danhmuc-tygia-ngoaite.md` | SIDMTGNT.dll | SHELL_ONLY |
| 090 | `090-SI-cauhinh-theme-giaodien.md` | SITheme.dll | SHELL_ONLY |
| 091 | `091-SI-danhmuc-nhapxuat.md` | SIDMNHHD.dll | SHELL_ONLY |
| 092 | `092-SI-danhmuc-tuychon-9.md` | SIDMOpt9.dll | SHELL_ONLY |
| 093 | `093-SI-danhmuc-phi.md` | SIDMPHI.dll | SHELL_ONLY |
| 094 | `094-SI-khaibao-mhinh-nhapchungtu.md` | SIDMCT.dll | SHELL_ONLY |
| 095 | `095-SI-danhmuc-nganhang.md` | SIDMNGH.dll | SHELL_ONLY |
| 096 | `096-SI-phieu-nhapkho.md` | SIVchSI1.dll | SHELL_ONLY |
| 097 | `097-SI-saoluu-phuchoi-dulieu.md` | SIBackupData.dll | SHELL_ONLY |
| 098 | `098-SI-danhmuc-hopdong.md` | SIDMHD.dll | SHELL_ONLY |
| 099 | `099-SI-thongke-capnhat-chungtu.md` | SIRptLOGCT.dll | SHELL_ONLY |
| 219 | `219-si-chuyen-so-lieu-import-export.md` | SiImExData.dll | SHELL_ONLY |
| 220 | `220-si-thong-tin-san-pham.md` | SiInfomationProduct.dll | SHELL_ONLY |
| 221 | `221-si-sap-xep-lai-so-chung-tu.md` | SiReOrderVoucherNumber.dll | SHELL_ONLY |
| 222 | `222-si-cong-cu-he-thong.md` | SiTools.dll | SHELL_ONLY |
| 223 | `223-si-cong-cu-he-thong-2.md` | SiTools_2.dll | SHELL_ONLY |
| 224 | `224-si-cap-nhat-log.md` | SiUpdateLog.dll | SHELL_ONLY |
| 361 | `361-si-smffy-khoa-so-lieu-cuoi-nam.md` | `SMFFY.dll` | PENDING |
| 362 | `362-si-smuserinfo-quan-ly-nguoi-dung.md` | `SMUserInfo.dll` | PENDING |
| 363 | `363-si-company-chon-cong-ty.md` |  | PENDING |
| 365 | `365-si-website-quan-ly-website.md` |  | PENDING |
| 368 | `368-si-optfieldinfo-danh-muc-truong-tu-do.md` | `OptFieldInfo.dll` | DOC_ONLY |
| 369 | `369-si-optfieldsetup-khai-bao-truong-tu-do.md` | `OptFieldSetup.dll` | DOC_ONLY |
| 376 | `376-simba-wrapper-duplicate-params.md` |  | PARTIAL — đã fix 143 wrapper TRÙNG TÊN (PR riêng); còn 28 wrapper THIẾU tham số |
| 383 | `383-audit-route-component-sai.md` |  | PARTIAL — phát hiện 2 trường hợp sai, đã fix 1 |

## SO — Đơn hàng bán

| ID | File | DLL | Status |
|---|---|---|---|
| 034 | `034-ban-hang-khach-hang-lien-ket-ngan-hang.md` |  | SHELL_ONLY |
| 035 | `035-ban-hang-khach-hang-lien-ket-nhom-phan-loai.md` |  | SHELL_ONLY |
| 036 | `036-ban-hang-khach-hang-lien-ket-danh-muc-tai-khoan.md` |  | SHELL_ONLY |
| 037 | `037-ban-hang-khach-hang-lien-ket-ma-thanh-toan.md` |  | SHELL_ONLY |
| 043 | `043-SO-dondathang-ma-khach-dac-biet.md` | SOND51dmqdadhd.dll | SHELL_ONLY |
| 044 | `044-SO-baocao-banhang-chitieu.md` | SORptBCPT06.dll | SHELL_ONLY |
| 045 | `045-SO-baocao-loi-nhuan.md` | SORptLaiLo.dll | SHELL_ONLY |
| 046 | `046-SO-tien-ich-ban-hang.md` | SOUtilities.dll | SHELL_ONLY |
| 047 | `047-SO-dondathang-diembanhang.md` | SOND51adhd.dll | SHELL_ONLY |
| 048 | `048-SO-baocao-tonghop-banhang.md` | SORptTH01.dll | DONE |
| 050 | `050-SO-dondathang-phuongthuc-hung.md` | SOND51phhd.dll | SHELL_ONLY |
| 052 | `052-SO-danhmuc-trungtam-dinhkhoan.md` | SODMTD.dll | SHELL_ONLY |
| 053 | `053-SO-danhmuc-giaban.md` | SODMGIABAN.dll | SHELL_ONLY |
| 054 | `054-SO-baocao-phantich-banhang-03.md` | SORptBCPT03.dll | DONE |
| 055 | `055-SO-danhmuc-phuongtien-vantai.md` | SODMPTVT.dll | SHELL_ONLY |
| 056 | `056-SO-dondathang-mathang.md` | SOND51mathd.dll | SHELL_ONLY |
| 057 | `057-SO-baocao-phantich-banhang-04.md` | SORptBCPT04.dll | DONE |
| 058 | `058-SO-danhmuc-hanghoa-khuyenmai.md` | SODMHHKM.dll | SHELL_ONLY |
| 059 | `059-SO-bangke-chungtu-banhang.md` | SORptBK02.dll | DONE |
| 060 | `060-SO-dondathang-bomauhoadon.md` | SOND51bmhd.dll | SHELL_ONLY |
| 061 | `061-SO-xuatdulieu-banhang.md` | SOTaOut.dll | SHELL_ONLY |
| 062 | `062-SO-danhmuc-khuyenmai.md` | SODMTKM.dll | SHELL_ONLY |
| 198 | `198-so-hoa-don-ban-hang-underscore.md` | SOVchSO3_.dll | SHELL_ONLY |
| 199 | `199-so-phieu-nhap-hang-ban-tra-lai.md` | SOVchSO4.dll | SHELL_ONLY |
| 200 | `200-so-hoa-don-ban-dich-vu.md` | SOVchSO5.dll | SHELL_ONLY |
| 202 | `202-so-bao-cao-phan-tich-f5-06.md` | SORptF5BCPT06.dll | SHELL_ONLY |
| 203 | `203-so-bao-cao-tong-hop-f5.md` | SORptF5TH0.dll | SHELL_ONLY |
| 204 | `204-so-bao-cao-tong-hop-ban-hang-02.md` | SORptTH02.dll | DONE |
| 205 | `205-so-danh-muc-chuyen-khoan.md` | SODMCK.dll | SHELL_ONLY |
| 206 | `206-so-danh-muc-don-gia-vat-tu.md` | SODMDGVT.dll | SHELL_ONLY |
| 207 | `207-so-danh-muc-dieu-khoan-thanh-toan.md` | SODMDKTT.dll | SHELL_ONLY |
| 208 | `208-so-danh-muc-hinh-thuc-thanh-toan.md` | SODMHTTT.dll | SHELL_ONLY |
| 209 | `209-so-danh-muc-khuyen-mai.md` | SODMKM.dll | SHELL_ONLY |
| 210 | `210-so-danh-muc-nhan-vien-kinh-doanh.md` | SODMNVKD.dll | SHELL_ONLY |
| 211 | `211-so-danh-muc-thue-suat.md` | SODMTS.dll | SHELL_ONLY |
| 212 | `212-so-thong-bao-huy-hoa-don.md` | SOND51HuyHD.dll | SHELL_ONLY |
| 213 | `213-so-bang-ke-hoa-don.md` | SOND51bkhd.dll | SHELL_ONLY |
| 214 | `214-so-danh-muc-mau-hoa-don.md` | SOND51dmmhd.dll | SHELL_ONLY |
| 215 | `215-so-thong-bao-mat-chay-hong-hoa-don.md` | SOND51mchhd.dll | SHELL_ONLY |
| 216 | `216-so-thong-bao-xoa-hoa-don.md` | SOND51xoahd.dll | SHELL_ONLY |
| 338 | `338-SO-phieuxuat-banle.md` | SOVchSO1.dll | SHELL_ONLY |
| 339 | `339-SO-dondathang-mauhoadon.md` | SOND51mhd.dll | SHELL_ONLY |
| 340 | `340-SO-dondathang-mauhoadon-SOVchSO3.md` | SOVchSO3.dll | DONE |
| 370 | `370-so-chi-tiet-cong-no-khach-hang-co-so-luong-06-30-38.md` | ARRptBCCN01.dll (form dùng chung cho AR và AP, menuid phân biệt) | PENDING |

## System — Framework & cross-link

| ID | File | DLL | Status |
|---|---|---|---|
| 357 | `357-system-livewire-input-components.md` |  | DONE |
| 367 | `367-system-framework-libraries.md` |  | DOC_ONLY |
| 372 | `372-fix-simba-menu-route-suffix-deterministic.md` |  | DONE |

