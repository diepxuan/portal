# Model Layer Behavior Audit Baseline

Generated: 2026-06-22T02:01:32+00:00
Source: `diepxuan/laravel-simba/src/Models`
Total Models: 445
With behavior: 28

## Phân loại

- `keep_simba`: scope/relation/accessor đọc trực tiếp field schema, hoặc method kiểu `isXxx()/getXxx()` parse enum/display từ field. Phù hợp giữ ở Simba Models.
- `move_catalog`: business logic, tính toán, mở service, ngữ nghĩa nghiệp vụ (KH/NCC/NV). Nên tách sang `diepxuan/laravel-catalog`.

## Bảng behavior

| File | scop | rel | acc | mut | meth | boot | classification | chi tiết |
|------|------|-----|-----|-----|------|------|----------------|----------|
| `ApCt1.php` | 7 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterBySoHd, FilterByMaNcc, FilterByMaBp, FilterByMaNt, FilterByNgayHd...<br/>rel: apDmNcc:belongsTo, sysDepartment:belongsTo, glDmTk:belongsTo |
| `ArCt1.php` | 7 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterBySoHd, FilterByMaKh, FilterByMaBp, FilterByMaNt, FilterByNgayHd...<br/>rel: arDmKh:belongsTo, sysDepartment:belongsTo, glDmTk:belongsTo |
| `ArDmKh.php` | 5 | 1 | 3 | 0 | 0 | - | `move_catalog` | scope: LaKhachHang, LaNhaCungCap, LaNhanVien, Search, OrderByMaKh<br/>rel: glCts:hasMany<br/>acc: IsKhachHang, IsNhaCungCap, IsNhanVien |
| `ArDmNhKh.php` | 2 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: Search, OrderByMaNhkh |
| `ArDmPlKh.php` | 3 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: Loai, Search, OrderByMaPlkh |
| `CaCt1.php` | 6 | 4 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByTk, FilterByTkList, FilterByMaKh, FilterByMaBp, FilterByNgayCt<br/>rel: caPh3:belongsTo, glDmTk:belongsTo, arDmKh:belongsTo, sysDepartment:belongsTo |
| `FaDmLk.php` | 4 | 1 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByMaTs, FilterByMaLk, FilterByKsd<br/>rel: faDmTs:belongsTo |
| `GlCdTk.php` | 2 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByTkList, FilterByMaNt |
| `GlCt.php` | 4 | 1 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByTkList, FilterByTkduList, FilterByMaBp, FilterByMaNt<br/>rel: arDmKh:belongsTo |
| `GlCt1.php` | 6 | 4 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByTk, FilterByTkList, FilterByMaKh, FilterByMaBp, FilterByMaNt<br/>rel: glDmTk:belongsTo, arDmKh:belongsTo, sysDepartment:belongsTo, glCt:belongsTo |
| `InDmKho.php` | 7 | 4 | 0 | 0 | 3 | - | `move_catalog` | scope: FilterByMaCty, FilterByMaKho, FilterByTenKho, FilterByKhoDl, FilterByKsd, Active...<br/>rel: glDmTk:belongsTo, inDmViTri:hasMany, inCtNhap:hasMany, inCtXuat:hasMany<br/>meth: getInventoryByProduct, getInventoryList, getInventoryValue |
| `InDmNhvt.php` | 2 | 2 | 0 | 0 | 0 | - | `keep_simba` | scope: IsRoot, HasParent<br/>rel: catChildrens:hasMany, catParent:belongsTo |
| `InDmVt.php` | 1 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: WithQuantity |
| `MmCt3.php` | 6 | 6 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterBySoDh, FilterByMaVt, FilterByMaKho, FilterByMaLo, FilterByMaBp<br/>rel: mmPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo, inDmViTri:belongsTo, inDmLo:belongsTo |
| `PoCp3.php` | 2 | 1 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCp, FilterByMaBp<br/>rel: poPh3:belongsTo |
| `PoCt1.php` | 6 | 8 | 0 | 0 | 1 | - | `move_catalog` | scope: FilterByMaCty, FilterByMaVt, FilterByMaKho, FilterByMaNcc, FilterByMaBp, FilterByNgayCt<br/>rel: poPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo, inDmViTri:belongsTo, inDmLo:belongsTo<br/>meth: getReceiptRate |
| `PoCt3.php` | 2 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaVt, FilterByMaKho<br/>rel: poPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo |
| `PoPh3.php` | 3 | 3 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterBySearch, FilterByMaKh, FilterByNgayCt<br/>rel: chiTiets:hasMany, chiPhis:hasMany, nhaCungCap:belongsTo |
| `SiDmCt.php` | 2 | 0 | 0 | 0 | 2 | - | `keep_simba` | scope: Voucher, MenuId<br/>meth: headerFieldsForInventory, detailFieldsForInventory |
| `SoCt1.php` | 7 | 7 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByMaCty, FilterByMaVt, FilterByMaKho, FilterByMaKh, FilterByMaNvkd, FilterByMaBp...<br/>rel: soPh3:belongsTo, inDmVt:belongsTo, inDmKho:belongsTo, inDmViTri:belongsTo, inDmLo:belongsTo |
| `SoPh3.php` | 1 | 0 | 0 | 0 | 0 | - | `keep_simba` | scope: FilterByNgayCt |
| `SysCompany.php` | 0 | 3 | 0 | 0 | 1 | - | `move_catalog` | rel: userRights:hasMany, resx:hasMany, users:belongsToMany<br/>meth: resxByLanguage |
| `SysCompanyResx.php` | 0 | 2 | 0 | 0 | 0 | - | `keep_simba` | rel: language:belongsTo, company:belongsTo |
| `SysDictionaryInfo.php` | 2 | 0 | 0 | 0 | 2 | - | `keep_simba` | scope: CodeName, MenuId<br/>meth: primaryKeyFields, carryFields |
| `SysLanguage.php` | 2 | 2 | 0 | 0 | 0 | - | `keep_simba` | scope: IsEnable, Current<br/>rel: resx:hasMany, companies:belongsToMany |
| `SysMenu.php` | 0 | 0 | 0 | 0 | 8 | - | `keep_simba` | meth: getDisplayName, getParentMenuId, isRoot, isGroup, isVoucher, isMasterData |
| `SysUserCompanyRight.php` | 0 | 2 | 0 | 0 | 0 | - | `keep_simba` | rel: user:belongsTo, company:belongsTo |
| `SysUserInfo.php` | 3 | 2 | 0 | 0 | 0 | - | `keep_simba` | scope: IsEnable, IsAdmin, IsGrand<br/>rel: companyRights:hasMany, companies:belongsToMany |

## Tổng hợp classification

| Classification | Count |
|----------------|-------|
| `keep_simba` | 24 |
| `move_catalog` | 4 |

## Plan tiếp theo

### move_catalog (cần tách sang laravel-catalog)

- `ArDmKh.php`
  - accessors: IsKhachHang, IsNhaCungCap, IsNhanVien
- `InDmKho.php`
  - methods: getInventoryByProduct, getInventoryList, getInventoryValue
- `PoCt1.php`
  - methods: getReceiptRate
- `SysCompany.php`
  - methods: resxByLanguage

### Cách tái tạo audit

```bash
php scripts/audit-model-layer-responsibility.php          # bảng tóm tắt
php scripts/audit-model-layer-responsibility.php --json   # JSON đầy đủ
php scripts/audit-model-layer-responsibility.php --filter=ApCt1
```
