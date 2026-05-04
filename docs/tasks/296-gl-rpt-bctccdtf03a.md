# Task 296: GLRptBCTCCDTF03A

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module bao cao BCTCCDTF03A (Bao cao tai chinh chi tiet F03A - XD) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptBCTCCDTF03A.dll
- **Assembly Title:** GLRptKPDA01
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Lookup TK xay lap, thiet bi, boi thuong, QLDA, tu van, khac |
| DMSPCT | San pham chi tiet | Lookup ma_spct |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay_ct1, ngay_ct2 | Ngay bat dau/ket thuc |
| tk_xaylap, tk_thietbi, tk_boithuong, tk_qlda, tk_tuvan, tk_khac | 6 tai khoan xay dung |
| ma_spct | Ma san pham chi tiet |

---

## Form classes

### 1. frmGLRptBCTCCDTF03A
- **Ke thua:** frmReport
- **Chuc nang:** Bao cao tai chinh chi tiet F03A theo 6 loai tai khoan xay dung

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk_xaylap | AsTextBox | Tai khoan xay lap (AutoLookup, par1) |
| txtTk_Thietbi | AsTextBox | Tai khoan thiet bi (AutoLookup, par2) |
| txtTk_boithuong | AsTextBox | Tai khoan boi thuong (AutoLookup, par3) |
| txtTk_QLDA | AsTextBox | Tai khoan QLDA (AutoLookup, par4) |
| txtTk_TuVan | AsTextBox | Tai khoan tu van (AutoLookup, par5) |
| txtTk_Khac | AsTextBox | Tai khoan khac (AutoLookup, par6) |
| txtMa_SPCT | AsTextBox | Ma san pham chi tiet (AutoLookup) |
| lblTen_* | Label | Hien thi ten tai khoan tuong ung |
| cboKyBc | ComboBox | Chon ky bao cao |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CCDTF03A_GET | Lay du lieu bao cao F03A |

### Parameters reference

```sql
EXEC SP_GL_RPT_CCDTF03A_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk_xaylap VARCHAR(50) = NULL,
    @pTk_thietbi VARCHAR(50) = NULL,
    @pTk_boithuong VARCHAR(50) = NULL,
    @pTk_qlda VARCHAR(50) = NULL,
    @pTk_tuvan VARCHAR(50) = NULL,
    @pTk_khac VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | It nhat 1 trong 6 TK | 'Chon it nhat 1 tai khoan de loc bao cao' |

### Business Rules

1. **6 tai khoan xay dung**: Cho phep loc theo 6 loai tai khoan: xay lap, thiet bi, boi thuong, QLDA, tu van, khac
2. **Gia tri mac dinh**: Doc tu MyMenuInfo.par1-par6
3. **San pham chi tiet**: Loc them theo ma_spct neu co
4. **FilterTitle**: Hien thi danh sach TK duoc chon tren bao cao
5. **Chi tien VND**: An cac tuy chon ngoai te (chi hien thi VND)

### Drill-down

- F5: Chi tiet cong thuc/So chu T
- Ctrl+F5: So chi tiet
- Shift+F5: Can doi PS cong no

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/BCTCCDTF03AService.php
namespace Diepxuan\Simba\Services\GL;

class BCTCCDTF03AService
{
    public function getReport(array $params): array
    {
        // CompanyID, ngay1, ngay2, tk_xaylap, tk_thietbi,
        // tk_boithuong, tk_qlda, tk_tuvan, tk_khac, ma_spct
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Bctccdtf03a.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Bctccdtf03a extends Component
{
    const MA_CT = 'GL';

    public ?string $tk_xaylap = null;
    public ?string $tk_thietbi = null;
    public ?string $tk_boithuong = null;
    public ?string $tk_qlda = null;
    public ?string $tk_tuvan = null;
    public ?string $tk_khac = null;
    public ?string $ma_spct = null;
    public ?string $ky_bc = null;
    public ?string $mau_bc = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;

    public function getReport(): void { /* ... */ }
    public function exportExcel(): void { /* ... */ }
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── bctccdtf03a.blade.php
└── _bctccdtf03a-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/bctccdtf03a', [Bctccdtf03a::class, 'render'])
    ->name('catalog.gl.baocao.bctccdtf03a');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | BCTCCDTF03AService.php | Chinh |
| Component | laravel-catalog | Bctccdtf03a.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |
| Lookup | laravel-simba | DMSPCT.php | San pham CT |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service (BCTCCDTF03AService)
- [ ] Tao Livewire Component
- [ ] Tao Views (form + report output)
- [ ] Them Routes
- [ ] Test bao cao (Crystal Report / Grid)
- [ ] Test drill-down (F5, Ctrl+F5, Shift+F5)
- [ ] Test export Excel
- [ ] Integration test voi menu system
