# Task 312: GLRptF5CTGS02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module F5CTGS02 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptF5CTGS02.dll
- **Assembly Title:** GLRptF5CTGS01
- **Version:** 1.0.0.0
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

### 1. frmGLRptF5CTGS02
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao F5 CTGS02

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_F5CTGS02_GET | Lay du lieu CTGS02 |

### Parameters reference

```sql
EXEC SP_GL_RPT_F5CTGS02_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **Bao cao tong hop**: Hien thi tong hop cac chung tu
2. **Drill-down F5**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/F5CTGS02Service.php
namespace Diepxuan\Simba\Services\GL;

class F5CTGS02Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/F5ctgs02.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class F5ctgs02 extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── f5ctgs02.blade.php
└── _f5ctgs02-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/f5ctgs02', [F5ctgs02::class, 'render'])
    ->name('catalog.gl.baocao.f5ctgs02');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | F5CTGS02Service.php | Chinh |
| Component | laravel-catalog | F5ctgs02.php | Livewire |

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
