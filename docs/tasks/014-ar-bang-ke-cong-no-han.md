# Task 014: ARRptBK02

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bang ke cong no theo han tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBK02.

## Chi tiet
- **DLL:** ARRptBK02.dll
- **Chuc nang:** Bang ke cac khoan cong no phan theo cac khoang thoi gian han ky - hien thi chi tiet hoa don va trang thai thanh toan
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBK02.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| DMNHKH | Danh muc nhom KH | FK ma_nhkh |
| ARTT | So du dau ky | FK ma_kh, ma_tt |
| ARDTK | Dieu khoan thanh toan | FK ma_tt, co han_tt |
| ARPost2TT | Phan bo thanh toan | Cap nhat da_tt |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ten_kh, ma_nhkh |
| DMNHKH | Nhom KH | Lookup ten_nhkh |
| ARDTK | Dieu khoan TT | Lookup han_tt |

---

## Form classes

### 1. frmARRptBK02 (Bang ke cong no theo han)
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke hoa don theo han thanh toan, phan loai do tre
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay_Ss | AsMaskedTextBox | Ngay so sanh (lam moc) |
| txtHan_ky1 | AsTextNumeric | Han ky 1 (ngay) |
| txtHan_ky2 | AsTextNumeric | Han ky 2 (ngay) |
| txtHan_ky3 | AsTextNumeric | Han ky 3 (ngay) |
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| txtMa_NhKh | AsTextBox | Ma nhom KH (AutoLookup) |
| txtMaTT | AsTextBox | Ma dieu khoan TT (AutoLookup) |
| cboChi_xem | ComboBox | Chi xem (0: chua TT, 1: da TT, 2: tat ca) |
| ChkSap_xep | AsCheckBox | Sap xep theo khach hang |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| dgvBK | DataGridView | Du lieu bang ke |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BK02_GET | Lay du lieu bang ke theo han |
| SP_AR_BK02_GETUNPAID | Lay hoa don chua tat toan |
| SP_AR_BK02_SUMMARY | Tong hop theo han ky |
| SP_AR_BK02_EXPORT | Xuat Excel |

### SP_GET (reference)

```sql
-- Lay du lieu bang ke cong no theo han
EXEC SP_AR_BK02_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay_ss DATETIME,
    @pHan_ky1 INT = 30,
    @pHan_ky2 INT = 60,
    @pHan_ky3 INT = 90,
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_nhkh VARCHAR(50) = NULL,
    @pMa_tt VARCHAR(50) = NULL,
    @pChi_xem INT = 2,  -- 0: chua TT, 1: da TT, 2: tat ca
    @pSap_xep INT = 0,  -- 0: ngay, 1: KH
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL,
    @pMa_nt VARCHAR(10) = 'VND'
```

---

## Business Logic

### Tinh han ky

```sql
-- Tinh so ngay qua han
so_ngay_qua_han = DATEDIFF(day, han_tt, @pNgay_ss)

-- Phan loai
CASE
    WHEN so_ngay_qua_han < 0 THEN 'chua_den_han'
    WHEN so_ngay_qua_han <= @pHan_ky1 THEN 'han_ky_1'
    WHEN so_ngay_qua_han <= @pHan_ky2 THEN 'han_ky_2'
    WHEN so_ngay_qua_han <= @pHan_ky3 THEN 'han_ky_3'
    ELSE 'qua_han'
END
```

### Cau hinh mac dinh

```csharp
txtHan_ky1.Value = AsiaErp.Framework.Environment.GetSOConfiguration().han_tt_ss1; // 30
txtHan_ky2.Value = AsiaErp.Framework.Environment.GetSOConfiguration().han_tt_ss2; // 60
txtHan_ky3.Value = AsiaErp.Framework.Environment.GetSOConfiguration().han_tt_ss3; // 90
```

### Chi xem

| Gia tri | Y nghia |
|---------|---------|
| 0 | Chi hien thi hoa don chua tat toan |
| 1 | Chi hien thi hoa don da tat toan |
| 2 | Hien thi tat ca hoa don |

### Cau truc bao cao

| Cot | Mo ta |
|-----|-------|
| ma_kh | Ma khach hang |
| ten_kh | Ten khach hang |
| so_ct | So hoa don |
| ngay_ct | Ngay hoa don |
| han_tt | Han thanh toan |
| so_ngay_qua_han | So ngay qua han |
| gia_tri_hd | Gia tri hoa don |
| da_tt | Da thanh toan |
| con_phai_tt | Con phai thanh toan |

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBK02.php
namespace Diepxuan\Simba\Models\AR;

class RptBK02 extends Model
{
    protected $table = 'VW_AR_BK02'; // View bang ke theo han
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $casts = [
        'gia_tri_hd' => 'decimal:2',
        'da_tt' => 'decimal:2',
        'con_phai_tt' => 'decimal:2',
        'so_ngay_qua_han' => 'integer',
        'ngay_ct' => 'date',
        'han_tt' => 'date',
    ];

    // Relationships
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function nhomKhachHang()
    {
        return $this->belongsTo(DMNHKH::class, 'ma_nhkh', 'ma_nhkh');
    }

    public function dieuKhoanTT()
    {
        return $this->belongsTo(ARDTK::class, 'ma_tt', 'ma_tt');
    }

    // Scopes
    public function scopeUnpaid($query)
    {
        return $query->whereColumn('con_phai_tt', '>', 0);
    }

    public function scopePaid($query)
    {
        return $query->whereColumn('con_phai_tt', '<=', 0);
    }

    public function scopeByAging($query, $column)
    {
        return $query->where('aging_bucket', $column);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBK02.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBK02 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BK02_GET';
    protected $params = [
        'pMa_cty',
        'pNgay_ss',
        'pHan_ky1',
        'pHan_ky2',
        'pHan_ky3',
        'pMa_kh',
        'pMa_nhkh',
        'pMa_tt',
        'pChi_xem',
        'pSap_xep',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBK02Summary.php
class AsARGetBK02Summary extends StoredProcedure
{
    protected $procedure = 'SP_AR_BK02_SUMMARY';
    protected $params = [
        'pMa_cty',
        'pNgay_ss',
        'pHan_ky1',
        'pHan_ky2',
        'pHan_ky3',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/BangKeCongNoHan.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class BangKeCongNoHan extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BK02';

    public ?Carbon $pNgaySs = null;
    public int $pHanKy1 = 30;
    public int $pHanKy2 = 60;
    public int $pHanKy3 = 90;
    public ?string $pMaKh = null;
    public ?string $pMaNhkh = null;
    public ?string $pMaTt = null;
    public int $pChiXem = 2; // 0: chua TT, 1: da TT, 2: all
    public bool $pSapXepKh = false;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pMaNt = 'VND';

    public Collection $pData;
    public array $pSummary = [];
    public array $pAgingSummary = [];

    public function mount(): void
    {
        $this->pNgaySs = now();
        $this->loadDefaultAging();
    }

    public function loadDefaultAging(): void
    {
        // Lay tu cau hinh he thong
    }

    public function loadReport(): void
    {
        $sp = new AsARGetBK02();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pNgay_ss' => $this->pNgaySs,
            'pHan_ky1' => $this->pHanKy1,
            'pHan_ky2' => $this->pHanKy2,
            'pHan_ky3' => $this->pHanKy3,
            'pMa_kh' => $this->pMaKh,
            'pMa_nhkh' => $this->pMaNhkh,
            'pMa_tt' => $this->pMaTt,
            'pChi_xem' => $this->pChiXem,
            'pSap_xep' => $this->pSapXepKh ? 1 : 0,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMa_nt' => $this->pMaNt,
        ]);
        $this->calculateSummary();
        $this->calculateAgingSummary();
    }

    public function calculateSummary(): void
    {
        $this->pSummary = [
            'tong_gia_tri_hd' => $this->pData->sum('gia_tri_hd'),
            'tong_da_tt' => $this->pData->sum('da_tt'),
            'tong_con_phai_tt' => $this->pData->sum('con_phai_tt'),
            'so_hoa_don' => $this->pData->count(),
        ];
    }

    public function calculateAgingSummary(): void
    {
        $this->pAgingSummary = [
            'chua_den_han' => $this->pData->where('aging_bucket', 'chua_den_han')->sum('con_phai_tt'),
            'han_ky_1' => $this->pData->where('aging_bucket', 'han_ky_1')->sum('con_phai_tt'),
            'han_ky_2' => $this->pData->where('aging_bucket', 'han_ky_2')->sum('con_phai_tt'),
            'han_ky_3' => $this->pData->where('aging_bucket', 'han_ky_3')->sum('con_phai_tt'),
            'qua_han' => $this->pData->where('aging_bucket', 'qua_han')->sum('con_phai_tt'),
        ];
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.bang-ke-cong-no-han');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── bang-ke-cong-no-han.blade.php        (Form bao cao)
├── bang-ke-cong-no-han-results.blade.php  (Ket qua)
├── _bang-ke-cong-no-han-row.blade.php    (Dong bao cao)
└── _bang-ke-cong-no-han-summary.blade.php (Tong hop theo han ky)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/bang-ke-cong-no-han', [BangKeCongNoHan::class, 'render'])
            ->name('bang-ke-cong-no-han');
        Route::get('/bang-ke-cong-no-han/export', [BangKeCongNoHan::class, 'exportExcel'])
            ->name('bang-ke-cong-no-han.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBK02.php | View bang ke |
| Model | laravel-simba | DMKH.php | Khach hang |
| Model | laravel-simba | DMNHKH.php | Nhom KH |
| Model | laravel-simba | ARDTK.php | Dieu khoan TT |
| SP | laravel-simba | AsARGetBK02.php | Lay du lieu |
| SP | laravel-simba | AsARGetBK02Summary.php | Tong hop |
| Component | laravel-catalog | BangKeCongNoHan.php | Form bao cao |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBK02 (View)
- [ ] Tao Livewire BangKeCongNoHan
- [ ] Tao Views (form + results)
- [ ] Them Routes
- [ ] Implement loc theo trang thai (chua TT / da TT)
- [ ] Test bang ke voi du lieu thuc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
\n## Portal implementation status\n\n- **Status:** DONE (route shell/read-only report)\n- **Source:** SimbaReportRegistry / SimbaRouteRegistry, sysReportInfo-backed route anchor\n- **Note:** Report shell hiển thị metadata và chưa execute SP khi chưa đối chiếu đủ tham số/payload/side effect.\n
