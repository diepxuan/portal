# Task 333: GlRptNkc03

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Nkc03 (So nhat ky thu tien) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptNkc03.dll
- **Assembly Title:** So nhat ky thu tien
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Drilldown theo ds_tk_no, ds_tk_co |
| DMBP | Danh muc bo phan | Loc theo ma_bp |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| ds_tk_no | Danh sach TK no |
| ds_tk_co | Danh sach TK co |
| ma_bp | Ma bo phan |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGlRptNkc03
- **Ke thua:** frmReport
- **Chuc nang:** So nhat ky thu tien

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtDs_Tk | AsTextBox | Danh sach TK no (par2) |
| txtDs_Tk_Du | AsTextBox | Danh sach TK co (par3) |
| txtMa_Bp | AsTextBox | Ma bo phan (par4) |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_NKC03_GET | Lay du lieu so nhat ky thu tien |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC03_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pDs_tk_no VARCHAR(500) = NULL,
    @pDs_tk_co VARCHAR(500) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **So NK thu tien**: Hien thi cac CT thu tien theo ds_tk
2. **Loc theo ds_tk**: No/co theo danh sach TK
3. **Loc theo BP**: Theo ma_bo_phan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC03Service.php
namespace Diepxuan\Simba\Services\GL;

class NKC03Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkc03.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkc03 extends Component
{
    const MA_CT = 'GL';

    public ?string $ds_tk_no = null;
    public ?string $ds_tk_co = null;
    public ?string $ma_bp = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/socai/
├── nkc03.blade.php
└── _nkc03-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkc03', [Nkc03::class, 'render'])
    ->name('catalog.gl.socai.nkc03');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC03Service.php | Chinh |
| Component | laravel-catalog | Nkc03.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so NK thu tien
- [ ] Test loc ds_tk
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
