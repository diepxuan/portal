# Model Layer Responsibility Refactor Implementation Plan

> **For Hermes:** Use subagent-driven-development skill to implement this plan task-by-task.

**Goal:** Tách rõ trách nhiệm 3 lớp model: `laravel-simba/src/SModel` chỉ giữ cấu hình database/schema SQL Server, `laravel-simba/src/Models` giữ Eloquent model trực tiếp tới bảng Simba, và `laravel-catalog/src/Models` giữ logic nghiệp vụ phục vụ Portal/Catalog.

**Architecture:** Dùng mô hình 3 tầng: Raw DB metadata -> Simba Eloquent -> Catalog domain model. `SModel/*Model.php` là lớp generated/base, chứa connection/table/key/casts/timestamps/fillable tối thiểu. `Simba\Models` kế thừa SModel để thêm scope/accessor/mutator/normalized query sát bảng Simba. `Catalog\Models` kế thừa Simba model để thêm relations nội bộ Portal, computed helpers, policy/business methods, không khai báo lại DB metadata nếu không cần.

**Tech Stack:** Laravel Eloquent, SQL Server connection `simba.connection`, PHPUnit, PHP 8.2.

---

## Mục tiêu

Tách rõ trách nhiệm 3 lớp model:

1. `diepxuan/laravel-simba/src/SModel`
   - Chỉ giữ raw/table schema của SimbaERP.
   - Không chứa business/query behavior.
2. `diepxuan/laravel-simba/src/Models`
   - Extend từ `SModel` tương ứng.
   - Chỉ giữ helper/query/relation/accessor sát bảng Simba.
   - Không chứa logic Portal/Catalog.
3. `diepxuan/laravel-catalog/src/Models` và services Catalog
   - Chứa business behavior, use-case, workflow, UI/navigation integration.

---

## Trạng thái đã làm trong PR #217

PR: https://github.com/diepxuan/portal/pull/217
Merge commit: `ac8212c08` — `refactor: document simba model layers (#217)`
Commit cuối trong PR: `48be82c74` — `feat(simba): add direct models for generated schema`

Đã hoàn tất:

- Thêm `diepxuan/laravel-simba/src/SModel/README.md` mô tả raw/table schema layer.
- Thêm `diepxuan/laravel-simba/src/Models/README.md` mô tả model layer extend từ `SModel`.
- Sửa các import/extend trong `laravel-simba/src/Models` đang trỏ sai tên class SModel generated:
  - `GlCdTk` -> `GlCdTkModel`
  - `GlDmTk` -> `GlDmTkModel`
  - `InDmNhvt` -> `InDmNhvtModel`
  - `InDmVt` -> `InDmVtModel`
  - `PhieuChuyenKho` -> `InPh3Model`
  - `PhieuChuyenKhoCT` -> `InCt3Model`
  - `SiSetup` -> `SiSetupModel`
  - `SoPh3` -> `SoPh3Model`
  - `SysCompany` -> `sysCompanyModel`
  - `SysCompanyResx` -> `sysCompanyResxModel`
  - `SysLanguage` -> `sysLanguageModel`
  - `SysUserCompanyRight` -> `sysUserCompanyRightModel`
  - `SysUserInfo` -> `sysUserInfoModel`
- `SysMenu` giữ trỏ về `SysMenuModel` mới/chuẩn vì file này đã có metadata đầy đủ hơn generated cũ `sysMenuModel`.
- Không đổi public model class để tránh phá caller hiện tại.
- Quy tắc primary key đã chốt và áp dụng cho toàn bộ 441 SModel:
  - Bỏ `ma_cty` làm `$primaryKey` generic.
  - Composite PK > 3 cột dùng `null` + `PRIMARY_KEY_COLUMNS`.
  - Composite PK 2-3 cột chọn key đại diện không phải `ma_cty` (ưu tiên `stt_rec`).
  - Bảng setup chỉ có `ma_cty` thì `null` + `PRIMARY_KEY_COLUMNS`.
- Xóa 13 file SModel legacy không hậu tố `Model` không còn tham chiếu.
- Tạo `diepxuan/laravel-simba/src/Models/Concerns/HasSimbaCompositeKey.php` với:
  - `getPrimaryKeyColumns()`
  - `getRepresentativeKeyName()`
  - `scopeForCompositeKey()` (bắt buộc đủ PRIMARY_KEY_COLUMNS)
  - `scopeForCompany()`
  - `findByCompositeKey()`
  - `updateByCompositeKey()`
  - `deleteByCompositeKey()`
  - `compositeKeyAttributes()`
  - `compositeKeyString()`
  - `assertCompositeKey()`
- Bổ sung đầy đủ Models trực tiếp cho từng SModel:
  - SModel classes: 441
  - Models files: 445 (441 direct table + 4 alias hiện hữu)
  - Models có `HasSimbaCompositeKey`: 342
- Cập nhật `diepxuan/laravel-simba/README.md` cho đúng chuẩn `<Table>Model` và ví dụ code.

Số liệu cuối PR #217:
- Lint pass: 446 file PHP trong Models + Concerns
- `class_exists` check: 445/445 pass
- `git diff --check` pass
- CI PR #217: 14/14 pass, mergeable, mergeStateStatus CLEAN.

---

## Quy tắc primary key (đã chốt và đang áp dụng)

Laravel Eloquent core chỉ hỗ trợ một `$primaryKey`, trong khi nhiều bảng Simba dùng composite primary key có `ma_cty` làm company scope.

Quy tắc trong `SModel`:

- Không dùng `ma_cty` làm `$primaryKey` generic, trừ bảng danh sách công ty thật sự như `sysCompany`.
- Composite primary key > 3 cột: `protected $primaryKey = null;` + khai báo `public const PRIMARY_KEY_COLUMNS = [...]` ghi đầy đủ các cột khóa thật từ `simba-docs/tables`.
- Composite primary key 2 hoặc 3 cột: bỏ `ma_cty` khỏi lựa chọn key đại diện và chọn cột định danh hợp lý hơn, ưu tiên `stt_rec` nếu có. Vẫn khai báo `PRIMARY_KEY_COLUMNS` cho composite key.
- Bảng detail có `stt_rec, stt_rec0`: dùng `stt_rec` làm key đại diện; vẫn khai báo `PRIMARY_KEY_COLUMNS`; cập nhật/xóa phải query đủ khóa, không blind theo key đơn:

```php
static::where('ma_cty', $maCty)
    ->where('stt_rec', $sttRec)
    ->where('stt_rec0', $sttRec0)
    ->update([...]);
```

- Với bảng có `$primaryKey = null`, chỉ dùng model như raw query/read schema hoặc thao tác bằng query builder đủ điều kiện khóa.

Kết quả hiện tại:

- 442 SModel PHP files, không còn file legacy thiếu hậu tố `Model`.
- 445 Simba Model PHP files.
- 346 Simba Model dùng `HasSimbaCompositeKey`.
- 84 model composite PK > 3 cột đều `null` và có `PRIMARY_KEY_COLUMNS`.
- 267 model composite PK 2-3 cột đều chọn key đại diện không phải `ma_cty`, có `PRIMARY_KEY_COLUMNS`.
- 32 model PK đơn.
- 13 file SModel không hậu tố `Model` đã được xóa vì không còn tham chiếu ngoài; mapping 1-1 theo chuẩn `<Table>Model` đang giữ.

---

## Cụm model còn phải chuẩn hóa schema duplication

Một số model trong `laravel-simba/src/Models` hiện còn tự khai báo schema thay vì extend SModel generated:

- `SysDictionaryInfo`
- `SysReportInfo`
- `SysReportDrillDownInfo`
- `SiDmCt`

Cần kiểm tra SModel generated tương ứng rồi refactor để:

- Schema nằm ở `SModel`.
- Behavior/helper nằm ở `Models`.
- Catalog cache/service nằm ở `laravel-catalog`.

### Trạng thái Phase 3 (đang thực hiện)

PR: `task/simba-model-layer-phase3-schema-refactor`

Audit SModel generated đã có:

| Model | SModel generated | PRIMARY_KEY_COLUMNS | Ghi chú |
|-------|------------------|----------------------|---------|
| `SysDictionaryInfo` | `sysDictionaryInfoModel` | (single PK `code_name`) | Có behavior: `primaryKeyFields`, `carryFields`, `scopeCodeName`, `scopeMenuId` |
| `SysReportInfo` | `sysReportInfoModel` | `['menuid', 'ma_mau']` | Composite 2 cột, không có behavior, model cũ dùng `SModel` base |
| `SysReportDrillDownInfo` | `sysReportDrillDownInfoModel` | `['menuid', 'ma_mau', 'press_key_name']` | Composite 3 cột, không có behavior, model cũ dùng `SModel` base |
| `SiDmCt` | `SiDmCtModel` | `['ma_cty', 'ma_ct']` | Có behavior: `scopeVoucher`, `scopeMenuId`, `headerFieldsForInventory`, `detailFieldsForInventory` |

Sai lệch schema cần đối chiếu giữa Model cũ và SModel generated:

- `SysReportInfo`:
  - Model cũ cast `bang_chu`, `bang_chu0`, `hasNT` là `boolean`.
  - SModel generated chỉ cast `isdefault` là `boolean`.
  - Cần đối chiếu `simba-docs/tables/sysReportInfo.md` để xác định đúng; mặc định lấy theo SModel generated vì là nguồn sinh từ docs.
- `SiDmCt`:
  - Model cũ cast `VoucherGetWhenOpenForm` là `boolean`.
  - SModel generated cast là `integer`.
  - Cần đối chiếu `simba-docs/tables/SiDmCt.md` để xác định đúng.

Hướng xử lý:

1. Refactor 4 Model để chỉ extend SModel generated, không khai báo lại schema (`$table`, `$primaryKey`, `$keyType`, `$fillable`, `$casts`, `$timestamps`, `$incrementing`, `$connection`).
2. Sử dụng `HasSimbaCompositeKey` trait cho các Model có composite PK (`SysReportInfo`, `SysReportDrillDownInfo`, `SiDmCt`).
3. Behavior hiện có giữ nguyên trong Model.
4. Các sai lệch casts nếu được chứng minh đúng từ docs sẽ được ghi đè trong Model bằng cast override, có comment giải thích nguồn từ docs.

Các bước còn lại:

- [x] Audit SModel generated đã tồn tại.
- [x] Refactor `SysDictionaryInfo`.
- [x] Refactor `SysReportInfo`.
- [x] Refactor `SysReportDrillDownInfo`.
- [x] Refactor `SiDmCt`.
- [x] Lint + autoload + diff check.
- [x] Đối chiếu casts sai lệch với `simba-docs/tables`.
- [x] Cập nhật README nếu cần.
- [ ] Tạo PR Phase 3.

Kết quả sau khi refactor:

- 4 Model chỉ extend SModel generated, không khai báo lại schema.
- 3 Model có composite PK dùng `HasSimbaCompositeKey`:
  - `SysReportInfo` -> PK `(menuid, ma_mau)`
  - `SysReportDrillDownInfo` -> PK `(menuid, ma_mau, press_key_name)`
  - `SiDmCt` -> PK `(ma_cty, ma_ct)`
- Behavior Simba-level giữ nguyên:
  - `SysDictionaryInfo`: `primaryKeyFields()`, `carryFields()`, `scopeCodeName`, `scopeMenuId`
  - `SiDmCt`: `scopeVoucher`, `scopeMenuId`, `headerFieldsForInventory()`, `detailFieldsForInventory()`
- Lint: 4/4 pass.
- `class_exists` + parent class + trait check: pass.
- `git diff --check` pass.
- Caller `diepxuan/laravel-catalog/src/Services/SimbaMetadataService.php`, `SimbaVoucherMetadata.php`, `Models/SysDictionaryInfo.php` chỉ dùng query/attribute thường; không phụ thuộc schema declaration trong Model nên không phá API.

Đối chiếu casts:

- `SysReportInfo`: SModel cast `isdefault` boolean. Cột `bang_chu`/`bang_chu0` (NVARCHAR 50) và `hasNT` (NVARCHAR 1) từ docs không phải boolean; Model cũ cast boolean là sai -> đã loại bỏ.
- `SiDmCt`: SModel cast `VoucherGetWhenOpenForm` integer (theo DB thật). Docs không liệt kê cột này; Model cũ cast boolean không có nguồn docs -> đã loại bỏ.

Branch: `task/simba-model-layer-phase3-schema-refactor`

---

## Phase 1: Audit behavior trong Models (đang thực hiện)

Mục tiêu: phân loại behavior hiện có trong `diepxuan/laravel-simba/src/Models` để biết cần giữ ở Simba hay tách sang laravel-catalog.

### Trạng thái Phase 1

PR: `task/simba-model-layer-phase1-behavior-audit`

Deliverables:

- `scripts/audit-model-layer-responsibility.php` — script PHP thuần, không cần composer, parse file Models và phân loại:
  - `keep_simba`: scope filter Simba-Simba, relation Simba-Simba, accessor parse enum/display từ field schema, method kiểu `isXxx()/getXxx()` đọc field trực tiếp.
  - `move_catalog`: business logic (tính toán, mở service), ngữ nghĩa nghiệp vụ (KH/NCC/NV).
  - Hỗ trợ `--json` và `--filter=Substring`.
- `docs/project/model-layer-audit-baseline.md` — kết quả audit đầy đủ với bảng chi tiết.

Kết quả:

- 445 Model files; 28 có behavior.
- 24 `keep_simba`.
- 4 `move_catalog`:
  - `ArDmKh`: accessor `IsKhachHang`, `IsNhaCungCap`, `IsNhanVien`.
  - `InDmKho`: methods `getInventoryByProduct`, `getInventoryList`, `getInventoryValue`.
  - `PoCt1`: method `getReceiptRate`.
  - `SysCompany`: method `resxByLanguage`.

Các bước còn lại:

- [x] Tạo audit script.
- [x] Tạo baseline doc.
- [ ] Phân tích 4 file `move_catalog` xem cần tách sang `diepxuan/laravel-catalog` hay giữ dưới dạng helper.
- [ ] Cập nhật README cho laravel-catalog liên quan đến `Catalog\Models\ArDmKh`, `Catalog\Models\InDmKho`, ...
- [ ] Tạo PR Phase 1.

Branch: `task/simba-model-layer-phase1-behavior-audit`

---

## Phase 2: Tách behavior theo cụm (đang thực hiện)

Mục tiêu: tách các method `move_catalog` (từ Phase 1 audit) ra khỏi Simba Models sang laravel-catalog.

### Trạng thái Phase 2 - cụm ArDmKh

Branch: `task/simba-model-layer-phase2-ardmkh-catalog`

Đã làm:

- Tạo `Diepxuan\Catalog\Models\Concerns\HasArDmKhCategories` chứa:
  - scope `laKhachHang`, `laNhaCungCap`, `laNhanVien`
  - accessor `is_khach_hang`, `is_nha_cung_cap`, `is_nhan_vien`
- Gắn trait vào `Diepxuan\Catalog\Models\ArDmKh`.
- Gỡ các method/accessor tương ứng khỏi `Diepxuan\Simba\Models\ArDmKh`.
- Giữ nguyên trong `Simba\Models\ArDmKh`:
  - `booted()` với global scope `ksd`.
  - `scopeSearch`, `scopeOrderByMaKh` (helper query thuần dữ liệu).
  - relation `glCts()`.
  - stored procedure wrapper `AsGetSoDuKh()`.
- Caller `diepxuan/laravel-catalog/src/Http/Livewire/Component/InputKhachhang.php` đã dùng `Catalog\ArDmKh` sẵn từ trước nên không cần sửa.

Verify:

- php -l: 3/3 pass.
- `git diff --check`: pass.
- Reflection (không boot app):
  - `Simba\ArDmKh`: `scopeLaKhachHang`=0, `getIsKhachHangAttribute`=0, `scopeSearch`=1, `scopeOrderByMaKh`=1.
  - `Catalog\ArDmKh`: `scopeLaKhachHang`=1, `getIsKhachHangAttribute`=1, `scopeSearch`=1 (inherited), parent=`Simba\ArDmKh`.

Các bước còn lại:

- [x] Tạo concern trong catalog.
- [x] Gắn trait vào `Catalog\ArDmKh`.
- [x] Gỡ method tương ứng khỏi `Simba\ArDmKh`.
- [x] Verify reflection.
- [ ] Lint + autoload Catalog composer dump.
- [ ] Tạo PR Phase 2 - cụm ArDmKh.

### Plan cho các cụm còn lại (Phase 1 audit đã chỉ ra)

- [x] `InDmKho` (cụm Inventory): method `getInventoryByProduct`, `getInventoryList`, `getInventoryValue`. Tạo `HasInDmKhoInventoryOperations` ở catalog.
- [x] `PoCt1` (cụm PO voucher): method `getTotalPurchaseByProduct`, `getTotalQuantityByProduct`, `getTotalPurchaseBySupplier`, `getReceiptRate`, `getPORptMH01`, `getPORptDH01`, `getPORptNH01`. Tạo `HasPoCt1PurchaseMetrics` ở catalog.
- [x] `SysCompany` (cụm Sys): method `resxByLanguage`. Helper nghiệp vụ, chuyển sang catalog qua `HasSysCompanyLocalizedResx`.

Mỗi cụm một PR nhỏ.


---

## Phase 4: Test bảo vệ ranh giới (đang thực hiện)

Mục tiêu: thiết lập rào chắn tự động, đảm bảo các PR sau không xâm phạm ranh giới 3 lớp.

### Trạng thái Phase 4

Branch: `task/simba-model-layer-responsibility-tests`

Test file: `tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php`

8 test method:

1. `testSModelGeneratedClassesHaveNoBehavior` — quét SModel generated, đảm bảo không có scope/relation/accessor/mutator/business method.
2. `testSModelClassesDoNotCallParentBoot` — đảm bảo SModel generated không gọi `parent::boot()`.
3. `testSimbaModelsDoNotExposeBusinessMethods` — kiểm tra business method đã move sang Catalog không còn trên `Simba\Models`.
4. `testSimbaModelsBootedDoesNotCallParentBoot` — đảm bảo `booted()` trong Simba Models không gọi `parent::boot()`.
5. `testCatalogModelsDoNotRedefineDbMetadata` — đảm bảo Catalog Models không khai báo DB metadata trực tiếp, trừ whitelist có lý do.
6. `testCatalogModelsBootedDoesNotCallParentBoot` — đảm bảo Catalog Models không gọi `parent::boot()` trong `booted()`.
7. `testCatalogModelsExtendSimbaModel` — kiểm tra parent class hợp lệ (Simba Models hoặc whitelist alias/utility).
8. `testCatalogModelsDoNotExtendSModelDirectly` — đảm bảo Catalog Models không extend trực tiếp `Diepxuan\Simba\SModel\*`.

Phát hiện/fix khi viết test:

- `Catalog\Models\ArDmKh::booted()` gọi `parent::boot()` không cần thiết → đã gỡ.
- `Simba\Models\SoCt1` còn business/report methods bị bỏ sót ở Phase 2 → tạo `Catalog\Models\Concerns\HasSoCt1SalesMetrics` + `Catalog\Models\SoCt1`, gỡ method khỏi `Simba\Models\SoCt1`.

Whitelist hiện tại:

- `Zsysmenu`: alias table cùng schema SysMenu.
- `System`, `SystemConfig`: catalog subclass alias.
- `User`: extends `App\Models\User`.
- `UserLink`: extends `AbstractModel`, utility link table.
- `Params`: utility params model.
- `InDmNhvt`: custom cast `CategoryMagento` ở catalog layer.

Ghi chú: `CaCt2`, `CaPh2`, `CaPh3` trước đây tạm whitelist vì Catalog extend trực tiếp SModel; hiện đã chuyển sang `Diepxuan\Simba\Models\CaCt2/CaPh2/CaPh3`, không còn nằm trong whitelist.

Verify:

```bash
php -l tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php
vendor/bin/phpunit tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php
```

Kết quả hiện tại: 8 tests, 10 assertions, OK.

Full `vendor/bin/phpunit` hiện còn lỗi pre-existing (`Core\PackageConfigTest`, `Feature\ExampleTest`) không liên quan PR này.

### Phase 4b: Cleanup còn lại sau test gate

- Tạo `scripts/audit-catalog-model-layer.php` để audit riêng `diepxuan/laravel-catalog/src/Models`.
  - Output hiện tại: 35 file, 12 có behavior.
  - Classification: `concern_business`, `inline_business`, `catalog_utility`, `passthrough`.
- Tích hợp CI gate trong `.github/workflows/tests.yml`:
  - `php scripts/audit-model-layer-responsibility.php`
  - `php scripts/audit-catalog-model-layer.php`
- Chuyển `Catalog\Models\CaCt2`, `Catalog\Models\CaPh2`, `Catalog\Models\CaPh3` sang extend `Diepxuan\Simba\Models\*` thay vì `Diepxuan\Simba\SModel\*`.
- Thêm test `testCatalogModelsDoNotExtendSModelDirectly` để khóa rule.

Verify:

```bash
php scripts/audit-model-layer-responsibility.php
php scripts/audit-catalog-model-layer.php
vendor/bin/phpunit tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php
```

Kết quả: Simba audit 445 file/28 behavior đều `keep_simba`; Catalog audit 35 file/12 behavior; PHPUnit 8 tests, 10 assertions, OK.

---

## Phase tiếp theo (theo cụm nhỏ)

### Phase 1: Audit behavior trong `laravel-simba/src/Models`

Mục tiêu: phân loại từng method hiện có.

Nhóm giữ lại trong Simba Models:

- Scope filter trực tiếp theo cột thật.
- Relation trực tiếp giữa các bảng Simba bằng key thật.
- Accessor/mutator chuẩn hóa dữ liệu thuần Simba.
- Helper query nhỏ không phụ thuộc Portal/Catalog.

Nhóm chuyển sang Catalog:

- Business rule create/edit/save/delete.
- Helper phục vụ màn hình Portal/Livewire.
- Navigation/menu/route resolver.
- Product/Magento mapping nếu phục vụ Catalog sync.
- Report workflow/use-case service.
- Policy/authorization/session/request/UI logic.

Deliverable:

- Tạo bảng audit theo file/method/phân loại/đích chuyển.
- Không code move trong phase này nếu chưa có danh sách caller.

### Phase 2: Tách behavior theo từng cụm nhỏ

Làm từng PR nhỏ theo module/use-case, không gom toàn bộ:

1. Inventory/Product group
   - `InDmVt`, `InDmNhvt`, `Product`-related behavior.
   - Chuyển helper Catalog/Magento sang `laravel-catalog`.
2. Menu/metadata group
   - `SysMenu`, report/dictionary metadata models.
   - Giữ Simba metadata thuần ở Simba; resolver/cache/use-case ở Catalog.
3. Finance report/query group
   - `Gl*`, `Ar*`, `Ap*`, `Ca*` report helpers.
   - Query sát bảng có thể giữ; report workflow/service chuyển Catalog.
4. Purchase/Sales voucher group
   - `Po*`, `So*`, `PhieuChuyenKho*`.
   - Tách alias/use-case ra Catalog nếu đang là Portal concept.

### Phase 3: Chuẩn hóa schema duplication

Một số model trong `laravel-simba/src/Models` hiện còn tự khai báo schema thay vì extend SModel generated:

- `SysDictionaryInfo`
- `SysReportInfo`
- `SysReportDrillDownInfo`
- `SiDmCt`

Cần kiểm tra SModel generated tương ứng rồi refactor để:

- Schema nằm ở `SModel`.
- Behavior/helper nằm ở `Models`.
- Catalog cache/service nằm ở `laravel-catalog`.

---

## 1. Hiện trạng audit nhanh

### 1.1 `diepxuan/laravel-simba/src/SModel`

Số file hiện tại: 455 PHP files.

Vai trò hiện tại:
- Phần lớn là generated base model, mỗi file khai báo trực tiếp:
  - `$table`
  - `$primaryKey`
  - `$keyType`
  - `$incrementing`
  - `$timestamps`
  - `$fillable`
  - `$casts`
- `SModel.php` đang chứa cả:
  - connection setup qua `HasSimbaConnection`
  - override `getTable()`
  - override `query()`, `all()`, `save()`, `delete()`
  - hook kiểu `validateLegacyRules`, `beforeLegacyDelete`, `afterLegacyDelete`
  - một số helper mang tính runtime/database operation.

Nhận xét:
- Đúng hướng khi `SModel` là nơi giữ cấu hình DB.
- Nhưng `SModel.php` hiện hơi rộng: có hành vi query/save/delete chung, có thể gây side effect khó kiểm soát.
- Các generated model nên giữ càng thuần càng tốt, không chứa nghiệp vụ.

### 1.2 `diepxuan/laravel-simba/src/Models`

Số file hiện tại: 49 PHP files.

Thống kê nhanh:
- 24 file có local scopes.
- 6 file có accessor.
- 4 file có relations.
- 3 file gọi StoredProcedures.
- 8 file vẫn có DB config trực tiếp.

Ví dụ hiện tại:
- `Diepxuan\Simba\Models\ArDmKh` đang có:
  - global scope `ksd`
  - scopes `laKhachHang`, `laNhaCungCap`, `laNhanVien`, `search`, `orderByMaKh`
  - relation `glCts()`
  - stored procedure wrapper `AsGetSoDuKh()`
  - accessor `is_khach_hang`, `is_nha_cung_cap`, `is_nhan_vien`

Nhận xét:
- Scope/accessor thuộc lớp Simba model là hợp lý nếu nó biểu diễn trực tiếp field/table Simba.
- Relations giữa các bảng Simba cũng có thể đặt ở đây nếu là quan hệ dữ liệu gốc, không phụ thuộc Portal module.
- Nhưng SP wrapper và một số relation/domain method có thể cần phân loại lại: nếu là thao tác nghiệp vụ Portal thì nên đưa lên Catalog/service.

### 1.3 `diepxuan/laravel-catalog/src/Models`

Số file hiện tại: 35 PHP files.

Thống kê nhanh:
- 7 file có relations.
- 5 file có scopes.
- 1 file có accessor.
- 2 file có DB config trực tiếp.

Ví dụ hiện tại:
- `Diepxuan\Catalog\Models\ArDmKh` kế thừa `Diepxuan\Simba\Models\ArDmKh`, có:
  - relations Portal/Catalog: `nhomKhachHang`, `phanLoaiKhachHang1/2/3`
  - helper `getSoduKh()`
  - business method `hasTransactions()`
  - global scope `orderByMaKh`

Nhận xét:
- Catalog model là nơi phù hợp cho relation/use-case của Portal.
- Nhưng cần tránh duplicate scope đã có ở Simba model, ví dụ order/scope/search có thể bị trùng hoặc thay đổi semantic.
- `booted()` trong `Catalog\Models\ArDmKh` đang gọi `parent::boot()` thay vì `parent::booted()`; cần review kỹ vì có thể bỏ qua hoặc gọi sai lifecycle.

---

## 2. Ranh giới trách nhiệm đề xuất

### 2.1 `laravel-simba/src/SModel`: Base DB schema/config only

Được phép chứa:
- Connection:
  - `protected $connection`
  - `getSimbaConnectionName()` hoặc cơ chế tương đương.
- Table metadata:
  - `$table`
  - `$primaryKey`
  - `$keyType`
  - `$incrementing`
  - `$timestamps`
- Eloquent metadata:
  - `$fillable` hoặc `$guarded`
  - `$casts`
  - date format nếu SQL Server cần.
- Base helpers an toàn, không nghiệp vụ:
  - normalize table name fallback.
  - SQL Server connection resolver.

Không nên chứa:
- Scope nghiệp vụ.
- Accessor/mutator mang ý nghĩa nghiệp vụ.
- Relations.
- Stored procedure wrapper theo nghiệp vụ.
- Override `save/delete/all/query` nếu không có lý do bắt buộc và test bảo vệ.

### 2.2 `laravel-simba/src/Models`: Direct Laravel model for Simba tables

Được phép chứa:
- Scope bám trực tiếp vào field Simba:
  - `scopeActive()`/`scopeDangSuDung()` cho `ksd` nếu field có thật.
  - `scopeCompany($maCty)` cho `ma_cty`.
  - `scopeSupplier()` cho `isncc`, `scopeCustomer()` cho `iskh`, nếu là semantic field trực tiếp.
- Accessor/cast normalize field:
  - boolean flag từ SQL Server bit/int.
  - tên accessor alias giúp code PHP đọc rõ hơn.
- Relations trực tiếp giữa bảng Simba nếu key có thật và ổn định:
  - `belongsTo`, `hasMany` giữa bảng danh mục/chứng từ/sổ cái.
- Query helper thuần dữ liệu, không UI/use-case.

Không nên chứa:
- Logic chỉ phục vụ Catalog UI.
- Điều hướng route, Livewire, request/session/auth.
- Business policy của Portal như `hasTransactions()` nếu dùng để quyết định UI/action trong Catalog.
- Stored procedure orchestration phức tạp; ưu tiên để ở `StoredProcedures` hoặc service/domain layer.

### 2.3 `laravel-catalog/src/Models`: Portal/Catalog domain model

Được phép chứa:
- Relations phục vụ module Portal/Catalog.
- Helper tính toán nghiệp vụ cho màn hình, ví dụ:
  - `hasTransactions()`
  - `getSoduKh()` nếu là API tiện ích cho Catalog.
  - computed status/display helpers.
- Scopes theo use-case Portal, ví dụ danh sách mặc định, filter UI.
- Bridge giữa Simba raw data và Portal module.

Không nên chứa:
- Khai báo lại `$table`, `$primaryKey`, `$connection`, `$casts` nếu lớp cha Simba đã có.
- Logic SQL Server connection.
- Stored procedure low-level call nếu đã có wrapper/service.

---

## 3. Nguyên tắc refactor

1. Không đổi tên bảng/cột/SP nếu chưa đối chiếu `simba-docs` hoặc source wrapper hiện có.
2. Không tạo/ALTER/INSERT SQL.
3. Mỗi model refactor phải có test hành vi trước khi sửa.
4. Không sửa 455 generated SModel bằng tay từng file nếu có thể dùng generator/rule tự động.
5. Không xóa compatibility alias khi chưa `git grep` hết usage.
6. Không thay global scope production trong một PR lớn; phải tách từng nhóm model có test.
7. Mọi thay đổi route/UI đang dùng model phải smoke lại màn hình liên quan.

---

## 4. Deliverables

1. Tài liệu ranh giới model layer:
   - `docs/project/model-layer-responsibility.md`
2. Static audit script:
   - `scripts/audit-model-layer-responsibility.php`
   - In ra các vi phạm:
     - SModel có `scope*`, relation, accessor, SP call.
     - Simba Model có `$table/$primaryKey/$connection` trùng base.
     - Catalog Model có DB metadata trực tiếp.
     - Catalog Model gọi `parent::boot()` trong `booted()`.
3. Test bảo vệ base model:
   - `diepxuan/laravel-simba/tests/Unit/SModelResponsibilityTest.php` hoặc test suite hiện hữu tương ứng.
   - `diepxuan/laravel-catalog/tests/Unit/Models/CatalogModelResponsibilityTest.php` nếu catalog package đang có test namespace.
4. Refactor từng nhóm model ưu tiên:
   - Nhóm ARDMKH: `ArDmKh`, `ArDmNhKh`, `ArDmPlKh`.
   - Nhóm SysMenu/Zsysmenu: vì đang là source route/menu.
   - Nhóm GL account: `GlDmTk`, `GlCt`, `GlCdTk`.
   - Nhóm PO voucher: `PoPh*`, `PoCt*`, `PoCp*` sau.

---

## 5. Implementation tasks

### Task 1: Chốt policy bằng docs

**Objective:** Tạo tài liệu chính thức về trách nhiệm 3 lớp model.

**Files:**
- Create: `docs/project/model-layer-responsibility.md`

**Steps:**
1. Viết tài liệu gồm 3 section:
   - `SModel: database schema/config`
   - `Simba Models: direct table behavior`
   - `Catalog Models: Portal domain behavior`
2. Thêm bảng `Allowed / Not allowed` cho từng lớp.
3. Thêm checklist review PR model.
4. Chạy:
   ```bash
   git diff --check docs/project/model-layer-responsibility.md
   ```

**Expected:** không có whitespace error.

### Task 2: Tạo audit script cho model layer

**Objective:** Có công cụ lặp lại để phát hiện model đặt sai trách nhiệm.

**Files:**
- Create: `scripts/audit-model-layer-responsibility.php`

**Rules cần check:**
- Trong `diepxuan/laravel-simba/src/SModel/**/*.php`:
  - fail nếu có `function scope[A-Z]` ngoài whitelist.
  - fail nếu có relation return types/imports: `BelongsTo`, `HasMany`, `HasOne`, `BelongsToMany`, `Morph*`.
  - fail nếu có accessor `get*Attribute` hoặc `Attribute::make`.
  - fail nếu có `StoredProcedures` hoặc `::call(` không thuộc base utility whitelist.
- Trong `diepxuan/laravel-simba/src/Models/**/*.php`:
  - warn nếu khai báo `$table`, `$primaryKey`, `$connection` mà SModel base tương ứng đã có.
  - warn nếu gọi route/auth/session/request/view.
- Trong `diepxuan/laravel-catalog/src/Models/**/*.php`:
  - warn nếu khai báo DB config trực tiếp.
  - fail nếu `booted()` gọi `parent::boot()` thay vì `parent::booted()`.

**Verification:**
```bash
php -l scripts/audit-model-layer-responsibility.php
php scripts/audit-model-layer-responsibility.php
```

**Expected:** script chạy được, ban đầu có thể báo violations hiện hữu nhưng exit code nên cấu hình `--strict` mới fail để không phá CI ngay.

### Task 3: Thêm baseline audit report

**Objective:** Ghi lại hiện trạng trước refactor để tránh làm mù.

**Files:**
- Create: `docs/project/model-layer-audit-baseline.md`

**Steps:**
1. Chạy audit script ở non-strict mode.
2. Ghi summary counts:
   - SModel files: 455
   - Simba Models: 49
   - Catalog Models: 33
3. Ghi nhóm vi phạm ưu tiên sửa.
4. Chạy `git diff --check`.

### Task 4: Viết tests cho ARDMKH model boundaries

**Objective:** Bảo vệ nhóm ARDMKH trước khi refactor.

**Files:**
- Add/modify tests dưới package phù hợp:
  - `diepxuan/laravel-catalog/tests/Unit/Models/ArDmKhModelTest.php`
  - hoặc test namespace hiện có nếu khác.

**Test cases:**
1. `Catalog\Models\ArDmKh` kế thừa `Simba\Models\ArDmKh`.
2. `Catalog\Models\ArDmKh::hasTransactions()` dùng relation `glCts()` và trả bool.
3. `Simba\Models\ArDmKh` vẫn có scopes field-level:
   - customer/supplier/employee.
4. `Catalog\Models\ArDmKh` không khai báo `$connection/$table/$primaryKey` riêng.

**Verification:**
```bash
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Models/ArDmKhModelTest.php
```

### Task 5: Sửa lifecycle bug trong Catalog ArDmKh nếu test xác nhận

**Objective:** Đưa `booted()` về đúng Laravel lifecycle.

**Files:**
- Modify: `diepxuan/laravel-catalog/src/Models/ArDmKh.php`

**Change dự kiến:**
```php
protected static function booted(): void
{
    parent::booted();

    static::addGlobalScope('orderByMaKh', static function ($query): void {
        $query->orderBy('ma_kh');
    });
}
```

**Note:** Nếu parent không có `booted()` custom thì vẫn hợp lệ vì Laravel Model có static boot flow; cần chạy test để xác nhận.

**Verification:**
```bash
php -l diepxuan/laravel-catalog/src/Models/ArDmKh.php
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Models/ArDmKhModelTest.php
```

### Task 6: Phân loại lại `Simba\Models\ArDmKh`

**Objective:** Tách logic nào là direct-table, logic nào là Catalog domain.

**Files:**
- Review: `diepxuan/laravel-simba/src/Models/ArDmKh.php`
- Review: `diepxuan/laravel-catalog/src/Models/ArDmKh.php`

**Decision matrix:**
- Giữ ở Simba:
  - scopes theo field `isKh/isNcc/isNv/ksd`.
  - accessor boolean alias.
  - search nếu search chỉ là query trực tiếp theo các cột ARDMKH.
- Chuyển/giữ ở Catalog:
  - `hasTransactions()`.
  - relation dùng model Catalog nếu phục vụ UI Catalog.
  - `getSoduKh()` nếu dùng cho Portal workflow.
- Đưa ra service nếu là SP orchestration:
  - tạo service `Catalog\Services\CustomerBalanceService` nếu `AsGetSoDuKh` cần logic tham số/ngày/tài khoản.

**Verification:**
```bash
git grep -n "AsGetSoDuKh\|getSoduKh\|hasTransactions\|laNhaCungCap\|laKhachHang" diepxuan
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Models/ArDmKhModelTest.php
```

### Task 7: Chuẩn hóa SysMenu/Zsysmenu model boundaries

**Objective:** Vì menu route đang là source of truth, cần model rõ ràng và ít side effect.

**Files:**
- Review: `diepxuan/laravel-simba/src/Models/SysMenu.php`
- Review: `diepxuan/laravel-simba/src/Models/Zsysmenu.php`
- Review: `diepxuan/laravel-catalog/src/Models/SysMenu.php`
- Review: `diepxuan/laravel-catalog/src/Models/Zsysmenu.php`
- Tests liên quan: `diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php`

**Rules:**
- Simba model: scopes/accessors field-level only.
- Catalog model/service: route/menu semantics, module placement, URL target.
- Không để route resolver logic trong Simba model.

**Verification:**
```bash
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
php scripts/generate-simba-source-routes.php --json
```

### Task 8: Chuẩn hóa GL/PO model theo pattern đã chốt

**Objective:** Áp dụng pattern sau khi ARDMKH và SysMenu ổn.

**Files ưu tiên:**
- GL: `GlDmTk`, `GlCt`, `GlCdTk`
- PO: `PoPh*`, `PoCt*`, `PoCp*`

**Steps:**
1. Chạy audit script lọc theo nhóm.
2. Viết test cho 1-2 model đại diện mỗi nhóm.
3. Di chuyển logic nếu sai layer.
4. Chạy module tests.

**Verification:**
```bash
php scripts/audit-model-layer-responsibility.php --group=gl
php scripts/audit-model-layer-responsibility.php --group=po
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit
```

### Task 9: Thêm CI non-blocking trước, strict sau

**Objective:** Đưa audit vào workflow an toàn, không làm vỡ CI ngay.

**Phase 1:** non-blocking/report only.
```bash
php scripts/audit-model-layer-responsibility.php --format=github
```

**Phase 2:** strict cho rule đã sạch.
```bash
php scripts/audit-model-layer-responsibility.php --strict=smodel
```

**DoD:**
- CI báo warning rõ ràng.
- Không fail trên legacy violations chưa xử lý.
- Khi một nhóm đã clean thì bật strict riêng nhóm đó.

---

## 6. Suggested PR split

### PR 1: docs + audit baseline
- Add `model-layer-responsibility.md`.
- Add `audit-model-layer-responsibility.php` non-strict.
- Add `model-layer-audit-baseline.md`.
- Không refactor model.

### PR 2: ARDMKH boundary cleanup
- Tests cho `ArDmKh`.
- Sửa lifecycle `booted()` nếu xác nhận.
- Phân loại `AsGetSoDuKh`, `hasTransactions`, relations.

### PR 3: SysMenu/Zsysmenu cleanup
- Đảm bảo menu metadata vẫn pass.
- Không làm đổi route count ngoài expected.

### PR 4+: GL/PO model groups
- Mỗi module/group một PR.
- Mỗi PR có test + audit delta.

---

## 7. Validation checklist chung

Chạy trước khi báo xong mỗi PR:

```bash
php -l scripts/audit-model-layer-responsibility.php
php scripts/audit-model-layer-responsibility.php
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php
git diff --check
git status --short
```

Nếu refactor model cụ thể, thêm:

```bash
php -l <changed-model.php>
vendor/bin/phpunit <new-or-related-test.php>
git grep -n "<moved-method-or-class>" diepxuan
```

---

## 8. Definition of Done

- Có tài liệu policy rõ ràng cho 3 lớp model.
- Có audit script chạy được và tái lập được baseline.
- Không còn logic nghiệp vụ trong `SModel` ngoài DB config/schema.
- `Simba\Models` giữ direct table behavior, không phụ thuộc Portal UI/route/auth.
- `Catalog\Models` giữ domain/helper/relation phục vụ Portal, không khai báo DB config trùng base.
- Các model trọng yếu ARDMKH, SysMenu/Zsysmenu có test bảo vệ.
- Không làm đổi route/source metadata ngoài expected.
- Không push/merge khi chưa có lệnh của Sếp.