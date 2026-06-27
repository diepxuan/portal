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
- **Component:** `Diepxuan\Catalog\Http\Livewire\In\Dict\Indmvt`
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
