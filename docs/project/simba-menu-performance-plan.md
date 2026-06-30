# SimbaERP Menu Performance Plan

Ngay cap nhat: 2026-06-30

## Context

Trang `/simba` render Livewire `catalog::system.simba-erp-menus`. Debugbar truoc do cho thay `catalog::system.simba-node` render lap lai khoang 361 lan, dong thoi metadata menu nap nhieu Eloquent model: `SysMenu`, `Zsysmenu`, `SysReportInfo`, `ZSysReportInfo`, `SysDictionaryInfo`.

Muc tieu cua task nay la giam chi phi RAM/render truoc mat, va lap plan tiep theo cho huong lay toan bo metadata bang SP hoac mot query/join duy nhat.

## Stored Procedure review

Da kiem tra trong `Diepxuan\Simba\StoredProcedures` va `simba-docs`:

| SP wrapper | Simba SP | Nguon docs | Nhan dinh |
|---|---|---|---|
| `AsGetMenuBar` | `asGetMenuBar` | `simba-docs/asia/si/SMUserInfo.md`, `SMUserInfoDAO.GetMenuBar()` | Lay menu bar theo language, phu hop menu UI Simba goc, chua du metadata Portal route/report/dictionary. |
| `AsGetMenuDetail` | `asGetMenuDetail` | `SMUserInfoDAO.GetSubMenuBar()` | Lay submenu theo language, khong thay tham so module/menu trong wrapper hien tai; chua thay du field enrich route. |
| `AsGetMenuForm` | `asGetMenuForm` | `SMUserInfoDAO.GetMenuForm()` | Lay danh sach form, khong phai source chinh cho cay menu + route metadata. |
| `AsGetMenuInfo` | `asGetMenuInfo` | `Framework.CommonDAO.GetMenuInformation()` | Lay thong tin theo tung `pMenuId`, neu goi cho toan bo menu se thanh N query. |
| `AsGetMenuDrillDownInfo` | `asGetMenuDrillDownInfo` | `Framework.CommonDAO.GetMenuDrillDownInformation()` | Lay drilldown theo tung `pMenuId`, khong phai batch toan bo menu. |
| `AsGetMenuInfoAll` | `asGetMenuInfoAll` | wrapper co san trong `Diepxuan\Simba\StoredProcedures` | Ung vien can test runtime de xem field tra ve co gom du `sysMenu/zsysmenu/report/dictionary/drilldown` hay khong. Chua su dung trong code vi docs hien co chua mo ta schema result. |
| `AsGetMenuIdByCommand` | `asGetMenuIdByCommand` | `PROCEDURES.md.backup` | Lookup nguoc tu command sang menuid, khong phai batch menu source. |
| `asGetMenuList` | `asGetMenuList` | `simba-docs/tasks/002-si-simba-login-entrypoint.md` | SP theo quyen user `@pMa_Cty, @pMa_User`; chua co wrapper trong `Diepxuan\Simba\StoredProcedures`. La ung vien cho menu theo permission, khong thay bang chung du metadata route/report/dictionary. |

Ket luan: SP co kha nang gan nhat de thu nghiem batch la `asGetMenuInfoAll`; `asGetMenuList` can wrapper neu Sếp can menu theo quyen user. Trong thay doi hien tai em chua thay source docs nao dam bao mot SP tra ve du toan bo metadata Portal can dung, nen khong thay the runtime bang SP de tranh sai contract.

## Implemented phase

- `SimbaMetadataService::indexBy($dataset, $field)` tao index theo field trong request, tranh `Collection::first()` lap lai tren dictionary/report/drilldown cho tung menu.
- `SimbaMenuRouteMetadata` dung index theo `menuid`, `code_name`, `table_name` thay vi scan collection lap lai.
- `SimbaMetadataService` chi nap menu `active = 1` va chi select cac cot menu dang dung tu `sysMenu/zsysmenu`: `menuid`, `stt`, `type`, `moduleid`, `bar`, `short_name`, `dllName`, `command`, `code_name`, `report`, `active`.
- `sysDictionaryInfo`, `sysReportInfo`, `zSysReportInfo`, `sysReportDrillDownInfo` chuyen sang `toBase()` + select cot can dung, giam hydrate Eloquent model cho metadata enrich.
- `SimbaErpMenus` cache `routeMapByMenuId()` trong component instance, tranh build lai route map cho tree/stats trong cung request.
- `simba-erp-menus.blade.php` inline node markup trong loop route chinh, khong con include `catalog::system.simba-node` tren tung node; muc tieu la xoa view render lap lai x 361 tren trang `/simba`.

## Plan tiep theo

1. Test runtime `AsGetMenuInfoAll::call([])` tren portal de ghi lai schema result, so hang, memory/query count. Chi thay source menu bang SP neu result co du field va khop docs.
2. Neu `asGetMenuInfoAll` khong du, thiet ke mot query read-only gom `sysMenu/zsysmenu` va left join metadata report/dictionary/drilldown bang field da co trong `simba-docs`. Khong tao SQL object moi, khong ALTER/CREATE.
3. Tao DTO nhe cho menu tree thay vi giu Eloquent `SysMenu/Zsysmenu` model trong cache, nhung phai giu du helper behavior hien co (`getDisplayName`, parent id, type flags).
4. Cache compiled menu payload theo company/user/language neu sau nay menu phu thuoc quyen user; can invalidation ro khi doi quyen/menu.
5. Giam DOM/render tiep bang visible-node rendering hoac pagination theo module neu cay menu vuot nguong lon; hien tai da giam view partial count, chua giam so node DOM.

## Verification

Da chay:

```bash
php -l diepxuan/laravel-catalog/src/Services/SimbaMetadataService.php
php -l diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php
php -l diepxuan/laravel-catalog/src/Http/Livewire/System/SimbaErpMenus.php
php artisan test diepxuan/laravel-catalog/tests/Unit/Services/SimbaMetadataServiceTest.php
php artisan test diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
php artisan test diepxuan/laravel-catalog/tests/Unit/Http/Livewire/SimbaErpMenusViewTest.php
php artisan test diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php
```

Ket qua hien tai: 21 tests pass, 200 assertions cho nhom test muc tieu va coverage route.

Website verification tren `portal.diepxuan.corp`:

```bash
curl -L -sS --max-time 20 -o /tmp/portal-simba-menu.html -w '%{http_code} %{time_total} %{size_download}\n' http://portal.diepxuan.corp/simba
```

Ket qua ngay 2026-06-30:

- `GET /simba`: `200`, HTML render duoc.
- Debugbar request status: `200 OK`, route `simba.index`.
- Debugbar views: `24`; `catalog::system.simba-node` x `0` trong HTML/debug output.
- Debugbar peak memory: khoang `20.5MB` tren request GET da test lai sau active filter; gia tri co dao dong theo Debugbar/request nhung da thap hon muc ~40MB ban dau.
- Debugbar model counter: `390` model, gom `SysMenu` 348 va `Zsysmenu` 37; khong con hydrate model `SysDictionaryInfo`, `ZSysReportInfo`, `SysReportDrillDownInfo` trong collector sau phase 1.
- `HEAD /simba` tra `500` do moi truong local thieu Vite manifest (`public/build/manifest.json`) khi render layout; `GET /simba` van pass va khong co exception trong Debugbar.
