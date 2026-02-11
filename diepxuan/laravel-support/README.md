# Laravel Support

Package hỗ trợ và tiện ích cho Laravel.

## Mô tả ngắn gọn

Cung cấp các công cụ hỗ trợ cho developer trong hệ thống DX, bao gồm mở rộng Collection và command tự động quản lý npm.

## Chức năng chính

- Cung cấp class `Collection` mở rộng từ `Illuminate\Support\Collection` với phương thức `toMarkdownTable` để chuyển collection thành bảng markdown (hỗ trợ UTF-8, căn chỉnh cột).
- Cung cấp command `app:dev:npm` tự động chạy `npm install` (nếu thiếu node_modules) và khởi động `npm run watch` ở background, quản lý PID file tránh trùng lặp process.
- Tích hợp với Laravel scheduling (command tự động chạy mỗi phút) để đảm bảo npm watch luôn chạy.
- Hỗ trợ xử lý charset thông qua dependency php-charset.

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-support
```

Package không có ServiceProvider, cần đăng ký command thủ công trong `app/Console/Kernel.php` nếu muốn sử dụng command:

```php
protected $commands = [
    \Diepxuan\Support\Commands\Npm::class,
];
```

Sử dụng Collection:

```php
use Diepxuan\Support\Collection;

$collection = new Collection([['name' => 'John', 'age' => 30], ...]);
echo $collection->toMarkdownTable(['name' => 'Tên', 'age' => 'Tuổi']);
```

Sử dụng command Npm:

```bash
php artisan app:dev:npm
```

Command sẽ kiểm tra node_modules, cài đặt nếu cần, và khởi chạy npm run watch với PID lưu tại `storage/watch.pid`.

## Cấu trúc thư mục

```
laravel-support/
├── config/
│   └── config.php                 # Cấu hình package (chỉ có name và namespace)
├── src/
│   ├── Collection.php             # Class Collection mở rộng
│   └── Commands/
│       └── Npm.php                # Command npm tự động
├── .editorconfig
├── .gitignore
├── .php-cs-fixer.dist.php
├── LICENSE
├── README.md
└── composer.json
```

## Liên kết đến các package liên quan

- diepxuan/php-charset (xử lý charset)
- diepxuan/laravel-core (core chung)

## Ghi chú

Package hỗ trợ các tiện ích nhỏ nhưng hữu ích cho quá trình phát triển, đặc biệt là command npm tự động giúp duy trì watch mode cho frontend assets. Collection markdown table hữu ích cho việc generate report trong console.