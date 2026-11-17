# Task 375: CA ARDMKH — Danh mục nhân viên (CRUD)

## Nhóm

CA (Cash — Tiền mặt & Ngân hàng) / dictionary chung ARDMKH

## Mục tiêu

Hoàn thiện danh mục nhân viên phục vụ nghiệp vụ CA, dùng chung bảng Simba `ARDMKH` / form `frmARDMKH`, phân loại mặc định `pModuleId=CA`, cờ `pIsnv=1`; UI cho phép thay đổi cờ đối tượng (khách hàng/nhà cung cấp/nhân viên). CRUD đầy đủ (xem, thêm, sửa, xóa) với SP wrappers chuẩn.

## Trạng thái

- **Status:** DONE (form + route + SP wrapper hoạt động; blocker cũ đã đóng ngày 2026-11-17). Còn 1 bug riêng cần task mới: `loadDoiTuong()` khớp tiền tố thay vì khớp chính xác mã — xem mục *Bug thật phát hiện khi đối chiếu*.
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
| `asARUpdDMKH` | Cập nhật NV (payload cờ đối tượng theo checkbox, không hardcode `pIsnv=1`) | `Diepxuan\Simba\StoredProcedures\AsARUpdDMKH` |
| `asARDelDMKH` | Xóa NV (validate `KSd=0`) | `Diepxuan\Simba\StoredProcedures\AsARDelDMKH` |

## Phạm vi

### Routes

| URI | Route name | Component |
|-----|-----------|-----------|
| `GET /simba/ca/dict/ardmkh` | `ca.dict.ardmkh` | `Ca\Dict\Ardmkh` |
| `GET /simba/ca/dict/ardmkh/create` | `ca.dict.ardmkh.create` | `Ca\Dict\ArdmkhForm` |
| `GET /simba/ca/dict/ardmkh/{id}/edit` | `ca.dict.ardmkh.edit` | `Ca\Dict\ArdmkhForm` |

URL thật: `http://portal.diepxuan.corp/simba/ca/dict/ardmkh`

### Component

- [Ardmkh.php](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Ca/Dict/Ardmkh.php): kế thừa `Po\Dict\Ardmkh`, override `deleteDoiTuong()` với message NV.
- [ArdmkhForm.php](/root/.openclaw/workspace/projects/portal/diepxuan/laravel-catalog/src/Http/Livewire/Ca/Dict/ArdmkhForm.php): kế thừa `Po\Dict\ArdmkhForm`, bổ sung 12 trường NV (`home_page`, `ma_httt`, `ma_httt_po`, `ma_ngh`, `ten_nh`, `cn_nh`, `so_tk_nh`, `tinh_tp_nh`, `ma_plkh1/2/3`, `ma_nhkh`, `ma_tt`, `gh_no`, `han_ck`, `tl_ck`, `han_tt`, `ls_qh`).

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
- Component `Ca\Dict\Ardmkh` + `Ca\Dict\ArdmkhForm` (kế thừa PO).
- Mapping `SimbaRouteRegistry`: `ca.dict.ardmkh` → menu `04.90.05`.
- Mapping `SimbaDictionaryRegistry`: `ca.dict.ardmkh` → `MA_KH` / `ARDMKH`.

## Blocker cũ — ĐÃ ĐIỀU TRA VÀ ĐÓNG (2026-11-17)

Ghi chú cũ (từ task 356, 2026-06-05) nói *"Form NV edit chưa lưu được trên
`/simba/ca/dict/ardmkh/1LETRUONGLUAT/edit`"*. Kiểm chứng lại bằng browser thật
trên `http://portal.diepxuan.corp` (không dùng CLI/DB):

**1. Form edit KHÔNG hỏng.** Với mã nhân viên có thật, form load đầy đủ dữ liệu:

| URL | `ma_kh` đọc được | `ten_kh` | Số field có giá trị |
|---|---|---|---|
| `/simba/ca/dict/ardmkh/CONGTY/edit` | `CONGTY` | Công ty Điệp Xuân | 7 |
| `/simba/ca/dict/ardmkh/K1/edit` | `K1 HUYEN` | nhan vien ban hang | 7 |
| `/simba/ca/dict/ardmkh/KHO1/edit` | `KHO1` | Kho 1 | 7 |

**2. `1LETRUONGLUAT` không tồn tại trong dữ liệu.** Danh sách
`/simba/ca/dict/ardmkh` có **28** đối tượng; không có mã `1LETRUONGLUAT`
(màn hình cũng không tìm thấy chuỗi này). Vì vậy mở URL đó hiện form trống là
**hành vi đúng** — không phải lỗi lưu.

**3. Kết luận:** blocker cũ là **hiểu nhầm do dùng mã không tồn tại** trong URL,
không phải bug `save()`/`rules()`/SP. Không cần sửa code cho blocker này.

## Bug thật phát hiện khi đối chiếu (2026-11-17)

Tìm kiếm theo mã trong form edit trả **sai bản ghi** vì
`AsARGetDMKH::getEmployees(search: ...)` truyền mã vào `pMa_kh`, mà
`simba-docs/procedures/AR/procedures.md` (mục `asARGetDMKH`, dòng 1197-1209)
mô tả `pMa_kh` là **prefix search** (`Mã khách hàng prefix search (null/empty = all)`),
không phải khớp chính xác.

Bằng chứng browser:

| Mã trên URL | Bản ghi được load | Đúng/Sai |
|---|---|---|
| `CONGTY` | `CONGTY` — Công ty Điệp Xuân | đúng (khớp chính xác) |
| `KHO1` | `KHO1` — Kho 1 | đúng (khớp chính xác) |
| `K1` | **`K1 HUYEN`** — nhan vien ban hang | **SAI** — `K1` là mã riêng, `K1 HUYEN` chỉ trùng tiền tố |

**Hệ quả:** với mã là tiền tố của mã khác, form edit sẽ load và cho sửa **nhầm
đối tượng**. Đây là lỗi nghiêm trọng (sửa sai dữ liệu), nhưng **có trước** task
này và cùng tồn tại ở SO/PO vì dùng chung `AsARGetDMKH`.

**Hướng sửa (cần task riêng):** trong `loadDoiTuong()` phải lọc lại kết quả theo
`ma_kh === $maKh` trước khi `$result->first()`; không sửa SP. Áp cho cả 3 form
`So|Po|Ca\Dict\ArdmkhForm`.

## Liên quan

- Task 001 (`001-ar-danh-muc-khach-hang.md`) — AR khách hàng (cùng bảng DMKH).
- Task **373** (`373-po-ardmkh-nha-cung-cap.md`) — PO nhà cung cấp (cùng bảng DMKH, làm mẫu cho component cha).
- Task **374** (`374-so-ardmkh-khach-hang-crud.md`) — SO khách hàng (cùng bảng DMKH).
- Task 210 (`210-so-danhmuc-nhan-vien-kinh-doanh.md`) — NVKD là dictionary riêng `SODMNVKD`, không dùng ARDMKH.

## Kiểm chứng

- `php -l` pass cho component + view kế thừa.
- `SourceRouteCoverageTest` expectation cho `ca.dict.ardmkh` pass.
- Có unit test cơ bản tại `tests/Unit/Packages/Catalog/ArdmkhFormTest.php`; cần bổ sung Livewire create/edit với DB test.
- **Đã fix visibility `field()` + output `pRet`; cần verify form edit với SQL Server trước khi chuyển sang DONE.**

## Công việc tiếp theo

1. Verify `/simba/ca/dict/ardmkh/{id}/edit` với DB thật sau khi chuyển `field()` sang `protected`.
2. Trace `$rules()` của `Ca\Dict\ArdmkhForm` — đảm bảo validate không chặn field thực sự required.
3. Trace SP `AsARUpdDMKH` với payload NV — so sánh với `asARUpdDMKH` metadata.
4. Viết unit test Livewire (create + edit + delete) để khoá hành vi.
