# MEMORY.md - Long-Term Memory

## Simba-docs Mount (2026-05-05)

- Chứa toàn bộ tài liệu SimbaSql .NET: 10 module ERP, 338 decompiled DLLs, SPs, system tables
- Read-only — nguồn sự thật về logic nghiệp vụ Simba
- Hướng dẫn chi tiết: `docs/SIMBA-DOCS.md`
- Identity files đã cập nhật: `SOUL.md`, `IDENTITY.md`, `AGENTS.md`, `TOOLS.md`

---

## 2026-07-11: PR #244 merged

- Task 357 (Livewire input components) DONE — merged PR #244 bang squash len main (commit `aa6c8c8fc`).
- Squash stats: +930 / -263, 12 files.
- Pattern da chuan hoa tren 4 component (InputKhachhang, InputTaikhoan, InputIndmvt, InputIndmkho):
  - Preload kho tu SP (boot/render), pass reduced payload xuong view
  - Blade search bang Alpine local JS (`khInputComponent`, `tkInputComponent`, `vtInputComponent`, `khoInputComponent`)
  - Bo `wire:model` khi go, sync Livewire qua `$wire.set()` chi khi chon item / Enter / Tab
  - Normalize bo dau (NFD + combining marks + `d/đ` + lowercase + collapse space)
  - Commit: exact code truoc, fallback dong dau filtered
- CatalogService::glDmTks() cache key doi tu `maCty|pTk|pStruct` -> `maCty|pStruct`, filter local theo `pTk`.
- Deferred: browser E2E cho CA4 / ARRptBCCN01 / INRptCD02; InputDonVi van dung Eloquent.

## 2026-07-13: Task 358 - slug suffix compact

- `SimbaMenuRouteMetadata::routeNameFor()` doi hau to slug trung ten thanh `menuIdSuffix()` (noi cac ky tu cua menuid, khong them `-`).
- Vi du: SysMenu `menuid=10.30.23, code_name=ARRptBCCN01` -> routeName `po.rpt.arrptbccn01103023` (thay vi `po.rpt.arrptbccn01-10-30-23`).
- URL moi: `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023`.
- Unit test `testRouteNameSuffixAppendsCompactMenuId` pin behavior; phpunit `SimbaMenuRouteMetadataTest` 9 tests / 20 assertions pass.

## 2026-05-05: Cac task co yeu cau CRUD khach hang

### Task 001: AR - Danh muc khach hang

- **Yeu cau:** Nhap, sua thong tin khach hang
- **Chuc nang:** Quan ly danh muc khach hang (CRUD)
- **Form classes:** frmARDMKH (xem danh sach voi btnAdd, btnEdit, btnDelete), frmARDMKHEdit (them/sua)
- **Stored Procedures:** SP_AR_DMKH_GET, INSERT, UPDATE, DELETE
- **Business Rules:**
    - Khong cho phep sua khi da co giao dich
    - Khong cho phep xoa khi da co giao dich
- **Trang thai:** HOAN THANH (da xac nhan)

### Task 38: Ban hang | khach hang | them, sua, xoa

- **Yeu cau:** Task CRUD cho khach hang trong module ban hang
- **Trang thai:** OPEN
- **Tien do:**
    - [ ] Phan tich yeu cau
    - [ ] Thiet ke co so du lieu (neu can)
    - [ ] Implement CRUD methods
    - [ ] Tao Livewire component (list, create, edit)
    - [ ] Them route
    - [ ] Viet test
    - [ ] Review va merge

### Task 002: AR - Danh muc nhom khach hang

- **Lien quan:** Co rang buoc voi khach hang
- **Business Rules:** Khong cho phep sua/xoa khi da co khach hang thuoc nhom

### Task 003: AR - Danh muc phan loai khach hang

- **Lien quan:** Co rang buoc voi khach hang
- **Business Rules:** Khong cho phep sua/xoa khi da co khach hang su dung

---

## 2026-05-04: Hoan thanh docs/tasks/

### Noi dung

Da hoan thanh viec tao **298 task files** trong `docs/tasks/` cho Portal Project.

### Chi tiet

| Chi so           | Gia tri |
| ---------------- | ------- |
| Tong so task     | 298     |
| DLLs decompiled  | 338     |
| DLLs da co task  | 336     |
| Ty le hoan thanh | 99.4%   |

### Cau truc

| Nhom   | So DLL | Task IDs                              |
| ------ | ------ | ------------------------------------- |
| AR     | ~16    | 001-018, 158                          |
| AP     | ~4     | 017-020                               |
| CA     | ~12    | 021-032, 159-165                      |
| CO     | ~20    | 039-042, 166-180                      |
| SO     | ~40    | 043-061, 197-216, 338-340             |
| PO     | ~20    | 063-080, 217                          |
| SI     | ~26    | 081-099, 218-224                      |
| IN     | ~29    | 100-117, 225-235                      |
| FA     | ~36    | 051 (da rename 341), 118-137, 236-253 |
| GL     | ~95    | 049, 138-157, 254-337                 |
| System | ~18    | 181-196                               |

### Lưu ý

- File 049-SO-phieuxuat-banle.md da rename thanh 340-SO-phieuxuat-banle.md
- File 051-FA-daocao-phantich-tscd-01.md da rename thanh 341-FA-baocao-phantich-tscd-01.md
- Simba.exe va INDMVT\_ khong phai DLL, khong can tao task

### Quy tac

- Task files theo khuon mau 002 (9 sections)
- Task ID unique, khong trung lap
- Nguon thong tin: SimbaSql/docs/decompiled/asia/{DLL}.dll/README.md
