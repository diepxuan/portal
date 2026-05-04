# Task 327: GlRptBk01

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bk01 (Bang ke chung tu) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptBk01.dll
- **Assembly Title:** Bang ke chung tu
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

### 1. frmGlRptBk01
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke chung tu

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
| SP_GL_RPT_BK01_GET | Lay du lieu bang ke BK01 |

### Parameters reference

```sql
EXEC SP_GL_RPT_BK01_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pNhom_theo VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Nhom theo**: Cho phep nhom theo TK hoac BP
2. **Bang ke CT**: Hien thi chi tiet cac chung tu

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BK01Service.php
namespace Diepxuan\Simba\Services\GL;

class BK01Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bk01.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bk01 extends Component
{
    const MA_CT = 'GL';

    public ?string $nhom_theo = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bk01.blade.php
└── _bk01-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bk01', [Bk01::class, 'render'])
    ->name('catalog.gl.baocao.bk01');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BK01Service.php | Chinh |
| Component | laravel-catalog | Bk01.php | Livewire |
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