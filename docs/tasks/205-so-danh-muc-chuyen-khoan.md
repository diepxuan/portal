# Task 205: SO-Danh-Muc-Chuyen-Khoan

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc chuyen khoan tu .NET sang PHP Laravel, dat ket qua tuong duong SODMCK.

## Chi tiet
- **DLL:** SODMCK.dll
- **Chuc nang:** Danh muc chuyen khoan (Transfer/Remittance Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface, AsiaErp.DataAccess`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMCK.dll/README.md`

---

## Cau truc du lieu

### Bang: dmcK (Danh muc chuyen khoan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_ck | varchar | 20 | Ma chuyen khoan (khoa chinh) |
| ten_ck | nvarchar | 255 | Ten chuyen khoan |
| tk_ck | varchar | 20 | Tai khoan ke toan (lookup) |
| ma_nh | varchar | 20 | Ma nhom chuyen khoan |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk_ck -> DMTK.tk (chi_tiet=1) |
| DMNH | Nhom chuyen khoan | FK ma_nh -> DMNH.ma_nh |

---

## Form classes

### 1. frmSODMCK (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Chuc nang:** Hien thi danh sach chuyen khoan, tim kiem, phan trang
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvcMa_Ck | DataGridViewColumn | Ma chuyen khoan |
| dgvcTen_Ck | DataGridViewColumn | Ten chuyen khoan |
| dgvcTk_Ck | DataGridViewColumn | Tai khoan CK |
| dgvcTen_Tk_Ck | DataGridViewColumn | Ten tai khoan |
| dgvcMa_Nh | DataGridViewColumn | Ma nhom |

### 2. frmSODMCKEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Chuc nang:** Nhap, sua thong tin chuyen khoan
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Ck | AsTextBox | ma_ck | Ma chuyen khoan |
| txtTen_Ck | TextBox | ten_ck | Ten chuyen khoan |
| txtTk_Ck | AsTextBox | tk_ck | Tai khoan ke toan (AutoLookup) |
| lblTen_Tk_Ck | Label | - | Ten tai khoan hien thi |
| txtMa_Nh | AsTextBox | ma_nh | Ma nhom chuyen khoan |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMCK_GET | Lay danh sach chuyen khoan |
| SP_SO_DMCK_GETBYID | Lay chi tiet 1 chuyen khoan |
| SP_SO_DMCK_INSERT | Them chuyen khoan moi |
| SP_SO_DMCK_UPDATE | Cap nhat chuyen khoan |
| SP_SO_DMCK_DELETE | Xoa chuyen khoan |
| SP_SO_DMCK_FIND | Tim kiem chuyen khoan |
| SP_SO_DMCK_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
EXEC SP_SO_DMCK_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMCK_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_ck VARCHAR(20),
    @pTen_ck NVARCHAR(255),
    @pTk_ck VARCHAR(20),
    @pMa_nh VARCHAR(20),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ck | 'Ma chuyen khoan khong duoc trong' |
| Max length 20 | ma_ck | 'Ma chuyen khoan toi da 20 ky tu' |
| Unique | ma_ck | 'Ma chuyen khoan da ton tai' |
| Required | ten_ck | 'Ten chuyen khoan khong duoc trong' |
| Lookup valid | tk_ck | 'Tai khoan khong ton tai hoac khong phai TK chi tiet' |

### Business Rules

1. **Tk_Ck Lookup**:
   - Chi lay TK co chi_tiet = 1
   - Tu dong dien ten TK khi chon ma TK

2. **Ma_Nh Lookup**:
   - Lookup tu bang nhom chuyen khoan

3. **Xoa chuyen khoan**:
   - Kiem tra khong co chung tu nao su dung ma_ck nay
   - Neu co -> khong cho xoa

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMcK.php
namespace Diepxuan\Simba\Models\SO;

class DMcK extends Model
{
    protected $table = 'dmcK';
    protected $primaryKey = 'ma_ck';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_ck',
        'ten_ck',
        'tk_ck',
        'ma_nh',
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'tk_ck', 'tk');
    }

    public function nhom()
    {
        return $this->belongsTo(DMNH::class, 'ma_nh', 'ma_nh');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_ck', 'like', "%{$search}%")
              ->orWhere('ten_ck', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetDMcK.php
class AsSOGetDMcK extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMCK_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsDMcK.php
class AsSOInsDMcK extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMCK_INSERT';
    protected $params = ['pMa_cty', 'pMa_ck', 'pTen_ck', 'pTk_ck', 'pMa_nh'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdDMcK.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelDMcK.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOChkDMcK.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Chuyenkhoan.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Chuyenkhoan;

class Chuyenkhoan extends Component
{
    public Collection $pList;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    public function mount(): void
    {
        $this->loadList();
    }

    public function loadList(): void
    {
        // Load tu SP_SO_DMCK_GET
    }

    public function render(): View
    {
        return view('catalog::so.chuyenkhoan');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/ChuyenkhoanEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\ChuyenkhoanEdit;

class ChuyenkhoanEdit extends Component
{
    public ?string $pMaCk = null;
    public string $pTenCk = '';
    public string $pTkCk = '';
    public string $pTenTkCk = '';
    public string $pMaNh = '';
    public ?string $pMode = 'create';

    protected $rules = [
        'pMaCk' => 'required|string|max:20',
        'pTenCk' => 'required|string|max:255',
        'pTkCk' => 'nullable|string|exists:DMTK,tk',
    ];

    public function mount(?string $maCk = null): void
    {
        if ($maCk) {
            $this->pMaCk = $maCk;
            $this->loadData();
        }
    }

    public function updatedPTkCk($value): void
    {
        $tk = DMTK::where('tk', $value)->where('chi_tiet', 1)->first();
        $this->pTenTkCk = $tk->ten_tk ?? '';
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT/UPDATE
    }

    public function render(): View
    {
        return view('catalog::so.chuyenkhoan-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── chuyenkhoan/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/chuyen-khoan', [Chuyenkhoan::class, 'render'])
            ->name('chuyenkhoan');
        Route::get('/chuyen-khoan/edit/{maCk?}', [ChuyenkhoanEdit::class, 'render'])
            ->name('chuyenkhoan.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMcK.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan (lookup) |
| Model | laravel-simba | DMNH.php | Nhom CK |
| SP | laravel-simba | AsSOGetDMcK.php | Get list |
| SP | laravel-simba | AsSOInsDMcK.php | Insert |
| SP | laravel-simba | AsSOUpdDMcK.php | Update |
| SP | laravel-simba | AsSODelDMcK.php | Delete |
| Component | laravel-catalog | Chuyenkhoan.php | List |
| Component | laravel-catalog | ChuyenkhoanEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMcK
- [ ] Tao Livewire Chuyenkhoan (list)
- [ ] Tao Livewire ChuyenkhoanEdit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Lookup tai khoan (chi_tiet=1)