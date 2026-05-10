# Task 066: PORptTH02

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bao cao tong hop mua hang 02 tu .NET sang PHP Laravel, dat ket qua tuong duong bao cao tong hop mua hang theo thoi gian (thang/quy/nam).

## Chi tiet
- **DLL:** PORptTH02.dll
- **Chuc nang:** Bao cao tong hop mua hang 02
- **Loai:** Report (RPT)
- **Assembly Title:** Bao cao tong hop mua hang 02
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PORptTH02 (Report PO)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptTH02.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| POMH | Phieu mua hang | Header chung tu mua |
| POMHCT | Chi tiet phieu mua | Detail chung tu mua |
| DMNCC | Danh muc nha cung cap | FK ma_ncc |
| DMVAT TU | Danh muc vat tu | FK ma_vt |
| DMKHO | Danh muc kho | FK ma_kho |

### Table Navigation

| Bang | Mo ta |
|------|-------|
| POMH | Lay du lieu chung tu mua |
| POMHCT | Lay chi tiet hang mua |

---

## Form classes

### frmPORptTH02 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Tao bao cao tong hop mua hang theo thoi gian

### Filter Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboLoai | ComboBox | Loai bao cao (thang/quy/nam) |
| cboLoai_ct | ComboBox | Loai chung tu (phieu nhap/hd mua) |
| cboLoaiPhieu | ComboBox | Loai phieu |
| txtTu_thang | AsTextNumeric | Tu thang |
| txtSo_ky | AsTextNumeric | So ky |
| txtNam | AsTextNumeric | Nam |
| cboMau_bc | ComboBox | Mau bao cao |
| cmdExcel | Button | Xuat Excel |
| cmdPrint | Button | In bao cao |

### Loai bao cao

| Gia tri | Mo ta |
|---------|-------|
| THANG | Theo thang (1-12) |
| QUY | Theo quy (1-4) |
| NAM | Theo nam |

### Loai chung tu

| Gia tri | Mo ta |
|---------|-------|
| PN | Phieu nhap mua |
| HD | Hoa don mua hang |

### Loai phieu ho tro

| Gia tri | Mo ta |
|---------|-------|
| PNMH | Phieu nhap mua |
| HDMUA | Hoa don mua hang |
| PYC | Phieu yeu cau mua |
| DHMUA | Don dat mua |
| PCMH | Phieu chi phi mua |
| XTRNCC | Xuat tra lai NCC |
| HDDV | Hoa don mua dich vu |
| HDNHK | Hoa don mua hang nhap khau |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_RPTTH02_GET | Lay du lieu bao cao tong hop 02 |
| SP_PO_RPTTH02_GETBYID | Lay chi tiet 1 ky |
| SP_PO_RPTTH02_FIND | Tim kiem bao cao |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTTH02_GET
    @pMa_cty VARCHAR(50) = '001',
    @pLoai VARCHAR(10) = 'THANG',     -- THANG/QUY/NAM
    @pLoai_ct VARCHAR(10) = 'PN',     -- PN/HD
    @pLoai_phieu VARCHAR(100) = NULL,
    @pTu_thang INT = 1,
    @pSo_ky INT = 12,
    @pNam INT = 2024,
    @pMa_ncc VARCHAR(50) = NULL,
    @pMa_vt VARCHAR(50) = NULL
```

### SP_GETBYID (reference)

```sql
EXEC SP_PO_RPTTH02_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pLoai VARCHAR(10),
    @pKy INT,
    @pNam INT
```

### SP_FIND (reference)

```sql
EXEC SP_PO_RPTTH02_FIND
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(200) = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Min 1, Max 12 | tu_thang | 'Thang 1-12' |
| Min 1900, Max 2079 | nam | 'Nam 1900-2079' |
| Valid so ky | so_ky | 'So ky hop le' |
| So ky <= 12 | so_ky | 'So ky khong vuot qua 12' |

### Business Rules

1. **Loai bao cao**:
   - THANG: Hien thi 12 thang
   - QUY: Hien thi 4 quy
   - NAM: Hien thi 1 dong tong hop

2. **Drill-down (F5)**:
   - Click vao ky -> Hien thi chi tiet thang/quy
   - Truyen tham so: ma_vt, ma_ncc, tu_ngay, den_ngay

3. **Tinh toan**:
   - Tong hop theo ky (thang/quy/nam)
   - Tinh tong tien, tien thue, tong thanh toan

4. **Xuat bao cao**:
   - Crystal Report
   - Excel

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/PO/POMH.php
namespace Diepxuan\Simba\Models\PO;

class POMH extends Model
{
    protected $table = 'POMH';
    protected $primaryKey = 'stt_rec';
    public $incrementing = false;
    protected $connection = 'simba';

    public function chiTiet()
    {
        return $this->hasMany(POMHCT::class, 'stt_rec', 'stt_rec');
    }

    public function nhaCungCap()
    {
        return $this->belongsTo(DMNCC::class, 'ma_ncc', 'ma_ncc');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptTH02.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptTH02 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTTH02_GET';
    protected $params = [
        'pMa_cty',
        'pLoai',
        'pLoai_ct',
        'pLoai_phieu',
        'pTu_thang',
        'pSo_ky',
        'pNam',
        'pMa_ncc',
        'pMa_vt',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptTH02ById.php
class AsPOGetRptTH02ById extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTTH02_GETBYID';
    protected $params = [
        'pMa_cty',
        'pLoai',
        'pKy',
        'pNam',
    ];
}
```

### 3. Livewire Component (Form bao cao)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/TonghopMua02.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class TonghopMua02 extends Component
{
    public string $pLoai = 'THANG';
    public string $pLoai_ct = 'PN';
    public string $pLoai_phieu = '';
    public int $pTu_thang = 1;
    public int $pSo_ky = 12;
    public int $pNam = 2024;
    public ?string $pMau_bc = null;
    public ?string $pMa_ncc = null;
    public ?string $pMa_vt = null;

    public Collection $pData;
    public array $pColumns = [];

    protected $rules = [
        'pTu_thang' => 'required|integer|min:1|max:12',
        'pNam' => 'required|integer|min:1900|max:2079',
        'pSo_ky' => 'required|integer|min:1|max:12',
    ];

    public function mount(): void
    {
        $this->pData = collect([]);
        $this->pColumns = ['ky', 'so_ct', 't_tien', 't_thue', 't_tt'];
    }

    public function loadData(): void
    {
        $result = AsPOGetRptTH02::run([
            'pMa_cty' => '001',
            'pLoai' => $this->pLoai,
            'pLoai_ct' => $this->pLoai_ct,
            'pLoai_phieu' => $this->pLoai_phieu ?: null,
            'pTu_thang' => $this->pTu_thang,
            'pSo_ky' => $this->pSo_ky,
            'pNam' => $this->pNam,
            'pMa_ncc' => $this->pMa_ncc,
            'pMa_vt' => $this->pMa_vt,
        ]);
        $this->pData = collect($result);
    }

    public function drilldown(int $ky): RedirectResponse
    {
        return redirect()->route('catalog.po.report.tonghopf5', [
            'loai' => $this->pLoai,
            'ky' => $ky,
            'nam' => $this->pNam,
        ]);
    }

    public function exportExcel(): void
    {
        // Xuat Excel
    }

    public function render(): View
    {
        return view('catalog::po.report.tonghopmua02');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── tonghopmua02.blade.php
└── _tonghopmua02-row.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/tong-hop-mua-02', [TonghopMua02::class, 'render'])
            ->name('tonghopmua02');
        Route::get('/tong-hop-mua-02/export', [TonghopMua02::class, 'exportExcel'])
            ->name('tonghopmua02.export');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | POMH.php | Chung tu mua |
| Model | laravel-simba | POMHCT.php | Chi tiet chung tu |
| Model | laravel-simba | DMNCC.php | Nha cung cap |
| Model | laravel-simba | DMVAT TU.php | Vat tu |
| SP | laravel-simba | AsPOGetRptTH02.php | Get report data |
| SP | laravel-simba | AsPOGetRptTH02ById.php | Get by ID |
| Component | laravel-catalog | TonghopMua02.php | Form bao cao |
| Component | laravel-catalog | TonghopF5.php | Drill-down form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, GetById, Find)
- [ ] Tao Model POMH, POMHCT
- [ ] Tao Livewire TonghopMua02 (form bao cao)
- [ ] Tao Views (list + drilldown)
- [ ] Them Routes
- [ ] Test xem bao cao
- [ ] Test xuat Excel
- [ ] Test drill-down (F5)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
