# Simba Menu-backed Registries Audit

Ngày audit: 2026-06-18

## Mục tiêu

Baseline cho refactor registry Simba sang nguồn dữ liệu `sysMenu`/`zsysmenu`.

## Trạng thái môi trường

Lệnh kiểm tra count qua `php artisan tinker` đã bị chặn bởi môi trường local thiếu Microsoft ODBC Driver for SQL Server:

```text
PDOException SQLSTATE[IMSSP]: This extension requires the Microsoft ODBC Driver for SQL Server to communicate with SQL Server.
```

Vì vậy audit runtime count từ database chưa lấy được trong môi trường hiện tại. Phần refactor vẫn giữ nguyên nguyên tắc: registry đọc qua `SimbaMenuRepository::activeMenus()` và không query trực tiếp `sysMenu`/`zsysmenu` trong registry.

## Registry chuyển đổi

Các class registry giữ API compatibility và delegate sang service mới `Diepxuan\Catalog\Services\SimbaMenuRouteMetadata`:

- `SimbaRouteRegistry::routes()`
- `SimbaRouteRegistry::routesWithoutProcesses()`
- `SimbaDictionaryRegistry::dictionaries()`
- `SimbaReportRegistry::reports()`
- `SimbaProcessRegistry::processes()`

## Source of truth

- Menu active lấy từ `SimbaMenuRepository::activeMenus()`.
- `SimbaMenuRepository` merge `SysMenu` và `Zsysmenu`, lọc `menuid` rỗng, unique theo `menuid`, rồi filter `active`.
- Metadata phụ enrich từ các model Simba tương ứng:
  - dictionary: `SysDictionaryInfo`
  - report: `SysReportInfo`, `ZSysReportInfo`, `SysReportDrillDownInfo`
  - process/custom: field trên menu

## Verification đã chạy

```bash
php -l diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php
php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php
php -l diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php
php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php
php -l diepxuan/laravel-catalog/src/Config/SimbaProcessRegistry.php
php -l diepxuan/laravel-catalog/src/Services/SimbaMenuTargetResolver.php
php -l diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
./vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
LOG_CHANNEL=stderr php artisan route:list --name=simba
```

Kết quả:

- PHP lint pass.
- Unit test mới pass: 5 tests, 10 assertions.
- Route list Simba load được 3 route generic `simba`, `simba.show-short`, `simba.show`.

## Blocker còn lại

- Chưa smoke được registry count thực tế từ SQL Server vì thiếu Microsoft ODBC Driver trong runtime hiện tại.
