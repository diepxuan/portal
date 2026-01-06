# Copilot / AI Agent Instructions

Mục tiêu: Tài liệu này cung cấp chỉ dẫn rõ ràng – mang tính mệnh lệnh cho AI agents / Copilot khi làm việc **chỉ trong thư mục** `diepxuan/`. AI phải tuân thủ nghiêm ngặt phạm vi và quy ước bên dưới.

## Phạm vi BẮT BUỘC

-   CHỈ được tạo mới hoặc chỉnh sửa file trong `diepxuan/` và các thư mục con của `diepxuan/`.
-   KHÔNG được sửa bất kỳ file nào ngoài phạm vi này, bao gồm nhưng không giới hạn: `app/`, `routes/`, `config/`, `database/`, `.github/`, `resources/`, v.v.
-   Chỉ được sửa ngoài phạm vi khi có chỉ dẫn rõ ràng bằng văn bản từ người dùng.
-   Nếu yêu cầu nằm ngoài phạm vi `diepxuan/`, AI phải dừng lại và báo lại thay vì tự ý sửa.

## Ngữ cảnh kỹ thuật cốt lõi

`diepxuan/` chứa các package Laravel nội bộ, được include vào project chính thông qua Composer `path` repositories.
Các package này thường được symlink, vì vậy:

-   Thay đổi code trong `diepxuan/\*` → ảnh hưởng ngay lập tức đến ứng dụng chính.
-   Các package khác không nằm trong `diepxuan/` được coi là thư viện dùng chung, không phải code ứng dụng.

Các package trong `diepxuan/` là code ứng dụng chính và thường có cấu trúc chuẩn của package Laravel:

-   Mã nguồn chính trong `src/`
-   Unit tests trong `tests/`
-   Tài nguyên bổ sung (nếu có) trong các thư mục như `config/`, `database/`, v.v.
-   Các package trong `diepxuan/` có thể có composer.json riêng, định nghĩa namespace autoload, dependencies, v.v.

## Quy trình làm việc CHUẨN

AI phải tuân theo quy trình sau:

-   Chỉnh sửa / tạo file **chỉ trong** `diepxuan/`
-   Nếu thay đổi liên quan autoload hoặc class mới: Yêu cầu chạy từ project root `composer dump-autoload`
-   Không thêm script, config, hay dependency ở root project nếu không được yêu cầu.

## Khi làm việc với từng package

Giữ thay đổi:

-   Nhỏ gọn
-   Có mục đích rõ ràng
-   Tránh ảnh hưởng lan rộng
    KHÔNG thay đổi nếu không cần:
-   Tên class public
-   Namespace
-   Interface / contract
-   Method signature public
    Nếu buộc phải thay đổi public API → phải ghi chú rõ ràng impact.

## Test & xác minh

Nếu package có test:

-   Chỉ sửa test liên quan trực tiếp đến thay đổi
-   Có thể chạy: `vendor/bin/phpunit --testsuite=<package>`

Nếu không có test:

-   Đảm bảo code: Không phá vỡ backward compatibility
-   Có type hints rõ ràng, tuân thủ coding style chung của repo cha
-   tự viết test cho function mới hoặc đang sửa nếu khả thi

## Tiêu chuẩn code

AI phải đảm bảo:

-   PHP >= 8.1 / 8.2 (theo repo cha)
-   Ưu tiên `declare(strict_types=1);` khi phù hợp
-   Code rõ ràng, dễ đọc, tránh magic behavior
-   Tuân thủ coding style chung của Laravel

## Debug nhanh sau khi chỉnh sửa

Sau khi sửa file trong `diepxuan/\*`, đề xuất chạy từ root project:

```
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

## Thay đổi liên quan Composer

-   KHÔNG tự ý chỉnh composer.json của root project
-   Chỉ chỉnh composer.json **bên trong package **`diepxuan/<package_name>` khi thật sự cần
-   Sau đó bắt buộc yêu cầu chạy một trong các lệnh: `composer dump-autoload` hoặc `composer update`

## Hướng dẫn khi tạo PR / thay đổi lớn

-   AI phải mô tả rõ:
-   Package nào trong `diepxuan/` bị ảnh hưởng
-   Danh sách file đã sửa
-   Thay đổi hành vi (nếu có)
-   Cách kiểm thử trong ứng dụng chính
-   Nếu thay đổi có khả năng ảnh hưởng toàn hệ thống → ghi rõ bước reproduce.

## Nguyên tắc an toàn

Khi không chắc chắn một thay đổi có an toàn hay không:

-   Không tự ý đoán
-   Đề xuất hỏi maintainer hoặc mở issue
-   Ưu tiên an toàn và tính ổn định hơn tốc độ.

---

# Tóm tắt cho AI (TL;DR)

-   Chỉ làm việc trong `diepxuan/`
-   Coi mỗi thư mục con là một package độc lập
-   Không phá public API nếu không được phép
-   Nhắc chạy `composer dump-autoload` khi cần
-   Không chắc thì dừng và hỏi
