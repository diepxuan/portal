# Task 375: CA ARDMKH — Danh mục nhân viên (CRUD)

## Nhóm

CA (Cash — Tiền mặt & Ngân hàng) / dictionary chung ARDMKH

## Mục tiêu

Hoàn thiện danh mục nhân viên phục vụ nghiệp vụ CA, dùng chung bảng Simba `ARDMKH` / form `frmARDMKH`, phân loại `pModuleId=CA`, cờ `pIsnv=1`. CRUD đầy đủ (xem, thêm, sửa, xóa) với SP wrappers chuẩn.

## Trạng thái

- **Status:** IN PROGRESS — blocker runtime trên form edit (`/cash/nhanvien/edit/{id}` chưa lưu được).
- **Ngày tạo:** 2026-07-28
- **Người tạo:** Bot (Portal Agent)
- **Tách từ:** task 356 (gộp KH + NCC + NV) → tách thành 373/374/375
- **Phase:** hiện tại (root `docs/tasks/`)

## Source of truth từ Simba

### sysMenu (CA)

| MenuID | Module | Tiêu đề | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `04.90.05` | CA | Danh mục nhân viên | `MA_KH` (trên `ARDMKH`) | `AsiaErp.UserInterface.frmARDMKH` | `1` |

### sysDictionaryInfo

| Code | Table | menuid | Ghi chú |
|------|-------|--------|---------|
| `MA_KH` | `ARDMKH` | `04.90.05` | Cờ phân loại `pIsnv=1` |

> **Lưu ý:** `MA_NV` trong `sysDictionaryInfo` là nguồn vốn `FADMNV` menu `20.90.02`, KHÔNG dùng cho nhân viên ARDMKH menu `04.90.05`.

### Stored procedures

| SP | Vai trò | Wrapper |
|----|---------|---------|
| `asARGetDMKH` | Lấy danh sách / chi tiết NV theo `pModuleId='CA'` | `Diepxuan\Simba\StoredProcedures\AsARGetDMKH` |
| `asARInsDMKH` | Thêm NV (set `pIskh=0, pIsncc=0, pIsnv=1`) | `Diepxuan\Simba\StoredProcedures\AsARInsDMKH` |
| `asARUpdDMKH` | Cập nhật NV | `Diepxuan\Simba\StoredProcedures\AsARUpdDMKH` |
| `asARDelDMKH` | Xóa NV (validate `KSd=0`) | `Diepxuan\Simba\StoredProcedures\AsARDelDMKH` |

## Phạm vi

### Routes

| URI | Route name | Component |
|-----|-----------|-----------|
| `GET /simba/ca/dict/ardmkh` | `ca.dict.ardmkh` | `Cash\Danhmuc\Nhanvien` |
| `GET /simba/ca/dict/ardmkh/create` | `ca.dict.ardmkh.create` | `Cash\Danhmuc\NhanvienForm` |
| `GET /simba/ca/dict/ardmkh/{id}/edit` | `ca.dict.ardmkh.edit` | `Cash\Danhmuc\NhanvienForm` |

URL thật: `http://portal.diepxuan.corp/simba/ca/dict/ardmkh`

### Component

- [Nhanvien.php](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Cash/Danhmuc/Nhanvien.php): kế thừa `Po\Dict\Ardmkh`, override `deleteDoiTuong()` với message NV.
- [NhanvienForm.php](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Cash/Danhmuc/NhanvienForm.php): kế thừa `Po\Dict\ArdmkhForm`, bổ sung 12 trường NV (`home_page`, `ma_httt`, `ma_httt_po`, `ma_ngh`, `ten_nh`, `cn_nh`, `so_tk_nh`, `tinh_tp_nh`, `ma_plkh1/2/3`, `ma_nhkh`, `ma_tt`, `gh_no`, `han_ck`, `tl_ck`, `han_tt`, `ls_qh`).

### Trường bổ sung cho NV (so với KH/NCC)

| Trường | Vai trò |
|--------|---------|
| `home_page` | Website cá nhân |
| `ma_httt` | Hình thức thanh toán |
| `ma_ngh` | Mã nghề nghiệp |
| `ten_nh`, `cn_nh`, `so_tk_nh`, `tinh_tp_nh` | Thông tin ngân hàng |
| `gh_no`, `han_ck`, `tl_ck`, `han_tt`, `ls_qh` | Thông tin công nợ / chiết khấu |

## Thay đổi chính (đã có)

- Route `ca.dict.ardmkh` (`/ca/dict/ardmkh`).
- Component `Cash\Danhmuc\Nhanvien` + `NhanvienForm` (kế thừa PO).
- Mapping `SimbaRouteRegistry`: `ca.nhanvien` → menu `04.90.05`.
- Mapping `SimbaDictionaryRegistry`: `ca.nhanvien` → `MA_KH` / `ARDMKH`.

## Blocker hiện tại

- **Form NV edit chưa lưu được trên `/cash/nhanvien/edit/1LETRUONGLUAT`** (ghi chú 2026-06-05 của task 356 cũ).
- Cần debug runtime: trace xem `mount()` có load đúng dữ liệu qua `AsARGetDMKH::call` không, `save()` có chạy `AsARUpdDMKH` không, error message gì.
- Có thể liên quan: thiếu field trong `rules()`, validation fail im lặng, hoặc SP reject vì thiếu tham số.

## Liên quan

- Task 001 (`001-ar-danh-muc-khach-hang.md`) — AR khách hàng (cùng bảng DMKH).
- Task **373** (`373-po-ardmkh-nha-cung-cap.md`) — PO nhà cung cấp (cùng bảng DMKH, làm mẫu cho component cha).
- Task **374** (`374-so-ardmkh-khach-hang-crud.md`) — SO khách hàng (cùng bảng DMKH).
- Task 210 (`210-so-danhmuc-nhan-vien-kinh-doanh.md`) — NVKD là dictionary riêng `SODMNVKD`, không dùng ARDMKH.

## Kiểm chứng

- `php -l` pass cho component + view kế thừa.
- `SourceRouteCoverageTest` expectation cho `ca.dict.ardmkh` pass.
- Không có unit test riêng cho `Nhanvien` / `NhanvienForm` — cần bổ sung.
- **Cần debug runtime form edit** trước khi chuyển sang DONE.

## Công việc tiếp theo

1. Reproduce bug trên `/cash/nhanvien/edit/1LETRUONGLUAT` (cần user thật hoặc DB test seed).
2. Trace `$rules()` của `NhanvienForm` — đảm bảo validate không chặn field thực sự required.
3. Trace SP `AsARUpdDMKH` với payload NV — so sánh với `asARUpdDMKH` metadata.
4. Sau khi fix bug, viết unit test Livewire (create + edit + delete) để khoá hành vi.
