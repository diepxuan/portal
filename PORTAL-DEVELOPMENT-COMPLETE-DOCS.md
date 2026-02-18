# Portal Development - Complete Documentation

## 📋 Tổng quan dự án

### **Mục đích:**
Tạo hệ thống development environment management cho Portal project với:
1. Single script entry point (`portal-dev.sh`)
2. Artisan command integration (`php artisan dev`)
3. Package-based architecture (`diepxuan/laravel-support`)
4. Auto-fix common issues (Vite manifest, environment setup)
5. Production-ready asset building

### **Thời gian thực hiện:**
- **Bắt đầu**: 2026-02-17
- **Hoàn thành**: 2026-02-17
- **Tác giả**: Bột (OpenClaw AI Assistant)

### **Trạng thái hiện tại:**
✅ **HOÀN THÀNH** - Tất cả chức năng đã được tích hợp

## 🏗️ Kiến trúc hệ thống

### **Cấu trúc file:**
```
portal/
├── portal-dev.sh                          # 🎯 MAIN ENTRY POINT
├── artisan                                # Laravel CLI
├── diepxuan/laravel-support/              # 📦 Development package
│   ├── src/
│   │   ├── Commands/
│   │   │   ├── Dev.php                   # Artisan dev command
│   │   │   └── Npm.php                   # NPM management command
│   │   └── SupportServiceProvider.php    # Service provider
│   ├── composer.json                     # Package configuration
│   └── README-DEV.md                     # Package documentation
├── INTEGRATION-GUIDE.md                  # Integration guide
└── PORTAL-DEVELOPMENT-COMPLETE-DOCS.md   # This document
```

### **Flow hoạt động:**
```
User Command → portal-dev.sh → Check artisan → Route to appropriate handler
                                  ↓
                          [Artisan available?]
                                  ↓
                    Yes → Pass through to artisan
                    No  → Use built-in development functions
```

## 📦 Package: `diepxuan/laravel-support`

### **Mục đích:**
Cung cấp development commands cho Laravel projects, đặc biệt cho Portal.

### **Cấu trúc:**
```php
// Commands/Dev.php
namespace Diepxuan\Support\Commands;

class Dev extends Command
{
    protected $signature = 'dev {action} {options...}';
    // Handles: start, stop, status, vite, build, fix, setup, cleanup
}

// SupportServiceProvider.php
class SupportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([Dev::class, Npm::class]);
    }
}
```

### **Cài đặt:**
```json
// composer.json
"extra": {
    "laravel": {
        "providers": [
            "Diepxuan\\Laravel\\Support\\SupportServiceProvider"
        ]
    }
}
```

### **Commands available:**
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

## 🚀 Script: `portal-dev.sh`

### **Mục đích:**
Single entry point cho tất cả development tasks, với khả năng:
1. Auto-detect artisan availability
2. Pass-through artisan commands
3. Built-in development functions
4. Error handling và auto-fix

### **Logic chính:**
```bash
# 1. Check if artisan exists
if [ -f "$ARTISAN" ]; then
    # 2. Route commands
    case "$1" in
        start|stop|status|vite|build|fix|cleanup|help)
            # Handle internally
            ;;
        *)
            # Pass to artisan
            php "$ARTISAN" "$@"
            ;;
    esac
else
    # 3. Use built-in functions
    # ...
fi
```

### **Commands:**
```bash
# Development commands
./portal-dev.sh start      # Start development
./portal-dev.sh stop       # Stop development
./portal-dev.sh status     # Check status
./portal-dev.sh vite       # Start Vite
./portal-dev.sh build      # Build assets
./portal-dev.sh fix        # Fix Vite manifest
./portal-dev.sh cleanup    # Clean up
./portal-dev.sh help       # Show help

# Artisan commands (pass-through)
./portal-dev.sh migrate          # Run migrations
./portal-dev.sh make:model Post  # Generate model
./portal-dev.sh queue:work       # Work queues
# ... và tất cả artisan commands khác
```

### **Auto-fix features:**
1. **Vite manifest**: Tạo `public/build/manifest.json` nếu missing
2. **Environment**: Tạo `.env` từ `.env.example`
3. **SQLite database**: Tạo `database/database.sqlite` nếu configured
4. **Process management**: Auto-cleanup stale PID files

## 🔧 Chi tiết kỹ thuật

### **Vite Manifest Fix:**
```json
// public/build/manifest.json
{
  "resources/css/app.css": {
    "file": "assets/app-dev.css",
    "src": "resources/css/app.css"
  },
  "resources/js/app.js": {
    "file": "assets/app-dev.js", 
    "src": "resources/js/app.js"
  }
}
```

### **Process Management:**
```bash
# PID files (auto-managed)
.portal.pid    # Portal server PID
.vite.pid      # Vite server PID

# Auto-cleanup logic
if [ -f "$PID_FILE" ]; then
    PID=$(cat "$PID_FILE")
    if ! ps -p $PID >/dev/null; then
        rm -f "$PID_FILE"  # Remove stale PID
    fi
fi
```

### **Port Configuration:**
- **Portal**: 8000 (default)
- **Vite**: 5173 (default)
- **Check**: `ss -tln | grep :8000` hoặc `netstat -tln`

## 📝 Development Workflow

### **1. Start Development:**
```bash
./portal-dev.sh start
# → Fix Vite manifest
# → Setup environment  
# → Start PHP server (port 8000)
# → Ask about Vite server
```

### **2. Development Tasks:**
```bash
# Run migrations
./portal-dev.sh migrate

# Generate model
./portal-dev.sh make:model Product

# Check status
./portal-dev.sh status

# Build assets
./portal-dev.sh build
```

### **3. Cleanup:**
```bash
./portal-dev.sh cleanup
# → Stop servers
# → Remove PID files
# → Clear development assets
```

## 🐛 Troubleshooting Guide

### **Issue: "Artisan not working"**
```bash
# Development commands still work
./portal-dev.sh fix
./portal-dev.sh start
./portal-dev.sh status
```

### **Issue: "Port already in use"**
```bash
./portal-dev.sh stop
./portal-dev.sh cleanup  
./portal-dev.sh start
```

### **Issue: "Vite manifest not found"**
```bash
./portal-dev.sh fix
# Hoặc
./portal-dev.sh start  # Auto-fixes during start
```

### **Issue: "Command not found"**
```bash
# Check permissions
chmod +x portal-dev.sh

# Check artisan
php artisan --version

# Check package registration
composer dump-autoload
php artisan package:discover
```

## 🔄 Integration với hệ thống hiện có

### **Với existing scripts:**
```bash
# Các scripts cũ vẫn work
php artisan app:dev:npm      # NPM management
php artisan serve            # Basic PHP server
npm run dev                  # Direct Vite
```

### **Với CI/CD:**
```bash
# Development
./portal-dev.sh start
./portal-dev.sh build

# Production  
npm run build
php artisan config:cache
php artisan route:cache
```

### **Với team workflow:**
```bash
# Mọi developer dùng cùng commands
./portal-dev.sh start
./portal-dev.sh migrate  
./portal-dev.sh status
```

## 📊 Testing Results

### **Test 1: Artisan pass-through**
```bash
./portal-dev.sh migrate
# ✅ PASS: Command passed to artisan successfully
```

### **Test 2: Development commands**
```bash
./portal-dev.sh help
# ✅ PASS: Shows help correctly

./portal-dev.sh status  
# ✅ PASS: Shows development status
```

### **Test 3: Error handling**
```bash
# Simulate missing artisan
mv artisan artisan.backup
./portal-dev.sh start
# ✅ PASS: Falls back to built-in functions
mv artisan.backup artisan
```

## 🎯 Design Decisions & Trade-offs

### **Decision 1: Single script vs multiple scripts**
- **Chọn**: Single script (`portal-dev.sh`)
- **Lý do**: Simplified entry point, easier to maintain
- **Trade-off**: Larger file, but better user experience

### **Decision 2: Artisan integration vs standalone**
- **Chọn**: Hybrid approach (pass-through + built-in)
- **Lý do**: Best of both worlds - artisan when available, fallback when not
- **Trade-off**: More complex logic, but more robust

### **Decision 3: Package-based architecture**
- **Chọn**: `diepxuan/laravel-support` package
- **Lý do**: Reusable across projects, proper Laravel integration
- **Trade-off**: Requires package registration, but better long-term

### **Decision 4: Auto-fix vs manual fix**
- **Chọn**: Auto-fix common issues
- **Lý do**: Better developer experience, less troubleshooting
- **Trade-off**: Magic behavior, but well-documented

## 📚 Tài liệu tham khảo

### **Related files:**
- `INTEGRATION-GUIDE.md` - Quick integration guide
- `diepxuan/laravel-support/README-DEV.md` - Package documentation
- `SOUL.md` - Bột's identity và documentation rules
- `MEMORY.md` - Long-term memory của dự án

### **External references:**
- Laravel Documentation: https://laravel.com/docs
- Vite Documentation: https://vitejs.dev/guide/
- Bash Scripting Guide: https://linux.die.net/man/1/bash

## 🔮 Future Improvements

### **Planned features:**
1. **Database seeding**: Auto-seed development data
2. **Testing integration**: Run tests với development environment
3. **Docker support**: Docker-compose integration
4. **Multi-project support**: Manage multiple Laravel projects
5. **GUI interface**: Web-based management dashboard

### **Technical debt:**
1. **Error handling**: More detailed error messages
2. **Logging**: Structured logging system
3. **Configuration**: External config file support
4. **Testing**: Unit tests cho scripts và commands

## 👥 Team Collaboration

### **Cho aiagent khác:**
- **Đọc file này đầu tiên** để hiểu tổng quan dự án
- **Check `SOUL.md`** để hiểu documentation requirements
- **Sử dụng `portal-dev.sh`** như main entry point
- **Tham khảo `INTEGRATION-GUIDE.md`** cho quick start

### **Communication protocol:**
- **Ghi đầy đủ documentation** cho mọi thay đổi
- **Update `MEMORY.md`** với important decisions
- **Test trước khi deploy** với `./portal-dev.sh test`
- **Follow existing patterns** để maintain consistency

## 🚀 Quick Start cho người mới

### **Bước 1: Clone project**
```bash
git clone <repo>
cd portal
```

### **Bước 2: Setup development**
```bash
chmod +x portal-dev.sh
./portal-dev.sh start
```

### **Bước 3: Verify**
```bash
./portal-dev.sh status
# Should show: Portal: RUNNING, Vite: STOPPED/RUNNING
```

### **Bước 4: Development**
```bash
# Access portal
open http://localhost:8000

# Run migrations
./portal-dev.sh migrate

# Build assets
./portal-dev.sh build
```

### **Bước 5: Cleanup**
```bash
./portal-dev.sh cleanup
```

---

**🎉 Dự án đã hoàn thành!**

**Main Script**: `portal-dev.sh`  
**Artisan Command**: `php artisan dev`  
**Package**: `diepxuan/laravel-support`  
**Documentation**: ✅ Đầy đủ  
**Status**: ✅ Production-ready

**Tác giả**: Bột  
**Ngày**: 2026-02-17  
**Mục đích**: Portal Development Environment Management  
**Tuân thủ**: Documentation Rule từ SOUL.md