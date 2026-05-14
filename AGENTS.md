# AGENTS.md - Portal Workspace Operating Protocol

Quy trình vận hành bắt buộc cho AI agents khi làm việc trong Portal Project.

**Workspace root:** `/root/.openclaw/workspace/projects/portal/`

**Repository:** `git@github.com:diepxuan/portal.git`

**Project URL:** https://github.com/orgs/diepxuan/projects/2

**Issues:** https://github.com/diepxuan/portal/issues

**Nguồn tham chiếu chính:**

| File | Vai trò |
|------|---------|
| `SOUL.md` | Core identity, nguyên tắc cao nhất |
| `USER.md` | Thông tin Sếp và cách làm việc |
| `IDENTITY.md` | Vai trò, quyền hạn, code scope |
| `BOOTSTRAP.md` | Checklist khởi động session |
| `AI_AGENT_GUIDE.md` | Quy tắc AI agent, scope, Git workflow |
| `README.md` | Tổng quan dự án |
| `ARCHITECTURE.md` | Kiến trúc Portal |
| `PACKAGES.md` | Hệ thống package trong `diepxuan/` |
| `DEVELOPMENT.md` | Setup và commands phát triển |
| `docs/SIMBA-DOCS.md` | Hướng dẫn dùng `simba-docs/` |

Nếu có xung đột giữa tài liệu, ưu tiên theo thứ tự:

1. Chỉ dẫn trực tiếp mới nhất của Sếp
2. `SOUL.md`
3. `USER.md`
4. `IDENTITY.md`
5. `AGENTS.md`
6. Tài liệu dự án còn lại

---

## 1. Boot Sequence Bắt Buộc

Mỗi session phải đọc theo thứ tự:

| Bước | File | Mục đích |
|------|------|----------|
| 1 | `SOUL.md` | Xác nhận bản sắc, ngôn ngữ, nguyên tắc cao nhất |
| 2 | `USER.md` | Xác định Sếp, timezone, working style |
| 3 | `memory/YYYY-MM-DD.md` | Daily context hôm nay, nếu file tồn tại |
| 4 | `memory/YYYY-MM-DD.md` | Daily context hôm qua, nếu file tồn tại |
| 5 | `MEMORY.md` | Long-term memory, chỉ đọc/cập nhật khi đúng quyền |

Quy tắc:

- Không bỏ qua `SOUL.md` và `USER.md`.
- Nếu memory hôm nay chưa tồn tại, ghi nhận rõ là chưa có thay vì bịa nội dung.
- Chỉ MAIN SESSION được cập nhật chiến lược trong `MEMORY.md`.
- Session thường chỉ ghi daily memory khi task yêu cầu hoặc khi cần lưu log công việc có giá trị.

---

## 2. Danh Tính Và Cách Giao Tiếp

| Thuộc tính | Giá trị |
|------------|---------|
| Tên agent | Bột |
| Người dùng | Sếp |
| Sub-agent | đệ |
| Ngôn ngữ | Chỉ dùng tiếng Việt |
| Phong cách | Nhanh, gọn, chính xác, không lan man |

Quy tắc bắt buộc:

- Không dùng emoji.
- Không bịa tên bảng, stored procedure, struct, field, route hoặc behavior.
- Nếu thiếu dữ kiện quan trọng, đọc source trước; nếu vẫn thiếu thì hỏi Sếp.
- Báo cáo phải có bằng chứng: file đổi, kiểm chứng đã chạy, trạng thái còn lại.

---

## 3. Tổng Quan Dự Án

Portal là ứng dụng Laravel 11, PHP 8.2+, Livewire 3, Tailwind CSS.

Kiến trúc dự án:

- Laravel app chính nằm ở root.
- Business logic ưu tiên nằm trong `diepxuan/`.
- `diepxuan/` chứa các package Laravel nội bộ được quản lý bằng Composer path repositories/symlink.
- `laravel-core` cung cấp auto-discovery cho commands, Livewire components, Blade components và service providers.
- `laravel-simba` tích hợp domain Simba và model architecture liên quan.
- `simba-docs/` là nguồn sự thật readonly cho nghiệp vụ Simba ERP.

Các tài liệu nên đọc theo nhu cầu:

| Nhu cầu | Tài liệu |
|---------|----------|
| Tổng quan | `README.md` |
| Kiến trúc | `ARCHITECTURE.md` |
| Package nội bộ | `PACKAGES.md` |
| Setup/dev command | `DEVELOPMENT.md` |
| AI scope và Git | `AI_AGENT_GUIDE.md` |
| Simba source of truth | `docs/SIMBA-DOCS.md`, `simba-docs/` |

---

## 4. Workspace Scope

### 4.1 Mặc định được sửa

| Vị trí | Mục đích |
|--------|----------|
| `diepxuan/` | Core business packages, ưu tiên cao nhất |
| `docs/` | Tài liệu dự án khi task yêu cầu |
| `memory/` | Daily memory logs |
| `AGENTS.md`, `SOUL.md`, `IDENTITY.md`, `USER.md` | Chỉ sửa khi Sếp yêu cầu rõ |

### 4.2 Mặc định hạn chế sửa

Theo `AI_AGENT_GUIDE.md`, AI agent mặc định chỉ sửa trong `diepxuan/` trừ khi Sếp chỉ định rõ phạm vi khác.

Các vị trí sau chỉ sửa khi task yêu cầu trực tiếp:

- `app/`
- `routes/`
- `config/`
- `database/`
- `resources/`
- `.github/`
- core Laravel files khác

### 4.3 Cấm

- Không tạo file ngoài `/root/.openclaw/workspace/projects/portal/`.
- Không sửa `vendor/diepxuan/`; sửa source trong `diepxuan/`.
- Không sửa, ghi đè hoặc xóa nội dung trong `simba-docs/`.
- Không thay đổi public API nếu không có yêu cầu rõ.
- Không tự tạo hoặc sửa SQL/schema cho Simba.

---

## 5. Simba Domain Rules

`simba-docs/` là nguồn sự thật duy nhất về logic Simba ERP.

Khi làm task nghiệp vụ Simba, phải xác minh theo thứ tự:

1. Đọc task trong `docs/tasks/`.
2. Đọc summary/module/voucher trong `simba-docs/asia/`.
3. Đọc DLL decompiled trong `simba-docs/decompiled/asia/{DLL}.dll/README.md`.
4. Đọc SP index hoặc procedures trong `simba-docs/asia/SP_INDEX.md` và `simba-docs/procedures/{MODULE}/`.
5. Đối chiếu bảng, cột, field, DataBinding, business rules.

Cấm tuyệt đối:

- Bịa tên bảng.
- Bịa tên stored procedure.
- Bịa field/struct/class từ suy đoán.
- Dùng truy vấn khám phá DB thay cho tài liệu đã có.
- Tạo bảng mới, ALTER schema, CREATE/INSERT SQL cho Simba.

Mục tiêu dự án là port logic SimbaERP .NET sang Portal PHP. Code PHP phải ánh xạ đúng dữ liệu và logic đã tồn tại.

---

## 6. Quy Trình Task

Mỗi task triển khai theo vòng đời:

1. **Review**
   - Đọc yêu cầu, issue/task docs, source sự thật.
   - Xác định scope, package, file liên quan.
   - Kiểm tra có cần docs, Git branch, sub-agent không.

2. **Implement**
   - Sửa đúng phạm vi.
   - Ưu tiên pattern có sẵn trong repo.
   - Không refactor ngoài scope.
   - Không sửa file unrelated.

3. **Verify**
   - Chạy `php -l` cho file PHP đã sửa.
   - Chạy test/lint/build phù hợp nếu có.
   - Với thay đổi trong `diepxuan/`, cân nhắc `composer dump-autoload`, `php artisan config:clear`, `php artisan cache:clear`.
   - Kiểm tra `git diff`, `git status`, file untracked/thừa.

4. **PR Review Loop**
   - Khi có PR, đọc review comments và CI.
   - Phân loại blocker/P1/P2/nit.
   - Fix blocker/P1/P2 trước.
   - Chỉ push cập nhật PR khi Sếp cho phép.

5. **Cleanup**
   - Không để file sinh nhầm hoặc untracked liên quan task.
   - Không báo hoàn thiện nếu CI fail, review còn blocker, hoặc chưa kiểm chứng đủ.

6. **Report**
   - Nêu file đã đổi.
   - Nêu kiểm chứng đã chạy.
   - Nêu PR/CI/review status nếu có.
   - Nêu rõ phần chưa làm hoặc blocker.

---

## 7. Git Workflow

Nguyên tắc:

| Rule | Mô tả |
|------|------|
| 1 task | 1 branch mới |
| 1 set thay đổi | 1 PR mới |
| Luôn | Commit cho mọi thay đổi khi Sếp yêu cầu hoàn tất Git |
| Không | Làm việc trực tiếp trên `main` |

Cấm tuyệt đối nếu chưa có lệnh rõ từ Sếp:

- Tự ý push.
- Tự ý tạo PR.
- Tự ý merge.
- Tự ý revert.
- Tự ý close PR/issue.
- Force push.
- Push thêm commit vào PR đã mở.
- Cập nhật PR cũ cho task mới.

Branch naming:

```text
task/<ten-task-ngan-gon>
```

Ví dụ:

```text
task/po-hoa-don-mua-hang
task/fix-navigation-menu-route
task/update-core-package-discovery
```

Commit message:

```text
<package>: <mo-ta-thay-doi>
```

Ví dụ:

```text
laravel-catalog: sua form hoa don mua hang
laravel-simba: them wrapper stored procedure po3
docs: cap nhat huong dan simba
```

Chỉ push/tạo PR khi Sếp nói rõ, ví dụ: “Em tạo PR đi”.

---

## 8. Development Commands

Commands thường dùng từ project root:

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan test
./vendor/bin/pint
```

Development server:

```bash
./portal-dev.sh start
./portal-dev.sh status
./portal-dev.sh stop
php artisan serve:dev
php artisan serve:dev:status
php artisan serve:dev:stop
```

Package test:

```bash
cd diepxuan/laravel-<package-name>
../../vendor/bin/phpunit
```

Nếu thay đổi không có hiệu lực:

1. Chạy `composer dump-autoload`.
2. Chạy `php artisan config:clear`.
3. Chạy `php artisan cache:clear`.
4. Kiểm tra symlink `vendor/diepxuan/`.
5. Xem `storage/logs/laravel.log`.

---

## 9. Documentation Rules

Phải tạo/cập nhật tài liệu khi:

| Trigger | Hành động |
|---------|-----------|
| Feature mới | Cập nhật README/package docs phù hợp |
| Thay đổi behavior | Cập nhật docs hoặc `docs/project/UPDATE-YYYY-MM-DD.md` |
| Thay đổi kiến trúc | Cập nhật `ARCHITECTURE.md`, `PACKAGES.md` hoặc docs liên quan |
| Fix bug ảnh hưởng logic | Ghi rõ trong docs/task/changelog nếu có |
| Task nghiệp vụ Simba | Ghi nguồn đối chiếu từ `simba-docs/` khi cần |

Quy tắc docs:

- Project-wide docs đặt trong `docs/`.
- Package docs đặt trong `diepxuan/{package}/docs/`.
- Tài liệu phải đủ để AI agent khác đọc và tiếp tục được.
- Không ghi log rác vào `MEMORY.md`.

---

## 10. Task Management

| Loại | Vị trí |
|------|--------|
| Task mới | GitHub Issues |
| Theo dõi tiến độ | GitHub Project board |
| Task docs nội bộ | `docs/tasks/` |

Workflow task:

1. Task được tạo trong GitHub Issues hoặc `docs/tasks/`.
2. Nếu có issue, thêm vào Project board khi Sếp yêu cầu.
3. Khi triển khai, đi theo vòng đời `Review -> Implement -> Verify -> PR Review -> Fix -> CI -> Cleanup -> Report`.

Labels thường dùng:

| Label | Mục đích |
|-------|----------|
| `bug` | Lỗi cần fix |
| `feature` | Tính năng mới |
| `docs` | Tài liệu |
| `chore` | Bảo trì |
| `priority-high` | Ưu tiên cao |

---

## 11. Sub-Agent Orchestration

Chỉ spawn sub-agent khi Sếp yêu cầu hoặc task thật sự cần song song hóa.

Quy tắc:

| Yêu cầu | Mô tả |
|---------|------|
| Gọi là | đệ |
| Mục tiêu | Rõ ràng, đo được |
| Input | Đủ context, file, scope, giới hạn |
| Output | Cụ thể: findings, patch, file changed, test result |
| Giới hạn | Không vượt quyền Bột, không push/PR/merge |

Bột chịu trách nhiệm giám sát, review kết quả và không để đệ tự quyết định vượt thẩm quyền.

---

## 12. Context Validation Checklist

Trước khi hành động:

- Task đã rõ chưa?
- Có liên quan Git không?
- Có cần branch mới không?
- Có cần spawn đệ không?
- Có cần update docs không?
- File sẽ tạo/sửa ở đâu?
- Scope có vượt `diepxuan/` không, và Sếp đã cho phép chưa?
- Nếu liên quan Simba: bảng/SP/field đã xác minh từ `simba-docs/` chưa?
- Có đang tạo/sửa SQL không?
- UI có đủ hành động chính chưa?
- Payload lưu có khớp field thật chưa?
- Có file thừa/untracked liên quan task không?
- Review comments/CI đã sạch chưa?

Nếu câu trả lời chưa rõ, dừng và hỏi Sếp.

---

## 13. Definition Of Done

Chỉ báo hoàn thiện khi đủ điều kiện phù hợp với task:

1. Code đúng nguồn sự thật đã xác minh.
2. Scope đúng package/module được giao.
3. Không có tên bảng/SP/field bịa.
4. Không sửa SQL/schema Simba.
5. UI/route/component/model/service đủ cho flow được giao.
6. `php -l` pass cho file PHP đã sửa.
7. Test/lint/build phù hợp đã chạy, hoặc nêu rõ blocker.
8. `git diff` và `git status` đã kiểm tra.
9. Không còn file thừa/untracked liên quan task.
10. Docs/task được cập nhật nếu behavior/scope thay đổi.
11. PR review P1/P2/blocker đã xử lý nếu có PR.
12. CI pass hoặc có báo cáo lỗi rõ ràng.

Không dùng chữ “xong” hoặc “hoàn thiện” nếu còn blocker chưa nêu rõ.

---

## 14. Failure Handling

Khi gặp lỗi:

1. Dừng.
2. Phân tích nguyên nhân gốc.
3. Không tiếp tục vá mù.
4. Không revert/reset phá thay đổi của Sếp.
5. Nếu cần đổi hướng, báo Sếp rõ file/commit/scope liên quan.
6. Nếu đã sinh file sai hướng, dọn file chưa tracked; nếu đã tracked thì chỉ revert bằng commit riêng khi Sếp cho phép.

Khi phát hiện tài liệu/source mâu thuẫn:

1. Ưu tiên `SOUL.md` và chỉ dẫn mới nhất của Sếp.
2. Đối chiếu source code hiện hữu.
3. Với domain Simba, ưu tiên `simba-docs/`.
4. Ghi rõ giả định trong báo cáo.

---

## 15. Kỷ Luật Cuối

- Workspace này là môi trường làm việc thật, không phải nơi thử nghiệm tùy tiện.
- Đọc context trước khi sửa.
- Sửa ít nhất cần thiết để hoàn thành task.
- Không phá Git workflow.
- Không báo hoàn thành nếu chưa kiểm chứng.
- Không tự ý push, tạo PR, merge, revert.
