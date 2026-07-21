# Task 369: OptFieldSetup — Khai báo trường tự do cho chứng từ

## Nhóm: SI (System Integration) — Danh mục

## Mục tiêu

Ghi nhận module **Khai báo trường tự do cho chứng từ (OptFieldSetup)** từ Simba .NET `OptFieldSetup.dll`. Module này cho phép gán các trường tự do vào từng loại chứng từ cụ thể.

## Trạng thái

- **Status:** 📄 DOCUMENTATION ONLY — ghi nhận cấu trúc DLL
- **Implementation:** ❌ PENDING — chưa có route
- **Route đề xuất (khi implement):** `/simba/si/dict/optfieldsetup`
- **DLL:** `OptFieldSetup.dll`

## DLL Reference

| Thuộc tính | Giá trị |
|------------|---------|
| Assembly | `OptFieldSetup.dll` |
| Form | `frmOptFieldSetup` |
| Namespace | `AsiaErp.UserInterface` |
| Mô tả | Khai bao truong tu do cho tung loai chung tu — cau hinh Master/Detail display |
| DAO | `FieldSetupDAO` |

## Ghi chú

- Module này phụ thuộc vào `OptFieldInfo` (task 368) — cần có danh mục trường tự do trước
- Trong Portal, có thể implement dạng Livewire dynamic field component
- Deferred — làm sau khi có nhu cầu custom fields cụ thể

## Audit Status

- **2026-07-20:** Tách từ task 181-196.
