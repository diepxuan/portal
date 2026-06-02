# Task 336: GlRptNkc06

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Nkc06 (So chi tiet cac tai khoan) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptNkc06.dll
- **Assembly Title:** So chi tiet cac tai khoan
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

### 1. frmGlRptNkc06
- **Ke thua:** frmReport
- **Chuc nang:** So chi tiet cac tai khoan

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
| SP_GL_RPT_NKC06_GET | Lay du lieu so chi tiet cac tai khoan |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC06_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **So chi tiet TK**: Hien thi chi tiet nhieu tai khoan
2. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC06Service.php
namespace Diepxuan\Simba\Services\GL;

class NKC06Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkc06.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkc06 extends Component
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
├── nkc06.blade.php
└── _nkc06-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkc06', [Nkc06::class, 'render'])
    ->name('catalog.gl.socai.nkc06');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC06Service.php | Chinh |
| Component | laravel-catalog | Nkc06.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so chi tiet TK
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `gl.task.336`
