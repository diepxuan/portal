# Task 130: FARptBCTS08

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao bien dong tai san 08 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCTS08.dll
- **Chuc nang:** Bao cao bien dong tai san 08
- **Loai:** Report (Bao cao)
- **Assembly Title:** FARptBCTS08
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCTS08.dll/README.md`

---

## Form classes

### frmFARptBCTS08 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_ts | AsTextBox | Ma tai san (MA_TS) |
| txtMa_nhts | AsTextBox | Ma nhom tai san (MA_NHTS) |
| txtMa_bpsd | AsTextBox | Ma bo phan su dung (MA_BPSD) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao |
| cboMau_bc | ComboBox | Mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_BCTS08_GET` | Lay du lieu bien dong TSCD 08 |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCTS08_GET
- [ ] Tao Livewire Baocaobiendo ng08
- [ ] Tao View baocao-bien-dong-08.blade.php
- [ ] Them Routes