# Portal Task

Task phát triển **Portal** (hạ tầng, công cụ nội bộ, UI/UX của chính Portal) — tách
biệt với task **port SimbaERP .NET sang Portal**.

> File `_index.md` này được TaskBoard đọc để hiển thị mô tả cột/nhóm trên board.

## Phân biệt

| Loại | Ở đâu | Nội dung |
|---|---|---|
| **SimbaERP task** | `docs/tasks/*.md`, `docs/tasks/phase 1/*.md` | Port chức năng từ Simba .NET (AR/AP/CA/SO/PO/SI/IN/FA/GL/CO) sang Portal |
| **Portal task** | `docs/tasks/portaltask/*.md` | Xây dựng/hạ tầng Portal: đăng nhập, dashboard, task board, công cụ dev, session, CI/CD |

## Phạm vi

Portal task bao gồm:

- **Xác thực & phiên**: đăng nhập, đăng xuất, SSO, auto-login nội bộ, session cookie
- **Khung ứng dụng**: dashboard, navigation, layout, theme
- **Công cụ phát triển**: task board, debug tooling, script sinh tài liệu
- **Hạ tầng**: Docker, CI/CD, cấu hình môi trường

## Quy ước

- ID Portal task dùng dải riêng, **bắt đầu từ `P001`** để không trùng ID SimbaERP.
- Mỗi file: `P{NNN}-{slug}.md`, heading `# Portal Task P{NNN}: {Tiêu đề}`.
- Status dùng cùng bộ từ khóa với task SimbaERP để TaskBoard phân loại nhất quán.
