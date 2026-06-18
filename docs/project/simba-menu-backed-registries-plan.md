# Simba Menu-backed Registries Implementation Plan

> **For Hermes:** Use subagent-driven-development skill to implement this plan task-by-task.

**Goal:** Chuyển các registry `SimbaRouteRegistry`, `SimbaDictionaryRegistry`, `SimbaReportRegistry`, `SimbaProcessRegistry` từ hard-code PHP array sang dữ liệu đọc từ database SimbaERP, với `sysMenu` và `zsysmenu` là nguồn route/menu chính.

**Architecture:** Tạo lớp resolver/repository trung gian đọc menu active từ `sysMenu` + `zsysmenu`, phân loại theo `type`, rồi enrich metadata từ các bảng SimbaERP hiện có (`SysDictionaryInfo`, `SysReportInfo`, `ZSysReportInfo`, `SysReportDrillDownInfo`, voucher metadata). Các class registry hiện tại được giữ làm API compatibility layer trong giai đoạn đầu, nhưng nội dung trả về sẽ lấy từ service mới thay vì mảng hard-code.

**Tech Stack:** Laravel package `diepxuan/laravel-catalog`, Simba models trong `diepxuan/laravel-simba`, SQL Server SimbaERP, Livewire `SimbaPage`/`SimbaErpMenus`.

---

## 1. Bối cảnh hiện tại

### 1.1 Registry đang tồn tại

- `diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php`
  - Đang giữ static array lớn: `routeName => module/menuid/source_type/...`.
  - Có mix giữa route thật, documented report/dictionary route, process route.

- `diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php`
  - Có static array danh mục đã biết.
  - Có phần dynamic lấy thêm từ `SysDictionaryInfo` + `SimbaMenuRepository`.

- `diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php`
  - Có static array báo cáo đã biết.
  - Có phần dynamic từ report-related Simba models.

- `diepxuan/laravel-catalog/src/Config/SimbaProcessRegistry.php`
  - Wrapper rất mỏng quanh `SimbaProcessMetadata`.

### 1.2 Nguồn dữ liệu SimbaERP đã có trong code

- `Diepxuan\Simba\Models\SysMenu`
  - Table: `sysMenu`
  - Fields liên quan: `menuid`, `type`, `moduleid`, `bar`, `short_name`, `dllName`, `command`, `code_name`, `report`, `form`, `active`, `zmenuid`, ...
  - Type constants:
    - `TYPE_VOUCHER = '1'`
    - `TYPE_MASTER = '2'`
    - `TYPE_UTILITY = '3'`
    - `TYPE_REPORT = '4'`
    - `TYPE_MODULE_ROOT = '5'`
    - `TYPE_SETUP = '6'`
    - `TYPE_GROUP = ''`

- `Diepxuan\Simba\Models\Zsysmenu`
  - Table: `zsysmenu`
  - Extends `SysMenu`.

- `Diepxuan\Catalog\Services\SimbaMenuRepository`
  - Đã merge `SysMenu::query()->get()` với `Zsysmenu::query()->get()`.
  - Đã filter `menuid` rỗng, unique theo `menuid`, sort active menu.

- Report/dictionary metadata models đang được registry cũ dùng:
  - `SysDictionaryInfo`
  - `SysReportInfo`
  - `ZSysReportInfo`
  - `SysReportDrillDownInfo`

---

## 2. Quyết định kiến trúc

### 2.1 Source of truth

Nguồn sự thật cho route/menu Portal phải là database SimbaERP:

1. `sysMenu`
2. `zsysmenu`
3. Các bảng metadata liên quan chỉ dùng để enrich, không quyết định menu tồn tại hay không:
   - dictionary: `SysDictionaryInfo`
   - report: `SysReportInfo`, `ZSysReportInfo`, `SysReportDrillDownInfo`
   - process/custom: fields ngay trên menu (`dllName`, `command`, `code_name`)

Không được tự tạo route từ mảng hard-code nếu menu không tồn tại trong `sysMenu`/`zsysmenu` hoặc menu inactive.

### 2.2 Class mới đề xuất

Tạo service mới:

`diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php`

Trách nhiệm:
- Đọc `SimbaMenuRepository::activeMenus()`.
- Phân loại từng menu thành `source_type`:
  - `SysMenu::TYPE_MASTER` => `SimbaRouteRegistry::TYPE_DICTIONARY`
  - `SysMenu::TYPE_VOUCHER` => `SimbaRouteRegistry::TYPE_VOUCHER`
  - `SysMenu::TYPE_REPORT` hoặc `report = true` => `SimbaRouteRegistry::TYPE_REPORT`
  - `TYPE_UTILITY`, `TYPE_SETUP`, menu có `dllName`/`command`/`code_name` nhưng không thuộc loại trên => `SimbaRouteRegistry::TYPE_CUSTOM`
  - `TYPE_MODULE_ROOT`, `TYPE_GROUP` => không sinh route leaf
- Sinh route name ổn định từ menu.
- Enrich metadata theo source_type.
- Trả về các API:
  - `routes(): array`
  - `dictionaries(): array`
  - `reports(): array`
  - `processes(): array`
  - `getRoute(string $routeName): ?array`
  - `getDictionary(string $routeName): ?array`
  - `getReport(string $routeName): ?array`
  - `getProcess(string $routeName): ?array`

### 2.3 Compatibility layer

Giữ 4 class registry cũ trong phase đầu để giảm blast radius:

- `SimbaRouteRegistry::routes()` gọi `app(SimbaMenuRouteMetadata::class)->routes()`.
- `SimbaDictionaryRegistry::dictionaries()` gọi `...->dictionaries()`.
- `SimbaReportRegistry::reports()` gọi `...->reports()`.
- `SimbaProcessRegistry::processes()` gọi `...->processes()`.

Sau khi ổn định mới xem xét xóa/gộp registry cũ.

### 2.4 Route name canonical

Không sinh route name từ DLL/SP namespace một cách mù. Quy tắc ưu tiên:

1. Nếu route đã có Livewire route thật trong Laravel và đang gắn với cùng `menuid`, giữ route name cũ để không gãy component.
2. Nếu menu có pattern hiện tại đã dùng trong `/simba/{module}/{kind}/{slug}`, sinh theo:
   - dictionary: `{module}.dict.{slug}` hoặc `{module}.{slug}` cho route legacy đã tồn tại
   - voucher: `{module}.vch.{slug}`
   - report: `{module}.rpt.{slug}`
   - process: `{module}.proc.{slug}`
3. Slug ưu tiên từ `dllName`, fallback `code_name`, fallback `command`, fallback `menuid` normalized.
4. Khi trùng slug, append menuid normalized, ví dụ `-02-20-11`.
5. `module` lấy từ `sysMenu.moduleid`, không suy luận từ DLL/SP/table prefix.

Lưu ý quan trọng đã từng gặp: các danh mục khách hàng có DLL/SP bắt đầu `AR*` nhưng nằm trong menu SO, nên route vẫn phải là `so.dict.*` nếu `sysMenu.moduleid = SO`.

---

## 3. Mapping dữ liệu đề xuất

### 3.1 Base route metadata

Mỗi route trả về tối thiểu:

```php
[
    'module'      => (string) $menu->moduleid,
    'menuid'      => (string) $menu->menuid,
    'source_type' => $sourceType,
    'title'       => $menu->getDisplayName(),
    'type'        => (string) $menu->type,
    'dll_name'    => (string) $menu->dllName,
    'command'     => (string) $menu->command,
    'code_name'   => (string) $menu->code_name,
]
```

### 3.2 Dictionary metadata

Nguồn chính:
- Menu leaf từ `sysMenu`/`zsysmenu` có `type = 2`.
- Enrich từ `SysDictionaryInfo` theo `menuid` hoặc `code_name`.

Trả về:

```php
[
    'module'    => $menu->moduleid,
    'menuid'    => $menu->menuid,
    'title'     => $menu->getDisplayName(),
    'code_name' => $dictionaryInfo->code_name ?: $menu->code_name,
    'table'     => $dictionaryInfo->table_name,
    'pk'        => splitCsv($dictionaryInfo->PK),
    'fields'    => splitCsv(strtolower($dictionaryInfo->carry_field_list)),
]
```

Nếu không tìm thấy `SysDictionaryInfo`, vẫn trả route base nhưng metadata phải có flag:

```php
'metadata_missing' => 'dictionary_info'
```

Không được tự bịa `table`, `pk`, `fields`.

### 3.3 Report metadata

Nguồn chính:
- Menu leaf từ `sysMenu`/`zsysmenu` có `type = 4` hoặc `report = true`.
- Enrich từ `SysReportInfo` / `ZSysReportInfo` theo `menuid`, `ma_mau`, `rptname`, hoặc quy tắc hiện tại trong `SimbaReportRegistry`.
- Drilldown enrich từ `SysReportDrillDownInfo` nếu có.

Trả về:

```php
[
    'module'  => $menu->moduleid,
    'menuid'  => $menu->menuid,
    'title'   => $menu->getDisplayName(),
    'ma_mau'  => $reportInfo->ma_mau,
    'spname'  => $reportInfo->spname,
    'rptname' => $reportInfo->rptname,
]
```

Nếu không có report info, không tự đặt `spname`/`rptname`; chỉ trả base + `metadata_missing = report_info`.

### 3.4 Voucher metadata

Nguồn chính:
- Menu leaf `type = 1`.
- `ma_ct` có thể lấy từ menu/code metadata nếu database có field rõ ràng; nếu chưa có source chắc chắn thì chỉ trả base + `metadata_missing = voucher_code`.
- Không lấy `ma_ct` bằng cách đoán từ route name.

Phase đầu không bắt buộc thay hết voucher metadata đặc thù nếu task khác đang refactor riêng. Mục tiêu chính là `SimbaRouteRegistry` route coverage và shell metadata.

### 3.5 Process/custom metadata

Nguồn chính:
- Menu leaf không thuộc dictionary/voucher/report nhưng có một trong các field:
  - `dllName`
  - `command`
  - `code_name`
- Không generate process cho group/root menu.

Trả về:

```php
[
    'module'    => $menu->moduleid,
    'menuid'    => $menu->menuid,
    'name'      => $menu->getDisplayName(),
    'type'      => (string) $menu->type,
    'dll_name'  => (string) $menu->dllName,
    'command'   => (string) $menu->command,
    'code_name' => (string) $menu->code_name,
]
```

---

## 4. Implementation tasks

### Task 1: Snapshot dữ liệu menu và registry hiện tại

**Objective:** Có baseline để so sánh trước/sau, tránh mất route/menu.

**Files:**
- Create: `docs/project/simba-menu-backed-registries-audit.md`

**Steps:**
1. Chạy artisan/tinker hoặc command nhỏ để dump count:
   - active `sysMenu`
   - active `zsysmenu`
   - route count từ `SimbaRouteRegistry::routes()` hiện tại
   - dictionary/report/process count hiện tại
2. Ghi các số này vào audit doc.
3. Liệt kê top route có component thật bằng `Route::has($routeName)`.
4. Không sửa code ở task này.

**Verification:**
- Audit doc có count rõ ràng.
- `git diff -- docs/project/simba-menu-backed-registries-audit.md` chỉ là documentation.

### Task 2: Viết unit test cho route metadata service mới

**Objective:** Khóa behavior trước khi thay registry.

**Files:**
- Create: `diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php`

**Test cases tối thiểu:**
1. Bỏ qua module root/group menu.
2. `type = 2` sinh `source_type = dictionary`.
3. `type = 4` hoặc `report = true` sinh `source_type = report`.
4. `type = 1` sinh `source_type = voucher`.
5. Utility/setup có `dllName`/`command` sinh `source_type = custom`.
6. Route name dùng `moduleid` từ menu, không từ DLL prefix.
7. Route name trùng thì append menuid normalized.

**Verification:**
- Test fail vì service chưa tồn tại.

### Task 3: Tạo `SimbaMenuRouteMetadata`

**Objective:** Tạo service core đọc từ `SimbaMenuRepository` và sinh metadata chuẩn.

**Files:**
- Create: `diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php`

**Implementation notes:**
- Inject hoặc khởi tạo `SimbaMenuRepository`.
- Có cache per-request trong property để không query nhiều lần.
- Không query trực tiếp `SysMenu`/`Zsysmenu` trong registry nữa; đi qua repository.
- Tách method nhỏ:
  - `sourceTypeFor(SysMenu $menu): ?string`
  - `routeNameFor(SysMenu $menu, string $sourceType, array $existing): string`
  - `baseMetadata(SysMenu $menu, string $sourceType): array`
  - `dictionaryMetadata(...)`
  - `reportMetadata(...)`
  - `processMetadata(...)`

**Verification:**
- Unit tests ở Task 2 pass.
- `php -l diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php` pass.

### Task 4: Chuyển `SimbaProcessRegistry` sang service mới

**Objective:** Thay phần dễ nhất trước vì process hiện đã đọc menu dynamic.

**Files:**
- Modify: `diepxuan/laravel-catalog/src/Config/SimbaProcessRegistry.php`
- Optionally modify: `diepxuan/laravel-catalog/src/Services/SimbaProcessMetadata.php`

**Steps:**
1. Đổi `processes()` sang gọi `SimbaMenuRouteMetadata::processes()`.
2. Đổi `get()` sang gọi `SimbaMenuRouteMetadata::getProcess()`.
3. Giữ signature public cũ.
4. Nếu `SimbaProcessMetadata` không còn caller, đánh dấu deprecated hoặc giữ tạm, chưa xóa trong PR đầu.

**Verification:**
- `php -l` pass.
- Route shell process vẫn resolve được `/simba/{module}/proc/{slug}`.

### Task 5: Chuyển `SimbaDictionaryRegistry` sang service mới

**Objective:** Dictionary registry trả dữ liệu từ menu + `SysDictionaryInfo`, không từ static PHP array.

**Files:**
- Modify: `diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php`
- Modify tests nếu có.

**Steps:**
1. Giữ methods public `dictionaries()` và `get()`.
2. Delegate sang `SimbaMenuRouteMetadata`.
3. Di chuyển helper `splitCsv()` nếu cần sang service mới.
4. Xóa hoặc deprecate static array cũ sau khi test route coverage ổn.

**Verification:**
- Dictionary shell vẫn hiển thị `table`, `pk`, `fields` cho menu có `SysDictionaryInfo`.
- Menu không có dictionary info không được bịa metadata.

### Task 6: Chuyển `SimbaReportRegistry` sang service mới

**Objective:** Report registry trả dữ liệu từ menu + report metadata tables.

**Files:**
- Modify: `diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php`

**Steps:**
1. Giữ public API `reports()` và `get()`.
2. Delegate sang `SimbaMenuRouteMetadata`.
3. Port logic enrich report hiện có sang service mới nhưng lọc theo menu active từ `sysMenu`/`zsysmenu`.
4. Không giữ report nếu không có menu tương ứng active.

**Verification:**
- Report shell vẫn hiển thị `spname`, `rptname`, `ma_mau` khi database có info.
- Không sinh route từ report info orphan nếu menu inactive/không tồn tại.

### Task 7: Chuyển `SimbaRouteRegistry` sang service mới

**Objective:** Route registry trung tâm không còn hard-code route list.

**Files:**
- Modify: `diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php`

**Steps:**
1. Giữ constants `TYPE_DICTIONARY`, `TYPE_VOUCHER`, `TYPE_REPORT`, `TYPE_CUSTOM` để tránh sửa nhiều caller.
2. `routes()` delegate sang `SimbaMenuRouteMetadata::routes()`.
3. `routesWithoutProcesses()` delegate sang service nhưng exclude `TYPE_CUSTOM`.
4. Nếu còn helper public khác, giữ behavior tương thích.
5. Chưa xóa file class trong PR đầu.

**Verification:**
- `SimbaMenuTargetResolver::resolveRouteName()` vẫn chạy.
- `SimbaErpMenus` vẫn build sidebar.
- Không có duplicate menuid trong routes.

### Task 8: Cập nhật resolver để không phụ thuộc registry phụ

**Objective:** Giảm coupling trong `SimbaMenuTargetResolver`.

**Files:**
- Modify: `diepxuan/laravel-catalog/src/Services/SimbaMenuTargetResolver.php`

**Steps:**
1. Thay `enrichMetadata()` dùng trực tiếp `SimbaMenuRouteMetadata::getRoute($routeName)` hoặc metadata đã enrich sẵn.
2. Bỏ import `SimbaDictionaryRegistry`, `SimbaReportRegistry` nếu không còn dùng.
3. Giữ `source_type` constants từ `SimbaRouteRegistry` hoặc chuyển constants sang class chung nếu cần.

**Verification:**
- Resolve dictionary/report/process đều trả metadata đầy đủ.
- View `catalog::system.simba-page-metadata` không cần query registry trong Blade.

### Task 9: Thêm command/check script kiểm tra coverage

**Objective:** Có công cụ chứng minh dữ liệu menu-backed không mất coverage.

**Files:**
- Create: `scripts/assert-simba-menu-backed-registries.php` hoặc artisan command nếu phù hợp.

**Checks:**
1. Mỗi route có `menuid` không rỗng.
2. Không duplicate `menuid` trong `routes()` trừ trường hợp được whitelist rõ.
3. Route `module` khớp `sysMenu.moduleid`.
4. `source_type` khớp `sysMenu.type` theo mapping.
5. Dictionary/report metadata không tự bịa field khi source missing.
6. URL `/simba/{module}/{kind}/{slug}` sinh được cho mọi route.

**Verification:**
- Script exit 0 trên dữ liệu hiện tại hoặc report danh sách issue thật cần xử lý.

### Task 10: Cleanup registry hard-code sau khi ổn định

**Objective:** Dọn static arrays cũ khi service mới đã pass smoke.

**Files:**
- Modify: các registry trong `src/Config`.
- Update: docs liên quan trong `docs/project`.

**Steps:**
1. Xóa static arrays lớn đã được thay thế.
2. Giữ class wrapper nếu caller còn dùng.
3. Nếu muốn xóa hẳn class wrapper, làm PR riêng sau khi search sạch caller.
4. Cập nhật docs để ghi source of truth là `sysMenu`/`zsysmenu`.

**Verification:**
- `git grep "SimbaDictionaryRegistry::\|SimbaReportRegistry::\|SimbaProcessRegistry::"` rõ caller còn lại.
- `php -l` toàn bộ file sửa.
- Route/menu smoke pass.

---

## 5. Rủi ro và guard rails

### 5.1 Rủi ro route name đổi làm hỏng component thật

Mitigation:
- Phase đầu phải có mapping giữ route name cũ cho menuid đã có component thật.
- Dùng `Route::has($routeName)` để detect route thật.
- Nếu route name mới khác route name cũ, tạo alias map tạm hoặc giữ route cũ.

### 5.2 Rủi ro sysMenu/zsysmenu duplicate menuid

Hiện `SimbaMenuRepository::allMenus()` unique theo `menuid`, sau khi merge `sysMenu` trước `zsysmenu`.

Cần chốt rule:
- `sysMenu` thắng hay `zsysmenu` thắng khi trùng?
- Nếu `zsysmenu` là customization cần override, đổi merge order hoặc explicit precedence.

Đề xuất cần Sếp chốt: `zsysmenu` nên override `sysMenu` nếu cùng `menuid`, vì đây thường là lớp custom/localization.

### 5.3 Rủi ro thiếu metadata dictionary/report

Không bịa dữ liệu.

Nếu thiếu source metadata:
- Vẫn hiển thị menu/shell base.
- Gắn `metadata_missing` để audit.
- Tạo report danh sách thiếu metadata cho task sau.

### 5.4 Rủi ro performance

Registry hiện có thể bị gọi nhiều lần trong request.

Mitigation:
- Cache per-request trong `SimbaMenuRouteMetadata`.
- Sau đó cân nhắc Laravel cache với key theo updated timestamp nếu Simba DB có trường phù hợp.
- Không cache vĩnh viễn khi chưa có invalidation.

### 5.5 Rủi ro workflow hiện tại đang có thay đổi khác

Tại thời điểm lập plan, worktree đang có nhiều file modified/deleted liên quan cleanup shell và docs. Không được overwrite hoặc revert các thay đổi đó khi implement plan này. Plan này là docs độc lập.

---

## 6. Verification tổng thể

Chạy tối thiểu:

```bash
php -l diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php
php -l diepxuan/laravel-catalog/src/Config/SimbaRouteRegistry.php
php -l diepxuan/laravel-catalog/src/Config/SimbaDictionaryRegistry.php
php -l diepxuan/laravel-catalog/src/Config/SimbaReportRegistry.php
php -l diepxuan/laravel-catalog/src/Config/SimbaProcessRegistry.php
```

Nếu container chạy được:

```bash
docker compose exec -T laravel.test php artisan optimize:clear
docker compose exec -T laravel.test php artisan route:list --name=simba
```

Smoke checks:

```bash
# Simba root/sidebar
curl -sS --max-time 10 -o /dev/null -w "%{http_code}" \
  http://127.0.0.1/simba -H 'Host: portal.diepxuan.corp'

# Một dictionary URL
curl -sS --max-time 10 -o /dev/null -w "%{http_code}" \
  http://127.0.0.1/simba/so/dict/ardmkh -H 'Host: portal.diepxuan.corp'

# Một report URL
curl -sS --max-time 10 -o /dev/null -w "%{http_code}" \
  http://127.0.0.1/simba/gl/rpt/ctgs01 -H 'Host: portal.diepxuan.corp'
```

Expected:
- HTTP 200 nếu auto-login local hoạt động.
- Không redirect login trong local corp host.
- Sidebar vẫn render menu active.
- Shell metadata không mất thông tin có source trong database.

---

## 7. Definition of Done

- Registry route/dictionary/report/process lấy dữ liệu từ `sysMenu` + `zsysmenu`, không còn phụ thuộc static arrays làm source chính.
- Không sinh route cho menu inactive hoặc menu không tồn tại trong SimbaERP menu.
- Không bịa table/SP/field khi metadata phụ thiếu.
- Route name vẫn ổn định với component thật hiện có.
- Có audit doc so sánh trước/sau.
- Có script hoặc test kiểm tra duplicate menuid/source_type/module mismatch.
- `php -l`, route smoke, sidebar smoke pass.
- Không đụng các thay đổi local khác ngoài scope.

---

## 8. Quyết định cần Sếp chốt

1. Khi `sysMenu` và `zsysmenu` trùng `menuid`, bảng nào thắng?
   - Đề xuất: `zsysmenu` thắng vì là lớp custom/override.

2. Route name legacy có cần giữ tuyệt đối không?
   - Đề xuất: giữ tuyệt đối cho route có Livewire component thật hoặc đã public trong `/simba/...`.

3. Có xóa hẳn các class registry cũ không?
   - Đề xuất: chưa xóa trong PR đầu. Giữ wrapper để an toàn, chỉ đổi backend data source.

4. Voucher metadata thiếu `ma_ct` từ menu thì xử lý thế nào?
   - Đề xuất: không đoán. Trả base + `metadata_missing = voucher_code`, tạo audit task riêng.
