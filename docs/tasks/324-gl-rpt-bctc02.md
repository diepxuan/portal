# Task 324: GlRptBctc02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module BCTC02 (Bang can doi ke toan) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptBctc02.dll
- **Assembly Title:** Bang can doi ke toan
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
| qd_cdkt | Quyet dinh cong dung |
| ngay_bc | Ngay bao cao |

---

## Form classes

### 1. frmGlRptBctc02
- **Ke thua:** frmReport
- **Chuc nang:** Bang can doi ke toan

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| txtQd_cdkt | AsTextBox | Quyet dinh cong dung (Lookup) |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BCTC02_GET | Lay du lieu BCTC02 |

### Parameters reference

```sql
EXEC SP_GL_RPT_BCTC02_GET
    @pMa_cty VARCHAR(50),
    @pQd_cdkt VARCHAR(50) = NULL,
    @pNgay_bc DATETIME
```

---

## Business Logic

### Business Rules

1. **Bang can doi KT**: Hien thi tai san, nguon von tai mot thoi diem
2. **Quyet dinh**: Ap dung qd_cdkt
3. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTC02Service.php
namespace Diepxuan\Simba\Services\GL;

class BCTC02Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctc02.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bctc02 extends Component
{
    const MA_CT = 'GL';

    public ?string $qd_cdkt = null;
    public ?Carbon $ngay_bc = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bctc02.blade.php
└── _bctc02-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bctc02', [Bctc02::class, 'render'])
    ->name('catalog.gl.baocao.bctc02');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTC02Service.php | Chinh |
| Component | laravel-catalog | Bctc02.php | Livewire |

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
