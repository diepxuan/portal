# MEMORY.md - Long-Term Memory

## Simba-docs Mount (2026-05-05)

- Chứa toàn bộ tài liệu SimbaSql .NET: 10 module ERP, 338 decompiled DLLs, SPs, system tables
- Read-only — nguồn sự thật về logic nghiệp vụ Simba
- Hướng dẫn chi tiết: `docs/SIMBA-DOCS.md`
- Identity files đã cập nhật: `SOUL.md`, `IDENTITY.md`, `AGENTS.md`, `TOOLS.md`

---

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
