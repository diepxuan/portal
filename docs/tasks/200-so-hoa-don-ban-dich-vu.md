# Task 200: SO-Hoa-Don-Ban-Dich-Vu

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang hoa don ban dich vu (SO5) tu .NET sang PHP Laravel, dat ket qua tuong duong SOVchSO5.

## Chi tiet
- **DLL:** SOVchSO5.dll
- **Chuc nang:** Hoa don ban dich vu (Service Invoice)
- **Loai:** Voucher (VCH)
- **Assembly Title:** Hoa don ban dich vu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO5

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO5.dll/README.md`

---

## Cau truc du lieu

### Bang: SO3 (Hoa don ban dich vu - Phan dau)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 20 | So thu tu record (khoa chinh) |
| ma_ct | varchar | 10 | Ma chung tu (SO5) |
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
| t_tien_nt2 | decimal | 18,2 | Tong tien hang NT |
| t_tien2 | decimal | 18,2 | Tong tien hang VND |
| t_ck_nt | decimal | 18,2 | Tong chiet khau NT |
| t_ck | decimal | 18,2 | Tong chiet khau VND |
| t_thue_nt | decimal | 18,2 | Tong thue GTGT NT |
| t_thue | decimal | 18,2 | Tong thue GTGT VND |
| t_tt_nt | decimal | 18,2 | Tong thanh toan NT |
| t_tt | decimal | 18,2 | Tong thanh toan VND |
| gh_no | decimal | 18,2 | Gioi han cong no |
| du13 | decimal | 18,2 | Du hien thoi cua KH |

**Luu y:** SO5 khong co `so_px` (phieu xuat kho) vi la dich vu, khong qua kho.

### Bang: SO4 (Hoa don ban dich vu - Chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma dich vu |
| ma_kho | varchar | - | Khong su dung trong SO5 |
| so_luong | decimal | So luong |
| gia_nt2 | decimal | Gia ban ngoai te |
| tien_nt2 | decimal | Tien hang NT |
| gia2 | decimal | Gia ban VND |
| tien2 | decimal | Tien hang VND |
| tl_ck | decimal | Ty le chiet khau |
| tien_ck_nt | decimal | Tien chiet khau NT |
| tien_ck | decimal | Tien chiet khau VND |
| ts_gtgt | decimal | Thue suat GTGT |
| thue_gtgt_nt | decimal | Thue GTGT NT |
| thue_gtgt | decimal | Thue GTGT VND |
| gia_nt | decimal | Gia ngoai te 1 |
| tien_nt | decimal | Tien ngoai te 1 |
| gia | decimal | Gia VND 1 |
| tien | decimal | Tien VND 1 |
| ma_nvkd | varchar | Ma nhan vien kinh doanh |

**Luu y:** Khong co `tk_vt` (TK kho) vi khong co hang hoa vat chat.

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

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | FK ma_kh |
| DMVT | Dich vu | FK ma_vt (loai=dich vu) |
| DMHTTT | Hinh thuc thanh toan | FK ma_httt |

---

## Form classes

### 1. frmSoVchSO5 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap hoa don ban dich vu
- **Controls:**

#### Thong tin chung

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang |
| lblTen_Kh | Label | ten_kh | Ten khach hang |
| txtTen_Kh | TextBox | ten_kh | Ten khach hang (editable) |
| txtDia_Chi_Vat | TextBox | dia_chi_vat | Dia chi xuat hoa don |
| txtNguoi_Gd | TextBox | nguoi_gd | Nguoi mua |
| txtMa_So_Thue | TextBox | ma_so_thue | Ma so thue |
| txtSo_Seri | TextBox | so_seri | So seri hoa don |
| txtSo_Ct | TextBox | so_ct | So hoa don |
| txtNgay_Ct | AsMaskedTextBox | ngay_ct | Ngay hoa don |
| cboMa_NT | AsComboBoxNT | ma_nt | Ma ngoai te |
| txtTy_Gia | AsTextNumeric | ty_gia | Ty gia |
| txtMa_Httt | AsTextBox | ma_httt | Ma hinh thuc thanh toan |
| txtTk_Pt | AsTextBox | tk_pt | TK phai thu |
| txtTk_Thue | AsTextBox | tk_thue | TK thue GTGT |
| chkSua_Ck | AsCheckBox | - | Cho phep sua chiet khau |
| chkSua_Thue | AsCheckBox | - | Cho phep sua thue |
| txtGh_No | AsTextNumeric | gh_no | Gioi han cong no |
| txtDu13 | AsTextNumeric | du13 | Du hien thoi KH |

#### TabControl

| Tab | Mo ta |
|-----|-------|
| tabDetail | Chi tiet dich vu |
| tabHach_Toan | Hach toan ke toan |

#### DataGridView (adgvDetail)

| Column | Type | DataField | Mo ta |
|--------|------|-----------|-------|
| dgvcMa_Vt | AsTextBox | ma_vt | Ma dich vu |
| dgvcTen_Vt | TextBox | ten_vt | Ten dich vu |
| dgvcDvt | TextBox | dvt | Don vi tinh |
| dgvcSo_Luong | AsTextNumeric | so_luong | So luong |
| dgvcGia_Nt2 | AsTextNumeric | gia_nt2 | Gia ban NT |
| dgvcTien_Nt2 | AsTextNumeric | tien_nt2 | Tien hang NT |
| dgvcTl_Ck | AsTextNumeric | tl_ck | Ty le CK |
| dgvcTien_Ck_Nt | AsTextNumeric | tien_ck_nt | Tien CK NT |
| dgvcTs_Gtgt | AsTextNumeric | ts_gtgt | Thue suat GTGT |
| dgvcThue_Gtgt_Nt | AsTextNumeric | thue_gtgt_nt | Thue NT |
| dgvcGia2 | AsTextNumeric | gia2 | Gia VND |
| dgvcTien2 | AsTextNumeric | tien2 | Tien VND |
| dgvcMa_Nvkd | AsTextBox | ma_nvkd | Ma NVKD |

#### Tong cong

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtT_Tien_Nt2 | AsTextNumeric | t_tien_nt2 | Tong tien NT |
| txtT_Tien2 | AsTextNumeric | t_tien2 | Tong tien VND |
| txtT_Ck_Nt | AsTextNumeric | t_ck_nt | Tong CK NT |
| txtT_Ck | AsTextNumeric | t_ck | Tong CK VND |
| txtT_Thue_Nt | AsTextNumeric | t_thue_nt | Tong thue NT |
| txtT_Thue | AsTextNumeric | t_thue | Tong thue VND |
| txtT_Tt_Nt | AsTextNumeric | t_tt_nt | Tong thanh toan NT |
| txtT_Tt | AsTextNumeric | t_tt | Tong thanh toan VND |

### 2. frmSoVchSO5Find (Form tim kiem)
- **Ke thua:** frmVoucherFind

### 3. frmSoVchSo5Print (Form in bao gia)
- **Ke thua:** frmVoucherPrint

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO5_GET | Lay danh sach hoa don dich vu |
| SP_SO5_GETBYID | Lay chi tiet 1 hoa don |
| SP_SO5_INSERT | Them hoa don dich vu |
| SP_SO5_UPDATE | Cap nhat hoa don dich vu |
| SP_SO5_DELETE | Xoa hoa don dich vu |
| SP_SO5_FIND | Tim kiem hoa don |
| SP_SO5_CHECK | Kiem tra trung so hoa don |

### SP_GET (reference)

```sql
EXEC SP_SO5_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_ct VARCHAR(10) = 'SO5',
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL,
    @pMa_kh VARCHAR(20) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
EXEC SP_SO5_INSERT
    @pMa_cty VARCHAR(50),
    @pStt_rec VARCHAR(20) OUTPUT,
    @pMa_ct VARCHAR(10) = 'SO5',
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
    @pT_tien_nt2 DECIMAL(18,2),
    @pT_tien2 DECIMAL(18,2),
    @pT_ck_nt DECIMAL(18,2),
    @pT_ck DECIMAL(18,2),
    @pT_thue_nt DECIMAL(18,2),
    @pT_thue DECIMAL(18,2),
    @pT_tt_nt DECIMAL(18,2),
    @pT_tt DECIMAL(18,2),
    @pGh_no DECIMAL(18,2),
    @pDu13 DECIMAL(18,2),
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
| Required | ngay_ct | 'Ngay hoa don khong duoc trong' |

### Business Rules

1. **Sau khi chon KH (txtMa_Kh.AfterCodeValidating)**:
   - Dien ten_kh, dia_chi_vat, ma_so_thue, nguoi_gd
   - Lay ma_httt, hinh thuc TT, TK phai thu, TK thue
   - Tinh du13 (du hien thoi)
   - Hien thi gh_no

2. **Tinh toan chi tiet** (khong co TK kho vi la dich vu):
   ```csharp
   Tien_Nt2 = So_Luong * Gia_Nt2
   Tien2 = Tien_Nt2 * Ty_Gia
   Tien_Ck_Nt = Tien_Nt2 * Tl_Ck / 100
   Thue_Gtgt_Nt = (Tien_Nt2 - Tien_Ck_Nt) * Ts_Gtgt / 100
   ```

3. **Checkbox chinh sua**:
   - `chkSua_Ck`: Cho phep sua tien chiet khau thu cong (khac voi SO3)
   - `chkSua_Thue`: Cho phep sua thue thu cong (khac voi SO3)

4. **Hach toan ke toan** (khong co kho):
   | Nợ | Có | Số tiền |
   |----|----|---------|
   | TK Phải thu KH | | T_Tt |
   | | TK Doanh thu DV | T_Tien2 |
   | | TK Thuế GTGT | T_Thue |

5. **Dac diem so voi SO3**:

   | Dac diem | SO3 (Hang hoa) | SO5 (Dich vu) |
   |----------|----------------|----------------|
   | Quan ly kho | Co | Khong |
   | Ton kho | Co | Khong |
   | TK gia von | Co | Khong |
   | TK vat tu | Co | Khong |
   | Chinh sua chiet khau | Khong | Co |
   | Chinh sua thue | Khong | Co |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/SO3SO5.php
namespace Diepxuan\Simba\Models\SO;

class SO3SO5 extends Model
{
    protected $table = 'SO3';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const MA_CT = 'SO5';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct', 'so_seri',
        'ma_kh', 'ten_kh', 'dia_chi_vat', 'ma_so_thue', 'nguoi_gd',
        'ma_httt', 'ma_nt', 'ty_gia', 'tk_pt', 'tk_thue',
        't_tien_nt2', 't_tien2', 't_ck_nt', 't_ck',
        't_thue_nt', 't_thue', 't_tt_nt', 't_tt',
        'gh_no', 'du13',
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
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetSO5.php
class AsSOGetSO5 extends StoredProcedure
{
    protected $procedure = 'SP_SO5_GET';
    protected $params = [
        'pMa_cty', 'pMa_ct', 'pNgay1', 'pNgay2',
        'pMa_kh', 'pSearch', 'pPageIndex', 'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsSO5.php
class AsSOInsSO5 extends StoredProcedure
{
    protected $procedure = 'SP_SO5_INSERT';
    protected $params = [
        'pMa_cty', 'pStt_rec', 'pMa_ct', 'pNgay_ct', 'pSo_Ct',
        'pSo_Seri', 'pMa_kh', 'pTen_kh', 'pDia_chi_vat',
        'pMa_so_thue', 'pNguoi_gd', 'pMa_httt', 'pMa_nt',
        'pTy_gia', 'pTk_pt', 'pTk_thue',
        'pT_tien_nt2', 'pT_tien2', 'pT_ck_nt', 'pT_ck',
        'pT_thue_nt', 'pT_thue', 'pT_tt_nt', 'pT_tt',
        'pGh_no', 'pDu13',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetSO5Detail.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdSO5.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelSO5.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Hoadonbandichvu.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Hoadonbandichvu;

class Hoadonbandichvu extends Component
{
    const MA_CT = 'SO5';

    public Collection $pHoaDons;
    public string $pSearch = '';
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public int $pPageIndex = 1;

    public function mount(): void
    {
        $this->loadHoaDon();
    }

    public function render(): View
    {
        return view('catalog::so.hoadonbandichvu');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/HoadonbandichvuEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\HoadonbandichvuEdit;

class HoadonbandichvuEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pMaCt = 'SO5';
    public string $pSoCt = '';
    public ?string $pNgayCt = null;
    public string $pMaKh = '';
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public bool $pSuaCk = false;
    public bool $pSuaThue = false;
    public float $pGHNo = 0;
    public float $pDu13 = 0;

    public array $pDetails = [];

    public float $pTTienNt2 = 0;
    public float $pTCkNt = 0;
    public float $pTThueNt = 0;
    public float $pTTtNt = 0;

    public function updatedPMaKh($value): void
    {
        $this->lookupKhachHang($value);
    }

    public function recalculate(): void
    {
        foreach ($this->pDetails as &$d) {
            $d['tien_nt2'] = $d['so_luong'] * $d['gia_nt2'];
            $d['tien_ck_nt'] = $d['tien_nt2'] * ($d['tl_ck'] ?? 0) / 100;
            $d['thue_gtgt_nt'] = ($d['tien_nt2'] - $d['tien_ck_nt']) * ($d['ts_gtgt'] ?? 0) / 100;
            $d['gia2'] = $d['gia_nt2'] * $this->pTyGia;
            $d['tien2'] = $d['tien_nt2'] * $this->pTyGia;
        }

        $this->pTTienNt2 = collect($this->pDetails)->sum('tien_nt2');
        $this->pTCkNt = collect($this->pDetails)->sum('tien_ck_nt');
        $this->pTThueNt = collect($this->pDetails)->sum('thue_gtgt_nt');
        $this->pTTtNt = $this->pTTienNt2 - $this->pTCkNt + $this->pTThueNt;
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT/SO5_UPDATE
    }

    public function render(): View
    {
        return view('catalog::so.hoadonbandichvu-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── hoadonbandichvu/
│   ├── index.blade.php
│   ├── edit.blade.php
│   └── _detail-row.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/hoa-don-dich-vu', [Hoadonbandichvu::class, 'render'])
            ->name('hoadonbandichvu');
        Route::get('/hoa-don-dich-vu/edit/{sttRec?}', [HoadonbandichvuEdit::class, 'render'])
            ->name('hoadonbandichvu.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SO3.php (SO5) | Chinh |
| Model | laravel-simba | SO4.php | Chi tiet (khong co kho) |
| Model | laravel-simba | HT01.php | Hach toan |
| Model | laravel-simba | DMKH.php | Khach hang |
| Model | laravel-simba | DMVT.php | Dich vu (loai=dich vu) |
| SP | laravel-simba | AsSOGetSO5.php | Get list |
| SP | laravel-simba | AsSOInsSO5.php | Insert |
| SP | laravel-simba | AsSOGetSO5Detail.php | Get detail |
| SP | laravel-simba | AsSOUpdSO5.php | Update |
| SP | laravel-simba | AsSODelSO5.php | Delete |
| Component | laravel-catalog | Hoadonbandichvu.php | List |
| Component | laravel-catalog | HoadonbandichvuEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model SO3 (SO5), SO4, HT01
- [ ] Tao Livewire Hoadonbandichvu (list)
- [ ] Tao Livewire HoadonbandichvuEdit (form nhap lieu)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations (dich vu, khong kho)
- [ ] Test tinh nang sua CK va sua thue
- [ ] Test Integration voi DMVT (dich vu)