# Task 217: PO-Hoa-Don-Mua-Dich-Vu

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang hoa don mua dich vu (PO6) tu .NET sang PHP Laravel, dat ket qua tuong duong PoVchPO6.

## Chi tiet
- **DLL:** PoVchPO6.dll
- **Chuc nang:** Hoa don mua dich vu (Service Purchase Invoice)
- **Loai:** Voucher (VCH)
- **Assembly Title:** Hoa don mua dich vu
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Công ty phần mềm Asia
- **Product:** Simba Accounting
- **Ma_ct:** PO6

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PoVchPO6.dll/README.md`

---

## Cau truc du lieu

### Bang: PO6 (Hoa don mua dich vu - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu record (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (PO6) |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 20 | So hoa don |
| so_seri | varchar | 20 | So seri |
| ma_kh | varchar | 20 | Ma nha cung cap (lookup) |
| nguoi_gd | nvarchar | 100 | Nguoi giao dich |
| dia_chi | nvarchar | 500 | Dia chi |
| ma_so_thue | varchar | 20 | Ma so thue |
| so_hd | varchar | 20 | So hoa don VAT |
| ngay_hd | datetime | 8 | Ngay hoa don VAT |
| ma_httt | varchar | 20 | Hinh thuc thanh toan |
| dien_giai | nvarchar | 255 | Dien giai |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,2 | Ty gia |
| tk_pt | varchar | 20 | TK phai tra |
| tk_thue | varchar | 20 | TK thue |
| t_tien_nt | decimal | 18,2 | Tong tien NT |
| t_thue_nt | decimal | 18,2 | Tong thue NT |
| t_tt_nt | decimal | 18,2 | Tong thanh toan NT |
| t_tien | decimal | 18,2 | Tong tien VND |
| t_thue | decimal | 18,2 | Tong thue VND |
| t_tt | decimal | 18,2 | Tong thanh toan VND |

### Bang: PO7 (Chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu/dich vu |
| dvt | nvarchar | Don vi tinh |
| so_luong | decimal | So luong |
| gia_nt | decimal | Gia ngoai te |
| tien_nt | decimal | Tien ngoai te |
| ts_gtgt | decimal | Thue suat GTGT |
| thue_gtgt_nt | decimal | Thue GTGT NT |
| gia | decimal | Gia VND |
| tien | decimal | Tien VND |
| thue_gtgt | decimal | Thue GTGT VND |
| tk_no | varchar | TK no |

### Bang: TAIN (Thue dau vao)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_thue | varchar | Ma thue |
| ts_gtgt | decimal | Thue suat |
| tien_nt | decimal | Tien hang NT |
| thue_nt | decimal | Tien thue NT |
| tien | decimal | Tien hang VND |
| thue | decimal | Tien thue VND |

---

## Form classes

### frmPoVchPO6 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_Seri | TextBox | so_seri | So seri hoa don |
| txtNgay_lct | AsMaskedTextBox | ngay_ct | Ngay lap chung tu |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia |
| txtMa_Kh | AsTextBox | ma_kh | Ma nha cung cap |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi giao dich |
| txtDia_chi | TextBox | dia_chi | Dia chi |
| txtMa_so_thue | TextBox | ma_so_thue | MST |
| txtSo_hd | TextBox | so_hd | So hoa don |
| txtNgay_hd | AsMaskedTextBox | ngay_hd | Ngay hoa don |
| txtMa_Httt | AsTextBox | ma_httt | HTTT |
| txtDien_giai | TextBox | dien_giai | Dien giai |
| adgvDetail | AsInputDGV | Chi tiet dich vu |
| ctlTaIn | ctlTaIn | Control thue dau vao |
| cmdGetTaInFromDetail | Button | Lay thue tu chi tiet |
| adgvHach_toan | AsInputDGV | Hach toan |
| txtTk_pt | AsTextBox | tk_pt | TK phai tra |
| txtTk_thue | AsTextBox | tk_thue | TK thue |

---

## Business Logic

### Hach toan

| Nợ | Có | Số tiền |
|----|----|---------|
| TK Chi phi / DV | | T_Tien |
| TK Thuế GTGT được khấu trừ | | T_Thue |
| | TK Phải trả NCC | T_Tt |

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/PO6.php
namespace Diepxuan\Simba\Models\PO;

class PO6 extends Model
{
    protected $table = 'PO6';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const MA_CT = 'PO6';

    public function details()
    {
        return $this->hasMany(PO7::class, 'stt_rec', 'stt_rec');
    }

    public function thueDauVao()
    {
        return $this->hasMany(TAIN::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/po')
    ->name('catalog.po.')
    ->group(function () {
        Route::get('/hoa-don-mua-dich-vu', [Hoadonmuadichvu::class, 'render'])
            ->name('hoadonmuadichvu');
        Route::get('/hoa-don-mua-dich-vu/edit/{sttRec?}', [HoadonmuadichvuEdit::class, 'render'])
            ->name('hoadonmuadichvu.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model PO6, PO7, TAIN
- [ ] Tao Livewire components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations