# Task 298: GLRptBCTCCDTF03D

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCTCCDTF03D (Bao cao tai chinh chi tiet F03D) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCTCCDTF03D.dll
- **Assembly Title:** GLRptKPDA01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Lookup theo tk |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay_ct1, ngay_ct2 | Ngay bat dau/ket thuc |
| tk | Tai khoan loc (par1) |

---

## Form classes

### 1. frmGLRptBCTCCDTF03D
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao tai chinh chi tiet F03D - loc theo tai khoan

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan loc (AutoLookup, LookupCodeName=TK, par1) |
| lblTen_Tk | Label | Hien thi ten tai khoan |
| lblTk | Label | Nhan "Tai khoan" |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboKyBc | ComboBox | Chon ky bao cao |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te (an) |
| optVND, optNt | RadioButton | Tuy chon tien te (an) |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CCDTF03D_GET | Lay du lieu bao cao F03D |

### Parameters reference

```sql
EXEC SP_GL_RPT_CCDTF03D_GET
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
| Optional | tk | Cho phep de trong |

### Business Rules

1. **Loc theo tai khoan**: Chon mot tai khoan cu the de loc bao cao
2. **Gia tri mac dinh**: Doc tu MyMenuInfo.par1
3. **FilterTitle**: "Tai khoan: [ma_tk - ten_tk]"
4. **Chi VND**: An tuy chon ngoai te

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTCCDTF03DService.php
namespace Diepxuan\Simba\Services\GL;

class BCTCCDTF03DService
{
    public function getReport(array $params): array
    {
        // CompanyID, ngay1, ngay2, tk
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctccdtf03d.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bctccdtf03d extends Component
{
    const MA_CT = 'GL';

    public ?string $tk = null;
    public ?string $ky_bc = null;
    public ?string $mau_bc = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bctccdtf03d.blade.php
└── _bctccdtf03d-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bctccdtf03d', [Bctccdtf03d::class, 'render'])
    ->name('catalog.gl.baocao.bctccdtf03d');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTCCDTF03DService.php | Chinh |
| Component | laravel-catalog | Bctccdtf03d.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test report output
- [ ] Test AutoLookup
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
