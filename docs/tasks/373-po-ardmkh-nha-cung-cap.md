# Task 373: PO/ARDMKH — Danh mục nhà cung cấp (CRUD đầy đủ)

## Nhóm

PO (Purchase Order — Đơn hàng mua) / dictionary chung ARDMKH (`frmARDMKH`)

## Mục tiêu

Hoàn thiện danh mục nhà cung cấp dùng chung bảng Simba `ARDMKH` / form `frmARDMKH`, phân loại `pModuleId=AP`, cờ `pIsncc=1`. CRUD đầy đủ (xem, thêm, sửa, xóa) qua SP wrappers chuẩn của `laravel-simba`.

## Trạng thái hiện tại

- **Status:** DONE — code merged qua các PR #214, #230, #255
- **Ngày tạo:** 2026-07-28
- **Người tạo:** Bot (Portal Agent)
- **Tách từ:** task 356 (gộp KH + NCC + NV ARDMKH) → tách thành 373 / 374 / 375
- **Phase:** hiện tại (root `docs/tasks/`)
- **Canonical URL:** `/simba/po/dict/ardmkh`
- **Route name:** `po.dict.ardmkh` (+ `.create`, `.edit`)

## Source of truth từ Simba

### sysMenu

| MenuID | Module | Tiêu đề | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `10.90.22` | PO | Danh mục nhà cung cấp | `MA_NCC` | `AsiaErp.UserInterface.frmARDMKH` | `1` |

### sysDictionaryInfo

| Code | Table | menuid | Ghi chú |
|------|-------|--------|---------|
| `MA_NCC` | `ARDMKH` | `10.90.22` | Cờ phân loại `pIskh=0, pIsncc=1, pIsnv=0` |

### Stored procedures

| SP | Vai trò | Wrapper |
|----|---------|---------|
| `asARGetDMKH` | Lấy danh sách / chi tiết NCC theo `pModuleId='AP'` | [`AsARGetDMKH.php`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/src/StoredProcedures/AsARGetDMKH.php) (helper `getSuppliers()`) |
| `asARInsDMKH` | Thêm NCC | [`AsARInsDMKH.php`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/src/StoredProcedures/AsARInsDMKH.php) (37 tham số) |
| `asARUpdDMKH` | Cập nhật NCC | [`AsARUpdDMKH.php`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/src/StoredProcedures/AsARUpdDMKH.php) (37 tham số) |
| `asARDelDMKH` | Xóa NCC (validate `KSd=0` qua `hasTransactions()`) | [`AsARDelDMKH.php`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/src/StoredProcedures/AsARDelDMKH.php) |

## Phạm vi đã implement

### Routes ([routes/web.php:234-236](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/routes/web.php:234))

| URI | Route name | Component |
|-----|-----------|-----------|
| `/po/dict/ardmkh` | `po.dict.ardmkh` | `Po\Dict\Ardmkh` |
| `/po/dict/ardmkh/create` | `po.dict.ardmkh.create` | `Po\Dict\ArdmkhForm` |
| `/po/dict/ardmkh/{id}/edit` | `po.dict.ardmkh.edit` | `Po\Dict\ArdmkhForm` |

URL thật: `http://portal.diepxuan.corp/simba/po/dict/ardmkh`

### Components

- [`Po\Dict\Ardmkh`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/Ardmkh.php): danh sách NCC với `search` (debounce 300ms), `WithPagination` (perPage=50), `deleteDoiTuong(maKh)` qua `AsARDelDMKH`.
- [`Po\Dict\ArdmkhForm`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/ArdmkhForm.php): mode `create` / `edit` (theo route param), `mount($id)` load qua `AsARGetDMKH` với `pModuleId='AP'`, `save()` chọn `AsARInsDMKH` / `AsARUpdDMKH` theo mode, validation rules 11 trường, redirect về `po.dict.ardmkh` sau khi lưu.

### Views

- [`po/dict/ardmkh.blade.php`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/resources/views/po/dict/ardmkh.blade.php): bảng NCC + 8 cột (mã, tên, địa chỉ, điện thoại, người GD, HTTT mua, thao tác), nút Thêm / Sửa / Xóa (`wire:confirm` cho xóa), `wire:model.live.debounce.300ms="search"`.
- [`po/dict/ardmkh-form.blade.php`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/resources/views/po/dict/ardmkh-form.blade.php): 3 section (Thông tin cơ bản / Liên hệ và thanh toán / Ghi chú), 2-col grid `md:grid-cols-2`, `wire:submit="save"`, `readonly` cho `ma_kh` khi edit.

### Model

- [`ArDmKh.php`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Models/Simba/ArDmKh.php): kế thừa `Diepxuan\Simba\Models\ArDmKh`, quan hệ `glCts()` (HasMany), `hasTransactions()` (check trước khi xóa), `nhomKhachHang()`, `phanLoaiKhachHang1/2/3()`.

## Thay đổi chính (theo PR)

- **PR #214 (`e718d0c86`):** canonicalize PO supplier ARDMKH actions — chuẩn hoá action routes cho supplier PO.
- **PR #230 (`6dc77dded`):** refactor — chuyển Simba-extending models sang `Models/Simba` (ArDmKh, ArDmKhNgh, ArDmNhKh, ArDmPlKh, GlCt, GlCt1, GlCtGs, ApCt1/3/4, ApPh1/3/4, ApTt).
- **PR #255 (`af30db3e6`):** unit test reflection-based cho AsPOGetPO3/AsPOSavePO3/AsPODeletePO3 — pattern tham khảo cho SP wrapper tests (chưa có test cho AsARGetDMKH family).

## Kiểm chứng

- `php -l` pass cho [Ardmkh.php](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/Ardmkh.php), [ArdmkhForm.php](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/ArdmkhForm.php), 4 SP wrappers trong `laravel-simba`, 2 view blade.
- [`SourceRouteCoverageTest::testCanonicalPoSupplierCreateEditUrlsResolve`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php:62) PASS: `/simba/po/dict/ardmkh/create` resolve tới `simba.create` (vì component `ArdmkhForm` cùng slug `ardmkh`), `/simba/po/dict/ardmkh/{id}/edit` resolve tới `simba.edit`.
- [`SourceRouteCoverageTest`](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php:150) có expectation cho `po.dict.ardmkh` → `Po\Dict\Ardmkh`.
- Không tạo bảng mới, không ALTER/INSERT SQL, không tự đặt tên SP/table/field ngoài metadata Simba.

## Bài học / Backlog

- **Pattern chuẩn cho ARDMKH dictionary:** route concrete đầy đủ 3 endpoint (`index`, `create`, `edit`) + component đặt trong namespace `{module}\Dict\{Slug}` để khớp slug — em đã áp dụng đúng ở PO. SO/AR (`Banhang\Khachhang`) và CA (`Cash\Danhmuc\Nhanvien`) KHÔNG theo pattern này (xem task 374, 375).
- **Unit test Livewire riêng:** hiện chỉ có route coverage test. Cần bổ sung test cho `Po\Dict\Ardmkh` (render, search, paginate, delete guard `hasTransactions()`, validation) và `Po\Dict\ArdmkhForm` (create vs edit chọn đúng SP wrapper, validation rules) — pattern tham khảo PR #255 cho SP wrappers reflection-based.
- **Test DB baseline issue:** `PhieubaonoTest::test_update_khach_hang_auto_fills` hiện fail vì `RefreshDatabase` + `ArDmKh::create()` — không liên quan ARDMKH PO, nhưng cần lưu ý khi viết test mới dùng `ArDmKh::create()`.
- **Token Simba:** `AsARGetDMKH::call` có `pStruct='0'` cố định; nếu sau này cần `pStruct='1'` cho form edit, cần verify metadata Simba trước.

## Liên quan

- Task 001 (`001-ar-danh-muc-khach-hang.md`) — AR khách hàng, gốc.
- Task **374** (`374-so-ardmkh-khach-hang-crud.md`) — SO khách hàng (cùng bảng DMKH, namespace lệch — backlog refactor).
- Task **375** (`375-ca-ardmkh-nhan-vien.md`) — CA nhân viên (cùng bảng DMKH, namespace lệch, blocker debug runtime).
- Task 069 (`069-po-hoadon-mua-hang.md`) — PO3 hoá đơn mua hàng, dùng `Po\Dict\Ardmkh` làm NCC lookup.
