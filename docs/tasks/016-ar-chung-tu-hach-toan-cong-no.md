# Task 016: AR - Chung tu hach toan cong no

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | ARVchAR4.dll |
| **Module** | AR (Accounts Receivable) |
| **Loai** | Voucher |
| **Trang thai** | Da phan tich |
| **Ma CT** | AR4 |

## Mo ta chuc nang

Nhap chung tu hach toan cong no phai thu, bu tru cong no.

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmArVchAR4 | frmVoucher | Form nhap lieu chinh |
| frmArVchAR4Find | - | Form tim kiem |

## Controls - Header

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtNgay_Ct | AsMaskedTextBox | ngay_ct | Ngay chung tu |
| txtSo_Ct | TextBox | so_ct | So chung tu |
| txtNgay_lct | AsMaskedTextBox | ngay_lct | Ngay lap CT |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| chkNt_Ph | AsCheckBox | nt_ph | Ngoai te chung |

## Controls - Detail Grid

| Column | Type | Mo ta |
|--------|------|-------|
| dgvcTk | DataGridViewAsTextBoxColumn | Tai khoan |
| dgvcTen_tk | DataGridViewTextBoxColumn | Ten TK |
| dgvcMa_kh | DataGridViewAsTextBoxColumn | Ma KH |
| dgvcPs_no_nt | DataGridViewAsTextNumericColumn | PS no NT |
| dgvcPs_co_nt | DataGridViewAsTextNumericColumn | PS co NT |
| dgvcPs_no | DataGridViewAsTextNumericColumn | PS no VND |
| dgvcPs_co | DataGridViewAsTextNumericColumn | PS co VND |
| dgvcDien_giai | DataGridViewTextBoxColumn | Dien giai |

## Tinh toan

- VND = NT × Ty gia
- Tong ps no = Tong ps co (can doi)
- Nếu tk_cn=1 thì phải nhập ma_kh

## CSDL

| Bang | Mo ta |
|------|-------|
| AR4PH | Chung tu AR4 header |
| AR4CT | Chung tu AR4 chi tiet |

## Tien do

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model
- [ ] Tao Controller
- [ ] Tao View

---

Nguoi thuc hien: Bot
Ngay tao: 2026-05-03
## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| AR4PH | Chứng từ AR4 header | Header |
| AR4CT | Chứng từ AR4 chi tiết | Detail |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `AR4PH_Get` | Lấy danh sách chứng từ AR4 |
| `AR4PH_Insert` | Thêm chứng từ AR4 header |
| `AR4PH_Update` | Cập nhật chứng từ AR4 header |
| `AR4PH_Delete` | Xóa chứng từ AR4 header |
| `AR4CT_Insert` | Thêm dòng chi tiết AR4 |
| `AR4CT_Update` | Cập nhật dòng chi tiết AR4 |
| `AR4CT_Delete` | Xóa dòng chi tiết AR4 |

## Business Logic

1. **Kiểm tra cân đối**: Tổng PS Nợ = Tổng PS Có (theo cả VND và NT)
2. **Tài khoản công nợ**: Nếu tk_cn=1 → bắt buộc nhập ma_kh
3. **Ngoại tệ**: Nếu nt_ph=1 → dùng tỷ giá chung từ header, ẩn cột ngoại tệ trên lưới
4. **Tính VND**: VND = NT × Tỷ giá
5. **Số chứng từ**: Auto generate theo cấu hình (prefix + số tự tăng)

## Mapping PHP

### Model: ArVchAR4
```php
// diepxuan/laravel-catalog/src/Models/ArVchAR4.php
namespace Diepxuan\Catalog\Models;

class ArVchAR4 extends Model
{
    protected $table = 'AR4PH';
    protected $primaryKey = 'so_ct';
    const MA_CT = 'AR4';

    public function details()
    {
        return $this->hasMany(ArVchAR4Ct::class, 'so_ct', 'so_ct')
            ->where('ma_cty', $this->ma_cty);
    }
}
```

### Controller
```php
Route::resource('ar-vch-ar4', ArVchAR4Controller::class);
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | AR | Module công nợ phải thu |
| diepxuan/system | Commons | Các hàm chung (AutoCode, FormatDate) |
| diepxuan/system | Lookup | Tra cứu TK, KH |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP
- [ ] Tao Model AR4PH, AR4CT
- [ ] Tao Controller ArVchAR4Controller
- [ ] Tao View (Livewire)
- [ ] Test CRUD
