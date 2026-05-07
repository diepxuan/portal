# Task 004: ARCDKH

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang bao cao cong no khach hang tu .NET sang PHP Laravel, dat ket qua tuong duong ARCDKH.

## Chi tiet
- **DLL:** ARCDKH.dll
- **Chuc nang:** Bao cao cong no khach hang - hien thi danh sach cong no theo khach hang voi nhieu tieu chi loc
- **Loai:** Bao cao
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARCDKH.dll/README.md`

---

## Cau truc du lieu

### Bang: VW_AR_CDKH (View bao cao cong no KH)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_kh | varchar | 50 | Ma khach hang |
| ten_kh | nvarchar | 200 | Ten khach hang |
| dia_chi | nvarchar | 500 | Dia chi |
| ma_so_thue | varchar | 50 | Ma so thue |
| ma_tk | varchar | 20 | Tai khoan cong no |
| ten_tk | nvarchar | 200 | Ten tai khoan |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |
| du_dk_nt | decimal | 18,2 | So du dau ky NT |
| du_dk | decimal | 18,2 | So du dau ky VND |
| ps_no_nt | decimal | 18,2 | Phat sinh no NT |
| ps_no | decimal | 18,2 | Phat sinh no VND |
| ps_co_nt | decimal | 18,2 | Phat sinh co NT |
| ps_co | decimal | 18,2 | Phat sinh co VND |
| du_ck_nt | decimal | 18,2 | So du cuoi ky NT |
| du_ck | decimal | 18,2 | So du cuoi ky VND |
| ma_plkh1 | varchar | 50 | Phan loai KH 1 |
| ma_plkh2 | varchar | 50 | Phan loai KH 2 |
| ma_plkh3 | varchar | 50 | Phan loai KH 3 |
| ma_nhkh | varchar | 50 | Ma nhom KH |

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| ARTT | So du dau ky hoa don | FK ma_kh |
| ARPost2TT | Phan bo thanh toan | FK ma_kh |
| AR4PH | Chung tu AR4 header | FK ma_kh |
| AR4CT | Chung tu AR4 chi tiet | FK ma_kh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ma_kh |
| DMTK | Tai khoan | Lookup ma_tk (tk_cn=1) |

---

## Form classes

### 1. frmARCDKH (Form xem bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi danh sach cong no khach hang, loc, xuat bao cao
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| txtMa_Tk | AsTextBox | Ma tai khoan cong no |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao |
| crvReportViewer | CrystalReportViewer | Viewer bao cao |
| btnExport | Button | Nut xuat Excel |

### 2. frmARCDKHEdit (Form chinh sua)
- **Ke thua:** (khong xac dinh)
- **Chuc nang:** Chinh sua thong tin cong no

### 3. frmARCDKHFilter (Form loc)
- **Ke thua:** (khong xac dinh)
- **Chuc nang:** Loc du lieu cong no

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_CDKH_GET | Lay danh sach cong no khach hang |
| SP_AR_CDKH_GETBYID | Lay chi tiet cong no 1 KH |
| SP_AR_CDKH_FIND | Tim kiem cong no KH |
| SP_AR_CDKH_REPORT | Lay du lieu bao cao |

### SP_GET (reference)

```sql
-- Lay danh sach cong no khach hang
EXEC SP_AR_CDKH_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_tk VARCHAR(50) = NULL,
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL,
    @pMa_nt VARCHAR(10) = 'VND',
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_REPORT (reference)

```sql
-- Lay du lieu bao cao cong no
EXEC SP_AR_CDKH_REPORT
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50) = NULL,
    @pMa_tk VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_nt VARCHAR(10) = 'VND'
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid date range | ngay1, ngay2 | 'Ngay bat dau phai nho hon ngay ket thuc' |
| Valid customer | ma_kh | 'Ma khach hang khong ton tai' |
| Valid account | ma_tk | 'Tai khoan khong hop le' |

### Business Rules

1. **Loc theo thoi gian**:
   - Mac dinh: ky bao cao hien tai
   - Cho phep chon khoang thoi gian tu ngay - den ngay

2. **Loc theo khach hang**:
   - Khong chon: hien thi tat ca KH
   - Chon 1 KH: chi hien thi KH do
   - AutoLookup tra ve danh sach KH hoat dong

3. **Loc theo tai khoan**:
   - Chi hien thi tai khoan co tinh chat cong no (tk_cn=1)
   - Mac dinh: tai khoan phai thu theo cau hinh

4. **Xuat bao cao**:
   - Crystal Report cho in an
   - Export Excel cho xu ly du lieu
   - Drill-down F4 xem chi tiet chung tu

### Tinh toan so du

- So du dau ky = Du cuoi ky ky truoc
- Phat sinh no = Tong cac but toan no trong ky
- Phat sinh co = Tong cac but toan co trong ky
- So du cuoi ky = Dau ky + No - Co

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/CDKH.php
namespace Diepxuan\Simba\Models\AR;

class CDKH extends Model
{
    protected $table = 'VW_AR_CDKH'; // View hoac table tong hop
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    // Relationships
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }

    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'ma_tk', 'ma_tk');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetCDKH.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetCDKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_CDKH_GET';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pMa_tk',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
        'pPageIndex',
        'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARReportCDKH.php
class AsARReportCDKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_CDKH_REPORT';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pMa_tk',
        'pNgay1',
        'pNgay2',
        'pMa_nt',
    ];
}
```

### 3. Livewire Component (Report)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Baocao/CongNoKhachHang.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Baocao;

class CongNoKhachHang extends Component
{
    const MA_CT = 'AR';
    const REPORT_TYPE = 'ARCDKH';

    public ?string $pMaKh = null;
    public ?string $pMaTk = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pMaNt = 'VND';
    public string $pKyBc = '';
    public Collection $pData;
    public array $pSummary = [];

    public function mount(): void
    {
        $this->loadConfig();
    }

    public function loadReport(): void
    {
        // Goi SP_REPORT
        $sp = new AsARReportCDKH();
        $this->pData = $sp->execute([...]);
        $this->calculateSummary();
    }

    public function exportExcel(): void
    {
        // Export Excel
    }

    public function render(): View
    {
        return view('catalog::ar.baocao.cong-no-khach-hang');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/baocao/
├── cong-no-khach-hang.blade.php        (Form loc & xem bao cao)
├── cong-no-khach-hang-partial.blade.php (Component bao cao)
└── _cong-no-khach-hang-row.blade.php   (Dong bao cao)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/baocao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/cong-no-khach-hang', [CongNoKhachHang::class, 'render'])
            ->name('cong-no-khach-hang');
        Route::get('/cong-no-khach-hang/export', [CongNoKhachHang::class, 'exportExcel'])
            ->name('cong-no-khach-hang.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | CDKH.php | View bao cao |
| Model | laravel-simba | DMKH.php | Lookup KH |
| Model | laravel-simba | DMTK.php | Lookup TK |
| SP | laravel-simba | AsARGetCDKH.php | Lay du lieu |
| SP | laravel-simba | AsARReportCDKH.php | Bao cao |
| Component | laravel-catalog | CongNoKhachHang.php | View/Controller |
| Library | laravel-catalog | ExcelExport.php | Xuat Excel |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model CDKH (View)
- [ ] Tao Livewire CongNoKhachHang (report)
- [ ] Tao Views (filter + report table)
- [ ] Them Routes
- [ ] Implement export Excel
- [ ] Test bao cao voi du lieu thuc