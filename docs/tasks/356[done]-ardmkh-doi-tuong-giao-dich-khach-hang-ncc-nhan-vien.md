# Task 356: Hoàn thiện nhóm ARDMKH đối tượng giao dịch

## Trạng thái

Done - 2026-06-05.

## Phạm vi

Hoàn thiện nhóm menu/dictionary dùng chung bảng Simba `ARDMKH` / form `frmARDMKH`:

| Simba menu | Portal route | Đối tượng | Dictionary | Ghi chú |
|------------|--------------|-----------|------------|---------|
| `06.90.02` | `ar.khachhang` | Khách hàng / người mua | `MA_KH` | Đã có danh sách, thêm, sửa, xóa |
| `10.90.22` | `po.cungcap` / `ar.cungcap` | Nhà cung cấp / người bán | `MA_NCC` | Bổ sung thêm, sửa, xóa |
| `04.90.05` | `ca.nhanvien` | Nhân viên | `MA_NV` | Bổ sung danh sách, thêm, sửa, xóa |

## Nguồn Simba đã dùng

- `simba-docs/data/sysMenu.md`
  - `06.90.02` - Danh mục khách hàng.
  - `10.90.22` - Danh mục nhà cung cấp.
  - `04.90.05` - Danh mục nhân viên.
- `simba-docs/data/sysDictionaryInfo.md`
  - Các menu trên cùng trỏ nhóm ARDMKH / `frmARDMKH`.
- Stored procedures có sẵn:
  - `asARGetDMKH`: tham số `pModuleId` phân loại `AR` khách hàng, `AP` nhà cung cấp, `CA` nhân viên.
  - `asARInsDMKH`, `asARUpdDMKH`, `asARDelDMKH`: lưu/xóa mềm theo field cờ `pIskh`, `pIsncc`, `pIsnv`.

## Thay đổi chính

### Route/menu

- Bổ sung route nhân viên:
  - `/cash/nhanvien` -> `ca.nhanvien`.
  - `/cash/nhanvien/create` -> `ca.nhanvien.create`.
  - `/cash/nhanvien/edit/{id}` -> `ca.nhanvien.edit`.
- Bổ sung route CRUD nhà cung cấp:
  - `/muahang/nhacungcap/create` -> `po.cungcap.create`.
  - `/muahang/nhacungcap/edit/{id}` -> `po.cungcap.edit`.
- Bổ sung mapping vào registry:
  - `SimbaRouteRegistry`: `ca.nhanvien` -> menu `04.90.05`.
  - `SimbaDictionaryRegistry`: `ca.nhanvien` -> `MA_NV` / `ARDMKH`.

### Component/view

- `Muahang\Cungcap`: bổ sung delete action và action buttons trên view.
- `Muahang\CungcapForm`: form thêm/sửa nhà cung cấp dùng `pModuleId=AP`, set `pIsncc=1`.
- `Cash\Danhmuc\Nhanvien`: danh sách nhân viên dùng `pModuleId=CA`.
- `Cash\Danhmuc\NhanvienForm`: form thêm/sửa nhân viên, set `pIsnv=1`.

## Liên quan task cũ

- Task 001: danh mục khách hàng.
- Task 038: khách hàng thêm/sửa/xóa.
- Task 034: khách hàng liên kết ngân hàng, hiện vẫn là shell/task docs; chưa mở rộng thành CRUD ngân hàng khách hàng vì cần xác nhận metadata chi tiết `ARDMKHNGH`/`ARDMKH_NH` trước khi ghi dữ liệu.
- Task 210: danh mục nhân viên kinh doanh; task này bổ sung lớp danh mục nhân viên ARDMKH theo Simba menu `04.90.05`.

## Kiểm chứng

- `php -l` pass cho các file PHP được sửa/thêm.
- Không tạo bảng mới, không ALTER/INSERT SQL, không tự đặt tên SP/table/field ngoài metadata đã có.
