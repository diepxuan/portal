# Hướng dẫn tích hợp và sử dụng trong Laravel Project

## Giới thiệu

Tài liệu này hướng dẫn cách tích hợp và sử dụng các thành phần của hệ thống SimbaSql vào một dự án Laravel. Portal là ví dụ điển hình cho việc tích hợp này, sử dụng package `diepxuan/laravel-simba` để kết nối và làm việc với database SimbaSql.

## Kiến trúc tích hợp tổng thể

```mermaid
graph TD
    A[Laravel Application (Portal)] --> B(diepxuan/laravel-simba Package)
    B --> C{Database Connection Configuration}
    C --> D[SQL Server (SimbaSql Database)]
    B --> E(Eloquent Models - SModel)
    B --> F(Stored Procedure Classes)
    E --> D
    F --> D
    A --> G[Frontend/API Layer]
    G --> B
```

## Các bước tích hợp

### 1. Cài đặt package `laravel-simba`

Trong project Laravel của bạn, chạy lệnh Composer sau:

```bash
composer require diepxuan/laravel-simba
```

Package này sẽ được thêm vào `vendor/diepxuan/laravel-simba` và tự động autoload.

### 2. Cấu hình kết nối Database SimbaSql

File `.env` của ứng dụng Laravel cần được cấu hình để kết nối đến database SimbaSql.

```env
# Cấu hình chung cho database Simba
SIMBA_CONNECTION=sqlsrv
DB_HOST_SIMBA=your_simba_db_host
DB_PORT_SIMBA=1433
DB_DATABASE_SIMBA=SimbaERP
DB_USERNAME_SIMBA=your_simba_db_user
DB_PASSWORD_SIMBA=your_simba_db_password

# Nếu bạn muốn dùng chung kết nối với DB chính của Laravel, thì không cần các biến trên
# và cấu hình DB_CONNECTION=sqlsrv trong config/database.php
```

**Quan trọng:**
- `SIMBA_CONNECTION`: Đảm bảo bạn đã cài đặt driver `sqlsrv` cho PHP (thường dùng `pdo_sqlsrv`).
- Các biến `DB_HOST_SIMBA`, `DB_PORT_SIMBA`, `DB_DATABASE_SIMBA`, `DB_USERNAME_SIMBA`, `DB_PASSWORD_SIMBA` cần được thay thế bằng thông tin kết nối thực tế đến server SimbaSql.

### 3. Khai báo kết nối Database (nếu cần)

Nếu bạn sử dụng các biến `DB_HOST_SIMBA`, `DB_PORT_SIMBA`, v.v. riêng biệt, bạn cần khai báo một kết nối database tùy chỉnh trong `config/database.php`.

**Ví dụ:** Thêm một mục vào mảng `connections` trong `config/database.php`:

```php
'connections' => [
    // ... các kết nối khác
    'simbasql' => [
        'driver' => 'sqlsrv',
        'host' => env('DB_HOST_SIMBA', 'localhost'),
        'port' => env('DB_PORT_SIMBA', '1433'),
        'database' => env('DB_DATABASE_SIMBA', 'SimbaERP'),
        'username' => env('DB_USERNAME_SIMBA', 'root'),
        'password' => env('DB_PASSWORD_SIMBA', ''),
        'charset' => 'utf8', // hoặc 'utf8mb4'
        'prefix' => '',
        'options' => [
            PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
        ]
    ],
],
```

Sau đó, trong `laravel-simba` package, `SModel` sẽ tự động tìm và sử dụng kết nối `simbasql` hoặc `sqlsrv` tùy theo cấu hình `SIMBA_CONNECTION`.

### 4. Sử dụng Eloquent Models

Các models được cung cấp trong `Diepxuan\Simba\SModel\` (hoặc `Diepxuan\Simba\Models\` cho các model mở rộng).

**Ví dụ:** Lấy danh sách khách hàng từ bảng `ArDmKh`:

```php
use Diepxuan\Simba\SModel\ArDmKh;

$customers = ArDmKh::where('isKh', 1)->get();

foreach ($customers as $customer) {
    echo $customer->ten_kh . " - " . $customer->dia_chi . "\n";
}
```

**Lưu ý về Composite Primary Keys:**

Nhiều bảng trong SimbaSql có khóa chính gồm nhiều cột (ví dụ: `SysUserCompanyRight` có `user_id` và `ma_cty`). Các model tương ứng đã được cấu hình để xử lý điều này. Khi tìm kiếm hoặc cập nhật bản ghi, bạn cần cung cấp đủ các cột trong khóa chính.

```php
use Diepxuan\Simba\SModel\SysUserCompanyRight;

// Tìm bản ghi với khóa chính composite
$userRight = SysUserCompanyRight::where([\n    'user_id' => $userId,\n    'ma_cty' => $companyId,\n])->first();
```

### 5. Sử dụng Stored Procedures

Các stored procedures được đóng gói thành các lớp PHP tĩnh trong `Diepxuan\Simba\StoredProcedures\`.

**Ví dụ:** Gọi procedure `asGetSoCt` để lấy danh sách chứng từ bán hàng:

```php
use Diepxuan\Simba\StoredProcedures\AsGetSoCt;

$salesDocuments = AsGetSoCt::call([
    'pMa_Cty' => '01',
    'pNgay_Ct' => '2024-01-01',
]);

foreach ($salesDocuments as $doc) {
    echo $doc->so_ct . " - " . $doc->dien_giai . "\n";
}
```

## Tích hợp vào Laravel Project

### 1. Truy cập dữ liệu và nghiệp vụ

- **Controller/Service Layer**: Gọi các Models hoặc Stored Procedure Classes để lấy/thao tác dữ liệu.
- **Business Logic**: Tích hợp các quy trình nghiệp vụ phức tạp bằng cách gọi các Stored Procedures.
- **API Endpoints**: Xây dựng các API routes để truy xuất dữ liệu Simba thông qua Models hoặc Stored Procedures.

### 2. Xử lý các tác vụ nền (Background Jobs)

Các tác vụ tốn thời gian (ví dụ: đồng bộ dữ liệu lớn, tạo báo cáo phức tạp) nên được thực hiện dưới dạng Queue Jobs.

```php
// Trong một Job hoặc Controller
use App\Jobs\SyncSimbaData;

$simbaData = SimbaDataFetcher::fetchLargeData(); // Lấy dữ liệu từ Simba qua Models/SPs

SyncSimbaData::dispatch($simbaData);
```

### 3. Xử lý lỗi và Logging

- **Database Errors**: Bắt các Exception SQL khi thao tác với database hoặc gọi Stored Procedures.
- **Application Errors**: Sử dụng Laravel's logging facilities để ghi lại các lỗi trong quá trình tích hợp.
- **Custom Logging**: Package `laravel-log` có thể được sử dụng để tách biệt log của các tác vụ liên quan đến Simba.

### 4. Tích hợp với các hệ thống khác

- **Magento**: Sử dụng `diepxuan/laravel-magento` để đồng bộ dữ liệu.
- **Gmail**: Sử dụng `diepxuan/laravel-gmail` cho việc gửi/nhận email.
- **Ronald Jack**: Sử dụng `diepxuan/laravel-ronaldjack` để tích hợp máy chấm công.

## Best Practices

- **Tách biệt concerns**: Giữ logic nghiệp vụ của Simba trong Stored Procedures và Models, logic ứng dụng trong Controllers/Services/Jobs.
- **Sử dụng `where` clause hiệu quả**: Luôn chỉ định `ma_cty` và các khóa chính khi query.
- **Transaction Management**: Đảm bảo các thao tác quan trọng được bao bọc trong transaction.
- **Performance**: Tối ưu hóa các câu truy vấn và việc gọi Stored Procedures.
- **Error Handling**: Xử lý các lỗi có thể xảy ra từ database hoặc application layer.

## Tài liệu liên quan

- [OVERVIEW.md](./OVERVIEW.md) - Tổng quan dự án và mối quan hệ Portal - SimbaSql.
- [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md) - Cấu trúc database SimbaSql.
- [STORED_PROCEDURES.md](./STORED_PROCEDURES.md) - Tài liệu Stored Procedures.
- [ELOQUENT_MODELS.md](./ELOQUENT_MODELS.md) - Tài liệu Eloquent Models.
- [AI_AGENT_REFERENCE.md](./AI_AGENT_REFERENCE.md) - Tài liệu tham khảo cho AI Agent.

---
*Tài liệu được cập nhật lần cuối: 2026-02-13*