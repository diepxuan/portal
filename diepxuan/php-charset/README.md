# PHP Charset

Chuyển đổi ký tự tiếng Việt giữa các bảng mã.

## Mô tả ngắn gọn

A php package that converts Vietnamese characters into different character set. Package cung cấp công cụ chuyển đổi giữa các bảng mã tiếng Việt phổ biến (unicode, ascii, virq, vnet, vni) và chuẩn hóa UTF-8.

## Chức năng chính

- Cung cấp class `vn_charset_conversion` (từ thư viện của Kenny Ngo) để chuyển đổi giữa các bảng mã tiếng Việt.
- Cung cấp class `VnEncoding` wrapper với interface hướng đối tượng, tự động normalize UTF-8.
- Cung cấp helper `vn_convert_encoding($string, $from, $to)` để chuyển đổi nhanh.
- Hỗ trợ các bảng mã: unicode, ascii, virq, vnet, vni.
- Hàm `normalize_to_utf8` để chuẩn hóa văn bản về UTF-8 (detect encoding, chuyển đổi, loại bỏ ký tự điều khiển).

## Cài đặt / Sử dụng

```bash
composer require diepxuan/php-charset
```

Sử dụng helper:

```php
echo vn_convert_encoding('Tôi tên là Ngô Chí Dũng.', 'unicode', 'ascii');
// Output: Toi ten la Ngo Chi Dung.

echo vn_convert_encoding('Toi ten la Ngo Chi Dung.', 'ascii', 'unicode');
// Output: Tôi tên là Ngô Chí Dũng.
```

Sử dụng class:

```php
use Diepxuan\Charset\VnEncoding;

$encoded = (string) new VnEncoding('Tôi tên là Ngô Chí Dũng.', 'unicode', 'virq');
```

Chuẩn hóa UTF-8:

```php
$normalized = normalize_to_utf8($text);
```

## Cấu trúc thư mục

```
php-charset/
├── src/
│   └── VnEncoding.php                 # Class wrapper
├── helpers.php                         # Helper functions
├── vn_charset_conversion.php           # Core conversion class (từ kenny-ngo/vietnamese-converter)
├── .editorconfig
├── .gitignore
├── .php-cs-fixer.dist.php
├── LICENSE
├── README.md
└── composer.json
```

## Liên kết đến các package liên quan

Không có dependency. Dựa trên thư viện `kenny-ngo/vietnamese-converter`.

## Ghi chú

Package này dựa trên thư viện `kenny-ngo/vietnamese-converter`. Hữu ích cho việc xử lý văn bản tiếng Việt trong các hệ thống cần chuyển đổi bảng mã, đặc biệt khi làm việc với dữ liệu từ nhiều nguồn (CSV, database cũ) với encoding khác nhau. Hàm `normalize_to_utf8` giúp đảm bảo văn bản luôn ở UTF-8 chuẩn.