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