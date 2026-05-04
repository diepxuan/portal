# Task 323: GlRptBctc01

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module BCTC01 (Bang can doi phat sinh cac tai khoan) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptBctc01.dll
- **Assembly Title:** Bang can doi phat sinh cac tai khoan
- **Version:** 9.1.0.0
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
| ngay1, ngay2 | Ngay bat dau/ket thuc |

---

## Form classes

### 1. frmGlRptBctc01
- **Ke thua:** frmReport
- **Chuc nang:** Bang can doi phat sinh cac tai khoan

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCTC01_GET | Lay du lieu BCTC01 |

### Parameters reference

```sql
EXEC SP_GL_RPT_BCTC01_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **Bang can doi PS**: Hien thi so du dau ky, phat sinh, so du cuoi ky
2. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTC01Service.php
namespace Diepxuan\Simba\Services\GL;

class BCTC01Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctc01.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bctc01 extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bctc01.blade.php
└── _bctc01-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bctc01', [Bctc01::class, 'render'])
    ->name('catalog.gl.baocao.bctc01');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTC01Service.php | Chinh |
| Component | laravel-catalog | Bctc01.php | Livewire |

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