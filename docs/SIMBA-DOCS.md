# SIMBA-DOCS.md — Hướng dẫn sử dụng SimbaSql Documentation Mount

## 1. Tổng quan

`simba-docs/` là ZFS mount trong workspace, trỏ đến toàn bộ tài liệu của dự án **SimbaSql .NET** — hệ thống ERP gốc mà Portal đang được xây dựng lại.

| Thuộc tính         | Giá trị                              |
| ------------------ | ------------------------------------ |
| **Workspace path** | `simba-docs/`                        |
| **Trạng thái**     | Readonly — không ghi đè              |
| **Repo gốc**       | https://github.com/diepxuan/SimbaSql |

---

## 2. Cấu trúc tổng thể

```
simba-docs/
├── README.md                    # Index chính của toàn bộ docs
├── asia/                        # 10 module ERP
│   ├── {AR,AP,CA,CO,SO,PO,SI,IN,FA,GL}_SUMMARY.md
│   ├── CROSS_MODULE_INTERACTIONS.md
│   ├── SP_INDEX.md
│   ├── TABLES_INDEX.md
│   ├── guides/
│   ├── common/
│   └── {ar,ap,ca,co,so,po,si,in,fa,gl}/   # Chi tiết từng module
├── decompiled/asia/             # 338 DLL đã decompile
├── procedures/                  # Stored Procedures theo module
│   ├── {AR,AP,CA,CO,SO,PO,SI,IN,FA,GL,System}/
│   └── guides/
├── data/                        # System tables documentation
│   ├── sysMenu.md
│   ├── sysVoucherInfo.md
│   ├── sysDictionaryInfo.md
│   └── ...
├── reference/                   # Tài liệu tra cứu
│   ├── ASIA_SIMBA_MAPPING.md
│   ├── QUICK_REFERENCE.md
│   ├── CODE_REFERENCE.md
│   └── FILE_INDEX.md
├── follows/                     # SQL scripts mẫu
└── tasks/                       # Task tracking, analysis
```

---

## 3. 10 Module ERP (thư mục `asia/`)

| Code   | Module              | Summary              | Mô tả                                                        |
| ------ | ------------------- | -------------------- | ------------------------------------------------------------ |
| **AR** | Accounts Receivable | `asia/AR_SUMMARY.md` | Công nợ phải thu, danh mục khách hàng, nhóm KH, phân loại KH |
| **AP** | Accounts Payable    | `asia/AP_SUMMARY.md` | Công nợ phải trả, nhà cung cấp                               |
| **CA** | Cash & Bank         | `asia/CA_SUMMARY.md` | Tiền mặt, tiền gửi ngân hàng, phiếu thu/chi                  |
| **CO** | Costing/Production  | `asia/CO_SUMMARY.md` | Sản xuất, tính giá thành, BOM                                |
| **SO** | Sales Order         | `asia/SO_SUMMARY.md` | Bán hàng, phiếu xuất, đơn hàng                               |
| **PO** | Purchase Order      | `asia/PO_SUMMARY.md` | Mua hàng, phiếu nhập, đơn đặt hàng                           |
| **SI** | System              | `asia/SI_SUMMARY.md` | Hệ thống, login, danh mục chung, phân quyền                  |
| **IN** | Inventory           | `asia/IN_SUMMARY.md` | Quản lý kho, vật tư, danh mục hàng hóa                       |
| **FA** | Fixed Assets        | `asia/FA_SUMMARY.md` | Tài sản cố định, khấu hao, dao cáo TSCĐ                      |
| **GL** | General Ledger      | `asia/GL_SUMMARY.md` | Kế toán tổng hợp, sổ cái, báo cáo tài chính                  |

### Chi tiết mỗi module

Mỗi module trong `asia/{module}/` có cấu trúc:

```
asia/ar/
├── masters/     # Danh mục (customers, groups, classifications)
├── vouchers/    # Chứng từ (phiếu, hóa đơn)
└── reports/     # Báo cáo
```

---

## 4. Decompiled DLL Analysis (`decompiled/asia/`)

**338 DLL** đã được decompile và phân tích. Mỗi DLL có thư mục riêng chứa `README.md` với:

- Danh sách Forms
- Methods chính
- Stored Procedure calls
- Business logic

### Ví dụ DLL quan trọng

| DLL            | Module | Chức năng                     |
| -------------- | ------ | ----------------------------- |
| `ARDMKH.dll`   | AR     | Danh mục khách hàng           |
| `ARDMNHKH.dll` | AR     | Danh mục nhóm khách hàng      |
| `ARDMPLKH.dll` | AR     | Danh mục phân loại khách hàng |
| `ARTT.dll`     | AR     | Thanh toán công nợ            |
| `SOVchSO1.dll` | SO     | Chứng từ bán hàng             |
| `POVchPO1.dll` | PO     | Chứng từ mua hàng             |
| `SiTools.dll`  | SI     | Tiện ích hệ thống             |

### Cách đọc DLL docs

```bash
# Xem thông tin DLL cụ thể
cat simba-docs/decompiled/asia/ARDMKH.dll/README.md

# Tìm DLL theo module
ls simba-docs/decompiled/asia/ | grep "^AR"

# Tìm SP calls trong tất cả DLL
grep -r "SP_" simba-docs/decompiled/asia/*/README.md
```

---

## 5. Stored Procedures (`procedures/`)

### Cấu trúc

```
procedures/
├── AR/     # SP cho module AR
├── AP/     # SP cho module AP
├── CA/     # SP cho module CA
├── CO/     # SP cho module CO
├── SO/     # SP cho module SO
├── PO/     # SP cho module PO
├── SI/     # SP cho module SI
├── IN/     # SP cho module IN
├── FA/     # SP cho module FA
├── GL/     # SP cho module GL
├── System/ # SP hệ thống
├── Dash/   # Dashboard
├── HR/     # Nhân sự
├── SA/     # Sales Admin
├── Ta/     # Tax
└── UTILITIES/
```

### Index SP

- **Toàn bộ:** `asia/SP_INDEX.md`
- **Theo module:** `procedures/{MODULE}/procedures.md`
- **Kiến trúc & naming:** `procedures/guides/CORE.md`

### Ví dụ tìm SP

```bash
# Tìm SP liên quan đến khách hàng
grep -ri "khach hang\|customer\|DMKH" simba-docs/procedures/AR/

# Xem SP GET cho danh mục KH
cat simba-docs/procedures/AR/SP_AR_DMKH_GET.sql 2>/dev/null || \
  grep -l "SP_AR_DMKH" simba-docs/procedures/AR/*
```

---

## 6. System Data (`data/`)

| File                   | Nội dung           | Ứng dụng                       |
| ---------------------- | ------------------ | ------------------------------ |
| `sysMenu.md`           | Hệ thống menu      | Xây dựng navigation Portal     |
| `sysVoucherInfo.md`    | Thông tin chứng từ | Định nghĩa voucher types       |
| `sysDictionaryInfo.md` | Từ điển dữ liệu    | Map field names, data types    |
| `sysReportInfo.md`     | Danh sách báo cáo  | Replicate reports trong Portal |
| `sysSetupModule.md`    | Cấu hình module    | Setup flow                     |
| `SiDmCt.md`            | Danh mục chứng từ  | Master list of vouchers        |

---

## 7. Tài liệu tra cứu (`reference/`)

| File                    | Mục đích                                   |
| ----------------------- | ------------------------------------------ |
| `ASIA_SIMBA_MAPPING.md` | Liên kết giữa Asia App (.NET) và Simba SQL |
| `QUICK_REFERENCE.md`    | Tham khảo nhanh SP theo nghiệp vụ          |
| `CODE_REFERENCE.md`     | Reference code patterns                    |
| `FILE_INDEX.md`         | Index file nhanh                           |

---

## 8. Luồng nghiệp vụ liên module

File `asia/CROSS_MODULE_INTERACTIONS.md` mô tả:

| Flow            | Modules           | Mô tả                                   |
| --------------- | ----------------- | --------------------------------------- |
| Bán hàng        | SO → SI → AR → GL | Đơn hàng → xuất kho → công nợ → kế toán |
| Mua hàng        | PO → IN → AP → GL | Đặt hàng → nhập kho → công nợ → kế toán |
| Thu/Chi tiền    | CA → GL           | Thu chi → ghi sổ kế toán                |
| Tài sản cố định | FA → GL           | Khấu hao → bút toán                     |
| Tính giá thành  | CO → GL           | Giá thành → kế toán                     |

---

## 9. Database Schema

| Object           | Path                                | Count |
| ---------------- | ----------------------------------- | ----- |
| Tables           | `../dbo/Tables/README.md`           | 440   |
| StoredProcedures | `../dbo/StoredProcedures/README.md` | 2,031 |
| Functions        | `../dbo/Functions/README.md`        | 89    |
| Views            | `../dbo/Views/README.md`            | 4     |

**Lưu ý:** `dbo/` nằm trong repo SimbaSql, không phải trong simba-docs mount.
Xem tại: https://github.com/diepxuan/SimbaSql/tree/main/dbo

---

## 10. Workflow khi implement task

Khi nhận task Portal, Bột làm theo thứ tự:

1. **Xác định module** — task thuộc module nào (AR, SO, IN, ...)
2. **Đọc summary** — `asia/{MODULE}_SUMMARY.md` để hiểu tổng quan
3. **Tra DLL** — `decompiled/asia/{DLL}.dll/README.md` để biết logic gốc
4. **Tra SP** — `procedures/{MODULE}/` để biết database calls
5. **Tra cross-module** — `asia/CROSS_MODULE_INTERACTIONS.md` nếu liên quan nhiều module
6. **Tra tables** — `asia/TABLES_INDEX.md` để biết bảng CSDL
7. **Implement** — dựa trên domain knowledge đã thu thập

---

## 11. Quy tắc

- `simba-docs/` là **readonly** — không ghi, sửa, xóa file trong mount
- Đây là **nguồn sự thật** về logic nghiệp vụ Simba ERP
- Luôn đối chiếu với simba-docs trước khi implement logic mới
- Nếu thông tin trong simba-docs không đủ → báo Sếp

---

## 12. Liên kết ngoài

| Resource        | URL                                         |
| --------------- | ------------------------------------------- |
| SimbaSql Repo   | https://github.com/diepxuan/SimbaSql        |
| SimbaSql Issues | https://github.com/diepxuan/SimbaSql/issues |
| SimbaSql PRs    | https://github.com/diepxuan/SimbaSql/pulls  |
| Portal Repo     | https://github.com/diepxuan/portal          |
| Portal Issues   | https://github.com/diepxuan/portal/issues   |
| Portal Project  | https://github.com/orgs/diepxuan/projects/2 |

---

_Last updated: 2026-05-05_
