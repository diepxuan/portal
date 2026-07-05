# Task 124: FADGTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang dinh gia lai tai san co dinh tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADGTS.dll
- **Chuc nang:** Dinh gia lai tai san co dinh (Tang/Giam nguyen gia)
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Dinh gia lai tai san co dinh
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (danh gia)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADGTS.dll/README.md`

---

## Cau truc du lieu

### Bang: FADGTS (Dinh gia tai san)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_cty | varchar | Ma cong ty |
| stt_rec | varchar | So thu tu record |
| ma_ts_tgng | varchar | Ma tai san tang/giam nguyen gia |
| so_ct | varchar | So chung tu |
| ngay_ct | datetime | Ngay chung tu |
| ngay_tg | datetime | Ngay tang/giam |
| ma_ldtg | varchar | Ma ly do tang/giam |
| ngay_bdkh | datetime | Ngay bat dau khau hao |
| ngay_gt_cl | datetime | Ngay gia tri con lai |
| st_kh | int | So thang khau hao |
| tl_kh | decimal | Ty le khau hao thang |
| so_luong | int | So luong tang/giam |
| sua_kh | bit | Sua khau hao |
| ng_gia_n1-4 | decimal | Nguyen gia theo nguon von |
| gt_kh_n1-4 | decimal | Gia tri da KH |
| gt_cl_n1-4 | decimal | Gia tri con lai |
| kh_th_n1-4 | decimal | Khau hao thang |

### Bang: FADGTPTLK (Dinh gia phu tung linh kien)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | FK |
| ma_lk | varchar | Ma linh kien |
| ten_lk | nvarchar | Ten linh kien |
| dvt | nvarchar | Don vi tinh |
| so_luong | decimal | So luong |
| gia_tri | decimal | Gia tri |
| tang_giam | bit | Tang/Giam |

---

## Form classes

### frmFADGTS (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### frmFADGTSEdit (Form nhap lieu)
- **Ke thua:** frmDMComplexEdit
- **3 Tab**: tabTTDG (thong tin dinh gia), tabPT_LK (phu tung linh kien), tabTTKH (thong tin tai san)

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_DGTS_GET | Lay danh sach |
| SP_FA_DGTS_GETBYID | Lay chi tiet |
| SP_FA_DGTS_INSERT | Them |
| SP_FA_DGTS_UPDATE | Cap nhat |
| SP_FA_DGTS_DELETE | Xoa |

---

## Business Logic

### Business Rules

1. **Tang/Giam**: Chon kieu tang hoac giam nguyen gia
2. **Nguon von 4 nguon**: Quan ly theo 4 nguon von
3. **Phu tung linh kien**: Quan ly linh kien kem theo TS
4. **Sua KH**: Cho phep sua khau hao sau khi dinh gia

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model FADGTS, FADGTPTLK
- [ ] Tao Livewire Dinhgialaiscd va DinhgialaiscdEdit
- [ ] Tao Views (3 tabs)
- [ ] Them Routes
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `fa.vch.dgts`
- **Note:** Calculation/transfer/voucher shell chưa execute side-effect khi chưa audit payload.
