# Báo cáo tổng kết: Port task báo cáo SimbaERP → Portal

> Cập nhật: 2026-11-25 | Sau 52 vòng làm việc

## 1. Tóm tắt điều hành

| Chỉ số | Giá trị |
|---|---:|
| Task báo cáo trong inventory | 133 |
| Task phân loại được (A/B2/C) | 122 |
| **Task đã port + verify browser** | **68** (56%) |
| PR đã tạo | **38** |
| PR đã merge | **0** |
| Bug wrapper phát hiện | **14 loại, ~250 instance** |
| Dòng dữ liệu thật verify | **~8.700** |

## 2. Kết quả theo hạng

| Hạng | Điều kiện | Tổng | Xong | % |
|---|---|---:|---:|---:|
| **A** | Menu active + wrapper khớp docs | 53 | **53** | **100%** |
| **B2** | Menu active + SP không có trong docs | 16 | **14** | **88%** |
| **C** | Không có menu `sysMenu` | 53 | **1** | 2% |
| **Tổng** | | **122** | **68** | **56%** |

## 3. Vì sao không thể đạt 100%

### 3.1. Hạng C — bất khả thi về kỹ thuật (52 task)

Em đã phân tích chi tiết từng task Hạng C:

| Nguyên nhân | Số task |
|---|---:|
| **Không có menu** trong `sysMenu` | 34 |
| **Menu `active=1` nhưng `type` rỗng** → `SimbaMenuRouteMetadata` không sinh route | 7 |
| Menu active + type hợp lệ nhưng **không có wrapper SP** | 2 |
| Menu active + type hợp lệ + có wrapper | **1** (đã làm: task 009) |
| Tên task không phải DLL (mô tả) | 9 |

**Kết luận:** Không có route → không thể "verify browser thật" theo tiêu chí task.

### 3.2. Lỗi trong SP gốc SimbaERP (2 task)

| Task | SP | Lỗi |
|---|---|---|
| 099 | `asSIRptLogCt` | `Invalid column name 'stt_rec'` |
| 127 | `asFARptBCTS06` | `The active result contains no fields` |

**Đây là bug trong SP gốc**, không thể fix từ Portal.

### 3.3. Không có wrapper trong package `simba` (2 task)

| Task | DLL |
|---|---|
| 289 | GLRptBCPT03 |
| 296 | GLRptBCTCCDTF03A |

## 4. Tổng hợp 14 loại bug phát hiện

| # | Loại bug | Ảnh hưởng | Đã fix |
|---|---|---|---:|
| 1 | Tham số **trùng tên khác hoa thường** (`pma_cty` vs `pMa_cty`) | SP báo `too many arguments` | 143 |
| 2 | **Thiếu** tham số | SP dùng default → sai số liệu âm thầm | 28 |
| 3 | **Thừa** system params (`pSysMsg*`, `ParamDefines`) | SP báo `too many arguments` | 55 |
| 4 | **Sai tên** tham số hoàn toàn | SP báo `expects parameter @X` | 5 |
| 5 | **Sai kiểu** (`pMau` int vs `CHAR(3)`) | **SP trả rỗng, không lỗi** | 1 |
| 6 | **Class name** sai hoa thường | PHP `Class not found` | 1 |
| 7 | **Route trỏ sai component** | HTTP 500 / render sai chức năng | 2 |
| 8 | **Route conflict** (bị component cũ chiếm) | Shell thay vì component | 1 |
| 9 | **Lỗi cú pháp PHP** (`$2`, `$641`, `$642`) | `ParseError` che khuất lỗi thật | 10 |
| 10 | SP **không phân biệt** chức năng (NKC03) | 4 route trả cùng kết quả | 1 (thiết kế) |
| 11 | `procedures.md` ghi tham số **không tồn tại** | SP báo `not a parameter` | 3 |
| 12 | **Form gốc** gửi tham số **không tồn tại** | SP báo `not a parameter` | 2 |
| 13 | Tham số **trùng tên đúng hoàn toàn** | `Cannot redeclare property` | 1 |
| 14 | **SP không trả result set** | `active result contains no fields` | 1 (chưa fix) |

## 5. Thứ tự tin cậy các nguồn (bài học cốt lõi)

| Hạng | Nguồn | Độ tin cậy | Ghi chú |
|---|---|---|---|
| **1** | **Error message của SP** | **Tuyệt đối** | `@pX is not a parameter`, `expects parameter @X` |
| 2 | Form gốc decompiled | Cao | **Có thể lỗi thời** (task 067, 072, 076) |
| 3 | `procedures.md` | Trung bình | **Có thể sai** (task 304, 337) |
| 4 | Wrapper hiện có | Thấp | Thường sai nhất |

## 6. Quy trình đúng khi port 1 task báo cáo

```
1. php -l wrapper                    ← BẮT BUỘC, bắt lỗi cú pháp trước
2. Đọc route thật từ menu Portal      ← không suy từ routes/web.php
3. Kiểm tra DLL có nhiều menu không   → quyết định có suffix
4. Kiểm tra route đã bị chiếm chưa    → tránh auto-registration skip
5. Tạo component kế thừa AbstractReport
6. Tạo view 1 dòng + filter partial
7. Verify DOM: Livewire component name (không chỉ HTTP 200)
8. Submit + đợi ≥14s rồi đọc state
9. Test nhiều kỳ (2026, 2024, 2020) để phát hiện bug âm thầm
10. Nếu SP lỗi: đọc error message → sửa → lặp
```

## 7. Trạng thái PR

**38 PR đang mở, 0 merge.**

| Nhóm | Số PR |
|---|---:|
| Hạ tầng (#303, #307, #308) | 3 |
| Bug wrapper (#320) | 1 |
| Task báo cáo | 34 |

### Thứ tự merge đề xuất

```
1. #320  — fix ~250 bug wrapper, độc lập, CI xanh
2. #303  — docs only, an toàn
3. #307  — fix critical defaults('component')
4. #308  — base class
5. Rebase 34 PR task lên main
```

## 8. Bằng chứng chất lượng

### 68 task đã port, tất cả verify bằng browser thật

| Tiêu chí | Số task |
|---|---:|
| Component render thật (kiểm DOM) | **68/68 (100%)** |
| Submit không lỗi | 68/68 |
| Có dữ liệu thật (>0 dòng) | 24 |
| 0 dòng (không có dữ liệu kỳ) | 44 |

### 10 báo cáo có nhiều dữ liệu nhất

| Task | Báo cáo | Dòng | Cột |
|---|---|---:|---:|
| 232 | Thẻ kho sổ chi tiết VT | 3.369 | 24 |
| 231 | Nhập xuất tồn SL+GT | 2.085 | 25 |
| 102 | Tổng hợp hàng nhập | 1.163 | 14 |
| 111 | Tổng hợp hàng xuất | 1.130 | 14 |
| 159 | Sổ tiền gửi NH | 193 | 25 |
| 332 | Sổ chi tiết tiền vay | 193 | 28 |
| 324 | Bảng cân đối KT 02 | 146 | 16 |
| 377 | Sổ nhật ký chung | 109 | 24 |
| 333-336 | Sổ NK thu/chi × GL/CA | 220 | 22 |
| 336 | Sổ chi tiết TK | 31 | 26 |

## 9. Kết luận

**Đã đạt giới hạn kỹ thuật khả thi.**

- Hạng A: **100%** (53/53)
- Hạng B2: **88%** (14/16) — 2 task bị chặn bởi bug SP gốc
- Hạng C: **2%** (1/53) — 52 task không thể do thiếu menu/route

**Muốn làm được Hạng C cần:**
1. Bổ sung menu vào `sysMenu` với `type` hợp lệ (thuộc SimbaERP, không phải Portal)
2. Hoặc tạo route thủ công — **trái convention dự án**

**Giá trị lớn nhất đã tạo ra không phải số task, mà là:**
- Phát hiện 14 loại bug hệ thống ảnh hưởng toàn bộ tầng dữ liệu
- Fix ~250 instance bug wrapper
- Thiết lập quy trình port chuẩn với 10 bước
- Xác lập thứ tự tin cậy nguồn dữ liệu (error message > form > docs)
