# Kiến trúc hệ thống Portal

Portal là một ứng dụng Laravel 11 được module hóa bằng **14 package nội bộ** nằm trong thư mục `diepxuan/`. Tài liệu này mô tả kiến trúc tổng thể, luồng dữ liệu và cách các thành phần tương tác.

## 1. Tổng quan kiến trúc

```
┌─────────────────────────────────────────────────────────────┐
│                     Portal (Laravel 11)                     │
│  ┌─────────────┐  ┌─────────────┐  ┌───────────────────┐  │
│  │   App       │  │   Routes    │  │   Config          │  │
│  │   (Livewire)│  │   (web,api) │  │   (database,      │  │
│  │             │  │             │  │    cache, ...)    │  │
│  └─────────────┘  └─────────────┘  └───────────────────┘  │
│                  │                                         │
│                  ▼                                         │
│  ┌─────────────────────────────────────────────────────┐  │
│  │               diepxuan/* (14 packages)              │  │
│  │  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐  │  │
│  │  │ laravel‑core│  │laravel‑catalog│ │laravel‑magento│ │  │
│  │  │ (auto‑disco)│  │   (catalog)  │ │  (Magento   │ │  │
│  │  └─────────────┘  └─────────────┘  │   API)      │ │  │
│  │  ┌─────────────┐  ┌─────────────┐  └─────────────┘  │  │
│  │  │laravel‑support││laravel‑scavenger│ ... (11 packages)│  │
│  │  └─────────────┘  └─────────────┘                   │  │
│  └─────────────────────────────────────────────────────┘  │
│                  │                                         │
│                  ▼                                         │
│  ┌─────────────────────────────────────────────────────┐  │
│  │               External Services                     │  │
│  │  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐│  │
│  │  │ MySQL   │  │ Redis   │  │ Magento │  │ Gmail   ││  │
│  │  │ (RDS)   │  │ (Cache) │  │ (API)   │  │ (API)   ││  │
│  │  └─────────┘  └─────────┘  └─────────┘  └─────────┘│  │
│  └─────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

## 2. Luồng dữ liệu chính

### 2.1. Luồng xử lý request HTTP
```
Request → web.php (routes) → Middleware → Controller/Livewire
      ↓
Gọi service từ package diepxuan (ví dụ: CatalogService, MagentoClient)
      ↓
Truy vấn database (MySQL) / gọi API ngoài (Magento, Gmail, RonaldJack)
      ↓
Trả response (View/JSON)
```

### 2.2. Luồng xử lý background job (queue)
```
Command/Schedule → Job → Queue (sync/database/redis)
      ↓
Xử lý job (scraping, sync với Magento, gửi mail)
      ↓
Ghi log vào custom channel (laravel‑log)
```

### 2.3. Luồng auto‑discovery (laravel‑core)
```
App boot → Package::list() → quét tất cả package
      ↓
Package::getCommands() → đăng ký commands
      ↓
Package::livewireComponentNamespace() → đăng ký Livewire components
      ↓
Package::bladeComponentNamespace() → đăng ký Blade components
```

## 3. Các thành phần cốt lõi

### 3.1. Laravel Core (`laravel‑core`)
- **Package::list()**: Lấy danh sách package diepxuan đã cài (dùng `Composer\InstalledVersions`).
- **Package::path() / source()**: Resolve đường dẫn vật lý của package.
- **Auto‑discovery commands, Livewire, Blade components** (xem chi tiết trong `PACKAGES.md`).
- **Service provider chính**: `Diepxuan\Core\Providers\ServiceProvider` đăng ký tất cả provider con.

### 3.2. Database & Eloquent
- **Driver**: MySQL (`DB_CONNECTION=mysql`).
- **Host**: `mysql.diepxuan.corp:3306`.
- **Mô hình mở rộng**: `laravel‑eloquent‑composite` cung cấp composite model support.
- **Migration**: Mỗi package có thư mục `database/migrations/`, được load bởi `MigrationServiceProvider`.

### 3.3. Cache & Session
- **Cache driver**: File (`CACHE_DRIVER=file`) – có thể chuyển thành Redis trong production.
- **Session driver**: Database (`SESSION_DRIVER=database`) – lưu session trong bảng `sessions`.
- **Session lifetime**: 120 phút.

### 3.4. Queue
- **Queue connection**: Sync (`QUEUE_CONNECTION=sync`) – chạy ngay trong request.
- **Có thể chuyển sang database/redis** để xử lý background.

### 3.5. Mail
- **Mailer**: SMTP (`MAIL_MAILER=smtp`).
- **Development**: Dùng Mailpit (`MAIL_HOST=mailpit:1025`) trong môi trường dev.
- **Production**: Cấu hình SMTP thật qua biến môi trường.

### 3.6. Logging
- **Log channel**: Stack (`LOG_CHANNEL=stack`).
- **Custom channel**: Package `laravel‑log` cung cấp channel tùy chỉnh.
- **Log level**: Debug (`LOG_LEVEL=debug`) trong dev.

## 4. Tích hợp với dịch vụ ngoài

### 4.1. Magento (OAuth 1.0)
- **Package**: `laravel‑magento`.
- **Flow**: Lấy OAuth token → gọi Magento REST API (products, orders, customers).
- **Authentication**: Token lưu trong database, refresh tự động.

### 4.2. Gmail API
- **Package**: `laravel‑gmail`.
- **Flow**: OAuth2 với Google, lưu credential, fetch/send email.
- **Dùng cho**: Notification, auto‑reply, ticket system.

### 4.3. Ronald Jack SDK
- **Package**: `laravel‑ronaldjack`.
- **Flow**: Gọi API của Ronald Jack (hệ thống CRM/ERP nội bộ).

### 4.4. Scraping (web crawler)
- **Package**: `laravel‑scavenger`.
- **Flow**: Crawl website → parse HTML → lưu dữ liệu vào database.
- **Hỗ trợ charset**: Dùng `php‑charset` để chuyển đổi tiếng Việt.

## 5. Security

- **Authentication**: Laravel Jetstream (Livewire stack) + Sanctum cho API.
- **Authorization**: Policies, Gates.
- **Environment**: Biến nhạy cảm lưu trong `.env`, key được mask bằng helper `maskKey()`.
- **API keys**: Lưu trong database, encrypted.

## 6. Deployment & Scaling

- **Web server**: Nginx + PHP‑FPM.
- **Database**: MySQL có thể tách riêng server.
- **Cache**: Có thể chuyển sang Redis để scaling.
- **Queue**: Có thể chuyển sang Redis hoặc database để xử lý background.
- **File storage**: Local (có thể chuyển sang S3 nếu cần).

## 7. Monitoring & Debug

- **Debug bar**: Barryvdh Laravel Debugbar (dev only).
- **Log**: Tập trung tại `storage/logs/laravel.log`.
- **Tracing**: Có thể tích hợp với Sentry/DataDog nếu cần.

---
*Kiến trúc này dựa trên code hiện tại và cấu hình môi trường dev (2026‑02‑11).*