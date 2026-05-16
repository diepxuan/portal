# Task Execution Coverage

Ngay cap nhat: 2026-05-15

Nguon su that:

- `docs/tasks/`
- `simba-docs/data/sysMenu.md`
- `simba-docs/data/zsysmenu.md`
- `simba-docs/data/sysReportInfo.md`
- `simba-docs/data/zSysReportInfo.md`
- `simba-docs/data/sysDictionaryInfo.md`
- `simba-docs/data/sysVoucherInfo.md`
- `simba-docs/data/SiDmCt.md`

Quy tac:

- Khong truy cap SQL Server.
- Khong execute SP/function neu chua doi chieu du tham so, payload, validate rule va side effect trong `simba-docs`.
- Active menu co metadata report/dictionary/voucher hoac co DLL/command/code_name phai co route anchor.
- Root/group/section menu khong co DLL/command/code_name khong tao route rieng.

## Route anchor coverage

`SimbaRouteRegistry::routes()` hien co 302 route anchors.

| Source type | Count | Y nghia |
|---|---:|---|
| `report` | 169 | Report co metadata tu `sysReportInfo`/`zSysReportInfo`, master-data list report khong co dictionary metadata sach, F5 route co `sysMenu.report = 1`, hoac F5/drilldown tu `sysReportDrillDownInfo`; static route hoac generic shell |
| `dictionary` | 47 | Dictionary co metadata tu `sysDictionaryInfo`; static route, generic shell, active sysMenu `code_name` alias, hoac `table_name` alias co `source_menuid` |
| `voucher` | 24 | Voucher co `ma_ct` tu `SiDmCt` va/hoac `sysVoucherInfo`; static/shell theo module |
| `custom` | 62 | Process/setup/menu co DLL/command/code_name hoac route he thong hien huu; read-only shell khi chua du metadata execute |

Route he thong hien huu duoc uu tien hon generic process shell khi menu Simba da co man hinh Portal tuong ung. Nhom `system.balance.*` dang map truc tiep cac menu so du/chuyen so du:

| Menuid | Simba menu | Portal route |
|---|---|---|
| `02.10.14` | So du dau ky cac tai khoan | `system.balance.account-opening` |
| `02.10.20` | Chuyen so du tai khoan sang nam sau | `system.balance.transfer` |
| `06.10.40` | So du dau ky cong no phai thu | `system.balance.accounts-receivable` |
| `10.10.44` | So du dau ky cong no phai tra | `system.balance.accounts-payable` |
| `14.10.20` | Nhap ton kho dau ky | `system.balance.inventory-opening` |
| `14.10.23` | Nhap ton kho dau ky NTXT | `system.balance.inventory-opening-ntxt` |
| `14.10.38` | Chuyen ton kho sang nam sau | `system.balance.inventory-transfer` |
| `18.10.11` | Nhap gia tri SP do dang cuoi ky | `system.balance.work-in-progress` |
| `18.10.14` | Nhap phat sinh luy ke tu khi khoi cong | `system.balance.cumulative-transactions` |

Menu he thong `90.40.17` (Chon don vi) da map vao `system.company`. Route nay chi cap nhat session `selected_company` theo danh sach don vi user duoc phan quyen; khong ghi SQL Server.

Mot so process he thong da co route Portal that thay cho generic process shell:

| Menuid | Simba menu | Portal route | Ghi chu |
|---|---|---|---|
| `90.20.02` | Quan ly nguoi su dung | `system.user.index` | Man hinh quan ly/link user hien huu |
| `90.20.08` | Doi mat khau | `profile.show` | Jetstream profile/password screen |
| `90.30.02` | Chon nam lam viec | `system.year` | Cap nhat session `year`, khong SQL write |

F5/drilldown report routes lay tu `sysReportDrillDownInfo.md` duoc phan loai la `report`, khong con nam trong generic `process`. Cac route nay van la read-only shell: hien DLL/command/source menu/key F5, chua execute SP/function.

Man hinh `hethong/menu` hien cay menu Simba tu `simba-docs`, gan link Portal cho cac menu da map va hien badge theo source type (`Report`, `Danh muc`, `Chung tu`, `Portal`). Search trong cay menu co the tim theo menuid, ten, DLL hoac route name.

Master-data menu co `sysReportInfo` nhung khong co dictionary metadata sach cung duoc mo bang report/list shell read-only; neu co dictionary exact/alias thi dictionary duoc uu tien. Menu F5 co `sysMenu.report = 1` cung duoc mo nhu report/list shell khi co `sysReportInfo`.

Mot so menu danh muc co `sysMenu.code_name` khop dictionary that nhung `sysDictionaryInfo.menuid` bi trong/lẹch. Cac menu nay duoc mo qua `simba.dictionary` voi `source_menuid` de khong che dau lech source:

| Menuid | Route | Code | Source menuid |
|---|---|---|---|
| `90.10.23` | `gl.dict.sidmbp` | `MA_BP` | `06.90.35` |
| `04.90.05` | `ca.dict.ardmkh` | `MA_KH` | `06.90.02` |
| `06.90.32` | `so.dict.sidmhd` | `MA_HD` | `90.10.17` |
| `10.90.25` | `po.dict.ardmplkh` | `MA_PLKH` | `06.90.11` |
| `10.90.07` | `po.dict.sidmnhhd` | `MA_NHHD` | `06.90.31` |
| `10.90.08` | `po.dict.sidmhd` | `MA_HD` | `90.10.17` |
| `10.90.11` | `po.dict.sidmbp` | `MA_BP` | `06.90.35` |
| `14.90.23` | `in.dict.codmspct` | `MA_SPCT` | `18.90.05` |
| `14.90.25` | `in.dict.sidmnhhd` | `MA_NHHD` | `06.90.31` |
| `14.90.26` | `in.dict.sidmhd` | `MA_HD` | `90.10.17` |
| `14.90.29` | `in.dict.fadmbpsd` | `MA_BPSD` | `20.90.08` |
| `17.90.04` | `gl.dict.sidmphi` | `MA_PHI` | `90.10.20` |
| `20.90.05` | `fa.dict.fadmldts` | `MA_LDTG` | `18.90.05` |

Table-name aliases them tu `sysDictionaryInfo.table_name`:

| Menuid | Route | Code | Table | Source menuid |
|---|---|---|---|---|
| `02.90.05` | `gl.dict.gldmkc` | `MA_KC` | `GLDMKC` | blank |
| `18.90.11` | `co.dict.codmbom` | `MA_COBOM` | `CODMBOM` | blank |
| `18.90.17` | `co.dict.gldmkc` | `MA_KC` | `GLDMKC` | blank |

## Coverage by module

Cot `Custom routes` la toan bo source_type `custom`: gom route Portal hien huu, route he thong moi va generic `simba.process`. Rieng generic process shell con lai duoc tach o `docs/project/remaining-process-shells.md`.

| Module | Dictionary | Voucher | Report | Custom routes |
|---|---:|---:|---:|---:|
| AP | 0 | 1 | 12 | 0 |
| AR | 0 | 1 | 12 | 0 |
| CA | 2 | 4 | 7 | 1 |
| CO | 6 | 0 | 19 | 12 |
| FA | 6 | 0 | 13 | 12 |
| GL | 6 | 2 | 49 | 6 |
| IN | 8 | 6 | 21 | 13 |
| PO | 7 | 6 | 12 | 4 |
| SI | 5 | 0 | 1 | 11 |
| SO | 7 | 4 | 23 | 3 |

## Generic shell routes

| Route | Component | Scope |
|---|---|---|
| `simba.report` | `System\SimbaReportIndex` | Hien `module`, `menuid`, `ma_mau`, `spname`, `rptname` |
| `simba.dictionary` | `System\SimbaDictionaryIndex` | Hien `code_name`, `table`, `PK`, `carry_field_list` source |
| `simba.process` | `System\SimbaProcessIndex` | Hien `dllName`, `command`, `code_name`; khong execute |

## Remaining active menu without route

Con 57 active menu khong co route anchor. Nhom nay chi gom:

- Root module menu.
- Group/section menu.
- Dong trong `sysMenu` khong co DLL/command/code_name.

Danh sach chi tiet: `docs/project/unmapped-active-menu.md`.

Process shell con lai: `docs/project/remaining-process-shells.md`.

Neu mot dong trong nhom nay sau nay duoc bo sung DLL/command/code_name hoac metadata report/dictionary/voucher trong `simba-docs`, `SimbaRouteRegistryTest::testEveryActionableActiveMenuHasRouteAnchor` se bat loi cho den khi Portal co route anchor.

## Blockers

Voucher/process khong duoc coi la hoan thanh execute khi con mot trong cac dieu kien:

- Khong co `sysVoucherInfo` cho `ma_ct`.
- `sysMenu` inactive hoac menuid lech giua `SiDmCt`, `sysMenu`, `sysVoucherInfo`.
- Chua co mapping tham so SP/function trong `simba-docs`.
- La flow co side effect nhu tinh gia, post sang GL, chuyen so lieu, khoa so, backup, import/export, xoa ket qua.

Voucher metadata mismatches dang duoc chan:

| Voucher | Ly do |
|---|---|
| `AP4` | `sysVoucherInfo.menuid = 12.10.11`, active menu/route dung `10.10.38`; route shell `ap.vch.ap4` theo active menu va `SiDmCt` |
| `AR4` | `sysVoucherInfo.menuid = 08.10.11`, active menu/route dung `06.10.29`; route shell `ar.vch.ar4` theo active menu va `SiDmCt` |
| `CA5` | `sysVoucherInfo.menuid = 04.10.14` nhung `sysMenu` inactive |
| `CR1` | `sysVoucherInfo.menuid = 02.10.06`; menu hop nhat tuong ung inactive trong `sysMenu` |

## Verification

Regression tests khoa coverage:

- `SimbaRouteRegistryTest::testRouteAnchorCountsBySourceType`
- `SimbaRouteRegistryTest::testRouteAnchorCountsByModuleAndSourceType`
- `SimbaRouteRegistryTest::testRemainingActiveMenusWithoutRoutesAreNonActionableContainers`
- `SimbaProcessRegistryTest::testRemainingProcessShellCountsByModule`

Da chay:

```bash
./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Config/SimbaRouteRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/PoVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SoVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/InVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/FinanceVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SimbaReportRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SimbaDictionaryRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SimbaProcessRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Services/SimbaDocsMenuRepositoryTest.php
```

Ket qua: 29 tests, 2805 assertions.
