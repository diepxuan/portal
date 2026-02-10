# Hướng dẫn phát triển Portal

Tài liệu này hướng dẫn thiết lập môi trường phát triển (development) cho ứng dụng Portal trên máy local.

## 1. Yêu cầu hệ thống

- **PHP**: ^8.2 (khuyến nghị 8.2+)
- **Composer**: 2.6+
- **Node.js**: 18+ (cho Vite, build frontend)
- **MySQL**: 8.0+ (hoặc MariaDB 10.5+)
- **Redis**: 7+ (tùy chọn, cache/session/queue)
- **Git**: 2.30+

## 2. Cài đặt ban đầu

### 2.1. Clone repository
```bash
git clone git@github.com:diepxuan/portal.git
cd portal
```

### 2.2. Cài đặt PHP dependencies
```bash
composer install
```

### 2.3. Cài đặt Node.js dependencies
```bash
npm install
```

### 2.4. Sao chép file environment
```bash
cp .env.example .env
```

## 3. Cấu hình environment (`.env`)

Sửa file `.env` với các giá trị phù hợp cho môi trường local:

### 3.1. Cấu hình ứng dụng
```
APP_NAME="Diepxuan Portal"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### 3.2. Cấu hình database (MySQL)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_dev
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3.3. Cấu hình cache & session
```
CACHE_DRIVER=file
SESSION_DRIVER=database
QUEUE_CONNECTION=sync
```

### 3.4. Cấu hình mail (dùng Mailpit cho dev)
```
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3.5. Cấu hình frontend (Vite)
```
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
```

## 4. Thiết lập database

### 4.1. Tạo database
```sql
CREATE DATABASE portal_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4.2. Chạy migrations
```bash
php artisan migrate
```

### 4.3. Chạy seeders (nếu có)
```bash
php artisan db:seed
```

## 5. Chạy ứng dụng

### 5.1. Generate application key
```bash
php artisan key:generate
```

### 5.2. Chạy development server
**Cách 1: Dùng Laravel dev server (PHP artisan)**
```bash
php artisan serve --port=8000
```

**Cách 2: Dùng Docker (Laravel Sail)**
```bash
./vendor/bin/sail up -d
```

**Cách 3: Dùng docker‑compose có sẵn** (có tailscale gateway)
```bash
docker-compose up -d
```

### 5.3. Chạy Vite dev server (frontend)
```bash
npm run dev
```

**Lưu ý:** Cần chạy cả PHP server và Vite server để có đầy đủ assets.

## 6. Cài đặt các service hỗ trợ (optional)

### 6.1. Mailpit (local SMTP)
```bash
# Cài đặt Mailpit
# Trên macOS:
brew install mailpit

# Trên Linux:
wget https://github.com/axllent/mailpit/releases/download/v1.19/mailpit-linux-amd64.tar.gz
tar -xzf mailpit-linux-amd64.tar.gz
sudo mv mailpit /usr/local/bin/

# Chạy Mailpit
mailpit
```

Truy cập http://localhost:8025 để xem email.

### 6.2. Redis (cho cache/session/queue)
```bash
# Cài đặt Redis
# Trên macOS:
brew install redis

# Trên Ubuntu/Debian:
sudo apt install redis-server

# Khởi động Redis
redis-server
```

Sau đó cập nhật `.env`:
```
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 7. Làm việc với package diepxuan

### 7.1. Cấu trúc package
Các package nằm trong `diepxuan/`. Mỗi package là một thư viện Laravel độc lập.

### 7.2. Sau khi sửa code trong `diepxuan/`
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### 7.3. Chạy test cho một package cụ thể
```bash
cd diepxuan/laravel-<package-name>
../../vendor/bin/phpunit
```

### 7.4. Thêm package mới
1. Tạo thư mục `diepxuan/laravel-<name>` với cấu trúc chuẩn.
2. Thêm `composer.json` trong package.
3. Chạy `composer dump-autoload` từ root.

## 8. Debug & Troubleshooting

### 8.1. Xem log
```bash
tail -f storage/logs/laravel.log
```

### 8.2. Clear cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 8.3. Kiểm tra symlink package
```bash
ls -la vendor/diepxuan/
```
Các package phải là symlink trỏ đến `../../diepxuan/`.

### 8.4. Nếu code change không có hiệu lực
1. Chạy `composer dump-autoload`.
2. Chạy `php artisan config:clear`.
3. Restart PHP server/Vite server.

## 9. Công cụ hỗ trợ phát triển

### 9.1. Laravel Debugbar
Đã được cài đặt trong `require‑dev`. Truy cập trang web sẽ thấy debug bar ở bottom.

### 9.2. Laravel Pint (code formatter)
```bash
./vendor/bin/pint
```

### 9.3. PHP‑CS‑Fixer
```bash
./vendor/bin/php-cs-fixer fix
```

### 9.4. Tinker (Laravel REPL)
```bash
php artisan tinker
```

## 10. Workflow Git

Tuân thủ quy trình trong [AI_AGENT_GUIDE.md](AI_AGENT_GUIDE.md):

1. `git checkout main && git pull origin main`
2. `git checkout -b task/<tên-task>`
3. Sửa code, commit với message: `<package>: mô tả`
4. `git push origin task/<tên-task>`
5. Tạo Pull Request trên GitHub.

---
*Hướng dẫn này dựa trên cấu hình môi trường dev hiện tại (2026‑02‑11).*