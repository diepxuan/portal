# Laravel Support - Development Commands

This package provides development environment management commands for Portal projects.

## Installation

The package is already included in the Portal project. To use the development commands:

```bash
# Make sure the package is loaded
composer dump-autoload

# Check available commands
php artisan list | grep dev
```

## Available Commands

### Development Environment Management

```bash
# Start development server
php artisan dev start

# Stop development server  
php artisan dev stop

# Check development status
php artisan dev status

# Start Vite development server
php artisan dev vite

# Build production assets
php artisan dev build

# Fix Vite manifest error
php artisan dev fix

# Setup development environment
php artisan dev setup

# Clean up development files
php artisan dev cleanup
```

### NPM Management

```bash
# Install dependencies and start watch mode
php artisan app:dev:npm
```

## 🎯 Development Workflow

### 1. Start Development Environment
```bash
php artisan dev start
```
This will:
- Fix Vite manifest errors
- Setup development environment
- Start PHP development server (port 8000)
- Ask to start Vite dev server (port 5173)

### 2. Check Status
```bash
php artisan dev status
```
Shows:
- Portal server status
- Vite server status  
- Port availability
- Process IDs

### 3. Build for Production
```bash
php artisan dev build
```
Builds production assets with Vite.

### 4. Clean Up
```bash
php artisan dev cleanup
```
Stops services and removes development files.

## ⚙️ Command Options

### `dev start`
```bash
php artisan dev start --port=9000 --host=127.0.0.1 --no-vite --force
```
- `--port`: Port to run server (default: 8000)
- `--host`: Host to bind server (default: 0.0.0.0)
- `--no-vite`: Don't ask about Vite server
- `--force`: Force start even if port is in use

### `dev status`
```bash
php artisan dev status --port=9000
```
- `--port`: Port to check (default: 8000)

## Automatic Fixes

The `dev fix` command automatically fixes common issues:

### Vite Manifest Error
Creates `public/build/manifest.json` with development assets:
```json
{
  "resources/css/app.css": {
    "file": "assets/app-dev.css",
    "src": "resources/css/app.css",
    "isEntry": true
  },
  "resources/js/app.js": {
    "file": "assets/app-dev.js", 
    "src": "resources/js/app.js",
    "isEntry": true
  }
}
```

### Environment Setup
The `dev setup` command:
1. Creates `.env` from `.env.example`
2. Generates app key if missing
3. Sets up SQLite database
4. Runs migrations
5. Clears cache

## 📁 File Structure

### Created Files
```
storage/app/
├── portal.pid    # Portal server process ID
└── vite.pid      # Vite server process ID

public/build/
├── manifest.json      # Development manifest
└── assets/
    ├── app-dev.css    # Development CSS
    └── app-dev.js     # Development JS
```

### Log Files
```
storage/logs/
├── laravel.log    # Laravel application logs
└── vite.log       # Vite server logs (if started)
```

## 🎨 Development URLs

- **Portal**: http://localhost:8000 (or custom port)
- **Vite**: http://localhost:5173

## 🔄 Integration with Portal

This package is designed to work seamlessly with the Portal project:

### Global Development Script
```bash
# From portal root directory
./portal-dev.sh dev:start
./portal-dev.sh dev:status
```

### Artisan Integration
```bash
# All artisan commands work normally
php artisan migrate
php artisan make:model Post
php artisan queue:work
```

## 🐛 Troubleshooting

### "Command not found"
```bash
# Rebuild autoload
composer dump-autoload

# Check if package is loaded
php artisan package:discover
```

### "Port already in use"
```bash
# Stop existing server
php artisan dev stop

# Or force start on different port
php artisan dev start --port=9000 --force
```

### "Vite not working"
```bash
# Check dependencies
php artisan dev fix
php artisan dev vite

# Or build manually
php artisan dev build
```

### "Artisan not working"
```bash
# Use the global script instead
./portal-dev.sh dev:start
./portal-dev.sh dev:fix
```

## Notes

- Development commands work even if artisan has issues
- PID files are automatically cleaned up
- All commands are safe to run multiple times
- No external web server required (uses PHP built-in server)
- SQLite database for easy development setup

## Quick Start

```bash
# 1. Start development
php artisan dev start

# 2. Check status
php artisan dev status

# 3. Build for production
php artisan dev build

# 4. Clean up
php artisan dev cleanup
```

## 🔗 Related Commands

- `php artisan app:dev:npm` - NPM dependency management
- `php artisan serve` - Basic PHP server (without development features)
- `php artisan npm:dev` - Alternative NPM command

---

**Package**: `diepxuan/laravel-support`  
**Location**: `diepxuan/laravel-support/`  
**Commands**: `Dev`, `Npm`  
**Service Provider**: `SupportServiceProvider`

---

## NEW: Tích hợp Systemd Service (2026-04-05)

### Tổng quan

Lệnh `serve:dev` giờ đây hỗ trợ chạy như một systemd service với quản lý tiến trình và kiểm tra sức khỏe đầy đủ.

### Bắt đầu nhanh

```bash
# Cài đặt như systemd service
sudo php artisan serve:dev --service --health

# Khởi động service
sudo systemctl start portal.service

# Kiểm tra trạng thái
sudo systemctl status portal.service

# Xem logs
journalctl -u portal.service -f
```

### Tùy chọn lệnh

```bash
php artisan serve:dev [options]

Options:
      --host[=HOST]         Địa chỉ host (mặc định: "0.0.0.0")
      --port[=PORT]         Cổng (mặc định: 8000)
      --vite-port[=PORT]    Cổng Vite (mặc định: 8073)
      --no-vite             Bỏ qua server Vite
      --foreground          Chạy ở chế độ foreground (cho systemd)
      --service             Cài đặt như systemd service
      --health              Bật kiểm tra sức khỏe
      --health-interval=N   Khoảng thời gian kiểm tra (giây, mặc định: 30)
```

### Lệnh quản lý Service

```bash
# Cài đặt service
sudo php artisan serve:dev:service install

# Gỡ cài đặt service
sudo php artisan serve:dev:service uninstall

# Start/Stop/Restart
sudo systemctl start portal.service
sudo systemctl stop portal.service
sudo systemctl restart portal.service

# Bật/tắt khi khởi động
sudo systemctl enable portal.service
sudo systemctl disable portal.service

# Kiểm tra trạng thái
sudo systemctl status portal.service
sudo systemctl status portal-health.timer
```

### Các lỗi nghiêm trọng đã sửa

#### Vấn đề 1: Service restart liên tục
**Triệu chứng**: Service không khởi động được, rơi vào vòng lặp restart.

**Nguyên nhân**: `Type=simple` với lệnh fork tiến trình con rồi thoát.

**Giải pháp**: Đổi thành `Type=forking` để phù hợp với hành vi thực tế của tiến trình.

#### Vấn đề 2: Tiến trình zombie
**Triệu chứng**: Nhiều tiến trình vite/npm/esbuild tích lũy theo thời gian, gây xung đột cổng.

**Nguyên nhân**: `KillMode=process` chỉ kill tiến trình chính, để lại tiến trình con chạy.

**Giải pháp**: Đổi thành `KillMode=control-group` để kill tất cả tiến trình trong cgroup.

#### Vấn đề 3: Xung đột transaction
**Triệu chứng**: Service không stop/restart được với lỗi "destructive transaction".

**Nguyên nhân**: Health check `ExecStartPost` tạo ra các systemd jobs xung đột.

**Giải pháp**: Tích hợp health check vào lệnh chính qua flag `--health`.

### Cấu hình Service File

```ini
[Unit]
Description=Portal Development Service (PHP + Vite)
After=network.target

[Service]
Type=forking
User=root
WorkingDirectory=/path/to/project
ExecStart=/usr/bin/php artisan serve:dev --foreground --health
Restart=always
KillMode=control-group
TimeoutStopSec=60

[Install]
WantedBy=multi-user.target
```

### Kiểm tra sức khỏe (Health Check)

Health check chạy tự động mỗi 30 giây (có thể cấu hình) và:
- Kiểm tra Laravel server có phản hồi không (HTTP 200/302)
- Kiểm tra Vite server có chạy không
- Tự động restart các service bị lỗi
- Ghi log vào systemd journal

```bash
# Kiểm tra sức khỏe thủ công
php artisan serve:dev:health --fix --log

# Xem logs health check
journalctl -u portal-health.service -f
```

### Xử lý sự cố

#### Service không khởi động được
```bash
# Kiểm tra logs
journalctl -u portal.service -n 50 --no-pager

# Kiểm tra xung đột cổng
ss -tlnp | grep -E '8000|8073'

# Kill tiến trình zombie
pkill -f 'artisan serve'
pkill -f 'node.*vite'
pkill -f 'esbuild'
```

#### Tiến trình zombie
```bash
# Stop service đúng cách
sudo systemctl stop portal.service

# Xác nhận tất cả tiến trình đã bị kill
ps aux | grep -E 'artisan|vite|esbuild' | grep -v grep

# Nếu vẫn chạy, force kill
sudo systemctl kill portal.service
```

#### Xung đột cổng sau restart
```bash
# Gỡ cài đặt và cài đặt lại service
sudo php artisan serve:dev:service uninstall
sudo php artisan serve:dev:service install
```

### Thực hành tốt nhất

1. **Luôn dùng `--foreground --health`** khi chạy như systemd service
2. **Đặt `KillMode=control-group`** để tránh tiến trình zombie
3. **Dùng `TimeoutStopSec=60`** để shutdown êm ái
4. **Theo dõi logs thường xuyên**: `journalctl -u portal.service -f`
5. **Kiểm tra health timer**: `systemctl status portal-health.timer`

### Kiến trúc

```
systemd
  └── portal.service (Type=forking)
       ├── Tiến trình chính (monitor, thoát sau khi spawn)
       ├── php artisan serve (PID file được theo dõi)
       └── npm run vite (con của serve)
            
portal-health.timer (mỗi 30s)
  └── portal-health.service
       └── php artisan serve:dev:health --fix --log
```

---

**Cập nhật cuối**: 2026-04-05  
**Phiên bản**: 2.0.0 (với hỗ trợ systemd)
