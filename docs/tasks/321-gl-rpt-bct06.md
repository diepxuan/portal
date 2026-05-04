# Task 321: GlRptBCT06

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module BCT06 (Bao cao LCTT - Phuong phap truc tiep) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptBCT06.dll
- **Assembly Title:** Bao cao luu chuyen tien te theo phuong phap truc tiep
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

### 1. frmGlRptBCT06
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao LCTT (Direct Method) v06

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
| SP_GL_RPT_BCT06_GET | Lay du lieu BCT06 LCTT |

### Parameters reference

```sql
EXEC SP_GL_RPT_BCT06_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME
```

---

## Business Logic

### Business Rules

1. **LCTT Direct**: Phan loai dong tien theo HDKD, dau tu, tai chinh
2. **So sanh ky**: Ky hien tai vs ky truoc
3. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCT06Service.php
namespace Diepxuan\Simba\Services\GL;

class BCT06Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bct06.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bct06 extends Component
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
├── bct06.blade.php
└── _bct06-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bct06', [Bct06::class, 'render'])
    ->name('catalog.gl.baocao.bct06');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCT06Service.php | Chinh |
| Component | laravel-catalog | Bct06.php | Livewire |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao LCTT
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test