# Task 211: SO-Danh-Muc-Thue-Suat

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc thue suat tu .NET sang PHP Laravel, dat ket qua tuong duong SODMTS.

## Chi tiet
- **DLL:** SODMTS.dll
- **Chuc nang:** Danh muc thue suat (Tax Rate Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc thue suat
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMTS.dll/README.md`

---

## Cau truc du lieu

### Bang: dmts (Danh muc thue suat)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_thue | varchar | 20 | Ma thue (khoa chinh) |
| ten_thue | nvarchar | 255 | Ten thue |
| ts_gtgt | decimal | 5,2 | Thue suat GTGT (%) |
| tk_thue_co | varchar | 20 | TK thue co (dau ra) |
| ksd | bit | 1 | Khoa su dung (0: HD, 1: Khoa) |
| kct | bit | 1 | Khong chiu thue (0: Chung, 1: KCT) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Tai khoan ke toan | FK tk_thue_co -> DMTK (chi_tiet=1) |
| SO4 | Chi tiet chung tu ban | FK ma_thue -> dmts |

---

## Form classes

### 1. frmSODMTS (Form xem danh sach)
- **Ke thua:** frmDMView
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Thue | AsTextBox | Ma thue |
| txtTen_Thue | TextBox | Ten thue |
| txtTS_GTGT | AsTextNumeric | Thue suat GTGT |
| txtTk_Thue_Co | AsTextBox | TK thue co |
| chkKsd | AsCheckBox | Khoa su dung |
| chk_KCT | AsCheckBox | Khong chiu thue |

### 2. frmSODMTSEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| lbMa_thue | Label | - | Nhan "Ma thue" |
| txtMa_Thue | AsTextBox | ma_thue | Ma thue |
| lbTen_Thue | Label | - | Nhan "Ten thue" |
| txtTen_thue | TextBox | ten_thue | Ten thue |
| lblTk_Thue_co | Label | - | Nhan "TK thue dau ra" |
| txtTk_Thue_Co | AsTextBox | tk_thue_co | TK thue (AutoLookup, chi_tiet=1) |
| lblTen_Tk_thue_co | Label | - | Ten TK thue hien thi |
| lblTS_GTGT | Label | - | Nhan "Thue suat GTGT" |
| txtTS_GTGT | AsTextNumeric | ts_gtgt | Thue suat GTGT (%) |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| chk_KCT | AsCheckBox | kct | Khong chiu thue |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMTS_GET | Lay danh sach |
| SP_SO_DMTS_GETBYID | Lay chi tiet |
| SP_SO_DMTS_INSERT | Them moi |
| SP_SO_DMTS_UPDATE | Cap nhat |
| SP_SO_DMTS_DELETE | Xoa |
| SP_SO_DMTS_FIND | Tim kiem |
| SP_SO_DMTS_CHECK | Kiem tra trung |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMTS_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_thue VARCHAR(20),
    @pTen_thue NVARCHAR(255),
    @pTS_GTGT DECIMAL(5,2),
    @pTk_thue_co VARCHAR(20),
    @pKsd BIT = 0,
    @pKct BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Cac loai thue pho bien

| Ma | Ten | Thue suat | Mo ta |
|----|-----|-----------|-------|
| GTGT0 | Thuế GTGT 0% | 0 | Thuế 0% |
| GTGT5 | Thuế GTGT 5% | 5 | Thuế 5% |
| GTGT10 | Thuế GTGT 10% | 10 | Thuế 10% (mac dinh) |
| KCT | Khong chiu thue | 0 | Khong chiu thue |

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_thue | 'Ma thue khong duoc trong' |
| Unique | ma_thue | 'Ma thue da ton tai' |
| Required | ten_thue | 'Ten thue khong duoc trong' |
| Required | ts_gtgt | 'Thue suat khong duoc trong' |
| Range 0-100 | ts_gtgt | 'Thue suat 0-100%' |
| Lookup valid | tk_thue_co | 'Tai khoan thue khong ton tai hoac khong phai TK chi tiet' |

### Business Rules

1. **TK_Thue_Co Lookup**:
   - Chi lay TK co chi_tiet = 1
   - Tu dong dien ten TK thue

2. **Khong chiu thue (KCT)**:
   - Neu kct = 1: vat tu khong chiu thu GTGT
   - Thue suat = 0
   - Khong tinh thue

3. **Khoa su dung (ksd)**:
   - Neu ksd = 1: khong hien thi trong danh sach chon tren chung tu
   - Van co trong danh muc de xem

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMts.php
namespace Diepxuan\Simba\Models\SO;

class DMts extends Model
{
    protected $table = 'dmts';
    protected $primaryKey = 'ma_thue';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_thue',
        'ten_thue',
        'ts_gtgt',
        'tk_thue_co',
        'ksd',
        'kct',
    ];

    protected $casts = [
        'ts_gtgt' => 'decimal:2',
        'ksd' => 'boolean',
        'kct' => 'boolean',
    ];

    public function taiKhoanThue()
    {
        return $this->belongsTo(DMTK::class, 'tk_thue_co', 'tk');
    }

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeChiuThue($query)
    {
        return $query->where('kct', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_thue', 'like', "%{$search}%")
              ->orWhere('ten_thue', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetDMts.php
class AsSOGetDMts extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMTS_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsDMts.php
class AsSOInsDMts extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMTS_INSERT';
    protected $params = [
        'pMa_cty', 'pMa_thue', 'pTen_thue', 'pTS_GTGT',
        'pTk_thue_co', 'pKsd', 'pKct',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdDMts.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelDMts.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOChkDMts.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Thuesuat.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Thuesuat;

class Thuesuat extends Component
{
    public Collection $pList;
    public string $pSearch = '';

    public function mount(): void
    {
        $this->loadList();
    }

    public function render(): View
    {
        return view('catalog::so.thuesuat');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/ThuesuatEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\ThuesuatEdit;

class ThuesuatEdit extends Component
{
    public ?string $pMaThue = null;
    public string $pTenThue = '';
    public float $pTsGtgt = 10;
    public string $pTkThueCo = '';
    public string $pTenTkThueCo = '';
    public bool $pKsd = false;
    public bool $pKct = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMaThue' => 'required|string|max:20',
        'pTenThue' => 'required|string|max:255',
        'pTsGtgt' => 'nullable|numeric|min:0|max:100',
        'pTkThueCo' => 'nullable|string|exists:dmtk,tk',
    ];

    public function mount(?string $maThue = null): void
    {
        if ($maThue) {
            $this->pMaThue = $maThue;
            $this->loadData();
        }
    }

    public function updatedPTkThueCo($value): void
    {
        $tk = DMTK::where('tk', $value)->where('chi_tiet', 1)->first();
        $this->pTenTkThueCo = $tk->ten_tk ?? '';
    }

    public function updatedPKct(bool $value): void
    {
        if ($value) {
            $this->pTsGtgt = 0;
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.thuesuat-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── thuesuat/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/thue-suat', [Thuesuat::class, 'render'])
            ->name('thuesuat');
        Route::get('/thue-suat/edit/{maThue?}', [ThuesuatEdit::class, 'render'])
            ->name('thuesuat.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMts.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan thue |
| SP | laravel-simba | AsSOGetDMts.php | Get list |
| SP | laravel-simba | AsSOInsDMts.php | Insert |
| SP | laravel-simba | AsSOUpdDMts.php | Update |
| SP | laravel-simba | AsSODelDMts.php | Delete |
| Component | laravel-catalog | Thuesuat.php | List |
| Component | laravel-catalog | ThuesuatEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMts
- [ ] Tao Livewire Thuesuat (list)
- [ ] Tao Livewire ThuesuatEdit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Lookup tai khoan thue (chi_tiet=1)
- [ ] Test checkbox KCT tu dong set thue suat = 0
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `so.dict.ts`
- **Note:** Voucher/report/dictionary route shell; write execute chỉ mở khi payload audit đủ.
