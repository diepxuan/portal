# Task 198: SO-Hoa-Don-Ban-Hang-Undercore

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang hoa don ban hang (SO3 - variant voi find forms) tu .NET sang PHP Laravel, dat ket qua tuong duong SOVchSO3_.

## Chi tiet
- **DLL:** SOVchSO3_.dll
- **Chuc nang:** Hoa don ban hang (Sales Invoice) - Extended version
- **Loai:** Voucher (VCH)
- **Assembly Title:** Hoa don ban hang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO3

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO3_.dll/README.md`

---

## Cau truc du lieu

### Bang: SO3 (Hoa don ban hang - Phan dau)

Giong nhu task 197, bo sung them:

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu record (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (SO3) |
| ngay_ct | datetime | 8 | Ngay chung tu |
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
| chkGia_dd | bit | 1 | Ho tro gia dac biet |

### Bang: SO4 (Hoa don ban hang - Chi tiet)

Giong nhu task 197, bo sung cac truong them:

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ma_kho | varchar | Ma kho |
| so_luong | decimal | So luong |
| gia_nt2 | decimal | Gia ban ngoai te |
| tien_nt2 | decimal | Tien hang NT |
| gia2 | decimal | Gia ban VND |
| tien2 | decimal | Tien hang VND |
| tl_ck | decimal | Ty le chiet khau |
| tien_ck_nt | decimal | Tien chiet khau NT |
| tien_ck | decimal | Tien chiet khau VND |
| ma_thue | varchar | Ma thue |
| ts_gtgt | decimal | Thue suat GTGT |
| thue_gtgt_nt | decimal | Thue GTGT NT |
| thue_gtgt | decimal | Thue GTGT VND |
| gia_nt | decimal | Gia ngoai te 1 |
| tien_nt | decimal | Tien ngoai te 1 |
| gia | decimal | Gia VND 1 |
| tien | decimal | Tien VND 1 |
| ma_nvkd | varchar | Ma nhan vien kinh doanh |
| tk_dt | varchar | TK doanh thu |
| tk_gv | varchar | TK gia von |
| tk_vt | varchar | TK kho |
| tk_ck | varchar | TK chiet khau |

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

---

## Form classes

### 1. frmSoVchSO3 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap hoa don ban hang - Extended version voi find forms
- **Controls:** Giong task 197, bo sung them:
  - `chkGia_dd` - Checkbox ho tro gia dac biet

### 2. frmSoVchSO3Find (Form tim kiem)
- **Ke thua:** frmVoucherFind
- **Chuc nang:** Tim kiem hoa don

### 3. frmSoVchSo3FindSO1 (Form tim kiem don hang SO1)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Tim kiem don hang SO1 de tao hoa don

### 4. frmSoVchSO3SeachSO1 (Form tim kiem chi tiet don hang SO1)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Hien thi chi tiet don hang SO1 da tim kiem

### 5. frmSoVchSo3ViewCrystal (Form xem bao cao Crystal)
- **Ke thua:** Form
- **Chuc nang:** Xem/in bao cao hoa don qua Crystal Reports

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO3_GET | Lay danh sach hoa don |
| SP_SO3_GETBYID | Lay chi tiet 1 hoa don |
| SP_SO3_INSERT | Them hoa don |
| SP_SO3_UPDATE | Cap nhat hoa don |
| SP_SO3_DELETE | Xoa hoa don |
| SP_SO3_FIND | Tim kiem hoa don |
| SP_SO3_CHECK | Kiem tra trung so hoa don |

### SP_GET (reference)

```sql
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

### SP_INSERT (reference - bo sung)

```sql
-- Them hoa don ban hang (bo sung gia dac biet)
EXEC SP_SO3_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20) OUTPUT,
    @pMa_ct VARCHAR(10),
    @pNgay_ct DATETIME,
    @pSo_Ct VARCHAR(20),
    @pSo_Seri VARCHAR(20),
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
    @pTl_ck_ds DECIMAL(5,2),
    @pGh_no DECIMAL(18,2),
    @pDu13 DECIMAL(18,2),
    @pChkGia_dd BIT = 0,
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

1. **AfterCodeValidating (txtMa_Kh)**:
   - Dien thong tin KH: ten_kh, dia_chi_vat, ma_so_thue, nguoi_gd
   - Lay ma_httt, hinh thuc TT, TK phai thu, TK thue
   - Tinh du13 (du hien thoi cua KH)
   - Kiem tra gh_no vs du13

2. **AfterCodeValidating (txtMa_Httt)**:
   - Lay tk_pt (TK phai thu)
   - Lay tk_thue (TK thue GTGT)
   - Lay tk_ck_ds (TK chiet khau doanh so)

3. **Gia dac biet (chkGia_dd)**:
   - Khi bat checkbox gia dac biet, cho phep nhap gia khac voi gia mac dinh
   - Ap dung gia tu bang gia dac biet (bang GIA_DD)

4. **Tinh toan chi tiet**:
   ```csharp
   // Tinh tien hang
   Tien_Nt2 = So_Luong * Gia_Nt2
   Tien2 = Tien_Nt2 * Ty_Gia

   // Tinh chiet khau mat hang
   Tien_Ck_Nt = Tien_Nt2 * Tl_Ck / 100

   // Tinh thue GTGT
   Thue_Gtgt_Nt = (Tien_Nt2 - Tien_Ck_Nt) * Ts_Gtgt / 100

   // Tinh CK doanh so
   T_Ck_Ds_Nt = T_Tien_Nt2 * Tl_Ck_Ds / 100
   ```

5. **Chon don hang (frmSoVchSo3FindSO1)**:
   - Tim kiem don hang SO1 chua xuat hoan toan
   - Hien thi chi tiet hang hoa tu don hang
   - Tu dong dien thong tin vao hoa don

6. **Hach toan ke toan**:
   | Nợ | Có | Số tiền |
   |----|----|---------|
   | TK Phải thu KH | | T_Tt |
   | | TK Doanh thu | T_Tien2 |
   | | TK Thuế GTGT | T_Thue |
   | TK Giá vốn | | T_Tien |
   | | TK Kho | T_Tien |

7. **In hoa don (Crystal Reports)**:
   - frmSoVchSo3ViewCrystal de xem va in hoa don VAT
   - Ho tro nhieu layout theo mau so hoa don

---

## Mapping PHP

### 1. Model (reuse tu task 197)

```php
// app/Models/SO/SO3.php (reuse)
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
        'chk_gia_dd',
    ];

    public function details()
    {
        return $this->hasMany(SO4::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function hachToans()
    {
        return $this->hasMany(HT01::class, 'stt_rec', 'stt_rec');
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

// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetSO3Detail.php
class AsSOGetSO3Detail extends StoredProcedure
{
    protected $procedure = 'SP_SO3_GETBYID';
    protected $params = ['pMa_cty', 'pStt_rec'];
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
        'pTl_ck_ds', 'pGh_no', 'pDu13', 'pChkGia_dd',
    ];
}
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/HoadonbanhangV.php
namespace Diepxuan\Catalog\Http\Livewire\SO\HoadonbanhangV;

class HoadonbanhangV extends Component
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
        return view('catalog::so.hoadonbanhang-v');
    }
}
```

### 4. Livewire Component (Find - Tim kiem don hang)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/HoadonbanhangFindSO1.php
namespace Diepxuan\Catalog\Http\Livewire\SO\HoadonbanhangFindSO1;

class HoadonbanhangFindSO1 extends Component
{
    public Collection $pDonHangs;
    public string $pSearch = '';
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;

    public function loadDonHang(): void
    {
        // Tim kiem don hang SO1 chua xuat hoan toan
    }

    public function selectDonHang(string $sttRec): void
    {
        // Emit event chon don hang
        $this->emit('donHangSelected', $sttRec);
    }

    public function render(): View
    {
        return view('catalog::so.hoadonbanhang-find-so1');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── hoadonbanhang-v/
│   ├── index.blade.php         (List page - extended)
│   ├── edit.blade.php          (Edit page)
│   └── find-so1.blade.php      (Find SO1 modal)
```

### 6. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/hoa-don-ban-hang-v', [HoadonbanhangV::class, 'render'])
            ->name('hoadonbanhangv');
        Route::get('/hoa-don-ban-hang-v/edit/{sttRec?}', [HoadonbanhangVEdit::class, 'render'])
            ->name('hoadonbanhangv.edit');
        Route::get('/hoa-don-ban-hang-v/find-so1', [HoadonbanhangFindSO1::class, 'render'])
            ->name('hoadonbanhangv.find-so1');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SO3.php | Chinh (bo sung chk_gia_dd) |
| Model | laravel-simba | SO4.php | Chi tiet |
| Model | laravel-simba | HT01.php | Hach toan |
| Model | laravel-simba | SO1.php | Don hang (FK tu lookup) |
| Model | laravel-simba | SO2.php | Don hang chi tiet |
| SP | laravel-simba | AsSOGetSO3.php | Get list |
| SP | laravel-simba | AsSOInsSO3.php | Insert (bo sung) |
| SP | laravel-simba | AsSOUpdSO3.php | Update |
| SP | laravel-simba | AsSODelSO3.php | Delete |
| Component | laravel-catalog | HoadonbanhangV.php | List |
| Component | laravel-catalog | HoadonbanhangVEdit.php | Edit |
| Component | laravel-catalog | HoadonbanhangFindSO1.php | Find SO1 |
| Component | laravel-catalog | HoadonbanhangViewCrystal.php | View report |
| Report | laravel-report | SOInvoice.rpt | In hoa don VAT |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model SO3 (bo sung chk_gia_dd), SO4, HT01
- [ ] Tao Livewire HoadonbanhangV (list - extended)
- [ ] Tao Livewire HoadonbanhangVEdit (form nhap lieu)
- [ ] Tao Livewire HoadonbanhangFindSO1 (form tim kiem don hang)
- [ ] Tao Views (list + edit + find-so1)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test tinh nang chon don hang SO1