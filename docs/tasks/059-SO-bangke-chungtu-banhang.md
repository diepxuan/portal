# Task 059: SORptBK02

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu ban hang 02 tu .NET/Crystal Reports sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SORptBK02.dll
- **Chuc nang:** Bang ke chung tu ban hang 02 (Nhom theo chi tieu)
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bang ke chung tu ban hang 02
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptBK02.dll/README.md`

---

## Form class (Report Viewer)

### frmSORptBK02
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bang ke hoa don nhom theo chi tieu
- **Report:** Crystal Reports
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau_bc | ComboBox | Chon mau bao cao |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc |
| txtTieu_De | TextBox | Tieu de bao cao |
| cboNhom_theo | AsComboBox | Nhom theo chi tieu |
| txtSo_ct1 | TextBox | So chung tu tu |
| txtSo_ct2 | TextBox | So chung tu den |
| cboLoaiPhieu | AsComboBox | Loai phieu |
| cboTrang_Thai | AsComboBox | Trang thai |
| txtMa_kh | AsTextBox | Ma khach hang |
| txtMa_nhkh | AsTextBox | Nhom khach hang |
| txtMa_plkh1/2/3 | AsTextBox | Phan loai KH 1/2/3 |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_nhhd | AsTextBox | Nhom hop dong |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Nhom vat tu |
| txtMa_plvt1/2/3 | AsTextBox | Phan loai VT 1/2/3 |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_bp | AsTextBox | Ma bo phan |
| txtMa_nvkd | AsTextBox | Ma nhan vien kinh doanh |
| txtMA_HTTT | AsTextBox | Hinh thuc thanh toan |
| txtMA_DKTT | AsTextBox | Dieu khoan thanh toan |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtMa_Lo | AsTextBox | Ma lo |
| txtMa_spct | AsTextBox | Ma san pham chi tiet |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |
| crvReport | CrystalReportViewer | Viewer bao cao |

---

## Stored Procedure Parameters

```sql
EXEC SP_SO_RPT_BK02
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pLoai_phieu VARCHAR(10) = NULL,
    @pNhom_theo VARCHAR(20) = NULL,
    @pMa_kh VARCHAR(20) = NULL,
    @pMa_nhkh VARCHAR(20) = NULL,
    @pMa_vt VARCHAR(20) = NULL,
    @pMa_nhvt VARCHAR(20) = NULL,
    @pMa_kho VARCHAR(20) = NULL,
    @pMa_vitri VARCHAR(20) = NULL,
    @pMa_Lo VARCHAR(20) = NULL,
    @pMa_httt VARCHAR(20) = NULL,
    @pMa_dktt VARCHAR(20) = NULL,
    @pMa_bp VARCHAR(20) = NULL,
    @pMa_nvkd VARCHAR(20) = NULL,
    @pMa_spct VARCHAR(20) = NULL,
    @pMa_hd VARCHAR(20) = NULL,
    @pMa_nhhd VARCHAR(20) = NULL,
    @pMa_nt VARCHAR(3) = 'VND',
    @pSo_ct1 VARCHAR(20) = NULL,
    @pSo_ct2 VARCHAR(20) = NULL,
    @pMa_plkh1 VARCHAR(20) = NULL,
    @pMa_plkh2 VARCHAR(20) = NULL,
    @pMa_plkh3 VARCHAR(20) = NULL,
    @pMa_plvt1 VARCHAR(20) = NULL,
    @pMa_plvt2 VARCHAR(20) = NULL,
    @pMa_plvt3 VARCHAR(20) = NULL
```

---

## Business Logic

### Filter Criteria

| Tieu chi | Mo ta |
|----------|-------|
| Ngay | Tu ngay - Den ngay |
| Loai phieu | Don hang, Phieu xuat, Hoa don... |
| Trang thai | Nhap, Da duyet, Da giao, Hoan thanh |
| Nhom theo | Chi tieu nhom (KH, VT, Kho, NVKD, ...) |
| So CT | Tu so - Den so |
| Khach hang | Ma KH, Nhom KH, PLKH 1/2/3 |
| Vat tu | Ma VT, Nhom VT, PLVT 1/2/3 |
| Kho | Ma kho |
| Bo phan | Ma bo phan |
| NVKD | Ma nhan vien kinh doanh |
| HD/NHD | Hop dong, Nhom hop dong |
| Tien te | VND hoac ngoai te |

### Group By Options

- Theo khach hang
- Theo vat tu
- Theo kho
- Theo NVKD
- Theo bo phan
- Theo hop dong

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-catalog/src/Services/Reports/SoBangKeChungTuBanHang02Report.php
namespace Diepxuan\Catalog\Services\Reports;

class SoBangKeChungTuBanHang02Report
{
    protected array $filters = [];

    public function setDateRange(string $ngay1, string $ngay2): self
    {
        $this->filters['ngay1'] = $ngay1;
        $this->filters['ngay2'] = $ngay2;
        return $this;
    }

    public function setGroupBy(string $groupBy): self
    {
        $this->filters['nhom_theo'] = $groupBy;
        return $this;
    }

    public function setSoCtRange(?string $soCt1 = null, ?string $soCt2 = null): self
    {
        $this->filters['so_ct1'] = $soCt1;
        $this->filters['so_ct2'] = $soCt2;
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

    public function setContractFilters(
        ?string $maHd = null,
        ?string $maNhhd = null
    ): self {
        $this->filters['ma_hd'] = $maHd;
        $this->filters['ma_nhhd'] = $maNhhd;
        return $this;
    }

    public function setLoaiPhieu(?string $loaiPhieu = null): self
    {
        $this->filters['loai_phieu'] = $loaiPhieu;
        return $this;
    }

    public function setTrangThai(?string $trangThai = null): self
    {
        $this->filters['trang_thai'] = $trangThai;
        return $this;
    }

    public function execute(): array
    {
        return app(SoRptBK02::class)->execute($this->filters);
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Reports/BangKeChungTuBanHang02.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Reports;

class BangKeChungTuBanHang02 extends Component
{
    const MA_CT = 'SO';

    public ?string $ngay1 = null;
    public ?string $ngay2 = null;
    public ?string $nhomTheo = null;
    public ?string $soCt1 = null;
    public ?string $soCt2 = null;
    public ?string $loaiPhieu = null;
    public ?string $trangThai = null;
    // Customer filters
    public ?string $maKh = null;
    public ?string $maNhKh = null;
    public ?string $maPlkh1 = null;
    public ?string $maPlkh2 = null;
    public ?string $maPlkh3 = null;
    // Product filters
    public ?string $maVt = null;
    public ?string $maNhVt = null;
    public ?string $maPlvt1 = null;
    public ?string $maPlvt2 = null;
    public ?string $maPlvt3 = null;
    // Organization filters
    public ?string $maKho = null;
    public ?string $maBp = null;
    public ?string $maNvkd = null;
    // Payment filters
    public ?string $maHttt = null;
    public ?string $maDktt = null;
    // Location filters
    public ?string $maVitri = null;
    public ?string $maLo = null;
    public ?string $maSpct = null;
    // Contract filters
    public ?string $maHd = null;
    public ?string $maNhhd = null;
    // Currency
    public ?string $maNt = 'VND';
    public array $reportData = [];

    public function mount(): void
    {
        $this->ngay1 = now()->startOfMonth()->format('Y-m-d');
        $this->ngay2 = now()->endOfMonth()->format('Y-m-d');
    }

    public function generateReport(): void
    {
        $report = app(SoBangKeChungTuBanHang02Report::class)
            ->setDateRange($this->ngay1, $this->ngay2)
            ->setGroupBy($this->nhomTheo)
            ->setSoCtRange($this->soCt1, $this->soCt2)
            ->setLoaiPhieu($this->loaiPhieu)
            ->setTrangThai($this->trangThai)
            ->setCustomerFilters($this->maKh, $this->maNhKh, $this->maPlkh1, $this->maPlkh2, $this->maPlkh3)
            ->setProductFilters($this->maVt, $this->maNhVt, $this->maPlvt1, $this->maPlvt2, $this->maPlvt3)
            ->setOrganizationFilters($this->maKho, $this->maBp, $this->maNvkd)
            ->setPaymentFilters($this->maHttt, $this->maDktt)
            ->setLocationFilters($this->maVitri, $this->maLo, $this->maSpct)
            ->setContractFilters($this->maHd, $this->maNhhd)
            ->setCurrency($this->maNt);

        $this->reportData = $report->execute();
    }

    public function exportExcel(): void
    {
        // Export using PhpSpreadsheet
    }

    public function render(): View
    {
        return view('catalog::so.reports.bang-ke-chung-tu-ban-hang-02');
    }
}
```

### 3. Views & Routes

```
resources/views/catalog/so/reports/
├── bang-ke-chung-tu-ban-hang-02.blade.php
```

```php
Route::prefix('catalog/so/reports')
    ->name('catalog.so.reports.')
    ->group(function () {
        Route::get('/bang-ke-chung-tu-ban-hang-02', [BangKeChungTuBanHang02::class, 'render'])
            ->name('bangkechungtubanhang02');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| SP | laravel-simba | SoRptBK02.php | Chinh |
| Report | laravel-catalog | SoBangKeChungTuBanHang02Report.php | Service |
| Component | laravel-catalog | BangKeChungTuBanHang02.php | Viewer |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure class
- [ ] Tao Report Service class
- [ ] Tao Livewire BangKeChungTuBanHang02
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Group by chi tieu
- [ ] Test So ct range
- [ ] Test Export Excel