# Task 118: FARptBCTS09

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao bien dong tai san 09 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCTS09.dll
- **Chuc nang:** Bao cao bien dong tai san 09 (So su dung)
- **Loai:** Report (Bao cao)
- **Assembly Title:** FARptBCTS09
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCTS09.dll/README.md`

---

## Form classes

### frmFARptBCTS09 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboLoai | ComboBox | Loai (0=Tat ca, 1=Tai san, 2=Cong cu) |
| txtMa_ts | AsTextBox | Ma tai san |
| txtMa_cc | AsTextBox | Ma cong cu |
| txtMa_bpsd | AsTextBox | Ma bo phan su dung |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | ComboBox | Ky bao cao |
| cboMau_bc | ComboBox | Mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| cmdOk | Button | Xem bao cao |
| cmdExcel | Button | Xuat Excel |

---

## Business Logic

### ComboBox Items (cboLoai)

| Index | Gia tri | Mo ta |
|-------|---------|-------|
| 0 | "Tat ca" | Hien thi ca tai san va cong cu |
| 1 | "Tai san" | Chi hien thi tai san |
| 2 | "Công cu" | Chi hien thi cong cu |

### Business Rules

1. **Dieu khien nhap lieu dong**:
   - Khi chon "Tai san": vo hieu hoa txtMa_cc
   - Khi chon "Công cu": vo hieu hoa txtMa_ts
   - Khi chon "Tat ca": cho phep nhap ca hai

---

## Mapping PHP

### 1. Livewire Component (Report Viewer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/Baocaobiendong09.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class Baocaobiendong09 extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'BCTS09';

    public int $pLoai = 0; // 0=Tat ca, 1=TS, 2=CC
    public ?string $pMa_ts = null;
    public ?string $pMa_cc = null;
    public ?string $pMa_bpsd = null;
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public ?int $pKyBc = null;
    public ?int $pMau_bc = null;
    public string $pTieuDe = '';

    public function render(): View
    {
        return view('catalog::fa.reports.baocao-bien-dong-09');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-bien-dong-09', [Baocaobiendong09::class, 'render'])
    ->name('catalog.fa.reports.bien-dong-09');
```

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_BCTS09_GET` | Lay du lieu bien dong 09 |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCTS09_GET
- [ ] Tao Livewire Baocaobiendo ng09
- [ ] Tao View baocao-bien-dong-09.blade.php
- [ ] Them Routes
- [ ] Test dieu khien nhap lieu theo loai
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** FIXED — space trong tên class PHP (Baocaobiendo ng09 → Baocaobiendong09)
- **Batch:** 2

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
