# Changelog - Systemd Service Fixes

## [2.0.0] - 2026-04-05

### Critical Fixes

#### Systemd Service Integration
Fixed critical issues with systemd service that caused service failures and zombie processes.

##### Issues Fixed

1. **Service Restart Loops** (#SYSTEMD-001)
   - **Symptom**: Service failed to start, entering continuous restart loops
   - **Root Cause**: `Type=simple` configuration with a command that forks child processes
   - **Impact**: Service unavailable, high CPU usage from restart attempts
   - **Fix**: Changed to `Type=forking` to match actual process behavior
   - **File**: `ServeDevService.php`

2. **Zombie Process Accumulation** (#SYSTEMD-002)
   - **Symptom**: Multiple vite/npm/esbuild processes accumulated over time
   - **Root Cause**: `KillMode=process` only killed main process, leaving children
   - **Impact**: Port conflicts, memory leaks, system instability
   - **Fix**: Changed to `KillMode=control-group` to kill entire process tree
   - **File**: `ServeDevService.php`

3. **Transaction Conflicts on Stop/Restart** (#SYSTEMD-003)
   - **Symptom**: "destructive transaction" errors when stopping/restarting service
   - **Root Cause**: `ExecStartPost` health check created conflicting systemd jobs
   - **Impact**: Service couldn't be stopped or restarted cleanly
   - **Fix**: Integrated health check into main command via `--health` flag
   - **Files**: `ServeDevService.php`, `ServeDev.php`

4. **Graceful Shutdown Not Working** (#SYSTEMD-004)
   - **Symptom**: Processes killed abruptly, data loss possible
   - **Root Cause**: No signal handling in foreground mode
   - **Impact**: Unclean shutdowns, potential data corruption
   - **Fix**: Added PCNTL signal handlers for SIGTERM/SIGINT
   - **File**: `ServeDev.php`

### Changes

#### ServeDevService.php
- Changed `Type=simple` → `Type=forking`
- Changed `KillMode=process` → `KillMode=control-group`
- Changed `TimeoutStopSec=30` → `TimeoutStopSec=60`
- Updated `ExecStart` to include `--foreground --health` flags
- Removed `ExecStartPost` health check (integrated into main command)
- Added comprehensive documentation comments

#### ServeDev.php
- Enhanced `waitForSignal()` method with:
  - PCNTL signal handling (SIGTERM, SIGINT)
  - Automatic restart of failed child processes
  - Periodic status logging (every 5 minutes)
  - Graceful shutdown via `stopAllServers()` method
- Added `stopAllServers()` helper method

### New Features

1. **Integrated Health Check**
   - Health check now runs as part of main command
   - No separate systemd timer required (but still supported)
   - Auto-recovery for failed child processes

2. **Signal Handling**
   - Graceful shutdown on SIGTERM (systemd stop)
   - Graceful shutdown on SIGINT (Ctrl+C)
   - Proper cleanup of PID files

3. **Status Logging**
   - Periodic health status to systemd journal
   - Easier debugging and monitoring

### Documentation

- Updated `README-DEV.md` with:
  - Systemd service installation guide
  - Management commands reference
  - Troubleshooting section
  - Architecture diagram
  - Best practices

- Added `CHANGELOG-SYSTEMD.md` (this file)

### Migration Guide

#### For Existing Installations

```bash
# 1. Stop current service
sudo systemctl stop portal.service
sudo systemctl stop portal-health.timer

# 2. Uninstall old service
sudo php artisan serve:dev:service uninstall

# 3. Reinstall with new configuration
sudo php artisan serve:dev:service install --interval=30

# 4. Start service
sudo systemctl start portal.service

# 5. Verify
sudo systemctl status portal.service
journalctl -u portal.service -f
```

#### Configuration Changes

Old service file:
```ini
Type=simple
ExecStart=/usr/bin/php artisan serve:dev
ExecStartPost=/bin/bash -c 'sleep 10 && php artisan serve:dev:health --fix --log'
KillMode=process
TimeoutStopSec=30
```

New service file:
```ini
Type=forking
ExecStart=/usr/bin/php artisan serve:dev --foreground --health
KillMode=control-group
TimeoutStopSec=60
```

### Testing

Tested scenarios:
- ✅ Service start/stop/restart
- ✅ Service enable/disable on boot
- ✅ Graceful shutdown under load
- ✅ Auto-recovery of failed processes
- ✅ No zombie process accumulation
- ✅ Clean journal logs
- ✅ Health check auto-fix

### Compatibility

- **Laravel**: 9.x, 10.x, 11.x
- **PHP**: 8.1+
- **Systemd**: 247+ (tested on Proxmox VE 8.x)
- **Node.js**: 18.x, 20.x, 22.x

### Known Limitations

1. **Type=forking** requires the command to properly daemonize
2. **PCNTL extension** required for signal handling
3. **Root access** required for service installation

### Contributors

- Duc Tran <ductn@diepxuan.com>

---

**Previous Version**: 1.0.0  
**Current Version**: 2.0.0  
**Release Date**: 2026-04-05
