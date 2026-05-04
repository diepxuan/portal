# Task 207: SO-Danh-Muc-Dieu-Khoan-Thanh-Toan

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc dieu khoan thanh toan tu .NET sang PHP Laravel, dat ket qua tuong duong SODMDKTT.

## Chi tiet
- **DLL:** SODMDKTT.dll
- **Chuc nang:** Danh muc dieu khoan thanh toan (Payment Terms Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMDKTT.dll/README.md`

---

## Cau truc du lieu

### Bang: dmtt (Danh muc dieu khoan thanh toan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_tt | varchar | 20 | Ma dieu khoan thanh toan (khoa chinh) |
| ten_tt | nvarchar | 255 | Ten dieu khoan |
| han_ck | int | 4 | Han chiet khau (ngay) |
| tl_ck | decimal | 5,2 | Ty le chiet khau (%) |
| han_tt | int | 4 | Han thanh toan (ngay) |
| ls_qh | decimal | 5,2 | Lai suat qua han (%) |
| mo_ta | nvarchar | 500 | Mo ta chi tiet |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | FK ma_tt (mac dinh cho KH) |

---

## Form classes

### 1. frmSODMDKTT (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvcMa_Tt | DataGridViewColumn | Ma dieu khoan |
| dgvcTen_Tt | DataGridViewColumn | Ten dieu khoan |
| dgvcHan_Ck | DataGridViewColumn | Han chiet khau |
| dgvcTl_Ck | DataGridViewColumn | Ty le chiet khau |
| dgvcHan_Tt | DataGridViewColumn | Han thanh toan |
| dgvcLs_Qh | DataGridViewColumn | Lai suat qua han |

### 2. frmSODMTTEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Tt | AsTextBox | ma_tt | Ma dieu khoan |
| txtTen_Tt | TextBox | ten_tt | Ten dieu khoan |
| txtHan_Ck | AsTextNumeric | han_ck | Han chiet khau (ngay) |
| txtTl_Ck | AsTextNumeric | tl_ck | Ty le chiet khau (%) |
| txtHan_Tt | AsTextNumeric | han_tt | Han thanh toan (ngay) |
| txtLs_Qh | AsTextNumeric | ls_qh | Lai suat qua han (%) |
| txtMo_Ta | TextBox | mo_ta | Mo ta |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMDKTT_GET | Lay danh sach |
| SP_SO_DMDKTT_GETBYID | Lay chi tiet |
| SP_SO_DMDKTT_INSERT | Them moi |
| SP_SO_DMDKTT_UPDATE | Cap nhat |
| SP_SO_DMDKTT_DELETE | Xoa |
| SP_SO_DMDKTT_FIND | Tim kiem |
| SP_SO_DMDKTT_CHECK | Kiem tra trung |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMDKTT_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_tt VARCHAR(20),
    @pTen_tt NVARCHAR(255),
    @pHan_ck INT,
    @pTl_ck DECIMAL(5,2),
    @pHan_tt INT,
    @pLs_qh DECIMAL(5,2),
    @pMo_ta NVARCHAR(500),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_tt | 'Ma dieu khoan khong duoc trong' |
| Max length 20 | ma_tt | 'Ma toi da 20 ky tu' |
| Unique | ma_tt | 'Ma da ton tai' |
| Required | ten_tt | 'Ten dieu khoan khong duoc trong' |
| Range 0-365 | han_ck | 'Han CK 0-365 ngay' |
| Range 0-100 | tl_ck | 'Ty le CK 0-100%' |
| Range 0-365 | han_tt | 'Han TT 0-365 ngay' |
| Range 0-100 | ls_qh | 'Lai suat 0-100%' |

### Business Rules

1. **Tinh ngay het han**:
   ```csharp
   // Ngay het han chiet khau
   Ngay_Hh_Ck = Ngay_Ct + Han_Ck

   // Ngay het han thanh toan
   Ngay_Hh_Tt = Ngay_Ct + Han_Tt
   ```

2. **Chiet khau thanh toan**:
   - Neu thanh toan trong han_ck ngay -> duoc huong tl_ck%
   - So tien chiet khau = Tong_tien * tl_ck / 100

3. **Lai qua han**:
   - Neu qua han_tt ngay -> tinh ls_qh% tren so tien
   - So tien lai = So_no * ls_qh / 100 * So_ngay_qua_han / 365

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMtt.php
namespace Diepxuan\Simba\Models\SO;

class DMtt extends Model
{
    protected $table = 'dmtt';
    protected $primaryKey = 'ma_tt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_tt',
        'ten_tt',
        'han_ck',
        'tl_ck',
        'han_tt',
        'ls_qh',
        'mo_ta',
    ];

    protected $casts = [
        'han_ck' => 'integer',
        'tl_ck' => 'decimal:2',
        'han_tt' => 'integer',
        'ls_qh' => 'decimal:2',
    ];

    public function khachHangs()
    {
        return $this->hasMany(DMKH::class, 'ma_tt', 'ma_tt');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_tt', 'like', "%{$search}%")
              ->orWhere('ten_tt', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetDMtt.php
class AsSOGetDMtt extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMDKTT_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsDMtt.php
class AsSOInsDMtt extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMDKTT_INSERT';
    protected $params = ['pMa_cty', 'pMa_tt', 'pTen_tt', 'pHan_ck', 'pTl_ck', 'pHan_tt', 'pLs_qh', 'pMo_ta'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdDMtt.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelDMtt.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOChkDMtt.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Dieukhoanthanhtoan.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Dieukhoanthanhtoan;

class Dieukhoanthanhtoan extends Component
{
    public Collection $pList;
    public string $pSearch = '';

    public function mount(): void
    {
        $this->loadList();
    }

    public function loadList(): void
    {
        // Load tu SP
    }

    public function render(): View
    {
        return view('catalog::so.dieukhoanthanhtoan');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/DieukhoanthanhtoanEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\DieukhoanthanhtoanEdit;

class DieukhoanthanhtoanEdit extends Component
{
    public ?string $pMaTt = null;
    public string $pTenTt = '';
    public int $pHanCk = 0;
    public float $pTlCk = 0;
    public int $pHanTt = 0;
    public float $pLsQh = 0;
    public string $pMoTa = '';
    public ?string $pMode = 'create';

    protected $rules = [
        'pMaTt' => 'required|string|max:20',
        'pTenTt' => 'required|string|max:255',
        'pHanCk' => 'nullable|integer|min:0|max:365',
        'pTlCk' => 'nullable|numeric|min:0|max:100',
        'pHanTt' => 'nullable|integer|min:0|max:365',
        'pLsQh' => 'nullable|numeric|min:0|max:100',
    ];

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.dieukhoanthanhtoan-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── dieukhoanthanhtoan/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/dieu-khoan-thanh-toan', [Dieukhoanthanhtoan::class, 'render'])
            ->name('dieukhoanthanhtoan');
        Route::get('/dieu-khoan-thanh-toan/edit/{maTt?}', [DieukhoanthanhtoanEdit::class, 'render'])
            ->name('dieukhoanthanhtoan.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMtt.php | Chinh |
| SP | laravel-simba | AsSOGetDMtt.php | Get list |
| SP | laravel-simba | AsSOInsDMtt.php | Insert |
| SP | laravel-simba | AsSOUpdDMtt.php | Update |
| SP | laravel-simba | AsSODelDMtt.php | Delete |
| Component | laravel-catalog | Dieukhoanthanhtoan.php | List |
| Component | laravel-catalog | DieukhoanthanhtoanEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMtt
- [ ] Tao Livewire Dieukhoanthanhtoan (list)
- [ ] Tao Livewire DieukhoanthanhtoanEdit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test validation han CK, han TT, lai suat