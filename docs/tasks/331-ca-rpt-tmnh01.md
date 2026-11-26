# Task 331: Sổ quỹ tiền mặt (CARptTMNH01)

## Nhom: CA (Cash)

- **Status:** DONE — `Ca\Rpt\Carpttmnh01042002` + route `ca.rpt.carpttmnh01042002`, verify browser 2026-11-25 (**3 dòng, 22 cột**)
- **Route:** `ca.rpt.carpttmnh01042002` (suffix `042002`)
- **Loai:** Báo cáo (Report)
- **DLL:** CARptTMNH01.dll
- **Menu:** `04.20.02` — "Sổ quỹ tiền mặt"

## Tham số

`asCARptTMNH01` — **5 tham số**: `pMa_Cty`, `pTk`, `pNgay1`, `pNgay2`, `pMaNt`

## 🐛 Bug wrapper: SAI TÊN tham số

Wrapper cũ dùng tên không tồn tại trong SP:

| Wrapper cũ | SP thật cần |
|---|---|
| `pNgay_Ct1` | `pNgay1` |
| `pNgay_ct2` | `pNgay2` |
| `pMa_Nt` | `pMaNt` |

Cùng bug như `AsCARptTMNH02` (task 159) — đã sửa theo `procedures.md`.

## ⚠️ Route có suffix + conflict với component cũ

`sysMenu` có **2 menu active** cùng DLL `CARptTMNH01`:

| MenuID | Route name |
|---|---|
| `04.20.02` | `ca.rpt.carpttmnh01**042002**` |
| `04.20.32` | `ca.rpt.carpttmnh01**042032**` |

**Vấn đề phát sinh:** route `ca.rpt.carpttmnh01` (không suffix) đã bị component cũ
`Ca\Rpt\Tienmat` chiếm. Auto-registration **skip** tên đã tồn tại → component
`Carpttmnh01` không bao giờ được đăng ký.

**Giải pháp:** đặt tên component theo route có suffix thật → `Carpttmnh01042002`.

### Bài học: kiểm tra route conflict trước khi đặt tên

Khi route không suffix đã bị chiếm bởi component cũ, phải dùng tên có suffix.

## Portal implementation (2026-11-25)

- **Component:** `Ca\Rpt\Carpttmnh01042002` (kế thừa `Rpt\AbstractReport`)
- **View:** `ca/rpt/carpttmnh01042002.blade.php` + filter tương ứng

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::ca.rpt.carpttmnh01042002` render thật |
| Submit | **3 dòng, 22 cột** |
| 22 cột | `ma_cty`, `stt_rec`, `ma_ct`, `So_ct`, `Ngay_ct`, ... |
| Page error | **0** |
