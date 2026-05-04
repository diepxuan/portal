# Task 144: GLRptTH01

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Bao cao tong hop 01 tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLRptTH01.dll
- **Chuc nang:** Bao cao tong hop 01 (TH - Tong hop)
- **Loai:** Report (Bao cao)
- **Assembly Title:** GLRptF5TH01.vb
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLRptTH01.dll/README.md`

---

## Cau truc du lieu

### Bang: Khong co bang (Report thuan tuy)

Module nay la report tong hop, du lieu duoc tao tu stored procedure voi nhieu tham so loc.

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | Lookup tk, tk_du |
| DMKHACHHANG | Danh muc khach hang | Lookup ma_kh |
| DMBOPHAN | Danh muc bo phan | Lookup ma_bp |
| DMHOPDONG | Danh muc hop dong | Lookup ma_hd |
| DMSANPHAM | San pham | Lookup ma_spct |

---

## Form classes

### 1. frmGLRptTH01 (Form xem bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao tong hop 01 voi nhieu tieu chi loc
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| cboNhom_Theo | ComboBox | nhom_theo | Nhom theo (KH/TK/BP/HD/Phi/SPCT) |
| txtTk | AsTextBox | tk | Tai khoan loc |
| txtTk_Du | AsTextBox | tk_du | Tai khoan doi ung |
| cboNo_Co | ComboBox | no_co | Loc Nợ/Có (0:Tat ca, 1:Nợ, 2:Có) |
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang (Lookup: KH) |
| txtMa_plkh1 | AsTextBox | ma_plkh1 | Phan loai KH 1 |
| txtMa_plkh2 | AsTextBox | ma_plkh2 | Phan loai KH 2 |
| txtMa_plkh3 | AsTextBox | ma_plkh3 | Phan loai KH 3 |
| txtMa_Bp | AsTextBox | ma_bp | Ma bo phan (Lookup: BP) |
| txtMa_Phi | AsTextBox | ma_phi | Ma phi |
| txtMa_Hd | AsTextBox | ma_hd | Ma hop dong (Lookup: HD) |
| txtMa_nhhd | AsTextBox | ma_nhhd | Nhom hop dong |
| txtMa_Spct | AsTextBox | ma_spct | Ma san pham chi tiet (Lookup: SPCT) |
| txtMa_lo | AsTextBox | ma_lo | Ma lo |
| txtMa_Ct | AsTextBox | ma_ct | Ma chung tu |
| txtSo_Ct1 | TextBox | so_ct1 | Tu so chung tu |
| txtSo_Ct2 | TextBox | so_ct2 | Den so chung tu |
| txtDien_giai | TextBox | dien_giai | Loc theo dien giai |
| txtNgay1 | AsMaskedTextBox | ngay1 | Tu ngay |
| txtNgay2 | AsMaskedTextBox | ngay2 | Den ngay |
| cboKyBc | ComboBox | ky_bc | Ky bao cao |
| txtMa_Nt | AsTextBox | ma_nt | Ma ngoai te |
| optVND | RadioButton | - | Tien VND |
| optNt | RadioButton | - | Tien nuoc ngoai |
| txtTieu_De | TextBox | tieu_de | Tieu de bao cao |
| dgvBC | DataGridView | - | Luoi hien thi du lieu bao cao |

### Action Buttons

| Button | Mo ta |
|--------|-------|
| cmdOk | Thuc hien tao bao cao |
| cmdCancel | Huy bo |
| cmdExcel | Xuat Excel |
| cmdModifyReport | Sua mau bao cao |
| cmdF5 | Drilldown |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_TH01_GET | Lay du lieu bao cao tong hop 01 |
| SP_GL_RPT_TH01_RPT | Lay bao cao crystal |

### SP_GET (reference)

```sql
-- Lay du lieu bao cao tong hop 01
EXEC SP_GL_RPT_TH01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pNhom_theo VARCHAR(10) = 'TK',
    @pTk VARCHAR(50) = NULL,
    @pTk_du VARCHAR(50) = NULL,
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_plkh1 VARCHAR(50) = NULL,
    @pMa_plkh2 VARCHAR(50) = NULL,
    @pMa_plkh3 VARCHAR(50) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_phi VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_nhhd VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL,
    @pMa_lo VARCHAR(50) = NULL,
    @pMa_ct VARCHAR(10) = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pDien_giai NVARCHAR(200) = NULL,
    @pNo_co INT = 0,
    @pMa_nt VARCHAR(10) = 'VND',
    @pTieu_de NVARCHAR(200) = NULL
```

---

## Business Logic

### Report Parameters

| Parameter | Loai | Mo ta |
|-----------|------|-------|
| nhom_theo | String | KH, TK, TK_Du, BP, HD, Phi, SPCT |
| ngay1, ngay2 | DateTime | Khoang thoi gian bao cao |
| tk, tk_du | String | Tai khoan loc |
| ma_kh, ma_plkh1/2/3 | String | Khach hang va phan loai |
| ma_bp | String | Bo phan |
| ma_phi | String | Phi |
| ma_hd, ma_nhhd | String | Hop dong |
| ma_spct, ma_lo | String | San pham |
| ma_ct, so_ct1/2 | String | Chung tu |
| dien_giai | String | Dien giai |
| no_co | Int | 0: Tat ca, 1: No, 2: Co |

### Nhom theo (cboNhom_Theo)

| Gia tri | Mo ta |
|---------|-------|
| KH | Nhom theo khach hang |
| TK | Nhom theo tai khoan |
| TK_Du | Nhom theo tai khoan doi ung |
| BP | Nhom theo bo phan |
| HD | Nhom theo hop dong |
| Phi | Nhom theo phi |
| SPCT | Nhom theo san pham chi tiet |

### Business Rules

1. **Nhom theo**:
   - Bat buoc chon 1 trong 7 tieu chi nhom
   - Thay doi nhom_theo se thay doi cuon hinc

2. **Ngay thoi gian**:
   - Bat buoc nhap ngay1, ngay2
   - ngay1 <= ngay2

3. **Nợ/Có**:
   - 0: Tat ca phat sinh
   - 1: Chi phat sinh nợ
   - 2: Chi phat sinh có

4. **Drilldown (F5)**:
   - Click row -> drilldown chi tiet
   - Ctrl+F5: Xem so chi tiet
   - Shift+F5: Can doi phat sinh cong no

---

## Mapping PHP

### 1. Report Service Class

```php
// app/Services/GL/Reports/TH01ReportService.php
namespace App\Services\GL\Reports;

class TH01ReportService
{
    protected $companyId;
    protected string $reportType = 'TH01';

    public const GROUP_KH = 'KH';
    public const GROUP_TK = 'TK';
    public const GROUP_TK_DU = 'TK_Du';
    public const GROUP_BP = 'BP';
    public const GROUP_HD = 'HD';
    public const GROUP_PHI = 'Phi';
    public const GROUP_SPCT = 'SPCT';

    public function __construct(string $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getReport(array $params): array
    {
        // Goi stored procedure lay du lieu
        // Xu ly group by theo nhom_theo
    }

    public function getFilterTitle(array $filters): string
    {
        // Tao chuoi tieu de filter
    }

    public function createDrilldownArgument(array $row, string $modifier = ''): array
    {
        // Tao tham so drilldown
    }
}
```

### 2. Livewire Component

```php
// app/Http/Livewire/GL/Reports/TH01Report.php
namespace App\Http\Livewire\GL\Reports;

class TH01Report extends Component
{
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public string $pNhomTheo = 'TK';
    public ?string $pTk = null;
    public ?string $pTkDu = null;
    public int $pNoCo = 0;
    public ?string $pMaKh = null;
    public ?string $pMaPlkh1 = null;
    public ?string $pMaPlkh2 = null;
    public ?string $pMaPlkh3 = null;
    public ?string $pMaBp = null;
    public ?string $pMaPhi = null;
    public ?string $pMaHd = null;
    public ?string $pMaNhhd = null;
    public ?string $pMaSpct = null;
    public ?string $pMaLo = null;
    public ?string $pMaCt = null;
    public ?string $pSoCt1 = null;
    public ?string $pSoCt2 = null;
    public ?string $pDienGiai = null;
    public string $pMaNt = 'VND';
    public ?string $pTieuDe = null;
    public array $pData = [];
    public bool $pShowReport = false;

    public array $nhomTheoOptions = [
        'TK' => 'Tai khoan',
        'KH' => 'Khach hang',
        'BP' => 'Bo phan',
        'HD' => 'Hop dong',
        'Phi' => 'Phi',
        'SPCT' => 'San pham',
    ];

    protected $rules = [
        'pNgay1' => 'required|date',
        'pNgay2' => 'required|date|after_or_equal:pNgay1',
        'pNhomTheo' => 'required|in:TK,KH,BP,HD,Phi,SPCT',
    ];

    public function generateReport(): void
    {
        $this->validate();
        $this->pData = $this->reportService->getReport([
            'ngay1' => $this->pNgay1,
            'ngay2' => $this->pNgay2,
            'nhom_theo' => $this->pNhomTheo,
            'tk' => $this->pTk,
            'tk_du' => $this->pTkDu,
            'no_co' => $this->pNoCo,
            'ma_kh' => $this->pMaKh,
            'ma_plkh1' => $this->pMaPlkh1,
            'ma_plkh2' => $this->pMaPlkh2,
            'ma_plkh3' => $this->pMaPlkh3,
            'ma_bp' => $this->pMaBp,
            'ma_phi' => $this->pMaPhi,
            'ma_hd' => $this->pMaHd,
            'ma_nhhd' => $this->pMaNhhd,
            'ma_spct' => $this->pMaSpct,
            'ma_lo' => $this->pMaLo,
            'ma_ct' => $this->pMaCt,
            'so_ct1' => $this->pSoCt1,
            'so_ct2' => $this->pSoCt2,
            'dien_giai' => $this->pDienGiai,
            'ma_nt' => $this->pMaNt,
        ]);
        $this->pShowReport = true;
    }

    public function drilldown(array $row): void
    {
        $args = $this->reportService->createDrilldownArgument($row, $this->pNhomTheo);
        $this->redirect(route('gl.reports.ctgs03', $args));
    }

    public function render(): View
    {
        return view('gl::reports.th01');
    }
}
```

### 3. Views

```
resources/views/gl/reports/
├── th01.blade.php           (Main report page)
├── th01-filters.blade.php   (Filter section - 22+ filters)
└── th01-table.blade.php     (Report table)
```

### 4. Routes

```php
// routes/gl.php
Route::prefix('gl/reports')
    ->name('gl.reports.')
    ->group(function () {
        Route::get('/th01', [TH01Report::class, 'render'])->name('th01');
        Route::get('/th01/export', [TH01Report::class, 'exportExcel'])->name('th01.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | Portal | TH01ReportService.php | Chinh |
| Component | Portal | TH01Report.php | Livewire |
| Component | Portal | CTGS03Report.php | Drilldown |
| Model | laravel-simba | DMTAIKHOAN.php | Lookup tai khoan |
| Model | laravel-simba | DMKHACHHANG.php | Lookup khach hang |
| Model | laravel-simba | DMBOPHAN.php | Lookup bo phan |
| Model | laravel-simba | DMHOPDONG.php | Lookup hop dong |
| Model | laravel-simba | DMSPCT.php | Lookup SPCT |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao ReportService (TH01ReportService)
- [ ] Tao Livewire Component (TH01Report)
- [ ] Tao Views (filters + table)
- [ ] Them Routes
- [ ] Implement 22+ filter logic
- [ ] Implement group by nhom_theo
- [ ] Implement drilldown (F5/CTGS03)
- [ ] Test report generation

---

## Ghi chu

- Day la report tong hop voi nhieu tieu chi loc
- Ho tro 7 cach nhom: TK, KH, BP, HD, Phi, SPCT, TK_Du
- Ho tro drilldown (F5) -> xem chi tiet CTGS
- Template Crystal Report can chuyen doi sang HTML/PDF