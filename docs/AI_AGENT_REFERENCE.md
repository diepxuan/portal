# Tài liệu tham khảo cho AI Agent

## Giới thiệu

Tài liệu này cung cấp thông tin cần thiết cho AI Agent để hiểu và làm việc hiệu quả trên dự án Portal, đặc biệt là phần tích hợp với hệ thống SimbaSql. Các AI Agent cần tuân thủ các quy tắc và sử dụng thông tin dưới đây một cách chính xác.

## 1. Tổng quan về Dự án Portal và SimbaSql

- **Portal**: Là ứng dụng Laravel 11 được module hóa bằng các package nội bộ (`diepxuan/*`). Cung cấp giao diện và logic nghiệp vụ hiện đại.
- **SimbaSql**: Là cơ sở dữ liệu của hệ thống ERP Simba, chứa đựng logic nghiệp vụ cốt lõi và dữ liệu lịch sử.
- **Mối quan hệ**: Portal tích hợp với SimbaSql thông qua package `diepxuan/laravel-simba`. Package này cung cấp Eloquent Models (ánh xạ đến bảng SimbaSql) và các lớp PHP để gọi Stored Procedures của SimbaSql.
- **Mục tiêu tích hợp**: Tận dụng dữ liệu và logic nghiệp vụ sẵn có của SimbaSql, xây dựng các tính năng mới trên nền tảng Portal, đảm bảo tính nhất quán và hiệu suất.

## 2. Cấu trúc Thư mục Chính

- **`/root/.openclaw/workspace/portal/`**: Thư mục gốc của dự án Portal.
  - **`app/`**: Code nguồn chính của ứng dụng Laravel (Controllers, Providers, v.v.).
  - **`bootstrap/`**: Các file khởi tạo ứng dụng.
  - **`config/`**: Các file cấu hình của Laravel.
  - **`database/`**: Migrations, Seeders, Factories.
  - **`diepxuan/`**: Chứa **14 package Laravel nội bộ**. Đây là khu vực làm việc chính cho AI Agent.
    - **`diepxuan/laravel-simba/`**: Package cốt lõi cho tích hợp SimbaSql.
      - **`src/SModel/`**: ~440 Eloquent Models ánh xạ đến các bảng SimbaSql.
      - **`src/StoredProcedures/`**: ~376+ lớp PHP gọi các Stored Procedures của SimbaSql.
      - **`docs/`**: Tài liệu chi tiết về Stored Procedures.
    - **Các package khác**: `laravel-catalog`, `laravel-core`, `laravel-magento`, v.v.
  - **`public/`**: Thư mục công khai (index.php).
  - **`resources/`**: Views, assets.
  - **`routes/`**: Định nghĩa các routes của ứng dụng.
  - **`storage/`**: Log files, cache, uploads.
- **`/root/.openclaw/workspace/SimbaSql/`**: Thư mục chứa các script SQL gốc của hệ thống SimbaSql.
  - **`dbo/Tables/`**: Hơn 200 script tạo bảng.
  - **`dbo/StoredProcedures/`**: Hơn 500 script Stored Procedures gốc.

## 3. Stored Procedures (SimbaSql)

- **Tổng số lượng đã chuyển đổi sang lớp PHP**: Hơn **376** procedures.
- **Mục đích**: Đóng gói logic nghiệp vụ cốt lõi, đảm bảo tính nhất quán.
- **Cách gọi**: Sử dụng các lớp tĩnh trong `Diepxuan\Simba\StoredProcedures\`.
  - Ví dụ: `AsGetSoCt::call(['pMa_Cty' => '01', 'pNgay_Ct' => '2024-01-01'])`.
- **Phân loại**: Thường được nhóm theo tiền tố (`asAP`, `asAR`, `asGL`, `asIN`, `z`, `sp`) và phân hệ nghiệp vụ.
- **Tài liệu chi tiết**: Tham khảo `diepxuan/laravel-simba/PROCEDURES.md` và các file trong `diepxuan/laravel-simba/docs/`.

## 4. Eloquent Models (SimbaSql)

- **Tổng số lượng**: Hơn **440** models.
- **Mục đích**: Cung cấp giao diện Object-Oriented để truy cập dữ liệu SimbaSql.
- **Vị trí**: `Diepxuan\Simba\SModel\` (ánh xạ trực tiếp) và `Diepxuan\Simba\Models\` (mở rộng).
- **Đặc điểm**: Hỗ trợ Composite Primary Keys (ví dụ: `SysUserCompanyRight`), quản lý kết nối database riêng.
- **Cách sử dụng**: Sử dụng như Eloquent Models thông thường (`Model::all()`, `Model::find()`, `Model::where()->get()`, `Model::create()`, `Model::update()`, `Model::delete()`).
- **Lưu ý**: Khóa chính composite cần được xử lý cẩn thận khi query.

## 5. Liên kết giữa SimbaSql và Portal

- **SQL Tables -> Eloquent Models**: Mỗi bảng trong `SimbaSql/dbo/Tables/` có một Eloquent Model tương ứng trong `diepxuan/laravel-simba/src/SModel/`.
- **SQL Procedures -> PHP Classes**: Mỗi Stored Procedure trong `SimbaSql/dbo/StoredProcedures/` có một lớp PHP tĩnh tương ứng trong `diepxuan/laravel-simba/src/StoredProcedures/`.
- **Package trung gian**: `diepxuan/laravel-simba` đóng vai trò cầu nối.
- **Package hỗ trợ**: `diepxuan/laravel-eloquent-composite` (cho Composite PK), `diepxuan/php-charset` (cho tiếng Việt).

## 6. Hướng dẫn sử dụng & Tích hợp

- **Cài đặt**: `composer require diepxuan/laravel-simba`.
- **Cấu hình DB**: Thiết lập `SIMBA_CONNECTION`, `DB_HOST_SIMBA`, v.v. trong `.env` và `config/database.php`.
- **Sử dụng Models**: Truy vấn, thêm, sửa, xóa dữ liệu qua các instance của Models.
- **Gọi Stored Procedures**: Sử dụng các lớp tĩnh `::call()` để thực thi logic nghiệp vụ.
- **Tác vụ nền**: Sử dụng Laravel Queues cho các công việc xử lý nặng.
- **Luồng làm việc AI Agent**: Tuân thủ `AI_AGENT_GUIDE.md` (chỉ làm việc trong `diepxuan/*`, quy trình Git nghiêm ngặt).

## 7. Quy ước đặt tên

- **Bảng SimbaSql**: Tiền tố theo phân hệ (`Ap`, `Ar`, `Gl`, `Si`, `In`, `Co`, `Ca`, `Hr`, `z_`) + Hậu tố theo loại (`Ct`, `Ph`, `Tt`, `Dm`, `Cd`).
- **Stored Procedures**: Tiền tố (`as`, `sp`, `z`, `af`, `av`) + Tên nghiệp vụ.
- **Eloquent Models**: Thường là tên bảng hoặc tên rút gọn, đặt trong `SModel/` hoặc `Models/`.
- **PHP Classes cho SPs**: Tên tương ứng với Stored Procedure gốc (ví dụ: `AsGetSoCt`).
- **Files tài liệu**: Markdown (`.md`) trong thư mục `portal/docs/`.

## 8. Database Schema (SimbaSql)

- **Hơn 200 bảng dữ liệu**, phân loại theo phân hệ.
- **Các bảng chính**: `GlCt`, `ArDmKh`, `InDmVt`, `SysCompany`, `SysUserInfo`, v.v.
- **Cột audit**: `cdate`, `cuser`, `ldate`, `luser`.
- **Cột khóa chính**: Thường bao gồm `ma_cty` và các trường khác.
- **Cấu trúc chi tiết**: Tham khảo `DATABASE_SCHEMA.md` và các file `DOCUMENTATION.md` trong `SimbaSql/`.

## Quy trình làm việc của AI Agent

1.  **Hiểu yêu cầu**: Nắm rõ task và phạm vi (chỉ làm việc trong `diepxuan/*`).
2.  **Khám phá codebase**: Sử dụng các lệnh `ls`, `find`, `read` để tìm hiểu cấu trúc, file liên quan.
3.  **Sử dụng Tool**: Gọi các tool `write`, `edit`, `exec` để tạo/sửa file.
4.  **Tham khảo tài liệu**: Sử dụng các file `.md` đã tạo để hiểu về Models, SPs, quy ước.
5.  **Tuân thủ quy trình Git**: `git checkout main`, `git pull`, tạo branch `task/...`, commit message chuẩn, tạo PR.
6.  **Ưu tiên an toàn**: Không tự ý sửa ngoài phạm vi, không phá vỡ API, dừng lại nếu không chắc chắn.

---
*Tài liệu này được tạo ra để hỗ trợ AI Agent làm việc hiệu quả.*