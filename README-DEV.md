# Portal Development Setup - Complete Package

## 🎯 Tổng hợp tất cả công việc đã làm + Vite watch mode

### 📦 Scripts đã tạo:

1. **`portal-dev-simple.sh`** - Main manager (đơn giản, dễ dùng)
2. **`vite-dev-mode.sh`** - Vite specialist
3. **`portal-service-control.sh`** - Service management
4. **`quick-dev-start.sh`** - One-command setup
5. **`DEV_SETUP.md`** - Documentation đầy đủ

## 🚀 Cách sử dụng nhanh

```bash
# 1. Làm cho scripts executable
chmod +x *.sh

# 2. Khởi động development environment
./quick-dev-start.sh

# Hoặc dùng script đơn giản
./portal-dev-simple.sh start
```

## 🔧 Tính năng chính

### ✅ Tự động fix lỗi Vite manifest
```bash
./portal-dev-simple.sh fix
# Tạo: public/build/manifest.json + assets
```

### ✅ Development environment tự động
- Tạo `.env` từ `.env.example`
- Generate app key
- Setup SQLite database
- Clear cache

### ✅ Vite watch mode cho developer
```bash
./portal-dev-simple.sh start
# Hỏi: "Start Vite development server? (y/n)"
# Chọn 'y' để bật Vite hot reload
```

### ✅ Service management
```bash
# System service (cần sudo)
sudo ./portal-service-control.sh install
sudo ./portal-service-control.sh status
```

### ✅ Production build
```bash
./portal-dev-simple.sh build
# Build assets với Vite
```

## 📁 Cấu trúc scripts

```
portal/
├── portal-dev-simple.sh       # 🎯 MAIN - Simple manager
├── vite-dev-mode.sh           # ⚡ Vite specialist
├── portal-service-control.sh  # 🔧 Service control  
├── quick-dev-start.sh         # 🚀 One-command start
├── DEV_SETUP.md              # 📖 Full documentation
├── README-DEV.md             # 📝 This file
└── .portal.pid /.vite.pid    # ⚙️ PID files (auto)
```

## 🎮 Development Workflow

### 1. Start development
```bash
./portal-dev-simple.sh start
# Portal: http://localhost:8000
# Vite:   http://localhost:5173 (optional)
```

### 2. Làm việc
- Edit PHP files: `app/`, `diepxuan/`
- Edit views: `resources/views/`
- Edit assets: `resources/js/`, `resources/css/`

### 3. Vite development
- Hot reload tự động (nếu bật Vite)
- Hoặc build thủ công: `./portal-dev-simple.sh build`

### 4. Testing
```bash
./portal-dev-simple.sh status
tail -f storage/logs/laravel.log
curl -I http://localhost:8000
```

### 5. Cleanup
```bash
./portal-dev-simple.sh stop
# Hoặc dọn sạch hoàn toàn
rm -rf public/build/
php artisan config:clear
```

## ⚡ Quick Commands Reference

### portal-dev-simple.sh
```bash
./portal-dev-simple.sh start    # Start portal + optional Vite
./portal-dev-simple.sh stop     # Stop everything
./portal-dev-simple.sh status   # Check status
./portal-dev-simple.sh vite     # Start Vite only
./portal-dev-simple.sh build    # Build production assets
./portal-dev-simple.sh fix      # Quick fix Vite error
./portal-dev-simple.sh help     # Show help
```

### vite-dev-mode.sh
```bash
./vite-dev-mode.sh start    # Start Vite dev server
./vite-dev-mode.sh stop     # Stop Vite
./vite-dev-mode.sh build    # Build production assets
./vite-dev-mode.sh watch    # Watch and rebuild
./vite-dev-mode.sh status   # Check Vite status
./vite-dev-mode.sh fix      # Quick fix assets
```

### portal-service-control.sh
```bash
sudo ./portal-service-control.sh install    # Install system service
sudo ./portal-service-control.sh uninstall  # Uninstall service
./portal-service-control.sh status          # Check status
./portal-service-control.sh logs laravel    # View logs
```

## 🛠️ Các công việc đã được tích hợp

### 1. ✅ Fix "Vite manifest not found"
- Tự động tạo `public/build/manifest.json`
- Tạo dummy CSS/JS assets
- Blade templates có development fallback

### 2. ✅ Setup development environment
- SQLite database tự động
- .env configuration
- Cache clearing

### 3. ✅ Vite watch mode
- Development server port 5173
- Hot reload cho assets
- Production build support

### 4. ✅ Service management
- Built-in PHP artisan serve
- Systemd service installation
- Log management

### 5. ✅ Quick fixes
- One-command fixes
- Auto-recovery
- Cleanup options

## 🎨 Development Modes

### Mode 1: Basic (không Vite)
```bash
./portal-dev-simple.sh start
# Chọn 'n' khi hỏi về Vite
# Dùng auto-generated assets
```

### Mode 2: Full (với Vite)
```bash
./portal-dev-simple.sh start  
# Chọn 'y' khi hỏi về Vite
# Vite hot reload enabled
```

### Mode 3: Vite Only
```bash
./portal-dev-simple.sh vite
# Hoặc
./vite-dev-mode.sh start
```

### Mode 4: Production
```bash
./portal-dev-simple.sh build
# Build assets thật với Vite
```

## 🔍 Port Configuration

| Service | Port | URL                          | Mục đích                |
|---------|------|------------------------------|-------------------------|
| Portal  | 8000 | http://localhost:8000        | Laravel application     |
| Vite    | 5173 | http://localhost:5173        | Asset development server|

## 📝 Log Files

```
storage/logs/
├── laravel.log     # Laravel application logs
├── server.log      # Portal server output (nếu dùng service)
├── vite.log        # Vite development server logs
├── service.log     # System service output
└── service-error.log # Service errors
```

## 🐛 Troubleshooting

### "Port already in use"
```bash
./portal-dev-simple.sh stop
# Hoặc
lsof -ti:8000 | xargs kill -9
lsof -ti:5173 | xargs kill -9
```

### "Vite not working"
```bash
# Check dependencies
node --version
npm --version

# Install
npm install

# Start
./vite-dev-mode.sh start
```

### "Database errors"
```bash
# Setup SQLite
touch database/database.sqlite
php artisan migrate

# Check .env
cat .env | grep DB_
```

## 🎯 Ready to Code!

### Quick Start:
```bash
./quick-dev-start.sh
```

### Manual Control:
```bash
./portal-dev-simple.sh start
```

### Check Status:
```bash
./portal-dev-simple.sh status
```

### View Logs:
```bash
tail -f storage/logs/laravel.log
```

---

**Development URLs:**
- 🌐 Portal: http://localhost:8000
- ⚡ Vite: http://localhost:5173 (if enabled)

**Tất cả công việc đã được tích hợp vào scripts này!** 🎉