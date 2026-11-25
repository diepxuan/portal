# Task 376: Bug wrapper SP — tham số trùng tên khác hoa thường

## Nhom: SI (System Integration)

- **Status:** PENDING — 145 wrapper cần sửa, mới fix 1 (`AsINRptBK01`)
- **Loai:** Bug fix (không phải báo cáo)
- **Nguồn phát hiện:** task 107 (INRptBK01) khi verify browser đổi năm

# Bug wrapper SP: tham số trùng tên khác hoa thường

> Quét `diepxuan/laravel-simba/src/StoredProcedures/As*.php` — phát hiện **145 wrapper** có tham số trùng.

## Nguyên nhân

SQL Server phân biệt `pma_cty` và `pMa_cty` là **2 tham số khác nhau**.
Khi wrapper gửi cả hai, SP báo:

```
SQLSTATE[42000]: Procedure or function <sp> has too many arguments specified
```

## Triệu chứng thực tế (task 107, `AsINRptBK01`)

- Năm hiện tại (2026): không lỗi
- Năm khác (2025/2024/2010): **lỗi**
- Sau khi bỏ param trùng: **không lỗi với mọi năm**

## Danh sách wrapper cần sửa

| # | Wrapper | SP | Số param | Nhóm trùng |
|---:|---|---|---:|---|
| 1 | `AsCOInsDMNHSPCT` | `asCOInsDMNHSPCT` | 10 | pLUser/pLUser |
| 2 | `AsCoCpCalDepreciation` | `asCoCpCalDepreciation` | 5 | pThang/pThang, pNam/pNam |
| 3 | `AsCoRptKHCPTT` | `asCoRptKHCPTT` | 10 | pMa_Cty/pMa_cty |
| 4 | `AsGLInsMAUBCTCTmVI15c` | `asGLInsMAUBCTCTmVI15c` | 64 | pMa_cty/pMa_cty/pMa_cty, pMau/pMau/pMau, pMa_so/pMa_so/pMa_so, pChi_tieu/pChi_tieu/pChi_tieu, pNd_chtieu/pNd_chtieu/pNd_chtieu, pCach_tinh/pcach_tinh/pCach_tinh/pCach_tinh, pLoai_ps/pLoai_ps/pLoai_ps, pTk_01/pTk_01/pTk_01/pTk_01, pTk_02/pTk_02/pTk_02/pTk_02, pIsPrint/pIsPrint/pIsPrint, pIsItalic/pIsItalic/pIsItalic, pBold/pBold/pBold, pModify/pModify/pModify/pModify/pModify, pTien_01/pTien_01, pTien_02/pTien_02, pTien_03/pTien_03, pTien_04/pTien_04, pTien_05/pTien_05, pTien_06/pTien_06, pUserData/pUserData, pGhi_chu/pGhi_chu, pNgay1/pNgay1, pNgay2/pNgay2 |
| 5 | `AsGLRptBCTC03` | `asGLRptBCTC03` | 20 | pMa_Cty/pMa_Cty, pQd_cdkt/pQd_cdkt, pNgay_Ct1/pNgay_Ct1, pNgay_Ct2/pNgay_Ct2, pNgay_Ct01/pNgay_Ct01, pNgay_Ct02/pNgay_Ct02, pMau/pMau, pMa_bp/pMa_bp, pMa_Nt/pMa_Nt, pDest/pDest |
| 6 | `AsGLRptBCTCCDTf03C` | `asGLRptBCTCCDTf03C` | 6 | pMa_cty/pMa_cty, pTk/pTk |
| 7 | `AsGLRptBCTCCDTf03D` | `asGLRptBCTCCDTf03D` | 6 | pMa_cty/pMa_cty, pTk/pTk |
| 8 | `AsGetTygia` | `asGetTygia` | 5 | pMa_Cty/pMa_cty |
| 9 | `AsGetVoucher2Post` | `asGetVoucher2Post` | 8 | pMa_cty/pMa_Cty |
| 10 | `AsGlCtgsCrtNumOfVoucher` | `asGlCtgsCrtNumOfVoucher` | 10 | pMa_ct/pma_ct/pMa_Ct |
| 11 | `AsHrGetChamCongKhac` | `asHrGetChamCongKhac` | 6 | pNgay/pngay |
| 12 | `AsINFilt3` | `asINFilt3` | 3 | pKeyCt/pKeyct |
| 13 | `AsINRptBKN01` | `asINRptBKN01` | 21 | pMa_cty/pMa_Cty, pMa_Hd/pMa_hd, pTk_Du/pTk_du |
| 14 | `AsINRptBKN02` | `asINRptBKN02` | 23 | pMa_cty/pMa_Cty, pMa_Hd/pMa_hd, pMa_NT/pMa_nt, pTK_VT/pTk_vt, pTk_Du/pTk_du |
| 15 | `AsINRptBKN03` | `asINRptBKN03` | 25 | pMa_cty/pMa_Cty, pMa_Hd/pMa_hd, pTK_VT/pTk_vt, pTk_Du/pTk_du, pMa_NT/pMa_nt |
| 16 | `AsINRptBKN04` | `asINRptBKN04` | 31 | pMa_cty/pMa_Cty, pMa_Hd/pMa_hd, pTK_VT/pTK_vt, pTK_Du/pTK_du, pMa_NT/pMa_nt |
| 17 | `AsINRptBKX01` | `asINRptBKX01` | 29 | pMa_cty/pMa_Cty, pMa_kh/pMa_Kh, pMa_NhKh/pMa_nhkh, pMa_PlKh1/pMa_plkh1, pMa_PlKh2/pMa_plkh2, pMa_PlKh3/pMa_plkh3, pMa_Nt/pMa_nt |
| 18 | `AsINRptBKX04` | `asINRptBKX04` | 30 | pMa_cty/pMa_Cty, pMa_Hd/pMa_hd, pMa_Nt/pMa_nt, ptk_vt/pTK_VT/pTK_vt, pTk_Du/pTK_du |
| 19 | `AsINRptCD01` | `asINRptCD01` | 17 | pMa_cty/pMa_Cty |
| 20 | `AsINRptCD01_4check` | `asINRptCD01_4check` | 17 | pMa_cty/pMa_Cty |
| 21 | `AsINRptCD01_Lo` | `asINRptCD01_Lo` | 19 | pMa_cty/pMa_Cty, pDVT/pDvt |
| 22 | `AsINRptCD01_PL123` | `asINRptCD01_PL123` | 22 | pMa_cty/pMa_Cty, pDVT/pDvt |
| 23 | `AsINRptCTVT02_crys` | `asINRptCTVT02_crys` | 13 | pMa_vt/pma_vt |
| 24 | `AsINRptF5CD05_kho` | `asINRptF5CD05_kho` | 18 | pMa_kho/pma_kho |
| 25 | `AsINRptF5CT01` | `asINRptF5CT01` | 22 | pMa_cty/pMa_Cty |
| 26 | `AsINRptTHN01` | `asINRptTHN01` | 33 | pMa_Hd/pMa_hd, pMa_NT/pMa_nt |
| 27 | `AsINRptTHX01` | `asINRptTHX01` | 28 | pMa_Hd/pMa_hd, pMa_NT/pMa_nt |
| 28 | `AsINUpdCDVT` | `asINUpdCDVT` | 14 | pMa_nt/pMa_Nt |
| 29 | `AsINUpdDMVT` | `asINUpdDMVT` | 45 | pMa_cty/pma_cty |
| 30 | `AsInCalGiaBQDD` | `asInCalGiaBQDD` | 14 | pMa_cty/pma_cty/pMa_Cty, pNhom_vt/pnhom_vt, pma_ct_cl/pMa_ct_cl |
| 31 | `AsInPostCDVT2CDFIFO` | `asInPostCDVT2CDFIFO` | 11 | pMa_vt/pma_vt, pMa_kho/pma_kho |
| 32 | `AsInUpdGiaFifo` | `asInUpdGiaFifo` | 2 | pma_cty/pMa_cty |
| 33 | `AsInsLogPrint` | `asInsLogPrint` | 14 | pso_ct/pSo_ct, pso_seri/pSo_seri |
| 34 | `AsInsUserGroup` | `asInsUserGroup` | 5 | pUserName/pusername |
| 35 | `AsLookup` | `asLookup` | 12 | pMa_cty/pMa_Cty |
| 36 | `AsMMRptBCPT01` | `asMMRptBCPT01` | 9 | pMa_cty/pMa_Cty |
| 37 | `AsPOLookupPnHd` | `asPOLookupPnHd` | 3 | pMa_cty/pMa_Cty |
| 38 | `AsPOReCalPO54Relate` | `asPOReCalPO54Relate` | 4 | pMa_cty/pma_cty, pStt_rec/pstt_rec |
| 39 | `AsPORptBCPT011` | `asPORptBCPT011` | 21 | pngay1/pNgay1 |
| 40 | `AsPORptBCPT012` | `asPORptBCPT012` | 26 | pngay1/pNgay1, pMa_vt/pMa_vt_ |
| 41 | `AsPORptBCPT022` | `asPORptBCPT022` | 26 | pngay1/pNgay1, pMa_vt/pMa_vt_ |
| 42 | `AsPORptBCPT03` | `asPORptBCPT03` | 32 | pMa_cty/pMa_Cty, pMa_HTTT/pMa_httt, pMa_NT/pMa_nt |
| 43 | `AsPORptBK01` | `asPORptBK01` | 33 | pMa_cty/pMa_Cty, pMa_hd/pMa_Hd, pMa_Phi/pMa_phi |
| 44 | `AsPORptBK02` | `asPORptBK02` | 32 | pMa_cty/pMa_Cty, pMa_Phi/pMa_phi |
| 45 | `AsPORptBK03` | `asPORptBK03` | 30 | pMa_cty/pMa_Cty, pMa_Phi/pMa_phi |
| 46 | `AsPORptBK04` | `asPORptBK04` | 21 | pMa_cty/pMa_Cty, pMa_hd/pMa_Hd, pSo_DH/pso_DH |
| 47 | `AsPORptBK05` | `asPORptBK05` | 21 | pMa_cty/pMa_Cty, pMa_Phi/pMa_phi, pMa_hd/pMa_Hd |
| 48 | `AsPORptBK06` | `asPORptBK06` | 20 | pMa_cty/pMa_Cty, pMa_hd/pMa_Hd |
| 49 | `AsPORptBK07` | `asPORptBK07` | 21 | pMa_cty/pMa_Cty |
| 50 | `AsPORptF5Bcpt03` | `asPORptF5Bcpt03` | 14 | pMa_cty/pMa_Cty |
| 51 | `AsPORptTH01` | `asPORptTH01` | 33 | pMa_cty/pma_cty/pMa_Cty, pMa_hd/pMa_Hd, pMa_NT/pMa_nt, pMa_Phi/pMa_phi |
| 52 | `AsPORptTH03` | `asPORptTH03` | 35 | pMa_cty/pma_cty/pMa_Cty, pMa_hd/pMa_Hd, pMa_NT/pMa_nt, pMa_Phi/pMa_phi |
| 53 | `AsPORptTH04` | `asPORptTH04` | 20 | pMa_cty/pMa_Cty, pMa_hd/pMa_Hd, pMa_NT/pMa_nt |
| 54 | `AsPORptTH05` | `asPORptTH05` | 19 | pMa_cty/pMa_Cty, pMa_hd/pMa_Hd, pMa_NT/pMa_nt |
| 55 | `AsPORptTH06` | `asPORptTH06` | 21 | pMa_cty/pMa_Cty, pMa_hd/pMa_Hd, pMa_NT/pMa_nt |
| 56 | `AsPORptTH07` | `asPORptTH07` | 27 | pMa_cty/pMa_Cty, pMa_NT/pMa_nt |
| 57 | `AsPORptTH08` | `asPORptTH08` | 20 | pMa_cty/pMa_Cty, pMa_hd/pMa_Hd, pMa_NT/pMa_nt |
| 58 | `AsPostArPh4_glct_1c` | `asPostArPh4_glct_1c` | 12 | pMa_cty/pma_cty, pSTT_rec/pStt_rec/pstt_rec, pNh_dk/pnh_dk |
| 59 | `AsPostArPh4_glct_1n` | `asPostArPh4_glct_1n` | 12 | pMa_cty/pma_cty, pSTT_rec/pStt_rec/pstt_rec, pNh_dk/pnh_dk |
| 60 | `AsPostCAPh3_CaTtHu` | `asPostCAPh3_CaTtHu` | 9 | pMa_cty/pma_cty/pMa_Cty |
| 61 | `AsPostCRPh1_crct_1c` | `asPostCRPh1_crct_1c` | 8 | pMa_cty/pma_cty/pMa_Cty, pSTT_rec/pstt_rec/pStt_rec, pNh_dk/pnh_dk |
| 62 | `AsPostCRPh1_crct_1n` | `asPostCRPh1_crct_1n` | 7 | pMa_cty/pma_cty, pSTT_rec/pstt_rec/pStt_rec, pNh_dk/pnh_dk |
| 63 | `AsPostGlPh1_glct` | `asPostGlPh1_glct` | 10 | pMa_cty/pma_cty, pStt_rec/pSTT_rec |
| 64 | `AsPostGlPh1_glct_1c` | `asPostGlPh1_glct_1c` | 11 | pMa_cty/pma_cty, pStt_rec/pSTT_rec/pstt_rec, pNh_dk/pnh_dk |
| 65 | `AsPostGlPh1_glct_1n` | `asPostGlPh1_glct_1n` | 11 | pMa_cty/pma_cty, pSTT_rec/pStt_rec/pstt_rec, pNh_dk/pnh_dk |
| 66 | `AsPostInPh6LR_GlCt` | `asPostInPh6LR_GlCt` | 10 | pMa_nt0/pMa_Nt0, pMa_nt/pMa_Nt |
| 67 | `AsPostInPh6TD_GlCt` | `asPostInPh6TD_GlCt` | 10 | pMa_nt0/pMa_Nt0, pMa_nt/pMa_Nt |
| 68 | `AsPostPoPh1_apTt` | `asPostPoPh1_apTt` | 7 | pma_cty/pMa_cty |
| 69 | `AsPostPoPh3_GlCt` | `asPostPoPh3_GlCt` | 16 | pMa_nt/pMa_Nt, pMa_nt0/pMa_Nt0 |
| 70 | `AsPostPoPh5_GlCt` | `asPostPoPh5_GlCt` | 12 | pMa_Nt0/pMa_nt0, pMa_Nt/pMa_nt |
| 71 | `AsPostSoPh1_SoCt` | `asPostSoPh1_SoCt` | 7 | pMa_Cty/pMa_cty |
| 72 | `AsPostSoPh2_SoCt` | `asPostSoPh2_SoCt` | 7 | pMa_Cty/pMa_cty |
| 73 | `AsPostSoPh3_SoCt` | `asPostSoPh3_SoCt` | 7 | pMa_Cty/pMa_cty |
| 74 | `AsPostSoPh3_taOut` | `asPostSoPh3_taOut` | 8 | pMa_Cty/pMa_cty |
| 75 | `AsPostSoPh4_SoCt` | `asPostSoPh4_SoCt` | 7 | pMa_Cty/pMa_cty |
| 76 | `AsPostSoPh4_arTt` | `asPostSoPh4_arTt` | 8 | pMa_cty/pMa_Cty |
| 77 | `AsPostSoPh4_taout` | `asPostSoPh4_taout` | 8 | pMa_Cty/pMa_cty |
| 78 | `AsPostSoPh5_SoCt` | `asPostSoPh5_SoCt` | 7 | pMa_Cty/pMa_cty |
| 79 | `AsPostSoPh5_glct` | `asPostSoPh5_glct` | 12 | pMa_Nt0/pMa_nt0, pMa_Nt/pMa_nt |
| 80 | `AsPostSoPh5_taOut` | `asPostSoPh5_taOut` | 8 | pMa_Cty/pMa_cty |
| 81 | `AsProcessCalLaiKU` | `asProcessCalLaiKU` | 12 | pMa_cty/pMa_Cty, pMa_ku/pMa_KU |
| 82 | `AsProcessPoph4` | `asProcessPoph4` | 4 | pStt_rec/pstt_rec |
| 83 | `AsProcessSoPh3` | `asProcessSoPh3` | 5 | pStt_rec/pstt_rec |
| 84 | `AsProcessSoPh4` | `asProcessSoPh4` | 4 | pStt_rec/pstt_rec |
| 85 | `AsProcessSoPh5` | `asProcessSoPh5` | 4 | pStt_rec/pstt_rec |
| 86 | `AsReCalCA54Relate` | `asReCalCA54Relate` | 3 | pMa_cty/pMa_Cty |
| 87 | `AsReCalPO0` | `asReCalPO0` | 3 | pMa_cty/pma_cty |
| 88 | `AsReCalPO14Relate` | `asReCalPO14Relate` | 3 | pMa_cty/pma_cty |
| 89 | `AsReCalPO2` | `asReCalPO2` | 4 | pMa_cty/pma_cty, pStt_rec_pn/pstt_rec_pn |
| 90 | `AsReCalPO24Relate` | `asReCalPO24Relate` | 3 | pMa_cty/pma_cty |
| 91 | `AsReCalPO3` | `asReCalPO3` | 4 | pMa_cty/pma_cty, pStt_rec_hd/pstt_rec_hd |
| 92 | `AsReCalPO34Relate` | `asReCalPO34Relate` | 3 | pMa_cty/pma_cty |
| 93 | `AsReCalPO84Relate` | `asReCalPO84Relate` | 3 | pMa_cty/pma_cty |
| 94 | `AsReCalSO34Relate` | `asReCalSO34Relate` | 4 | pMa_cty/pma_cty, pStt_rec/pstt_rec |
| 95 | `AsReCalSO44Relate` | `asReCalSO44Relate` | 4 | pMa_cty/pma_cty, pStt_rec/pstt_rec |
| 96 | `AsReCalSo1` | `asReCalSo1` | 4 | pMa_cty/pma_cty, pStt_rec_dh/pstt_rec_dh |
| 97 | `AsReCalSo2` | `asReCalSo2` | 4 | pMa_cty/pma_cty, pStt_rec_px/pstt_rec_px |
| 98 | `AsReCalSo3` | `asReCalSo3` | 3 | pMa_cty/pma_cty |
| 99 | `AsRptUpdTATNDN01A_DC` | `asRptUpdTATNDN01A_DC` | 9 | pMa_Cty/pMa_cty |
| 100 | `AsRptUpdTatndn03_dc` | `asRptUpdTatndn03_dc` | 9 | pMa_Cty/pMa_cty |
| 101 | `AsSIMaintain03` | `asSIMaintain03` | 8 | pma_cty/pMa_cty, pngay_ct1/pNgay_ct1, pngay_ct2/pNgay_ct2 |
| 102 | `AsSIMaintain04` | `asSIMaintain04` | 7 | pma_cty/pMa_cty, pngay_ct1/pNgay_ct1 |
| 103 | `AsSODelPH2` | `asSODelPH2` | 6 | pMa_cty/pma_cty, pStt_rec/pstt_rec |
| 104 | `AsSOPostTraTruoc_arTt` | `asSOPostTraTruoc_arTt` | 13 | pStt_rec_pt/pstt_rec_pt, pStt_rec_dh/pstt_rec_dh, pStt_rec_hd/pstt_rec_hd |
| 105 | `AsSORptBCPT021` | `asSORptBCPT021` | 23 | pngay1/pNgay1 |
| 106 | `AsSORptBCPT022` | `asSORptBCPT022` | 28 | pngay1/pNgay1, pMa_vt/pMa_vt_ |
| 107 | `AsSORptBCPT03` | `asSORptBCPT03` | 37 | pMa_cty/pMa_Cty, pkhuyen_mai/pKhuyen_mai |
| 108 | `AsSORptBCPT04` | `asSORptBCPT04` | 33 | pMa_cty/pMa_Cty, pMa_Bp/pMa_bp, pMa_Nvkd/pMa_nvkd, pMa_NT/pMa_nt |
| 109 | `AsSORptBCPT05` | `asSORptBCPT05` | 26 | pMa_cty/pMa_Cty, pMa_Bp/pMa_bp, pMa_Nvkd/pMa_nvkd, pMa_NT/pMa_nt |
| 110 | `AsSORptBCPT06` | `asSORptBCPT06` | 33 | pMa_cty/pMa_Cty, pMa_Bp/pMa_bp, pMa_nvkd/pMa_Nvkd, pMa_HTTT/pMa_httt, pMa_NT/pMa_nt |
| 111 | `AsSORptBCPT07` | `asSORptBCPT07` | 34 | pMa_cty/pMa_Cty, pMa_Bp/pMa_bp, pMa_NT/pMa_nt |
| 112 | `AsSORptBCPT08` | `asSORptBCPT08` | 19 | pNgay1/pngay1, pMa_Bp/pMa_bp, pMa_Nvkd/pMa_nvkd, pMa_Nt/pMa_nt |
| 113 | `AsSORptBCPT10` | `asSORptBCPT10` | 13 | pMa_cty/pMa_Cty |
| 114 | `AsSORptBK02` | `asSORptBK02` | 31 | pMa_cty/pMa_Cty |
| 115 | `AsSORptBK03` | `asSORptBK03` | 24 | pMa_cty/pMa_Cty |
| 116 | `AsSORptBK04` | `asSORptBK04` | 22 | pMa_cty/pMa_Cty |
| 117 | `AsSORptBK05` | `asSORptBK05` | 26 | pMa_cty/pMa_Cty, pTK_VT/pTk_vt |
| 118 | `AsSORptBK06` | `asSORptBK06` | 26 | pMa_cty/pMa_Cty |
| 119 | `AsSORptF5BCPT03` | `asSORptF5BCPT03` | 26 | pMa_cty/pMa_Cty, pkhuyen_mai/pKhuyen_mai |
| 120 | `AsSORptLaiLoHopDong02` | `asSORptLaiLoHopDong02` | 13 | pMa_cty/pma_cty |
| 121 | `AsSORptTH01` | `asSORptTH01` | 34 | pMa_cty/pMa_Cty, pMa_NT/pMa_nt |
| 122 | `AsSORptTH02` | `asSORptTH02` | 13 | pLoai/ploai |
| 123 | `AsSORptTH03` | `asSORptTH03` | 29 | pMa_cty/pMa_Cty, pMa_TKVT/pMa_Tkvt, pMa_NT/pMa_nt |
| 124 | `AsSORptTH05` | `asSORptTH05` | 24 | pMa_cty/pMa_Cty, pMa_TKVT/pMa_Tkvt, pMa_NT/pMa_nt |
| 125 | `AsSORptTH06` | `asSORptTH06` | 28 | pMa_cty/pMa_Cty, pMa_TKVT/pMa_Tkvt, pMa_NT/pMa_nt |
| 126 | `AsSORptTH07` | `asSORptTH07` | 10 | pLoai/ploai |
| 127 | `AsSaChkExistQuyLuong` | `asSaChkExistQuyLuong` | 6 | pMa_bp/pMa_Bp |
| 128 | `AsSaRptBangLuong01` | `asSaRptBangLuong01` | 8 | pMa_cty/pMa_Cty |
| 129 | `AsSaRptBangLuong02` | `asSaRptBangLuong02` | 8 | pMa_cty/pMa_Cty |
| 130 | `AsSaRptPhiBHXH` | `asSaRptPhiBHXH` | 4 | pMa_cty/pMa_Cty |
| 131 | `AsSaRptPhiCongDoan` | `asSaRptPhiCongDoan` | 5 | pMa_cty/pMa_Cty |
| 132 | `AsSaRptPhieuLuong` | `asSaRptPhieuLuong` | 6 | pMa_cty/pMa_Cty |
| 133 | `AsSaRptTamUng` | `asSaRptTamUng` | 5 | pMa_cty/pMa_Cty |
| 134 | `AsSaRptThemGio` | `asSaRptThemGio` | 5 | pMa_cty/pMa_Cty |
| 135 | `AsSaRptThueTNCN` | `asSaRptThueTNCN` | 5 | pMa_cty/pMa_Cty |
| 136 | `AsSaRptTongQuyLuong` | `asSaRptTongQuyLuong` | 8 | pMa_cty/pMa_Cty |
| 137 | `AsSiGetCt4PostGL` | `asSiGetCt4PostGL` | 5 | pMa_Cty/pMa_cty |
| 138 | `AsSiReOrderVoucherNumber` | `asSiReOrderVoucherNumber` | 12 | pMa_cty/pma_cty |
| 139 | `AsSiRePostCt` | `asSiRePostCt` | 11 | pMa_cty/pMa_Cty, pStt_rec/pSTT_rec |
| 140 | `AsSoLookupDhHd` | `asSoLookupDhHd` | 3 | pMa_cty/pMa_Cty |
| 141 | `AsSoLookupDhPx` | `asSoLookupDhPx` | 3 | pMa_cty/pMa_Cty |
| 142 | `AsUpdArcdkh13` | `asUpdArcdkh13` | 7 | pMa_cty/pma_cty, pma_kh/pMa_kh, pnam/pNam |
| 143 | `AsUpdateReportResX` | `asUpdateReportResX` | 9 | pmenuid/pMenuid, pma_mau/pMa_mau |
| 144 | `AsUpdateReportResX_Export2excel_col_list` | `asUpdateReportResX_Export2excel_col_list` | 6 | pmenuid/pMenuid, pma_mau/pMa_mau |
| 145 | `AsValid` | `asValid` | 9 | pMa_cty/pMa_Cty |

## Cách sửa

1. Đối chiếu `simba-docs/procedures/<module>/procedures.md` → tên tham số chuẩn
2. Giữ tên đúng theo docs, bỏ dòng trùng
3. Nếu docs không có → ưu tiên tên lowercase (theo đa số wrapper Simba)
4. Verify bằng browser: đổi tham số sang nhiều giá trị khác nhau, không được lỗi
