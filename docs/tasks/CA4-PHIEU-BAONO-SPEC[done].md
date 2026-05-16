# Phiếu Báo Nợ Ngân Hàng (CA4) - Technical Specification

**Last updated:** 2026-03-30  
**Issue:** [SimbaSql #58](https://github.com/diepxuan/SimbaSql/issues/58)  
**Module:** Cash > Ngân hàng  
**Mã chứng từ:** CA4  

---

## 1. Tổng quan

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

## 2. Database Schema

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

## 3. Stored Procedures

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

## 4. Implementation Files

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

## 5. Constants & Defaults

```php
// Phieubaono.php
const MA_CT          = 'CA4';           // Mã chứng từ
const DEFAULT_TK_CO  = 11_217;          // TK ngân hàng mặc định
const DEFAULT_MA_NT  = 'VND';           // Ngoại tệ mặc định
const DEFAULT_TY_GIA = 1;               // Tỷ giá mặc định
```

---

## 6. Validation Rules

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

## 7. Feature Checklist

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

## 8. Hướng dẫn cho AI Agent

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

## 9. Related Issues

| Issue | Repo | Title |
|-------|------|-------|
| #18 | SimbaSql | [CA] Phiếu chi - frmCaVchCA2 |
| #24 | portal | Cash \| Phieu chi \| Them, sua, xoa |
| #58 | SimbaSql | [CA] Phiếu báo nợ ngân hàng (UNC) |

---

## 10. References

- **Source code:** `diepxuan/laravel-catalog/src/Http/Livewire/Cash/Nganhang/Baono/`
- **Project Board:** https://github.com/orgs/diepxuan/projects/2
- **Issue:** https://github.com/diepxuan/SimbaSql/issues/58

---

*Document created by Bột - Portal Project Assistant*

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** NOT A TASK (meta/doc file, skipped)
