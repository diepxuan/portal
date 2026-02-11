# Laravel Ronald Jack

SDK Ronald Jack cho Laravel.

## Mô tả ngắn gọn

Ronald Jack SDK for Laravel. Package tích hợp với thiết bị chấm công Ronald Jack thông qua thư viện zkemkeeper.dll (COM object) trên Windows.

## Chức năng chính

- Tích hợp với thiết bị chấm công Ronald Jack thông qua thư viện zkemkeeper.dll (COM).
- Cung cấp model Machine để kết nối và tương tác với máy chấm công.
- Cung cấp controller RonaldJackController với các action CRUD cơ bản.
- Sử dụng package core (`diepxuan/laravel-core`) để lấy đường dẫn thư viện.
- Route mẫu cho domain `mcc.diepxuan.io.vn` với middleware clearcache.

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-ronaldjack
```

Package không có ServiceProvider, cần sử dụng thủ công.

Cần có thư viện zkemkeeper.dll trong thư mục libs của package core (đường dẫn: `diepxuan/laravel-core/libs/zkemkeeper.dll`).

Sử dụng model Machine:

```php
use Diepxuan\RonaldJack\Models\Machine;

$machine = new Machine(); // Sẽ khởi tạo COM object từ DLL
```

Controller cung cấp các route để quản lý máy chấm công (cần định nghĩa route riêng nếu không dùng route mặc định). Route mặc định:

```php
Route::domain('mcc.diepxuan.io.vn')->middleware('clearcache')->group(static function (): void {
    Route::get('/', [RonaldJackController::class, 'index']);
});
```

## Cấu trúc thư mục

```
laravel-ronaldjack/
├── config/
│   └── config.php                 # Cấu hình package
├── libs/
│   └── zkemkeeper.dll             # Thư viện DLL (Windows)
├── routes/
│   └── web.php                    # Route mẫu
├── src/
│   ├── Http/Controllers/
│   │   └── RonaldJackController.php
│   └── Models/
│       └── Machine.php
├── .editorconfig
├── .gitignore
├── LICENSE
├── README.md
└── composer.json
```

## Liên kết đến các package liên quan

- diepxuan/laravel-core (để lấy đường dẫn thư viện)

## Ghi chú

Package này dành riêng cho tích hợp với thiết bị chấm công Ronald Jack, chỉ hoạt động trên môi trường Windows có hỗ trợ COM và thư viện zkemkeeper.dll. Cần cài đặt driver và phần mềm Ronald Jack tương thích.