# Simba model layer refactor plan

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

## Trạng thái đã làm trong PR này

- Thêm README cho `SModel` để ghi rõ đây là raw/table schema layer.
- Thêm README cho `Models` để ghi rõ đây là model layer extend từ `SModel`.
- Sửa các import/extend trong `laravel-simba/src/Models` đang trỏ sai tên class SModel generated.
- Không đổi public model class để tránh phá caller hiện tại.

## Các model đã sửa tên import/extend

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

`SysMenu` giữ trỏ về `SysMenuModel` mới/chuẩn vì file này đã có metadata đầy đủ hơn generated cũ `sysMenuModel`.

## Việc tiếp theo

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

## Verification checklist cho các PR tiếp theo

```bash
php -l <files changed>
git diff --check
php -r 'require "vendor/autoload.php"; foreach ([/* classes */] as $c) { echo class_exists($c) ? "ok" : "missing"; }'
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php
```

Nếu đụng behavior đang được Catalog gọi, bắt buộc search caller trước:

```bash
git grep -n "methodName\|ClassName" diepxuan tests routes config docs
```

## Definition of Done

- Không còn import SModel sai tên class trong `laravel-simba/src/Models`.
- README nêu rõ ranh giới layer.
- Mọi refactor behavior có audit caller và test/lint tương ứng.
- Không chuyển logic rộng trong cùng PR với rename/import cleanup.
