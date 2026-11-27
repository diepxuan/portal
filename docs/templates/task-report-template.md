# Task {ID}: {TÊN DLL}

## Nhóm: {MODULE}

## Trạng thái
- **Status:** {DONE|DONE (component)|SHELL_ONLY|BLOCKED}
- **DLL:** {DLL}.dll
- **Route:** `{module}.{kind}.{slug}`
- **Menu:** `{menuid}`

---

## Checklist DONE (9 mục — xem PROJECT_CONVENTIONS §2.7)

| # | Mục | Kết quả | Bằng chứng |
|---|---|---|---|
| 1 | Component render thật | ⬜ | `window.Livewire.all()` → `catalog::{route}` |
| 2 | Route 200 | ⬜ | `curl -o /dev/null -w "%{http_code}"` |
| 3 | Submit có dữ liệu đúng kỳ | ⬜ | kỳ {ngày} → {n} dòng |
| 4 | Không `errorMessage` | ⬜ | `err: null` |
| 5 | Bộ chọn kỳ (`component.timer`) | ⬜ | filter view |
| 6 | Label tiếng Việt | ⬜ | grep `lbl*.Text` frm{DLL}.cs |
| 7 | Dropdown field có danh mục | ⬜ | {n} field |
| 8 | Giá trị mặc định | ⬜ | `sysReportInfo.par0` |
| 9 | Tham số rỗng = `''` | ⬜ | test NULL vs `''` |

> **Chỉ đánh DONE khi đủ 9/9.**

---

## Tham số SP — đối chiếu `INFORMATION_SCHEMA`

```sql
SELECT PARAMETER_NAME FROM INFORMATION_SCHEMA.PARAMETERS
WHERE SPECIFIC_NAME = 'as{DLL}' ORDER BY ORDINAL_POSITION;
```

| # | Tham số | Kiểu | Ghi chú |
|---|---|---|---|

### Kiểm tra NULL vs `''`

| Tham số | `NULL` | `''` | Kết luận |
|---|---:|---:|---|

---

## Label — từ form gốc

```bash
grep -oE 'lbl[A-Za-z_0-9]+\.Text = "[^"]+"' \
  simba-docs/decompiled/asia/{DLL}.dll/AsiaERP.UserInterface/frm{DLL}.cs
```

| Field | Label |
|---|---|

---

## Field ẩn (`.Visible = false`)

```bash
grep -E "\.Visible = false" frm{DLL}.cs
```

```
...
```

Vẫn gửi trong payload, chỉ không hiện UI.

---

## Giá trị mặc định — `sysReportInfo`

```sql
SELECT menuid, ma_mau, isdefault, par0, hasNT
FROM sysReportInfo WHERE menuid = '{menuid}' AND isdefault = 1;
```

| Menu | `par0` | Ý nghĩa |
|---|---|---|

---

## Component & view

- **Component:** `{Module}\{Kind}\{PascalSlug}` (kế thừa `Rpt\AbstractReport`)
- **View:** `{module}/{kind}/{slug}.blade.php`
- **Filter:** `{module}/{kind}/filters/{slug}.blade.php`

### Dropdown dùng lại

| Field | Component | Props |
|---|---|---|

---

---

## Đối chiếu trang chuẩn (§2.8)

**Trang chuẩn cùng loại:** `/simba/so/rpt/sorptbk01` _(hoặc route khác cùng loại)_

| # | Hạng mục | Trang chuẩn | Trang của mình | Ghi chú |
|---|---|---|---|---|
| 1 | Component render thật | ✅ | ⬜ | |
| 2 | Route 200 | ✅ | ⬜ | |
| 3 | Submit dữ liệu đúng kỳ | ✅ | ⬜ | |
| 4 | Bộ chọn kỳ (`component.timer`) | ✅ | ⬜ | |
| 5 | **Label cột tiếng Việt** | ✅ | ⬜ | **quan trọng** |
| 6 | Sticky header | ✅ | ⬜ | |
| 7 | Cột `#` số thứ tự | ✅ | ⬜ | |
| 8 | Màu/nền hover dòng | ✅ | ⬜ | |
| 9 | Click dòng → panel chi tiết | ✅ | ⬜ | Master-Detail |
| 10 | Format số `vi-VN` | ✅ | ⬜ | |
| 11 | Số tiền theo loại tiền tệ | ✅ | ⬜ | VND/NT |
| 12 | Xuất Excel | ✅ | ⬜ | |
| 13 | Empty state khi 0 dòng | ✅ | ⬜ | |
| 14 | Hiển thị `errorMessage` | ✅ | ⬜ | |

> Hạng mục nào ❌ phải ghi lý do chấp nhận hoặc task riêng. Không bỏ trống.

### Tự trả lời 7 câu (§2.8.7)

1. Trang chuẩn cùng loại: _..._
2. Đã mở cả 2 trang trên browser: _có/không_
3. Hạng mục trang mình thiếu: _..._
4. 5 cột đầu hiện label gì: _..._
5. Số tiền định dạng thế nào: _..._
6. Khi 0 dòng người dùng thấy gì: _..._
7. Đã so số dòng/cột với SQL trực tiếp: _..._

---

## Label cột kết quả

| Cột SP | Label tiếng Việt | Nguồn |
|---|---|---|

## Bug đã fix

### Bug 1: {tên}
- **Triệu chứng:**
- **Nguyên nhân:**
- **Cách fix:**
- **Bằng chứng:**

---

## Verify browser (2026-11-27)

| Kiểm chứng | Kết quả |
|---|---|

---

## Đang làm / Sẽ làm

| Việc | Trạng thái |
|---|---|

