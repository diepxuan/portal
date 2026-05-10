# Task 302: GLRptBk02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bang ke chung tu nhom theo chi tieu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBk02.dll
- **Assembly Title:** Bang ke chung tu nhom theo chi tieu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Nhom theo tk |
| DMBP | Danh muc bo phan | Nhom theo bp |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| nhom_theo | Nhom theo TK / BP |

---

## Form classes

### 1. frmGLRptBk02
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke chung tu nhom theo chi tieu

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboNhom_Theo | ComboBox | Chon nhom theo TK hoac BP |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_BK02_GET | Lay du lieu bang ke nhom theo chi tieu |

### Parameters reference

```sql
EXEC SP_GL_RPT_BK02_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pNhom_theo VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Nhom theo**: Cho phep nhom theo TK hoac BP
2. **Ngay thoi gian**: Loc chung tu theo ngay
3. **Tong hop**: Hien thi tong hop theo nhom

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BangKe02Service.php
namespace Diepxuan\Simba\Services\GL;

class BangKe02Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bangke02.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bangke02 extends Component
{
    const MA_CT = 'GL';

    public ?string $nhom_theo = null;
    public ?string $ky_bc = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bangke02.blade.php
└── _bangke02-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bangke02', [Bangke02::class, 'render'])
    ->name('catalog.gl.baocao.bangke02');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BangKe02Service.php | Chinh |
| Component | laravel-catalog | Bangke02.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |
| Lookup | laravel-simba | DMBP.php | Bo phan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao
- [ ] Test nhom theo
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
