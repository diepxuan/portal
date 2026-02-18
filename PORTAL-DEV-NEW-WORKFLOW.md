# Portal Development - New Workflow Documentation

## 🎯 Mục tiêu
Tạo luồng hoạt động thống nhất: `portal-dev.sh` là alias cho `artisan serve:dev` với auto-fix và fallback.

## 🔄 Luồng hoạt động

### 1. **Start Development**
```
./portal-dev.sh start
```
**Luồng:**
1. Kiểm tra `serve:dev` command có sẵn không
2. Nếu không có → tự động cài đặt dependencies (composer, laravel-support)
3. Chạy `php artisan serve:dev`
4. Fallback: Nếu vẫn không được → chạy mode cũ

### 2. **Stop Development**
```
./portal-dev.sh stop
```
**Luồng:**
1. Gọi `php artisan serve:dev:stop`
2. Fallback: Stop processes theo PID files

### 3. **Check Status**
```
./portal-dev.sh status
```
**Luồng:**
1. Gọi `php artisan serve:dev:status`
2. Fallback: Hiển thị status từ PID files và port checking

### 4. **Start Vite**
```
./portal-dev.sh vite
```
**Luồng:**
1. Gọi `php artisan serve:dev:vite` (nếu có)
2. Fallback: Chạy `npm run dev` trực tiếp

## 🛠️ Auto-Fix Features

### **Tự động cài đặt khi thiếu:**
1. **Composer**: Nếu chưa có → tự động cài
2. **laravel-support package**: Nếu chưa có → tự động thêm vào composer.json và cài đặt
3. **serve:dev commands**: Kiểm tra và báo lỗi nếu không thể cài đặt

### **Fallback Mode:**
Khi `serve:dev` không khả dụng, script sẽ:
- Sử dụng PID files trong `storage/app/`
- Chạy Laravel server bằng `php artisan serve`
- Chạy Vite bằng `npm run dev`
- Quản lý processes cơ bản

## 📁 File Structure

```
portal/
├── portal-dev.sh              # Main script (alias for serve:dev)
├── storage/app/
│   ├── portal.pid            # Laravel PID file (fallback)
│   └── vite.pid              # Vite PID file (fallback)
├── storage/logs/
│   ├── server.log            # Laravel server logs
│   └── vite.log              # Vite server logs
└── vendor/diepxuan/laravel-support/
    └── src/Commands/         # serve:dev commands
```

## 🔧 Các Commands Available

### **Development Commands:**
- `start`    - Start development environment
- `stop`     - Stop development environment  
- `status`   - Check development status
- `vite`     - Start Vite development server
- `build`    - Build production assets
- `fix`      - Fix Vite manifest error
- `cleanup`  - Clean up development files

### **Artisan Pass-through:**
Bất kỳ artisan command nào cũng có thể chạy qua:
```
./portal-dev.sh migrate
./portal-dev.sh make:model Post
./portal-dev.sh queue:work
```

## 🚀 Quick Start

```bash
# 1. Start development (auto-fix nếu cần)
./portal-dev.sh start

# 2. Check status
./portal-dev.sh status

# 3. Start Vite (nếu chưa tự động)
./portal-dev.sh vite

# 4. Stop everything
./portal-dev.sh stop
```

## ⚠️ Troubleshooting

### **1. serve:dev không có**
```
❌ serve:dev command not found
✅ Tự động cài đặt laravel-support...
✅ serve:dev command fixed
```

### **2. Composer không có**
```
❌ composer not found
✅ Tự động cài đặt Composer...
✅ Composer installed
```

### **3. Fallback mode**
```
⚠️ Using fallback mode (serve:dev not available)
✅ Portal started (PID: XXX)
🌐 URL: http://localhost:8000
```

## 📝 Notes

1. **PID files location**: `storage/app/` (tương thích với laravel-support)
2. **Auto-cleanup**: PID files tự động xóa khi processes stop
3. **Port checking**: Tự động kiểm tra port 8000 và 5173
4. **Logs**: Tất cả logs lưu trong `storage/logs/`

## 🔄 Migration từ phiên bản cũ

Nếu đang dùng phiên bản cũ:
1. **PID files**: Di chuyển từ `.portal.pid` và `.vite.pid` sang `storage/app/`
2. **Script**: Thay thế bằng phiên bản mới
3. **Commands**: Tất cả commands vẫn tương thích ngược

## ✅ Benefits

1. **Thống nhất**: Một luồng duy nhất qua `serve:dev`
2. **Tự động**: Auto-fix dependencies khi thiếu
3. **Fallback**: Hoạt động ngay cả khi serve:dev không có
4. **Tương thích**: Backward compatible với phiên bản cũ
5. **Documentation**: Đầy đủ cho các aiagent khác hiểu