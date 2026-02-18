# Portal Development Service - Systemd Integration

## 🎯 Mục tiêu
Tạo systemd service `portal.service` dùng `serve:dev` để:
1. **Khởi động cả PHP server và Vite server**
2. **Tự động restart nếu một trong hai server bị lỗi**
3. **Health check định kỳ 30 giây**
4. **Auto-recovery cho từng server riêng lẻ**

## 🏗️ Architecture

```
portal.service (systemd)
      ↓
php artisan serve:dev
      ├── Laravel Server (port 8000)
      └── Vite Server (port 5173)
      ↓
portal-health.timer (30s)
      ↓
scripts/health-check.sh
      ├── Check Laravel (port 8000 + HTTP)
      ├── Check Vite (port 5173)
      └── Auto-restart if failed
```

## 📁 File Structure

```
portal/
├── portal.service              # Main systemd service
├── portal-health.service       # Health check service
├── portal-health.timer         # Health check timer (30s)
├── scripts/
│   ├── health-check.sh         # Health check script
│   └── install-portal-service.sh # Installation script
├── storage/
│   ├── app/
│   │   ├── portal.pid         # Laravel PID file
│   │   └── vite.pid           # Vite PID file
│   └── logs/
│       ├── portal-service.log  # Service logs
│       ├── health-check.log    # Health check logs
│       ├── laravel-restart.log # Laravel restart logs
│       └── vite-restart.log    # Vite restart logs
└── portal-dev.sh              # CLI wrapper
```

## 🔧 Health Check Logic

### **Kiểm tra mỗi 30 giây:**
1. **Laravel Server:**
   - Port 8000 listening?
   - HTTP response 200/301/302/304?
   - Process running (PID file)?

2. **Vite Server:**
   - Port 5173 listening?
   - Process running (PID file)?

### **Auto-Recovery Scenarios:**

#### **1. Laravel down, Vite up:**
```
❌ Laravel port 8000: NOT LISTENING
✅ Vite port 5173: LISTENING
⚠️ Laravel server down - restarting...
✅ Laravel restarted (PID: XXX)
```

#### **2. Vite down, Laravel up:**
```
✅ Laravel port 8000: LISTENING  
❌ Vite port 5173: NOT LISTENING
⚠️ Vite server down - restarting...
✅ Vite restarted (PID: XXX)
```

#### **3. Cả hai down:**
```
❌ Laravel port 8000: NOT LISTENING
❌ Vite port 5173: NOT LISTENING
🚨 CRITICAL: Both servers down - restarting entire service
```

## 🚀 Installation

```bash
# 1. Make installation script executable
chmod +x scripts/install-portal-service.sh

# 2. Run as root
sudo ./scripts/install-portal-service.sh
```

**Hoặc manual installation:**
```bash
sudo cp portal.service /etc/systemd/system/
sudo cp portal-health.service /etc/systemd/system/
sudo cp portal-health.timer /etc/systemd/system/

sudo systemctl daemon-reload
sudo systemctl enable portal.service portal-health.timer
sudo systemctl start portal.service portal-health.timer
```

## 🛠️ Management Commands

### **Service Management:**
```bash
# Start/Stop/Restart
sudo systemctl start portal.service
sudo systemctl stop portal.service
sudo systemctl restart portal.service

# Status
sudo systemctl status portal.service
sudo systemctl status portal-health.timer

# Logs
sudo journalctl -u portal.service -f
sudo journalctl -u portal-health.service -f
```

### **Health Check Manual:**
```bash
# Run health check manually
./scripts/health-check.sh

# View health logs
tail -f storage/logs/health-check.log
tail -f storage/logs/portal-service.log
```

## ⚙️ Service Configuration

### **portal.service:**
```ini
Restart=always          # Auto-restart on failure
RestartSec=10          # Wait 10 seconds before restart
StartLimitInterval=60  # Max 5 restarts in 60 seconds
StartLimitBurst=5
```

### **portal-health.timer:**
```ini
OnUnitActiveSec=30s    # Run every 30 seconds after activation
OnBootSec=60s          # Run 60 seconds after boot
OnUnitInactiveSec=30s  # Run 30 seconds after deactivation
```

## 🔍 Monitoring

### **Check Service Status:**
```bash
# Detailed status
systemctl status portal.service

# Check if running
systemctl is-active portal.service

# Check health check timer
systemctl list-timers --all | grep portal
```

### **View Logs:**
```bash
# Service logs
journalctl -u portal.service -n 50 --no-pager

# Follow logs in real-time
journalctl -u portal.service -f

# Health check logs
tail -f storage/logs/health-check.log
```

## 🚨 Troubleshooting

### **1. Service không start:**
```bash
# Check errors
sudo systemctl status portal.service --no-pager

# Check journal logs
sudo journalctl -u portal.service --since "5 minutes ago"

# Test serve:dev manually
cd /root/.openclaw/workspace/portal && php artisan serve:dev
```

### **2. Health check không chạy:**
```bash
# Check timer status
systemctl status portal-health.timer

# Check timer list
systemctl list-timers --all

# Run health check manually
./scripts/health-check.sh
```

### **3. Port conflicts:**
```bash
# Check which process is using port
sudo lsof -i :8000
sudo lsof -i :5173

# Kill conflicting processes
sudo kill -9 $(sudo lsof -t -i:8000)
sudo kill -9 $(sudo lsof -t -i:5173)
```

## 📈 Benefits

1. **High Availability:** Auto-restart trên failure
2. **Independent Recovery:** Mỗi server restart độc lập
3. **Centralized Management:** Qua systemd
4. **Comprehensive Logging:** Đầy đủ logs cho debugging
5. **Easy Monitoring:** Systemd tools + custom logs
6. **Production Ready:** Có thể dùng cho staging/production

## 🔄 Integration với portal-dev.sh

`portal-dev.sh` vẫn hoạt động như CLI wrapper:
```bash
# CLI commands still work
./portal-dev.sh status
./portal-dev.sh stop  # Will stop systemd service
./portal-dev.sh start # Will start via systemd
```

**Note:** `portal-dev.sh` sẽ gọi systemd commands khi service được cài đặt.