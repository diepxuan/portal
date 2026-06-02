# Task 307: GLRptF5BCPT08

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module F5BCPT08 (Bao cao phan tich BCT) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptF5BCPT08.dll
- **Assembly Title:** GLRptF5BCPT08
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
| tk_du | Tai khoan doi ung |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGLRptF5BCPT08
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao phan tich F5 BCT

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan chinh |
| txtTk_du | AsTextBox | Tai khoan doi ung |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_F5BCPT08_GET | Lay du lieu BCPT08 |

### Parameters reference

```sql
EXEC SP_GL_RPT_F5BCPT08_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk VARCHAR(50) = NULL,
    @pTk_du VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Loc theo TK**: Theo tai khoan chinh
2. **Loc theo TK doi ung**: Theo tk_du
3. **Drill-down**:
   - F5: Chi tiet theo tk
   - Ctrl+F5: Chi tiet theo tk/tk_du

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/F5BCPT08Service.php
namespace Diepxuan\Simba\Services\GL;

class F5BCPT08Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/F5bcpt08.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class F5bcpt08 extends Component
{
    const MA_CT = 'GL';

    public ?string $tk = null;
    public ?string $tk_du = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── f5bcpt08.blade.php
└── _f5bcpt08-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/f5bcpt08', [F5bcpt08::class, 'render'])
    ->name('catalog.gl.baocao.f5bcpt08');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | F5BCPT08Service.php | Chinh |
| Component | laravel-catalog | F5bcpt08.php | Livewire |
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
- **Route:** `gl.task.307`
