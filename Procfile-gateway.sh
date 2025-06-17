#!/bin/bash
# File: start-services.sh
# Script này sẽ thiết lập các biến môi trường và khởi động Docker Compose.

# Dùng set -e để thoát ngay khi có lỗi
set -e

echo "--- Preparing environment for Docker Compose ---"

# 1. Gán các biến môi trường cần thiết
# Lấy PORT từ môi trường bên ngoài, nếu không có thì mặc định là 8000
export APP_PORT=${PORT:-8000}

# Lấy UID và GID của user hiện tại
export WWWUSER=$(id -u)
export WWWGROUP=$(id -g)

# In ra để debug
echo "Using APP_PORT: $APP_PORT"
echo "Using WWWUSER: $WWWUSER"
echo "Using WWWGROUP: $WWWGROUP"

# 2. Bây giờ mới chạy Docker Compose
# Nó sẽ tự động kế thừa các biến môi trường đã được export ở trên.
echo "--- Starting Docker Compose ---"
docker compose up -d

# 3. (Tùy chọn) Theo dõi log của một dịch vụ cụ thể
# Lệnh `docker compose up -d` sẽ thoát ngay, nhưng foreman cần một tiến trình
# chạy "mãi mãi". `docker compose logs -f` là một lựa chọn tốt.
# Nó sẽ hiển thị log của tất cả các dịch vụ và giữ cho tiến trình "sống".
echo "--- Tailing logs ---"
docker compose logs -f