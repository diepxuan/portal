# Task 326: GlRptBctc04

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module BCTC04 (Bao cao LCTT - Phuong phap truc tiep) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptBctc04.dll
- **Assembly Title:** Bao cao luu chuyen tien te theo phuong phap truc tiep
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Drilldown theo tk |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| qd_cdkt | Quyet dinh cong dung |
| ngay1, ngay2 | Ngay ky bao cao |

---

## Form classes

### 1. frmGlRptBctc04
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao LCTT (Direct Method) v04

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| txtQd_cdkt | AsTextBox | Quyet dinh cong dung (Lookup) |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCTC04_GET | Lay du lieu BCTC04 LCTT |

### Parameters reference

```sql
EXEC SP_GL_RPT_BCTC04_GET
    @pMa_cty VARCHAR(50),
    @pQd_cdkt VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **LCTT Direct**: Phan loai dong tien theo HDKD, dau tu, tai chinh
2. **So sanh ky**: Ky hien tai vs ky truoc
3. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTC04Service.php
namespace Diepxuan\Simba\Services\GL;

class BCTC04Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctc04.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bctc04 extends Component
{
    const MA_CT = 'GL';

    public ?string $qd_cdkt = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bctc04.blade.php
└── _bctc04-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bctc04', [Bctc04::class, 'render'])
    ->name('catalog.gl.baocao.bctc04');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTC04Service.php | Chinh |
| Component | laravel-catalog | Bctc04.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao LCTT
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test