# Database Schema - SimbaSql

## Tổng quan

SimbaSql là cơ sở dữ liệu của hệ thống ERP Simba, được phát triển bởi Asia Software Development JSC. Database này hỗ trợ đầy đủ các phân hệ nghiệp vụ của doanh nghiệp với hơn 200 bảng, 500+ stored procedures, và các đối tượng database khác.

## Cấu trúc thư mục

```
SimbaSql/
├── dbo/
│   ├── Tables/              # 200+ bảng dữ liệu
│   ├── StoredProcedures/    # 500+ stored procedures
│   ├── Views/               # Các view hệ thống
│   ├── Functions/           # Các hàm tính toán
│   └── UserDefinedTypes/    # Kiểu dữ liệu người dùng
├── Security/                # Script security
└── Documentation/           # Tài liệu
```

## Quy ước đặt tên

### Tiền tố bảng theo phân hệ

| Tiền tố | Phân hệ | Mô tả |
|---------|---------|-------|
| **Ap** | Accounts Payable | Phải trả nhà cung cấp |
| **Ar** | Accounts Receivable | Phải thu khách hàng |
| **Gl** | General Ledger | Kế toán tổng hợp |
| **Si** | System Information | Hệ thống tham số |
| **Po** | Purchase Order | Đơn mua hàng |
| **Sa** | Sales | Bán hàng |
| **In** | Inventory | Kho |
| **Co** | Manufacturing | Sản xuất |
| **Ca** | Fixed Assets | Tài sản cố định |
| **Bn** | Bank | Ngân hàng |
| **Hr** | Human Resources | Nhân sự |
| **z_** | Temporary | Bảng tạm/sao lưu |

### Hậu tố bảng theo loại

| Hậu tố | Loại | Mô tả |
|--------|------|-------|
| **Ct**, **Ct1**, **Ct2** | Chi tiết | Bảng chi tiết chứng từ |
| **Ph**, **Ph1**, **Ph2** | Tổng hợp | Bảng header chứng từ |
| **Tt** | Thanh toán | Bảng thanh toán |
| **Dm** | Danh mục | Master data |
| **Cd** | Số dư | Opening balance |
| **Gs** | Ghi sổ | Posted transactions |

### Tiền tố stored procedures

| Tiền tố | Loại | Ví dụ |
|---------|------|-------|
| **as** | Asia Software | `asAPGetTT`, `asGLGetCT` |
| **sp** | Stored Procedure | `spGetUserInfo` |
| **z** | Temporary/Backup | `zBackupData` |
| **af** | Aggregate Function | `afDuCuoiTk` |
| **av** | View | `avDependencies` |

## Các bảng chính theo phân hệ

### 1. Kế toán tổng hợp (General Ledger)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **GlCt** | Chi tiết chứng từ kế toán | `ma_cty`, `stt_rec`, `stt_rec0` |
| **GlCt1** | Chi tiết chứng từ (phân bổ) | `ma_cty`, `stt_rec`, `stt_rec0` |
| **GlCtGs** | Chứng từ đã ghi sổ | `ma_cty`, `stt_rec` |
| **GlCdTk** | Số dư đầu kỳ tài khoản | `ma_cty`, `tk`, `ma_nt` |
| **GlDmTk** | Danh mục tài khoản | `ma_cty`, `tk` |
| **GlDmMa** | Danh mục mã phân tích | `ma_cty`, `ma` |

**Cột quan trọng trong GlCt:**
- `tk`: Tài khoản nợ
- `tk_du`: Tài khoản có  
- `ps_no`: Phát sinh nợ
- `ps_co`: Phát sinh có
- `ma_kh`: Mã khách hàng/NCC
- `ma_bp`: Mã bộ phận
- `ma_hd`: Mã hợp đồng
- `ma_spct`: Mã sản phẩm công đoạn

### 2. Phải thu (Accounts Receivable)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **ArTt** | Thanh toán phải thu | `ma_cty`, `stt_rec` |
| **ArCt1**, **ArCt3**, **ArCt4** | Chi tiết chứng từ phải thu | `ma_cty`, `stt_rec`, `stt_rec0` |
| **ArPh1**, **ArPh3**, **ArPh4** | Tổng hợp chứng từ phải thu | `ma_cty`, `stt_rec` |
| **ArDmKh** | Danh mục khách hàng | `ma_cty`, `ma_kh` |
| **ArDmNhKh** | Danh mục nhóm khách hàng | `ma_cty`, `ma_nh_kh` |
| **ArDmPlKh** | Danh mục phân loại khách hàng | `ma_cty`, `ma_pl_kh` |

**Cột quan trọng trong ArDmKh:**
- `isKh`: Là khách hàng
- `isNcc`: Là nhà cung cấp  
- `isNv`: Là nhân viên
- `ten_kh`: Tên khách hàng
- `dia_chi`: Địa chỉ
- `tel`: Điện thoại

### 3. Phải trả (Accounts Payable)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **ApTt** | Thanh toán phải trả | `ma_cty`, `stt_rec` |
| **ApCt1**, **ApCt3**, **ApCt4** | Chi tiết chứng từ phải trả | `ma_cty`, `stt_rec`, `stt_rec0` |
| **ApPh1**, **ApPh3**, **ApPh4** | Tổng hợp chứng từ phải trả | `ma_cty`, `stt_rec` |
| **ApDmNcc** | Danh mục nhà cung cấp | `ma_cty`, `ma_ncc` |

### 4. Kho (Inventory)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **InDmVt** | Danh mục vật tư | `ma_cty`, `ma_vt` |
| **InDmLo** | Danh mục lô hàng | `ma_cty`, `ma_lo` |
| **InDmKho** | Danh mục kho | `ma_cty`, `ma_kho` |
| **InDmNhVt** | Danh mục nhóm vật tư | `ma_cty`, `ma_nh_vt` |
| **InCt**, **InCt1** | Chứng từ kho | `ma_cty`, `stt_rec`, `stt_rec0` |
| **InPh**, **InPh1** | Tổng hợp chứng từ kho | `ma_cty`, `stt_rec` |

### 5. Hệ thống (System)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **SiSetup** | Thiết lập hệ thống | `ma_cty` |
| **SiDmProduct** | Danh mục sản phẩm | `ma_cty`, `ma_product` |
| **SiDmBp** | Danh mục bộ phận | `ma_cty`, `ma_bp` |
| **SiDmHd** | Danh mục hợp đồng | `ma_cty`, `ma_hd` |
| **SiDmPhi** | Danh mục phí | `ma_cty`, `ma_phi` |
| **SysCompany** | Thông tin công ty | `ma_cty` |
| **SysUserInfo** | Thông tin người dùng | `user_id` |
| **SysLanguage** | Ngôn ngữ hệ thống | `lang_id` |

### 6. Nhân sự (Human Resources)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **HrDmKQDanhGia** | Danh mục kết quả đánh giá | `ma_cty`, `ma_kq_dg` |
| **HrDmTCDanhGiaCT** | Danh mục tiêu chí đánh giá | `ma_cty`, `ma_tc_dg` |
| **HrQTHopDongLD** | Hợp đồng lao động | `ma_cty`, `id` |
| **HrQTLuong** | Quản trị lương | `ma_cty`, `id` |
| **HrHsNsTab** | Hồ sơ nhân sự | `ma_cty`, `ma_nv` |

### 7. Sản xuất (Manufacturing)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **CoDmSpct** | Danh mục sản phẩm công đoạn | `ma_cty`, `ma_spct` |
| **CoDmBomCt**, **CoDmBomPh** | Danh mục BOM | `ma_cty`, `stt_rec` |
| **CoDmPb** | Danh mục phế phẩm | `ma_cty`, `ma_pb` |
| **CoCt**, **CoCt1** | Chứng từ sản xuất | `ma_cty`, `stt_rec`, `stt_rec0` |

### 8. Tài sản cố định (Fixed Assets)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **CaCt1**, **CaCt2**, **CaCt3** | Chứng từ tài sản | `ma_cty`, `stt_rec`, `stt_rec0` |
| **CaDmKu** | Danh mục công trình | `ma_cty`, `ma_ku` |
| **CaDmTscd** | Danh mục tài sản | `ma_cty`, `ma_ts` |

### 9. Ngân hàng (Bank)

| Bảng | Mô tả | Khóa chính |
|------|-------|------------|
| **BnCt**, **BnCt1** | Chứng từ ngân hàng | `ma_cty`, `stt_rec`, `stt_rec0` |
| **BnPh** | Tổng hợp chứng từ ngân hàng | `ma_cty`, `stt_rec` |
| **BnDmTkNH** | Danh mục tài khoản ngân hàng | `ma_cty`, `ma_tk_nh` |

## Cấu trúc cột chung

### Cột audit
| Cột | Kiểu dữ liệu | Mô tả |
|-----|--------------|-------|
| `cdate` | `SMALLDATETIME` | Ngày tạo |
| `cuser` | `NVARCHAR(20)` | Người tạo |
| `ldate` | `SMALLDATETIME` | Ngày sửa |
| `luser` | `NVARCHAR(20)` | Người sửa |

### Cột khóa chính
| Cột | Kiểu dữ liệu | Mô tả |
|-----|--------------|-------|
| `ma_cty` | `NVARCHAR(5)` | Mã công ty |
| `stt_rec` | `NVARCHAR(20)` | Số thứ tự record |
| `stt_rec0` | `NVARCHAR(10)` | Số thứ tự dòng |

### Cột chứng từ
| Cột | Kiểu dữ liệu | Mô tả |
|-----|--------------|-------|
| `ma_ct` | `NVARCHAR(5)` | Mã chứng từ |
| `ngay_ct` | `SMALLDATETIME` | Ngày chứng từ |
| `so_ct` | `NVARCHAR(20)` | Số chứng từ |
| `dien_giai` | `NVARCHAR(250)` | Diễn giải |

### Cột tiền tệ
| Cột | Kiểu dữ liệu | Mô tả |
|-----|--------------|-------|
| `ma_nt` | `NVARCHAR(3)` | Mã ngoại tệ |
| `ty_gia` | `DECIMAL(19,4)` | Tỷ giá |
| `t_tien_nt` | `DECIMAL(19,4)` | Tiền ngoại tệ |
| `t_tien` | `DECIMAL(19,4)` | Tiền quy đổi |

## Quan hệ giữa các bảng

### Quan hệ chứng từ
```
ArPh1 (Header) → ArCt1 (Detail)
     ↓
ArTt (Payment)
```

### Quan hệ danh mục
```
ArDmNhKh (Group) → ArDmKh (Customer)
     ↓
ArPh1 (Document)
```

### Quan hệ kế toán
```
GlCt (Journal Entry) → GlCdTk (Opening Balance)
     ↓
GlDmTk (Account)
```

## Views hệ thống

| View | Mô tả | Công dụng |
|------|-------|-----------|
| **avDependencies** | Liệt kê dependencies giữa các đối tượng | Phân tích impact khi thay đổi |
| **avIndex** | Thông tin index của các bảng | Tối ưu hiệu suất |
| **avIndexStatus** | Trạng thái index | Bảo trì database |
| **concat_TEST** | View test nối chuỗi | Testing purposes |

## Functions

| Function | Mô tả | Parameters |
|----------|-------|------------|
| **afDuCuoiTk** | Tính số dư cuối kỳ tài khoản | `@pMa_cty`, `@pTk`, `@pNgay` |
| **afDuDauTk** | Tính số dư đầu kỳ tài khoản | `@pMa_cty`, `@pTk`, `@pNgay` |
| **afTinhGiaXuat** | Tính giá xuất kho | `@pMa_cty`, `@pMa_vt`, `@pNgay` |

## Migration từ SimbaSql sang Portal

### Eloquent Models
- **440+ models** đã được tạo trong `laravel-simba/src/SModel/`
- Mỗi model tương ứng với một bảng trong SimbaSql
- Hỗ trợ khóa chính composite qua trait `HasCompositePrimaryKey`

### Stored Procedure Classes
- **376+ classes** đã được tạo trong `laravel-simba/src/StoredProcedures/`
- Mỗi class cung cấp method `call()` để gọi stored procedure
- Parameters mapping tự động

### Database Connection
```php
// Cấu hình trong .env
SIMBA_CONNECTION=sqlsrv
DB_CONNECTION_SIMBA=sqlsrv
```

## Best Practices

### 1. Sử dụng stored procedures
- Ưu tiên gọi stored procedures thay vì raw queries
- Đảm bảo business logic consistency
- Tận dụng optimization trên database server

### 2. Transaction management
- Sử dụng transactions cho các thao tác liên quan
- Rollback tự động khi có lỗi
- Đảm bảo data integrity

### 3. Index optimization
- Sử dụng các index có sẵn
- Tránh full table scans
- Monitor query performance

### 4. Data validation
- Validate data ở application level
- Sử dụng constraints ở database level
- Kiểm tra business rules trước khi lưu

## Tài liệu tham khảo

- [SimbaSql Documentation](../SimbaSql/DOCUMENTATION.md) - Tài liệu chi tiết về SimbaSql
- [STORED_PROCEDURES.md](./STORED_PROCEDURES.md) - Danh sách stored procedures
- [ELOQUENT_MODELS.md](./ELOQUENT_MODELS.md) - Danh sách Eloquent models
- [INTEGRATION_GUIDE.md](./INTEGRATION_GUIDE.md) - Hướng dẫn tích hợp

---
*Tài liệu được cập nhật lần cuối: 2026-02-13*