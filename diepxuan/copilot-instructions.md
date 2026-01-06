# Hướng dẫn AI Agent cho thư mục diepxuan/

Mục đích: cung cấp hướng dẫn ngắn gọn, chính xác cho AI agents/collaborators khi làm việc chỉ trong thư mục `diepxuan/`.

1. Phạm vi công việc

-   Chỉ thay đổi và tạo file bên trong thư mục `diepxuan/` và các phụ thư mục của nó.
-   Không sửa file ngoài phạm vi này (ví dụ: `app/`, `routes/`, `.github/`, v.v.) trừ khi được phép rõ ràng.

2. Ngữ cảnh nhanh

-   `diepxuan/` chứa một loạt các package Laravel nhỏ được include qua Composer `path` repositories. Các package này thường là thư viện nội bộ được symlinked vào ứng dụng chính.
-   Thay đổi trong `diepxuan/*` sẽ ảnh hưởng trực tiếp khi composer autoload dùng symlink.

3. Quy trình làm việc cơ bản

-   Lấy môi trường dev: chạy các lệnh dự án từ root khi cần (ví dụ `composer dump-autoload`) nhưng chỉ sửa code trong `diepxuan/`.
-   Khi thay đổi composer.json của một package nội bộ, chạy `composer dump-autoload` từ root để cập nhật autoloader.

4. Tập trung khi sửa package

-   Giữ thay đổi nhỏ, tập trung, và có test nếu khả thi.
-   Tôn trọng các public API hiện có: tránh đổi tên lớp, contract, hay signature nếu không cần thiết.

5. Test & kiểm tra

-   Nếu package có unit tests, chạy từng package bằng `vendor/bin/phpunit --testsuite=...` hoặc chạy toàn bộ test suite từ root khi cần.
-   Chỉ sửa hay thêm mới test liên quan đến thay đổi thực tế.

6. Tiêu chuẩn mã và commit

-   Tuân thủ coding style của repo cha (ví dụ PHP 8+, strict types khi cần) và giữ code rõ ràng, có type hints.
-   Viết commit messages ngắn gọn: `<package>: mô tả thay đổi`.

7. Cách debug nhanh

-   Sau sửa file trong `diepxuan/*`, từ project root chạy:

```
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

8. Khi cần thay đổi cấu hình composer (path repository)

-   Chỉ sửa file `composer.json` trong package khi bắt buộc, rồi thông báo để chạy `composer update` hoặc `composer dump-autoload` ở root.

9. Gợi ý khi mở PR

-   Mô tả phạm vi thay đổi, file sửa trong `diepxuan/`, ảnh hưởng tới package nào, và cách kiểm thử.
-   Nếu thay đổi ảnh hưởng tới behavior toàn hệ thống, ghi rõ các bước reproduce ở ứng dụng chính.

10. Liên hệ và notes

-   Nếu không chắc một thay đổi có an toàn hay không, hỏi maintainers hoặc mở issue trước khi merge.
