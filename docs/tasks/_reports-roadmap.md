# Lộ trình hoàn thiện task BÁO CÁO

> Sinh từ `docs/tasks/_reports-inventory.md`, đối chiếu `sysMenu` + wrapper SP + `simba-docs/procedures`.
> Quy ước: **mỗi task = 1 PR riêng** (component + view + route + verify browser).

## Tổng quan

| Hạng | Điều kiện | Số task | Việc cần làm |
|---|---|---:|---|
| **A** | Menu active **+** wrapper SP khớp docs | **53** | Làm được ngay |
| **B** | Menu active **+** wrapper thiếu tham số | **0** | Sửa wrapper SP trước (đã có docs) |
| **B2** | Menu active **+** SP không có trong `procedures.md` | **16** | Không verify được tham số — rủi ro cao |
| **C** | **Không có menu** trong sysMenu | **53** | Không nối route được |
| | **Tổng** | **122** | |

## Quy trình mỗi task (1 PR)

```
1. Đọc task doc + simba-docs/procedures/<module>/procedures.md
2. Component  src/Http/Livewire/{Module}/Rpt/{PascalSlug}.php
   pattern: So\Rpt\Sorptbk01 hoặc In\Rpt\Inrptcd02
   mount(?module,?kind,?slug) / submit() / selectRow() / exportCsv() / render()
3. View       resources/views/{module}/rpt/{slug}.blade.php
4. Route      routes/web.php: ['uri'=>'{module}/rpt/{slug}', 'name'=>'{module}.rpt.{slug}']
5. Verify     browser thật /simba/{module}/rpt/{slug} — HTTP 200, bảng render, 0 error
6. Task doc   Status = DONE + bằng chứng browser
7. 1 branch = 1 PR = 1 task
```

## Hạng A — làm ngay (53 task)

### GL — 28 task

| # | ID | Tên | Route | SP wrapper |
|---:|---|---|---|---|
| 1 | 139 | GLRptBCTCCDTB02 | `gl.rpt.glrptbctccdtb02` | `asGlrptbctccdtb02` |
| 2 | 144 | GLRptTH01 | `gl.rpt.glrptth01` | `asGlrptth01` |
| 3 | 149 | GLRptBCT03 | `gl.rpt.glrptbct03` | `asGlrptbct03` |
| 4 | 288 | GLRptBCPT02 | `gl.rpt.glrptbcpt02` | `asGlrptbcpt02` |
| 5 | 290 | GLRptBCPT04 | `gl.rpt.glrptbcpt04` | `asGlrptbcpt04` |
| 6 | 291 | GLRptBCPT05 | `gl.rpt.glrptbcpt05` | `asGlrptbcpt05` |
| 7 | 292 | GLRptBCT01 | `gl.rpt.glrptbct01` | `asGlrptbct01` |
| 8 | 293 | GLRptBCT02 | `gl.rpt.glrptbct02` | `asGlrptbct02` |
| 9 | 295 | GLRptBCTCCDTF02 | `gl.rpt.glrptbctccdtf02` | `asGlrptbctccdtf02` |
| 10 | 303 | GLRptCTGS01 | `gl.rpt.glrptctgs01` | `asGlrptctgs01` |
| 11 | 304 | GLRptCTGS02 | `gl.rpt.glrptctgs02` | `asGlrptctgs02` |
| 12 | 305 | GLRptCTGS03 | `gl.rpt.glrptctgs03` | `asGlrptctgs03` |
| 13 | 306 | GLRptCTGS05 | `gl.rpt.glrptctgs05` | `asGlrptctgs05` |
| 14 | 319 | GlRptBCT04 | `gl.rpt.glrptbct04` | `asGlrptbct04` |
| 15 | 320 | GlRptBCT05 | `gl.rpt.glrptbct05` | `asGlrptbct05` |
| 16 | 321 | GlRptBCT06 | `gl.rpt.glrptbct06` | `asGlrptbct06` |
| 17 | 322 | GlRptBcpt08 | `gl.rpt.glrptbcpt08` | `asGlrptbcpt08` |
| 18 | 323 | GlRptBctc01 | `gl.rpt.glrptbctc01` | `asGlrptbctc01` |
| 19 | 324 | GlRptBctc02 | `gl.rpt.glrptbctc02` | `asGlrptbctc02` |
| 20 | 325 | GlRptBctc03 | `gl.rpt.glrptbctc03` | `asGlrptbctc03` |
| 21 | 326 | GlRptBctc04 | `gl.rpt.glrptbctc04` | `asGlrptbctc04` |
| 22 | 327 | GlRptBk01 | `gl.rpt.glrptbk01` | `asGlrptbk01` |
| 23 | 330 | GlRptNKC01All | `gl.rpt.glrptnkc01all` | `asGlrptnkc01All` |
| 24 | 332 | GlRptNkc02 | `gl.rpt.glrptnkc02` | `asGlrptnkc02` |
| 25 | 334 | GlRptNkc04 | `gl.rpt.glrptnkc04` | `asGlrptnkc04` |
| 26 | 335 | GlRptNkc05 | `gl.rpt.glrptnkc05` | `asGlrptnkc05` |
| 27 | 336 | GlRptNkc06 | `gl.rpt.glrptnkc06` | `asGlrptnkc06` |
| 28 | 337 | GlRptNkc07 | `gl.rpt.glrptnkc07` | `asGlrptnkc07` |

### IN — 10 task

| # | ID | Tên | Route | SP wrapper |
|---:|---|---|---|---|
| 1 | 102 | INRptTHN01 | `in.rpt.inrptthn01` | `asInrptthn01` |
| 2 | 105 | INRptCTVT01 | `in.rpt.inrptctvt01` | `asInrptctvt01` |
| 3 | 107 | INRptBK01 | `in.rpt.inrptbk01` | `asInrptbk01` |
| 4 | 111 | INRptTHX01 | `in.rpt.inrptthx01` | `asInrptthx01` |
| 5 | 229 | INRptBKN04 | `in.rpt.inrptbkn04` | `asInrptbkn04` |
| 6 | 230 | INRptBKX04 | `in.rpt.inrptbkx04` | `asInrptbkx04` |
| 7 | 231 | INRptCD01 | `in.rpt.inrptcd01` | `asInrptcd01` |
| 8 | 232 | INRptCTVT02 | `in.rpt.inrptctvt02` | `asInrptctvt02` |
| 9 | 233 | INRptTHN02 | `in.rpt.inrptthn02` | `asInrptthn02` |
| 10 | 234 | INRptTHX02 | `in.rpt.inrptthx02` | `asInrptthx02` |

### SO — 8 task

| # | ID | Tên | Route | SP wrapper |
|---:|---|---|---|---|
| 1 | 010 | ARRptBCCN04 | `so.rpt.arrptbccn04` | `asArrptbccn04` |
| 2 | 011 | ARRptBCCN05 | `so.rpt.arrptbccn05` | `asArrptbccn05` |
| 3 | 013 | ARRptBK01 | `so.rpt.arrptbk01` | `asArrptbk01` |
| 4 | 048 | SORptTH01 | `so.rpt.sorptth01` | `asSorptth01` |
| 5 | 054 | SORptBCPT03 | `so.rpt.sorptbcpt03` | `asSorptbcpt03` |
| 6 | 057 | SORptBCPT04 | `so.rpt.sorptbcpt04` | `asSorptbcpt04` |
| 7 | 059 | SORptBK02 | `so.rpt.sorptbk02` | `asSorptbk02` |
| 8 | 204 | SO-Bao-Cao-Tong-Hop-Ban-Hang-02 | `so.rpt.sorptth02` | `asSorptth02` |

### PO — 7 task

| # | ID | Tên | Route | SP wrapper |
|---:|---|---|---|---|
| 1 | 066 | PORptTH02 | `po.rpt.porptth02` | `asPorptth02` |
| 2 | 067 | PORptBCPT03 | `po.rpt.porptbcpt03` | `asPorptbcpt03` |
| 3 | 071 | PORptBK01 | `po.rpt.porptbk01` | `asPorptbk01` |
| 4 | 072 | PORptTH03 | `po.rpt.porptth03` | `asPorptth03` |
| 5 | 073 | PORptBK02 | `po.rpt.porptbk02` | `asPorptbk02` |
| 6 | 076 | PORptTH01 | `po.rpt.porptth01` | `asPorptth01` |
| 7 | 077 | PORptBK03 | `po.rpt.porptbk03` | `asPorptbk03` |

## Hạng B — sửa wrapper SP trước (0 task)

| ID | Tên | Route | SP |
|---|---|---|---|

> Wrapper thiếu tham số so với `procedures.md`. Sửa wrapper rồi port — vd `AsCARptTMNH02`
> cần `pNgay1`/`pNgay2` nhưng đang khai `pNgay_Ct1`/`pNgay_ct2`.

## Hạng B2 — SP thiếu tài liệu (16 task)

| ID | Tên | Route | SP |
|---|---|---|---|
| 118 | FARptBCTS09 | `fa.rpt.farptbcts09` | `asFarptbcts09` |
| 120 | FARptBCTS07 | `fa.rpt.farptbcts07` | `asFarptbcts07` |
| 127 | FARptBCTS06 | `fa.rpt.farptbcts06` | `asFarptbcts06` |
| 128 | FARptBCTS01 | `fa.rpt.farptbcts01` | `asFarptbcts01` |
| 130 | FARptBCTS08 | `fa.rpt.farptbcts08` | `asFarptbcts08` |
| 249 | FARptBCPT10 | `fa.rpt.farptbcpt10` | `asFarptbcpt10` |
| 250 | FARptBCTS04 | `fa.rpt.farptbcts04` | `asFarptbcts04` |
| 251 | FARptBCTS05 | `fa.rpt.farptbcts05` | `asFarptbcts05` |
| 142 | GLRptBCTCCDTF03B | `gl.rpt.glrptbctccdtf03b` | `asGlrptbctccdtf03B` |
| 289 | GLRptBCPT03 | `gl.rpt.glrptbcpt03` | `asGlrptbcpt03` |
| 294 | GLRptBCTCCDTB03 | `gl.rpt.glrptbctccdtb03` | `asGlrptbctccdtb03` |
| 296 | GLRptBCTCCDTF03A | `gl.rpt.glrptbctccdtf03a` | `asGlrptbctccdtf03A` |
| 297 | GLRptBCTCCDTF03C | `gl.rpt.glrptbctccdtf03c` | `asGlrptbctccdtf03C` |
| 298 | GLRptBCTCCDTF03D | `gl.rpt.glrptbctccdtf03d` | `asGlrptbctccdtf03D` |
| 333 | GlRptNkc03 | `gl.rpt.glrptnkc03` | `asGlrptnkc03` |
| 099 | SIRptLOGCT | `si.vch.sirptlogct` | `asSirptlogct` |

> SP **không có** trong `simba-docs/procedures/*/procedures.md` nên không verify được tham số.
> Port được nhưng phải test kỹ bằng browser vì không có tài liệu đối chiếu.

## Hạng C — không có menu trong sysMenu (53 task)

| ID | Tên | DLL | Ghi chú |
|---|---|---|---|
| 125 | FABHCC | FABHCC | `FABHCC` không có trong sysMenu |
| 316 | GLRptTMBCTC | GLRPTTMBCTC | `GLRPTTMBCTC` không có trong sysMenu |
| 009 | ARRptBCCN02 | ARRPTBCCN02, | `ARRPTBCCN02,` không có trong sysMenu |
| 012 | ARRptBCCN06 | ARRPTBCCN06 | `ARRPTBCCN06` không có trong sysMenu |
| 014 | ARRptBK02 | ARRPTBK02 | `ARRPTBK02` không có trong sysMenu |
| 015 | ARRptBK03 | ARRPTBK03 | `ARRPTBK03` không có trong sysMenu |
| 019 | APRptBK | APRPTBK01, | `APRPTBK01,` không có trong sysMenu |
| 032-038 | CA - Bao cao tien mat ngan hang | — | DLL trống trong task doc |
| 044 | SO - Bao cao ban hang theo chi tieu | — | DLL trống trong task doc |
| 045 | SO - Bao cao loi nhuan ban hang | — | DLL trống trong task doc |
| 078 | PORptF5TH0 | PORPTF5TH0 | `PORPTF5TH0` không có trong sysMenu |
| 116 | INRptF5CD01 | INRPTF5CD01 | `INRPTF5CD01` không có trong sysMenu |
| 121 | FARptBCPT02 | FARPTBCPT02 | `FARPTBCPT02` không có trong sysMenu |
| 122 | FARptBCPT05 | FARPTBCPT05 | `FARPTBCPT05` không có trong sysMenu |
| 123 | FARptSoTSCD | FARPTSOTSCD | `FARPTSOTSCD` không có trong sysMenu |
| 126 | FARptBCPT03 | FARPTBCPT03 | `FARPTBCPT03` không có trong sysMenu |
| 137 | FARptBCPT09 | FARPTBCPT09 | `FARPTBCPT09` không có trong sysMenu |
| 141 | GLRptF5CTGS03 | GLRPTF5CTGS03 | `GLRPTF5CTGS03` không có trong sysMenu |
| 154 | GLRptBCTCCR01 | GLRPTBCTCCR01 | `GLRPTBCTCCR01` không có trong sysMenu |
| 158 | AR-Rpt-F5-BCCN01a-DrillDown | ARRPTF5BCCN01A | `ARRPTF5BCCN01A` không có trong sysMenu |
| 159-165 | CA-RptTMNH-BaoCaoTienMatNganHang | — | DLL trống trong task doc |
| 168-180 | CO-BaoCao-SanXuat | — | DLL trống trong task doc |
| 202 | SO-Bao-Cao-Phan-Tich-F5-06 | SORPTF5BCPT06 | `SORPTF5BCPT06` không có trong sysMenu |
| 203 | SO-Bao-Cao-Tong-Hop-F5 | SORPTF5TH0 | `SORPTF5TH0` không có trong sysMenu |
| 245 | FARptBCPT01 | FARPTBCPT01 | `FARPTBCPT01` không có trong sysMenu |
| 246 | FARptBCPT06 | FARPTBCPT06 | `FARPTBCPT06` không có trong sysMenu |
| 247 | FARptBCPT07 | FARPTBCPT07 | `FARPTBCPT07` không có trong sysMenu |
| 248 | FARptBCPT08 | FARPTBCPT08 | `FARPTBCPT08` không có trong sysMenu |
| 252 | FARptSoSD | FARPTSOSD | `FARPTSOSD` không có trong sysMenu |
| 287 | GLRptBCPT01 | GLRPTBCPT01 | `GLRPTBCPT01` không có trong sysMenu |
| 299 | GLRptBCTCCR02 | GLRPTBCTCCR02 | `GLRPTBCTCCR02` không có trong sysMenu |
| 300 | GLRptBCTCCR03 | GLRPTBCTCCR03 | `GLRPTBCTCCR03` không có trong sysMenu |
| 301 | GLRptBCTCCR04 | GLRPTBCTCCR04 | `GLRPTBCTCCR04` không có trong sysMenu |
| 302 | GLRptBk02 | GLRPTBK02 | `GLRPTBK02` không có trong sysMenu |
| 307 | GLRptF5BCPT08 | GLRPTF5BCPT08 | `GLRPTF5BCPT08` không có trong sysMenu |
| 308 | GLRptF5BCTC02 | GLRPTF5BCTC02 | `GLRPTF5BCTC02` không có trong sysMenu |
| 309 | GLRptF5BCTC02CT | GLRPTF5BCTC02CT | `GLRPTF5BCTC02CT` không có trong sysMenu |
| 310 | GLRptF5BCTC03CT | GLRPTF5BCTC03CT | `GLRPTF5BCTC03CT` không có trong sysMenu |
| 311 | GLRptF5CTGS01 | GLRPTF5CTGS01 | `GLRPTF5CTGS01` không có trong sysMenu |
| 312 | GLRptF5CTGS02 | GLRPTF5CTGS02 | `GLRPTF5CTGS02` không có trong sysMenu |
| … | (còn 13 task) | | |

> `SimbaMenuRouteMetadata` sinh route từ `sysMenu` → không có menu thì không có route.
> Cần bổ sung DLL vào sysMenu (thuộc SimbaERP gốc) hoặc xác nhận bỏ.

## Thứ tự thực hiện

| Bước | Nội dung | Số PR |
|---|---|---:|
| 1 | Hạng A — GL (28 task báo cáo tài chính/kế toán) | 28 |
| 2 | Hạng A — IN | 10 |
| 2 | Hạng A — SO | 8 |
| 2 | Hạng A — PO | 7 |
| 3 | Hạng B — sửa wrapper SP + port | 0 |
| 4 | Hạng B2 — port có kiểm chứng browser kỹ | 16 |
| 5 | Hạng C — chờ bổ sung sysMenu | 53 |

**Nguyên tắc:** A → B → B2 → C. Không làm C trước vì không nối route được.
**Tổng PR cần:** 69 (không tính C).
