# Task 364: Year — Chọn năm làm việc

## Nhóm: SI (System Integration) — Infrastructure

## Mục tiêu

Chuyển route **Chọn năm làm việc** từ `/hethong/year` sang `/simba/si/vch/year`. Component hiện tại `YearSelector` chỉ cập nhật session, không ghi SQL Server.

## Trạng thái

- **Status:** 🔄 CẦN MAP — route hiện tại `/hethong/year` qua `YearSelector` Livewire
- **Route hiện tại:** `/hethong/year` (route name: `system.year`)
- **Route đích:** `/simba/si/vch/year` (route name: `si.vch.year`)
- **Component hiện tại:** `Diepxuan\Catalog\Http\Livewire\System\YearSelector`
- **Component đích:** Move lên `Si\Vch\Year`

## Yêu cầu

1. Tạo route `/simba/si/vch/year` trong `_simba-source` group
2. Move component từ `System\YearSelector` → `Si\Vch\Year`
3. Giữ redirect từ `/hethong/year` → `/simba/si/vch/year`
4. Cập nhật menu mapping

## Độ phức tạp

**Rất thấp.** Component nhỏ, chỉ đọc năm từ config và cập nhật session.

## Audit Status

- **2026-07-20:** Tách từ task 181-196.
