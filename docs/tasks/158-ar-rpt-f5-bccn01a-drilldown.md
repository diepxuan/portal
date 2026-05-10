# Task 158: AR-Rpt-F5-BCCN01a-DrillDown

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang drill-down F5 tu bao cao BCCN01a sang PHP Laravel.

## Chi tiet
- **DLL:** ArRptF5BCCN01a.dll
- **Chuc nang:** Drill-down F5 tu bao cao BCCN01a (Cong no khach hang)
- **Loai:** Report (Drill-down)
- **Assembly Title:** ArRptF5BCCN01a
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia
- **Ma_ct:** AR

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ArRptF5BCCN01a.dll/README.md`

---

## Cau truc du lieu

### Bang: ARRptBCCN01a (Bang tam drill-down)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So te nhan biet |
| ma_kh | varchar | Ma khach hang |
| ten_kh | nvarchar | Ten khach hang |
| so_du_no | decimal | So du no |
| so_du_co | decimal | So du co |
| ngay_ct | datetime | Ngay chung tu |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| ARRptBCCN01a | Bao cao me | Drilldown source |

---

## Form classes

### frmArRptF5BCCN01a (Drill-down Report Form)
- **Ke thua:** frmDrilldownReport
- **Chuc nang:** Hien thi chi tiet drill-down tu bao cao BCCN01a
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvBC | AsDataGridView | Luoi hien thi du lieu drill-down |
| crvReportViewer | CrystalReportViewer | Crystal Report viewer (neu co) |

### Base Controls (tu frmDrilldownReport)

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | AsComboBox | Ky bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |
| txtTieu_De | TextBox | Tieu de bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| (From mother report) | Lay du lieu tu bao cao cha |

### Drilldown Parameters

| Parameter | Kieu | Mo ta |
|-----------|------|-------|
| motherReportInfo | ReportInformation | Thong tin bao cao me |
| drilldownMenuId | string | ID menu drilldown |
| formularFields | AsDictionary | Dictionary cac truong cong thuc |
| isNT | bool | Co phai ngoai te khong |
| nhan_in | string | Nhan in |
| filter4Tilte | string | Filter cho tieu de |
| formatedColList | string | Danh sach cot dinh dang |
| datasource | object | Nguon du lieu |

---

## Business Logic

### Validate Rules

| Rule | Message |
|------|---------|
| Kiem tra quyen xem bao cao | 'Khong co quyen xem bao cao' |
| Kiem tra ngay ky | 'Ngay khong hop le' |

### Business Rules

1. **Drilldown tu bao cao me:**
   - Nhan vao dong trong BCCN01a de drill-down
   - Truyen tham so: ma_kh, ngay1, ngay2

2. **Hien thi chi tiet:**
   - Hien thi chi tiet cong no theo khach hang
   - Phan theo no/co cua tung chung tu

3. **Ho tro isNT:**
   - Neu la ngoai te, hien thi so tien ngoai te
   - Neu la VND, hien thi so tien VND

4. **Filter title:**
   - Hien thi thong tin loc tu bao cao cha

---

## Mapping PHP

### 1. Model (neu can)

```php
// Khong co bang, chi lay tu SP cua bao cao cha
```

### 2. Livewire Component (Drilldown Report)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Reports/BCCN01aDrilldown.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Reports;

class BCCN01aDrilldown extends Component
{
    const MA_CT = 'AR';

    public ?string $pMaKh = null;
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public bool $pIsNT = false;
    public ?string $pTieuDe = null;

    protected $queryString = [
        'pMaKh' => ['except' => null],
        'pNgay1' => ['except' => null],
        'pNgay2' => ['except' => null],
        'pIsNT' => ['except' => false],
    ];

    public function mount(
        ?string $maKh = null,
        ?string $ngay1 = null,
        ?string $ngay2 = null,
        bool $isNT = false,
        ?string $tieuDe = null
    ): void {
        $this->pMaKh = $maKh;
        $this->pNgay1 = $ngay1;
        $this->pNgay2 = $ngay2;
        $this->pIsNT = $isNT;
        $this->pTieuDe = $tieuDe;
    }

    public function getData(): Collection
    {
        // Goi SP lay du lieu drill-down
        // Tra ve Collection cho DataGrid
    }

    public function render(): View
    {
        return view('catalog::ar.reports.bccn01a-drilldown');
    }
}
```

### 3. Views

```
resources/views/catalog/ar/reports/
├── bccn01a-drilldown.blade.php    (Drill-down page)
└── _bccn01a-drilldown-row.blade.php (Component row)
```

### 4. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/bao-cao')
    ->name('catalog.ar.baocao.')
    ->group(function () {
        Route::get('/bccn01a-drilldown', [BCCN01aDrilldown::class, 'render'])
            ->name('bccn01a.drilldown');
    });
```

---

## Dependencies

| Loai | Package | Ghi chu |
|------|---------|---------|
| Component | laravel-catalog | BCCN01aDrilldown |
| Voucher | AR - Bao cao BCCN01a | Nguon drill-down |
| Framework | AsiaERP | frmDrilldownReport pattern |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Livewire BCCN01aDrilldown
- [ ] Tao View drill-down
- [ ] Them Routes
- [ ] Test drilldown tu BCCN01a
- [ ] Test hien thi du lieu
- [ ] Test export Excel
- [ ] Test in bao cao (neu can)
- [ ] Integration test voi module AR
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
