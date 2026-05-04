# Task 351: CO - Post chi phi tap trung sang GL (CoPostCPTT2GL)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 351 |
| **DLL** | CoPostCPTT2GL.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Utility |
| **Assembly Title** | Phan bo cong cu dung cu |
| **Version** | 9.1.0.0 |
| **GUID** | 2b77c71e-b8d4-4512-9c4a-843e2824a429 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Thuc hien post (ghi so) cac chi phi tap trung sang so tong hop (GL). Tao cac but toan phan bo tu TK phan bo sang TK chi phi.

## Form classes

### 1. frmCoPostCPTT2GL
- **Ke thua:** `frmCalc`
- **Chuc nang:** Post chi phi tap trung sang GL
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | AsComboBox | Chon thang (Ky bao cao) |
| txtNam | AsTextNumeric | Nam (readonly) |
| Label1 | Label | "Thang" |
| Label2 | Label | "Nam" |
| cmdOK | Button | Thuc hien post |
| cmdCancel | Button | Huy |

### Execute Parameters
```
[CompanyID, txtNam.Text, cboKyBc.Text, MyMenuInfo.par1]
```

### ValidData
- Ngay2 cua ky bao cao phai > ngay khoa so (ngay_ks)
- Neu sai: hien loi 50136

### InitComponents
- Load ky bao cao: `GetKyBaoCao(Ngay_DnTc, "10000")`
- txtNam = FinancialYear
- cboKyBc = thang hien tai (publicVariables "thang1")

## Cau truc du lieu

### Bang: GLPOST (So cai)
Ghi nhan cac but toan post tu CPTT sang GL.

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| (MyController.Execute) | Post CPTT sang GL (lay tu menu config) |

## Business Logic

### Validation
1. **Ky bao cao:** Ngay2 > ngay khoa so
2. **Thang/Nam:** Hop le

### Business Rules
1. **Post:** Goi MyController.Execute([CompanyID, Nam, Thang, par1])
2. **Ket qua:** 50015 = thanh cong, 50010 = that bai
3. **Par1:** Tham so tu menu (co the la loai chi phi hoac filter)

## Mapping PHP

### 1. SP Class

```php
class AsCoPostCPTT2GL extends StoredProcedure
{
    protected $procedure = ''; // Lay tu menu config
    protected $params = ['pMa_cty', 'pNam', 'pThang', 'pPar1'];
}
```

### 2. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Postcpsanggl.php
class Postcpsanggl extends Component
{
    const MA_CT = 'CO';
    public int $pThang = 0;
    public int $pNam = 0;
    public array $pKyBcOptions = [];

    public function execute(): void
    {
        // Validate: ngay ky > ngay khoa so
        // Goi SP post CPTT sang GL
    }

    public function render(): View
    {
        return view('catalog::co.post-cp-sang-gl');
    }
}
```

### 3. Views & Routes

```
resources/views/catalog/co/
├── post-cp-sang-gl.blade.php
```

```php
Route::get('/co/post-cp-sang-gl', [Postcpsanggl::class, 'render'])
    ->name('co.post-cp-sang-gl');
```

## Dependencies

| Loai | Package | File |
|------|---------|------|
| SP | laravel-simba | AsCoPostCPTT2GL.php |
| Framework | CO | GetKyBaoCao |

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao SP class
- [ ] Tao Livewire Postcpsanggl
- [ ] Tao View
- [ ] Test post GL
