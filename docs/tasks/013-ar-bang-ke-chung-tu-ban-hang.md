# Task 013: ARRptBK01

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu ban hang tu .NET sang PHP Laravel, dat ket qua tuong duong ARRptBK01.

## Chi tiet
- **DLL:** ARRptBK01.dll
- **Chuc nang:** Bang ke chi tiet cac chung tu ban hang, hoa don phai thu theo nhieu tieu chi loc - hien thi danh sach hoa don theo thoi gian, khach hang, vat tu
- **Loai:** Bao cao (Report)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRptBK01.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| ARSOHD | Hoa don ban hang | FK ma_kh, ma_vt, ma_kho |
| ARSOH DCT | Chi tiet hoa don | FK ma_vt, so_luong, gia |
| DMKH | Danh muc khach hang | FK ma_kh |
| DMVT | Danh muc vat tu | FK ma_vt |
| DMKHO | Danh muc kho | FK ma_kho |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ten_kh, ma_nhkh, ma_plkh1/2/3 |
| DMVT | Vat tu | Lookup ten_vt, ma_nhvt, ma_lo |
| DMKHO | Kho | Lookup ten_kho |
| DMNVIEN | Nhan vien KD | Lookup ten_nv, ma_nvkd |

---

## Form classes

### 1. frmARRptBK01 (Bang ke hoa don ban hang)
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke chi tiet hoa don, loc nhieu tieu chi, xuat bao cao
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| txtMa_vt | AsTextBox | Ma vat tu (AutoLookup) |
| txtMa_nhvt | AsTextBox | Nhom vat tu (AutoLookup) |
| txtMa_kho | AsTextBox | Ma kho (AutoLookup) |
| txtMa_lo | AsTextBox | Ma lo (AutoLookup) |
| txtMa_Bp | AsTextBox | Ma bo phan (AutoLookup) |
| txtMa_Hd | AsTextBox | Ma hop dong (AutoLookup) |
| txtMa_Nvkd | AsTextBox | Ma NVKD (AutoLookup) |
| txtMa_plkh1 | AsTextBox | Phan loai KH 1 (AutoLookup) |
| txtMa_plkh2 | AsTextBox | Phan loai KH 2 (AutoLookup) |
| txtMa_plkh3 | AsTextBox | Phan loai KH 3 (AutoLookup) |
| txtSo_Ct1 | TextBox | So chung tu tu |
| txtSo_Ct2 | TextBox | So chung tu den |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| txtMa_phi | AsTextBox | Ma phi (AutoLookup) |
| txtMa_spct | AsTextBox | Ma SPCT (AutoLookup) |
| cboKyBc | ComboBox | Ky bao cao |
| dgvBK | DataGridView | Du lieu bang ke |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_BK01_GET | Lay du lieu bang ke hoa don |
| SP_AR_BK01_GETBYKH | Lay theo khach hang |
| SP_AR_BK01_GETBYVT | Lay theo vat tu |
| SP_AR_BK01_SUMMARY | Tong hop theo tieu chi |
| SP_AR_BK01_EXPORT | Xuat Excel |

### SP_GET (reference)

```sql
-- Lay du lieu bang ke hoa don ban hang
EXEC SP_AR_BK01_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_nhvt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_lo VARCHAR(50) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_hd VARCHAR(50) = NULL,
    @pMa_nvkd VARCHAR(50) = NULL,
    @pMa_plkh1 VARCHAR(50) = NULL,
    @pMa_plkh2 VARCHAR(50) = NULL,
    @pMa_plkh3 VARCHAR(50) = NULL,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_phi VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND'
```

---

## Business Logic

### Tinh toan

1. **Thanh tien**:
   - Thanh tien = So luong x Don gia
   - Neu co chiet khau: Thanh tien = SL x Gia x (1 - TL_ck/100)

2. **Tong hop**:
   - Tong so luong = Sum(so_luong)
   - Tong thanh tien = Sum(thanh_tien)

### Loc nhieu dieu kien

- Tat ca cac truong deu la tuy chon
- Chi loc neu co gia tri
- Ket hop nhieu dieu kien voi AND

### Cau truc bao cao

| Cot | Mo ta |
|-----|-------|
| ngay_ct | Ngay chung tu |
| so_ct | So chung tu |
| ma_kh | Ma khach hang |
| ten_kh | Ten khach hang |
| ma_vt | Ma vat tu |
| ten_vt | Ten vat tu |
| dvt | Don vi tinh |
| so_luong | So luong |
| gia | Don gia |
| thanh_tien | Thanh tien |

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/RptBK01.php
namespace Diepxuan\Simba\Models\AR;

class RptBK01 extends Model
{
    protected $table = 'VW_AR_BK01'; // View bang ke hoa don
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $casts = [
        'so_luong' => 'decimal:2',
        'gia' => 'decimal:2',
        'thanh_tien' => 'decimal:2',
        'gia_nt' => 'decimal:2',
        'thanh_tien_nt' => 'decimal:2',
    ];

    // Relationships
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function kho()
    {
        return $this->belongsTo(DMKHO::class, 'ma_kho', 'ma_kho');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBK01.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetBK01 extends StoredProcedure
{
    protected $procedure = 'SP_AR_BK01_GET';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pMa_vt',
        'pMa_nhvt',
        'pMa_kho',
        'pMa_lo',
        'pMa_bp',
        'pMa_hd',
        'pMa_nvkd',
        'pMa_plkh1',
        'pMa_plkh2',
        'pMa_plkh3',
        'pSo_ct1',
        'pSo_ct2',
        'pNgay1',
        'pNgay2',
        'pMa_phi',
        'pMa_spct',
        'pMa_nt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARGetBK01Summary.php
class AsARGetBK01Summary extends StoredProcedure
{
    protected $procedure = 'SP_AR_BK01_SUMMARY';
    protected $params = [
        'pMa_cty',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
        'pGroupBy', // 'kh', 'vt', 'kho', 'nvkd', etc.
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/BangKeBanHang.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class BangKeBanHang extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'BK01';

    // Filters
    public ?string $pMaKh = null;
    public ?string $pMaVt = null;
    public ?string $pMaNhvt = null;
    public ?string $pMaKho = null;
    public ?string $pMaLo = null;
    public ?string $pMaBp = null;
    public ?string $pMaHd = null;
    public ?string $pMaNvkd = null;
    public ?string $pMaPlkh1 = null;
    public ?string $pMaPlkh2 = null;
    public ?string $pMaPlkh3 = null;
    public ?string $pSoCt1 = null;
    public ?string $pSoCt2 = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public ?string $pMaPhi = null;
    public ?string $pMaSpct = null;
    public string $pMaNt = 'VND';

    public Collection $pData;
    public array $pSummary = [];

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
    }

    public function loadReport(): void
    {
        $sp = new AsARGetBK01();
        $this->pData = $sp->execute([
            'pMa_cty' => '001',
            'pMa_kh' => $this->pMaKh,
            'pMa_vt' => $this->pMaVt,
            'pMa_nhvt' => $this->pMaNhvt,
            'pMa_kho' => $this->pMaKho,
            'pMa_lo' => $this->pMaLo,
            'pMa_bp' => $this->pMaBp,
            'pMa_hd' => $this->pMaHd,
            'pMa_nvkd' => $this->pMaNvkd,
            'pMa_plkh1' => $this->pMaPlkh1,
            'pMa_plkh2' => $this->pMaPlkh2,
            'pMa_plkh3' => $this->pMaPlkh3,
            'pSo_ct1' => $this->pSoCt1,
            'pSo_ct2' => $this->pSoCt2,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMa_phi' => $this->pMaPhi,
            'pMa_spct' => $this->pMaSpct,
            'pMa_nt' => $this->pMaNt,
        ]);
        $this->calculateSummary();
    }

    public function calculateSummary(): void
    {
        $this->pSummary = [
            'tong_sl' => $this->pData->sum('so_luong'),
            'tong_thanh_tien' => $this->pData->sum('thanh_tien'),
            'so_hoa_don' => $this->pData->distinct('so_ct')->count(),
        ];
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.bang-ke-ban-hang');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── bang-ke-ban-hang.blade.php        (Form bao cao)
├── bang-ke-ban-hang-results.blade.php (Ket qua)
├── _bang-ke-ban-hang-row.blade.php    (Dong bao cao)
└── _bang-ke-ban-hang-summary.blade.php (Tong hop)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/bang-ke-ban-hang', [BangKeBanHang::class, 'render'])
            ->name('bang-ke-ban-hang');
        Route::get('/bang-ke-ban-hang/export', [BangKeBanHang::class, 'exportExcel'])
            ->name('bang-ke-ban-hang.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | RptBK01.php | View bang ke |
| Model | laravel-simba | DMKH.php | Khach hang |
| Model | laravel-simba | DMVT.php | Vat tu |
| Model | laravel-simba | DMKHO.php | Kho |
| Model | laravel-simba | ARSOHD.php | Hoa don |
| SP | laravel-simba | AsARGetBK01.php | Lay du lieu |
| SP | laravel-simba | AsARGetBK01Summary.php | Tong hop |
| Component | laravel-catalog | BangKeBanHang.php | Form bao cao |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model RptBK01 (View)
- [ ] Tao Livewire BangKeBanHang
- [ ] Tao Views (form + results)
- [ ] Them Routes
- [ ] Implement nhieu tieu chi loc
- [ ] Test bang ke voi du lieu thuc