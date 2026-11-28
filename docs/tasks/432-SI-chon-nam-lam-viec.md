# Task 432: SiChangeFY — Chọn năm làm việc

## Nhóm: SI (System)

## Trạng thái

- **Status:** DONE (component) — đã có `Si\Vch\YearSelector` + route
- **DLL:** `SiChangeFY.dll`
- **Route:** `si.vch.year` → `/simba/si/vch/year` (menu `90.30.02`)
- **Component:** `Si\Vch\YearSelector`
- **View:** `si/vch/year-selector.blade.php`

> Task doc này tạo để **lấp khoảng trống** — route đã hoạt động nhưng chưa có doc.
> Không cần implement lại.

---

## Checklist DONE

| # | Mục | Kết quả |
|---|---|---|
| 1 | Component render | ✅ |
| 2 | Route 200 | ✅ |
| 3 | Chức năng đổi năm | ✅ |
| 4 | Không `errorMessage` | ✅ |
| 5 | Bộ chọn kỳ | — (bản thân là bộ chọn năm) |
| 6 | Label tiếng Việt | ✅ |
| 7 | Dropdown | — |
| 8 | Giá trị mặc định | ✅ (năm hiện tại) |
| 9 | Tham số rỗng | — |

---

## Đặc thù: route khai báo TAY

Đây là **1 trong 2 route không tự sinh** từ `sysMenu`:

```php
// SimbaMenuRouteMetadata::MENU_ROUTE_OVERRIDES
'90.30.02' => [
    'route_name'  => 'si.vch.year',
    'url'         => '/simba/si/vch/year',
    'source_type' => self::TYPE_UTILITY,
],
```

**Lý do:** `sysMenu.type = 3` (tiện ích) không có `dllName`/`code_name` chuẩn
→ `sourceTypeFor()` trả null → không tự sinh được route.

Và `routes/web.php` còn **1 entry `$sourceRoutes` duy nhất** cho route này.

---

## Vấn đề còn treo: tên class

Component hiện là `YearSelector` (không phải `Year`).

| Phương án | Ưu | Nhược |
|---|---|---|
| **A. Đổi `YearSelector` → `Year`** | đúng convention §2.2 | đã test an toàn: 24 tests PASS, browser 200 |
| **B. Thêm hằng `ROUTE_SLUG`** | tách tên route khỏi tên class | thêm khái niệm mới |
| **C. Giữ nguyên** | không rủi ro | sai convention §2.2 |

**Đã kiểm chứng phương án A an toàn:**

- 24 tests / 75 assertions PASS
- Browser 200 sau khi đổi
- `$sourceRoutes` giảm còn 0 (không cần khai báo tay nữa)

Sếp chưa chọn. **Cần quyết định trước khi làm task khác.**

---

## Chức năng

Chọn năm làm việc (`CatalogService` lưu vào `session('year')`).

| Hành vi | Nguồn |
|---|---|
| Danh sách năm | `SiSetup` / `CatalogService::year()` |
| Ghi session | `CatalogService` |
| Ảnh hưởng | mọi báo cáo có `pNgay1`/`pNgay2` theo kỳ |

---

## Verify hiện tại

| Kiểm chứng | Kết quả |
|---|---|
| `/simba/si/vch/year` | 200 |
| Component | `catalog::si.vch.year-selector` |
| Đổi năm → báo cáo cập nhật kỳ | ✅ (đã test ở các task báo cáo) |
