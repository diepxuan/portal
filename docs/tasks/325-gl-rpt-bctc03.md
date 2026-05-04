# Task 325: GlRptBctc03

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module BCTC03 (Bao cao ket qua hoat dong kinh doanh) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptBctc03.dll
- **Assembly Title:** Bao cao ket qua hoat dong kinh doanh
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

### 1. frmGlRptBctc03
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao KQ HDKD

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
| SP_GL_RPT_BCTC03_GET | Lay du lieu BCTC03 |

### Parameters reference

```sql
EXEC SP_GL_RPT_BCTC03_GET
    @pMa_cty VARCHAR(50),
    @pQd_cdkt VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **Bao cao KQ HDKD**: Hien thi doanh thu, chi phi, loi nhuan
2. **So sanh ky**: Ky hien tai vs ky truoc
3. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTC03Service.php
namespace Diepxuan\Simba\Services\GL;

class BCTC03Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctc03.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bctc03 extends Component
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
├── bctc03.blade.php
└── _bctc03-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bctc03', [Bctc03::class, 'render'])
    ->name('catalog.gl.baocao.bctc03');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTC03Service.php | Chinh |
| Component | laravel-catalog | Bctc03.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao KQ HDKD
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test