# Task 048: SORptTH01

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop ban hang tu .NET/Crystal Reports sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SORptTH01.dll
- **Chuc nang:** Bao cao tong hop ban hang 01
- **Loai:** Report (Bao cao)
- **Assembly Title:** Bao cao tong hop ban hang
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptTH01.dll/README.md`

---

## Cau truc du lieu

### Bang: VCSO1 (Voucher - Chung tu so cao)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So trace (khoa chinh) |
| ma_ct | varchar | Ma chung tu (SO1) |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| ma_kh | varchar | Ma khach hang |
| ma_nvkd | varchar | Ma nhan vien kinh doanh |
| ma_httt | varchar | Hinh thuc thanh toan |
| ma_tt | varchar | Dieu khoan thanh toan |
| ma_kho | varchar | Ma kho |
| ma_bp | varchar | Ma bo phan |
| t_tien_nt2 | decimal | Tong tien ngoai te |
| t_tien | decimal | Tong tien VND |
| trang_thai | varchar | Trang thai |

### Bang: VCSO2 (Voucher - Chi tiet ban hang)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So trace (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ma_kho | varchar | Ma kho |
| so_luong | decimal | So luong |
| gia_nt2 | decimal | Gia ngoai te |
| tien_nt2 | decimal | Tien ngoai te |
| tl_ck | decimal | Ty le chiet khau |
| tien_ck_nt | decimal | Tien chiet khau |
| thue_gtgt_nt | decimal | Thue GTGT ngoai te |

---

## Form class (Report Viewer)

### frmSORptTH01
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao tong hop ban hang voi nhieu tieu chi loc
- **Report:** Crystal Reports
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| tabFilter | TabControl | Tab loc bao cao |
| cboMau_bc | ComboBox | Chon mau bao cao |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc |
| txtTieu_De | TextBox | Tieu de bao cao |
| cboLoaiPhieu | AsComboBox | Loai phieu |
| cboTrang_Thai | AsComboBox | Trang thai |
| txtMa_Kh | AsTextBox | Ma khach hang |
| txtMa_NhKh | AsTextBox | Nhom khach hang |
| txtMa_plkh1 | AsTextBox | Phan loai KH 1 |
| txtMa_plkh2 | AsTextBox | Phan loai KH 2 |
| txtMa_plkh3 | AsTextBox | Phan loai KH 3 |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_nhhd | AsTextBox | Nhom hop dong |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Nhom vat tu |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_bp | AsTextBox | Ma bo phan |
| txtMa_nvkd | AsTextBox | Ma nhan vien kinh doanh |
| txtMA_HTTT | AsTextBox | Hinh thuc thanh toan |
| txtMA_DKTT | AsTextBox | Dieu khoan thanh toan |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtMaLo | AsTextBox | Ma lo |
| txtMa_spct | AsTextBox | Ma san pham chi tiet |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| ChkTra_lai | AsCheckBox | Tru hang ban tra lai |
| ChkTra_ck | AsCheckBox | Hang chiet khau |
| ChkKhuyen_mai | AsCheckBox | Hang tra khuyen mai |
| ChkHang_ban | AsCheckBox | Hang ban |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |
| crvReport | CrystalReportViewer | Viewer bao cao |

---

## Stored Procedure Parameters

### SP_GET_REPORT (reference)

```sql
-- Bao cao tong hop ban hang
EXEC SP_SO_RPT_TONGHOP_BANHANG
    @pMa_cty VARCHAR(50) = '001',
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pLoai_phieu VARCHAR(10) = NULL,
    @pTrang_thai VARCHAR(10) = NULL,
    @pMa_kh VARCHAR(20) = NULL,
    @pMa_nhkh VARCHAR(20) = NULL,
    @pMa_vt VARCHAR(20) = NULL,
    @pMa_nhvt VARCHAR(20) = NULL,
    @pMa_kho VARCHAR(20) = NULL,
    @pMa_bp VARCHAR(20) = NULL,
    @pMa_nvkd VARCHAR(20) = NULL,
    @pMa_hd VARCHAR(20) = NULL,
    @pMa_nhhd VARCHAR(20) = NULL,
    @pMa_httt VARCHAR(20) = NULL,
    @pMa_dktt VARCHAR(20) = NULL,
    @pMa_vitri VARCHAR(20) = NULL,
    @pMa_lo VARCHAR(20) = NULL,
    @pMa_spct VARCHAR(20) = NULL,
    @pMa_nt VARCHAR(3) = 'VND',
    @pChkKhuyen_mai BIT = 0,
    @pChkTra_ck BIT = 0,
    @pChkHang_ban BIT = 1,
    @pChkTra_lai BIT = 0,
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
| Khach hang | Ma KH, Nhom KH, PLKH 1/2/3 |
| Vat tu | Ma VT, Nhom VT, PLVT 1/2/3 |
| Kho | Ma kho |
| Bo phan | Ma bo phan |
| NVKD | Ma nhan vien kinh doanh |
| HD/NHD | Hop dong, Nhom hop dong |
| Tien te | VND hoac ngoai te |

### Checkbox Logic

| Checkbox | Mo ta | Default |
|----------|-------|---------|
| Hang_ban | Bao gom hang ban | true |
| Tra_lai | Tru hang tra lai | false |
| Tra_ck | Tru hang chiet khau | false |
| Khuyen_mai | Bao gom tra khuyen mai | false |

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-catalog/src/Services/Reports/SoTongHopBanHangReport.php
namespace Diepxuan\Catalog\Services\Reports;

class SoTongHopBanHangReport
{
    protected array $filters = [];

    public function setDateRange(string $ngay1, string $ngay2): self
    {
        $this->filters['ngay1'] = $ngay1;
        $this->filters['ngay2'] = $ngay2;
        return $this;
    }

    public function setCustomer(?string $maKh = null, ?string $maNhKh = null): self
    {
        $this->filters['ma_kh'] = $maKh;
        $this->filters['ma_nhkh'] = $maNhKh;
        return $this;
    }

    public function setProduct(?string $maVt = null, ?string $maNhVt = null): self
    {
        $this->filters['ma_vt'] = $maVt;
        $this->filters['ma_nhvt'] = $maNhVt;
        return $this;
    }

    public function setWarehouse(?string $maKho = null): self
    {
        $this->filters['ma_kho'] = $maKho;
        return $this;
    }

    public function setDepartment(?string $maBp = null): self
    {
        $this->filters['ma_bp'] = $maBp;
        return $this;
    }

    public function setSalesRep(?string $maNvkd = null): self
    {
        $this->filters['ma_nvkd'] = $maNvkd;
        return $this;
    }

    public function setPayment(?string $maHttt = null, ?string $maDktt = null): self
    {
        $this->filters['ma_httt'] = $maHttt;
        $this->filters['ma_dktt'] = $maDktt;
        return $this;
    }

    public function setCurrency(string $maNt = 'VND'): self
    {
        $this->filters['ma_nt'] = $maNt;
        return $this;
    }

    public function setStatus(?string $trangThai = null): self
    {
        $this->filters['trang_thai'] = $trangThai;
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

    public function execute(): array
    {
        return app(SoRptTongHopBanHang::class)->execute($this->filters);
    }
}
```

### 2. Report Stored Procedure Class

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoRptTongHopBanHang.php
namespace Diepxuan\Simba\StoredProcedures;

class SoRptTongHopBanHang extends StoredProcedure
{
    protected $procedure = 'SP_SO_RPT_TONGHOP_BANHANG';

    public function execute(array $filters = []): array
    {
        $params = [
            'pMa_cty' => $filters['ma_cty'] ?? '001',
            'pNgay1' => $filters['ngay1'],
            'pNgay2' => $filters['ngay2'],
            'pLoai_phieu' => $filters['loai_phieu'] ?? null,
            'pTrang_thai' => $filters['trang_thai'] ?? null,
            'pMa_kh' => $filters['ma_kh'] ?? null,
            'pMa_nhkh' => $filters['ma_nhkh'] ?? null,
            'pMa_vt' => $filters['ma_vt'] ?? null,
            'pMa_nhvt' => $filters['ma_nhvt'] ?? null,
            'pMa_kho' => $filters['ma_kho'] ?? null,
            'pMa_bp' => $filters['ma_bp'] ?? null,
            'pMa_nvkd' => $filters['ma_nvkd'] ?? null,
            // ... other params
        ];

        return $this->call($params);
    }
}
```

### 3. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Reports/TongHopBanHang.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Reports;

class TongHopBanHang extends Component
{
    const MA_CT = 'SO';

    public array $filters = [];
    public ?string $ngay1 = null;
    public ?string $ngay2 = null;
    public ?string $maKh = null;
    public ?string $maNhKh = null;
    public ?string $maVt = null;
    public ?string $maNhVt = null;
    public ?string $maKho = null;
    public ?string $maBp = null;
    public ?string $maNvkd = null;
    public ?string $maHttt = null;
    public ?string $maDktt = null;
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
        $report = app(SoTongHopBanHangReport::class)
            ->setDateRange($this->ngay1, $this->ngay2)
            ->setCustomer($this->maKh, $this->maNhKh)
            ->setProduct($this->maVt, $this->maNhVt)
            ->setWarehouse($this->maKho)
            ->setDepartment($this->maBp)
            ->setSalesRep($this->maNvkd)
            ->setPayment($this->maHttt, $this->maDktt)
            ->setCurrency($this->maNt)
            ->setIncludeFlags($this->hangBan, $this->traLai, $this->traCk, $this->khuyenMai);

        $this->reportData = $report->execute();
    }

    public function exportExcel(): void
    {
        // Export to Excel using PhpSpreadsheet
    }

    public function render(): View
    {
        return view('catalog::so.reports.tong-hop-ban-hang');
    }
}
```

### 4. Views

```
resources/views/catalog/so/reports/
├── tong-hop-ban-hang.blade.php        (Filter + Viewer)
├── _tong-hop-ban-hang-filter.blade.php (Filter partial)
└── _tong-hop-ban-hang-table.blade.php  (Table partial)
```

### 5. Routes

```php
Route::prefix('catalog/so/reports')
    ->name('catalog.so.reports.')
    ->group(function () {
        Route::get('/tong-hop-ban-hang', [TongHopBanHang::class, 'render'])
            ->name('tonghopbanhang');
        Route::post('/tong-hop-ban-hang/export', [TongHopBanHang::class, 'exportExcel'])
            ->name('tonghopbanhang.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| SP | laravel-simba | SoRptTongHopBanHang.php | Chinh |
| Report | laravel-catalog | SoTongHopBanHangReport.php | Service |
| Component | laravel-catalog | TongHopBanHang.php | Viewer |
| Model | laravel-simba | VCSO1.php | Voucher header |
| Model | laravel-simba | VCSO2.php | Voucher detail |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure class cho report
- [ ] Tao Report Service class
- [ ] Tao Livewire TongHopBanHang (filter + viewer)
- [ ] Tao Views (filter + table)
- [ ] Them Routes
- [ ] Test Report parameters
- [ ] Test Export Excel
- [ ] Test Drill-down (neu co)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
