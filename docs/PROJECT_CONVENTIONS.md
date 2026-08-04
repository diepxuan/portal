# Portal Project Conventions

Tài liệu quy ước dự án bắt buộc để các session sau không lặp lại lỗi kiến trúc/domain.

## 1. Field `ksd`

- `ksd = 1` nghĩa là **không sử dụng / khóa sử dụng** (disabled).
- `ksd = 0` nghĩa là **đang sử dụng** (active).
- Lọc dữ liệu active dùng `ksd = 0`; `ksd = 1` là loại trừ.
- Checkbox `KSD` checked = khóa sử dụng.
- Không hiểu `ksd = 1` là active, không hỏi lại.

## 2. Canonical ARDMKH / Dictionary

- Component danh mục dictionary chính đặt theo `{Module}\Dict\{Slug}`.
- View đặt theo `{module}/dict/{slug}.blade.php`.
- Route name theo `{module}.dict.{slug}`.
- Không dùng tên nghiệp vụ cũ cho route dictionary: `Banhang\Khachhang` đã được thay bằng `So\Dict\Ardmkh`; `Cash\Danhmuc\Nhanvien*` đã được thay bằng `Ca\Dict\Ardmkh*` (2026-08-03).

### Ví dụ đúng

| Module | Component | Blade view | Route |
|--------|-----------|------------|-------|
| SO - Khách hàng | `So\Dict\Ardmkh` | `so/dict/ardmkh.blade.php` | `so.dict.ardmkh` |
| PO - Nhà cung cấp | `Po\Dict\Ardmkh` | `po/dict/ardmkh.blade.php` | `po.dict.ardmkh` |
| SO - Form | `So\Dict\ArdmkhForm` | `so/dict/ardmkh-form.blade.php` | `so.dict.ardmkh.create/edit` |
| CA - Nhân viên | `Ca\Dict\Ardmkh` | `ca/dict/ardmkh.blade.php` | `ca.dict.ardmkh` |
| CA - Form | `Ca\Dict\ArdmkhForm` | `ca/dict/ardmkh-form.blade.php` | `ca.dict.ardmkh.create/edit` |

- Hành động xóa danh mục ARDMKH dùng method `deleteDoiTuong`, không dùng `deleteKhachHang`.

## 3. ARDMKH Save: default không được `NULL`

Theo `simba-docs/tables/ArDmKh.md`, hầu hết cột `NOT NULL` có default:

- String: `''`
- Decimal: `0`
- Bit: `0` / `1`

Khi gọi `asARInsDMKH` / `asARUpdDMKH`, payload phải convert null thành default:

```php
protected function stringValue(?string $value): string
{
    return (string) ($value ?? '');
}

protected function numberValue(mixed $value): float
{
    return null === $value || '' === $value ? 0.0 : (float) $value;
}
```

Các wrapper `AsARInsDMKH` / `AsARUpdDMKH` phải khai báo output `pRet`:

```php
'pRet' => ['type' => 'INT', 'output' => true],
```

## 4. Header / SimbaPage

- `SimbaPage` là nơi duy nhất render `x-head-title` và `x-slot name="header"` cho màn hình `/simba/*`.
- Các Livewire component con trong `SimbaPage` **không được lặp lại** `x-head-title` / `x-slot name="header"`.
- View danh sách đặt nút `Create` trong toolbar nội dung, không đưa vào header slot.
- Danh sách ARDMKH không dùng pagination; load toàn bộ rows một lần và dùng client-side JS filter (Alpine).
- View form đặt link `Quay lại` trong toolbar nội dung; tiêu đề thêm/sửa hiển thị trong nội dung nếu cần.
- Đã áp dụng cho ARDMKH SO/PO/CA:
  - `so/dict/ardmkh*.blade.php`
  - `po/dict/ardmkh*.blade.php`
  - `ca/dict/ardmkh*.blade.php`

## Liên quan

- `docs/README.md` — documentation index
- `docs/SIMBA-DOCS.md` — hướng dẫn simba-docs
- `docs/DESIGN.md` — design tokens UI
- `docs/DEVELOPMENT.md` — setup dev
