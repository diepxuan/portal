# Task 012: ARRptBCCN06

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich cong no theo han ky (aging report) tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBCCN06.

## Chi tiet
- **DLL:** ARRptBCCN06.dll
- **Chuc nang:** Phan tich cong no theo cac khoang thoi gian (han ky) de danh gia chat luong cong no va ke hoach thu hoi
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBCCN06.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| DMNHKH | Danh muc nhom KH | FK ma_nhkh |
| ARTT | Dieu khoan thanh toan | FK ma_tt, co han_tt |
| AR4PH | Chung tu header | Chua ngay_ct, ma_kh |
| AR4CT | Chung tu chi tiet | Chi tiet phat sinh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ten_kh, ma_nhkh |
| DMNHKH | Nhom KH | Lookup ten_nhkh |
| ARTT | Dieu khoan TT | Lookup han_tt, tinh ngay den han |

---

## Form classes

### 1. frmARRptBCCN06 (Bao cao cong no theo han ky)
- **Ke thua:** frmReport
- **Chuc nang:** Phan tich cong no theo cac khoang thoi gian, so sanh giua cac ky
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay_Ss | AsMaskedTextBox | Ngay so sanh (lam muc so) |
| txtHan_ky1 | AsTextNumeric | Han ky 1 (so ngay, mac dinh 30) |
| txtHan_ky2 | AsTextNumeric | Han ky 2 (so ngay, mac dinh 60) |
| txtHan_ky3 | AsTextNumeric | Han ky 3 (so ngay, mac dinh 90) |
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| txtMa_NhKh | AsTextBox | Ma nhom KH (AutoLookup) |
| txtMaTT | AsTextBox | Ma dieu khoan TT (AutoLookup) |
| cboKyBc | ComboBox | Ky bao cao |
| dgvBC | DataGridView | Du lieu bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BC06_GET | Lay bao cao theo han ky |
| SP_AR_BC06_GETBYKH | Lay chi tiet 1 KH |
| SP_AR_BC06_EXPORT | Xuat Excel |
| SP_AR_BC06_SUMMARY | Tong hop theo nhom |

### SP_GET (reference)

```sql
-- Lay bao cao phan tich han ky
EXEC SP_AR_BC06_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay_ss DATETIME,
    @pHan_ky1 INT = 30,
    @pHan_ky2 INT = 60,
    @pHan_ky3 INT = 90,
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_nhkh VARCHAR(50) = NULL,
    @pMa_tt VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND'
```

---

## Business Logic

### Phan khoang cong no

| Khoang | Tinh toan | Y nghia |
|--------|-----------|---------|
| Chua den han | han_tt - ngay_ss > han_ky1 | Cong no nam trong han |
| Han ky 1 | 1 <= (han_tt - ngay_ss) <= han_ky1 | Qua han nhe (1-30 ngay) |
| Han ky 2 | han_ky1 < (han_tt - ngay_ss) <= han_ky2 | Qua han trung binh (31-60 ngay) |
| Han ky 3 | han_ky2 < (han_tt - ngay_ss) <= han_ky3 | Qua han nang (61-90 ngay) |
| Qua han | (han_tt - ngay_ss) > han_ky3 | Qua han rat nang (>90 ngay) |

### Tinh toan so ngay qua han

```sql
-- So ngay qua han = Ngay so sanh - Han thanh toan
so_ngay_qua_han = DATEDIFF(day, han_tt, @pNgay_ss)
```

### Cau hinh mac dinh

```csharp
txtHan_ky1.Value = AsiaErp.Framework.Environment.GetSOConfiguration().han_tt_ss1; // 30
txtHan_ky2.Value = AsiaErp.Framework.Environment.GetSOConfiguration().han_tt_ss2; // 60
txtHan_ky3.Value = AsiaErp.Framework.Environment.GetSOConfiguration().han_tt_ss3; // 90
```

### Cuc du lieu

| Cot | Mo ta |
|-----|-------|
| ma_kh | Ma khach hang |
| ten_kh | Ten khach hang |
| chua_den_han | So tien chua den han |
| han_ky_1 | So tien trong han ky 1 |
| han_ky_2 | So tien trong han ky 2 |
| han_ky_3 | So tien trong han ky 3 |
| qua_han | So tien qua han |
| tong_cong | Tong cong |

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBCCN06.php
namespace Diepxuan\Simba\Models\AR;

class RptBCCN06 extends Model
{
    protected $table = 'VW_AR_BC06'; // View phan tich han ky
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $casts = [
        'chua_den_han' => 'decimal:2',
        'han_ky_1' => 'decimal:2',
        'han_ky_2' => 'decimal:2',
        'han_ky_3' => 'decimal:2',
        'qua_han' => 'decimal:2',
        'tong_cong' => 'decimal:2',
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

    // Scopes
    public function scopeByAging($query, $column)
    {
        return $query->where($column, '>', 0);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN06.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBCCN06 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC06_GET';
    protected $params = [
        'pMa_cty',
        'pNgay_ss',
        'pHan_ky1',
        'pHan_ky2',
        'pHan_ky3',
        'pMa_kh',
        'pMa_nhkh',
        'pMa_tt',
        'pMa_nt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN06Summary.php
class AsARGetBCCN06Summary extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC06_SUMMARY';
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
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/CongNoHanKy.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class CongNoHanKy extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BCCN06';

    public ?Carbon $pNgaySs = null;
    public int $pHanKy1 = 30;
    public int $pHanKy2 = 60;
    public int $pHanKy3 = 90;
    public ?string $pMaKh = null;
    public ?string $pMaNhkh = null;
    public ?string $pMaTt = null;
    public string $pMaNt = 'VND';
    public Collection $pData;
    public array $pSummary = [];
    public array $pChartData = [];
    public array $pAgingPercentages = [];

    public function mount(): void
    {
        $this->pNgaySs = now();
        $this->loadDefaultAging();
    }

    public function loadDefaultAging(): void
    {
        // Lay tu cau hinh he thong
        // $config = GetSOConfiguration();
        // $this->pHanKy1 = $config->han_tt_ss1 ?? 30;
        // $this->pHanKy2 = $config->han_tt_ss2 ?? 60;
        // $this->pHanKy3 = $config->han_tt_ss3 ?? 90;
    }

    public function loadReport(): void
    {
        $sp = new AsARGetBCCN06();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pNgay_ss' => $this->pNgaySs,
            'pHan_ky1' => $this->pHanKy1,
            'pHan_ky2' => $this->pHanKy2,
            'pHan_ky3' => $this->pHanKy3,
            'pMa_kh' => $this->pMaKh,
            'pMa_nhkh' => $this->pMaNhkh,
            'pMa_tt' => $this->pMaTt,
            'pMa_nt' => $this->pMaNt,
        ]);
        $this->calculateSummary();
        $this->calculatePercentages();
        $this->prepareChartData();
    }

    public function calculateSummary(): void
    {
        $this->pSummary = [
            'tong_chua_den_han' => $this->pData->sum('chua_den_han'),
            'tong_han_ky_1' => $this->pData->sum('han_ky_1'),
            'tong_han_ky_2' => $this->pData->sum('han_ky_2'),
            'tong_han_ky_3' => $this->pData->sum('han_ky_3'),
            'tong_qua_han' => $this->pData->sum('qua_han'),
            'tong_cong' => $this->pData->sum('tong_cong'),
        ];
    }

    public function calculatePercentages(): void
    {
        $tong = $this->pSummary['tong_cong'] ?? 1;
        $this->pAgingPercentages = [
            'chua_den_han' => round(($this->pSummary['tong_chua_den_han'] / $tong) * 100, 2),
            'han_ky_1' => round(($this->pSummary['tong_han_ky_1'] / $tong) * 100, 2),
            'han_ky_2' => round(($this->pSummary['tong_han_ky_2'] / $tong) * 100, 2),
            'han_ky_3' => round(($this->pSummary['tong_han_ky_3'] / $tong) * 100, 2),
            'qua_han' => round(($this->pSummary['tong_qua_han'] / $tong) * 100, 2),
        ];
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.cong-no-han-ky');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── cong-no-han-ky.blade.php           (Form bao cao)
├── cong-no-han-ky-results.blade.php    (Ket qua)
├── _cong-no-han-ky-row.blade.php      (Dong bao cao)
├── _cong-no-han-ky-summary.blade.php   (Tong hop)
└── _cong-no-han-ky-chart.blade.php     (Bieu do pie/bar)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/cong-no-han-ky', [CongNoHanKy::class, 'render'])
            ->name('cong-no-han-ky');
        Route::get('/cong-no-han-ky/export', [CongNoHanKy::class, 'exportExcel'])
            ->name('cong-no-han-ky.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBCCN06.php | View phan tich |
| Model | laravel-simba | DMKH.php | Lookup KH |
| Model | laravel-simba | DMNHKH.php | Lookup nhom KH |
| Model | laravel-simba | ARTT.php | Dieu khoan TT |
| SP | laravel-simba | AsARGetBCCN06.php | Lay du lieu |
| SP | laravel-simba | AsARGetBCCN06Summary.php | Tong hop |
| Component | laravel-catalog | CongNoHanKy.php | Form bao cao |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBCCN06 (View)
- [ ] Tao Livewire CongNoHanKy
- [ ] Tao Views (report + chart)
- [ ] Them Routes
- [ ] Implement bieu do phan bo cong no
- [ ] Test bao cao voi du lieu thuc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
