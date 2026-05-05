# AGENTS.md - Workspace Operating Protocol

Quy trình vận hành workspace cho Portal Project.

**Workspace root:** `/root/.openclaw/workspace/projects/portal/`

**Repository:** `git@github.com:diepxuan/portal.git`

**Project URL:** https://github.com/orgs/diepxuan/projects/2

**Issues:** https://github.com/diepxuan/portal/issues

**Tham chiếu:** `SOUL.md` (core identity), `IDENTITY.md` (role definition)

---

## 1. Boot Sequence (BẮT BUỘC)

**Mỗi session phải đọc theo thứ tự:**

| Bước | File | Mục đích |
|------|------|----------|
| 1 | `SOUL.md` | Xác nhận bản sắc và nguyên tắc |
| 2 | `USER.md` | Xác định đối tượng phục vụ |
| 3 | `memory/YYYY-MM-DD.md` | Hôm nay |
| 4 | `memory/YYYY-MM-DD.md` | Hôm qua |
| 5* | `MEMORY.md` | Chỉ MAIN SESSION |

\* **MAIN SESSION** có quyền cập nhật `MEMORY.md`, định nghĩa chiến lược.

**Không được bỏ qua bước nào.**

---

## 2. Memory Structure

### 2.1 Daily Memory

| File | Mục đích | Quy tắc |
|------|----------|---------|
| `memory/YYYY-MM-DD.md` | Log thô theo ngày | Không chỉnh sửa lịch sử |

### 2.2 Long-Term Memory

| File | Mục đích | Quy tắc |
|------|----------|---------|
| `MEMORY.md` | Thông tin chiến lược | Chỉ lưu giá trị lâu dài, không ghi log rác |

---

## 3. Session Types

| Loại | Quyền hạn | Giới hạn |
|------|-----------|----------|
| **MAIN SESSION** | Cập nhật `MEMORY.md`, định nghĩa chiến lược, điều chỉnh workflow | Tuân thủ `SOUL.md` |
| **Session thường** | Ghi daily memory, thực thi task | Không thay đổi cấu trúc nền tảng |

---

## 4. Task Management

### 4.1 Task Creation

| Loại | Vị trí | URL |
|------|--------|-----|
| Task mới | GitHub Issues | https://github.com/diepxuan/portal/issues |
| Project board | GitHub Projects | https://github.com/orgs/diepxuan/projects/2 |

**Workflow:**
1. Task được tạo trong Issues
2. Issues được thêm vào Project board
3. Project board dùng để theo dõi tiến độ

### 4.2 Issue Labels

| Label | Mục đích |
|-------|----------|
| `bug` | Lỗi cần fix |
| `feature` | Tính năng mới |
| `docs` | Tài liệu |
| `chore` | Công việc bảo trì |
| `priority-high` | Ưu tiên cao |

---

## 5. Git Workflow

### 5.1 Nguyên tắc

| Rule | Mô tả |
|------|-------|
| 1 task | 1 branch mới |
| 1 set thay đổi | 1 PR mới |
| Luôn | Commit cho mọi thay đổi |
| Không | Làm việc trực tiếp trên `main` |

### 5.2 Cấm tuyệt đối

- ❌ Tự ý push
- ❌ Tự ý tạo PR
- ❌ Tự ý merge / revert / close PR
- ❌ Cập nhật PR cũ
- ❌ Push thêm commit vào PR đã mở
- ❌ Force push vào branch cũ
- ❌ Push vào PR đã merge

### 5.3 Commit Convention

```
<type>: <description>

feat: add new feature
fix: fix bug
docs: update documentation
chore: maintenance tasks
refactor: code refactoring
```

### 5.4 Branch Naming

```
<type>/<description>

feat/livewire-dashboard
fix/navigation-menu-route
chore/soul-code-scope-rule
docs/add-laravel-rules
```

**Chỉ push khi Sếp nói:** "Em tạo PR đi"

---

## 6. Sub-Agent Orchestration

### 6.1 Khi spawn đệ

| Yêu cầu | Mô tả |
|---------|-------|
| **Gọi là** | **đệ** |
| **Mục tiêu** | Rõ ràng, đo lường được |
| **Input** | Đầy đủ context cần thiết |
| **Output** | Định nghĩa cụ thể |
| **Giới hạn** | Thẩm quyền không được vượt |

### 6.2 Giám sát

- Không để đệ tự quyết định vượt thẩm quyền
- Check status khi cần (không poll loop)
- Intervention khi có vấn đề

---

## 7. Context Validation

**Trước khi hành động, xác nhận:**

| Câu hỏi | Mục đích |
|---------|----------|
| Task đã rõ chưa? | Hiểu yêu cầu |
| Có liên quan Git không? | Áp dụng workflow đúng |
| Có cần spawn đệ không? | Delegate nếu cần |
| Có cần update documentation không? | Duy trì tài liệu |
| File sẽ tạo ở vị trí nào? | Đảm bảo workspace scope |

**Nếu chưa rõ → hỏi Sếp.**

---

## 8. Documentation Trigger

**Phải tạo/cập nhật tài liệu khi:**

| Trigger | Hành động |
|---------|-----------|
| Feature mới | README.md, docs/ |
| Thay đổi cấu trúc | ARCHITECTURE.md, README.md |
| Thay đổi behavior | docs/UPDATE-YYYY-MM-DD.md |
| Fix bug ảnh hưởng logic | CHANGELOG.md, docs/ |

---

## 9. Failure Handling

**Nếu xảy ra lỗi:**

1. **Dừng** — không continue mù quáng
2. **Phân tích** — tìm nguyên nhân gốc
3. **Không patch** — vào branch cũ
4. **Branch mới** — nếu cần fix
5. **Báo cáo** — Sếp rõ ràng

---

## 10. Workspace Scope

### 10.1 Cho phép

| Vị trí | Mục đích |
|--------|----------|
| `diepxuan/` | Core business packages (ưu tiên) |
| `scripts/` | Scripts riêng cho Portal |
| `docs/` | Documentation |
| `memory/` | Daily memory logs |
| `simba-docs/` | Mount ZFS từ SimbaSql repo — domain knowledge (readonly) |

### 10.2 Cấm

- ❌ Tạo file ngoài `/root/.openclaw/workspace/projects/portal/`
- ❌ Sửa core Laravel files (trừ khi được yêu cầu)
- ❌ Ghi đè hoặc sửa file trong `simba-docs/` (mount readonly từ SimbaSql)

---

## 11. Kỷ Luật

| Rule | Mô tả |
|------|-------|
| Không bỏ qua | Boot sequence |
| Không hành động | Khi chưa nắm đủ context |
| Không phá vỡ | Git workflow |
| Mỗi task | Phải rõ ràng trước khi thực thi |

---

**Workspace này không phải chỗ thử nghiệm.**  
Đây là hệ điều hành tư duy của Bột cho Portal Project.
