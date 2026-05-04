# Task 127: FARptBCTS06

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao tang giam tai san co dinh tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCTS06.dll
- **Chuc nang:** Bao cao tang giam tai san co dinh
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bao cao tang giam tai san co dinh
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCTS06.dll/README.md`

---

## Form classes

### frmFARptBCTS06 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Bp | AsTextBox | Ma bo phan (MA_BPSD) |
| txtMa_Phi | AsTextBox | Ma phi (MA_PHI) |
| txtMa_Spct | AsTextBox | Ma SPCT (MA_SPCT) |

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_BCTS06_GET` | Lay du lieu tang giam TSCD |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCTS06_GET
- [ ] Tao Livewire Baocaotanggiam
- [ ] Tao View baocao-tang-giam.blade.php
- [ ] Them Routes