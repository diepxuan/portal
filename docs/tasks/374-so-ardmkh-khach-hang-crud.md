# Task 374: SO ARDMKH — Danh mục khách hàng CRUD (góc nhìn bán hàng)

## Nhóm

SO (Sales Order — Đơn hàng bán) / dictionary chung ARDMKH

## Mục tiêu

Hoàn thiện danh mục khách hàng phục vụ nghiệp vụ bán hàng, dùng chung bảng Simba `ARDMKH` / form `frmARDMKH`, phân loại `pModuleId=AR`, cờ `pIskh=1`. CRUD đầy đủ (xem, thêm, sửa, xóa) với SP wrappers chuẩn.

## Trạng thái

- **Status:** PENDING (route + component + view đã có, thiếu unit test Livewire riêng + gắn với task 001)
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
| `GET /simba/so/dict/ardmkh` | `so.dict.ardmkh` | `Banhang\Khachhang` |
| `GET /simba/so/dict/ardmkh/create` | `so.dict.ardmkh.create` | `So\Dict\ArdmkhForm` |
| `GET /simba/so/dict/ardmkh/{id}/edit` | `so.dict.ardmkh.edit` | `So\Dict\ArdmkhForm` |

URL thật: `http://portal.diepxuan.corp/simba/so/dict/ardmkh`

### Component

- `Banhang\Khachhang` (index): search, paginate, `deleteDoiTuong(maKh)`.
- `Banhang\KhachhangForm`: mode create/edit, `save()` chọn `AsARInsDMKH` / `AsARUpdDMKH` theo mode với `pIskh=1, pIsncc=0, pIsnv=0`.

### View

- `resources/views/banhang/khachhang.blade.php`: danh sách KH.
- `resources/views/banhang/khachhang-form.blade.php`: form thêm/sửa.

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
- Component `Banhang\Khachhang` (list) + `Banhang\KhachhangForm` (form).
- View `resources/views/banhang/khachhang.blade.php` + `khachhang-form.blade.php`.
- Mapping `SimbaRouteRegistry`, `SimbaDictionaryRegistry`.

## Thay đổi dự kiến (PENDING)

- Bổ sung 4 trường giao hàng (`dia_chi_gh`, `nguoi_nhan`, `dt_nguoi_nhan`, `email_giao_hang`) vào form và SP wrapper (cần verify metadata trước).
- Unit test Livewire riêng cho `Banhang\Khachhang` + `Banhang\KhachhangForm`.
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
- Không có unit test riêng cho `Banhang\Khachhang` / `Banhang\KhachhangForm` — cần bổ sung.
