# Task 367: System Framework Libraries — Ghi nhận cấu trúc

## Nhóm: System — Framework & Infrastructure

## Mục tiêu

Ghi nhận cấu trúc các **System Framework DLLs** — đây là các thư viện nền tảng (infrastructure), không cần implement UI riêng trong Portal. Các chức năng tương đương đã có trong Laravel ecosystem.

## Trạng thái

- **Status:** 📄 DOCUMENTATION ONLY — ghi nhận, không implement
- **Loại:** Framework/Infrastructure DLLs

## Danh sách DLL

| # | DLL | Mô tả | PHP equivalent | Action |
|:-:|-----|-------|---------------|--------|
| 1 | `AsiaLicenseCommon.dll` | Quản lý license (DSA signature, trial 90 ngày) | Laravel license check (không cần) | Ghi nhận |
| 2 | `DashBoard.dll` | Dashboard Widget System (MENU, TABLE, CHART) | Livewire dashboard components | Ghi nhận |
| 3 | `Docking.dll` | VS2005-style docking framework | Livewire layout (không cần dock) | Ghi nhận |
| 4 | `DynReport.dll` | Crystal Report wrapper | Laravel reporting (Laravel-Excel, etc.) | Ghi nhận |
| 5 | `DynamicReport.dll` | Dynamic report form (tạo controls từ SP) | Livewire dynamic form | Ghi nhận |
| 6 | `Framework.dll` | **Core framework** — frmAsiaRoot, frmVoucher, frmDMView, frmDMEdit, AsControls, DAO pattern | Laravel base controllers, Livewire components | Ghi nhận |
| 7 | `GenerationReport.dll` | RDL report generator | Laravel reporting | Ghi nhận |
| 8 | `Helper.dll` | Encryption (RSA, DES, SHA, MD5), CBO mapping, MessageBox | Laravel helpers, Crypt facade | Ghi nhận |
| 9 | `ReportDynamic.dll` | Dynamic report filter form | Livewire filter components | Ghi nhận |
| 10 | `RptCommon.dll` | Common report framework | Livewire report components | Ghi nhận |
| 11 | `ToolCommon.dll` | DB connection, session management | Laravel DB, Session facades | Ghi nhận |

## Kết luận

Các DLL trên là **framework/infrastructure** của .NET Simba, không cần port thành code PHP riêng. Portal (Laravel) đã có sẵn các tương đương:
- `Framework.dll` (core base classes) → Laravel base classes + Livewire
- `Helper.dll` (utilities) → Laravel helpers + Crypt
- `ToolCommon.dll` (DB/session) → Laravel DB/Session
- `Docking.dll` (UI docking) → Tailwind/Livewire layout
- `DashBoard.dll` → Livewire dashboard components
- `DynReport` / `GenerationReport` / `ReportDynamic` / `RptCommon` → Laravel reporting ecosystem

## Audit Status

- **2026-07-20:** Tách từ task 181-196. Framework DLLs giữ nguyên documentation.
