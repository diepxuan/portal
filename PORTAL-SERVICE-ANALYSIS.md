# Portal Service Analysis

## 📋 Tổng quan
**Ngày kiểm tra**: 2026-02-17  
**Thời gian**: 18:25 GMT+7  
**Mục đích**: Phân tích portal service đang chạy những gì  
**Tác giả**: Bột (OpenClaw AI Assistant)

## 🔍 Kiểm tra thực tế

### **1. Processes đang chạy:**
```bash
# 2 processes PHP đang chạy trên port 8000
root      403104  php artisan serve --host=0.0.0.0 --port=8000
root      403119  /usr/bin/php8.2 -S 0.0.0.0:8000 [Laravel server]
```

### **2. Port status:**
```bash
# Port 8000 đang listen
tcp  0.0.0.0:8000  0.0.0.0:*  LISTEN  403119/php8.2
```

### **3. Service status:**
```bash
systemctl status portal.service
# Output: inactive (dead) - Service file không được kích hoạt
```

## 🏗️ Cấu hình Service

### **File: `/etc/systemd/system/portal.service`**
```ini
[Unit]
Description=Portal Laravel Application
After=network.target

[Service]
Type=simple
User=root
WorkingDirectory=/root/.openclaw/workspace/portal
Environment="APP_ENV=local"
Environment="APP_DEBUG=true"
Environment="DB_CONNECTION=sqlite"
Environment="DB_DATABASE=/root/.openclaw/workspace/portal/database/database.sqlite"
ExecStart=/usr/bin/php artisan serve --host=0.0.0.0 --port=8000
Restart=on-failure
RestartSec=10

[Install]
WantedBy=multi-user.target
```

### **File: `/root/.openclaw/workspace/portal/.env` (phần quan trọng)**
```env
APP_NAME="Portal"
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:0HzX7Kh6M64qJ8NQscUb85X1KXSNBUDYRy3nkQS60/A=
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
DB_DATABASE=/root/.openclaw/workspace/portal/database/database.sqlite
SIMBA_CONNECTION=sqlsrv
```

## 📊 Thành phần đang chạy

### **1. Web Server:**
- **Type**: PHP built-in server (artisan serve)
- **Port**: 8000
- **Host**: 0.0.0.0 (accessible từ mọi interface)
- **Status**: ✅ Đang chạy, responding với HTTP 302

### **2. Database:**
- **Type**: SQLite
- **File**: `database/database.sqlite` (135KB)
- **Status**: ✅ Tồn tại, có dữ liệu

### **3. Application Stack:**
- **Laravel**: 11.48.0
- **PHP**: 8.2.29
- **Environment**: local
- **Debug**: enabled (APP_DEBUG=true)

### **4. Frontend Assets:**
- **Vite server**: ❌ Không chạy (port 5173 không listen)
- **Built assets**: Có thể có trong `public/build/`

### **5. Packages loaded:**
- 919 classes declared (bao gồm tất cả packages)
- Packages từ `diepxuan/` namespace
- Laravel packages (Fortify, Jetstream, Sanctum, etc.)

## 🛣️ Routes Configuration

### **Main routes (`routes/web.php`):**
```php
// Rất đơn giản - chỉ có auth middleware routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::get('/dashboard', ...)->name('dashboard');
});
```

### **API routes (`routes/api.php`):**
```php
// Cần kiểm tra thêm
```

### **Package routes:**
- `diepxuan/laravel-catalog/routes/`
- `diepxuan/laravel-magento/routes/`

## ⚙️ Configuration Issues

### **1. CatalogController error:**
```bash
php artisan route:list
# Error: Class "Diepxuan\Catalog\Http\Controllers\CatalogController" does not exist
```

### **2. Service file không active:**
- File tồn tại tại `/etc/systemd/system/portal.service`
- Nhưng service không enabled/started
- Processes đang chạy manual (không qua systemd)

### **3. Duplicate processes:**
- 2 PHP processes trên cùng port 8000
- Có thể gây conflict

## 🔗 Connectivity Test

### **HTTP Test:**
```bash
curl -I http://localhost:8000
# HTTP/1.1 302 Found - Redirecting (có thể đến login)
```

### **Port Test:**
```bash
# Port 8000: ✅ LISTENING
# Port 5173 (Vite): ❌ NOT LISTENING
```

## 📁 File Structure liên quan

### **Database:**
```
database/
├── database.sqlite          # SQLite database (135KB)
├── migrations/             # Migration files
└── seeders/               # Seeder classes
```

### **Public assets:**
```
public/
├── build/                 # Vite built assets (nếu có)
├── index.php             # Laravel entry point
└── .htaccess             # Apache config
```

### **Configuration:**
```
config/
├── app.php               # Application config
├── database.php          # Database config
├── auth.php              # Authentication
└── ... nhiều config files
```

## 🎯 Services đang chạy

### **✅ Đang chạy:**
1. **PHP/Laravel Web Server** (port 8000)
2. **SQLite Database** (file-based)
3. **Laravel Application** với full package stack

### **❌ Không chạy:**
1. **Vite Development Server** (port 5173)
2. **Systemd Service** (portal.service)
3. **Queue Workers** (nếu có)
4. **Schedule Runner** (nếu có)

### **⚠️ Có vấn đề:**
1. **Duplicate PHP processes**
2. **CatalogController class missing**
3. **Service file không được sử dụng**

## 🔧 Recommendations

### **1. Fix duplicate processes:**
```bash
# Stop all portal processes
pkill -f "artisan serve"
pkill -f "php.*serve"

# Start fresh với portal-dev.sh
./portal-dev.sh start
```

### **2. Fix CatalogController:**
```bash
# Kiểm tra package diepxuan/laravel-catalog
composer dump-autoload
php artisan package:discover
```

### **3. Enable systemd service (optional):**
```bash
sudo systemctl enable portal.service
sudo systemctl start portal.service
sudo systemctl status portal.service
```

### **4. Start Vite nếu cần:**
```bash
./portal-dev.sh vite
# Hoặc
./portal-dev.sh start  # Sẽ hỏi có start Vite không
```

## 📈 Health Check Summary

| Component | Status | Notes |
|-----------|--------|-------|
| Web Server | ✅ Running | Port 8000, responding |
| Database | ✅ Available | SQLite, 135KB |
| Laravel App | ⚠️ Partial | CatalogController error |
| Vite Server | ❌ Stopped | Port 5173 not listening |
| Systemd Service | ❌ Inactive | File exists but not used |
| Processes | ⚠️ Duplicate | 2 PHP processes on same port |

## 🚀 Quick Actions

### **Để restart portal cleanly:**
```bash
cd /root/.openclaw/workspace/portal
./portal-dev.sh stop      # Stop everything
./portal-dev.sh cleanup   # Clean up
./portal-dev.sh start     # Start fresh
```

### **Để kiểm tra status:**
```bash
./portal-dev.sh status    # Check development status
curl -I http://localhost:8000  # Test HTTP response
```

### **Để fix issues:**
```bash
# Fix autoload
composer dump-autoload
php artisan package:discover

# Fix routes
./portal-dev.sh fix       # Fix common issues
```

---

**🎯 Kết luận:** Portal service đang chạy Laravel application trên port 8000 với SQLite database, nhưng có một số issues cần fix (duplicate processes, missing controller, inactive systemd service).

**Tác giả**: Bột  
**Ngày**: 2026-02-17  
**Tuân thủ**: Documentation Rule từ SOUL.md