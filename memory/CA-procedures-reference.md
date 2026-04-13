# CA Procedures Reference

## Tham chiếu Stored Procedures module CA (Cash)

Documentation đầy đủ về CA procedures được lưu tại: `docs/procedures/CA/procedures.md`

### Key Procedures

#### asCAGetPH2 - Lấy thông tin phiếu chi (CAPH2)
- **File SQL:** SimbaSql/dbo/StoredProcedures/asCAGetPH2.sql
- **Parameters:** pMa_cty, pStt_rec, pMa_ct, pStruct
- **Returns:** Thông tin phiếu chi kèm tên khách hàng, tên tài khoản

#### asCAInsPH2 - Thêm phiếu chi (CAPH2)
- **Parameters:** pMa_cty, pStt_rec, pMa_ct, pSo_ct, pNgay_ct, pNgay_lct, pKht_tain, pMa_kh, pDia_chi, pNguoi_gd, pDien_giai, pTk_co, pMa_nt, pTy_gia, pT_tien_nt, pT_tien, pT_Thue, pT_Tt_nt, pT_Tt, pTrang_thai, pPost2gl, pLUser, pRet

#### asCAUpdPH2 - Cập nhật phiếu chi (CAPH2)
- **Parameters:** Tương tự asCAInsPH2 nhưng có thêm pLUser cho update

#### asCADelPH2 - Xóa phiếu chi (CAPH2)
- **Parameters:** pMa_cty, pStt_rec, pLUser, pRet
- **Cascade:** Xóa CAPH2 + GLCT + TAIN + ARTT + CATTHU + CACT2

### Related Tables
- CAPH1: Phiếu thu header
- CAPH2: Phiếu chi header
- CAPH3: Giấy đề nghị thanh toán header
- CACT1: Chi tiết phiếu thu
- CACT2: Chi tiết phiếu chi
- CACT3: Chi tiết giấy đề nghị thanh toán

### Cross-Module References
- GL: Posting to General Ledger
- AR: Customer receipts
- AP: Vendor payments

---
*Updated: 2026-04-12*