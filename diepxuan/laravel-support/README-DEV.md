# Laravel Support - Development Commands

This package provides development environment management commands for Portal projects.

## 🚀 Installation

The package is already included in the Portal project. To use the development commands:

```bash
# Make sure the package is loaded
composer dump-autoload

# Check available commands
php artisan list | grep dev
```

## 📋 Available Commands

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

## 🔧 Automatic Fixes

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

## 📝 Notes

- Development commands work even if artisan has issues
- PID files are automatically cleaned up
- All commands are safe to run multiple times
- No external web server required (uses PHP built-in server)
- SQLite database for easy development setup

## 🚀 Quick Start

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

## 🔥 NEW: Systemd Service Integration (2026-04-05)

### Overview

The `serve:dev` command now supports running as a systemd service with proper process management and health checks.

### Quick Start

```bash
# Install as systemd service
sudo php artisan serve:dev --service --health

# Start the service
sudo systemctl start portal.service

# Check status
sudo systemctl status portal.service

# View logs
journalctl -u portal.service -f
```

### Command Options

```bash
php artisan serve:dev [options]

Options:
      --host[=HOST]         Host address (default: "0.0.0.0")
      --port[=PORT]         Port number (default: 8000)
      --vite-port[=PORT]    Vite port (default: 8073)
      --no-vite             Skip Vite server
      --foreground          Run in foreground (for systemd)
      --service             Install as systemd service
      --health              Enable health check
      --health-interval=N   Health check interval in seconds (default: 30)
```

### Service Management Commands

```bash
# Install service
sudo php artisan serve:dev:service install

# Uninstall service
sudo php artisan serve:dev:service uninstall

# Start/Stop/Restart
sudo systemctl start portal.service
sudo systemctl stop portal.service
sudo systemctl restart portal.service

# Enable/disable on boot
sudo systemctl enable portal.service
sudo systemctl disable portal.service

# Check status
sudo systemctl status portal.service
sudo systemctl status portal-health.timer
```

### Critical Fixes Applied

#### Issue 1: Service Restart Loops
**Problem**: Service failed to start, entering restart loops.

**Root Cause**: `Type=simple` with a command that forks child processes and exits.

**Solution**: Changed to `Type=forking` to match actual process behavior.

#### Issue 2: Zombie Processes
**Problem**: Multiple vite/npm/esbuild processes accumulated over time, causing port conflicts.

**Root Cause**: `KillMode=process` only killed the main process, leaving children running.

**Solution**: Changed to `KillMode=control-group` to kill all processes in the cgroup.

#### Issue 3: Transaction Conflicts
**Problem**: Service failed to stop/restart with "destructive transaction" errors.

**Root Cause**: `ExecStartPost` health check created conflicting systemd jobs.

**Solution**: Integrated health check into main command via `--health` flag.

### Service File Configuration

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

### Health Check

The health check runs automatically every 30 seconds (configurable) and:
- Checks if Laravel server is responding (HTTP 200/302)
- Checks if Vite server is running
- Automatically restarts failed services
- Logs to systemd journal

```bash
# Manual health check
php artisan serve:dev:health --fix --log

# View health check logs
journalctl -u portal-health.service -f
```

### Troubleshooting

#### Service won't start
```bash
# Check logs
journalctl -u portal.service -n 50 --no-pager

# Check for port conflicts
ss -tlnp | grep -E '8000|8073'

# Kill zombie processes
pkill -f 'artisan serve'
pkill -f 'node.*vite'
pkill -f 'esbuild'
```

#### Zombie processes
```bash
# Stop service properly
sudo systemctl stop portal.service

# Verify all processes killed
ps aux | grep -E 'artisan|vite|esbuild' | grep -v grep

# If still running, force kill
sudo systemctl kill portal.service
```

#### Port conflicts after restart
```bash
# Uninstall and reinstall service
sudo php artisan serve:dev:service uninstall
sudo php artisan serve:dev:service install
```

### Best Practices

1. **Always use `--foreground --health`** when running as systemd service
2. **Set `KillMode=control-group`** to prevent zombie processes
3. **Use `TimeoutStopSec=60`** for graceful shutdown
4. **Monitor logs regularly**: `journalctl -u portal.service -f`
5. **Check health timer**: `systemctl status portal-health.timer`

### Architecture

```
systemd
  └── portal.service (Type=forking)
       ├── Main process (monitor, exits after spawn)
       ├── php artisan serve (PID file tracked)
       └── npm run vite (child of serve)
            
portal-health.timer (every 30s)
  └── portal-health.service
       └── php artisan serve:dev:health --fix --log
```

---

**Last Updated**: 2026-04-05  
**Version**: 2.0.0 (with systemd support)
