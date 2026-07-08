# Tasks - SimbaSql Asia App Analysis

**Tổng quan:** 338 DLL được decompile, **329 files** (324 task ở root + 2 task ở `phase 1/` + 1 README + 2 `_index.md`).

> **Đối với AI agent:** Đọc §1 → §2 → §4 trước khi làm task. §3 là index tra cứu nhanh, không tự đổi trạng thái task.

---

## 1. Tổng quan trạng thái

### Quy ước phase

- **Phase hiện tại** là các task còn ở root `docs/tasks/`. Mục tiêu của phase này là làm đúng bộ khung cho dự án: task spec, nguồn `simba-docs`, route/menu, Data Access Map, SP/wrapper, phạm vi và tiêu chí kiểm chứng. Tất cả task ở root giữ trạng thái `PENDING` cho đến khi xong phase hiện tại.
- **Phase 1** là thư mục `docs/tasks/phase 1/`. Task được chuyển vào đây sau khi đã xong phase hiện tại. Phase 1 tương lai sẽ tiếp tục hoàn thiện chức năng nghiệp vụ và UI theo task cụ thể.
- Hiện tại chỉ `008` và `117` đã xong phase hiện tại và được chuyển sang `phase 1/`. Các task còn lại giữ nguyên trạng thái chờ hoàn thành.

| Khu vực | Files | Trạng thái |
|---|---:|---|
| Root `docs/tasks/` | 324 | PENDING - đang chờ hoàn thành phase hiện tại |
| `docs/tasks/phase 1/` | 2 | DONE phase hiện tại: 008, 117 |
| **Tổng task** | **326** | 324 PENDING + 2 phase 1 |

### Tổng quan root theo module

| Module | Files | Trạng thái |
|---|---:|---|
| AR — Công nợ phải thu | 16 | PENDING |
| AP — Công nợ phải trả | 4 | PENDING |
| CA — Tiền mặt & Ngân hàng | 13 | PENDING |
| CO — Sản xuất | 19 | PENDING |
| SO — Đơn hàng bán | 47 | PENDING |
| PO — Đơn hàng mua | 19 | PENDING |
| SI — System Integration | 26 | PENDING |
| IN — Tồn kho | 30 | PENDING |
| FA — Tài sản cố định | 39 | PENDING |
| GL — Sổ cái tổng hợp | 103 | PENDING |
| System — Framework & cross-link | 8 | PENDING |
| **Tổng root** | **324** | PENDING |

**Snapshot audit mới nhất (route/menu):** `../project/task-execution-coverage.md`, `../project/remaining-process-shells.md`, `../project/simba-router-menu-matrix.md`.

## 2. Tasks đã chuyển sang phase 1 (2)

| # | Task | Module | PR |
|---|---|---|---|
| 008 | ar-bao-cao-cong-no-tk-kh | AR | phase 1 |
| 117 | in-baocao-tonkho-02 | IN | [#241](https://github.com/diepxuan/portal/pull/241) |

## 3. Index theo module (326 tasks)

> Xem [`_index.md`](_index.md) cho root phase hiện tại và [`phase 1/_index.md`](phase%201/_index.md) cho task đã chuyển phase. Cả hai file sinh tự động từ `scripts/gen-tasks-index.php`.

**Tóm tắt nhanh:**

- Root phase hiện tại: 324 task, toàn bộ `PENDING`.
- Phase 1: 2 task `DONE` phase hiện tại (`008`, `117`).
- Khi thêm hoặc chuyển task, chạy `php scripts/gen-tasks-index.php` để cập nhật `_index.md`.

## 4. Data Access Map bắt buộc cho task SimbaERP

Mỗi task có thao tác dữ liệu SimbaERP cần ghi rõ mapping từ UI sang nguồn `simba-docs`. Hiển thị danh sách, lookup/filter, thêm, sửa, xóa ưu tiên Stored Procedure wrapper theo `sysDAOInfo` và DLL/DAO/procedures. Eloquent/model là phương án thay thế khi đã tra nguồn Simba nhưng chưa có SP phù hợp, kèm ghi chú nguồn tra cứu và lý do.

### Workflow tra cứu nguồn Simba (cho AI agent)

```
1. sysDictionaryInfo.md  → code_name, table, form, fields, lookup/filter
2. sysDAOInfo.md         → get_sp, ins_sp, upd_sp, del_sp
3. DLL/DAO               → xác nhận tham số SP
4. procedures/{MODULE}/  → đối chiếu tham số cuối cùng
5. → Implement wrapper trong StoredProcedures\... hoặc ghi rõ lý do fallback
```

### Template Data Access Map cho task

```markdown
## Data Access Map

| UI/data action | Code name | Simba table | Source | GET SP/wrapper | INS SP/wrapper | UPD SP/wrapper | DEL SP/wrapper | Eloquent/model fallback |
|---|---|---|---|---|---|---|---|---|
| Danh sách/lookup/thêm/sửa/xóa kho | `MA_KHO` | `INDMKHO` | `sysDictionaryInfo` + `sysDAOInfo` | `asINGetDMKHO` / `StoredProcedures\AsINGetDMKHO` | `asINInsDMKHO` / `StoredProcedures\AsINInsDMKHO` | `asINUpdDMKHO` / `StoredProcedures\AsINUpdDMKHO` | `asINDelDMKHO` / `StoredProcedures\AsINDelDMKHO` | Ghi nguồn tra cứu và lý do khi dùng fallback |
```

### Ví dụ đã có

| Task | Module | Bảng | SP |
|---|---|---|---|
| 001 | AR | ARDMKH | AsARGetDMKH / AsARInsDMKH / AsARUpdDMKH / AsARDelDMKH |
| 100 | IN | INDMKHO | AsINGetDMKHO / AsINInsDMKHO / AsINUpdDMKHO / AsINDelDMKHO |

## 5. Cập nhật gần đây

**2026-07-07:**
- Chốt quy ước phase: root `docs/tasks/` là phase hiện tại để dựng đúng bộ khung dự án; xong phase hiện tại thì chuyển task vào `phase 1/`.
- Hiện chỉ `008` và `117` ở `phase 1/`; các task còn lại giữ `PENDING`.
- Đánh lại status cũ ở root về `PENDING` theo quy ước phase mới: `069` (DONE → PENDING), `118/120/123` (FIXED → PENDING — chỉ là fix tên class, chưa xong phase). Lý do: status cũ phản ánh tiến độ kiểu cũ (route/shell exists, class name fix), không tương thích quy ước phase hiện tại.

**2026-07-06:**
- Thêm Task 357 — chuẩn hóa 6 Livewire input components (`input-khachhang`, `input-taikhoan`, `input-indmvt`, `input-indmkho`, `input-indmnhvt`, `input-donvi`) theo chính sách SP wrapper ưu tiên.

**2026-06-05:**
- Bổ sung Task 356 — nhóm ARDMKH (`06.90.02` MA_KH / `10.90.22` MA_NCC / `04.90.05` MA_KH nhân viên).

**2026-05-15:**
- Route/menu matrix cập nhật (`../project/simba-router-menu-matrix.md`). 302 route anchors, 57 menu không route, 48 generic `simba.process` read-only shell.

**2026-05-10:**
- Audit 325 task files (`AUDIT-2026-05-10.md` — snapshot cũ, không còn dùng).

## 6. Quy trình cho AI agent

### Đọc file này khi nào
- Bắt đầu task mới: §1 (tổng quan) → §3 (xem task cùng module) → §4 (Data Access Map)
- Review PR có đụng task: §2 (DONE list) → §3 (index)

### Khi viết/sửa task file
1. Mỗi task file phải có section "Data Access Map" theo template §4
2. Mỗi task file phải có section "Audit Status" cuối file (status + ngày + người audit)
3. Không tự đổi trạng thái DONE trong root `docs/tasks/`
4. Khi task xong phase hiện tại, chuyển file sang `docs/tasks/phase 1/` rồi chạy lại `php scripts/gen-tasks-index.php`
5. Phase 1 là nơi tiếp tục hoàn thiện chức năng nghiệp vụ và UI theo task cụ thể

### Khi implement
- Bắt buộc tra `simba-docs/data/sysDictionaryInfo.md` và `sysDAOInfo.md` trước
- Wrapper ở `diepxuan/laravel-simba/src/StoredProcedures/`
- Không tạo/sửa SQL trực tiếp
- Eloquent chỉ khi có ghi chú lý do trong task file

## 7. Ghi chú

- Task files lưu tại: `docs/tasks/{number}-{prefix}-{slug-title}.md`
- Format ID range: `159-165` = 1 file đại diện cho 7 ID
- Nhân viên ARDMKH = `04.90.05 / MA_KH` (không phải `MA_NV` — đó là nguồn vốn `FADMNV`)
- Ngân hàng khách hàng (Task 034) chưa mở CRUD, còn shell/task docs
- Không có nhóm HR (không tìm thấy DLL prefix `HR*`)

---

*Cập nhật: 2026-07-07 00:00 GMT+7*
*Sinh tự động từ `scripts/gen-tasks-index.php` — xem [`scripts/gen-tasks-index.php`](../../scripts/gen-tasks-index.php)*
