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

Ví dụ justification tốt — xem §2 ở mục Codex CLI bên dưới (3 ví dụ tốt + 3 ví dụ xấu với lý do từ chối).

### Nguyên tắc sau khi được phép

- Chỉ chạy đúng lệnh/phạm vi đã xin phép.
- Không dùng approval cho hành động khác rộng hơn.
- Báo lại kết quả quan trọng: lệnh đã chạy, pass/fail, file hoặc trạng thái bị ảnh hưởng.
- Không push, tạo PR, merge hoặc thay đổi remote nếu Sếp chưa nói rõ: "Em tạo PR đi" hoặc cho phép tương đương.

## Codex CLI — cú pháp CMD cụ thể để escalate lệnh

> Áp dụng cho runtime hiện tại của agent Portal: **Codex CLI** (`@openai/codex@0.142.0`, profile `ninerouter`) chạy dưới **OpenClaw gateway** (`openclaw@2026.6.8`, port `18789`). Cập nhật 2026-07-21 dựa trên tình trạng runtime quan sát được.
>
> Mục đích: 9router agent đọc TOOLS.md này để hiểu cách Portal agent escalate lệnh ngoài sandbox — từ đó thống nhất cơ chế giữa hai project.

### 1. Nhận diệt runtime đang chạy

Trước khi escalate, luôn xác định runtime đang chạy. Lệnh read-only, chạy được không cần approval:

```bash
# env hints
env | grep -iE 'codex|openclaw|hermes' | sed 's/=.*$/=***/' | sort -u

# running process
ps -ef | grep -iE 'codex|openclaw|hermes' | grep -v grep | awk '{print $NF}' | sort -u

# filesystem marker
for d in /root/.codex /root/.openclaw /root/.hermes /root/.claude; do
  [ -d "$d" ] && echo "FOUND: $d" || echo "MISS : $d"
done

# init / launcher
cat /proc/1/cmdline 2>/dev/null | tr '\0' ' '; echo
```

| Runtime    | Env đặc trưng                                                                                  | Process                                                                                            | Filesystem marker                                    |
| ---------- | ---------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------- | ---------------------------------------------------- |
| Codex CLI  | `CODEX_THREAD_ID`, `CODEX_CI`, `CODEX_MANAGED_BY_NPM`, `CODEX_SANDBOX_NETWORK_DISABLED`        | `bwrap ... --argv0 codex-linux-sandbox` (runtime hiện tại) HOẶC `node .../@openai/codex/bin/codex.js --profile <name>` HOẶC vendor binary `codex`                  | `/root/.codex/` (auth.json, config.toml, history.jsonl, sessions/) |
| OpenClaw   | (gateway env nếu có), port 18789, Chromium headless                                            | `node .../openclaw/dist/index.js gateway --port 18789`                                              | `/root/.openclaw/` (browser/, socket, workspace index) |
| Hermes     | `HERMES_TUI_THEME` (chỉ theme, KHÔNG đủ để khẳng định), `HERMES_*` khác                       | `python -m hermes_cli.main gateway run`                                                            | `/root/.hermes/` (.env, .hermes_history, auth.json, SOUL.md) |
| Khác       | Không khớp 3 dòng trên                                                                          | Không khớp                                                                                          | Không khớp                                            |

Nếu không khớp 3 runtime trên: dừng, hỏi Sếp trước khi chạy bất kỳ lệnh ngoài sandbox nào.

### 2. Cú pháp escalate lệnh cho Codex CLI

Đây là cú pháp cụ thể khi gọi tool có hỗ trợ sandbox (vd `exec_command`, `write_stdin`):

```
sandbox_permissions: require_escalated
justification: <câu hỏi ngắn cho Sếp>
```

**Quy tắc viết `justification`:**

- Câu ngắn, 1 dòng, bằng tiếng Việt, xưng "em", gọi "Sếp".
- Nêu rõ: lệnh cần chạy, lý do, phạm vi tác động.
- Format: `Sếp cho phép em chạy '<lệnh đầy đủ>' ngoài sandbox để <mục đích cụ thể> không?`
- Văn bản thuần (plain text): KHÔNG kèm markdown, code fence, ký tự escape hay định dạng phức tạp — runtime đọc thẳng làm UI prompt cho Sếp duyệt.
- KHÔNG viết justification dài dòng, KHÔNG kèm flag phụ không cần thiết.

**Ví dụ justification tốt:**

```text
Sếp cho phép em chạy `gh pr view 43 --repo diepxuan/9router --json title,body,files` ngoài sandbox để lấy metadata PR trước khi viết patch update TOOLS.md không?
```

```text
Sếp cho phép em chạy `git push origin feature/runtime-detection` ngoài sandbox để push branch sau khi Sếp nói "push đi" không?
```

```text
Sếp cho phép em chạy `composer require spatie/laravel-permission --no-interaction` ngoài sandbox để cài package cho task ACL không?
```

**Ví dụ justification XẤU (từ chối):**

```text
# Quá ngắn — thiếu lệnh và lý do
Sếp cho phép em chạy lệnh không?

# Có flag thừa — nghi ngờ né sandbox
Sếp cho phép em chạy `curl --insecure https://api.github.com --resolve api.github.com:443:127.0.0.1` không?

# Hành động rộng hơn lệnh đã xin
Sếp cho phép em chạy `rm -rf /tmp/* && git clone ... && git push` không?
```

### 3. Bốn phương án thực thi lệnh ngoài sandbox

Áp dụng theo thứ tự ưu tiên. Runtime hiện tại (Codex CLI + OpenClaw) hỗ trợ đầy đủ Phương án A.

| Phương án | Cơ chế                                                                                              | Ưu                                            | Nhược                                                       | Khi nào dùng                                                              |
| --------- | --------------------------------------------------------------------------------------------------- | --------------------------------------------- | ----------------------------------------------------------- | ------------------------------------------------------------------------- |
| **A — Escalation per-command** | Đặt `sandbox_permissions: require_escalated` + `justification` (xem §2). Runtime hiển thị UI approval cho Sếp bấm duyệt. | An toàn nhất, audit rõ, không cần đổi hạ tầng | Chậm khi nhiều lệnh; đòi hỏi runtime có cơ chế escalate    | **Mặc định.** Thỉnh thoảng cần `gh pr view`, `git push origin <branch>`, `composer require`. |
| **B — Out-of-band proxy**      | Sếp cấp HTTP/SOCKS proxy, export `HTTPS_PROXY`/`HTTP_PROXY`/`ALL_PROXY`. `gh`/`curl`/`composer`/`npm` đi qua proxy có log/audit. | Giải quyết triệt để egress                    | Cần Sếp cấu hình proxy + token mới; proxy down thì agent tê cứng | Agent hay cần `gh`, `composer install`, `npm install`, gọi CI. **Chưa có trong hạ tầng hiện tại.** |
| **C — Out-of-sandbox runner**  | Sếp chạy agent trên máy có đầy đủ network (gateway DiepXuan, máy Sếp, container `network_mode: host`). | Tool nào cũng chạy được                       | Rời khỏi guard rail workspace                              | Cần mở PR từ máy Sếp, chạy CI local, tool chỉ chạy ngoài sandbox.        |
| **D — Human-in-the-loop**      | Agent soạn script/lệnh + giải thích ngắn, ghi `memory/cmd-requests/<ts>.sh`. Sếp copy/paste chạy trên máy Sếp rồi paste output về cho agent. | Zero infra, an toàn nhất                      | Agent phải dừng chờ; tốc độ rất thấp                       | Chỉ 1-2 lệnh/ngày; Sếp không muốn cấp proxy. **Hiện đang dùng cho mọi lệnh `gh` vì token hết hạn.** |

**Quy trình chuẩn:**

1. Thử Phương án A — viết justification, gọi tool với `sandbox_permissions: require_escalated`, chờ Sếp duyệt.
2. Nếu runtime không hỗ trợ escalation → fallback Phương án D (nhờ Sếp chạy tay).
3. Nếu Sếp chủ động bật proxy → chuyển sang Phương án B.
4. Nếu task đặc biệt cần máy ngoài sandbox → Phương án C, do Sếp quyết.

### 4. Triệu chứng sandbox chặn egress (đã quan sát 2026-07-21)

Triệu chứng thực tế của runtime `ninerouter` trong phiên này, ghi để session sau debug nhanh:

- `env | grep CODEX_SANDBOX_NETWORK_DISABLED` → có giá trị (network mặc định tắt).
- `curl -sS -o /dev/null -w "%{http_code}\n" https://api.github.com` → `000` + `Could not resolve host: api.github.com` (DNS fail).
- `gh pr view <N> --repo <owner>/<repo>` → `error connecting to api.github.com`.
- `gh auth status` → nếu PASS, token vẫn live (xem token scopes + last refresh). Nếu `authentication failed`, dừng và báo Sếp theo §5.
- `git clone https://github.com/<owner>/<repo>.git` → lúc chạy được, lúc fail DNS — không ổn định. Ưu tiên `gh repo clone` (có token xác thực, bỏ qua DNS resolution qua giao thức HTTPS).

**Quy tắc khi gặp các triệu chứng trên:**

1. DỪNG, không retry bằng cách thêm flag hay đổi env.
2. Báo Sếp: lệnh đã chạy, exit code, stderr ngắn, nghi vấn nguyên nhân.
3. Xin approval Phương án A (§2) với justification rõ ràng.
4. Sau khi Sếp duyệt: chỉ chạy đúng lệnh đã xin, không mở rộng phạm vi.
5. Báo lại kết quả: file đổi, exit code, output cần thiết.

### 5. Token hygiene (GitHub CLI)

- Token lưu tại `/root/.config/gh/hosts.yml`. Xoay vòng bằng `gh auth login --with-token < new-token.txt` (xoá file sau khi dùng).
- **KHÔNG tự `gh auth login`** khi gặp `authentication failed` — dừng và báo Sếp. Sếp cấp token mới qua channel an toàn.
- Token scope khuyến nghị cho agent Portal: `repo`, `read:org`, `workflow`. Expiration ≤ 30 ngày.
- Không commit token, không in ra log, không paste vào file trong workspace (kể cả `/tmp/`).

### 6. Tham chiếu chéo giữa Portal và 9router

- Portal: file này (mục Codex CLI) + `AGENTS.md` §6 (Task Completion Cycle, Guard rails).
- 9router: tham khảo file tương đương ở repo [`diepxuan/9router`](https://github.com/diepxuan/9router) (TOOLS.md, AGENTS.md) — Sếp đang port protocol từ Portal sang 9router để hai agent dùng chung quy tắc.
- Khi protocol ở 1 repo đổi, Sếp quyết định có port sang repo kia hay không; agent KHÔNG tự port.
