# Task 015: ARRptBK03

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu thanh toan tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBK03.

## Chi tiet
- **DLL:** ARRptBK03.dll
- **Chuc nang:** Bang ke cac chung tu thanh toan tu khach hang - theo doi cac khoan thanh toan, phan loai giao dich, trang thai tat toan
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBK03.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| ARPost2TT | Phan bo thanh toan | Header phan bo |
| ARPost2TTCT | Chi tiet phan bo | Chi tiet phan bo |
| DMKH | Danh muc khach hang | FK ma_kh |
| DMNHKH | Danh muc nhom KH | FK ma_nhkh |
| DMAIGD | Danh muc loai giao dich | FK ma_gd |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ten_kh, ma_nhkh, ma_plkh1/2/3 |
| DMNHKH | Nhom KH | Lookup ten_nhkh |
| DMAIGD | Loai giao dich | Lookup ten_gd |

---

## Form classes

### 1. frmARRptBK03 (Bang ke chung tu thanh toan)
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke chi tiet cac khoan thanh toan, loc theo nhieu tieu chi
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| txtMa_NhKh | AsTextBox | Ma nhom KH (AutoLookup) |
| txtMa_plkh1 | AsTextBox | Phan loai KH 1 (AutoLookup) |
| txtMa_plkh2 | AsTextBox | Phan loai KH 2 (AutoLookup) |
| txtMa_plkh3 | AsTextBox | Phan loai KH 3 (AutoLookup) |
| txtSo_Ct1 | TextBox | So chung tu tu |
| txtSo_Ct2 | TextBox | So chung tu den |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboGiao_dich | ComboBox | Loai giao dich |
| cboChi_xem | ComboBox | Loai tat toan (0: chua, 1: da, 2: all) |
| ChkSap_xep | AsCheckBox | Sap xep theo khach hang |
| dgvBK | DataGridView | Du lieu bang ke |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BK03_GET | Lay du lieu bang ke thanh toan |
| SP_AR_BK03_GETBYKH | Lay theo khach hang |
| SP_AR_BK03_GETBYGD | Lay theo loai giao dich |
| SP_AR_BK03_SUMMARY | Tong hop theo tieu chi |
| SP_AR_BK03_EXPORT | Xuat Excel |

### SP_GET (reference)

```sql
-- Lay du lieu bang ke chung tu thanh toan
EXEC SP_AR_BK03_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_nhkh VARCHAR(50) = NULL,
    @pMa_plkh1 VARCHAR(50) = NULL,
    @pMa_plkh2 VARCHAR(50) = NULL,
    @pMa_plkh3 VARCHAR(50) = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_gd VARCHAR(50) = NULL,  -- Loai giao dich (tu DMAIGD)
    @pChi_xem INT = 2,            -- 0: chua TT, 1: da TT, 2: all
    @pSap_xep INT = 0,            -- 0: ngay, 1: KH
    @pMa_nt VARCHAR(10) = 'VND'
```

---

## Business Logic

### Loai giao dich

- Lay tu danh muc DMAIGD theo par1 cua menu
- Hien thi ma_gd va ten_gd

### Chi xem (trang thai tat toan)

| Gia tri | Y nghia |
|---------|---------|
| 0 | Chi hien thi chua tat toan (con_lai > 0) |
| 1 | Chi hien thi da tat toan (con_lai = 0) |
| 2 | Hien thi tat ca |

### Sap xep

| Gia tri | Y nghia |
|---------|---------|
| 0 | Sap xep theo ngay chung tu |
| 1 | Sap xep theo khach hang |

### Cau truc bao cao

| Cot | Mo ta |
|-----|-------|
| ngay_ct | Ngay chung tu |
| so_ct | So chung tu |
| ma_kh | Ma khach hang |
| ten_kh | Ten khach hang |
| ma_gd | Ma giao dich |
| ten_gd | Ten giao dich |
| tien | So tien thanh toan |
| da_tat_toan | Da tat toan |
| con_lai | Con lai |

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBK03.php
namespace Diepxuan\Simba\Models\AR;

class RptBK03 extends Model
{
    protected $table = 'VW_AR_BK03'; // View bang ke thanh toan
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $casts = [
        'tien' => 'decimal:2',
        'da_tat_toan' => 'decimal:2',
        'con_lai' => 'decimal:2',
        'ngay_ct' => 'date',
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
    public function scopeUnpaid($query)
    {
        return $query->whereColumn('con_lai', '>', 0);
    }

    public function scopePaid($query)
    {
        return $query->whereColumn('con_lai', '<=', 0);
    }

    public function scopeByTransaction($query, $maGd)
    {
        return $query->where('ma_gd', $maGd);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBK03.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBK03 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BK03_GET';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pMa_nhkh',
        'pMa_plkh1',
        'pMa_plkh2',
        'pMa_plkh3',
        'pSo_ct1',
        'pSo_ct2',
        'pNgay1',
        'pNgay2',
        'pMa_gd',
        'pChi_xem',
        'pSap_xep',
        'pMa_nt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBK03Summary.php
class AsARGetBK03Summary extends StoredProcedure
{
    protected $procedure = 'SP_AR_BK03_SUMMARY';
    protected $params = [
        'pMa_cty',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
        'pGroupBy',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetGiaoDich.php
class AsARGetGiaoDich extends StoredProcedure
{
    protected $procedure = 'SP_DM_AIGD_GET';
    protected $params = ['pMa_cty'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/BangKeThanhToan.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class BangKeThanhToan extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BK03';

    // Filters
    public ?string $pMaKh = null;
    public ?string $pMaNhkh = null;
    public ?string $pMaPlkh1 = null;
    public ?string $pMaPlkh2 = null;
    public ?string $pMaPlkh3 = null;
    public ?string $pSoCt1 = null;
    public ?string $pSoCt2 = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public ?string $pMaGd = null;
    public int $pChiXem = 2; // 0: chua, 1: da, 2: all
    public bool $pSapXepKh = false;
    public string $pMaNt = 'VND';

    public Collection $pData;
    public Collection $pGiaoDichList;
    public array $pSummary = [];
    public array $pGiaoDichSummary = [];

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
        $this->loadGiaoDichList();
    }

    public function loadGiaoDichList(): void
    {
        $sp = new AsARGetGiaoDich();
        $this->pGiaoDichList = $sp->execute(['pMa_cty' => '001']);
    }

    public function loadReport(): void
    {
        $sp = new AsARGetBK03();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pMa_kh' => $this->pMaKh,
            'pMa_nhkh' => $this->pMaNhkh,
            'pMa_plkh1' => $this->pMaPlkh1,
            'pMa_plkh2' => $this->pMaPlkh2,
            'pMa_plkh3' => $this->pMaPlkh3,
            'pSo_ct1' => $this->pSoCt1,
            'pSo_ct2' => $this->pSoCt2,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMa_gd' => $this->pMaGd,
            'pChi_xem' => $this->pChiXem,
            'pSap_xep' => $this->pSapXepKh ? 1 : 0,
            'pMa_nt' => $this->pMaNt,
        ]);
        $this->calculateSummary();
        $this->calculateGiaoDichSummary();
    }

    public function calculateSummary(): void
    {
        $this->pSummary = [
            'tong_tien' => $this->pData->sum('tien'),
            'tong_da_tat_toan' => $this->pData->sum('da_tat_toan'),
            'tong_con_lai' => $this->pData->sum('con_lai'),
            'so_chung_tu' => $this->pData->count(),
        ];
    }

    public function calculateGiaoDichSummary(): void
    {
        $this->pGiaoDichSummary = $this->pData
            ->groupBy('ma_gd')
            ->map(function ($items) {
                return [
                    'ma_gd' => $items->first()->ma_gd,
                    'ten_gd' => $items->first()->ten_gd,
                    'tong_tien' => $items->sum('tien'),
                    'so_ct' => $items->count(),
                ];
            })
            ->values()
            ->toArray();
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.bang-ke-thanh-toan');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── bang-ke-thanh-toan.blade.php        (Form bao cao)
├── bang-ke-thanh-toan-results.blade.php  (Ket qua)
├── _bang-ke-thanh-toan-row.blade.php    (Dong bao cao)
├── _bang-ke-thanh-toan-summary.blade.php (Tong hop)
└── _bang-ke-thanh-toan-gd-summary.blade.php (Tong hop theo giao dich)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/bang-ke-thanh-toan', [BangKeThanhToan::class, 'render'])
            ->name('bang-ke-thanh-toan');
        Route::get('/bang-ke-thanh-toan/export', [BangKeThanhToan::class, 'exportExcel'])
            ->name('bang-ke-thanh-toan.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBK03.php | View bang ke |
| Model | laravel-simba | DMKH.php | Khach hang |
| Model | laravel-simba | DMNHKH.php | Nhom KH |
| Model | laravel-simba | ARPost2TT.php | Phan bo thanh toan |
| SP | laravel-simba | AsARGetBK03.php | Lay du lieu |
| SP | laravel-simba | AsARGetBK03Summary.php | Tong hop |
| SP | laravel-simba | AsARGetGiaoDich.php | Loai giao dich |
| Component | laravel-catalog | BangKeThanhToan.php | Form bao cao |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBK03 (View)
- [ ] Tao Livewire BangKeThanhToan
- [ ] Tao Views (form + results)
- [ ] Them Routes
- [ ] Implement loc theo loai giao dich
- [ ] Test bang ke voi du lieu thuc