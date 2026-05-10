# Task 328: GlRptF5Bctc03

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module F5Bctc03 (Bao cao F5 BCTC03) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptF5Bctc03.dll
- **Assembly Title:** GLRptF5CTGS01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Drilldown theo tk_no, tk_co |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| tk_no | Tai khoan no |
| tk_co | Tai khoan co |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGlRptF5Bctc03
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao F5 BCTC03

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk_no | AsTextBox | Tai khoan no |
| txtTk_co | AsTextBox | Tai khoan co |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_F5BCTC03_GET | Lay du lieu F5BCTC03 |

### Parameters reference

```sql
EXEC SP_GL_RPT_F5BCTC03_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk_no VARCHAR(50) = NULL,
    @pTk_co VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Drill-down**: Chi tiet theo tk_no hoac tk_co

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/F5BCTC03Service.php
namespace Diepxuan\Simba\Services\GL;

class F5BCTC03Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/F5bctc03.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class F5bctc03 extends Component
{
    const MA_CT = 'GL';

    public ?string $tk_no = null;
    public ?string $tk_co = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── f5bctc03.blade.php
└── _f5bctc03-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/f5bctc03', [F5bctc03::class, 'render'])
    ->name('catalog.gl.baocao.f5bctc03');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | F5BCTC03Service.php | Chinh |
| Component | laravel-catalog | F5bctc03.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

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
