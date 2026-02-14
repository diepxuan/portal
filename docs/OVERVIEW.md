# Tổng quan về Portal và SimbaSql

## Giới thiệu

**Portal** là một ứng dụng Laravel 11 được module hóa bằng 14 package nội bộ, cung cấp nền tảng quản lý doanh nghiệp tích hợp với hệ thống ERP Simba. **SimbaSql** là cơ sở dữ liệu của hệ thống ERP Simba, chứa toàn bộ cấu trúc bảng, stored procedures và business logic cho các phân hệ kế toán, bán hàng, mua hàng, kho, sản xuất, nhân sự.

## Mối quan hệ giữa Portal và SimbaSql

### Kiến trúc tích hợp

```
┌─────────────────────────────────────────────────────────────┐
│                     Portal (Laravel 11)                     │
│  ┌─────────────────────────────────────────────────────┐  │
│  │               diepxuan/* (14 packages)              │  │
│  │  ┌─────────────────────────────────────────────┐  │  │
│  │  │        laravel-simba (Integration Layer)    │  │  │
│  │  │  • 440+ Eloquent Models (SModel)            │  │  │
│  │  │  • 376+ Stored Procedure Classes            │  │  │
│  │  │  • Database Connection Management           │  │  │
│  │  └─────────────────────────────────────────────┘  │  │
│  └─────────────────────────────────────────────────────┘  │
│                  │                                         │
│                  ▼                                         │
│  ┌─────────────────────────────────────────────────────┐  │
│  │               SimbaSql Database                     │  │
│  │  • 200+ Tables                                      │  │
│  │  • 500+ Stored Procedures                           │  │
│  │  • Views, Functions, Security Objects               │  │
│  └─────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

### Luồng dữ liệu

1. **Portal** sử dụng package **laravel-simba** để kết nối với database SimbaSql
2. **laravel-simba** cung cấp:
   - **SModel**: 440+ Eloquent models tương ứng với các bảng trong SimbaSql
   - **StoredProcedure Classes**: 376+ PHP classes để gọi stored procedures
   - **Connection Management**: Quản lý kết nối database riêng cho Simba
3. **SimbaSql** chứa:
   - Toàn bộ business logic trong stored procedures
   - Cấu trúc database cho ERP system
   - Data validation và transaction handling

### Các package chính liên quan

| Package | Mô tả | Vai trò trong tích hợp |
|---------|-------|------------------------|
| **laravel-simba** | Tích hợp Laravel với Simba | Cung cấp models và stored procedure callers |
| **laravel-eloquent-composite** | Hỗ trợ khóa chính composite | Xử lý khóa chính composite trong Simba tables |
| **php-charset** | Chuyển đổi ký tự tiếng Việt | Xử lý encoding dữ liệu tiếng Việt |
| **laravel-core** | Core package cho hệ thống | Quản lý package và auto-discovery |

## Mục đích tích hợp

### 1. Truy cập dữ liệu ERP
- Đọc/ghi dữ liệu từ các bảng Simba (khách hàng, sản phẩm, chứng từ, v.v.)
- Thực hiện các nghiệp vụ kinh doanh qua stored procedures
- Đồng bộ dữ liệu giữa Portal và Simba ERP

### 2. Tích hợp business logic
- Sử dụng stored procedures đã được kiểm thử và tối ưu
- Đảm bảo tính toàn vẹn dữ liệu và business rules
- Tận dụng logic nghiệp vụ đã có trong Simba

### 3. Mở rộng chức năng
- Xây dựng các tính năng mới trên nền tảng Portal
- Tích hợp với các hệ thống khác (Magento, Gmail, v.v.)
- Cung cấp API và giao diện web hiện đại

## Phạm vi tích hợp hiện tại

### ✅ Đã hoàn thành
- **440+ Eloquent Models**: Đã tạo từ tất cả các bảng trong SimbaSql
- **376+ Stored Procedure Classes**: Đã chuyển đổi từ stored procedures
- **Database Connection**: Cấu hình kết nối SQL Server riêng
- **Composite Key Support**: Hỗ trợ khóa chính composite

### 🔄 Đang phát triển
- **API Integration**: Xây dựng REST API cho các nghiệp vụ
- **Real-time Sync**: Đồng bộ dữ liệu thời gian thực
- **Advanced Features**: Các tính năng nâng cao trên Portal

## Lợi ích của kiến trúc này

### 1. **Tách biệt concerns**
- Portal tập trung vào presentation và business logic mới
- SimbaSql đảm nhiệm data persistence và core business logic
- Dễ dàng bảo trì và nâng cấp từng phần

### 2. **Tái sử dụng code**
- Tận dụng stored procedures đã có
- Sử dụng models cho các thao tác CRUD cơ bản
- Đóng gói logic phức tạp trong stored procedures

### 3. **Hiệu suất**
- Stored procedures được tối ưu trên database server
- Giảm network traffic với batch operations
- Transaction management hiệu quả

### 4. **Bảo mật**
- Kiểm soát truy cập qua stored procedures
- Data validation ở database level
- Audit logging tích hợp sẵn

## Hướng phát triển tương lai

1. **Microservices Architecture**: Tách các module thành microservices độc lập
2. **Event-Driven Design**: Sử dụng message queue cho các tác vụ async
3. **API Gateway**: Cung cấp unified API cho tất cả clients
4. **Real-time Analytics**: Xử lý và phân tích dữ liệu thời gian thực
5. **Machine Learning Integration**: Dự đoán và tối ưu hóa nghiệp vụ

## Tài liệu liên quan

- [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md) - Cấu trúc database SimbaSql
- [STORED_PROCEDURES.md](./STORED_PROCEDURES.md) - Tài liệu stored procedures
- [ELOQUENT_MODELS.md](./ELOQUENT_MODELS.md) - Tài liệu Eloquent models
- [INTEGRATION_GUIDE.md](./INTEGRATION_GUIDE.md) - Hướng dẫn tích hợp
- [AI_AGENT_REFERENCE.md](./AI_AGENT_REFERENCE.md) - Tài liệu tham khảo cho AI Agent

---
*Tài liệu được cập nhật lần cuối: 2026-02-13*