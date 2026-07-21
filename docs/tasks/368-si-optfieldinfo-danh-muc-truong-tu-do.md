# Task 368: OptFieldInfo — Danh mục trường tự do

## Nhóm: SI (System Integration) — Danh mục

## Mục tiêu

Ghi nhận module **Danh mục trường tự do (OptFieldInfo)** từ Simba .NET `OptFieldInfo.dll`. Module này cho phép quản lý danh mục các trường tự do (custom fields) — chức năng mà Portal có thể implement sau khi có framework Eloquent attribute casting phù hợp.

## Trạng thái

- **Status:** 📄 DOCUMENTATION ONLY — ghi nhận cấu trúc DLL
- **Implementation:** ❌ PENDING — chưa có route
- **Route đề xuất (khi implement):** `/simba/si/dict/optfieldinfo`
- **DLL:** `OptFieldInfo.dll`

## DLL Reference

| Thuộc tính | Giá trị |
|------------|---------|
| Assembly | `OptFieldInfo.dll` |
| Form | `frmOptFieldInfo` |
| Namespace | `AsiaErp.UserInterface` |
| Mô tả | Danh mục các trường tu do — chinh sua tieu de (caption) |
| DAO | `OptFieldDAO` |

## Ghi chú

- Module này quản lý **định nghĩa** của trường tự do (tên, kiểu dữ liệu, caption)
- Module `OptFieldSetup` (task 369) quản lý **gán** trường tự do vào loại chứng từ
- Trong Portal, có thể dùng `spatie/laravel-medialibrary` hoặc JSON column + dynamic attributes

## Audit Status

- **2026-07-20:** Tách từ task 181-196.
