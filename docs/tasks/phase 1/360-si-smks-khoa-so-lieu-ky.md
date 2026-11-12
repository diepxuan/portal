# Task 360: SMKS — Khóa số liệu kỳ

## Nhóm: SI (System Integration) — Infrastructure

## Mục tiêu

Ghi nhận kết quả chuyển đổi module **Khóa số liệu kỳ (SMKS)** từ Simba .NET `SMKS.dll` sang Portal Livewire, route `/simba/si/vch/smks`.

## Trạng thái

- **Status:** ✅ DONE — đã merge vào main
- **Route:** `/simba/si/vch/smks` (route name: `si.vch.smks`)
- **Component:** `Diepxuan\Catalog\Http\Livewire\Si\Vch\Smks`
- **SP Wrapper:** `Diepxuan\Simba\StoredProcedures\AssiUpd_ks` (SP `assiUpd_ks`)
- **Legacy:** `/hethong/system` redirect → `/simba/si/vch/smks`
- **Nav:** Đã gỡ link riêng khỏi Portal navigation (chỉ truy cập qua Simba shell/menu)

## DLL Reference

| Thuộc tính | Giá trị |
|------------|---------|
| DLL | `SMKS.dll` |
| Form | `frmSMKS` (base `frmCalc`) |
| SP | `assiUpd_ks` — params: `@pMa_cty`, `@pNgay_ks`, `@pRet` (output) |

## Chi tiết

- Hiển thị công ty, năm tài chính, ngày khóa sổ
- Khi cập nhật: gọi SP `assiUpd_ks` với `pMa_cty` + `pNgay_ks`
- `ma_cty` từ SiSetup là `NVARCHAR(3)`, chuẩn hóa về `001`/`002`
- Đọc `SystemConfig` trực tiếp — tránh eager relation bị ép key số mất số 0 đầu

## Follow-up: Kiểm tra `ngay_ks` trong Portal

### Mục tiêu

Đưa mốc khóa sổ `SiSetup.ngay_ks` thành một ràng buộc nghiệp vụ dùng chung trong
Portal: mọi luồng nhập/sửa/xóa/post chứng từ phải chặn dữ liệu thuộc kỳ đã khóa
giống SimbaERP. Hiện tại Portal mới chỉ cập nhật được `ngay_ks` tại
`/simba/si/vch/smks`; chưa có tầng validation/helper dùng chung.

### Cách SimbaERP dùng `ngay_ks`

- Mốc được lưu tại `SiSetup.ngay_ks`, công ty hiện tại qua `CompanyInformations.CompanyID`.
- Quy tắc chung: chứng từ chỉ được phép thao tác khi `ngay_ct > ngay_ks`.
- Với **kỳ tính toán/post**: hợp lệ khi `ngay2 > ngay_ks` (ngày cuối kỳ sau ngày khóa sổ).
- Simba kiểm tra ở 2 tầng:
  1. UI/form dùng `Environment.GetSIConfiguration().ngay_ks` để chặn sớm, thường báo
     lỗi `50136` / `50012`.
  2. SP post/process đọc `ngay_ks` và return/không thực hiện khi ngày thuộc kỳ đã khóa.

#### `ngay_ks` KHÔNG liên quan tới màn xem báo cáo

Đây là điểm dễ hiểu nhầm, cần chốt rõ:

- Rà toàn bộ `simba-docs/decompiled/asia/*/README.md`: chỉ **15 DLL** nhắc `ngay_ks`,
  và **không DLL nào là báo cáo** (`*Rpt*`). Danh sách đầy đủ:
  `CoCalcCost`, `CoDelPostCP2GL`, `CoPostCPTT2GL`, `FACalKHTS`, `FADelCC2GL`,
  `FADelKHTS`, `FADelTS2GL`, `FAPostCC2GL`, `GLPost2DGTG`, `GLPost2GL`,
  `GLPost2GLKC`, `INCalGiaNTXT`, `SIAbout`, `SMKS`, `SOTaOut`.
- **Toàn bộ** đều là hành động **ghi/tính dữ liệu**: tính khấu hao, tính giá FIFO,
  tính giá thành, kết chuyển, post GL, xóa dữ liệu đã post, hoặc nhập chứng từ.
- Các báo cáo thuần đọc (`ARRptBCCN01*`, `ARRptBK01*`, `APRptBK01*`, `CARptTMNH*`);
  không có DLL báo cáo nào dùng `ngay_ks` → **xem báo cáo kỳ đã khóa sổ là hợp lệ**.
- Thuật ngữ trong simba-docs dễ gây nhầm: `cboKyBc` / "kỳ báo cáo" ở form
  `FACalKHTS`, `INCalGiaNTXT`, `CoPostCPTT2GL` là **tham số đầu vào của hành động
  tính/post**, không phải màn hiển thị báo cáo. Vì vậy message lỗi trong Portal
  đặt là "Kỳ đã khóa sổ, không thể thực hiện tính toán/kết chuyển", không dùng
  chữ "kỳ báo cáo".

Hệ quả khi triển khai Portal:

| Loại màn hình | Có guard `ngay_ks`? |
|---|---|
| Form chứng từ (nhập/sửa/xóa: SO3, PO3, CA4…) | **Có** — theo `ngay_ct` |
| Hành động tính/post theo kỳ (khấu hao, kết chuyển, post GL) | **Có** — theo `ngay2` |
| Màn cập nhật `ngay_ks` (`/simba/si/vch/smks`) | Không (chính là nơi mở khóa) |
| Màn xem báo cáo / tra cứu dữ liệu | **Không** — phải xem được kỳ đã khóa |
| Đường xóa chứng từ (kể cả xóa từ bảng kê báo cáo) | **Có** — xóa là ghi dữ liệu |

### Phạm vi triển khai đề xuất

#### 1. Service/trait dùng chung

- Tạo service hoặc trait kiểm tra khóa sổ, ưu tiên đặt trong `diepxuan/laravel-catalog`
  (tầng ứng dụng Portal) hoặc `diepxuan/laravel-simba` nếu cần dùng cho nhiều package.
- API gợi ý:
  - `assertDocumentDateNotLocked(?string $ngayCt, ?string $maCty = null)`
  - `assertPeriodNotLocked(?string $ngay1, ?string $ngay2, ?string $maCty = null)`
  - `isDocumentDateLocked(?string $ngayCt, ?string $maCty = null): bool`
- Ngày khóa sổ lấy từ `SiSetup` theo company hiện tại, không hardcode.
- Trả message tiếng Việt rõ ràng, ví dụ:
  - `Không được nhập/sửa/xóa chứng từ trước ngày khóa sổ.`
  - `Kỳ đã khóa sổ, không thể thực hiện tính toán/kết chuyển.`

#### 2. Áp dụng cho UI/form chứng từ

Theo tài liệu SimbaERP, các form gốc có kiểm tra `ngay_ks` dù SP CRUD chưa chắc tự chặn:

| Nghiệp vụ | Form/DLL | Điều kiện Simba | Portal cần áp dụng |
|---|---|---|---|
| Phiếu thu | `CAVchCA1.dll` | `base.ValidData()`: `ngay_ct > ngay_ks` | Form CA1 (khi có) |
| Phiếu chi | `CAVchCA2.dll` | `base.ValidData()`: `ngay_ct > ngay_ks` | Form CA2 (khi có) |
| Báo nợ ngân hàng | `CAVchCA3.dll` | `base.ValidData()`: `ngay_ct > ngay_ks` | Form CA3 (khi có) |
| Số dư đầu kỳ phiếu chi | `CACDPC.dll` | `ngay_ct <= ngay_ks` → 50136 | Form CACDPC (khi có) |
| Thanh toán công nợ | `ARTT.dll` | save: `ngay_ct > ngay_ks`; delete: `Ngay_ct_tt <= ngay_ks` → chặn | Form ARTT (khi có) |
| Phiếu trả lại hàng bán | `SOVchSO4.dll` | `ngay_ct > ngay_ks` | Form SO4 (khi có) |
| Số dư đầu kỳ tài khoản | `GLCDTK.dll` | tháng nhập <= tháng khóa sổ và năm <= năm khóa sổ → 50136 | Form GLCDTK (khi có) |
| Chuyển số liệu vào sổ cái | `GLPost2GL.dll` | `ngay_ks > ngay1` → 50012 | Form GLPost2GL (khi có) |
| Kết chuyển tự động | `GLPost2GLKC.dll` | `txtNgay2 <= ngay_ks` → 50136 | Form GLPost2GLKC (khi có) |
| Định mức chi tiết | `CODD1.dll` | `last_day_of_month <= ngay_ks` → 50136 | Form CODD1 (khi có) |
| Bút toán phân bổ | `COPB.dll` | `txtNgay2 <= ngay_ks` → 50136 | Form COPB (khi có) |
| Tính giá thành | `CoCalcCost.dll` | `txtNgay2 <= ngay_ks` → 50136 | Form CoCalcCost (khi có) |
| Post/xóa chi phí tập trung | `CoPostCPTT2GL.dll`, `CoDelPostCP2GL.dll` | `ngay2 <= ngay_ks` → 50136 | Form tương ứng (khi có) |
| Khấu hao TSCĐ | `FACalKHTS.dll`, `FADelKHTS.dll`, `FAAdjustKHTS.dll` | `ngay2 <= ngay_ks` → 50136 | Form tương ứng (khi có) |
| Post/xóa khấu hao sang GL | `FAPostTS2GL.dll`, `FADelTS2GL.dll`, `FAPostCC2GL.dll`, `FADelCC2GL.dll` | `ngay2 <= ngay_ks` → 50136 | Form tương ứng (khi có) |

#### 3. Đối chiếu SP đã có sẵn kiểm tra `ngay_ks`

Các wrapper SP trong `diepxuan/laravel-simba/src/StoredProcedures/` đã có
`pNgay_ks` hoặc comment xác nhận SP kiểm tra `ngay_ks`:

- GL: `AsPostGlPh1_glct`
- AR/AP: `AsPostArPh3_glct`, `AsPostArPh4_glct`, `AsPostArPh4_glct_1c`,
  `AsPostArPh4_glct_1n`, `AsPostArPh3_arTt`, `AsPostApPh3_glct`,
  `AsPostApPh4_glct`, `AsPostApPh4_glct_1c`, `AsPostApPh4_glct_1n`,
  `AsPostApPh3_apTt`
- SO: `AsPostSoPh1_arTt`, `AsPostSoPh1_SoCt`, `AsPostSoPh2_SoCt`,
  `AsPostSoPh2_glct`, `AsPostSoPh2_inct`, `AsPostSoPh3_SoCt`,
  `AsPostSoPh3_glct`, `AsPostSoPh3_inct`, `AsPostSoPh3_arTt`,
  `AsPostSoPh3_taOut`, `AsPostSoPh4_SoCt`, `AsPostSoPh4_arTt`,
  `AsPostSoPh4_inct`, `AsPostSoPh4_taout`, `AsPostSoPh5_SoCt`,
  `AsPostSoPh5_arTt`, `AsPostSoPh5_glct`, `AsPostSoPh5_taOut`
- PO: `AsPostPoPh0_poct`, `AsPostPoPh1_apTt`, `AsPostPoPh1_poct`,
  `AsPostPoPh2_apTt`, `AsPostPoPh2_inct`, `AsPostPoPh2_PoCt`,
  `AsPostPoPh3_apTt`, `AsPostPoPh3_inct`, `AsPostPoPh3_poct`,
  `AsPostPoPh3_GlCt`, `AsPostPoPh4_apTt`, `AsPostPoPh4_inct`,
  `AsPostPoPh5_apTt`, `AsPostPoPh5_inct`, `AsPostPoPh5_poct`,
  `AsPostPoPh5_GlCt`, `AsPostPoPh6_poct`, `AsPostPoPh6_GlCt`,
  `AsPostPoph4_GlCt`
- IN: `AsPostInPh1_glct`, `AsPostInPh1_inct`, `AsPostInPh2_inct`,
  `AsPostInPh3_glct`, `AsPostInPh5_glct`, `AsPostInPh5_inct`,
  `AsPostInPh6_PoCt`, `AsPostInPh6_apTt`, `AsPostInPh6LR_GlCt`,
  `AsPostInPh6LR_inct`, `AsPostInPh6TD_GlCt`, `AsPostInPh6TD_inct`,
  `AsPostInPh9_inct`, `AsPostinPh3_inct`
- CA: `AsPostCAPh2_CaTtHu`, `AsPostCAPh3_CaTtHu`, `AsProcessCalLaiKU`
- Khác: `AsSOPostTraTruoc_arTt`, `AsPostSoPh3TraTruoc_arTt`,
  `AsCOCalcPb`, `AsCODelPostCp2GlCt`, `AsGLChuyenSdTk`, `AsINChuyenTonKho`

#### 4. SP chưa thấy kiểm tra trong wrapper nhưng form/UI gốc có kiểm tra

Cần kiểm tra source SQL thật trước khi kết luận; hiện không có bằng chứng wrapper
tự kiểm tra:

| Nghiệp vụ | SP/DAO | Ghi chú |
|---|---|---|
| CA1/CA2/CA3 | `SP_CA1_*`, `SP_CA2_*`, `SP_CA3_*` | form dùng `frmVoucher.ValidData()` chặn |
| CACDPC | base `Insert/Update/Delete` | form `ngay_ct <= ngay_ks` → 50136 |
| ARTT | `asARInsTT/asARUpdTT/asARDelTT` | form save/delete đều chặn |
| SO4 | base CRUD | form `ValidData()` chặn |
| GLCDTK | `asGLCalSumCdTk` | form/filter chặn tháng khóa sổ |
| GLPost2GL | `asPost2Gl` | form filter chặn `ngay1` |
| GLPost2GLKC | `asGLCrtKC`, `asGLDelKC` | form chặn trước khi gọi SP |
| GLPost2DGTG | `asGLCrtDGTG`, `asGLDelDGTG` | cần verify source SP |
| CODD1/COPB/CoCalcCost/CoPostCPTT2GL/CoDelPostCP2GL | SP tương ứng | form chặn `ngay2` |
| FA | `asFACalKHTS`, `asFADelKHTS`, `asFAPostTS2GL`, `asFADelTS2GL`, `asFADelCC2GL`, `asFAPostCC2GL` | form/filter chặn `ngay2` |

#### 5. Thứ tự implement đề xuất

1. Tạo `KhoaSo`/`LockDate` service hoặc trait dùng chung.
2. Áp dụng cho form chứng từ đã có trong Portal trước:
   - CA4 phiếu báo nợ (`Phieubaono`) hiện đang gọi `AsPostCaPh2_glct`.
   - SO3/PO3 nếu chưa kiểm tra `ngay_ct`.
   - Các form chứng từ mới phát triển sau phải gọi helper ngay từ `save/update/delete`.
3. Không tạo/ALTER/SQL; chỉ gọi SP wrapper hoặc đọc `SiSetup` qua model hiện có.
4. Cập nhật `docs/project/simba-router-menu-matrix.md` nếu thêm route/service.
5. Viết unit test cho helper + test Livewire cho ít nhất 1 form.

### Data Access Map cho phần kiểm tra

| UI/data action | Code name | Simba table | Source | GET SP/wrapper | Ghi chú |
|---|---|---|---|---|---|
| Đọc ngày khóa sổ theo công ty | `SISETUP` | `SiSetup` | `sysDictionaryInfo`/`sysDAOInfo` | `asSiGetSetupByName` hoặc Eloquent `SiSetup` | Nếu không có SP phù hợp thì dùng `SiSetupModel`/`SystemConfig` và ghi rõ lý do |
| Cập nhật ngày khóa sổ | `SISETUP` | `SiSetup` | `SMKS.dll` | `assiUpd_ks` / `AssiUpd_ks` | Đã có tại `/simba/si/vch/smks` |
| Post GL/công nợ/tồn kho | các SP `AsPost*` | nhiều bảng | `simba-docs/procedures/*` | các wrapper `AsPost*` | SP đã kiểm tra `ngay_ks` theo nhóm mục 3 |
| Form chứng từ | `CA1/CA2/CA3/ARTT/SO4/GLCDTK/...` | nhiều bảng | tài liệu DLL gốc | SP CRUD tương ứng | UI cần chặn sớm bằng helper |

### Checklist triển khai

- [x] Tạo helper/service kiểm tra `ngay_ks` dùng chung.
  + `Diepxuan\Catalog\Services\KhoaSo` + `KhoaSoException`; singleton trong
    `CatalogServiceProvider::register()` để cache `ngay_ks` theo công ty trong 1 request.
  + API: `lockDate()`, `isDocumentDateLocked()`, `isPeriodLocked()`,
    `assertDocumentDateNotLocked()`, `assertPeriodNotLocked()`, `currentCompanyCode()`.
  + Quy tắc: hợp lệ khi `ngay_ct > ngay_ks`; kỳ hợp lệ khi `ngay2 > ngay_ks`.
    Không có cấu hình `ngay_ks` → trả `false` (không chặn nhầm).
  + Đọc qua `SystemConfig` (`SiSetup`) theo công ty hiện tại, không hardcode.
- [x] Unit test helper: chứng từ trước/đúng/sau ngày khóa sổ, kỳ tính toán, đổi công ty.
  + `tests/Unit/Packages/Catalog/KhoaSoTest.php` — **15 tests / 27 assertions PASS**.
- [x] Áp dụng helper cho CA4 phiếu báo nợ trước khi `AsPostCaPh2_glct`.
  + `Phieubaono::submit()` chặn ngay sau `validate()`, `addError('pNgay_Ct', ...)`.
  + `Phieubaono::deletePhieu()` chặn luôn đường xóa (asCADelCT2/asCADelPH2 không
    có `pNgay_ks` nên SQL không tự chặn).
- [x] Áp dụng helper cho SO3/PO3 và các form chứng từ đang có.
  + `Sovchso3Edit::submit()` và `Povchpo3Edit::submit()` — cùng vị trí sau validate.
  + `Sovchso3Edit::deleteInvoice()` và `Povchpo3Edit::deleteInvoice()` — chặn xóa.
    Lý do: `asSODelPH3` và `asPODeletePO3` **không có** `pNgay_ks`
    (xác nhận qua wrapper + `simba-docs/procedures/SO/procedures.md:2087` chỉ có
    `pMa_cty/pStt_rec/pLUser`), nên nếu chỉ guard ở submit thì xóa chứng từ cũ vẫn lọt.
- [x] Kiểm tra các SP wrapper có sẵn `pNgay_ks` để không truyền sai/sót.
  + **63 wrapper** có tham số `pNgay_ks`: nhóm AR/AP/GL/IN/SO/PO/CA post-to-GL,
    cộng `AsSOPostTraTruoc_arTt`, `AsProcessCalLaiKU`, `AssiUpd_ks`.
  + Các SP này tự kiểm tra `ngay_ks` phía SQL — form chỉ cần chặn sớm để có
    message tiếng Việt thay vì lỗi SP.
  + **`AsPostCaPh2_glct` KHÔNG có `pNgay_ks`** (grep wrapper = 0) — nằm trong nhóm
    "chưa kiểm tra", nên guard ở `Phieubaono::submit()` là bắt buộc chứ không
    phải lớp chặn sớm thừa.
- [x] Ghi rõ từng SP sau khi verify source SQL: có kiểm tra / không kiểm tra.
  + Có kiểm tra (wrapper có `pNgay_ks`): xem danh sách 63 SP ở mục 3 phía trên.
  + Chưa thấy kiểm tra trong wrapper (cần verify SQL thật khi dùng): nhóm CRUD
    `asARInsTT/asARUpdTT/asARDelTT`, `asGLCalSumCdTk`, `asPost2Gl`,
    `asGLCrtKC/asGLDelKC`, `asGLCrtDGTG/asGLDelDGTG`, `SP_CA1/2/3_*`,
    CRUD base của CACDPC/SO4, `asSOUpdPH3/asPOUpdPH3`, `asSODelPH3/asPODeletePO3`,
    `AsPostCaPh2_glct`, `asFACalKHTS/asFADelKHTS/asFAPostTS2GL/...`
    → **form phải tự chặn bằng `KhoaSo`** (đã áp dụng cho CA4/SO3/PO3 cả submit + delete).
- [x] E2E: thử lưu chứng từ ngày `<= ngay_ks` bị chặn với message tiếng Việt.
  + **PASS** (2026-11-12, browser thật Playwright + Chromium trên
    `http://portal.diepxuan.corp`, KHÔNG qua CLI).
  + `ngay_ks` hiện tại = `2026-08-30` (đọc từ `/simba/si/vch/smks`).
  + Mở SO3 `001wSO30000000633055` (`ngay_ct = 2025-09-03` → thuộc kỳ đã khóa),
    gọi `submit()`: form giữ nguyên trang, DOM hiển thị đúng
    **"Không được nhập/sửa/xóa chứng từ trước ngày khóa sổ."**; không có
    transaction nào được commit.
- [x] E2E: thử mở khóa tại `/simba/si/vch/smks` rồi lưu lại chứng từ cũ.
  + **PASS** (cùng ngày/phương pháp).
  + Đổi `ngay_ks` → `2025-01-01` tại `/simba/si/vch/smks` → "Đã cập nhật ngày
    khóa sổ."; submit lại cùng chứng từ: guard **không còn chặn** (không còn
    message khóa sổ) → chứng minh `KhoaSo` đọc đúng giá trị mới.
  + Đã **khôi phục** `ngay_ks = 2026-08-30` ngay sau test để không đổi dữ liệu
    vận hành.

#### Phát hiện thêm trong E2E (bug có sẵn, KHÔNG do task 360)

Sau khi mở khóa, submit đi qua guard thành công nhưng tầng ghi dữ liệu fail:

```
SQLSTATE[42000]: Procedure or function asSOUpdPH3 has too many arguments specified.
```

- App gửi **69 tham số**, `simba-docs/procedures/SO/procedures.md` (section
  `asSOUpdPH3`) cũng khai **69** — danh sách khớp từng tên, không thừa/thiếu.
- Nghĩa là **signature SP thực tế trong DB khác simba-docs** (ít hơn 69 tham số).
- Đây là lỗi có trước, thuộc wrapper `AsSOUpdPH3` / DB, **không liên quan**
  `KhoaSo`. Cần task riêng: đối chiếu `sys.parameters` của SP thật với wrapper.
- Lưu ý: không thể query `sys.parameters` từ shell (không có ODBC Driver 18);
  phải nhờ một màn hình Portal có sẵn chức năng đọc metadata, hoặc Sếp cung cấp
  kết quả query từ SQL Server Management Studio.

## Ghi chú

Task này là task đầu tiên được chuyển từ nhóm 181-196 System-Framework thành task cụ thể. Đã hoàn thành trước khi tách task.

## Audit Status

- **2026-06-30:** Implementation — route `/simba/si/vch/smks` hoạt động
- **2026-07-20:** Tách từ task 181-196 thành task riêng
- **2026-08-21:** Bổ sung follow-up kiểm tra `ngay_ks` trong Portal (chưa implement)
- **2026-10-19:** Implement helper `KhoaSo` + áp dụng CA4/SO3/PO3, 12 unit test PASS. E2E để Sếp test tay (CLI thiếu ODBC driver).
