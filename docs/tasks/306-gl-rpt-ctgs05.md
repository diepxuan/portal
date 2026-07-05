# Task 306: GLRptCTGS05

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bang ke chung tu CTGS05 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptCTGS05.dll
- **Assembly Title:** Bang ke chung tu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMLO | Danh muc lo | Loc theo ngay lo |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay_ct1, ngay_ct2 | Ngay chung tu |
| ngay_lo1, ngay_lo2 | Ngay lo |

---

## Form classes

### 1. frmGLRptCTGS05
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke chung tu

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay chung tu |
| txtNgay_lo1, txtNgay_lo2 | AsMaskedTextBox | Ngay lo |
| cboMau_bc | ComboBox | Chon mau bao cao |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CTGS05_GET | Lay du lieu bang ke CTGS05 |

### Parameters reference

```sql
EXEC SP_GL_RPT_CTGS05_GET
    @pMa_cty VARCHAR(50),
    @pNgay_ct1 DATETIME,
    @pNgay_ct2 DATETIME,
    @pNgay_lo1 DATETIME = NULL,
    @pNgay_lo2 DATETIME = NULL
```

---

## Business Logic

### Business Rules

1. **Loc theo ngay CT**: Theo ngay chung tu
2. **Loc theo ngay lo**: Theo ngay nhap lo (khac ngay CT)
3. **Tong hop**: Hien thi chi tiet cac chung tu

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/CTGS05Service.php
namespace Diepxuan\Simba\Services\GL;

class CTGS05Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Ctgs05.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Ctgs05 extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay_ct1 = null;
    public ?Carbon $ngay_ct2 = null;
    public ?Carbon $ngay_lo1 = null;
    public ?Carbon $ngay_lo2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── ctgs05.blade.php
└── _ctgs05-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/ctgs05', [Ctgs05::class, 'render'])
    ->name('catalog.gl.baocao.ctgs05');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | CTGS05Service.php | Chinh |
| Component | laravel-catalog | Ctgs05.php | Livewire |
| Lookup | laravel-simba | DMLO.php | Lo |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao
- [ ] Test loc ngay lo
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
