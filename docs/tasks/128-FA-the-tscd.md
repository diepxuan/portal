# Task 128: FARptBCTS01

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang the tai san (bao cao bien dong) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCTS01.dll
- **Chuc nang:** The tai san (Bao cao bien dong TSCD)
- **Loai:** Report (Bao cao)
- **Assembly Title:** The tai san
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCTS01.dll/README.md`

---

## Form classes

### frmFARptBCTS01 (Form bao cao)
- **Ke thua:** frmReport2DGV (2 DataGridView: Master + Detail)

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_ts | AsTextBox | Ma tai san |
| dgvMaster | DataGridView | Luoi master (header) |
| dgvDetail | DataGridView | Luoi detail (chi tiet) |

---

## Business Logic

### Business Rules

1. **2 grid**: Master (thong tin TS) va Detail (chi tiet bien dong)
2. **Click chon**: Click vao dong master de xem chi tiet
3. **Checkbox**: Cot TAG de chon TS in

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_BCTS01_GET` | Lay du lieu the TSCD |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCTS01_GET
- [ ] Tao Livewire Thetaisan
- [ ] Tao View the-tai-san.blade.php (2 grid)
- [ ] Them Routes