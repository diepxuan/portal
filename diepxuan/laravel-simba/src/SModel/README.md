# Simba SModel layer

Thư mục này chứa các model raw/table schema của SimbaERP.

## Vai trò

`SModel` là lớp thấp nhất phản ánh trực tiếp cấu trúc bảng SQL Server của SimbaERP. Mỗi `*Model.php` tương ứng với một bảng vật lý trong Simba và chỉ nên giữ thông tin schema/kết nối cần thiết để Eloquent đọc/ghi đúng bảng.

## Được phép đặt tại đây

- Connection SQL Server / Simba connection.
- Tên bảng (`$table`).
- Primary key (`$primaryKey`).
- Key type, incrementing, timestamps.
- Fillable/guarded theo cột thật của bảng.
- Casts/date format thuần schema.
- Helper nền an toàn phục vụ kết nối hoặc metadata kỹ thuật chung.

## Không đặt tại đây

- Business logic.
- Query scope mang ý nghĩa nghiệp vụ.
- Accessor/mutator có domain meaning.
- Relation nghiệp vụ giữa các model.
- Stored procedure orchestration.
- Logic route/auth/session/request/UI.
- Logic phục vụ Portal/Catalog use-case.

## Quy tắc cập nhật

- Không tự đặt tên bảng/cột/SP. Nguồn sự thật là `simba-docs/tables` và các tài liệu Simba readonly liên quan.
- Nếu cần thêm behavior cho một bảng Simba, không thêm vào `SModel`; tạo hoặc sửa model tương ứng trong `diepxuan/laravel-simba/src/Models` nếu đó là helper/query trực tiếp sát bảng.
- Nếu behavior đã mang ngữ cảnh Portal/Catalog, workflow, UI, chính sách nghiệp vụ, hoặc use-case cụ thể, chuyển sang package `diepxuan/laravel-catalog`.

## Tóm tắt

`SModel` = raw/generated DB schema only.

Mọi logic behavior không thuộc schema phải nằm ngoài thư mục này.
