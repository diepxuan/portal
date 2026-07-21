# Task 361: SMFFY — Khóa số liệu cuối năm

## Nhóm: SI (System Integration) — Infrastructure

## Mục tiêu

Chuyển đổi module **Thiết lập ngày đầu năm tài chính (SMFFY)** từ Simba .NET `SMFFY.dll` sang Portal Livewire, route `/simba/si/vch/smffy`.

## Trạng thái

- **Status:** ❌ PENDING — chưa implement
- **Route đề xuất:** `/simba/si/vch/smffy` (route name: `si.vch.smffy`)
- **Component đề xuất:** `Diepxuan\Catalog\Http\Livewire\Si\Vch\Smffy`
- **View đề xuất:** `diepxuan/laravel-catalog/resources/views/si/vch/smffy.blade.php`
- **DLL:** `SMFFY.dll`

## DLL Reference

| Thuộc tính | Giá trị |
|------------|---------|
| Assembly | `SMFFY.dll` |
| Form | `frmSMFFY` (base `frmCalc`) |
| Namespace | `AsiaERP.UserInterface`, `AsiaERP.DataAccess` |
| UI Size | 370 x 139 (FixedDialog) |

### Form controls

| Control | Type | Mô tả |
|---------|------|-------|
| `txtNgay_dntc` | AsMaskedTextBox (Mask: `##/##`) | Ngày đầu năm tài chính (dd/MM) |
| `cmdOK` | Button | Xác nhận lưu |
| `cmdCancel` | Button | Hủy (inherited from frmCalc) |

### SP chi tiết

| SP | Params | Mục đích |
|----|--------|----------|
| `asSiUpd_Ngay_dntc` | `[CompanyID, ngay_ks]` | **SP thực tế** form gọi — cập nhật ngày đầu năm TC |
| `asSiUpdFirstFinancialYear` | `@pNgay1`, `@pRet` | SP trong DAO (dead code — không dùng) |

**Lưu ý:** Form gọi trực tiếp `Commons.ExecuteStoredProcedure("asSiUpd_Ngay_dntc", ...)` — KHÔNG dùng DAO pattern (khác với SMKS).

## Yêu cầu

1. Tạo route `/simba/si/vch/smffy` trong `_simba-source` group
2. Tạo Livewire component `Si\Vch\Smffy`:
   - Input mask: `##/##` (dd/MM)
   - Load current `Ngay_DnTc` từ cấu hình hệ thống
   - Gọi SP `asSiUpd_Ngay_dntc` với CompanyID + ngay_ks
   - Hiển thị success/error message
3. Tạo SP wrapper `AsSiUpd_Ngay_dntc` trong laravel-simba

## Kế thừa code mẫu

Dựa trên `Si\Vch\Smks` đã hoàn thành (task 360):
- Component structure tương tự (form đơn giản 1 input)
- Chỉ khác SP và mask format

## Audit Status

- **2026-07-20:** Tạo task từ 181-196. DLL spec đã có từ simba-docs.
