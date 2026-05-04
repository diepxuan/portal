# Task 315: GLRptNKCTSoCai

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module NKCTSoCai tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptNKCTSoCai.dll
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

---

## Form classes

### 1. frmGLRptNKCTSoCai
- **Ke thua:** frmReport
- **Chuc nang:** So cai (chi tiet)

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_NKCTSOCAI_GET | Lay du lieu NKCTSoCai |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKCTSOCAI_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **So cai chi tiet**: Hien thi chi tiet cac nghiem vu ke toan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKCTSoCaiService.php
namespace Diepxuan\Simba\Services\GL;

class NKCTSoCaiService
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkctsocai.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkctsocai extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/socai/
├── nkctsocai.blade.php
└── _nkctsocai-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkctsocai', [Nkctsocai::class, 'render'])
    ->name('catalog.gl.socai.nkctsocai');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKCTSoCaiService.php | Chinh |
| Component | laravel-catalog | Nkctsocai.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so cai
- [ ] Test export Excel
- [ ] Integration test