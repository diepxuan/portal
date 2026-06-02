# Task 069: POVchPO3 — Hóa đơn mua hàng

## Nhom: PO (Purchase Order - Đơn hàng mua)

---

## Audit Results (2026-05-14)

**Ngày audit:** 2026-05-14
**Người audit:** Bột (sub-agent)
**Nguồn đối chiếu:** Schema Simba ERP .NET — repo SimbaSql, file `dbo/Tables/PoPh3.sql`, `PoCt3.sql`, `PoCp3.sql`

### Kết luận

- **Schema nguồn duy nhất:** SimbaSql repo (`dbo/Tables/`), đã xác thực trực tiếp từ file `.sql`
- **Bộ bảng ĐÚNG:** `PoPh3` (Header), `PoCt3` (Chi tiết vật tư), `PoCp3` (Chi phí)
- **KHÔNG tồn tại:** `POHMN`, `POHMNCT`, `POHMNCP` — không có trong SimbaSql schema, không có trong bất kỳ DB nào. Đây là suy đoán sai.
- Các cột trong task này đã được thay thế bằng danh sách cột thực tế từ file `.sql`

### Kiểm tra codebase hiện tại

| Hạng mục | Code thực tế | Kết luận |
|----------|--------------|----------|
| SModel `PoPh3Model` | ✅ Tồn tại, table=`PoPh3` | ĐÚNG |
| SModel `PoCt3Model` | ✅ Tồn tại, table=`PoCt3` | ĐÚNG |
| SModel `PoCp3Model` | ✅ Tồn tại, table=`PoCp3` | ĐÚNG |
| Bảng Po3HT | Không có trong simba-docs | ĐÚNG — không có bảng hạch toán riêng |
| Livewire List `Hoadonmua.php` | ✅ Tồn tại | Cần refactor sang dùng PoPh3 |
| Livewire Edit `HoadonmuaEdit.php` | ✅ Tồn tại | Cần refactor sang dùng PoPh3 |
| Views `hoadonmua*.blade.php` | ✅ Tồn tại | ĐÚNG |
| Model class (non-SModel) | ❌ Không có file nào trong `src/Models/` cho PoPh3/PoCt3/PoCp3 | Cần tạo |
| SP wrapper classes | ❌ Không có cho AsPOGetPO3, AsPOSavePO3, AsPODeletePO3, ... | Cần tạo |
| Routes web `/muahang/hoadonmua` | ✅ 3 routes tồn tại | ĐÚNG |
| API routes `/api/po/*` | ❌ Không tồn tại | Không cần nếu dùng Livewire |

### SP classes đã có trong codebase

| SP Class | Trạng thái |
|----------|------------|
| AsPOChkRightStatusPO3 | ✅ ĐÃ CÓ |
| AsReCalPO3 | ✅ ĐÃ CÓ |
| AsReCalPO34Relate | ✅ ĐÃ CÓ |
| AsAPUpdTt_SoDuPo3 | ✅ ĐÃ CÓ |

---

## Muc tieu

Chuyển đổi chứng từ **Hóa đơn mua hàng (PO3)** từ .NET (POVchPO3.dll) sang PHP Laravel.

## Chi tiet

- **DLL:** POVchPO3.dll
- **Chứng từ:** PO3 — Hóa đơn mua hàng
- **Loại:** Voucher (kế thừa frmVoucher)
- **Assembly Title:** Voucher hóa đơn mua hàng
- **Version:** 9.1.0.0
- **Framework:** .NET Framework 3.5
- **Namespace:** AsiaErp.UserInterface
- **Company:** Asia Software Development JSC
- **Ma_ct:** PO3

## GitHub Issues

- **Issue:** #178 (PO3)
- **Project Board:** https://github.com/orgs/diepxuan/projects/2

## Tai lieu tham khao

- Decompiled: `simba-docs/decompiled/asia/POVchPO3.dll/README.md`
- Voucher spec: `simba-docs/asia/po/vouchers/POVchPO3.md`
- PO3 spec: `simba-docs/asia/po/vouchers/PO3.md`
- SP Index: `simba-docs/asia/SP_INDEX.md`

---

## Bối cảnh module PO

Module Mua hàng (Purchase Order) trong Simba ERP gồm các chức năng:

| Task ID | Chức năng             | DLL          | Status        |
| ------- | --------------------- | ------------ | ------------- |
| 063     | CT Mua hàng           | —            | TODO          |
| 064     | DM ĐK TT              | —            | TODO          |
| 065     | PTLHM                 | —            | TODO          |
| 068     | DM HTTT               | —            | TODO          |
| **069** | **Hóa đơn mua (PO3)** | POVchPO3.dll | **IN REVIEW** |
| 070     | CT nhận hàng mua      | —            | TODO          |
| 074     | PTT mua hàng          | —            | TODO          |
| 080     | ĐH mua hàng           | —            | TODO          |
| 217     | Hóa đơn mua DV (PO6)  | PoVchPO6.dll | TODO          |

**Nguyên tắc triển khai:**

1. Mỗi bước = 1 commit
2. 1 Phase = 1 branch = 1 PR
3. Không push khi Sếp chưa yêu cầu
4. Tham chiếu pattern từ code hiện có (Cash, Banhang)
5. SP là interface duy nhất — PHP không query trực tiếp vào bảng

---

## Cau truc du lieu

**NGUỒN:** Schema từ Simba ERP .NET (repo SimbaSql, dbo/Tables/). Không suy đoán.
**KHÔNG tồn tại:** POHMN, POHMNCT, POHMNCP — không có trong SimbaSql schema, không có trong bất kỳ DB nào.

### Bảng: PoPh3 (Header) — table name trong DB: `PoPh3`

**PK:** `ma_cty`, `stt_rec`

| Truong | Kieu | Mo ta |
| ---------- | -------- | --------------------- |
| ma_cty | NVARCHAR(3) | Mã công ty |
| stt_rec | NVARCHAR(20) | Số thứ tự record (PK) |
| ma_ct | NVARCHAR(3) | Mã chứng từ |
| ma_gd | NVARCHAR(1) | Mã giao dịch |
| mau_hd | NVARCHAR(1) | Mẫu hóa đơn |
| ma_kh | NVARCHAR(20) | Mã khách hàng/NCC |
| dia_chi | NVARCHAR(255) | Địa chỉ |
| nguoi_gd | NVARCHAR(30) | Người giao dịch |
| ma_httt | NVARCHAR(20) | Hình thức thanh toán |
| tk_pt | NVARCHAR(20) | Tài khoản phải trả |
| tk_ck_ds | NVARCHAR(20) | TK chiết khấu doanh số |
| dien_giai | NVARCHAR(255) | Diễn giải |
| so_seri | NVARCHAR(12) | Số seri |
| so_ct | NVARCHAR(12) | Số chứng từ |
| ngay_ct | SMALLDATETIME | Ngày chứng từ |
| ngay_lct | SMALLDATETIME | Ngày lập chứng từ |
| kht_tain | BIT | Khách thuế đầu vào |
| ngay_pn | SMALLDATETIME | Ngày nhập |
| so_pn | NVARCHAR(12) | Số phiếu nhập |
| ngay_hd | SMALLDATETIME | Ngày hóa đơn |
| so_hd | NVARCHAR(12) | Số hóa đơn |
| ma_tt_po | NVARCHAR(8) | Mã thanh toán PO |
| han_ck | DECIMAL(19,4) | Hạn chiết khấu |
| tl_ck | DECIMAL(19,4) | Tỷ lệ chiết khấu |
| han_tt | DECIMAL(19,4) | Hạn thanh toán |
| ls_qh | DECIMAL(19,4) | Lãi suất quá hạn |
| ma_nt | NVARCHAR(3) | Mã ngoại tệ |
| ty_gia | DECIMAL(19,4) | Tỷ giá |
| t_tien_nt0 | DECIMAL(19,4) | Tổng tiền NT (trước thuế) |
| t_tien0 | DECIMAL(19,4) | Tổng tiền VND (trước thuế) |
| ts_nk | DECIMAL(19,4) | Thuế suất NK |
| t_thue_nk_nt | DECIMAL(19,4) | Thuế NK NT |
| t_thue_nk | DECIMAL(19,4) | Thuế NK VND |
| ts_ttdb | DECIMAL(19,4) | Thuế suất TTĐB |
| t_thue_ttdb_nt | DECIMAL(19,4) | Thuế TTĐB NT |
| t_thue_ttdb | DECIMAL(19,4) | Thuế TTĐB VND |
| t_cp_nt | DECIMAL(19,4) | Tổng chi phí NT |
| t_cp | DECIMAL(19,4) | Tổng chi phí VND |
| t_tien_nt | DECIMAL(19,4) | Tổng tiền NT |
| t_tien | DECIMAL(19,4) | Tổng tiền VND |
| t_thue_nt | DECIMAL(19,4) | Tổng thuế NT |
| t_thue | DECIMAL(19,4) | Tổng thuế VND |
| tl_ck_hd | DECIMAL(19,4) | Tỷ lệ CK hóa đơn |
| t_ck | DECIMAL(19,4) | Tổng CK VND |
| t_ck_nt | DECIMAL(19,4) | Tổng CK NT |
| t_tt | DECIMAL(19,4) | Tổng thanh toán VND |
| t_tt_nt | DECIMAL(19,4) | Tổng thanh toán NT |
| t_so_luong | DECIMAL(19,4) | Tổng số lượng |
| ck_st | BIT | Chiết khấu trước thuế |
| sua_tien | BIT | Sửa tiền |
| sua_thue | BIT | Sửa thuế |
| sua_thue_nk | BIT | Sửa thuế NK |
| sua_thue_ttdb | BIT | Sửa thuế TTĐB |
| sua_tt | BIT | Sửa tổng |
| tao_tu_pn | BIT | Tạo từ phiếu nhập |
| tao_tu_dh | BIT | Tạo từ đơn hàng |
| trang_thai | NVARCHAR(1) | Trạng thái |
| ghi_chu | NVARCHAR(255) | Ghi chú |
| post2gl | BIT | Post vào GL |
| post2in | BIT | Post vào Inventory |
| cdate | SMALLDATETIME | Ngày tạo |
| cuser | NVARCHAR(20) | Người tạo |
| ldate | SMALLDATETIME | Ngày sửa |
| luser | NVARCHAR(20) | Người sửa |

### Bảng: PoCt3 (Chi tiết vật tư) — table name trong DB: `PoCt3`

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`

| Truong | Kieu | Mo ta |
| --------------- | -------- | --------------------------- |
| ma_cty | NVARCHAR(3) | Mã công ty |
| stt_rec | NVARCHAR(20) | Số thứ tự record (FK → PoPh3) |
| stt_rec0 | NVARCHAR(3) | Số thứ tự dòng |
| ma_vt | NVARCHAR(20) | Mã vật tư |
| ten_vt | NVARCHAR(100) | Tên vật tư |
| tk_vt | NVARCHAR(20) | TK vật tư |
| tk_thue | NVARCHAR(20) | TK thuế GTGT |
| tk_thue_nk | NVARCHAR(20) | TK thuế NK |
| tk_thue_ttdb | NVARCHAR(20) | TK thuế TTĐB |
| ma_kho | NVARCHAR(8) | Mã kho |
| ma_vitri | NVARCHAR(8) | Mã vị trí |
| ma_lo | NVARCHAR(20) | Mã lô |
| so_luong | DECIMAL(19,4) | Số lượng |
| dvt | NVARCHAR(8) | Đơn vị tính |
| so_luong_qd | DECIMAL(19,4) | Số lượng quy đổi |
| gia_nt0 | DECIMAL(19,4) | Đơn giá NT (trước thuế) |
| gia0 | DECIMAL(19,4) | Đơn giá VND (trước thuế) |
| tien_nt0 | DECIMAL(19,4) | Thành tiền NT (trước thuế) |
| tien0 | DECIMAL(19,4) | Thành tiền VND (trước thuế) |
| ts_nk | DECIMAL(19,4) | Thuế suất NK |
| thue_nk_nt | DECIMAL(19,4) | Thuế NK NT |
| thue_nk | DECIMAL(19,4) | Thuế NK VND |
| ts_ttdb | DECIMAL(19,4) | Thuế suất TTĐB |
| thue_ttdb_nt | DECIMAL(19,4) | Thuế TTĐB NT |
| thue_ttdb | DECIMAL(19,4) | Thuế TTĐB VND |
| cp_nt | DECIMAL(19,4) | Chi phí NT |
| cp | DECIMAL(19,4) | Chi phí VND |
| gia_nt | DECIMAL(19,4) | Đơn giá NT |
| gia | DECIMAL(19,4) | Đơn giá VND |
| tien_nt | DECIMAL(19,4) | Thành tiền NT |
| tien | DECIMAL(19,4) | Thành tiền VND |
| ts_gtgt | DECIMAL(19,4) | Thuế suất GTGT |
| thue_gtgt_nt | DECIMAL(19,4) | Thuế GTGT NT |
| thue_gtgt | DECIMAL(19,4) | Thuế GTGT VND |
| tl_ck | DECIMAL(19,4) | Tỷ lệ chiết khấu |
| ck_nt | DECIMAL(19,4) | Tiền CK NT |
| ck | DECIMAL(19,4) | Tiền CK VND |
| tt_nt | DECIMAL(19,4) | Tổng NT |
| tt | DECIMAL(19,4) | Tổng VND |
| ma_hd | NVARCHAR(20) | Mã hóa đơn |
| ma_bp | NVARCHAR(20) | Mã bộ phận |
| ma_phi | NVARCHAR(20) | Mã phí |
| ma_spct | NVARCHAR(20) | Mã SP chi tiết |
| stt_rec_pn | NVARCHAR(20) | STT_rec phiếu nhập |
| stt_rec0_pn | NVARCHAR(3) | STT_rec0 phiếu nhập |
| stt_rec_dh | NVARCHAR(20) | STT_rec đơn hàng |
| stt_rec0_dh | NVARCHAR(3) | STT_rec0 đơn hàng |
| stt_rec_pdn | NVARCHAR(20) | STT_rec yêu cầu mua |
| stt_rec0_pdn | NVARCHAR(3) | STT_rec0 yêu cầu mua |
| so_pn | NVARCHAR(12) | Số phiếu nhập |
| so_dh | NVARCHAR(12) | Số đơn hàng |
| so_pdn | NVARCHAR(12) | Số yêu cầu mua |
| sl_px | DECIMAL(19,4) | Số lượng đã xuất |
| sl_px_qd | DECIMAL(19,4) | Số lượng đã xuất quy đổi |

### Bảng: PoCp3 (Chi phí) — table name trong DB: `PoCp3`

**PK:** `ma_cty`, `stt_rec`, `stt_rec0`

| Truong | Kieu | Mo ta |
| --------------- | -------- | ---------------------------------------------------------- |
| ma_cty | NVARCHAR(3) | Mã công ty |
| stt_rec | NVARCHAR(20) | Số thứ tự record (FK → PoPh3) |
| stt_rec0 | NVARCHAR(3) | Số thứ tự dòng |
| ma_cp | NVARCHAR(20) | Mã chi phí |
| ten_cp | NVARCHAR(100) | Tên chi phí |
| tt_pb | NVARCHAR(1) | Tiêu chí phân bổ ("1" = Theo số lượng, "2" = Theo giá trị) |
| tien_cp_nt | DECIMAL(19,4) | Tiền CP NT |
| tien_cp | DECIMAL(19,4) | Tiền CP VND |
| ts_gtgt | DECIMAL(19,4) | Thuế suất GTGT |
| thue_gtgt_nt | DECIMAL(19,4) | Thuế GTGT NT |
| thue_gtgt | DECIMAL(19,4) | Thuế GTGT VND |
| tt_nt | DECIMAL(19,4) | Tổng NT |
| tt | DECIMAL(19,4) | Tổng VND |
| ma_bp | NVARCHAR(20) | Mã bộ phận |
| ma_phi | NVARCHAR(20) | Mã phí |
| ma_spct | NVARCHAR(20) | Mã SP chi tiết |
| ma_lo | NVARCHAR(20) | Mã lô |

---

## Stored Procedures (từ simba-docs)

**LƯU Ý QUAN TRỌNG:** PO3 dùng `asPOSavePO3` để lưu (theo POVchPO3.md + PO_SUMMARY.md).
Các SP `asPOInsOrder/UpdOrder/DelOrder` trong SP_INDEX.md là nhóm SP chung cho PO3-7,
**không dùng trực tiếp cho PO3** — bỏ khỏi task này để tránh nhầm lẫn.

| SP Name         | Mo ta                                                   | Source                 |
| --------------- | ------------------------------------------------------- | ---------------------- |
| asPOGetPO3      | Lấy dữ liệu hóa đơn mua                                 | POVchPO3.md            |
| asPOSavePO3     | Lưu hóa đơn mua (header + detail + chi phí + hạch toán) | POVchPO3.md            |
| asPODeletePO3   | Xóa hóa đơn mua                                         | POVchPO3.md            |
| asPOGetDmVt     | Lấy danh mục vật tư                                     | POVchPO3.md            |
| asPOGetDmKho    | Lấy danh mục kho                                        | POVchPO3.md            |
| asPOGetChiPhi   | Lấy chi phí mua hàng                                    | POVchPO3.md            |
| asPOGetHachToan | Lấy hạch toán                                           | POVchPO3.md            |
| asPOGetDMNCC    | Lấy danh mục NCC                                        | SP_INDEX.md            |
| asPOGetDMBP     | Lấy danh mục BP                                         | SP_INDEX.md            |
| asGetSoCt       | Sinh số chứng từ                                        | Framework (dùng chung) |
| asGetSttRec     | Sinh stt_rec                                            | Framework (dùng chung) |
| asChkSoCt       | Kiểm tra trùng số CT                                    | Framework (dùng chung) |

---

## Form classes (từ decompiled DLL)

### 1. frmPOVchPO3 (Form nhập liệu chính)

- **Kế thừa:** frmVoucher
- **Constructors:** `frm()`, `frm(menuid)`, `frm(menuid, stt_rec)`
- **BindingSources:** bsPH (header), bsCT (detail), bsCP (chi phí), bsTain (thuế)

**Header Controls:**

| Control       | Type            | DataBinding | Lookup           | Mo ta               |
| ------------- | --------------- | ----------- | ---------------- | ------------------- |
| txtMa_Kh      | AsTextBox       | Ma_Kh       | MA_NCC (isNcc=1) | Mã NCC              |
| lblTen_Kh     | Label           | Ten_Kh      | —                | Tên NCC (auto-fill) |
| txtDia_chi    | TextBox         | Dia_chi     | —                | Địa chỉ (auto-fill) |
| txtMa_so_thue | TextBox         | Ma_so_thue  | —                | MST (auto-fill)     |
| txtNguoi_Gd   | TextBox         | Nguoi_Gd    | —                | Người giao dịch     |
| txtDien_giai  | TextBox         | Dien_giai   | —                | Diễn giải           |
| txtNgay_lct   | AsMaskedTextBox | Ngay_lct    | —                | Ngày lập CT         |
| cboMa_NT      | AsComboBoxNT    | Ma_NT       | —                | Mã ngoại tệ         |
| txtTy_gia     | AsTextNumeric   | Ty_gia      | —                | Tỷ giá              |
| txtSo_hd      | TextBox         | So_hd       | —                | Số hóa đơn          |
| txtNgay_hd    | AsMaskedTextBox | Ngay_hd     | —                | Ngày hóa đơn        |
| txtMa_Httt    | AsTextBox       | Ma_Httt     | MA_HTTT          | Hình thức TT        |
| txtTk_pt      | AsTextBox       | Tk_pt       | TK               | TK phải trả         |
| txtTk_thue    | AsTextBox       | Tk_thue     | TK               | TK thuế             |

**Tab Chi tiết (Grid vật tư):**

| Column           | DataPropertyName | Lookup | Mo ta                     |
| ---------------- | ---------------- | ------ | ------------------------- |
| dgvcMa_vt        | Ma_vt            | MA_VT  | Mã vật tư                 |
| dgvcTen_vt       | Ten_vt           | —      | Tên vật tư                |
| dgvcDvt          | Dvt              | —      | Đơn vị tính               |
| dgvcMa_kho       | Ma_kho           | MA_KHO | Mã kho                    |
| dgvcTon          | Ton_so_luong     | —      | Tồn kho (readonly)        |
| dgvcSo_luong     | So_luong         | —      | Số lượng                  |
| dgvcGia_nt0      | Gia_nt0          | —      | Đơn giá NT                |
| dgvcTien_nt0     | Tien_nt0         | —      | Thành tiền NT             |
| dgvcTl_ck        | Tl_ck            | —      | Tỷ lệ CK (%)              |
| dgvcCk_nt        | Ck_nt            | —      | Tiền CK NT                |
| dgvcTien_cp_nt   | Tien_cp_nt       | —      | Chi phí NT                |
| dgvcTs_gtgt      | Ts_gtgt          | —      | Thuế suất GTGT            |
| dgvcThue_gtgt_nt | Thue_gtgt_nt     | —      | Thuế GTGT NT              |
| dgvcGia0         | Gia0             | —      | Đơn giá VND (readonly)    |
| dgvcTien0        | Tien0            | —      | Thành tiền VND (readonly) |
| dgvcCk           | Ck               | —      | Tiền CK VND (readonly)    |
| dgvcTien_cp      | Tien_cp          | —      | Chi phí VND (readonly)    |
| dgvcThue_gtgt    | Thue_gtgt        | —      | Thuế GTGT VND (readonly)  |

**Tab Chi phí (Grid chi phí):**

| Column              | DataPropertyName | Lookup    | Mo ta                                             |
| ------------------- | ---------------- | --------- | ------------------------------------------------- |
| dgvcMa_chiphi       | Ma_chiphi        | MA_CHIPHI | Mã chi phí                                        |
| dgvcTen_chi_phi     | Ten_chi_phi      | —         | Tên chi phí                                       |
| dgvcTT_PB           | TT_PB            | —         | Dropdown: "1" = Theo số lượng, "2" = Theo giá trị |
| dgvcTien_cp_nt_cp   | Tien_cp_nt_cp    | —         | Tiền CP NT                                        |
| dgvcTs_gtgt_cp      | Ts_gtgt_cp       | —         | Thuế suất GTGT                                    |
| dgvcThue_gtgt_nt_cp | Thue_gtgt_nt_cp  | —         | Thuế GTGT NT                                      |
| dgvcTt_nt_Cp        | Tt_nt_Cp         | —         | Tổng NT                                           |
| dgvcMa_bp_cp        | Ma_bp_cp         | MA_BP     | Bộ phận                                           |
| dgvcMa_spct_cp      | Ma_spct_cp       | MA_SPCT   | Sản phẩm CT                                       |
| dgvcMa_phi_cp       | Ma_phi_cp        | MA_PHI    | Mã phí                                            |
| dgvcMa_lo_cp        | Ma_lo_cp         | MA_LO     | Mã lô                                             |

**Tab Hạch toán (Grid hạch toán):**

| Column  | DataPropertyName | Lookup | Mo ta       |
| ------- | ---------------- | ------ | ----------- |
| tk_no   | Tk_no            | TK     | TK nợ       |
| tk_co   | Tk_co            | TK     | TK có       |
| ma_vt   | Ma_vt            | —      | Mã vật tư   |
| ten_vt  | Ten_vt           | —      | Tên vật tư  |
| tien    | Tien             | —      | Số tiền VND |
| tien_nt | Tien_nt          | —      | Số tiền NT  |

**Tab Thuế (ctlTaIn):**

- Control `ctlTaIn` — quản lý thuế GTGT đầu vào
- Fields: t_so_luong, t_tien0, t_tien_nt0, t_cp, t_cp_nt, t_thue, t_thue_nt, t_tt, t_tt_nt, tl_ck_hd, t_ck, t_ck_nt

### 2. frmPOVchPO3Find — Tìm kiếm chứng từ

- Kế thừa: frmVoucherFind

### 3. frmPoVchPo3FindPO1 — Tìm đơn đặt hàng (PO1) liên kết

### 4. frmPOVchPO3SeachPO1 — Tìm kiếm nâng cao PO1

---

## Business Logic (từ decompiled source)

### Tính toán tự động

```
Tien_nt0 = So_luong * Gia_nt0  (round)
Tien0    = So_luong * Gia0     (round)
Ck_nt    = Tien_nt0 * Tl_ck / 100
Ck       = Tien0 * Tl_ck / 100
Thue_gtgt_nt = (Tien_nt0 - Ck_nt + Tien_cp_nt) * Ts_gtgt / 100
Thue_gtgt    = (Tien0 - Ck + Tien_cp) * Ts_gtgt / 100
T_tt_nt = Tien_nt0 - Ck_nt + Tien_cp_nt + Thue_gtgt_nt
T_tt    = Tien0 - Ck + Tien_cp + Thue_gtgt
```

### Phân bổ chi phí (Calc_ChiPhiMuaHang) — từ source code gốc

**Cơ chế:** Khi nhấn `cmdPhan_bo`, hệ thống phân bổ chi phí cho từng dòng chi tiết.

**Dropdown `TT_PB` (DataGridViewComboBoxColumn) — 2 lựa chọn:**

| Value | Display       | Cách phân bổ   | Công thức                                                   |
| ----- | ------------- | -------------- | ----------------------------------------------------------- |
| `"1"` | Theo số lượng | Mặc định       | `cp_nt_dòng = cp_nt_chi_phí × (so_luong_dòng / Σ so_luong)` |
| `"2"` | Theo giá trị  | Theo tiền hàng | `cp_nt_dòng = cp_nt_chi_phí × (tien_nt0_dòng / Σ tien_nt0)` |

- Default value: `"1"` (Theo số lượng) — từ `base.CPTable.Columns["TT_PB"].DefaultValue = "1"`
- Column: `dgvcTT_PB` (DataGridViewComboBoxColumn) trong grid chi phí

**Chi tiết thuật toán (từ `Calc_ChiPhiMuaHang`):**

```
num  = Σ tien_nt0  (tổng tiền NT của tất cả detail lines)
num2 = Σ tien0     (tổng tiền VND của tất cả detail lines)
num3 = Σ so_luong  (tổng số lượng của tất cả detail lines)

Với mỗi chi phí có tien_cp_nt > 0 hoặc tien_cp > 0:
  Nếu tt_pb == "2" (Theo giá trị):
    cp_nt_dòng = round(cp_nt_chi_phí × tien_nt0_dòng / num, Round_Nt)
    cp_dòng    = round(cp_nt_dòng × ty_gia, Round)
  Nếu tt_pb == "1" (Theo số lượng):
    cp_nt_dòng = round(cp_nt_chi_phí × so_luong_dòng / num3, Round_Nt)
    cp_dòng    = round(cp_nt_dòng × ty_gia, Round)
  → Gọi Calc_TienVon(item) để tính lại vốn
  → Gọi Calc_ThanhToan(item) để tính lại tổng thanh toán
```

### Auto-fill khi chọn NCC (txtMa_Kh_AfterCodeValidating)

```
txtNguoi_Gd  ← row["nguoi_gd"]
txtDia_chi   ← row["dia_chi"]
txtMa_so_thue← row["ma_so_thue"]
txtMa_Httt   ← row["MA_HTTT_PO"]
```

### Auto-fill TK khi chọn HTTT (txtMa_Httt_AfterCodeValidating)

```
txtTk_pt     ← row["tk"]
tk_thue_gtgt ← row["tk_thue_gtgt_mua"]
tk_thue_nk   ← row["tk_thue_nk"]
tk_thue_ttdb ← row["tk_thue_ttdb"]
ctlTaIn.Tk_Du     ← row["tk"]
ctlTaIn.Tk_Thue   ← row["tk_thue_gtgt_mua"]
```

### Liên kết chứng từ

| Module                | Quan hệ | Mô tả                                       |
| --------------------- | ------- | ------------------------------------------- |
| PO1 (Đơn đặt hàng)    | ← PO3   | Lấy dữ liệu NCC, chi tiết VT từ PO1         |
| AP (Công nợ phải trả) | → AP    | PO3 kích hoạt công nợ cho NCC               |
| CA (Chi tiền)         | ← PO3   | Phiếu chi thanh toán cho PO3 (asPOGetCA4PO) |
| GL (Sổ cái)           | → GL    | Post bút toán từ PO3                        |

### Lookup codes

| Code      | Bảng     | Mô tả                              |
| --------- | -------- | ---------------------------------- |
| MA_NCC    | ARDMKH   | Danh mục nhà cung cấp              |
| MA_VT     | INDMVT   | Danh mục vật tư                    |
| MA_KHO    | INDMKHO  | Danh mục kho                       |
| MA_HTTT   | SIDMHTTT | Hình thức thanh toán (module='PO') |
| MA_BP     | SMInfo   | Danh mục bộ phận                   |
| MA_PHI    | SIDMPHI  | Danh mục phí                       |
| MA_SPCT   | CODMSPCT | Danh mục SP chi tiết               |
| MA_LO     | INDMLO   | Danh mục lô                        |
| TK        | GLDMTK   | Danh mục tài khoản                 |
| MA_NT     | SIDMNT   | Danh mục ngoại tệ                  |
| MA_CHIPHI | PoDmCp   | Danh mục chi phí                   |

---

## Sub-tasks chi tiết

### Phase 0: Cleanup file cũ (BẮT BUỘC làm trước)

### Phase 1: Models + SP Classes (laravel-simba)

- [ ] **1.1** ✅ SModel `PoPh3Model` — **ĐÃ CÓ** tại `src/SModel/PoPh3Model.php`
    - Bảng: `PoPh3`, PK: `ma_cty, stt_rec`
    - **Ghi chú:** SModel đã có, đúng schema Simba ERP.

- [ ] **1.2** ✅ SModel `PoCt3Model` — **ĐÃ CÓ** tại `src/SModel/PoCt3Model.php`
    - Bảng: `PoCt3`, PK: `ma_cty, stt_rec, stt_rec0`
    - **Ghi chú:** SModel đã có, đúng schema Simba ERP.

- [ ] **1.3** ✅ SModel `PoCp3Model` — **ĐÃ CÓ** tại `src/SModel/PoCp3Model.php`
    - Bảng: `PoCp3`, PK: `ma_cty, stt_rec, stt_rec0`
    - **Ghi chú:** SModel đã có, đúng schema Simba ERP.

- [ ] **1.4** ❌ SModel `Po3HTModel` — **KHÔNG CẦN TẠO** — không có bảng Po3HT trong simba-docs. Hạch toán xử lý trong SP `asPOSavePO3`.

- [ ] **1.5** Tạo Model `PoPh3 extends PoPh3Model` — path: `src/Models/PoPh3.php`
    - Scopes: filterByMaCty, filterByMaKh, filterByNgayCt, filterBySoHd, filterBySearch
    - Relations: chiTiets() → hasMany PoCt3, chiPhis() → hasMany PoCp3, nhaCungCap() → belongsTo ArDmKh, hinhThucTt() → belongsTo MmHttt
    - **KHÔNG có** hachToans() — không có bảng Po3HT
    - Method: recalculateTotals() — tính lại t_tien_nt0, t_tien0, t_thue_nt, t_thue, t_cp_nt, t_cp, t_tt_nt, t_tt từ detail/cost rows

- [ ] **1.6** Tạo Model `PoCt3 extends PoCt3Model` — path: `src/Models/PoCt3.php`
    - Relation: poPh3() → belongsTo PoPh3
    - Method: calculateLineTotals() — tính tien_nt0, tien0, ck_nt, ck, thue_gtgt_nt, thue_gtgt

- [ ] **1.7** Tạo Model `PoCp3 extends PoCp3Model` — path: `src/Models/PoCp3.php`
    - Relation: poPh3() → belongsTo PoPh3

- [ ] **1.8** ❌ Model `Po3HT` — **KHÔNG TẠO** — không có bảng Po3HT

- [ ] **1.9** Tạo SP class `AsPOGetPO3` — path: `src/StoredProcedures/AsPOGetPO3.php`
    - ⚠️ SP `asPOGetPO3` có trong DB (từ SP_INDEX.md) nhưng CHƯA CÓ wrapper class
    - Tham số: pStt_rec (NVARCHAR)
    - Trả về: dataset header + detail + chi phí

- [ ] **1.10** Tạo SP class `AsPOSavePO3` — path: `src/StoredProcedures/AsPOSavePO3.php`
    - ⚠️ SP `asPOSavePO3` có trong DB (từ POVchPO3.md) nhưng CHƯA CÓ wrapper class
    - SP DUY NHẤT để lưu PO3 (không dùng asPOInsOrder/UpdOrder)
    - Tham số: toàn bộ field header + detail + chi phí
    - Trả về: stt_rec mới / status

- [ ] **1.11** Tạo SP class `AsPODeletePO3` — path: `src/StoredProcedures/AsPODeletePO3.php`
    - ⚠️ SP `asPODeletePO3` có trong DB nhưng CHƯA CÓ wrapper class
    - Tham số: pStt_rec
    - Trả về: status

- [ ] **1.12** Tạo SP class `AsPOGetDmVt` — lấy danh mục vật tư — **CHƯA CÓ wrapper class**
- [ ] **1.13** Tạo SP class `AsPOGetDmKho` — lấy danh mục kho — **CHƯA CÓ wrapper class**
- [ ] **1.14** Tạo SP class `AsPOGetChiPhi` — lấy chi phí mua hàng — **CHƯA CÓ wrapper class**
- [ ] **1.15** Tạo SP class `AsPOGetHachToan` — lấy hạch toán — **CHƯA CÓ wrapper class**
- [ ] **1.16** Tạo SP class `AsPOGetDMNCC` — lấy danh mục NCC — **CHƯA CÓ wrapper class**
- [ ] **1.17** Tạo SP class `AsPOGetDMBP` — lấy danh mục bộ phận — **CHƯA CÓ wrapper class**

- [ ] **1.18** ⚠️ SP class `AsGetSoCt` — **CÓ THỂ ĐÃ CÓ** từ task CA4, cần kiểm tra
    - SP: `asGetSoCt`
    - Params: `pMa_Cty`, `pMa_ct` ('PO3'), `pNgay_Ct`, `pSo_Ct`
    - Trả về: `SoCt` string (pattern: PO3/YYMM/NNN)

- [ ] **1.19** ⚠️ SP class `AsGetSttRec` — **CÓ THỂ ĐÃ CÓ** từ task CA4, cần kiểm tra
    - SP: `asGetSttRec`
    - Params: `pMa_cty`, `pMa_ct`, `pStt_rec` (output NVARCHAR(20))

- [ ] **1.20** ⚠️ SP class `AsChkSoCt` — **CÓ THỂ ĐÃ CÓ** từ task CA4, cần kiểm tra
    - SP: `asChkSoCt`
    - Params: `pMa_cty`, `pMa_ct`, `pStt_rec`, `pSo_ct`, `pNgay_Ct`, `pRet` (output INT)

- [ ] **1.21** ⚠️ SP class `AsPOChkRightStatusPO3` — **ĐÃ CÓ** tại `src/StoredProcedures/AsPOChkRightStatusPO3.php`
    - Params: `pMa_cty`, `pStt_rec`, `pLanguage`

- [ ] **1.22** ⚠️ SP class `AsReCalPO3` — **ĐÃ CÓ** tại `src/StoredProcedures/AsReCalPO3.php`
    - Params: `pMa_cty`, `pStt_rec_hd`

- [ ] **1.23** ⚠️ SP class `AsReCalPO34Relate` — **ĐÃ CÓ** tại `src/StoredProcedures/AsReCalPO34Relate.php`
    - Params: `pMa_cty`, `pStt_rec`

- [ ] **1.24** ⚠️ SP class `AsAPUpdTt_SoDuPo3` — **ĐÃ CÓ** tại `src/StoredProcedures/AsAPUpdTt_SoDuPo3.php`
    - Params: `pMa_cty`, `pStt_rec_hd`

### Phase 2: Livewire Components (laravel-catalog)

- [ ] **2.1** ⚠️ Livewire `Muahang/Hoadonmua` — **ĐÃ CÓ** tại `src/Http/Livewire/Muahang/Hoadonmua.php`
    - ⚠️ Cần refactor sang dùng `PoPh3` model (thay vì model cũ)
    - Bảng danh sách với filter: ma_cty, ma_kh, ngay_ct (from-to), so_hd, search
    - Columns: so_hd, ngay_hd, ma_kh/ten_kh, so_ct, t_tt_nt, t_tt, trang_thai
    - Pagination
    - Actions: Xem, Sửa

- [ ] **2.2** ⚠️ Livewire `Muahang/HoadonmuaEdit` — **ĐÃ CÓ** tại `src/Http/Livewire/Muahang/HoadonmuaEdit.php`
    - ⚠️ Cần refactor sang dùng `PoPh3` model (thay vì model cũ)
    - ⚠️ Method `submit()` còn TODO — chưa gọi SP để lưu
    - Header: fields (ma_kh lookup, ten_kh auto-fill, so_hd, ngay_hd, ma_httt lookup, ty_gia, ma_nt, dien_giai, tk_pt, tk_thue, ...)
    - Tab Chi tiết: Grid editable — chi tiết vật tư
    - Tab Chi phí: Grid editable — chi phí mua hàng
    - Tab Hạch toán: **KHÔNG CÓ** trong UI hiện tại (pActiveTab max = 2)
- [ ] **2.3** ⚠️ Livewire `Muahang/HoadonmuaFind` — Tìm kiếm chứng từ — **CHƯA CÓ**
- [ ] **2.4** ⚠️ Livewire `Muahang/ChonPO1` — Chọn đơn đặt hàng (PO1) liên kết — **CHƯA CÓ**

### Phase 3: Views (laravel-catalog)

- [ ] **3.1** ⚠️ View `muahang/hoadonmua.blade.php` — **ĐÃ CÓ** tại `resources/views/muahang/hoadonmua.blade.php`
    - Filter bar (search, ngay_ct from-to)
    - Bảng dữ liệu với pagination
    - Action buttons (Sửa)

- [ ] **3.2** ⚠️ View `muahang/hoadonmua-edit.blade.php` — **ĐÃ CÓ** tại `resources/views/muahang/hoadonmua-edit.blade.php`
    - Header section
    - Tab navigation: Chi tiết | Chi phí | Hạch toán
    - Grid chi tiết, chi phí (editable rows)
    - Footer totals
    - Action buttons (Lưu, Hủy)

- [ ] **3.3** Partial `_grid-chitiet.blade.php` — Grid chi tiết vật tư — **CHƯA CÓ**
- [ ] **3.4** Partial `_grid-chiphi.blade.php` — Grid chi phí — **CHƯA CÓ**
- [ ] **3.5** Partial `_grid-hachtoan.blade.php` — Grid hạch toán — **CHƯA CÓ**
- [ ] **3.6** Partial `_tax-control.blade.php` — Thuế đầu vào — **CHƯA CÓ**
- [ ] **3.7** Partial `_footer-totals.blade.php` — Tổng cộng footer — **CHƯA CÓ**
- [ ] **3.8** Partial `_lookup-ncc.blade.php` — Lookup nhà cung cấp — **CHƯA CÓ**

### Phase 4: Routes + Menu

- [ ] **4.1** ⚠️ Route danh sách — `GET /muahang/hoadonmua` → `muahang.hoadonmua` — **ĐÃ CÓ** trong `routes/web.php`
- [ ] **4.2** ⚠️ Route create — `GET /muahang/hoadonmua/create` → `muahang.hoadonmua.create` — **ĐÃ CÓ**
- [ ] **4.3** ⚠️ Route edit — `GET /muahang/hoadonmua/edit/{stt_rec}` → `muahang.hoadonmua.edit` — **ĐÃ CÓ**
- [ ] **4.4** Route find — `GET /muahang/hoadonmua/tim-kiem` — **CHƯA CÓ**
- [ ] **4.5** Route chọn PO1 — `GET /muahang/hoadonmua/chon-po1` — **CHƯA CÓ**
- [ ] **4.6** Thêm menu item vào module Mua hàng — **CHƯA CÓ**
- [ ] **4.7** ⚠️ API routes `/api/po/*` — **KHÔNG TỒN TẠI** — không có `routes/api.php` cho PO. Không cần thiết nếu dùng Livewire.

### Phase 5: Validation & Business Logic

- [ ] **5.1** Validate required fields: ma_kh, so_hd, ngay_hd
- [ ] **5.2** Auto-calc tiền hàng: tien_nt0 = so_luong × gia_nt0, tien0 = so_luong × gia0
- [ ] **5.3** Auto-calc chiết khấu: ck_nt = tien_nt0 × tl_ck / 100
- [ ] **5.4** Auto-calc thuế GTGT: thue_gtgt_nt = (tien_nt0 - ck_nt + tien_cp_nt) × ts_gtgt / 100
- [ ] **5.5** Auto-calc VND từ NT khi thay đổi tỷ giá: tien0 = tien_nt0 × ty_gia
- [ ] **5.6** Auto-fill NCC info khi chọn ma_kh (ten_kh, dia_chi, ma_so_thue, MA_HTTT_PO)
- [ ] **5.7** Auto-fill TK khi chọn HTTT (tk_pt, tk_thue_gtgt_mua, tk_thue_nk, tk_thue_ttdb)
- [ ] **5.8** Phân bổ chi phí theo dropdown TT_PB: "1" = theo số lượng, "2" = theo tiền hàng
- [ ] **5.9** Gọi `AsGetSoCt::call(['pMa_ct' => 'PO3', 'pNgay_Ct' => $ngayCt])` khi tạo mới → gán `so_ct`
- [ ] **5.10** Gọi `AsChkSoCt::call(['pMa_ct' => 'PO3', 'pStt_rec' => $sttRec, 'pSo_ct' => $soCt, 'pNgay_Ct' => $ngayCt])` trước khi save → báo lỗi nếu `pRet > 0`
- [ ] **5.11** Gọi `AsGetSttRec::call(['pMa_ct' => 'PO3'])` khi tạo mới → lấy `pStt_rec` output
- [ ] **5.12** recalculateTotals() — tính lại toàn bộ tổng khi lưu
- [ ] **5.13** Sync thuế giữa detail grid và ctlTaIn

### Phase 6: Lookup Integration

- [ ] **6.1** Lookup NCC (ARDMKH) — chọn, auto-fill
- [ ] **6.2** Lookup VT (INDMVT) — trong grid chi tiết
- [ ] **6.3** Lookup Kho (INDMKHO) — trong grid chi tiết
- [ ] **6.4** Lookup HTTT (SIDMHTTT, module='PO')
- [ ] **6.5** Lookup TK (GLDMTK) — cho tk_pt, tk_thue, tk_no, tk_co
- [ ] **6.6** Lookup NT (SIDMNT) — mã ngoại tệ
- [ ] **6.7** Lookup BP (SMInfo) — bộ phận
- [ ] **6.8** Lookup Phí (SIDMPHI)
- [ ] **6.9** Lookup SPCT (CODMSPCT)
- [ ] **6.10** Lookup Lô (INDMLO)
- [ ] **6.11** Lookup Chi phí (PoDmCp)

### Phase 7: Integration với module khác

- [ ] **7.1** Integration PO1: Lấy dữ liệu từ đơn đặt hàng (NCC, chi tiết VT, số lượng đặt)
- [ ] **7.2** Integration AP: PO3 tạo công nợ phải trả cho NCC sau khi lưu
- [ ] **7.3** Integration CA: Phiếu chi thanh toán cho PO3 (SP: asPOGetCA4PO)
- [ ] **7.4** Integration GL: Post bút toán kế toán từ PO3 (xử lý trong SP `asPOSavePO3`)

### Phase 8: Testing

- [ ] **8.1** Test load danh sách + filter
- [ ] **8.2** Test tạo mới hóa đơn (header + detail + chi phí + hạch toán)
- [ ] **8.3** Test chỉnh sửa hóa đơn
- [ ] **8.4** Test xóa hóa đơn
- [ ] **8.5** Test tính toán tự động (tiền, thuế, CK, tổng)
- [ ] **8.6** Test phân bổ chi phí — theo số lượng (tt_pb="1")
- [ ] **8.6b** Test phân bổ chi phí — theo giá trị (tt_pb="2")
- [ ] **8.7** Test lookup NCC (auto-fill)
- [ ] **8.8** Test lookup HTTT (auto-fill TK)
- [ ] **8.9** Test lookup VT trong grid
- [ ] **8.10** Test multi-currency (NT ↔ VND qua tỷ giá)
- [ ] **8.11** Test save qua SP AsPOSavePO3
- [ ] **8.12** Test tax sync (detail ↔ ctlTaIn)
- [ ] **8.13** Test chọn từ PO1
- [ ] **8.14** Test hạch toán (xử lý qua SP, không có grid riêng)
- [ ] **8.15** Test numbering: `AsGetSoCt` sinh đúng pattern PO3/YYMM/NNN
- [ ] **8.16** Test numbering: `AsChkSoCt` chặn trùng `so_ct` khi tạo nhiều PO3 cùng ngày
- [ ] **8.17** Test numbering: `AsGetSttRec` sinh `stt_rec` mới khi tạo PO3

---

## Mapping PHP (UPDATED — đối chiếu code thực tế 2026-05-14)

### Models (laravel-simba) — Thực tế

```
src/SModel/
├── PoPh3Model.php          ✅ ĐÃ CÓ — table: PoPh3
├── PoCt3Model.php          ✅ ĐÃ CÓ — table: PoCt3
└── PoCp3Model.php          ✅ ĐÃ CÓ — table: PoCp3

src/Models/
├── ❌ PoPh3.php             CHƯA CÓ — cần tạo (extends PoPh3Model)
├── ❌ PoCt3.php             CHƯA CÓ — cần tạo (extends PoCt3Model)
└── ❌ PoCp3.php             CHƯA CÓ — cần tạo (extends PoCp3Model)
```

### Stored Procedures (laravel-simba) — Thực tế

```
src/StoredProcedures/
├── ❌ AsPOGetPO3.php        CHƯA CÓ — cần tạo
├── ❌ AsPOSavePO3.php       CHƯA CÓ — cần tạo (SP DUY NHẤT để lưu)
├── ❌ AsPODeletePO3.php     CHƯA CÓ — cần tạo
├── ❌ AsPOGetDmVt.php       CHƯA CÓ — cần tạo
├── ❌ AsPOGetDmKho.php      CHƯA CÓ — cần tạo
├── ❌ AsPOGetChiPhi.php     CHƯA CÓ — cần tạo
├── ❌ AsPOGetHachToan.php   CHƯA CÓ — cần tạo
├── ❌ AsPOGetDMNCC.php      CHƯA CÓ — cần tạo
├── ❌ AsPOGetDMBP.php       CHƯA CÓ — cần tạo
├── ✅ AsPOChkRightStatusPO3.php ĐÃ CÓ
├── ✅ AsReCalPO3.php        ĐÃ CÓ
├── ✅ AsReCalPO34Relate.php ĐÃ CÓ
├── ✅ AsAPUpdTt_SoDuPo3.php ĐÃ CÓ
├── ⚠️ AsGetSoCt.php         CẦN KIỂM TRA (đã có từ CA4?)
├── ⚠️ AsGetSttRec.php       CẦN KIỂM TRA (đã có từ CA4?)
└── ⚠️ AsChkSoCt.php         CẦN KIỂM TRA (đã có từ CA4?)
```

### Livewire + Views (laravel-catalog) — Thực tế

```
src/Http/Livewire/Muahang/
├── ✅ Hoadonmua.php         ĐÃ CÓ — cần refactor sang PoPh3
├── ✅ HoadonmuaEdit.php     ĐÃ CÓ — cần refactor sang PoPh3, submit() còn TODO
├── ❌ HoadonmuaFind.php     CHƯA CÓ
└── ❌ ChonPO1.php           CHƯA CÓ

resources/views/muahang/
├── ✅ hoadonmua.blade.php   ĐÃ CÓ
├── ✅ hoadonmua-edit.blade.php ĐÃ CÓ
└── partials/
    ├── ❌ _grid-chitiet.blade.php     CHƯA CÓ
    ├── ❌ _grid-chiphi.blade.php      CHƯA CÓ
    ├── ❌ _grid-hachtoan.blade.php    CHƯA CÓ
    ├── ❌ _tax-control.blade.php      CHƯA CÓ
    ├── ❌ _footer-totals.blade.php    CHƯA CÓ
    └── ❌ _lookup-ncc.blade.php       CHƯA CÓ

src/Services/MuaHang/
└── ❌ (thư mục rỗng)

src/Http/Controllers/
└── ❌ PoAjaxController.php KHÔNG TỒN TẠI
```

---

## Dependencies (UPDATED — audit 2026-05-14)

| Loai      | Package         | File                  | Status   | Ghi chu                                      |
| --------- | --------------- | --------------------- | -------- | -------------------------------------------- |
| SModel    | laravel-simba   | PoPh3Model.php        | ĐÃ CÓ    | Header — table PoPh3                          |
| SModel    | laravel-simba   | PoCt3Model.php        | ĐÃ CÓ    | Chi tiết VT — table PoCt3                     |
| SModel    | laravel-simba   | PoCp3Model.php        | ĐÃ CÓ    | Chi phí — table PoCp3                         |
| Model     | laravel-simba   | PoPh3.php             | CHƯA CÓ  | Header model (extends PoPh3Model)             |
| Model     | laravel-simba   | PoCt3.php             | CHƯA CÓ  | Detail model (extends PoCt3Model)             |
| Model     | laravel-simba   | PoCp3.php             | CHƯA CÓ  | Cost model (extends PoCp3Model)               |
| Model     | laravel-simba   | ArDmKh.php            | ĐÃ CÓ    | Lookup NCC                                    |
| Model     | laravel-simba   | InDmVt.php            | ĐÃ CÓ    | Lookup VT                                     |
| Model     | laravel-simba   | InDmKho.php           | ĐÃ CÓ    | Lookup Kho                                    |
| Model     | laravel-simba   | GlDmTk.php            | ĐÃ CÓ    | Lookup TK                                     |
| SP        | laravel-simba   | AsPOGetPO3.php        | CHƯA CÓ  | Lấy dữ liệu PO3                                |
| SP        | laravel-simba   | AsPOSavePO3.php       | CHƯA CÓ  | Lưu PO3 (SP DUY NHẤT)                         |
| SP        | laravel-simba   | AsPODeletePO3.php     | CHƯA CÓ  | Xóa PO3                                       |
| SP        | laravel-simba   | AsPOChkRightStatusPO3.php | ĐÃ CÓ | Check quyền/trạng thái                       |
| SP        | laravel-simba   | AsReCalPO3.php        | ĐÃ CÓ    | Recalculate PO3                               |
| SP        | laravel-simba   | AsReCalPO34Relate.php | ĐÃ CÓ    | Recalculate related objects                   |
| SP        | laravel-simba   | AsAPUpdTt_SoDuPo3.php | ĐÃ CÓ    | Update AP balance for PO3                     |
| SP        | laravel-simba   | AsGetSoCt.php         | CẦN KT   | Sinh so_ct (dùng chung)                       |
| SP        | laravel-simba   | AsGetSttRec.php       | CẦN KT   | Sinh stt_rec (dùng chung)                     |
| SP        | laravel-simba   | AsChkSoCt.php         | CẦN KT   | Check trùng so_ct (dùng chung)                |
| Component | laravel-catalog | Hoadonmua.php         | ĐÃ CÓ    | List — cần refactor sang PoPh3                |
| Component | laravel-catalog | HoadonmuaEdit.php     | ĐÃ CÓ    | Edit form — cần refactor sang PoPh3, submit() TODO   |

---

## Out of Scope (xử lý sau)

Các hạng mục sau **không nằm trong phạm vi task 069**, sẽ xử lý ở task riêng:

| Hạng mục            | Mô tả                                         | Lý do defer                                                      |
| ------------------- | --------------------------------------------- | ---------------------------------------------------------------- |
| **Print/In ấn**     | Xuất PDF hóa đơn mua hàng                     | Cần template riêng, dùng chung hệ thống print                    |
| **Authorization**   | Phân quyền xem/sửa/xóa PO3                    | Framework phân quyền chung cho toàn bộ voucher                   |
| **Status/Workflow** | Trạng thái chứng từ (Draft, Approved, Posted) | Cần spec workflow từ Simba gốc, áp dụng chung cho tất cả voucher |

---

## Audit Status

- **Ngày audit 1:** 2026-05-13
- **Kết quả 1:** UPDATED — spec từ simba-docs, sub-tasks chi tiết 8 phases
- **Ngày audit 2:** 2026-05-14
- **Kết quả 2:** RE-AUDIT — đối chiếu PO3.md với code thực tế
  - Bảng CSDL: Sửa từ `PO3/PO3CT/PO3CP/PO3HT` → `PoPh3/PoCt3/PoCp3` (Simba ERP) + ghi chú bộ `POHMN/POHMNCT/POHMNCP` (Livewire hiện tại)
  - Models/PO/: Xóa — folder không tồn tại
  - Livewire names: `Hoadonmuahang` → `Hoadonmua` (đúng với code)
  - View names: `hoadonmuahang.blade.php` → `hoadonmua.blade.php`
  - Routes: `/muahang/hoadon-mua-hang` → `/muahang/hoadonmua`
  - SP Classes: Đánh dấu ĐÃ CÓ/CHƯA CÓ đúng với thực tế
  - Bổ sung 4 SP classes đã có: AsPOChkRightStatusPO3, AsReCalPO3, AsReCalPO34Relate, AsAPUpdTt_SoDuPo3
  - Mapping PHP: Update toàn bộ tree structure
  - Dependencies: Update với status ĐÃ CÓ/CHƯA CÓ
- **Kết quả 3:** 2026-05-14 07:44 — Sếp chỉ đạo: Dùng schema Simba ERP .NET, xóa toàn bộ phần POHMN đoán bừa.
  - Audit Results: Rewrite — nguồn duy nhất là SimbaSql `.sql` files
  - Cấu trúc dữ liệu: Thay thế cột bằng danh sách thực tế từ `PoPh3.sql`, `PoCt3.sql`, `PoCp3.sql`
  - Xóa toàn bộ reference đến POHMN/Pohnm trong sub-tasks, mapping, dependencies
  - Sub-tasks 1.1-1.3: Xác nhận SModel đã có, đúng schema
  - Sub-tasks 2.1-2.2: Thay "dùng Pohnm" → "cần refactor sang dùng PoPh3"
  - Sub-task 1.5: Xóa note về Pohnm
  - Audit Status: Bổ sung dòng chỉ đạo của Sếp
- **Ghi chú:** SP là interface duy nhất — PHP không query trực tiếp vào bảng, không tính toán nghiệp vụ. Tất cả logic qua SP.
- ~~**Quyết định cần Sếp:** Dùng bộ bảng `PoPh3/PoCt3/PoCp3` (Simba ERP legacy, đã có SModel) HOẶC tiếp tục bộ `POHMN/POHMNCT/POHMNCP` (Livewire hiện tại đang dùng)?~~ → **ĐÃ QUYẾT ĐỊNH:** Dùng `PoPh3/PoCt3/PoCp3`.

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `muahang.hoadonmua`
- **Note:** Shell/voucher route đã có; không execute write ngoài payload đã audit.
