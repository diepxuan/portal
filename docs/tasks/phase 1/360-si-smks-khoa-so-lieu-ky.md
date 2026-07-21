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

## Ghi chú

Task này là task đầu tiên được chuyển từ nhóm 181-196 System-Framework thành task cụ thể. Đã hoàn thành trước khi tách task.

## Audit Status

- **2026-06-30:** Implementation — route `/simba/si/vch/smks` hoạt động
- **2026-07-20:** Tách từ task 181-196 thành task riêng
