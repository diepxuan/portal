# MEMORY.md - Long-Term Memory

## 2026-05-04: Hoan thanh docs/tasks/

### Noi dung

Da hoan thanh viec tao **298 task files** trong `docs/tasks/` cho Portal Project.

### Chi tiet

| Chi so | Gia tri |
|--------|---------|
| Tong so task | 298 |
| DLLs decompiled | 338 |
| DLLs da co task | 336 |
| Ty le hoan thanh | 99.4% |

### Cau truc

| Nhom | So DLL | Task IDs |
|------|--------|----------|
| AR | ~16 | 001-018, 158 |
| AP | ~4 | 017-020 |
| CA | ~12 | 021-032, 159-165 |
| CO | ~20 | 039-042, 166-180 |
| SO | ~40 | 043-061, 197-216, 338-340 |
| PO | ~20 | 063-080, 217 |
| SI | ~26 | 081-099, 218-224 |
| IN | ~29 | 100-117, 225-235 |
| FA | ~36 | 051 (da rename 341), 118-137, 236-253 |
| GL | ~95 | 049, 138-157, 254-337 |
| System | ~18 | 181-196 |

### Lưu ý

- File 049-SO-phieuxuat-banle.md da rename thanh 340-SO-phieuxuat-banle.md
- File 051-FA-daocao-phantich-tscd-01.md da rename thanh 341-FA-baocao-phantich-tscd-01.md
- Simba.exe va INDMVT_ khong phai DLL, khong can tao task

### Quy tac

- Task files theo khuon mau 002 (9 sections)
- Task ID unique, khong trung lap
- Nguon thong tin: SimbaSql/docs/decompiled/asia/{DLL}.dll/README.md