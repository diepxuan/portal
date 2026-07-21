# Task 366: GL Balance — Số dư ban đầu

## Nhóm: GL (General Ledger) — Sổ cái

## Mục tiêu

Chuyển 9 route **Số dư ban đầu (Balance)** từ `/hethong/balance/*` sang `/simba/gl/balance/*`. Các component hiện tại nằm dưới namespace `System\Balance\*`.

## Trạng thái

- **Status:** 🔄 CẦN MAP — 9 Livewire components hiện tại dưới `/hethong/balance/*`
- **Route hiện tại:** `/hethong/balance/*` (prefix `system.balance.*`)
- **Route đích:** `/simba/gl/balance/*` (prefix `gl.balance.*`)
- **Components hiện tại:** `Diepxuan\Catalog\Http\Livewire\System\Balance\*`
- **Components đích:** `Diepxuan\Catalog\Http\Livewire\Gl\Balance\*`

### Danh sách 9 components

| # | Route hiện tại | Component hiện tại | Route đích đề xuất |
|:-:|---------------|-------------------|-------------------|
| 1 | `/hethong/balance` | `System\Balance\Index` | `/simba/gl/balance` |
| 2 | `/hethong/balance/account-opening` | `System\Balance\AccountOpening` | `/simba/gl/balance/account-opening` |
| 3 | `/hethong/balance/transfer` | `System\Balance\Transfer` | `/simba/gl/balance/transfer` |
| 4 | `/hethong/balance/accounts-receivable` | `System\Balance\AccountsReceivable` | `/simba/gl/balance/accounts-receivable` |
| 5 | `/hethong/balance/accounts-payable` | `System\Balance\AccountsPayable` | `/simba/gl/balance/accounts-payable` |
| 6 | `/hethong/balance/inventory-opening` | `System\Balance\InventoryOpening` | `/simba/gl/balance/inventory-opening` |
| 7 | `/hethong/balance/inventory-opening-ntxt` | `System\Balance\InventoryOpeningNtxt` | `/simba/gl/balance/inventory-opening-ntxt` |
| 8 | `/hethong/balance/inventory-transfer` | `System\Balance\InventoryTransfer` | `/simba/gl/balance/inventory-transfer` |
| 9 | `/hethong/balance/work-in-progress` | `System\Balance\WorkInProgress` | `/simba/gl/balance/work-in-progress` |
| 10 | `/hethong/balance/cumulative-transactions` | `System\Balance\CumulativeTransactions` | `/simba/gl/balance/cumulative-transactions` |

## Yêu cầu

1. Move 9 components từ `System\Balance\*` → `Gl\Balance\*`
2. Tạo 10 routes mới dưới prefix `/simba/gl/balance`
3. Thêm redirect từ `/hethong/balance/*` → `/simba/gl/balance/*`
4. Cập nhật menu mapping trong `simba-router-menu-matrix.md`

## Độ phức tạp

**Trung bình.** Nhiều files (9 components + routes + redirects) nhưng mỗi component tương đối đơn giản (form nhập số dư).

## Audit Status

- **2026-07-20:** Tách từ task 181-196.
