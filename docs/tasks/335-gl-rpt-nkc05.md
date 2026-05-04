# Task 335: GlRptNkc05

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Nkc05 (So nhat ky mua hang) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptNkc05.dll
- **Assembly Title:** So nhat ky mua hang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Drilldown theo tk |
| DMKH | Danh muc khach hang | Lookup ma_kh |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| tk_phai_tra | TK phai tra (par2) |
| tk_hh | TK hang hoa (par3) |
| tk_nvl | TK nguyen vat lieu (par4) |
| tk_kho_khac | TK kho khac (par5) |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGlRptNkc05
- **Ke thua:** frmReport
- **Chuc nang:** So nhat ky mua hang

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk_Phai_tra | AsTextBox | TK phai tra (par2) |
| txtTk_Hh | AsTextBox | TK hang hoa (par3) |
| txtTk_Nvl | AsTextBox | TK nguyen vat lieu (par4) |
| txtTk_Kho_khac | AsTextBox | TK kho khac (par5) |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_NKC05_GET | Lay du lieu so nhat ky mua hang |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC05_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk_phai_tra VARCHAR(50) = NULL,
    @pTk_hh VARCHAR(50) = NULL,
    @pTk_nvl VARCHAR(50) = NULL,
    @pTk_kho_khac VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **So NK mua hang**: Hien thi cac CT mua hang theo TK
2. **Loc theo TK**: Phai tra, hang hoa, nguyen vat lieu, kho khac
3. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC05Service.php
namespace Diepxuan\Simba\Services\GL;

class NKC05Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkc05.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkc05 extends Component
{
    const MA_CT = 'GL';

    public ?string $tk_phai_tra = null;
    public ?string $tk_hh = null;
    public ?string $tk_nvl = null;
    public ?string $tk_kho_khac = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/socai/
├── nkc05.blade.php
└── _nkc05-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkc05', [Nkc05::class, 'render'])
    ->name('catalog.gl.socai.nkc05');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC05Service.php | Chinh |
| Component | laravel-catalog | Nkc05.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so NK mua hang
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test