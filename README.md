# Diepxuan Portal (Laravel 11)

Portal là ứng dụng web cốt lõi cho hệ sinh thái Diepxuan, được xây dựng trên nền tảng Laravel 11. Nó đóng vai trò là nền tảng tập trung tích hợp nhiều module nghiệp vụ khác nhau thông qua kiến trúc module hóa.

## 📚 Tài liệu quan trọng

Tài liệu cần đọc cho lập trình viên và AI agents làm việc trên dự án này:

- **[Hướng dẫn AI Agent](AI_AGENT_GUIDE.md)**: **BẮT BUỘC ĐỌC**. Các quy tắc nghiêm ngặt cho AI agents về phạm vi công việc, quy trình git và an toàn code.
- **[Tổng quan kiến trúc](ARCHITECTURE.md)**: Hướng dẫn toàn diện về kiến trúc hệ thống, luồng dữ liệu và các thành phần cốt lõi.
- **[Hệ thống Package](PACKAGES.md)**: Chi tiết về 14 package nội bộ (trong thư mục `diepxuan/`) và cách hệ thống module hoạt động.
- **[Thiết lập môi trường phát triển](DEVELOPMENT.md)**: Hướng dẫn từng bước để cài đặt môi trường development trên máy local.

## 🚀 Bắt đầu nhanh

1. **Clone & Cài đặt**:
   ```bash
   git clone git@github.com:diepxuan/portal.git
   cd portal
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   ```

2. **Cấu hình Database**: Cập nhật file `.env` với thông tin kết nối database của bạn.

3. **Chạy Dev Server** (Recommended - dùng serve:dev commands):
   ```bash
   # Start development environment với 1 command
   ./portal-dev.sh start
   
   # Hoặc dùng artisan command trực tiếp
   php artisan serve:dev
   ```

## 🧩 Cấu trúc dự án

- **`app/`**: Logic ứng dụng Laravel chuẩn.
- **`diepxuan/`**: **Core Business Logic (Nghiệp vụ cốt lõi)**. Chứa 14 modular packages (được symlink qua Composer). **Hầu hết việc phát triển diễn ra ở đây.**
- **`resources/`**: Views và assets.

## 🤝 Đóng góp (Contributing)

Vui lòng tham khảo [AI_AGENT_GUIDE.md](AI_AGENT_GUIDE.md) để biết chi tiết về quy trình đóng góp.

---

## Laravel Framework (Original README)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.
