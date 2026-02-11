# Laravel Gmail

Client Gmail tùy chỉnh cho Laravel.

## Mô tả ngắn gọn

Custom Gmail client for Laravel (lấy từ composer.json). Package cung cấp tích hợp với Google API Client để làm việc với Gmail API.

## Chức năng chính

- Tích hợp Google API Client (google/apiclient ^2.0) để làm việc với Gmail API.
- Hỗ trợ xác thực OAuth2 cho Gmail.
- Cung cấp các chức năng gửi, nhận, quản lý email qua Gmail API.
- Cấu hình đơn giản qua file config.

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-gmail
```

Package hiện chưa có ServiceProvider tự động đăng ký, cần tự đăng ký trong `config/app.php` hoặc sử dụng trực tiếp.

## Cấu trúc thư mục

```
laravel-gmail/
├── config/
│   └── config.php      # Cấu hình package
├── src/                # Source code (hiện chưa có code)
├── .editorconfig
├── .gitignore
├── .php-cs-fixer.dist.php
├── LICENSE
├── README.md
└── composer.json
```

## Liên kết đến các package liên quan

- google/apiclient (dependency)

## Ghi chú

Package này đang trong giai đoạn phát triển, chưa có source code chính thức. Cần xem xét bổ sung các class và service provider.