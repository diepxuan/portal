# Diepxuan Portal Design System

DESIGN.md là nguồn sự thật duy nhất về **nhận dạng trực quan** của Portal. File này giúp AI agents (Claude Code, Cursor, Codex...) và developers tham gia dự án giữ UI/UX nhất quán xuyên suốt 14 core packages trong `diepxuan/`, các Blade view trong `resources/views/`, và cả phần Livewire + Alpine.js.

Phạm vi áp dụng: mọi view mới hoặc sửa đổi trong `diepxuan/*/resources/views/**/*.blade.php` và `resources/views/**/*.blade.php` phải bám token dưới đây. Khi cần thêm token mới — mở task/PR riêng, cập nhật file này + `tailwind.config.js` (nếu cần) và chờ Sếp duyệt trước khi ship.

---

## Overview (Brand & Style)

Portal là ứng dụng nghiệp vụ (Laravel + Livewire + Alpine) phục vụ vận hành kế toán / kho / bán hàng được port từ SimbaERP .NET. Tính cách thiết kế đã được Portal Phase 1 (task 008, 117, 358, 359) định hình:

- **Nghiêm túc, đáng tin cậy** — giao diện dày đặc thông tin, dữ liệu dày đặc, form CRUD chiếm phần lớn trang.
- **Trực quan, dễ quét** — semantic color (success / warning / error), icon đơn giản, table chiếm ưu thế.
- **Tiếng Việt là chính** — copy và label ưu tiên tiếng Việt, RTL/LTR mặc định trái-sang-phải.
- **Tailwind-first** — mọi giá trị dưới đây đều map 1-1 sang Tailwind utility class. Không tự chế CSS thuần trừ khi Sếp duyệt.

Font chính: **Figtree** (đã khai báo trong `tailwind.config.js`, weight 400 / 500 / 600). Font phụ cho dữ liệu kỹ thuật: **JetBrains Mono** — chỉ dùng khi cần hiển thị mã chứng từ, ID dài, JSON log.

---

## Colors

Bảng màu lấy cảm hứng từ Tailwind palette (blue / gray / red / yellow / green / sky / indigo) đã sử dụng thực tế trong toàn bộ codebase. Bám sát thói quen hiện có của Portal, không tạo scale mới.

| Token | Hex | Tailwind class | Vai trò |
|-------|-----|----------------|---------|
| `primary` | `#2563EB` | `blue-600` | Action chính (Thêm, Lưu, Submit), link quan trọng, focus ring. **Chỉ một primary action nổi bật mỗi màn hình.** |
| `primary-hover` | `#1D4ED8` | `blue-700` | Hover / active của primary. |
| `tertiary` | `#0EA5E9` | `sky-500` | Row hover (`hover:bg-sky-50`), nhấn nhẹ, breadcrumb. |
| `neutral` | `#F9FAFB` | `gray-50` | Nền trang mặc định. |
| `surface` | `#FFFFFF` | `white` | Bề mặt card / table / form. |
| `on-surface` | `#1F2937` | `gray-800` | Text chính. |
| `secondary` | `#6B7280` | `gray-500` | Text phụ, metadata, label placeholder. |
| `border` | `#E5E7EB` | `gray-200` | Viền card, input, divider bảng, ring trung tính. |
| `error` | `#DC2626` | `red-600` | Thông báo lỗi, nút Xóa có chủ đích (destructive). Badge lỗi dùng `bg-red-100 text-red-800`. |
| `success` | `#16A34A` | `green-600` | Badge hoàn thành (`bg-green-100 text-green-800`), nút Lưu phụ. Banner success dùng `bg-indigo-500` (xem Banner bên dưới). |
| `warning` | `#CA8A04` | `yellow-600` | Cảnh báo validation. Badge chờ dùng `bg-yellow-100 text-yellow-700` + hover `bg-yellow-200`. |
| `info` | `#4F46E5` | `indigo-600` | Banner success của hệ thống (`<x-banner style="success">` → `bg-indigo-500`). Focus ring trong form (một số component Jetstream). |

> **Badge color rule:** dùng `bg-{color}-100 text-{color}-800` cho badge trạng thái (success/error), `text-{color}-700` cho badge phụ (warning). KHÔNG dùng `text-{color}-600` cho text trên nền nhạt — không đủ contrast.

> **Banner rule:** `success` → `bg-indigo-500`, `danger` → `bg-red-700`, `warning` → `bg-yellow-500`. Quy ước này đã có trong `components/banner.blade.php` — giữ nguyên để tránh phá Jetstream banner mặc định.

---

## Typography

Strategy chỉ dùng **Figtree** với tối đa 2 weight (Regular 400 + Semi-Bold 600) trong cùng một màn hình. JetBrains Mono dùng riêng cho ID / số chứng từ / code snippet.

| Token | Class Tailwind | Dùng cho |
|-------|----------------|----------|
| H1 | `text-3xl font-semibold` (30px / 600) | Tiêu đề dashboard lớn (hiếm). |
| H2 | `text-2xl font-semibold` (24px / 600) | Tiêu đề trang chính, header. |
| H3 | `text-xl font-semibold` (20px / 600) | Tiêu đề card, tiêu đề section trong form. |
| H4 | `text-lg font-semibold` (18px / 600) | Tiêu đề phụ trong page. |
| Body | `text-sm` (14px / 400) | Nội dung chính của form, table cell, helper text. |
| Label | `text-sm font-medium` (14px / 500) | Nhãn input, header table, label button. |
| Caption | `text-xs` (12px / 400) | Ghi chú nhỏ, metadata, badge text. |
| Mono | `font-mono text-xs` | Mã chứng từ, stt_rec, ID dài, JSON log. |

**Quy ước:**
- KHÔNG dùng `font-bold` (700) trên label/button — chỉ dùng `font-semibold` (600) là tối đa.
- KHÔNG set `letter-spacing` âm; Tailwind mặc định đã đủ.
- KHÔNG scale font theo viewport (cấm `text-base sm:text-lg md:text-xl`).

---

## Layout (Layout & Spacing)

Portal theo **Fixed-Max-Width Grid** dựng trên Tailwind spacing scale 4px. Cấm tự đặt giá trị lẻ như `13px`, `5px`, `7px`.

### App layout thực tế (`diepxuan/laravel-catalog/resources/views/layouts/app.blade.php`)

| Vùng | Class Tailwind | Ghi chú |
|------|----------------|---------|
| Page background | `min-h-screen bg-gray-100` | Neutral `#F3F4F6` thực tế (gray-100) — KHÔNG dùng `bg-gray-50`. |
| Top navigation | `@livewire('catalog::navigation-menu')` | Trắng, border-b gray-100. |
| Header | `border-b border-gray-200 bg-white shadow` | Chứa `$header` slot + `<x-sys-user-info>` `<x-sys-year>` `<x-sys-company>` `<x-sys-language>`. |
| Header max width | `mx-auto max-w-7xl px-4 pt-6 pb-6 sm:px-6 lg:px-8` | `max-w-7xl` = 80rem = 1280px (KHÔNG dùng 1200px). |
| Main content | `max-w-12xl mx-auto px-0` + inner `px-6 py-3 lg:p-8` | Cho phép full-bleed table ngang. |

### Spacing token (map sang Tailwind)

| Token | Giá trị | Tailwind |
|-------|---------|----------|
| `xs` | 4px | `p-1`, `gap-1` |
| `sm` | 8px | `p-2`, `gap-2` |
| `md` | 16px | `p-4`, `gap-4` |
| `lg` | 24px | `p-6`, `gap-6` |
| `xl` | 32px | `p-8`, `gap-8` |
| `xxl` | 48px | `p-12`, `gap-12` |

### Pattern dùng nhiều trong codebase

- **Form filter (3-col grid):** `grid grid-cols-3 items-center gap-4` — label `text-right text-sm text-gray-700` + control `col-span-2`. Stack các row bằng `space-y-3` hoặc `space-y-4`.
- **Table cell padding:** `px-3 py-2` (12/8) cho cell nội dung, `px-3 py-2` cho header `font-medium text-gray-500 bg-gray-50`.
- **Card padding:** `p-4` cho card dashboard, `p-6` cho card CRUD chi tiết. KHÔNG tự thêm `margin-bottom` cho từng element — dùng `space-y-4` / `space-y-6` cho stack.
- **Input spacing:** label cách input bằng `mt-1`; error message `<x-input-error for="..." class="mt-1" />` (đã có sẵn `text-sm text-red-600`).
- **Action row spacing:** `flex justify-end gap-2` cho nhóm nút Sửa/Xóa trong table.

---

## Elevation & Depth

Portal dùng **soft shadow ưu tiên** thay vì border nặng. Bốn mức shadow xuất hiện thực tế:

| Class | Dùng cho |
|-------|----------|
| `shadow-sm` | Card CRUD, table wrapper, input/button hover. **Phổ biến nhất.** |
| `shadow` | Header navigation. |
| `shadow-xl` | `dashboard.blade.php` panel lớn. |
| `shadow-lg` | Dropdown Alpine (input-khachhang, navigation-menu). |

**Tonal layering:** page dùng `bg-gray-100` (đậm hơn neutral), card bên trong dùng `bg-white` để phân tầng. Card luôn kết hợp `border border-gray-200` + `shadow-sm` + `rounded-lg` — không chỉ dựa vào shadow.

---

## Shapes

Ngôn ngữ hình dạng: **Soft Utility**. Toàn bộ giao diện dùng corner-radius 4–12px. Badge trạng thái dùng `rounded-full`.

| Element | Class | Radius |
|---------|-------|--------|
| Input, button, badge thường | `rounded-md` | 6px |
| Card, panel lớn, table wrapper | `rounded-lg` | 8px |
| Modal, dialog xác nhận | `rounded-xl` | 12px |
| Badge trạng thái (success/warning/error) | `rounded-full` | 9999px |
| Checkbox, radio, link nút nhỏ (Sửa/Xóa inline) | `rounded` | 4px |

**Quy ước:** KHÔNG trộn `rounded` (4px) với `rounded-lg` (8px) trong cùng một view trừ khi là link nút inline trong table row.

---

## Components

Định nghĩa token cho các "nguyên tử" Portal dùng lặp lại. Mỗi component map 1-1 sang class Tailwind thực tế.

### Buttons

- **button-primary (Portal style)** — `inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-wait disabled:opacity-70`. Dùng cho Thêm / Lưu / Submit / Thực hiện.
- **button-primary (compact)** — `rounded-md bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700` (task 359) — dùng khi row quá chật.
- **button-primary (x-button-loading)** — `<x-button-loading class="rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:cursor-wait disabled:opacity-70" wire:click="submit">Thực hiện</x-button-loading>` — có spinner tích hợp, dùng cho mọi submit Livewire.
- **button-secondary (x-button)** — `<x-button>...</x-button>` (`bg-gray-800 border-transparent text-white uppercase tracking-widest hover:bg-gray-700`). Jetstream mặc định, hiếm dùng trong Portal thực tế.
- **button-secondary (Portal style)** — `bg-white text-gray-700 rounded-md px-3 py-1.5 text-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50`. Dùng cho "Xuất Excel".
- **button-danger (x-danger-button)** — `<x-danger-button>...</x-danger-button>` (`bg-red-600 ... hover:bg-red-500`). Jetstream mặc định cho confirm modal.
- **button-danger (inline action)** — `rounded bg-red-100 px-2 py-1 text-xs text-red-700 hover:bg-red-200`. Dùng cho nút Xóa trong table row (task AR/PO list).
- **button-warning (inline action)** — `rounded bg-yellow-100 px-2 py-1 text-xs text-yellow-700 hover:bg-yellow-200`. Dùng cho nút Sửa trong table row.
- **button-loading** — `<x-button-loading>...</x-button-loading>` wrapper, tự động đổi text thành "Đang xử lý..." khi `wire:loading`. Mặc định không có background — truyền class qua `class=""` attribute.

### Card

- **card CRUD (panel chính)** — `<div class="rounded-lg border border-gray-200 bg-white shadow-sm p-6">` — dùng cho form edit.
- **card CRUD (compact)** — `rounded-md border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm text-gray-700` — dùng cho display-only field (task 359 pTieu_de).
- **card dashboard** — `<div class="rounded-lg border border-gray-200 bg-white p-4">` — không shadow-sm.
- **table wrapper** — `<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">` — bọc `<table class="w-full text-sm">` với `<thead class="bg-gray-50">` + `<tbody>` row `hover:bg-sky-50`.

### Input Field

- **input text/select/textarea** — `<input class="mt-1 block w-full rounded-md border-gray-300 py-1 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">` — pattern phổ biến nhất.
- **input compact (timer)** — `rounded-md border-gray-300 bg-white px-2 py-1 text-sm text-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500` — dùng trong `<x-catalog::component.timer>` (focus ring indigo).
- **input readonly display** — `rounded-md border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm text-gray-700` — chỉ hiển thị, không bind `wire:model` (task 359 pTieu_de).
- **input disabled** — thêm `disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-400`.
- **error message** — `<x-input-error for="pNgay1" class="mt-1" />` (đã có `text-sm text-red-600`).
- **input có icon (clear/search)** — wrapper `relative` + `<input>` + button clear absolute `right-2 top-1/2 -translate-y-1/2` (`x-catalog::component.input-khachhang`).

### Badges (status pill)

- **badge-success** — `inline-flex rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800` — Hoạt động, Đã duyệt.
- **badge-error** — `inline-flex rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800` — Khóa, Lỗi.
- **badge-warning** — `inline-flex rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800` — Chờ duyệt, Nháp.
- **badge-neutral** — `inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800` — fallback khi không có semantic.

### Toast & Banner

- **toast success** — `border-green-300 bg-green-50 text-green-800` (xem `components/toast.blade.php`).
- **toast error** — `border-red-300 bg-red-50 text-red-800`.
- **banner success** — `bg-indigo-500` (không green — quy ước Jetstream).
- **banner danger** — `bg-red-700`.
- **banner warning** — `bg-yellow-500`.

### Tabs

- **tab nav** — `<x-nav-tabs default-tab="filter">` component, dùng Alpine `x-data="{ activeTab: '...' }"` + dispatch event `switch-tab` từ Livewire.
- **tab link** — `inline-block rounded-t-lg border-b-2 p-4` + dynamic class `border-blue-500 text-blue-600` (active) / `border-transparent hover:text-gray-600 hover:border-gray-300` (inactive).

### Modal & Loading

- **loading overlay** — `<div id="catalog-loading-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">` + SVG spinner `text-blue-600 animate-spin`. Auto-toggle qua Livewire hook `request → respond`.
- **confirmation modal** — Jetstream default `<x-confirmation-modal>` + `<x-danger-button>`.

### Link inline trong table (Sửa / Xem / Xóa)

- **link Sửa** — `rounded bg-yellow-100 px-2 py-1 text-xs text-yellow-700 hover:bg-yellow-200`.
- **link Xem** — `rounded border border-gray-200 px-2 py-1 text-xs font-medium text-gray-700 hover:border-sky-300 hover:text-sky-700` (task 359).
- **link Xóa** — `rounded bg-red-100 px-2 py-1 text-xs text-red-700 hover:bg-red-200` + `wire:confirm="..."`.

---

## Do's and Don'ts

### Do

- Dùng `bg-blue-600` (`primary`) **chỉ cho một action nổi bật nhất** trên mỗi màn hình — thường là "Thêm" / "Lưu" / "Thực hiện". Nút phụ dùng `x-button-loading` không có background hoặc `bg-gray-700` cho "Xuất Excel".
- Đặt mọi card trong page nền `bg-gray-100`, card con dùng `bg-white` để phân tầng. Bọc table bằng `rounded-lg border border-gray-200 bg-white shadow-sm`.
- Giữ contrast WCAG AA — text thường tối thiểu 4.5:1 (`text-gray-800` trên `bg-white`; `text-gray-500` chỉ cho metadata phụ). Badge text dùng `*-800` (không `*-600`).
- Dùng component token ở trên — `<x-button-loading>`, `<x-input-error>`, `<x-nav-tabs>`, `<x-head-title>`, `<x-banner>`, `<x-toast>` — thay vì tự compose lại.
- Theo spacing token 4px — cấm tự đặt `p-3.5`, `mt-2.5`, `w-7`. Nếu cần nửa step, mở task mới thảo luận trước.
- Click handler cho action chính: `wire:click="submit"` + wrap trong `<x-button-loading>` để có spinner tự động.
- Destructive action phải có `wire:confirm="Bạn có chắc chắn muốn xóa {ma_kh}?"` — không dùng modal riêng cho row-level delete.

### Don't

- KHÔNG trộn `rounded` (4px) với `rounded-lg` (8px) trong cùng một view, trừ link nút inline trong table row.
- KHÔNG dùng quá 2 font weight trong cùng một màn hình (thường Regular 400 + Semi-Bold 600).
- KHÔNG tự ý tạo class Tailwind mới hoặc sửa `tailwind.config.js` — mở task/PR riêng, Sếp duyệt.
- KHÔNG dùng màu ngoài palette (`bg-purple-600`, `bg-pink-500`, `bg-orange-500`, ...) trừ khi design token mới được thêm vào file này.
- KHÔNG hard-code shadow ngoài `shadow-sm` / `shadow` / `shadow-lg` / `shadow-xl`.
- KHÔNG dùng `font-bold` (700) trên label/button — dùng `font-semibold` (600) là tối đa.
- KHÔNG scale font theo viewport (cấm `sm:text-lg md:text-xl`).
- KHÔNG set `letter-spacing` âm; KHÔNG set line-height lẻ.
- KHÔNG bind `wire:model` cho field display-only — chỉ render `{{ $value }}` trong thẻ `<div>` với class readonly.
- KHÔNG render raw toàn bộ column SP trong table. Tạo `$presentationColumns()` trong component để quyết định cột hiển thị; merge `ngay_ct`/`so_ct`/`stt_rec` vào cột "Chứng từ" compact, gom `ma_vt`/`ten_vt`/`dvt` vào sub-line trong cột "Diễn giải".
- KHÔNG tự ý tạo bảng/SP/field mới — phải đọc `simba-docs` trước, lấy đúng tên từ sysMenu/sysReportInfo/sysDictionaryInfo.

---

## Áp dụng vào Portal

Khi tạo hoặc sửa view trong `diepxuan/*/resources/views/`:

1. Mở file này (`docs/DESIGN.md`) trước, lấy token cho color/typography/radius/spacing/component.
2. Map sang Tailwind utility class theo bảng trong section Colors / Typography / Components.
3. Khi cần component mới — thêm variant vào section Components, **không** tự ý thay đổi palette.
4. Khi cần token ngoài bảng — mở task/PR riêng để mở rộng DESIGN.md + cập nhật `tailwind.config.js` (nếu cần), Sếp duyệt trước khi ship.
5. Sau khi tạo view, chạy `rg -no "rounded-(sm|md|lg|xl|none|full)" path/to/view` để verify không phát sinh class ngoài token.
6. Đối chiếu với task đã merge ở `docs/tasks/phase 1/` (008, 117, 358, 359) làm reference UI thực tế.

---

*Cập nhật lần cuối: 2026-07-17 · Bột (Portal Project Assistant) · theo pattern phase 1 (008 AR BCCN01, 117 INRptCD02, 358 route metadata, 359 AP BCCN01 SL).*
