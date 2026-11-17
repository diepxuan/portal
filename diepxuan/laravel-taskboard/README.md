# Laravel TaskBoard

Module quản lý task dạng **Kanban** cho Portal, đọc và cập nhật trực tiếp các file
markdown trong `docs/tasks/`.

## Vì sao là module riêng

Task board **không dùng database** — nguồn dữ liệu là file `.md` trong repo. Nhờ vậy
màn hình chạy được trên máy dev (nơi không có kết nối DB trực tiếp, xem
`docs/DEVELOPMENT.md` §4.1).

## Tính năng

- **Kanban 4 cột**: Chờ làm / Đang làm / Hoàn thành / Khác
- **Danh sách**: bảng có phân cột, sticky header
- **Tìm kiếm**: theo ID, tên task, module, DLL, status (chuẩn hóa bỏ dấu như các
  filter khác trong Portal)
- **Lọc**: theo module (AR/AP/CA/SO/PO/SI/IN/FA/GL/SYS) và phase (Hiện tại / phase 1)
- **Panel chi tiết**: hiển thị module, phase, trạng thái, DLL, status gốc, và
  **checklist** kèm thanh tiến độ
- **Deep-link**: filter lưu trên URL query (`?q=&module=&phase=&view=`)

## Cấu trúc

```
diepxuan/laravel-taskboard/
├── config/taskboard.php                     # tasks_path, writable
├── routes/web.php                           # hethong/tasks (name: system.tasks.index)
├── src/
│   ├── Http/Livewire/TaskBoard.php          # component chính
│   ├── Providers/TaskBoardServiceProvider.php
│   └── Services/TaskRepository.php          # parse + ghi task md
├── resources/views/taskboard/index.blade.php
└── tests/Unit/TaskRepositoryTest.php
```

## Cách dùng

Truy cập **Hệ thống → Quản lý task** trên menu, hoặc trực tiếp:

```
http://portal.diepxuan.corp/hethong/tasks
```

## Parse task doc

Module parse metadata theo cùng quy ước `scripts/gen-tasks-index.php`:

| Trường | Nguồn |
|---|---|
| ID | `# Task {ID}:` dòng đầu, fallback prefix filename |
| Title | sau dấu `:` ở heading, fallback tên file |
| Module | `## Nhom: XX` → hoặc prefix filename (`008-ar-...` → AR) |
| Status | `**Status:** ...` |
| DLL | `**DLL:** ...` hoặc bảng `\| **DLL** \| ... \|` |
| Checklist | các dòng `- [x]` / `- [ ]` |

### Suy ra cột Kanban từ status

Status trong repo rất đa dạng (`DONE (route shell)`, `✅ DONE — merged PR #277`,
`🔄 CẦN MAP`, `IN PROGRESS (...)`), nên module match theo từ khóa:

| Cột | Từ khóa nhận diện |
|---|---|
| Khác | `NOT A TASK`, `DOCUMENTATION ONLY`, `📄` |
| Đang làm | `IN PROGRESS`, `IMPLEMENTED`, `CẦN MAP`, `🔄` |
| Chờ làm | `PENDING`, `TODO`, `❌`, `CHƯA`, hoặc không có status |
| Hoàn thành | `DONE`, `MERGED`, `✅` |

## Ghi dữ liệu (tùy chọn)

Mặc định module **chỉ đọc**. Để cho phép cập nhật status/checklist từ UI, bật:

```dotenv
TASKBOARD_WRITABLE=true
```

Khi bật, `TaskRepository::updateStatus()` ghi đè dòng `**Status:**` và
`toggleChecklist()` đổi `- [ ]` ↔ `- [x]` trong file `.md` tương ứng.

> **Cảnh báo:** ghi trực tiếp vào file trong repo sẽ tạo thay đổi working tree.
> Chỉ bật khi thật sự muốn sửa task doc từ giao diện.

## Cấu hình

| Biến | Mặc định | Mô tả |
|---|---|---|
| `TASKBOARD_TASKS_PATH` | `docs/tasks` | Thư mục chứa task docs (tính từ `base_path()`) |
| `TASKBOARD_WRITABLE` | `false` | Cho phép ghi status/checklist vào file `.md` |

## Test

```bash
vendor/bin/phpunit diepxuan/laravel-taskboard/tests/Unit/TaskRepositoryTest.php
```

Test thuần logic (dùng thư mục fixture tạm), **không chạm DB**.
