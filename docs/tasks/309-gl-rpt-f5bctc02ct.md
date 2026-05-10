# Task 309: GLRptF5BCTC02CT

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module F5BCTC02CT (Bao cao BCTC02 chi tiet) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptF5BCTC02CT.dll
- **Assembly Title:** GLRptF5CTGS01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Drilldown theo tk_du |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay_dau_nam | Ngay dau nam |
| ngay_ct2 | Ngay ket thuc |
| tk | Tai khoan chinh |
| tk_du | Tai khoan doi ung |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGLRptF5BCTC02CT
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao BCTC02 chi tiet theo TK doi ung

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
| SP_GL_RPT_F5BCTC02CT_GET | Lay du lieu BCTC02CT |

### Parameters reference

```sql
EXEC SP_GL_RPT_F5BCTC02CT_GET
    @pMa_cty VARCHAR(50),
    @pNgay_dau_nam DATETIME,
    @pNgay_ct2 DATETIME,
    @pTk VARCHAR(50) = NULL,
    @pTk_du VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Drill-down**: Theo tk_du (tai khoan doi ung)
2. **Ngay dau nam**: Tu 01/01 cua nam bao cao

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/F5BCTC02CTService.php
namespace Diepxuan\Simba\Services\GL;

class F5BCTC02CTService
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/F5bctc02ct.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class F5bctc02ct extends Component
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
├── f5bctc02ct.blade.php
└── _f5bctc02ct-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/f5bctc02ct', [F5bctc02ct::class, 'render'])
    ->name('catalog.gl.baocao.f5bctc02ct');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | F5BCTC02CTService.php | Chinh |
| Component | laravel-catalog | F5bctc02ct.php | Livewire |
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
