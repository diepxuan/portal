# Phương án tích hợp create/edit nhà cung cấp vào `po/dict/ardmkh`

Ngày lập: 2026-06-19

## 1. Mục tiêu

Tích hợp 2 URL legacy:

- `/muahang/nhacungcap/create`
- `/muahang/nhacungcap/edit/{id}`

vào flow canonical của Simba source route:

- `/_simba-source/po/dict/ardmkh`

Theo chuẩn SimbaERP của `ARDMKH.dll`, form `frmARDMKH` / `frmARDMKHEdit`.

## 2. Nguồn tham chiếu SimbaERP

Đã đối chiếu các nguồn sau:

- `simba-docs/asia/ar/vouchers/ARDMKH.md`
- `simba-docs/asia/ar/stored-procedures/asARGetDMKH.md`
- `simba-docs/procedures/AR/procedures.md` — chữ ký `asARInsDMKH`, `asARUpdDMKH`, `asARDelDMKH`, `asARGetDMKH`
- `simba-docs/decompiled/asia/ARDMKH.dll/AsiaErp.UserInterface/frmARDMKH.cs`
- `simba-docs/decompiled/asia/ARDMKH.dll/AsiaErp.UserInterface/frmARDMKHEdit.cs`

Kết luận nghiệp vụ:

- `ARDMKH.dll` là danh mục đối tượng dùng chung cho AR/AP/CA.
- Với PO/AP context, bản ghi nhà cung cấp là `ARDMKH.isncc = 1`.
- `frmARDMKH.GetData()` gọi:

```csharp
base.GetData(CompanyInformations.CompanyID, "", "0", MyMenuInfo.moduleid);
```

- `frmARDMKHEdit.InitAfterGetData()` set default khi create:

```csharp
case "CA": chkIsNv.Checked = true; break;
case "AR": chkIsKh.Checked = true; break;
case "AP": chkIsNcc.Checked = true; break;
```

- Validation chính:
  - `ma_kh` bắt buộc.
  - `ten_kh` bắt buộc.
  - Ít nhất một trong `iskh/isncc/isnv` phải checked.
  - Edit không cho sửa `ma_kh`.

## 3. Hiện trạng Portal

### 3.1 Route hiện có

Trong `diepxuan/laravel-catalog/routes/web.php` hiện có:

```php
Route::get('/muahang/nhacungcap/create', ArdmkhForm::class)->name('po.cungcap.create');
Route::get('/muahang/nhacungcap/edit/{id}', ArdmkhForm::class)->name('po.cungcap.edit');
```

Và source route:

```php
['uri' => 'po/dict/ardmkh', 'name' => 'po.dict.ardmkh', 'module' => 'po', 'kind' => 'dict', 'slug' => 'ardmkh', 'component' => Ardmkh::class]
```

### 3.2 Component hiện có

- List: `Diepxuan\Catalog\Http\Livewire\Po\Dict\Ardmkh`
- Form: `Diepxuan\Catalog\Http\Livewire\Po\Dict\ArdmkhForm`
- View list: `diepxuan/laravel-catalog/resources/views/po/dict/ardmkh.blade.php`
- View form: `diepxuan/laravel-catalog/resources/views/po/dict/ardmkh-form.blade.php`

### 3.3 Lệch chuẩn cần xử lý

1. Create/edit đang dùng URL legacy `/muahang/nhacungcap/...`, chưa nằm trong cây `po/dict/ardmkh`.
2. Form hiện mới là subset, chưa đủ binding theo `frmARDMKHEdit`.
3. Validation chưa đủ rule “ít nhất một loại đối tượng”.
4. Payload save chưa đầy đủ theo field Simba; cần audit chữ ký wrapper SP trước khi mở rộng.
5. Link trong list đang trỏ `po.cungcap.create/edit`, chưa trỏ canonical `po.dict.ardmkh.create/edit`.

## 4. Phương án route canonical

### 4.1 List

Canonical list giữ nguyên:

```text
GET /_simba-source/po/dict/ardmkh
name: po.dict.ardmkh
component: Ardmkh::class
```

### 4.2 Create

Thêm route canonical:

```text
GET /_simba-source/po/dict/ardmkh/create
name: po.dict.ardmkh.create
component: ArdmkhForm::class
```

### 4.3 Edit

Thêm route canonical:

```text
GET /_simba-source/po/dict/ardmkh/{id}/edit
name: po.dict.ardmkh.edit
component: ArdmkhForm::class
```

### 4.4 Legacy routes

Không giữ route legacy cho nhà cung cấp. URL cũ phải không còn resolve để tránh người dùng đi nhầm flow ngoài cây Simba source route:

```text
GET /muahang/nhacungcap/create      => 404
GET /muahang/nhacungcap/edit/{id}   => 404
```

List view phải sinh link canonical `po.dict.ardmkh.create/edit`.

### 4.5 Quy ước edit URL

Plan này chốt canonical edit URL theo resource-style:

```text
/_simba-source/po/dict/ardmkh/{id}/edit
```

Không dùng dạng `/_simba-source/po/dict/ardmkh/edit/{id}` trong PR này để tránh song song hai chuẩn.
Nếu code hiện đang có dạng `edit/{id}` thì đổi về `{id}/edit` và cập nhật test tương ứng.

### 4.6 Gợi ý implement route

Trong `diepxuan/laravel-catalog/routes/web.php`, đặt create/edit ngay sau list `po/dict/ardmkh` trong `$sourceRoutes` để cùng nhóm SimbaERP menu PO dictionary:

```php
['uri' => 'po/dict/ardmkh', 'name' => 'po.dict.ardmkh', 'module' => 'po', 'kind' => 'dict', 'slug' => 'ardmkh', 'component' => Ardmkh::class],
['uri' => 'po/dict/ardmkh/create', 'name' => 'po.dict.ardmkh.create', 'module' => 'po', 'kind' => 'dict', 'slug' => 'ardmkh', 'component' => ArdmkhForm::class],
['uri' => 'po/dict/ardmkh/{id}/edit', 'name' => 'po.dict.ardmkh.edit', 'module' => 'po', 'kind' => 'dict', 'slug' => 'ardmkh', 'component' => ArdmkhForm::class],
```

Không khai báo create/edit rời bên ngoài `$sourceRoutes`. Không đăng ký route legacy `/muahang/nhacungcap/create` hoặc `/muahang/nhacungcap/edit/{id}`.

## 5. Phương án component `Ardmkh`

`Ardmkh` giữ vai trò tương đương `frmARDMKH` cho PO/AP context.

Cần chỉnh:

1. Nút thêm trong `cungcap.blade.php`:

```php
route('po.dict.ardmkh.create')
```

2. Nút sửa:

```php
route('po.dict.ardmkh.edit', ['id' => $arDmKh->ma_kh])
```

3. Không dùng và không đăng ký `po.cungcap.create/edit`; URL legacy phải 404 để tránh đi nhầm flow ngoài `_simba-source`.

4. List data tiếp tục lấy từ `AsARGetDMKH` với supplier filter:

- Nếu wrapper hỗ trợ `pModuleId = 'PO'`: dùng `PO` cho khớp route.
- Nếu wrapper chỉ chuẩn hoá supplier qua `AP`: giữ `AP`, vì docs SP xác nhận `AP/PO` đều map `isNcc = 1`.

Không tự đổi SQL hoặc tạo bảng/SP mới.

## 6. Phương án component `ArdmkhForm`

`ArdmkhForm` đóng vai `frmARDMKHEdit` cho PO supplier.

### 6.1 Field cần có theo Simba binding

Nhóm thông tin cơ bản:

- `ma_kh`
- `ten_kh`
- `dia_chi`
- `ma_so_thue`
- `tel`
- `fax`
- `email`
- `home_page`
- `nguoi_gd`

Nhóm thanh toán:

- `ma_httt` — HTTT bán, lookup `MA_HTTT`, condition `moduleid='SO'`
- `ma_httt_po` — HTTT mua, lookup `MA_HTTT_PO`, condition `moduleid='PO'`
- `ma_tt` — điều khoản thanh toán
- `gh_no`
- `han_ck`
- `tl_ck`
- `han_tt`
- `ls_qh`

Nhóm ngân hàng:

- `ma_ngh`
- `ten_nh` display
- `so_tk_nh`
- `cn_nh` / `Cn_nh`
- `tinh_tp_nh`

Nhóm phân loại:

- `ma_plkh1`, `ten_plkh1`, lookup `MA_PLKH`, condition `loai=1`
- `ma_plkh2`, `ten_plkh2`, lookup `MA_PLKH`, condition `loai=2`
- `ma_plkh3`, `ten_plkh3`, lookup `MA_PLKH`, condition `loai=3`
- `ma_nhkh` — nhóm khách hàng/nhà cung cấp

Flags:

- `iskh`
- `isncc`
- `isnv`
- `tinh_dt_nb`
- `ksd`

Khác:

- `ghi_chu`

### 6.2 Default create

Với create từ PO supplier:

```php
$this->mode = 'create';
$this->iskh = false;
$this->isncc = true;
$this->isnv = false;
```

Với edit:

- Load record từ `AsARGetDMKH`.
- Giữ nguyên flags theo dữ liệu, không ép lại default.
- `ma_kh` readonly / không cho đổi.

### 6.3 Validation

Theo Simba:

- `ma_kh` required.
- `ten_kh` required.
- Ít nhất một trong `iskh/isncc/isnv` phải true.
- `ma_kh` uppercase/trim trước khi save.
- `email` validate định dạng nếu có.

Rule đề xuất:

```php
return [
    'ma_kh' => 'required|string|max:20',
    'ten_kh' => 'required|string|max:100',
    'dia_chi' => 'nullable|string|max:255',
    'ma_so_thue' => 'nullable|string|max:20',
    'tel' => 'nullable|string|max:30',
    'fax' => 'nullable|string|max:30',
    'email' => 'nullable|email|max:30',
    'home_page' => 'nullable|string|max:30',
    'nguoi_gd' => 'nullable|string|max:30',
    'ma_httt' => 'nullable|string|max:20',
    'ma_httt_po' => 'nullable|string|max:20',
    'ma_tt' => 'nullable|string|max:8',
    'ma_ngh' => 'nullable|string|max:20',
    'ten_nh' => 'nullable|string|max:50',
    'so_tk_nh' => 'nullable|string|max:20',
    'cn_nh' => 'nullable|string|max:50',
    'tinh_tp_nh' => 'nullable|string|max:50',
    'ma_plkh1' => 'nullable|string|max:8',
    'ma_plkh2' => 'nullable|string|max:8',
    'ma_plkh3' => 'nullable|string|max:8',
    'ma_nhkh' => 'nullable|string|max:8',
    'gh_no' => 'nullable|numeric',
    'han_ck' => 'nullable|numeric',
    'tl_ck' => 'nullable|numeric',
    'han_tt' => 'nullable|numeric',
    'ls_qh' => 'nullable|numeric',
    'ghi_chu' => 'nullable|string|max:255',
];
```

Sau validate:

```php
if (!$this->iskh && !$this->isncc && !$this->isnv) {
    throw ValidationException::withMessages([
        'iskh' => 'Phải chọn ít nhất một loại đối tượng.',
    ]);
}
```

## 7. Phương án persist

Tiếp tục dùng stored procedure wrapper hiện có, không tạo SQL mới:

- Read: `AsARGetDMKH`
- Insert: `AsARInsDMKH`
- Update: `AsARUpdDMKH`
- Delete: `AsARDelDMKH`

Trước khi code payload cuối cùng phải audit chữ ký wrapper trong package Simba để biết chính xác tên param. Không tự bịa param.

Payload mục tiêu theo field Simba và chữ ký `asARInsDMKH` / `asARUpdDMKH`:

- `pMa_cty`
- `pMa_kh`
- `pLoai`
- `pTen_kh`
- `pMa_so_thue`
- `pDia_chi`
- `pTel`
- `pFax`
- `pEmail`
- `pHome_page`
- `pNguoi_gd`
- `pMa_ngh`
- `pTen_nh`
- `pCn_nh`
- `pSo_tk_nh`
- `pTinh_tp_nh`
- `pTk`
- `pMa_plkh1`
- `pMa_plkh2`
- `pMa_plkh3`
- `pMa_nhkh`
- `pMa_tt`
- `pMa_httt`
- `pMa_httt_po`
- `pGh_no`
- `pHan_ck`
- `pTl_ck`
- `pHan_tt`
- `pLs_qh`
- `pGhi_chu`
- `pTinh_dt_nb`
- `pIskh`
- `pIsncc`
- `pIsnv`
- `pKsd`
- `pLUser`
- `pRet` output nếu wrapper yêu cầu khai báo

Giá trị mặc định khi form chưa expose đủ UI:

```php
'pLoai' => 1,
'pMa_ngh' => $this->ma_ngh ?: '',
'pTen_nh' => $this->ten_nh ?: '',
'pCn_nh' => $this->cn_nh ?: '',
'pSo_tk_nh' => $this->so_tk_nh ?: '',
'pTinh_tp_nh' => $this->tinh_tp_nh ?: '',
'pMa_plkh1' => $this->ma_plkh1 ?: '',
'pMa_plkh2' => $this->ma_plkh2 ?: '',
'pMa_plkh3' => $this->ma_plkh3 ?: '',
'pMa_nhkh' => $this->ma_nhkh ?: '',
'pMa_tt' => $this->ma_tt ?: '',
'pMa_httt' => $this->ma_httt ?: '',
'pMa_httt_po' => $this->ma_httt_po ?: '',
'pGh_no' => $this->decimalOrZero($this->gh_no),
'pHan_ck' => $this->decimalOrZero($this->han_ck),
'pTl_ck' => $this->decimalOrZero($this->tl_ck),
'pHan_tt' => $this->decimalOrZero($this->han_tt),
'pLs_qh' => $this->decimalOrZero($this->ls_qh),
'pTinh_dt_nb' => (int) $this->tinh_dt_nb,
'pIskh' => (int) $this->iskh,
'pIsncc' => (int) $this->isncc,
'pIsnv' => (int) $this->isnv,
'pKsd' => (int) $this->ksd,
```

Với create từ PO supplier, default flags phải là:

```php
$this->iskh = false;
$this->isncc = true;
$this->isnv = false;
```

Với edit, load record rồi giữ nguyên flags từ dữ liệu nếu có; không ép lại `isncc = true` sau khi đã load.

Nếu wrapper hiện chưa expose đủ field:

1. Chỉ truyền field wrapper nhận thật.
2. Ghi rõ field chưa persist.
3. Không sửa SQL/SP trong task này.

## 8. Phương án view form

`catalog::po.dict.ardmkh-form` nên chia nhóm theo `frmARDMKHEdit`:

1. Thông tin cơ bản
2. Liên hệ
3. Phân loại
4. Thanh toán
5. Ngân hàng
6. Flags đối tượng
7. Ghi chú

Với PO context:

- Label ưu tiên “Nhà cung cấp”.
- Checkbox “Là nhà cung cấp” default checked khi create.
- Vẫn cho phép user tick thêm “Là khách hàng” hoặc “Là nhân viên” nếu dữ liệu Simba cần dùng chung đối tượng.

## 9. Test cần cập nhật

### 9.1 Route test

Assert route tồn tại:

- `po.dict.ardmkh`
- `po.dict.ardmkh.create`
- `po.dict.ardmkh.edit`

Assert canonical URL resolve:

- `/_simba-source/po/dict/ardmkh`
- `/_simba-source/po/dict/ardmkh/create`
- `/_simba-source/po/dict/ardmkh/NCC001/edit`

Assert legacy route không còn resolve:

- `/muahang/nhacungcap/create`
- `/muahang/nhacungcap/edit/NCC001`

### 9.2 Form test

- Create default `isncc = true`.
- Missing `ma_kh` fail.
- Missing `ten_kh` fail.
- `iskh/isncc/isnv` đều false fail.
- Edit không đổi `ma_kh`.

### 9.3 Payload/persist test

Nếu có thể test không chạm DB thật, thêm unit/helper test cho payload builder:

- Payload create có đủ key theo `asARInsDMKH/asARUpdDMKH` docs.
- Create PO default: `pIskh=0`, `pIsncc=1`, `pIsnv=0`.
- Numeric empty string normalize về `0` cho `pGh_no`, `pHan_ck`, `pTl_ck`, `pHan_tt`, `pLs_qh`.
- `ma_kh` uppercase/trim trước khi persist.

Nếu chưa tách được payload builder, task này nên tách method protected/private như `buildPayload()` hoặc `payloadForStoredProcedure()` rồi test gián tiếp qua reflection/test subclass; không gọi DB thật trong unit test.

## 10. Verification cần chạy

Sau khi implement:

```bash
php -l diepxuan/laravel-catalog/routes/web.php
php -l diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/Ardmkh.php
php -l diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/ArdmkhForm.php
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
# Nếu thêm test riêng cho payload/form:
vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Http/Livewire/Po/Dict/ArdmkhFormTest.php
```

Trong docker:

```bash
docker compose exec -T laravel.test php artisan optimize:clear
docker compose exec -T laravel.test php artisan route:list --name=po.dict.ardmkh
```

Smoke URL:

```text
/_simba-source/po/dict/ardmkh                  => 200
/_simba-source/po/dict/ardmkh/create           => 200
/_simba-source/po/dict/ardmkh/NCC001/edit      => 200
/muahang/nhacungcap/create                     => 404
/muahang/nhacungcap/edit/NCC001                => 404
```

## 11. Prompt thực thi cho Claude

```text
Worktree: /root/.openclaw/workspace/projects/portal
Branch base: origin/main
Plan source: docs/project/po-ardmkh-canonical-integration-plan.md

Muc tieu:
Tich hop create/edit nha cung cap vao canonical SimbaERP source route cua PO ARDMKH:
- list:   /_simba-source/po/dict/ardmkh              route name po.dict.ardmkh
- create: /_simba-source/po/dict/ardmkh/create       route name po.dict.ardmkh.create
- edit:   /_simba-source/po/dict/ardmkh/{id}/edit    route name po.dict.ardmkh.edit

Legacy URLs khong duoc dang ky route, phai 404:
- /muahang/nhacungcap/create
- /muahang/nhacungcap/edit/{id}

Nguon bat buoc doc truoc khi code:
- simba-docs/asia/ar/vouchers/ARDMKH.md
- simba-docs/asia/ar/stored-procedures/asARGetDMKH.md
- simba-docs/procedures/AR/procedures.md
- simba-docs/decompiled/asia/ARDMKH.dll/AsiaErp.UserInterface/frmARDMKH.cs
- simba-docs/decompiled/asia/ARDMKH.dll/AsiaErp.UserInterface/frmARDMKHEdit.cs

Rang buoc:
- Khong sua simba-docs.
- Khong tao/sua SQL, schema, migration, stored procedure.
- Khong sua root app routes/controllers/models.
- Chi sua trong diepxuan/laravel-catalog va test/doc lien quan.
- Khong force-push, khong merge.

Cong viec:
1. Tao branch: fix/po-ardmkh-canonical-actions
2. Sua diepxuan/laravel-catalog/routes/web.php:
   - Them canonical create/edit routes vao `$sourceRoutes`, dat ngay sau route list po/dict/ardmkh.
   - Khong khai bao route create/edit roi ben ngoai `$sourceRoutes`.
   - Khong dang ky legacy URL /muahang/nhacungcap/create va /muahang/nhacungcap/edit/{id}.
   - Khong duplicate route name po.dict.ardmkh.
3. Sua view/component:
   - cungcap.blade.php dung po.dict.ardmkh.create/edit.
   - cungcap-form.blade.php quay ve po.dict.ardmkh.
   - ArdmkhForm redirect sau save ve po.dict.ardmkh.
4. Chuan hoa ArdmkhForm theo ARDMKH PO supplier context:
   - Create default iskh=false, isncc=true, isnv=false.
   - Edit load flags tu data neu co, khong ep lai.
   - ma_kh required, ten_kh required, email format, it nhat mot flag iskh/isncc/isnv.
   - ma_kh uppercase/trim truoc save, readonly khi edit.
   - Payload persist phai theo asARInsDMKH/asARUpdDMKH trong docs, gom cac param:
     pMa_cty, pMa_kh, pLoai, pTen_kh, pMa_so_thue, pDia_chi, pTel, pFax,
     pEmail, pHome_page, pNguoi_gd, pMa_ngh, pTen_nh, pCn_nh, pSo_tk_nh,
     pTinh_tp_nh, pTk, pMa_plkh1, pMa_plkh2, pMa_plkh3, pMa_nhkh, pMa_tt,
     pMa_httt, pMa_httt_po, pGh_no, pHan_ck, pTl_ck, pHan_tt, pLs_qh,
     pGhi_chu, pTinh_dt_nb, pIskh, pIsncc, pIsnv, pKsd, pLUser.
   - Neu wrapper thuc te khong nhan du param nao, khong sua SQL; ghi ro trong PR body.
5. Test:
   - SourceRouteCoverageTest assert canonical create/edit resolve dung route name.
   - SourceRouteCoverageTest assert legacy create/edit khong resolve.
   - Neu tach duoc payload builder, them unit test payload khong cham DB.
6. Validation:
   php -l diepxuan/laravel-catalog/routes/web.php
   php -l diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/Ardmkh.php
   php -l diepxuan/laravel-catalog/src/Http/Livewire/Po/Dict/ArdmkhForm.php
   vendor/bin/phpunit diepxuan/laravel-catalog/tests/Feature/SourceRouteCoverageTest.php
   vendor/bin/phpunit diepxuan/laravel-catalog/tests/Unit/Services/SimbaMenuRouteMetadataTest.php
   php artisan route:list --name=po.dict.ardmkh
7. Commit: fix(catalog): route PO supplier actions through ARDMKH source
8. Push va tao PR target main. Khong merge.
```

## 12. Quyết định đề xuất

Triển khai theo hướng:

1. `/_simba-source/po/dict/ardmkh` là canonical list.
2. `/_simba-source/po/dict/ardmkh/create` là canonical create.
3. `/_simba-source/po/dict/ardmkh/{id}/edit` là canonical edit.
4. `/muahang/nhacungcap/create` và `/muahang/nhacungcap/edit/{id}` không còn hoạt động; dùng canonical route trong cây `_simba-source`.
5. `ArdmkhForm` được chuẩn hóa thành implementation của `frmARDMKHEdit` cho PO/AP supplier context.
6. Không tạo/sửa SQL, không tự đặt tên bảng/SP/field ngoài nguồn Simba docs/source.
