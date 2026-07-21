# Task 363: Company — Chọn công ty làm việc

## Nhóm: SI (System Integration) — Infrastructure

## Mục tiêu

Chuyển route **Chọn công ty** từ `/hethong/company` sang `/simba/si/vch/company`. Component hiện tại `CompanySelector` chỉ cập nhật session, không ghi SQL Server.

## Trạng thái

- **Status:** 🔄 CẦN MAP — route hiện tại `/hethong/company` qua `CompanySelector` Livewire
- **Route hiện tại:** `/hethong/company` (route name: `system.company`)
- **Route đích:** `/simba/si/vch/company` (route name: `si.vch.company`)
- **Component hiện tại:** `Diepxuan\Catalog\Http\Livewire\System\CompanySelector`
- **Component đích:** giữ nguyên, chỉ đổi namespace lên `Si\Vch\Company`

## Yêu cầu

1. Tạo route `/simba/si/vch/company` trong `_simba-source` group
2. Move component từ `System\CompanySelector` → `Si\Vch\Company`
3. Giữ redirect từ `/hethong/company` → `/simba/si/vch/company`
4. Cập nhật menu mapping trong `simba-router-menu-matrix.md`

## Chức năng hiện tại

- Hiển thị danh sách công ty user được phân quyền
- Chọn công ty → cập nhật session `selected_company`
- KHÔNG ghi SQL Server — chỉ thay đổi context làm việc

## Độ phức tạp

**Thấp.** Component nhỏ, không có SP, chỉ đọc danh sách công ty từ Eloquent.

## Audit Status

- **2026-07-20:** Tách từ task 181-196.
