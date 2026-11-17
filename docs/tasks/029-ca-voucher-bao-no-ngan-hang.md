# Task 029: CA - Voucher bao no ngan hang

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CAVchCA3.dll |
| **Module** | CA (Cash & Banking) |
| **Loai** | Voucher |
| **Trang thai** | Da phan tich |
| **Ma CT** | CA3 |

## Mo ta chuc nang

Nhap chung tu bao no ngan hang (Uy nhiem chi).

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCaVchCA3 | frmVoucher | Form nhap lieu chinh |
| frmCaVchCA3Find | - | Form tim kiem |

## Controls - Header

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | Ma_Kh | Ma khach hang |
| txtTk_No | AsTextBox | tk_no | TK no (NH) |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| txtT_Tien | AsTextNumeric | t_tien | Tong tien |

## CSDL

| Bang | Mo ta |
|------|-------|
| CA3PH | Bao no NH header |
| CA3CT | Bao no NH chi tiet |

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| CA3PH | Báo nợ NH header | Header |
| CA3CT | Báo nợ NH chi tiết | Detail |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `CA3PH_Get` | Lấy danh sách báo nợ |
| `CA3PH_Insert` | Thêm báo nợ header |
| `CA3PH_Update` | Cập nhật báo nợ header |
| `CA3PH_Delete` | Xóa báo nợ header |
| `CA3CT_Insert` | Thêm dòng chi tiết |
| `CA3CT_Delete` | Xóa dòng chi tiết |

## Business Logic

1. **Báo nợ NH**: Nhận thông báo nợ từ ngân hàng (ứng với CA1 - thu tiền)
2. **Tỷ giá**: Tự động load theo mã ngoại tệ
3. **Đối tượng**: TK Nợ = TK ngân hàng nhận

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CA/Vouchers/BaonoNganhang.php
namespace Diepxuan\Catalog\Http\Livewire\CA\Vouchers;

class BaonoNganhang extends Component
{
    const MA_CT = 'CA3';

    public function render(): View
    {
        return view('catalog::ca.vouchers.bao-no-ngan-hang');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | CA | Module tiền mặt/ngân hàng |
| diepxuan/system | Commons | AutoCode, FormatDate |
| diepxuan/system | Lookup | Tra cứu TK |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model CA3PH, CA3CT
- [ ] Tao Livewire BaonoNganhang
- [ ] Tao View
- [ ] Test CRUD
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
\n## Portal implementation status\n\n- **Status:** DONE (route/component exists)\n- **Source:** SimbaRouteRegistry voucher mapping CA1/CA2/CA4 and existing Cash Livewire screens.\n

---

## Technical Specification (CA4)

> Nội dung gộp từ `CA4-PHIEU-BAONO-SPEC.md` (đã xoá file riêng, tránh trùng ID/tài liệu rời).

**Last updated:** 2026-03-30  
**Issue:** [SimbaSql #58](https://github.com/diepxuan/SimbaSql/issues/58)  
**Module:** Cash > Ngân hàng  
**Mã chứng từ:** CA4  

---

### 1. Tổng quan

Chức năng quản lý Phiếu báo nợ ngân hàng (Ủy nhiệm chi) - chuyển đổi từ ASIA app (frmCaVchCA3).

### Business Logic

| Yếu tố | Giá trị |
|--------|---------|
| **TK Nợ** | Các TK công nợ, chi phí (từ chi tiết) |
| **TK Có** | TK ngân hàng 112xxx (từ header, mặc định 11217) |
| **Công thức** | Tổng PS Nợ = Tổng PS Có |
| **Ngoại tệ** | Tiền VND = Tiền NT × Tỷ giá |
| **VAT** | Không có (kht_tain = 0) |

---

### 2. Database Schema

### CaPh2 (Master) - Dùng chung cho CA2 và CA4

| Field | Type | Mô tả |
|-------|------|-------|
| ma_cty | NVARCHAR(10) | Mã công ty |
| stt_rec | NVARCHAR(20) | **PK** - Số thứ tự record |
| ma_ct | NVARCHAR(3) | Mã chứng từ (CA4) |
| so_ct | NVARCHAR(12) | Số chứng từ |
| ngay_ct | SMALLDATETIME | Ngày chứng từ |
| ngay_lct | SMALLDATETIME | Ngày lập CT |
| kht_tain | BIT | Có thuế đầu vào (0 = không) |
| ma_kh | NVARCHAR(20) | Mã khách hàng |
| dia_chi | NVARCHAR(255) | Địa chỉ |
| nguoi_gd | NVARCHAR(30) | Người giao dịch |
| dien_giai | NVARCHAR(255) | Diễn giải |
| tk_co | NVARCHAR(20) | **TK Có** (ngân hàng 112xxx) |
| ma_nt | NVARCHAR(3) | Mã ngoại tệ |
| ty_gia | DECIMAL(19,4) | Tỷ giá |
| t_tien_nt | DECIMAL(19,4) | Tổng tiền NT |
| t_tien | DECIMAL(19,4) | Tổng tiền VND |
| t_thue | DECIMAL(19,4) | Tổng thuế |
| t_tt | DECIMAL(19,4) | Tổng thanh toán |
| t_thue_nt | DECIMAL(19,4) | Tổng thuế NT |
| t_tt_nt | DECIMAL(19,4) | Tổng TT NT |
| trang_thai | NVARCHAR(1) | Trạng thái |
| post2gl | NVARCHAR(1) | Đã post sang GL |
| cdate | DATETIME | Ngày tạo |
| cuser | NVARCHAR(30) | Người tạo |
| ldate | DATETIME | Ngày sửa |
| luser | NVARCHAR(30) | Người sửa |

### CaCt2 (Detail) - Dùng chung cho CA2 và CA4

| Field | Type | Mô tả |
|-------|------|-------|
| ma_cty | NVARCHAR(10) | Mã công ty |
| stt_rec | NVARCHAR(20) | **FK** - Ref to CaPh2 |
| stt_rec0 | NVARCHAR(3) | Số dòng (001, 002, ...) |
| stt_rec_pc | NVARCHAR(20) | Ref phiếu chi (nếu link) |
| stt_rec0_pc | NVARCHAR(3) | Số dòng phiếu chi |
| so_pc | NVARCHAR(12) | Số phiếu chi |
| tk | NVARCHAR(20) | **TK Nợ** (đối ứng) |
| ps_no | DECIMAL(19,4) | Phát sinh nợ VND |
| ps_co | DECIMAL(19,4) | Phát sinh có VND |
| ps_no_nt | DECIMAL(19,4) | Phát sinh nợ NT |
| ps_co_nt | DECIMAL(19,4) | Phát sinh có NT |
| dien_giai | NVARCHAR(255) | Diễn giải chi tiết |
| ma_kh | NVARCHAR(20) | Mã khách hàng |
| ma_hd | NVARCHAR(20) | Mã hợp đồng |
| ma_bp | NVARCHAR(20) | Mã bộ phận |
| ma_phi | NVARCHAR(20) | Mã phí |
| ma_spct | NVARCHAR(20) | Mã SP chi tiết |
| ma_lo | NVARCHAR(20) | Mã lô |
| ma_ku | NVARCHAR(20) | Mã khế ước |

---

### 3. Stored Procedures

### Core SPs

| SP Name | Mục đích | Parameters |
|---------|----------|------------|
| `asGetSoCt` | Lấy số CT tự động | pMa_Cty, pMa_Ct, pNgay_Ct |
| `asGetSttRec` | Lấy stt_rec mới | pMa_Cty, pMa_Ct |
| `asChkSoCt` | Check số CT trùng | pMa_Cty, pMa_Ct, pStt_Rec, pSo_ct, pNgay_ct |
| `asCAInsPH2` | Insert header | pMa_cty, pStt_rec, pMa_ct, pSo_ct, ... |
| `asCAUpdPH2` | Update header | pMa_cty, pStt_rec, pMa_ct, pSo_ct, ... |
| `asCAInsCT2` | Insert detail | pMa_cty, pStt_rec, pStt_rec0, pTk, pPs_no, ... |
| `asCADelCT2` | Delete detail | pMa_cty, pStt_rec |
| `asCADelPH2` | Delete header | pMa_cty, pStt_rec |
| `asProcessCt` | Process chứng từ | pMa_cty, pMa_Ct, pStt_rec, pMode |
| `asPostCaPh2_glct` | Post sang GL | pMa_cty, pStt_rec |
| `asGetSoDuKh` | Lấy số dư KH | pMa_Cty, pMa_kh, pTk, pNgay |
| `asValid` | Validate danh mục | pMa_Cty, pCodeName, pCodeValue, ... |

### Mode values for asProcessCt

| Mode | Ý nghĩa |
|------|---------|
| `1` | Tạo mới / Xác nhận sửa |
| `2` | Sửa / Xóa (unlock) |

---

### 4. Implementation Files

### Laravel Catalog (Frontend)

```
diepxuan/laravel-catalog/
├── src/Http/Livewire/Cash/Nganhang/
│   ├── Baono.php                    # List component
│   └── Baono/
│       └── Phieubaono.php           # Form CRUD component
├── src/Models/
│   ├── CaPh2.php                    # Model extends SModel (dùng chung CA2/CA4)
│   └── CaCt2.php                    # Model extends SModel (dùng chung CA2/CA4)
├── resources/views/cash/nganhang/
│   ├── baono.blade.php              # Main view (list + form)
│   └── baono/phieubaono.blade.php   # Form component view
└── routes/web.php
    └── Route::get('/cash/nganhang/baono', Baono::class)
```

### Laravel Simba (Backend)

```
diepxuan/laravel-simba/
├── src/SModel/
│   ├── CaPh2Model.php              # ✅ Đã có (dùng chung CA2/CA4)
│   └── CaCt2Model.php              # ✅ Đã có (dùng chung CA2/CA4)
├── src/StoredProcedures/
│   ├── AsProcessCaPh2.php          # ✅ Đã có
│   ├── AsPostCaPh2_glct.php        # ✅ Đã có
│   ├── AsCAInsPH2.php              # ✅ Đã có
│   ├── AsCAUpdPH2.php              # ✅ Đã có
│   ├── AsCAInsCT2.php              # ✅ Đã có
│   ├── AsCADelCT2.php              # ✅ Đã có
│   ├── AsCADelPH2.php              # ✅ Đã có
│   ├── AsGetSoCt.php               # ✅ Đã có
│   ├── AsGetSttRec.php             # ✅ Đã có
│   ├── AsChkSoCt.php               # ✅ Đã có
│   └── AsGetSoDuKh.php             # ✅ Đã có
└── database/migrations/
    └── (Tables CaPh2/CaCt2 đã tồn tại từ CA2)
```

---

### 5. Constants & Defaults

```php
// Phieubaono.php
const MA_CT          = 'CA4';           // Mã chứng từ
const DEFAULT_TK_CO  = 11_217;          // TK ngân hàng mặc định
const DEFAULT_MA_NT  = 'VND';           // Ngoại tệ mặc định
const DEFAULT_TY_GIA = 1;               // Tỷ giá mặc định
```

---

### 6. Validation Rules

```php
protected $rules = [
    'pMa_Kh'          => 'required',
    'pTk_Co'          => 'required',
    'pNgay_Ct'        => 'required|date',
    'pNgay_Lap'       => 'required|date',
    'pDia_Chi'        => 'nullable|string|max:255',
    'pNguoi_Gd'       => 'nullable|string|max:30',
    'pMa_Nt'          => 'required|string|size:3',
    'pTy_Gia'         => 'required|numeric|min:0',
    'pCts.*.ma_tk'    => 'required',
    'pCts.*.ps_no'    => 'required|numeric|min:0',
    'pCts.*.ps_co'    => 'nullable|numeric|min:0',
    'pCts.*.ps_no_nt' => 'nullable|numeric|min:0',
    'pCts.*.ps_co_nt' => 'nullable|numeric|min:0',
    'pCts.*.ma_kh'    => 'nullable|string|max:20',
    'pCts.*.ma_hd'    => 'nullable|string|max:20',
    'pCts.*.ma_bp'    => 'nullable|string|max:20',
    'pCts.*.ma_phi'   => 'nullable|string|max:20',
    'pCts.*.ma_spct'  => 'nullable|string|max:20',
    'pCts.*.ma_lo'    => 'nullable|string|max:20',
    'pCts.*.ma_ku'    => 'nullable|string|max:20',
];
```

---

### 7. Feature Checklist

### Đã hoàn thành

- [x] Xem danh sách phiếu (list với filter)
- [x] Tạo mới phiếu
- [x] Sửa phiếu
- [x] Xóa phiếu (⚠️ cần AsCADelPH2)
- [x] Validation dữ liệu
- [x] Tính toán tự động (tỷ giá, tổng tiền)
- [x] Lấy số dư khách hàng
- [x] Post sang GL

### Chưa hoàn thành

- [ ] In phiếu
- [ ] AsCADelPH2 stored procedure
- [ ] Link với phiếu chi (stt_rec_pc, so_pc)
- [ ] Migration files (cần kiểm tra)

---

### 8. Hướng dẫn cho AI Agent

### Khi đọc task này, cần lưu ý:

1. **Mã chứng từ là CA4** (không phải CA3)
2. **TK mặc định là 11217** (ngân hàng)
3. **Hướng ghi:** Nợ (chi tiết) / Có (header - TK 112)
4. **Không có VAT** (kht_tain = 0 mặc định)
5. **Follow pattern** của Phieubaono.php hiện có
6. **Re-use components:** 
   - `input-khachhang` (mode="khachhang,nhacungcap")
   - `input-taikhoan`
   - `input-date`

### Code pattern tham khảo

```php
// 1. Get số chứng từ
$this->pSo_Ct = AsGetSoCt::call([
    'pMa_ct'   => self::MA_CT,
    'pNgay_Ct' => $this->pNgay_Ct,
]);

// 2. Get stt_rec
$stt_rec = AsGetSttRec::call([
    'pMa_cty' => $maCty,
    'pMa_Ct'  => self::MA_CT,
])->first()->pStt_rec ?? '';

// 3. Check số CT trùng
$checkSoCt = AsChkSoCt::call([
    'pMa_Cty'  => $maCty,
    'pMa_Ct'   => self::MA_CT,
    'pStt_Rec' => $isEditMode ? $this->pStt_Rec : '0',
    'pSo_ct'   => $this->pSo_Ct,
    'pNgay_ct' => $this->pNgay_Ct,
]);

// 4. Insert Header
AsCAInsPH2::call([...params...]);

// 5. Insert Details
foreach ($this->pCts as $index => $row) {
    AsCAInsCT2::call([...params...]);
}

// 6. Process chứng từ
AsProcessCt::call([
    'pMa_cty'  => $maCty,
    'pMa_Ct'   => self::MA_CT,
    'pStt_rec' => $stt_rec,
    'pMode'    => '1',
]);

// 7. Post to GL
AsPostCaPh2_glct::call([
    'pMa_cty'  => $maCty,
    'pStt_rec' => $stt_rec,
]);
```

---

### 9. Related Issues

| Issue | Repo | Title |
|-------|------|-------|
| #18 | SimbaSql | [CA] Phiếu chi - frmCaVchCA2 |
| #24 | portal | Cash \| Phieu chi \| Them, sua, xoa |
| #58 | SimbaSql | [CA] Phiếu báo nợ ngân hàng (UNC) |

---

### 10. References

- **Source code:** `diepxuan/laravel-catalog/src/Http/Livewire/Cash/Nganhang/Baono/`
- **Project Board:** https://github.com/orgs/diepxuan/projects/2
- **Issue:** https://github.com/diepxuan/SimbaSql/issues/58

---

*Document created by Bột - Portal Project Assistant*

---
### Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

### Portal implementation status

- **Status:** NOT A TASK (meta/doc file, skipped)
