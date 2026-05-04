# Task 030: CA4 - Phieu bao no ngan hang

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | CAVchCA4.dll |
| **Module** | CA (Cash - Tien mat & ngan hang) |
| **Loai** | Voucher (Phieu chi - UNC) |
| **Trang thai** | Da hoan thanh |

## Muc tieu

Chuyen doi chuc nang quan ly Phieu bao no ngan hang (CA4) tu .NET sang PHP Laravel.

## Chi tiet

- **Chuc nang:** Quan ly phieu bao no ngan hang (Uy nhiem chi)
- **Ma_chung_tu:** CA4
- **Assembly Title:** CAVchCA4
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Cau truc du lieu

### Bang: CaPh2 (Master - Dung chung cho CA2 va CA4)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_cty | nvarchar | 10 | Ma cong ty |
| stt_rec | nvarchar | 20 | So thu tu record (PK) |
| ma_ct | nvarchar | 3 | Ma chung tu (CA4) |
| so_ct | nvarchar | 12 | So chung tu |
| ngay_ct | smalldatetime | 4 | Ngay chung tu |
| ngay_lct | smalldatetime | 4 | Ngay lap chung tu |
| kht_tain | bit | 1 | Co thue dau vao (0 = khong) |
| ma_kh | nvarchar | 20 | Ma khach hang |
| dia_chi | nvarchar | 255 | Dia chi |
| nguoi_gd | nvarchar | 30 | Nguoi giao dich |
| dien_giai | nvarchar | 255 | Dien giai |
| tk_co | nvarchar | 20 | TK co (ngan hang 112xxx) |
| ma_nt | nvarchar | 3 | Ma ngoai te |
| ty_gia | decimal | 19,4 | Ty gia |
| t_tien_nt | decimal | 19,4 | Tong tien NT |
| t_tien | decimal | 19,4 | Tong tien VND |
| t_thue | decimal | 19,4 | Tong thue |
| t_tt | decimal | 19,4 | Tong thanh toan |
| t_thue_nt | decimal | 19,4 | Tong thue NT |
| t_tt_nt | decimal | 19,4 | Tong TT NT |
| trang_thai | nvarchar | 1 | Trang thai |
| post2gl | nvarchar | 1 | Da post sang GL |
| cdate | datetime | 8 | Ngay tao |
| cuser | nvarchar | 30 | Nguoi tao |
| ldate | datetime | 8 | Ngay sua |
| luser | nvarchar | 30 | Nguoi sua |

### Bang: CaCt2 (Detail - Dung chung cho CA2 va CA4)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_cty | nvarchar | 10 | Ma cong ty |
| stt_rec | nvarchar | 20 | FK - Ref to CaPh2 |
| stt_rec0 | nvarchar | 3 | So dong (001, 002, ...) |
| stt_rec_pc | nvarchar | 20 | Ref phieu chi (neu link) |
| stt_rec0_pc | nvarchar | 3 | So dong phieu chi |
| so_pc | nvarchar | 12 | So phieu chi |
| tk | nvarchar | 20 | TK No (doi ung) |
| ps_no | decimal | 19,4 | Phat sinh no VND |
| ps_co | decimal | 19,4 | Phat sinh co VND |
| ps_no_nt | decimal | 19,4 | Phat sinh no NT |
| ps_co_nt | decimal | 19,4 | Phat sinh co NT |
| dien_giai | nvarchar | 255 | Dien giai chi tiet |
| ma_kh | nvarchar | 20 | Ma khach hang |
| ma_hd | nvarchar | 20 | Ma hop dong |
| ma_bp | nvarchar | 20 | Ma bo phan |
| ma_phi | nvarchar | 20 | Ma phi |
| ma_spct | nvarchar | 20 | Ma SP chi tiet |
| ma_lo | nvarchar | 20 | Ma lo |
| ma_ku | nvarchar | 20 | Ma ke uoc |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk_co -> DMTK.tk, FK tk -> DMTK.tk |
| DMDVKD | Don vi kinh doanh | FK ma_cty -> DMDVKD.ma_dvcs |
| DMMANHOM | Ma nhom | FK ma_kh -> DMMANHOM.ma_nhom |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmCAVchCA4 | frmVoucher | Form chinh cho phieu bao no |
| frmCAVchCA4Edit | frmVoucherEdit | Form nhap lieu chi tiet |

## Controls chinh

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_ct | AsTextBox | so_ct | So chung tu (auto) |
| txtNgay_ct | AsMaskedTextBox | ngay_ct | Ngay chung tu |
| txtNgay_lct | AsMaskedTextBox | ngay_lct | Ngay lap chung tu |
| txtMa_kh | AsTextBox | ma_kh | Ma khach hang |
| txtDia_chi | AsTextBox | dia_chi | Dia chi khach hang |
| txtNguoi_gd | AsTextBox | nguoi_gd | Nguoi giao dich |
| txtTk_co | AsTextBox | tk_co | TK co (ngan hang 11217) |
| cboMa_nt | AsComboBoxNT | ma_nt | Combobox ngoai te |
| txtTy_gia | AsTextNumeric | ty_gia | Ty gia quy doi |
| txtT_tien_nt | AsTextNumeric | t_tien_nt | Tong tien NT |
| txtT_tien | AsTextNumeric | t_tien | Tong tien VND |
| grdCt | AsDataGrid | CaCt2 | Grid chi tiet phat sinh |
| txtTk | AsTextBox | tk | TK No (doi ung) |
| txtPs_no | AsTextNumeric | ps_no | Phat sinh no |
| txtPs_co | AsTextNumeric | ps_co | Phat sinh co |
| txtPs_no_nt | AsTextNumeric | ps_no_nt | Phat sinh no NT |
| txtPs_co_nt | AsTextNumeric | ps_co_nt | Phat sinh co NT |
| txtDien_giai | AsTextBox | dien_giai | Dien giai chi tiet |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asGetSoCt | Lay so CT tu dong |
| asGetSttRec | Lay stt_rec moi |
| asChkSoCt | Check so CT trung |
| asCAInsPH2 | Insert header |
| asCAUpdPH2 | Update header |
| asCAInsCT2 | Insert detail |
| asCADelCT2 | Delete detail |
| asCADelPH2 | Delete header |
| asProcessCt | Process chung tu |
| asPostCaPh2_glct | Post sang GL |
| asGetSoDuKh | Lay so du KH |
| asValid | Validate danh muc |

### asProcessCt modes

| Mode | Y nghia |
|------|---------|
| 1 | Tao moi / Xac nhan sua |
| 2 | Sua / Xoa (unlock) |

### asCAInsPH2 (reference)

```sql
EXEC asCAInsPH2
    @pMa_cty NVARCHAR(10),
    @pStt_rec NVARCHAR(20),
    @pMa_ct NVARCHAR(3),
    @pSo_ct NVARCHAR(12),
    @pNgay_ct SMALLDATETIME,
    @pNgay_lct SMALLDATETIME,
    @pKht_tain BIT,
    @pMa_kh NVARCHAR(20),
    @pDia_chi NVARCHAR(255),
    @pNguoi_gd NVARCHAR(30),
    @pDien_giai NVARCHAR(255),
    @pTk_co NVARCHAR(20),
    @pMa_nt NVARCHAR(3),
    @pTy_gia DECIMAL(19,4),
    @pT_tien_nt DECIMAL(19,4),
    @pT_tien DECIMAL(19,4),
    @pT_thue DECIMAL(19,4),
    @pT_tt DECIMAL(19,4),
    @pT_thue_nt DECIMAL(19,4),
    @pT_tt_nt DECIMAL(19,4),
    @pTrang_thai NVARCHAR(1),
    @pPost2gl NVARCHAR(1)
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Required | tk_co | 'Tai khoan co khong duoc trong' |
| Required | ngay_ct | 'Ngay chung tu khong duoc trong' |
| Numeric | ty_gia | 'Ty gia phai la so' |
| Min value | ty_gia | 'Ty gia phai lon hon 0' |

### Business Rules

1. **TK Nợ:** Các TK công nợ, chi phí (từ chi tiết)
2. **TK Có:** TK ngân hàng 112xxx (từ header, mặc định 11217)
3. **Công thức:** Tổng PS Nợ = Tổng PS Có
4. **Ngoại tệ:** Tiền VND = Tiền NT × Tỷ giá
5. **VAT:** Không có (kht_tain = 0)
6. **Auto-number:** Số chứng từ tự động tăng theo ngày
7. **Validation:** Số chứng từ không được trùng trong cùng ngày

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/Cash/CA/CaPh2.php
namespace Diepxuan\Simba\Models\Cash\CA;

class CaPh2 extends SModel
{
    protected $table = 'CaPh2';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'stt_rec', 'ma_ct', 'so_ct', 'ngay_ct', 'ngay_lct',
        'kht_tain', 'ma_kh', 'dia_chi', 'nguoi_gd', 'dien_giai',
        'tk_co', 'ma_nt', 'ty_gia', 't_tien_nt', 't_tien',
        't_thue', 't_tt', 't_thue_nt', 't_tt_nt',
        'trang_thai', 'post2gl'
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ngay_lct' => 'datetime',
        'kht_tain' => 'boolean',
        'ty_gia' => 'decimal:4',
        't_tien_nt' => 'decimal:4',
        't_tien' => 'decimal:4',
        't_thue' => 'decimal:4',
        't_tt' => 'decimal:4',
        't_thue_nt' => 'decimal:4',
        't_tt_nt' => 'decimal:4'
    ];

    // Relationships
    public function taiKhoanCo()
    {
        return $this->hasOne(DMTK::class, 'tk', 'tk_co');
    }

    public function khachHang()
    {
        return $this->hasOne(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function chiTiet()
    {
        return $this->hasMany(CaCt2::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Detail Model

```php
// diepxuan/laravel-simba/src/Models/Cash/CA/CaCt2.php
namespace Diepxuan\Simba\Models\Cash\CA;

class CaCt2 extends SModel
{
    protected $table = 'CaCt2';
    protected $primaryKey = ['stt_rec', 'stt_rec0'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'stt_rec', 'stt_rec0', 'stt_rec_pc', 'stt_rec0_pc',
        'so_pc', 'tk', 'ps_no', 'ps_co', 'ps_no_nt', 'ps_co_nt',
        'dien_giai', 'ma_kh', 'ma_hd', 'ma_bp', 'ma_phi',
        'ma_spct', 'ma_lo', 'ma_ku'
    ];

    protected $casts = [
        'ps_no' => 'decimal:4',
        'ps_co' => 'decimal:4',
        'ps_no_nt' => 'decimal:4',
        'ps_co_nt' => 'decimal:4'
    ];

    // Relationships
    public function header()
    {
        return $this->belongsTo(CaPh2::class, 'stt_rec', 'stt_rec');
    }

    public function taiKhoanNo()
    {
        return $this->hasOne(DMTK::class, 'tk', 'tk');
    }
}
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/Cash/Nganhang/Baono.php
namespace Diepxuan\Catalog\Http\Livewire\Cash\Nganhang;

class Baono extends Component
{
    const MA_CT = 'CA4';

    public Collection $pBaonos;
    public string $pSearch = '';
    public ?string $pMa_Kh = null;
    public ?string $pTk_Co = null;
    public ?Carbon $pTuNgay = null;
    public ?Carbon $pDenNgay = null;

    public function mount(): void
    {
        $this->pTuNgay = Carbon::today()->startOfMonth();
        $this->pDenNgay = Carbon::today();
    }

    public function loadBaonos(): void
    {
        $this->pBaonos = CaPh2::where('ma_ct', self::MA_CT)
            ->where('ma_cty', auth()->user()->pMa_Cty)
            ->when($this->pSearch, fn($q) => $q->where('so_ct', 'like', "%{$this->pSearch}%"))
            ->when($this->pMa_Kh, fn($q) => $q->where('ma_kh', $this->pMa_Kh))
            ->when($this->pTk_Co, fn($q) => $q->where('tk_co', $this->pTk_Co))
            ->when($this->pTuNgay, fn($q) => $q->whereDate('ngay_ct', '>=', $this->pTuNgay))
            ->when($this->pDenNgay, fn($q) => $q->whereDate('ngay_ct', '<=', $this->pDenNgay))
            ->orderBy('ngay_ct', 'desc')
            ->orderBy('so_ct', 'desc')
            ->get();
    }

    public function render(): View
    {
        return view('catalog::cash.nganhang.baono.index');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/Cash/Nganhang/Baono/Phieubaono.php
namespace Diepxuan\Catalog\Http\Livewire\Cash\Nganhang\Baono;

class Phieubaono extends Component
{
    const MA_CT = 'CA4';
    const DEFAULT_TK_CO = 11_217;
    const DEFAULT_MA_NT = 'VND';
    const DEFAULT_TY_GIA = 1;

    public bool $pIsEditMode = false;
    public string $pStt_Rec = '';
    public string $pSo_Ct = '';
    public Carbon $pNgay_Ct;
    public Carbon $pNgay_Lap;
    public string $pMa_Kh = '';
    public string $pDia_Chi = '';
    public string $pNguoi_Gd = '';
    public string $pDien_Giai = '';
    public string $pTk_Co = '';
    public string $pMa_Nt = '';
    public float $pTy_Gia = 1;
    public float $pT_Tien_Nt = 0;
    public float $pT_Tien = 0;
    public float $pT_Thue = 0;
    public float $pT_Tt = 0;
    public float $pT_Thue_Nt = 0;
    public float $pT_Tt_Nt = 0;
    public array $pCts = [];

    protected $rules = [
        'pMa_Kh' => 'required',
        'pTk_Co' => 'required',
        'pNgay_Ct' => 'required|date',
        'pNgay_Lap' => 'required|date',
        'pDia_Chi' => 'nullable|string|max:255',
        'pNguoi_Gd' => 'nullable|string|max:30',
        'pMa_Nt' => 'required|string|size:3',
        'pTy_Gia' => 'required|numeric|min:0',
        'pCts.*.ma_tk' => 'required',
        'pCts.*.ps_no' => 'required|numeric|min:0',
        'pCts.*.ps_co' => 'nullable|numeric|min:0',
        'pCts.*.ps_no_nt' => 'nullable|numeric|min:0',
        'pCts.*.ps_co_nt' => 'nullable|numeric|min:0',
        'pCts.*.ma_kh' => 'nullable|string|max:20',
        'pCts.*.ma_hd' => 'nullable|string|max:20',
        'pCts.*.ma_bp' => 'nullable|string|max:20',
        'pCts.*.ma_phi' => 'nullable|string|max:20',
        'pCts.*.ma_spct' => 'nullable|string|max:20',
        'pCts.*.ma_lo' => 'nullable|string|max:20',
        'pCts.*.ma_ku' => 'nullable|string|max:20',
    ];

    public function mount(?string $stt_rec = null): void
    {
        $this->pNgay_Ct = Carbon::today();
        $this->pNgay_Lap = Carbon::today();
        $this->pTk_Co = self::DEFAULT_TK_CO;
        $this->pMa_Nt = self::DEFAULT_MA_NT;
        $this->pTy_Gia = self::DEFAULT_TY_GIA;

        if ($stt_rec) {
            $this->pIsEditMode = true;
            $this->loadFromDb($stt_rec);
        } else {
            $this->pSo_Ct = $this->getSoCt();
        }
    }

    private function loadFromDb(string $stt_rec): void
    {
        $header = CaPh2::find($stt_rec);
        if (!$header) return;

        $this->pStt_Rec = $header->stt_rec;
        $this->pSo_Ct = $header->so_ct;
        $this->pNgay_Ct = $header->ngay_ct;
        $this->pNgay_Lap = $header->ngay_lct;
        $this->pMa_Kh = $header->ma_kh;
        $this->pDia_Chi = $header->dia_chi;
        $this->pNguoi_Gd = $header->nguoi_gd;
        $this->pDien_Giai = $header->dien_giai;
        $this->pTk_Co = $header->tk_co;
        $this->pMa_Nt = $header->ma_nt;
        $this->pTy_Gia = $header->ty_gia;
        $this->pT_Tien_Nt = $header->t_tien_nt;
        $this->pT_Tien = $header->t_tien;
        $this->pT_Thue = $header->t_thue;
        $this->pT_Tt = $header->t_tt;
        $this->pT_Thue_Nt = $header->t_thue_nt;
        $this->pT_Tt_Nt = $header->t_tt_nt;

        $this->pCts = $header->chiTiet->map(function ($ct) {
            return [
                'stt_rec0' => $ct->stt_rec0,
                'ma_tk' => $ct->tk,
                'ps_no' => $ct->ps_no,
                'ps_co' => $ct->ps_co,
                'ps_no_nt' => $ct->ps_no_nt,
                'ps_co_nt' => $ct->ps_co_nt,
                'dien_giai' => $ct->dien_giai,
                'ma_kh' => $ct->ma_kh,
                'ma_hd' => $ct->ma_hd,
                'ma_bp' => $ct->ma_bp,
                'ma_phi' => $ct->ma_phi,
                'ma_spct' => $ct->ma_spct,
                'ma_lo' => $ct->ma_lo,
                'ma_ku' => $ct->ma_ku,
            ];
        })->toArray();
    }

    public function getSoCt(): string
    {
        return AsGetSoCt::call([
            'pMa_ct' => self::MA_CT,
            'pNgay_Ct' => $this->pNgay_Ct,
        ])->first()->pSo_Ct ?? '';
    }

    public function updatedCts(): void
    {
        $this->calculateTotals();
    }

    private function calculateTotals(): void
    {
        $tien_nt = collect($this->pCts)->sum('ps_no_nt');
        $tien = $tien_nt * $this->pTy_Gia;

        $this->pT_Tien_Nt = $tien_nt;
        $this->pT_Tien = $tien;
        $this->pT_Thue = 0; // CA4 khong co VAT
        $this->pT_Tt = $tien;
        $this->pT_Thue_Nt = 0;
        $this->pT_Tt_Nt = $tien_nt;
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            $maCty = auth()->user()->pMa_Cty;
            
            if ($this->pIsEditMode) {
                $stt_rec = $this->pStt_Rec;
                AsCADelCT2::call(['pMa_cty' => $maCty, 'pStt_rec' => $stt_rec]);
            } else {
                $stt_rec = AsGetSttRec::call([
                    'pMa_cty' => $maCty,
                    'pMa_Ct' => self::MA_CT,
                ])->first()->pStt_rec ?? '';
                
                $this->pStt_Rec = $stt_rec;
            }

            // Check so CT trung
            $checkSoCt = AsChkSoCt::call([
                'pMa_Cty' => $maCty,
                'pMa_Ct' => self::MA_CT,
                'pStt_Rec' => $this->pIsEditMode ? $this->pStt_Rec : '0',
                'pSo_ct' => $this->pSo_Ct,
                'pNgay_ct' => $this->pNgay_Ct,
            ]);

            if ($checkSoCt->first()->pCheck ?? 0) {
                throw new Exception('So chung tu da ton tai trong ngay');
            }

            // Insert header
            AsCAInsPH2::call([
                'pMa_cty' => $maCty,
                'pStt_rec' => $stt_rec,
                'pMa_ct' => self::MA_CT,
                'pSo_ct' => $this->pSo_Ct,
                'pNgay_ct' => $this->pNgay_Ct,
                'pNgay_lct' => $this->pNgay_Lap,
                'pKht_tain' => 0, // khong co VAT
                'pMa_kh' => $this->pMa_Kh,
                'pDia_chi' => $this->pDia_Chi,
                'pNguoi_gd' => $this->pNguoi_Gd,
                'pDien_giai' => $this->pDien_Giai,
                'pTk_co' => $this->pTk_Co,
                'pMa_nt' => $this->pMa_Nt,
                'pTy_gia' => $this->pTy_Gia,
                'pT_tien_nt' => $this->pT_Tien_Nt,
                'pT_tien' => $this->pT_Tien,
                'pT_thue' => $this->pT_Thue,
                'pT_tt' => $this->pT_Tt,
                'pT_thue_nt' => $this->pT_Thue_Nt,
                'pT_tt_nt' => $this->pT_Tt_Nt,
                'pTrang_thai' => '1',
                'pPost2gl' => '0',
            ]);

            // Insert details
            foreach ($this->pCts as $index => $row) {
                $stt_rec0 = str_pad(($index + 1) . '', 3, '0', STR_PAD_LEFT);
                
                AsCAInsCT2::call([
                    'pMa_cty' => $maCty,
                    'pStt_rec' => $stt_rec,
                    'pStt_rec0' => $stt_rec0,
                    'pStt_rec_pc' => $row['stt_rec_pc'] ?? null,
                    'pStt_rec0_pc' => $row['stt_rec0_pc'] ?? null,
                    'pSo_pc' => $row['so_pc'] ?? null,
                    'pTk' => $row['ma_tk'],
                    'pPs_no' => $row['ps_no'],
                    'pPs_co' => $row['ps_co'] ?? 0,
                    'pPs_no_nt' => $row['ps_no_nt'],
                    'pPs_co_nt' => $row['ps_co_nt'] ?? 0,
                    'pDien_giai' => $row['dien_giai'] ?? '',
                    'pMa_kh' => $row['ma_kh'] ?? null,
                    'pMa_hd' => $row['ma_hd'] ?? null,
                    'pMa_bp' => $row['ma_bp'] ?? null,
                    'pMa_phi' => $row['ma_phi'] ?? null,
                    'pMa_spct' => $row['ma_spct'] ?? null,
                    'pMa_lo' => $row['ma_lo'] ?? null,
                    'pMa_ku' => $row['ma_ku'] ?? null,
                ]);
            }

            // Process chung tu
            AsProcessCt::call([
                'pMa_cty' => $maCty,
                'pMa_Ct' => self::MA_CT,
                'pStt_rec' => $stt_rec,
                'pMode' => $this->pIsEditMode ? '2' : '1',
            ]);

            // Post to GL
            AsPostCaPh2_glct::call([
                'pMa_cty' => $maCty,
                'pStt_rec' => $stt_rec,
            ]);
        });

        session()->flash('message', 'Luu thanh cong');
        return redirect()->route('cash.nganhang.baono');
    }

    public function render(): View
    {
        return view('catalog::cash.nganhang.baono.form');
    }
}
```

### 5. Views

```blade
{{-- resources/views/catalog::cash/nganhang/baono/index.blade.php --}}
@extends('catalog::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Phiếu báo nợ ngân hàng (CA4)</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input wire:model.live="pSearch" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
                <div class="col-md-2">
                    <input wire:model.live="pTuNgay" type="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <input wire:model.live="pDenNgay" type="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <input wire:model.live="pMa_Kh" type="text" class="form-control" placeholder="Mã khách hàng">
                </div>
                <div class="col-md-2">
                    <input wire:model.live="pTk_Co" type="text" class="form-control" placeholder="TK có">
                </div>
                <div class="col-md-1">
                    <a href="{{ route('cash.nganhang.baono.create') }}" class="btn btn-primary">Tạo mới</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Số CT</th>
                            <th>Ngày CT</th>
                            <th>Mã KH</th>
                            <th>Tên KH</th>
                            <th>TK Có</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pBaonos as $baono)
                        <tr>
                            <td>{{ $baono->so_ct }}</td>
                            <td>{{ $baono->ngay_ct->format('d/m/Y') }}</td>
                            <td>{{ $baono->ma_kh }}</td>
                            <td>{{ $baono->khachHang->ten_kh ?? '' }}</td>
                            <td>{{ $baono->tk_co }}</td>
                            <td>{{ number_format($baono->t_tien) }}</td>
                            <td>{{ $baono->trang_thai }}</td>
                            <td>
                                <a href="{{ route('cash.nganhang.baono.edit', $baono->stt_rec) }}" class="btn btn-sm btn-info">Sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
```

```blade
{{-- resources/views/catalog::cash/nganhang/baono/form.blade.php --}}
@extends('catalog::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>{{ $pIsEditMode ? 'Sửa' : 'Tạo mới' }} Phiếu báo nợ ngân hàng (CA4)</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Số chứng từ</label>
                            <input wire:model="pSo_Ct" type="text" class="form-control" readonly>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Ngày chứng từ *</label>
                            <input wire:model="pNgay_Ct" type="date" class="form-control">
                            @error('pNgay_Ct') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Ngày lập *</label>
                            <input wire:model="pNgay_Lap" type="date" class="form-control">
                            @error('pNgay_Lap') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Mã khách hàng *</label>
                            <input-khachhang mode="khachhang,nhacungcap" wire:model="pMa_Kh" />
                            @error('pMa_Kh') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input wire:model="pDia_Chi" type="text" class="form-control">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Người giao dịch</label>
                            <input wire:model="pNguoi_Gd" type="text" class="form-control">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Diễn giải</label>
                            <input wire:model="pDien_Giai" type="text" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">TK Có *</label>
                            <input-taikhoan wire:model="pTk_Co" />
                            @error('pTk_Co') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Ngoại tệ *</label>
                            <select wire:model="pMa_Nt" class="form-select">
                                <option value="VND">VND</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                            @error('pMa_Nt') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Tỷ giá *</label>
                            <input-numeric wire:model="pTy_Gia" min="0" step="0.0001" />
                            @error('pTy_Gia') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Tổng tiền NT</label>
                            <input-numeric wire:model="pT_Tien_Nt" readonly />
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Tổng tiền VND</label>
                            <input-numeric wire:model="pT_Tien" readonly />
