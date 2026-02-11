# Laravel Disreg

Package vô hiệu hóa đăng ký trong Laravel.

## Mô tả

Disable Laravel registration (lấy từ composer.json).

## Chức năng chính

- Cung cấp middleware `DisableRegistrationMiddleware` để chặn truy cập route `/register`.
- Đăng ký middleware với alias `disable.register`.
- Khi truy cập route `/register`, trả về HTTP 403 với thông báo "Registration is disabled."

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-disreg
```

Package tự động đăng ký ServiceProvider.

Áp dụng middleware trong `app/Http/Kernel.php` hoặc trong route:

```php
// Trong route
Route::middleware('disable.register')->group(function () {
    // Các route cần chặn đăng ký
});

// Hoặc áp dụng global
protected $middlewareGroups = [
    'web' => [
        // ...
        \Diepxuan\DisableRegistration\Http\Middleware\DisableRegistrationMiddleware::class,
    ],
];
```

## Cấu trúc thư mục

```
laravel-disreg/
├── src/
│   ├── Http/
│   │   └── Middleware/
│   │       └── DisableRegistrationMiddleware.php
│   └── Providers/
│       └── DisableRegistrationServiceProvider.php
└── composer.json
```

## Liên kết đến các package liên quan

Không có dependency.

## Ghi chú

Package nhỏ, hữu ích cho hệ thống không cho phép người dùng tự đăng ký.