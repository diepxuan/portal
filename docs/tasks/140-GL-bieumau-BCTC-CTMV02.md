# Task 140: GLMAUBCTCTMV02

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Mau bao cao tai chinh V02 tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLMAUBCTCTMV02.dll
- **Chuc nang:** Quan ly mau bao cao tai chinh V02 (BCTC - Bao cao tai chinh)
- **Loai:** Bieu mau (MAU)
- **Assembly Title:** GLBCTC07V02
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)
- **Template:** BCTC V02 (Thong tu 200/2014/TT-BTC)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLMAUBCTCTMV02.dll/README.md`

---

## Cau truc du lieu

### Bang: MAUBCTC (Mau bao cao tai chinh)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Ma mau QD (khoa chinh) |
| ma_so | varchar | 50 | Ma chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh toan |
| tk_01 | varchar | 50 | Tai khoan (Lookup: TK) |
| IsPrint | bit | 1 | Co in hay khong |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | FK tk_01 -> DMTAIKHOAN.tk |
| GLRpt* | Cac bao cao | Lookup mau |

---

## Form classes

### 1. frmGLMAUBCTCTMV02 (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chi tieu BCTC V02, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma_so/chi_tieu |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmGLMAUBCTCTMV02Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin chi tieu BCTC V02
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu (AutoComplete, Uppercase) |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu (Multiline) |
| txtCong_thuc | TextBox | cach_tinh | Cong thuc tinh toan |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (Lookup: TK) |
| lblTK | Label | - | Hien thi ten tai khoan |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_MAU_BCTC_V02_GET | Lay danh sach chi tieu V02 |
| SP_GL_MAU_BCTC_V02_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_MAU_BCTC_V02_INSERT | Them chi tieu moi |
| SP_GL_MAU_BCTC_V02_UPDATE | Cap nhat chi tieu |
| SP_GL_MAU_BCTC_V02_DELETE | Xoa chi tieu |
| SP_GL_MAU_BCTC_V02_FIND | Tim kiem chi tieu |
| SP_GL_MAU_BCTC_V02_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach chi tieu V02
EXEC SP_GL_MAU_BCTC_V02_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMau VARCHAR(50) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
-- Them chi tieu moi
EXEC SP_GL_MAU_BCTC_V02_INSERT
    @pMa_cty VARCHAR(50),
    @pMau VARCHAR(50),
    @pMa_so VARCHAR(50),
    @pChi_tieu NVARCHAR(200),
    @pNd_chtieu NVARCHAR(500) = NULL,
    @pCach_tinh NVARCHAR(200) = NULL,
    @pTk_01 VARCHAR(50) = NULL,
    @pIsPrint BIT = 1,
    @pIsItalic BIT = 0,
    @pBold BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_so | 'Ma chi tieu khong duoc trong' |
| Max length 50 | ma_so | 'Ma chi tieu toi da 50 ky tu' |
| Unique | ma_so + mau | 'Ma chi tieu da ton tai trong mau nay' |
| Required | chi_tieu | 'Chi tieu khong duoc trong' |
| Max length 200 | chi_tieu | 'Chi tieu toi da 200 ky tu' |
| Max length 500 | nd_chtieu | 'Noi dung chi tieu toi da 500 ky tu' |
| Max length 200 | cach_tinh | 'Cong thuc tinh toi da 200 ky tu' |

### Business Rules

1. **Ma chi tieu**:
   - Uppercase tu dong
   - AutoComplete tu danh sach
   - Khong cho phep trung trong cung mau

2. **Mau quyet dinh**:
   - Mac dinh lay tu CompanyInformations.Qd_cdkt
   - Neu de trong thi tu dong gan

3. **Tai khoan**:
   - Lookup tu DMTAIKHOAN
   - Hien thi ten tai khoan

4. **Tuy chon in**:
   - IsPrint: Mac dinh = true khi them moi
   - IsItalic: Mac dinh = false
   - Bold: Mac dinh = false

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/MAUBCTCMVI211.php
namespace Diepxuan\Simba\Models\GL;

class MAUBCTCMVI211 extends Model
{
    protected $table = 'MAUBCTC_V02';
    protected $primaryKey = ['mau', 'ma_so'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'mau',
        'ma_so',
        'chi_tieu',
        'nd_chtieu',
        'cach_tinh',
        'tk_01',
        'IsPrint',
        'IsItalic',
        'bold',
    ];

    protected $casts = [
        'IsPrint' => 'boolean',
        'IsItalic' => 'boolean',
        'bold' => 'boolean',
    ];

    // Relationships
    public function taiKhoan()
    {
        return $this->belongsTo(DMTAIKHOAN::class, 'tk_01', 'tk');
    }

    // Scopes
    public function scopeByMau($query, $mau)
    {
        return $query->where('mau', $mau);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_so', 'like', "%{$search}%")
              ->orWhere('chi_tieu', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLGetMAUBCTCV02.php
namespace Diepxuan\Simba\StoredProcedures;

class AsGLGetMAUBCTCV02 extends StoredProcedure
{
    protected $procedure = 'SP_GL_MAU_BCTC_V02_GET';
    protected $params = [
        'pMa_cty',
        'pMau',
        'pSearch',
        'pPageIndex',
        'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGLInsMAUBCTCV02.php
class AsGLInsMAUBCTCV02 extends StoredProcedure
{
    protected $procedure = 'SP_GL_MAU_BCTC_V02_INSERT';
    protected $params = [
        'pMa_cty',
        'mau',
        'ma_so',
        'chi_tieu',
        'nd_chtieu',
        'cach_tinh',
        'tk_01',
        'IsPrint',
        'IsItalic',
        'bold',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGLUpdMAUBCTCV02.php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLDelMAUBCTCV02.php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLChkMAUBCTCV02.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV02.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV02 extends Component
{
    const MA_CT = 'GL';

    public Collection $pChiTieus;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaSo = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadChiTieus();
    }

    public function loadChiTieus(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::gl.bieumau.bctcmv02');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV02Edit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV02Edit extends Component
{
    public ?string $pMau = null;
    public ?string $pMaSo = null;
    public string $pChiTieu = '';
    public string $pNdChtieu = '';
    public string $pCachTinh = '';
    public ?string $pTk01 = null;
    public string $pTenTk = '';
    public bool $pIsPrint = true;
    public bool $pIsItalic = false;
    public bool $pBold = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMaSo' => 'required|string|max:50',
        'pChiTieu' => 'required|string|max:200',
        'pNdChtieu' => 'nullable|string|max:500',
        'pCachTinh' => 'nullable|string|max:200',
        'pTk01' => 'nullable|string|max:50',
    ];

    protected $messages = [
        'pMaSo.required' => 'Ma chi tieu khong duoc trong',
        'pChiTieu.required' => 'Chi tieu khong duoc trong',
    ];

    public function mount(?string $mau = null, ?string $maSo = null): void
    {
        $this->pMau = $mau ?? config('simba.company.default_mau_qd');
        if ($maSo) {
            $this->pMaSo = $maSo;
            $this->loadChiTieu();
        }
    }

    public function updatedPTk01($value): void
    {
        if ($value) {
            $this->pTenTk = $this->getTkName($value);
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::gl.bieumau.bctcmv02-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/gl/bieumau/
├── bctcmv02.blade.php           (List page)
├── bctcmv02-edit.blade.php      (Modal edit)
└── _bctcmv02-row.blade.php      (Component row)
```

### 6. Routes

```php
// routes/web.php hoac routes/catalog.php
Route::prefix('catalog/gl/bieumau')
    ->name('catalog.gl.bieumau.')
    ->group(function () {
        Route::get('/bctcmv02', [BCTCMV02::class, 'render'])
            ->name('bctcmv02');
        Route::get('/bctcmv02/edit/{mau?}/{maSo?}', [BCTCMV02Edit::class, 'render'])
            ->name('bctcmv02.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | MAUBCTCMVI211.php | Chinh |
| Model | laravel-simba | DMTAIKHOAN.php | Lien quan (FK) |
| SP | laravel-simba | AsGLGetMAUBCTCV02.php | Chinh |
| SP | laravel-simba | AsGLInsMAUBCTCV02.php | Insert |
| SP | laravel-simba | AsGLUpdMAUBCTCV02.php | Update |
| SP | laravel-simba | AsGLDelMAUBCTCV02.php | Delete |
| SP | laravel-simba | AsGLChkMAUBCTCV02.php | Check trung |
| Component | laravel-catalog | BCTCMV02.php | List |
| Component | laravel-catalog | BCTCMV02Edit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model MAUBCTCMVI211
- [ ] Tao Livewire BCTCMV02 (list)
- [ ] Tao Livewire BCTCMV02Edit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTAIKHOAN

---

## Ghi chu

- Mau BCTC V02 la mau bao cao tai chinh theo Thong tu 200/2014/TT-BTC
- Moi chi tieu co 1 tai khoan (tk_01)
- Cong thuc tinh co the tham chieu den cac tai khoan khac
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
