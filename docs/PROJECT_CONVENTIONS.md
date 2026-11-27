# Portal Project Conventions

Tài liệu quy ước dự án bắt buộc để các session sau không lặp lại lỗi kiến trúc/domain.

## 1. Field `ksd`

- `ksd = 1` nghĩa là **không sử dụng / khóa sử dụng** (disabled).
- `ksd = 0` nghĩa là **đang sử dụng** (active).
- Lọc dữ liệu active dùng `ksd = 0`; `ksd = 1` là loại trừ.
- Checkbox `KSD` checked = khóa sử dụng.
- Không hiểu `ksd = 1` là active, không hỏi lại.

## 2. Namespace PHP ↔ Route ↔ View — QUY TẮC TỔNG QUÁT

> **Đây là quy tắc gốc, áp dụng cho MỌI màn hình**, không riêng ARDMKH.
> Route name là nguồn sự thật; namespace PHP và đường dẫn view phải suy ra từ đó.

### 2.1. Route name sinh từ sysMenu (nguồn sự thật)

Theo [`docs/project/simba-router-menu-matrix.md`](project/simba-router-menu-matrix.md) và
`SimbaMenuRouteMetadata::baseRouteName()`:

```
route name = {module}.{kind}.{slug}

  module = strtolower(sysMenu.moduleid)        → so, po, ca, ar, ap, gl, in, fa, co, si
  kind   = dict | vch | rpt | proc             (xem bảng dưới)
  slug   = slug(sysMenu.dllName ?: code_name)  → ardmkh, povchpo3, sorptbk01...
```

| `source_type` | `kind` | Ý nghĩa |
|---|---|---|
| `TYPE_DICTIONARY` | `dict` | Danh mục / tham số |
| `TYPE_VOUCHER` | `vch` | Chứng từ |
| `TYPE_REPORT` | `rpt` | Báo cáo |
| khác | `proc` | Xử lý / tiện ích |

Khi nhiều menu trùng `(module, kind, slug)`, `SimbaMenuRouteMetadata` nối thêm hậu tố
`menuIdSuffix(menuid)` (chỉ ký tự alphanumeric), vd `po.rpt.arrptbccn01103011`.

### 2.2. Suy namespace PHP + view từ route name

Cho route `${module}.${kind}.${slug}`:

| Thành phần | Công thức | Ví dụ (`po.vch.povchpo3`) |
|---|---|---|
| Namespace component | `Diepxuan\Catalog\Http\Livewire\{Module}\{Kind}\{PascalSlug}` | `...\Po\Vch\Povchpo3` |
| Form (create/edit) | thêm hậu tố `Form` | `...\Po\Vch\Povchpo3Form` |
| View | `{module}/{kind}/{slug}.blade.php` | `po/vch/povchpo3.blade.php` |
| View form | `{module}/{kind}/{slug}-form.blade.php` | `po/vch/povchpo3-form.blade.php` |

Trong đó `{Module}` và `{Kind}` viết **PascalCase**, `{PascalSlug}` là slug viết PascalCase
(`povchpo3` → `Povchpo3`, `ardmkh` → `Ardmkh`).

### 2.3. Cấm dùng namespace thư mục nghiệp vụ cũ

Các thư mục dưới đây là **di sản, không được dùng cho code mới**:

| Cấm | Dùng thay thế |
|---|---|
| `Muahang\*` | `Po\{Kind}\*` |
| `Banhang\*` | `So\{Kind}\*` |
| `Cash\Danhmuc\*` | `Ca\Dict\*` |
| `Danhmuc\*` (không module) | `{Module}\Dict\*` |

Đã migrate: `Banhang\Khachhang` → `So\Dict\Ardmkh`; `Cash\Danhmuc\Nhanvien*` →
`Ca\Dict\Ardmkh*` (2026-08-03).

### 2.4. Kiểm chứng — bắt buộc trước khi báo DONE

```bash
# 1. Route có thật không (KHÔNG tin tài liệu task ghi tay)
php artisan route:list --name={module}.{kind}.{slug}

# 2. Namespace có khớp quy tắc không
grep -rn "namespace Diepxuan.Catalog.Http.Livewire" diepxuan/laravel-catalog/src/Http/Livewire/{Module}/{Kind}/

# 3. Kiểm tra toàn bộ route của 1 module
php artisan route:list --path={module}
```

Mọi route/namespace ghi trong task doc **phải** khớp output của `route:list`. Tài liệu task
có thể đã lỗi thời — **`route:list` là nguồn sự thật cuối cùng**.

> ⚠️ **Route 200 + component render CHƯA ĐỦ để gọi DONE.**
>
> Đó chỉ là **2/9 mục** của định nghĩa DONE. Với bảng kê/báo cáo, phải kiểm thêm:
> submit có dữ liệu đúng kỳ, bộ chọn kỳ, label tiếng Việt, dropdown, giá trị mặc định,
> tham số rỗng `''` (không `null`).
>
> Xem **mục 2.7** — bắt buộc đọc trước khi đánh `DONE` cho bất kỳ bảng kê/báo cáo nào.
>
> *Bài học PR #428: task 071/073/077 từng được đánh DONE khi chỉ đạt 2/9 mục →
> thực tế nhập kỳ ra **0 dòng**, dùng không được.*

### 2.5. Ví dụ đúng (toàn bộ loại)

| Loại | Route | Namespace component | View |
|---|---|---|---|
| Dict | `so.dict.ardmkh` | `So\Dict\Ardmkh` | `so/dict/ardmkh.blade.php` |
| Dict form | `so.dict.ardmkh.create` | `So\Dict\ArdmkhForm` | `so/dict/ardmkh-form.blade.php` |
| Dict | `po.dict.podmcp` | `Po\Dict\Podmcp` | `po/dict/podmcp.blade.php` |
| Voucher | `po.vch.povchpo3` | `Po\Vch\Povchpo3` | `po/vch/povchpo3.blade.php` |
| Voucher + form | `so.vch.sovchso3` / `.create` | `So\Vch\Sovchso3` / `Sovchso3Edit` | `so/vch/sovchso3.blade.php` / `-edit.blade.php` |
| Report | `so.rpt.sorptbk01` | `So\Rpt\Sorptbk01` | `so/rpt/sorptbk01.blade.php` |
| Process | `si.vch.smks` | `Si\Vch\Smks` | `si/vch/smks.blade.php` |

### 2.6. ARDMKH — đặc tả riêng (canonical)

#### Ví dụ ARDMKH

| Module | Component | Blade view | Route |
|--------|-----------|------------|-------|
| SO - Khách hàng | `So\Dict\Ardmkh` | `so/dict/ardmkh.blade.php` | `so.dict.ardmkh` |
| PO - Nhà cung cấp | `Po\Dict\Ardmkh` | `po/dict/ardmkh.blade.php` | `po.dict.ardmkh` |
| SO - Form | `So\Dict\ArdmkhForm` | `so/dict/ardmkh-form.blade.php` | `so.dict.ardmkh.create/edit` |
| CA - Nhân viên | `Ca\Dict\Ardmkh` | `ca/dict/ardmkh.blade.php` | `ca.dict.ardmkh` |
| CA - Form | `Ca\Dict\ArdmkhForm` | `ca/dict/ardmkh-form.blade.php` | `ca.dict.ardmkh.create/edit` |

- Hành động xóa danh mục ARDMKH dùng method `deleteDoiTuong`, không dùng `deleteKhachHang`.

## 2.7. Định nghĩa DONE — bảng kê / báo cáo (bài học PR #428)

> **Bối cảnh:** Task 071/073/077 (3 bảng kê mua hàng PO) từng được đánh dấu `DONE`
> khi mới chỉ có *component render được + route 200*. Thực tế **không dùng được**:
> nhập kỳ → **0 dòng**, label hiện tên tham số thô (`pTrang_thai`, `pMa_kh`),
> thiếu bộ chọn kỳ, dropdown không có dữ liệu.
>
> PR #428 mới đưa 3 màn về mức **dùng được thật**. Section này chốt lại tiêu chí
> để các task sau **không dừng ở mức cũ**.

### 2.7.1. Checklist bắt buộc — 9 mục

Một task bảng kê/báo cáo **chỉ được đánh `DONE`** khi qua đủ 9 mục:

| # | Hạng mục | Cách kiểm chứng | Mức cũ | Mức #428 |
|---|---|---|---|---|
| 1 | Component render thật (không phải shell) | `window.Livewire.all()` có `catalog::{module}.{kind}.{slug}` | ✅ | ✅ |
| 2 | Route trả 200 | `curl -o /dev/null -w "%{http_code}"` | ✅ | ✅ |
| 3 | **Submit có dữ liệu đúng kỳ** | Nhập kỳ có phát sinh → `rows.length > 0` | ❌ | ✅ |
| 4 | **Không lỗi `errorMessage`** | `$wire.get('errorMessage') === null` | ⚠️ | ✅ |
| 5 | **Bộ chọn kỳ** (`component.timer`) | `@livewire('catalog::component.timer')` trong filter | ❌ | ✅ |
| 6 | **Label tiếng Việt** | Lấy từ `grep 'lbl*.Text = "..."'` form gốc | ❌ | ✅ |
| 7 | **Dropdown cho field có danh mục** | field nào SP có danh mục → dùng `input-*` component | ❌ | ✅ |
| 8 | **Giá trị mặc định đúng** | Đọc `sysReportInfo.par0` / form gốc | ❌ | ✅ |
| 9 | **Tham số rỗng = `''` không `null`** | Xem 2.7.3 | ❌ | ✅ |

**"Mức cũ" = chỉ mục 1-2.** Đây **KHÔNG đủ** để gọi DONE.

### 2.7.2. Bộ chọn kỳ — luôn dùng `component.timer`

Bảng kê/báo cáo **bắt buộc** có bộ chọn kỳ giống SimbaERP:

```blade
<div class="grid grid-cols-3 items-center gap-4">
    <label class="text-right text-sm text-gray-700">Kỳ báo cáo</label>
    <div class="col-span-2">
        @livewire('catalog::component.timer', key('{slug}-timer'))
        <x-input-error for="pNgay1" class="mt-1" />
        <x-input-error for="pNgay2" class="mt-1" />
    </div>
</div>
```

```php
public function mount(?string $module = null, ?string $kind = null, ?string $slug = null): void
{
    parent::mount($module, $kind, $slug);

    $this->syncTimer();
}

private function syncTimer(): void
{
    $timer = \CatalogService::timer();

    $this->pNgay1 = (string) ($timer['from'] ?? now()->startOfMonth()->toDateString());
    $this->pNgay2 = (string) ($timer['to'] ?? now()->toDateString());
}
```

**Không dùng `now()` trực tiếp** — `pNgay2` sẽ là *hôm nay* thay vì *cuối kỳ*
→ lệch số liệu so với SimbaERP.

### 2.7.3. 🔴 Tham số rỗng PHẢI là `''`, KHÔNG được `null`

**Đây là bug nghiêm trọng nhất của PR #428.**

Nhiều SP dựng SQL động:

```sql
+ case @pX when '' then '' else ' AND col LIKE @pX + ''%''' end
```

Trong SQL Server: **`NULL = ''` → `UNKNOWN`** (không phải `TRUE`)
→ rơi vào nhánh `else` → sinh `AND col LIKE NULL + '%'` → **lọc sạch 0 dòng**.

**Triệu chứng:** nhập kỳ có dữ liệu nhưng báo cáo **luôn 0 dòng, không lỗi**.
Không có error message → rất khó phát hiện.

**Quy tắc:**

```php
// SAI — gây 0 dòng âm thầm
public ?string $pMa_nt = null;

// ĐÚNG
public ?string $pMa_nt = '';
```

**Cách xác định field nào bắt buộc `''`:** test từng tham số với `NULL` và `''`,
so số dòng. Field nào `NULL` → 0 dòng thì **phải** `''`.

Ví dụ đã kiểm chứng (`asPORptBK01`, tháng 10/2026, `pMa_ct='PO3'`):

| Tham số | `NULL` | `''` | Kết luận |
|---|---|---|---|
| `pTrang_thai` | **0** | 111 | bắt buộc `''` |
| `pMa_nt` | **0** | 111 | bắt buộc `''` |
| `pMa_kho` | **0** | 111 | bắt buộc `''` |
| `pMa_lo` | **0** | 111 | bắt buộc `''` |
| `pMa_httt` | **0** | 111 | bắt buộc `''` |
| `pMa_bp` | **0** | 111 | bắt buộc `''` |
| `pMa_spct` | **0** | 111 | bắt buộc `''` |
| `pMa_Phi` | **0** | 111 | bắt buộc `''` |
| `pMa_kh` | 111 | 111 | an toàn cả 2 |
| `pMa_vt` | 111 | 111 | an toàn cả 2 |
| `pMa_hd` | 111 | 111 | an toàn cả 2 |

> **Lưu ý:** không có quy tắc chung "mọi field `''`" — phải **test từng SP**.
> Nhưng mặc định an toàn là `''` (khớp default SimbaERP `= ''` trong khai báo SP).

### 2.7.4. Label tiếng Việt — lấy từ form gốc, không tự đặt

```bash
# Lay label that tu form decompiled
grep -oE 'lbl[A-Za-z_0-9]+\.Text = "[^"]+"' \
  simba-docs/decompiled/asia/{DLL}.dll/AsiaERP.UserInterface/frm{DLL}.cs
```

| Field | Label (từ form gốc) |
|---|---|
| `pSoct1` | Chứng từ số |
| `pSoct2` | Đến số |
| `pMa_ct` | Loại phiếu |
| `pMa_kh` | Mã NCC / Mã nhà cung cấp |
| `pMa_plkh1/2/3` | P loại NCC1/2/3 |
| `pMa_hd` | Mã hợp đồng |
| `pMa_nhhd` | Nhóm hợp đồng |
| `pMa_httt` | Hình thức TT |
| `pMa_kho` | Mã kho |
| `pMa_lo` | Mã lô |
| `pMa_Phi` | Mã phí |
| `pMa_spct` | Mã SPCT |
| `pMa_vt` | Mã vật tư |
| `pMa_nhvt` | Mã nhóm vật tư |
| `pMa_nt` | Mã ngoại tệ |
| `pGroupType` | Nhóm theo |

**Cấm** hiển thị thẳng tên tham số SP (`pMa_kh`, `pSoct1`...) trên UI.

### 2.7.5. Field ẩn — theo `.Visible = false` của form gốc

Form gốc ẩn nhiều field. **Không hiện trên UI nhưng vẫn gửi trong payload**
(SP cần đủ tham số).

```bash
grep -E "\.Visible = false" frmXXX.cs | grep -oE "[A-Za-z_0-9]+\)\.Visible" | sed 's/)\.Visible//'
```

Ví dụ `PORptBK01/02/03` ẩn:

```
pTrang_thai, pMa_nhkh, pMa_vitri, pMa_nvkd,
pMa_plvt1/2/3, pMa_TT, pMa_bp
```

### 2.7.6. Giá trị mặc định — đọc `sysReportInfo`

**Nguồn:** bảng `sysReportInfo` (= `MyReportInfo` trong form C#).

```sql
SELECT menuid, ma_mau, isdefault, par0, hasNT
FROM sysReportInfo
WHERE menuid = '{menuid}' AND isdefault = 1
```

Form gốc gán:

```csharp
((ListControl)cboLoaiPhieu).SelectedValue = base.MyReportInfo.par0;
```

Ví dụ:

| Menu | `par0` | Ý nghĩa |
|---|---|---|
| `10.20.02` (BK01) | `PO3` | Hoá đơn mua hàng trong nước |
| `10.20.05` (BK02) | `PO3` | Hoá đơn mua hàng trong nước |
| `10.20.20` (BK03) | `''` | Tất cả |

Ngoại tệ mặc định: `Framework.dll` dòng `optVND.Checked = true` → **`'VND'`**.

### 2.7.7. Dropdown — dùng component có sẵn, không viết mới

Trước khi viết component mới, **kiểm tra `src/Http/Livewire/Component/`**:

| Field | Component | Ghi chú |
|---|---|---|
| Loại phiếu | `input-loai-phieu` | `phan-he="{PO\|SO\|CA...}"` |
| Khách hàng / NCC / NV | `input-khachhang` | `mode="{khachhang\|nhacungcap\|nhanvien}"` |
| Hình thức TT | `input-httt` | **bắt buộc `module-id`** |
| Kho | `input-indmkho` | |
| Vật tư | `input-indmvt` | |
| Nhóm vật tư | `input-indmnhvt` | dùng `<datalist>` |
| Ngoại tệ | `input-ngoaite` | |
| Tài khoản | `input-taikhoan` | |
| Kỳ báo cáo | `component.timer` | |

**Field không có danh mục** (giữ `input type="text"`):
`pMa_hd`, `pMa_nhhd`, `pMa_lo`, `pMa_Phi`, `pMa_spct`, `pGroupType`...

### 2.7.8. Bug thường gặp khi dùng component autocomplete

#### a) `mount()` không nhận `wire:model` value

Parent set default (`pMa_nt='VND'`) nhưng `mount($value)` **không nhận được**
→ input hiện **rỗng**.

**Fix — thêm `hydrate()` + sync trong `render()`:**

```php
public function hydrate(): void
{
    if (null !== $this->value && '' !== trim((string) $this->value) && '' === trim($this->search)) {
        $this->refreshSearchFromValue();
    }
}

public function render(): View
{
    if (null !== $this->value && '' !== trim((string) $this->value) && '' === trim($this->search)) {
        $this->refreshSearchFromValue();
    }

    return view('...', [...]);
}
```

#### b) `pLanguageId` — không dùng `app()->getLocale()`

`asSIGetDmSo_ct` cần culture **`vi-VN`**. `app()->getLocale()` trả `'en'`
→ SP trả **0 dòng**.

| `pLanguageId` | Dòng |
|---|---:|
| `vi-VN` | **6** ✅ |
| `en` | 0 |
| `vi` | 0 |
| `''` | 2 |

#### c) `InputHttt` bắt buộc `module-id`

| `pModuleid` | Dòng |
|---|---:|
| `null` / `''` | **0** |
| `PO` | **6** ✅ |
| `SO` | 7 |

### 2.7.9. Quy trình kiểm chứng — 6 bước

```
1. Tham số:  query INFORMATION_SCHEMA.PARAMETERS → wrapper phải khớp CHÍNH XÁC
2. NULL test: từng field NULL vs '' → field nào 0 dòng thì đổi sang ''
3. Label:    grep 'lbl*.Text' trong frmXXX.cs → không tự đặt tên
4. Default:  sysReportInfo.par0 (isdefault=1) + Framework.dll optVND.Checked
5. Browser:  mở trang → kiểm DOM component → nhập kỳ CÓ DỮ LIỆU → submit
6. So sánh:  số dòng + số cột với query SQL trực tiếp
```

**Bước 5 là quan trọng nhất** — phải nhập kỳ **có phát sinh thật**, không dùng
kỳ mặc định (dễ trúng kỳ rỗng → tưởng bug).

### 2.7.10. Task doc — phải ghi đủ

> **Template:** `docs/templates/task-report-template.md` — copy ra
> `docs/tasks/{ID}-{ten}.md` rồi điền. Template đã có sẵn 9 mục checklist.

Task doc đạt chuẩn phải có:

- **9 mục checklist** ở 2.7.1, mỗi mục ghi ✅/❌
- **Bảng chứng** cho từng mục (query DB, DOM, số dòng)
- **Nguồn** đã tra: `procedures.md` / form gốc / `sysReportInfo` / `INFORMATION_SCHEMA`
- **Bug đã fix** (nếu có) với triệu chứng + nguyên nhân + cách fix
- **Ảnh hưởng các báo cáo khác** (nếu bug mang tính hệ thống)

### 2.7.11. Ví dụ đạt chuẩn — task 071/073/077 sau PR #428

| Mục | Trước #428 | Sau #428 |
|---|---|---|
| Component render | ✅ | ✅ |
| Route 200 | ✅ | ✅ |
| Submit kỳ 10/2026 | **0 dòng** ❌ | **111 dòng** ✅ |
| `errorMessage` | null | null |
| Bộ chọn kỳ | ❌ | ✅ `component.timer` |
| Label tiếng Việt | ❌ thô | ✅ 22-23 label |
| Dropdown | ❌ | ✅ 7 field |
| Default | ❌ | ✅ `PO3` + `VND` |
| Param `''` | ❌ `null` | ✅ `''` |

**Trước #428 = 2/9 mục. Sau #428 = 9/9 mục.**

Đây là mức tối thiểu để gọi `DONE`.

---

## 2.8. Tự kiểm tra — đối chiếu với trang chuẩn (không dừng ở checklist)

§2.7 là **danh sách tối thiểu**. Để đạt mức **hoàn thiện như trang chuẩn**, agent phải
**tự đối chiếu** với một màn hình đã được công nhận tốt — không chỉ tick đủ ô.

### 2.8.1. Trang chuẩn tham chiếu

**`/simba/so/rpt/sorptbk01`** (Sổ chi tiết công nợ khách hàng) — được xem là
**mức hoàn thiện tương đối** để so sánh.

Lý do: có Master-Detail, label cột tiếng Việt, xử lý số tiền theo loại tiền tệ,
empty state, sticky header, xuất Excel, và đã verify với dữ liệu thật.

Khi làm task mới **cùng loại** (bảng kê / báo cáo), phải tự hỏi:

> Trang chuẩn có gì mà trang của mình **chưa có**? Vì sao thiếu? Có chấp nhận được không?

### 2.8.2. Bảng đối chiếu bắt buộc — 12 hạng mục

Agent phải tự điền bảng này vào task doc:

| # | Hạng mục | Trang chuẩn `sorptbk01` | Trang của mình | Ghi chú |
|---|---|---|---|---|
| 1 | Component render thật | ✅ | ? | |
| 2 | Route 200 | ✅ | ? | |
| 3 | Submit dữ liệu đúng kỳ | ✅ | ? | |
| 4 | Bộ chọn kỳ (`component.timer`) | ✅ | ? | |
| 5 | **Label cột tiếng Việt** | ✅ `'label' => 'Loại phiếu'` | ? | **quan trọng** |
| 6 | Sticky header | ✅ | ? | |
| 7 | Cột số thứ tự `#` | ✅ | ? | |
| 8 | Màu/nền theo loại dòng | ✅ | ? | |
| 9 | Click dòng → panel chi tiết | ✅ | ? | Master-Detail |
| 10 | Định dạng số theo `vi-VN` | ✅ | ? | |
| 11 | Số tiền theo loại tiền tệ (VND/NT) | ✅ | ? | |
| 12 | Xuất Excel | ✅ | ? | |
| 13 | Empty state khi 0 dòng | ✅ | ? | |
| 14 | Hiển thị `errorMessage` | ✅ | ? | |

**Quy tắc:** hạng mục nào đánh `❌` phải ghi rõ **lý do chấp nhận** hoặc **task riêng
sẽ làm**. Không được bỏ trống.

### 2.8.3. Label cột — khác biệt lớn nhất

`report-shell` hiện `$column` thô (`ma_cty`, `stt_rec`, `ma_kh`).
Trang chuẩn map sang label tiếng Việt:

```php
$columns = [
    ['key' => 'ma_ct',   'label' => 'Loại phiếu', 'class' => 'text-left whitespace-nowrap'],
    ['key' => 'ngay_ct', 'label' => 'Ngày CT',    'class' => 'text-left whitespace-nowrap'],
    ['key' => 'so_ct',   'label' => 'Số CT',      'class' => 'text-left whitespace-nowrap font-mono'],
    ['key' => 'ma_kh',   'label' => 'Mã KH',      'class' => 'text-left whitespace-nowrap'],
    ['key' => 'ten_kh',  'label' => 'Khách hàng', 'class' => 'text-left'],
];
```

**Pattern cần áp dụng cho report dùng `report-shell`:**

1. Component khai báo `columnLabels(): array` map `key => label`
2. Truyền vào view: `'columnLabels' => $this->columnLabels()`
3. `report-shell` dùng `$columnLabels[$column] ?? $column`

Với cột động (SP trả nhiều cột), thêm fallback `appendDynamicColumns()`:
cột quen → label tay, cột lạ → dùng tên cột.

### 2.8.4. Nguồn label cột — lấy từ đâu

| Nguồn | Ưu tiên | Ghi chú |
|---|---|---|
| **Form decompiled** (`lbl*.Text`) | 1 | chính xác nhất |
| **`sysReportResx`** trong DB | 2 | bản dịch chính thức SimbaERP |
| **RPT file** (Crystal Report) | 3 | nếu có decompiled |
| Tự đặt | ❌ | **cấm** |

Query `sysReportResx`:

```sql
SELECT * FROM sysReportResx WHERE menuid = '{menuid}' ORDER BY ctlname;
```

### 2.8.5. Định dạng số — theo `vi-VN` và loại tiền tệ

Trang chuẩn xử lý:

```php
$currency = $this->isForeignCurrency() ? 'NT' : 'VND';

['key' => 'tien2', 'label' => 'Tiền ' . $currency, ...]
```

- `1.234.567` (dấu chấm ngăn nghìn, không thập phân cho VND)
- Ngoại tệ: hiện thêm cột `_nt`
- Ô tiền trống: `'—'` trên UI, `''` khi xuất CSV

### 2.8.6. Quy trình tự đối chiếu — 5 bước

```
1. Chọn trang chuẩn CÙNG LOẠI (bảng kê / báo cáo / phiếu / danh mục)
2. Mở cả 2 trang trên browser, chụp lại cấu trúc
3. Điền bảng đối chiếu 14 hạng mục (§2.8.2)
4. Với mỗi ❌: quyết định "làm ngay" / "task riêng + lý do"
5. Ghi kết quả vào task doc — KHÔNG chỉ ghi ✅
```

### 2.8.7. Câu hỏi tự kiểm tra (bắt buộc trả lời trong task doc)

1. **Trang chuẩn cùng loại là gì?** (route cụ thể)
2. **Đã mở cả 2 trang trên browser chưa?** (có/không)
3. **Hạng mục nào trang mình thiếu so với chuẩn?** (liệt kê)
4. **Cột kết quả hiện label gì?** (chụp 5 cột đầu)
5. **Số tiền định dạng thế nào?** (ví dụ thực)
6. **Nếu 0 dòng, người dùng thấy gì?** (empty state)
7. **Đã so số dòng/cột với query SQL trực tiếp chưa?** (số cụ thể)

**Không trả lời được 7 câu này = chưa đủ điều kiện báo xong.**

### 2.8.8. Ví dụ — đối chiếu 071/073/077 với `sorptbk01`

| # | Hạng mục | `sorptbk01` | `porptbk01` | Ghi chú |
|---|---|---|---|---|
| 1 | Component render | ✅ | ✅ | |
| 2 | Route 200 | ✅ | ✅ | |
| 3 | Submit dữ liệu | ✅ | ✅ 111 / 1.371 dòng | |
| 4 | Bộ chọn kỳ | ✅ | ✅ | |
| 5 | **Label cột tiếng Việt** | ✅ | ❌ **`ma_cty`, `stt_rec`** | **cần fix** |
| 6 | Sticky header | ✅ | ✅ | |
| 7 | Cột `#` | ✅ | ✅ | |
| 8 | Màu dòng hover | ✅ | ✅ | |
| 9 | Click dòng → chi tiết | ✅ | ✅ (`selectedRow`) | |
| 10 | Format số `vi-VN` | ✅ | ⚠️ `number_format` | chưa có locale |
| 11 | Số tiền theo tiền tệ | ✅ | ❌ | cần biết cột tiền |
| 12 | Xuất Excel | ✅ | ✅ | |
| 13 | Empty state | ✅ | ✅ | |
| 14 | `errorMessage` | ✅ | ✅ | |

**Kết luận:** 11/14 ✅, **3 mục cần fix** (5, 10, 11) — ghi vào task riêng.

## 3. ARDMKH Save: default không được `NULL`

Theo `simba-docs/tables/ArDmKh.md`, hầu hết cột `NOT NULL` có default:

- String: `''`
- Decimal: `0`
- Bit: `0` / `1`

Khi gọi `asARInsDMKH` / `asARUpdDMKH`, payload phải convert null thành default:

```php
protected function stringValue(?string $value): string
{
    return (string) ($value ?? '');
}

protected function numberValue(mixed $value): float
{
    return null === $value || '' === $value ? 0.0 : (float) $value;
}
```

Các wrapper `AsARInsDMKH` / `AsARUpdDMKH` phải khai báo output `pRet`:

```php
'pRet' => ['type' => 'INT', 'output' => true],
```

## 4. Header / SimbaPage

- `SimbaPage` là nơi duy nhất render `x-head-title` và `x-slot name="header"` cho màn hình `/simba/*`.
- Các Livewire component con trong `SimbaPage` **không được lặp lại** `x-head-title` / `x-slot name="header"`.
- View danh sách đặt nút `Create` trong toolbar nội dung, không đưa vào header slot.
- Danh sách ARDMKH không dùng pagination; load toàn bộ rows một lần và dùng client-side JS filter (Alpine).
- View form đặt link `Quay lại` trong toolbar nội dung; tiêu đề thêm/sửa hiển thị trong nội dung nếu cần.
- Đã áp dụng cho ARDMKH SO/PO/CA:
  - `so/dict/ardmkh*.blade.php`
  - `po/dict/ardmkh*.blade.php`
  - `ca/dict/ardmkh*.blade.php`

## 5. Input autocomplete khách hàng / đối tượng

- `input-khachhang` là lookup dùng chung cho khách hàng, nhà cung cấp và nhân viên theo `mode`.

### Quy tắc search chung (áp dụng cho mọi filter/list/autocomplete)

- Search luôn chuẩn hóa trước khi so khớp: bỏ dấu NFD, quy `đ/Đ` về `d`, lowercase, gộp khoảng trắng.
- Khớp theo **dãy con đúng thứ tự** (subsequence) sau khi bỏ khoảng trắng: query không cần nằm liền nhau, không cần bắt đầu từ, và không cần là chữ cái đầu mỗi từ.
- Ví dụ `Thủy Đông Hà` khớp cả `tdh`, `tda`, `ygh`, `thuy dong`, `dong ha`.
- Không dùng alias, không dùng bí danh từ khóa, không dùng viết tắt chữ cái đầu mỗi từ, không hardcode từ khóa nào vào filter.
- Thứ tự kết quả ưu tiên: mã chính xác → tên chính xác → chuỗi liên tiếp (contains) → dãy con đúng thứ tự.
- `commitSearch()` chỉ tự chọn khi có một kết quả rõ ràng; nhiều kết quả thì giữ dropdown để người dùng chọn.

### Chi tiết áp dụng

- Search luôn chuẩn hóa trước khi so khớp: bỏ dấu NFD, quy `đ/Đ` về `d`, lowercase, gộp khoảng trắng.
- Danh sách dùng client-side filter (vd ARDMKH, INDMVT) phải áp dụng cùng quy tắc dãy con đúng thứ tự cho toàn bộ field được tìm kiếm.

## 6. Danh sách chứng từ và bảng phụ chi tiết

- Danh sách voucher SO3/PO3 không đặt nút `Sửa` trực tiếp trong bảng chính và không có cột `Chi tiết`.
- Click dòng chứng từ sẽ mở bảng phụ `Chi tiết phiếu #N` bên dưới; click lại dòng đang mở sẽ đóng, click dòng khác sẽ chuyển selection.
- Bảng phụ hiển thị chi tiết vật tư lấy từ CT result set của SP filter, không gọi SP load edit riêng.
- Nút `Sửa` / `Xóa` đặt bên phải header bảng phụ; action xóa dùng `wire:confirm` và SP delete gốc.
- `Xuất Excel` đặt ở footer bảng chính, không đặt trong tab lọc.

## 7. Bảng kê gộp nhiều loại chứng từ — cột `Loại phiếu`

- Báo cáo bảng kê gộp nhiều loại chứng từ (vd `SORptBK01` gộp SO1–SO5; menu `06.20.53`/`06.20.56` là các mẫu in riêng cho SO4/SO5 nhưng cùng form) **bắt buộc hiển thị cột `Loại phiếu`** trong bảng phiếu để phân biệt từng loại.
- Giá trị cột lấy `ma_ct` từ PH result set của SP, map sang `ten_ct` từ danh mục `asSIGetDmSo_ct` (đã load sẵn cho dropdown lọc); fallback hiển thị chính `ma_ct` nếu chưa có trong danh mục.
- Cột đặt đầu bảng phiếu, class `text-left whitespace-nowrap`; khi export CSV cũng phải kèm cột `Loại phiếu`.
- Ví dụ đã áp dụng: `So\Rpt\Sorptbk01` (`phieuColumns()` + `phieuCellValue()` + `csvRows()`, helper `voucherTypeName()`).

### Bảng hiển thị đầy đủ cột của SP (auto-generate như SimbaERP)

- Báo cáo master-detail (vd `SORptBK01`) phải hiển thị **mọi cột** mà SP trả về, không chỉ subset cố định — giống DataGridView của SimbaERP (`ReportGridviewBrowseDynamic` tự sinh cột từ DataTable của result set).
- Cách làm: khai báo các cột quen thuộc (nhãn tiếng Việt, canh lề, xử lý VND/NT) trước, sau đó `appendDynamicColumns()` tự bổ sung các cột còn lại của từng dòng với nhãn từ `extraColumnLabel()` và class từ `extraColumnClass()`.
- Bỏ qua cột liên kết nội bộ `stt_rec`; bỏ qua biến thể tiền tệ không được chọn (`isCurrencyVariantToSkip()` theo `pMa_nt`) để không trùng cột tiền chính.
- Tên cột chuẩn của PH/CT `asSORptBK01` lấy từ SQL definition trên SQL Server (không lấy từ bảng voucher `SO3` vì khác tên): PH trả về `tien2`/`tien_nt2`, `thue_gtgt`/`thue_gtgt_nt`, `tt`/`tt_nt`; CT trả về `gia2`/`gia_nt2`, `tien2`/`tien_nt2`, `thue_gtgt`/`thue_gtgt_nt`, `tt`/`tt_nt`.
- Cột động chỉ thêm khi có nhãn tiếng Việt trong `extraColumnLabel()`; không hiển thị cột raw chỉ có tên kỹ thuật (vd `ma_cty`, `stt_rec0`, `ma_lo`, `ma_vitri`, `tk_pt`, `tk_thue`, `tk_ck_ds`) vì DataGridView gốc không có header tương ứng.
- Không viết tắt nhãn nghiệp vụ khi có thể đọc rõ: `ck_ds`/`t_ck_ds` hiển thị là `Chiết khấu doanh số`, `tien_ck` hiển thị là `Tiền chiết khấu`, `tk_ck_ds` hiển thị là `TK chiết khấu doanh số`; không dùng `CK ĐS`/`Tiền CK`.
- Định dạng cell động theo loại cột: cột tiền (`isMoneyColumn()`) dùng `moneyCell()` (định dạng số, ô trống hiển thị `—`), cột ngày (`ngay*`) dùng `dateValue()`, còn lại chuỗi thô — qua `dynamicCellValue()`.
- CSV export cũng phải kèm đủ các cột động (đi qua `phieuColumns()`/`chiTietColumns()`), ô tiền trống xuất `''` (dùng cờ `$forExport` của `phieuCellValue()`/`chiTietCellValue()`).

### Phiếu trả lại (SO4) / giá trị âm và ô tiền trống

- SO4 (phiếu nhập hàng bán bị trả lại) lưu số tiền **dương** trong `SoPh4`; dấu âm chỉ áp dụng khi post GL (`asPostSoPh4_glct`). **Phải đánh dấu theo `ma_ct == 'SO4'`**, không dựa vào dấu âm, nếu không phiếu trả hàng không bao giờ có màu; cell âm nói chung vẫn được đánh dấu.
- Màu đánh dấu dùng `text-red-500` (đỏ nhạt, nhẹ nhàng, không gây rối / không xáo trộn design), không đổi nền row (giữ pattern hover/chọn `sky-50`).
- Ô tiền/thuế/thanh toán trống (phiếu không phát sinh tiền, vd SO1 đơn đặt hàng) hiển thị `—` trong UI nhưng CSV export vẫn xuất `''`.
- Ví dụ đã áp dụng: `So\Rpt\Sorptbk01` (`phieuCellClass()` / `chiTietCellClass()` đánh dấu theo `ma_ct == 'SO4'` hoặc giá trị âm; `moneyDisplay()` cho placeholder `—`; `columnKeys()` map tên cột PH/CT; `appendDynamicColumns()` + `dynamicCellValue()` cho cột động của SP).

## 8. Khóa sổ liệu kỳ (`SiSetup.ngay_ks`)

### Quy tắc

- Mốc khóa sổ lưu ở `SiSetup.ngay_ks`, đọc theo công ty hiện tại — **không hardcode**.
- Chứng từ hợp lệ khi `ngay_ct > ngay_ks` (bằng ngày khóa sổ **vẫn bị chặn**).
- Hành động tính/post theo kỳ hợp lệ khi `ngay2 > ngay_ks`.
- Không có cấu hình `ngay_ks` → **không chặn** (tránh chặn nhầm).
- Dùng service `Diepxuan\Catalog\Services\KhoaSo` (singleton, cache theo request):
  `lockDate()`, `isDocumentDateLocked()`, `isPeriodLocked()`,
  `assertDocumentDateNotLocked()`, `assertPeriodNotLocked()`.
- Message tiếng Việt: "Không được nhập/sửa/xóa chứng từ trước ngày khóa sổ." và
  "Kỳ đã khóa sổ, không thể thực hiện tính toán/kết chuyển."

### `ngay_ks` KHÔNG liên quan màn xem báo cáo

Đã rà toàn bộ `simba-docs/decompiled/asia/*`: chỉ **15 DLL** dùng `ngay_ks` và
**không DLL nào là báo cáo** (`*Rpt*`). Tất cả đều là hành động ghi/tính dữ liệu:
`CoCalcCost`, `CoDelPostCP2GL`, `CoPostCPTT2GL`, `FACalKHTS`, `FADelCC2GL`,
`FADelKHTS`, `FADelTS2GL`, `FAPostCC2GL`, `GLPost2DGTG`, `GLPost2GL`,
`GLPost2GLKC`, `INCalGiaNTXT`, `SIAbout`, `SMKS`, `SOTaOut`.

Cảnh báo thuật ngữ: "kỳ báo cáo" (`cboKyBc`) trong simba-docs là **tham số đầu vào
của hành động tính/post** (vd `FACalKHTS`, `INCalGiaNTXT`, `CoPostCPTT2GL`), không
phải màn hiển thị báo cáo. Vì thế message lỗi không dùng chữ "kỳ báo cáo".

| Loại màn hình | Guard `ngay_ks`? |
|---|---|
| Form chứng từ (nhập/sửa/xóa) | **Có** — theo `ngay_ct`, áp cho cả `submit()` và `delete*()` |
| Hành động tính/post theo kỳ | **Có** — theo `ngay2` |
| Màn cập nhật `ngay_ks` (`/simba/si/vch/smks`) | Không (chính là nơi mở khóa) |
| Màn xem báo cáo / tra cứu | **Không** — phải xem được kỳ đã khóa |
| Đường xóa chứng từ (kể cả xóa từ bảng kê báo cáo) | **Có** — xóa là ghi dữ liệu |

### Bắt buộc: guard cả đường xóa

Nhiều SP xóa **không có** tham số `pNgay_ks` nên SQL không tự chặn:
`asSODelPH3`, `asPODeletePO3`, `asCADelCT2`, `asCADelPH2`, `asSOUpdPH3`,
`asPOUpdPH3`, `AsPostCaPh2_glct`. Các form gọi nhóm này **phải tự guard** ở tầng
Livewire cho cả `submit()` lẫn `delete*()`. Đã áp dụng: `Sovchso3Edit`,
`Povchpo3Edit`, `Phieubaono`, `Sorptbk01::deleteVoucher()`.

## 9. Cờ loại đối tượng `iskh` / `isncc` / `isnv` (ARDMKH)

### Quy tắc

- Một đối tượng ARDMKH có thể **đồng thời** là khách hàng, nhà cung cấp và nhân viên —
  ba cờ độc lập, không loại trừ nhau.
- `iskh = 1` → là khách hàng (SO/AR dùng).
- `isncc = 1` → là nhà cung cấp (PO/AP dùng).
- `isnv = 1` → là nhân viên (CA dùng).
- Cả ba cột là `NOT NULL`, default `1` theo `simba-docs/tables/ArDmKh.md`.
- Việc lọc theo module do **tham số `pModuleId` của `asARGetDMKH`** quyết định:
  `'AR'` = khách hàng, `'AP'` = nhà cung cấp, `'CA'` = nhân viên.

### Bắt buộc khi lưu (save/persist)

- **KHÔNG hardcode** `pIskh`/`pIsncc`/`pIsnv` trong payload SP. Phải lấy từ checkbox
  người dùng chọn: `$this->isKh ? 1 : 0`, v.v.
- Lý do: hardcode làm **mất cờ** của đối tượng. Ví dụ đã xảy ra: `2VANQT` vừa là
  khách hàng vừa là nhà cung cấp; form PO hardcode `pIskh => 0, pIsncc => 1` nên mỗi
  lần bấm Lưu đều **xoá cờ khách hàng**, biến đối tượng thành chỉ còn nhà cung cấp.
- Form phải hiển thị đủ 3 checkbox `isKh` / `isNcc` / `isNv` cho người dùng quyết định.
  Đã áp dụng cho `po/dict/ardmkh-form`, `so/dict/ardmkh-form`, `ca/dict/ardmkh-form`.

### Bắt buộc: gửi đủ cột NOT NULL khi save

`ArDmKh` có **35 cột NOT NULL** (xem `simba-docs/tables/ArDmKh.md`). Nếu payload SP thiếu
tham số, SP nhận `NULL` và SQL Server báo:

```
Cannot insert the value NULL into column '<ten_cot>', table 'ArDmKh'; column does not allow nulls. UPDATE fails.
```

Vì vậy mọi form ARDMKH **phải** gửi đủ các cột sau (đã áp dụng PO/SO/CA):

- Chuỗi (default `''`): `pHome_page`, `pMa_ngh`, `pTen_nh`, `pCn_nh`, `pSo_tk_nh`,
  `pTinh_tp_nh`, `pMa_tt`, `pMa_httt`, `pGhi_chu`, cùng các cột đã có.
- Số (default `0`): `pGh_no`, `pHan_ck`, `pTl_ck`, `pHan_tt`, `pLs_qh`.
- Bit (default `0`/`1`): `pTinh_dt_nb`, `pIskh`, `pIsncc`, `pIsnv`, `pKsd`.

Helper dùng chung trong `Po\Dict\ArdmkhForm`: `stringValue()` (null → `''`) và
`numberValue()` (null/`''` → `0`). Đây chính là quy tắc §3 áp dụng cho đầy đủ payload.

## Liên quan

- `docs/README.md` — documentation index
- `docs/SIMBA-DOCS.md` — hướng dẫn simba-docs
- `docs/DESIGN.md` — design tokens UI
- `docs/DEVELOPMENT.md` — setup dev
