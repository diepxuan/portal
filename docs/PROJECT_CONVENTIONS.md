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

## 5. Input autocomplete khách hàng / đối tượng

- `input-khachhang` là lookup dùng chung cho khách hàng, nhà cung cấp và nhân viên theo `mode`.
- Search luôn chuẩn hóa trước khi so khớp: bỏ dấu NFD, quy `đ/Đ` về `d`, lowercase, gộp khoảng trắng.
- Ngoài tên đầy đủ, cần tạo thêm chuỗi viết tắt từ chữ cái đầu mỗi từ để hỗ trợ tìm nhanh, ví dụ `tdh` khớp `Thủy Đông Hà`.
- Thứ tự kết quả ưu tiên: mã chính xác → tên chính xác → viết tắt prefix → tên prefix → contains.
- `commitSearch()` chỉ tự chọn khi có một kết quả rõ ràng; nhiều kết quả thì giữ dropdown để người dùng chọn.

## 6. Danh sách chứng từ và bảng phụ chi tiết

- Danh sách voucher SO3/PO3 không đặt nút `Sửa` trực tiếp trong bảng chính và không có cột `Chi tiết`.
- Click dòng chứng từ sẽ mở bảng phụ `Chi tiết phiếu #N` bên dưới; click lại dòng đang mở sẽ đóng, click dòng khác sẽ chuyển selection.
- Bảng phụ hiển thị chi tiết vật tư lấy từ CT result set của SP filter, không gọi SP load edit riêng.
- Nút `Sửa` / `Xóa` đặt bên phải header bảng phụ; action xóa dùng `wire:confirm` và SP delete gốc.
- `Xuất Excel` đặt ở footer bảng chính, không đặt trong tab lọc.

## 7. Bảng kê gộp nhiều loại chứng từ — cột `Loại phiếu`

- Báo cáo bảng kê gộp nhiều loại chứng từ (vd `SORptBK01` gộp SO1–SO5; menu `06.20.53`/`06.20.56` là các mẫu in riêng cho SO4/SO5 nhưng cùng form) **bắt buộc hiển thị cột `Loại phiếu`** trong bảng phiếu để phân biệt từng loại.
- Giá trị cột lấy `ma_ct` từ PH result set của SP, map sang `ten_ct` từ danh mục `asSIGetDmSo_ct` (đã load sẵn cho dropdown lọc); fallback hiển thị chính `ma_ct` nếu chưa có trong danh mục.
- Cột đặt đầu bảng phiếu, class `text-left whitespace-nowrap`; khi export CSV cũng phải kèm cột `Loại phiếu`.
- Ví dụ đã áp dụng: `So\Rpt\Sorptbk01` (`phieuColumns()` + `phieuCellValue()` + `csvRows()`, helper `voucherTypeName()`).

### Bảng hiển thị đầy đủ cột của SP (auto-generate như SimbaERP)

- Báo cáo master-detail (vd `SORptBK01`) phải hiển thị **mọi cột** mà SP trả về, không chỉ subset cố định — giống DataGridView của SimbaERP (`ReportGridviewBrowseDynamic` tự sinh cột từ DataTable của result set).
- Cách làm: khai báo các cột quen thuộc (nhãn tiếng Việt, canh lề, xử lý VND/NT) trước, sau đó `appendDynamicColumns()` tự bổ sung các cột còn lại của từng dòng với nhãn từ `extraColumnLabel()` và class từ `extraColumnClass()`.
- Bỏ qua cột liên kết nội bộ `stt_rec`; bỏ qua biến thể tiền tệ không được chọn (`isCurrencyVariantToSkip()` theo `pMa_nt`) để không trùng cột tiền chính.
- Tên cột chuẩn của PH/CT `asSORptBK01` lấy từ SQL definition trên SQL Server (không lấy từ bảng voucher `SO3` vì khác tên): PH trả về `tien2`/`tien_nt2`, `thue_gtgt`/`thue_gtgt_nt`, `tt`/`tt_nt`; CT trả về `gia2`/`gia_nt2`, `tien2`/`tien_nt2`, `thue_gtgt`/`thue_gtgt_nt`, `tt`/`tt_nt`.
- Cột động chỉ thêm khi có nhãn tiếng Việt trong `extraColumnLabel()`; không hiển thị cột raw chỉ có tên kỹ thuật (vd `ma_cty`, `stt_rec0`, `ma_lo`, `ma_vitri`, `tk_pt`, `tk_thue`, `tk_ck_ds`) vì DataGridView gốc không có header tương ứng.
- Không viết tắt nhãn nghiệp vụ khi có thể đọc rõ: `ck_ds`/`t_ck_ds` hiển thị là `Chiết khấu doanh số`, `tien_ck` hiển thị là `Tiền chiết khấu`, `tk_ck_ds` hiển thị là `TK chiết khấu doanh số`; không dùng `CK ĐS`/`Tiền CK`.
- Định dạng cell động theo loại cột: cột tiền (`isMoneyColumn()`) dùng `moneyCell()` (định dạng số, ô trống hiển thị `—`), cột ngày (`ngay*`) dùng `dateValue()`, còn lại chuỗi thô — qua `dynamicCellValue()`.
- CSV export cũng phải kèm đủ các cột động (đi qua `phieuColumns()`/`chiTietColumns()`), ô tiền trống xuất `''` (dùng cờ `$forExport` của `phieuCellValue()`/`chiTietCellValue()`).

### Phiếu trả lại (SO4) / giá trị âm và ô tiền trống

- SO4 (phiếu nhập hàng bán bị trả lại) lưu số tiền **dương** trong `SoPh4`; dấu âm chỉ áp dụng khi post GL (`asPostSoPh4_glct`). **Phải đánh dấu theo `ma_ct == 'SO4'`**, không dựa vào dấu âm, nếu không phiếu trả hàng không bao giờ có màu; cell âm nói chung vẫn được đánh dấu.
- Màu đánh dấu dùng `text-red-500` (đỏ nhạt, nhẹ nhàng, không gây rối / không xáo trộn design), không đổi nền row (giữ pattern hover/chọn `sky-50`).
- Ô tiền/thuế/thanh toán trống (phiếu không phát sinh tiền, vd SO1 đơn đặt hàng) hiển thị `—` trong UI nhưng CSV export vẫn xuất `''`.
- Ví dụ đã áp dụng: `So\Rpt\Sorptbk01` (`phieuCellClass()` / `chiTietCellClass()` đánh dấu theo `ma_ct == 'SO4'` hoặc giá trị âm; `moneyDisplay()` cho placeholder `—`; `columnKeys()` map tên cột PH/CT; `appendDynamicColumns()` + `dynamicCellValue()` cho cột động của SP).

## Liên quan

- `docs/README.md` — documentation index
- `docs/SIMBA-DOCS.md` — hướng dẫn simba-docs
- `docs/DESIGN.md` — design tokens UI
- `docs/DEVELOPMENT.md` — setup dev
