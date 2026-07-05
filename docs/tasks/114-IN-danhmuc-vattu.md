# Task 114: INDMVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang danh muc vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INDMVT.dll
- **Chuc nang:** Danh muc vat tu
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc vat tu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMVT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMVT (Danh muc vat tu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_vt | varchar | 50 | Ma vat tu (khoa chinh) |
| ten_vt | nvarchar | 200 | Ten vat tu |
| dvt | nvarchar | 20 | Don vi tinh |
| ma_nhvt | varchar | 50 | Ma nhom vat tu |
| loai | int | - | Loai vat tu |
| gia_ton | int | - | Phuong phap gia ton |
| ma_kho | varchar | 50 | Kho mac dinh |
| ma_thue | varchar | 50 | Ma thue GTGT |
| tk_vt | varchar | 50 | TK vat tu (kho) |
| tk_dt | varchar | 50 | TK doanh thu |
| tk_dtnb | varchar | 50 | TK doanh thu noi bo |
| tk_gv | varchar | 50 | TK gia von |
| tk_tl | varchar | 50 | TK tra lai |
| tk_ck | varchar | 50 | TK chiet khau |
| sl_min | decimal | - | Ton toi thieu |
| sl_max | decimal | - | Ton toi da |
| gia_nt0 | decimal | - | Gia mua |
| gia_nt2 | decimal | - | Gia ban |
| ts_gtgt | decimal | - | Thue suat GTGT |
| ts_nk | decimal | - | Thue suat NK |
| ts_xk | decimal | - | Thue suat XK |
| ts_ttdb | decimal | - | Thue suat TTDN |
| dvt_mua | nvarchar | 20 | DVT mua |
| dvt_ban | nvarchar | 20 | DVT ban |
| hs_dvtmua | decimal | - | He so DVT mua |
| hs_dvtban | decimal | - | He so DVT ban |
| ton_kho | bit | 1 | Theo doi ton kho |

---

## Form classes

### 1. frmINDMVT (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmINDMVTEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:** txtMa_Vt, txtTen_Vt, cboDvt, txtMa_Nhvt, cboLoai, cboGia_ton, txtMa_kho, txtMa_Thue, cac TK, txtSl_min, txtSl_max, txtGia_nt0, txtGia_nt2, txtTs_Gtgt, cac DVT, chkTon_kho

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_DMVT_GET | Lay danh sach vat tu |
| SP_IN_DMVT_GETBYID | Lay chi tiet 1 vat tu |
| SP_IN_DMVT_INSERT | Them vat tu moi |
| SP_IN_DMVT_UPDATE | Cap nhat vat tu |
| SP_IN_DMVT_DELETE | Xoa vat tu |
| SP_IN_DMVT_FIND | Tim kiem vat tu |
| SP_IN_DMVT_CHECK | Kiem tra trung ma |

---

## Business Logic

### Business Rules

1. **Don vi tinh**: Kho, mua, ban co he so chuyen doi
2. **Gia ton kho**: Phuong phap tinh gia (1=thap hon, 2=NTXT, ...)
3. **Tai khoan**: Tu dong dien tu nhom vat tu khi chon ma_nhvt
4. **Ton kho**: Chi tiet ton kho khi ton_kho=1

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/DMVT.php
namespace Diepxuan\Simba\Models\IN;

class DMVT extends Model
{
    protected $table = 'DMVT';
    protected $primaryKey = 'ma_vt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_vt', 'ten_vt', 'dvt', 'ma_nhvt', 'loai', 'gia_ton',
        'ma_kho', 'ma_thue', 'tk_vt', 'tk_dt', 'tk_dtnb', 'tk_gv',
        'tk_tl', 'tk_ck', 'sl_min', 'sl_max', 'gia_nt0', 'gia_nt2',
        'ts_gtgt', 'ts_nk', 'ts_xk', 'ts_ttdb', 'dvt_mua', 'dvt_ban',
        'hs_dvtmua', 'hs_dvtban', 'ton_kho',
    ];

    protected $casts = [
        'ton_kho' => 'boolean',
        'sl_min' => 'decimal:8', 'sl_max' => 'decimal:8',
        'gia_nt0' => 'decimal:8', 'gia_nt2' => 'decimal:8',
    ];

    public function nhomVatTu()
    {
        return $this->belongsTo(DMNHVT::class, 'ma_nhvt', 'ma_nhvt');
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/vat-tu', [Vattu::class, 'render'])->name('vat-tu');
        Route::get('/vat-tu/edit/{maVt?}', [VattuEdit::class, 'render'])->name('vat-tu.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model DMVT
- [ ] Tao Livewire Vattu va VattuEdit
- [ ] Tao Views (list + edit voi nhieu field)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test AutoLookup tai khoan tu nhom VT
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** IMPLEMENTED locally (CRUD UI + doi ma + BOM sync), pending commit/PR because current sandbox cannot write `.git`.
- **Route:** `in.dict.indmvt`
- **URL:** `/_simba-source/in/dict/indmvt` -> `/simba/in/dict/indmvt`
- **Component:** `Diepxuan\Catalog\Http\Livewire\In\Dict\IndmvtPage`
- **View:** `catalog::in.dict.indmvt`
- **Note:** Route/component folder structure follows `module/kind/slug`, same convention as `Po\Dict\Ardmkh`.

## Implementation Update 2026-06-26

### Simba audit corrections

Task content above was generated from an older abstraction and contains non-authoritative names such as `DMVT`, `SP_IN_DMVT_*`, `INDVVT`, and `MA_BOM`. Current implementation uses only names verified from `simba-docs`:

| Source | Verified value |
|--------|----------------|
| `simba-docs/data/sysMenu.md` | menu `14.90.02`, module `IN`, DLL `INDMVT`, form `AsiaErp.UserInterface.frmINDMVT`, code `MA_VT` |
| `simba-docs/data/sysDictionaryInfo.md` | dictionary `MA_VT`, PK `MA_CTY,MA_VT`, edit form `frmINDMVTEdit` |
| `simba-docs/data/sysDAOInfo.md` | `INDMVT` -> `asINGetDMVT`, `asINInsDMVT`, `asINUpdDMVT`, `asINDelDMVT` |
| `simba-docs/tables/InDmVt.md` | main table `InDmVt`, PK `ma_cty, ma_vt` |
| `simba-docs/tables/InDmBom.md` | BOM table `InDmBom`, PK `ma_cty, ma_vt, ma_lk` |
| `simba-docs/procedures/IN/procedures.md` | BOM SPs `asINGetDMBOM`, `asINInsDMBOM`, `asINUpdDMBOM`, `asINDelDMBOM` |

### Completed locally

- Replaced markdown-only `INDMVT` screen with Livewire component `In\Dict\Indmvt` following route folder structure.
- Added searchable/selectable material list loaded through `InDmVt::getAsINGetDMVT`.
- Added create/edit form for audited `InDmVt` fields: item identity, units, stock flags, group/kho/vitri, accounting accounts, tax/classification, price/quantity thresholds, manufacturer/distributor notes.
- Added group lookup auto-fill for accounting fields from `InDmNhvt` when empty.
- Added write/delete through audited SPs using `ProcedureCaller`: `asINInsDMVT`, `asINUpdDMVT`, `asINDelDMVT`. Insert/update check output `pRet`; delete follows the audited signature without `pRet`.
- Added BOM load and sync in the same transaction using `asINGetDMBOM`, `asINInsDMBOM`, `asINUpdDMBOM`, `asINDelDMBOM`. BOM insert/update check output `pRet`; BOM delete follows the audited signature without `pRet`.
- Added validation for required fields, audited max lengths, numeric fields, duplicate BOM components, BOM quantity > 0, and component not equal to parent item.
- Moved the large create/edit form above the list and added auto-scroll to the form when opening create/edit, so users do not need to scroll through long material lists before editing.
- Updated `SourceRouteCoverageTest` expected component class to `In\Dict\Indmvt`.
- Updated `docs/project/simba-router-menu-matrix.md` route/class mapping.

### Interaction Update 2026-06-27

- Added `Đổi mã` action for selected rows and toolbar selection.
- Audited `Đổi mã` against `simba-docs/data/sysDAOInfo.md` and `simba-docs/data/sysDictionaryInfo.md`: `INDMVT` uses `asDoiMa`, dictionary code field `MA_VT`, max length `20`.
- Implemented rename form at the top of the screen, mutually exclusive with the create/edit form, and auto-scrolls to `#indmvt-rename-form` when opened.
- `renameItem()` validates old code exists, new code is required/max 20/different, and new code does not already exist in the loaded material list before calling `AsDoiMa` with `pTable_name=INDMVT` and `pCode_name=MA_VT`.
- Added fixed `Lên đầu` button for long page scroll.

### Deliberate limits

- `asINInsDMVT` has params `pDvdg`, `pQcdg` and `asINUpdDMVT` has `pMa_lo`, but matching `InDmVt` columns were not confirmed in `simba-docs/tables/InDmVt.md`. Implementation passes defaults only to satisfy the audited procedure signatures and does not expose unverified UI fields.
- No SQL DDL/DML was added. No table/SP/field names were invented.
- Commit and PR body updates were not performed because `.git` is read-only in the current sandbox and `gh auth status` reported invalid auth earlier in this session.

### Verification

- `php -l diepxuan/laravel-catalog/src/Http/Livewire/In/Dict/Indmvt.php` passed after `Đổi mã` update.
- `php -l diepxuan/laravel-catalog/routes/web.php` passed.
- `php -l diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php` passed.
- `php artisan route:list --path=_simba-source/in/dict/indmvt` shows `in.dict.indmvt` registered to the new component.
- `php artisan test diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php` passed: 6 tests, 154 assertions.
- `git diff --check` passed.
- `php artisan view:cache` could not run because the sandbox cannot append `storage/logs/laravel.log` or write compiled views under `storage/framework/views`; this is an environment permission blocker, not a code assertion failure.

---

## Progress Review 2026-06-29 (đang làm)

### Bối cảnh

Người dùng báo cáo: khi sửa một vật tư trong form Sửa/Thêm, đổi `dvt` từ "cái" sang "đôi" rồi chuyển sang field input tiếp theo, UI báo "đang xử lý", phải đợi ~30 giây mới tiếp tục sửa được. Khi có nhiều lần blur liên tiếp, thời gian đợi cộng dồn tới 14 giây mỗi lần chuyển field.

### Nguyên nhân đã xác nhận

1. `wire:model.blur` trên từng field gửi một Livewire request khi blur. Mỗi request phải:
   - Lấy session lock từ DB (driver `SESSION_DRIVER=database`).
   - Render lại toàn bộ component, gồm bảng ~1000 dòng vật tư.
   - Serialize HTML payload gửi về browser.
2. Vì component hiện tại gộp cả form + list + rename trong một component duy nhất (`Indmvt.php`, 773 dòng), mỗi lần blur form đều kéo theo serialize lại toàn bộ bảng, dẫn tới request nặng và serialize chậm.
3. Sau khi `save()` thành công, code gọi thêm `refreshData()` (5 SP) + `loadBomRows()` (1 SP) = 6 SP tuần tự qua SQL Server, làm thời gian phản hồi Lưu cũng kéo dài thêm ~2 giây.

### Phương án đã chọn

Tách component hiện tại thành 4 Livewire component nhỏ, giao tiếp qua events. Mục tiêu: khi người dùng gõ vào form Sửa/Thêm, chỉ component form re-render, không serialize lại bảng danh sách.

Cấu trúc mới:

| Component        | Trách nhiệm                                                  | View                       |
|------------------|--------------------------------------------------------------|----------------------------|
| `IndmvtPage`     | Component cha, mount các component con, không chứa logic nặng | `in/dict/indmvt.blade.php` |
| `IndmvtList`     | Search + bảng danh sách + chọn dòng                         | `in/dict/indmvt-list.blade.php` |
| `IndmvtForm`     | Form Sửa/Thêm vật tư + validate + BOM                        | `in/dict/indmvt-form.blade.php`  |
| `IndmvtRename`   | Form Đổi mã vật tư                                          | `in/dict/indmvt-rename.blade.php` |

Giao tiếp giữa các component (Livewire events):

- `IndmvtList` → `IndmvtForm`: phát `indmvt-list.item-selected` (mã VT), `IndmvtForm` nghe và mở form sửa.
- `IndmvtList` → `IndmvtForm`: phát `indmvt-list.create-clicked`, `IndmvtForm` mở form thêm.
- `IndmvtForm` → `IndmvtList`: phát `indmvt-form.saved` (mã VT), `IndmvtList` chỉ refresh đúng 1 dòng đó (không gọi lại toàn bộ danh sách).
- `IndmvtRename` → `IndmvtList`: phát `indmvt-rename.saved` (mã cũ + mã mới), `IndmvtList` cập nhật key `ma_vt` trong rows.

### Tiến độ

| # | Công việc                                                            | Trạng thái        |
|---|----------------------------------------------------------------------|-------------------|
| 1 | Audit: xác định state cần chia sẻ                                   | DONE              |
| 2 | Tạo `IndmvtList` (PHP)                                              | DONE (160 dòng)   |
| 3 | Tạo `indmvt-list.blade.php`                                         | DONE (95 dòng)    |
| 4 | Tạo `IndmvtForm` (PHP) + view form                                  | DONE              |
| 5 | Tạo `IndmvtRename` (PHP) + view đổi mã                              | DONE              |
| 6 | Tạo `IndmvtPage` (cha) mount các component con                       | DONE              |
| 7 | Cập nhật `routes/web.php` để trỏ `in.dict.indmvt` về `IndmvtPage`    | DONE              |
| 8 | Cập nhật `SourceRouteCoverageTest` (component class đổi từ Indmvt sang IndmvtPage) | DONE |
| 9 | Xoá hoặc giữ file `Indmvt.php` cũ                                   | DONE — giữ file cũ làm fallback, route không còn trỏ vào class này |
| 10 | `php -l` + `git diff --check` + `phpunit` test                       | DONE              |
| 11 | Commit + push + mở PR `task/indmvt-split-components`                | BLOCKED — đã tạo branch local, chờ Sếp nói "Em tạo PR đi" trước khi commit/push/PR |

### Files đã tạo (chưa commit)

- `diepxuan/laravel-catalog/src/Http/Livewire/In/Dict/IndmvtList.php` (160 dòng, PHP syntax OK)
- `diepxuan/laravel-catalog/resources/views/in/dict/indmvt-list.blade.php` (95 dòng, PHP syntax OK)
- `diepxuan/laravel-catalog/src/Http/Livewire/In/Dict/IndmvtForm.php`
- `diepxuan/laravel-catalog/resources/views/in/dict/indmvt-form.blade.php`
- `diepxuan/laravel-catalog/src/Http/Livewire/In/Dict/IndmvtRename.php`
- `diepxuan/laravel-catalog/resources/views/in/dict/indmvt-rename.blade.php`
- `diepxuan/laravel-catalog/src/Http/Livewire/In/Dict/IndmvtPage.php`

### Verification Update 2026-06-29

- `php -l` passed for `Indmvt.php`, `IndmvtList.php`, `IndmvtForm.php`, `IndmvtRename.php`, `IndmvtPage.php`, `routes/web.php`, `SourceRouteCoverageTest.php`.
- `composer dump-autoload` passed and package discovery completed.
- `php artisan route:list --path=_simba-source/in/dict/indmvt` shows route `in.dict.indmvt` registered.
- `php artisan test diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php` passed: 6 tests, 154 assertions.
- `git diff --check` passed.
- `php -r` autoload check confirmed `IndmvtPage` and `IndmvtRename` classes exist.
- `Livewire::mount()` check passed for `catalog::in.dict.indmvt-rename`, `catalog::in.dict.indmvt-form`, `catalog::in.dict.indmvt-list`, `catalog::in.dict.indmvt-page` after fixing root elements.
- `php artisan view:clear` passed to remove compiled Blade from the pre-fix render.
- `php artisan cache:clear` could not run in this CLI because cache uses MySQL and `mysql.diepxuan.corp` DNS is not resolvable here.
- `php artisan view:cache` blocked before compiling the edited view because missing existing directory `diepxuan/laravel-core/resources/views`.

### Runtime Fix 2026-06-29

- Log khi truy cập `/simba/in/dict/indmvt` báo `RootTagMissingFromViewException` từ Livewire.
- Nguyên nhân: view con `indmvt-rename.blade.php` có thể render rỗng khi form đổi mã đang ẩn, và `indmvt-form.blade.php` có nhiều root element (`@if` message + form + datalist).
- Fix: bọc `indmvt-form.blade.php` và `indmvt-rename.blade.php` trong một root `<div class="space-y-3">` cố định.

### Quyết định triển khai 2026-06-29

1. Giữ `Indmvt.php` cũ làm fallback tạm thời, nhưng route `in.dict.indmvt` không còn trỏ vào class này.
2. Giữ view path `catalog::in.dict.indmvt`, đổi nội dung thành page wrapper mount `IndmvtRename`, `IndmvtForm`, `IndmvtList`.
3. Giữ nguyên route name `in.dict.indmvt`; chỉ đổi component class gắn vào route từ `Indmvt::class` sang `IndmvtPage::class`.
4. Không commit/push/PR trong bước này vì Sếp chưa nói "Em tạo PR đi".

### Lợi ích kỳ vọng

- Khi người dùng gõ vào form Sửa/Thêm, chỉ `IndmvtForm` re-render (payload nhỏ, ~10 field + BOM). Bảng không bị serialize lại → thời gian blur giảm từ ~30s xuống còn ~0.5s (chỉ sync 1 property).
- Sau khi `save()` thành công, `IndmvtList.refreshRow()` chỉ load 1 dòng qua `asINGetDMVT` với `pMa_vt = $maVt` thay vì toàn bộ danh sách → tiết kiệm ~1.5s.
- Sau khi `renameItem()` thành công, chỉ cập nhật 1 key trong `rows[]` thay vì gọi `refreshData()`.
- Tổng thời gian Lưu giảm từ ~10s (5 SP refresh) xuống ~1s (chỉ refresh 1 dòng).
