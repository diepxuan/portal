# Task 430: SIDMBP — Danh mục bộ phận

## Nhóm: SI / PO / GL (dùng chung một DLL, 3 menu)

## Trạng thái

- **Status:** TODO — chưa có component
- **DLL:** `SIDMBP.dll` (không có decompiled — suy từ bảng + SP)
- **Bảng:** `SiDmBp`
- **Routes:** 3 route cùng DLL, khác `menuid`:
  - `so.dict.sidmbp` → menu `06.90.35` (Bộ phận)
  - `po.dict.sidmbp` → menu `10.90.11` (Bộ phận)
  - `gl.dict.sidmbp` → menu `90.10.23` (Danh mục bộ phận)
- **Component dự kiến:** `So\Dict\Sidmbp`, `Po\Dict\Sidmbp`, `Gl\Dict\Sidmbp`
- **View:** `so/dict/sidmbp.blade.php` + 2 view tương ứng

> **Lưu ý:** cùng 1 bảng `SiDmBp` nhưng 3 menu → 3 route riêng.
> Có thể dùng chung 1 base component + 3 subclass mỏng (xem §Cách làm).

---

## Checklist DONE (9 mục — PROJECT_CONVENTIONS §2.7)

| # | Mục | Kết quả |
|---|---|---|
| 1 | Component render thật | ⬜ |
| 2 | Route 200 (cả 3) | ⬜ |
| 3 | Hiển thị đúng 11 dòng | ⬜ |
| 4 | Không `errorMessage` | ⬜ |
| 5 | Bộ chọn kỳ | — **không cần** (danh mục, không theo kỳ) |
| 6 | Label tiếng Việt | ⬜ |
| 7 | Dropdown field có danh mục | ⬜ |
| 8 | Giá trị mặc định | ⬜ |
| 9 | Tham số rỗng = `''` | ⬜ (kiểm theo bảng dưới) |

---

## Cấu trúc bảng `SiDmBp` (8 cột)

Nguồn: `simba-docs/tables/SiDmBp.md`

| # | Cột | Kiểu | Nullable | Default | Ý nghĩa |
|---|---|---|---|---|---|
| 1 | `ma_cty` **PK** | NVARCHAR(3) | NO | `''` | Mã công ty |
| 2 | `ma_bp` **PK** | NVARCHAR(20) | NO | `''` | Mã bộ phận |
| 3 | `ten_bp` | NVARCHAR(50) | NO | `''` | Tên bộ phận |
| 4 | `ksd` | BIT | NO | `0` | Khóa sử dụng |
| 5 | `cdate` | SMALLDATETIME | YES | `''` | Ngày tạo |
| 6 | `cuser` | NVARCHAR(20) | YES | `''` | Người tạo |
| 7 | `ldate` | SMALLDATETIME | YES | `''` | Ngày sửa |
| 8 | `luser` | NVARCHAR(20) | YES | `''` | Người sửa |

**Khoá chính phức hợp:** `(ma_cty, ma_bp)`

---

## Stored Procedures — `INFORMATION_SCHEMA.PARAMETERS`

| SP | Tham số | Ghi chú |
|---|---|---|
| `asSIGetDMBP` | `pMa_cty, pMa_bp, pStruct` (3) | `pMa_bp=''` → lấy tất cả |
| `asSIInsDMBP` | `pMa_cty, pMa_bp, pTen_bp, pKsd, pLUser, pRet` (6) | `pRet` là **OUTPUT** |
| `asSIUpdDMBP` | `pMa_cty, pMa_bp, pTen_bp, pKsd, pLUser, pRet` (6) | `pRet` OUTPUT |
| `asSIDelDMBP` | `pMa_cty, pMa_bp, pRet` (3) | `pRet` OUTPUT |

### Kiểm tra NULL vs `''` — BẮT BUỘC làm khi implement

Chưa test. Phải chạy:

```sql
-- với từng tham số, so sánh số dòng khi NULL vs ''
EXEC asSIGetDMBP @pMa_cty='001', @pMa_bp='', @pStruct='0';
EXEC asSIGetDMBP @pMa_cty='001', @pMa_bp=NULL, @pStruct='0';
```

Field nào `NULL` → 0 dòng thì **phải** dùng `''` (xem §2.7.3).

---

## Dữ liệu thật (cty 001 — 11 dòng)

| ma_bp | ten_bp | ksd |
|---|---|---|
| K1 | k2 kho cua hang | 0 |
| KKCN | khu cn | 0 |
| VINCOM | Showroom Vincom | 0 |
| XE01593 | Xe 01593 | 0 |
| XE03166 | Xe 03166 | 0 |
| XE05605 | Xe 05605 | 0 |

→ **Verify: danh sách phải hiện đúng 11 dòng.**

---

## Cách làm — 3 route cùng 1 bảng

**Đề xuất:** 1 component gốc + 3 subclass mỏng.

```php
// src/Http/Livewire/So/Dict/Sidmbp.php
class Sidmbp extends AbstractDmbp
{
    protected string $moduleSlug = 'so';   // chỉ khác nhau ở đây
}

// src/Http/Livewire/Po/Dict/Sidmbp.php
class Sidmbp extends AbstractDmbp
{
    protected string $moduleSlug = 'po';
}

// src/Http/Livewire/Gl/Dict/Sidmbp.php
class Sidmbp extends AbstractDmbp
{
    protected string $moduleSlug = 'gl';
}
```

Base component chứa toàn bộ logic CRUD + view dùng chung.

---

## Label tiếng Việt

Không có `frmSIDMBP.cs` để tra. Lấy từ:
1. `sysReportResx` nếu có
2. `sysMenu.bar` của từng menu
3. Tên cột trong `SiDmBp.md`

| Cột | Label |
|---|---|
| `ma_bp` | Mã bộ phận |
| `ten_bp` | Tên bộ phận |
| `ksd` | KSD |

---

## Verify browser (khi implement)

| Kiểm chứng | Cách |
|---|---|
| 3 route | `curl -o /dev/null -w "%{http_code}"` |
| Component | `window.Livewire.all()` có `catalog::so.dict.sidmbp`... |
| Số dòng | Phải **11** |
| CRUD | Thêm/sửa/xoá 1 bản ghi test rồi verify DB sạch baseline |
