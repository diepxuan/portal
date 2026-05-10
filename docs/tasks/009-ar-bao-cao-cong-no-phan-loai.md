# Task 009: ARRptBCCN02

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop cong no theo phan loai khach hang tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBCCN02.

## Chi tiet
- **DLL:** ARRptBCCN02.dll, ARRptBCCN03.dll
- **Chuc nang:** Tong hop cong no theo cac tieu chi phan loai khach hang (PL1, PL2, PL3) - chi tiet va tong hop
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBCCN02.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh, co PL1/PL2/PL3 |
| DMPLKH1 | Phan loai 1 | FK ma_plkh1 |
| DMPLKH2 | Phan loai 2 | FK ma_plkh2 |
| DMPLKH3 | Phan loai 3 | FK ma_plkh3 |
| AR4CT | Chung tu chi tiet | Phat sinh theo ma_kh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ma_plkh1/2/3 |
| DMPLKH1 | Phan loai 1 | Lookup ten_plkh1 |
| DMPLKH2 | Phan loai 2 | Lookup ten_plkh2 |
| DMPLKH3 | Phan loai 3 | Lookup ten_plkh3 |

---

## Form classes

### 1. frmARRptBCCN02 (Chi tiet theo phan loai)
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao chi tiet theo phan loai KH, hien thi tung KH trong nhom
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_plkh1 | AsTextBox | Phan loai KH 1 (AutoLookup) |
| txtMa_plkh2 | AsTextBox | Phan loai KH 2 (AutoLookup) |
| txtMa_plkh3 | AsTextBox | Phan loai KH 3 (AutoLookup) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao |
| dgvBC | DataGridView | Du lieu bao cao |

### 2. frmARRptBCCN03 (Tong hop theo phan loai)
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao tong hop theo phan loai, chi hien thi nhom, khong chi tiet KH

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BC02_GET | Lay bao cao chi tiet theo PL |
| SP_AR_BC02_GETBYPL1 | Lay bao cao theo PL1 |
| SP_AR_BC02_GETBYPL2 | Lay bao cao theo PL2 |
| SP_AR_BC02_GETBYPL3 | Lay bao cao theo PL3 |
| SP_AR_BC02_EXPORT | Xuat Excel |

### SP_GET (reference)

```sql
-- Lay bao cao chi tiet theo phan loai
EXEC SP_AR_BC02_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_plkh1 VARCHAR(50) = NULL,
    @pMa_plkh2 VARCHAR(50) = NULL,
    @pMa_plkh3 VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_nt VARCHAR(10) = 'VND',
    @pLevel INT = 0  -- 0: ca 3 cap, 1: chi PL1, 2: chi PL2, 3: chi PL3
```

---

## Business Logic

### Phan loai khach hang

| Loai | Y nghia | Vi du |
|------|---------|-------|
| PL1 | Theo nganh nghe, linh vuc KD | Thep, Xi mang, Keo |
| PL2 | Theo khu vuc dia ly | Mien Nam, Mien Trung, Mien Bac |
| PL3 | Theo muc do quan trong | VIP, Normal, Potential |

### Tinh toan

1. **Nhom theo phan loai**:
   - Sum du_dk, ps_no, ps_co, du_ck theo ma_plkh*
   - Tinh % ty trong so voi tong cong

2. **Bieu do**:
   - Bieu do cot cho ty trong theo nhom
   - Bieu do duong cho xu huong

### Xuat bao cao

- Crystal Report cho in an
- Excel Export cho xu ly tiep

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBCCN02.php
namespace Diepxuan\Simba\Models\AR;

class RptBCCN02 extends Model
{
    protected $table = 'VW_AR_BC02'; // View bao cao
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $casts = [
        'du_dk' => 'decimal:2',
        'ps_no' => 'decimal:2',
        'ps_co' => 'decimal:2',
        'du_ck' => 'decimal:2',
    ];

    // Relationships
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function plKhachHang1()
    {
        return $this->belongsTo(DMPLKH1::class, 'ma_plkh1', 'ma_plkh1');
    }

    public function plKhachHang2()
    {
        return $this->belongsTo(DMPLKH2::class, 'ma_plkh2', 'ma_plkh2');
    }

    public function plKhachHang3()
    {
        return $this->belongsTo(DMPLKH3::class, 'ma_plkh3', 'ma_plkh3');
    }

    // Scopes
    public function scopeByClassification($query, $level, $maPl)
    {
        return match ($level) {
            1 => $query->where('ma_plkh1', $maPl),
            2 => $query->where('ma_plkh2', $maPl),
            3 => $query->where('ma_plkh3', $maPl),
            default => $query,
        };
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN02.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBCCN02 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC02_GET';
    protected $params = [
        'pMa_cty',
        'pMa_plkh1',
        'pMa_plkh2',
        'pMa_plkh3',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
        'pLevel',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN02Summary.php
class AsARGetBCCN02Summary extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC02_SUMMARY';
    protected $params = [
        'pMa_cty',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
        'pLevel',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/CongNoTheoPhanLoai.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class CongNoTheoPhanLoai extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BCCN02';

    public ?string $pMaPlkh1 = null;
    public ?string $pMaPlkh2 = null;
    public ?string $pMaPlkh3 = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pMaNt = 'VND';
    public int $pLevel = 0; // 0: all, 1: PL1, 2: PL2, 3: PL3
    public Collection $pData;
    public array $pSummary = [];
    public array $pChartData = [];

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
    }

    public function loadReport(): void
    {
        $sp = new AsARGetBCCN02();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pMa_plkh1' => $this->pMaPlkh1,
            'pMa_plkh2' => $this->pMaPlkh2,
            'pMa_plkh3' => $this->pMaPlkh3,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMa_nt' => $this->pMaNt,
            'pLevel' => $this->pLevel,
        ]);
        $this->calculateSummary();
        $this->prepareChartData();
    }

    public function calculateSummary(): void
    {
        $this->pSummary = [
            'tong_du_dk' => $this->pData->sum('du_dk'),
            'tong_ps_no' => $this->pData->sum('ps_no'),
            'tong_ps_co' => $this->pData->sum('ps_co'),
            'tong_du_ck' => $this->pData->sum('du_ck'),
        ];
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.cong-no-theo-phan-loai');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── cong-no-theo-phan-loai.blade.php        (Form bao cao)
├── cong-no-theo-phan-loai-results.blade.php (Ket qua)
├── _cong-no-theo-phan-loai-row.blade.php   (Dong bao cao)
└── _cong-no-theo-phan-loai-chart.blade.php (Bieu do)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/cong-no-theo-phan-loai', [CongNoTheoPhanLoai::class, 'render'])
            ->name('cong-no-theo-phan-loai');
        Route::get('/cong-no-theo-phan-loai/export', [CongNoTheoPhanLoai::class, 'exportExcel'])
            ->name('cong-no-theo-phan-loai.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBCCN02.php | View bao cao |
| Model | laravel-simba | DMKH.php | Lookup KH + PL |
| Model | laravel-simba | DMPLKH1.php | Phan loai 1 |
| Model | laravel-simba | DMPLKH2.php | Phan loai 2 |
| Model | laravel-simba | DMPLKH3.php | Phan loai 3 |
| SP | laravel-simba | AsARGetBCCN02.php | Lay du lieu |
| SP | laravel-simba | AsARGetBCCN02Summary.php | Tong hop |
| Component | laravel-catalog | CongNoTheoPhanLoai.php | Form bao cao |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBCCN02 (View)
- [ ] Tao Livewire CongNoTheoPhanLoai
- [ ] Tao Views (report + summary)
- [ ] Them Routes
- [ ] Implement tinh % ty trong
- [ ] Test bao cao voi du lieu thuc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
