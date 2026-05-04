# Task 064: PODMDKTT

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang danh muc dieu khoan thanh toan mua tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** PODMDKTT.dll
- **Chuc nang:** Danh muc dieu khoan thanh toan mua
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc dieu khoan thanh toan mua
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PODMDKTT (danh muc PO)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PODMDKTT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMDKTT (Danh muc dieu khoan thanh toan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_tt_po | varchar | 50 | Ma dieu khoan (khoa chinh) |
| mo_ta | nvarchar | 200 | Mo ta dieu khoan |
| han_tt | int | 4 | Han thanh toan (ngay) |
| tl_ck | decimal | 18,6 | Ty le chiet khau (%) |
| han_ck | int | 4 | Han chiet khau (ngay) |
| ls_qh | decimal | 18,6 | Lai suat qua han (%) |
| ksd | bit | 1 | Khoa su dung |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| POMHCT | Chi tiet mua hang | FK ma_tt_po -> DMDKTT.ma_tt_po |
| DMKH | Khach hang | Lookup ma_tt_po |

---

## Form classes

### 1. frmPODMDKTT (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach dieu khoan thanh toan
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi |
| txtSearch | TextBox | - | Tim kiem |
| btnAdd | Button | - | Nut them |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmPODMDKTTEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_tt_po | AsTextBox | ma_tt_po | Ma dieu khoan |
| txtMo_ta | TextBox | mo_ta | Mo ta |
| txtHan_tt | AsTextNumeric | han_tt | Han thanh toan |
| txttl_ck | AsTextNumeric | tl_ck | Ty le chiet khau |
| txtHan_ck | AsTextNumeric | han_ck | Han chiet khau |
| txtls_qh | AsTextNumeric | ls_qh | Lai suat qua han |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_DMDKTT_GET | Lay danh sach |
| SP_PO_DMDKTT_GETBYID | Lay chi tiet |
| SP_PO_DMDKTT_INSERT | Them moi |
| SP_PO_DMDKTT_UPDATE | Cap nhat |
| SP_PO_DMDKTT_DELETE | Xoa |
| SP_PO_DMDKTT_FIND | Tim kiem |
| SP_PO_DMDKTT_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
EXEC SP_PO_DMDKTT_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_tt_po | 'Ma dieu khoan khong duoc trong' |
| Max length 50 | ma_tt_po | 'Ma toi da 50 ky tu' |
| Unique | ma_tt_po | 'Ma da ton tai' |
| Required | mo_ta | 'Mo ta khong duoc trong' |
| Max length 200 | mo_ta | 'Mo ta toi da 200 ky tu' |
| Min 0, Max 100 | tl_ck | 'Ty le chiết khấu 0-100%' |
| Min 0 | han_tt | 'Han thanh toan >= 0' |

### Business Rules

1. **Han thanh toan** (`han_tt`):
   - So ngay cho phep cong no
   - Mac dinh = 0

2. **Ty le chiet khau** (`tl_ck`):
   - Phan tram chiết khấu thanh toán sớm
   - 0-100%

3. **Han chiet khau** (`han_ck`):
   - So ngay duoc huong chiết khấu

4. **Lai suat qua han** (`ls_qh`):
   - % phat neu qua han thanh toan

5. **Xoa**:
   - Kiem tra khong co khach hang su dung

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/DMDKTT.php
namespace Diepxuan\Simba\Models\PO;

class DMDKTT extends Model
{
    protected $table = 'DMDKTT';
    protected $primaryKey = 'ma_tt_po';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_tt_po',
        'mo_ta',
        'han_tt',
        'tl_ck',
        'han_ck',
        'ls_qh',
        'ksd',
    ];

    protected $casts = [
        'han_tt' => 'integer',
        'tl_ck' => 'decimal:6',
        'han_ck' => 'integer',
        'ls_qh' => 'decimal:6',
        'ksd' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_tt_po', 'like', "%{$search}%")
              ->orWhere('mo_ta', 'like', "%{$search}%");
        });
    }
}
```

### 2. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Danhmuc/Dieukhoantt.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Danhmuc;

class Dieukhoantt extends Component
{
    const MA_CT = 'PODMDKTT';

    public Collection $pDanhSach;
    public string $pSearch = '';

    public function render(): View
    {
        return view('catalog::po.danhmuc.dieukhoantt');
    }
}
```

### 3. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Danhmuc/DieukhoanttEdit.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Danhmuc;

class DieukhoanttEdit extends Component
{
    public ?string $pMa_tt_po = null;
    public string $pMo_ta = '';
    public int $pHan_tt = 0;
    public float $pTl_ck = 0;
    public int $pHan_ck = 0;
    public float $pLs_qh = 0;
    public bool $pKsd = false;

    protected $rules = [
        'pMa_tt_po' => 'required|string|max:50|unique:DMDKTT,ma_tt_po',
        'pMo_ta' => 'required|string|max:200',
        'pTl_ck' => 'nullable|numeric|min:0|max:100',
    ];

    public function render(): View
    {
        return view('catalog::po.danhmuc.dieukhoantt-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/po/danhmuc/
├── dieukhoantt.blade.php
├── dieukhoantt-edit.blade.php
└── _dieukhoantt-row.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/po/danhmuc')
    ->name('catalog.po.danhmuc.')
    ->group(function () {
        Route::get('/dieu-khoan-tt', [Dieukhoantt::class, 'render'])
            ->name('dieukhoantt');
        Route::get('/dieu-khoan-tt/edit/{ma_tt_po?}', [DieukhoanttEdit::class, 'render'])
            ->name('dieukhoantt.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMDKTT.php | Chinh |
| Component | laravel-catalog | Dieukhoantt.php | List |
| Component | laravel-catalog | DieukhoanttEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMDKTT
- [ ] Tao Livewire Dieukhoantt (list)
- [ ] Tao Livewire DieukhoanttEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMKH