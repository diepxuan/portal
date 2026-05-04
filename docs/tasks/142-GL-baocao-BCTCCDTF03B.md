# Task 142: GLRptBCTCCDTF03B

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Bao cao tai chinh chi tiet F03B tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLRptBCTCCDTF03B.dll
- **Chuc nang:** Bao cao tai chinh chi tiet F03B
- **Loai:** Report (Bao cao)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLRptBCTCCDTF03B.dll/README.md`

---

## Cau truc du lieu

### Bang: Khong co bang (Report thuan tuy)

Module nay la report thuan tuy, du lieu duoc tao tu stored procedure voi nhieu tham so loc.

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | Lookup cac tk_xaylap, tk_thietbi, etc. |
| DMSPCT | San pham chi tiet | Lookup ma_spct |

---

## Form classes

### 1. frmGLRptBCTCCDTF03B (Form xem bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao tai chinh chi tiet F03B
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTk_xaylap | AsTextBox | tk_xaylap | Tai khoan xay lap (Lookup: TK) |
| txtTk_Thietbi | AsTextBox | tk_thietbi | Tai khoan thiet bi (Lookup: TK) |
| txtTk_boithuong | AsTextBox | tk_boithuong | Tai khoan boi thuong (Lookup: TK) |
| txtTk_QLDA | AsTextBox | tk_qlda | Tai khoan quan ly du an (Lookup: TK) |
| txtTk_TuVan | AsTextBox | tk_tuvan | Tai khoan tu van (Lookup: TK) |
| txtTk_Khac | AsTextBox | tk_khac | Tai khoan khac (Lookup: TK) |
| txtMa_SPCT | AsTextBox | ma_spct | Ma san pham chi tiet (Lookup: SPCT) |
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
| SP_GL_RPT_BCTCCDTF03B_GET | Lay du lieu bao cao F03B |
| SP_GL_RPT_BCTCCDTF03B_RPT | Lay bao cao crystal |

### SP_GET (reference)

```sql
-- Lay du lieu bao cao F03B
EXEC SP_GL_RPT_BCTCCDTF03B_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk_xaylap VARCHAR(50) = NULL,
    @pTk_thietbi VARCHAR(50) = NULL,
    @pTk_boithuong VARCHAR(50) = NULL,
    @pTk_qlda VARCHAR(50) = NULL,
    @pTk_tuvan VARCHAR(50) = NULL,
    @pTk_khac VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL,
    @pMau_bc INT = 0,
    @pMa_nt VARCHAR(10) = 'VND'
```

---

## Business Logic

### Report Parameters

| Parameter | Loai | Mo ta |
|-----------|------|-------|
| ngay1, ngay2 | DateTime | Khoang thoi gian bao cao |
| tk_xaylap, tk_thietbi, tk_boithuong, tk_qlda, tk_tuvan, tk_khac | String | 6 tai khoan loc |
| ma_spct | String | Ma san pham chi tiet |
| mau_bc | Int | Mau bao cao |

### Business Rules

1. **Ngay thoi gian**:
   - Bat buoc nhap ngay1, ngay2
   - ngay1 <= ngay2

2. **Tai khoan loc**:
   - 6 tai khoan cho phep loc dong thoi
   - AutoLookup tu bang DMTAIKHOAN

3. **San pham chi tiet**:
   - Tuy chon, loc theo SPCT

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
// app/Services/GL/Reports/BCTCCDTF03BReportService.php
namespace App\Services\GL\Reports;

class BCTCCDTF03BReportService
{
    protected $companyId;
    protected string $reportType = 'BCTCCDTF03B';

    public function __construct(string $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getReport(array $params): array
    {
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
// app/Http/Livewire/GL/Reports/BCTCCDTF03BReport.php
namespace App\Http\Livewire\GL\Reports;

class BCTCCDTF03BReport extends Component
{
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public ?string $pTkXaylap = null;
    public ?string $pTkThietbi = null;
    public ?string $pTkBoithuong = null;
    public ?string $pTkQlda = null;
    public ?string $pTkTuvan = null;
    public ?string $pTkKhac = null;
    public ?string $pMaSpct = null;
    public int $pMau_bc = 0;
    public string $pMa_nt = 'VND';
    public ?string $pTieu_de = null;
    public array $pData = [];
    public bool $pShowReport = false;

    protected $rules = [
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date|after_or_equal:pNgay1',
    ];

    public function generateReport(): void
    {
        $this->validate();
        $this->pData = $this->reportService->getReport([
            'ngay1' => $this->pNgay1,
            'ngay2' => $this->pNgay2,
            'tk_xaylap' => $this->pTkXaylap,
            'tk_thietbi' => $this->pTkThietbi,
            'tk_boithuong' => $this->pTkBoithuong,
            'tk_qlda' => $this->pTkQlda,
            'tk_tuvan' => $this->pTkTuvan,
            'tk_khac' => $this->pTkKhac,
            'ma_spct' => $this->pMaSpct,
            'mau_bc' => $this->pMau_bc,
            'ma_nt' => $this->pMa_nt,
        ]);
        $this->pShowReport = true;
    }

    public function render(): View
    {
        return view('gl::reports.bctccdtf03b');
    }
}
```

### 3. Views

```
resources/views/gl/reports/
├── bctccdtf03b.blade.php         (Main report page)
├── bctccdtf03b-filters.blade.php (Filter section)
└── bctccdtf03b-table.blade.php   (Report table)
```

### 4. Routes

```php
// routes/gl.php
Route::prefix('gl/reports')
    ->name('gl.reports.')
    ->group(function () {
        Route::get('/bctccdtf03b', [BCTCCDTF03BReport::class, 'render'])
            ->name('bctccdtf03b');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | Portal | BCTCCDTF03BReportService.php | Chinh |
| Component | Portal | BCTCCDTF03BReport.php | Livewire |
| Model | laravel-simba | DMTAIKHOAN.php | Lookup tai khoan |
| Model | laravel-simba | DMSPCT.php | Lookup SPCT |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao ReportService (BCTCCDTF03BReportService)
- [ ] Tao Livewire Component (BCTCCDTF03BReport)
- [ ] Tao Views (filters + table)
- [ ] Them Routes
- [ ] Implement 6 TK filter logic
- [ ] Implement SPCT filter logic
- [ ] Test report generation
- [ ] Test export functionality

---

## Ghi chu

- Day la report co nhieu tham so loc (6 TK + SPCT)
- Ho tro drilldown (F5) - xem chi tiet chung tu
- Template Crystal Report can chuyen doi sang HTML/PDF