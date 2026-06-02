# Task 032: SO - Tong hop module Ban hang

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Task tong hop cho toan bo module ban hang (Sales Order). Day la meta-task de theo tien do cac submodule.

## Chi tiet
- **DLL chinh:** SOVchSO1.dll, SOVchSO3.dll, SOUtilities.dll
- **Chuc nang:** Quan ly toan bo nghiep vu ban hang
- **Loai:** Meta-task (tong hop)
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO1.dll/README.md`
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO3.dll/README.md`
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOUtilities.dll/README.md`

---

## Pham vi module

Module ban hang (SO) bao gom cac chuc nang chinh:

### 1. Don hang ban (SO1) - SOVchSO1.dll
- Tao, sua, xoa don hang ban
- Quan ly trang thai don hang (Nhap, Cho duyet, Da duyet, Dang giao, Hoan thanh, Huy)
- Quan ly chi tiết don hang (vat tu, so luong, gia, thue)
- Kiem tra ton kho khi nhap lieu
- Lien ket voi phieu xuat va hoa don

### 2. Hoa don ban hang (SO3) - SOVchSO3.dll
- Tao hoa don tu don hang hoac doc lap
- Hoa don kiem phieu xuat / Chi la hoa don
- Quan ly so seri, mau hoa don
- Hach toan ke toan (No/Co)
- In hoa don VAT

### 3. Tien ich SO - SOUtilities.dll
- Lay gia ban (Get_GiaBan)
- Tinh chiet khau (Get_GiamGia)
- Lookup chuoi chung tu (DH->PX->HD->PN)
- Quan ly quyen in (Get_RightPrint, SoInsLogPrint)
- Kiem tra quyen chung tu (SOChkStatusRightSO1/2/3/5)

### 4. Danh muc lien quan
- Danh muc khach hang (ARDMKH)
- Danh muc nhan vien kinh doanh (SODMNVKD)
- Danh muc hinh thuc thanh toan (SODMHTTT)
- Danh muc dieu khoan thanh toan (SODMDKTT)
- Danh muc thue suat (SODMTS)
- Danh muc gia ban (SODMGIABAN)

---

## Chuoi chung tu

```
Don hang ban (SO1) → Phieu xuat (SO2) → Hoa don ban (SO3)
                                               ↓
                                        Phieu nhap tra lai (SO5)
```

---

## Sub-tasks lien quan

| Task | Mo ta | Trang thai |
|------|-------|------------|
| 32-ban-hang.md | Task tong hop (file nay) | Meta |
| 34-... | Lien ket ngan hang | Sub-task |
| 35-... | Lien ket nhom phan loai | Sub-task |
| 36-... | Lien ket danh muc tai khoan | Sub-task |
| 37-... | Lien ket ma thanh toan | Sub-task |
| 38-... | CRUD khach hang | Sub-task |
| 55-... | Hoa don ban hang | Sub-task |
| 043-... | Ma khach dac biet | Sub-task |
| 050-... | Phuong thuc Hung | Sub-task |

---

## Cau truc du lieu chinh

### Bang: SO1 (Don hang ban - Phan dau)
Xem chi tiet: `55-ban-hang-hoa-don-ban-hang.md`

### Bang: SO2 (Don hang ban - Chi tiet)
Xem chi tiet: `55-ban-hang-hoa-don-ban-hang.md`

### Bang: SO3 (Hoa don ban - Phan dau)
Xem chi tiet: `55-ban-hang-hoa-don-ban-hang.md`

### Bang: SO4 (Hoa don ban - Chi tiet)
Xem chi tiet: `55-ban-hang-hoa-don-ban-hang.md`

---

## Mapping PHP

### Services chinh

| Service | Mo ta |
|---------|-------|
| SOService | Xu ly nghiep vu ban hang |
| SOPricingService | Lay gia, tinh chiet khau (tu SOUtilities) |
| SOVoucherService | Xu ly voucher (SO1, SO3) |
| SOReportService | Bao cao, in an |

### Controllers/Livewire

| Component | Mo ta |
|-----------|-------|
| Donhangban | List don hang (SO1) |
| DonhangbanEdit | Edit don hang |
| Hoadonbanhang | List hoa don (SO3) |
| HoadonbanhangEdit | Edit hoa don |

---

## Business Logic

### Document Chain

```
Don hang ban (SO1) → Phieu xuat (SO2) → Hoa don ban (SO3) → Phieu nhap tra lai (SO5)
```

### Pricing Flow

1. User chon KH, VT, so luong
2. Goi SOCommon.Get_GiaBan() -> Lay gia
3. Goi SOCommon.Get_GiamGia() -> Tinh chiet khau
4. Tinh tong tien, thue, thanh toan
5. Luu chung tu -> Check rights
6. In chung tu -> Check RightPrint -> InsLogPrint

### Status Flow

| Trang thai | Mo ta |
|------------|-------|
| 0 | Nhap (Draft) |
| 1 | Cho duyet |
| 2 | Da duyet |
| 3 | Dang giao hang |
| 4 | Hoan thanh |
| 5 | Huy |

---

## Dependencies

| Loai | DLL | Ghi chu |
|------|-----|---------|
| Voucher | SOVchSO1.dll | Don hang ban |
| Voucher | SOVchSO3.dll | Hoa don ban |
| Utility | SOUtilities.dll | Pricing, Lookup, Print |
| Report | SORptTH01.dll | Tong hop ban hang |
| Report | SORptBK01.dll | Bang ke chung tu |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task tong hop
- [ ] Implement submodule Don hang ban (SO1)
- [ ] Implement submodule Hoa don ban (SO3)
- [ ] Implement SOUtilities (Pricing, Lookup)
- [ ] Implement cac danh muc lien quan
- [ ] Test chuoi chung tu (SO1->SO2->SO3)
- [ ] Test in an, bao cao
- [ ] Review va merge

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** NOT A TASK (meta/doc file, skipped)
