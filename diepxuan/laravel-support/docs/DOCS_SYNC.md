# Documentation Sync Commands

Tự động sync tài liệu từ SimbaSql → Portal với real-time watch.

---

## 📦 Commands

### 1. `docs:sync` - Sync một lần

Sync toàn bộ docs từ source → destination.

```bash
php artisan docs:sync \
    --source=/root/.openclaw/workspace/projects/SimbaSql/docs \
    --dest=/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/docs
```

#### Options:

| Option | Default | Mô tả |
|--------|---------|-------|
| `--source` | `/root/.openclaw/workspace/projects/SimbaSql/docs` | Source directory |
| `--dest` | `/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/docs` | Destination directory |
| `--dry-run` | `false` | Show what would be copied without copying |
| `--delete` | `false` | Delete files in dest not in source |
| `--verbose` | `false` | Show detailed output |

#### Examples:

```bash
# Sync với dry-run (xem trước)
php artisan docs:sync --dry-run --verbose

# Sync và xóa files thừa trong dest
php artisan docs:sync --delete

# Sync với source/dest custom
php artisan docs:sync --source=/path/to/source --dest=/path/to/dest
```

---

### 2. `docs:watch` - Watch và auto-sync

Watch filesystem changes và tự động sync khi có thay đổi.

```bash
php artisan docs:watch
```

#### Options:

| Option | Default | Mô tả |
|--------|---------|-------|
| `--source` | `/root/.openclaw/workspace/projects/SimbaSql/docs` | Source directory |
| `--dest` | `/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/docs` | Destination directory |
| `--foreground` | `false` | Run in foreground (cho systemd service) |
| `--service` | `false` | Install as systemd service |
| `--interval` | `5` | Debounce interval in seconds |
| `--log` | `false` | Log to storage/logs/docs-sync.log |

#### Examples:

```bash
# Watch trong foreground (cho testing)
php artisan docs:watch --foreground

# Install systemd service
sudo php artisan docs:watch --service

# Watch với custom interval
php artisan docs:watch --foreground --interval=10
```

---

### 3. `docs:watch:status` - Kiểm tra status

```bash
php artisan docs:watch:status
php artisan docs:watch:status --verbose
```

---

### 4. `docs:watch:stop` - Stop watcher

```bash
php artisan docs:watch:stop
php artisan docs:watch:stop --force  # Force kill
```

---

## 🔧 Systemd Service

### Install Service

```bash
sudo php artisan docs:watch --service
```

Service sẽ:
1. Kiểm tra và cài đặt `inotify-tools` nếu chưa có
2. Tạo systemd service file
3. Enable và start service

### Management Commands

```bash
# Check status
sudo systemctl status portal-docs-watch.service

# Start/Stop/Restart
sudo systemctl start portal-docs-watch.service
sudo systemctl stop portal-docs-watch.service
sudo systemctl restart portal-docs-watch.service

# Enable/Disable auto-start
sudo systemctl enable portal-docs-watch.service
sudo systemctl disable portal-docs-watch.service

# View logs
journalctl -u portal-docs-watch.service -f
journalctl -u portal-docs-watch.service --no-pager -n 50
```

### Service Files

| File | Path |
|------|------|
| Service | `/etc/systemd/system/portal-docs-watch.service` |

---

## 📊 Architecture

```
┌─────────────────────────────────────────────────────────┐
│ systemd service (portal-docs-watch.service)            │
│ ExecStart: php artisan docs:watch --foreground         │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ docs:watch command                                      │
│ - Check requirements (inotify-tools)                   │
│ - Initial sync                                          │
│ - Loop: inotifywait → debounce → sync                  │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ inotifywait (from inotify-tools package)               │
│ - Watch: modify, create, delete, move                  │
│ - Block until event occurs                             │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ docs:sync command                                       │
│ - Use rsync (preferred) or cp (fallback)               │
│ - Sync files from source → dest                        │
└─────────────────────────────────────────────────────────┘
```

---

## 📦 Requirements

### inotify-tools (BẮT BUỘC)

Package cung cấp `inotifywait` binary để watch filesystem events.

**Cài đặt tự động:**
```bash
sudo php artisan docs:watch --service
# Tự động cài đặt inotify-tools nếu chưa có
```

**Cài đặt thủ công:**
```bash
# Ubuntu/Debian
sudo apt-get install inotify-tools

# CentOS/RHEL
sudo yum install inotify-tools

# Alpine
sudo apk add inotify-tools
```

**Kiểm tra:**
```bash
which inotifywait
inotifywait --version
```

### rsync (OPTIONAL nhưng recommended)

Dùng để sync hiệu quả hơn (chỉ copy files thay đổi).

```bash
# Ubuntu/Debian
sudo apt-get install rsync

# CentOS/RHEL
sudo yum install rsync
```

**Fallback:** Nếu không có rsync, command sẽ dùng `cp`.

---

## 🔍 Troubleshooting

### 1. "inotifywait not found"

```bash
# Kiểm tra
which inotifywait

# Cài đặt
sudo apt-get install inotify-tools
```

### 2. Service không start được

```bash
# Check status
sudo systemctl status portal-docs-watch.service

# View logs
journalctl -u portal-docs-watch.service -f

# Restart
sudo systemctl restart portal-docs-watch.service
```

### 3. Files không được sync

```bash
# Check source directory
ls -la /root/.openclaw/workspace/projects/SimbaSql/docs

# Run manual sync
php artisan docs:sync --verbose

# Check logs
tail -f storage/logs/docs-sync.log
```

### 4. Permission denied

```bash
# Ensure proper permissions
chmod -R 755 /root/.openclaw/workspace/projects/SimbaSql/docs
chmod -R 755 /root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/docs

# Or run as root
sudo php artisan docs:sync
```

---

## 📝 Log Files

| Log | Path |
|-----|------|
| Sync log | `storage/logs/docs-sync.log` |
| Systemd journal | `journalctl -u portal-docs-watch.service` |

---

## 🎯 Best Practices

1. **Run initial sync trước khi enable watch:**
   ```bash
   php artisan docs:sync
   php artisan docs:watch --service
   ```

2. **Use --dry-run để test trước:**
   ```bash
   php artisan docs:sync --dry-run --verbose
   ```

3. **Set appropriate debounce interval:**
   - Default: 5s (good for most cases)
   - Increase nếu có nhiều file changes cùng lúc

4. **Monitor logs regularly:**
   ```bash
   journalctl -u portal-docs-watch.service -f
   ```

---

**Updated:** 2026-04-12  
**Version:** 1.0
