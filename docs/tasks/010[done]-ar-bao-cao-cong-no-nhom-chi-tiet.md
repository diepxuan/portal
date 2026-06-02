# Task 010: ARRptBCCN04

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bao cao cong no theo nhom khach hang va chi tiet tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBCCN04.

## Chi tiet
- **DLL:** ARRptBCCN04.dll
- **Chuc nang:** Bao cao ket hop giua tong hop theo nhom khach hang va chi tiet tung khach hang trong nhom, co drill-down
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBCCN04.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMNHKH | Danh muc nhom KH | FK ma_nhkh |
| DMKH | Danh muc khach hang | FK ma_kh, FK ma_nhkh |
| AR4CT | Chung tu chi tiet | Phat sinh theo ma_kh |
| ARBalance | So du | Du_dk, du_ck |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMNHKH | Nhom KH | Lookup ten_nhkh |
| DMKH | Khach hang | Lookup ten_kh, ma_nhkh |

---

## Form classes

### 1. frmARRptBCCN04 (Bao cao nhom va chi tiet)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao theo nhom KH, drill-down xuong chi tiet KH
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_NhKh | AsTextBox | Ma nhom KH (AutoLookup) |
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao |
| dgvBC | DataGridView | Du lieu bao cao (nhom + chi tiet) |
| btnIn | Button | Nut in |
| btnXuat | Button | Nut xuat Excel |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BC04_GET | Lay bao cao nhom va chi tiet |
| SP_AR_BC04_GETGROUP | Lay tong hop theo nhom |
| SP_AR_BC04_GETDETAIL | Lay chi tiet KH trong nhom |
| SP_AR_BC04_EXPORT | Xuat Excel |

### SP_GET (reference)

```sql
-- Lay bao cao nhom va chi tiet
EXEC SP_AR_BC04_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_nhkh VARCHAR(50) = NULL,
    @pMa_kh VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_nt VARCHAR(10) = 'VND',
    @pShowDetail BIT = 1
```

---

## Business Logic

### Cau truc bao cao

1. **Dong nhom** (IsGroup = true):
   | Cot | Mo ta |
   |-----|-------|
   | ma_nhkh | Ma nhom KH |
   | ten_nhkh | Ten nhom |
   | du_dk | So du dau ky tong hop |
   | ps_no | Phat sinh no tong hop |
   | ps_co | Phat sinh co tong hop |
   | du_ck | So du cuoi ky tong hop |

2. **Dong chi tiet** (IsGroup = false):
   | Cot | Mo ta |
   |-----|-------|
   | ma_kh | Ma khach hang |
   | ten_kh | Ten khach hang |
   | du_dk | So du dau ky KH |
   | ps_no | Phat sinh no KH |
   | ps_co | Phat sinh co KH |
   | du_ck | So du cuoi ky KH |

### Drill-down

- Click vao dong nhom -> Hien thi cac KH trong nhom
- Click vao dong KH -> Hien thi chi tiet chung tu

### Tinh toan nhom

```sql
-- Tong hop nhom
SELECT
    nh.ma_nhkh,
    nh.ten_nhkh,
    SUM(kh.du_dk) as du_dk,
    SUM(kh.ps_no) as ps_no,
    SUM(kh.ps_co) as ps_co,
    SUM(kh.du_ck) as du_ck
FROM DMNHKH nh
LEFT JOIN DMKH kh ON kh.ma_nhkh = nh.ma_nhkh
WHERE nh.ma_cty = @pMa_cty
GROUP BY nh.ma_nhkh, nh.ten_nhkh
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBCCN04.php
namespace Diepxuan\Simba\Models\AR;

class RptBCCN04 extends Model
{
    protected $table = 'VW_AR_BC04'; // View bao cao
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $casts = [
        'du_dk' => 'decimal:2',
        'ps_no' => 'decimal:2',
        'ps_co' => 'decimal:2',
        'du_ck' => 'decimal:2',
        'is_group' => 'boolean',
    ];

    // Relationships
    public function nhomKhachHang()
    {
        return $this->belongsTo(DMNHKH::class, 'ma_nhkh', 'ma_nhkh');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    // Scopes
    public function scopeGroups($query)
    {
        return $query->where('is_group', true);
    }

    public function scopeDetails($query)
    {
        return $query->where('is_group', false);
    }

    public function scopeByNhomKh($query, $maNhkh)
    {
        return $query->where('ma_nhkh', $maNhkh);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN04.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBCCN04 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC04_GET';
    protected $params = [
        'pMa_cty',
        'pMa_nhkh',
        'pMa_kh',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
        'pShowDetail',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN04Group.php
class AsARGetBCCN04Group extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC04_GETGROUP';
    protected $params = [
        'pMa_cty',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN04Detail.php
class AsARGetBCCN04Detail extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC04_GETDETAIL';
    protected $params = [
        'pMa_cty',
        'pMa_nhkh',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/CongNoNhomVaChiTiet.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class CongNoNhomVaChiTiet extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BCCN04';

    public ?string $pMaNhkh = null;
    public ?string $pMaKh = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pMaNt = 'VND';
    public bool $pShowDetail = true;
    public Collection $pData;
    public array $pSummary = [];
    public ?string $pExpandedGroup = null;
    public Collection $pGroupDetail;

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
    }

    public function loadReport(): void
    {
        $sp = new AsARGetBCCN04();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pMa_nhkh' => $this->pMaNhkh,
            'pMa_kh' => $this->pMaKh,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMa_nt' => $this->pMaNt,
            'pShowDetail' => $this->pShowDetail,
        ]);
        $this->calculateSummary();
    }

    public function toggleGroup(string $maNhkh): void
    {
        if ($this->pExpandedGroup === $maNhkh) {
            $this->pExpandedGroup = null;
            $this->pGroupDetail = collect();
        } else {
            $this->pExpandedGroup = $maNhkh;
            $sp = new AsARGetBCCN04Detail();
            $this->pGroupDetail = $sp->execute([
                'pMa_cty' => '001',
                'pMa_nhkh' => $maNhkh,
                'pNgay1' => $this->pNgay1,
                'pNgay2' => $this->pNgay2,
                'pMa_nt' => $this->pMaNt,
            ]);
        }
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.cong-no-nhom-va-chi-tiet');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── cong-no-nhom-va-chi-tiet.blade.php        (Form bao cao)
├── cong-no-nhom-va-chi-tiet-results.blade.php (Ket qua)
├── _cong-no-nhom-row.blade.php               (Dong nhom)
├── _cong-no-nhom-detail.blade.php             (Chi tiet KH)
└── _cong-no-nhom-summary.blade.php            (Tong ket)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/cong-no-nhom-va-chi-tiet', [CongNoNhomVaChiTiet::class, 'render'])
            ->name('cong-no-nhom-va-chi-tiet');
        Route::get('/cong-no-nhom-va-chi-tiet/{maNhkh}/toggle', [CongNoNhomVaChiTiet::class, 'toggleGroup'])
            ->name('cong-no-nhom-va-chi-tiet.toggle');
        Route::get('/cong-no-nhom-va-chi-tiet/export', [CongNoNhomVaChiTiet::class, 'exportExcel'])
            ->name('cong-no-nhom-va-chi-tiet.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBCCN04.php | View bao cao |
| Model | laravel-simba | DMNHKH.php | Nhom KH |
| Model | laravel-simba | DMKH.php | Khach hang |
| SP | laravel-simba | AsARGetBCCN04.php | Lay du lieu |
| SP | laravel-simba | AsARGetBCCN04Group.php | Lay nhom |
| SP | laravel-simba | AsARGetBCCN04Detail.php | Lay chi tiet KH |
| Component | laravel-catalog | CongNoNhomVaChiTiet.php | Form bao cao |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBCCN04 (View)
- [ ] Tao Livewire CongNoNhomVaChiTiet
- [ ] Tao Views (report + drilldown)
- [ ] Them Routes
- [ ] Implement toggle expand/collapse nhom
- [ ] Test bao cao voi du lieu thuc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
\n## Portal implementation status\n\n- **Status:** DONE (route shell/read-only report)\n- **Source:** SimbaReportRegistry / SimbaRouteRegistry, sysReportInfo-backed route anchor\n- **Note:** Report shell hiển thị metadata và chưa execute SP khi chưa đối chiếu đủ tham số/payload/side effect.\n
