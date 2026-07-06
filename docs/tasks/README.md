# Tasks - SimbaSql Asia App Analysis

**Tổng quan:** 338 DLL được decompile, **329 files** (324 task ở root + 2 task ở `phase 1/` + 1 README + 2 `_index.md`).

> **Đối với AI agent:** Đọc §1 → §2 → §5 để có context. §3 là index tra cứu nhanh. §4 là template bắt buộc cho task SimbaERP.

---

## 1. Tổng quan trạng thái

| Nhóm | Files | DLL gốc | Status |
|---|---:|---:|---|
| AR — Công nợ phải thu | 16 | ~16 | 3 DONE (001, 002, 003) |
| AP — Công nợ phải trả | 4 | ~4 | 0 DONE |
| CA — Tiền mặt & Ngân hàng | 12 | ~12 | 4 DONE (027–030) |
| CO — Sản xuất | 19 | ~18 | 0 DONE |
| SO — Đơn hàng bán | 47 | ~40 | 1 DONE (038) |
| PO — Đơn hàng mua | 19 | ~20 | 1 DONE (063) |
| SI — System Integration | 26 | ~25 | 1 DONE (084) |
| IN — Tồn kho | 30 | ~40 | 4 DONE (100, 109, 114, 117) |
| FA — Tài sản cố định | 39 | ~50 | 0 DONE |
| GL — Sổ cái tổng hợp | 103 | ~95 | 1 DONE (146) |
| System — Framework & cross-link | 9 | ~18 | 1 DONE (admin-dashboard) |
| **Tổng (root)** | **324** | **~338** | **14 DONE** |
| **Phase 1 (IMPLEMENTED)** | **2** | — | 2 DONE (008, 117) |
| **Tổng (root + phase 1)** | **326** | **~338** | **16 DONE** |

> DONE = đã implement và merge PR. PENDING = chỉ có task spec, chưa code.

**Snapshot audit mới nhất (route/menu):** `../project/task-execution-coverage.md`, `../project/remaining-process-shells.md`, `../project/simba-router-menu-matrix.md`.

## 2. Tasks đã hoàn thành (15)

| # | Task | Module | PR |
|---|---|---|---|
| 001 | ar-danh-muc-khach-hang | AR | — |
| 002 | ar-danh-muc-nhom-khach-hang | AR | — |
| 003 | ar-danh-muc-phan-loai-khach-hang | AR | — |
| 027 | ca-voucher-thu-tien | CA | — |
| 028 | ca-voucher-chi-tien | CA | — |
| 029 | ca-voucher-bao-no-ngan-hang | CA | — |
| 030 | ca-voucher-bao-co-uy-nhiem-chi | CA | — |
| 038 | ban-hang-khach-hang-them-sua-xoa | SO | [#170](https://github.com/diepxuan/portal/pull/170) |
| 063 | po-danhmuc-chuongtrinh-muahang | PO | — |
| 084 | si-danhmuc-bophan | SI | — |
| 100 | in-danhmuc-kho | IN | — |
| 109 | in-danhmuc-nhomhang-vat | IN | — |
| 114 | in-danhmuc-vattu | IN | — |
| 008 | ar-bao-cao-cong-no-tk-kh | AR | phase 1 |
| 117 | in-baocao-tonkho-02 | IN | [#241](https://github.com/diepxuan/portal/pull/241) |
| 146 | gl-danhmuc-taikhoan | GL | — |
| 11 | admin-dashboard | System | — |

## 3. Index theo module (326 tasks)

> Xem [`_index.md`](_index.md) — file sinh tự động từ `scripts/gen-tasks-index.php`. Mỗi dòng: ID, slug, module, DLL, status.

**Tóm tắt nhanh:**

- AR: `001-016`, `158` (17 tasks, bao gồm `038-ban-hang-...` cross-link về ARDMKH)
- AP: `017-020`
- CA: `021-032` + `159-165` (12 tasks, có 1 file range ID `032-038`)
- CO: `039-042` + `166-180` + `342-353` (18 tasks)
- SO: `043-062` + `197-216` + `339-340` (40 tasks)
- PO: `063-080` + `217` (19 tasks)
- SI: `081-099` + `218-224` (26 tasks)
- IN: `100-117` + `225-235` (29 tasks, 117 DONE)
- FA: `118-137` + `236-253` (39 tasks)
- GL: `138-157` + `254-337` (103 tasks)
- System: `1`, `5`, `11`, `26`, `32`, `34-37`, `55`, `59`, `CA4-PHIEU-BAONO-SPEC`, `357`

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
| 001 | AR | DMKH | AsARGetDMKH / AsARInsDMKH / AsARUpdDMKH / AsARDelDMKH |
| 100 | IN | DMKHO | AsINGetDMKHO / AsINInsDMKHO / AsINUpdDMKHO / AsINDelDMKHO |

## 5. Cập nhật gần đây

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
3. Không tự đổi trạng thái DONE — phải có PR merged vào main

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

*Cập nhật: 2026-07-06 17:15 GMT+7*
*Sinh tự động từ `scripts/gen-tasks-index.php` — xem [`scripts/gen-tasks-index.php`](../../scripts/gen-tasks-index.php)*