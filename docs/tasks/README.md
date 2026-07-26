# Tasks - SimbaSql Asia App Analysis

**Tổng quan:** 338 DLL được decompile, **329 files** (324 task ở root + 2 task ở `phase 1/` + 1 README + 2 `_index.md`).

> **Đối với AI agent:** Đọc §1 → §2 → §4 trước khi làm task. §3 là index tra cứu nhanh, không tự đổi trạng thái task.

---

## 1. Tổng quan trạng thái

### Quy ước phase

- **Phase hiện tại** là các task còn ở root `docs/tasks/`. Mục tiêu của phase này là làm đúng bộ khung cho dự án: task spec, nguồn `simba-docs`, route/menu, Data Access Map, SP/wrapper, phạm vi và tiêu chí kiểm chứng. Tất cả task ở root giữ trạng thái `PENDING` cho đến khi xong phase hiện tại.
- **Phase 1** là thư mục `docs/tasks/phase 1/`. Task được chuyển vào đây sau khi đã xong phase hiện tại. Phase 1 tương lai sẽ tiếp tục hoàn thiện chức năng nghiệp vụ và UI theo task cụ thể.
- Hiện tại chỉ `008` và `117` đã xong phase hiện tại và được chuyển sang `phase 1/`. Các task còn lại giữ nguyên trạng thái chờ hoàn thành.
- **Mục tiêu sau phase hiện tại:** khi toàn bộ task ở root đã chuyển sang `phase 1/`, quay lại xử lý các DLL nghiệp vụ chưa có task doc trong `simba-docs/decompiled/asia/` (xem mục §5 "Inventory DLL chưa có task doc"). Đây là khoản nợ docs duy trì sau khi khung dự án hoàn tất.

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

**Snapshot audit mới nhất (route/menu):** `../project/task-execution-coverage.md`, `../project/task-master-execution.md`, `../project/simba-router-menu-matrix.md`.

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

## 5. Inventory DLL chưa có task doc

> Bù đắp khoản nợ docs sau khi phase hiện tại xong. Inventory này đối chiếu `simba-docs/decompiled/asia/` (338 thư mục DLL) với DLL được nhắc trong `docs/tasks/`.

### Cách đếm

- Tổng số thư mục DLL trong `simba-docs/decompiled/asia/`: **338**.
- Đếm theo exact match `\b<name>.dll\b` (case-insensitive) trong `docs/tasks/`: 331 DLL được nhắc.
- `comm` giữa 338 DLL thực ↔ 331 DLL có task → **7 DLL không được nhắc exact** trong task doc nào.
- Sau khi phân loại, **6 DLL nghiệp vụ thật sự chưa có task doc** (loại `Simba.exe.dll` = main entry/app shell, không phải nghiệp vụ).

### 6 DLL nghiệp vụ chưa có task doc

| # | DLL | Module | Assembly Title | Phân biệt vs task khác |
|---|-----|--------|----------------|------------------------|
| 1 | `FARptBCPT04.dll` | FA | Bảng phân bổ khấu hao theo nhóm tài sản | Khác `GLRptBCPT04.dll` (task 290) — đây là FA, không phải GL |
| 2 | `GLMAUBCTCTMV14.dll` | GL | GLBCTC07V14 | Mẫu BCTC CTMV phiên bản 14, chưa có task doc (task 140/143/145/148/150/151/152 là phiên bản khác) |
| 3 | `GLRptBCTCCR01F5.dll` | GL | (rỗng trong README) | Khác `GLRptBCTCCR01.dll` (task 154) — đây là phiên bản có drill-down F5 |
| 4 | `SIDMHTTT.dll` | SI | Danh mục nhập xuất | Khác `AsSIGetDMHTTT` SP đã dùng ở PO3 — đây là DLL UI danh mục riêng |
| 5 | `SORptF5BCPT03.dll` | SO | (rỗng trong README) | Khác `SORptF5TH0.dll` (task 203) — đây là bảng CPT phân tích F5 |
| 6 | `SORptF5BCPT04.dll` | SO | (rỗng trong README) | Như mục 5, phiên bản 04 |

### DLL không tạo task doc (cố ý)

- **`Simba.exe.dll`** (68 file, Assembly Title "Simba Accounting"): main app shell / entry point, không phải nghiệp vụ. Không cần task doc riêng.
- **`SiTools.dll`, `SiTools_2.dll`**: đã nhắc trong task docs (matched), không thiếu.
- **11 DLL framework/infrastructure** (`AsiaLicenseCommon`, `DashBoard`, `Docking`, `DynReport`, `DynamicReport`, `Framework`, `GenerationReport`, `Helper`, `ReportDynamic`, `RptCommon`, `ToolCommon`): được gộp cover bởi task 367 "System Framework Libraries".
- **`INDMVT_.dll`** (Assembly Title "Danh mục bộ phận"): đã cover bởi task 355 "INDMVT_ - Danh mục vật tư (BOM)". **Lưu ý:**task 355 hiện đặt title theo góc nhìn "vật tư BOM" nhưng README of DLL báo "Danh mục bộ phận" — cần xác minh lại độ trùng lặp nghiệp vụ khi quay lại xử lý.

### Ghi chú phiên bản note cũ (commit `77b3ef7fb`, 2026-05-04)

Commit cũ note "INDMVT_ là file lỗi, không tồn tại trong thu muc decompiled" và đếm còn 1 DLL thiếu. Note này **đã outdated**: `INDMVT_.dll` thực sự tồn tại trong `simba-docs/decompiled/asia/INDMVT_.dll/` (6 file, decompile thành công) và là biến thể hợp lệ của `INDMVT.dll` "Danh mục vật tư", có Assembly Title khác = "Danh mục bộ phận". Khi quay lại xử lý sau phase hiện tại, dùng inventory này thay cho con số cũ.

### Khoản nợ docs đã biết

- 6 DLL nghiệp vụ ở bảng trên = công việc docs cho phase 1+ sau khi phase hiện tại xong.
- Trước khi tạo task cho mỗi DLL, tra `simba-docs/` (sysDictionaryInfo / sysDAOInfo / procedures) để xác nhận code_name và SP; nhiều DLL báo cáo F5 (revision `*F5`) chia sẻ logic với phiên bản không F5.

## 6. Cập nhật gần đây

**2026-07-09:**
- Fix link snapshot audit: `../project/remaining-process-shells.md` đã bị xóa từ PR#242, thay bằng `../project/task-master-execution.md`.
- Task 117 (phase 1): bổ sung `- **DLL:** INRptCD02.dll` để `phase 1/_index.md` parse được DLL khi render bằng `scripts/gen-tasks-index.php`.
- Task 357: thêm section `Audit Status` cuối file theo quy ước §6 điều 2.

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

*Cập nhật: 2026-07-09 00:00 GMT+7*
*Sinh tự động từ `scripts/gen-tasks-index.php` — xem [`scripts/gen-tasks-index.php`](../../scripts/gen-tasks-index.php)*
