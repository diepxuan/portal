---
version: alpha
name: Diepxuan Portal Design System
description: Visual identity & design tokens for the Diepxuan Portal Laravel application. Consumed by AI agents and humans to keep Blade, Livewire và Alpine UI nhất quán trên toàn bộ 14 core packages.
colors:
  primary: "#2563EB"
  primary-hover: "#1D4ED8"
  secondary: "#6B7280"
  tertiary: "#0EA5E9"
  neutral: "#F9FAFB"
  surface: "#FFFFFF"
  on-surface: "#1F2937"
  error: "#DC2626"
  success: "#16A34A"
  warning: "#CA8A04"
  border: "#E5E7EB"
  muted: "#6B7280"
typography:
  h1:
    fontFamily: Figtree
    fontSize: 30px
    fontWeight: 600
    lineHeight: 1.2
    letterSpacing: -0.01em
  h2:
    fontFamily: Figtree
    fontSize: 24px
    fontWeight: 600
    lineHeight: 1.25
  h3:
    fontFamily: Figtree
    fontSize: 20px
    fontWeight: 600
    lineHeight: 1.3
  h4:
    fontFamily: Figtree
    fontSize: 18px
    fontWeight: 600
    lineHeight: 1.35
  body-md:
    fontFamily: Figtree
    fontSize: 16px
    fontWeight: 400
    lineHeight: 1.5
  body-sm:
    fontFamily: Figtree
    fontSize: 14px
    fontWeight: 400
    lineHeight: 1.5
  label-md:
    fontFamily: Figtree
    fontSize: 14px
    fontWeight: 500
    lineHeight: 1.4
  label-sm:
    fontFamily: Figtree
    fontSize: 12px
    fontWeight: 500
    lineHeight: 1.4
    letterSpacing: 0.02em
  caption:
    fontFamily: Figtree
    fontSize: 12px
    fontWeight: 400
    lineHeight: 1.4
  mono:
    fontFamily: "JetBrains Mono"
    fontSize: 14px
    fontWeight: 400
    lineHeight: 1.5
rounded:
  none: 0px
  sm: 4px
  md: 6px
  lg: 8px
  xl: 12px
  full: 9999px
spacing:
  base: 16px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  xxl: 48px
  gutter: 24px
  margin: 32px
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "#FFFFFF"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "{spacing.sm} {spacing.md}"
  button-primary-hover:
    backgroundColor: "{colors.primary-hover}"
    textColor: "#FFFFFF"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "{spacing.sm} {spacing.md}"
  button-secondary:
    backgroundColor: "#FFFFFF"
    textColor: "{colors.on-surface}"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "{spacing.sm} {spacing.md}"
  button-danger:
    backgroundColor: "#FFFFFF"
    textColor: "{colors.error}"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "{spacing.sm} {spacing.md}"
  card:
    backgroundColor: "{colors.surface}"
    rounded: "{rounded.lg}"
    padding: "{spacing.lg}"
  input-field:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.on-surface}"
    typography: "{typography.body-sm}"
    rounded: "{rounded.md}"
    padding: "{spacing.sm} {spacing.md}"
  badge-success:
    backgroundColor: "#DCFCE7"
    textColor: "{colors.success}"
    typography: "{typography.label-sm}"
    rounded: "{rounded.full}"
  badge-warning:
    backgroundColor: "#FEF9C3"
    textColor: "{colors.warning}"
    typography: "{typography.label-sm}"
    rounded: "{rounded.full}"
  badge-error:
    backgroundColor: "#FEE2E2"
    textColor: "{colors.error}"
    typography: "{typography.label-sm}"
    rounded: "{rounded.full}"
  table-row-hover:
    backgroundColor: "#F0F9FF"
---

# Diepxuan Portal Design System

DESIGN.md là nguồn sự thật duy nhất về **nhận dạng trực quan** của Portal. File này giúp AI agents (Claude Code, Cursor, Codex...) và developers tham gia dự án giữ UI/UX nhất quán xuyên suốt 14 core packages trong `diepxuan/`, các Blade view trong `resources/views/`, và cả phần Livewire + Alpine.js.

> **Spec tham chiếu:** [google-labs-code/design.md (alpha)](https://github.com/google-labs-code/design.md/blob/main/docs/spec.md) — 7 sections chuẩn: Overview / Colors / Typography / Layout / Elevation / Shapes / Components / Do's & Don'ts.

---

## Overview (Brand & Style)

Portal là ứng dụng nghiệp vụ (Laravel + Livewire) phục vụ vận hành kế toán/kho/bán hàng được port từ SimbaERP .NET. Tính cách thiết kế:

- **Nghiêm túc, đáng tin cậy** — giao diện dày dặn thông tin, dữ liệu dàng dặc, form CRUD chiếm phần lớn trang.
- **Trực quan, dễ quét** — semantic color (success/warning/error), icon đơn giản, table chiếm ưu thế.
- **Tiếng Việt là chính** — copy và label ưu tiên tiếng Việt, RTL/LTR mặc định trái-sang-phải.
- **Tailwind-first** — mọi giá trị dưới đây đều map 1-1 sang Tailwind utility class, không tự chế CSS thuần trừ khi Sếp duyệt.

Font chính: **Figtree** (đã khai báo trong `tailwind.config.js`). Font phụ cho dữ liệu kỹ thuật / số ID: **JetBrains Mono** (chưa import — dùng khi cần highlight code hoặc cột ID dài).

---

## Colors

Bảng màu lấy cảm hứng từ Tailwind palette (blue/gray/red/yellow/green/sky) đã sử dụng thực tế trong toàn bộ codebase. Bám sát thói quen hiện có của Portal, không tạo scale mới.

- **Primary (#2563EB)** — Royal Blue. Dùng cho action chính của trang (Thêm, Lưu, Submit), link quan trọng, focus ring. **Chỉ một primary action nổi bật mỗi màn hình.**
- **Primary Hover (#1D4ED8)** — trạng thái hover/active của primary.
- **Secondary / Muted (#6B7280)** — slate gray cho text phụ, metadata, border trung tính.
- **Tertiary (#0EA5E9)** — sky-500 cho row hover (`hover:bg-sky-50`) và nhấn nhẹ.
- **Neutral (#F9FAFB)** — gray-50, nền trang mặc định.
- **Surface (#FFFFFF)** — bề mặt card / table / form.
- **On-Surface (#1F2937)** — gray-800, text chính.
- **Error (#DC2626)** — red-600, thông báo lỗi, nút Xóa có chủ đích (destructive).
- **Success (#16A34A)** — green-600, thông báo thành công / badge hoàn thành.
- **Warning (#CA8A04)** — yellow-600, cảnh báo validation, badge trạng thái chờ.
- **Border (#E5E7EB)** — gray-200, viền card, input, divider bảng.
- **Muted (#6B7280)** — gray-500, text phụ, label placeholder.

### Token map (YAML ↔ Tailwind class)

| Token | Giá trị | Tailwind class thường dùng |
|-------|---------|---------------------------|
| `colors.primary` | `#2563EB` | `bg-blue-600`, `text-blue-600`, `ring-blue-600`, `hover:bg-blue-700` |
| `colors.primary-hover` | `#1D4ED8` | `hover:bg-blue-700` |
| `colors.secondary` / `muted` | `#6B7280` | `bg-gray-500`, `text-gray-500` |
| `colors.tertiary` | `#0EA5E9` | `bg-sky-500`, `hover:bg-sky-50` |
| `colors.neutral` | `#F9FAFB` | `bg-gray-50` |
| `colors.surface` | `#FFFFFF` | `bg-white` |
| `colors.on-surface` | `#1F2937` | `text-gray-800` |
| `colors.error` | `#DC2626` | `bg-red-600`, `text-red-600`, `bg-red-100`/`text-red-700` cho badge |
| `colors.success` | `#16A34A` | `bg-green-600`, `text-green-600`, `bg-green-100`/`text-green-700` |
| `colors.warning` | `#CA8A04` | `text-yellow-600`, `bg-yellow-100`/`text-yellow-700` |
| `colors.border` | `#E5E7EB` | `border-gray-200` |

---

## Typography

Strategy chỉ dùng **Figtree** với một weight-axis duy nhất trong giao diện chính để UI gọn gàng. JetBrains Mono để hiển thị ID / số chứng từ / code snippet.

- **Headlines (h1–h4):** Figtree Semi-Bold (600), dùng cho tiêu đề trang, tiêu đề card.
- **Body (body-md / body-sm):** Figtree Regular (400), dùng cho nội dung chính và nội dung phụ.
- **Label (label-md / label-sm):** Figtree Medium (500), dùng cho nhãn input, nhãn button, header table.
- **Caption:** Figtree Regular 12px — ghi chú nhỏ, helper text, metadata.
- **Mono:** JetBrains Mono 14px — mã chứng từ, ID dài, JSON log.

> **Quy ước:** Không trộn hơn 2 weight trong cùng một màn hình (đã có `Don'ts` ở dưới).

---

## Layout (Layout & Spacing)

Portal theo **Fixed-Max-Width Grid** với chiều rộng tối đa vùng nội dung `1200px`, gutter 24px. Toàn bộ layout dựng trên **Tailwind spacing scale 4px** (`xs = 4px`, `sm = 8px`, `md = 16px`, `lg = 24px`, `xl = 32px`, `xxl = 48px`). Cấm tự đặt giá trị lạ như `13px`, `5px`, `7px` — không khớp spacing token.

Các quy tắc cụ thể:

- **Page padding:** `px-6 py-6` (24px) trên desktop, `px-4 py-4` (16px) trên mobile.
- **Card padding:** `p-6` (24px) cho card CRUD chi tiết, `p-4` (16px) cho card dashboard.
- **Stack spacing:** dùng `space-y-4` / `space-y-6` cho form fields, **không** tự thêm margin-bottom cho từng element.
- **Table cell padding:** `px-3 py-2` (12/8) — pattern chuẩn cho bảng danh sách.
- **Input spacing:** label cách input bằng `mt-1`, error message cách input bằng `mt-1` + `text-sm text-red-600`.

---

## Elevation & Depth

Portal dùng **soft shadow ưu tiên** thay vì border nặng. Chỉ ba mức shadow:

- **`shadow-sm`** — input focus / button hover, độ nổi rất nhẹ.
- **`shadow-sm`** (kết hợp `border border-gray-200`) — card chuẩn CRUD (`rounded-lg`).
- **`shadow-xl`** — `dashboard` panel lớn, modal overlay (hiện có ở `dashboard.blade.php`).

**Tonal layering** làm nền phân tầng: page dùng `bg-gray-50` (neutral), card bên trong dùng `bg-white` (surface). Tránh shadow đậm trên element phụ — luôn giữ ranh giới rõ ràng giữa container và nội dung.

---

## Shapes

Ngôn ngữ hình dạng: **Soft Utility**. Toàn bộ giao diện dùng corner-radius từ 4px đến 12px. Trừ các badge trạng thái (dùng `rounded-full`).

| Element | Radius |
|---------|--------|
| Input, button, badge thường | `rounded-md` (6px) |
| Card, panel lớn | `rounded-lg` (8px) |
| Modal, dialog xác nhận | `rounded-xl` (12px) |
| Badge trạng thái (success/warning/error pill) | `rounded-full` |
| Checkbox, radio | `rounded` (4px) |

**Không trộn sharp và soft corner trong cùng một view** — đã nêu trong Do's & Don'ts.

---

## Components

Định nghĩa token cho các "nguyên tử" Portal dùng lặp lại trong CRUD/danh sách. Mỗi component map 1-1 sang class Tailwind thực tế trong codebase.

### Buttons

- **button-primary** — `bg-blue-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-blue-700`
- **button-primary-hover** — same as primary + `hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600`
- **button-secondary** — `bg-white text-gray-700 rounded-md px-4 py-2 text-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50`
- **button-danger** — `bg-white text-red-600 rounded-md px-4 py-2 text-sm ring-1 ring-inset ring-red-200 hover:bg-red-50` (cho Xóa có confirm)

### Card

- **card** — `<div class="rounded-lg border border-gray-200 bg-white shadow-sm p-6">` — pattern chuẩn cho mọi panel CRUD/danh sách.

### Input Field

- **input-field** — `<input class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">` — dùng cho text/select/textarea.

### Badges

- **badge-success** — `bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium`
- **badge-warning** — `bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium`
- **badge-error** — `bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium`

### Table row hover

- **table-row-hover** — `hover:bg-sky-50` — dùng cho toàn bộ table row khi có tương tác edit/delete inline.

---

## Do's and Don'ts

### Do

- Dùng `colors.primary` chỉ cho **một action nổi bật nhất** trên mỗi màn hình (thường là "Lưu" / "Thêm").
- Đặt mọi card trong `bg-gray-50` page nền, card con dùng `bg-white` để phân tầng.
- Giữ contrast WCAG AA — text thường tối thiểu 4.5:1 trên nền tương ứng (`text-gray-800` trên `bg-white`, `text-gray-500` chỉ cho metadata phụ).
- Dùng component token ở trên (button-primary, card, input-field…) thay vì tự compose class mới khi tương đương.
- Theo spacing token 4px — cấm tự đặt `p-3.5`, `mt-2.5`, `w-7`… trừ khi Sếp duyệt.

### Don't

- Không trộn `rounded` (4px) với `rounded-lg` (8px) hoặc lớn hơn trong cùng một view.
- Không dùng quá 2 font weight trong cùng một màn hình (thường Regular 400 + Semi-Bold 600).
- Không tự ý tạo class Tailwind mới — chỉ dùng token đã định nghĩa hoặc mở rộng `tailwind.config.js` sau khi Sếp duyệt.
- Không dùng màu ngoài palette (`bg-purple-600`, `bg-pink-500`, …) trừ khi design token mới được thêm vào file này.
- Không hard-code shadow khác `shadow-sm` / `shadow-xl` (đã định nghĩa).
- Không dùng `font-bold` (700) trên label/button — dùng `font-semibold` (600) là tối đa.

---

## Áp dụng vào Portal

Khi tạo hoặc sửa view trong `diepxuan/*/resources/views/`:

1. Mở file này (`docs/DESIGN.md`) trước, lấy token cho color/typography/radius/spacing/component.
2. Map sang Tailwind utility class theo bảng trong section Colors / Typography.
3. Khi cần component mới — thêm variant vào section Components, **không** tự ý thay đổi palette.
4. Khi cần token ngoài bảng — mở task/PR riêng để mở rộng DESIGN.md + cập nhật `tailwind.config.js` (nếu cần), Sếp duyệt trước khi ship.

---

*Cập nhật lần cuối: 2026-07-17 · Bột (Portal Project Assistant) · theo [DESIGN.md spec alpha](https://github.com/google-labs-code/design.md/blob/main/docs/spec.md).*
