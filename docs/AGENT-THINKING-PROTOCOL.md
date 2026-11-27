# AGENT THINKING PROTOCOL — Phương thức suy nghĩ & thực hiện

> **Mục đích:** để bất kỳ session/agent nào nhận task cũng suy nghĩ và làm **giống nhau**,
> không phải để Sếp nhắc lại từng lần.
>
> **Đọc file này NGAY SAU `PROJECT_CONVENTIONS.md`** trong boot sequence.
> Đây là *cách nghĩ*, `PROJECT_CONVENTIONS.md` là *quy tắc cụ thể*.

---

## 0. Vì sao có file này

Các lần gần đây Sếp phải nhắc đi nhắc lại những điều **lẽ ra agent phải tự biết**:

| Sếp đã phải nhắc | Lẽ ra agent phải tự làm |
|---|---|
| "title anh nói là `pTrang_thai`, `pSoct1`... field name này cơ mà" | Tự hiểu "title/label" là nhãn field, tra form gốc |
| "sắp xếp theo ảnh simbaerp gốc này" | Tự đối chiếu ảnh/form gốc trước khi dựng UI |
| "khoan merge, tiếp tục tạo autocomplete" | Không tự merge khi chưa đủ |
| "mã ngoại tệ mặc định là VND" | Tự tra `sysReportInfo`/form gốc lấy default |
| "field nào ko có dữ liệu dropdown thì để nguyên" | Tự kiểm tra nguồn dữ liệu từng field |
| "đối chiếu với `/simba/so/rpt/sorptbk01`" | Tự chọn trang chuẩn cùng loại để so |
| "vừa làm vừa đồng bộ tài liệu" | Cập nhật doc **trong lúc làm**, không để cuối |
| **"bảng thông tin cũ đâu rồi? anh bảo merge với nhau chứ có bảo thay thế đâu"** | **"Merge" = gộp, GIỮ CẢ HAI. "Thay thế" = bỏ cái cũ. Phải phân biệt rõ 2 từ này** |

**Gốc rễ:** agent dừng ở mức "chạy được" thay vì "đúng như SimbaERP".

---

## 1. Nguyên tắc số 1 — KHÔNG TỰ ĐẶT, LUÔN TRA NGUỒN

Trước khi viết bất kỳ tên/label/giá trị nào, phải trả lời:

> **"Cái này lấy từ đâu?"**

Nếu không trả lời được → **chưa được viết**.

### Thứ tự ưu tiên nguồn sự thật

| Hạng | Nguồn | Dùng cho | Độ tin cậy |
|---|---|---|---|
| 1 | **Lỗi runtime từ SP/DB** | tham số, kiểu dữ liệu | tuyệt đối |
| 2 | **`INFORMATION_SCHEMA.PARAMETERS`** | tên/kiểu/thứ tự tham số SP | tuyệt đối |
| 3 | **Dữ liệu thật trong bảng** | biết có dữ liệu không, phân bố | tuyệt đối |
| 4 | **Form decompiled `.cs`** | label, thứ tự field, field ẩn, default | cao |
| 5 | **`sysReportInfo` / `sysReportResx`** | mẫu báo cáo, `par0..par9`, `hasNT` | cao |
| 6 | **`Framework.dll`** (base class) | hành vi chung (`optVND.Checked`) | cao |
| 7 | **`procedures.md`** (simba-docs) | tham khảo | trung bình — có thể lỗi thời |
| 8 | **Wrapper PHP hiện có** | tham khảo | **thấp nhất** — thường sai |
| ❌ | Trí nhớ agent / suy đoán | — | **cấm** |

### 4 câu hỏi bắt buộc trước khi code

1. **Tên tham số/field này lấy từ đâu?** → chỉ ra file/query cụ thể
2. **Label tiếng Việt lấy từ đâu?** → `grep 'lbl*.Text'` trong `frm*.cs`
3. **Giá trị mặc định lấy từ đâu?** → `sysReportInfo.par0` hoặc form gốc
4. **Có dữ liệu thật để verify chưa?** → query `COUNT(*)` theo kỳ

Không trả lời được → **dừng, tra tiếp, không code**.

---

## 2. Quy trình suy nghĩ khi nhận task báo cáo/bảng kê

### Bước 1 — Hiểu đúng yêu cầu (đừng vội code)

```
Sếp nói "sửa cái title"  → title là gì?
  → page title?  field label?  column header?  menu bar?
  → PHẢI hỏi hoặc suy từ ngữ cảnh + ảnh, KHÔNG đoán rồi làm sai hướng
```

**Bài học:** agent từng đi sai hướng đi tìm `sysMenu.bar`/`AssemblyTitle` khi Sếp nói
"title" — thực ra Sếp muốn nói **label của field** (`pTrang_thai` → "Trạng thái").

**Quy tắc:** khi từ ngữ mơ hồ, **nêu 2-3 cách hiểu + bằng chứng**, hoặc hỏi. Không
đoán rồi làm 15 lần sai.

### Bước 2 — Tra nguồn sự thật (theo §1)

### Bước 3 — Đối chiếu trang chuẩn cùng loại

Trước khi dựng UI, **mở một trang đã hoàn thiện cùng loại** và so:

| Loại task | Trang chuẩn |
|---|---|
| Bảng kê / báo cáo | `/simba/so/rpt/sorptbk01` |
| Phiếu (voucher) | `/simba/po/vch/povchpo3/create` |
| Danh mục | `/simba/so/dict/ardmkh` |

Điền bảng 14 hạng mục — xem `PROJECT_CONVENTIONS.md` §2.8.

### Bước 4 — Verify bằng dữ liệu thật

**Không verify bằng kỳ mặc định** — dễ trúng kỳ rỗng rồi tưởng bug.

```
1. Query DB tìm kỳ CÓ phát sinh:  SELECT MAX(ngay_ct), COUNT(*) ...
2. Nhập đúng kỳ đó trên browser
3. So số dòng UI với số dòng SQL
```

### Bước 5 — Cập nhật tài liệu NGAY (không để cuối)

Mỗi khi phát hiện điều mới (bug, quirk, nguồn dữ liệu), **ghi vào doc trong cùng commit**.

---

## 3. Cách nhận diện lỗi — 5 dấu hiệu agent đang đi sai

| Dấu hiệu | Ý nghĩa | Xử lý |
|---|---|---|
| Đoán tên bảng/SP/field | vi phạm §1 | dừng, tra `simba-docs` |
| Sửa 5-10 lần vẫn lỗi | chưa hiểu nguyên nhân gốc | dừng, đọc source/SP definition |
| "Chắc là do..." | suy đoán | thay bằng test cụ thể |
| Verify bằng "HTTP 200" | bằng chứng yếu | đọc DOM/`window.Livewire.all()` |
| Báo xong khi chỉ "render được" | thiếu 9 mục §2.7 | làm tiếp |

### Bài học: lỗi PHP case-insensitive class (15 lần thử sai)

Agent thử opcache clear, container restart, classmap check... đều không giải thích được
`Cannot declare class ... already in use`.

**Nguyên nhân thật:** `use Diepxuan\Catalog\Models\Simba\GlDmTk;` + `class Gldmtk`
→ PHP case-insensitive → trùng tên.

**Bài học:** khi lỗi không giải thích được sau 2-3 lần thử, **đọc lại code từ đầu**
thay vì thử mò.

---

## 4. Cách báo cáo với Sếp

### Phải có bằng chứng cụ thể

| ❌ Không đủ | ✅ Đủ |
|---|---|
| "đã fix xong" | "0 → 111 dòng, 3 route 200" |
| "component chạy" | "`window.Livewire.all()` có `catalog::po.rpt.porptbk01`" |
| "dữ liệu đúng" | "SQL 26 dòng, UI 26 dòng" |
| "label tiếng Việt" | "bảng 17 label + nguồn `frmPORptBK01.cs` dòng XXX" |

### Cấu trúc báo cáo chuẩn

```
1. Kết luận ngắn (1-2 câu)
2. Bằng chứng (bảng số liệu thật)
3. Nguyên nhân (nếu là bug)
4. Đã làm gì
5. Verify (số cụ thể)
6. Còn lại / đề xuất
```

### Không được

- Báo "xong" khi chưa verify browser thật
- Giấu việc chưa làm được
- Tự merge/push khi Sếp chưa nói

---

## 5. Quy tắc phối hợp với Sếp

| Tình huống | Hành động |
|---|---|
| Yêu cầu rõ ràng | làm luôn, không hỏi lại |
| Yêu cầu mơ hồ | nêu cách hiểu + bằng chứng, hoặc hỏi 1 câu ngắn |
| Sếp sửa hướng | ghi nhận, **cập nhật doc** để lần sau không lặp |
| Sếp nói "khoan merge" | dừng, không merge |
| Sếp nói "merge đi" | `gh pr merge --squash --delete-branch`, verify `MERGED` |
| Sếp chỉ ra lỗi | tìm nguyên nhân gốc, không vá mù |

### Phân biệt "merge" vs "thay thế" — BẮT BUỘC

Đây là lỗi ngôn ngữ nghiêm trọng, agent đã mắc:

| Sếp nói | Nghĩa ĐÚNG | Agent từng làm SAI |
|---|---|---|
| **"merge 2 bảng với nhau"** | gộp lại, **GIỮ CẢ HAI**, sắp xếp cùng khu vực | bỏ bảng cũ, chỉ hiện bảng mới |
| **"gộp"** | như merge | |
| **"thay thế"** | bỏ cái cũ, chỉ dùng cái mới | |
| **"chuyển xuống dưới"** | đổi **vị trí**, giữ **nội dung** | đổi vị trí + đổi cả nội dung |
| **"sắp xếp lại"** | đổi **thứ tự**, giữ nguyên field | thêm/bớt field |

**Quy tắc:** khi Sếp nói "merge"/"gộp" → **liệt kê những gì sẽ giữ lại** trước khi code.
Nếu định bỏ bất kỳ thành phần nào → **phải hỏi**.

### Khi Sếp phải nhắc 2 lần cùng một điều

→ **Đó là lỗi của agent.** Phải:
1. Ghi ngay vào `PROJECT_CONVENTIONS.md` hoặc file này
2. Nêu rõ trong báo cáo: "đã ghi vào doc mục X"

---

## 6. Định nghĩa "XONG" — 3 mức

| Mức | Nghĩa | Ai chấp nhận |
|---|---|---|
| **Chạy được** | route 200, component render | ❌ không tính |
| **Dùng được** | 9 mục §2.7 + dữ liệu thật | ✅ tối thiểu |
| **Hoàn thiện** | 14 mục §2.8 = trang chuẩn | ✅ mục tiêu |

**Không bao giờ báo xong ở mức "chạy được".**

---

## 7. Checklist tư duy — tự hỏi trước khi báo cáo

- [ ] Tên/label/default có nguồn cụ thể chưa?
- [ ] Đã mở trang chuẩn cùng loại để so chưa?
- [ ] Verify bằng kỳ **có dữ liệu thật** chưa?
- [ ] Số dòng UI khớp số dòng SQL chưa?
- [ ] Đã cập nhật doc **trong lúc làm** chưa?
- [ ] Báo cáo có số liệu cụ thể hay chỉ nói "xong"?
- [ ] Có điều gì Sếp đã từng nhắc mà lần này lặp lại không?

**Nếu còn ô chưa tick → chưa báo xong.**

---

## 8. Ghi nhớ cốt lõi

> **Không tự đặt tên. Luôn tra nguồn. Đối chiếu trang chuẩn. Verify bằng dữ liệu thật.
> Cập nhật doc ngay. Báo cáo bằng số liệu.**

Đó là toàn bộ phương thức. Mọi task đều đi theo trình tự này.

