# Accounts Receivable (AR) Stored Procedures

Danh sách các stored procedure thuộc module Công nợ phải thu (Accounts Receivable) đã được chuyển đổi thành class PHP.

| Procedure | Class | Parameters | Description |
|-----------|-------|------------|-------------|
| asARFilt1 | `AsARFilt1` | `pKeyPh` (nvarchar(1000)), `pKeyCt` (nvarchar(1000)) | Lọc danh sách phiếu thu/chi và chi tiết theo điều kiện. Trả về hai result sets: phiếu và chi tiết. |
| asARGetCT1 | `AsARGetCT1` | `pMa_cty` (nvarchar(3)), `pStt_rec` (nvarchar(20)), `pStruct` (nvarchar(1)) | Lấy thông tin chi tiết phiếu công nợ phải thu (bảng ARCT1) theo mã công ty và số chứng từ. |
| asARGetCT3 | `AsARGetCT3` | `pMa_cty` (nvarchar(3)), `pStt_rec` (nvarchar(20)), `pStruct` (nvarchar(1)) | Lấy thông tin chi tiết phiếu công nợ phải thu (bảng ARCT3). |
| asARGetMaCT | `AsARGetMaCT` | `pMa_cty` (nvarchar(3)) | Tìm kiếm mã loại chứng từ được phân bổ cho module công nợ phải thu (CA1, CA3, AR4, AP4). |
| asARGetPH1 | `AsARGetPH1` | `pMa_cty` (nvarchar(3)), `pStt_rec` (nvarchar(20)), `pMa_ct` (nvarchar(3)), `pStruct` (nvarchar(1)) | Lấy thông tin phiếu công nợ phải thu (bảng ARPH1) theo mã công ty, số chứng từ, mã chứng từ. |
| asARGetSO34AR1 | `AsARGetSO34AR1` | `pMa_cty` (nvarchar(3)), `pStt_rec` (nvarchar(20)), `pStruct` (nvarchar(1)) | Lấy thông tin phiếu bán hàng liên quan đến công nợ phải thu (bảng SO34AR1). |
| asARGetTT | `AsARGetTT` | `pMa_cty` (nvarchar(3)), `pStt_rec` (nvarchar(20)), `pStruct` (nvarchar(1)) | Lấy thông tin thanh toán (bảng ARTT). |
| asARInsCdKH | `AsARInsCdKH` | `pMa_cty`, `pNam`, `pTk`, `pMa_nt`, `pMa_kh`, `pMa_bp`, `pMa_hd`, `pMa_spct`, `pDu_no`, `pDu_co`, `pDu_no_nt`, `pDu_co_nt`, `pUser` | Chèn dữ liệu vào bảng arcdkh (công nợ chi tiết khách hàng) và đồng bộ sang glcdtk (công nợ chi tiết tài khoản). Có output parameter `pRet`. |
| asARInsDMDCKH | `AsARInsDMDCKH` | `pMa_cty`, `pMa_kh`, `pMa_dckh`, `pTen_kh`, `pDia_chi`, `pTel`, `pFax`, `pNguoi_gd`, `pKsd`, `pDc_md`, `pLUser` | Thêm mới địa chỉ khách hàng (danh mục địa chỉ khách hàng). Có output parameter `pRet`. |
| asARInsPH1 | `AsARInsPH1` | `pMa_cty`, `pStt_rec`, `pMa_ct`, `pSo_ct`, `pStt_rec_dh`, `pSo_dh`, `pNgay_ct`, `pNgay_lct`, `pMa_kh`, `pDia_chi`, `pNguoi_gd`, `pDien_giai`, `pTk_no`, `pMa_gd`, `pMa_nt`, `pTy_gia`, `pT_tien_nt`, `pT_tien`, `pDu`, `pDu_nt`, `pTrang_thai`, `pPost2gl`, `pLUser` | Thêm mới phiếu công nợ phải thu (bảng ARPH1). Có output parameter `pRet`. |
| asARInsPost2TT_ARTT | `AsARInsPost2TT_ARTT` | `pMa_cty`, `pStt_rec`, `pStt_rec_hd`, `pMa_ct`, `pNguoi_gd`, `pDien_giai`, `pTk_pt`, `pMa_kh`, `pSo_ct`, `pNgay_ct`, `pMa_nt`, `pTy_gia`, `pT_tt`, `pT_tt_nt`, `pTien_tt`, `pTien_tt_nt`, `pTien_tt_qd`, `pT_tien`, `pT_tien_nt`, `pUser` | Thêm mới phân bổ chứng từ công nợ phải thu (bảng artt). Có output parameter `pRet`. |

## Ghi chú

- Các procedure có output parameter `pRet` hiện chưa được xử lý bởi `ProcedureCaller`. Cần cập nhật `ProcedureCaller` nếu muốn lấy giá trị output.
- Các tham số có giá trị mặc định trong SQL được chuyển thành giá trị mặc định trong class (ví dụ `null`).
- Để gọi procedure, sử dụng phương thức tĩnh `::call()` của class tương ứng, truyền mảng tham số.
- Chi tiết đầy đủ về từng tham số xem trong comment của từng class.

## Liên kết

- [Tổng hợp tất cả procedure](../PROCEDURES.md)
- [Nhóm AP (Accounts Payable)](./procedures-ap.md)
