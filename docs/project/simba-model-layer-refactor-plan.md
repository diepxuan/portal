# Simba Model Layer Refactor Plan

Plan tổng hợp 3 tài liệu về model layer trong hệ thống:
- Trách nhiệm 3 lớp (SModel / Simba Models / Catalog Models).
- Lịch sử refactor Phase 0 → 5 + PR liên quan.
- Audit baseline 28 file có behavior.

> `simba-router-menu-matrix.md` là plan riêng về menu/route, không thuộc doc này.

## Mục lục

1. Tóm tắt policy 3 lớp.
2. Tóm tắt tiến độ refactor.
3. Audit baseline (28 file).
4. Phase 0 — Composite PK + alias + trait (PR #217).
5. Phase 1 — Deduplicate schema 4 model metadata (PR #218).
6. Phase 2 — Audit behavior baseline (PR #219).
7. Phase 3 — Tách behavior sang Catalog (PR #220, #222, #223).
8. Phase 4 — Test gate 8 method (PR #223, #225).
9. Phase 4b — Cleanup còn lại + audit Catalog + CI gate (PR #225).
10. Phase 5 — Doc policy 3 lớp (PR #224).
11. Hiện trạng audit ban đầu (lưu trước refactor).
12. Ranh giới trách nhiệm (final).
13. Nguyên tắc refactor.
14. Validation checklist + Definition of Done.

---

## 1. Tóm tắt policy 3 lớp

Schema Simba là nguồn sự thật duy nhất (`simba-docs/tables`).

### 1.1. `SModel` (`Diepxuan\Simba\SModel\*`)

Vai trò: ánh xạ schema Simba sang Eloquent. Không có business logic.

**Allowed:**

- Khai báo `$table`, `$connection`, `$primaryKey`, `$keyType`, `$incrementing`, `$timestamps`.
- Khai báo `$fillable`, `$guarded`, `$hidden`, `$casts`, `$attributes`.
- Hằng số `PRIMARY_KEY_COLUMNS` cho composite PK.
- Method helper DB hợp lệ (set connection theo cty, transaction begin/commit/rollback).
- Scope Simba-level: `scopeIsEnable`, filter theo field Simba.
- Global scope `onlyFirstCompany` ở `SModel` base.
- Relation Simba-Simba (theo key thật).

**Not allowed:**

- Scope, relation, accessor, mutator theo ngữ nghĩa nghiệp vụ (ví dụ: `scopeLaKhachHang`, `getIsXxxAttribute`).
- Method business (tính tổng, gọi SP báo cáo, nghiệp vụ KH/NCC/NV).
- Khai báo behavior cụm (inventory, sales, purchase) trên bảng gốc.

### 1.2. `Simba\Models` (`Diepxuan\Simba\Models\*`)

Vai trò: lớp 2, bọc SModel + helper nghiệp vụ dữ liệu thuần Simba.

**Allowed:**

- Extend SModel tương ứng.
- Dùng trait `HasSimbaCompositeKey` cho bảng composite PK.
- Scope filter theo field Simba (`scopeFilterByMaCty`, `scopeFilterByMaVt`, `scopeFilterByMaKho`, `scopeFilterByMaKh`, `scopeFilterByMaNvkd`, `scopeFilterByMaBp`, `scopeFilterByNgayCt`, `scopeSearch`, `scopeOrderByMaKh`, v.v.).
- Relation Simba-Simba (`belongsTo`, `hasMany`).
- Wrapper gọi stored procedure đơn giản (mapping param) — chỉ khi bản thân SP không phải logic nghiệp vụ phức tạp, ví dụ `getAsINGetDMKHO`, `getAsINRptCD01`. Hạn chế; ưu tiên catalog.
- Accessor/mutator chuẩn hóa dữ liệu thuần Simba.
- Global scope khi cần (ví dụ `ksd` lọc soft-deleted).

**Not allowed:**

- Business method (tính tổng doanh thu, số lượng, nghiệp vụ KH/NCC/NV, công thức tính giá, tỉ lệ nhập, v.v.).
- Report method (các `getSORpt*`, `getPORpt*`, `getINRpt*`).
- Gọi `parent::boot()` trong `booted()` (SModel base đã set connection trong `__construct`).
- Khi gỡ behavior phải đảm bảo caller chuyển sang Catalog.

### 1.3. `Catalog\Models` (`Diepxuan\Catalog\Models\*`)

Vai trò: lớp 3, business logic phục vụ Portal/Catalog UI.

**Allowed:**

- Extend `Simba\Models\*` (mặc định).
- Concern `HasArDmKhCategories`, `HasInDmKhoInventoryOperations`, `HasPoCt1PurchaseMetrics`, `HasSoCt1SalesMetrics`, `HasSysCompanyLocalizedResx` — khi cần business logic cụm.
- Scope nghiệp vụ (`scopeLaKhachHang`, `scopeLaNhaCungCap`).
- Accessor nghiệp vụ (`getIsKhachHangAttribute`, `getIsNhaCungCapAttribute`).
- Method business: `getInventoryByProduct`, `getInventoryList`, `getInventoryValue`, `getTotalPurchaseByProduct`, `getReceiptRate`, `resxByLanguage`.
- Method report (chạy SP báo cáo): `getSORpt*`, `getPORpt*`.
- Custom cast class ở `$casts` (ví dụ `CategoryMagento` cho `InDmNhvt`).
- Global scope nghiệp vụ (ví dụ `orderByMaKh` ở `ArDmKh`).

**Not allowed:**

- Khai báo `$table`/`$connection`/`$primaryKey` trực tiếp (đã có SModel), trừ alias subclass đặc biệt (`Zsysmenu` cùng schema SysMenu bảng khác).
- Gọi `parent::boot()` trong `booted()`.

### 1.4. Whitelist (Catalog Models được phép lệch rule)

| Model | Lý do |
|-------|-------|
| `Zsysmenu` | Alias table cùng schema SysMenu |
| `System`, `SystemConfig` | Catalog subclass alias |
| `User` | Extends `App\Models\User` (Laravel auth) |
| `UserLink` | Extends `AbstractModel`, utility link table |
| `Params` | Utility params model, không có SModel |
| `InDmNhvt` | Custom cast `CategoryMagento` ở catalog |

Ghi chú (cập nhật từ PR #225): `CaCt2`, `CaPh2`, `CaPh3` trước đây tạm whitelist vì Catalog extend trực tiếp SModel; hiện đã chuyển sang `Diepxuan\Simba\Models\CaCt2/CaPh2/CaPh3`, không còn nằm trong whitelist.

Khi thêm Catalog Model mới mà cần lệch rule, **phải thêm vào whitelist kèm comment lý do** trong:

- `SimbaModelLayerResponsibilityTest::$CATALOG_DB_METADATA_WHITELIST`
- `SimbaModelLayerResponsibilityTest::$CATALOG_EXTENDS_WHITELIST`

### 1.5. Quy trình thêm behavior mới

1. Có behavior cần thêm?
   - Có ý nghĩa nghiệp vụ? → Catalog (Concern hoặc trực tiếp).
   - Chỉ là filter/relation Simba-Simba? → Simba Models.
   - Cần thêm cột/bảng/schema? → SModel + `simba-docs/tables`.
2. Catalog Concern là lựa chọn ưu tiên nếu:
   - Áp dụng được cho nhiều Catalog Model cùng pattern.
   - Có dependency vào các model khác (đặt vào trait để tránh circular).
3. Với method gọi SP:
   - Wrapper param mapping đơn giản có thể ở Simba Models (nếu nhiều Catalog Model cùng dùng).
   - Logic nghiệp vụ (tính tổng, lọc, aggregate) ở Catalog.
4. Mỗi concern phải có docblock mô tả lý do tách và nhóm method.

### 1.6. Review checklist

Khi review PR liên quan model layer:

- [ ] SModel generated không thêm scope/relation/method.
- [ ] Simba Models không thêm business method.
- [ ] Business method mới ở Catalog Models (hoặc concern).
- [ ] Catalog Models không khai báo DB metadata trùng SModel (trừ whitelist).
- [ ] `booted()` không gọi `parent::boot()` ở cả 3 lớp.
- [ ] Tên concern có pattern `Has<Model><Group>`.
- [ ] Chạy `vendor/bin/phpunit tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php`.
- [ ] Chạy `php scripts/audit-model-layer-responsibility.php` (nếu có audit liên quan).
- [ ] Cập nhật bảng audit baseline ở section 3 nếu thêm/bớt method.

### 1.7. Công cụ kiểm tra tự động

- **Test:** `tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php` (8 test, 10 assertion - tăng từ 7 test ở PR #225).
- **Audit script Simba:** `scripts/audit-model-layer-responsibility.php` (Phase 2 PR #219, output: 445 file / 28 behavior đều `keep_simba`).
- **Audit script Catalog:** `scripts/audit-catalog-model-layer.php` (Phase 4b PR #225, output: 35 file / 12 behavior).
- **CI gate:** `.github/workflows/tests.yml` chạy 2 audit script trước `vendor/bin/phpunit` (PR #225).

---

## 2. Tóm tắt tiến độ refactor

| Phase | Mô tả | PR | Trạng thái |
|-------|-------|----|------------|
| 0 | Composite PK + alias + trait `HasSimbaCompositeKey` | #217 | MERGED |
| 1 | Deduplicate schema 4 model metadata | #218 | MERGED |
| 2 | Audit behavior baseline | #219 | MERGED |
| 3a | Move ArDmKh KH/NCC/NV sang Catalog | #220 | MERGED |
| 3b | Move InDmKho + PoCt1 + SysCompany sang Catalog | #222 | MERGED |
| 3c | Move SoCt1 sales metrics sang Catalog + fix ArDmKh::booted | #223 | MERGED |
| 4 | Test gate 7 method (gốc 7, mở rộng 8) | #223 + #225 | MERGED |
| 4b | Cleanup còn lại (CaCt2/CaPh2/CaPh3, audit Catalog, CI gate) | #225 | MERGED |
| 5 | Doc policy 3 lớp | #224 | MERGED |

Trạng thái hiện tại:

- SModel layer: sạch, chỉ schema mapping (442 file, không còn file legacy thiếu hậu tố `Model`).
- Simba\Models layer: 445 file, không còn business method nghiệp vụ (đã move hết sang Catalog). 346 model dùng `HasSimbaCompositeKey`.
- Catalog\Models layer: 35 file, nhận tất cả business method nghiệp vụ qua 5 concern (HasArDmKhCategories, HasInDmKhoInventoryOperations, HasPoCt1PurchaseMetrics, HasSoCt1SalesMetrics, HasSysCompanyLocalizedResx) + 2 model mới `Catalog\PoCt1` (PR #222) và `Catalog\SoCt1` (PR #223).
- Test gate: 8 test, 10 assertion ở `tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php`, chạy trong root phpunit.
- Audit script: 2 file (`audit-model-layer-responsibility.php` cho Simba, `audit-catalog-model-layer.php` cho Catalog) gắn trong `.github/workflows/tests.yml` trước khi chạy phpunit (PR #225).
- Số liệu cuối: 442 SModel, 445 Simba Models, 346 composite-key Models, 35 Catalog Models, 5 Catalog concerns.

---

## 3. Audit baseline (28 file)

Generated: 2026-06-22T02:01:32+00:00
Source: `diepxuan/laravel-simba/src/Models`
Total Models: 445
With behavior: 28

### 3.1. Phân loại

- `keep_simba`: scope/relation/accessor đọc trực tiếp field schema, hoặc method kiểu `isXxx()/getXxx()` parse enum/display từ field. Phù hợp giữ ở Simba Models.
- `move_catalog`: business logic, tính toán, mở service, ngữ nghĩa nghiệp vụ (KH/NCC/NV). Nên tách sang `diepxuan/laravel-catalog`.

### 3.2. Bảng behavior

| File | scop | rel | acc | mut | meth | boot | classification | chi tiết |
|------|------|-----|-----|-----|------|------|----------------|----------|
| `ApCt1.php` | 7 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterBySoHd, FilterByMaNcc, FilterByMaBp, FilterByMaNt, FilterByNgayHd...<br/>rel: apDmNcc:belongsTo, sysDepartment:belongsTo, glDmTk:belongsTo |
| `ArCt1.php` | 7 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterBySoHd, FilterByMaKh, FilterByMaBp, FilterByMaNt, FilterByNgayHd...<br/>rel: arDmKh:belongsTo, sysDepartment:belongsTo, glDmTk:belongsTo |
| `ArDmKh.php` | 5 | 1 | 3 | 0 | 0 | - | `move_catalog` | scope: LaKhachHang, LaNhaCungCap, LaNhanVien, Search, OrderByMaKh<br/>rel: glCts:hasMany<br/>acc: IsKhachHang, IsNhaCungCap, IsNhanVien |
| `ArDmNhKh.php` | 2 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: Search, OrderByMaNhkh |
| `ArDmPlKh.php` | 3 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: Loai, Search, OrderByMaPlkh |
| `CaCt1.php` | 6 | 4 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByTk, FilterByTkList, FilterByMaKh, FilterByMaBp, FilterByNgayCt<br/>rel: caPh3:belongsTo, glDmTk:belongsTo, arDmKh:belongsTo, sysDepartment:belongsTo |
| `FaDmLk.php` | 4 | 1 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByMaTs, FilterByMaLk, FilterByKsd<br/>rel: faDmTs:belongsTo |
| `GlCdTk.php` | 2 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByTkList, FilterByMaNt |
| `GlCt.php` | 4 | 1 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByTkList, FilterByTkduList, FilterByMaBp, FilterByMaNt<br/>rel: arDmKh:belongsTo |
| `GlCt1.php` | 6 | 4 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByTk, FilterByTkList, FilterByMaKh, FilterByMaBp, FilterByMaNt<br/>rel: glDmTk:belongsTo, arDmKh:belongsTo, sysDepartment:belongsTo, glCt:belongsTo |
| `InDmKho.php` | 7 | 4 | 0 | 0 | 3 | - | `move_catalog` | scope: FilterByMaCty, FilterByMaKho, FilterByTenKho, FilterByKhoDl, FilterByKsd, Active...<br/>rel: glDmTk:belongsTo, inDmViTri:hasMany, inCtNhap:hasMany, inCtXuat:hasMany<br/>meth: getInventoryByProduct, getInventoryList, getInventoryValue |
| `InDmNhvt.php` | 2 | 2 | 0 | 0 | 0 | - | `keep_simba` | scope: IsRoot, HasParent<br/>rel: catChildrens:hasMany, catParent:belongsTo |
| `InDmVt.php` | 1 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: WithQuantity |
| `MmCt3.php` | 6 | 6 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterBySoDh, FilterByMaVt, FilterByMaKho, FilterByMaLo, FilterByMaBp<br/>rel: mmPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo, inDmViTri:belongsTo, inDmLo:belongsTo |
| `PoCp3.php` | 2 | 1 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCp, FilterByMaBp<br/>rel: poPh3:belongsTo |
| `PoCt1.php` | 6 | 8 | 0 | 0 | 1 | - | `move_catalog` | scope: FilterByMaCty, FilterByMaVt, FilterByMaKho, FilterByMaNcc, FilterByMaBp, FilterByNgayCt<br/>rel: poPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo, inDmViTri:belongsTo, inDmLo:belongsTo<br/>meth: getReceiptRate |
| `PoCt3.php` | 2 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaVt, FilterByMaKho<br/>rel: poPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo |
| `PoPh3.php` | 3 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterBySearch, FilterByMaKh, FilterByNgayCt<br/>rel: chiTiets:hasMany, chiPhis:hasMany, nhaCungCap:belongsTo |
| `SiDmCt.php` | 2 | 0 | 0 | 0 | 2 | - | `keep_simba` | scope: Voucher, MenuId<br/>meth: headerFieldsForInventory, detailFieldsForInventory |
| `SoCt1.php` | 7 | 7 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByMaVt, FilterByMaKho, FilterByMaKh, FilterByMaNvkd, FilterByMaBp...<br/>rel: soPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo, inDmViTri:belongsTo, inDmLo:belongsTo |
| `SoPh3.php` | 1 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByNgayCt |
| `SysCompany.php` | 0 | 3 | 0 | 0 | 1 | - | `move_catalog` | rel: userRights:hasMany, resx:hasMany, users:belongsToMany<br/>meth: resxByLanguage |
| `SysCompanyResx.php` | 0 | 2 | 0 | 0 | 0 | - | `keep_simba` | rel: language:belongsTo, company:belongsTo |
| `SysDictionaryInfo.php` | 2 | 0 | 0 | 0 | 2 | - | `keep_simba` | scope: CodeName, MenuId<br/>meth: primaryKeyFields, carryFields |
| `SysLanguage.php` | 2 | 2 | 0 | 0 | 0 | - | `keep_simba` | scope: IsEnable, Current<br/>rel: resx:hasMany, companies:belongsToMany |
| `SysMenu.php` | 0 | 0 | 0 | 0 | 8 | - | `keep_simba` | meth: getDisplayName, getParentMenuId, isRoot, isGroup, isVoucher, isMasterData |
| `SysUserCompanyRight.php` | 0 | 2 | 0 | 0 | 0 | - | `keep_simba` | rel: user:belongsTo, company:belongsTo |
| `SysUserInfo.php` | 3 | 2 | 0 | 0 | 0 | - | `keep_simba` | scope: IsEnable, IsAdmin, IsGrand<br/>rel: companyRights:hasMany, companies:belongsToMany |

### 3.3. Tổng hợp classification

| Classification | Count |
|----------------|-------|
| `keep_simba` | 24 |
| `move_catalog` | 4 |

### 3.4. `move_catalog` (đã tách sang laravel-catalog trong Phase 3)

- `ArDmKh.php` — accessors: IsKhachHang, IsNhaCungCap, IsNhanVien.
- `InDmKho.php` — methods: getInventoryByProduct, getInventoryList, getInventoryValue.
- `PoCt1.php` — method: getReceiptRate (audit gốc chỉ phát hiện 1 method, Phase 3 mở rộng ra 6 method + 1 SP report).
- `SysCompany.php` — method: resxByLanguage.

`SoCt1.php` bị bỏ sót trong audit gốc, phát hiện trong Phase 4 khi viết test gate: 6 business/report method đã tách sang `HasSoCt1SalesMetrics` ở #223.

### 3.5. Cách tái tạo audit

```bash
php scripts/audit-model-layer-responsibility.php          # bảng tóm tắt Simba Models
php scripts/audit-model-layer-responsibility.php --json   # JSON đầy đủ Simba
php scripts/audit-model-layer-responsibility.php --filter=ApCt1
php scripts/audit-catalog-model-layer.php                 # bảng tóm tắt Catalog Models (PR #225)
php scripts/audit-catalog-model-layer.php --json          # JSON đầy đủ Catalog
php scripts/audit-catalog-model-layer.php --filter=Ar
```

---

## 4. Phase 0 — Composite PK + alias + trait (PR #217)

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

### 4.1. Quy tắc primary key (đã chốt và đang áp dụng)

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

---

## 5. Phase 1 — Deduplicate schema 4 model metadata (PR #218)

PR: https://github.com/diepxuan/portal/pull/218
Merge commit: `fa0e44ebe8`

Mục tiêu: 4 model trong `laravel-simba/src/Models` còn tự khai báo schema thay vì extend SModel generated. Refactor để chỉ SModel chứa schema.

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
  - Đã đối chiếu `simba-docs/tables/sysReportInfo.md`; lấy theo SModel generated (nguồn sinh từ docs).
- `SiDmCt`:
  - Model cũ cast `VoucherGetWhenOpenForm` là `boolean`.
  - SModel generated cast là `integer`.
  - Đã đối chiếu `simba-docs/tables/SiDmCt.md`; xác nhận theo SModel generated.

Hướng xử lý đã chốt:

1. Refactor 4 Model để chỉ extend SModel generated, không khai báo lại schema.
2. Sử dụng `HasSimbaCompositeKey` trait cho các Model có composite PK.
3. Behavior hiện có giữ nguyên trong Model.
4. Các sai lệch casts đã được xác minh từ docs; ghi đè trong Model bằng cách bỏ cast sai, có comment giải thích nguồn từ docs.

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

---

## 6. Phase 2 — Audit behavior baseline (PR #219)

PR: https://github.com/diepxuan/portal/pull/219
Merge commit: `6ce2931a08` — merged lúc `2026-06-22T02:07:01Z`

Mục tiêu: phân loại behavior hiện có trong `diepxuan/laravel-simba/src/Models` để biết cần giữ ở Simba hay tách sang laravel-catalog.

Deliverables:

- `scripts/audit-model-layer-responsibility.php` — script PHP thuần, không cần composer, parse file Models và phân loại:
  - `keep_simba`: scope filter Simba-Simba, relation Simba-Simba, accessor parse enum/display từ field schema, method kiểu `isXxx()/getXxx()` đọc field trực tiếp.
  - `move_catalog`: business logic (tính toán, mở service), ngữ nghĩa nghiệp vụ (KH/NCC/NV).
  - Hỗ trợ `--json` và `--filter=Substring`.
- Bảng audit baseline 28 file (lưu trong section 3 của doc này).

Kết quả:

- 445 Model files; 28 có behavior.
- 24 `keep_simba`.
- 4 `move_catalog` (theo audit Phase 2):
  - `ArDmKh`: accessor `IsKhachHang`, `IsNhaCungCap`, `IsNhanVien`.
  - `InDmKho`: methods `getInventoryByProduct`, `getInventoryList`, `getInventoryValue`.
  - `PoCt1`: method `getReceiptRate`.
  - `SysCompany`: method `resxByLanguage`.
- Sau Phase 3, phát hiện thêm 1 cụm bị bỏ sót:
  - `SoCt1`: 3 accessor + 4 report method (chuyển trong #223).

---

## 7. Phase 3 — Tách behavior sang Catalog (PR #220, #222, #223)

Mục tiêu: tách các method `move_catalog` (từ Phase 2 audit) ra khỏi Simba Models sang laravel-catalog.

Quyết định: mỗi nhóm một concern riêng ở `diepxuan/laravel-catalog/src/Models/Concerns/`, gắn vào Catalog Model tương ứng.

### 7.1. Phase 3a: Cụm ArDmKh (PR #220)

PR: https://github.com/diepxuan/portal/pull/220
Merge commit: `6ce2931a08` (cùng base) — merged

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

### 7.2. Phase 3b: Cụm InDmKho + PoCt1 + SysCompany (PR #222)

PR: https://github.com/diepxuan/portal/pull/222
Merge commit: `84cf00213` — merged lúc `2026-06-22T03:38:36Z`

3 concern mới + 1 model mới:

- `HasInDmKhoInventoryOperations` (3 method):
  - `getInventoryByProduct`
  - `getInventoryList`
  - `getInventoryValue`
- `HasPoCt1PurchaseMetrics` (7 method + 1 helper):
  - `getTotalPurchaseByProduct`
  - `getTotalQuantityByProduct`
  - `getTotalPurchaseBySupplier`
  - `getReceiptRate`
  - `getPORptMH01`
  - `getPORptDH01`
  - `getPORptNH01`
  - `executeRptSp` (helper dùng chung cho 3 SP report)
- `HasSysCompanyLocalizedResx` (1 method):
  - `resxByLanguage`
- `Catalog\Models\PoCt1` (tạo mới, dùng `HasPoCt1PurchaseMetrics`).

Simba gỡ:

- `Simba\InDmKho.php`: -69 dòng, gỡ 3 method inventory.
- `Simba\PoCt1.php`: -130 dòng, gỡ 7 method report/metrics.
- `Simba\SysCompany.php`: -7 dòng, gỡ `resxByLanguage`.

Catalog gắn:

- `Catalog\InDmKho.php`: thêm `use HasInDmKhoInventoryOperations;`.
- `Catalog\PoCt1.php`: tạo mới, dùng `HasPoCt1PurchaseMetrics`.
- `Catalog\SysCompany.php`: thêm `use HasSysCompanyLocalizedResx;`.

Verify:

- `php -l`: 9/9 file pass.
- `git diff --check`: pass.
- Reflection:
  - `Simba\InDmKho`: `getInventoryByProduct`=0, `getAsINGetDMKHO`=1.
  - `Simba\PoCt1`: `getReceiptRate`=0, `getPORptMH01`=0, `getTotalPurchaseByProduct`=0.
  - `Simba\SysCompany`: `resxByLanguage`=0, `resx`=1, `users`=1.
  - `Catalog\InDmKho`: `getInventoryByProduct`=1, `getAsINGetDMKHO`=1 (inherited).
  - `Catalog\PoCt1`: `getReceiptRate`=1, `getPORptMH01`=1, `getTotalPurchaseByProduct`=1.
  - `Catalog\SysCompany`: `resxByLanguage`=1, `resx`=1 (inherited), `users`=1 (inherited).
- Caller ngoài audit:
  - `getInventory*`, `getReceiptRate`, `getPORpt*`, `getTotal*`, `resxByLanguage`: không có caller bên ngoài.
  - `getAsINGetDMKHO`: chỉ `Catalog\InDmKho` gọi qua `parent::` (vẫn còn trên Simba base), không cần sửa.
  - `getAsINRptCD01`, `getPORpt*`: không có caller bên ngoài (giữ trên Simba base, đề phòng tương lai).

CI: 14/14 pass, mergeable, mergeStateStatus CLEAN.

### 7.3. Phase 3c: Cụm SoCt1 + fix `ArDmKh::booted` (PR #223)

PR: https://github.com/diepxuan/portal/pull/223
Merge commit: `e1d771907` — merged lúc `2026-06-22T04:59:35Z`

Phát hiện khi viết test gate:

- `Catalog\Models\ArDmKh::booted()` đang gọi `parent::boot()` không cần thiết; SModel base đã set connection trong `__construct`. → gỡ.
- `Simba\Models\SoCt1` còn 7 business/report method bị bỏ sót ở Phase 2:
  - `getTotalRevenueByProduct`
  - `getTotalQuantityByProduct`
  - `getTotalRevenueBySalesperson`
  - `getSORptBH01`
  - `getSORptDT01`
  - `getSORptSL01`
  - (3 method bổ sung ngoài audit gốc 1 method `getReceiptRate` đã move ở #222)

Xử lý:

- Tạo `Diepxuan\Catalog\Models\Concerns\HasSoCt1SalesMetrics` (6 method + 1 helper `executeSORptSp`).
- Tạo `Diepxuan\Catalog\Models\SoCt1` (tương tự PoCt1, extends Simba + dùng trait).
- Gỡ 7 method trên khỏi `Simba\Models\SoCt1`. Chỉ giữ scope filter + relation Simba-Simba.
- Gỡ `parent::boot()` trong `Catalog\Models\ArDmKh::booted()`.

Verify:

- `php -l`: 5/5 pass.
- Reflection: `Catalog\SoCt1` parent=`Simba\SoCt1`, có `getTotalRevenueByProduct=1`, `getSORptBH01=1`, v.v.
- 7 test gate pass (PR #223 lúc đó có 7 method; PR #225 thêm test 8 nâng lên 8 method, 10 assertion).

CI: 14/14 pass, mergeable, mergeStateStatus CLEAN.

### 7.4. Tổng kết Catalog Concerns

| Concern | Owner Model | Method |
|---------|-------------|--------|
| `HasArDmKhCategories` | `Catalog\Models\ArDmKh` | 3 scope + 3 accessor |
| `HasInDmKhoInventoryOperations` | `Catalog\Models\InDmKho` | 3 method |
| `HasPoCt1PurchaseMetrics` | `Catalog\Models\PoCt1` | 7 method + 1 helper |
| `HasSoCt1SalesMetrics` | `Catalog\Models\SoCt1` | 6 method + 1 helper |
| `HasSysCompanyLocalizedResx` | `Catalog\Models\SysCompany` | 1 method |

---

## 8. Phase 4 — Test gate 8 method (PR #223, #225)

File mới: `tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php`.

- PR #223 thêm 7 test method, 9 assertion.
- PR #225 thêm test 8 (`testCatalogModelsDoNotExtendSModelDirectly`) + 1 assertion = 8 test, 10 assertion.

8 test method:

1. `testSModelGeneratedClassesHaveNoBehavior` — quét SModel generated, đảm bảo không có scope/relation/accessor/mutator/business method.
2. `testSModelClassesDoNotCallParentBoot` — đảm bảo SModel generated không gọi `parent::boot()`.
3. `testSimbaModelsDoNotExposeBusinessMethods` — kiểm tra business method đã move sang Catalog không còn trên `Simba\Models`.
4. `testSimbaModelsBootedDoesNotCallParentBoot` — đảm bảo `booted()` trong Simba Models không gọi `parent::boot()`.
5. `testCatalogModelsDoNotRedefineDbMetadata` — đảm bảo Catalog Models không khai báo DB metadata trực tiếp, trừ whitelist có lý do.
6. `testCatalogModelsBootedDoesNotCallParentBoot` — đảm bảo Catalog Models không gọi `parent::boot()` trong `booted()`.
7. `testCatalogModelsExtendSimbaModel` — kiểm tra parent class hợp lệ (Simba Models hoặc whitelist alias/utility).
8. `testCatalogModelsDoNotExtendSModelDirectly` (PR #225) — đảm bảo Catalog Models không extend trực tiếp `Diepxuan\Simba\SModel\*`.

Phát hiện/fix khi viết test:

- `Catalog\Models\ArDmKh::booted()` gọi `parent::boot()` không cần thiết → đã gỡ.
- `Simba\Models\SoCt1` còn business/report methods bị bỏ sót ở Phase 2 → tạo `Catalog\Models\Concerns\HasSoCt1SalesMetrics` + `Catalog\Models\SoCt1`, gỡ method khỏi `Simba\Models\SoCt1`.

Whitelist hiện tại: xem section 1.4.

Ghi chú (cập nhật từ PR #225): `CaCt2`, `CaPh2`, `CaPh3` trước đây tạm whitelist vì Catalog extend trực tiếp SModel; hiện đã chuyển sang `Diepxuan\Simba\Models\CaCt2/CaPh2/CaPh3`, không còn nằm trong whitelist.

Verify:

```bash
php -l tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php
vendor/bin/phpunit tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php
```

Kết quả hiện tại: 8 tests, 10 assertions, OK.

Full `vendor/bin/phpunit` hiện còn lỗi pre-existing (`Core\PackageConfigTest` currency config, `Feature\ExampleTest` redirect 302, 31 errors khác) không liên quan các PR này.

## 9. Phase 4b — Cleanup còn lại + audit Catalog + CI gate (PR #225)

PR: https://github.com/diepxuan/portal/pull/225
Merge commit: `36478d777` — merged lúc `2026-06-22T12:44:38Z`

### Trạng thái Phase 4b

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

## 10. Phase 5 — Doc policy 3 lớp (PR #224)

PR: https://github.com/diepxuan/portal/pull/224
Merge commit: `ccaa2befa` — merged lúc `2026-06-22T11:04:06Z`

Nội dung PR gốc tạo `docs/project/model-layer-responsibility.md` (147 dòng) — tóm tắt policy 3 lớp, whitelist, quy trình thêm behavior, review checklist, công cụ kiểm tra tự động.

> Từ PR kế tiếp sau doc này, file `model-layer-responsibility.md` đã được gộp vào plan này (section 1). Doc hiện tại là nguồn tham chiếu duy nhất cho model layer refactor.

---

## 11. Hiện trạng audit ban đầu (lưu trước refactor)

> Phần này mô tả hiện trạng trước khi refactor để tham chiếu.

### 11.1. Hiện trạng `diepxuan/laravel-simba/src/SModel`

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

### 11.2. Hiện trạng `diepxuan/laravel-simba/src/Models`

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

### 11.3. Hiện trạng `diepxuan/laravel-catalog/src/Models`

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

## 12. Ranh giới trách nhiệm (final)

> Tóm tắt khả thi thi hành ở section 1.

### 12.1. `laravel-simba/src/SModel`: Base DB schema/config only

**Được phép chứa:**

- Connection: `$connection`, `getSimbaConnectionName()` hoặc cơ chế tương đương.
- Table metadata: `$table`, `$primaryKey`, `$keyType`, `$incrementing`, `$timestamps`.
- Eloquent metadata: `$fillable` hoặc `$guarded`, `$casts`, date format nếu SQL Server cần.
- Base helpers an toàn, không nghiệp vụ: normalize table name fallback, SQL Server connection resolver.

**Không nên chứa:**

- Scope nghiệp vụ.
- Accessor/mutator mang ý nghĩa nghiệp vụ.
- Relations.
- Stored procedure wrapper theo nghiệp vụ.
- Override `save/delete/all/query` nếu không có lý do bắt buộc và test bảo vệ.

### 12.2. `laravel-simba/src/Models`: Direct Laravel model for Simba tables

**Được phép chứa:**

- Scope bám trực tiếp vào field Simba:
  - `scopeActive()`/`scopeDangSuDung()` cho `ksd` nếu field có thật.
  - `scopeCompany($maCty)` cho `ma_cty`.
  - `scopeSupplier()` cho `isncc`, `scopeCustomer()` cho `iskh`, nếu là semantic field trực tiếp.
- Accessor/cast normalize field:
  - boolean flag từ SQL Server bit/int.
  - tên accessor alias giúp code PHP đọc rõ hơn.
- Relations trực tiếp giữa bảng Simba nếu key có thật và ổn định.
- Query helper thuần dữ liệu, không UI/use-case.
- Wrapper SP thuần param mapping đơn giản (giữ hạn chế; ưu tiên catalog).

**Không nên chứa:**

- Logic chỉ phục vụ Catalog UI.
- Điều hướng route, Livewire, request/session/auth.
- Business policy của Portal như `hasTransactions()` nếu dùng để quyết định UI/action trong Catalog.
- Stored procedure orchestration phức tạp; ưu tiên để ở `StoredProcedures` hoặc service/domain layer.

### 12.3. `laravel-catalog/src/Models`: Portal/Catalog domain model

**Được phép chứa:**

- Relations phục vụ module Portal/Catalog.
- Helper tính toán nghiệp vụ cho màn hình, ví dụ `hasTransactions()`, `getSoduKh()` nếu là API tiện ích cho Catalog, computed status/display helpers.
- Scopes theo use-case Portal, ví dụ danh sách mặc định, filter UI.
- Business method: `getInventoryByProduct`, `getTotalPurchaseByProduct`, `getReceiptRate`, `resxByLanguage`, v.v.
- Report method (chạy SP báo cáo): `getSORpt*`, `getPORpt*`.
- Custom cast class ở `$casts` (ví dụ `CategoryMagento` cho `InDmNhvt`).
- Global scope nghiệp vụ (ví dụ `orderByMaKh` ở `ArDmKh`).
- Bridge giữa Simba raw data và Portal module.

**Không nên chứa:**

- Khai báo lại `$table`, `$primaryKey`, `$connection`, `$casts` nếu lớp cha Simba đã có (trừ whitelist alias).
- Logic SQL Server connection.
- Stored procedure low-level call nếu đã có wrapper/service.

---

## 13. Nguyên tắc refactor

1. Không đổi tên bảng/cột/SP nếu chưa đối chiếu `simba-docs` hoặc source wrapper hiện có.
2. Không tạo/ALTER/INSERT SQL.
3. Mỗi model refactor phải có test hành vi trước khi sửa.
4. Không sửa 455 generated SModel bằng tay từng file nếu có thể dùng generator/rule tự động.
5. Không xóa compatibility alias khi chưa `git grep` hết usage.
6. Không thay global scope production trong một PR lớn; phải tách từng nhóm model có test.
7. Mọi thay đổi route/UI đang dùng model phải smoke lại màn hình liên quan.

---

## 14. Validation checklist + Definition of Done

### 14.1. Validation checklist chung

Chạy trước khi báo xong mỗi PR model layer:

```bash
php -l scripts/audit-model-layer-responsibility.php
php scripts/audit-model-layer-responsibility.php
vendor/bin/phpunit tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php
git diff --check
git status --short
```

Nếu refactor model cụ thể, thêm:

```bash
php -l <changed-model.php>
vendor/bin/phpunit <new-or-related-test.php>
git grep -n "<moved-method-or-class>" diepxuan
```

### 14.2. Definition of Done

- [x] Có tài liệu policy rõ ràng cho 3 lớp model (section 1 của doc này).
- [x] Có audit script chạy được và tái lập được baseline cho cả Simba (`scripts/audit-model-layer-responsibility.php`) và Catalog (`scripts/audit-catalog-model-layer.php`).
- [x] Có test gate 8 method (`SimbaModelLayerResponsibilityTest`, 10 assertion).
- [x] Không còn logic nghiệp vụ trong `SModel` ngoài DB config/schema.
- [x] `Simba\Models` giữ direct table behavior, không phụ thuộc Portal UI/route/auth.
- [x] `Catalog\Models` giữ domain/helper/relation phục vụ Portal, không khai báo DB config trùng base.
- [x] Các model trọng yếu ARDMKH, SysMenu/Zsysmenu, SoCt1 có test bảo vệ.
- [x] Không làm đổi route/source metadata ngoài expected.
- [x] Không push/merge khi chưa có lệnh của Sếp.
- [x] Audit script đã gắn vào CI gate `.github/workflows/tests.yml` (chạy tự động trong PR).

### 14.3. Còn lại (chưa xong)

- [x] Audit bổ sung catalog layer `diepxuan/laravel-catalog/src/Models` — đã có `scripts/audit-catalog-model-layer.php` với 4 classification: `concern_business`, `inline_business`, `catalog_utility`, `passthrough`. Output hiện tại: 35 file, 12 có behavior (5 concern_business, 7 catalog_utility).
- [x] Refactor `CaCt2`/`CaPh2`/`CaPh3` từ extend SModel sang có Simba Model riêng (gỡ TODO khỏi whitelist test) — 3 Catalog Model đã chuyển sang `extends Diepxuan\Simba\Models\CaCt2/CaPh2/CaPh3`; test gate 8 method pass.
- [x] Tích hợp audit script vào CI gate — `tests.yml` chạy `audit-model-layer-responsibility.php` + `audit-catalog-model-layer.php` trước khi phpunit.
- [x] Rà soát Gl* và Ap* theo Task 8 — tất cả `GlCt`, `GlCt1`, `GlCdTk`, `GlDmTk`, `ApCt1` chỉ có scope filter + Simba-Simba relation, không có business method, đều `keep_simba` đúng policy. PR #227.
- [ ] Fix pre-existing CI failures: `Core\PackageConfigTest` currency config, `Feature\ExampleTest` redirect 302, 31 errors khác. Đây là tech debt ngoài scope refactor model layer; cần PR riêng sau khi điều tra root cause (DB config, env, hoặc test cũ).

### 14.4. Implementation tasks (lịch sử)

| Task | Trạng thái | PR |
|------|------------|-----|
| 1. Chốt policy bằng docs | DONE | #224 |
| 2. Tạo audit script cho model layer (Simba) | DONE | #219 |
| 2b. Tạo audit script cho Catalog layer | DONE | #225 |
| 3. Thêm baseline audit report | DONE | #219 |
| 4-6. ARDMKH boundary cleanup | DONE | #220 |
| 7. Chuẩn hóa SysMenu/Zsysmenu model boundaries | DONE | #217 |
| 8. Chuẩn hóa GL/PO/CA theo pattern đã chốt | DONE | #222 (PoCt1), #217 (Ca* Simba Models), #227 (audit kết luận Gl* & Ap* chỉ scope/relation, đều `keep_simba`) |
| 9. Thêm CI non-blocking trước, strict sau | DONE | #225 — audit script gắn vào `.github/workflows/tests.yml` chạy trước phpunit; phpunit chạy 8 test pass; full phpunit còn pre-existing fail (ngoài scope). |

### 14.5. PR split (lịch sử)

| PR | Phase | Tóm tắt |
|----|-------|---------|
| #217 | 0 | Composite PK + alias + trait `HasSimbaCompositeKey` |
| #218 | 1 | Deduplicate schema 4 model metadata |
| #219 | 2 | Audit script + baseline doc |
| #220 | 3a | Move ArDmKh KH/NCC/NV sang Catalog concern |
| #222 | 3b | Move InDmKho + PoCt1 + SysCompany sang Catalog concern + tạo `Catalog\PoCt1` |
| #223 | 3c + 4 | Move SoCt1 sang Catalog concern + 7 test gate + fix `ArDmKh::booted` |
| #224 | 5 | Doc policy 3 lớp (gộp vào plan section 1) |
| #225 | 4b | Cleanup CaCt2/CaPh2/CaPh3 + audit Catalog + CI gate + test gate 8 method |

---

## Tài liệu liên quan

- `simba-router-menu-matrix.md` — plan riêng về menu/route, không thuộc doc này.
- `diepxuan/laravel-simba/src/SModel/README.md` — raw/table schema layer.
- `diepxuan/laravel-simba/src/Models/README.md` — model layer extend từ SModel.
- `diepxuan/laravel-catalog/src/Models/Concerns/` — 5 concern nghiệp vụ (HasArDmKhCategories, HasInDmKhoInventoryOperations, HasPoCt1PurchaseMetrics, HasSoCt1SalesMetrics, HasSysCompanyLocalizedResx).
- `simba-docs/tables/` — schema Simba là nguồn sự thật.
- `scripts/audit-model-layer-responsibility.php` — audit Simba Models (445 file, 28 behavior).
- `scripts/audit-catalog-model-layer.php` — audit Catalog Models (35 file, 12 behavior).
- `tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php` — test gate 8 method, 10 assertion.
- `.github/workflows/tests.yml` — CI gate chạy 2 audit script trước phpunit.
