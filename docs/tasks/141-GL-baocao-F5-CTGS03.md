# Task 141: GLRptF5CTGS03

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Phan tich chuc nang va cau truc cua GLRptF5CTGS03.dll

## Chi tiet
- **DLL:** GLRptF5CTGS03.dll
- **Chuc nang:** Bao cao Chung tu ghi so 03 (CTGS - Chung tu ghi so)
- **Loai:** Report (Bao cao)
- **Assembly Title:** GLRptF5CTGS01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLRptF5CTGS03.dll/README.md`

---

## Cau truc du lieu

### Bang: Khong co bang (Drilldown Report)

Module nay la drilldown report, hien thi chi tiet tu bao cao cha.

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| GLRptTH01 | Bao cao tong hop | Drilldown tu TH01 |
| GLRptF5* | Cac bao cao F5 khac | Drilldown tu cac bao cao khac |

---

## Form classes

### 1. frmGLRptF5CTGS03 (Form xem chi tiet)
- **Ke thua:** frmDrilldownReport
- **Chuc nang:** Hien thi chi tiet Chung tu ghi so 03
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvBC | DataGridView | - | Luoi hien thi chi tiet CTGS |
| lblTieuDe | Label | - | Tieu de bao cao (dong) |

### Methods

| Method | Mo ta |
|--------|-------|
| InitOtherComponents() | Khoi tao components, focus vao dgvBC |
| CreateDrilldownArgument() | Tao tham so drilldown (neu can) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CTGS03_GET | Lay du lieu CTGS03 |

### SP_GET (reference)

```sql
-- Lay du lieu CTGS03
EXEC SP_GL_RPT_CTGS03_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_ct VARCHAR(10) = 'CTGS',
    @pTk VARCHAR(50) = NULL,
    @pTk_du VARCHAR(50) = NULL,
    @pMa_kh VARCHAR(50) = NULL
```

---

## Business Logic

### Drilldown Parameters

| Parameter | Loai | Mo ta |
|-----------|------|-------|
| ngay1, ngay2 | DateTime | Khoang thoi gian |
| ma_ct | String | Ma chung tu (CTGS) |
| tk | String | Tai khoan loc |
| tk_du | String | Tai khoan doi ung |
| ma_kh | String | Ma khach hang |

### Business Rules

1. **Nhan tham so tu bao cao cha**:
   - Tu dong nhan tu CreateDrilldownArgument()
   - Hien thi chi tiet theo tham so truyen

2. **Hien thi**:
   - Focus vao dgvBC khi khoi tao
   - Chi hien thi, khong cho phep sua

3. **Drilldown tiep**:
   - Click doi chuot -> drilldown tiep (neu co)
   - F5 -> xem chi tiet chung tu

---

## Mapping PHP

### 1. Report Service Class

```php
// app/Services/GL/Reports/CTGS03ReportService.php
namespace App\Services\GL\Reports;

class CTGS03ReportService
{
    protected $companyId;

    public function __construct(string $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getDetail(array $params): array
    {
        // Goi stored procedure lay chi tiet CTGS
        // Xu ly va tra ve mang ket qua
    }

    public function getDrilldownData(string $sttRec): array
    {
        // Lay du lieu drilldown theo stt_rec
    }
}
```

### 2. Livewire Component

```php
// app/Http/Livewire/GL/Reports/CTGS03Report.php
namespace App\Http\Livewire\GL\Reports;

class CTGS03Report extends Component
{
    public array $pParams = [];
    public array $pData = [];
    public string $pTieuDe = 'Chung tu ghi so 03';

    public function mount(array $params = []): void
    {
        $this->pParams = $params;
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->pData = $this->reportService->getDetail($this->pParams);
    }

    public function drilldown(array $row): void
    {
        // Drilldown to detail
    }

    public function render(): View
    {
        return view('gl::reports.ctgs03');
    }
}
```

### 3. Views

```
resources/views/gl/reports/
├── ctgs03.blade.php      (Main report page)
└── ctgs03-table.blade.php (Report table)
```

### 4. Routes

```php
// routes/gl.php
Route::prefix('gl/reports')
    ->name('gl.reports.')
    ->group(function () {
        Route::get('/ctgs03', [CTGS03Report::class, 'render'])
            ->name('ctgs03');
        Route::get('/ctgs03/drilldown', [CTGS03Report::class, 'drilldown'])
            ->name('ctgs03.drilldown');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | Portal | CTGS03ReportService.php | Chinh |
| Component | Portal | CTGS03Report.php | Livewire |
| Report | Portal | TH01Report.php | Drilldown tu TH01 |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao ReportService (CTGS03ReportService)
- [ ] Tao Livewire Component (CTGS03Report)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Implement drilldown logic
- [ ] Test drilldown tu TH01
- [ ] Test drilldown toi CTGS03
- [ ] Test export functionality

---

## Ghi chu

- Day la drilldown report, khong co filter rieng
- Nhan tham so tu bao cao cha
- Ho tro drilldown tiep theo (F5)