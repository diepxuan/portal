# Task 055: SOVchSO3

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang voucher hoa don ban hang tu .NET sang PHP Laravel, dat ket qua tuong duong SOVchSO3.

## Chi tiet
- **DLL:** SOVchSO3.dll
- **Chuc nang:** Quan ly hoa don ban hang (Sales Invoice Voucher)
- **Loai:** Voucher (Vch)
- **Assembly Title:** Hoa don ban hang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO3

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO3.dll/README.md`

---

## Cau truc du lieu

### Bang: SO3 (Hoa don ban hang - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu ban ghi (khoa chinh) |
| ma_ct | varchar | 10 | Loai chung tu (SO3) |
| ngay_ct | datetime | 8 | Ngay hoa don |
| so_ct | varchar | 20 | So hoa don |
| so_seri | varchar | 20 | So seri hoa don |
| ma_kh | varchar | 20 | Ma khach hang |
| ten_kh | nvarchar | 255 | Ten khach hang |
| dia_chi_vat | nvarchar | 500 | Dia chi xuat hoa don |
| ma_so_thue | varchar | 20 | Ma so thue KH |
| nguoi_gd | nvarchar | 100 | Nguoi mua |
| ma_httt | varchar | 20 | Ma hinh thuc thanh toan |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,2 | Ty gia |
| tk_pt | varchar | 20 | Tai khoan phai thu |
| tk_thue | varchar | 20 | Tai khoan thue GTGT |
| tk_ck_ds | varchar | 20 | Tai khoan chiet khau doanh so |
| so_px | varchar | 20 | So phieu xuat lien quan |
| t_tien_nt2 | decimal | 18,2 | Tong tien hang NT |
| t_tien2 | decimal | 18,2 | Tong tien hang VND |
| t_ck_nt | decimal | 18,2 | Tong chiet khau NT |
| t_ck | decimal | 18,2 | Tong chiet khau VND |
| t_ck_ds_nt | decimal | 18,2 | Tong CK doanh so NT |
| t_ck_ds | decimal | 18,2 | Tong CK doanh so VND |
| t_thue_nt | decimal | 18,2 | Tong thue GTGT NT |
| t_thue | decimal | 18,2 | Tong thue GTGT VND |
| t_tt_nt | decimal | 18,2 | Tong thanh toan NT |
| t_tt | decimal | 18,2 | Tong thanh toan VND |

### Bang: SO4 (Hoa don ban hang - Chi tiet)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | FK -> SO3.stt_rec |
| stt_rec0 | varchar | 5 | So thu tu dong |
| ma_vt | varchar | 20 | Ma vat tu |
| ma_kho | varchar | 20 | Ma kho |
| so_luong | decimal | 18,2 | So luong |
| gia_nt2 | decimal | 18,2 | Gia ban NT |
| tien_nt2 | decimal | 18,2 | Tien hang NT |
| gia2 | decimal | 18,2 | Gia ban VND |
| tien2 | decimal | 18,2 | Tien hang VND |
| tl_ck | decimal | 5,2 | Ty le chiet khau |
| tien_ck_nt | decimal | 18,2 | Tien CK NT |
| tien_ck | decimal | 18,2 | Tien CK VND |
| ma_thue | varchar | 20 | Ma thue |
| ts_gtgt | decimal | 5,2 | Thue suat GTGT |
| thue_gtgt_nt | decimal | 18,2 | Thue GTGT NT |
| thue_gtgt | decimal | 18,2 | Thue GTGT VND |
| ma_nvkd | varchar | 20 | Ma NVKD |
| tk_dt | varchar | 20 | TK doanh thu |
| tk_gv | varchar | 20 | TK gia von |
| tk_vt | varchar | 20 | TK kho |
| tk_ck | varchar | 20 | TK chiet khau |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh -> DMKH.ma_kh |
| SO1 | Don hang ban | Lien ket qua so_px |
| SOND51mhd | Mau hoa don | FK so_seri -> SOND51mhd |
| SOUtilities | Tien ich SO | Lookup gia, chiet khau, quyen in |

---

## Form classes

### 1. frmSoVchSO3 (Form voucher hoa don)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap lieu, xem, sua hoa don ban hang
- **Controls phan thong tin chung (gbPH):**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | ma_kh | Ma KH (lookup) |
| lblTen_Kh | Label | ten_kh | Ten KH |
| txtTen_Kh | TextBox | ten_kh | Ten KH (editable) |
| txtDia_Chi_Vat | TextBox | dia_chi_vat | Dia chi xuat HD |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi mua |
| txtMa_So_Thue | TextBox | ma_so_thue | Ma so thue |
| txtSo_Seri | TextBox | so_seri | So seri HD |
| txtSo_Ct | TextBox | so_ct | So hoa don |
| txtNgay_Ct | AsMaskedTextBox | ngay_ct | Ngay HD (dd/MM/yyyy) |
| txtNgay_Lct | AsMaskedTextBox | ngay_lct | Ngay lap chung tu |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtMa_Httt | AsTextBox | ma_httt | Ma hinh thuc TT |
| cboHttt | ComboBox | httt | HTTT (TM/CK) |
| txtTk_Pt | AsTextBox | tk_pt | TK phai thu |
| txtTk_Thue | AsTextBox | tk_thue | TK thue GTGT |
| txtSo_Px | TextBox | so_px | So PX lien quan |
| txtGh_No | AsTextNumeric | gh_no | Gioi han no |
| txtDu13 | AsTextNumeric | du13 | Du hien thoi KH |

### 2. TabChiTiet - DataGridView (adgvDetail)

| Column | DataField | Mo ta |
|--------|-----------|-------|
| dgvcMa_Vt | ma_vt | Ma vat tu |
| dgvcTen_Vt | ten_vt | Ten vat tu |
| dgvcDvt | dvt | Don vi tinh |
| dgvcMa_Kho | ma_kho | Ma kho |
| dgvcTon | ton | Ton kho |
| dgvcSo_Luong | so_luong | So luong |
| dgvcGia_Nt2 | gia_nt2 | Gia ban NT |
| dgvcTien_Nt2 | tien_nt2 | Tien hang NT |
| dgvcTl_Ck | tl_ck | Ty le CK |
| dgvcTien_Ck_Nt | tien_ck_nt | Tien CK NT |
| dgvcTs_Gtgt | ts_gtgt | Thue suat GTGT |
| dgvcThue_Gtgt_Nt | thue_gtgt_nt | Thue GTGT NT |
| dgvcGia2 | gia2 | Gia ban VND |
| dgvcTien2 | tien2 | Tien hang VND |
| dgvcMa_Nvkd | ma_nvkd | Ma NVKD |
| dgvcTk_Dt | tk_dt | TK doanh thu |
| dgvcTk_Gv | tk_gv | TK gia von |
| dgvcTk_Vt | tk_vt | TK kho |
| dgvcTk_Ck | tk_ck | TK chiet khau |

### 3. Tab Hach toan (tabHach_Toan)
- Thong tin hach toan ke toan (no/co)

### 4. Tab Truong tuy chon (tabOptFields)
- Cac truong tuy bien theo cau hinh

### 5. Tong cong (Footer)

| Control | Mo ta |
|---------|-------|
| txtT_So_Luong | Tong so luong |
| txtT_Tien_Nt2 | Tong tien NT |
| txtT_Tien2 | Tong tien VND |
| txtT_Ck_Nt | Tong CK NT |
| txtT_Ck | Tong CK VND |
| txtT_Thue_Nt | Tong thue NT |
| txtT_Thue | Tong thue VND |
| txtT_Tt_Nt | Tong thanh toan NT |
| txtT_Tt | Tong thanh toan VND |
| txtTl_Ck_Ds | Ty le CK doanh so |
| txtT_Ck_Ds_Nt | Tien CK doanh so NT |
| txtT_Ck_Ds | Tien CK doanh so VND |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_SO3_GET | Lay danh sach hoa don |
| SP_SO_SO3_GETBYID | Lay chi tiet 1 hoa don |
| SP_SO_SO3_INSERT | Them hoa don moi |
| SP_SO_SO3_UPDATE | Cap nhat hoa don |
| SP_SO_SO3_DELETE | Xoa hoa don |
| SP_SO_SO3_FIND | Tim kiem hoa don |

### SP_GET (reference)

```sql
EXEC SP_SO_SO3_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
EXEC SP_SO_SO3_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pStt_rec VARCHAR(20)
```

### SP_INSERT (reference)

```sql
EXEC SP_SO_SO3_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20),
    @pMa_ct VARCHAR(10),
    @pNgay_ct DATETIME,
    @pSo_ct VARCHAR(20),
    @pSo_seri VARCHAR(20),
    @pMa_kh VARCHAR(20),
    @pTen_kh NVARCHAR(255),
    @pDia_chi_vat NVARCHAR(500),
    @pMa_so_thue VARCHAR(20),
    @pNguoi_gd NVARCHAR(100),
    @pMa_httt VARCHAR(20),
    @pMa_nt VARCHAR(3),
    @pTy_gia DECIMAL(18,2),
    @pTk_pt VARCHAR(20),
    @pTk_thue VARCHAR(20),
    @pTk_ck_ds VARCHAR(20),
    @pSo_px VARCHAR(20),
    @pT_tien_nt2 DECIMAL(18,2),
    @pT_tien2 DECIMAL(18,2),
    @pT_ck_nt DECIMAL(18,2),
    @pT_ck DECIMAL(18,2),
    @pT_ck_ds_nt DECIMAL(18,2),
    @pT_ck_ds DECIMAL(18,2),
    @pT_thue_nt DECIMAL(18,2),
    @pT_thue DECIMAL(18,2),
    @pT_tt_nt DECIMAL(18,2),
    @pT_tt DECIMAL(18,2),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Required | ngay_ct | 'Ngay hoa don khong duoc trong' |
| Required | so_seri | 'So seri khong duoc trong' |
| Required | so_ct | 'So hoa don khong duoc trong' |
| Required | ma_httt | 'Hinh thuc thanh toan khong duoc trong' |
| Numeric | ty_gia | 'Ty gia phai la so' |
| Check ton kho | so_luong | 'Ton kho khong du' |
| Check cong no | t_tt | 'Vuot gioi han no' |

### Business Rules

1. **Loai hoa don**:
   - "1": Hoa don kiem phieu xuat
   - "2": Chi la hoa don

2. **Tu dong dien thong tin KH**:
   - Sau khi chon ma_kh -> dien ten_kh, dia_chi_vat, ma_so_thue, nguoi_gd, ma_httt
   - Lookup tu DMKH

3. **Tu dong dien TK ke toan**:
   - Sau khi chon ma_httt -> dien tk_pt, tk_thue, tk_ck_ds
   - Lay tu cau hinh HTTT

4. **Tinh toan**:
   ```
   Tien_Nt2 = So_Luong * Gia_Nt2
   Tien2 = Tien_Nt2 * Ty_Gia
   Tien_Ck_Nt = Tien_Nt2 * Tl_Ck / 100
   Thue_Gtgt_Nt = (Tien_Nt2 - Tien_Ck_Nt) * Ts_Gtgt / 100
   T_Ck_Ds_Nt = T_Tien_Nt2 * Tl_Ck_Ds / 100
   T_Tt_Nt = Tien_Nt2 - Tien_Ck_Nt + Thue_Gtgt_Nt - Ck_Ds
   ```

5. **Kiem tra gioi han cong no**:
   - So sanh t_tt voi gh_no (gioi han no) + du13 (du hien thoi)
   - Vuot han -> canh bao

6. **Hach toan ke toan**:
   | No | Co | So tien |
   |----|----|---------|
   | TK Phai thu KH | | T_Tt |
   | | TK Doanh thu | T_Tien2 |
   | | TK Thue GTGT | T_Thue |
   | TK Gia von | | T_Tien |
   | | TK Kho | T_Tien |

7. **In hoa don**:
   - Crystal Reports integration
   - Kiem tra quyen in (Get_RightPrint)
   - Ghi log in (SoInsLogPrint)

### Lookup Integration

- Tu DMKH: Chon khach hang, dien thong tin
- Tu SODMHTTT: Chon hinh thuc thanh toan, dien TK
- Tu SOUtilities: Lay gia ban, chiet khau, kiem tra quyen
- Tu SOND51mhd: Chon mau/seri hoa don
- Tu SO1: Lien ket don hang ban (qua so_px)

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/SO3.php
namespace Diepxuan\Simba\Models\SO;

class SO3 extends Model
{
    protected $table = 'SO3';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct', 'so_seri',
        'ma_kh', 'ten_kh', 'dia_chi_vat', 'ma_so_thue', 'nguoi_gd',
        'ma_httt', 'ma_nt', 'ty_gia',
        'tk_pt', 'tk_thue', 'tk_ck_ds', 'so_px',
        't_tien_nt2', 't_tien2', 't_ck_nt', 't_ck',
        't_ck_ds_nt', 't_ck_ds', 't_thue_nt', 't_thue',
        't_tt_nt', 't_tt',
    ];

    protected $casts = [
        'ngay_ct' => 'date',
        'ty_gia' => 'decimal:2',
        't_tien_nt2' => 'decimal:2',
        't_tien2' => 'decimal:2',
        't_ck_nt' => 'decimal:2',
        't_ck' => 'decimal:2',
        't_ck_ds_nt' => 'decimal:2',
        't_ck_ds' => 'decimal:2',
        't_thue_nt' => 'decimal:2',
        't_thue' => 'decimal:2',
        't_tt_nt' => 'decimal:2',
        't_tt' => 'decimal:2',
    ];

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function chiTiet()
    {
        return $this->hasMany(SO4::class, 'stt_rec', 'stt_rec');
    }

    public function phieuXuat()
    {
        return $this->belongsTo(SO2::class, 'so_px', 'so_ct');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('so_ct', 'like', "%{$search}%")
              ->orWhere('ten_kh', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoGetSO3.php
class SoGetSO3 extends StoredProcedure
{
    protected $procedure = 'SP_SO_SO3_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoInsSO3.php
class SoInsSO3 extends StoredProcedure
{
    protected $procedure = 'SP_SO_SO3_INSERT';
    // params: all header fields
}

// diepxuan/laravel-simba/src/StoredProcedures/SoUpdSO3.php
// diepxuan/laravel-simba/src/StoredProcedures/SoDelSO3.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Voucher/Hoadonbanhang.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Voucher;

class Hoadonbanhang extends Component
{
    const MA_CT = 'SO3';

    public Collection $pHoaDons;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingSttRec = null;

    public function mount(): void { $this->loadHoaDon(); }
    public function loadHoaDon(): void { /* Load via SP */ }
    public function render(): View { return view('catalog::so.voucher.hoadonbanhang'); }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Voucher/HoadonbanhangEdit.php
class HoadonbanhangEdit extends Component
{
    public ?string $pStt_Rec = null;
    public ?string $pMa_Kh = null;
    public string $pTen_Kh = '';
    public ?string $pNgay_Ct = null;
    public ?string $pMa_Httt = null;
    public ?string $pMa_Nt = 'VND';
    public Collection $pChiTiet;
    public ?string $pMode = 'create';

    public function updatedPMaKh($value): void { /* Lookup KH info */ }
    public function updatedPMaHttt($value): void { /* Lookup accounting accounts */ }
    public function submit(): void { $this->validate(); /* Call SP */ }
    public function render(): View { return view('catalog::so.voucher.hoadonbanhang-edit'); }
}
```

### 5. Views

```
resources/views/catalog/so/voucher/
├── hoadonbanhang.blade.php           (List page)
├── hoadonbanhang-edit.blade.php      (Edit voucher)
└── _hoadonbanhang-row.blade.php      (Row component)
```

### 6. Routes

```php
Route::prefix('catalog/so/voucher')
    ->name('catalog.so.voucher.')
    ->group(function () {
        Route::get('/hoa-don-ban-hang', [Hoadonbanhang::class, 'render'])
            ->name('hoadonbanhang');
        Route::get('/hoa-don-ban-hang/edit/{sttRec?}', [HoadonbanhangEdit::class, 'render'])
            ->name('hoadonbanhang.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SO3.php | Chinh |
| Model | laravel-simba | SO4.php | Chi tiet |
| Model | laravel-simba | DMKH.php | Lien quan |
| SP | laravel-simba | SoGetSO3.php | Get list |
| SP | laravel-simba | SoInsSO3.php | Insert |
| SP | laravel-simba | SoUpdSO3.php | Update |
| SP | laravel-simba | SoDelSO3.php | Delete |
| Component | laravel-catalog | Hoadonbanhang.php | List |
| Component | laravel-catalog | HoadonbanhangEdit.php | Edit |
| Utility | laravel-simba | SOCommon.php | Pricing, lookup |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete)
- [ ] Tao Model SO3 + SO4
- [ ] Tao Livewire Hoadonbanhang (list)
- [ ] Tao Livewire HoadonbanhangEdit (edit)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test tinh toan tien, thue, chiet khau
- [ ] Test lookup KH, HTTT
- [ ] Test kiem tra gioi han cong no
- [ ] Test in hoa don (Crystal Reports -> PHP PDF)

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
