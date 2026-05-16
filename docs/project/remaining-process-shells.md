# Remaining Process Shells

Ngay cap nhat: 2026-05-15

Nguon:

- `simba-docs/data/sysMenu.md`
- `SimbaProcessRegistry`
- `SimbaRouteRegistry`

Sau cac batch route/report/dictionary/voucher, con 48 route `simba.process`.
Nhom nay khong duoc execute vi con thieu metadata payload/SP/function sach hoac co side effect ghi/xoa/chuyen so lieu.

## Counts

| Module | Process shells | Ly do chinh |
|---|---:|---|
| GL | 4 | Ket chuyen, dang ky CTGS, F5 thieu `sysReportInfo` |
| CA | 1 | Ty gia ngoai te thieu `sysDictionaryInfo` |
| SO | 2 | Hoa don GTGT dau ra, tham so he thong |
| PO | 3 | Hoa don GTGT dau vao, gia mua, tham so he thong |
| IN | 10 | Tinh gia ton kho, F5 thieu report metadata, tham so |
| CO | 10 | Chi phi tra truoc, ket chuyen/post/xoa phan bo |
| FA | 12 | Tai san/CCDC, tinh/xoa/phan bo khau hao |
| SI | 6 | Tham so, khoa so, backup, import/export, danh lai so CT |

## Rules

- Neu co `sysDictionaryInfo` exact/alias hoac table-name alias sach thi route phai ra `simba.dictionary`, khong nam o day.
- Neu co `sysReportInfo`/`zSysReportInfo`/`sysReportDrillDownInfo` du chuan thi route phai ra `simba.report`, khong nam o day.
- Neu co `sysVoucherInfo` + `SiDmCt` du chuan thi route phai ra voucher shell, khong nam o day.
- Moi route trong file nay chi la read-only shell; khong goi SQL/SP/function.

## Blocked Groups

| Group | Menu examples | Blocker |
|---|---|---|
| GL post/transfer | `02.10.05`, `18.10.02` | Ket chuyen/post sang GL co side effect |
| Inventory costing | `14.10.26`, `14.10.29`, `14.10.32` | Tinh gia ton kho, can audit transaction va ket qua ghi |
| CO allocation/posting | `17.15.05`, `17.15.11`, `18.15.05`, `18.15.11` | Phan bo/xoa phan bo/post sang GL |
| FA depreciation/posting | `20.10.23`, `20.10.29`, `20.10.35`, `20.10.38` | Tinh/xoa/phan bo khau hao, side effect lon |
| SI maintenance | `90.30.05`, `90.30.11`, `90.30.14`, `90.30.17`, `90.30.26` | Khoa so, backup, import/export, danh lai so CT |
| Metadata missing | `90.10.29`, `10.90.12`, `14.80.02`, `14.80.05` | Co DLL/menu nhung thieu dictionary/report metadata sach trong `simba-docs/data` |

## Verification

Full registry/menu batch pass:

```bash
./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Config/SimbaRouteRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/PoVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SoVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/InVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/FinanceVoucherRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SimbaReportRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SimbaDictionaryRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SimbaProcessRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Services/SimbaDocsMenuRepositoryTest.php
```

Ket qua moi nhat: `29 tests, 2805 assertions`.
