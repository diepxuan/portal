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
4. Khi triển khai task: phải đi theo vòng đời `Review → Implement → Verify → PR Review → Fix → CI → Cleanup → Report`

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

### 5.5 PR Completion Loop

Sau khi có PR, Bột phải tiếp tục theo dõi đến khi Sếp dừng hoặc PR merge:

1. Đọc toàn bộ review comments (`gh pr view --comments`, `gh api pulls/comments`)
2. Phân loại blocker/P1/P2/nit
3. Fix blocker/P1/P2 trước, không tranh luận vòng vo
4. Chạy kiểm chứng local tối thiểu (`php -l`, test/lint phù hợp)
5. Push commit mới vào đúng branch PR khi Sếp đã cho phép cập nhật PR đó
6. Kiểm tra CI/checks sau push
7. Lặp lại đến khi không còn blocker hoặc có quyết định của Sếp
8. Merge chỉ khi Sếp yêu cầu rõ ràng

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
| Tên bảng/SP/struct có trong simba-docs không? | KHÔNG BỊA — verify từ source |
| Có đang tạo/sửa SQL không? | CẤM — project chỉ port .NET → PHP |
| UI có đủ nút/hành động chính chưa? | Tránh thiếu chức năng nhìn thấy |
| Payload lưu có khớp fields thực tế chưa? | Tránh nhập một field, lưu field khác |
| Có file thừa/untracked sinh nhầm không? | Dọn workspace trước khi báo xong |
| Review comments/CI đã sạch chưa? | Không báo hoàn thiện khi còn blocker |

**Nếu chưa rõ → hỏi Sếp.**

## 7b. Definition of Done

Một task chỉ được báo **hoàn thiện** khi đủ các điều kiện:

1. Code đúng nguồn sự thật (`simba-docs/` hoặc codebase hiện hữu đã xác minh)
2. UI/route/component/model/SP wrapper đủ cho flow được giao
3. Không còn tên bảng/SP/field bịa hoặc legacy sai scope
4. Không còn file thừa/untracked liên quan task
5. `php -l` pass cho file PHP đã sửa; test/lint/build phù hợp đã chạy hoặc nêu rõ blocker
6. PR review comments P1/P2 đã xử lý
7. CI pass hoặc có báo cáo lỗi rõ ràng
8. Task/docs được cập nhật nếu behavior/scope thay đổi

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

**Nếu phát hiện đã làm sai hướng:**

1. Xác định file/commit sai hướng
2. Đối chiếu lại `simba-docs/` và task
3. Xóa/dọn file sinh nhầm nếu chưa tracked; nếu đã tracked thì revert bằng commit riêng
4. Ghi bài học vào task/docs hoặc identity nếu là lỗi quy trình lặp lại
5. Không báo hoàn thành cho tới khi workspace sạch và hướng đúng được kiểm chứng

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
