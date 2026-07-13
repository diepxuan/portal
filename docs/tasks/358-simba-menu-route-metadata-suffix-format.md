# Task 358: SimbaMenuRouteMetadata — định dạng hậu tố routeName

## Trạng thái

DONE - 2026-07-13 (merged PR #246).

Task này chuẩn hoá cách `SimbaMenuRouteMetadata::routeNameFor()` sinh `routeName` cho các SysMenu có cùng `code_name`/`module` nhưng khác `menuid`, tránh trùng routeName khi slug cũ chỉ lặp lại code_name.

## Bối cảnh

Form SimbaERP được dùng chung cho nhiều menu (ví dụ `frmARRptBCCN01` dùng cho cả menu `10.30.11`, `10.30.23`, `10.30.14`). Trước đây `routeNameFor()` ghép `slug(menuid)` với dấu `-`:

| menuid | code_name | routeName (cũ) |
|---|---|---|
| `10.30.11` | `ARRptBCCN01` | `po.rpt.arrptbccn01-10-30-11` |
| `10.30.23` | `ARRptBCCN01` | `po.rpt.arrptbccn01-10-30-23` |

Hậu tố có dấu gạch ngang làm URL dài và dễ nhầm với slug phân cấp. Chuẩn hoá về dạng **compact** — chỉ nối các ký tự A-Z/0-9 của `menuid`, không thêm `-`.

## Mục tiêu

- `routeNameFor()` dùng helper `menuIdSuffix($menuid)` thay cho `"-".slug((string) $menu->menuid)`.
- `menuIdSuffix()` trả về chuỗi alnum nối liền từ `menuid`. Ví dụ: `"10.30.23"` → `"103023"`, `"10.30.11"` → `"103011"`.
- Mapping mới:

| menuid | code_name | routeName (mới) |
|---|---|---|
| `10.30.11` | `ARRptBCCN01` | `po.rpt.arrptbccn01103011` |
| `10.30.23` | `ARRptBCCN01` | `po.rpt.arrptbccn01103023` |

- URL mới: `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023`.

## Nguồn tài liệu phải đọc trước khi code

- `simba-docs/data/sysMenu.md` — danh sách `menuid` và `code_name` cần phân biệt.
- `simba-docs/data/sysReportInfo.md` — đối chiếu `report`/SP theo menuid.
- `diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php` — điểm sửa.
- `docs/project/simba-router-menu-matrix.md` — ma trận tham khảo (slug trong matrix mang tính tham khảo; slug thực tế trong route registry là dạng compact).

## Thay đổi chính

### `SimbaMenuRouteMetadata.php`

```diff
-        return "{$route}-{$this->slug((string) $menu->menuid)}";
+        return "{$route}{$this->menuIdSuffix((string) $menu->menuid)}";
```

```php
private function menuIdSuffix(string $menuid): string
{
    return preg_replace('/[^A-Za-z0-9]+/', '', $menuid) ?? '';
}
```

### `SimbaMenuRouteMetadataTest.php`

Thêm test `testRouteNameSuffixAppendsCompactMenuId` — dựng metadata với 2 menu `10.30.11` và `10.30.23`, cùng `code_name=ARRptBCCN01`, khẳng định `routeName` mới xuất hiện đúng và routeName cũ có dấu gạch ngang **không còn**.

## Kiểm chứng

- `php -l` pass cho `SimbaMenuRouteMetadata.php` và test file.
- phpunit `SimbaMenuRouteMetadataTest` — **9 tests / 20 assertions pass**.
- GitHub Actions: `Module / Test and Build laravel-catalog module` — SUCCESS.
- Codex review: 👍 không có suggestion blocker.

## Phạm vi / Không phạm vi

### Trong phạm vi
- Sửa helper sinh routeName trong `SimbaMenuRouteMetadata`.
- Thêm unit test pin behavior.
- Cập nhật MEMORY.md + `_index.md` + tạo file task 359 (draft AP BCCN01 SL) tham chiếu slug mới.

### Ngoài phạm vi
- Không sửa `diepxuan/laravel-catalog/routes/web.php` để mở route mới cho `ap.rpt.arrptbccn01103023` (task 359 sẽ xử lý khi Sếp yêu cầu).
- Không sửa ma trận `simba-router-menu-matrix.md` trong task này; slug trong matrix vẫn là tham khảo.
- Không tạo bảng/SP/field mới.

## Liên kết

- PR: https://github.com/diepxuan/portal/pull/246
- Commit: `8cdda4298` (squash vào `e3371acc8` trên main).
- Task kế tiếp tham chiếu: `docs/tasks/359-ap-so-chi-tiet-cong-no-mot-nha-cung-cap-10-30-23.md`.

## Ghi chú kỹ thuật

- Helper chỉ dùng `preg_replace('/[^A-Za-z0-9]+/', '', $menuid)` — đơn giản, idempotent, không phụ thuộc locale.
- Có thể mở rộng helper này cho các bài toán sinh id/prefix từ `menuid` sau này (ví dụ: cache key, lookup table).
- Sau task này, mọi tham chiếu slug trong task docs nên dùng dạng compact để khớp với route registry.
