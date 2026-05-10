# Task 125: FABHCC

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bang phan bo khau hao theo nhom tai san tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FABHCC.dll
- **Chuc nang:** Bang phan bo khau hao theo nhom tai san
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bang phan bo khau hao theo nhom tai san
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FABHCC.dll/README.md`

---

## Form classes

### frmFABHCC (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky bao cao |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| txtMa_nhts | AsTextBox | Ma nhom tai san |
| txtMa_bpsd | AsTextBox | Ma bo phan su dung |
| cboMau_bc | ComboBox | Mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FAMHTS | Hao mon tai san | Transaction |
| FATSO | Tai san co dinh | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_BHCC_GET` | Lay du lieu bang phan bo KH |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BHCC_GET
- [ ] Tao Livewire Bangphanbokhauhao
- [ ] Tao View bang-phan-bo-khau-hao.blade.php
- [ ] Them Routes
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
