# Task 334: GlRptNkc04

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Nkc04 (So nhat ky ban hang) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GlRptNkc04.dll
- **Assembly Title:** So nhat ky ban hang
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
| tk_phai_thu | TK phai thu (par2) |
| tk_dt_hh | TK doanh thu hang hoa (par3) |
| tk_dt_tp | TK doanh thu thanh pham (par4) |
| tk_dt_dv | TK doanh thu dich vu (par5) |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGlRptNkc04
- **Ke thua:** frmReport
- **Chuc nang:** So nhat ky ban hang

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk_Phai_thu | AsTextBox | TK phai thu (par2) |
| txtTk_Dt_hh | AsTextBox | TK DT hang hoa (par3) |
| txtTk_Dt_tp | AsTextBox | TK DT thanh pham (par4) |
| txtTk_Dt_dv | AsTextBox | TK DT dich vu (par5) |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_NKC04_GET | Lay du lieu so nhat ky ban hang |

### Parameters reference

```sql
EXEC SP_GL_RPT_NKC04_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk_phai_thu VARCHAR(50) = NULL,
    @pTk_dt_hh VARCHAR(50) = NULL,
    @pTk_dt_tp VARCHAR(50) = NULL,
    @pTk_dt_dv VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **So NK ban hang**: Hien thi cac CT ban hang theo TK DT
2. **Loc theo TK**: Phai thu, DT hang hoa, thanh pham, dich vu
3. **Drill-down**: Chi tiet theo tai khoan

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/NKC04Service.php
namespace Diepxuan\Simba\Services\GL;

class NKC04Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Socai/Nkc04.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Socai;

class Nkc04 extends Component
{
    const MA_CT = 'GL';

    public ?string $tk_phai_thu = null;
    public ?string $tk_dt_hh = null;
    public ?string $tk_dt_tp = null;
    public ?string $tk_dt_dv = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/socai/
├── nkc04.blade.php
└── _nkc04-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/socai/nkc04', [Nkc04::class, 'render'])
    ->name('catalog.gl.socai.nkc04');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | NKC04Service.php | Chinh |
| Component | laravel-catalog | Nkc04.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test so NK ban hang
- [ ] Test drill-down
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
