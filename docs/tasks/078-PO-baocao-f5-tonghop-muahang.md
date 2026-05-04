# Task 078: PORptF5TH0

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang bao cao drill-down F5 (tong hop) tu .NET sang PHP Laravel, dat ket qua tuong duong bao cao chi tiet khi drill-down tu bao cao tong hop mua hang.

## Chi tiet
- **DLL:** PORptF5TH0.dll
- **Chuc nang:** Bao cao drill-down F5 (tong hop)
- **Loai:** Report (RPT) - Drill-down
- **Assembly Title:** SORptF5TH0
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** asiasoft
- **Ma_ct:** PORptF5TH0

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PORptF5TH0.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| POMH | Phieu mua hang | Header chung tu |
| POMHCT | Chi tiet phieu mua | Detail chung tu |
| DMNCC | Danh muc nha cung cap | FK ma_ncc |
| DMVAT TU | Danh muc vat tu | FK ma_vt |

### Table Navigation

| Bang | Mo ta |
|------|-------|
| POMH | Lay thong tin chung tu |
| POMHCT | Lay chi tiet chung tu |

---

## Form classes

### frmPORptF5TH0 (Form drill-down)
- **Ke thua:** frmDrilldownReport
- **Chuc nang:** Hien thi chi tiet tu bao cao tong hop

### Constructors

| Constructor | Tham so | Mo ta |
|-------------|---------|-------|
| frmPORptF5TH0() | - | Mac dinh |
| frmPORptF5TH0(...) | motherReportInfo, drilldown_menuid, formularFields, isNT, nhan_in, filter4Tilte, formatedColList, datasource, arg | Drill-down tu bao cao me |

### Fields (from constructor)

| Field | Type | Mo ta |
|-------|------|-------|
| motherReportInfo | string | Thong tin bao cao me |
| drilldown_menuid | string | Menu ID cua drill-down |
| formularFields | string[] | Cac truong cong thuc |
| isNT | bool | La ngoai te |
| nhan_in | string | Nhan in |
| filter4Tilte | string | Filter cho title |
| formatedColList | string[] | Danh sach cot dinh dang |
| datasource | DataTable | Du lieu nguon |
| arg | string | Cac tham so them |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_RPTF5TH0_GET | Lay du lieu chi tiet |
| SP_PO_RPTF5TH0_GETBYID | Lay chi tiet 1 dong |

### SP_GET (reference)

```sql
EXEC SP_PO_RPTF5TH0_GET
    @pMa_cty VARCHAR(50) = '001',
    @pArg VARCHAR(500) = NULL,  -- Tham so tu bao cao me
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_ncc VARCHAR(50) = NULL,
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL,
    @pLoai VARCHAR(10) = NULL,
    @pKy INT = NULL,
    @pNam INT = NULL,
    @pNhom_theo VARCHAR(50) = NULL,
    @pMa_nhom VARCHAR(50) = NULL,
    @pStt_rec VARCHAR(50) = NULL
```

### SP_GETBYID (reference)

```sql
EXEC SP_PO_RPTF5TH0_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pStt_rec VARCHAR(50)
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid arg | arg | 'Tham so khong hop le' |

### Business Rules

1. **Drill-down (F5)**:
   - Nhan F5 tu bao cao me (PORptTH01, PORptTH02, PORptTH03, PORptBK01, PORptBK02, PORptBK03, PORptBCPT03)
   - Nhan tham so tu dong duoc chon
   - Hien thi chi tiet theo tham so truyen vao

2. **Tham so drill-down**:
   - loai: THANG/QUY/NAM (tu PORptTH02)
   - ky: So ky (thang/quy)
   - nam: Nam bao cao
   - nhom_theo: Chi tieu nhom (tu PORptBK02, PORptBK03)
   - ma_nhom: Ma nhom (tu PORptBK02, PORptBK03)
   - stt_rec: So tu nhien chung tu
   - ma_vt: Ma vat tu
   - ma_ncc: Ma nha cung cap

3. **Drill-down tiep theo**:
   - Tu dong goi CreateDrilldownArgument
   - Mo form drill-down tiep (PORptF5TH0)

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
// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptF5TH0.php
namespace Diepxuan\Simba\StoredProcedures\PO;

class AsPOGetRptF5TH0 extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTF5TH0_GET';
    protected $params = [
        'pMa_cty',
        'pArg',
        'pMa_vt',
        'pMa_ncc',
        'pTu_ngay',
        'pDen_ngay',
        'pLoai',
        'pKy',
        'pNam',
        'pNhom_theo',
        'pMa_nhom',
        'pStt_rec',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/PO/AsPOGetRptF5TH0ById.php
class AsPOGetRptF5TH0ById extends StoredProcedure
{
    protected $procedure = 'SP_PO_RPTF5TH0_GETBYID';
    protected $params = ['pMa_cty', 'pStt_rec'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Report/TonghopF5.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Report;

class TonghopF5 extends Component
{
    // Tham so tu bao cao me
    public ?string $pMother_report = null;
    public ?string $pDrilldown_menuid = null;
    public ?string $pFormular_fields = null;
    public bool $pIsNT = false;
    public ?string $pNhan_in = null;
    public ?string $pFilter4_title = null;
    public ?string $pFormated_col_list = null;

    // Tham so drill-down
    public ?string $pArg = null;
    public ?string $pMa_vt = null;
    public ?string $pMa_ncc = null;
    public ?string $pTu_ngay = null;
    public ?string $pDen_ngay = null;
    public ?string $pLoai = null;       // THANG/QUY/NAM
    public ?int $pKy = null;             // So ky
    public ?int $pNam = null;            // Nam
    public ?string $pNhom_theo = null;   // Chi tieu nhom
    public ?string $pMa_nhom = null;     // Ma nhom
    public ?string $pStt_rec = null;     // So tu nhien

    public Collection $pData;
    public array $pColumns = [];
    public array $pFilterTitle = [];

    public function mount(
        ?string $mother_report = null,
        ?string $drilldown_menuid = null,
        ?string $arg = null,
        ?string $ma_vt = null,
        ?string $ma_ncc = null,
        ?string $tu_ngay = null,
        ?string $den_ngay = null,
        ?string $loai = null,
        ?int $ky = null,
        ?int $nam = null,
        ?string $nhom_theo = null,
        ?string $ma_nhom = null,
        ?string $stt_rec = null,
    ): void {
        $this->pMother_report = $mother_report;
        $this->pDrilldown_menuid = $drilldown_menuid;
        $this->pArg = $arg;
        $this->pMa_vt = $ma_vt;
        $this->pMa_ncc = $ma_ncc;
        $this->pTu_ngay = $tu_ngay;
        $this->pDen_ngay = $den_ngay;
        $this->pLoai = $loai;
        $this->pKy = $ky;
        $this->pNam = $nam;
        $this->pNhom_theo = $nhom_theo;
        $this->pMa_nhom = $ma_nhom;
        $this->pStt_rec = $stt_rec;
        $this->pData = collect([]);
        $this->pColumns = ['stt_rec', 'so_ct', 'ngay_ct', 'ma_vt', 'ten_vt', 'ma_ncc', 'ten_ncc', 'so_luong', 'don_gia', 'tien'];
    }

    public function loadData(): void
    {
        $result = AsPOGetRptF5TH0::run([
            'pMa_cty' => '001',
            'pArg' => $this->pArg,
            'pMa_vt' => $this->pMa_vt,
            'pMa_ncc' => $this->pMa_ncc,
            'pTu_ngay' => $this->pTu_ngay,
            'pDen_ngay' => $this->pDen_ngay,
            'pLoai' => $this->pLoai,
            'pKy' => $this->pKy,
            'pNam' => $this->pNam,
            'pNhom_theo' => $this->pNhom_theo,
            'pMa_nhom' => $this->pMa_nhom,
            'pStt_rec' => $this->pStt_rec,
        ]);
        $this->pData = collect($result);
        $this->buildFilterTitle();
    }

    public function buildFilterTitle(): void
    {
        $filters = [];
        if ($this->pLoai) $filters[] = "Loai: {$this->pLoai}";
        if ($this->pKy) $filters[] = "Ky: {$this->pKy}";
        if ($this->pNam) $filters[] = "Nam: {$this->pNam}";
        if ($this->pMa_vt) $filters[] = "VT: {$this->pMa_vt}";
        if ($this->pMa_ncc) $filters[] = "NCC: {$this->pMa_ncc}";
        if ($this->pNhom_theo) $filters[] = "Nhom theo: {$this->pNhom_theo}";
        if ($this->pMa_nhom) $filters[] = "Ma nhom: {$this->pMa_nhom}";
        $this->pFilterTitle = $filters;
    }

    public function drilldown(string $sttRec): RedirectResponse
    {
        // Drill-down tiep theo
        return redirect()->route('catalog.po.report.tonghopf5', [
            'mother_report' => 'PORptF5TH0',
            'stt_rec' => $sttRec,
        ]);
    }

    public function render(): View
    {
        return view('catalog::po.report.tonghopf5');
    }
}
```

### 4. Views

```
resources/views/catalog/po/report/
├── tonghopf5.blade.php           (Drill-down detail)
└── _tonghopf5-row.blade.php      (Row component)
```

### 5. Routes

```php
Route::prefix('catalog/po/report')
    ->name('catalog.po.report.')
    ->group(function () {
        Route::get('/tong-hop-f5', [TonghopF5::class, 'render'])
            ->name('tonghopf5');
        Route::get('/tong-hop-f5/{sttRec}', [TonghopF5::class, 'render'])
            ->name('tonghopf5.detail');
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
| SP | laravel-simba | AsPOGetRptF5TH0.php | Get drill-down data |
| SP | laravel-simba | AsPOGetRptF5TH0ById.php | Get by ID |
| Component | laravel-catalog | TonghopF5.php | Drill-down form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, GetById)
- [ ] Tao Model POMH, POMHCT
- [ ] Tao Livewire TonghopF5 (Drill-down)
- [ ] Tao Views (Detail list)
- [ ] Them Routes
- [ ] Test drill-down tu PORptTH01
- [ ] Test drill-down tu PORptTH02
- [ ] Test drill-down tu PORptTH03
- [ ] Test drill-down tu PORptBK01
- [ ] Test drill-down tu PORptBK02
- [ ] Test drill-down tu PORptBK03
- [ ] Test drill-down tu PORptBCPT03
- [ ] Test drill-down tiep theo (F5 -> F5)