# Laravel Log

Log custom channel cho Laravel.

## Mô tả ngắn gọn

Custom Channel Log for Laravel. Package cung cấp class Log để ghi log theo channel, mỗi channel lưu vào file riêng.

## Chức năng chính

- Cung cấp class `Diepxuan\Log\Log` để ghi log theo channel (mỗi channel là một file log riêng).
- Hỗ trợ tất cả các mức độ log: debug, info, notice, warning, error, critical, alert, emergency.
- Tự động tạo file log tại `storage/logs/{channel}.log`.
- Sử dụng Monolog `StreamHandler` với `LineFormatter`.
- Đăng ký singleton trong ServiceProvider, tự động đăng ký với Laravel.

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-log
```

Package tự động đăng ký ServiceProvider.

Sử dụng trong code:

```php
use Diepxuan\Log\Log;

$log = app(Log::class);
$log->info('channel-name', 'Message log', ['context' => 'value']);
// Hoặc các phương thức khác: debug, notice, warning, error, critical, alert, emergency.
```

## Cấu trúc thư mục

```
laravel-log/
├── config/
│   └── config.php          # Cấu hình package
├── src/
│   ├── Log.php             # Class Log chính
│   └── Providers/
│       └── ServiceProvider.php
├── .editorconfig
├── .gitignore
├── .php-cs-fixer.dist.php
├── LICENSE
├── README.md
└── composer.json
```

## Liên kết đến các package liên quan

- monolog/monolog (dependency ngầm của Laravel)

## Ghi chú

Package hữu ích khi muốn phân tách log thành nhiều file theo từng channel (ví dụ: log riêng cho từng module).