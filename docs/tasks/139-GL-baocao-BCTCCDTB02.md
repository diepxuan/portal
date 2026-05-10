# Task 139: GLRptBCTCCDTB02

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Bao cao tai chinh chi tiet B02 tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLRptBCTCCDTB02.dll
- **Chuc nang:** Bao cao tai chinh chi tiet B02 (BCTCCDT - Bao cao tai chinh chi tiet)
- **Loai:** Report (Bao cao)
- **Assembly Title:** GLRptKPDA01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLRptBCTCCDTB02.dll/README.md`

---

## Cau truc du lieu

### Bang: Khong co bang (Report thuan tuy)

Module nay la report thuan tuy, khong co bang du lieu rieng. Du lieu duoc tao tu stored procedure.

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | Lookup tk |
| GLMAUBCTCT* | Cac mau BCTC | Lookup mau_bc |

---

## Form classes

### 1. frmGLRptBCTCCDTB02 (Form xem bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao tai chinh chi tiet B02
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTk | AsTextBox | tk | Tai khoan loc (LookupCodeName: TK) |
| lblTen_Tk | Label | ten_tk | Ten tai khoan |
| lblTk | Label | - | Nhan "Tai khoan" |
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
| SP_GL_RPT_BCTCCDTB02_GET | Lay du lieu bao cao B02 |
| SP_GL_RPT_BCTCCDTB02_RPT | Lay bao cao crystal |

### SP_GET (reference)

```sql
-- Lay du lieu bao cao B02
EXEC SP_GL_RPT_BCTCCDTB02_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk VARCHAR(50) = NULL,
    @pMau_bc INT = 0,
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
| mau_bc | Int | Mau bao cao (0: mac dinh) |
| ma_nt | String | Ma ngoai te (VND/NT) |

### Business Rules

1. **Ngay thoi gian**:
   - Bat buoc nhap ngay1, ngay2
   - ngay1 <= ngay2
   - Mac dinh: ngay1 = ngay dau thang, ngay2 = ngay cuoi thang

2. **Tai khoan loc**:
   - Tuy chon, neu de trong thi hien thi tat ca
   - AutoLookup tu bang DMTAIKHOAN

3. **Mau bao cao**:
   - Combo chon mau B02
   - Mac dinh = 0

4. **Tien te**:
   - VND / Ngoai te (an)
   - Mac dinh VND

### Export Options

- **Excel**: Xuat du lieu ra file Excel
- **Print**: In bao cao
- **Modify**: Chinh sua mau bao cao (Crystal Report)

---

## Mapping PHP

### 1. Report Service Class

```php
// app/Services/GL/Reports/BCTCCDTB02ReportService.php
namespace App\Services\GL\Reports;

class BCTCCDTB02ReportService
{
    protected $companyId;
    protected string $reportType = 'BCTCCDTB02';

    public function __construct(string $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getReport(
        ?string $ngay1,
        ?string $ngay2,
        ?string $tk = null,
        int $mau_bc = 0,
        string $ma_nt = 'VND',
        ?string $tieu_de = null
    ): array {
        // Goi stored procedure lay du lieu
        // Xu ly va tra ve mang ket qua
    }

    public function getTkName(string $tk): string
    {
        // Lay ten tai khoan tu DMTAIKHOAN
    }

    public function exportExcel(array $data, string $filename): bool
    {
        // Xuat bao cao ra Excel
    }
}
```

### 2. Livewire Component

```php
// app/Http/Livewire/GL/Reports/BCTCCDTB02Report.php
namespace App\Http\Livewire\GL\Reports;

class BCTCCDTB02Report extends Component
{
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public ?string $pTk = null;
    public string $pTenTk = '';
    public int $pMau_bc = 0;
    public string $pMa_nt = 'VND';
    public ?string $pTieu_de = null;
    public array $pData = [];
    public bool $pShowReport = false;

    protected $rules = [
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date|after_or_equal:pNgay1',
    ];

    public function updatedPTk($value): void
    {
        if ($value) {
            $this->pTenTk = $this->getTkName($value);
        } else {
            $this->pTenTk = '';
        }
    }

    public function generateReport(): void
    {
        $this->validate();
        $this->pData = $this->reportService->getReport(
            $this->pNgay1,
            $this->pNgay2,
            $this->pTk,
            $this->pMau_bc,
            $this->pMa_nt,
            $this->pTieu_de
        );
        $this->pShowReport = true;
    }

    public function exportExcel(): void
    {
        // Export logic
    }

    public function render(): View
    {
        return view('gl::reports.bctccdtb02');
    }
}
```

### 3. Views

```
resources/views/gl/reports/
├── bctccdtb02.blade.php      (Main report page)
├── bctccdtb02-filters.blade.php (Filter section)
└── bctccdtb02-table.blade.php (Report table)
```

### 4. Routes

```php
// routes/gl.php
Route::prefix('gl/reports')
    ->name('gl.reports.')
    ->group(function () {
        Route::get('/bctccdtb02', [BCTCCDTB02Report::class, 'render'])
            ->name('bctccdtb02');
        Route::post('/bctccdtb02/export', [BCTCCDTB02Report::class, 'exportExcel'])
            ->name('bctccdtb02.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | Portal | BCTCCDTB02ReportService.php | Chinh |
| Component | Portal | BCTCCDTB02Report.php | Livewire |
| Model | laravel-simba | DMTAIKHOAN.php | Lookup tai khoan |
| Model | laravel-simba | GLMAUBCTC*.php | Lookup mau bc |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao ReportService (BCTCCDTB02ReportService)
- [ ] Tao Livewire Component (BCTCCDTB02Report)
- [ ] Tao Views (filters + table)
- [ ] Them Routes
- [ ] Implement filter logic
- [ ] Implement export Excel
- [ ] Test report generation
- [ ] Test export functionality

---

## Ghi chu

- Day la report thuan tuy, khong co CRUD database
- Du lieu duoc tao tu stored procedure
- Ho tro drilldown (F5) - xem chi tiet chung tu
- Template Crystal Report can chuyen doi sang HTML/PDF
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
