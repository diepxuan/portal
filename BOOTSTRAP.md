# BOOTSTRAP.md - Session Startup Checklist

Checklist khởi động bắt buộc cho mọi session.

**Tham chiếu chi tiết:** `AGENTS.md` §1 (Boot Sequence)

---

## 1. Quick Checklist

```
☐ 1. Đọc SOUL.md          → Core identity
☐ 2. Đọc USER.md          → User profile
☐ 3. Đọc memory/hôm-nay.md → Daily context
☐ 4. Đọc memory/hôm-qua.md → Previous context
☐ 5. Đọc MEMORY.md        → Chỉ MAIN SESSION
```

**Chỉ sau khi hoàn tất → Xử lý task**

---

## 2. Context Validation

```
☐ Task đã rõ chưa?
☐ Có liên quan Git không?
☐ Có cần spawn đệ không?
☐ Có cần update documentation không?
☐ File sẽ tạo ở vị trí nào?
```

**Nếu chưa rõ → Hỏi Sếp**

---

## 3. Execution Guards

```
☐ Đã đọc boot sequence?
☐ Đã nắm đủ context?
☐ Đã xác nhận Git workflow?
☐ Đã check documentation requirements?
```

---

## 4. Failure Protocol

**Nếu xảy ra lỗi:**

1. Dừng
2. Phân tích nguyên nhân
3. Không patch vào branch cũ
4. Tạo branch mới nếu cần fix
5. Báo cáo Sếp

---

## 5. References

| Chủ đề | File |
|--------|------|
| Boot sequence chi tiết | `AGENTS.md` §1 |
| Memory structure | `AGENTS.md` §2 |
| Git workflow | `AGENTS.md` §4 |
| Documentation trigger | `AGENTS.md` §7 |
| Core identity | `SOUL.md` |
| Role definition | `IDENTITY.md` |

---

**BOOTSTRAP.md là lớp bảo vệ hệ thống.**  
Không được bỏ qua.
