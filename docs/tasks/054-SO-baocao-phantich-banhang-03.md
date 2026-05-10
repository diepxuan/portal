# Task 054: SORptBCPT03

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich ban hang 03 tu .NET/Crystal Reports sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SORptBCPT03.dll
- **Chuc nang:** Bao cao phan tich ban hang 03 (Chi tiet theo mat hang)
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bao cao phan tich ban hang 03
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptBCPT03.dll/README.md`

---

## Form class (Report Viewer)

### frmSORptBCPT03
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao phan tich ban hang chi tiet theo mat hang
- **Report:** Crystal Reports
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau_bc | ComboBox | Chon mau bao cao |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc |
| txtTieu_De | TextBox | Tieu de bao cao |
| txtMa_Kh | AsTextBox | Ma khach hang |
| txtMa_NhKh | AsTextBox | Nhom khach hang |
| txtMa_Plkh1/2/3 | AsTextBox | Phan loai KH 1/2/3 |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_nhhd | AsTextBox | Nhom hop dong |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Nhom vat tu |
| txtMa_plvt1/2/3 | AsTextBox | Phan loai VT 1/2/3 |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_Bp | AsTextBox | Ma bo phan |
| txtMa_Nvkd | AsTextBox | Ma nhan vien kinh doanh |
| txtMA_HTTT | AsTextBox | Hinh thuc thanh toan |
| txtMA_DKTT | AsTextBox | Dieu khoan thanh toan |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtMaLo | AsTextBox | Ma lo |
| txtMa_spct | AsTextBox | Ma san pham chi tiet |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| ChkTra_lai | AsCheckBox | Tru hang tra lai |
| ChkTra_ck | AsCheckBox | Tru hang chiet khau |
| ChkKhuyen_mai | AsCheckBox | Bao gom khuyen mai |
| ChkHang_ban | AsCheckBox | Bao gom hang ban |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |
| crvReport | CrystalReportViewer | Viewer bao cao |

---

## Stored Procedure Parameters

```sql
EXEC SP_SO_RPT_BCPT03
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_kh VARCHAR(20) = NULL,
    @pMa_nhkh VARCHAR(20) = NULL,
    @pMa_vt VARCHAR(20) = NULL,
    @pMa_nhvt VARCHAR(20) = NULL,
    @pMa_kho VARCHAR(20) = NULL,
    @pMa_bp VARCHAR(20) = NULL,
    @pMa_nvkd VARCHAR(20) = NULL,
    @pMa_hd VARCHAR(20) = NULL,
    @pMa_nhhd VARCHAR(20) = NULL,
    @pMa_plvt1 VARCHAR(20) = NULL,
    @pMa_plvt2 VARCHAR(20) = NULL,
    @pMa_plvt3 VARCHAR(20) = NULL,
    @pChkKhuyen_mai BIT = 0,
    @pChkTra_ck BIT = 0,
    @pChkHang_ban BIT = 1,
    @pChkTra_lai BIT = 0,
    @pMa_nt VARCHAR(3) = 'VND',
    @pMa_Plkh1 VARCHAR(20) = NULL,
    @pMa_Plkh2 VARCHAR(20) = NULL,
    @pMa_Plkh3 VARCHAR(20) = NULL,
    @pMa_httt VARCHAR(20) = NULL,
    @pMa_dktt VARCHAR(20) = NULL,
    @pMa_vitri VARCHAR(20) = NULL,
    @pMa_lo VARCHAR(20) = NULL,
    @pMau_bc VARCHAR(50) = NULL
```

---

## Business Logic

### Drill-down

Khi nhan F4 tren 1 dong co ma_vt:
- Goi menu: SORptF5BCPT03
- Truyen cac tham so loc tuong tu + ma_vt da chon

### Filter Title

```php
public function getFilterTitle(): string
{
    // Xay dung chuoi tieu de loc:
    // "Tu ngay: dd/MM/yyyy - Den ngay: dd/MM/yyyy | Khach hang: XXX | ..."
}
```

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-catalog/src/Services/Reports/SoPhanTichBanHang03Report.php
namespace Diepxuan\Catalog\Services\Reports;

class SoPhanTichBanHang03Report
{
    protected array $filters = [];

    public function setDateRange(string $ngay1, string $ngay2): self
    {
        $this->filters['ngay1'] = $ngay1;
        $this->filters['ngay2'] = $ngay2;
        return $this;
    }

    public function setCustomerFilters(
        ?string $maKh = null,
        ?string $maNhKh = null,
        ?string $maPlkh1 = null,
        ?string $maPlkh2 = null,
        ?string $maPlkh3 = null
    ): self {
        $this->filters['ma_kh'] = $maKh;
        $this->filters['ma_nhkh'] = $maNhKh;
        $this->filters['ma_plkh1'] = $maPlkh1;
        $this->filters['ma_plkh2'] = $maPlkh2;
        $this->filters['ma_plkh3'] = $maPlkh3;
        return $this;
    }

    public function setProductFilters(
        ?string $maVt = null,
        ?string $maNhVt = null,
        ?string $maPlvt1 = null,
        ?string $maPlvt2 = null,
        ?string $maPlvt3 = null
    ): self {
        $this->filters['ma_vt'] = $maVt;
        $this->filters['ma_nhvt'] = $maNhVt;
        $this->filters['ma_plvt1'] = $maPlvt1;
        $this->filters['ma_plvt2'] = $maPlvt2;
        $this->filters['ma_plvt3'] = $maPlvt3;
        return $this;
    }

    public function setOrganizationFilters(
        ?string $maKho = null,
        ?string $maBp = null,
        ?string $maNvkd = null
    ): self {
        $this->filters['ma_kho'] = $maKho;
        $this->filters['ma_bp'] = $maBp;
        $this->filters['ma_nvkd'] = $maNvkd;
        return $this;
    }

    public function setContractFilters(
        ?string $maHd = null,
        ?string $maNhhd = null
    ): self {
        $this->filters['ma_hd'] = $maHd;
        $this->filters['ma_nhhd'] = $maNhhd;
        return $this;
    }

    public function setPaymentFilters(
        ?string $maHttt = null,
        ?string $maDktt = null
    ): self {
        $this->filters['ma_httt'] = $maHttt;
        $this->filters['ma_dktt'] = $maDktt;
        return $this;
    }

    public function setLocationFilters(
        ?string $maVitri = null,
        ?string $maLo = null,
        ?string $maSpct = null
    ): self {
        $this->filters['ma_vitri'] = $maVitri;
        $this->filters['ma_lo'] = $maLo;
        $this->filters['ma_spct'] = $maSpct;
        return $this;
    }

    public function setCurrency(string $maNt = 'VND'): self
    {
        $this->filters['ma_nt'] = $maNt;
        return $this;
    }

    public function setIncludeFlags(
        bool $hangBan = true,
        bool $traLai = false,
        bool $traCk = false,
        bool $khuyenMai = false
    ): self {
        $this->filters['hang_ban'] = $hangBan;
        $this->filters['tra_lai'] = $traLai;
        $this->filters['tra_ck'] = $traCk;
        $this->filters['khuyen_mai'] = $khuyenMai;
        return $this;
    }

    public function setMauBc(?string $mauBc = null): self
    {
        $this->filters['mau_bc'] = $mauBc;
        return $this;
    }

    public function execute(): array
    {
        return app(SoRptBCPT03::class)->execute($this->filters);
    }
}
```

### 2. Report Stored Procedure Class

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoRptBCPT03.php
namespace Diepxuan\Simba\StoredProcedures;

class SoRptBCPT03 extends StoredProcedure
{
    protected $procedure = 'SP_SO_RPT_BCPT03';

    public function execute(array $filters = []): array
    {
        $params = [
            'pMa_cty' => $filters['ma_cty'] ?? '001',
            'pNgay1' => $filters['ngay1'],
            'pNgay2' => $filters['ngay2'],
            'pMa_kh' => $filters['ma_kh'] ?? null,
            'pMa_nhkh' => $filters['ma_nhkh'] ?? null,
            'pMa_vt' => $filters['ma_vt'] ?? null,
            'pMa_nhvt' => $filters['ma_nhvt'] ?? null,
            // ... full params
        ];

        return $this->call($params);
    }
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Reports/PhanTichBanHang03.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Reports;

class PhanTichBanHang03 extends Component
{
    const MA_CT = 'SO';

    // Filter properties
    public ?string $ngay1 = null;
    public ?string $ngay2 = null;
    public ?string $maKh = null;
    public ?string $maNhKh = null;
    public ?string $maVt = null;
    public ?string $maNhVt = null;
    public ?string $maKho = null;
    public ?string $maBp = null;
    public ?string $maNvkd = null;
    public ?string $maHd = null;
    public ?string $maNhhd = null;
    public ?string $maPlvt1 = null;
    public ?string $maPlvt2 = null;
    public ?string $maPlvt3 = null;
    public ?string $maPlkh1 = null;
    public ?string $maPlkh2 = null;
    public ?string $maPlkh3 = null;
    public ?string $maHttt = null;
    public ?string $maDktt = null;
    public ?string $maVitri = null;
    public ?string $maLo = null;
    public ?string $maSpct = null;
    public ?string $maNt = 'VND';
    public bool $hangBan = true;
    public bool $traLai = false;
    public bool $traCk = false;
    public bool $khuyenMai = false;
    public array $reportData = [];

    public function mount(): void
    {
        $this->ngay1 = now()->startOfMonth()->format('Y-m-d');
        $this->ngay2 = now()->endOfMonth()->format('Y-m-d');
    }

    public function generateReport(): void
    {
        $report = app(SoPhanTichBanHang03Report::class)
            ->setDateRange($this->ngay1, $this->ngay2)
            ->setCustomerFilters($this->maKh, $this->maNhKh, $this->maPlkh1, $this->maPlkh2, $this->maPlkh3)
            ->setProductFilters($this->maVt, $this->maNhVt, $this->maPlvt1, $this->maPlvt2, $this->maPlvt3)
            ->setOrganizationFilters($this->maKho, $this->maBp, $this->maNvkd)
            ->setContractFilters($this->maHd, $this->maNhhd)
            ->setPaymentFilters($this->maHttt, $this->maDktt)
            ->setLocationFilters($this->maVitri, $this->maLo, $this->maSpct)
            ->setCurrency($this->maNt)
            ->setIncludeFlags($this->hangBan, $this->traLai, $this->traCk, $this->khuyenMai);

        $this->reportData = $report->execute();
    }

    public function drillDown(string $maVt): void
    {
        // Redirect to drill-down report with ma_vt
    }

    public function exportExcel(): void
    {
        // Export using PhpSpreadsheet
    }

    public function render(): View
    {
        return view('catalog::so.reports.phan-tich-ban-hang-03');
    }
}
```

### 4. Views

```
resources/views/catalog/so/reports/
├── phan-tich-ban-hang-03.blade.php
├── _phan-tich-ban-hang-03-filter.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/so/reports')
    ->name('catalog.so.reports.')
    ->group(function () {
        Route::get('/phan-tich-ban-hang-03', [PhanTichBanHang03::class, 'render'])
            ->name('phantichbanhang03');
        Route::get('/phan-tich-ban-hang-03/drilldown/{maVt}', [PhanTichBanHang03::class, 'drillDown'])
            ->name('phantichbanhang03.drilldown');
        Route::post('/phan-tich-ban-hang-03/export', [PhanTichBanHang03::class, 'exportExcel'])
            ->name('phantichbanhang03.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| SP | laravel-simba | SoRptBCPT03.php | Chinh |
| Report | laravel-catalog | SoPhanTichBanHang03Report.php | Service |
| Component | laravel-catalog | PhanTichBanHang03.php | Viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure class
- [ ] Tao Report Service class
- [ ] Tao Livewire PhanTichBanHang03
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Drill-down F4
- [ ] Test Export Excel
- [ ] Test Full filter params
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
