# Task 201: SO - Bảng kê chứng từ bán hàng 01

## Nhóm: SO (Sales Order - Đơn hàng bán)

## Mục tiêu

Chuyển đổi chức năng bảng kê chứng từ bán hàng (BK01) từ .NET sang PHP Laravel, đạt kết quả tương đương `SORptBK01`.

## Chi tiết

- **DLL:** SORptBK01.dll
- **Chức năng:** Bảng kê chứng từ bán hàng (Sale Voucher Register)
- **Loại:** Report (RPT)
- **Assembly Title:** Asia Enterprise
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Mã CT:** SO (tất cả loại chứng từ SO)

## Tài liệu tham khảo

- `simba-docs/asia/so/reports/SORptBK01.md`
- `simba-docs/decompiled/asia/SORptBK01.dll/AsiaErp.UserInterface/frmSORptBK01.cs`

---

## Cấu trúc dữ liệu

### Dữ liệu master-detail (2 DataGridView)

#### Bảng PH (Phiếu - Master)

| Trường | Kiểu | Mô tả |
|--------|------|-------|
| `stt_rec` | varchar | Số thứ tự record |
| `ngay_ct` | datetime | Ngày chứng từ |
| `so_ct` | varchar | Số chứng từ |
| `ma_kh` | varchar | Mã khách hàng |
| `ten_kh` | nvarchar | Tên khách hàng |
| `t_tien_nt2` | decimal | Tổng tiền NT |
| `t_tien2` | decimal | Tổng tiền VND |
| `t_thue_nt` | decimal | Tổng thuế NT |
| `t_thue` | decimal | Tổng thuế VND |
| `t_tt_nt` | decimal | Tổng thanh toán NT |
| `t_tt` | decimal | Tổng thanh toán VND |

#### Bảng CT (Chi tiết - Detail)

| Trường | Kiểu | Mô tả |
|--------|------|-------|
| `stt_rec` | varchar | Số thứ tự record (FK) |
| `stt_rec0` | varchar | Số thứ tự chi tiết |
| `ma_vt` | varchar | Mã vật tư |
| `ten_vt` | nvarchar | Tên vật tư |
| `dvt` | nvarchar | Đơn vị tính |
| `ma_kho` | varchar | Mã kho |
| `so_luong` | decimal | Số lượng |
| `gia_nt2` | decimal | Giá NT |
| `tien_nt2` | decimal | Tiền NT |
| `ts_gtgt` | decimal | Thuế suất GTGT |
| `thue_gtgt_nt` | decimal | Thuế NT |
| `gia2` | decimal | Giá VND |
| `tien2` | decimal | Tiền VND |
| `ma_nvkd` | varchar | Mã nhân viên kinh doanh |

### Quan hệ bảng

| Bảng | Mô tả | Relationship |
|------|-------|---------------|
| `PH` (SO1-SO5) | Các phiếu bán hàng | PK `stt_rec` |
| `CT` (SO2-SO4) | Chi tiết bán hàng | FK `stt_rec` |
| `DMKH` | Khách hàng | FK `ma_kh` |
| `DMVT` | Vật tư | FK `ma_vt` |
| `DMKHO` | Kho | FK `ma_kho` |
| `DMNHKH` | Nhóm khách hàng | Lookup |
| `DMPLVT` | Phân loại vật tư | Lookup |

---

## Form classes

### frmSORptBK01 (Form báo cáo chính)

- **Kế thừa:** frmReport2DGV
- **Chức năng:** Hiển thị bảng kê 2 DataGridView: phiếu (`ph`) và chi tiết (`ct`)

#### TabFilter

| Control | Type | Mô tả |
|---------|------|-------|
| `cboMau_bc` | ComboBox | Chọn mẫu báo cáo |
| `cboKyBc` | ComboBox | Chọn kỳ báo cáo |
| `txtNgay1` | AsMaskedTextBox | Ngày bắt đầu |
| `txtNgay2` | AsMaskedTextBox | Ngày kết thúc |
| `txtTieu_De` | TextBox | Tiêu đề báo cáo |
| `txtSo_ct1` | TextBox | Số chứng từ từ |
| `txtSo_ct2` | TextBox | Số chứng từ đến |
| `cboLoaiPhieu` | AsComboBox | Loại phiếu (SO1-SO5) |
| `cboTrang_Thai` | AsComboBox | Trạng thái |
| `txtMa_kh` | AsTextBox | Mã khách hàng |
| `txtMa_Nhkh` | AsTextBox | Nhóm khách hàng |
| `txtMa_Plkh1` | AsTextBox | Phân loại KH 1 |
| `txtMa_Plkh2` | AsTextBox | Phân loại KH 2 |
| `txtMa_Plkh3` | AsTextBox | Phân loại KH 3 |
| `txtMa_hd` | AsTextBox | Mã hợp đồng |
| `txtMa_nhhd` | AsTextBox | Nhóm hợp đồng |
| `txtMa_vt` | AsTextBox | Mã vật tư |
| `txtMa_nhvt` | AsTextBox | Nhóm vật tư |
| `txtMa_plvt1` | AsTextBox | Phân loại VT 1 |
| `txtMa_plvt2` | AsTextBox | Phân loại VT 2 |
| `txtMa_plvt3` | AsTextBox | Phân loại VT 3 |
| `txtMa_kho` | AsTextBox | Mã kho |
| `txtMa_bp` | AsTextBox | Mã bộ phận |
| `txtMa_nvkd` | AsTextBox | Mã nhân viên kinh doanh |
| `txtMA_HTTT` | AsTextBox | Hình thức thanh toán |
| `txtMA_DKTT` | AsTextBox | Điều khoản thanh toán |
| `txtMa_vitri` | AsTextBox | Mã vị trí |
| `txtMaLo` | AsTextBox | Mã lô |
| `txtMa_spct` | AsTextBox | Mã sản phẩm chi tiết |
| `txtMa_Nt` | AsTextBox | Mã ngoại tệ |
| `optVND` | RadioButton | Tiền VND |
| `optNt` | RadioButton | Tiền ngoại tệ |
| `crvReportViewer` | CrystalReportViewer | Viewer báo cáo |

#### Label hiển thị tên (AutoLookup)

| Label | Mô tả |
|-------|-------|
| `lblTen_KH` | Tên khách hàng |
| `lblTen_nhkh` | Tên nhóm khách hàng |
| `lblTen_lkh1-lkh3` | Tên phân loại KH |
| `lblTen_vt` | Tên vật tư |
| `lblTen_Nhvt` | Tên nhóm vật tư |
| `lblTen_plvt1-plvt3` | Tên phân loại VT |
| `lblTen_kho` | Tên kho |
| `lblTen_bp` | Tên bộ phận |
| `lblTen_nvkd` | Tên nhân viên KD |
| `lblTenHTTT` | Tên HTTT |
| `lblTen_TT` | Tên điều khoản TT |
| `lblTen_lo` | Tên lô |
| `lblTen_spct` | Tên sản phẩm CT |

#### DataGridViews

| Control | Mô tả |
|---------|-------|
| `dgvBCPh` | Grid hiển thị danh sách phiếu |
| `dgvBCCt` | Grid hiển thị chi tiết (lọc theo phiếu) |

### Layout Grid

```
SplitContainer (scGrid)
├── dgvBCPh (trên) - Danh sách phiếu
└── dgvBCCt (dưới) - Chi tiết phiếu được chọn
```

---

## Business Logic

### InitOtherComponents()

```csharp
ArrayList arrayList = new ArrayList();
arrayList.Add(CompanyInformations.CompanyID);
arrayList.Add(MyMenuInfo.moduleid);
arrayList.Add("0");  // Không lọc theo loại CT
arrayList.Add(SystemInformations.CurrentCultureName);

ArrayList arrayList2 = CBO<lstVoucherInfo>.FillCollection(
    Commons.GetDataReader("asSIGetDmSo_ct", arrayList.ToArray()));
arrayList2.Add(new lstVoucherInfo("", "Tất cả")); // Thêm option "Tất cả"
cboLoaiPhieu.DataSource = arrayList2;
```

### LoadData()

```csharp
DataSet dataSet = MyController.GetDataSet(arrayList.ToArray());

// Set nguồn cho 2 grid
set_MyDGVPhSource(isSet2Print: true, dataSet.Tables[1]);  // Phiếu
set_MyDGVCtSource(isSet2Print: true, dataSet.Tables[0]);  // Chi tiết
```

### dgvBCPh_RowEnter()

Lọc chi tiết theo phiếu được chọn:

```csharp
((DataTable)dgvBCCt.DataSource).DefaultView.RowFilter =
    "stt_rec='" + ((DataTable)dgvBCPh.DataSource).DefaultView[e.RowIndex]["stt_rec"].ToString() + "'";
```

### GetFilterTitle()

Xây dựng chuỗi tiêu đề lọc từ các điều kiện đã chọn.

### Lọc theo loại phiếu

- Tất cả chứng từ SO1, SO2, SO3, SO4, SO5
- Hoặc chỉ một loại cụ thể

---

## Mapping PHP (path theo route /simba/so/rpt/sorptbk01)

### 1. Stored Procedure

- File: `diepxuan/laravel-simba/src/StoredProcedures/AsSORptBK01.php`
- SP: `asSORptBK01` (sysReportInfo spname, report `SOBK013.rpt` / `SOBK014.rpt` / `SOBK011.rpt`)
- `callWithDataSets()` đọc và trả về 2 result sets: `ct` (Tables[0]) và `ph` (Tables[1]).
- 28 tham số lấy từ `frmSORptBK01.LoadData()` trong simba-docs/decompiled.

### 2. Livewire Component

- File: `diepxuan/laravel-catalog/src/Http/Livewire/So/Rpt/Sorptbk01.php`
- Namespace: `Diepxuan\Catalog\Http\Livewire\So\Rpt`
- Component hiển thị master-detail: `phieuRows`, `chiTietRows`, `chiTietFiltered`.
- Filter controls: ngày, loại phiếu (`asSIGetDmSo_ct`), trạng thái, số CT, KH, nhóm/phân loại KH, HD, nhóm HD, VT, nhóm/phân loại VT, kho, vị trí, lô, HTTT, DKTT, bộ phận, NVKD, SPCT, ngoại tệ.

### 3. View

- File: `diepxuan/laravel-catalog/resources/views/so/rpt/sorptbk01.blade.php`
- Blade path: `catalog::so.rpt.sorptbk01`
- Layout theo DESIGN.md và pattern task 008/359/370: `x-nav-tabs`, table wrapper `rounded-lg border border-gray-200 bg-white shadow-sm`.

### 4. Routes

```php
// diepxuan/laravel-catalog/routes/web.php
['uri' => 'so/rpt/sorptbk01', 'name' => 'so.rpt.sorptbk01', 'module' => 'so', 'kind' => 'rpt', 'slug' => 'sorptbk01', 'component' => Sorptbk01::class],
['uri' => 'so/rpt/sorptbk01062002', 'name' => 'so.rpt.sorptbk01062002', 'module' => 'so', 'kind' => 'rpt', 'slug' => 'sorptbk01062002', 'component' => Sorptbk01::class],
```

URL thực tế:
- `http://portal.diepxuan.corp/simba/so/rpt/sorptbk01`
- `http://portal.diepxuan.corp/simba/so/rpt/sorptbk01062002`

## Dependencies

| Loại | Package | File | Ghi chú |
|------|---------|------|---------|
| SP | laravel-simba | AsSORptBK01.php | asSORptBK01, 2 result sets ct/ph |
| Component | laravel-catalog | Http/Livewire/So/Rpt/Sorptbk01.php | Master-detail report |
| View | laravel-catalog | resources/views/so/rpt/sorptbk01.blade.php | Filter + phiếu/chi tiết grids |
| Lookup | laravel-simba | AsSIGetDmSo_ct.php | Danh mục loại chứng từ SO |

---

## Progress Checklist

- [x] Phân tích yêu cầu và review task này
- [x] Tạo Stored Procedure class `AsSORptBK01` (`callWithDataSets`)
- [x] Tạo Livewire `Sorptbk01` component
- [x] Tạo View với 2 grid (phiếu + chi tiết)
- [x] Implement `selectPhieu` để lọc chi tiết
- [x] Thêm filter controls (ngày, loại phiếu, KH, VT, kho...)
- [x] Thêm routes (`so/rpt/sorptbk01` + compact suffix)
- [x] Test export Excel (CSV)
- [ ] Test filter và lọc chi tiết với dữ liệu thực

---

## Audit Status

- **Ngày audit:** 2026-05-10
- **Kết quả:** IN PROGRESS — implementation xong, chờ E2E với SQL Server

## Portal implementation status

- **Status:** IN PROGRESS (Livewire component + SP wrapper + route mapping đã xong, chưa verify dữ liệu thực)
- **Source:** `simba-docs/data/sysReportInfo.md` (asSORptBK01), `simba-docs/decompiled/asia/SORptBK01.dll` (frmSORptBK01.cs), `simba-docs/procedures/SO/procedures.md` (asSIGetDmSo_ct).
- **Note:** Chưa verify với dữ liệu thực trên SQL Server; cần chạy E2E sau khi có session/login và database Simba.
