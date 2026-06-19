# Simba Menu-backed Registries Audit

Ngày audit: 2026-06-19

## Mục tiêu

Loại bỏ các registry Simba hard-code trong `diepxuan/laravel-catalog/src/Config`; route/menu metadata phải lấy từ chính MSSQL SimbaERP thông qua các model Simba hiện hữu.

## Trạng thái sau PR #206

PR #206 (`cleanup: remove Simba config registries`) đã merge vào `main`. Các file registry hard-code/compatibility wrapper trong `diepxuan/laravel-catalog/src/Config` đã bị xóa hoàn toàn:

- `SimbaRouteRegistry.php`
- `SimbaDictionaryRegistry.php`
- `SimbaReportRegistry.php`
- `SimbaProcessRegistry.php`

Các test tương ứng trong `tests/Unit/Config/Simba*` cũng đã được xóa cùng đợt refactor vì không còn class để cover.

Sau #206, không còn caller runtime trỏ về các registry trên trong `diepxuan/laravel-catalog/src`, `diepxuan/laravel-catalog/tests`, `scripts`.

## Trạng thái môi trường smoke

Lệnh smoke đọc runtime từ database bị chặn bởi môi trường local thiếu Microsoft ODBC Driver for SQL Server:

```text
PDOException SQLSTATE[IMSSP]: This extension requires the Microsoft ODBC Driver for SQL Server to communicate with SQL Server.
```

Vì vậy runtime count từ database chưa lấy được trong môi trường local. Trên server `web` (qua SSH), audit runtime đã chạy trực tiếp và lấy được số liệu, xem chi tiết tại `docs/project/simba-menu-route-review.md`.

## Source of truth hiện tại (sau #206 / #207)

- Service trung tâm: `Diepxuan\Catalog\Services\SimbaMenuRouteMetadata`.
- File code: `diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php`.
- Unit test: `diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php`.
- Menu active lấy từ `SimbaMenuRepository::activeMenus()`.
- `SimbaMenuRepository` merge `SysMenu` và `Zsysmenu`, lọc `menuid` rỗng, unique theo `menuid`, rồi filter `active`.
- Metadata phụ enrich từ các model Simba tương ứng:
  - dictionary: `SysDictionaryInfo`
  - report: `SysReportInfo`, `ZSysReportInfo`, `SysReportDrillDownInfo`
  - voucher/process/custom: field trên menu
- Constants: `TYPE_DICTIONARY`, `TYPE_VOUCHER`, `TYPE_REPORT`, `TYPE_CUSTOM`.

## Public API thay thế

Các caller hiện dùng trực tiếp `SimbaMenuRouteMetadata`:

- `routes()`
- `routesWithoutProcesses()`
- `dictionaries()`
- `reports()`
- `processes()`
- constants `TYPE_DICTIONARY`, `TYPE_VOUCHER`, `TYPE_REPORT`, `TYPE_CUSTOM`

## Tài liệu tham chiếu

- `docs/project/simba-menu-route-review.md` — review classifier theo menu thực tế từ MSSQL SimbaERP, PR #207.
- `docs/project/simba-router-menu-matrix.md` — ma trận route/menu.
- `docs/project/task-execution-coverage.md` — độ phủ task.
- `docs/project/unmapped-active-menu.md` — menu active chưa map route.
- `docs/project/remaining-process-shells.md` — process shell còn lại.

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
