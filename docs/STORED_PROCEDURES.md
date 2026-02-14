# Tài liệu Stored Procedures (SimbaSql)

## Giới thiệu

Tài liệu này mô tả về các stored procedures từ hệ thống SimbaSql đã được chuyển đổi thành các lớp PHP trong package `diepxuan/laravel-simba`. Mục tiêu là cung cấp một giao diện lập trình (API) rõ ràng và nhất quán cho các AI Agent khi làm việc với logic nghiệp vụ cốt lõi của Simba.

## Tổng quan

- **Số lượng Stored Procedures đã chuyển đổi**: Hơn **376** procedures.
- **Mục đích**: Đóng gói logic nghiệp vụ phức tạp, đảm bảo tính nhất quán và hiệu suất.
- **Cơ sở dữ liệu gốc**: SimbaSql (SQL Server).
- **Thư mục chứa code PHP**: `diepxuan/laravel-simba/src/StoredProcedures/`.
- **Thư mục tài liệu chi tiết**: `diepxuan/laravel-simba/docs/procedures-*.md`.

## Quy ước đặt tên và phân loại

Các stored procedures được nhóm dựa trên tiền tố và chức năng chính:

### 1. Theo tiền tố (Prefix)

- **`as*`**: Nhóm procedures chính của Asia Software (ví dụ: `asAP...`, `asAR...`, `asGL...`, `asIN...`, `asSI...`, `asPost...`, `asGet...`). Đây là nhóm lớn nhất, bao gồm các nghiệp vụ cốt lõi.
- **`sp*`**: Stored Procedures thông thường.
- **`z*`**: Procedures tạm thời, sao lưu hoặc các chức năng đặc biệt (ví dụ: `ZCreateCompany`, `ZGenSpCt`).
- **`af*`**: Aggregate Functions (hàm tính toán, ví dụ: `afDuCuoiTk`, `afDuDauTk`).
- **`av*`**: Views (ví dụ: `avDependencies`, `avIndex`).

### 2. Theo phân hệ nghiệp vụ

Các procedures thường có tiền tố chỉ phân hệ (ví dụ: `AP` cho Accounts Payable, `AR` cho Accounts Receivable, `GL` cho General Ledger, `IN` cho Inventory, `SI` cho System, `HR` cho Human Resources, `PO` cho Purchase Order, `CA` cho Fixed Assets).

## Danh sách các nhóm Stored Procedures chính (ước tính theo `PROCEDURES.md`)

| Nhóm Stored Procedure | Mô tả chi tiết | Số lượng (ước tính) |
|----------------------|----------------|---------------------|
| **asGL*** (General Ledger) | Các procedure liên quan đến kế toán tổng hợp, báo cáo tài chính, sổ cái. | 20+ |
| **asIN*** (Inventory) | Các procedure quản lý kho, vật tư, chứng từ kho. | 22+ |
| **asHR*** (Human Resources) | Các procedure liên quan đến quản lý nhân sự, chấm công, lương, đánh giá. | Ít hơn GL, IN |
| **asSI*** (System & Inventory) | Các procedure hệ thống, bán hàng, quản lý chung. | 23+ |
| **asDel*** (Delete) | Các procedure xóa dữ liệu (chứng từ, danh mục). | 1+ |
| **asAR*** (Accounts Receivable) | Các procedure quản lý công nợ phải thu, thanh toán. | 11+ |
| **asPost*** (Posting) | Các procedure ghi sổ, cập nhật số liệu kế toán/kho. | Nhiều |
| **asAP*** (Accounts Payable) | Các procedure quản lý công nợ phải trả, thanh toán. | 18+ |
| **asPO*** (Purchase Order) | Các procedure liên quan đến đơn mua hàng. | 14+ |
| **asFA*** (Fixed Assets) | Các procedure quản lý tài sản cố định. | Nhiều |
| **asCA*** (Fixed Assets) | Các procedure quản lý tài sản cố định. | Nhiều |
| **System/Utility** | Các procedure tiện ích, hệ thống, quản lý người dùng, cấu hình. | 46+ |

*Lưu ý: Số lượng trên là ước tính dựa trên file `PROCEDURES.md`. Tổng số lên tới 376+ procedures đã được chuyển đổi.* 

## Cách sử dụng trong Portal

### 1. Sử dụng lớp PHP thay thế

Mỗi stored procedure được ánh xạ tới một lớp PHP tĩnh tương ứng trong namespace `Diepxuan\Simba\StoredProcedures\`.

**Cú pháp gọi chung:**
```php
use Diepxuan\Simba\StoredProcedures\{TênLớpProcedure};

// Khai báo tham số theo định dạng mảng associative
$params = [
    'pMa_cty' => '001',
    'pNgay_ct' => '2024-01-01',
    // ... các tham số khác
];

// Gọi hàm call tĩnh
$result = {TênLớpProcedure}::call($params);

// $result thường là một Illuminate\Support\Collection, hoặc giá trị đơn lẻ tùy procedure.
```

**Ví dụ:** Gọi procedure `asGetSoCt` để lấy chứng từ bán hàng:

```php
use Diepxuan\Simba\StoredProcedures\AsGetSoCt;

$sochungtus = AsGetSoCt::call([
    'pMa_Cty' => '01',
    'pNgay_Ct' => '2024-01-01',
]);
```

### 2. Sử dụng `ProcedureCaller`

Có thể sử dụng lớp `ProcedureCaller` để gọi bất kỳ procedure nào khi tên procedure được biết.

```php
use Diepxuan\Simba\StoredProcedures\ProcedureCaller;

$result = ProcedureCaller::call('asGetSoCt', [
    'pMa_Cty' => '01',
    'pNgay_Ct' => '2024-01-01',
]);
```

## Thông tin chi tiết cho từng Procedure

- **Tên lớp PHP**: Tương ứng với tên stored procedure, ví dụ `AsGLRptNKC06`.
- **Tham số**: Mỗi lớp `call()` method nhận một mảng associative chứa các tham số đầu vào. Tên tham số trong PHP khớp với tên tham số SQL (thường bắt đầu bằng `p`).
- **Giá trị trả về**: Thường là `Illuminate\Support\Collection` chứa các bản ghi hoặc một giá trị đơn lẻ.
- **Tài liệu chi tiết**: Để biết danh sách đầy đủ các procedure, tham số, kiểu dữ liệu và mô tả chi tiết, vui lòng tham khảo các file trong thư mục `diepxuan/laravel-simba/docs/` (ví dụ: `procedures-gl.md`, `procedures-ap.md`, `procedures-in.md`, v.v.).

## Lưu ý quan trọng

- **Kết nối Database**: Các procedure được gọi thông qua connection được cấu hình trong `.env` (`SIMBA_CONNECTION`).
- **Xử lý lỗi**: Các lỗi khi gọi stored procedure (ví dụ: sai tham số, lỗi SQL) sẽ được throw dưới dạng Exception.
- **Encoding**: Vấn đề về ký tự tiếng Việt (charset) đã được xử lý thông qua package `php-charset` và các lớp con.
- **Không sửa đổi trực tiếp Stored Procedures gốc**: Mọi thay đổi về logic nghiệp vụ nên được thực hiện thông qua các lớp PHP hoặc các stored procedures mới nếu cần thiết.

## Tài liệu liên quan

- [OVERVIEW.md](./OVERVIEW.md) - Tổng quan dự án và mối quan hệ Portal - SimbaSql.
- [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md) - Cấu trúc database SimbaSql.
- [ELOQUENT_MODELS.md](./ELOQUENT_MODELS.md) - Tài liệu Eloquent models.
- [INTEGRATION_GUIDE.md](./INTEGRATION_GUIDE.md) - Hướng dẫn tích hợp.
- [AI_AGENT_REFERENCE.md](./AI_AGENT_REFERENCE.md) - Tài liệu tham khảo cho AI Agent.

---
*Tài liệu được cập nhật lần cuối: 2026-02-13*