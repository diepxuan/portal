# Task 364: Year — Chọn năm làm việc

> **Gộp từ task 218 (SI-Thay-Doi-Nam-Tai-Chinh) vào task 364 (2026-08-08).**
> Cùng menuid `90.30.02`, cùng DLL `SiChangeFY.dll`, cùng form `frmSiChangeFY`,
> cùng side effect (chỉ set biến runtime, không ghi DB). Task 218 trùng 100% với
> task 364 — xem mục `Bằng chứng merge` ở dưới.

## Nhóm: SI (System Integration) — Infrastructure

## Mục tiêu

Chuyển route **Chọn năm làm việc** từ `/hethong/year` sang `/simba/si/vch/year`.
Component chỉ cập nhật `session('year')` qua `CatalogService::year()`, không
ghi SQL Server.

## Trạng thái

- **Status:** 🔄 IMPLEMENTING — route `si.vch.year` đã đăng ký, đang hoàn thiện header chọn năm.
- **Menu Simba:** `90.30.02` (theo `simba-docs/data/sysMenu.md:634`).
- **DLL:** `SiChangeFY.dll` (namespace `AsiaErp.UserInterface`, form `frmSiChangeFY`).
- **Route hiện tại:** `/hethong/year` (route name: `system.year`).
- **Route đích:** `/simba/si/vch/year` (route name: `si.vch.year`).
- **Component hiện tại:** `Diepxuan\Catalog\Http\Livewire\System\YearSelector`.
- **Component đích:** `Diepxuan\Catalog\Http\Livewire\Si\Vch\YearSelector`.

## Yêu cầu

1. Tạo route `/simba/si/vch/year` trong `_simba-source` group (đăng ký dạng
   concrete entry, không dùng `SimbaPage` shell — xem pattern `si.vch.smks` ở
   `diepxuan/laravel-catalog/routes/web.php:274`).
2. Move component từ `System\YearSelector` → `Si\Vch\YearSelector`.
3. Sửa range năm trong component khớp DLL gốc: `now()->year - 10` → `now()->year + 10`
   (hiện tại `range(now()->year + 1, 2006)` chỉ đúng cho năm hiện tại ≥ 2006 và
   bị cố định cận dưới ở 2006 — bug khi user mở sau năm 2006 vẫn OK, nhưng KHÔNG
   khớp với `frmSiChangeFY`).
4. Giữ session key là `session('year')` (đúng với `CatalogService::year()` ở
   `diepxuan/laravel-catalog/src/Services/CatalogService.php:178` và
   `CatalogFunctions::afNamTC()` ở `:82`). Bỏ key `session('financial_year')` ở
   spec cũ task 218 — không khớp với codebase.
5. Giữ alias redirect `system.year` → `si.vch.year` (back-compat, tránh gãy
   bookmark / link cũ).
6. Cập nhật `docs/project/simba-router-menu-matrix.md` mục `Chon nam lam viec`
   (90.30.02) → `si.vch.year`.
7. Thêm `InputYearWorked` vào header `layouts/app.blade.php` để chọn năm làm
   việc trực tiếp trên mọi màn hình, thay thế `<x-sys-year />` display-only.
8. Thêm override metadata cho menu utility `90.30.02` để Simba menu trỏ về
   `si.vch.year` và hiển thị nhãn `Tien ich`.

## Bằng chứng merge (218 ≡ 364)

### `simba-docs/data/sysMenu.md:634`

```
| 90.30.02 | ... | SI | Chọn năm làm việc | Chọn năm làm việc | SiChangeFY | ASIAERP.USERINTERFACE.frmSiChangeFY | CHGFY | ... | SiChangeFY.png |
```

Chỉ có 1 menu cho "Chọn năm làm việc" — không có entry thứ 2 cho "Thay đổi năm tài chính".

### DLL gốc `frmSiChangeFY.cs` (khởi tạo năm)

```csharp
int year = DateAndTime.Now.Year;
int num  = year - 10;
int num2 = year + 10;
// loop num -> num2, add to cboFinanceYear.Items
((ComboBox)cboFinanceYear).SelectedItem = SystemInformations.FinancialYear;
```

### DLL gốc `frmSiChangeFY.cs` (cmdOK)

```csharp
private void cmdOK_Click(object sender, EventArgs e) {
    intFinanceYear = int.Parse(...);
    SystemInformations.FinancialYear = intFinanceYear;
    ((Form)this).Close();
}
```

→ Side effect duy nhất: set biến runtime `SystemInformations.FinancialYear`. Không
có SP, không ghi DB. Implementation PHP hiện tại (`System\YearSelector::selectYear`)
đã đúng phần này.

### Bảng đối chiếu spec

| | Task 218 | Task 364 |
|---|---|---|
| DLL | `SiChangeFY.dll` | `SiChangeFY.dll` |
| menuid | không ghi (nhưng gián tiếp qua DLL = 90.30.02) | 90.30.02 |
| Side effect | set `session('financial_year')` | set `session('year')` (qua `CatalogService`) |
| Range | `now - 10 → now + 10` | chưa ghi rõ |
| Component đề xuất | `SI\Thaydoinamtaichinh` (chưa có) | `System\YearSelector` (đã có) |

Cả 2 spec mô tả cùng form, cùng menu, cùng side effect — chỉ khác nhau tên gọi
("thay đổi năm tài chính" vs "chọn năm làm việc") và 1 chỗ không nhất quán ở
session key. Task 218 không có implementation; task 364 đã có shell `system.year`
chạy được. Gộp về 364, xóa 218.

## Implementation checklist

- [x] Đọc simba-docs (`SiChangeFY.dll`, `sysMenu.md`).
- [x] Verify menuid 90.30.02 chỉ có 1 entry trong sysMenu.
- [x] Tạo branch `task/364-merge-218-year-selector`.
- [x] Tạo component `Si\Vch\YearSelector` (move từ `System\YearSelector`, sửa range năm theo DLL).
- [x] Sửa view `catalog::si.vch.year-selector` (move từ `system.year-selector`).
- [x] Đăng ký route concrete `si/vch/year` trong `_simba-source` group.
- [x] Giữ alias redirect `hethong/year` → `si/vch/year` (back-compat).
- [x] Cập nhật `docs/project/simba-router-menu-matrix.md`.
- [x] Xóa file `docs/tasks/218-si-thay-doi-nam-tai-chinh.md` (gộp vào đây).
- [x] Cập nhật `docs/tasks/_index.md` (bỏ entry 218).
- [x] Thêm `InputYearWorked` header + override metadata utility.
- [x] `php -l` các file PHP mới.
- [x] `php artisan route:list --name=si.vch.year` verify route.
- [ ] Commit + push + mở PR.

## Độ phức tạp

**Rất thấp.** Component nhỏ, chỉ đọc năm từ `CatalogService::year()` và cập nhật
`session('year')`. Side effect đã đúng, chỉ cần move file + sửa range + đăng ký route.

## Audit Status

- **2026-07-20:** Tách từ task 181-196.
- **2026-08-08:** Merge với task 218 (cùng menuid/DLL). Cập nhật range năm khớp
  DLL. Chuẩn hóa session key = `session('year')` theo `CatalogService` (nguồn
  sự thật codebase). Thêm header input chọn năm và metadata utility.
