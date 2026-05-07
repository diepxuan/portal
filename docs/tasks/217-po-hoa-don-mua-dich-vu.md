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

## Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMNCC | Danh muc NCC | FK ma_kh -> DMNCC.ma_kh |
| DMHTTT | Danh muc HTTT | FK ma_httt -> DMHTTT.ma_httt |
| DMTS | Danh muc thue suat | FK ma_thue -> DMTS.ma_thue |
| DMVT | Danh muc vat tu | FK ma_vt -> DMVT.ma_vt |
| DSTK | Danh sach tai khoan | FK tk_* -> DSTK.tk |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_PO6_GET | Lay danh sach hoa don mua dich vu |
| SP_PO_PO6_GETBYID | Lay chi tiet 1 hoa don (header + detail + thue) |
| SP_PO_PO6_INSERT | Them hoa don moi |
| SP_PO_PO6_UPDATE | Cap nhat hoa don |
| SP_PO_PO6_DELETE | Xoa hoa don |
| SP_PO_PO6_FIND | Tim kiem hoa don |

### SP_GET (reference)

```sql
EXEC SP_PO_PO6_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
EXEC SP_PO_PO6_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pStt_rec VARCHAR(20)
```

### SP_INSERT (reference)

```sql
EXEC SP_PO_PO6_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20),
    @pMa_ct VARCHAR(10),
    @pNgay_ct DATETIME,
    @pSo_ct VARCHAR(20),
    @pSo_seri VARCHAR(20),
    @pMa_kh VARCHAR(20),
    @pNguoi_gd NVARCHAR(100),
    @pDia_chi NVARCHAR(500),
    @pMa_so_thue VARCHAR(20),
    @pSo_hd VARCHAR(20),
    @pNgay_hd DATETIME,
    @pMa_httt VARCHAR(20),
    @pDien_giai NVARCHAR(255),
    @pMa_nt VARCHAR(3),
    @pTy_gia DECIMAL(18,2),
    @pTk_pt VARCHAR(20),
    @pTk_thue VARCHAR(20),
    @pT_tien_nt DECIMAL(18,2),
    @pT_thue_nt DECIMAL(18,2),
    @pT_tt_nt DECIMAL(18,2),
    @pT_tien DECIMAL(18,2),
    @pT_thue DECIMAL(18,2),
    @pT_tt DECIMAL(18,2),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Hach toan

| Nợ | Có | Số tiền |
|----|----|---------|
| TK Chi phi / DV | | T_Tien |
| TK Thuế GTGT được khấu trừ | | T_Thue |
| | TK Phải trả NCC | T_Tt |

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma nha cung cap khong duoc trong' |
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Required | ma_httt | 'Hinh thuc thanh toan khong duoc trong' |
| Required | so_hd | 'So hoa don khong duoc trong' |
| Required | ngay_hd | 'Ngay hoa don khong duoc trong' |

### Business Rules

1. **Tu dong dien thong tin NCC**:
   - Sau khi chon ma_kh -> dien nguoi_gd, dia_chi, ma_so_thue, ma_httt
   - Lookup tu DMNCC

2. **Tu dong dien TK ke toan**:
   - Sau khi chon ma_httt -> dien tk_pt, tk_thue
   - Lay tu cau hinh HTTT

3. **Tinh toan**:
   ```
   Tien_NT = So_Luong * Gia_NT
   Tien = Tien_NT * Ty_Gia
   Thue_GTGT_NT = (Tien_NT) * Ts_GTGT / 100
   Thue_GTGT = Thue_GTGT_NT * Ty_Gia
   T_Tt_NT = T_Tien_NT + T_Thue_NT
   ```

4. **Lay thue dau vao tu chi tiet**:
   - Nut "cmdGetTaInFromDetail": Tong hop thue tu bang chi tiet
   - Dien vao bang TAIN

5. **Hach toan ke toan**:
   | No | Co | So tien |
   |----|----|---------|
   | TK Chi phi / Dich vu | | T_Tien |
   | TK Thue GTGT duoc khau tru | | T_Thue |
   | | TK Phai tra NCC | T_Tt |

### Lookup Integration

- Tu DMNCC: Chon nha cung cap, dien thong tin
- Tu DMHTTT: Chon hinh thuc thanh toan, dien TK
- Tu DMTS: Chon thue suat
- Tu DSTK: Chon tai khoan ke toan

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

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/PoGetPO6.php
class PoGetPO6 extends StoredProcedure
{
    protected $procedure = 'SP_PO_PO6_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/PoInsPO6.php
class PoInsPO6 extends StoredProcedure
{
    protected $procedure = 'SP_PO_PO6_INSERT';
    // params: all header fields
}

// diepxuan/laravel-simba/src/StoredProcedures/PoUpdPO6.php
// diepxuan/laravel-simba/src/StoredProcedures/PoDelPO6.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/Hoadonmuadichvu.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Voucher;

class Hoadonmuadichvu extends Component
{
    const MA_CT = 'PO6';

    public Collection $pHoaDons;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingSttRec = null;

    public function mount(): void { $this->loadHoaDon(); }
    public function loadHoaDon(): void { /* Load via SP */ }
    public function render(): View { return view('catalog::po.voucher.hoadonmuadichvu'); }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Voucher/HoadonmuadichvuEdit.php
class HoadonmuadichvuEdit extends Component
{
    public ?string $pStt_Rec = null;
    public ?string $pMa_Kh = null;
    public string $pSo_Hd = '';
    public ?string $pNgay_Ct = null;
    public ?string $pNgay_Hd = null;
    public ?string $pMa_Httt = null;
    public ?string $pMa_Nt = 'VND';
    public Collection $pChiTiet;
    public Collection $pThueDauVao;
    public ?string $pMode = 'create';

    public function updatedPMaKh($value): void { /* Lookup NCC info */ }
    public function updatedPMaHttt($value): void { /* Lookup accounting accounts */ }
    public function getThueFromDetail(): void { /* Aggregate tax from details */ }
    public function submit(): void { $this->validate(); /* Call SP */ }
    public function render(): View { return view('catalog::po.voucher.hoadonmuadichvu-edit'); }
}
```

### 5. Views

```
resources/views/catalog/po/voucher/
├── hoadonmuadichvu.blade.php           (List page)
├── hoadonmuadichvu-edit.blade.php      (Edit voucher)
└── _hoadonmuadichvu-row.blade.php      (Row component)
```

### 6. Routes

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

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | PO6.php | Chinh |
| Model | laravel-simba | PO7.php | Chi tiet |
| Model | laravel-simba | TAIN.php | Thue dau vao |
| SP | laravel-simba | PoGetPO6.php | Get list |
| SP | laravel-simba | PoInsPO6.php | Insert |
| SP | laravel-simba | PoUpdPO6.php | Update |
| SP | laravel-simba | PoDelPO6.php | Delete |
| Component | laravel-catalog | Hoadonmuadichvu.php | List |
| Component | laravel-catalog | HoadonmuadichvuEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model PO6, PO7, TAIN
- [ ] Tao Livewire components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test lookup NCC, HTTT
- [ ] Test tinh toan tien, thue
- [ ] Test lay thue dau vao tu chi tiet
- [ ] Test hach toan ke toan