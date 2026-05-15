# Portal Task Master Execution

**Muc tieu:** thuc hien toan bo task trong `docs/tasks/` theo dung SimbaERP, khong suy doan.

**Ngay lap:** 2026-05-14

---

## 1. Pham vi bat buoc

Tat ca task nguon nam trong `docs/tasks/`.

Nguon su that duy nhat khi implement:

| Nhom | Nguon |
|------|-------|
| Menu/router | `simba-docs/data/sysMenu.md`, `simba-docs/data/zsysmenu.md` |
| Chung tu | `simba-docs/data/SiDmCt.md`, `simba-docs/data/sysVoucherInfo.md`, `simba-docs/data/sysVoucherResx.md` |
| Bao cao | `simba-docs/data/sysReportInfo.md`, `simba-docs/data/zSysReportInfo.md`, `simba-docs/data/sysReportDrillDownInfo.md` |
| Tu dien field | `simba-docs/data/sysDictionaryInfo.md`, `simba-docs/data/sysDictionaryResx.md` |
| Tables/SP/function | `simba-docs/asia/TABLES_INDEX.md`, `simba-docs/asia/SP_INDEX.md`, `simba-docs/procedures/` |
| Logic/DLL | `simba-docs/decompiled/asia/{DLL}.dll/README.md` |
| Module flow | `simba-docs/asia/{MODULE}_SUMMARY.md`, `simba-docs/asia/{module}/` |

Rang buoc:

- Khong truy cap SQL Server trong qua trinh implement.
- Khong tao/sua schema SQL.
- Khong bia ten bang, SP, function, field, route.
- Router/menu phai theo data SimbaERP, khong dat theo cam tinh.
- Code PHP chi anh xa logic va du lieu da co trong Simba.

---

## 2. Inventory ban dau

Ket qua quet `docs/tasks/`:

| Nhom | Range/chum task chinh | Ghi chu |
|------|------------------------|---------|
| System/SI | `081-099`, `181-196`, `218-224`, task cu `1`, `5`, `11`, `26` | Nen lam truoc de co nen router, framework, auth, config |
| AR | `001-016`, `158` | Cong no phai thu, danh muc KH, bao cao AR |
| AP | `017-020` | Cong no phai tra |
| CA | `021-032`, `159-165`, `CA4-PHIEU-BAONO-SPEC` | Tien mat ngan hang |
| SO | `038`, `043-062`, `197-216`, `339-340`, task cu `32`, `34-37`, `55` | Ban hang |
| PO | `063-080`, `217` | Mua hang, PO3 dang WIP |
| IN | `100-117`, `225-235`, `355`, task cu `59` | Ton kho |
| FA | `118-137`, `236-253`, `341` | Tai san co dinh |
| GL | `049`, `138-157`, `254-337` | So cai, BCTC, reports |
| CO | `039-042`, `166-180`, `342-353` | San xuat, gia thanh |

Trang thai docs hien tai khong dong nhat: `docs/tasks/README.md` co cac bang ghi nhieu task la Done, nhung audit cung ghi phan lon pending/needs update/WIP. Khi implement tung task, phai xac minh lai bang code hien huu va nguon `simba-docs/`, khong tin tuyet doi vao status trong README.

---

## 3. Thu tu thuc hien

### Phase 0 - Foundation inventory

1. Lap task matrix tu `docs/tasks/`.
2. Lap menu/router matrix tu `simba-docs/data/sysMenu.md`.
3. Lap voucher matrix tu `SiDmCt.md` va `sysVoucherInfo.md`.
4. Lap report matrix tu `sysReportInfo.md`.
5. Doi chieu code hien co trong `diepxuan/laravel-catalog` va `diepxuan/laravel-simba`.

### Phase 1 - System foundation

Tap trung:

- `181-196-system-framework-infrastructure.md`
- `081-099-SI-*`
- `218-224-si-*`
- task cu: `1-simba-login.md`, `5-developer-support.md`, `11-admin-dashboard.md`

Output bat buoc:

- Router/menu generator hoac mapping doc theo `sysMenu`.
- Base module registry.
- Base voucher/report/menu patterns.
- SQL Server access policy chi dung wrappers/model da co, khong doc DB truc tiep.

### Phase 2 - Master data

Thu tu:

1. SI common masters.
2. AR/AP customers/suppliers/payment terms.
3. IN item/warehouse masters.
4. GL accounts.
5. SO/PO/FA/CO module-specific masters.

### Phase 3 - Vouchers

Thu tu:

1. CA vouchers.
2. PO vouchers.
3. SO vouchers.
4. IN vouchers.
5. GL vouchers.
6. FA/CO process vouchers.

### Phase 4 - Reports and calculations

Chi lam report/calculation khi:

- Menu route da co.
- Source SP/report info da xac minh.
- Input filters va lookup da co pattern dung.
- Data model/SP wrapper da co.

### Phase 5 - Audit, CI, PR

Chi tao PR review khi:

- Toan bo task trong `docs/tasks/` da co status ro rang.
- Task implement xong da pass verify phu hop.
- Task chua the implement co blocker doc tu `simba-docs/` ro rang.
- Khong con file thua/untracked lien quan.

---

## 4. Definition of Done cho tung task

Mot task chi duoc danh dau done khi:

1. Co route/menu dung theo `simba-docs/data`.
2. Co UI du action chinh cua form Simba goc.
3. Co model/SP/function wrapper dung ten that.
4. Co payload map dung field that.
5. Co validate/business rule lay tu DLL/docs.
6. Khong co SQL moi, khong sua schema.
7. `php -l` pass cho file PHP sua.
8. Test/lint/build phu hop da chay hoac co blocker ro.
9. Co cap nhat task status/doc neu thay doi behavior.

---

## 5. Batch dang thuc hien

### Batch A - Foundation inventory/router source

Trang thai: DONE cho route/menu coverage read-only; execute SP/function co side effect van blocked theo tung task.

Checklist:

- [x] Xac nhan khong truy cap SQL Server.
- [x] Quet danh sach task trong `docs/tasks/`.
- [x] Xac nhan cac data source trong `simba-docs/data`.
- [x] Doi `SimbaMenuTree` tu model `SysMenu` tren `sqlsrv` sang repository doc `simba-docs/data/sysMenu.md` va `zsysmenu.md`.
- [x] Them controller API dang thieu de Artisan bootstrap route duoc.
- [x] Verify `php artisan route:list --path=muahang` chay duoc va hien 4 route mua hang hien co.
- [x] Parse `sysMenu.md` va lap router/menu matrix trong `docs/project/simba-router-menu-matrix.md`.
- [x] Parse `SiDmCt.md`, `sysVoucherInfo.md`.
- [x] Parse `sysReportInfo.md`.
- [x] Audit route hien co trong `diepxuan/laravel-catalog/routes`.
- [x] Lap batch implement dau tien: route metadata + PO voucher family.

Verification da chay:

| Check | Result |
|---|---|
| `php -l diepxuan/laravel-catalog/src/Services/SimbaDocsDataRepository.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Services/SimbaDocsMenuItem.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Services/SimbaDocsMenuRepository.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/System/SimbaMenuTree.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Controllers/CatalogController.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Controllers/CategoryController.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Services/SimbaDocsMenuRepositoryTest.php` | Pass |
| `./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaDocsMenuRepositoryTest.php` | Pass; 2 tests, 7 assertions |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Config/SimbaRouteRegistryTest.php` | Pass |
| `./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Config/SimbaRouteRegistryTest.php` | Pass; 3 tests, 25 assertions |
| `php -l diepxuan/laravel-catalog/src/Config/PoVoucherRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Muahang/PoVoucherIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Config/PoVoucherRegistryTest.php` | Pass |
| `./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Config/PoVoucherRegistryTest.php` | Pass; 2 tests, 45 assertions |
| `./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Config/SimbaRouteRegistryTest.php` | Pass; 3 tests, 35 assertions |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Config/SimbaReportRegistryTest.php` | Pass |
| `./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Config/SimbaReportRegistryTest.php diepxuan/laravel-catalog/tests/Unit/Config/SimbaRouteRegistryTest.php` | Pass; 4 tests, 67 assertions |
| Combined registry tests | Pass; 8 tests, 115 assertions |
| `php artisan route:list --path=muahang` | Pass; 11 routes listed |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Banhang/Khachhang.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Muahang/Cungcap.php` | Pass |
| `php -l diepxuan/laravel-simba/src/StoredProcedures/AsARGetDMKH.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Config/SimbaDictionaryRegistryTest.php` | Pass |
| `./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Config/SimbaDictionaryRegistryTest.php` | Pass; 2 tests, 195 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Muahang/PoDmCpIndex.php` | Pass |
| `php artisan route:list --path=muahang/chiphimuahang` | Pass; 2 routes listed |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Muahang/PoReportIndex.php` | Pass |
| `php artisan route:list --path=muahang/baocao` | Pass; 8 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 352 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Banhang/SoReportIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=banhang/baocao` | Pass; 12 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 400 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/In/Baocao/InReportIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=khohang/baocao` | Pass; 11 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 444 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Gl/GlReportIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=gl/baocao` | Pass; 32 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 572 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Fa/FaReportIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=taisan/baocao` | Pass; 12 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 620 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Fa/FaDictionaryIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=taisan/danhmuc` | Pass; 2 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 639 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Co/CoReportIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=chiphi/baocao` | Pass; 15 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 699 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Co/CoDictionaryIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=chiphi/danhmuc` | Pass; 3 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 750 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/System/SiDictionaryIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=hethong/danhmuc` | Pass; 3 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 808 assertions |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Banhang/ArReportIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Muahang/ApReportIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=banhang/congno/baocao` | Pass; 12 routes listed |
| `php artisan route:list --path=muahang/congno/baocao` | Pass; 12 routes listed |
| Combined registry/dictionary tests | Pass; 10 tests, 904 assertions |
| `php -l diepxuan/laravel-catalog/src/Config/SoVoucherRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/Banhang/SoVoucherIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Config/SoVoucherRegistryTest.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=banhang` | Pass; 38 routes listed |
| Combined registry/dictionary/voucher tests | Pass; 12 tests, 931 assertions |
| `php -l diepxuan/laravel-catalog/src/Config/InVoucherRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/In/InVoucherIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Config/InVoucherRegistryTest.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=khohang/chungtu` | Pass; 6 routes listed |
| Combined registry/dictionary/voucher tests | Pass; 14 tests, 985 assertions |
| `php -l diepxuan/laravel-catalog/src/Config/FinanceVoucherRegistry.php` | Pass |
| `php -l diepxuan/laravel-catalog/src/Http/Livewire/FinanceVoucherIndex.php` | Pass |
| `php -l diepxuan/laravel-catalog/tests/Unit/Config/FinanceVoucherRegistryTest.php` | Pass |
| `php -l diepxuan/laravel-catalog/routes/web.php` | Pass |
| `php artisan route:list --path=gl/phieu-ke-toan` | Pass; 1 route listed |
| `php artisan route:list --path=bu-tru-cong-no` | Pass; 2 routes listed |
| Combined registry/dictionary/voucher tests | Pass; 16 tests, 1009 assertions |

Cap nhat 2026-05-15:

| Check | Result |
|---|---|
| `SimbaRouteRegistry::routes()` | Pass; 302 route anchors |
| Full registry/menu/voucher test batch | Pass; 29 tests, 2805 assertions |
| `LOG_CHANNEL=stderr php artisan route:list` | Pass; full route table load, 260 routes |
| `php -l` cho tat ca PHP modified/untracked | Pass |
| `git diff --check` | Pass |

Tai lieu coverage moi:

- `docs/project/task-execution-coverage.md`
- `docs/project/unmapped-active-menu.md`
- `docs/project/remaining-process-shells.md`
