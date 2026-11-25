# Checklist bàn giao: Port task báo cáo SimbaERP

> Tạo: 2026-11-25 | Trạng thái: 41 PR mở, 0 merge

## 1. Việc cần làm ngay (cho Sếp)

### 1.1. Merge 4 PR nền tảng theo thứ tự

```bash
# Bước 1: Fix ~250 bug wrapper (độc lập, CI xanh, 188 files)
gh pr merge 320 --repo diepxuan/portal --squash --delete-branch

# Bước 2: Chấm lại status task (docs only)
gh pr merge 303 --repo diepxuan/portal --squash --delete-branch

# Bước 3: Fix critical defaults('component')
gh pr merge 307 --repo diepxuan/portal --squash --delete-branch

# Bước 4: Base class cho báo cáo
gh pr merge 308 --repo diepxuan/portal --squash --delete-branch
```

**Sau khi merge 4 PR này, chạy verify:**

```bash
cd /root/.openclaw/workspace/projects/portal
php artisan optimize:clear
curl -s -o /dev/null -w "%{http_code}\n" http://portal.diepxuan.corp/simba/gl/rpt/glrptbct03
# Phải trả 200 VÀ component render thật (không shell)
```

### 1.2. Rebase 37 PR task lên main mới

Sau khi 4 PR nền tảng merge, mỗi PR task cần rebase:

```bash
for br in feat/task-131-*.md feat/task-159-* feat/task-204-* ...; do
  git checkout $br
  git rebase main
  git push --force-with-lease
done
```

**Danh sách 37 PR task cần rebase:** #304-306, #309-332, #334-339, #341-362

## 2. Kiểm chứng không regression

### 2.1. Test 3 task đã xác minh (sau merge)

| Task | Route | Dòng kỳ vọng | Cột |
|---|---|---:|---:|
| 232 | `/simba/in/rpt/inrptctvt02142032` | **3.369** | 24 |
| 159 | `/simba/ca/rpt/carpttmnh02` | **193** | 25 |
| 377 | `/simba/gl/rpt/glrptnkc02` | **109** | 24 |

**Lệnh test:**

```bash
node /tmp/vfull.js "http://portal.diepxuan.corp/simba/in/rpt/inrptctvt02142032"
# Kỳ vọng: {"n":3369,"nc":24,...}
```

### 2.2. Test 5 route khác (0 dòng hoặc ít dòng)

| Route | Kỳ vọng |
|---|---|
| `/simba/gl/rpt/glrptctgs05` | 1 dòng |
| `/simba/fa/rpt/farptbcts09` | 2 dòng |
| `/simba/co/rpt/corptgt01` | 6 dòng |
| `/simba/so/rpt/arrptbccn02` | 1 dòng |
| `/simba/gl/rpt/glrptth01` | 1 dòng |

## 3. Vấn đề còn tồn đọng

### 3.1. Bug SP gốc SimbaERP (2 task không fix được)

| Task | SP | Lỗi | Cần làm |
|---|---|---|---|
| 099 | `asSIRptLogCt` | `Invalid column name 'stt_rec'` | Sửa SP trong SQL Server |
| 127 | `asFARptBCTS06` | `The active result contains no fields` | Kiểm tra SP có SELECT không |

### 3.2. Hạng C — 52 task không làm được

| Nguyên nhân | Số task |
|---|---:|
| Không có menu trong `sysMenu` | 34 |
| Menu `active=1` nhưng `type` rỗng | 7 |
| Menu có nhưng không có wrapper | 2 |
| Tên task không phải DLL | 9 |

**Để làm được cần:**
- Bổ sung `type` cho 7 menu F5 trong `sysMenu` (thuộc SimbaERP)
- Hoặc chấp nhận không port Hạng C

### 3.3. 9 wrapper RỖNG còn lại

`AsGLRptNKCTBK1/2/4`, `AsGLRptNKCTNK1/2/4/5/8`, `AsSORptPrintVoucher`

**Tất cả không có menu active** → không port được cho đến khi có menu.

## 4. Tài liệu tham khảo

| File | Nội dung |
|---|---|
| `docs/tasks/_reports-final-report.md` | Báo cáo tổng kết đầy đủ |
| `docs/tasks/_reports-roadmap.md` | Lộ trình phân loại A/B2/C |
| `docs/tasks/_reports-inventory.md` | Inventory 133 task |
| `docs/PROJECT_CONVENTIONS.md` | Convention namespace + route |

## 5. Quy trình port task mới (nếu cần)

```
1. php -l wrapper                     ← BẮT BUỘC trước tiên
2. Đọc route thật từ menu Portal      (không suy từ routes/web.php)
3. Kiểm tra DLL có nhiều menu không   → quyết định suffix
4. Kiểm tra route đã bị component cũ chiếm chưa
5. Tạo component kế thừa AbstractReport
6. Tạo view 1 dòng + filter partial
7. Verify DOM: window.Livewire.all() → component name
8. Submit + đợi ≥14s rồi đọc state
9. Test nhiều kỳ (2026, 2024, 2020)
10. SP lỗi → đọc error message → sửa → lặp
```

## 6. Cảnh báo kỹ thuật

### 6.1. Script test phải đợi

```javascript
// SAI: đọc state ngay
await wire.call('submit');
const rows = wire.get('rows');  // n=0 giả

// ĐÚNG: đợi 14s
await wire.call('submit');
await page.waitForTimeout(14000);
const rows = wire.get('rows');
```

### 6.2. Verify phải kiểm DOM, không chỉ HTTP

```javascript
// SAI: chỉ kiểm HTTP 200 (shell cũng 200)
const res = await fetch(url);

// ĐÚNG: kiểm Livewire component name
const comps = await page.evaluate(() => 
  window.Livewire.all().map(c => c.snapshot.memo.name)
);
// Phải thấy 'catalog::gl.rpt.glrptbct03', không chỉ 'catalog::system.simba-page'
```

### 6.3. Tham số SP: error message là chân lý

| Hạng | Nguồn | Ghi chú |
|---|---|---|
| **1** | **Error message SP** | `@pX is not a parameter`, `expects parameter @X` |
| 2 | Form gốc decompiled | Có thể lỗi thời |
| 3 | `procedures.md` | Có thể sai |
| 4 | Wrapper hiện có | Thường sai nhất |

## 7. Liên hệ

Nếu cần hỗ trợ thêm về bất kỳ task nào trong 41 PR, tham khảo:
- PR body (mỗi PR có mô tả chi tiết bug + verify)
- Task doc tương ứng trong `docs/tasks/`
