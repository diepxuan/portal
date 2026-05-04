# Task 331: GlRptNkc01

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Nkc01 (So cai) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptNkc01.dll
- **Assembly Title:** So cai
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
| ngay1, ngay2 | Ngay bat dau/ket thuc |

---

## Form classes

### 1. frmGlRptNkc01
- **Ke thua:** frmReport
- **Chuc nang:** So cai

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_NKC01_GET | Lay du lieu so cai NKC01 |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC01_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **So cai**: Hien thi tat ca nghiem vu ke toan theo thoi gian
2. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC01Service.php
namespace Diepxuan\Simba\Services\GL;

class NKC01Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkc01.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkc01 extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/socai/
├── nkc01.blade.php
└── _nkc01-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkc01', [Nkc01::class, 'render'])
    ->name('catalog.gl.socai.nkc01');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC01Service.php | Chinh |
| Component | laravel-catalog | Nkc01.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so cai
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test