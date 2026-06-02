# Simba Router/Menu Matrix

Nguon lap ngay 2026-05-14:

- Menu: `simba-docs/data/sysMenu.md`, `simba-docs/data/zsysmenu.md`
- Voucher: `simba-docs/data/SiDmCt.md`, `simba-docs/data/sysVoucherInfo.md`
- Report: `simba-docs/data/sysReportInfo.md`, `simba-docs/data/zSysReportInfo.md`
- Dictionary: `simba-docs/data/sysDictionaryInfo.md`, `simba-docs/data/sysDictionaryResx.md`
- Route hien co: `php artisan route:list --json`

Quy tac:

- Khong doc SQL Server.
- Khong tao ten bang/SP/field moi.
- Menu route phai gan duoc `menuid` that tu `sysMenu`/`zsysmenu`.
- Voucher phai gan duoc `ma_ct`, `ph`, `ct`, `menuid` tu `SiDmCt`.
- Dictionary phai gan duoc `code_name`, `key`, `menuid` tu `sysDictionaryInfo`.

---

## 1. Simba menu coverage

Active menu count theo `sysMenu.md`:

| Module | Active menus |
|---|---:|
| GL | 73 |
| SO | 55 |
| IN | 51 |
| PO | 46 |
| FA | 43 |
| CO | 39 |
| SI | 22 |
| CA | 19 |

`SimbaDocsMenuRepository` doc ca `sysMenu.md` va `zsysmenu.md`, unique theo `menuid`, active total hien tai: 357.

System balance/process menus da co route Portal hien huu:

| Simba menu | menuid | Portal route |
|---|---:|---|
| So du dau ky cac tai khoan | 02.10.14 | `system.balance.account-opening` |
| Chuyen so du tai khoan sang nam sau | 02.10.20 | `system.balance.transfer` |
| So du dau ky cong no phai thu | 06.10.40 | `system.balance.accounts-receivable` |
| So du dau ky cong no phai tra | 10.10.44 | `system.balance.accounts-payable` |
| Nhap ton kho dau ky | 14.10.20 | `system.balance.inventory-opening` |
| Nhap ton kho dau ky NTXT | 14.10.23 | `system.balance.inventory-opening-ntxt` |
| Chuyen ton kho sang nam sau | 14.10.38 | `system.balance.inventory-transfer` |
| Nhap gia tri SP do dang cuoi ky | 18.10.11 | `system.balance.work-in-progress` |
| Nhap phat sinh luy ke tu khi khoi cong | 18.10.14 | `system.balance.cumulative-transactions` |
| Quan ly nguoi su dung | 90.20.02 | `system.user.index` |
| Doi mat khau | 90.20.08 | `profile.show` |
| Chon nam lam viec | 90.30.02 | `system.year` |
| Chon don vi | 90.40.17 | `system.company` |

---

## 2. Current implemented route anchors

| Simba source | menuid | Portal route | Component/controller | Status |
|---|---:|---|---|---|
| GL account dictionary | 02.90.02 | `gl.taikhoan` | `Gl\Taikhoan` | Registry verified as `dictionary` |
| CA1 Phiếu thu | 04.10.02 | `ca.tienmat.thu` | `Cash\Tienmat\Phieuthu` | Registry verified as `voucher` |
| CA2 Phiếu chi | 04.10.05 | `ca.tienmat.chi` | `Cash\Tienmat\Phieuchi` | Registry verified as `voucher` |
| CA3 Báo có | 04.10.08 | `ca.nganhang.baoco` | `Cash\Nganhang\Baoco` | Registry verified as `voucher` |
| CA4 Báo nợ | 04.10.11 | `ca.nganhang.baono` | `Cash\Nganhang\Baono` | Registry verified as `voucher` |
| SO3 Hoá đơn bán hàng | 06.10.08 | `ar.ph.hdbh` | `Banhang\Hoadonbanhang` | Registry verified as `voucher` |
| MA_KH Khách hàng | 06.90.02 | `ar.khachhang` | `Banhang\Khachhang` | Registry verified as `dictionary` |
| PO3 Hoá đơn mua hàng trong nước | 10.10.14 | `muahang.hoadonmua` | `Muahang\Hoadonmua` | Registry verified as `voucher` |
| MA_NCC Nhà cung cấp | 10.90.22 | `po.cungcap` | `Muahang\Cungcap` | Added; legacy `ar.cungcap` kept |
| MA_CP Chi phí mua hàng | 10.90.14 | `po.dmcp` | `Muahang\PoDmCpIndex` | `asPOGetDMCP` |
| MA_TT_PO Điều khoản thanh toán mua | 10.90.05 | Blocked |  | `sysMenu` inactive, no route opened |
| MA_NV Nguồn vốn | 20.90.02 | `fa.dmnv` | `Fa\FaDictionaryIndex` | `FADMNV` |
| MA_BPSD Bộ phận sử dụng | 20.90.08 | `fa.dmbpsd` | `Fa\FaDictionaryIndex` | `FADMBPSD` |
| MA_LDTG Lý do tăng giảm tài sản | 20.90.05 | `fa.dict.fadmldts` | `System\SimbaDictionaryIndex` | Alias theo `sysMenu.code_name`; source menuid `18.90.05` |
| MA_NHTS Nhóm tài sản | 20.90.11 | `fa.rpt.fadmnhts` | `System\SimbaReportIndex` | Master-data list shell theo `sysReportInfo`; chua co dictionary metadata sach |
| MA_SP Sản phẩm CO | 18.90.02 | `co.dmsp` | `Co\CoDictionaryIndex` | `CODMSPCT` |
| MA_SPCT Công trình | 18.90.05 | `co.dmspct` | `Co\CoDictionaryIndex` | `CODMSPCT` |
| MA_NHSPCT Nhóm công trình | 18.90.08 | `co.dmnhspct` | `Co\CoDictionaryIndex` | `CODMNHSPCT` |
| GLDMKC Bút toán kết chuyển tự động | 18.90.17 | `co.dict.gldmkc` | `System\SimbaDictionaryIndex` | Alias theo `sysDictionaryInfo.table_name`, source menuid blank |
| CODMPB Bút toán phân bổ tự động | 18.90.20 | `co.rpt.codmpb` | `System\SimbaReportIndex` | Master-data list shell; dictionary metadata PB thieu/lẹch carry fields |
| SIDMCT Khai báo chứng từ | 90.10.02 | `si.dmct` | `System\SiDictionaryIndex` | `SIDMCT` |
| MA_PHI Khoản mục phí | 90.10.20 | `si.dmphi` | `System\SiDictionaryIndex` | `SIDMPHI` |
| MA_NT Ngoại tệ | 90.10.26 | `si.dmnt` | `System\SiDictionaryIndex` | `SIDMNT` |
| Nhập/Chuyển số dư | 90.40.14 | `system.balance.index` | `System\Balance\Index` | Existing Portal balance route |
| MA_NHHD Nhóm hợp đồng | 90.10.14 | Blocked |  | `sysMenu` inactive |
| MA_HD Hợp đồng | 90.10.17 | Blocked |  | `sysMenu` inactive |
| MA_BP Bộ phận | 90.10.23 | `gl.dict.sidmbp` | `System\SimbaDictionaryIndex` | Alias theo `sysMenu.code_name`; source menuid `06.90.35` |
| MA_TGNT Tỷ giá ngoại tệ | 90.10.29 | `ca.process.sidmtgnt` | `System\SimbaProcessIndex` | Read-only process shell; active menu co DLL nhung thieu `sysDictionaryInfo` |
| MA_VT Hàng hoá, vật tư | 14.90.02 | `in.dmvt` | `In\Dmvt` | Registry verified as `dictionary` |
| MA_NHVT Nhóm vật tư | 14.90.05 | `in.dmnhvt` | `In\Dmnhvt` | Registry verified as `dictionary` |
| MA_KHO Kho hàng | 14.90.14 | `in.khohang` | `In\Dmkho` | Registry verified as `dictionary` |
| Sổ quỹ tiền mặt | 04.20.02 | `ca.tienmat.quy` | `Cash\Baocao\Tienmat` | `asCARptTMNH01` |
| Sổ tiền gửi ngân hàng | 04.20.05 | `ca.nganhang.quy` | `Cash\Baocao\Nganhang` | `asCARptTMNH02` |
| Sổ nhật ký thu tiền | 04.20.08 | `ca.thu` | `Cash\Baocao\Thu` | `asGLRptNKC03` |
| Sổ nhật ký chi tiền | 04.20.11 | `ca.chi` | `Cash\Baocao\Chi` | `asGLRptNKC03` |
| Sổ đăng ký chứng từ ghi sổ | 02.20.11 | `gl.rpt.ctgs01` | `Gl\GlReportIndex` | `asGLRptCTGS01` |
| Chứng từ ghi sổ | 02.20.14 | `gl.rpt.ctgs02` | `Gl\GlReportIndex` | `asGLRptCTGS02` |
| Sổ cái chứng từ ghi sổ | 02.20.17 | `gl.rpt.ctgs03` | `Gl\GlReportIndex` | `asGLRptCTGS03` |
| Bảng kê chứng từ ghi sổ | 02.20.20 | `gl.rpt.ctgs05` | `Gl\GlReportIndex` | `asGLRptCTGS05` |
| Sổ cái | 02.25.02 | `gl.rpt.nkc01` | `Gl\GlReportIndex` | `asGLRptNKC01` |
| Sổ nhật ký chung | 02.25.05 | `gl.rpt.nkc02` | `Gl\GlReportIndex` | `asGLRptNKC02` |
| Sổ nhật ký thu tiền | 02.25.08 | `gl.rpt.nkc03` | `Gl\GlReportIndex` | `asGLRptNKC03` |
| Sổ nhật ký chi tiền | 02.25.11 | `gl.rpt.nkc03-chi` | `Gl\GlReportIndex` | `asGLRptNKC03` |
| Sổ nhật ký bán hàng | 02.25.14 | `gl.rpt.nkc04` | `Gl\GlReportIndex` | `asGLRptNKC04` |
| Sổ nhật ký mua hàng | 02.25.17 | `gl.rpt.nkc05` | `Gl\GlReportIndex` | `asGLRptNKC05` |
| Sổ chi tiết tài khoản | 02.25.20 | `gl.rpt.nkc06` | `Gl\GlReportIndex` | `asGLRptNKC06` |
| Sổ chữ T của một tài khoản | 02.25.23 | `gl.rpt.nkc07` | `Gl\GlReportIndex` | `asGLRptNKC07` |
| Bảng kê chứng từ | 02.25.26 | `gl.rpt.bk02` | `Gl\GlReportIndex` | `asGLRptBK02` |
| Tổng hợp phát sinh nhóm theo chỉ tiêu | 02.25.29 | `gl.rpt.th01` | `Gl\GlReportIndex` | `asGLRptTH01` |
| Bảng kê thuế mua vào | 02.40.02 | `gl.rpt.bct01` | `Gl\GlReportIndex` | `asGLRptBCT01` |
| Bảng kê thuế bán ra | 02.40.05 | `gl.rpt.bct02` | `Gl\GlReportIndex` | `asGLRptBCT02` |
| Tờ khai thuế GTGT | 02.40.08 | `gl.rpt.bct03` | `Gl\GlReportIndex` | `asGLRptBCT03` |
| Tờ khai thuế TNDN tạm tính | 02.40.14 | `gl.rpt.bct04` | `Gl\GlReportIndex` | `asGLRptBCT04` |
| Tờ khai quyết toán thuế TNDN | 02.40.17 | `gl.rpt.bct05` | `Gl\GlReportIndex` | `asGLRptBCT05` |
| Phụ lục kết quả HĐKD | 02.40.20 | `gl.rpt.bct06` | `Gl\GlReportIndex` | `asGLRptBCT06` |
| Bảng cân đối số phát sinh | 02.50.02 | `gl.rpt.bctc01` | `Gl\GlReportIndex` | `asGLRptBCTC01` |
| Bảng cân đối kế toán | 02.50.05 | `gl.rpt.bctc02` | `Gl\GlReportIndex` | `asGLRptBCTC02` |
| Báo cáo kết quả HĐKD | 02.50.08 | `gl.rpt.bctc03` | `Gl\GlReportIndex` | `asGLRptBCTC03` |
| Báo cáo lưu chuyển tiền tệ trực tiếp | 02.50.11 | `gl.rpt.bctc04` | `Gl\GlReportIndex` | `asGLRptBCTC04` |
| Thuyết minh báo cáo tài chính | 02.50.20 | `gl.rpt.tmbctc` | `Gl\GlReportIndex` | `asGLRptBCTCTM` |
| Nguồn vốn đầu tư | 02.55.02 | `gl.rpt.bctccdtb02` | `Gl\GlReportIndex` | `asGLRptBCTCCDTB02` |
| Chi tiết nguồn vốn đầu tư | 02.55.05 | `gl.rpt.bctccdtf02` | `Gl\GlReportIndex` | `asGLRptBCTCCDTf02` |
| Thực hiện đầu tư theo dự án | 02.55.08 | `gl.rpt.bctccdtf03a` | `Gl\GlReportIndex` | `asGLRptBCTCCDTf03A` |
| Quyết toán đầu tư theo dự án | 02.55.11 | `gl.rpt.bctccdtf03b` | `Gl\GlReportIndex` | `asGLRptBCTCCDTf03B` |
| Thực hiện đầu tư | 02.55.14 | `gl.rpt.bctccdtb03` | `Gl\GlReportIndex` | `asGLRptBCTCCDTB03` |
| Chi phí khác | 02.55.17 | `gl.rpt.bctccdtf03c` | `Gl\GlReportIndex` | `asGLRptBCTCCDTf03C` |
| Chi phí ban quản lý dự án | 02.55.20 | `gl.rpt.bctccdtf03d` | `Gl\GlReportIndex` | `asGLRptBCTCCDTf03D` |
| Thẻ tài sản cố định | 20.20.02 | `fa.rpt.bcts01` | `Fa\FaReportIndex` | `asFARptBCTS01` |
| Sổ tài sản cố định | 20.20.05 | `fa.rpt.bcts08` | `Fa\FaReportIndex` | `asFARptBCTS08` |
| Sổ theo dõi TSCĐ và CCDC | 20.20.08 | `fa.rpt.bcts09` | `Fa\FaReportIndex` | `asFARptBCTS09` |
| Bảng tính khấu hao tài sản | 20.20.11 | `fa.rpt.bcts04` | `Fa\FaReportIndex` | `asFARptBCTS04` |
| Bảng phân bổ khấu hao tài sản | 20.20.14 | `fa.rpt.bcts05` | `Fa\FaReportIndex` | `asFARptBCTS05` |
| Báo cáo tăng giảm tài sản | 20.20.17 | `fa.rpt.bcts06` | `Fa\FaReportIndex` | `asFARptBCTS06` |
| Báo cáo chi tiết kiểm kê tài sản | 20.20.20 | `fa.rpt.bcts07` | `Fa\FaReportIndex` | `asFARptBCTS07` |
| Sổ chi tiết công cụ dụng cụ | 20.30.02 | `fa.rpt.bcpt10` | `Fa\FaReportIndex` | `asFARptBCPT10` |
| Bảng kê phiếu nhập CCDC | 20.30.08 | `fa.rpt.bkn04` | `Fa\FaReportIndex` | `asINRptBKN04` |
| Tổng hợp hàng nhập CCDC | 20.30.11 | `fa.rpt.thn01` | `Fa\FaReportIndex` | `asINRptTHN01` |
| Bảng kê phiếu xuất CCDC | 20.30.14 | `fa.rpt.bkx04` | `Fa\FaReportIndex` | `asINRptBKX04` |
| Tổng hợp hàng xuất CCDC | 20.30.17 | `fa.rpt.thx01` | `Fa\FaReportIndex` | `asINRptTHX01` |
| CO Bảng kê chứng từ | 17.60.02 | `co.rpt.bk02` | `Co\CoReportIndex` | `asGLRptBK02` |
| CO Tổng hợp phát sinh nhóm | 17.60.05 | `co.rpt.th01` | `Co\CoReportIndex` | `asGLRptTH01` |
| Bảng tính phân bổ chi phí trả trước | 17.60.08 | `co.rpt.khcp` | `Co\CoReportIndex` | `asCoRptKHCPTT` |
| Thẻ giá thành | 18.20.02 | `co.rpt.gt01` | `Co\CoReportIndex` | `asCORptGt01` |
| Bảng giá thành sản phẩm | 18.20.05 | `co.rpt.gt02` | `Co\CoReportIndex` | `asCORptGt02` |
| CO Bảng kê phiếu nhập | 18.20.14 | `co.rpt.bkn04` | `Co\CoReportIndex` | `asINRptBKN04` |
| CO Tổng hợp hàng nhập | 18.20.17 | `co.rpt.thn01` | `Co\CoReportIndex` | `asINRptTHN01` |
| CO Tổng hợp hàng nhập hai chỉ tiêu | 18.20.18 | `co.rpt.thn02` | `Co\CoReportIndex` | `asINRptTHN02` |
| CO Bảng kê phiếu xuất | 18.20.20 | `co.rpt.bkx04` | `Co\CoReportIndex` | `asINRptBKX04` |
| CO Tổng hợp hàng xuất | 18.20.23 | `co.rpt.thx01` | `Co\CoReportIndex` | `asINRptTHX01` |
| CO Tổng hợp hàng xuất hai chỉ tiêu | 18.20.26 | `co.rpt.thx02` | `Co\CoReportIndex` | `asINRptTHX02` |
| Bảng giá thành công trình | 18.25.02 | `co.rpt.gt03` | `Co\CoReportIndex` | `asCORptGt03` |
| Bảng giá thành công trình có dự toán | 18.25.08 | `co.rpt.gt03-dutoan` | `Co\CoReportIndex` | `asCORptGt03` |
| Báo cáo lãi lỗ theo công trình | 18.25.11 | `co.rpt.gt03-lailo` | `Co\CoReportIndex` | `asCORptGt03` |
| Cân đối phát sinh công nợ theo công trình | 18.25.14 | `co.rpt.bccn04` | `Co\CoReportIndex` | `asARRptBCCN04` |
| Thẻ kho/Sổ chi tiết vật tư | 14.20.02 | `in.rpt.ctvt01` | `In\Baocao\InReportIndex` | `asINRptCTVT01` |
| Thẻ kho/Sổ chi tiết vật tư in tất cả | 14.20.05 | `in.rpt.ctvt02` | `In\Baocao\InReportIndex` | `asINRptCTVT02` |
| Tổng hợp nhập xuất tồn | 14.20.08 | `in.rpt.cd01` | `In\Baocao\InReportIndex` | `asINRptCD01` |
| Báo cáo tồn kho | 14.20.11 | `in.tonkho` | `In\Baocao\Tonkho` | `asINRptCD02` |
| Bảng kê phiếu nhập | 14.20.14 | `in.rpt.bkn04` | `In\Baocao\InReportIndex` | `asINRptBKN04` |
| Tổng hợp hàng nhập | 14.20.17 | `in.rpt.thn01` | `In\Baocao\InReportIndex` | `asINRptTHN01` |
| Tổng hợp hàng nhập hai chỉ tiêu | 14.20.18 | `in.rpt.thn02` | `In\Baocao\InReportIndex` | `asINRptTHN02` |
| Bảng kê phiếu xuất | 14.20.20 | `in.rpt.bkx04` | `In\Baocao\InReportIndex` | `asINRptBKX04` |
| Tổng hợp hàng xuất | 14.20.23 | `in.rpt.thx01` | `In\Baocao\InReportIndex` | `asINRptTHX01` |
| Tổng hợp hàng xuất hai chỉ tiêu | 14.20.24 | `in.rpt.thx02` | `In\Baocao\InReportIndex` | `asINRptTHX02` |
| Thông tin tính giá NTXT | 14.20.26 | `in.rpt.bk01` | `In\Baocao\InReportIndex` | `asINRptBK01` |
| Bảng giá trung bình | 14.20.56 | `in.rpt.banggiatb` | `In\Baocao\InReportIndex` | `asINRptBangGiaTB` |
| Bảng kê mua hàng | 10.20.02 | `po.rpt.bk01` | `Muahang\PoReportIndex` | `asPORptBK01` |
| Bảng kê mua hàng nhóm theo chỉ tiêu | 10.20.05 | `po.rpt.bk02` | `Muahang\PoReportIndex` | `asPORptBK02` |
| Tổng hợp mua hàng | 10.20.08 | `po.rpt.th01` | `Muahang\PoReportIndex` | `asPORptTH01` |
| Tổng hợp mua hàng theo kỳ | 10.20.11 | `po.rpt.th02` | `Muahang\PoReportIndex` | `asPORptTH02` |
| Bảng kê chi phí mua hàng | 10.20.20 | `po.rpt.bk03` | `Muahang\PoReportIndex` | `asPORptBK03` |
| Tổng hợp chi phí mua hàng | 10.20.23 | `po.rpt.th03` | `Muahang\PoReportIndex` | `asPORptTH03` |
| Báo cáo mua hàng theo hai chỉ tiêu | 10.20.26 | `po.rpt.bcpt03` | `Muahang\PoReportIndex` | `asPORptBCPT03` |
| Sổ nhật ký mua hàng | 10.20.32 | `po.rpt.nkc05` | `Muahang\PoReportIndex` | `asGLRptNKC05` |
| Bảng kê hóa đơn phải thu | 06.30.02 | `ar.rpt.bk01` | `Banhang\ArReportIndex` | `asARRptBK01` |
| AR Sổ chi tiết công nợ một khách hàng | 06.30.14 | `ar.rpt.bccn01` | `Banhang\ArReportIndex` | `asARRptBCCN01` |
| AR Sổ chi tiết công nợ nhiều khách hàng | 06.30.17 | `ar.rpt.bccn01a` | `Banhang\ArReportIndex` | `asARRptBCCN01a` |
| AR Bảng cân đối phát sinh công nợ | 06.30.20 | `ar.rpt.bccn02` | `Banhang\ArReportIndex` | `asARRptBCCN02` |
| AR Tổng hợp số dư công nợ một tài khoản | 06.30.23 | `ar.rpt.bccn03` | `Banhang\ArReportIndex` | `asARRptBCCN03` |
| AR Biên bản đối chiếu công nợ tổng hợp | 06.30.26 | `ar.rpt.bccn05` | `Banhang\ArReportIndex` | `asARRptBCCN05` |
| AR Bảng cân đối công nợ theo chỉ tiêu | 06.30.35 | `ar.rpt.bccn04` | `Banhang\ArReportIndex` | `asARRptBCCN04` |
| AR Sổ chi tiết công nợ có số lượng | 06.30.38 | `ar.rpt.bccn01sl` | `Banhang\ArReportIndex` | `asARRptBCCN01SL` |
| AR Sổ chi tiết công nợ nhiều khách hàng liên tục | 06.30.41 | `ar.rpt.bccn01a-cont` | `Banhang\ArReportIndex` | `asARRptBCCN01a` |
| AR Tổng hợp số dư đầu | 06.30.44 | `ar.rpt.bccn03-open` | `Banhang\ArReportIndex` | `asARRptBCCN03` |
| AR Tổng hợp số dư cuối | 06.30.47 | `ar.rpt.bccn03-close` | `Banhang\ArReportIndex` | `asARRptBCCN03` |
| AR Biên bản đối chiếu công nợ chi tiết | 06.30.50 | `ar.rpt.bccn05-detail` | `Banhang\ArReportIndex` | `asARRptBCCN05` |
| Bảng kê hóa đơn phải trả | 10.30.02 | `ap.rpt.bk01` | `Muahang\ApReportIndex` | `asAPRptBK01` |
| AP Sổ chi tiết công nợ một nhà cung cấp | 10.30.11 | `ap.rpt.bccn01` | `Muahang\ApReportIndex` | `asARRptBCCN01` |
| AP Sổ chi tiết công nợ nhiều nhà cung cấp | 10.30.14 | `ap.rpt.bccn01a` | `Muahang\ApReportIndex` | `asARRptBCCN01a` |
| AP Bảng cân đối phát sinh công nợ | 10.30.17 | `ap.rpt.bccn02` | `Muahang\ApReportIndex` | `asARRptBCCN02` |
| AP Tổng hợp số dư công nợ một tài khoản | 10.30.20 | `ap.rpt.bccn03` | `Muahang\ApReportIndex` | `asARRptBCCN03` |
| AP Sổ chi tiết công nợ có số lượng | 10.30.23 | `ap.rpt.bccn01sl` | `Muahang\ApReportIndex` | `asARRptBCCN01SL` |
| AP Biên bản đối chiếu công nợ tổng hợp | 10.30.26 | `ap.rpt.bccn05` | `Muahang\ApReportIndex` | `asARRptBCCN05` |
| AP Sổ chi tiết công nợ nhiều nhà cung cấp liên tục | 10.30.27 | `ap.rpt.bccn01a-cont` | `Muahang\ApReportIndex` | `asARRptBCCN01a` |
| AP Bảng cân đối công nợ theo chỉ tiêu | 10.30.35 | `ap.rpt.bccn04` | `Muahang\ApReportIndex` | `asARRptBCCN04` |
| AP Tổng hợp số dư đầu | 10.30.44 | `ap.rpt.bccn03-open` | `Muahang\ApReportIndex` | `asARRptBCCN03` |
| AP Tổng hợp số dư cuối | 10.30.47 | `ap.rpt.bccn03-close` | `Muahang\ApReportIndex` | `asARRptBCCN03` |
| AP Biên bản đối chiếu công nợ chi tiết | 10.30.50 | `ap.rpt.bccn05-detail` | `Muahang\ApReportIndex` | `asARRptBCCN05` |
| Bảng kê bán hàng | 06.20.02 | `so.rpt.bk01` | `Banhang\SoReportIndex` | `asSORptBK01` |
| Bảng kê bán hàng nhóm theo chỉ tiêu | 06.20.05 | `so.rpt.bk02` | `Banhang\SoReportIndex` | `asSORptBK02` |
| Tổng hợp bán hàng | 06.20.08 | `so.rpt.th01` | `Banhang\SoReportIndex` | `asSORptTH01` |
| Tổng hợp bán hàng theo kỳ | 06.20.11 | `so.rpt.th02` | `Banhang\SoReportIndex` | `asSORptTH02` |
| Lãi lỗ mặt hàng | 06.20.20 | `so.rpt.bcpt03` | `Banhang\SoReportIndex` | `asSORptBCPT03` |
| Doanh số bán hàng theo bộ phận | 06.20.23 | `so.rpt.bcpt04` | `Banhang\SoReportIndex` | `asSORptBCPT04` |
| Báo cáo bán hàng theo hai chỉ tiêu | 06.20.26 | `so.rpt.bcpt06` | `Banhang\SoReportIndex` | `asSORptBCPT06` |
| Lãi lỗ theo hợp đồng | 06.20.47 | `so.rpt.lailo` | `Banhang\SoReportIndex` | `asSORptLaiLoHopDong` |
| Sổ nhật ký bán hàng | 06.20.50 | `so.rpt.nkc04` | `Banhang\SoReportIndex` | `asGLRptNKC04` |
| Lãi lỗ mặt hàng lãi ròng | 06.20.83 | `so.rpt.bcpt03-net` | `Banhang\SoReportIndex` | `asSORptBCPT03` |
| Doanh số bán hàng theo nhân viên | 06.20.86 | `so.rpt.bcpt04-nv` | `Banhang\SoReportIndex` | `asSORptBCPT04` |
| Tổng hợp lãi lỗ theo hợp đồng | 06.20.89 | `so.rpt.lailo-th` | `Banhang\SoReportIndex` | `asSORptLaiLoHopDong02` |

Immediate mismatch:

- Existing route names are app-specific and not consistently linked to `menuid`.
- `System\SimbaMenuTree` previously read `SysMenu` over `sqlsrv`; fixed to read `simba-docs/data`.
- `ca.nganhang.quy` previously called `asCARptTMNH01`; fixed to `asCARptTMNH02` per `sysReportInfo`.
- Legacy route `ar.cungcap` is now registered as a PO supplier alias to `10.90.22`.
- Supplier list now uses `asARGetDMKH` with `pModuleId = AP`, same ARDMKH dictionary source as `MA_NCC`.
- Dictionary registry now covers current GL/AR/PO/IN master-data routes and checks table, PK, menuid, carry fields against `sysDictionaryInfo`.
- Task 063 wording says "chương trình mua hàng", but source of truth maps `PODMCP/MA_CP/10.90.14` to "Chi phí mua hàng"; implementation follows `sysDictionaryInfo` and `sysMenu`.
- `gl.rpt.bctc05` / `02.50.14` has `sysReportInfo` but inactive `sysMenu`, so no route is opened.
- FA report rows marked with `*` in `sysMenu` are inactive and are not opened.

---

## 3. Voucher matrix from `SiDmCt.md`

Unique voucher codes: 51.

| ma_ct | module | name | ph | ct | menuid | Current route |
|---|---|---|---|---|---:|---|
| AP1 | PO | Phiếu chi tiền hàng | apPh1 | apCt1 | 12.10.01 | Blocked: no `sysVoucherInfo`; CA payment flow overlaps |
| AP2 | PO | Phiếu chi tiền hàng qua NH | apPh1 | apCt1 | 12.10.02 | Blocked: no `sysVoucherInfo`; CA payment flow overlaps |
| AP3 | PO | Điều chỉnh công nợ phải trả | apPh3 | apCt3 | 12.10.03 | Blocked: no `sysVoucherInfo` |
| AP4 | AP | Phiếu bù trừ công nợ phải trả | apPh4 | apCt4 | 10.10.38 | `ap.vch.ap4` |
| AR1 | SO | Phiếu thu tiền hàng | arPh1 | arCt1 | 08.10.01 | Blocked: no `sysVoucherInfo`; CA receipt flow overlaps |
| AR2 | SO | Phiếu thu tiền hàng qua NH | arPh1 | arCt1 | 08.10.06 | Blocked: no `sysVoucherInfo`; CA receipt flow overlaps |
| AR3 | SO | Điều chỉnh công nợ phải thu | arPh3 | arCt3 | 08.10.02 | Blocked: no `sysVoucherInfo` |
| AR4 | AR | Phiếu bù trừ công nợ phải thu | arPh4 | arCt4 | 06.10.29 | `ar.vch.ar4` |
| CA1 | CA | Phiếu thu | caPh1 | caCt1 | 04.10.02 | `ca.tienmat.thu` |
| CA2 | CA | Phiếu chi | caPh2 | caCt2 | 04.10.05 | `ca.tienmat.chi` |
| CA3 | CA | Báo có | caPh1 | caCt1 | 04.10.08 | `ca.nganhang.baoco` |
| CA4 | CA | Báo nợ | caPh2 | caCt2 | 04.10.11 | `ca.nganhang.baono` |
| CA5 | CA | Phiếu thanh toán | caPh3 | caCt3 | 04.10.11 | Blocked: `sysVoucherInfo` menu `04.10.14`, but `sysMenu` row inactive |
| CA6 | CA | Lãi suất khế ước |  |  | 04.10.35 | Blocked: no `sysVoucherInfo`; related `sysMenu` rows inactive |
| GL1 | GL | Phiếu kế toán | glPh1 | glCt1 | 02.10.02 | `gl.vch.gl1` |
| NB1 | GL | Chứng từ ngoại bảng |  |  | 02.10.17 | `gl.vch.nb1`; `sysVoucherInfo` dùng bảng `GLNB` |
| IN1 | IN | Phiếu nhập kho | inPh1 | inCt1 | 14.10.02 | `in.vch.in1` |
| IN2 | IN | Phiếu xuất kho | inPh2 | inCt2 | 14.10.05 | `in.vch.in2` |
| IN3 | IN | Phiếu xuất chuyển kho | inPh3 | inCt3 | 14.10.08 | `in.vch.in3` |
| IN4 | IN | Phiếu nhập điều chuyển | inPh3 | inCt3 | 14.10.08 | `in.vch.in4` |
| IN5 | IN | Phiếu xuất công cụ dụng cụ | inPh5 | inCt5 | 14.10.11 | `in.vch.in5` |
| IN6 | IN | Lắp ráp, tháo dỡ | inPh6 | inCt6 |  | `in.vch.in6`; active menu/sysVoucherInfo `14.10.14` |
| IN9 | IN | Điều chỉnh kiểm kê cuối kỳ | inPh9 | inCt9 | 14.10.34 | Blocked: `sysMenu` inactive/no `sysVoucherInfo` |
| PO0 | PO | Phiếu đề nghị mua hàng | poPh0 | poCt0 | 10.10.01 | Blocked: `sysMenu` row inactive/mismatch |
| PO1 | PO | Đơn hàng mua | poPh1 | poCt1 | 10.10.02 | `muahang.po1`; active menu `10.10.05` |
| PO2 | PO | Phiếu nhập mua | poPh2 | poCt2 | 10.10.04 | Blocked: `sysMenu` row inactive/mismatch |
| PO3 | PO | Hoá đơn mua hàng trong nước | poPh3 | poCt3 | 10.10.14 | `muahang.hoadonmua` |
| PO4 | PO | Phiếu chi phí mua hàng | poPh4 | poCt4 | 10.10.20 | `muahang.po4` |
| PO5 | PO | Phiếu xuất trả lại nhà cung cấp | poPh5 | poCt5 | 10.10.23 | `muahang.po5` |
| PO6 | PO | Hoá đơn mua dịch vụ | poPh6 | poCt6 | 10.10.26 | `muahang.po6` |
| PO7 | PO | Hoá đơn mua hàng nhập khẩu | poPh3 | poCt3 | 10.10.17 | `muahang.po7` |
| PO8 | PO | Phiếu nhập mua xuất thẳng | poPh3 | poCt3 | 10.10.05 | Blocked: `sysMenu` row inactive/mismatch |
| SO0 | SO | Kế hoạch bán hàng | soPh0 | soCt0 | 06.10.12 | Blocked: no `sysVoucherInfo` |
| SO1 | SO | Đơn đặt hàng | soPh1 | soCt1 | 06.10.01 | `banhang.so1`; active menu/sysVoucherInfo `06.10.02` |
| SO2 | SO | Phiếu xuất bán hàng | soPh2 | soCt2 | 06.10.02 | Blocked: `sysMenu` inactive/no `sysVoucherInfo` |
| SO3 | SO | Hoá đơn bán hàng | soPh3 | soCt3 | 06.10.08 | `ar.ph.hdbh` |
| SO4 | SO | Phiếu nhập hàng bán bị trả lại | soPh4 | soCt4 | 06.10.11 | `banhang.so4` |
| SO5 | SO | Hoá đơn dịch vụ | soPh5 | soCt5 | 06.10.14 | `banhang.so5` |

Process vouchers without `ph/ct` table in `SiDmCt.md` must be implemented only after source DLL/procedure audit:

`CO1`, `CO2`, `CO3`, `CR1`, `FA1`, `FA2`, `GL2`, `GL3`, `GL4`, `GL5`, `MM3`, `TAI`, `TAO`, plus `IN6` missing menuid.

---

## 4. First implementation batch from matrix

Batch B should fix foundation inconsistencies before adding new forms:

1. [x] Rename or alias supplier route from `ar.cungcap` to PO-scoped route while preserving backward compatibility.
2. [x] Add explicit route/menu metadata map for implemented routes (`menuid`, `ma_ct` or dictionary key).
3. [x] Continue active PO voucher family after PO3: `PO1`, `PO4`, `PO5`, `PO6`, `PO7`.
4. [ ] Resolve inactive/mismatched PO vouchers before routing: `PO0`, `PO2`, `PO8`.
5. [ ] For each voucher, verify `sysVoucherInfo.md` has `ph_table_name`, `ct_table_name`, optional `cp_table_name` before creating edit UI.

## 5. Dynamic docs-backed coverage

Ngay 2026-05-15, route registry duoc mo rong tu source docs:

- `SimbaReportRegistry` giu cac route ten than thien da khai bao tay, sau do tu dong bo sung report route cho moi active menu co row trong `sysReportInfo.md` hoac `zSysReportInfo.md`.
- `SimbaDictionaryRegistry` giu cac route danh muc da khai bao tay, sau do tu dong bo sung dictionary route cho moi active menu co row trong `sysDictionaryInfo.md`.
- `SimbaRouteRegistry` gom ca static routes va dynamic routes; hien tai co 302 route anchors docs-backed.
- `System\SimbaMenuTree` hien link truc tiep cho menu da map. Static route se mo route cu; dynamic report/dictionary route se mo qua `simba.report` hoac `simba.dictionary`.
- Dynamic report/dictionary shell chi hien metadata docs-backed. Filter, payload, save/delete va goi SP chua duoc mo neu chua doi chieu tham so trong `simba-docs`.
- F5/drilldown routes trong `sysReportDrillDownInfo.md` duoc phan loai la `report` va mo qua `simba.report`, chi hien DLL/command/source menu/key F5 cho den khi audit du tham so va logic.
- Active master-data menu co `code_name` khop `sysDictionaryInfo` nhung menuid trong source bi trong/lẹch duoc mo qua `simba.dictionary` voi `source_menuid`; khong mo CRUD cho den khi audit payload va quyen sua/xoa.
- Master-data menu co DLL/code khop `sysDictionaryInfo.table_name` cung duoc mo qua `simba.dictionary` voi `source_menuid`, vi day la source table ro rang nhung menuid trong dictionary bi trong/lẹch.
- Master-data menu co `sysReportInfo` nhung khong co dictionary metadata sach duoc mo qua `simba.report` nhu list/report shell read-only; dictionary exact/alias luon duoc uu tien truoc report/list. Menu F5 co `sysMenu.report = 1` cung duoc mo nhu report/list shell khi co `sysReportInfo`.
- `SimbaProcessRegistry` bo sung read-only shell cho active menu co DLL/command/code_name nhung khong co metadata report/dictionary/voucher du chuan. Process shell mo qua `simba.process`, chi hien anchor ky thuat va chan execute.

Kiem chung:

- `php -l` pass cho cac file registry/component moi sua.
- `phpunit` pass cho route/report/dictionary/process/voucher/menu repository tests.
- `LOG_CHANNEL=stderr php artisan route:list --name=simba` load duoc 3 generic shell routes: `simba.dictionary`, `simba.report`, `simba.process`.
- Them test coverage bat buoc: moi active menu co metadata report/dictionary/voucher hoac co DLL/command/code_name phai co route anchor trong `SimbaRouteRegistry`.
- Dynamic report khong tu mo route cho voucher menu, de tranh phan loai sai cac dong in chung tu trong `sysReportInfo`; da co test rieng bat report route phai gan voi menu type report.
- Process shell khong duoc duplicate menu da co report/dictionary/voucher route; da co test rieng bat regression nay.
- Kiem chung moi nhat: 29 tests, 2805 assertions.

Con lai sau dynamic coverage:

- `SimbaRouteRegistry::routes()` hien co 302 route anchors.
- 57 active menu chua co route anchor; day la root/group/section menu hoac dong trong `sysMenu` khong co DLL/command/code_name de gan route an toan.
- Process dang bi chan o shell den khi audit du DLL/command/procedure/payload trong `simba-docs`: GL transfer/posting, IN tinh gia/chuyen ton, CO tinh gia thanh/phan bo/post sang GL, FA tinh/xoa khau hao/chuyen GL, SI maintenance/backup/sync tools.
