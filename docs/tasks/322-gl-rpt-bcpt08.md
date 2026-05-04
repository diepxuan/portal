# Task 322: GlRptBcpt08

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module BCPT08 (Bao cao ket qua hoat dong SXKD) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptBcpt08.dll
- **Assembly Title:** Bao cao ket qua hoat dong san xuat kinh doanh
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Drilldown theo tk |
| DMKHO | Danh muc kho | Lookup ma_kho |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| ma_kho | Ma kho (optional) |

---

## Form classes

### 1. frmGlRptBcpt08
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao ket qua SXKD

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| txtMa_kho | AsTextBox | Ma kho (AutoLookup) |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCPT08_GET | Lay du lieu BCPT08 |

### Parameters reference

```sql
EXEC SP_GL_RPT_BCPT08_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pMa_kho VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Bao cao KQ SXKD**: Hien thi ket qua hoat dong san xuat kinh doanh
2. **Loc theo kho**: Loc theo ma_kho neu co
3. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCPT08Service.php
namespace Diepxuan\Simba\Services\GL;

class BCPT08Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bcpt08.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bcpt08 extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_kho = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bcpt08.blade.php
└── _bcpt08-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bcpt08', [Bcpt08::class, 'render'])
    ->name('catalog.gl.baocao.bcpt08');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCPT08Service.php | Chinh |
| Component | laravel-catalog | Bcpt08.php | Livewire |
| Lookup | laravel-simba | DMKHO.php | Kho |

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