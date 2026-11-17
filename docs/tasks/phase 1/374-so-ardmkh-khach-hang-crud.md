# Task 374: SO ARDMKH — Danh mục khách hàng CRUD (góc nhìn bán hàng)

## Nhóm

SO (Sales Order — Đơn hàng bán) / dictionary chung ARDMKH

## Mục tiêu

Hoàn thiện danh mục khách hàng phục vụ nghiệp vụ bán hàng, dùng chung bảng Simba `ARDMKH` / form `frmARDMKH`, phân loại `pModuleId=AR`, cờ `pIskh=1`. CRUD đầy đủ (xem, thêm, sửa, xóa) với SP wrappers chuẩn.

## Trạng thái

- **Status:** DONE (2026-11-17 — verify E2E bằng browser thật)
- **Fix 2026-11-17 (PR #296) — cờ loại đối tượng:** form khách hàng trước đây **hardcode**
  `pIskh`/`pIsncc`/`pIsnv` trong payload SP, nên mỗi lần bấm Lưu là **xoá cờ** của các loại
  khác. Ví dụ thật: đối tượng `2VANQT` vừa là khách hàng vừa là nhà cung cấp; form PO gửi
  `pIskh => 0, pIsncc => 1` nên Lưu xong `2VANQT` chỉ còn là nhà cung cấp.
  + Nay form có đủ 3 checkbox **Là khách hàng / Là nhà cung cấp / Là nhân viên**, payload lấy
    theo lựa chọn thay vì hardcode.
  + Gửi đủ **35 cột NOT NULL** của `ArDmKh` (`pHome_page`, `pMa_ngh`, `pTen_nh`, `pCn_nh`,
    `pSo_tk_nh`, `pTinh_tp_nh`, `pMa_tt`, `pMa_httt`, `pGh_no`, `pHan_ck`, `pTl_ck`, `pHan_tt`,
    `pLs_qh`, `pTinh_dt_nb`) — thiếu tham số thì SP nhận `NULL` và SQL báo
    `Cannot insert the value NULL into column ...; UPDATE fails`.
  + Verify browser thật: bỏ tick "Là nhà cung cấp" của `2VANQT` trên form PO rồi Lưu →
    `success: "Đã lưu nhà cung cấp 2VANQT"`; đọc lại: SO `isKh=true, isNcc=false`;
    PO **không còn** `2VANQT`; CA không có. Đúng yêu cầu "chỉ là khách hàng".
  + Quy tắc đã ghi vào `docs/PROJECT_CONVENTIONS.md` §9.
- **Verify 2026-11-17** (Playwright + Chromium, `http://portal.diepxuan.corp`):
  + `/simba/so/dict/ardmkh` → HTTP **200**, title `Khách hàng [SimbaERP]`, **666 dòng** render.
  + `/simba/so/dict/ardmkh/create` → HTTP **200**, 10 field `wire:model`, có nút Lưu.
  + Component `So\Dict\Ardmkh` + `So\Dict\ArdmkhForm`; route `so.dict.ardmkh[.create|.edit]`.
  + **Lỗi JS phát hiện (P2, không chặn chức năng):** console có `SyntaxError: Unexpected string`
    từ Alpine khi parse `x-data` của menu sidebar (`div.w-[360px]`, ~19KB). Lỗi xuất hiện trên cả
    3 màn ARDMKH (SO/PO/CA) nhưng **không** ở `/simba`, SO3 list, SMKS, `/login`.
    Alpine vẫn init (v3.15.12), dữ liệu vẫn render, form vẫn thao tác được; chỉ menu sidebar
    không nhận state Alpine. Cần task riêng để truy nguyên biểu thức gây lỗi.
  + **Bug dùng chung:** xem task 375 — `loadDoiTuong()` khớp tiền tố (`pMa_kh` là prefix search
    theo simba-docs), nên mã là tiền tố của mã khác sẽ load nhầm bản ghi. Áp cho cả SO/PO/CA.
- **Ngày tạo:** 2026-07-28
- **Người tạo:** Bot (Portal Agent)
- **Tách từ:** task 038 (ban đầu dùng tên `038-ban-hang-khach-hang-them-sua-xoa.md`)
- **Phase:** hiện tại (root `docs/tasks/`)

## Source of truth từ Simba

### sysMenu (SO/AR — khách hàng)

| MenuID | Module | Tiêu đề | Command | Form | Active |
|--------|--------|---------|---------|------|--------|
| `06.90.02` | AR | Danh mục khách hàng | `MA_KH` | `AsiaErp.UserInterface.frmARDMKH` | `1` |

### sysDictionaryInfo

| Code | Table | menuid | Ghi chú |
|------|-------|--------|---------|
| `MA_KH` | `ARDMKH` | `06.90.02` | Cờ phân loại `pIskh=1` |

### Stored procedures

| SP | Vai trò | Wrapper |
|----|---------|---------|
| `asARGetDMKH` | Lấy danh sách / chi tiết KH theo `pModuleId='AR'` | `Diepxuan\Simba\StoredProcedures\AsARGetDMKH` |
| `asARInsDMKH` | Thêm KH (set `pIskh=1, pIsncc=0, pIsnv=0`) | `Diepxuan\Simba\StoredProcedures\AsARInsDMKH` |
| `asARUpdDMKH` | Cập nhật KH | `Diepxuan\Simba\StoredProcedures\AsARUpdDMKH` |
| `asARDelDMKH` | Xóa KH (validate `KSd=0`) | `Diepxuan\Simba\StoredProcedures\AsARDelDMKH` |

## Phạm vi

### Routes

| URI | Route name | Component |
|-----|-----------|-----------|
| `GET /simba/so/dict/ardmkh` | `so.dict.ardmkh` | `So\Dict\Ardmkh` |
| `GET /simba/so/dict/ardmkh/create` | `so.dict.ardmkh.create` | `So\Dict\ArdmkhForm` |
| `GET /simba/so/dict/ardmkh/{id}/edit` | `so.dict.ardmkh.edit` | `So\Dict\ArdmkhForm` |

URL thật: `http://portal.diepxuan.corp/simba/so/dict/ardmkh`

### Component

- `So\Dict\Ardmkh` (index): client-side Alpine search, không dùng pagination, `deleteDoiTuong(maKh)`.
- `So\Dict\ArdmkhForm`: mode create/edit, `save()` chọn `AsARInsDMKH` / `AsARUpdDMKH` theo mode với `pIskh=1, pIsncc=0, pIsnv=0`.

### View

- `resources/views/so/dict/ardmkh.blade.php`: danh sách KH.
- `resources/views/so/dict/ardmkh-form.blade.php`: form thêm/sửa (dropdown phân loại KH + checkbox khóa sử dụng).

### Trường bổ sung cho SO (theo task 038 cũ)

| Trường | Kiểu | Mô tả |
|--------|------|-------|
| `dia_chi_gh` | nvarchar(500) | Địa chỉ giao hàng |
| `nguoi_nhan` | nvarchar(100) | Người nhận hàng |
| `dt_nguoi_nhan` | varchar(50) | SĐT người nhận |
| `email_giao_hang` | varchar(100) | Email giao hàng |

> **Lưu ý:** các trường này hiện CHƯA được thêm vào form / SP wrapper. Khi triển khai phải xác nhận metadata trong `simba-docs/data/sysDictionaryInfo.md` + SP `asARInsDMKH` thật có hỗ trợ không trước khi ghi dữ liệu.

### Business rules (theo task 038 cũ)

1. **Địa chỉ giao hàng mặc định:** nếu không nhập, lấy `dia_chi` từ DMKH.
2. **Kiểm tra nợ quá hạn:** khi tạo đơn hàng, kiểm tra nợ quá hạn của KH.
3. **Chặn bán hàng:** nếu KH bị chặn (trong DMNHKH), không cho tạo đơn.

## Thay đổi chính (đã có)

- Route `so.dict.ardmkh` (`/so/dict/ardmkh`).
- Component `So\Dict\Ardmkh` (list) + `So\Dict\ArdmkhForm` (form).
- View `resources/views/so/dict/ardmkh.blade.php` + `resources/views/so/dict/ardmkh-form.blade.php`.
- Mapping `SimbaRouteRegistry`, `SimbaDictionaryRegistry`.

## Thay đổi dự kiến (PENDING)

- Bổ sung 4 trường giao hàng (`dia_chi_gh`, `nguoi_nhan`, `dt_nguoi_nhan`, `email_giao_hang`) vào form và SP wrapper (cần verify metadata trước).
- Unit test Livewire riêng cho `So\Dict\Ardmkh` + `So\Dict\ArdmkhForm`.
- Liên kết business rule "chặn bán hàng" từ DMNHKH với SO1/SO3 (chưa có).

## Liên quan

- Task 001 (`001-ar-danh-muc-khach-hang.md`) — đã DONE danh sách KH.
- Task **373** (`373-po-ardmkh-nha-cung-cap.md`) — PO nhà cung cấp (cùng bảng DMKH).
- Task **375** (`375-ca-ardmkh-nhan-vien.md`) — CA nhân viên (cùng bảng DMKH).
- Task 034 (`034-ban-hang-khach-hang-lien-ket-ngan-hang.md`) — KH liên kết ngân hàng, chưa mở rộng CRUD `ARDMKHNGH`/`ARDMKH_NH`.
- Task 037 (`037-ban-hang-khach-hang-lien-ket-ma-thanh-toan.md`) — KH liên kết mã thanh toán.

## Kiểm chứng

- `php -l` pass cho component + view (đã verify ở session cũ).
- `SourceRouteCoverageTest` expectation cho `so.dict.ardmkh` pass.
- Có unit test cơ bản tại `tests/Unit/Packages/Catalog/ArdmkhFormTest.php`; cần bổ sung Livewire create/edit với DB test.
