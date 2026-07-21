# Task 365: Website — Quản lý website

## Nhóm: SI (System Integration) — Infrastructure

## Mục tiêu

Chuyển route **Quản lý website** từ `/hethong/website` sang `/simba/si/vch/website`. Route hiện tại dùng `SystemWebsiteController` (REST resource).

## Trạng thái

- **Status:** 🔄 CẦN MAP — route hiện tại `/hethong/website` qua `SystemWebsiteController`
- **Route hiện tại:** `/hethong/website` (route name: `system.website.*`)
- **Route đích:** `/simba/si/vch/website` (route name: `si.vch.website`)
- **Controller hiện tại:** `Diepxuan\Catalog\Http\Controllers\SystemWebsiteController`
- **Component đề xuất:** `Si\Vch\Website` (Livewire)

## Yêu cầu

1. Tạo route `/simba/si/vch/website` trong `_simba-source` group
2. Chuyển Controller → Livewire component
3. Giữ redirect từ `/hethong/website` → `/simba/si/vch/website`
4. Cập nhật menu mapping

## Độ phức tạp

**Trung bình.** Cần chuyển từ Controller (REST) sang Livewire full-page component.

## Audit Status

- **2026-07-20:** Tách từ task 181-196.
