# Task 332: GlRptNkc02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Nkc02 (So nhat ky chung) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptNkc02.dll
- **Assembly Title:** So nhat ky chung
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
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGlRptNkc02
- **Ke thua:** frmReport
- **Chuc nang:** So nhat ky chung

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
| SP_GL_RPT_NKC02_GET | Lay du lieu so nhat ky chung |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC02_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **So NK chung**: Hien thi tat ca CT theo thu tu ngay, so
2. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC02Service.php
namespace Diepxuan\Simba\Services\GL;

class NKC02Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkc02.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkc02 extends Component
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
├── nkc02.blade.php
└── _nkc02-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkc02', [Nkc02::class, 'render'])
    ->name('catalog.gl.socai.nkc02');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC02Service.php | Chinh |
| Component | laravel-catalog | Nkc02.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so NK chung
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
