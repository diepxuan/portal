# Task 313: GLRptNKC08

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module NKC08 (So cai ngan) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptNKC08.dll
- **Assembly Title:** GLRptNKC08
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Loc theo tk |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| tk | Tai khoan loc |

---

## Form classes

### 1. frmGLRptNKC08
- **Ke thua:** frmReport
- **Chuc nang:** So cai ngan

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan loc |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_NKC08_GET | Lay du lieu NKC08 |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC08_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk VARCHAR(50) = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | tk | 'Chon tai khoan de xem so cai' |

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC08Service.php
namespace Diepxuan\Simba\Services\GL;

class NKC08Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkc08.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkc08 extends Component
{
    const MA_CT = 'GL';

    public ?string $tk = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/socai/
├── nkc08.blade.php
└── _nkc08-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkc08', [Nkc08::class, 'render'])
    ->name('catalog.gl.socai.nkc08');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC08Service.php | Chinh |
| Component | laravel-catalog | Nkc08.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so cai
- [ ] Test validate
- [ ] Test export Excel
- [ ] Integration test