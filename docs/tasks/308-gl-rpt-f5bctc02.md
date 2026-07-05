# Task 308: GLRptF5BCTC02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module F5BCTC02 (Bao cao BCTC02) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptF5BCTC02.dll
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
| ngay_ct1, ngay_ct2 | Ngay bat dau/ket thuc |
| tk | Tai khoan loc |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGLRptF5BCTC02
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao BCTC02 (F5)

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan loc |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_F5BCTC02_GET | Lay du lieu BCTC02 |

### Parameters reference

```sql
EXEC SP_GL_RPT_F5BCTC02_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Drill-down F5**: Chi tiet theo tai khoan
2. **Drill-down Ctrl+F5**: Chi tiet theo tk/tk_du

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/F5BCTC02Service.php
namespace Diepxuan\Simba\Services\GL;

class F5BCTC02Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/F5bctc02.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class F5bctc02 extends Component
{
    const MA_CT = 'GL';

    public ?string $tk = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── f5bctc02.blade.php
└── _f5bctc02-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/f5bctc02', [F5bctc02::class, 'render'])
    ->name('catalog.gl.baocao.f5bctc02');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | F5BCTC02Service.php | Chinh |
| Component | laravel-catalog | F5bctc02.php | Livewire |
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

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `gl.task.308`
