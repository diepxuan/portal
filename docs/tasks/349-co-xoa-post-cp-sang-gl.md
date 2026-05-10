# Task 349: CO - Xoa post chi phi sang GL (CoDelPostCP2GL)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 349 |
| **DLL** | CoDelPostCP2GL.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Utility |
| **Assembly Title** | Phan bo cong cu dung cu |
| **Version** | 9.1.0.0 |
| **GUID** | 2b77c71e-b8d4-4512-9c4a-843e2824a429 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Xoa bo cac but toan da post chi phi sang so cai (GL). Dung khi can tinh toan lai hoac co sai sot trong viec post chi phi.

## Form classes

### 1. frmCoDelPostCP2GL
- **Ke thua:** `frmCalc`
- **Chuc nang:** Xoa post chi phi sang GL
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | AsComboBox | Chon thang (Ky bao cao) |
| txtNam | AsTextNumeric | Nam (readonly, tu dong dien) |
| Label1 | Label | "Thang" |
| Label2 | Label | "Nam" |
| cmdOK | Button | Thuc hien xoa post |
| cmdCancel | Button | Huy |

### Execute Parameters
```
[CompanyID, MyMenuInfo.par1, txtNam.Text, cboKyBc.Text]
```

### ValidData
- Kiem tra ngay2 cua ky bao cao phai sau ngay khoa so (ngay_ks)
- Neu sai: hien loi 50136

### InitComponents
- Load ky bao cao: `GetKyBaoCao(Ngay_DnTc, "10000")`
- txtNam = FinancialYear
- cboKyBc = thang hien tai (tu publicVariables "thang1")

## Cau truc du lieu

### Bang: GLPOST (So cai - general ledger)
Xu ly xoa cac but toan da post tu CO sang GL.

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| (MyController.Execute) | Xoa post CP sang GL (lay tu menu config) |

## Business Logic

### Validation
1. **Ky bao cao:** Ngay2 > ngay khoa so
2. **Thang/Nam:** Chon ky hop le

### Business Rules
1. **Xoa post:** Goi MyController.Execute voi param [CompanyID, par1, Nam, Thang]
2. **Ket qua:** 50015 = thanh cong, 50010 = that bai
3. **Tu dong:** txtNam readonly, lay nam tai chinh hien tai

## Mapping PHP

### 1. SP Class

```php
class AsCoDelPostCP2GL extends StoredProcedure
{
    protected $procedure = ''; // Lay tu menu config
    protected $params = ['pMa_cty', 'pPar1', 'pNam', 'pThang'];
}
```

### 2. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Xoapostcpsanggl.php
class Xoapostcpsanggl extends Component
{
    const MA_CT = 'CO';
    public int $pThang = 0;
    public int $pNam = 0;
    public array $pKyBcOptions = [];

    public function execute(): void
    {
        // Validate: ngay ky > ngay khoa so
        // Goi SP xoa post
    }

    public function render(): View
    {
        return view('catalog::co.xoa-post-cp-sang-gl');
    }
}
```

### 3. Views & Routes

```
resources/views/catalog/co/
├── xoa-post-cp-sang-gl.blade.php
```

```php
Route::get('/co/xoa-post-cp-sang-gl', [Xoapostcpsanggl::class, 'render'])
    ->name('co.xoa-post-cp-sang-gl');
```

## Dependencies

| Loai | Package | File |
|------|---------|------|
| SP | laravel-simba | AsCoDelPostCP2GL.php |
| Framework | CO | GetKyBaoCao, GetSIConfiguration |

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao SP class
- [ ] Tao Livewire Xoapostcpsanggl
- [ ] Tao View
- [ ] Test xoa post

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
