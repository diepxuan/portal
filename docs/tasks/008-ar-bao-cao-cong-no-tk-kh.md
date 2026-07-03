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

Nguon chuan: `simba-docs/data/sysReportInfo.md` va `diepxuan/laravel-simba/docs/procedures/AR/procedures.md`.

| SP Name | Menu | Ma mau | Report | Mo ta |
|---------|------|--------|--------|-------|
| asARRptBCCN01 | 06.30.14 | 01 | ARBCCN011.rpt | So chi tiet cong no mot khach hang |
| asARRptBCCN01SL | 06.30.38 | 02 | ARBCCN012.rpt | Bien the co so luong |

### asARRptBCCN01 parameters

| Name | Type | Required | Source |
|------|------|----------|--------|
| ma_cty | nvarchar(3) | No | Company context |
| Ngay1 | smalldatetime | No | txtNgay1 |
| Ngay2 | smalldatetime | No | txtNgay2 |
| Tk | nvarchar(20) | No | txtTk |
| ma_kh | nvarchar(20) | No | txtMa_Kh |
| ma_nt | nvarchar(3) | No | txtMa_Nt |

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
// diepxuan/laravel-simba/src/StoredProcedures/AsARRptBCCN01.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARRptBCCN01
{
    protected $procedure = 'asARRptBCCN01';
    protected $params = ['ma_cty', 'Ngay1', 'Ngay2', 'Tk', 'ma_kh', 'ma_nt'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/So/Rpt/Arrptbccn01.php
namespace Diepxuan\Catalog\Http\Livewire\So\Rpt;

class Arrptbccn01 extends Component
{
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public ?string $pTk = null;
    public ?string $pMa_kh = null;
    public ?string $pMa_nt = '';
    public array $rows = [];

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
    }

    public function loadReport(): void
    {
        $this->pData = AsARRptBCCN01::call([
            'ma_cty' => '001',
            'Ngay1' => $this->pNgay1,
            'Ngay2' => $this->pNgay2,
            'Tk' => $this->pTk,
            'ma_kh' => $this->pMa_kh,
            'ma_nt' => $this->pMa_nt,
        ]);
    }

    public function exportExcel(): void
    {
        // Export Excel
    }

    public function render(): View
    {
        return view('catalog::so.rpt.arrptbccn01');
    }
}
```

### 4. Views

```
diepxuan/laravel-catalog/resources/views/so/rpt/
└── arrptbccn01.blade.php
```

### 5. Routes

```php
// diepxuan/laravel-catalog/routes/web.php
['_simba-source/so/rpt/arrptbccn01', name: 'so.rpt.arrptbccn01']

// Public canonical URL:
/simba/so/rpt/arrptbccn01
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKH.php | Lookup KH |
| Model | laravel-simba | DMTK.php | Lookup TK |
| SP | laravel-simba | AsARRptBCCN01.php | Lay du lieu |
| Component | laravel-catalog | So/Rpt/Arrptbccn01.php | Form bao cao |
| View | laravel-catalog | so/rpt/arrptbccn01.blade.php | Filter + grid |

---

## Progress Checklist

- [x] Phan tich yeu cau & review task nay
- [x] Tim kiem mapping SP tu DLL
- [x] Sua Stored Procedure class AsARRptBCCN01 theo tham so Simba docs
- [x] Tao Livewire So/Rpt/Arrptbccn01 (report)
- [x] Tao view filter + grid
- [x] Them route source so.rpt.arrptbccn01 vao canonical /simba/so/rpt/arrptbccn01
- [ ] Implement drill-down chi tiet
- [ ] Test bao cao voi du lieu thuc tren `http://portal.diepxuan.corp/simba/so/rpt/arrptbccn01`
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** IMPLEMENTED PARTIAL — route canonical co Livewire report page, SP wrapper dung tham so docs; drilldown/export chua implement.

## Portal implementation status

- **Status:** IMPLEMENTED PARTIAL (filter + SP-backed grid)
- **Route:** `/simba/so/rpt/arrptbccn01`
- **Website verification URL:** `http://portal.diepxuan.corp/simba/so/rpt/arrptbccn01`
- **Menu:** `06.30.14`
- **SP:** `asARRptBCCN01`
- **Report:** `ARBCCN011.rpt`
- **Grid rendering:** Giu HTML `<table>` thay vi `Diepxuan\Support\Collection::toMarkdownTable()` de co scroll ngang, hover row, header style va canh cot so trong UI. Style table tham chieu quy tac cua `Collection`: co cot thu tu, null thanh rong, boolean 1/0, normalize UTF-8, cot tien/phat sinh/so du canh phai.
- **Note:** Page chi read qua SP, khong tao SQL/schema moi. Drilldown/export de phase sau.
