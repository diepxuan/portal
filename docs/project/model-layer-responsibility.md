# Simba Model Layer Responsibility

Doc chốt policy cho 3 lớp model trong hệ thống. Đây là bản tóm tắt khả thi thi hành; tham chiếu đầy đủ ở `simba-model-layer-refactor-plan.md`.

## 1. Mục tiêu

- Schema Simba là nguồn sự thật duy nhất (`simba-docs/tables`).
- 3 lớp có trách nhiệm tách biệt, không xâm phạm lẫn nhau.
- Có thể thay thế / nâng cấp từng lớp mà không phá lớp khác.

## 2. 3 lớp và quy tắc

### 2.1. `SModel` (`Diepxuan\Simba\SModel\*`)

Vai trò: ánh xạ schema Simba sang Eloquent. Không có business logic.

Allowed:

- Khai báo `$table`, `$connection`, `$primaryKey`, `$keyType`, `$incrementing`, `$timestamps`.
- Khai báo `$fillable`, `$guarded`, `$hidden`, `$casts`, `$attributes`.
- Hằng số `PRIMARY_KEY_COLUMNS` cho composite PK.
- Method helper dbo hợp lệ (set connection theo cty, transaction begin/commit/rollback).
- Scope Simba-level: `scopeIsEnable`, filter theo field Simba.
- Global scope `onlyFirstCompany` ở `SModel` base.
- Relation Simba-Simba (theo key thật).

Not allowed:

- Scope, relation, accessor, mutator theo ngữ nghĩa nghiệp vụ (ví dụ: `scopeLaKhachHang`, `getIsXxxAttribute`).
- Method business (tính tổng, gọi SP báo cáo, nghiệp vụ KH/NCC/NV).
- Khai báo behavior cụm (inventory, sales, purchase) trên bảng gốc.

### 2.2. `Simba\Models` (`Diepxuan\Simba\Models\*`)

Vai trò: lớp 2, bọc SModel + helper nghiệp vụ dữ liệu thuần Simba.

Allowed:

- Extend SModel tương ứng.
- Dùng trait `HasSimbaCompositeKey` cho bảng composite PK.
- Scope filter theo field Simba (`scopeFilterByMaCty`, `scopeFilterByMaVt`, `scopeFilterByMaKho`, `scopeFilterByMaKh`, `scopeFilterByMaNvkd`, `scopeFilterByMaBp`, `scopeFilterByNgayCt`, `scopeSearch`, `scopeOrderByMaKh`, v.v.).
- Relation Simba-Simba (`belongsTo`, `hasMany`).
- Wrapper gọi stored procedure đơn giản (mapping param) — chỉ khi bản thân SP không phải logic nghiệp vụ phức tạp, ví dụ `getAsINGetDMKHO`, `getAsINRptCD01`. Hạn chế; ưu tiên catalog.
- Accessor/mutator chuẩn hóa dữ liệu thuần Simba.
- Global scope khi cần (ví dụ `ksd` lọc soft-deleted).

Not allowed:

- Business method (tính tổng doanh thu, số lượng, nghiệp vụ KH/NCC/NV, công thức tính giá, tỉ lệ nhập, v.v.).
- Report method (các `getSORpt*`, `getPORpt*`, `getINRpt*`).
- Gọi `parent::boot()` trong `booted()` (SModel base đã set connection trong `__construct`).
- Khi gỡ behavior phải đảm bảo caller chuyển sang Catalog.

### 2.3. `Catalog\Models` (`Diepxuan\Catalog\Models\*`)

Vai trò: lớp 3, business logic phục vụ Portal/Catalog UI.

Allowed:

- Extend `Simba\Models\*` (mặc định).
- Concern `HasArDmKhCategories`, `HasInDmKhoInventoryOperations`, `HasPoCt1PurchaseMetrics`, `HasSoCt1SalesMetrics`, `HasSysCompanyLocalizedResx` — khi cần business logic cụm.
- Scope nghiệp vụ (`scopeLaKhachHang`, `scopeLaNhaCungCap`).
- Accessor nghiệp vụ (`getIsKhachHangAttribute`, `getIsNhaCungCapAttribute`).
- Method business: `getInventoryByProduct`, `getInventoryList`, `getInventoryValue`, `getTotalPurchaseByProduct`, `getReceiptRate`, `resxByLanguage`.
- Method report (chạy SP báo cáo): `getSORpt*`, `getPORpt*`.
- Custom cast class ở `$casts` (ví dụ `CategoryMagento` cho `InDmNhvt`).
- Global scope nghiệp vụ (ví dụ `orderByMaKh` ở `ArDmKh`).

Not allowed:

- Khai báo `$table`/`$connection`/`$primaryKey` trực tiếp (đã có SModel), trừ alias subclass đặc biệt (`Zsysmenu` cùng schema SysMenu bảng khác).
- Gọi `parent::boot()` trong `booted()`.

## 3. Whitelist (Catalog Models được phép lệch rule)

| Model | Lý do |
|-------|-------|
| `Zsysmenu` | Alias table cùng schema SysMenu |
| `System`, `SystemConfig` | Catalog subclass alias |
| `User` | Extends `App\Models\User` (Laravel auth) |
| `UserLink` | Extends `AbstractModel`, utility link table |
| `Params` | Utility params model, không có SModel |
| `InDmNhvt` | Custom cast `CategoryMagento` ở catalog |
| `CaCt2`, `CaPh2`, `CaPh3` | Đang extend SModel trực tiếp, TODO tạo Simba\Model |

Khi thêm Catalog Model mới mà cần lệch rule, **phải thêm vào whitelist kèm comment lý do** trong:

- `SimbaModelLayerResponsibilityTest::$CATALOG_DB_METADATA_WHITELIST`
- `SimbaModelLayerResponsibilityTest::$CATALOG_EXTENDS_WHITELIST`

## 4. Quy trình thêm behavior mới

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

## 5. Review checklist

Khi review PR liên quan model layer:

- [ ] SModel generated không thêm scope/relation/method.
- [ ] Simba Models không thêm business method.
- [ ] Business method mới ở Catalog Models (hoặc concern).
- [ ] Catalog Models không khai báo DB metadata trùng SModel (trừ whitelist).
- [ ] `booted()` không gọi `parent::boot()` ở cả 3 lớp.
- [ ] Tên concern có pattern `Has<Model><Group>`.
- [ ] Chạy `vendor/bin/phpunit tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php`.
- [ ] Chạy `php scripts/audit-model-layer-responsibility.php` (nếu có audit liên quan).
- [ ] Cập nhật `docs/project/model-layer-audit-baseline.md` nếu thêm/bớt method.

## 6. Công cụ kiểm tra tự động

- **Test:** `tests/Unit/Packages/Simba/SimbaModelLayerResponsibilityTest.php` (7 test).
- **Audit script:** `scripts/audit-model-layer-responsibility.php` (Phase 1 PR #219).
- **Test chạy trong:** `.github/workflows/tests.yml` (root phpunit).

## 7. Tài liệu liên quan

- `simba-model-layer-refactor-plan.md` — plan đầy đủ, bao gồm audit baseline, Phase 1/2/3/4, validation checklist.
- `model-layer-audit-baseline.md` — bảng 28 file có behavior ở Simba Models sau Phase 1.
- `README.md` (root repo) — tham chiếu portal tổng quan.
- `simba-docs/tables/` — schema Simba là nguồn sự thật.

## 8. Lịch sử refactor

| PR | Phase | Nội dung |
|----|-------|---------|
| #217 | Phase 0 | Composite PK chuẩn hóa + alias Models + trait `HasSimbaCompositeKey` |
| #218 | Phase 0 | Deduplicate schema 4 model metadata |
| #219 | Phase 1 | Audit baseline 28 file behavior |
| #220 | Phase 2 cụm 1 | Move ArDmKh KH/NCC/NV → `HasArDmKhCategories` |
| #222 | Phase 2 cụm 2-4 | Move InDmKho/PoCt1/SysCompany → 3 concern + Catalog\Models\SoCt1 + gỡ `ArDmKh::booted()` |
| #223 | Phase 2 cụm 5 | Move SoCt1 → `HasSoCt1SalesMetrics` + 7 test gate |
