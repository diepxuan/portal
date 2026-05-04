# Task 206: SO-Danh-Muc-Don-Gia-Vat-Tu

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc don gia vat tu tu .NET sang PHP Laravel, dat ket qua tuong duong SODMDGVT.

## Chi tiet
- **DLL:** SODMDGVT.dll
- **Chuc nang:** Danh muc don gia vat tu (Unit Price Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMDGVT.dll/README.md`

---

## Cau truc du lieu

### Bang: dmdgvt (Danh muc don gia vat tu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_vt | varchar | 20 | Ma vat tu (khoa chinh) |
| ma_dv | varchar | 20 | Ma don vi tinh (khoa chinh) |
| ngay_ap | date | 8 | Ngay ap dung (khoa chinh) |
| gia | decimal | 18,2 | Don gia |
| ma_nt | varchar | 3 | Ma ngoai te |

**Khoa chinh:** (ma_vt, ma_dv, ngay_ap)

### Bang: dmvt (Danh muc vat tu - Lookup)

| Truong | Mo ta |
|--------|-------|
| ma_vt | Ma vat tu |
| ten_vt | Ten vat tu |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Vat tu | FK ma_vt -> DMVT.ma_vt |
| DMDV | Don vi tinh | FK ma_dv -> DMDV.ma_dv |

---

## Form classes

### 1. frmSODMDGVT (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvcMa_Vt | DataGridViewColumn | Ma vat tu |
| dgvcTen_Vt | DataGridViewColumn | Ten vat tu |
| dgvcMa_Dv | DataGridViewColumn | Ma don vi |
| dgvcGia | DataGridViewColumn | Don gia |
| dgvcNgay_Ap | DataGridViewColumn | Ngay ap dung |
| dgvcMa_Nt | DataGridViewColumn | Ma ngoai te |

### 2. frmSODMDGVTEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Vt | AsTextBox | ma_vt | Ma vat tu (AutoLookup) |
| lblTen_Vt | Label | - | Ten vat tu hien thi |
| txtMa_Dv | AsTextBox | ma_dv | Ma don vi tinh |
| txtGia | AsTextNumeric | gia | Don gia |
| txtNgay_Ap | AsMaskedTextBox | ngay_ap | Ngay ap dung |
| cboMa_Nt | AsComboBoxNT | ma_nt | Ma ngoai te |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMDGVT_GET | Lay danh sach don gia |
| SP_SO_DMDGVT_GETBYID | Lay chi tiet 1 don gia |
| SP_SO_DMDGVT_INSERT | Them don gia moi |
| SP_SO_DMDGVT_UPDATE | Cap nhat don gia |
| SP_SO_DMDGVT_DELETE | Xoa don gia |
| SP_SO_DMDGVT_FIND | Tim kiem don gia |
| SP_SO_DMDGVT_CHECK | Kiem tra trung lap |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMDGVT_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_vt VARCHAR(20),
    @pMa_dv VARCHAR(20),
    @pNgay_ap DATE,
    @pGia DECIMAL(18,2),
    @pMa_nt VARCHAR(3),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Lookup valid | ma_vt | 'Vat tu khong ton tai' |
| Required | ma_dv | 'Don vi tinh khong duoc trong' |
| Required | ngay_ap | 'Ngay ap dung khong duoc trong' |
| Required | gia | 'Don gia khong duoc trong' |
| Positive | gia | 'Don gia phai lon hon 0' |

### Business Rules

1. **Ma_Vt Lookup**:
   - Lookup tu bang dmvt
   - Tu dong dien ten vat tu

2. **Don gia theo thoi gian**:
   - Co nhieu don gia cho cung vat tu, khac nhau theo ngay ap dung
   - Su dung khoa chinh (ma_vt, ma_dv, ngay_ap)

3. **Don gia theo ngoai te**:
   - Ho tro nhieu don gia theo nhieu loai ngoai te
   - Quy doi theo ty gia khi can

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMdgvt.php
namespace Diepxuan\Simba\Models\SO;

class DMdgvt extends Model
{
    protected $table = 'dmdgvt';
    protected $primaryKey = ['ma_vt', 'ma_dv', 'ngay_ap'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_vt',
        'ma_dv',
        'ngay_ap',
        'gia',
        'ma_nt',
    ];

    protected $casts = [
        'ngay_ap' => 'date',
        'gia' => 'decimal:2',
    ];

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function donVi()
    {
        return $this->belongsTo(DMDV::class, 'ma_dv', 'ma_dv');
    }

    public function scopeForVatTu($query, string $maVt)
    {
        return $query->where('ma_vt', $maVt);
    }

    public function scopeActive($query, ?string $date = null)
    {
        $date = $date ?? date('Y-m-d');
        return $query->where('ngay_ap', '<=', $date)
            ->orderBy('ngay_ap', 'desc');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetDMdgvt.php
class AsSOGetDMdgvt extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMDGVT_GET';
    protected $params = ['pMa_cty', 'pMa_vt', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsDMdgvt.php
class AsSOInsDMdgvt extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMDGVT_INSERT';
    protected $params = ['pMa_cty', 'pMa_vt', 'pMa_dv', 'pNgay_ap', 'pGia', 'pMa_nt'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdDMdgvt.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelDMdgvt.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Dongiavattu.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Dongiavattu;

class Dongiavattu extends Component
{
    public Collection $pList;
    public string $pSearch = '';
    public ?string $pMaVt = null;
    public int $pPageIndex = 1;

    public function mount(?string $maVt = null): void
    {
        $this->pMaVt = $maVt;
        $this->loadList();
    }

    public function loadList(): void
    {
        // Load tu SP_SO_DMDGVT_GET
    }

    public function render(): View
    {
        return view('catalog::so.dongiavattu');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/DongiavattuEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\DongiavattuEdit;

class DongiavattuEdit extends Component
{
    public string $pMaVt = '';
    public string $pTenVt = '';
    public string $pMaDv = '';
    public string $pNgayAp = '';
    public float $pGia = 0;
    public string $pMaNt = 'VND';
    public ?string $pMode = 'create';

    protected $rules = [
        'pMaVt' => 'required|string|max:20',
        'pMaDv' => 'required|string|max:20',
        'pNgayAp' => 'required|date',
        'pGia' => 'required|numeric|min:0.01',
    ];

    public function mount(?string $maVt = null, ?string $maDv = null, ?string $ngayAp = null): void
    {
        if ($maVt && $maDv && $ngayAp) {
            $this->pMaVt = $maVt;
            $this->pMaDv = $maDv;
            $this->pNgayAp = $ngayAp;
            $this->loadData();
        }
    }

    public function updatedPMaVt($value): void
    {
        $vt = DMVT::find($value);
        $this->pTenVt = $vt->ten_vt ?? '';
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.dongiavattu-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── dongiavattu/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/don-gia-vat-tu', [Dongiavattu::class, 'render'])
            ->name('dongiavattu');
        Route::get('/don-gia-vat-tu/edit', [DongiavattuEdit::class, 'render'])
            ->name('dongiavattu.edit');
        Route::get('/don-gia-vat-tu/edit/{maVt}/{maDv}/{ngayAp}', [DongiavattuEdit::class, 'render'])
            ->name('dongiavattu.edit.bykey');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMdgvt.php | Chinh |
| Model | laravel-simba | DMVT.php | Vat tu |
| Model | laravel-simba | DMDV.php | Don vi tinh |
| SP | laravel-simba | AsSOGetDMdgvt.php | Get list |
| SP | laravel-simba | AsSOInsDMdgvt.php | Insert |
| Component | laravel-catalog | Dongiavattu.php | List |
| Component | laravel-catalog | DongiavattuEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMdgvt (composite key)
- [ ] Tao Livewire Dongiavattu (list)
- [ ] Tao Livewire DongiavattuEdit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD voi composite key
- [ ] Test Lookup vat tu