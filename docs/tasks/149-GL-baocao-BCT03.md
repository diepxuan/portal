# Task 149: GLRptBCT03

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang To khai thue GTGT tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLRptBCT03.dll
- **Chuc nang:** To khai gia tri gia tang (GTGT - Goods and Services Tax)
- **Loai:** Report (Bao cao thue)
- **Assembly Title:** To khai gia tri gia tang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLRptBCT03.dll/README.md`

---

## Cau truc du lieu

### Bang: BCT03 (To khai GTGT)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | So thu tu ban ghi |
| ma_so2 | varchar | 20 | Ma so chi tieu |
| doanh_so | decimal(18,2) | - | Doanh so |
| thue | decimal(18,2) | - | Thue GTGT |
| cong_thuc | varchar | 200 | Cong thuc tinh toan |
| usertype | int | 4 | Loai nguoi dung (0: binh thuong, 1: quan tri) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTHUESuat | Danh muc thue | Lookup ma_so2 |
| GLMAUBCT03 | Mau to khai | Lookup mau |

---

## Form classes

### 1. frmGLRptBCT03 (Form xem to khai)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi to khai GTGT, cho phep chinh sua truc tiep tren grid
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtNgay1 | AsMaskedTextBox | ngay1 | Tu ngay |
| txtNgay2 | AsMaskedTextBox | ngay2 | Den ngay |
| cboKyBc | ComboBox | ky_bc | Ky bao cao |
| cboMau_bc | ComboBox | mau_bc | Mau to khai |
| txtMa_Nt | AsTextBox | ma_nt | Ma ngoai te (an) |
| optVND | RadioButton | - | Tien VND (an) |
| optNt | RadioButton | - | Tien nuoc ngoai (an) |
| txtTieu_De | TextBox | tieu_de | Tieu de bao cao |
| dgvBC | DataGridView | - | Luoi hien thi cac chi tieu GTGT |

### Action Buttons

| Button | Mo ta |
|--------|-------|
| cmdOk | Thuc hien tao to khai |
| cmdCancel | Huy bo |
| cmdExcel | Xuat Excel |
| cmdModifyReport | Sua mau bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCT03_GET | Lay du lieu to khai GTGT |
| SP_GL_RPT_BCT03_DIEUCHINH | Dieu chinh so lieu to khai |
| SP_GL_RPT_BCT03_RPT | Lay bao cao crystal |

### SP_GET (reference)

```sql
-- Lay du lieu to khai GTGT
EXEC SP_GL_RPT_BCT03_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMau_bc INT = 0,
    @pMa_nt VARCHAR(10) = 'VND'
```

### SP_DIEUCHINH (reference)

```sql
-- Dieu chinh so lieu to khai
EXEC SP_GL_RPT_BCT03_DIEUCHINH
    @pMa_cty VARCHAR(50),
    @pThang INT,
    @pNam INT,
    @pStt_rec VARCHAR(50),
    @pDoanh_so DECIMAL(18,2),
    @pThue DECIMAL(18,2)
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ngay1 | 'Tu ngay khong duoc trong' |
| Required | ngay2 | 'Den ngay khong duoc trong' |
| Range | ngay1, ngay2 | 'Phai cung thang' |

### Business Logic

1. **Tinh toan tu dong**:
   - Cong thuc tinh toan giua cac chi tieu
   - Vi du: [01] + [02] - [03] = Tong
   - Cap nhat tu dong khi co thay doi

2. **Chinh sua truc tiep**:
   - CellEnter: Focus vao cell
   - CellEndEdit: Tinh toan lai cong thuc
   - Chi cho phep sua neu co quyen (usertype = 1)

3. **Dieu chinh so lieu**:
   - Goi DieuChinhBCT03 de cap nhat xuong database
   - Tham so: ma_cty, thang, nam, stt_rec, doanh_so, thue

4. **Thong tin thang/nam**:
   - Lay tu txtNgay1.Value (Month, Year)
   - Dung cho dieu chinh du lieu

---

## Mapping PHP

### 1. Report Service Class

```php
// app/Services/GL/Reports/BCT03ReportService.php
namespace App\Services\GL\Reports;

class BCT03ReportService
{
    protected $companyId;
    protected string $reportType = 'BCT03';

    public function __construct(string $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getReport(array $params): array
    {
        // Goi stored procedure lay du lieu
        // Xu ly cong thuc tinh toan
    }

    public function adjust(array $data): bool
    {
        // Dieu chinh so lieu to khai
        // Goi SP_DIEUCHINH
    }

    public function calculateFormulas(array $items): array
    {
        // Tinh toan cong thuc giua cac chi tieu
    }
}
```

### 2. Livewire Component

```php
// app/Http/Livewire/GL/Reports/BCT03Report.php
namespace App\Http\Livewire\GL\Reports;

class BCT03Report extends Component
{
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public int $pMau_bc = 0;
    public string $pMa_nt = 'VND';
    public ?string $pTieu_de = null;
    public array $pData = [];
    public bool $pShowReport = false;
    public bool $pCanEdit = false;

    protected $rules = [
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date',
    ];

    public function mount(): void
    {
        $this->pCanEdit = auth()->user()->usertype === 1;
    }

    public function generateReport(): void
    {
        $this->validate();
        $this->pData = $this->reportService->getReport([
            'ngay1' => $this->pNgay1,
            'ngay2' => $this->pNgay2,
            'mau_bc' => $this->pMau_bc,
            'ma_nt' => $this->pMa_nt,
        ]);
        $this->pShowReport = true;
    }

    public function cellUpdated(string $sttRec, string $field, $value): void
    {
        if (!$this->pCanEdit) {
            return;
        }
        // Cap nhat va tinh lai cong thuc
    }

    public function render(): View
    {
        return view('gl::reports.bct03');
    }
}
```

### 3. Views

```
resources/views/gl/reports/
├── bct03.blade.php           (Main report page)
├── bct03-table.blade.php    (Editable grid)
└── bct03-formulas.blade.php (Formula display)
```

### 4. Routes

```php
// routes/gl.php
Route::prefix('gl/reports')
    ->name('gl.reports.')
    ->group(function () {
        Route::get('/bct03', [BCT03Report::class, 'render'])->name('bct03');
        Route::post('/bct03/adjust', [BCT03Report::class, 'adjust'])->name('bct03.adjust');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | Portal | BCT03ReportService.php | Chinh |
| Component | Portal | BCT03Report.php | Livewire |
| Model | laravel-simba | DMTHUESuat.php | Lookup ma_so2 |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao ReportService (BCT03ReportService)
- [ ] Tao Livewire Component (BCT03Report)
- [ ] Tao Views (editable grid)
- [ ] Them Routes
- [ ] Implement editable cell logic
- [ ] Implement formula calculation
- [ ] Test adjust functionality
- [ ] Test export functionality

---

## Ghi chu

- Day la report co the chinh sua truc tiep tren grid
- Chi quan tri moi duoc phep sua so lieu
- Ho tro tinh toan cong thuc tu dong
- Theo quy dinh To khai GTGT cua Tong cuc Thue VN
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
