# Task 434: Phân quyền nhóm người sử dụng

## Nhóm: SI (System) — `frmSiSetRights`

## Trạng thái

- **Status:** ✅ **DONE (component)** — verify browser thật 2026-11-28
- **DLL:** `SIGroupInfo.dll`
- **Form gốc:** `AsiaErp.UserInterface.frmSiSetRights` (801 dòng)
- **Route:** `si.vch.sigroupinfo.rights` → `/simba/si/vch/sigroupinfo/{group}/rights`
- **Component:** `Si\Vch\SigroupinfoRights`
- **View:** `si/vch/sigroupinfo-rights.blade.php`
- **Mở từ:** task 088 (`Si\Vch\Sigroupinfo`) — nút **"Phân quyền"**

> Task doc này tách từ task 088 (đã DONE phần CRUD nhóm).
> Đây là màn **phân quyền chức năng** cho từng nhóm — form gốc `frmSiSetRights`.

---

## Checklist DONE (9 mục — PROJECT_CONVENTIONS §2.7)

| # | Mục | Kết quả |
|---|---|---|
| 1 | Component render thật | ✅ `catalog::si.vch.sigroupinfo-rights` |
| 2 | Route 200 | ✅ `/simba/si/vch/sigroupinfo/LEADER/rights` |
| 3 | Hiển thị đúng 571 chức năng | ✅ 571 dòng |
| 4 | Không `errorMessage` | ✅ `err=null` |
| 5 | Bộ chọn kỳ | — **không cần** (phân quyền, không theo kỳ) |
| 6 | Label tiếng Việt | ✅ Phân hệ/Số liệu/Chức năng/Xem/Thêm/Sửa/Xoá |
| 7 | Dropdown Phân hệ + Số liệu | ✅ 13 + 9 (lọc theo phân hệ) |
| 8 | Giá trị mặc định | ✅ `02.00.00` → `02.10.00` |
| 9 | Tham số rỗng = `''` | ✅ đã test |

---

## Cấu trúc UI — theo ảnh SimbaERP + form gốc

```
┌─ Phân quyền ─────────────────────────────────────────────┐
│  Phân hệ   [Tổng hợp            ▼]                        │
│            [Số liệu             ▼]                        │
│  ┌─────────────────────────────────────────────────────┐ │
│  │ #  Chức năng            │ Xem │ Thêm │ Sửa │ Xoá    │ │
│  │ 1  Phiếu kế toán        │  ☐  │  ☐   │  ☐  │  ☐     │ │
│  │ 2  Kết chuyển tự động   │  ☐  │  ☐   │  ☐  │  ☐     │ │
│  │ 3  Phân bổ chi phí ...  │  ☐  │  ☐   │  ☐  │  ☐     │ │
│  │ ...                                                  │ │
│  └─────────────────────────────────────────────────────┘ │
│                                   [Lưu]  [Thoát]          │
└──────────────────────────────────────────────────────────┘
```

**Label** (từ `grep 'Text = ...'` trong `frmSiSetRights.cs`):

| Control | Label |
|---|---|
| Form | **Phân quyền** |
| Combo 1 | **Phân hệ** |
| Combo 2 | **Số liệu** |
| Cột 1 | **Chức năng** |
| Cột 2-5 | **Xem** / **Thêm** / **Sửa** / **Xoá** |
| Nút | **Lưu** / **Thoát** |

---

## Stored Procedures — `INFORMATION_SCHEMA.PARAMETERS`

| SP | Tham số | Dữ liệu thật |
|---|---|---|
| `asGetMenuBar` | `pLanguage` (1) | **13 dòng** — `bar, MenuID, Link` |
| `asGetMenuDetail` | `pLanguage` (1) | **42 dòng** — `bar, MenuID, LinkDetail, Link` |
| `asSiGetAllGroupRights` | `pGroupName` (1) | **571 dòng** — `MenuID, Bar, BasicRight, LinkDetail, Link, ViewRight, UpdateRight, DeleteRight, InsertRight` |
| `asInsGroupRight` | `pGroupName, pMenuID, pViewRight, pInsertRight, pUpdateRight, pDeleteRight, pRet` (7) | `pRet` OUTPUT |
| `asDelGroupRight` | `pGroupName, pMenuID, pRet` (3) | `pRet` OUTPUT |
| `asUpdGroupRight` | `pGroupName, pGroupName_Old, pRet` (3) | `pRet` OUTPUT — **không dùng trong form gốc** |
| `asGroupCheckGrand` | `pUserName` (1) | kiểm tra user có quyền "phân lại quyền" |

### 🐛 3 wrapper ĐÃ SỬA khi khảo sát task này

Đối chiếu `INFORMATION_SCHEMA.PARAMETERS` phát hiện 3 lỗi wrapper (đúng bài học PR #427):

| Wrapper | Lỗi | Đã sửa |
|---|---|---|
| `AsDelGroupRight` | Gọi **sai tên SP**: `asSIDelGroupRight` (không tồn tại) → `asDelGroupRight` | ✅ |
| `AsDelGroupRight` | **Thiếu `pRet`** → SP báo *"expects parameter '@pRet', which was not supplied"* | ✅ thêm `pRet` |
| `AsGroupCheckGrand` | **Thừa `pCheck`** — SP thật chỉ có `pUserName` (1 tham số) | ✅ bỏ `pCheck` |

**Lưu ý về `pRet`:** đây là OUTPUT parameter nhưng SP **vẫn yêu cầu truyền vào**.
Bài học: "OUTPUT" ≠ "không truyền" — phải test thật mới biết.

`AsInsGroupRight` dùng passthrough `$params` (không tường minh) nhưng **hoạt động đúng**
— đã test insert + xoá dọn sạch.

### Dữ liệu mẫu `asGetMenuBar`

| bar | MenuID | Link |
|---|---|---|
| Tổng hợp | `02.00.00` | `02` |
| Tiền mặt, Ngân hàng | `04.00.00` | `04` |
| Bán hàng | `06.00.00` | `06` |
| Mua hàng | `10.00.00` | `10` |
| … (13 dòng) | | |

### Dữ liệu mẫu `asGetMenuDetail`

| bar | MenuID | LinkDetail | Link |
|---|---|---|---|
| Số liệu | `02.10.00` | `10` | `02` |
| Báo cáo Nhật ký chung | `02.25.00` | `25` | `02` |
| Báo cáo Chứng từ ghi sổ | `02.20.00` | `20` | `02` |
| … (42 dòng) | | | |

---

## Logic lọc — theo `frmSiSetRights.cs`

### 1. Chọn "Phân hệ" (combo 1)

```csharp
// cboMainMenu_SelectedValueChanged
RowFilter("Link = '" + SelectedItem["Link"] + "'");   // cho f_oTblSubMenu
// -> combo 2 chỉ hiện các "Số liệu" có cùng Link
```

### 2. Chọn "Số liệu" (combo 2)

```csharp
// cboSubMenu_SelectedIndexChanged
RowFilter("SUBSTRING(MenuID,1,5) = '" + SelectedItem["MenuID"].Substring(0,5) + "'");
// -> bảng chỉ hiện chức năng thuộc 5 ký tự đầu của MenuID
```

**Ví dụ:** chọn "Số liệu" = `02.10.00` → filter `SUBSTRING(MenuID,1,5) = '02.10'`
→ hiện `02.10.02`, `02.10.05`, `02.10.08`...

### 3. Lưu — theo `cmdSave_Click`

```csharp
// Chỉ xử lý các dòng có thay đổi
foreach (row in f_oTblGroupRight.GetChanges(DataRowState.Modified).Rows) {
    dao.DeleteGroupRight(groupName, row["MenuID"]);          // xoá cũ trước

    // Chỉ insert nếu có ÍT NHẤT 1 quyền
    if (row.ViewRight || row.InsertRight || row.UpdateRight || row.DeleteRight) {
        dao.InsertGroupRight(groupName, row["MenuID"],
            ViewRight: true,                                  // ← LUÔN true
            row.InsertRight, row.UpdateRight, row.DeleteRight);
        row["ViewRight"] = true;
    }
}
```

**Điểm quan trọng:**

- **Delete-then-Insert**: không có SP update, nên xoá rồi thêm lại
- **ViewRight LUÔN = true** khi insert (nếu có bất kỳ quyền nào)
- Nếu **bỏ tick hết 4 quyền** → chỉ Delete, không Insert → xoá quyền

---

## ⚠️ Trạng thái dữ liệu hiện tại

**`sysGroupRight` có 0 dòng** (kiểm 2026-11-28).

Hệ quả: `asSiGetAllGroupRights` trả **571 dòng giống hệt nhau** cho mọi nhóm
(`ViewRight=0, InsertRight=0, UpdateRight=0, DeleteRight=0`).

→ Ảnh SimbaERP chụp màn hình cho thấy tất cả checkbox **đều trống** — khớp với DB.

**Cần xác nhận với Sếp:** đây là dữ liệu thật (chưa ai phân quyền) hay DB thiếu?
Nếu chưa phân quyền bao giờ thì màn này sẽ tạo dữ liệu mới cho `sysGroupRight`.

---

## Bảng `sysGroupRight` (11 cột)

| # | Cột | Kiểu |
|---|---|---|
| 1 | `groupname` | nvarchar |
| 2 | `menuid` | nvarchar |
| 3 | `viewright` | bit |
| 4 | `deleteright` | bit |
| 5 | `updateright` | bit |
| 6 | `insertright` | bit |
| 7 | `limitedprint` | int |
| 8 | `cuser` | nvarchar |
| 9 | `luser` | nvarchar |
| 10 | `cdate` | smalldatetime |
| 11 | `ldate` | smalldatetime |

---

## Cách làm đề xuất

### Component

```php
namespace Diepxuan\Catalog\Http\Livewire\Si\Vch;

class SigroupinfoRights extends Component
{
    public string $groupName = '';

    /** 13 dòng từ asGetMenuBar */
    public array $mainMenus = [];

    /** 42 dòng từ asGetMenuDetail */
    public array $subMenus = [];

    /** 571 dòng từ asSiGetAllGroupRights */
    public array $rights = [];

    public ?string $mainMenuId = null;   // "Phân hệ"
    public ?string $subMenuId = null;    // "Số liệu"

    public function mount(string $group): void { /* load 3 SP */ }

    public function updatedMainMenuId(): void { /* reset subMenuId */ }

    /** Bảng chức năng đã lọc theo mainMenuId + subMenuId */
    public function filteredRights(): array { }
}
```

### Lưu ý hiệu năng

`asSiGetAllGroupRights` trả **571 dòng** mỗi nhóm. Không cần phân trang (bảng nhỏ),
nhưng **lọc client-side** để chuyển combo mượt — không gọi lại SP.

---

## Verify browser (khi implement)

| Kiểm chứng | Cách |
|---|---|
| Route | 200 |
| Component | `catalog::si.vch.sigroupinfo-rights` |
| Combo "Phân hệ" | **13** option |
| Combo "Số liệu" | đổi theo phân hệ (tổng **42**) |
| Bảng chức năng | **571** dòng khi không lọc |
| Lọc `02.10` | hiện đúng các dòng `02.10.xx` |
| Lưu | tick 1 quyền → `sysGroupRight` có 1 dòng `viewright=1` |
| Bỏ tick hết | `sysGroupRight` không còn dòng đó |
| DB baseline | chụp md5 trước/sau, verify sạch |

---

## Liên quan

- **Task 088** — `Si\Vch\Sigroupinfo` (CRUD nhóm, đã DONE) — nút "Phân quyền" mở màn này
- SP đã có wrapper sẵn: `AsGetMenuBar`, `AsGetMenuDetail`, `AsSiGetAllGroupRights`,
  `AsInsGroupRight`, `AsUpdGroupRight`, `AsDelGroupRight`, `AsGroupCheckGrand`

---

## Portal implementation — DONE (2026-11-28)

### Verify browser thật

**URL:** `/simba/si/vch/sigroupinfo/LEADER/rights`

| Kiểm chứng | Kết quả |
|---|---|
| Component | `catalog::si.vch.sigroupinfo-rights` ✅ |
| `groupName` | **LEADER** (nhận từ tham số `{group}`) ✅ |
| Combo "Phân hệ" | **13** option, mặc định "Tổng hợp" (`02.00.00`) ✅ |
| Combo "Số liệu" | **9** option, mặc định "Số liệu" (`02.10.00`) ✅ |
| Bảng chức năng | **9 dòng**: Phiếu kế toán `02.10.02`, Kết chuyển tự động `02.10.05`, ... ✅ |
| Header bảng | `# / Chức năng / Xem / Thêm / Sửa / Xoá` ✅ |
| `errorMessage` | `null` ✅ |

### Test lọc

| Thao tác | Kết quả |
|---|---|
| Chọn "Mua hàng" (`10.00.00`) | 5 số liệu, tự chọn `10.10.00`, bảng hiện **22 chức năng** `10.10.xx` ✅ |

### Test lưu quyền

Baseline `sysGroupRight`: **0 dòng**

| Bước | Kết quả |
|---|---|
| Tick "Xem" chức năng `02.10.02` | `viewRight = true` |
| Bấm "Lưu" | message **"Đã lưu phân quyền cho nhóm LEADER."** |
| Kiểm DB | **1 dòng**: `LEADER \| 02.10.02 \| view=1 ins=0 upd=0 del=0` — **`ViewRight` tự bật `true`** đúng form gốc ✅ |
| Bỏ tick + Lưu | `sysGroupRight` về **0 dòng** ✅ (chỉ Delete, không Insert) |

**Sau test — DB sạch baseline:**

```
sysGroupRight: 0 dong  (baseline 0)
sysGroupInfo : 13 dong (khong dung)
```

### Điều hướng

| Từ | Đến |
|---|---|
| Nút "Phân quyền" ở danh sách (13 nút) | `/simba/si/vch/sigroupinfo/{group}/rights` ✅ |
| Nút "Thoát" | `/simba/si/vch/sigroupinfo` ✅ |

### 3 thay đổi hạ tầng kèm theo

#### 1. Shell route `/{module}/{kind}/{slug}/{id}/{action}`

Trước: shell chỉ có `/create` và `/{id}/edit`. Route `.../sigroupinfo/{group}/rights` trả **404**.

Thêm vào `routes/web.php`:

```php
Route::get('/{module}/{kind}/{slug}/{id}/{action}', SimbaPage::class)
    ->where([... 'action' => '[a-z0-9-]+'])
    ->name('sub');
```

#### 2. `SimbaMenuTargetResolver::resolveActionPath()` — cho phép action tuỳ ý

Trước: chỉ nhận `create` / `edit`, action khác → `return null` → 404.

Sau: nhận mọi action khớp `[a-z0-9-]+` nếu route `{module}.{kind}.{slug}.{action}` tồn tại.

#### 3. Map `$id` vào ĐÚNG tên tham số route

Trước: luôn gán `params['id'] = $id` → `mount(string $group)` nhận rỗng.

Sau: thêm `dynamicParamName($route)` → `params['group'] = $id` cho route `{group}`,
vẫn giữ thêm `params['id']` để tương thích ngược.

#### 4. Auto-register bỏ qua class `*Rights`

Route có tham số không auto được → khai báo tay trong `$sourceRoutes`.
Thêm `Rights` vào danh sách skip để không sinh route rác `si.vch.sigroupinforights`.

### Test

| Test | Kết quả |
|---|---|
| `SourceRouteCoverageTest` | **11 tests / 46 assertions PASS** |
| `SimbaMenuRouteMetadataTest` | **13 tests / 29 assertions PASS** |

> Test `SourceRouteCoverageTest` đã cập nhật: cho phép component có route con
> (`{base}.{action}`) và thêm `si.vch.sigroupinfo.rights` vào danh sách route khai báo tay.

### 5. Nút "Phân quyền" — chuyển sang THANH CÔNG CỤ (theo SimbaERP)

**Sếp chỉ ra:** SimbaERP có nút **"Phân quyền"** ở thanh công cụ, tác động lên **dòng đang chọn** —
không phải link riêng từng dòng như em làm ban đầu.

**Đã sửa:**

| Trước | Sau |
|---|---|
| link "Phân quyền" ở **từng dòng** (13 link) | nút ở **thanh công cụ**, cạnh Mới/Sửa/Xoá |
| bấm là vào ngay | phải **chọn dòng trước**, nút mới bật |
| không có trạng thái chọn | dòng được chọn **tô nền xanh**, có nhãn "đang chọn `<mã>`" |

**Cơ chế mới:**

```php
public ?string $selectedGroupName = null;   // dong dang chon

public function selectGroup(string $groupName): void
{
    $this->selectedGroupName = $groupName;
}

public function selectedRightsUrl(): ?string
{
    return url('/simba/si/vch/sigroupinfo/' . rawurlencode($this->selectedGroupName) . '/rights');
}
```

View dòng: `wire:click="selectGroup(...)"` + `@class(['bg-sky-100' => $selectedGroupName === ...])`.

**Nút Sửa / Xoá / Phân quyền** đều `@disabled(null === $selectedGroupName)` → mờ khi chưa chọn.

**Verify:**

| Trạng thái | Nút "Phân quyền" | Sửa/Xoá |
|---|---|---|
| Ban đầu | `<span>` mờ, không link | **disabled** |
| Chọn LEADER | `<a href=".../LEADER/rights">` | **enabled** |
| Bấm nút sau khi chọn PO | vào `/simba/si/vch/sigroupinfo/PO%20/rights`, `group="PO "`, 13 phân hệ | ✅ |

### ⚠️ Dữ liệu gốc có dấu cách: nhóm `PO `

Kiểm `sysGroupInfo`:

```
[PO ] len=2 bytes=6     <- co 1 dau cach cuoi
[AP]  len=2 bytes=4
[SI]  len=2 bytes=4
```

→ Nhóm `PO` trong DB SimbaERP **lưu kèm dấu cách cuối**. Đây là **dữ liệu gốc**, không sửa.

**Xử lý:**

- So sánh dùng `trim()` (không sửa giá trị)
- URL dùng `rawurlencode()` → `/PO%20/rights`
- Route `where('group', '[^/]+')` chấp nhận `%20`
- Verify: `/simba/si/vch/sigroupinfo/PO%20/rights` → 200, `group="PO "`, 571 quyền

> Đây là **quirk dữ liệu cần biết** khi làm các màn khác đọc `sysGroupInfo`.

### 6. Bỏ 2 nút ở từng dòng — chỉ dùng thanh công cụ

**Sếp chỉ ra:** để cả 2 nút Sửa/Xoá ở thanh công cụ **luôn**, bỏ khỏi từng dòng.

**Trước:**

| Vị trí | Nút |
|---|---|
| Thanh công cụ | Mới, Sửa, Xoá, Phân quyền |
| Từng dòng (cột "Thao tác") | Sửa, Xoá |

**Sau:**

| Vị trí | Nút |
|---|---|
| Thanh công cụ | **Mới, Sửa, Xoá, Phân quyền** (duy nhất) |
| Từng dòng | **không có nút nào** — chỉ click để chọn |

Cột "Thao tác" đã bỏ khỏi header → bảng còn 5 cột:
`# / Tên nhóm / Tên đầy đủ / Phân lại quyền / KSD`

**Guard bổ sung:** `delete()` và `openEdit()` giờ kiểm tra rỗng trước khi chạy
(vì nút toolbar truyền `$selectedGroupName` có thể `null`):

```php
if ('' === trim($groupName)) {
    $this->errorMessage = 'Chưa chọn nhóm để xoá.';   // hoac '... de sua.'
    return;
}
```

**Verify:**

| Kiểm chứng | Kết quả |
|---|---|
| Header bảng | `# / Tên nhóm / Tên đầy đủ / Phân lại quyền / KSD` — không còn "Thao tác" ✅ |
| Nút trong dòng | **0** ✅ |
| Toolbar ban đầu | Mới ✅ / Sửa ❌ / Xoá ❌ / Phân quyền (span mờ) ✅ |
| Chọn LEADER | Mới / **Sửa** / **Xoá** / **Phân quyền** (có href) ✅ |
| Bấm "Sửa" từ toolbar (nhóm AR) | form mở, `isEdit=true`, `groupName=AR`, `nameDisabled=true` ✅ |
| Gọi `delete('')` | `"Chưa chọn nhóm để xoá."`, **không xoá gì** ✅ |
| Gọi `openEdit('')` | `"Chưa chọn nhóm để sửa."`, form không mở ✅ |

**DB sau test:** `sysGroupInfo` 13 dòng, `sysGroupRight` 0 dòng — đúng baseline.

### 7. Multiselect — selection trên CLIENT (Alpine), không round-trip

**Sếp yêu cầu:** thêm multiselect, và chuyển selection từ Livewire sang **client-side**.

**Trước (Livewire):**

```blade
<tr wire:click="selectGroup('{{ $group['groupname'] }}')">
```

Mỗi click = **1 request Livewire** → chậm, giật khi chọn nhiều dòng.
Chỉ chọn được **1 dòng**.

**Sau (Alpine):**

```blade
<div class="w-full" x-data="sigroupinfoList(@js($groups->pluck('groupname')->values()))" x-init="init()">
```

```js
window.sigroupinfoList = function(pageGroups) {
    return {
        selected: [],                        // mang ma nhom dang chon
        pageGroups: pageGroups.map(String),

        isSelected(name),                    // kiem tra 1 dong
        toggleRow(name),                     // bat/tat 1 dong
        toggleAll(checked, names),           // chon bo / bo chon ca trang
        allSelected(),                       // da chon het trang?
        isSingleSelected(),                  // chon dung 1 dong?
        editSelected(),                      // $wire.call('openEdit', ...)
        deleteSelected(wire),                // confirm + $wire.call('deleteMany', [...])
        rightsUrl(),                         // URL man phan quyen
    };
};
```

**Chỉ round-trip server khi bấm nút:** Sửa (1 dòng) / Xoá (1..n) / Phân quyền (1 dòng).

### Multiselect

| Tính năng | Chi tiết |
|---|---|
| Checkbox mỗi dòng | bấm vào ô hoặc cả dòng đều toggle |
| Checkbox header | chọn / bỏ chọn **tất cả trang hiện tại** |
| Chọn nhiều dòng | tô nền xanh, nhãn "đã chọn N" |
| Nút **Sửa** | chỉ bật khi chọn **đúng 1** dòng |
| Nút **Xoá** | bật khi chọn **≥1** dòng, confirm `"Xoá N nhóm: A, B, ...?"` |
| Nút **Phân quyền** | chỉ hiện link khi chọn **đúng 1** dòng |

### Thêm `deleteMany()`

```php
public function deleteMany(array|string $groupNames): void
{
    // loc rong, trim
    // xoa tung nhom bang asSiDelGroupInfo
    // bao success / error theo ket qua tung nhom
}
```

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Cột header | `"" (checkbox) / # / Tên nhóm / Tên đầy đủ / Phân lại quyền / KSD` — **không còn "Thao tác"** ✅ |
| Checkbox mỗi dòng | 13 ✅ |
| Click 3 dòng thật | `["AP","AR","CO"]`, 3 dòng tô xanh, "đã chọn 3" ✅ |
| **Livewire request khi click** | **0** — selection hoàn toàn client ✅ |
| Chọn 3 dòng | Sửa **disabled**, Xoá **enabled** ✅ |
| Chọn 1 dòng (`LEADER`) | `isSingleSelected=true`, `rightsUrl=/simba/si/vch/sigroupinfo/LEADER/rights` ✅ |
| Select all (header) | **13** dòng, `allSelected=true` ✅ |
| Bấm Xoá (2 dòng) | confirm `"Xoá 2 nhóm: CA, CO?"`; **Huỷ** → không xoá ✅ |
| `deleteMany([])` | `"Chưa chọn nhóm để xoá."` — không xoá gì ✅ |

**DB sau test:** `sysGroupInfo` 13 dòng, `sysGroupRight` 0 dòng — đúng baseline.

### 8. 🐛 BUG: nút "Phân quyền" vô hình — class Tailwind không tồn tại trong CSS build

**Sếp báo:** "anh vẫn chưa thấy nút phân quyền".

**Chẩn đoán:** nút **có trong DOM, đúng toạ độ** (`x=1064, y=79, w=97, h=32`),
`display: block`, `elementFromPoint` trả về chính nó — nhưng **mắt không thấy**.

**Nguyên nhân:** class `bg-emerald-600` **KHÔNG có trong CSS build**.

```
grep "bg-emerald-600" public/build/assets/*.css   -> 0 ket qua
grep "bg-blue-600"    public/build/assets/*.css   -> co
grep "bg-green-600"   public/build/assets/*.css   -> co
```

`tailwind.config.js` chỉ scan `diepxuan/*/resources/views/**`, nhưng Tailwind **purge**
class không được dùng ở bất kỳ file nào **tại thời điểm build**. `emerald-600` chưa
từng dùng → không vào CSS → chữ trắng trên **nền trắng** = vô hình.

**Fix:** đổi `emerald` → `green` (đã có trong build):

```blade
- class="... bg-emerald-600 ... hover:bg-emerald-700"
+ class="... bg-green-600 ... hover:bg-green-700"
```

**Verify sau fix:**

| Kiểm chứng | Kết quả |
|---|---|
| Nút hiển thị | nền **xanh lá**, chữ trắng — thấy rõ ✅ |
| Bấm nút (chọn LEADER) | vào `/simba/si/vch/sigroupinfo/LEADER/rights` ✅ |
| Component | `catalog::si.vch.sigroupinfo-rights`, `group=LEADER` ✅ |
| Combos | **13** phân hệ, **9** số liệu ✅ |
| Quyền | **571** dòng, `err=null` ✅ |

### 📌 Bài học — Tailwind purge

> Khi thêm class Tailwind **mới** (màu/spacing chưa dùng ở đâu), phải **rebuild CSS**
> (`npm run build`) — nếu không class không tồn tại và element **vô hình/không style**
> dù DOM hoàn toàn đúng.
>
> Cách phát hiện: `grep "<class>" public/build/assets/*.css`
> — nếu không có kết quả thì class chưa được build.
>
> **Ưu tiên dùng class đã có** trong build để tránh phải rebuild.

### 9. Bố cục toolbar + form phân quyền không cần tham số (theo Sếp)

**4 yêu cầu của Sếp:**

| # | Yêu cầu | Đã làm |
|---|---|---|
| 1 | Nút Phân quyền ra **sau cùng** | ✅ nằm cuối nhóm nút |
| 2 | Dòng "13 nhóm · đã chọn N" **nhỏ lại**, ra **sau search box** | ✅ `text-xs`, sát ngay sau input |
| 3 | Nút Phân quyền **căn phải** | ✅ `justify-between` → cách mép phải **0px** |
| 4 | Form phân quyền **không cần truyền gì**, không bắt buộc chọn dòng | ✅ route bỏ `{group}`, form tự chọn nhóm |

### Bố cục mới

```
[ Tìm kiếm... ] 13 nhóm · đã chọn 2              [Mới] [Sửa] [Xoá] [Phân quyền]
                                                                     ↑ cuối, sát phải
```

### Route đổi: bỏ tham số `{group}`

```diff
- si/vch/sigroupinfo/{group}/rights    → /simba/si/vch/sigroupinfo/LEADER/rights
+ si/vch/sigroupinfo/rights            → /simba/si/vch/sigroupinfo/rights
```

`SigroupinfoRights::mount()` giờ:
1. Nạp **danh sách nhóm** (`AsGetGroupInfo('')` → 13 nhóm)
2. Nếu có `?group=` trên URL và hợp lệ → dùng
3. Không thì **chọn nhóm đầu tiên**
4. Nạp quyền + menu

`updatedGroupName()` → đổi nhóm thì nạp lại quyền ngay.

### View: thêm dropdown "Nhóm"

3 combo thay vì 2:

```
Nhóm      [LEADER — Lãnh đạo doanh nghiệp (CEO,CFO...)  ▼]
Phân hệ   [Tổng hợp                                       ▼]
Số liệu   [Số liệu                                        ▼]
```

### ⚠️ 2 class Tailwind không có trong build

| Class dùng | Có trong build? | Thay bằng |
|---|---|---|
| `ml-auto` | ❌ **0 kết quả** | `justify-between` (có sẵn) |
| `w-72` | ❌ **0 kết quả** | `w-full max-w-md` (có sẵn) |

→ Đây là **lần thứ 2** gặp lỗi này (lần trước `bg-emerald-600`). Xem §8 bài học Tailwind purge.

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Nút Phân quyền khi **chưa chọn dòng** | `href` đúng, `disabled=false` ✅ |
| Bấm nút (chưa chọn) | vào `/simba/si/vch/sigroupinfo/rights` ✅ |
| Form tự chọn nhóm | dropdown **13 nhóm**, mặc định `AP — Phải trả` ✅ |
| Đổi nhóm sang LEADER | `group=LEADER`, **571** quyền, `err=null` ✅ |
| Toolbar | `gapToRight = 0` — Phân quyền sát mép phải ✅ |
| Đếm nhóm | `text-xs`, ngay sau search ✅ |

### Shell route mới: `/{module}/{kind}/{slug}/{action}`

Route `/simba/si/vch/sigroupinfo/rights` (4 đoạn) trước trả **404** — shell chỉ có
3 đoạn hoặc 5-6 đoạn. Đã thêm:

```php
Route::get('/{module}/{kind}/{slug}/{action}', SimbaPage::class)
    ->where(['action' => '[a-z0-9-]+'])
    ->name('sub-action');
```
