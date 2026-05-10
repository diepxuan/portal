# Task 297: GLRptBCTCCDTF03C

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCTCCDTF03C (Bao cao tai chinh chi tiet F03C) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCTCCDTF03C.dll
- **Assembly Title:** Báo cáo tài chính chi tiết F03C
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Lookup theo ma_tk |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay_ct1, ngay_ct2 | Ngay bat dau/ket thuc |
| tk | Tai khoan loc bao cao (par1) |

---

## Form classes

### 1. frmGLRptBCTCCDTF03C
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao tai chinh chi tiet F03C - loc theo mot tai khoan

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan loc (AutoLookup, LookupCodeName=TK, par1) |
| lblTen_Tk | Label | Hien thi ten tai khoan (NameControl bind) |
| lblTk | Label | Nhan "Tai khoan" |
| cboKyBc | ComboBox | Chon ky bao cao |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND, optNt | RadioButton | Tuy chon tien te (an) |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CCDTF03C_GET | Lay du lieu bao cao F03C |

### Parameters reference

```sql
EXEC SP_GL_RPT_CCDTF03C_GET
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
| Optional | tk | Cho phep de trong, bao cao tong hop tat ca |

### Business Rules

1. **Loc theo mot tai khoan**: Cho phep chon mot tai khoan cu the
2. **AutoLookup TK**: Autocomplete, CharacterCasing=Upper, BackColor=Info
3. **Hien thi ten TK**: NameControl bind vao lblTen_Tk
4. **FilterTitle**: "Tai khoan: [ma_tk - ten_tk]" neu co
5. **An tien te**: Chi hien thi VND (optNt an)

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTCCDTF03CService.php
namespace Diepxuan\Simba\Services\GL;

class BCTCCDTF03CService
{
    public function getReport(array $params): array
    {
        // CompanyID, ngay1, ngay2, tk
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctccdtf03c.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bctccdtf03c extends Component
{
    const MA_CT = 'GL';

    public ?string $tk = null;
    public ?string $ky_bc = null;
    public ?string $mau_bc = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bctccdtf03c.blade.php
└── _bctccdtf03c-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bctccdtf03c', [Bctccdtf03c::class, 'render'])
    ->name('catalog.gl.baocao.bctccdtf03c');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTCCDTF03CService.php | Chinh |
| Component | laravel-catalog | Bctccdtf03c.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views (form + report output)
- [ ] Them Routes
- [ ] Test bao cao
- [ ] Test AutoLookup TK
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
