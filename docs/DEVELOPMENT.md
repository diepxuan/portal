# Hướng dẫn phát triển Portal

Tài liệu này hướng dẫn thiết lập môi trường phát triển (development) cho ứng dụng Portal trên máy local. Trước khi code, đọc thêm [Project Conventions](PROJECT_CONVENTIONS.md) để nắm các quy ước bắt buộc (`ksd`, canonical dictionary).

## 1. Yêu cầu hệ thống

**Trên máy dev/agent** (môi trường code, không nối trực tiếp DB):

- **PHP**: ^8.2 (khuyến nghị 8.2+)
- **Composer**: 2.6+ (CI dùng 2.11.x)
- **Node.js**: 18+ (cho Vite, build frontend)
- **Git**: 2.30+

**Trên môi trường có kết nối DB** (web server, deploy):

- **SQL Server**: DB nghiệp vụ Simba, truy cập qua connection `sqlsrv`
- **MySQL**: 8.0+ cho DB ứng dụng Laravel (users/sessions/jobs)
- **Microsoft ODBC Driver 18 for SQL Server**: cần cho `sqlsrv` — chỉ cài trên máy
  chủ có kết nối DB, không phải máy dev/agent

> Máy dev **không** kết nối trực tiếp database; xem mục 4.1 để biết cách làm việc
> với dữ liệu trong mô hình này.

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

### 3.2. Cấu hình database

Portal dùng **2 kết nối**, khai báo trong `config/database.php`:

| Kết nối | Dùng cho | Connection name |
|---|---|---|
| MySQL (`DB_*`) | users, sessions, jobs, cache của Laravel | `mysql` (mặc định) |
| SQL Server (`SQLSRV_*`) | DB nghiệp vụ Simba, đọc/ghi qua SP wrapper | `sqlsrv` |

Tên biến thật trong config:

```
DB_CONNECTION / DB_HOST / DB_PORT / DB_DATABASE / DB_USERNAME / DB_PASSWORD
SQLSRV_HOST / SQLSRV_PORT / SQLSRV_DATABASE / SQLSRV_USERNAME / SQLSRV_PASSWORD
SQLSRV_URL        # tùy chọn, ghi đè toàn bộ DSN
```

Model Simba luôn dùng connection `sqlsrv`
(`Diepxuan\Simba\Traits\HasSimbaConnection::getSimbaConnectionName()` →
`config('simba.connection', 'sqlsrv')`). Khóa `simba.connection` **chưa được khai báo**
trong `diepxuan/laravel-simba/config/simba.php`, nên luôn rơi về `sqlsrv`.

> **Máy dev/agent không cần và không nên cấu hình DB.** File `.env` trên máy dev
> không mở được kết nối DB (xem mục 4.1). Credential DB chỉ đặt trên môi trường có
> kết nối thật (web server/deploy), không commit và không khai báo trên máy dev.

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

## 4. Database trong môi trường phát triển

### 4.1. Nguyên tắc: máy dev KHÔNG kết nối trực tiếp DB

Máy phát triển (và agent/CI chạy trên đó) **không có kết nối trực tiếp tới database**.
Đây là **đặc điểm thiết kế của môi trường**, không phải thiếu cài đặt và không phải
việc cần khắc phục:

- Database chỉ truy cập được **qua web server** đã cấu hình sẵn
  (`http://portal.diepxuan.corp`) — nơi PHP-FPM có đường kết nối tới DB.
- Process PHP chạy trên máy dev (CLI) không đi qua web server đó, nên không có
  đường tới DB.

Hệ quả trực tiếp: mọi thao tác database từ shell **không thuộc phạm vi sử dụng** trên
máy này. Không cần cố gắng làm chúng chạy được.

### 4.2. Việc KHÔNG làm từ shell

| Lệnh | Vì sao không dùng |
|---|---|
| `php artisan migrate` | cần kết nối DB từ process CLI |
| `php artisan db:seed` / `db:*` | như trên |
| `php artisan tinker` (khi chạm model/SP) | như trên |
| `sqlcmd`, script PHP gọi SP | như trên |

Nếu cố chạy, sẽ gặp lỗi kết nối:
`SQLSTATE[IMSSP]: This extension requires the Microsoft ODBC Driver for SQL Server
to communicate with SQL Server`. Đây là dấu hiệu đúng là bạn đang cố vượt ra ngoài
phạm vi môi trường — dừng lại và chuyển sang browser.

### 4.3. Cách đúng để làm việc với dữ liệu

- **Kiểm chứng dữ liệu, luồng nghiệp vụ, UI:** dùng browser thật trên
  `http://portal.diepxuan.corp` + prefix `/simba`. Đây là kênh duy nhất đi qua
  web server có kết nối DB.
- **Đọc/ghi dữ liệu để verify:** mở đúng màn hình Portal, thao tác như người dùng,
  đọc kết quả từ DOM/message.
- **Viết test:** `vendor/bin/phpunit` chỉ dùng cho **unit test thuần logic**
  (không chạm model/SP). Test cần DB/SP phải verify bằng browser E2E.
- **Cần biết schema/field/SP:** đọc `simba-docs/` (nguồn sự thật), không query DB.

### 4.4. Thiết lập database (chỉ cho môi trường có kết nối DB)

Phần này dành cho máy chủ/môi trường **có kết nối DB trực tiếp** (deploy, staging có
DB local). Agent và máy dev thường không chạy các bước này.

```sql
CREATE DATABASE portal_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
php artisan migrate
php artisan db:seed    # nếu có seeder
```

Nếu cần chạy các lệnh trên, thực hiện trên máy có kết nối DB, không phải từ shell
của máy dev/agent.

Chi tiết policy môi trường: `TOOLS.md` §"Môi trường thực thi: KHÔNG dùng DB từ shell".

## 5. Chạy ứng dụng

### 5.0. Domain kiểm thử website

Khi cần truy cập website để kiểm thử luồng Portal/SimbaERP, dùng domain dự án:

```text
http://portal.diepxuan.corp
```

Không tự thay bằng `localhost`, `127.0.0.1` hoặc port dev server riêng cho bước website verification, trừ khi Sếp yêu cầu rõ là test local server.

**Lưu ý cho AI agent:** `portal.diepxuan.corp` là local domain đã được cấu hình sẵn. Không tự chạy `php artisan serve`, `php artisan serve:dev`, `npm run dev` hoặc `./portal-dev.sh start` chỉ vì `serve:dev:status` báo stopped/no PID file. Lệnh status đó chỉ kiểm tra process do `serve:dev` quản lý, không phải nguồn sự thật về local domain/proxy đang chạy. Muốn kiểm tra website thì truy cập trực tiếp `portal.diepxuan.corp`; chỉ start/restart server khi Sếp yêu cầu rõ.

### 5.1. Generate application key
```bash
php artisan key:generate
```

### 5.2. Chạy development server với serve:dev commands (Recommended)
**Cách 1: Dùng portal-dev.sh wrapper (đơn giản nhất)**
```bash
# Start development environment
./portal-dev.sh start

# Check status
./portal-dev.sh status

# Stop everything
./portal-dev.sh stop

# Health check with auto-recovery
./portal-dev.sh health --fix

# Install as systemd service
sudo ./portal-dev.sh start --service
```

**Cách 2: Dùng artisan commands trực tiếp**
```bash
# Start Laravel + Vite servers
php artisan serve:dev

# Check status
php artisan serve:dev:status

# Stop servers
php artisan serve:dev:stop

# Health check
php artisan serve:dev:health --fix

# Systemd service management
sudo php artisan serve:dev:service install
```

**Cách 3: Dùng Laravel dev server truyền thống**
```bash
php artisan serve --port=8000
```

**Cách 4: Dùng Docker (Laravel Sail)**
```bash
./vendor/bin/sail up -d
```

**Cách 5: Dùng docker‑compose có sẵn** (có tailscale gateway)
```bash
docker-compose up -d
```

### 5.3. Chạy Vite dev server (frontend) - nếu dùng cách 3
```bash
npm run dev
```

**Lưu ý:** Cách 1 và 2 (serve:dev commands) tự động chạy cả PHP server và Vite server.

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

Chỉ áp dụng cho **unit test thuần logic**. Test có gọi model/SP (chạm DB) không chạy
được trên máy dev — verify các luồng đó bằng browser thật (xem mục 4.1–4.3).

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

### 9.4. Không dùng Tinker để làm việc với dữ liệu

`php artisan tinker` **không phải công cụ dùng được trên máy dev/agent**, vì mọi câu
lệnh chạm model/SP đều cần kết nối DB mà máy không có (xem mục 4.1).

Thay thế theo mục đích:

| Mục đích | Cách làm đúng |
|---|---|
| Xem dữ liệu một bảng/danh mục | mở màn hình tương ứng trong Portal (`/simba/...`) |
| Kiểm tra luồng nghiệp vụ | thao tác trên form thật + đọc message/DOM |
| Kiểm tra config/route/class | đọc trực tiếp `config/*.php`, `routes/*.php`, file class |
| Kiểm tra schema/field/SP | đọc `simba-docs/` |

Với câu lệnh chỉ kiểm tra sự tồn tại (không cần DB), dùng `php -l` hoặc `ls` file
thay vì `tinker`.

## 10. Workflow Git

Tuân thủ quy trình trong [AI_AGENT_GUIDE.md](AI_AGENT_GUIDE.md):

1. `git checkout main && git pull origin main`
2. `git checkout -b task/<tên-task>`
3. Sửa code, commit với message: `<package>: mô tả`
4. `git push origin task/<tên-task>`
5. Tạo Pull Request trên GitHub.

---
*Hướng dẫn này dựa trên cấu hình môi trường dev hiện tại (2026‑02‑18).*
