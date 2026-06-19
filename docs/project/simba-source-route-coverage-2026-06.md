# Simba Source Route Coverage

Ngày sinh: 2026-06-19

Nguồn: `simba-docs/data/sysMenu.md` + `simba-docs/data/zsysmenu.md`.

- Filter: `active=1`, `moduleid in (GL, CA, SO, AP, AR, FA, IN, PO, CO)`, `type in (1,2,4,6)`, có `dllName` hoặc `code_name`.
- Kind map: `1 -> vch`, `2 -> dict`, `4 -> rpt`, `6 -> proc`.
- URL pattern: `/_simba-source/{module}/{kind}/{slug}`.
- Route name pattern: `{module}.{kind}.{slug}`.

## Summary

- Total source routes: 217
- Routes with concrete Livewire component: 13
- Routes using `SimbaPage` shell: 204
- Route name conflicts skipped: 26

## Conflicts

| routeName | menuids |
|---|---|
| `ca.rpt.carpttmnh01` | `04.20.32`, `04.20.02` |
| `ca.rpt.glrptnkc03` | `04.20.11`, `04.20.08` |
| `co.dict.codmspct` | `18.90.05`, `18.90.02` |
| `co.rpt.corptctpbcptt` | `18.60.08`, `17.60.08` |
| `co.rpt.corptgt03` | `18.25.08`, `18.25.02`, `18.25.11` |
| `co.rpt.glrptbk01` | `18.60.02`, `17.60.02` |
| `co.rpt.glrptth01` | `18.60.05`, `17.60.05` |
| `co.vch.codelpostcp2gl` | `18.15.11`, `17.15.11` |
| `co.vch.codmcptt` | `18.15.02`, `17.15.02` |
| `co.vch.congungkhcptt` | `18.15.08`, `17.15.08` |
| `co.vch.copostcptt2gl` | `18.15.05`, `17.15.05` |
| `gl.dict.sidmphi` | `90.10.20`, `17.90.04` |
| `gl.rpt.glrptnkc03` | `02.25.11`, `02.25.08` |
| `in.rpt.inrptctvt01` | `14.20.29`, `14.20.02` |
| `in.rpt.inrptctvt02` | `14.20.32`, `14.20.05` |
| `po.rpt.arrptbccn01` | `10.30.23`, `10.30.11` |
| `po.rpt.arrptbccn01a` | `10.30.27`, `10.30.14` |
| `po.rpt.arrptbccn03` | `10.30.44`, `10.30.20`, `10.30.47` |
| `po.rpt.arrptbccn05` | `10.30.50`, `10.30.26` |
| `so.rpt.arrptbccn01` | `06.30.38`, `06.30.14` |
| `so.rpt.arrptbccn01a` | `06.30.41`, `06.30.17` |
| `so.rpt.arrptbccn03` | `06.30.44`, `06.30.23`, `06.30.47` |
| `so.rpt.arrptbccn05` | `06.30.50`, `06.30.26` |
| `so.rpt.sorptbcpt03` | `06.20.83`, `06.20.20` |
| `so.rpt.sorptbcpt04` | `06.20.86`, `06.20.23` |
| `so.rpt.sorptlailo` | `06.20.89`, `06.20.47` |

## Routes

| moduleid | menuid | type | dllName | code_name | slug | kind | routeName | hasComponent | component |
|---|---:|---:|---|---|---|---|---|---|---|
| CA | `04.90.05` | `2` | `ARDMKH` | `MA_KH` | `ardmkh` | `dict` | `ca.dict.ardmkh` | yes | `Diepxuan\Catalog\Http\Livewire\Cash\Danhmuc\Nhanvien` |
| CA | `04.90.08` | `2` | `SIDMNGH` | `MA_NGH` | `sidmngh` | `dict` | `ca.dict.sidmngh` | no | `SimbaPage shell` |
| CA | `90.10.26` | `2` | `SIDMNT` | `MA_NT` | `sidmnt` | `dict` | `ca.dict.sidmnt` | no | `SimbaPage shell` |
| CA | `90.10.29` | `2` | `SIDMTGNT` | `MA_TGNT` | `sidmtgnt` | `dict` | `ca.dict.sidmtgnt` | no | `SimbaPage shell` |
| CA | `04.20.02` | `4` | `CARptTMNH01` | `` | `carpttmnh01` | `rpt` | `ca.rpt.carpttmnh01` | no | `SimbaPage shell` |
| CA | `04.20.05` | `4` | `CARptTMNH02` | `` | `carpttmnh02` | `rpt` | `ca.rpt.carpttmnh02` | no | `SimbaPage shell` |
| CA | `04.20.14` | `4` | `CARptTMNH06` | `` | `carpttmnh06` | `rpt` | `ca.rpt.carpttmnh06` | no | `SimbaPage shell` |
| CA | `04.20.29` | `4` | `GLRptBK01` | `` | `glrptbk01` | `rpt` | `ca.rpt.glrptbk01` | no | `SimbaPage shell` |
| CA | `04.20.08` | `4` | `GLRptNKC03` | `` | `glrptnkc03` | `rpt` | `ca.rpt.glrptnkc03` | no | `SimbaPage shell` |
| CA | `04.10.02` | `1` | `CAVchCA1` | `CA1` | `cavchca1` | `vch` | `ca.vch.cavchca1` | yes | `Diepxuan\Catalog\Http\Livewire\Cash\Tienmat\Phieuthu` |
| CA | `04.10.05` | `1` | `CAVchCA2` | `CA2` | `cavchca2` | `vch` | `ca.vch.cavchca2` | yes | `Diepxuan\Catalog\Http\Livewire\Cash\Tienmat\Phieuchi` |
| CA | `04.10.08` | `1` | `CAVchCA3` | `CA3` | `cavchca3` | `vch` | `ca.vch.cavchca3` | no | `SimbaPage shell` |
| CA | `04.10.11` | `1` | `CAVchCA4` | `CA4` | `cavchca4` | `vch` | `ca.vch.cavchca4` | yes | `Diepxuan\Catalog\Http\Livewire\Cash\Nganhang\Baoco` |
| CO | `18.90.11` | `2` | `CODMBOM` | `16.30.01` | `codmbom` | `dict` | `co.dict.codmbom` | no | `SimbaPage shell` |
| CO | `18.90.08` | `2` | `CODMNHSPCT` | `MA_NHSPCT` | `codmnhspct` | `dict` | `co.dict.codmnhspct` | no | `SimbaPage shell` |
| CO | `18.90.20` | `2` | `CODMPB` | `MA_PB` | `codmpb` | `dict` | `co.dict.codmpb` | no | `SimbaPage shell` |
| CO | `18.90.02` | `2` | `CODMSPCT` | `MA_SP` | `codmspct` | `dict` | `co.dict.codmspct` | no | `SimbaPage shell` |
| CO | `18.90.17` | `2` | `GLDMKC` | `GLDMKC` | `gldmkc` | `dict` | `co.dict.gldmkc` | no | `SimbaPage shell` |
| CO | `18.10.11` | `6` | `CODD1` | `MA_SPCT_DD` | `codd1` | `proc` | `co.proc.codd1` | no | `SimbaPage shell` |
| CO | `18.10.14` | `6` | `COLK` | `MA_SPCT_LK` | `colk` | `proc` | `co.proc.colk` | no | `SimbaPage shell` |
| CO | `18.25.14` | `4` | `ARRptBCCN04` | `` | `arrptbccn04` | `rpt` | `co.rpt.arrptbccn04` | no | `SimbaPage shell` |
| CO | `17.60.08` | `4` | `CoRptCTPBCPTT` | `` | `corptctpbcptt` | `rpt` | `co.rpt.corptctpbcptt` | no | `SimbaPage shell` |
| CO | `18.20.02` | `4` | `CORptGt01` | `` | `corptgt01` | `rpt` | `co.rpt.corptgt01` | no | `SimbaPage shell` |
| CO | `18.20.05` | `4` | `CORptGt02` | `` | `corptgt02` | `rpt` | `co.rpt.corptgt02` | no | `SimbaPage shell` |
| CO | `18.25.02` | `4` | `CORptGt03` | `` | `corptgt03` | `rpt` | `co.rpt.corptgt03` | no | `SimbaPage shell` |
| CO | `17.60.02` | `4` | `GLRptBK01` | `` | `glrptbk01` | `rpt` | `co.rpt.glrptbk01` | no | `SimbaPage shell` |
| CO | `17.60.05` | `4` | `GLRptTH01` | `` | `glrptth01` | `rpt` | `co.rpt.glrptth01` | no | `SimbaPage shell` |
| CO | `18.20.14` | `4` | `INRptBKN04` | `` | `inrptbkn04` | `rpt` | `co.rpt.inrptbkn04` | no | `SimbaPage shell` |
| CO | `18.20.20` | `4` | `INRptBKX04` | `` | `inrptbkx04` | `rpt` | `co.rpt.inrptbkx04` | no | `SimbaPage shell` |
| CO | `18.20.17` | `4` | `INRptTHN01` | `` | `inrptthn01` | `rpt` | `co.rpt.inrptthn01` | no | `SimbaPage shell` |
| CO | `18.20.18` | `4` | `INRptTHN02` | `` | `inrptthn02` | `rpt` | `co.rpt.inrptthn02` | no | `SimbaPage shell` |
| CO | `18.20.23` | `4` | `INRptTHX01` | `` | `inrptthx01` | `rpt` | `co.rpt.inrptthx01` | no | `SimbaPage shell` |
| CO | `18.20.26` | `4` | `INRptTHX02` | `` | `inrptthx02` | `rpt` | `co.rpt.inrptthx02` | no | `SimbaPage shell` |
| CO | `18.10.08` | `1` | `CoCalcCost` | `` | `cocalccost` | `vch` | `co.vch.cocalccost` | no | `SimbaPage shell` |
| CO | `17.15.11` | `1` | `CoDelPostCP2GL` | `` | `codelpostcp2gl` | `vch` | `co.vch.codelpostcp2gl` | no | `SimbaPage shell` |
| CO | `17.15.02` | `1` | `CoDMCPTT` | `MA_CPTT` | `codmcptt` | `vch` | `co.vch.codmcptt` | no | `SimbaPage shell` |
| CO | `17.15.08` | `1` | `CoNgungKHCPTT` | `MA_CPTT2` | `congungkhcptt` | `vch` | `co.vch.congungkhcptt` | no | `SimbaPage shell` |
| CO | `18.10.05` | `1` | `COPB` | `` | `copb` | `vch` | `co.vch.copb` | no | `SimbaPage shell` |
| CO | `17.15.05` | `1` | `CoPostCPTT2GL` | `` | `copostcptt2gl` | `vch` | `co.vch.copostcptt2gl` | no | `SimbaPage shell` |
| CO | `18.10.02` | `1` | `GLPOST2GLKC` | `` | `glpost2glkc` | `vch` | `co.vch.glpost2glkc` | no | `SimbaPage shell` |
| FA | `20.90.08` | `2` | `FADMBPSD` | `MA_BPSD` | `fadmbpsd` | `dict` | `fa.dict.fadmbpsd` | no | `SimbaPage shell` |
| FA | `20.90.05` | `2` | `FADMLDTS` | `MA_LDTG` | `fadmldts` | `dict` | `fa.dict.fadmldts` | no | `SimbaPage shell` |
| FA | `20.90.11` | `2` | `FADMNHTS` | `MA_NHTS` | `fadmnhts` | `dict` | `fa.dict.fadmnhts` | no | `SimbaPage shell` |
| FA | `20.90.02` | `2` | `FADMNV` | `MA_NV` | `fadmnv` | `dict` | `fa.dict.fadmnv` | no | `SimbaPage shell` |
| FA | `20.90.17` | `2` | `SISysvars` | `` | `sisysvars` | `dict` | `fa.dict.sisysvars` | no | `SimbaPage shell` |
| FA | `20.30.02` | `4` | `FARptBCPT10` | `` | `farptbcpt10` | `rpt` | `fa.rpt.farptbcpt10` | no | `SimbaPage shell` |
| FA | `20.20.02` | `4` | `FARptBCTS01` | `` | `farptbcts01` | `rpt` | `fa.rpt.farptbcts01` | no | `SimbaPage shell` |
| FA | `20.20.11` | `4` | `FARptBCTS04` | `` | `farptbcts04` | `rpt` | `fa.rpt.farptbcts04` | no | `SimbaPage shell` |
| FA | `20.20.14` | `4` | `FARptBCTS05` | `` | `farptbcts05` | `rpt` | `fa.rpt.farptbcts05` | no | `SimbaPage shell` |
| FA | `20.20.17` | `4` | `FARptBCTS06` | `` | `farptbcts06` | `rpt` | `fa.rpt.farptbcts06` | no | `SimbaPage shell` |
| FA | `20.20.20` | `4` | `FARptBCTS07` | `` | `farptbcts07` | `rpt` | `fa.rpt.farptbcts07` | no | `SimbaPage shell` |
| FA | `20.20.05` | `4` | `FARptBCTS08` | `` | `farptbcts08` | `rpt` | `fa.rpt.farptbcts08` | no | `SimbaPage shell` |
| FA | `20.20.08` | `4` | `FARptBCTS09` | `` | `farptbcts09` | `rpt` | `fa.rpt.farptbcts09` | no | `SimbaPage shell` |
| FA | `20.30.08` | `4` | `INRptBKN04` | `` | `inrptbkn04` | `rpt` | `fa.rpt.inrptbkn04` | no | `SimbaPage shell` |
| FA | `20.30.14` | `4` | `INRptBKX04` | `` | `inrptbkx04` | `rpt` | `fa.rpt.inrptbkx04` | no | `SimbaPage shell` |
| FA | `20.30.11` | `4` | `INRptTHN01` | `` | `inrptthn01` | `rpt` | `fa.rpt.inrptthn01` | no | `SimbaPage shell` |
| FA | `20.30.17` | `4` | `INRptTHX01` | `` | `inrptthx01` | `rpt` | `fa.rpt.inrptthx01` | no | `SimbaPage shell` |
| FA | `20.10.26` | `1` | `FAAdjustKHTS` | `MA_FADCKH` | `faadjustkhts` | `vch` | `fa.vch.faadjustkhts` | no | `SimbaPage shell` |
| FA | `20.15.05` | `1` | `FABHCC` | `MA_BHCC` | `fabhcc` | `vch` | `fa.vch.fabhcc` | no | `SimbaPage shell` |
| FA | `20.10.23` | `1` | `FACalKHTS` | `` | `facalkhts` | `vch` | `fa.vch.facalkhts` | no | `SimbaPage shell` |
| FA | `20.10.17` | `1` | `FAChuyenTS` | `FAChuyenTS` | `fachuyents` | `vch` | `fa.vch.fachuyents` | no | `SimbaPage shell` |
| FA | `20.15.11` | `1` | `FADelCC2GL` | `` | `fadelcc2gl` | `vch` | `fa.vch.fadelcc2gl` | no | `SimbaPage shell` |
| FA | `20.10.29` | `1` | `FADelKHTS` | `` | `fadelkhts` | `vch` | `fa.vch.fadelkhts` | no | `SimbaPage shell` |
| FA | `20.10.38` | `1` | `FADelTS2GL` | `` | `fadelts2gl` | `vch` | `fa.vch.fadelts2gl` | no | `SimbaPage shell` |
| FA | `20.10.05` | `1` | `FADGTS` | `MA_TS1` | `fadgts` | `vch` | `fa.vch.fadgts` | no | `SimbaPage shell` |
| FA | `20.15.02` | `1` | `FADMCC` | `MA_CC` | `fadmcc` | `vch` | `fa.vch.fadmcc` | no | `SimbaPage shell` |
| FA | `20.10.02` | `1` | `FADMTS` | `MA_TS` | `fadmts` | `vch` | `fa.vch.fadmts` | no | `SimbaPage shell` |
| FA | `20.10.11` | `1` | `FAGiamTS` | `FAGiamTS` | `fagiamts` | `vch` | `fa.vch.fagiamts` | no | `SimbaPage shell` |
| FA | `20.15.08` | `1` | `FAPostCC2GL` | `` | `fapostcc2gl` | `vch` | `fa.vch.fapostcc2gl` | no | `SimbaPage shell` |
| FA | `20.10.35` | `1` | `FAPostTS2GL` | `MA_FAPBKH` | `fapostts2gl` | `vch` | `fa.vch.fapostts2gl` | no | `SimbaPage shell` |
| FA | `20.10.14` | `1` | `FAThoiKHTS` | `MA_THOIKHTS` | `fathoikhts` | `vch` | `fa.vch.fathoikhts` | no | `SimbaPage shell` |
| GL | `02.90.05` | `2` | `GLDMKC` | `GLDMKC` | `gldmkc` | `dict` | `gl.dict.gldmkc` | no | `SimbaPage shell` |
| GL | `02.90.02` | `2` | `GLDMTK` | `TK` | `gldmtk` | `dict` | `gl.dict.gldmtk` | yes | `Diepxuan\Catalog\Http\Livewire\Gl\Taikhoan` |
| GL | `90.10.23` | `2` | `SIDMBP` | `MA_BP` | `sidmbp` | `dict` | `gl.dict.sidmbp` | no | `SimbaPage shell` |
| GL | `17.90.04` | `2` | `SiDmPhi` | `MA_PHI` | `sidmphi` | `dict` | `gl.dict.sidmphi` | no | `SimbaPage shell` |
| GL | `02.10.14` | `6` | `GLCDTK` | `MA_CDTK` | `glcdtk` | `proc` | `gl.proc.glcdtk` | no | `SimbaPage shell` |
| GL | `02.10.20` | `6` | `GLTransferGLCDTK` | `` | `gltransferglcdtk` | `proc` | `gl.proc.gltransferglcdtk` | no | `SimbaPage shell` |
| GL | `02.20.05` | `4` | `GLDKCTGS` | `` | `gldkctgs` | `rpt` | `gl.rpt.gldkctgs` | no | `SimbaPage shell` |
| GL | `02.20.02` | `4` | `GLDMCTGS` | `MA_CTGS` | `gldmctgs` | `rpt` | `gl.rpt.gldmctgs` | no | `SimbaPage shell` |
| GL | `02.60.05` | `4` | `GLRptBCPT02` | `` | `glrptbcpt02` | `rpt` | `gl.rpt.glrptbcpt02` | no | `SimbaPage shell` |
| GL | `02.60.08` | `4` | `GLRptBCPT03` | `` | `glrptbcpt03` | `rpt` | `gl.rpt.glrptbcpt03` | no | `SimbaPage shell` |
| GL | `02.60.11` | `4` | `GLRptBCPT04` | `` | `glrptbcpt04` | `rpt` | `gl.rpt.glrptbcpt04` | no | `SimbaPage shell` |
| GL | `02.60.14` | `4` | `GLRptBCPT05` | `` | `glrptbcpt05` | `rpt` | `gl.rpt.glrptbcpt05` | no | `SimbaPage shell` |
| GL | `02.60.02` | `4` | `GLRptBCPT08` | `GLPL_MA_SO08` | `glrptbcpt08` | `rpt` | `gl.rpt.glrptbcpt08` | no | `SimbaPage shell` |
| GL | `02.40.02` | `4` | `GLRptBCT01` | `` | `glrptbct01` | `rpt` | `gl.rpt.glrptbct01` | no | `SimbaPage shell` |
| GL | `02.40.05` | `4` | `GLRptBCT02` | `` | `glrptbct02` | `rpt` | `gl.rpt.glrptbct02` | no | `SimbaPage shell` |
| GL | `02.40.08` | `4` | `GLRptBCT03` | `` | `glrptbct03` | `rpt` | `gl.rpt.glrptbct03` | no | `SimbaPage shell` |
| GL | `02.40.14` | `4` | `GLRptBCT04` | `TATNDN01A` | `glrptbct04` | `rpt` | `gl.rpt.glrptbct04` | no | `SimbaPage shell` |
| GL | `02.40.17` | `4` | `GLRptBCT05` | `TATNDN03` | `glrptbct05` | `rpt` | `gl.rpt.glrptbct05` | no | `SimbaPage shell` |
| GL | `02.40.20` | `4` | `GLRptBCT06` | `TATNDN031A` | `glrptbct06` | `rpt` | `gl.rpt.glrptbct06` | no | `SimbaPage shell` |
| GL | `02.50.02` | `4` | `GLRptBCTC01` | `` | `glrptbctc01` | `rpt` | `gl.rpt.glrptbctc01` | no | `SimbaPage shell` |
| GL | `02.50.05` | `4` | `GLRptBCTC02` | `GLBS_MA_SO` | `glrptbctc02` | `rpt` | `gl.rpt.glrptbctc02` | no | `SimbaPage shell` |
| GL | `02.50.08` | `4` | `GLRptBCTC03` | `GLPL_MA_SO` | `glrptbctc03` | `rpt` | `gl.rpt.glrptbctc03` | no | `SimbaPage shell` |
| GL | `02.50.11` | `4` | `GLRptBCTC04` | `GLCF_MA_SO` | `glrptbctc04` | `rpt` | `gl.rpt.glrptbctc04` | no | `SimbaPage shell` |
| GL | `02.55.02` | `4` | `GLRptBCTCCDTB02` | `` | `glrptbctccdtb02` | `rpt` | `gl.rpt.glrptbctccdtb02` | no | `SimbaPage shell` |
| GL | `02.55.14` | `4` | `GLRptBCTCCDTB03` | `` | `glrptbctccdtb03` | `rpt` | `gl.rpt.glrptbctccdtb03` | no | `SimbaPage shell` |
| GL | `02.55.05` | `4` | `GLRptBCTCCDTF02` | `` | `glrptbctccdtf02` | `rpt` | `gl.rpt.glrptbctccdtf02` | no | `SimbaPage shell` |
| GL | `02.55.08` | `4` | `GLRptBCTCCDTF03A` | `` | `glrptbctccdtf03a` | `rpt` | `gl.rpt.glrptbctccdtf03a` | no | `SimbaPage shell` |
| GL | `02.55.11` | `4` | `GLRptBCTCCDTF03B` | `` | `glrptbctccdtf03b` | `rpt` | `gl.rpt.glrptbctccdtf03b` | no | `SimbaPage shell` |
| GL | `02.55.17` | `4` | `GLRptBCTCCDTF03C` | `` | `glrptbctccdtf03c` | `rpt` | `gl.rpt.glrptbctccdtf03c` | no | `SimbaPage shell` |
| GL | `02.55.20` | `4` | `GLRptBCTCCDTF03D` | `` | `glrptbctccdtf03d` | `rpt` | `gl.rpt.glrptbctccdtf03d` | no | `SimbaPage shell` |
| GL | `02.25.26` | `4` | `GLRptBK01` | `` | `glrptbk01` | `rpt` | `gl.rpt.glrptbk01` | no | `SimbaPage shell` |
| GL | `02.20.11` | `4` | `GLRptCTGS01` | `` | `glrptctgs01` | `rpt` | `gl.rpt.glrptctgs01` | no | `SimbaPage shell` |
| GL | `02.20.14` | `4` | `GLRptCTGS02` | `` | `glrptctgs02` | `rpt` | `gl.rpt.glrptctgs02` | no | `SimbaPage shell` |
| GL | `02.20.17` | `4` | `GLRptCTGS03` | `` | `glrptctgs03` | `rpt` | `gl.rpt.glrptctgs03` | no | `SimbaPage shell` |
| GL | `02.20.20` | `4` | `GLRptCTGS05` | `` | `glrptctgs05` | `rpt` | `gl.rpt.glrptctgs05` | no | `SimbaPage shell` |
| GL | `02.25.02` | `4` | `GLRptNKC01All` | `` | `glrptnkc01all` | `rpt` | `gl.rpt.glrptnkc01all` | no | `SimbaPage shell` |
| GL | `02.25.05` | `4` | `GLRptNKC02` | `` | `glrptnkc02` | `rpt` | `gl.rpt.glrptnkc02` | no | `SimbaPage shell` |
| GL | `02.25.08` | `4` | `GLRptNKC03` | `` | `glrptnkc03` | `rpt` | `gl.rpt.glrptnkc03` | no | `SimbaPage shell` |
| GL | `02.25.14` | `4` | `GLRptNKC04` | `` | `glrptnkc04` | `rpt` | `gl.rpt.glrptnkc04` | no | `SimbaPage shell` |
| GL | `02.25.17` | `4` | `GLRptNKC05` | `` | `glrptnkc05` | `rpt` | `gl.rpt.glrptnkc05` | no | `SimbaPage shell` |
| GL | `02.25.20` | `4` | `GLRptNKC06` | `` | `glrptnkc06` | `rpt` | `gl.rpt.glrptnkc06` | no | `SimbaPage shell` |
| GL | `02.25.23` | `4` | `GLRptNKC07` | `` | `glrptnkc07` | `rpt` | `gl.rpt.glrptnkc07` | no | `SimbaPage shell` |
| GL | `02.25.29` | `4` | `GLRptTH01` | `` | `glrptth01` | `rpt` | `gl.rpt.glrptth01` | no | `SimbaPage shell` |
| GL | `02.50.20` | `4` | `GLRptTMBCTC` | `` | `glrpttmbctc` | `rpt` | `gl.rpt.glrpttmbctc` | no | `SimbaPage shell` |
| GL | `02.10.24` | `1` | `GLBudget` | `GLKHNS_MA_SO` | `glbudget` | `vch` | `gl.vch.glbudget` | no | `SimbaPage shell` |
| GL | `02.10.17` | `1` | `GLNB` | `GLNB` | `glnb` | `vch` | `gl.vch.glnb` | no | `SimbaPage shell` |
| GL | `02.10.05` | `1` | `GLPOST2GLKC` | `` | `glpost2glkc` | `vch` | `gl.vch.glpost2glkc` | no | `SimbaPage shell` |
| GL | `02.10.02` | `1` | `GLVchGL1` | `GL1` | `glvchgl1` | `vch` | `gl.vch.glvchgl1` | no | `SimbaPage shell` |
| IN | `14.90.23` | `2` | `CODMSPCT` | `MA_SPCT` | `codmspct` | `dict` | `in.dict.codmspct` | no | `SimbaPage shell` |
| IN | `14.90.29` | `2` | `FADMBPSD` | `MA_BPSD` | `fadmbpsd` | `dict` | `in.dict.fadmbpsd` | no | `SimbaPage shell` |
| IN | `14.90.14` | `2` | `INDMKHO` | `MA_KHO` | `indmkho` | `dict` | `in.dict.indmkho` | yes | `Diepxuan\Catalog\Http\Livewire\In\Dmkho` |
| IN | `14.90.20` | `2` | `INDMLO` | `MA_LO` | `indmlo` | `dict` | `in.dict.indmlo` | no | `SimbaPage shell` |
| IN | `14.90.05` | `2` | `INDMNHVT` | `MA_NHVT` | `indmnhvt` | `dict` | `in.dict.indmnhvt` | yes | `Diepxuan\Catalog\Http\Livewire\In\Dmnhvt` |
| IN | `14.90.02` | `2` | `INDMVT` | `MA_VT` | `indmvt` | `dict` | `in.dict.indmvt` | yes | `Diepxuan\Catalog\Http\Livewire\In\Dmvt` |
| IN | `14.90.26` | `2` | `SIDMHD` | `MA_HD` | `sidmhd` | `dict` | `in.dict.sidmhd` | no | `SimbaPage shell` |
| IN | `14.90.25` | `2` | `SIDMNHHD` | `MA_NHHD` | `sidmnhhd` | `dict` | `in.dict.sidmnhhd` | no | `SimbaPage shell` |
| IN | `14.90.38` | `2` | `SISysvars` | `` | `sisysvars` | `dict` | `in.dict.sisysvars` | no | `SimbaPage shell` |
| IN | `14.10.23` | `6` | `INCDFIFO` | `INCDFIFO` | `incdfifo` | `proc` | `in.proc.incdfifo` | no | `SimbaPage shell` |
| IN | `14.10.20` | `6` | `INCDVT` | `INCDVT` | `incdvt` | `proc` | `in.proc.incdvt` | no | `SimbaPage shell` |
| IN | `14.10.38` | `6` | `INTransferINCDVT` | `` | `intransferincdvt` | `proc` | `in.proc.intransferincdvt` | no | `SimbaPage shell` |
| IN | `14.20.56` | `4` | `DynamicReport` | `` | `dynamicreport` | `rpt` | `in.rpt.dynamicreport` | no | `SimbaPage shell` |
| IN | `14.20.26` | `4` | `INRptBK01` | `` | `inrptbk01` | `rpt` | `in.rpt.inrptbk01` | no | `SimbaPage shell` |
| IN | `14.20.14` | `4` | `INRptBKN04` | `` | `inrptbkn04` | `rpt` | `in.rpt.inrptbkn04` | no | `SimbaPage shell` |
| IN | `14.20.20` | `4` | `INRptBKX04` | `` | `inrptbkx04` | `rpt` | `in.rpt.inrptbkx04` | no | `SimbaPage shell` |
| IN | `14.20.08` | `4` | `INRptCD01` | `` | `inrptcd01` | `rpt` | `in.rpt.inrptcd01` | no | `SimbaPage shell` |
| IN | `14.20.11` | `4` | `INRptCD02` | `` | `inrptcd02` | `rpt` | `in.rpt.inrptcd02` | no | `SimbaPage shell` |
| IN | `14.20.02` | `4` | `INRptCTVT01` | `` | `inrptctvt01` | `rpt` | `in.rpt.inrptctvt01` | no | `SimbaPage shell` |
| IN | `14.20.05` | `4` | `INRptCTVT02` | `` | `inrptctvt02` | `rpt` | `in.rpt.inrptctvt02` | no | `SimbaPage shell` |
| IN | `14.20.17` | `4` | `INRptTHN01` | `` | `inrptthn01` | `rpt` | `in.rpt.inrptthn01` | no | `SimbaPage shell` |
| IN | `14.20.18` | `4` | `INRptTHN02` | `` | `inrptthn02` | `rpt` | `in.rpt.inrptthn02` | no | `SimbaPage shell` |
| IN | `14.20.23` | `4` | `INRptTHX01` | `` | `inrptthx01` | `rpt` | `in.rpt.inrptthx01` | no | `SimbaPage shell` |
| IN | `14.20.24` | `4` | `INRptTHX02` | `` | `inrptthx02` | `rpt` | `in.rpt.inrptthx02` | no | `SimbaPage shell` |
| IN | `14.10.29` | `1` | `INCalGiaBQDD` | `` | `incalgiabqdd` | `vch` | `in.vch.incalgiabqdd` | no | `SimbaPage shell` |
| IN | `14.10.32` | `1` | `INCalGiaNTXT` | `` | `incalgiantxt` | `vch` | `in.vch.incalgiantxt` | no | `SimbaPage shell` |
| IN | `14.10.26` | `1` | `INCalGiaTB` | `` | `incalgiatb` | `vch` | `in.vch.incalgiatb` | no | `SimbaPage shell` |
| IN | `14.10.02` | `1` | `INVchIN1` | `IN1` | `invchin1` | `vch` | `in.vch.invchin1` | no | `SimbaPage shell` |
| IN | `14.10.05` | `1` | `INVchIN2` | `IN2` | `invchin2` | `vch` | `in.vch.invchin2` | no | `SimbaPage shell` |
| IN | `14.10.08` | `1` | `INVchIN3` | `IN3` | `invchin3` | `vch` | `in.vch.invchin3` | no | `SimbaPage shell` |
| IN | `14.10.11` | `1` | `INVchIN5` | `IN5` | `invchin5` | `vch` | `in.vch.invchin5` | no | `SimbaPage shell` |
| IN | `14.10.14` | `1` | `INVchIN6` | `IN6` | `invchin6` | `vch` | `in.vch.invchin6` | no | `SimbaPage shell` |
| PO | `10.90.22` | `2` | `ARDMKH` | `MA_KH` | `ardmkh` | `dict` | `po.dict.ardmkh` | yes | `Diepxuan\Catalog\Http\Livewire\Muahang\Cungcap` |
| PO | `10.90.25` | `2` | `ARDMPLKH` | `MA_PLKH` | `ardmplkh` | `dict` | `po.dict.ardmplkh` | no | `SimbaPage shell` |
| PO | `10.90.14` | `2` | `PODMCP` | `MA_CP` | `podmcp` | `dict` | `po.dict.podmcp` | yes | `Diepxuan\Catalog\Http\Livewire\Muahang\PoDmCpIndex` |
| PO | `10.90.12` | `2` | `PODMGIAMUA` | `MA_GIAMUA` | `podmgiamua` | `dict` | `po.dict.podmgiamua` | no | `SimbaPage shell` |
| PO | `10.90.02` | `2` | `PODMHTTT` | `MA_HTTT_PO` | `podmhttt` | `dict` | `po.dict.podmhttt` | no | `SimbaPage shell` |
| PO | `10.90.11` | `2` | `SIDMBP` | `MA_BP` | `sidmbp` | `dict` | `po.dict.sidmbp` | no | `SimbaPage shell` |
| PO | `10.90.08` | `2` | `SIDMHD` | `MA_HD` | `sidmhd` | `dict` | `po.dict.sidmhd` | no | `SimbaPage shell` |
| PO | `10.90.07` | `2` | `SIDMNHHD` | `MA_NHHD` | `sidmnhhd` | `dict` | `po.dict.sidmnhhd` | no | `SimbaPage shell` |
| PO | `10.90.80` | `2` | `SISysvars` | `` | `sisysvars` | `dict` | `po.dict.sisysvars` | no | `SimbaPage shell` |
| PO | `10.10.44` | `6` | `ARCDKH` | `MA_CDKH` | `arcdkh` | `proc` | `po.proc.arcdkh` | no | `SimbaPage shell` |
| PO | `10.30.02` | `4` | `APRptBK01` | `` | `aprptbk01` | `rpt` | `po.rpt.aprptbk01` | no | `SimbaPage shell` |
| PO | `10.30.11` | `4` | `ARRptBCCN01` | `` | `arrptbccn01` | `rpt` | `po.rpt.arrptbccn01` | no | `SimbaPage shell` |
| PO | `10.30.14` | `4` | `ARRptBCCN01a` | `` | `arrptbccn01a` | `rpt` | `po.rpt.arrptbccn01a` | no | `SimbaPage shell` |
| PO | `10.30.17` | `4` | `ARRptBCCN02` | `` | `arrptbccn02` | `rpt` | `po.rpt.arrptbccn02` | no | `SimbaPage shell` |
| PO | `10.30.20` | `4` | `ARRptBCCN03` | `` | `arrptbccn03` | `rpt` | `po.rpt.arrptbccn03` | no | `SimbaPage shell` |
| PO | `10.30.35` | `4` | `ARRptBCCN04` | `` | `arrptbccn04` | `rpt` | `po.rpt.arrptbccn04` | no | `SimbaPage shell` |
| PO | `10.30.26` | `4` | `ARRptBCCN05` | `` | `arrptbccn05` | `rpt` | `po.rpt.arrptbccn05` | no | `SimbaPage shell` |
| PO | `10.20.32` | `4` | `GLRptNKC05` | `` | `glrptnkc05` | `rpt` | `po.rpt.glrptnkc05` | no | `SimbaPage shell` |
| PO | `10.20.26` | `4` | `PORptBCPT03` | `` | `porptbcpt03` | `rpt` | `po.rpt.porptbcpt03` | no | `SimbaPage shell` |
| PO | `10.20.02` | `4` | `PORptBK01` | `` | `porptbk01` | `rpt` | `po.rpt.porptbk01` | no | `SimbaPage shell` |
| PO | `10.20.05` | `4` | `PORptBK02` | `` | `porptbk02` | `rpt` | `po.rpt.porptbk02` | no | `SimbaPage shell` |
| PO | `10.20.20` | `4` | `PORptBK03` | `` | `porptbk03` | `rpt` | `po.rpt.porptbk03` | no | `SimbaPage shell` |
| PO | `10.20.08` | `4` | `PORptTH01` | `` | `porptth01` | `rpt` | `po.rpt.porptth01` | no | `SimbaPage shell` |
| PO | `10.20.11` | `4` | `PORptTH02` | `` | `porptth02` | `rpt` | `po.rpt.porptth02` | no | `SimbaPage shell` |
| PO | `10.20.23` | `4` | `PORptTH03` | `` | `porptth03` | `rpt` | `po.rpt.porptth03` | no | `SimbaPage shell` |
| PO | `10.10.38` | `1` | `APVchAP4` | `AP4` | `apvchap4` | `vch` | `po.vch.apvchap4` | no | `SimbaPage shell` |
| PO | `10.10.53` | `1` | `POTaIn` | `POTAIN_STT_REC` | `potain` | `vch` | `po.vch.potain` | no | `SimbaPage shell` |
| PO | `10.10.05` | `1` | `POVchPO1` | `PO1` | `povchpo1` | `vch` | `po.vch.povchpo1` | no | `SimbaPage shell` |
| PO | `10.10.14` | `1` | `POVchPO3` | `PO3` | `povchpo3` | `vch` | `po.vch.povchpo3` | no | `SimbaPage shell` |
| PO | `10.10.20` | `1` | `POVchPO4` | `PO4` | `povchpo4` | `vch` | `po.vch.povchpo4` | no | `SimbaPage shell` |
| PO | `10.10.23` | `1` | `POVchPO5` | `PO5` | `povchpo5` | `vch` | `po.vch.povchpo5` | no | `SimbaPage shell` |
| PO | `10.10.26` | `1` | `POVchPO6` | `PO6` | `povchpo6` | `vch` | `po.vch.povchpo6` | no | `SimbaPage shell` |
| PO | `10.10.17` | `1` | `POVchPO7` | `PO7` | `povchpo7` | `vch` | `po.vch.povchpo7` | no | `SimbaPage shell` |
| SO | `06.90.02` | `2` | `ARDMKH` | `MA_KH` | `ardmkh` | `dict` | `so.dict.ardmkh` | yes | `Diepxuan\Catalog\Http\Livewire\Banhang\Khachhang` |
| SO | `06.90.11` | `2` | `ARDMPLKH` | `MA_PLKH` | `ardmplkh` | `dict` | `so.dict.ardmplkh` | yes | `Diepxuan\Catalog\Http\Livewire\AR\Danhmuc\Phanloaikhachhang` |
| SO | `06.90.35` | `2` | `SIDMBP` | `MA_BP` | `sidmbp` | `dict` | `so.dict.sidmbp` | no | `SimbaPage shell` |
| SO | `06.90.32` | `2` | `SIDMHD` | `MA_HD` | `sidmhd` | `dict` | `so.dict.sidmhd` | no | `SimbaPage shell` |
| SO | `06.90.31` | `2` | `SIDMNHHD` | `MA_NHHD` | `sidmnhhd` | `dict` | `so.dict.sidmnhhd` | no | `SimbaPage shell` |
| SO | `06.90.56` | `2` | `SISysvars` | `` | `sisysvars` | `dict` | `so.dict.sisysvars` | no | `SimbaPage shell` |
| SO | `06.90.29` | `2` | `SODMGIABAN` | `MA_GIABAN` | `sodmgiaban` | `dict` | `so.dict.sodmgiaban` | no | `SimbaPage shell` |
| SO | `06.90.05` | `2` | `SODMHTTT` | `MA_HTTT` | `sodmhttt` | `dict` | `so.dict.sodmhttt` | no | `SimbaPage shell` |
| SO | `06.90.38` | `2` | `SODMNVKD` | `MA_NVKD` | `sodmnvkd` | `dict` | `so.dict.sodmnvkd` | no | `SimbaPage shell` |
| SO | `06.90.50` | `2` | `SODMTS` | `MA_THUE` | `sodmts` | `dict` | `so.dict.sodmts` | no | `SimbaPage shell` |
| SO | `06.10.40` | `6` | `ARCDKH` | `MA_CDKH` | `arcdkh` | `proc` | `so.proc.arcdkh` | no | `SimbaPage shell` |
| SO | `06.30.14` | `4` | `ARRptBCCN01` | `` | `arrptbccn01` | `rpt` | `so.rpt.arrptbccn01` | no | `SimbaPage shell` |
| SO | `06.30.17` | `4` | `ARRptBCCN01a` | `` | `arrptbccn01a` | `rpt` | `so.rpt.arrptbccn01a` | no | `SimbaPage shell` |
| SO | `06.30.20` | `4` | `ARRptBCCN02` | `` | `arrptbccn02` | `rpt` | `so.rpt.arrptbccn02` | no | `SimbaPage shell` |
| SO | `06.30.23` | `4` | `ARRptBCCN03` | `` | `arrptbccn03` | `rpt` | `so.rpt.arrptbccn03` | no | `SimbaPage shell` |
| SO | `06.30.35` | `4` | `ARRptBCCN04` | `` | `arrptbccn04` | `rpt` | `so.rpt.arrptbccn04` | no | `SimbaPage shell` |
| SO | `06.30.26` | `4` | `ARRptBCCN05` | `` | `arrptbccn05` | `rpt` | `so.rpt.arrptbccn05` | no | `SimbaPage shell` |
| SO | `06.30.02` | `4` | `ARRptBK01` | `` | `arrptbk01` | `rpt` | `so.rpt.arrptbk01` | no | `SimbaPage shell` |
| SO | `06.20.50` | `4` | `GLRptNKC04` | `` | `glrptnkc04` | `rpt` | `so.rpt.glrptnkc04` | no | `SimbaPage shell` |
| SO | `06.20.20` | `4` | `SORptBCPT03` | `` | `sorptbcpt03` | `rpt` | `so.rpt.sorptbcpt03` | no | `SimbaPage shell` |
| SO | `06.20.23` | `4` | `SORptBCPT04` | `` | `sorptbcpt04` | `rpt` | `so.rpt.sorptbcpt04` | no | `SimbaPage shell` |
| SO | `06.20.26` | `4` | `SORptBCPT06` | `` | `sorptbcpt06` | `rpt` | `so.rpt.sorptbcpt06` | no | `SimbaPage shell` |
| SO | `06.20.02` | `4` | `SORptBK01` | `` | `sorptbk01` | `rpt` | `so.rpt.sorptbk01` | no | `SimbaPage shell` |
| SO | `06.20.05` | `4` | `SORptBK02` | `` | `sorptbk02` | `rpt` | `so.rpt.sorptbk02` | no | `SimbaPage shell` |
| SO | `06.20.47` | `4` | `SORptLaiLo` | `` | `sorptlailo` | `rpt` | `so.rpt.sorptlailo` | no | `SimbaPage shell` |
| SO | `06.20.08` | `4` | `SORptTH01` | `` | `sorptth01` | `rpt` | `so.rpt.sorptth01` | no | `SimbaPage shell` |
| SO | `06.20.11` | `4` | `SORptTH02` | `` | `sorptth02` | `rpt` | `so.rpt.sorptth02` | no | `SimbaPage shell` |
| SO | `06.10.29` | `1` | `ARVchAR4` | `AR4` | `arvchar4` | `vch` | `so.vch.arvchar4` | no | `SimbaPage shell` |
| SO | `06.10.35` | `1` | `SOTaOut` | `SOTAOUT_STT_REC` | `sotaout` | `vch` | `so.vch.sotaout` | no | `SimbaPage shell` |
| SO | `06.10.02` | `1` | `SOVchSO1` | `SO1` | `sovchso1` | `vch` | `so.vch.sovchso1` | yes | `Diepxuan\Catalog\Http\Livewire\Banhang\Hoadonbanhang` |
| SO | `06.10.08` | `1` | `SOVchSO3` | `SO3` | `sovchso3` | `vch` | `so.vch.sovchso3` | no | `SimbaPage shell` |
| SO | `06.10.11` | `1` | `SOVchSO4` | `SO4` | `sovchso4` | `vch` | `so.vch.sovchso4` | no | `SimbaPage shell` |
| SO | `06.10.14` | `1` | `SOVchSO5` | `SO5` | `sovchso5` | `vch` | `so.vch.sovchso5` | no | `SimbaPage shell` |
