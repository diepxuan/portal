# TOOLS.md - Local Notes

File này ghi chú các chi tiết riêng của môi trường Portal. Skill và protocol dùng chung nằm ở nơi khác; file này chỉ giữ thông tin cần thiết cho workspace này.

## Nguyên tắc

- Không lưu bí mật, token, mật khẩu hoặc dữ liệu nhạy cảm.
- Không ghi lại hướng dẫn chung có thể sống trong skill/plugin.
- Khi thêm tool/client mới, ghi rõ phạm vi áp dụng và cách nhận diện.

## simba-docs

- **Mount point:** `simba-docs/`
- **Mục đích:** Toàn bộ tài liệu SimbaSql .NET, là nguồn sự thật domain.
- **Trạng thái:** Readonly.
- **Chi tiết:** `docs/SIMBA-DOCS.md`

## Website Verification & Dev Server

- `http://portal.diepxuan.corp` là local domain đã được cấu hình sẵn và luôn là URL mặc định khi kiểm tra UI/browser E2E cho Portal.
- Agent không được tự start Laravel/Vite dev server (`php artisan serve`, `php artisan serve:dev`, `npm run dev`, `./portal-dev.sh start`) chỉ vì `serve:dev:status` báo stopped hoặc không thấy PID file.
- `serve:dev:status` chỉ phản ánh server do command `serve:dev` quản lý; nó không phải nguồn sự thật về việc `portal.diepxuan.corp` đang phục vụ website qua local domain/proxy.
- Khi cần verify website, dùng domain thật trước, ví dụ:

```bash
curl -I http://portal.diepxuan.corp/simba
```

- Chỉ start/stop/restart dev server khi Sếp yêu cầu rõ ràng hoặc task trực tiếp là xử lý dev-server process. Nếu thật sự cần, phải xin phép Sếp trước và báo rõ lý do.

## Sandbox & Escalation

Mặc định agent chỉ được đọc/ghi trong workspace Portal và các thư mục được môi trường cho phép. Mọi hành động cần quyền ngoài sandbox phải xin phép Sếp trước khi chạy.

### Phân nhóm lệnh theo quyền

**Read-only (KHÔNG cần hỏi Sếp — chạy luôn):**

- `cat`, `head`, `tail`, `less`, `wc`, `file`, `nl` — đọc file
- `ls`, `find`, `tree`, `du`, `stat` — duyệt filesystem
- `grep`, `rg`, `ag`, `awk`, `sed -n` — search/filter
- `diff`, `cmp` — so sánh file
- `git status`, `git log`, `git show`, `git diff`, `git branch -a`, `git remote -v` — git read-only
- `git ls-files`, `git ls-tree` — git read-only
- `php -l`, `vendor/bin/phpunit`, `php artisan route:list`, `php artisan config:show` — PHP read-only
- `curl` GET (không mutate), `gh pr view`, `gh issue view` — API read-only
- `node --version`, `composer --version` — version check
- `date`, `whoami`, `pwd`, `echo` — system info

**Ghi local (KHÔNG cần hỏi Sếp — chạy luôn, nằm trong scope):**

- `mkdir`, `cp`, `mv` trong workspace Portal hoặc thư mục tạm được phép (`/tmp/`, `/slash_tmp/`)
- `sed -i` in-place, `write` tool tạo/sửa file mới trong workspace Portal
- `git checkout -b <new-branch>` — tạo branch mới (local)
- `git add`, `git commit`, `git mv` — staging local
- `composer dump-autoload`, `php artisan config:clear`, `php artisan cache:clear` — local dev
- `vendor/bin/phpunit --testsuite=...` chạy test local
- `npm run build`, `npm run dev` (chỉ khi task yêu cầu build asset local)

**Ghi cần xin phép Sếp (chỉ chạy khi được approval):**

- `git push origin <feature-branch>` — push branch feature lên remote; **chỉ khi Sếp cho lệnh "push đi" / "em tạo PR đi"** (AGENTS.md §5).
- `gh pr create`, `gh pr edit` (PR body/title), `gh api PATCH/POST` cho PR/issue — workflow GitHub; **chỉ khi Sếp cho lệnh "em tạo PR đi"**.
- `gh pr merge <N>`, `gh pr close <N>` — merge/close PR (chỉ khi Sếp ra lệnh "merge" / "close").
- `git push origin main` — push trực tiếp lên main
- `git reset --hard`, `git checkout -- <file>`, `git clean -fd` — phá dữ liệu local
- `git push --force`, `git push --force-with-lease` — force push
- `rm` file lớn, `rm -rf` ngoài `/tmp/` hoặc ngoài workspace
- Lệnh ghi ra ngoài workspace Portal (ngoài `/tmp/`, `/slash_tmp/`, `~`)
- Lệnh cần network ra ngoài GitHub: `composer install/update`, `npm install`, download package, gọi API mutation bên ngoài
- Lệnh mở GUI/browser/app ngoài terminal
- Migration/write DB ngoài phạm vi task
- Lệnh start/stop/restart dev server (`php artisan serve`, `php artisan serve:dev`, `npm run dev`, `./portal-dev.sh start`) — chỉ khi Sếp yêu cầu rõ
- Bất kỳ lệnh nào fail do sandbox/network/permission nhưng vẫn cần chạy để hoàn thành task

### Khi nào phải xin phép Sếp

Tổng quát: mọi lệnh thuộc nhóm **"Ghi cần xin phép"** ở trên, hoặc lệnh fail do sandbox/network/permission nhưng vẫn cần chạy để hoàn thành task.

**Quy tắc khi lệnh gặp lỗi / trả về kết quả không mong muốn:**

- DỪNG, không tự ý retry bằng cách thêm flag hay né sandbox.
- Báo cáo Sếp: lệnh đã chạy, exit code, stderr/output quan trọng, nghi vấn nguyên nhân.
- Xin approval để chạy lại với quyền escalated (`sandbox_permissions: require_escalated` + `justification`).
- Ví dụ: `git push` bị reject non-fast-forward → KHÔNG tự `git pull --rebase` + push lại; báo Sếp trước.

### Cách xin phép

- Không tự ý tìm cách né sandbox.
- Nói rõ lệnh cần chạy, lý do, phạm vi tác động, và rủi ro nếu có.
- Chờ Sếp chấp thuận qua cơ chế approval của tool hoặc trả lời trực tiếp trước khi chạy.
- Dùng cơ chế approval/escalation do runtime hiện tại cung cấp.
- Với Codex: đặt `sandbox_permissions` = `require_escalated` và viết `justification` thành câu hỏi ngắn cho Sếp.
- Với agent/tool khác: dùng cơ chế tương đương nếu có; nếu không có, dừng và hỏi Sếp trực tiếp, không tự chạy ngoài sandbox.

Ví dụ justification tốt:

```text
Sếp cho phép em chạy `git fetch origin` ngoài sandbox để lấy trạng thái PR mới nhất không?
```

```text
Sếp cho phép em chạy `composer install` ngoài sandbox để tải dependency còn thiếu cho test không?
```

### Nguyên tắc sau khi được phép

- Chỉ chạy đúng lệnh/phạm vi đã xin phép.
- Không dùng approval cho hành động khác rộng hơn.
- Báo lại kết quả quan trọng: lệnh đã chạy, pass/fail, file hoặc trạng thái bị ảnh hưởng.
- Không push, tạo PR, merge hoặc thay đổi remote nếu Sếp chưa nói rõ: "Em tạo PR đi" hoặc cho phép tương đương.
