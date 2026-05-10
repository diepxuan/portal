# Task 154: GLRptBCTCCR01

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Bao cao tai chinh CCR01 tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLRptBCTCCR01.dll
- **Chuc nang:** Bao cao can doi phat sinh CCR01 (Can doi cong no)
- **Loai:** Report (Bao cao)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLRptBCTCCR01.dll/README.md`

---

## Cau truc du lieu

### Bang: Khong co bang (Report thuan tuy)

Module nay la report thuan tuy, du lieu duoc tao tu stored procedure.

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | Lookup tk |
| GLRptTH01 | Bao cao tong hop | Drilldown tu TH01 |

---

## Form classes

### 1. frmGLRptBCTCCR01 (Form xem bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao can doi phat sinh theo tai khoan
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTk | AsTextBox | tk | Tai khoan loc (LookupCodeName: TK) |
| lblTk | Label | - | Nhan "Tai khoan" |
| txtBac | AsTextNumeric | bac | So bac hien thi (mac dinh: 9) |
| lblbac | Label | - | Nhan "In den bac" |
| chkTK_sc | CheckBox | tk_sc | Len cho tai khoan so chi tiet |
| txtNgay1 | AsMaskedTextBox | ngay1 | Tu ngay |
| txtNgay2 | AsMaskedTextBox | ngay2 | Den ngay |
| cboKyBc | ComboBox | ky_bc | Ky bao cao |
| cboMau_bc | ComboBox | mau_bc | Mau bao cao |
| txtMa_Nt | AsTextBox | ma_nt | Ma ngoai te (an) |
| optVND | RadioButton | - | Tien VND (an) |
| optNt | RadioButton | - | Tien nuoc ngoai (an) |
| txtTieu_De | TextBox | tieu_de | Tieu de bao cao |
| dgvBC | DataGridView | - | Luoi hien thi du lieu bao cao |

### Action Buttons

| Button | Mo ta |
|--------|-------|
| cmdOk | Thuc hien tao bao cao |
| cmdCancel | Huy bo |
| cmdExcel | Xuat Excel |
| cmdModifyReport | Sua mau bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CCR01_GET | Lay du lieu bao cao CCR01 |
| SP_GL_RPT_CCR01_RPT | Lay bao cao crystal |

### SP_GET (reference)

```sql
-- Lay du lieu bao cao CCR01
EXEC SP_GL_RPT_CCR01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk VARCHAR(50) = NULL,
    @pBac INT = 9,
    @pTk_sc BIT = 0,
    @pMa_nt VARCHAR(10) = 'VND',
    @pTieu_de NVARCHAR(200) = NULL
```

---

## Business Logic

### Report Parameters

| Parameter | Loai | Mo ta |
|-----------|------|-------|
| ngay1, ngay2 | DateTime | Khoang thoi gian bao cao |
| tk | String | Tai khoan loc (tuy chon) |
| bac | Int | So bac hien thi (1-9, mac dinh: 9) |
| tk_sc | Boolean | Len cho tai khoan so chi tiet |
| ma_nt | String | Ma ngoai te (VND/NT) |

### Business Rules

1. **Bac tai khoan**:
   - Mac dinh = 9
   - Chi hien thi cac cap co bac <= bac
   - Ví du: bac = 3 -> hien thi TK 1, 11, 111

2. **Tai khoan so chi tiet**:
   - Checkbox tk_sc de xem them tai khoan so chi tiet
   - Hien thi chi tiet hon

3. **Ngoai te**:
   - VND / Ngoai te (an)
   - Mac dinh VND

### Drilldown (F5)

| Phim | Chuc nang |
|------|-----------|
| F5 | Xem so chi tiet cua tai khoan |
| Ctrl+F5 | Xem so chi tiet |
| Shift+F5 | Can doi phat sinh cong no |
| F7 | Xem |
| F9 | In |

---

## Mapping PHP

### 1. Report Service Class

```php
// app/Services/GL/Reports/CCR01ReportService.php
namespace App\Services\GL\Reports;

class CCR01ReportService
{
    protected $companyId;
    protected string $reportType = 'CCR01';

    public function __construct(string $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getReport(array $params): array
    {
        // Goi stored procedure lay du lieu
        // Xu ly phan cap theo bac
    }

    public function getTkName(string $tk): string
    {
        // Lay ten tai khoan tu DMTAIKHOAN
    }

    public function createDrilldownArgument(array $row, string $modifier = ''): array
    {
        // Tao tham so drilldown
    }
}
```

### 2. Livewire Component

```php
// app/Http/Livewire/GL/Reports/CCR01Report.php
namespace App\Http\Livewire\GL\Reports;

class CCR01Report extends Component
{
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public ?string $pTk = null;
    public int $pBac = 9;
    public bool $pTkSc = false;
    public string $pMa_nt = 'VND';
    public ?string $pTieu_de = null;
    public array $pData = [];
    public bool $pShowReport = false;

    protected $rules = [
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date|after_or_equal:pNgay1',
        'pBac' => 'required|integer|between:1,9',
    ];

    public function generateReport(): void
    {
        $this->validate();
        $this->pData = $this->reportService->getReport([
            'ngay1' => $this->pNgay1,
            'ngay2' => $this->pNgay2,
            'tk' => $this->pTk,
            'bac' => $this->pBac,
            'tk_sc' => $this->pTkSc,
            'ma_nt' => $this->pMa_nt,
        ]);
        $this->pShowReport = true;
    }

    public function drilldown(array $row, string $modifier = ''): void
    {
        $args = $this->reportService->createDrilldownArgument($row, $modifier);
        // Chuyen huong den trang drilldown
    }

    public function render(): View
    {
        return view('gl::reports.ccr01');
    }
}
```

### 3. Views

```
resources/views/gl/reports/
├── ccr01.blade.php           (Main report page)
├── ccr01-filters.blade.php   (Filter section)
└── ccr01-table.blade.php     (Report table)
```

### 4. Routes

```php
// routes/gl.php
Route::prefix('gl/reports')
    ->name('gl.reports.')
    ->group(function () {
        Route::get('/ccr01', [CCR01Report::class, 'render'])->name('ccr01');
        Route::get('/ccr01/drilldown', [CCR01Report::class, 'drilldown'])->name('ccr01.drilldown');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | Portal | CCR01ReportService.php | Chinh |
| Component | Portal | CCR01Report.php | Livewire |
| Model | laravel-simba | DMTAIKHOAN.php | Lookup tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao ReportService (CCR01ReportService)
- [ ] Tao Livewire Component (CCR01Report)
- [ ] Tao Views (filters + table)
- [ ] Them Routes
- [ ] Implement filter logic
- [ ] Implement drilldown (F5/CTGS)
- [ ] Test report generation
- [ ] Test export functionality

---

## Ghi chu

- Day la report can doi phat sinh theo cau truc phan cap TK
- Ho tro drilldown (F5) - xem chi tiet chung tu
- Ho tro xem den bac n (1-9)
- Template Crystal Report can chuyen doi sang HTML/PDF
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
