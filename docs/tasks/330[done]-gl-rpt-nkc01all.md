# Task 330: GlRptNKC01All

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module NKC01All (Bang can doi phat sinh tat ca TK) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptNKC01All.dll
- **Assembly Title:** Bang can doi phat sinh cac tai khoan
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

### 1. frmGlRptNKC01All
- **Ke thua:** frmReport
- **Chuc nang:** Bang can doi phat sinh tat ca TK

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
| SP_GL_RPT_NKC01ALL_GET | Lay du lieu NKC01All |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC01ALL_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **Bang can doi PS**: Hien thi so du dau ky, phat sinh, so du cuoi ky tat ca TK
2. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC01AllService.php
namespace Diepxuan\Simba\Services\GL;

class NKC01AllService
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Nkc01all.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Nkc01all extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── nkc01all.blade.php
└── _nkc01all-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/nkc01all', [Nkc01all::class, 'render'])
    ->name('catalog.gl.baocao.nkc01all');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC01AllService.php | Chinh |
| Component | laravel-catalog | Nkc01all.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `gl.task.330`
