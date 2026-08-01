# Task 201: SO-Bang-Ke-Chung-Tu-Ban-Hang-01

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu ban hang (BK01) tu .NET sang PHP Laravel, dat ket qua tuong duong SORptBK01.

## Chi tiet
- **DLL:** SORptBK01.dll
- **Chuc nang:** Bang ke chung tu ban hang (Sale Voucher Register)
- **Loai:** Report (RPT)
- **Assembly Title:** Asia Enterprise
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO (tat ca loai chung tu SO)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptBK01.dll/README.md`

---

## Cau truc du lieu

### Du lieu master-detail (2 DataGridView)

#### Bang: PH (Phieu - Master)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| ma_kh | varchar | Ma khach hang |
| ten_kh | nvarchar | Ten khach hang |
| t_tien_nt2 | decimal | Tong tien NT |
| t_tien2 | decimal | Tong tien VND |
| t_thue_nt | decimal | Tong thue NT |
| t_thue | decimal | Tong thue VND |
| t_tt_nt | decimal | Tong thanh toan NT |
| t_tt | decimal | Tong thanh toan VND |

#### Bang: CT (Chi tiet - Detail)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ten_vt | nvarchar | Ten vat tu |
| dvt | nvarchar | Don vi tinh |
| ma_kho | varchar | Ma kho |
| so_luong | decimal | So luong |
| gia_nt2 | decimal | Gia NT |
| tien_nt2 | decimal | Tien NT |
| ts_gtgt | decimal | Thue suat GTGT |
| thue_gtgt_nt | decimal | Thue NT |
| gia2 | decimal | Gia VND |
| tien2 | decimal | Tien VND |
| ma_nvkd | varchar | Ma nhan vien kinh doanh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| PH (SO1-SO5) | Cac phieu ban hang | PK stt_rec |
| CT (SO2-SO4) | Chi tiet ban hang | FK stt_rec |
| DMKH | Khach hang | FK ma_kh |
| DMVT | Vat tu | FK ma_vt |
| DMKHO | Kho | FK ma_kho |
| DMNHKH | Nhom khach hang | Lookup |
| DMPLVT | Phan loai vat tu | Lookup |

---

## Form classes

### frmSORptBK01 (Form bao cao chinh)
- **Ke thua:** frmReport2DGV
- **Chuc nang:** Hien thi bang ke 2 DataGridView: phieu (ph) va chi tiet (ct)
- **Controls:**

#### TabFilter

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau_bc | ComboBox | Chon mau bao cao |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc |
| txtTieu_De | TextBox | Tieu de bao cao |
| txtSo_ct1 | TextBox | So chung tu tu |
| txtSo_ct2 | TextBox | So chung tu den |
| cboLoaiPhieu | AsComboBox | Loai phieu (SO1-SO5) |
| cboTrang_Thai | AsComboBox | Trang thai |
| txtMa_kh | AsTextBox | Ma khach hang |
| txtMa_Nhkh | AsTextBox | Nhom khach hang |
| txtMa_Plkh1 | AsTextBox | Phan loai KH 1 |
| txtMa_Plkh2 | AsTextBox | Phan loai KH 2 |
| txtMa_Plkh3 | AsTextBox | Phan loai KH 3 |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_nhhd | AsTextBox | Nhom hop dong |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Nhom vat tu |
| txtMa_plvt1 | AsTextBox | Phan loai VT 1 |
| txtMa_plvt2 | AsTextBox | Phan loai VT 2 |
| txtMa_plvt3 | AsTextBox | Phan loai VT 3 |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_bp | AsTextBox | Ma bo phan |
| txtMa_nvkd | AsTextBox | Ma nhan vien kinh doanh |
| txtMA_HTTT | AsTextBox | Hinh thuc thanh toan |
| txtMA_DKTT | AsTextBox | Dieu khoan thanh toan |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtMaLo | AsTextBox | Ma lo |
| txtMa_spct | AsTextBox | Ma san pham chi tiet |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |
| crvReportViewer | CrystalReportViewer | Viewer bao cao |

#### Labels hien thi ten (AutoLookup)

| Label | Mo ta |
|-------|-------|
| lblTen_KH | Ten khach hang |
| lblTen_nhkh | Ten nhom khach hang |
| lblTen_lkh1-lkh3 | Ten phan loai KH |
| lblTen_vt | Ten vat tu |
| lblTen_Nhvt | Ten nhom vat tu |
| lblTen_plvt1-plvt3 | Ten phan loai VT |
| lblTen_kho | Ten kho |
| lblTen_bp | Ten bo phan |
| lblTen_nvkd | Ten nhan vien KD |
| lblTenHTTT | Ten HTTT |
| lblTen_TT | Ten dieu khoan TT |
| lblTen_lo | Ten lo |
| lblTen_spct | Ten san pham CT |

#### DataGridViews

| Control | Mo ta |
|---------|-------|
| dgvBCPh | Grid hien thi danh sach phieu |
| dgvBCCt | Grid hien thi chi tiet (loc theo phieu) |

### Layout Grid

```
SplitContainer (scGrid)
├── dgvBCPh (tren) - Danh sach phieu
└── dgvBCCt (duoi) - Chi tiet phieu duoc chon
```

---

## Business Logic

### InitOtherComponents()

```csharp
ArrayList arrayList = new ArrayList();
arrayList.Add(CompanyInformations.CompanyID);
arrayList.Add(MyMenuInfo.moduleid);
arrayList.Add("0");  // Khong loc theo loai CT
arrayList.Add(SystemInformations.CurrentCultureName);

ArrayList arrayList2 = CBO<lstVoucherInfo>.FillCollection(
    Commons.GetDataReader("asSIGetDmSo_ct", arrayList.ToArray()));
arrayList2.Add(new lstVoucherInfo("", "Tat ca")); // Them option "Tat ca"
cboLoaiPhieu.DataSource = arrayList2;
```

### LoadData()

```csharp
DataSet dataSet = MyController.GetDataSet(arrayList.ToArray());

// Set nguon cho 2 grid
set_MyDGVPhSource(isSet2Print: true, dataSet.Tables[1]);  // Phieu
set_MyDGVCtSource(isSet2Print: true, dataSet.Tables[0]);  // Chi tiet
```

### dgvBCPh_RowEnter()

Loc chi tiet theo phieu duoc chon:

```csharp
((DataTable)dgvBCCt.DataSource).DefaultView.RowFilter =
    "stt_rec='" + ((DataTable)dgvBCPh.DataSource).DefaultView[e.RowIndex]["stt_rec"].ToString() + "'";
```

### GetFilterTitle()

Xay dung chuoi tieu de loc tu cac dieu kien da chon.

### Loc theo loai phieu

- Tat ca chung tu SO1, SO2, SO3, SO4, SO5
- Hoac chi mot loai cu the

---

## Mapping PHP (path theo route /simba/so/rpt/sorptbk01)

### 1. Stored Procedure

- File: `diepxuan/laravel-simba/src/StoredProcedures/AsSORptBK01.php`
- SP: `asSORptBK01` (sysReportInfo spname, report `SOBK013.rpt` / `SOBK014.rpt` / `SOBK011.rpt`)
- `callWithDataSets()` doc tra ve 2 result sets: `ct` (Tables[0]) va `ph` (Tables[1]).
- 28 tham so lay tu `frmSORptBK01.LoadData()` trong simba-docs/decompiled.

### 2. Livewire Component

- File: `diepxuan/laravel-catalog/src/Http/Livewire/So/Rpt/Sorptbk01.php`
- Namespace: `Diepxuan\Catalog\Http\Livewire\So\Rpt`
- Component hien thi master-detail: `phieuRows`, `chiTietRows`, `chiTietFiltered`.
- Filter controls: ngay, loai phieu (`asSIGetDmSo_ct`), trang thai, so CT, KH, nhom/phan loai KH, HD, nhom HD, VT, nhom/phan loai VT, kho, vi tri, lo, HTTT, DKTT, bo phan, NVKD, SPCT, ngoai te.

### 3. View

- File: `diepxuan/laravel-catalog/resources/views/so/rpt/sorptbk01.blade.php`
- Blade path: `catalog::so.rpt.sorptbk01`
- Layout theo DESIGN.md va pattern task 008/359/370: `x-nav-tabs`, table wrapper `rounded-lg border border-gray-200 bg-white shadow-sm`.

### 4. Routes

```php
// diepxuan/laravel-catalog/routes/web.php
['uri' => 'so/rpt/sorptbk01', 'name' => 'so.rpt.sorptbk01', 'module' => 'so', 'kind' => 'rpt', 'slug' => 'sorptbk01', 'component' => Sorptbk01::class],
['uri' => 'so/rpt/sorptbk01062002', 'name' => 'so.rpt.sorptbk01062002', 'module' => 'so', 'kind' => 'rpt', 'slug' => 'sorptbk01062002', 'component' => Sorptbk01::class],
```

URL thuc te:
- `http://portal.diepxuan.corp/simba/so/rpt/sorptbk01`
- `http://portal.diepxuan.corp/simba/so/rpt/sorptbk01062002`

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| SP | laravel-simba | AsSORptBK01.php | asSORptBK01, 2 result sets ct/ph |
| Component | laravel-catalog | Http/Livewire/So/Rpt/Sorptbk01.php | Master-detail report |
| View | laravel-catalog | resources/views/so/rpt/sorptbk01.blade.php | Filter + phieu/detail grids |
| Lookup | laravel-simba | AsSIGetDmSo_ct.php | Danh muc loai chung tu SO |

---

## Progress Checklist

- [x] Phan tich yeu cau & review task nay
- [x] Tao Stored Procedure class AsSORptBK01 (callWithDataSets)
- [x] Tao Livewire Sorptbk01 component
- [x] Tao View voi 2 grid (phieu + chi tiet)
- [x] Implement selectPhieu de loc chi tiet
- [x] Them filter controls (ngay, loai phieu, KH, VT, kho...)
- [x] Them Routes (so/rpt/sorptbk01 + compact suffix)
- [x] Test export Excel (CSV)
- [ ] Test filter va loc chi tiet voi du lieu thuc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (Livewire component + SP wrapper + route mapping)
- **Source:** `simba-docs/data/sysReportInfo.md` (asSORptBK01), `simba-docs/decompiled/asia/SORptBK01.dll` (frmSORptBK01.cs), `simba-docs/procedures/SO/procedures.md` (asSIGetDmSo_ct).
- **Note:** Chua verify voi du lieu thuc tren SQL Server; can chay E2E sau khi co session/login va database Simba.
