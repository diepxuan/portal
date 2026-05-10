# Task 008: ARRptBCCN01

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bao cao so chi tiet cong no theo tai khoan va khach hang tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBCCN01.

## Chi tiet
- **DLL:** ARRptBCCN01.dll, ARRptBCCN01a.dll
- **Chuc nang:** Bao cao so chi tiet cong no - hien thi so du cong no chi tiet theo tung tai khoan va khach hang voi drill-down
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBCCN01.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| DMTK | Danh muc tai khoan | FK ma_tk (tk_cn=1) |
| AR4PH | Chung tu AR4 header | Phat sinh no/co |
| AR4CT | Chung tu AR4 chi tiet | Chi tiet phat sinh |
| ARBalance | So du dau/cuoi ky | Du_dk, du_ck |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ten_kh |
| DMTK | Tai khoan | Lookup ten_tk (tk_cn=1) |

---

## Form classes

### 1. frmARRptBCCN01 (So chi tiet cong no)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi so chi tiet cong no, loc, drill-down, xuat bao cao
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Tk | AsTextBox | Ma tai khoan (AutoLookup, tk_cn=1) |
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao |
| cboMau_bc | ComboBox | Mau bao cao |
| optVND | RadioButton | Hien thi VND |
| optNt | RadioButton | Hien thi ngoai te |
| dgvBC | DataGridView | Du lieu bao cao |
| btnIn | Button | Nut in bao cao |
| btnXuat | Button | Nut xuat Excel |

### 2. frmARRptBCCN01a (So chi tiet Excel nang cao)
- **Ke thua:** frmDrilldownReport
- **Chuc nang:** Xuat Excel voi drill-down chi tiet

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BC01_GET | Lay du lieu bao cao |
| SP_AR_BC01_GETBYID | Lay chi tiet 1 KH |
| SP_AR_BC01_DRILLDOWN | Lay chi tiet chung tu |
| SP_AR_BC01_EXPORT | Lay du lieu xuat Excel |

### SP_GET (reference)

```sql
-- Lay du lieu so chi tiet cong no
EXEC SP_AR_BC01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_tk VARCHAR(50) = NULL,
    @pMa_kh VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_nt VARCHAR(10) = 'VND',
    @pMau_bc VARCHAR(50) = 'DEFAULT'
```

---

## Business Logic

### Tinh toan so du

1. **So du dau ky**:
   ```sql
   du_dk = (SELECT SUM(ps_no - ps_co) FROM AR4CT
            WHERE ngay_ct < @pNgay1 AND ma_kh = @pMa_kh)
   ```

2. **Phat sinh no**:
   ```sql
   ps_no = (SELECT SUM(ps_no_nt) FROM AR4CT
            WHERE ngay_ct BETWEEN @pNgay1 AND @pNgay2 AND ma_kh = @pMa_kh)
   ```

3. **Phat sinh co**:
   ```sql
   ps_co = (SELECT SUM(ps_co_nt) FROM AR4CT
            WHERE ngay_ct BETWEEN @pNgay1 AND @pNgay2 AND ma_kh = @pMa_kh)
   ```

4. **So du cuoi ky**:
   ```
   du_ck = du_dk + ps_no - ps_co
   ```

### Drill-down (F4)

- Click vao dong KH -> Hien thi chi tiet chung tu
- Hien thi tat ca chung tu trong ky cua KH do
- Cho phep xem chi tiet nhieu cap

### Xuat bao cao

- Crystal Report: In an chuan
- Excel Export: Xu ly du lieu

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBCCN01.php
namespace Diepxuan\Simba\Models\AR;

class RptBCCN01 extends Model
{
    protected $table = 'VW_AR_BC01'; // View bao cao
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

    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'ma_tk', 'ma_tk');
    }

    // Scopes
    public function scopeByAccount($query, $maTk)
    {
        return $query->where('ma_tk', $maTk);
    }

    public function scopeByCustomer($query, $maKh)
    {
        return $query->where('ma_kh', $maKh);
    }

    public function scopeByPeriod($query, $ngay1, $ngay2)
    {
        return $query->whereBetween('ngay_ct', [$ngay1, $ngay2]);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN01.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBCCN01 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC01_GET';
    protected $params = [
        'pMa_cty',
        'pMa_tk',
        'pMa_kh',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
        'pMau_bc',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBCCN01Drilldown.php
class AsARGetBCCN01Drilldown extends StoredProcedure
{
    protected $procedure = 'SP_AR_BC01_DRILLDOWN';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/SoChiTietCongNo.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class SoChiTietCongNo extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BCCN01';

    public ?string $pMaTk = null;
    public ?string $pMaKh = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pMaNt = 'VND';
    public string $pMauBc = 'DEFAULT';
    public string $pCurrencyType = 'VND'; // 'VND' | 'NT'
    public Collection $pData;
    public array $pSummary = [];
    public ?string $pDrilldownMaKh = null;
    public Collection $pDrilldownData;

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
    }

    public function loadReport(): void
    {
        $sp = new AsARGetBCCN01();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pMa_tk' => $this->pMaTk,
            'pMa_kh' => $this->pMaKh,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMa_nt' => $this->pMaNt,
            'pMau_bc' => $this->pMauBc,
        ]);
        $this->calculateSummary();
    }

    public function drilldown(string $maKh): void
    {
        $sp = new AsARGetBCCN01Drilldown();
        $this->pDrilldownMaKh = $maKh;
        $this->pDrilldownData = $sp->execute([
            'pMa_cty' => '001',
            'pMa_kh' => $maKh,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMa_nt' => $this->pMaNt,
        ]);
    }

    public function exportExcel(): void
    {
        // Export Excel
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.so-chi-tiet-cong-no');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── so-chi-tiet-cong-no.blade.php        (Form bao cao)
├── so-chi-tiet-cong-no-results.blade.php (Bang ket qua)
├── _so-chi-tiet-cong-no-row.blade.php   (Dong bao cao)
└── _so-chi-tiet-cong-no-drilldown.blade.php (Chi tiet drilldown)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/so-chi-tiet-cong-no', [SoChiTietCongNo::class, 'render'])
            ->name('so-chi-tiet-cong-no');
        Route::get('/so-chi-tiet-cong-no/{maKh}/drilldown', [SoChiTietCongNo::class, 'drilldown'])
            ->name('so-chi-tiet-cong-no.drilldown');
        Route::get('/so-chi-tiet-cong-no/export', [SoChiTietCongNo::class, 'exportExcel'])
            ->name('so-chi-tiet-cong-no.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBCCN01.php | View bao cao |
| Model | laravel-simba | DMKH.php | Lookup KH |
| Model | laravel-simba | DMTK.php | Lookup TK |
| SP | laravel-simba | AsARGetBCCN01.php | Lay du lieu |
| SP | laravel-simba | AsARGetBCCN01Drilldown.php | Chi tiet drilldown |
| Component | laravel-catalog | SoChiTietCongNo.php | Form bao cao |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBCCN01 (View)
- [ ] Tao Livewire SoChiTietCongNo (report)
- [ ] Tao Views (report + drilldown)
- [ ] Them Routes
- [ ] Implement drill-down chi tiet
- [ ] Test bao cao voi du lieu thuc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
