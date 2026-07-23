# AGENTS.md - Operating Instructions

Operating instructions cho Portal Agent. Xem SOUL.md cho bản sắc, IDENTITY.md cho chi tiết identity.

---

## 0. Boot Sequence

Mỗi session PHẢI đọc theo đúng thứ tự dưới đây. KHÔNG được chỉ đọc AGENTS.md rồi thao tác luôn - nhiều file dưới đây chứa policy/quirk quan trọng không lặp lại trong AGENTS.md.

1. **SOUL.md** - bản sắc, nguyên tắc tư duy, voice rules
2. **USER.md** - xác định Sếp, timezone, working style
3. **IDENTITY.md** - chi tiết identity (workspace, server, DB, file hạn chế)
4. **TOOLS.md** - sandbox & escalation (phân biệt lệnh Read-only / Ghi local / Ghi cần hỏi Sếp); nếu task cần verify URL trên browser, đọc thêm mục "Website Verification & Dev Server" (base URL local mặc định `http://portal.diepxuan.corp`, route package nằm dưới prefix `/simba`, vd `http://portal.diepxuan.corp/simba/po/vch/povchpo3/create`. KHÔNG suy ra URL chỉ từ `routes/web.php` vì thiếu host + prefix)
5. **memory/<hôm-nay>.md** - daily context hôm nay (nếu có)
6. **memory/<hôm-qua>.md** - daily context hôm qua (nếu có)
7. **MEMORY.md** - long-term memory (chỉ MAIN SESSION)
8. **docs/DESIGN.md** - nếu task có chạm UI/Blade/Livewire/Alpine: design tokens (color/typography/radius/spacing/components) chuẩn Google Labs `design.md` spec

Nếu có xung đột giữa các tài liệu, ưu tiên: chỉ dẫn mới nhất của Sếp → SOUL.md → USER.md → IDENTITY.md → AGENTS.md → tài liệu dự án còn lại.

---

## 1. Code Scope

| Ưu tiên | Vị trí | Ghi chú |
|---------|--------|---------|
| Cao nhất | `diepxuan/` | 14 core business packages |
| Hạn chế | Core Laravel files | Chỉ khi Sếp yêu cầu |

### Files hạn chế sửa

- `routes/web.php`
- `app/Http/Controllers/`
- `app/Models/`
- `config/*.php`

---

## 2. Simba Domain Knowledge

- Mount readonly tại `simba-docs/` — nguồn sự thật duy nhất
- **Cấm tuyệt đối:** tự đặt tên bảng/SP/field, tạo bảng mới, ALTER/CREATE/INSERT SQL
- Trước khi code: đọc simba-docs → lấy đúng tên bảng, cột, SP, fields từ DataBinding
- Mọi thao tác dữ liệu SimbaERP gồm hiển thị danh sách, lookup/filter, thêm, sửa, xóa đều ưu tiên Stored Procedure gốc từ `simba-docs` (`sysDAOInfo`, DLL/DAO, procedures). Eloquent/model là phương án thay thế khi đã tra `simba-docs` nhưng chưa có thông tin SP phù hợp, và phải ghi rõ nguồn tra cứu/lý do trong task docs.

---

## 3. Git Discipline

- Không tự ý push / tạo PR / merge
- Mỗi task = 1 branch = 1 PR
- Chỉ push khi Sếp nói: "Em tạo PR đi"

### 3.1. Merge PR — DÙNG `gh pr merge`, KHÔNG `git merge` local

**Khi Sếp nói "merge PR" / "merge #N" / "merge cho anh", agent phải dùng `gh pr merge`.**

- **ĐÚNG:** `gh pr merge <N> --repo <owner/repo> --squash --delete-branch`
- **SAI:** `git merge --squash` local + `gh pr close`

**Lý do:** `gh pr merge` giữ PR state `MERGED`, bảo toàn attribution.

**Verify sau merge:** `state == MERGED`, `mergeCommit.oid` không rỗng.

### 3.2. Khi nào được dùng `git merge` local

- Khi Sếp nói rõ "cherry-pick" / "gộp branch" / "rebase local"
- Khi Sếp yêu cầu tổng hợp commit trước khi mở PR

---

## 4. Task Completion Cycle

Khi nhận task, phải đi hết vòng đời:

1. **Đọc task + source** — simba-docs, vouchers, SP, DataBinding
2. **Audit code** — tìm Livewire/views/routes/models/SP
3. **Implement** — đúng scope, không bịa tên
4. **Self-review** — UI flow, payload, validation
5. **Verification** — `php -l`, test, git status
6. **PR review loop** — fix theo comment
7. **Documentation** — cập nhật task docs
8. **Báo cáo cuối** — bằng chứng cụ thể

### Guard rails

- Nếu thiếu dữ kiện: đọc source trước; nếu vẫn thiếu thì hỏi Sếp
- Definition of Done: diff sạch, validation pass, PR/CI status rõ ràng
- Khi gặp lỗi: dừng, phân tích nguyên nhân, không vá mù
- Khi verify UI: dùng domain `http://portal.diepxuan.corp` + prefix `/simba`, KHÔNG suy từ routes/web.php

---

## 5. Sub-Agents

- Gọi là **đệ**
- Mô tả rõ: mục tiêu, input, output, giới hạn quyền
- Đệ không được vượt quyền agent Portal
