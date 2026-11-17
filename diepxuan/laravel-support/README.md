# Laravel Support

Package hỗ trợ và tiện ích cho Laravel.

## 📚 Documentation

- **Project Docs:** [Serve:Dev Commands](../../docs/project/serve-dev-commands.md) - Development server commands
- **Project Docs:** [Package Namespace Conventions](../../docs/project/package-namespace-conventions.md)

## Mô tả ngắn gọn

Cung cấp các công cụ hỗ trợ cho developer trong hệ thống DX, bao gồm:
- Mở rộng Collection với tiện ích markdown
- Command quản lý npm tự động
- **Hệ thống serve:dev commands** để quản lý development server (Laravel + Vite)

## Chức năng chính

### 1. Collection Extension
- Class `Collection` mở rộng từ `Illuminate\Support\Collection`
- Phương thức `toMarkdownTable` chuyển collection thành bảng markdown (hỗ trợ UTF-8, căn chỉnh cột)

### 2. NPM Management Command
- Command `app:dev:npm` tự động chạy `npm install` (nếu thiếu node_modules)
- Khởi động `npm run watch` ở background
- Quản lý PID file tránh trùng lặp process
- Tích hợp với Laravel scheduling (tự động chạy mỗi phút)

### 3. Serve:Dev Commands (Development Server)
- `serve:dev` - Start Laravel + Vite development servers
- `serve:dev:stop` - Stop development servers
- `serve:dev:status` - Check server status
- `serve:dev:health` - Health check với auto-recovery
- `serve:dev:service` - Systemd service management
- `serve:dev:logs` - View logs real-time

**Xem chi tiết:** [docs/SERVE-DEV-COMMANDS.md](docs/SERVE-DEV-COMMANDS.md)

### 4. Charset Support
- Hỗ trợ xử lý charset thông qua dependency php-charset

### 5. Auto-login nội bộ (dev)
- Middleware `CorpAutoLogin` tự đăng nhập trên môi trường dev nội bộ
- 6 lớp điều kiện fail-safe, không kích hoạt ngoài `APP_ENV=local`
- **Xem chi tiết:** [§Auto-login nội bộ (dev)](#auto-login-nội-bộ-dev)

### 6. Route chẩn đoán chỉ mở khi debug
- Middleware `DebugOnly` chặn route debug (`/check-proxy`, `test/*`) trên production
- Chỉ mở khi `APP_DEBUG=true` **và** `APP_ENV != production`; bị chặn → trả 404
- **Xem chi tiết:** [§Route chẩn đoán chỉ mở khi debug](#route-chẩn-đoán-chỉ-mở-khi-debug)

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-support
```

Package không có ServiceProvider, cần đăng ký command thủ công trong `app/Console/Kernel.php`:

```php
protected $commands = [
    \Diepxuan\Support\Commands\Npm::class,
    \Diepxuan\Support\Commands\ServeDev::class,
    \Diepxuan\Support\Commands\ServeDevStop::class,
    \Diepxuan\Support\Commands\ServeDevStatus::class,
    \Diepxuan\Support\Commands\ServeDevHealth::class,
    \Diepxuan\Support\Commands\ServeDevService::class,
    \Diepxuan\Support\Commands\ServeDevLogs::class,
];
```

### Auto-login nội bộ (dev)

`Diepxuan\Support\Http\Middleware\CorpAutoLogin` tự đăng nhập khi truy cập Portal
trên môi trường dev nội bộ, tránh phải login tay mỗi lần reset DB.

**Đăng ký:** middleware này **không** global; áp trong route group của package dùng
nó (hiện tại `diepxuan/laravel-catalog/routes/web.php`):

```php
use Diepxuan\Support\Http\Middleware\CorpAutoLogin;

Route::middleware([CorpAutoLogin::class])->group(function (): void {
    // routes...
});
```

**Biến môi trường (.env):**

| Biến | Mặc định | Mô tả |
|---|---|---|
| `DX_CORP_AUTO_LOGIN_ENABLED` | `false` | Bật/tắt auto-login (`true` mới dùng) |
| `DX_CORP_AUTO_LOGIN_EMAIL` | `''` | Email user đăng nhập tự động. Rỗng → tắt |
| `DX_CORP_AUTO_LOGIN_HOST_SUFFIX` | `.diepxuan.corp` | Chỉ auto-login khi host kết thúc bằng suffix này |
| `DX_CORP_AUTO_LOGIN_SERVER_ADDR` | `10.0.0.122` | Danh sách IP server được phép, phân tách bằng dấu phẩy |

Ví dụ cấu hình dev:

```dotenv
DX_CORP_AUTO_LOGIN_ENABLED=true
DX_CORP_AUTO_LOGIN_EMAIL=dev@diepxuan.corp
DX_CORP_AUTO_LOGIN_HOST_SUFFIX=.diepxuan.corp
DX_CORP_AUTO_LOGIN_SERVER_ADDR=10.0.0.122
```

**Sáu điều kiện phải đồng thời đúng** (bất kỳ điều kiện nào sai → bỏ qua,
chuyển về trang login thường):

1. `APP_ENV=local`
2. `DX_CORP_AUTO_LOGIN_ENABLED=true`
3. Request hiện tại là guest (chưa đăng nhập)
4. `DX_CORP_AUTO_LOGIN_EMAIL` có giá trị
5. Host khớp `DX_CORP_AUTO_LOGIN_HOST_SUFFIX`
6. Địa chỉ server khớp `DX_CORP_AUTO_LOGIN_SERVER_ADDR`

Thiết kế fail-safe: ngoài môi trường `local` middleware **không bao giờ** auto-login,
nên không có rủi ro kích hoạt nhầm trên production.

**Ghi log:**

- Đăng nhập thành công → `Log::info('Corp auto-login authenticated request.')`
- Không tìm thấy user theo email → `Log::warning(...)` kèm gợi ý kiểm tra email
- Bỏ qua auto-login (khi env local + enabled) → `Log::debug()` ghi đủ 6 điều kiện

**Lưu ý:** `Auth::login($user, true)` bật remember-me, giữ session qua nhiều request.

### Ép HTTPS (`DX_FORCE_HTTPS`)

`SupportServiceProvider` ép scheme `https` cho URL generate. Ngoài môi trường local
luôn ép; trong local đọc `DX_FORCE_HTTPS` (mặc định `true`).

Biến cũ `DX_CORP_AUTO_LOGIN_HTTPS` vẫn được đọc làm fallback để không phá cấu hình
sẵn có, nhưng tên đó **gây nhầm** với `CorpAutoLogin` nên đã đổi thành
`DX_FORCE_HTTPS`.

### Route chẩn đoán chỉ mở khi debug

`Diepxuan\Support\Http\Middleware\DebugOnly` bảo vệ các route **chẩn đoán nội bộ**
khỏi bị truy cập trên production. Đây không phải trang cho người dùng cuối; nếu để
public, chúng làm lộ thông tin hạ tầng (`app_url`, scheme, header proxy, cấu hình
server).

**Đăng ký:** middleware này **không** global; gắn riêng cho route debug cần bảo vệ:

```php
use Diepxuan\Support\Http\Middleware\DebugOnly;

Route::get('/check-proxy', fn () => [...])
    ->middleware([DebugOnly::class]);
```

**Hai điều kiện phải đồng thời đúng:**

| Điều kiện | Ý nghĩa |
|---|---|
| `APP_DEBUG=true` | Đọc qua `config('app.debug')` — tôn trọng config cache khi deploy |
| `APP_ENV != production` | Chặn cả trường hợp bật `APP_DEBUG=true` nhầm trên production |

**Hành vi khi bị chặn:** trả **404** (không phải 403) — route coi như *không tồn tại*,
để không tiết lộ endpoint chẩn đoán đang hiện diện.

**Ghi log:** nếu `APP_DEBUG=true` nhưng vẫn bị chặn (do `APP_ENV=production`),
middleware ghi `Log::warning('Debug-only route bị chặn vì môi trường production.')`
kèm host/path để phát hiện cấu hình mâu thuẫn.

**Route đang được bảo vệ** (`diepxuan/laravel-catalog/routes/web.php`):

- `/check-proxy` — chẩn đoán scheme/proxy
- `test/utf8` — kiểm tra hiển thị UTF-8

**Bật debug trong `.env` dev:**

```dotenv
APP_ENV=local
APP_DEBUG=true
```

> Khi `APP_DEBUG=false` (kể cả ở local), các route này cũng trả 404. Đây là chủ ý:
> route chẩn đoán chỉ dùng khi đang debug.

### Sử dụng Collection

```php
use Diepxuan\Support\Collection;

$collection = new Collection([['name' => 'John', 'age' => 30], ...]);
echo $collection->toMarkdownTable(['name' => 'Tên', 'age' => 'Tuổi']);
```

### Sử dụng NPM Command

```bash
php artisan app:dev:npm
```

Command sẽ kiểm tra node_modules, cài đặt nếu cần, và khởi chạy npm run watch với PID lưu tại `storage/watch.pid`.

### Sử dụng Serve:Dev Commands

```bash
# Start development server
php artisan serve:dev

# Check status
php artisan serve:dev:status

# Health check with auto-fix
php artisan serve:dev:health --fix

# Install as systemd service
sudo php artisan serve:dev:service install

# Stop servers
php artisan serve:dev:stop
```

**Xem chi tiết:** [docs/SERVE-DEV-COMMANDS.md](docs/SERVE-DEV-COMMANDS.md)

## Cấu trúc thư mục

```
laravel-support/
├── config/
│   └── config.php                 # Cấu hình package
├── src/
│   ├── Collection.php             # Class Collection mở rộng
│   └── Commands/
│       ├── Npm.php                # Command npm tự động
│       ├── ServeDev.php           # Main serve:dev command
│       ├── ServeDevStop.php       # Stop command
│       ├── ServeDevStatus.php     # Status command
│       ├── ServeDevHealth.php     # Health check
│       ├── ServeDevService.php    # Service management
│       └── ServeDevLogs.php       # Log viewer
├── docs/
│   ├── CODE-STYLE-AND-FORMATTING.md
│   └── SERVE-DEV-COMMANDS.md      # Serve:dev documentation
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

## Tài liệu

- [Code Style & Formatting](docs/CODE-STYLE-AND-FORMATTING.md)
- [Serve:Dev Commands](docs/SERVE-DEV-COMMANDS.md)

## Ghi chú

Package hỗ trợ các tiện ích nhỏ nhưng hữu ích cho quá trình phát triển:
- Command npm tự động giúp duy trì watch mode cho frontend assets
- Collection markdown table hữu ích cho việc generate report trong console
- Serve:dev commands thay thế hoàn toàn external scripts, tích hợp đầy đủ development server management