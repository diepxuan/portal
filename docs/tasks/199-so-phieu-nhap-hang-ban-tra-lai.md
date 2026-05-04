# Task 199: SO-Phieu-Nhap-Hang-Ban-Tra-Lai

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang phieu nhap hang ban tra lai (SO4) tu .NET sang PHP Laravel, dat ket qua tuong duong SOVchSO4.

## Chi tiet
- **DLL:** SOVchSO4.dll
- **Chuc nang:** Phieu nhap hang ban bi tra lai (Return Purchase Invoice)
- **Loai:** Voucher (VCH)
- **Assembly Title:** Phieu nhap hang ban bi tra lai
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO4

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO4.dll/README.md`

---

## Cau truc du lieu

### Bang: SO3 (Phieu nhap tra lai - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu record (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (SO4) |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 20 | So phieu nhap |
| so_seri | varchar | 20 | So seri |
| ma_kh | varchar | 20 | Ma khach hang tra hang |
| ten_kh | nvarchar | 255 | Ten khach hang |
| dia_chi_vat | nvarchar | 500 | Dia chi |
| ma_so_thue | varchar | 20 | Ma so thue |
| nguoi_gd | nvarchar | 100 | Nguoi giao hang |
| ma_httt | varchar | 20 | Ma hinh thuc thanh toan |
| ma_nt | varchar | 3 | Ma ngoai te |
| ty_gia | decimal | 18,2 | Ty gia |
| tk_pt | varchar | 20 | Tai khoan phai tra |
| tk_thue | varchar | 20 | Tai khoan thue GTGT |
| so_hd | varchar | 20 | So hoa don goc |
| ngay_hd | datetime | 8 | Ngay hoa don goc |
| t_tien_nt2 | decimal | 18,2 | Tong tien hang NT |
| t_tien2 | decimal | 18,2 | Tong tien hang VND |
| t_thue_nt | decimal | 18,2 | Tong thue GTGT NT |
| t_thue | decimal | 18,2 | Tong thue GTGT VND |
| t_tt_nt | decimal | 18,2 | Tong thanh toan NT |
| t_tt | decimal | 18,2 | Tong thanh toan VND |

### Bang: SO4 (Phieu nhap tra lai - Chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ma_kho | varchar | Ma kho nhap |
| so_luong | decimal | So luong tra lai |
| gia_nt2 | decimal | Gia ngoai te |
| tien_nt2 | decimal | Tien hang NT |
| ts_gtgt | decimal | Thue suat GTGT |
| thue_gtgt_nt | decimal | Thue GTGT NT |
| gia2 | decimal | Gia VND |
| tien2 | decimal | Tien hang VND |
| thue_gtgt | decimal | Thue GTGT VND |
| gia_nt | decimal | Gia ngoai te 1 |
| tien_nt | decimal | Tien ngoai te 1 |
| gia | decimal | Gia VND 1 |
| tien | decimal | Tien VND 1 |
| ma_nvkd | varchar | Ma nhan vien kinh doanh |

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

### Bang: TAIN (Thue dau vao)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_thue | varchar | Ma thue |
| ts_gtgt | decimal | Thue suat GTGT |
| tien_nt | decimal | Tien hang NT |
| thue_nt | decimal | Tien thue NT |
| tien | decimal | Tien hang VND |
| thue | decimal | Tien thue VND |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| SO3 (SO3) | Hoa don ban hang goc | FK so_hd, ngay_hd |
| SO4 (SO2/SO3) | Chi tiet hoa don goc | Lookup de lay gia |
| DMKH | Khach hang | FK ma_kh -> DMKH |
| DMKHO | Kho | FK ma_kho -> DMKHO |
| DMVT | Vat tu | FK ma_vt -> DMVT |

---

## Form classes

### 1. frmSoVchSO4 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap phieu nhap hang tra lai
- **Controls:**

#### Thong tin chung

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang tra hang |
| lblTen_Kh | Label | ten_kh | Ten khach hang |
| txtTen_Kh | TextBox | ten_kh | Ten khach hang |
| txtDia_Chi_Vat | TextBox | dia_chi_vat | Dia chi |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi giao hang |
| txtMa_So_Thue | TextBox | ma_so_thue | Ma so thue |
| txtSo_Seri | TextBox | so_seri | So seri |
| txtSo_Ct | TextBox | so_ct | So phieu nhap |
| txtNgay_Ct | AsMaskedTextBox | ngay_ct | Ngay phieu nhap |
| txtNgay_Lct | AsMaskedTextBox | ngay_ct | Ngay lap chung tu |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtMa_Httt | AsTextBox | ma_httt | Hinh thuc thanh toan |
| txtTk_Pt | AsTextBox | tk_pt | TK phai tra |
| txtTk_Thue | AsTextBox | tk_thue | TK thue |
| txtSo_Hd | TextBox | so_hd | So hoa don goc |
| txtNgay_Hd | AsMaskedTextBox | ngay_hd | Ngay hoa don goc |
| chkSua_Thue | AsCheckBox | - | Cho phep sua thue |
| chkSua_Tien | AsCheckBox | - | Cho phep sua tien |

#### TabControl

| Tab | Mo ta |
|-----|-------|
| tabDetail | Chi tiet hang tra lai |
| tabTain | Thong tin thue dau vao |
| tabHach_Toan | Hach toan ke toan |

#### DataGridView (adgvDetail)

| Column | Type | DataField | Mo ta |
|--------|------|-----------|-------|
| dgvcMa_Vt | AsTextBox | ma_vt | Ma vat tu |
| dgvcTen_Vt | TextBox | ten_vt | Ten vat tu |
| dgvcDvt | TextBox | dvt | Don vi tinh |
| dgvcMa_Kho | AsTextBox | ma_kho | Ma kho nhap |
| dgvcSo_Luong | AsTextNumeric | so_luong | So luong tra lai |
| dgvcGia_Nt2 | AsTextNumeric | gia_nt2 | Gia NT |
| dgvcTien_Nt2 | AsTextNumeric | tien_nt2 | Tien NT |
| dgvcTs_Gtgt | AsTextNumeric | ts_gtgt | Thue suat |
| dgvcThue_Gtgt_Nt | AsTextNumeric | thue_gtgt_nt | Thue NT |
| dgvcGia2 | AsTextNumeric | gia2 | Gia VND |
| dgvcTien2 | AsTextNumeric | tien2 | Tien VND |
| dgvcMa_Nvkd | AsTextBox | ma_nvkd | Ma NVKD |

#### Tong cong

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtT_So_Luong | AsTextNumeric | - | Tong so luong |
| txtT_Tien_Nt2 | AsTextNumeric | t_tien_nt2 | Tong tien NT |
| txtT_Tien2 | AsTextNumeric | t_tien2 | Tong tien VND |
| txtT_Thue_Nt | AsTextNumeric | t_thue_nt | Tong thue NT |
| txtT_Thue | AsTextNumeric | t_thue | Tong thue VND |
| txtT_Tt_Nt | AsTextNumeric | t_tt_nt | Tong thanh toan NT |
| txtT_Tt | AsTextNumeric | t_tt | Tong thanh toan VND |

### 2. frmSoVchSO4Find (Form tim kiem)
- **Ke thua:** frmVoucherFind

### 3. frmSoVchSo4FindSO2, frmSoVchSo4FindSO3 (Tim hoa don goc)
- **Ke thua:** frmAsiaRoot

### 4. frmSoVchSO4SeachSO2SO3 (Tim chi tiet hoa don goc)
- **Ke thua:** frmAsiaRoot

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO4_GET | Lay danh sach phieu nhap tra lai |
| SP_SO4_GETBYID | Lay chi tiet 1 phieu nhap |
| SP_SO4_INSERT | Them phieu nhap tra lai |
| SP_SO4_UPDATE | Cap nhat phieu nhap tra lai |
| SP_SO4_DELETE | Xoa phieu nhap tra lai |
| SP_SO4_FIND | Tim kiem phieu nhap tra lai |
| SP_SO4_CHECK | Kiem tra trung so phieu |

### SP_GET (reference)

```sql
EXEC SP_SO4_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_ct VARCHAR(10) = 'SO4',
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL,
    @pMa_kh VARCHAR(20) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
EXEC SP_SO4_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20) OUTPUT,
    @pMa_ct VARCHAR(10) = 'SO4',
    @pNgay_ct DATETIME,
    @pSo_Ct VARCHAR(20),
    @pSo_Seri VARCHAR(20),
    @pMa_kh VARCHAR(20),
    @pTen_kh NVARCHAR(255),
    @pMa_httt VARCHAR(20),
    @pMa_nt VARCHAR(3),
    @pTy_gia DECIMAL(18,2),
    @pTk_pt VARCHAR(20),
    @pTk_thue VARCHAR(20),
    @pSo_hd VARCHAR(20),
    @pNgay_hd DATETIME,
    @pT_tien_nt2 DECIMAL(18,2),
    @pT_tien2 DECIMAL(18,2),
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
| Required | so_ct | 'So phieu nhap khong duoc trong' |
| Required | ngay_ct | 'Ngay phieu nhap khong duoc trong' |

### Business Rules

1. **Chon hoa don goc (SO2/SO3)**:
   - Tim kiem hoa don SO2 (hoa don thong thuong) hoac SO3 (hoa don VAT)
   - Kiem tra so luong tra lai khong vuot so luong da ban

2. **Sau khi chon hoa don goc**:
   - Dien thong tin KH tu hoa don goc
   - Dien chi tiet hang hoa tu hoa don goc (gia goc)
   - Tinh lai tien hang, thue theo so luong tra lai

3. **Kiem tra so luong tra lai**:
   - So luong tra lai <= So luong con lai chua tra (da ban - da tra)
   - Neu vuot qua: canh bao nguoi dung

4. **Hach toan ke toan** (nguoc lai voi hoa don ban):
   | Nợ | Có | Số tiền |
   |----|----|---------|
   | TK Phải trả KH | | T_Tt |
   | TK Doanh thu | | T_Tien2 (giam) |
   | TK Thuế GTGT | | T_Thue (giam) |
   | TK Kho | | T_Tien |
   | | TK Giá vốn | T_Tien |

5. **Tab thue dau vao (tabTain)**:
   - Su dung ctlTaIn control
   - Tu dong tao chung tu thue dau vao
   - Dieu chinh thue GTGT (giam thue dau vao)

6. **Checkbox chinh sua**:
   - `chkSua_Thue`: Cho phep sua tien thue thu cong
   - `chkSua_Tien`: Cho phep sua tien thang thu cong

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/SO3SO4.php
namespace Diepxuan\Simba\Models\SO;

class SO3SO4 extends Model
{
    protected $table = 'SO3';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const MA_CT = 'SO4';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct', 'so_seri',
        'ma_kh', 'ten_kh', 'dia_chi_vat', 'ma_so_thue', 'nguoi_gd',
        'ma_httt', 'ma_nt', 'ty_gia', 'tk_pt', 'tk_thue',
        'so_hd', 'ngay_hd',
        't_tien_nt2', 't_tien2', 't_thue_nt', 't_thue',
        't_tt_nt', 't_tt',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ngay_hd' => 'datetime',
        'ty_gia' => 'decimal:2',
    ];

    public function details()
    {
        return $this->hasMany(SO4::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function thueDauVao()
    {
        return $this->hasMany(TAIN::class, 'stt_rec', 'stt_rec');
    }

    public function hachToans()
    {
        return $this->hasMany(HT01::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetSO4.php
class AsSOGetSO4 extends StoredProcedure
{
    protected $procedure = 'SP_SO4_GET';
    protected $params = [
        'pMa_cty', 'pMa_ct', 'pNgay1', 'pNgay2',
        'pMa_kh', 'pSearch', 'pPageIndex', 'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsSO4.php
class AsSOInsSO4 extends StoredProcedure
{
    protected $procedure = 'SP_SO4_INSERT';
    protected $params = [
        'pMa_cty', 'pStt_rec', 'pMa_ct', 'pNgay_ct', 'pSo_Ct',
        'pSo_Seri', 'pMa_kh', 'pTen_kh', 'pMa_httt',
        'pMa_nt', 'pTy_gia', 'pTk_pt', 'pTk_thue',
        'pSo_hd', 'pNgay_hd',
        'pT_tien_nt2', 'pT_tien2', 'pT_thue_nt', 'pT_thue',
        'pT_tt_nt', 'pT_tt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetSO4Detail.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdSO4.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelSO4.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Phieunhapkhotralai.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Phieunhapkhotralai;

class Phieunhapkhotralai extends Component
{
    const MA_CT = 'SO4';

    public Collection $pPhieuNhaps;
    public string $pSearch = '';
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public int $pPageIndex = 1;

    public function mount(): void
    {
        $this->loadPhieuNhap();
    }

    public function loadPhieuNhap(): void
    {
        // Load tu SP_SO4_GET
    }

    public function render(): View
    {
        return view('catalog::so.phieunhapkhotralai');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/PhieunhapkhotralaiEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\PhieunhapkhotralaiEdit;

class PhieunhapkhotralaiEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pMaCt = 'SO4';
    public string $pSoCt = '';
    public ?string $pNgayCt = null;
    public string $pMaKh = '';
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public string $pSoHd = '';
    public ?string $pNgayHd = null;
    public bool $pSuaThue = false;
    public bool $pSuaTien = false;

    public array $pDetails = [];
    public array $pThueDauVaos = [];

    // Tong
    public float $pTTienNt2 = 0;
    public float $pTThueNt = 0;
    public float $pTTtNt = 0;

    public function mount(?string $sttRec = null): void
    {
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadPhieuNhap();
        }
    }

    public function loadFromHD(string $sttRecHD, string $maCtHD): void
    {
        // Load hoa don goc (SO2/SO3), dien thong tin va chi tiet
    }

    public function recalculate(): void
    {
        foreach ($this->pDetails as &$d) {
            $d['tien_nt2'] = $d['so_luong'] * $d['gia_nt2'];
            $d['thue_gtgt_nt'] = $d['tien_nt2'] * $d['ts_gtgt'] / 100;
            $d['gia2'] = $d['gia_nt2'] * $this->pTyGia;
            $d['tien2'] = $d['tien_nt2'] * $this->pTyGia;
        }
        $this->pTTienNt2 = collect($this->pDetails)->sum('tien_nt2');
        $this->pTThueNt = collect($this->pDetails)->sum('thue_gtgt_nt');
        $this->pTTtNt = $this->pTTienNt2 + $this->pTThueNt;
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT/SO4_UPDATE
    }

    public function render(): View
    {
        return view('catalog::so.phieunhapkhotralai-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── phieunhapkhotralai/
│   ├── index.blade.php
│   ├── edit.blade.php
│   └── _detail-row.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/phieu-nhap-tra-lai', [Phieunhapkhotralai::class, 'render'])
            ->name('phieunhapkhotralai');
        Route::get('/phieu-nhap-tra-lai/edit/{sttRec?}', [PhieunhapkhotralaiEdit::class, 'render'])
            ->name('phieunhapkhotralai.edit');
        Route::get('/phieu-nhap-tra-lai/find-hd', [FindHoadonGoc::class, 'render'])
            ->name('phieunhapkhotralai.find-hd');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SO3.php (SO4) | Chinh |
| Model | laravel-simba | SO4.php | Chi tiet |
| Model | laravel-simba | TAIN.php | Thue dau vao |
| Model | laravel-simba | HT01.php | Hach toan |
| Model | laravel-simba | DMKH.php | Khach hang |
| Model | laravel-simba | DMVT.php | Vat tu |
| SP | laravel-simba | AsSOGetSO4.php | Get list |
| SP | laravel-simba | AsSOInsSO4.php | Insert |
| SP | laravel-simba | AsSOGetSO4Detail.php | Get detail |
| Component | laravel-catalog | Phieunhapkhotralai.php | List |
| Component | laravel-catalog | PhieunhapkhotralaiEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete)
- [ ] Tao Model SO3 (SO4), SO4, TAIN, HT01
- [ ] Tao Livewire Phieunhapkhotralai (list)
- [ ] Tao Livewire PhieunhapkhotralaiEdit (form nhap lieu)
- [ ] Tao Livewire FindHoadonGoc (tim hoa don goc SO2/SO3)
- [ ] Tao Views (list + edit + find form)
- [ ] Them Routes
- [ ] Test chon hoa don goc va lay thong tin
- [ ] Test tinh toan thue & hach toan nguoc