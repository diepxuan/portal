# Route chưa nối được — danh sách theo dõi

> Chuyển từ `diepxuan/laravel-catalog/routes/web.php` (203 dòng comment) ngày 2026-11-26.

> Mục đích: giữ `routes/web.php` gọn, không còn khối comment lớn.


## Bối cảnh

Từ 2026-11-26, toàn bộ route được **sinh tự động** từ cấu trúc thư mục:

```
src/Http/Livewire/{Module}/{Kind}/{PascalSlug}.php       -> {module}.{kind}.{slug}
src/Http/Livewire/{Module}/{Kind}/{PascalSlug}Form.php   -> {module}.{kind}.{slug}.create + .edit
src/Http/Livewire/{Module}/{Kind}/{PascalSlug}Edit.php   -> {module}.{kind}.{slug}.create + .edit
```

Chỉ còn **1 entry khai báo tay** trong `$sourceRoutes`: `si.vch.year` (helper có route POST riêng).

## Danh sách theo module

### CA — 12 màn hình

| URI | Route name | Ghi chú |
|---|---|---|
| `ca/dict/cadmku` | `` | KHÔNG NỐI ĐƯỢC: menu 04.90.02 (CADMKU) có active=0 trong sysMenu |
| `ca/dict/sidmngh` | `ca.dict.sidmngh` |  |
| `ca/dict/sidmnt` | `ca.dict.sidmnt` |  |
| `ca/dict/sidmtgnt` | `ca.dict.sidmtgnt` |  |
| `ca/rpt/carpttmnh01` | `ca.rpt.carpttmnh01` |  |
| `ca/rpt/carpttmnh02` | `ca.rpt.carpttmnh02` |  |
| `ca/rpt/carpttmnh06` | `ca.rpt.carpttmnh06` |  |
| `ca/rpt/glrptbk01` | `ca.rpt.glrptbk01` |  |
| `ca/rpt/glrptnkc03` | `ca.rpt.glrptnkc03` |  |
| `ca/rpt/carpttmnh02` | `` | TẠM HOÃN: AsCARptTMNH02 gọi SP thiếu tham số @pNgay1 (bug package simba, xem docs/PROJECT_CONVENTIONS.md) |
| `ca/rpt/carpttmnh06` | `` | component tự đăng ký qua convention (Ca\Rpt\Carpttmnh06) |
| `ca/rpt/carpttmnh03` | `` | KHÔNG NỐI ĐƯỢC: menu 04.20.20 (CARptTMNH03) có active=0 trong sysMenu, SimbaMenuRouteMetadata không sinh route |

### CO — 27 màn hình

| URI | Route name | Ghi chú |
|---|---|---|
| `co/dict/codmbom` | `co.dict.codmbom` |  |
| `co/dict/codmnhspct` | `co.dict.codmnhspct` |  |
| `co/dict/codmpb` | `co.dict.codmpb` |  |
| `co/dict/codmspct` | `co.dict.codmspct` |  |
| `co/dict/gldmkc` | `co.dict.gldmkc` |  |
| `co/proc/codd1` | `co.proc.codd1` |  |
| `co/proc/colk` | `co.proc.colk` |  |
| `co/rpt/arrptbccn04` | `co.rpt.arrptbccn04` |  |
| `co/rpt/corptctpbcptt` | `co.rpt.corptctpbcptt` |  |
| `co/rpt/corptgt01` | `co.rpt.corptgt01` |  |
| `co/rpt/corptgt02` | `co.rpt.corptgt02` |  |
| `co/rpt/corptgt03` | `co.rpt.corptgt03` |  |
| `co/rpt/glrptbk01` | `co.rpt.glrptbk01` |  |
| `co/rpt/glrptth01` | `co.rpt.glrptth01` |  |
| `co/rpt/inrptbkn04` | `co.rpt.inrptbkn04` |  |
| `co/rpt/inrptbkx04` | `co.rpt.inrptbkx04` |  |
| `co/rpt/inrptthn01` | `co.rpt.inrptthn01` |  |
| `co/rpt/inrptthn02` | `co.rpt.inrptthn02` |  |
| `co/rpt/inrptthx01` | `co.rpt.inrptthx01` |  |
| `co/rpt/inrptthx02` | `co.rpt.inrptthx02` |  |
| `co/vch/cocalccost` | `co.vch.cocalccost` |  |
| `co/vch/codelpostcp2gl` | `co.vch.codelpostcp2gl` |  |
| `co/vch/codmcptt` | `co.vch.codmcptt` |  |
| `co/vch/congungkhcptt` | `co.vch.congungkhcptt` |  |
| `co/vch/copb` | `co.vch.copb` |  |
| `co/vch/copostcptt2gl` | `co.vch.copostcptt2gl` |  |
| `co/vch/glpost2glkc` | `co.vch.glpost2glkc` |  |

### FA — 31 màn hình

| URI | Route name | Ghi chú |
|---|---|---|
| `fa/dict/fadmbpsd` | `fa.dict.fadmbpsd` |  |
| `fa/dict/fadmldts` | `fa.dict.fadmldts` |  |
| `fa/dict/fadmnhts` | `fa.dict.fadmnhts` |  |
| `fa/dict/fadmnv` | `fa.dict.fadmnv` |  |
| `fa/dict/sisysvars` | `fa.dict.sisysvars` |  |
| `fa/rpt/farptbcpt10` | `fa.rpt.farptbcpt10` |  |
| `fa/rpt/farptbcts01` | `fa.rpt.farptbcts01` |  |
| `fa/rpt/farptbcts04` | `fa.rpt.farptbcts04` |  |
| `fa/rpt/farptbcts05` | `fa.rpt.farptbcts05` |  |
| `fa/rpt/farptbcts06` | `fa.rpt.farptbcts06` |  |
| `fa/rpt/farptbcts07` | `fa.rpt.farptbcts07` |  |
| `fa/rpt/farptbcts08` | `fa.rpt.farptbcts08` |  |
| `fa/rpt/farptbcts09` | `fa.rpt.farptbcts09` |  |
| `fa/rpt/inrptbkn04` | `fa.rpt.inrptbkn04` |  |
| `fa/rpt/inrptbkx04` | `fa.rpt.inrptbkx04` |  |
| `fa/rpt/inrptthn01` | `fa.rpt.inrptthn01` |  |
| `fa/rpt/inrptthx01` | `fa.rpt.inrptthx01` |  |
| `fa/vch/faadjustkhts` | `fa.vch.faadjustkhts` |  |
| `fa/vch/fabhcc` | `fa.vch.fabhcc` |  |
| `fa/vch/facalkhts` | `fa.vch.facalkhts` |  |
| `fa/vch/fachuyents` | `fa.vch.fachuyents` |  |
| `fa/vch/fadelcc2gl` | `fa.vch.fadelcc2gl` |  |
| `fa/vch/fadelkhts` | `fa.vch.fadelkhts` |  |
| `fa/vch/fadelts2gl` | `fa.vch.fadelts2gl` |  |
| `fa/vch/fadgts` | `fa.vch.fadgts` |  |
| `fa/vch/fadmcc` | `fa.vch.fadmcc` |  |
| `fa/vch/fadmts` | `fa.vch.fadmts` |  |
| `fa/vch/fagiamts` | `fa.vch.fagiamts` |  |
| `fa/vch/fapostcc2gl` | `fa.vch.fapostcc2gl` |  |
| `fa/vch/fapostts2gl` | `fa.vch.fapostts2gl` |  |
| `fa/vch/fathoikhts` | `fa.vch.fathoikhts` |  |

### GL — 47 màn hình

| URI | Route name | Ghi chú |
|---|---|---|
| `gl/dict/gldmkc` | `gl.dict.gldmkc` |  |
| `gl/dict/sidmbp` | `gl.dict.sidmbp` |  |
| `gl/dict/sidmphi` | `gl.dict.sidmphi` |  |
| `gl/proc/glcdtk` | `gl.proc.glcdtk` |  |
| `gl/proc/gltransferglcdtk` | `gl.proc.gltransferglcdtk` |  |
| `gl/rpt/gldkctgs` | `gl.rpt.gldkctgs` |  |
| `gl/rpt/gldmctgs` | `gl.rpt.gldmctgs` |  |
| `gl/rpt/glrptbcpt02` | `gl.rpt.glrptbcpt02` |  |
| `gl/rpt/glrptbcpt03` | `gl.rpt.glrptbcpt03` |  |
| `gl/rpt/glrptbcpt04` | `gl.rpt.glrptbcpt04` |  |
| `gl/rpt/glrptbcpt05` | `gl.rpt.glrptbcpt05` |  |
| `gl/rpt/glrptbcpt08` | `gl.rpt.glrptbcpt08` |  |
| `gl/rpt/glrptbct01` | `gl.rpt.glrptbct01` |  |
| `gl/rpt/glrptbct02` | `gl.rpt.glrptbct02` |  |
| `gl/rpt/glrptbct03` | `gl.rpt.glrptbct03` |  |
| `gl/rpt/glrptbct04` | `gl.rpt.glrptbct04` |  |
| `gl/rpt/glrptbct05` | `gl.rpt.glrptbct05` |  |
| `gl/rpt/glrptbct06` | `gl.rpt.glrptbct06` |  |
| `gl/rpt/glrptbctc01` | `gl.rpt.glrptbctc01` |  |
| `gl/rpt/glrptbctc02` | `gl.rpt.glrptbctc02` |  |
| `gl/rpt/glrptbctc03` | `gl.rpt.glrptbctc03` |  |
| `gl/rpt/glrptbctc04` | `gl.rpt.glrptbctc04` |  |
| `gl/rpt/glrptbctccdtb02` | `gl.rpt.glrptbctccdtb02` |  |
| `gl/rpt/glrptbctccdtb03` | `gl.rpt.glrptbctccdtb03` |  |
| `gl/rpt/glrptbctccdtf02` | `gl.rpt.glrptbctccdtf02` |  |
| `gl/rpt/glrptbctccdtf03a` | `gl.rpt.glrptbctccdtf03a` |  |
| `gl/rpt/glrptbctccdtf03b` | `gl.rpt.glrptbctccdtf03b` |  |
| `gl/rpt/glrptbctccdtf03c` | `gl.rpt.glrptbctccdtf03c` |  |
| `gl/rpt/glrptbctccdtf03d` | `gl.rpt.glrptbctccdtf03d` |  |
| `gl/rpt/glrptbk01` | `gl.rpt.glrptbk01` |  |
| `gl/rpt/glrptctgs01` | `gl.rpt.glrptctgs01` |  |
| `gl/rpt/glrptctgs02` | `gl.rpt.glrptctgs02` |  |
| `gl/rpt/glrptctgs03` | `gl.rpt.glrptctgs03` |  |
| `gl/rpt/glrptctgs05` | `gl.rpt.glrptctgs05` |  |
| `gl/rpt/glrptnkc01all` | `gl.rpt.glrptnkc01all` |  |
| `gl/rpt/glrptnkc02` | `gl.rpt.glrptnkc02` |  |
| `gl/rpt/glrptnkc03` | `gl.rpt.glrptnkc03` |  |
| `gl/rpt/glrptnkc04` | `gl.rpt.glrptnkc04` |  |
| `gl/rpt/glrptnkc05` | `gl.rpt.glrptnkc05` |  |
| `gl/rpt/glrptnkc06` | `gl.rpt.glrptnkc06` |  |
| `gl/rpt/glrptnkc07` | `gl.rpt.glrptnkc07` |  |
| `gl/rpt/glrptth01` | `gl.rpt.glrptth01` |  |
| `gl/rpt/glrpttmbctc` | `gl.rpt.glrpttmbctc` |  |
| `gl/vch/glbudget` | `gl.vch.glbudget` |  |
| `gl/vch/glnb` | `gl.vch.glnb` |  |
| `gl/vch/glpost2glkc` | `gl.vch.glpost2glkc` |  |
| `gl/vch/glvchgl1` | `gl.vch.glvchgl1` |  |

### IN — 28 màn hình

| URI | Route name | Ghi chú |
|---|---|---|
| `in/dict/codmspct` | `in.dict.codmspct` |  |
| `in/dict/fadmbpsd` | `in.dict.fadmbpsd` |  |
| `in/dict/indmlo` | `in.dict.indmlo` |  |
| `in/dict/sidmhd` | `in.dict.sidmhd` |  |
| `in/dict/sidmnhhd` | `in.dict.sidmnhhd` |  |
| `in/dict/sisysvars` | `in.dict.sisysvars` |  |
| `in/proc/incdfifo` | `in.proc.incdfifo` |  |
| `in/proc/incdvt` | `in.proc.incdvt` |  |
| `in/proc/intransferincdvt` | `in.proc.intransferincdvt` |  |
| `in/rpt/dynamicreport` | `in.rpt.dynamicreport` |  |
| `in/rpt/inrptbk01` | `in.rpt.inrptbk01` |  |
| `in/rpt/inrptbkn04` | `in.rpt.inrptbkn04` |  |
| `in/rpt/inrptbkx04` | `in.rpt.inrptbkx04` |  |
| `in/rpt/inrptcd01` | `in.rpt.inrptcd01` |  |
| `in/rpt/inrptctvt01` | `in.rpt.inrptctvt01` |  |
| `in/rpt/inrptctvt02` | `in.rpt.inrptctvt02` |  |
| `in/rpt/inrptthn01` | `in.rpt.inrptthn01` |  |
| `in/rpt/inrptthn02` | `in.rpt.inrptthn02` |  |
| `in/rpt/inrptthx01` | `in.rpt.inrptthx01` |  |
| `in/rpt/inrptthx02` | `in.rpt.inrptthx02` |  |
| `in/vch/incalgiabqdd` | `in.vch.incalgiabqdd` |  |
| `in/vch/incalgiantxt` | `in.vch.incalgiantxt` |  |
| `in/vch/incalgiatb` | `in.vch.incalgiatb` |  |
| `in/vch/invchin1` | `in.vch.invchin1` |  |
| `in/vch/invchin2` | `in.vch.invchin2` |  |
| `in/vch/invchin3` | `in.vch.invchin3` |  |
| `in/vch/invchin5` | `in.vch.invchin5` |  |
| `in/vch/invchin6` | `in.vch.invchin6` |  |

### PO — 30 màn hình

| URI | Route name | Ghi chú |
|---|---|---|
| `po/dict/ardmplkh` | `po.dict.ardmplkh` |  |
| `po/dict/podmgiamua` | `po.dict.podmgiamua` |  |
| `po/dict/podmhttt` | `po.dict.podmhttt` |  |
| `po/dict/sidmbp` | `po.dict.sidmbp` |  |
| `po/dict/sidmhd` | `po.dict.sidmhd` |  |
| `po/dict/sidmnhhd` | `po.dict.sidmnhhd` |  |
| `po/dict/sisysvars` | `po.dict.sisysvars` |  |
| `po/proc/arcdkh` | `po.proc.arcdkh` |  |
| `po/rpt/aprptbk01` | `po.rpt.aprptbk01` |  |
| `po/rpt/arrptbccn01` | `po.rpt.arrptbccn01` |  |
| `po/rpt/arrptbccn01a` | `po.rpt.arrptbccn01a` |  |
| `po/rpt/arrptbccn02` | `po.rpt.arrptbccn02` |  |
| `po/rpt/arrptbccn03` | `po.rpt.arrptbccn03` |  |
| `po/rpt/arrptbccn04` | `po.rpt.arrptbccn04` |  |
| `po/rpt/arrptbccn05` | `po.rpt.arrptbccn05` |  |
| `po/rpt/glrptnkc05` | `po.rpt.glrptnkc05` |  |
| `po/rpt/porptbcpt03` | `po.rpt.porptbcpt03` |  |
| `po/rpt/porptbk01` | `po.rpt.porptbk01` |  |
| `po/rpt/porptbk02` | `po.rpt.porptbk02` |  |
| `po/rpt/porptbk03` | `po.rpt.porptbk03` |  |
| `po/rpt/porptth01` | `po.rpt.porptth01` |  |
| `po/rpt/porptth02` | `po.rpt.porptth02` |  |
| `po/rpt/porptth03` | `po.rpt.porptth03` |  |
| `po/vch/apvchap4` | `po.vch.apvchap4` |  |
| `po/vch/potain` | `po.vch.potain` |  |
| `po/vch/povchpo1` | `po.vch.povchpo1` |  |
| `po/vch/povchpo4` | `po.vch.povchpo4` |  |
| `po/vch/povchpo5` | `po.vch.povchpo5` |  |
| `po/vch/povchpo6` | `po.vch.povchpo6` |  |
| `po/vch/povchpo7` | `po.vch.povchpo7` |  |

### SO — 28 màn hình

| URI | Route name | Ghi chú |
|---|---|---|
| `so/dict/sidmbp` | `so.dict.sidmbp` |  |
| `so/dict/sidmhd` | `so.dict.sidmhd` |  |
| `so/dict/sidmnhhd` | `so.dict.sidmnhhd` |  |
| `so/dict/sisysvars` | `so.dict.sisysvars` |  |
| `so/dict/sodmgiaban` | `so.dict.sodmgiaban` |  |
| `so/dict/sodmhttt` | `so.dict.sodmhttt` |  |
| `so/dict/sodmnvkd` | `so.dict.sodmnvkd` |  |
| `so/dict/sodmts` | `so.dict.sodmts` |  |
| `so/proc/arcdkh` | `so.proc.arcdkh` |  |
| `so/rpt/arrptbccn01a` | `so.rpt.arrptbccn01a` |  |
| `so/rpt/arrptbccn02` | `so.rpt.arrptbccn02` |  |
| `so/rpt/arrptbccn03` | `so.rpt.arrptbccn03` |  |
| `so/rpt/arrptbccn04` | `so.rpt.arrptbccn04` |  |
| `so/rpt/arrptbccn05` | `so.rpt.arrptbccn05` |  |
| `so/rpt/arrptbk01` | `so.rpt.arrptbk01` |  |
| `so/rpt/glrptnkc04` | `so.rpt.glrptnkc04` |  |
| `so/rpt/sorptbcpt03` | `so.rpt.sorptbcpt03` |  |
| `so/rpt/sorptbcpt04` | `so.rpt.sorptbcpt04` |  |
| `so/rpt/sorptbcpt06` | `so.rpt.sorptbcpt06` |  |
| `so/rpt/sorptbk02` | `so.rpt.sorptbk02` |  |
| `so/rpt/sorptlailo` | `so.rpt.sorptlailo` |  |
| `so/rpt/sorptth01` | `so.rpt.sorptth01` |  |
| `so/rpt/sorptth02` | `so.rpt.sorptth02` |  |
| `so/vch/arvchar4` | `so.vch.arvchar4` |  |
| `so/vch/sotaout` | `so.vch.sotaout` |  |
| `so/vch/sovchso1` | `` | SAI: menu 06.10.02 (SOVchSO1) là 'Đơn đặt hàng' không phải 'Hoá đơn bán hàng'; chưa có component riêng -> SimbaPage shell |
| `so/vch/sovchso4` | `so.vch.sovchso4` |  |
| `so/vch/sovchso5` | `so.vch.sovchso5` |  |

## Tổng: 203 màn hình

## Cách xử lý khi cần nối

1. Kiểm tra `simba-docs/data/sysMenu.md`: menu phải có `active=1` và `type` hợp lệ
2. Tạo component đúng convention `src/Http/Livewire/{Module}/{Kind}/{PascalSlug}.php`
3. Route sẽ **tự sinh** — không cần sửa `routes/web.php`
4. Verify browser: `http://portal.diepxuan.corp/simba/{module}/{kind}/{slug}`

### Bảng type trong sysMenu

| type | Ý nghĩa | kind |
|---|---|---|
| `1` | Voucher (phiếu) | `vch` |
| `2` | Master (danh mục) | `dict` |
| `4` | Report (báo cáo) | `rpt` |
| `6` | Setup (nhập liệu) | `proc` |
| `` (rỗng) | **Không sinh route** | — |
| `5` | Module root | — |
