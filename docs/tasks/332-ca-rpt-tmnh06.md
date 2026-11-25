# Task 332: Sổ chi tiết tiền vay (CARptTMNH06)

## Nhom: CA (Cash)

- **Status:** DONE — `Ca\Rpt\Carpttmnh06` + route `ca.rpt.carpttmnh06`, verify browser 2026-11-25 (**193 dòng, 28 cột**)
- **Route:** `ca.rpt.carpttmnh06` — 1 menu, không suffix
- **Loai:** Báo cáo (Report)
- **DLL:** CARptTMNH06.dll
- **Menu:** `04.20.14` — "Sổ chi tiết tiền vay"

## Tham số

`asCARptTMNH06` — **6 tham số**: `pMa_cty`, `pNgay_ct1`, `pNgay_ct2`, `pTk`, `pMa_Ku`, `pMa_Nt`

Wrapper đã đúng sẵn — **không cần sửa**.

## 🐛 Bug phát hiện: route khai báo tay trỏ SAI component

`diepxuan/laravel-catalog/routes/web.php` dòng cũ:

```php
['uri' => 'ca/rpt/carpttmnh06', ..., 'component' => CaRptThu::class],
```

**Sai nghiệp vụ:** `CaRptThu` là "Phiếu thu", còn menu `04.20.14` là
**"Sổ chi tiết tiền vay"** — hai chức năng hoàn toàn khác nhau.

**Hậu quả:** trang `/simba/ca/rpt/carpttmnh06` (HTTP 500) render component
`Thu` thay vì báo cáo tiền vay.

**Fix:** comment route khai báo tay → auto-registration theo convention
tự đăng ký `Ca\Rpt\Carpttmnh06`.

### Bài học: route khai báo tay có thể trỏ SAI component

Không nên tin route có sẵn là đúng — phải đối chiếu:
- tên component
- tên menu (`sysMenu.title`)
- DLL

Nếu 3 thứ không khớp nhau → route khai báo tay đang sai.

## Portal implementation (2026-11-25)

- **Component:** `Ca\Rpt\Carpttmnh06` (kế thừa `Rpt\AbstractReport`)
- **View:** `ca/rpt/carpttmnh06.blade.php` + filter tương ứng
- **Files:** `routes/web.php` (comment route sai)

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| HTTP | **200** (trước fix: **500**) |
| Livewire component | `catalog::ca.rpt.carpttmnh06` render thật |
| Submit | **193 dòng, 28 cột** |
| 28 cột | `ma_kh`, `stt_rec`, `ma_ct`, `ngay_ct`, `ngay_lct`, ... |
| Page error | **0** |
