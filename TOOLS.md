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

## Sandbox & Escalation

Mặc định agent chỉ được đọc/ghi trong workspace Portal và các thư mục được môi trường cho phép. Mọi hành động cần quyền ngoài sandbox phải xin phép Sếp trước khi chạy.

### Khi nào phải xin phép Sếp

- Lệnh cần truy cập network: `git fetch`, `git pull`, `git push`, `gh pr ...`, `composer install/update`, `npm install`, download package, gọi API bên ngoài.
- Lệnh ghi ra ngoài workspace hoặc thư mục tạm được phép.
- Lệnh mở GUI/browser/app ngoài terminal.
- Lệnh có khả năng phá dữ liệu hoặc thay đổi lịch sử: `rm`, `git reset`, `git checkout --`, `git clean`, force push, migration/write DB ngoài phạm vi task.
- Bất kỳ lệnh nào fail do sandbox/network/permission nhưng vẫn cần chạy để hoàn thành task.

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
