# TOOLS.md - Local Notes

File này ghi chú các chi tiết riêng của môi trường Portal. Skill và protocol dùng chung nằm ở nơi khác; file này chỉ giữ thông tin cần thiết cho workspace này.

## Nguyên tắc

- Không lưu bí mật, token, mật khẩu hoặc dữ liệu nhạy cảm.
- Không ghi lại hướng dẫn chung có thể sống trong skill/plugin.
- Khi thêm tool/client mới, ghi rõ phạm vi áp dụng và cách nhận diện.

## SSH Hosts

### Development Servers

- **web** -> `ssh root@web`
  - Portal development server.
  - Chứa dữ liệu gần production phục vụ development.

### Database Connections

- **Portal Database:** SQL Server trên `web`.

### Notes

- SSH key: `~/.ssh/id_rsa`
- Default port: `22`
- Dùng `ssh root@web` khi cần truy cập trực tiếp.

## simba-docs

- **Mount point:** `simba-docs/`
- **Mục đích:** Toàn bộ tài liệu SimbaSql .NET, là nguồn sự thật domain.
- **Trạng thái:** Readonly.
- **Chi tiết:** `docs/SIMBA-DOCS.md`

<!-- AIGHT-CLIENT-START v=8 -->
## Aight Client Notes

Các ghi chú dưới đây chỉ áp dụng khi message đến từ Aight iOS app hoặc hosted Aight control UI.

### Nhận diện

- Aight iOS: `clientId = "openclaw-ios"`
- Hosted control UI: `clientId = "openclaw-control-ui"`
- Connect frame có `displayName = "Aight"`

Nếu message không đến từ client trên, bỏ qua toàn bộ section Aight.

### Chat, Voice, Images

- Inbound voice đã được app chuyển thành text trước khi gửi vào gateway.
- Outbound luôn trả plain text; app tự text-to-speech khi user bật voice mode.
- Không dùng TTS tool và không gửi audio file cho Aight client.
- Khi gửi ảnh, ưu tiên tool trả image bytes inline.
- Nếu tool chỉ ghi file, file phải nằm trong `~/.openclaw/media/` hoặc legacy `~/.clawdbot/media/`, rồi trả mỗi file bằng một dòng `MEDIA: <path>`.
- Không inline base64 image data.

### Task Follow-Up

- Không fire-and-forget khi giao việc async.
- Nếu chỉ cần kết quả sub-agent ở lượt kế tiếp, dùng `sessions_yield`.
- Nếu cần theo dõi hoặc điều hướng sub-agent, dùng `subagents` với `list`, `steer`, hoặc `kill`.
- Chỉ dùng cron watchdog cho external async work, group-chat coordination, hoặc việc cần kiểm tra theo thời gian.
- Worker phải claim task ngay, báo blocker nhanh, và báo completion với commit/change/next step.

### Group Chat

- Message group chat có prefix dạng `[Group Chat: "Name" - Members: ...]`.
- Muốn nói với agent khác thì `@mention` trực tiếp trong text; không dùng `sessions_send`.
- Recent messages là context; `[Your turn]` đánh dấu message mới cần xử lý.
- Trong group task: claim ngay, báo blocker dưới 2 phút, không để task im lặng quá 5 phút, và báo completion không cần chờ hỏi.
<!-- AIGHT-CLIENT-END -->
