# Task 372: Fix SimbaMenuRouteMetadata route suffix — deterministic group-based

## Nhóm

Catalog service (Livewire shell routing) / cross-module bug

## Mục tiêu

Sửa bug trong `SimbaMenuRouteMetadata::routeNameFor()`: route name cho menu trùng slug phụ thuộc thứ tự lặp của `SimbaMenuRepository::activeMenus()`. Cụ thể, cặp menu PO 10.30.11 và 10.30.23 cùng `dllName = "ARRptBCCN01"`, trước fix:

- 10.30.11 (vào trước vì `stt=244` tie, fallback menuid sort) → `po.rpt.arrptbccn01` (không suffix)
- 10.30.23 → `po.rpt.arrptbccn01103023` (suffix)

Kết quả: cột `Route` trong SimbaErpMenus view hiển thị `po.rpt.arrptbccn01` cho 10.30.11, không khớp với tên route thật đã đăng ký trong `routes/web.php` (`po.rpt.arrptbccn01103011`). URL `/simba/po/rpt/arrptbccn01` không resolve tới component `PoArrptbccn01::class`.

## Trạng thái hiện tại

- **Status:** DONE — branch `fix/372-simba-menu-route-suffix-deterministic`
- **Ngày tạo:** 2026-07-25
- **Người tạo:** Bot (Portal Agent)
- **Phạm vi:** PO 10.30.11, SO 06.30.14 (apply đồng nhất theo task 358)

## Source of truth từ Simba

### sysMenu (PO — đã có PR #264)

| MenuID | Module | Tiêu đề | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `10.30.11` | PO | Sổ chi tiết công nợ một nhà cung cấp | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |
| `10.30.23` | PO | Sổ chi tiết công nợ một nhà cung cấp — có số lượng | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |

### sysMenu (SO — bị ảnh hưởng bởi fix)

| MenuID | Module | Tiêu đề | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `06.30.14` | SO | Sổ chi tiết công nợ một khách hàng | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |
| `06.30.38` | SO | Sổ chi tiết công nợ một khách hàng — có số lượng | `ARRptBCCN01` | `AsiaErp.UserInterface.frmARRptBCCN01` | `1` |

## Nguyên nhân

`routeNameFor()` quyết định gắn suffix `menuIdSuffix(menuuid)` dựa trên việc tên base đã tồn tại trong mảng `$existing` hay chưa. Đây là **stateful** theo thứ tự insert:

```php
$route = "{$module}.{$kind}.{$slug}";
if (!isset($existing[$route])) {
    return $route;                          // base, không suffix
}
return "{$route}{$this->menuIdSuffix(...)}"; // suffix
```

Vì `activeMenus()` sort theo `stt ?: menuid`, menu có menuid nhỏ hơn vào trước → giữ base name. Menu sau bị thêm suffix.

## Phương án fix

2-pass deterministic trong `routes()`:

1. **Pass 1:** quét toàn bộ active leaf menus, với mỗi menu tính base name (`{module}.{kind}.{slug}`) qua helper `baseRouteName()`. Đếm số menu rơi vào cùng group.
2. **Pass 2:** build route map. Nếu group size ≥ 2 → tất cả menu trong group đều lấy `base + menuIdSuffix(menuuid)`. Nếu group size = 1 → giữ base không suffix.

Helper `routeNameFor()` cũ bị xoá; logic chuyển vào `routes()`.

## Routes cập nhật

| Module | MenuID | Trước fix | Sau fix | Component |
|--------|--------|-----------|---------|-----------|
| PO | 10.30.11 | `po.rpt.arrptbccn01` (sai) | `po.rpt.arrptbccn01103011` | `Po\Rpt\Arrptbccn01` |
| PO | 10.30.23 | `po.rpt.arrptbccn01103023` | `po.rpt.arrptbccn01103023` (giữ) | `Po\Rpt\Arrptbccn01Sl` |
| SO | 06.30.14 | `so.rpt.arrptbccn01` | `so.rpt.arrptbccn01063014` (route mới thêm) | `So\Rpt\Arrptbccn01` |
| SO | 06.30.38 | `so.rpt.arrptbccn01063038` | `so.rpt.arrptbccn01063038` (giữ) | `So\Rpt\Arrptbccn01Sl` |

Backward-compat: route cũ `so.rpt.arrptbccn01` (line 285) giữ nguyên, alias `so.rpt.arrptbccn01063014` được thêm với cùng component `So\Rpt\Arrptbccn01::class`.

## Files thay đổi

- `diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php` — refactor `routes()` thành 2-pass; thêm `baseRouteName()`; xoá `routeNameFor()` cũ.
- `diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php` — update `testRouteNameSuffixAppendsCompactMenuId`; thêm `testRouteNameSuffixDeterministicRegardlessOfInputOrder` + `testRouteNameKeepsBaseWhenSingleMenuPerGroup`.
- `diepxuan/laravel-catalog/routes/web.php` — thêm line mới cho `so/rpt/arrptbccn01063014` ngay sau line `so/rpt/arrptbccn01`.
- `diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php` — thêm expectation cho `so.rpt.arrptbccn01063014`.
- `docs/tasks/371-...` — update status `PENDING` → `DONE — merged PR #264`.

## Verify

- `php -l` 4 file modified pass.
- `vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php --exclude-filter testShellSourceRoutesAreNotRegisteredAsConcreteComponentRoutes` → 18/18 pass, 251 assertions.
- Pre-existing fail `testShellSourceRoutesAreNotRegisteredAsConcreteComponentRoutes` không liên quan (route `povchpo3` đã đăng ký concrete ở line 256-258, fail ngay từ main baseline).
- `vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Http/Livewire/SimbaErpMenusViewTest.php` → 1/1 pass.
- `php artisan route:list --name=arrptbccn` → 5 routes hiển thị:
  - `po.rpt.arrptbccn01103011`
  - `po.rpt.arrptbccn01103023`
  - `so.rpt.arrptbccn01`
  - `so.rpt.arrptbccn01063014` (mới)
  - `so.rpt.arrptbccn01063038`

## Bài học

- Test cũ `testRouteNameSuffixAppendsCompactMenuId` không phát hiện bug vì input luôn đúng thứ tự làm menu đầu tiên rơi vào base. Test mới `testRouteNameSuffixDeterministicRegardlessOfInputOrder` chạy cả 2 hướng và so sánh set equality, không phụ thuộc thứ tự input.
- Quy ước đặt tên route có thể phụ thuộc state → cần 2-pass khi có quyết định dựa trên "đã có chưa" trong cùng một vòng lặp.
