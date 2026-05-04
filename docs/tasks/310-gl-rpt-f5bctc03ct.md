# Task 310: GLRptF5BCTC03CT

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module F5BCTC03CT (Bao cao BCTC03 chi tiet) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptF5BCTC03CT.dll
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
| ngay_ct1, ngay_ct2 | Ngay bat dau/ket thuc |
| tk_no | Tai khoan no |
| tk_co | Tai khoan co |
| chi_tieu | Ten chi tieu |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGLRptF5BCTC03CT
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao BCTC03 chi tiet

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk_no | AsTextBox | Tai khoan no |
| txtTk_co | AsTextBox | Tai khoan co |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_F5BCTC03CT_GET | Lay du lieu BCTC03CT |

### Parameters reference

```sql
EXEC SP_GL_RPT_F5BCTC03CT_GET
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

1. **Loc TK no/co**: Chi tiet theo tk_no hoac tk_co
2. **Drill-down**: Theo chi_tieu (ten chi tieu)
3. **Hien thi chi tieu**: Lay tu drilldown_menuid1

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/F5BCTC03CTService.php
namespace Diepxuan\Simba\Services\GL;

class F5BCTC03CTService
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/F5bctc03ct.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class F5bctc03ct extends Component
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
├── f5bctc03ct.blade.php
└── _f5bctc03ct-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/f5bctc03ct', [F5bctc03ct::class, 'render'])
    ->name('catalog.gl.baocao.f5bctc03ct');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | F5BCTC03CTService.php | Chinh |
| Component | laravel-catalog | F5bctc03ct.php | Livewire |
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