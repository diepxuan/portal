# Changelog - Sửa lỗi Systemd Service

## [2.0.0] - 2026-04-05

### Sửa lỗi nghiêm trọng

#### Tích hợp Systemd Service
Đã sửa các lỗi nghiêm trọng với systemd service gây ra lỗi service và tiến trình zombie.

##### Các lỗi đã sửa

1. **Service restart liên tục** (#SYSTEMD-001)
   - **Triệu chứng**: Service không khởi động được, rơi vào vòng lặp restart liên tục
   - **Nguyên nhân**: Cấu hình `Type=simple` với lệnh fork tiến trình con
   - **Ảnh hưởng**: Service không khả dụng, CPU tăng cao do cố gắng restart
   - **Sửa**: Đổi thành `Type=forking` để phù hợp với hành vi thực tế của tiến trình
   - **File**: `ServeDevService.php`

2. **Tích lũy tiến trình zombie** (#SYSTEMD-002)
   - **Triệu chứng**: Nhiều tiến trình vite/npm/esbuild tích lũy theo thời gian
   - **Nguyên nhân**: `KillMode=process` chỉ kill tiến trình chính, để lại tiến trình con
   - **Ảnh hưởng**: Xung đột cổng, rò rỉ bộ nhớ, mất ổn định hệ thống
   - **Sửa**: Đổi thành `KillMode=control-group` để kill toàn bộ cây tiến trình
   - **File**: `ServeDevService.php`

3. **Xung đột transaction khi Stop/Restart** (#SYSTEMD-003)
   - **Triệu chứng**: Lỗi "destructive transaction" khi stop/restart service
   - **Nguyên nhân**: Health check `ExecStartPost` tạo ra các systemd jobs xung đột
   - **Ảnh hưởng**: Không thể stop hoặc restart service một cách sạch sẽ
   - **Sửa**: Tích hợp health check vào lệnh chính qua flag `--health`
   - **Files**: `ServeDevService.php`, `ServeDev.php`

4. **Shutdown êm ái không hoạt động** (#SYSTEMD-004)
   - **Triệu chứng**: Tiến trình bị kill đột ngột, có thể mất dữ liệu
   - **Nguyên nhân**: Không có xử lý signal trong chế độ foreground
   - **Ảnh hưởng**: Shutdown không sạch sẽ, có thể hỏng dữ liệu
   - **Sửa**: Thêm bộ xử lý signal PCNTL cho SIGTERM/SIGINT
   - **File**: `ServeDev.php`

### Thay đổi

#### ServeDevService.php
- Đổi `Type=simple` thành `Type=forking`
- Đổi `KillMode=process` thành `KillMode=control-group`
- Đổi `TimeoutStopSec=30` thành `TimeoutStopSec=60`
- Cập nhật `ExecStart` bao gồm flags `--foreground --health`
- Xóa health check `ExecStartPost` (tích hợp vào lệnh chính)
- Thêm comments tài liệu chi tiết

#### ServeDev.php
- Nâng cao phương thức `waitForSignal()` với:
  - Xử lý signal PCNTL (SIGTERM, SIGINT)
  - Tự động restart tiến trình con bị lỗi
  - Ghi log trạng thái định kỳ (mỗi 5 phút)
  - Phương thức helper `stopAllServers()` để shutdown êm ái
- Thêm phương thức helper `stopAllServers()`

### Tính năng mới

1. **Health Check tích hợp**
   - Health check giờ chạy như một phần của lệnh chính
   - Không cần systemd timer riêng (vẫn hỗ trợ)
   - Tự động phục hồi tiến trình con bị lỗi

2. **Xử lý Signal**
   - Shutdown êm ái khi nhận SIGTERM (systemd stop)
   - Shutdown êm ái khi nhận SIGINT (Ctrl+C)
   - Dọn dẹp file PID đúng cách

3. **Ghi log trạng thái**
   - Ghi log trạng thái sức khỏe định kỳ vào systemd journal
   - Debug và giám sát dễ dàng hơn

### Tài liệu

- Cập nhật `README-DEV.md` với:
  - Hướng dẫn cài đặt systemd service
  - Tham chiếu lệnh quản lý
  - Mục xử lý sự cố
  - Sơ đồ kiến trúc
  - Thực hành tốt nhất

- Thêm `CHANGELOG-SYSTEMD.md` (file này)

### Hướng dẫn Migration

#### Cho cài đặt hiện có

```bash
# 1. Stop service hiện tại
sudo systemctl stop portal.service
sudo systemctl stop portal-health.timer

# 2. Gỡ cài đặt service cũ
sudo php artisan serve:dev:service uninstall

# 3. Cài đặt lại với cấu hình mới
sudo php artisan serve:dev:service install --interval=30

# 4. Start service
sudo systemctl start portal.service

# 5. Xác minh
sudo systemctl status portal.service
journalctl -u portal.service -f
```

#### Thay đổi cấu hình

File service cũ:
```ini
Type=simple
ExecStart=/usr/bin/php artisan serve:dev
ExecStartPost=/bin/bash -c 'sleep 10 && php artisan serve:dev:health --fix --log'
KillMode=process
TimeoutStopSec=30
```

File service mới:
```ini
Type=forking
ExecStart=/usr/bin/php artisan serve:dev --foreground --health
KillMode=control-group
TimeoutStopSec=60
```

### Testing

Các kịch bản đã test:
- -  Service start/stop/restart
- -  Service enable/disable khi khởi động
- -  Shutdown êm ái dưới tải
- -  Tự động phục hồi tiến trình bị lỗi
- -  Không tích lũy tiến trình zombie
- -  Logs journal sạch sẽ
- -  Health check tự động sửa lỗi

### Tương thích

- **Laravel**: 9.x, 10.x, 11.x
- **PHP**: 8.1+
- **Systemd**: 247+ (test trên Proxmox VE 8.x)
- **Node.js**: 18.x, 20.x, 22.x

### Hạn chế đã biết

1. **Type=forking** yêu cầu lệnh phải daemonize đúng cách
2. **Extension PCNTL** yêu cầu cho xử lý signal
3. **Quyền root** yêu cầu cho cài đặt service

### Contributors

- Duc Tran <ductn@diepxuan.com>

---

**Phiên bản trước**: 1.0.0  
**Phiên bản hiện tại**: 2.0.0  
**Ngày phát hành**: 2026-04-05
