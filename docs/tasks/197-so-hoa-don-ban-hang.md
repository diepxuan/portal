# Task 197: SO-Hoa-Don-Ban-Hang

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang hoa don ban hang (SO3) tu .NET sang PHP Laravel, dat ket qua tuong duong SOVchSO3.

## Chi tiet
- **DLL:** SOVchSO3.dll
- **Chuc nang:** Hoa don ban hang (Sales Invoice)
- **Loai:** Voucher (VCH)
- **Assembly Title:** Asia Enterprise
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
| stt_rec | varchar | 20 | So thu tu record (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (SO3) |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 20 | So hoa don |
| so_seri | varchar | 20 | So seri hoa don |
| ma_kh | varchar | 20 | Ma khach hang (lookup) |
| ten_kh | nvarchar | 255 | Ten khach hang |
| dia_chi_vat | nvarchar | 500 | Dia chi xuat hoa don |
| ma_so_thue | varchar | 20 | Ma so thue KH |
| nguoi_gd | nvarchar | 100 | Nguoi mua |
| ma_httt | varchar | 20 | Ma hinh thuc thanh toan |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,2 | Ty gia |
| tk_pt | varchar | 20 | Tai khoan phai thu |
| tk_thue | varchar | 20 | Tai khoan thue GTGT |
| tk_ck_ds | varchar | 20 | TK chiet khau doanh so |
| so_px | varchar | 20 | So phieu xuat kho lien quan |
| t_tien_nt2 | decimal | 18,2 | Tong tien hang NT |
| t_tien2 | decimal | 18,2 | Tong tien hang VND |
| t_ck_nt | decimal | 18,2 | Tong chiet khau NT |
| t_ck | decimal | 18,2 | Tong chiet khau VND |
| t_ck_ds_nt | decimal | 18,2 | CK doanh so NT |
| t_ck_ds | decimal | 18,2 | CK doanh so VND |
| t_thue_nt | decimal | 18,2 | Tong thue GTGT NT |
| t_thue | decimal | 18,2 | Tong thue GTGT VND |
| t_tt_nt | decimal | 18,2 | Tong thanh toan NT |
| t_tt | decimal | 18,2 | Tong thanh toan VND |
| tl_ck_ds | decimal | 5,2 | Ty le CK doanh so |
| gh_no | decimal | 18,2 | Gioi han cong no |
| du13 | decimal | 18,2 | Du hien thoi cua KH |

### Bang: SO4 (Hoa don ban hang - Chi tiet)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu record (FK) |
| stt_rec0 | varchar | 5 | So thu tu chi tiet |
| ma_vt | varchar | 20 | Ma vat tu |
| ma_kho | varchar | 20 | Ma kho |
| so_luong | decimal | 18,2 | So luong |
| gia_nt2 | decimal | 18,2 | Gia ban ngoai te |
| tien_nt2 | decimal | 18,2 | Tien hang NT |
| gia2 | decimal | 18,2 | Gia ban VND |
| tien2 | decimal | 18,2 | Tien hang VND |
| tl_ck | decimal | 5,2 | Ty le chiet khau |
| tien_ck_nt | decimal | 18,2 | Tien chiet khau NT |
| tien_ck | decimal | 18,2 | Tien chiet khau VND |
| ma_thue | varchar | 20 | Ma thue |
| ts_gtgt | decimal | 5,2 | Thue suat GTGT |
| thue_gtgt_nt | decimal | 18,2 | Thue GTGT NT |
| thue_gtgt | decimal | 18,2 | Thue GTGT VND |
| ma_nvkd | varchar | 20 | Ma nhan vien kinh doanh |
| tk_dt | varchar | 20 | TK doanh thu |
| tk_gv | varchar | 20 | TK gia von |
| tk_vt | varchar | 20 | TK kho |
| tk_ck | varchar | 20 | TK chiet khau |

### Bang: HT01 (Hach toan)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu hach toan |
| tk | varchar | Tai khoan |
| ps_no | decimal | Phat sinh no |
| ps_co | decimal | Phat sinh co |
| ma_kh | varchar | Ma khach hang |
| ma_vv | varchar | Ma vu viec |
| ma_bp | varchar | Ma bo phan |
| ma_phi | varchar | Ma phi |
| ma_hd | varchar | Ma hop dong |
| ma_ku | varchar | Ma ke uoc |
| ma_spct | varchar | Ma san pham chi tiet |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh -> DMKH.ma_kh |
| DMVT | Danh muc vat tu | FK ma_vt -> DMVT.ma_vt |
| DMKHO | Danh muc kho | FK ma_kho -> DMKHO.ma_kho |
| SO3 | Hoa don ban hang | PK stt_rec |
| DMHTTT | Hinh thuc thanh toan | FK ma_httt -> DMHTTT.ma_httt |

---

## Form classes

### 1. frmSoVchSO3 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap hoa don ban hang voi chi tiet hang hoa
- **Controls:**

#### Thong tin chung (gbPH)

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang (AutoLookup) |
| lblTen_Kh | Label | ten_kh | Ten khach hang |
| txtTen_Kh | TextBox | ten_kh | Ten khach hang (editable) |
| txtDia_Chi_Vat | TextBox | dia_chi_vat | Dia chi xuat hoa don |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi mua |
| txtMa_So_Thue | TextBox | ma_so_thue | Ma so thue KH |
| txtSo_Seri | TextBox | so_seri | So seri hoa don |
| txtSo_Ct | TextBox | so_ct | So hoa don |
| txtNgay_Ct | AsMaskedTextBox | ngay_ct | Ngay hoa don |
| txtNgay_Lct | AsMaskedTextBox | ngay_ct | Ngay lap chung tu |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtMa_Httt | AsTextBox | ma_httt | Ma hinh thuc thanh toan |
| cboHttt | ComboBox | ma_httt | Hinh thuc TT (TM/CK) |
| txtTk_Pt | AsTextBox | tk_pt | TK phai thu |
| txtTk_Thue | AsTextBox | tk_thue | TK thue GTGT |
| txtSo_Px | TextBox | so_px | So phieu xuat kho lien quan |
| txtGh_No | AsTextNumeric | gh_no | Gioi han cong no |
| txtDu13 | AsTextNumeric | du13 | Du hien thoi KH |

#### TabControl

| Tab | Mo ta |
|-----|-------|
| tabDetail | Chi tiet hang hoa/dich vu |
| tabHach_Toan | Thong tin hach toan ke toan |
| tabOptFields | Truong tuy chon |

#### DataGridView (adgvDetail)

| Column | Type | DataField | Mo ta |
|--------|------|-----------|-------|
| dgvcMa_Vt | AsTextBox | ma_vt | Ma vat tu |
| dgvcTen_Vt | TextBox | ten_vt | Ten vat tu |
| dgvcDvt | TextBox | dvt | Don vi tinh |
| dgvcMa_Kho | AsTextBox | ma_kho | Ma kho |
| dgvcTon | AsTextNumeric | ton_kho | Ton kho |
| dgvcSo_Luong | AsTextNumeric | so_luong | So luong |
| dgvcGia_Nt2 | AsTextNumeric | gia_nt2 | Gia ban NT |
| dgvcTien_Nt2 | AsTextNumeric | tien_nt2 | Tien hang NT |
| dgvcTl_Ck | AsTextNumeric | tl_ck | Ty le chiet khau |
| dgvcTien_Ck_Nt | AsTextNumeric | tien_ck_nt | Tien CK NT |
| dgvcTs_Gtgt | AsTextNumeric | ts_gtgt | Thue suat GTGT |
| dgvcThue_Gtgt_Nt | AsTextNumeric | thue_gtgt_nt | Thue GTGT NT |
| dgvcGia2 | AsTextNumeric | gia2 | Gia ban VND |
| dgvcTien2 | AsTextNumeric | tien2 | Tien hang VND |
| dgvcMa_Nvkd | AsTextBox | ma_nvkd | Ma NVKD |
| dgvcTk_Dt | AsTextBox | tk_dt | TK doanh thu |
| dgvcTk_Gv | AsTextBox | tk_gv | TK gia von |
| dgvcTk_Vt | AsTextBox | tk_vt | TK kho |
| dgvcTk_Ck | AsTextBox | tk_ck | TK chiet khau |

#### Footer (Tong cong)

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtT_So_Luong | AsTextNumeric | - | Tong so luong |
| txtT_Tien_Nt2 | AsTextNumeric | t_tien_nt2 | Tong tien NT |
| txtT_Tien2 | AsTextNumeric | t_tien2 | Tong tien VND |
| txtT_Ck_Nt | AsTextNumeric | t_ck_nt | Tong CK NT |
| txtT_Ck | AsTextNumeric | t_ck | Tong CK VND |
| txtT_Thue_Nt | AsTextNumeric | t_thue_nt | Tong thue NT |
| txtT_Thue | AsTextNumeric | t_thue | Tong thue VND |
| txtT_Tt_Nt | AsTextNumeric | t_tt_nt | Tong thanh toan NT |
| txtT_Tt | AsTextNumeric | t_tt | Tong thanh toan VND |
| txtTl_Ck_Ds | AsTextNumeric | tl_ck_ds | Ty le CK doanh so |
| txtT_Ck_Ds_Nt | AsTextNumeric | t_ck_ds_nt | Tien CK doanh so NT |
| txtT_Ck_Ds | AsTextNumeric | t_ck_ds | Tien CK doanh so VND |

### 2. frmSoVchSO3Find (Form tim kiem)
- **Ke thua:** frmVoucherFind
- **Chuc nang:** Tim kiem hoa don theo nhieu tieu chi

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO3_GET | Lay danh sach hoa don ban hang |
| SP_SO3_GETBYID | Lay chi tiet 1 hoa don |
| SP_SO3_INSERT | Them hoa don ban hang |
| SP_SO3_UPDATE | Cap nhat hoa don ban hang |
| SP_SO3_DELETE | Xoa hoa don ban hang |
| SP_SO3_FIND | Tim kiem hoa don |
| SP_SO3_CHECK | Kiem tra trung so hoa don |

### SP_GET (reference)

```sql
-- Lay danh sach hoa don ban hang
EXEC SP_SO3_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_ct VARCHAR(10) = 'SO3',
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL,
    @pMa_kh VARCHAR(20) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
-- Lay chi tiet hoa don + chi tiet hang hoa + hach toan
EXEC SP_SO3_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pStt_rec VARCHAR(20)
```

### SP_INSERT (reference)

```sql
-- Them hoa don ban hang
EXEC SP_SO3_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20) OUTPUT,
    @pMa_ct VARCHAR(10),
    @pNgay_ct DATETIME,
    @pSo_Ct VARCHAR(20),
    @pSo_Seri VARCHAR(20),
    @pMa_kh VARCHAR(20),
    @pTen_kh NVARCHAR(255),
    -- ... cac truong khac
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Required | so_ct | 'So hoa don khong duoc trong' |
| Unique (so_ct + so_seri) | so_ct | 'So hoa don da ton tai' |
| Required | ma_nt | 'Ma ngoai te khong duoc trong' |
| Required | ngay_ct | 'Ngay hoa don khong duoc trong' |
| Valid | ty_gia | 'Ty gia phai lon hon 0' |

### Business Rules

1. **Loai hoa don**:
   - HOA_DON_KIEM_PHIEU_XUAT = "1" (Hoa don kiem phieu xuat)
   - HOA_DON = "2" (Chi la hoa don)

2. **AfterCodeValidating (txtMa_Kh)**:
   - Dien thong tin KH: ten_kh, dia_chi_vat, ma_so_thue, nguoi_gd
   - Lay ma_httt, hinh thuc TT, TK phai thu, TK thue
   - Tinh du13 (du hien thoi cua KH)
   - Kiem tra gh_no vs du13

3. **AfterCodeValidating (txtMa_Httt)**:
   - Lay tk_pt (TK phai thu)
   - Lay tk_thue (TK thue GTGT)
   - Lay tk_ck_ds (TK chiet khau doanh so)

4. **TyGia ValueChanged**:
   - Quy doi gia tu ngoai te sang VND: gia2 = gia_nt2 * ty_gia
   - Tinh lai tien hang VND: tien2 = tien_nt2 * ty_gia

5. **Tinh toan chi tiet**:
   ```csharp
   // Tinh tien hang
   Tien_Nt2 = So_Luong * Gia_Nt2
   Tien2 = Tien_Nt2 * Ty_Gia

   // Tinh chiet khau mat hang
   Tien_Ck_Nt = Tien_Nt2 * Tl_Ck / 100
   Tien_Ck = Tien_Ck_Nt * Ty_Gia

   // Tinh thue GTGT
   Thue_Gtgt_Nt = (Tien_Nt2 - Tien_Ck_Nt) * Ts_Gtgt / 100
   Thue_Gtgt = Thue_Gtgt_Nt * Ty_Gia

   // Tinh CK doanh so (phan bo theo dong hang)
   T_Ck_Ds_Nt = T_Tien_Nt2 * Tl_Ck_Ds / 100
   ```

6. **Hach toan ke toan**:
   | Nợ | Có | Số tiền |
   |----|----|---------|
   | TK Phải thu KH | | T_Tt |
   | | TK Doanh thu | T_Tien2 |
   | | TK Thuế GTGT | T_Thue |
   | TK Giá vốn | | T_Tien |
   | | TK Kho | T_Tien |

7. **Lien ket phieu xuat kho (So_Px)**:
   - Khi co so_px, tu dong tao phieu xuat kho lien quan
   - Chi tiet hang hoa tu dong dien vao grid

8. **Kiem tra cong no**:
   - Neu gh_no > 0 va du13 > gh_no: canh bao vuot gioi han cong no

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

    const MA_CT = 'SO3';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct', 'so_seri',
        'ma_kh', 'ten_kh', 'dia_chi_vat', 'ma_so_thue', 'nguoi_gd',
        'ma_httt', 'ma_nt', 'ty_gia', 'tk_pt', 'tk_thue', 'tk_ck_ds',
        'so_px', 't_tien_nt2', 't_tien2', 't_ck_nt', 't_ck',
        't_ck_ds_nt', 't_ck_ds', 't_thue_nt', 't_thue',
        't_tt_nt', 't_tt', 'tl_ck_ds', 'gh_no', 'du13',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:2',
        't_tien_nt2' => 'decimal:2',
        't_tien2' => 'decimal:2',
        't_ck_nt' => 'decimal:2',
        't_ck' => 'decimal:2',
        't_thue_nt' => 'decimal:2',
        't_thue' => 'decimal:2',
        't_tt_nt' => 'decimal:2',
        't_tt' => 'decimal:2',
    ];

    // Relationships
    public function details()
    {
        return $this->hasMany(SO4::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function hinhThucThanhToan()
    {
        return $this->belongsTo(DMHTTT::class, 'ma_httt', 'ma_httt');
    }

    public function hachToans()
    {
        return $this->hasMany(HT01::class, 'stt_rec', 'stt_rec');
    }

    // Scopes
    public function scopeByMaCt($query, $maCt = 'SO3')
    {
        return $query->where('ma_ct', $maCt);
    }

    public function scopeDateRange($query, $ngay1, $ngay2)
    {
        return $query->whereBetween('ngay_ct', [$ngay1, $ngay2]);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetSO3.php
namespace Diepxuan\Simba\StoredProcedures;

class AsSOGetSO3 extends StoredProcedure
{
    protected $procedure = 'SP_SO3_GET';
    protected $params = [
        'pMa_cty', 'pMa_ct', 'pNgay1', 'pNgay2',
        'pMa_kh', 'pSearch', 'pPageIndex', 'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsSO3.php
class AsSOInsSO3 extends StoredProcedure
{
    protected $procedure = 'SP_SO3_INSERT';
    protected $params = [
        'pMa_cty', 'pStt_rec', 'pMa_ct', 'pNgay_ct', 'pSo_Ct',
        'pSo_Seri', 'pMa_kh', 'pTen_kh', 'pDia_chi_vat',
        'pMa_so_thue', 'pNguoi_gd', 'pMa_httt', 'pMa_nt',
        'pTy_gia', 'pTk_pt', 'pTk_thue', 'pTk_ck_ds',
        'pSo_px', 'pT_tien_nt2', 'pT_tien2',
        'pT_ck_nt', 'pT_ck', 'pT_ck_ds_nt', 'pT_ck_ds',
        'pT_thue_nt', 'pT_thue', 'pT_tt_nt', 'pT_tt',
        'pTl_ck_ds', 'pGh_no', 'pDu13',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsSO4.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsHT01.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Hoadonbanhang.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Hoadonbanhang;

class Hoadonbanhang extends Component
{
    const MA_CT = 'SO3';

    public Collection $pHoaDons;
    public string $pSearch = '';
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public ?string $pMaKh = null;
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadHoaDon();
    }

    public function loadHoaDon(): void
    {
        // Load tu Stored Procedure SP_SO3_GET
    }

    public function render(): View
    {
        return view('catalog::so.hoadonbanhang');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/HoadonbanhangEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\HoadonbanhangEdit;

class HoadonbanhangEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pMaCt = 'SO3';
    public string $pSoSeri = '';
    public string $pSoCt = '';
    public ?string $pNgayCt = null;
    public string $pMaKh = '';
    public string $pTenKh = '';
    public string $pDiaChiVat = '';
    public string $pMaSoThue = '';
    public string $pNguoiGd = '';
    public string $pMaHttt = '';
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public string $pTkPt = '';
    public string $pTkThue = '';
    public float $pGHNo = 0;
    public float $pDu13 = 0;
    public float $pTlCkDs = 0;

    // Chi tiet hang hoa
    public array $pDetails = [];

    // Tong cong
    public float $pTSoLuong = 0;
    public float $pTTienNt2 = 0;
    public float $pTTien2 = 0;
    public float $pTCkNt = 0;
    public float $pTCk = 0;
    public float $pTThueNt = 0;
    public float $pTThue = 0;
    public float $pTTtNt = 0;
    public float $pTTt = 0;

    protected $rules = [
        'pMaKh' => 'required|string|max:20',
        'pNgayCt' => 'required|date',
    ];

    public function updatedPMaKh($value): void
    {
        // Lookup KH, dien thong tin, tinh du13
        $this->lookupKhachHang($value);
    }

    public function updatedPTyGia(): void
    {
        $this->recalculateAll();
    }

    public function updatedPDetails(): void
    {
        $this->recalculateAll();
    }

    public function recalculateAll(): void
    {
        // Tinh tong theo chi tiet
        foreach ($this->pDetails as &$detail) {
            $detail['tien_nt2'] = $detail['so_luong'] * $detail['gia_nt2'];
            $detail['tien_ck_nt'] = $detail['tien_nt2'] * $detail['tl_ck'] / 100;
            $detail['thue_gtgt_nt'] = ($detail['tien_nt2'] - $detail['tien_ck_nt']) * $detail['ts_gtgt'] / 100;
            $detail['gia2'] = $detail['gia_nt2'] * $this->pTyGia;
            $detail['tien2'] = $detail['tien_nt2'] * $this->pTyGia;
        }

        // Tinh tong
        $this->pTSoLuong = collect($this->pDetails)->sum('so_luong');
        $this->pTTienNt2 = collect($this->pDetails)->sum('tien_nt2');
        $this->pTCkNt = collect($this->pDetails)->sum('tien_ck_nt');
        $this->pTThueNt = collect($this->pDetails)->sum('thue_gtgt_nt');
        $this->pTTtNt = $this->pTTienNt2 - $this->pTCkNt + $this->pTThueNt;

        $this->pTTien2 = $this->pTTienNt2 * $this->pTyGia;
        $this->pTCk = $this->pTCkNt * $this->pTyGia;
        $this->pTThue = $this->pTThueNt * $this->pTyGia;
        $this->pTTt = $this->pTTtNt * $this->pTyGia;
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT
    }

    public function render(): View
    {
        return view('catalog::so.hoadonbanhang-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── hoadonbanhang/
│   ├── index.blade.php         (List page)
│   ├── edit.blade.php          (Edit page)
│   └── _detail-row.blade.php   (Detail row component)
```

### 6. Routes

```php
// routes/catalog.php
Route::prefix('catalog/so')
    ->name('catalog.so.')
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
| Model | laravel-simba | HT01.php | Hach toan |
| Model | laravel-simba | DMKH.php | Khach hang |
| Model | laravel-simba | DMVT.php | Vat tu |
| Model | laravel-simba | DMKHO.php | Kho |
| Model | laravel-simba | DMHTTT.php | HTTT |
| SP | laravel-simba | AsSOGetSO3.php | Get list |
| SP | laravel-simba | AsSOInsSO3.php | Insert |
| SP | laravel-simba | AsSOUpdSO3.php | Update |
| SP | laravel-simba | AsSODelSO3.php | Delete |
| Component | laravel-catalog | Hoadonbanhang.php | List |
| Component | laravel-catalog | HoadonbanhangEdit.php | Edit |
| Report | laravel-report | SOInvoice.rpt | In hoa don VAT |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model SO3, SO4, HT01
- [ ] Tao Livewire Hoadonbanhang (list)
- [ ] Tao Livewire HoadonbanhangEdit (form nhap lieu)
- [ ] Tao Views (list + edit + detail grid)
- [ ] Them Routes
- [ ] Test CRUD operations voi chi tiet
- [ ] Test tinh toan ty gia & chiet khau
- [ ] Test Integration voi DMKH, DMVT, DMKHO
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `banhang.so3`
- **Note:** Voucher/report/dictionary route shell; write execute chỉ mở khi payload audit đủ.
