# Task 433: Nhập/Chuyển số dư

## Nhóm: SYSTEM (Hệ thống) — Portal core

## Trạng thái

- **Status:** DONE (component) — 10 component đã có
- **Menu SimbaERP:** `90.40.14` — `sysMenu.type = 3` (tiện ích, **không có `dllName`**)
- **Route:** `system.balance.index` → `/hethong/balance`
- **Component:** `System\Balance\*` (10 file)
- **View:** `system/balance/*.blade.php`

> Task này tạo để **lấp khoảng trống**: route + component đã hoạt động nhưng
> chưa có task doc nào làm chủ. Task 317 chỉ **nhắc phụ** (`90.40.14` map vào
> `system.balance.index`), không phải task của màn này.

---

## Đặc thù: route NGOÀI prefix `/simba`

```
/simba/...      → màn port từ SimbaERP (qua shell SimbaPage)
/hethong/...    → màn Portal thuần (không qua shell Simba)
```

Route khai báo trong `routes/web.php` (Portal core), **không** qua
`SimbaMenuRouteMetadata`.

Menu `90.40.14` được **map tay** (PR #432):

```php
'90.40.14' => [
    'route_name'  => 'system.balance.index',
    'url'         => '/hethong/balance',
    'source_type' => self::TYPE_UTILITY,
],
```

---

## Danh sách component (10 file)

`src/Http/Livewire/System/Balance/`:

| File | Chức năng |
|---|---|
| `Index.php` | Trang chính, liệt kê các loại số dư |
| `AccountOpening.php` | Số dư đầu kỳ tài khoản |
| `AccountsPayable.php` | Công nợ phải trả |
| `AccountsReceivable.php` | Công nợ phải thu |
| `CumulativeTransactions.php` | Giao dịch lũy kế |
| `InventoryOpening.php` | Số dư đầu kỳ tồn kho |
| `InventoryOpeningNtxt.php` | Tồn kho đầu kỳ (NTXT) |
| `InventoryTransfer.php` | Chuyển kho |
| `Transfer.php` | Chuyển số dư |
| `WorkInProgress.php` | Chi phí sản xuất dở dang |

Kèm tài liệu `BALANCE_TRANSFER_INTEGRATION.md`.

---

## Route con (10 route)

```
GET hethong/balance                            system.balance.index
GET hethong/balance/account-opening            system.balance.account-opening
GET hethong/balance/accounts-payable           system.balance.accounts-payable
GET hethong/balance/accounts-receivable        system.balance.accounts-receivable
GET hethong/balance/cumulative-transactions    system.balance.cumulative-transactions
GET hethong/balance/inventory-opening          system.balance.inventory-opening
...
```

---

## Checklist DONE

| # | Mục | Kết quả |
|---|---|---|
| 1 | Component render | ✅ |
| 2 | Route 200 (10 route con) | ✅ |
| 3 | Chức năng nhập/chuyển số dư | ✅ |
| 4 | Không lỗi | ✅ |
| 5 | Bộ chọn kỳ | ✅ |
| 6 | Label tiếng Việt | ✅ |
| 7 | Dropdown TK/Kho/VT | ✅ |
| 8 | Giá trị mặc định | ✅ |
| 9 | Tham số rỗng | ✅ |

---

## Verify hiện tại

| Kiểm chứng | Kết quả |
|---|---|
| `/hethong/balance` | 200 |
| Menu sidebar `90.40.14` có link | ✅ (sau PR #432) |

---

## ⚠️ Lịch sử revert

Map `90.40.14` từng được làm ở commit `688c45ee5` rồi **bị revert** (`a9ba3e083`),
sau đó PR #432 đưa lại.

**Lý do revert chưa được ghi lại.** Trước khi sửa `MENU_ROUTE_OVERRIDES` cho
`90.40.14` lần nữa, phải đọc lịch sử git và xác định lý do.
