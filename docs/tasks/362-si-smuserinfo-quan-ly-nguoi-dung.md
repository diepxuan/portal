# Task 362: SMUserInfo — Quản lý người dùng & phân quyền

## Nhóm: SI (System Integration) — Infrastructure

## Mục tiêu

Chuyển đổi module **Quản lý người dùng & phân quyền (SMUserInfo)** từ Simba .NET `SMUserInfo.dll` sang Portal Livewire. Route hiện tại `/hethong/user` (SystemUserController) cần map sang `/simba/si/vch/smuserinfo`.

## Trạng thái

- **Status:** 🔄 CẦN MAP — route hiện tại `/hethong/user` qua `SystemUserController`
- **Route hiện tại:** `/hethong/user` (prefix `system.`)
- **Route đích:** `/simba/si/vch/smuserinfo` (route name: `si.vch.smuserinfo`)
- **Component đề xuất:** `Diepxuan\Catalog\Http\Livewire\Si\Vch\Smuserinfo`
- **View đề xuất:** `diepxuan/laravel-catalog/resources/views/si/vch/smuserinfo.blade.php`
- **DLL:** `SMUserInfo.dll`

## DLL Reference

| Thuộc tính | Giá trị |
|------------|---------|
| Assembly | `SMUserInfo.dll` |
| Namespace | `AsiaErp.UserInterface`, `AsiaErp.DataAccess`, `DTE.Bussiness` |
| Base class | `frmAsiaRoot` (UI), `MsSqlDAO` (DataAccess), `RootController` (Business) |

### Forms chính

| Form | Chức năng | Mô tả |
|------|-----------|-------|
| `frmSMUserInfo` | Danh sách người dùng | Grid + CRUD buttons (F5=Thêm, F6=Sửa, F9=Xóa) |
| `frmSMUserInfoEdit` | Thêm/Sửa user | Username, Fullname, Password, IsAdmin, Group assignment |
| `frmSMUserChangePassword` | Đổi mật khẩu | Old pass + New pass + Re-type |
| `frmSMUserResetPassword` | Reset mật khẩu (Admin) | New pass + Re-type |
| `frmSmSetRights` | Phân quyền chức năng | 5 quyền: Xem/Thêm/Sửa/Xóa/Giới hạn in |
| `frmSmSetRightsCompany` | Phân quyền công ty | Multi-tenant company access |

### SP wrappers cần tạo

| Method | SP | Mô tả |
|--------|----|-------|
| GetUserInfo | `asGetUserInfo` | Danh sách user |
| InsertUserInfo | `asInsUserInfo` | Thêm user (password encrypted) |
| UpdateUserInfo | `asUpdUserInfo` | Sửa user |
| DeleteUserInfo | `asDelUserInfo` | Xóa user |
| ChangePassword | `asChangePassword` | Đổi mật khẩu |
| GetAllUserRights | `asGetAllUserRights` | Quyền của user |
| InsertUserRight | `asInsUserRight` | Thêm quyền |
| GetMenuBar | `asGetMenuBar` | Menu chính |
| GetSubMenuBar | `asGetMenuDetail` | Menu con |

## Yêu cầu mapping

### Hiện tại (`/hethong/user`)

```
Route::resource('hethong/user', SystemUserController::class)
    ->names('system.user.*')
    ->parameters(['user' => 'system'])
    ->except('create', 'store');
```

### Cần chuyển thành

```
Route::get('/si/vch/smuserinfo', Smuserinfo::class)->name('si.vch.smuserinfo')
```

1. Giữ nguyên redirect từ `/hethong/user/*` → `/simba/si/vch/smuserinfo`
2. Tạo Livewire component với đầy đủ CRUD + phân quyền (ưu tiên list + edit trước)
3. Component phải hỗ trợ multi-company permission

## Ghi chú

- Module này là một trong những module lớn nhất trong SI — cần phân chia sub-phase
- Phase 1: List + CRUD user cơ bản
- Phase 2: Phân quyền chức năng (SetRights)
- Phase 3: Phân quyền công ty
- Phase 4: Group management

## Audit Status

- **2026-07-20:** Tách từ task 181-196. Route hiện tại dùng Controller (không Livewire) — cần chuyển đổi.
