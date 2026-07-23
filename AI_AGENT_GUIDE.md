# AI Agent Guide — Portal Project

> Hướng dẫn ngắn gọn cho **AI agents** làm việc trên repository `diepxuan/portal`.
>
> Nguyên tắc cao nhất: **an toàn > tốc độ**. Khi không chắc chắn → dừng và hỏi.
>
> Ngày cập nhật cuối: 2026-07-22 (session refactor, đồng bộ với AGENTS.md/TOOLS.md/MEMORY.md).

---

## 1. Phạm vi công việc (BẮT BUỘC)

| Được phép | Không được phép (trừ khi Sếp chỉ định rõ) |
|----------|----------------------------------|
| Sửa file trong `diepxuan/`, `docs/`, `MEMORY.md`, `TOOLS.md`, `AI_AGENT_GUIDE.md`, `AGENTS.md`, `SOUL.md`, `USER.md`, `IDENTITY.md` | Sửa `routes/*.php`, `app/`, `bootstrap/`, `config/`, `database/`, `.env`, `.github/` (ngoại trừ workflow Portal mới) |
| Refactor doc trong `diepxuan/*/docs/` | Sync thay đổi sang repo khác (vd 9router, 9panel) — Sếp quyết port, agent KHÔNG tự port |
| Tạo branch mới + commit + push + mở PR cho task được giao | `git push origin main` trực tiếp, `gh pr merge` khi chưa có lệnh Sếp |

> **AI Agent scope: dự án Portal, KHÔNG lan sang project khác** (vd repo `diepxuan/9router` chỉ do Sếp port thủ công).

---

## 2. Boot sequence (đọc trước mỗi task)

Đọc đầy đủ theo thứ tự:

1. `SOUL.md` — bản sắc, nguyên tắc cao nhất.
2. `USER.md` — định danh Sếp, timezone (`Asia/Ho_Chi_Minh`), working style.
3. `TOOLS.md` — local notes + **Sandbox & Escalation** (§Codex CLI) + Website Verification (`http://portal.diepxuan.corp/simba/...`).
4. `memory/<YYYY-MM-DD>.md` (hôm nay) + `memory/<YYYY-MM-DD>.md` (hôm qua) — daily context.
5. `MEMORY.md` — long-term memory (5 sections: §0 quy tắc / §1 PRs / §2 Tasks / §3 lessons / §4 domain / §5 backlog).
6. Nếu task chạm UI/Blade/Livewire/Alpine: `docs/DESIGN.md` — design tokens.
7. Nếu task cần test/URL/dev server: §"Website Verification & Dev Server" trong `TOOLS.md` (base URL `http://portal.diepxuan.corp`, các route nằm dưới prefix `/simba`).

### 2.1. Ngữ cảnh nhanh

- **Portal** là ứng dụng Laravel chính (Laravel 11+).
- **`diepxuan/`** chứa 12 package Laravel nội bộ (`laravel-core`, `laravel-catalog`, `laravel-currency`, `laravel-disreg`, `laravel-eloquent-composite`, `laravel-gmail`, `laravel-log`, `laravel-magento`, `laravel-ronaldjack`, `laravel-scavenger`, `laravel-simba`, `laravel-support`) + 1 package PHP thuần (`php-charset`) — quản lý qua Composer `path` repositories (symlink).
- **Thay đổi trong `diepxuan/*`** ảnh hưởng trực tiếp ứng dụng chính (autoload symlink).
- **Design tokens:** `docs/DESIGN.md` là nguồn sự thật duy nhất (chuẩn Google Labs `design.md` spec). Mọi sửa view/Blade/Livewire/Alpine phải map token → Tailwind class. Cần mở rộng → mở PR riêng cho `docs/DESIGN.md`.
- **Simba docs:** `simba-docs/` mount readonly — nguồn sự thật về table/field/SP. Mọi thao tác Simba ưu tiên SP wrapper; Eloquent chỉ fallback khi không có SP phù hợp.

---

## 3. Quy trình Git bắt buộc

Quy trình 8 bước (Task Completion Cycle, AGENTS.md §6). Mọi task phải qua đủ:

1. Đọc task + source (`simba-docs`, vouchers, SP, DataBinding).
2. Audit code (tìm Livewire/views/routes/models/SP, phân loại đúng/sai/thiếu/thừa).
3. Implement (đúng scope, không bịa tên bảng/SP/field).
4. Self-review (UI actions đầy đủ, flow create/edit/save/delete, payload khớp fields).
5. Verification (`php -l`, phpunit, git diff/status, dọn file thừa).
6. PR review loop (đọc comment, fix đến khi không còn blocker).
7. Documentation (cập nhật task docs, ghi quyết định kỹ thuật).
8. Báo cáo cuối (bằng chứng cụ thể: file đổi, kiểm chứng, PR/CI/merge status).

### 3.1. Trước khi bắt đầu
```bash
git checkout main
git pull origin main
```

Đọc `MEMORY.md` (đặc biệt §0 quy tắc cố định + §3 bài học) — tránh lặp lại lỗi đã học.

### 3.2. Tạo branch
- **Mẫu:** `task/<tên-task-ngắn-gọn>` (lowercase, gạch ngang).
- **KHÔNG** commit trực tiếp lên `main` (AGENTS.md §5).
- Ví dụ: `git checkout -b task/fix-magento-api-auth`.

### 3.3. Làm việc và commit
- Chỉ sửa file trong phạm vi.
- Commit message ngắn gọn: `<package>: mô tả thay đổi` hoặc `docs(<file>): mô tả`.
- Kiểm `php -l` cho file PHP; chạy `phpunit` cho test nếu có.

### 3.4. Push và tạo PR
```bash
git push origin task/<tên-branch>
gh pr create --base main --head task/<tên-branch> --title '...' --body '...'
```

PR title: `[<scope>] Mô tả ngắn`. PR body phải có: file đổi, ảnh hưởng, test steps, bằng chứng.

### 3.5. Merge PR
- **CHỈ merge khi Sếp ra lệnh rõ** (vd "merge PR đi", "em tạo PR đi").
- Lệnh: `gh pr merge <N> --repo diepxuan/portal --squash --delete-branch`.
- Verify sau merge: `gh pr view <N> --json state,mergeCommit.oid` → `state == MERGED`, oid không rỗng.
- **KHÔNG dùng** `git merge --squash` local + `gh pr close` (mất PR state MERGED, mất attribution contributor).

---

## 4. Quy trình phát triển Portal

### 4.1. Khi sửa package trong `diepxuan/`
- Chỉ sửa code trong thư mục package tương ứng.
- Nếu sửa `composer.json` → chạy từ root project: `composer dump-autoload`.

### 4.2. Sau khi sửa file trong `diepxuan/`
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### 4.3. Test
```bash
# Trong 1 package:
cd diepxuan/laravel-<package> && ../../vendor/bin/phpunit

# Toàn bộ từ root:
php artisan test
```

### 4.4. SimbaERP data access policy
- `simba-docs/` nguồn sự thật cho table/field/DLL/DAO/SP.
- Thứ tự tra cứu: `data/sysDictionaryInfo.md` → `data/sysDAOInfo.md` → DLL/DAO → `procedures/{MODULE}/`.
- **Ưu tiên SP wrapper** (`StoredProcedures\...`) cho mọi thao tác Simba (list/lookup/CRUD).
- **Eloquent/model fallback** khi không có SP phù hợp — ghi rõ nguồn đã tra + lý do trong task docs/PR body.

### 4.5. Design system (docs/DESIGN.md)
- Mọi UI mới phải đọc `docs/DESIGN.md` trước.
- Token chính: primary `bg-blue-600`, surface `border border-gray-200 bg-white shadow-sm rounded-lg`, label `text-sm font-medium`, caption `text-xs`.
- **KHÔNG** dùng: `letter-spacing` âm, font-scale theo viewport, palette đơn sắc, custom radius ngoài hệ (`rounded-md/lg/xl/full`).

---

## 5. Tiêu chuẩn mã

- **PHP:** ^8.2, strict types, đầy đủ type hints.
- **Style:** PSR-12, dùng `vendor/bin/pint` hoặc `vendor/bin/php-cs-fixer` (đã có sẵn).
- **Commit message:** ngắn gọn, scope rõ ràng. Không viết thường xuyên "fix bug" mà không mô tả.
- **Backward compatibility:** giữ nguyên public API (class name, namespace, interface, method signature) trừ khi Sếp duyệt.

---

## 6. Debug nhanh

Nếu thay đổi không có hiệu lực:

1. `composer dump-autoload` từ root.
2. `php artisan config:clear && php artisan cache:clear`.
3. Kiểm tra symlink `vendor/diepxuan/` còn trỏ đúng `diepxuan/`.
4. Đọc `storage/logs/laravel.log`.

---

## 7. Khi gặp vấn đề

| Tình huống | Hành động |
|------------|----------|
| Không chắc thay đổi an toàn | Dừng, hỏi Sếp. |
| Phát hiện bug ngoài task | Ghi note trong PR description, KHÔNG sửa ngoài scope. |
| Cần sửa file ngoài `diepxuan/` | Xin phép Sếp rõ ràng bằng văn bản. |
| Lệnh fail do sandbox/network | DỪNG, báo Sếp, KHÔNG tự retry bằng flag. |
| Token `gh` hết hạn / lỗi xác thực | Dừng, báo Sếp theo TOOLS.md §5. |
| Phân biệt local vs network command | `gh auth status` đọc local, `gh api`/`gh pr` hit network. Test `gh api /octocat` trước khi mutation. |

---

## 8. Nguyên tắc an toàn (Definition of Done cho task nhỏ)

- [ ] Diff sạch, không có file thừa (untracked, backup, `.bak`, `.tmp`).
- [ ] Validation pass cho form/CRUD.
- [ ] Test pass cho unit test trong phạm vi.
- [ ] PR mở đúng base = `main`, đúng head = branch `task/...`.
- [ ] CI check pass (nếu có — docs PR docs-only không cần).
- [ ] MEMORY.md cập nhật nếu có bài học mới.
- [ ] Task doc (`docs/tasks/...`) tick `[x]` cho mục liên quan.

Cho task lớn: thêm Verification checklist + báo cáo cuối rõ ràng cho Sếp.

---

## 9. TL;DR cho AI agent mới

- **Scope**: CHỈ sửa `diepxuan/`, KHÔNG sync sang project khác.
- **Mỗi thư mục = 1 package** với cấu trúc Laravel chuẩn.
- **Workflow**: đọc task → tạo branch → sửa → commit → push → PR → chờ review.
- **Boot**: đọc `MEMORY.md` + `TOOLS.md` trước mỗi task lớn.
- **Design**: `docs/DESIGN.md` cho UI.
- **Simba**: `simba-docs/` + SP wrapper, Eloquent fallback.
- **Merge**: chỉ khi Sếp bảo, dùng `gh pr merge --squash --delete-branch`.
- **An toàn**: khi không chắc → dừng + hỏi, KHÔNG tự retry né sandbox.

---

## 10. Tham chiếu nhanh

| Tài liệu | Vai trò | Đọc khi nào |
|---------|---------|------------|
| `AGENTS.md` | Định danh + nguyên tắc agent | Boot sequence §1-2 |
| `SOUL.md` | Bản sắc + nguyên tắc cao nhất | Boot §1 |
| `USER.md` | Định danh Sếp + timezone + working style | Boot §2 |
| `TOOLS.md` | Local notes + Sandbox + Website Verification | Boot §3, mỗi task có lệnh |
| `MEMORY.md` | Long-term memory (PRs, lessons, domain) | Boot §5, trước task lớn |
| `docs/DESIGN.md` | Design tokens + UI patterns | Task UI |
| `docs/DEVELOPMENT.md` | Quy trình phát triển Portal | Setup môi trường |
| `docs/SIMBA-DOCS.md` | Hướng dẫn dùng `simba-docs/` | Task Simba |
| `docs/tasks/*.md` | Task docs theo từng DLL/voucher | Audit task hiện tại |
| `simba-docs/` (readonly) | Source thật SimbaSql .NET | Tra table/SP/field |

---

*Tài liệu này cập nhật lần cuối: 2026-07-22. Mọi AI agent làm việc trên repository `diepxuan/portal` phải tuân thủ các quy tắc trên.*
