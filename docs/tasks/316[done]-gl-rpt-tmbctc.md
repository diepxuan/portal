# Task 316: GLRptTMBCTC

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module TMBCTC (Bao cao ton kho cuoi ky) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptTMBCTC.dll
- **Assembly Title:** Bao cao ton kho cuoi ky
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKHO | Danh muc kho | Lookup qd_cdkt |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| qd_cdkt | Quyet dinh cong dung |
| ngay1, ngay2 | Ngay bat dau/ket thuc |

---

## Form classes

### 1. frmGLRptTMBCTC
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao ton kho cuoi ky

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtQd_cdkt | AsTextBox | Quyet dinh cong dung (Lookup) |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_TMBCTC_GET | Lay du lieu ton kho cuoi ky |

### Parameters reference

```sql
EXEC SP_GL_RPT_TMBCTC_GET
    @pMa_cty VARCHAR(50),
    @pQd_cdkt VARCHAR(50) = NULL,
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **Bao cao ton kho**: Hien thi ton kho cuoi ky theo ky
2. **Hai che do**: Crystal Report hoac Grid view

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/TMBCTCService.php
namespace Diepxuan\Simba\Services\GL;

class TMBCTCService
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Tmbctc.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Tmbctc extends Component
{
    const MA_CT = 'GL';

    public ?string $qd_cdkt = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── tmbctc.blade.php
└── _tmbctc-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/tmbctc', [Tmbctc::class, 'render'])
    ->name('catalog.gl.baocao.tmbctc');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | TMBCTCService.php | Chinh |
| Component | laravel-catalog | Tmbctc.php | Livewire |
| Lookup | laravel-simba | DMKHO.php | Kho |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao
- [ ] Test Crystal/Grid
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `gl.task.316`
