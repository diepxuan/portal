# Portal Development Integration Guide

## 🎯 Tổng hợp hoàn chỉnh: 1 script + artisan integration

### 📦 Đã tạo xong:

#### **1. Main Script - `portal-dev.sh`**
```bash
# 🎯 Single script for everything
./portal-dev.sh start      # Start development
./portal-dev.sh stop       # Stop everything  
./portal-dev.sh status     # Check status
./portal-dev.sh vite       # Start Vite
./portal-dev.sh build      # Build assets
./portal-dev.sh fix        # Fix Vite manifest
./portal-dev.sh cleanup    # Clean up
./portal-dev.sh help       # Show help

# 🎯 Artisan integration (nếu artisan hoạt động)
./portal-dev.sh migrate          # Run migrations
./portal-dev.sh make:model Post  # Generate model
./portal-dev.sh queue:work       # Work queues
# ... và tất cả artisan commands khác
```

#### **2. Laravel Support Package - `diepxuan/laravel-support`**
- **Command**: `php artisan dev [action]`
- **Location**: `diepxuan/laravel-support/src/Commands/Dev.php`
- **Service Provider**: `SupportServiceProvider.php`

#### **3. Development Commands trong artisan:**
```bash
php artisan dev start      # Start development server
php artisan dev stop       # Stop development server  
php artisan dev status     # Check development status
php artisan dev vite       # Start Vite dev server
php artisan dev build      # Build production assets
php artisan dev fix        # Fix Vite manifest error
php artisan dev setup      # Setup development environment
php artisan dev cleanup    # Clean up development files
```

## 🔧 Cách hoạt động

### **Khi artisan hoạt động:**
```
./portal-dev.sh [command] → php artisan [command]
./portal-dev.sh dev:*    → php artisan dev [action]
```

### **Khi artisan không hoạt động:**
```
./portal-dev.sh [command] → Built-in development commands
```

### **Auto-detection logic:**
1. Kiểm tra `artisan --version`
2. Nếu artisan works: pass through commands
3. Nếu artisan fails: use built-in development commands
4. Luôn có fallback cho development tasks

## 🚀 Quick Start

### **Option 1: Dùng script trực tiếp**
```bash
cd /root/.openclaw/workspace/portal
chmod +x portal-dev.sh
./portal-dev.sh start
```

### **Option 2: Dùng artisan commands**
```bash
cd /root/.openclaw/workspace/portal
php artisan dev start
```

### **Option 3: Mixed mode**
```bash
./portal-dev.sh start          # Start development
./portal-dev.sh migrate        # Run migrations (via artisan)
./portal-dev.sh status         # Check status
```

## 📁 File Structure

### **Root directory:**
```
portal/
├── portal-dev.sh              # 🎯 MAIN SCRIPT - Single entry point
├── artisan                    # Laravel CLI
├── diepxuan/laravel-support/  # 📦 Development package
│   ├── src/Commands/Dev.php   # Artisan dev command
│   ├── src/SupportServiceProvider.php
│   └── README-DEV.md         # Package documentation
└── INTEGRATION-GUIDE.md      # This document
```

### **Generated files (temporary):**
```
portal/
├── .portal.pid               # Portal server PID
├── .vite.pid                 # Vite server PID  
├── public/build/             # Development assets
│   ├── manifest.json
│   └── assets/app-dev.*
└── storage/logs/
    ├── server.log           # Portal server logs
    └── vite.log             # Vite server logs
```

## 🎨 Development Features

### **✅ Tự động fix lỗi Vite manifest**
```bash
./portal-dev.sh fix
# Tạo: public/build/manifest.json + assets
```

### **✅ Development environment tự động**
- Tạo `.env` từ `.env.example`
- Generate app key
- Setup SQLite database
- Clear cache

### **✅ Vite watch mode**
```bash
./portal-dev.sh start
# Hỏi: "Start Vite? (y/n)"
# Chọn 'y' → Vite hot reload (port 5173)
```

### **✅ Artisan integration**
```bash
# Tất cả artisan commands đều work
./portal-dev.sh migrate
./portal-dev.sh make:model Post
./portal-dev.sh db:seed
./portal-dev.sh queue:work
```

### **✅ Production build**
```bash
./portal-dev.sh build
# Build assets với Vite
```

## 🔄 Workflow Examples

### **Development workflow:**
```bash
# 1. Start development
./portal-dev.sh start

# 2. Run migrations
./portal-dev.sh migrate

# 3. Generate model
./portal-dev.sh make:model Product

# 4. Check status
./portal-dev.sh status

# 5. Build for production
./portal-dev.sh build

# 6. Clean up
./portal-dev.sh cleanup
```

### **Troubleshooting workflow:**
```bash
# Artisan không hoạt động?
./portal-dev.sh fix          # Fix Vite manifest
./portal-dev.sh start        # Start development anyway

# Port conflict?
./portal-dev.sh stop         # Stop everything
./portal-dev.sh cleanup      # Clean up
./portal-dev.sh start        # Start fresh
```

## ⚙️ Configuration

### **Port configuration:**
- **Portal**: 8000 (default)
- **Vite**: 5173 (default)

### **Environment:**
- **Development**: SQLite database
- **Production**: Build assets với Vite
- **Fallback**: Auto-generated assets nếu Vite fails

## 📝 Log Files

### **Development logs:**
```bash
# Portal server logs
tail -f storage/logs/server.log

# Vite server logs  
tail -f storage/logs/vite.log

# Laravel application logs
tail -f storage/logs/laravel.log
```

### **PID files (auto-managed):**
```bash
# Check running processes
cat .portal.pid  # Portal PID
cat .vite.pid    # Vite PID

# Script tự động cleanup stale PID files
```

## 🐛 Troubleshooting

### **"Artisan not working"**
```bash
# Development commands vẫn work
./portal-dev.sh fix
./portal-dev.sh start
./portal-dev.sh status
```

### **"Port already in use"**
```bash
./portal-dev.sh stop
./portal-dev.sh cleanup
./portal-dev.sh start
```

### **"Vite manifest not found"**
```bash
./portal-dev.sh fix
# Hoặc
./portal-dev.sh start  # Tự động fix
```

### **"Command not found"**
```bash
# Check script permissions
chmod +x portal-dev.sh

# Check artisan
php artisan --version
```

## 🎯 Key Benefits

### **1. Single entry point**
- 1 script cho tất cả development tasks
- Artisan integration khi available
- Fallback khi artisan fails

### **2. Zero configuration**
- Tự động setup environment
- Tự động fix common errors
- Tự động cleanup

### **3. Developer experience**
- Simple commands: `./portal-dev.sh [command]`
- Auto-completion cho artisan commands
- Clear status và logs

### **4. Production ready**
- Build assets với Vite
- Clear separation dev/prod
- Easy deployment path

## 🔗 Integration Points

### **With existing scripts:**
```bash
# Các scripts cũ vẫn work
php artisan app:dev:npm      # NPM management
php artisan serve            # Basic PHP server
npm run dev                  # Direct Vite
```

### **With CI/CD:**
```bash
# Development
./portal-dev.sh start
./portal-dev.sh build

# Production  
npm run build
php artisan config:cache
php artisan route:cache
```

### **With team workflow:**
```bash
# Mọi developer dùng cùng commands
./portal-dev.sh start
./portal-dev.sh migrate
./portal-dev.sh status
```

## 🚀 Ready to Use!

### **Start development:**
```bash
cd /root/.openclaw/workspace/portal
./portal-dev.sh start
```

### **Development URLs:**
- **Portal**: http://localhost:8000
- **Vite**: http://localhost:5173 (nếu enabled)

### **Management:**
```bash
./portal-dev.sh status      # Check status
./portal-dev.sh stop        # Stop everything
./portal-dev.sh cleanup     # Clean up completely
```

---

**🎉 Tất cả công việc đã được tích hợp vào 1 script duy nhất!**

**Script**: `portal-dev.sh`  
**Artisan Command**: `php artisan dev`  
**Package**: `diepxuan/laravel-support`  
**Status**: ✅ Hoàn thành tích hợp