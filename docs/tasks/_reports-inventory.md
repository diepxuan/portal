# Toàn bộ task BÁO CÁO — 133 task

> Sinh từ `docs/tasks/**`, nhận diện theo `Loại: Report/RPT`, `DLL: *Rpt*`, hoặc route `.rpt.`.
> Status lấy **thật** từ field `**Status:**` (sau P2 — PR #303).
> Route đã chuẩn hóa theo `sysMenu` (`{module}.{kind}.{slug}` từ `dllName`).

## Tổng quan theo trạng thái

| Trạng thái | Số task | Ý nghĩa |
|---|---:|---|
| **DONE** | 5 | Có component thật, **chạy được** (verify browser) |
| **SHELL_ONLY** | 127 | Chỉ route anchor/metadata shell — **CHƯA có màn hình báo cáo** |
| **PENDING** | 1 | Chưa làm |
| **Tổng** | **133** | |

## Tổng quan theo module

| Module | Số task báo cáo |
|---|---:|
| GL | 57 |
| FA | 19 |
| IN | 12 |
| KHAC | 12 |
| SO | 11 |
| AR | 10 |
| PO | 8 |
| AP | 1 |
| CA | 1 |
| CO | 1 |
| SI | 1 |

---

## AP — 1 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 019 | APRptBK | APRptBK01, APRptBK02, APRptBK0 | — | SHELL_ONLY | root |

## AR — 10 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 004 | ARCDKH | ARCDKH | — | SHELL_ONLY | root |
| 008 | AR/ARBCCN01 — Sổ chi tiết công nợ một khách hàng ( | ARRptBCCN01, ARRptBCCN01a | `so.rpt.arrptbccn01` | DONE | phase 1 |
| 009 | ARRptBCCN02 | ARRptBCCN02, ARRptBCCN03 | — | SHELL_ONLY | root |
| 010 | ARRptBCCN04 | ARRptBCCN04 | — | SHELL_ONLY | root |
| 011 | ARRptBCCN05 | ARRptBCCN05 | — | SHELL_ONLY | root |
| 012 | ARRptBCCN06 | ARRptBCCN06 | — | SHELL_ONLY | root |
| 013 | ARRptBK01 | ARRptBK01 | — | SHELL_ONLY | root |
| 014 | ARRptBK02 | ARRptBK02 | — | SHELL_ONLY | root |
| 015 | ARRptBK03 | ARRptBK03 | — | SHELL_ONLY | root |
| 158 | AR-Rpt-F5-BCCN01a-DrillDown | ArRptF5BCCN01a | `task.shell.158` | SHELL_ONLY | root |

## CA — 1 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 159-165 | CA-RptTMNH-BaoCaoTienMatNganHang | — | — | SHELL_ONLY | root |

## CO — 1 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 168-180 | CO-BaoCao-SanXuat | — | `task.shell.168` | SHELL_ONLY | root |

## FA — 19 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 118 | FARptBCTS09 | FARptBCTS09 | — | SHELL_ONLY | root |
| 120 | FARptBCTS07 | FARptBCTS07 | — | SHELL_ONLY | root |
| 121 | FARptBCPT02 | FARptBCPT02 | `fa.rpt shell` | SHELL_ONLY | root |
| 122 | FARptBCPT05 | FARptBCPT05 | `fa.rpt shell` | SHELL_ONLY | root |
| 123 | FARptSoTSCD | FARptSoTSCD | `fa.rpt.bcts08` | SHELL_ONLY | root |
| 125 | FABHCC | FABHCC | `fa.rpt.bcts05` | SHELL_ONLY | root |
| 126 | FARptBCPT03 | FARptBCPT03 | `fa.rpt shell` | SHELL_ONLY | root |
| 127 | FARptBCTS06 | FARptBCTS06 | — | SHELL_ONLY | root |
| 128 | FARptBCTS01 | FARptBCTS01 | — | SHELL_ONLY | root |
| 130 | FARptBCTS08 | FARptBCTS08 | — | SHELL_ONLY | root |
| 137 | FARptBCPT09 | FARptBCPT09 | `fa.rpt shell` | SHELL_ONLY | root |
| 245 | FARptBCPT01 | FARptBCPT01 | `fa.rpt.bcpt01` | SHELL_ONLY | root |
| 246 | FARptBCPT06 | FARptBCPT06 | `fa.rpt.bcpt06` | SHELL_ONLY | root |
| 247 | FARptBCPT07 | FARptBCPT07 | `fa.rpt.bcpt07` | SHELL_ONLY | root |
| 248 | FARptBCPT08 | FARptBCPT08 | `fa.rpt.bcpt08` | SHELL_ONLY | root |
| 249 | FARptBCPT10 | FARptBCPT10 | — | SHELL_ONLY | root |
| 250 | FARptBCTS04 | FARptBCTS04 | — | SHELL_ONLY | root |
| 251 | FARptBCTS05 | FARptBCTS05 | — | SHELL_ONLY | root |
| 252 | FARptSoSD | FARptSoSD | `gl.task.252` | SHELL_ONLY | root |

## GL — 57 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 139 | GLRptBCTCCDTB02 | GLRptBCTCCDTB02 | — | SHELL_ONLY | root |
| 141 | GLRptF5CTGS03 | GLRptF5CTGS03 | `gl.task.141` | SHELL_ONLY | root |
| 142 | GLRptBCTCCDTF03B | GLRptBCTCCDTF03B | `gl.rpt.glrptbctccdtf03b` | SHELL_ONLY | root |
| 144 | GLRptTH01 | GLRptTH01 | — | SHELL_ONLY | root |
| 149 | GLRptBCT03 | GLRptBCT03 | — | SHELL_ONLY | root |
| 154 | GLRptBCTCCR01 | GLRptBCTCCR01 | `gl.rpt.glrptbctccr01` | SHELL_ONLY | root |
| 255 | GLDKCTGS | GLDKCTGS | `gl.rpt.gldkctgs` | SHELL_ONLY | root |
| 256 | GLDMCTGS | GLDMCTGS | `gl.rpt.gldmctgs` | SHELL_ONLY | root |
| 287 | GLRptBCPT01 | GLRptBCPT01 | `gl.task.287` | SHELL_ONLY | root |
| 288 | GLRptBCPT02 | GLRptBCPT02 | `gl.rpt.glrptbcpt02` | SHELL_ONLY | root |
| 289 | GLRptBCPT03 | GLRptBCPT03 | `gl.rpt.glrptbcpt03` | SHELL_ONLY | root |
| 290 | GLRptBCPT04 | GLRptBCPT04 | `gl.rpt.glrptbcpt04` | SHELL_ONLY | root |
| 291 | GLRptBCPT05 | GLRptBCPT05 | `gl.rpt.glrptbcpt05` | SHELL_ONLY | root |
| 292 | GLRptBCT01 | GLRptBCT01 | — | SHELL_ONLY | root |
| 293 | GLRptBCT02 | GLRptBCT02 | — | SHELL_ONLY | root |
| 294 | GLRptBCTCCDTB03 | GLRptBCTCCDTB03 | — | SHELL_ONLY | root |
| 295 | GLRptBCTCCDTF02 | GLRptBCTCCDTF02 | `gl.rpt.glrptbctccdtf02` | SHELL_ONLY | root |
| 296 | GLRptBCTCCDTF03A | GLRptBCTCCDTF03A | `gl.rpt.glrptbctccdtf03a` | SHELL_ONLY | root |
| 297 | GLRptBCTCCDTF03C | GLRptBCTCCDTF03C | `gl.rpt.glrptbctccdtf03c` | SHELL_ONLY | root |
| 298 | GLRptBCTCCDTF03D | GLRptBCTCCDTF03D | `gl.rpt.glrptbctccdtf03d` | SHELL_ONLY | root |
| 299 | GLRptBCTCCR02 | GLRptBCTCCR02 | `gl.rpt.glrptbctccr02` | SHELL_ONLY | root |
| 300 | GLRptBCTCCR03 | GLRptBCTCCR03 | `gl.rpt.glrptbctccr03` | SHELL_ONLY | root |
| 301 | GLRptBCTCCR04 | GLRptBCTCCR04 | `gl.rpt.glrptbctccr04` | SHELL_ONLY | root |
| 302 | GLRptBk02 | GLRptBk02 | `gl.task.302` | SHELL_ONLY | root |
| 303 | GLRptCTGS01 | GLRptCTGS01 | — | SHELL_ONLY | root |
| 304 | GLRptCTGS02 | GLRptCTGS02 | — | SHELL_ONLY | root |
| 305 | GLRptCTGS03 | GLRptCTGS03 | — | SHELL_ONLY | root |
| 306 | GLRptCTGS05 | GLRptCTGS05 | — | SHELL_ONLY | root |
| 307 | GLRptF5BCPT08 | GLRptF5BCPT08 | `gl.task.307` | SHELL_ONLY | root |
| 308 | GLRptF5BCTC02 | GLRptF5BCTC02 | `gl.task.308` | SHELL_ONLY | root |
| 309 | GLRptF5BCTC02CT | GLRptF5BCTC02CT | `gl.task.309` | SHELL_ONLY | root |
| 310 | GLRptF5BCTC03CT | GLRptF5BCTC03CT | `gl.task.310` | SHELL_ONLY | root |
| 311 | GLRptF5CTGS01 | GLRptF5CTGS01 | `gl.task.311` | SHELL_ONLY | root |
| 312 | GLRptF5CTGS02 | GLRptF5CTGS02 | `gl.task.312` | SHELL_ONLY | root |
| 313 | GLRptNKC08 | GLRptNKC08 | `gl.task.313` | SHELL_ONLY | root |
| 314 | GLRptNKCTNK1 | GLRptNKCTNK1 | `gl.task.314` | SHELL_ONLY | root |
| 315 | GLRptNKCTSoCai | GLRptNKCTSoCai | `gl.task.315` | SHELL_ONLY | root |
| 316 | GLRptTMBCTC | GLRptTMBCTC | `gl.rpt.glrpttmbctc` | SHELL_ONLY | root |
| 319 | GlRptBCT04 | GlRptBCT04 | `gl.rpt.glrptbct04` | SHELL_ONLY | root |
| 320 | GlRptBCT05 | GlRptBCT05 | `gl.rpt.glrptbct05` | SHELL_ONLY | root |
| 321 | GlRptBCT06 | GlRptBCT06 | `gl.rpt.glrptbct06` | SHELL_ONLY | root |
| 322 | GlRptBcpt08 | GlRptBcpt08 | `gl.rpt.glrptbcpt08` | SHELL_ONLY | root |
| 323 | GlRptBctc01 | GlRptBctc01 | `gl.rpt.glrptbctc01` | SHELL_ONLY | root |
| 324 | GlRptBctc02 | GlRptBctc02 | `gl.rpt.glrptbctc02` | SHELL_ONLY | root |
| 325 | GlRptBctc03 | GlRptBctc03 | `gl.rpt.glrptbctc03` | SHELL_ONLY | root |
| 326 | GlRptBctc04 | GlRptBctc04 | `gl.rpt.glrptbctc04` | SHELL_ONLY | root |
| 327 | GlRptBk01 | GlRptBk01 | `gl.rpt.glrptbk01` | SHELL_ONLY | root |
| 328 | GlRptF5Bctc03 | GlRptF5Bctc03 | `gl.task.328` | SHELL_ONLY | root |
| 329 | GlRptF5Bctc04 | GlRptF5Bctc04 | `gl.task.329` | SHELL_ONLY | root |
| 330 | GlRptNKC01All | GlRptNKC01All | `gl.rpt.glrptnkc01all` | SHELL_ONLY | root |
| 331 | GlRptNkc01 | GlRptNkc01 | `gl.task.331` | SHELL_ONLY | root |
| 332 | GlRptNkc02 | GlRptNkc02 | `gl.rpt.glrptnkc02` | SHELL_ONLY | root |
| 333 | GlRptNkc03 | GlRptNkc03 | `gl.rpt.glrptnkc03` | SHELL_ONLY | root |
| 334 | GlRptNkc04 | GlRptNkc04 | `gl.rpt.glrptnkc04` | SHELL_ONLY | root |
| 335 | GlRptNkc05 | GlRptNkc05 | `gl.rpt.glrptnkc05` | SHELL_ONLY | root |
| 336 | GlRptNkc06 | GlRptNkc06 | `gl.rpt.glrptnkc06` | SHELL_ONLY | root |
| 337 | GlRptNkc07 | GlRptNkc07 | `gl.rpt.glrptnkc07` | SHELL_ONLY | root |

## IN — 12 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 102 | INRptTHN01 | INRptTHN01 | — | SHELL_ONLY | root |
| 105 | INRptCTVT01 | INRptCTVT01 | — | SHELL_ONLY | root |
| 107 | INRptBK01 | INRptBK01 | — | SHELL_ONLY | root |
| 111 | INRptTHX01 | INRptTHX01 | — | SHELL_ONLY | root |
| 116 | INRptF5CD01 | INRptF5CD01 | `task.shell.116` | SHELL_ONLY | root |
| 117 | INRptCD02 | INRptCD02 | `in.rpt.inrptcd02` | DONE | phase 1 |
| 229 | INRptBKN04 | INRptBKN04 | — | SHELL_ONLY | root |
| 230 | INRptBKX04 | INRptBKX04 | — | SHELL_ONLY | root |
| 231 | INRptCD01 | INRptCD01 | — | SHELL_ONLY | root |
| 232 | INRptCTVT02 | INRptCTVT02 | — | SHELL_ONLY | root |
| 233 | INRptTHN02 | INRptTHN02 | — | SHELL_ONLY | root |
| 234 | INRptTHX02 | INRptTHX02 | — | SHELL_ONLY | root |

## KHAC — 12 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 032-038 | CA - Bao cao tien mat ngan hang | — | — | SHELL_ONLY | root |
| 042 | CO - Danh muc but toan phan bo tu dong | — | `co.rpt.codmpb` | SHELL_ONLY | root |
| 044 | SO - Bao cao ban hang theo chi tieu | — | `so.rpt.bcpt06` | SHELL_ONLY | root |
| 045 | SO - Bao cao loi nhuan ban hang | — | `so.rpt.lailo` | SHELL_ONLY | root |
| 341 | FA - Bao cao phan tich tai san 01 | — | `task.341` | SHELL_ONLY | root |
| 344 | CO - Bao cao Gia thanh 01 (CORptGt01) | — | — | SHELL_ONLY | root |
| 345 | CO - Bao cao Gia thanh 02 (CORptGt02) | — | — | SHELL_ONLY | root |
| 346 | CO - Bao cao Gia thanh 03 (CORptGt03) | — | — | SHELL_ONLY | root |
| 352 | CO - Bao cao chi tiet phan bo chi phi tap trung (C | — | `task.352` | SHELL_ONLY | root |
| 353 | CO - Bao cao khai bao chi phi tap trung (CoRptKHCP | — | — | SHELL_ONLY | root |
| 359 | AP - Sổ chi tiết công nợ một nhà cung cấp (menu 10 | ARRptBCCN01 (form dung chung c | `po.rpt.arrptbccn01103023` | DONE | phase 1 |
| 371 | AP/ARBCCN01 — Sổ chi tiết công nợ một nhà cung cấp | ARRptBCCN01 (form dùng chung c | `po.rpt.arrptbccn01103011` | DONE | root |

## PO — 8 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 066 | PORptTH02 | PORptTH02 | — | SHELL_ONLY | root |
| 067 | PORptBCPT03 | PORptBCPT03 | — | SHELL_ONLY | root |
| 071 | PORptBK01 | PORptBK01 | — | SHELL_ONLY | root |
| 072 | PORptTH03 | PORptTH03 | — | SHELL_ONLY | root |
| 073 | PORptBK02 | PORptBK02 | — | SHELL_ONLY | root |
| 076 | PORptTH01 | PORptTH01 | — | SHELL_ONLY | root |
| 077 | PORptBK03 | PORptBK03 | — | SHELL_ONLY | root |
| 078 | PORptF5TH0 | PORptF5TH0 | `simba.report/po dynamic F5` | SHELL_ONLY | root |

## SI — 1 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 099 | SIRptLOGCT | SIRptLOGCT | `si.rpt.logct` | SHELL_ONLY | root |

## SO — 11 task báo cáo

| ID | Tên | DLL | Route | Status | Phase |
|---|---|---|---|---|---|
| 048 | SORptTH01 | SORptTH01 | `so.rpt.th01` | SHELL_ONLY | root |
| 054 | SORptBCPT03 | SORptBCPT03 | — | SHELL_ONLY | root |
| 057 | SORptBCPT04 | SORptBCPT04 | — | SHELL_ONLY | root |
| 059 | SORptBK02 | SORptBK02 | — | SHELL_ONLY | root |
| 060 | SOND51bmhd | SOND51bmhd | `so.rpt.sond51bmhd` | SHELL_ONLY | root |
| 201 | SO - Bảng kê chứng từ bán hàng 01 | SORptBK01 | `so.rpt.sorptbk01` | DONE | phase 1 |
| 202 | SO-Bao-Cao-Phan-Tich-F5-06 | SORptF5BCPT06 | `so.rpt F5 shell` | SHELL_ONLY | root |
| 203 | SO-Bao-Cao-Tong-Hop-F5 | SORptF5TH0 | `so.rpt F5 shell` | SHELL_ONLY | root |
| 204 | SO-Bao-Cao-Tong-Hop-Ban-Hang-02 | SORptTH02 | — | SHELL_ONLY | root |
| 213 | SO-Bang-Ke-Hoa-Don | SOND51bkhd | `so.rpt.bkhd` | SHELL_ONLY | root |
| 370 | SO/ARBCCN01SL — Sổ chi tiết công nợ một khách hàng | ARRptBCCN01 (form dùng chung c | `so.rpt.arrptbccn01063038` | PENDING | root |
