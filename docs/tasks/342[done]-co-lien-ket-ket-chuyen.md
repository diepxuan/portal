# Task 342: CO - Lien ket ket chuyen tu dong (COLK)

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **Task #** | 342 |
| **DLL** | COLK.dll |
| **Module** | CO (Manufacturing) |
| **Loai** | Master/Danh muc |
| **Assembly Title** | Khai bao cac but toan ket chuyen tu dong |
| **Version** | 9.1.0.0 |
| **GUID** | 2b77c71e-b8d4-4512-9c4a-843e2824a429 |
| **Trang thai** | Da phan tich |

## Mo ta chuc nang

Quan ly lien ket (mapping) cho cac but toan ket chuyen tu dong. Cho phep cau hinh lien ket giua cac danh muc de phuc vu qua trinh ket chuyen so lieu cuoi ky.

## Form classes

### 1. frmCoLk (Form xem danh sach)
- **Ke thua:** `frmDMComplexView`
- **Chuc nang:** Hien thi danh sach lien ket ket chuyen
- **Controls:**
  - `cmdChgCode` - An (Visible = false)
  - `txtValue` - An (Visible = false)
  - `cboFilter` - An (Visible = false)
  - `cmdSearch` - An (Visible = false)
  - `lblTen` - An (Visible = false)
  - `cmdPrint` - An (Visible = false)
  - `cmdAdd`, `cmdDel`, `cmdEdit` - Dieu chinh vi tri
- **GetData override:**
  ```
  base.GetData(CompanyID, FinancialYear, 0, "", "", "");
  ```

### 2. frmCoLkEdit (Form chinh sua)
- **Ke thua:** `frmDMComplexEdit`
- **Chuc nang:** Them/sua thong tin lien ket
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Spct | AsTextBox | Ma_spct | Ma san pham chi tiet |
| txtTK | AsTextBox | TK | Tai khoan |
| txtTK_du | AsTextBox | TK_DU | Tai khoan doi ung |
| txtPS_no | AsTextNumeric | ps_no | Phat sinh No |
| txtPs_No_nt | AsTextNumeric | ps_no_nt | Phat sinh No ngoai te |
| txtPs_co | AsTextNumeric | ps_co | Phat sinh Co |
| txtPs_co_nt | AsTextNumeric | ps_co_nt | Phat sinh Co ngoai te |
| txtThang | AsTextNumeric | THANG | Thang |
| txtNam | TextBox | NAM | Nam |
| lblTen_vt | Label | - | Ten vat tu (lookup) |
| lblMa_vt | Label | - | Ma vat tu |
| lblTen_tk | Label | - | Ten tai khoan |
| lblTK | Label | - | Nhan "TK" |
| lblTKdu | Label | - | Nhan "TK doi ung" |
| lblPsNo | Label | - | Nhan "PS No" |
| lblPSno_nt | Label | - | Nhan "PS No NT" |
| Label1-4 | Label | - | Nhan phu |

- **DataBinding:**
  - Ma_spct, NAM, THANG, TK, TK_DU
  - ps_no (Value), ps_no_nt (Value), ps_co (Value), ps_co_nt (Value)
- **ValidData:** Kiem tra txtMa_Spct va txtTK khong duoc trong
- **DisableFields:** txtMa_Spct, txtTK, txtTK_du readonly

## Cau truc du lieu

### Bang: COLK (Lien ket ket chuyen)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| Ma_spct | varchar | Ma san pham chi tiet |
| NAM | int | Nam tai chinh |
| THANG | int | Thang |
| TK | varchar | Tai khoan ket chuyen |
| TK_DU | varchar | Tai khoan doi ung |
| ps_no | decimal | Phat sinh No |
| ps_no_nt | decimal | Phat sinh No ngoai te |
| ps_co | decimal | Phat sinh Co |
| ps_co_nt | decimal | Phat sinh Co ngoai te |

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| COLK_Get | Lay danh sach lien ket |
| COLK_Insert | Them lien ket moi |
| COLK_Update | Cap nhat lien ket |
| COLK_Delete | Xoa lien ket |

## Business Logic

### Validation Rules
| Rule | Field | Message |
|------|-------|---------|
| Required | Ma_spct | Khong duoc trong |
| Required | TK | Khong duoc trong |
| Auto-fill | NAM | Lay nam tai chinh hien tai |

### Business Rules
1. **Lookup**: Ma_spct lookup tu danh muc SPCT
2. **Lookup**: TK lookup tu danh muc tai khoan
3. **TK_DU**: Tai khoan doi ung tu dong hien thi ten
4. **Format**: So tien theo Amount_Input_Format va FCAmount_Input_Format
5. **Nam tai chinh**: Tu dong dien nam hien tai

## Mapping PHP

### 1. Model

```php
// app/Models/CO/COLK.php
namespace Diepxuan\Simba\Models\CO;

class COLK extends Model
{
    protected $table = 'COLK';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty',
        'ma_spct',
        'NAM',
        'THANG',
        'TK',
        'TK_DU',
        'ps_no',
        'ps_no_nt',
        'ps_co',
        'ps_co_nt',
    ];

    protected $casts = [
        'NAM' => 'integer',
        'THANG' => 'integer',
        'ps_no' => 'decimal:2',
        'ps_no_nt' => 'decimal:2',
        'ps_co' => 'decimal:2',
        'ps_co_nt' => 'decimal:2',
    ];

    public function scopeByCompany($query, $maCty)
    {
        return $query->where('ma_cty', $maCty);
    }

    public function scopeByYear($query, $nam)
    {
        return $query->where('NAM', $nam);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_spct', 'like', "%{$search}%")
              ->orWhere('TK', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCoGetCOLK.php
class AsCoGetCOLK extends StoredProcedure
{
    protected $procedure = 'COLK_Get';
    protected $params = ['pMa_cty', 'pNam', 'pThang'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoInsCOLK.php
class AsCoInsCOLK extends StoredProcedure
{
    protected $procedure = 'COLK_Insert';
    protected $params = ['pMa_cty', 'pMa_spct', 'pNam', 'pThang', 'pTK', 'pTK_DU', 'pPs_no', 'pPs_no_nt', 'pPs_co', 'pPs_co_nt'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCoUpdCOLK.php
// diepxuan/laravel-simba/src/StoredProcedures/AsCoDelCOLK.php
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Lienketketchuyen.php
namespace Diepxuan\Catalog\Http\Livewire\CO;

class Lienketketchuyen extends Component
{
    const MA_CT = 'CO';
    const LIST_TYPE = 'COLK';

    public function render(): View
    {
        return view('catalog::co.lien-ket-ket-chuyen');
    }
}
```

### 4. Views

```
resources/views/catalog/co/
├── lien-ket-ket-chuyen.blade.php    (List page)
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        Route::get('/lien-ket-ket-chuyen', [Lienketketchuyen::class, 'render'])
            ->name('lien-ket-ket-chuyen');
    });
```

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | COLK.php | Chinh |
| SP | laravel-simba | AsCoGetCOLK.php | Get |
| SP | laravel-simba | AsCoInsCOLK.php | Insert |
| SP | laravel-simba | AsCoUpdCOLK.php | Update |
| SP | laravel-simba | AsCoDelCOLK.php | Delete |
| Component | laravel-catalog | Lienketketchuyen.php | List |
| DM | CO | DMSPCT | Lookup SPCT |
| DM | System | DSTK | Lookup TK |

## Progress Checklist

- [ ] Phan tich yeu cau & review task
- [ ] Tao Stored Procedure classes
- [ ] Tao Model COLK
- [ ] Tao Livewire Lienketketchuyen
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.342`
