# Serve:Dev Commands - Development Server Management

## Overview

Package `laravel-support` cung cấp hệ thống command `serve:dev` để quản lý development server (Laravel + Vite) một cách tích hợp.

**Lưu ý:** Toàn bộ scripts đã được tích hợp vào `serve:dev` commands. Không còn external scripts.

## Available Commands

### **1. serve:dev** - Main development command

```bash
php artisan serve:dev
```

**Options:**
- `--host=0.0.0.0` - Host address
- `--port=8000` - Laravel port
- `--vite-port=5173` - Vite port
- `--no-vite` - Don't start Vite
- `--foreground` - Run in foreground
- `--service` - Install as systemd service
- `--health` - Enable health check
- `--health-interval=30` - Health check interval

**Examples:**
```bash
# Basic start
php artisan serve:dev

# Install as systemd service
php artisan serve:dev --service

# With health check
php artisan serve:dev --health --health-interval=60

# Custom ports
php artisan serve:dev --port=8080 --vite-port=3000
```

### **2. serve:dev:stop** - Stop development

```bash
php artisan serve:dev:stop
```

Stops both Laravel and Vite servers.

### **3. serve:dev:status** - Check status

```bash
php artisan serve:dev:status
```

Shows detailed status of both servers.

### **4. serve:dev:health** - Health check with auto-recovery

```bash
php artisan serve:dev:health
```

**Options:**
- `--fix` - Auto-fix if server is down
- `--interval=30` - Health check interval
- `--once` - Run once and exit
- `--log` - Log to storage/logs/health-check.log

**Examples:**
```bash
# Check only
php artisan serve:dev:health

# Auto-fix
php artisan serve:dev:health --fix

# With logging
php artisan serve:dev:health --fix --log
```

### **5. serve:dev:service** - Systemd service management

```bash
php artisan serve:dev:service <action>
```

**Actions:**
- `install` - Install systemd service
- `uninstall` - Uninstall service
- `start` - Start service
- `stop` - Stop service
- `restart` - Restart service
- `status` - Check service status
- `enable` - Enable service
- `disable` - Disable service

**Options:**
- `--name=portal` - Service name
- `--user=root` - Service user
- `--group=root` - Service group
- `--interval=30` - Health check interval

**Examples:**
```bash
# Install service
sudo php artisan serve:dev:service install

# Check status
php artisan serve:dev:service status

# Start service
sudo php artisan serve:dev:service start
```

### **6. serve:dev:logs** - View logs real-time

```bash
php artisan serve:dev:logs [type]
```

**Arguments:**
- `type` - Type of logs (laravel, vite, health, all) - default: all

**Options:**
- `-f, --follow` - Follow log output (tail -f)
- `-l, --lines=50` - Number of lines to show
- `-c, --clear` - Clear log file after viewing

**Examples:**
```bash
# View all logs (last 50 lines)
php artisan serve:dev:logs

# Follow Laravel logs real-time
php artisan serve:dev:logs laravel --follow

# View Vite logs with 100 lines
php artisan serve:dev:logs vite --lines=100

# View and clear health logs
php artisan serve:dev:logs health --clear

# Follow all logs
php artisan serve:dev:logs all --follow
```

**Log files:**
- `storage/logs/laravel.log` - Laravel application logs
- `storage/logs/vite-server.log` - Vite server logs
- `storage/logs/health-check.log` - Health check logs

## Architecture

```
serve:dev commands (in laravel-support package)
├── serve:dev              # Main command
├── serve:dev:stop         # Stop servers
├── serve:dev:status       # Check status
├── serve:dev:health       # Health check + auto-recovery
├── serve:dev:service      # Systemd service management
└── serve:dev:logs         # Log viewer
```

**Không còn external scripts** - tất cả đều trong package.

## Quick Start

### **Option 1: Basic development**
```bash
php artisan serve:dev
php artisan serve:dev:status
php artisan serve:dev:stop
```

### **Option 2: With systemd service**
```bash
# Install as service
sudo php artisan serve:dev --service

# Or manually install service
sudo php artisan serve:dev:service install

# Check service status
php artisan serve:dev:service status
```

### **Option 3: With health check**
```bash
# Start with health check
php artisan serve:dev --health

# Manual health check
php artisan serve:dev:health --fix
```

## Auto-Recovery Features

### **Health Check Logic:**
1. **Kiểm tra Laravel:**
   - Port 8000 listening?
   - HTTP response OK?
   - Process running?

2. **Kiểm tra Vite:**
   - Port 5173 listening?
   - Process running?

3. **Auto-Fix với `--fix`:**
   - Laravel down → restart Laravel
   - Vite down → restart Vite
   - Both down → restart entire service

### **Systemd Integration:**
```ini
# Auto-restart on failure
Restart=always
RestartSec=10

# Health check every 30 seconds
OnUnitActiveSec=30s
```

## File Structure

```
laravel-support/
├── src/Commands/
│   ├── ServeDev.php       # Main command
│   ├── ServeDevStop.php   # Stop command
│   ├── ServeDevStatus.php # Status command
│   ├── ServeDevHealth.php # Health check
│   ├── ServeDevService.php # Service management
│   └── ServeDevLogs.php   # Log viewer
└── docs/
    └── SERVE-DEV-COMMANDS.md  # This documentation
```

**PID files:**
- `storage/app/portal.pid` - Laravel PID
- `storage/app/vite.pid` - Vite PID

**Log files:**
- `storage/logs/health-check.log` - Health check logs

## Migration từ External Scripts

**Đã loại bỏ:**
- `scripts/health-check.sh`
- `scripts/install-portal-service.sh`
- `portal.service`, `portal-health.*`
- `PORTAL-SERVICE-DOCS.md`

**Thay thế bằng:**
```bash
# Health check
php artisan serve:dev:health --fix

# Service management
php artisan serve:dev:service install
```

## Benefits

1. **Centralized**: Tất cả trong package
2. **Maintainable**: Dễ update và maintain
3. **Consistent**: Cùng coding standards
4. **Testable**: Có thể viết tests
5. **Documented**: Artisan help sẵn có

## Development Workflow

```bash
# 1. Start development
php artisan serve:dev

# 2. Check status
php artisan serve:dev:status

# 3. Health check (auto-fix)
php artisan serve:dev:health --fix

# 4. Install as service (production)
sudo php artisan serve:dev --service

# 5. Stop everything
php artisan serve:dev:stop
```

**Tất cả đều qua `serve:dev` commands - không còn external scripts!**
