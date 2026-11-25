# Task 383: Audit route khai báo tay trỏ SAI component

## Nhom: SI (System Integration)

- **Status:** PARTIAL — phát hiện 2 trường hợp sai, đã fix 1
- **Loai:** Bug fix (không phải báo cáo)
- **Nguồn phát hiện:** task 332 (CARptTMNH06) khi debug HTTP 500

## Vấn đề

`diepxuan/laravel-catalog/routes/web.php` có ~37 route khai báo tay dạng:

```php
['uri' => 'module/kind/slug', 'name' => 'module.kind.slug', ..., 'component' => SomeClass::class],
```

Một số route trỏ **SAI component** so với nghiệp vụ thật của menu.

## Cách phát hiện

Đối chiếu 3 nguồn:

| Nguồn | Lấy từ |
|---|---|
| Route khai báo tay | `routes/web.php` |
| Menu thật | `simba-docs/data/sysMenu.md` (dllName + title) |
| Component | tên class + nghiệp vụ |

Nếu tên component **không khớp** nghiệp vụ của menu → sai.

Script kiểm tra:

```bash
python3 - <<'PY'
import re, html
menus = {}
for l in open('simba-docs/data/sysMenu.md', encoding='utf-8'):
    if not l.startswith('|'): continue
    c = [x.strip() for x in l.split('|')]
    if len(c) < 31 or not c[7]: continue
    menus[c[7].upper()] = (c[1], html.unescape(c[6]), c[4], c[29])

src = open('diepxuan/laravel-catalog/routes/web.php', encoding='utf-8').read()
entries = re.findall(
    r"\['uri' => '([^']+)', 'name' => '([^']+)', 'module' => '([^']+)', "
    r"'kind' => '([^']+)', 'slug' => '([^']+)', 'component' => ([\w\\\\]+)::class\]", src)

for uri, name, mod, kind, slug, comp in entries:
    if comp == 'SimbaPage': continue
    m = menus.get(slug.upper())
    if m:
        mid, title, mod2, active = m
        print(f'{name:34} {comp.split(chr(92))[-1]:22} {title[:40]}')
PY
```

## Kết quả audit

### ❌ SAI — đã fix

| Route | Component cũ | Menu thật | Component đúng |
|---|---|---|---|
| `ca.rpt.carpttmnh06` | `CaRptThu` ("Phiếu thu") | `04.20.14` "Sổ chi tiết tiền vay" | `Carpttmnh06` (task 332) |

### ❌ SAI — đã fix trong task này

| Route | Component cũ | Menu thật | Xử lý |
|---|---|---|---|
| `so.vch.sovchso1` | `Hoadonbanhang` ("Hoá đơn bán hàng") | `06.10.02` **"Đơn đặt hàng"** | Comment route → SimbaPage shell (chưa có component) |

### ⚠️ NGHI VẤN — cần review

| Route | Component | Menu thật | Nhận xét |
|---|---|---|---|
| `ca.rpt.carpttmnh01` | `CaRptTienmat` | `04.20.02` "Sổ kế toán chi tiết quỹ tiền mặt" | Tên khác nhưng **cùng nghiệp vụ tiền mặt** — có thể chấp nhận |
| `so.rpt.arrptbccn01` | `Arrptbccn01` | "Sổ chi tiết công nợ một nhà cung cấp" | Khớp |

### ✅ ĐÚNG (không cần sửa)

Các route còn lại: `ca.vch.*`, `po.vch.*`, `so.vch.sovchso3*`, `*.dict.ardmkh*`, `gl.dict.gldmtk`, `in.dict.*`, `in.rpt.inrptcd02`, `po.dict.podmcp`, `si.vch.smks`, `so.dict.ardmplkh*`

## Bài học

**Route khai báo tay là nguồn bug nghiệp vụ âm thầm:**

- Trang vẫn trả HTTP (200 hoặc 500) → không ai báo lỗi
- Người dùng có thể đang **xem dữ liệu sai chức năng**
- Không có test tự động nào phát hiện

**Khuyến nghị:** chuyển toàn bộ sang auto-registration theo convention
(xem `docs/PROJECT_CONVENTIONS.md` §2.1/§2.2), xoá route khai báo tay.
