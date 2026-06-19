# Simba Menu-backed Registries Audit

Ngày audit: 2026-06-19

## Mục tiêu

Loại bỏ các registry Simba hard-code trong `diepxuan/laravel-catalog/src/Config`; route/menu metadata phải lấy từ chính MSSQL SimbaERP thông qua các model Simba hiện hữu.

## Trạng thái môi trường

Lệnh smoke đọc runtime từ database bị chặn bởi môi trường local thiếu Microsoft ODBC Driver for SQL Server:

```text
PDOException SQLSTATE[IMSSP]: This extension requires the Microsoft ODBC Driver for SQL Server to communicate with SQL Server.
```

Vì vậy runtime count từ database chưa lấy được trong môi trường hiện tại. Code đã chuyển sang dùng `SimbaMenuRepository::activeMenus()` để đọc dữ liệu MSSQL SimbaERP thay vì PHP array hard-code.

## Registry đã loại bỏ

Các file registry hard-code/compatibility wrapper trong `src/Config` đã bị xóa:

- `SimbaRouteRegistry.php`
- `SimbaDictionaryRegistry.php`
- `SimbaReportRegistry.php`
- `SimbaProcessRegistry.php`

Không còn caller runtime trỏ về các registry này trong `diepxuan/laravel-catalog/src`, `diepxuan/laravel-catalog/tests`, `scripts`.

## Source of truth hiện tại

- Service trung tâm: `Diepxuan\Catalog\Services\SimbaMenuRouteMetadata`.
- Menu active lấy từ `SimbaMenuRepository::activeMenus()`.
- `SimbaMenuRepository` merge `SysMenu` và `Zsysmenu`, lọc `menuid` rỗng, unique theo `menuid`, rồi filter `active`.
- Metadata phụ enrich từ các model Simba tương ứng:
  - dictionary: `SysDictionaryInfo`
  - report: `SysReportInfo`, `ZSysReportInfo`, `SysReportDrillDownInfo`
  - voucher/process/custom: field trên menu

## Public API thay thế

Các caller dùng trực tiếp `SimbaMenuRouteMetadata`:

- `routes()`
- `routesWithoutProcesses()`
- `dictionaries()`
- `reports()`
- `processes()`
- constants `TYPE_DICTIONARY`, `TYPE_VOUCHER`, `TYPE_REPORT`, `TYPE_CUSTOM`

## Verification

```bash
php -l diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php
php -l diepxuan/laravel-catalog/src/Services/SimbaMenuTargetResolver.php
php -l diepxuan/laravel-catalog/src/Http/Livewire/System/SimbaErpMenus.php
php -l diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
php -l scripts/assert-simba-menu-backed-registries.php
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
php scripts/assert-simba-menu-backed-registries.php
```

Kết quả local:

- PHP lint: pass cho các file liên quan.
- Unit test `SimbaMenuRouteMetadataTest`: pass.
- Smoke script MSSQL-backed registry: blocked do thiếu Microsoft ODBC Driver SQL Server trên runtime local.
