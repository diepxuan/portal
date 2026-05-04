# Task 055: SODMPTVT

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc phuong tien van tai tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SODMPTVT.dll
- **Chuc nang:** Quan ly danh muc phuong tien van tai
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc phuong tien van tai
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PTVT (Phuong tien van tai)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMPTVT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMPTVT (Danh muc phuong tien van tai)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_pt | varchar | 20 | Ma phuong tien (khoa chinh) |
| ten_pt | nvarchar | 100 | Ten phuong tien |
| bien_so | varchar | 20 | Bien so xe |
| nguoi_dk | nvarchar | 100 | Nguoi dieu khien |
| cao | decimal | 10,2 | Chieu cao (m) |
| rong | decimal | 10,2 | Chieu rong (m) |
| dai | decimal | 10,2 | Chieu dai (m) |
| the_tich | decimal | 10,2 | The tich (m3) |
| trong_tai | decimal | 10,2 | Trong tai (tan) |
| tg_xep | decimal | 10,2 | Thoi gian xep (gio) |
| tg_do | decimal | 10,2 | Thoi gian do (gio) |
| ksd | bit | 1 | Khoa su dung |

---

## Form classes

### 1. frmSODMPTVT (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach phuong tien, tim kiem, phan trang
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem theo ma/ten/bien so |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmSODMPTVTEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin phuong tien
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_pt | AsTextBox | ma_pt | Ma phuong tien |
| txtTen_pt | TextBox | ten_pt | Ten phuong tien |
| txtBien_so | TextBox | bien_so | Bien so xe |
| txtNguoi_dk | TextBox | nguoi_dk | Nguoi dieu khien |
| txtCao | AsTextNumeric | cao | Chieu cao (m) |
| txtRong | AsTextNumeric | rong | Chieu rong (m) |
| txtDai | AsTextNumeric | dai | Chieu dai (m) |
| txtThe_tich | AsTextNumeric | the_tich | The tich (m3) |
| txtTrong_tai | AsTextNumeric | trong_tai | Trong tai (tan) |
| txtTG_xep | AsTextNumeric | tg_xep | Thoi gian xep (gio) |
| txtTG_do | AsTextNumeric | tg_do | Thoi gian do (gio) |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_PTVT_GET | Lay danh sach phuong tien |
| SP_SO_PTVT_GETBYID | Lay chi tiet 1 phuong tien |
| SP_SO_PTVT_INSERT | Them phuong tien moi |
| SP_SO_PTVT_UPDATE | Cap nhat phuong tien |
| SP_SO_PTVT_DELETE | Xoa phuong tien |
| SP_SO_PTVT_FIND | Tim kiem |
| SP_SO_PTVT_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
EXEC SP_SO_PTVT_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_pt VARCHAR(20),
    @pTen_pt NVARCHAR(100),
    @pBien_so VARCHAR(20) = NULL,
    @pNguoi_dk NVARCHAR(100) = NULL,
    @pCao DECIMAL(10,2) = 0,
    @pRong DECIMAL(10,2) = 0,
    @pDai DECIMAL(10,2) = 0,
    @pThe_tich DECIMAL(10,2) = 0,
    @pTrong_tai DECIMAL(10,2) = 0,
    @pTg_xep DECIMAL(10,2) = 0,
    @pTg_do DECIMAL(10,2) = 0,
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_pt | 'Ma phuong tien khong duoc trong' |
| Max length 20 | ma_pt | 'Ma phuong tien toi da 20 ky tu' |
| Required | ten_pt | 'Ten phuong tien khong duoc trong' |
| Max length 100 | ten_pt | 'Ten phuong tien toi da 100 ky tu' |
| Numeric | cao | 'Chieu cao phai la so' |
| Numeric | rong | 'Chieu rong phai la so' |
| Numeric | dai | 'Chieu dai phai la so' |
| Numeric | the_tich | 'The tich phai la so' |
| Numeric | trong_tai | 'Trong tai phai la so' |

### Business Rules

1. **Ma phuong tien (ma_pt)**:
   - AutoGenerate neu de trong
   - CharacterCasing: Upper

2. **Bien so xe (bien_so)**:
   - Khong bat buoc
   - Su dung de tra cuu phuong tien

3. **Thong so ky thuat**:
   - Don vi: m (cao/rong/dai), m3 (the tich), tan (trong tai)
   - Gio (tg_xep, tg_do)

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMPTVT.php
namespace Diepxuan\Simba\Models\SO;

class DMPTVT extends Model
{
    protected $table = 'DMPTVT';
    protected $primaryKey = 'ma_pt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_pt', 'ten_pt', 'bien_so', 'nguoi_dk',
        'cao', 'rong', 'dai', 'the_tich',
        'trong_tai', 'tg_xep', 'tg_do', 'ksd',
    ];

    protected $casts = [
        'cao' => 'decimal:2',
        'rong' => 'decimal:2',
        'dai' => 'decimal:2',
        'the_tich' => 'decimal:2',
        'trong_tai' => 'decimal:2',
        'tg_xep' => 'decimal:2',
        'tg_do' => 'decimal:2',
        'ksd' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_pt', 'like', "%{$search}%")
              ->orWhere('ten_pt', 'like', "%{$search}%")
              ->orWhere('bien_so', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoGetDMPTVT.php
namespace Diepxuan\Simba\StoredProcedures;

class SoGetDMPTVT extends StoredProcedure
{
    protected $procedure = 'SP_SO_PTVT_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoInsDMPTVT.php
class SoInsDMPTVT extends StoredProcedure
{
    protected $procedure = 'SP_SO_PTVT_INSERT';
    protected $params = [
        'pMa_cty', 'ma_pt', 'ten_pt', 'bien_so', 'nguoi_dk',
        'cao', 'rong', 'dai', 'the_tich',
        'trong_tai', 'tg_xep', 'tg_do', 'ksd',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoUpdDMPTVT.php
// diepxuan/laravel-simba/src/StoredProcedures/SoDelDMPTVT.php
// diepxuan/laravel-simba/src/StoredProcedures/SoChkDMPTVT.php
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Phuongtienvantai.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Phuongtienvantai extends Component
{
    const MA_CT = 'PTVT';

    public Collection $pPhuongTiens;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaPt = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadPhuongTien();
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.phuongtienvantai');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/PhuongtienvantaiEdit.php
class PhuongtienvantaiEdit extends Component
{
    public ?string $pMa_Pt = null;
    public string $pTen_Pt = '';
    public string $pBien_So = '';
    public string $pNguoi_Dk = '';
    public float $pCao = 0;
    public float $pRong = 0;
    public float $pDai = 0;
    public float $pThe_Tich = 0;
    public float $pTrong_Tai = 0;
    public float $pTg_Xep = 0;
    public float $pTg_Do = 0;
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Pt' => 'required|string|max:20',
        'pTen_Pt' => 'required|string|max:100',
    ];

    public function render(): View
    {
        return view('catalog::so.danhmuc.phuongtienvantai-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/so/danhmuc/
├── phuongtienvantai.blade.php
├── phuongtienvantai-edit.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/phuong-tien-van-tai', [Phuongtienvantai::class, 'render'])
            ->name('phuongtienvantai');
        Route::get('/phuong-tien-van-tai/edit/{maPt?}', [PhuongtienvantaiEdit::class, 'render'])
            ->name('phuongtienvantai.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMPTVT.php | Chinh |
| SP | laravel-simba | SoGetDMPTVT.php | Get list |
| SP | laravel-simba | SoInsDMPTVT.php | Insert |
| SP | laravel-simba | SoUpdDMPTVT.php | Update |
| SP | laravel-simba | SoDelDMPTVT.php | Delete |
| SP | laravel-simba | SoChkDMPTVT.php | Check trung |
| Component | laravel-catalog | Phuongtienvantai.php | List |
| Component | laravel-catalog | PhuongtienvantaiEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMPTVT
- [ ] Tao Livewire Phuongtienvantai
- [ ] Tao Livewire PhuongtienvantaiEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Search by bien_so