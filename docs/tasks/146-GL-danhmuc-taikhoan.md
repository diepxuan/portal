# Task 146: GLDMTK

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Danh muc tai khoan tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLDMTK.dll
- **Chuc nang:** Quan ly danh muc tai khoan ke toan (Chart of Accounts)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc tai khoan
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLDMTK.dll/README.md`

---

## Cau truc du lieu

### Bang: DMTAIKHOAN (Danh muc tai khoan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| tk | varchar | 50 | Ma tai khoan (khoa chinh) |
| ten_tk | nvarchar | 200 | Ten tai khoan |
| tk_me | varchar | 50 | Tai khoan me (NULL = root) |
| bac_tk | int | 4 | Bac tai khoan (1, 2, 3...) |
| bold | bit | 1 | In dam (1: tai khoan me co con) |
| tk_cn | bit | 1 | Tai khoan cong no (0: thuong, 1: cong no) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Chinh no | FK tk_me -> DMTAIKHOAN.tk (self-reference) |
| CDTK | So du dau ky | FK tk -> DMTAIKHOAN.tk |
| GLMAU* | Cac mau BCTC | Lookup tk |

---

## Form classes

### 1. frmGLDMTK (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach tai khoan theo cau truc phan cap, tim kiem
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach (TreeView style) |
| txtSearch | TextBox | - | Tim kiem theo tk/ten_tk |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmGLDMTKEdit (Form them/sua)
- **Chuc nang:** Nhap, sua thong tin tai khoan
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTk | AsTextBox | tk | Ma tai khoan |
| txtTen_Tk | TextBox | ten_tk | Ten tai khoan |
| txtTk_Me | AsTextBox | tk_me | Tai khoan me (Lookup: TK) |
| lblTen_Tk_Me | Label | - | Hien thi ten tai khoan me |
| txtBac_Tk | TextBox | bac_tk | Bac tai khoan (auto) |
| chkBold | AsCheckBox | bold | In dam |
| chkTk_Cn | AsCheckBox | tk_cn | Tai khoan cong no |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_DMTK_GET | Lay danh sach tai khoan (phan cap) |
| SP_GL_DMTK_GETBYID | Lay chi tiet 1 tai khoan |
| SP_GL_DMTK_INSERT | Them tai khoan moi |
| SP_GL_DMTK_UPDATE | Cap nhat tai khoan |
| SP_GL_DMTK_DELETE | Xoa tai khoan |
| SP_GL_DMTK_FIND | Tim kiem tai khoan |
| SP_GL_DMTK_CHECK | Kiem tra trung ma |
| SP_GL_DMTK_CHECK_TKME | Kiem tra tai khoan me |
| SP_GL_DMTK_CALC_BAC | Tinh lai bac tai khoan |

### SP_GET (reference)

```sql
-- Lay danh sach tai khoan
EXEC SP_GL_DMTK_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL
```

### SP_INSERT (reference)

```sql
-- Them tai khoan moi
EXEC SP_GL_DMTK_INSERT
    @pMa_cty VARCHAR(50),
    @pTk VARCHAR(50),
    @pTen_tk NVARCHAR(200),
    @pTk_me VARCHAR(50) = NULL,
    @pBold BIT = 0,
    @pTk_cn BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | tk | 'Ma tai khoan khong duoc trong' |
| Max length 50 | tk | 'Ma tai khoan toi da 50 ky tu' |
| Unique | tk | 'Ma tai khoan da ton tai' |
| Required | ten_tk | 'Ten tai khoan khong duoc trong' |
| Max length 200 | ten_tk | 'Ten tai khoan toi da 200 ky tu' |

### Business Rules

1. **Ma tai khoan**:
   - Khong cho phep sua khi da co phat sinh
   - AutoGenerate neu de trong (gan ma tu dong)

2. **Tai khoan me (tk_me)**:
   - Neu de trong -> tai khoan goc (root)
   - Neu co -> phai ton tai trong danh muc
   - Kiem tra chu trinh: tk -> tk_me -> ... -> NULL

3. **Tinh bac tai khoan (bac_tk)**:
   - Tu dong tinh theo do dai ma TK
   - TK 1 ky tu -> bac_tk = 1
   - TK 2 ky tu -> bac_tk = 2
   - TK n ky tu -> bac_tk = n

4. **In dam (bold)**:
   - Tu dong = 1 khi co tai khoan con
   - Tu dong = 0 khi khong co tai khoan con

5. **Tai khoan cong no (tk_cn)**:
   - 0: Tai khoan thuong
   - 1: Tai khoan cong no (co so du)

6. **Xoa tai khoan**:
   - Kiem tra khong co tai khoan con
   - Kiem tra khong co phat sinh
   - Neu co -> khong cho xoa

### Thu at toan phan cap

```php
// Xac dinh tai khoan me tu ma TK
// VD: TK 1111 -> TK me: 111
// TK 111 -> TK me: 11
// TK 11 -> TK me: 1
// TK 1 -> TK me: NULL (root)

$tk_me = strlen($tk) > 1 ? substr($tk, 0, -1) : null;

// Tinh bac
$bac_tk = strlen($tk);

// Thuut le ten TK theo bac
$indent = str_repeat('   ', $bac_tk - 1);
$ten_tk_hienthi = $indent . $ten_tk;
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/DMTAIKHOAN.php
namespace Diepxuan\Simba\Models\GL;

class DMTAIKHOAN extends Model
{
    protected $table = 'DMTAIKHOAN';
    protected $primaryKey = 'tk';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'tk',
        'ten_tk',
        'tk_me',
        'bac_tk',
        'bold',
        'tk_cn',
    ];

    protected $casts = [
        'bold' => 'boolean',
        'tk_cn' => 'boolean',
    ];

    // Relationships
    public function taiKhoanMe()
    {
        return $this->belongsTo(DMTAIKHOAN::class, 'tk_me', 'tk');
    }

    public function taiKhoanCons()
    {
        return $this->hasMany(DMTAIKHOAN::class, 'tk_me', 'tk');
    }

    public function soDuDauKy()
    {
        return $this->hasMany(CDTK::class, 'tk', 'tk');
    }

    // Scopes
    public function scopeRoot($query)
    {
        return $query->whereNull('tk_me');
    }

    public function scopeCongNo($query)
    {
        return $query->where('tk_cn', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('tk', 'like', "%{$search}%")
              ->orWhere('ten_tk', 'like', "%{$search}%");
        });
    }

    // Attributes
    public function getTenTkMeAttribute()
    {
        return $this->taiKhoanMe ? $this->taiKhoanMe->ten_tk : '';
    }

    public function getIndentTenTkAttribute()
    {
        return str_repeat('   ', $this->bac_tk - 1) . $this->ten_tk;
    }

    // Methods
    public function hasCon(): bool
    {
        return $this->taiKhoanCons()->count() > 0;
    }

    public function isRoot(): bool
    {
        return is_null($this->tk_me);
    }

    public static function calculateTkMe(string $tk): ?string
    {
        return strlen($tk) > 1 ? substr($tk, 0, -1) : null;
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLGetDMTK.php
namespace Diepxuan\Simba\StoredProcedures;

class AsGLGetDMTK extends StoredProcedure
{
    protected $procedure = 'SP_GL_DMTK_GET';
    protected $params = [
        'pMa_cty',
        'pSearch',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGLInsDMTK.php
class AsGLInsDMTK extends StoredProcedure
{
    protected $procedure = 'SP_GL_DMTK_INSERT';
    protected $params = [
        'pMa_cty',
        'tk',
        'ten_tk',
        'tk_me',
        'bold',
        'tk_cn',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGLUpdDMTK.php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLDelDMTK.php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLChkDMTK.php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLChkTkMe.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Danhmuc/DanhmucTaikhoan.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Danhmuc;

class DanhmucTaikhoan extends Component
{
    const MA_CT = 'GL';

    public Collection $pTaiKhoans;
    public string $pSearch = '';
    public ?string $pEditingTk = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadTaiKhoans();
    }

    public function loadTaiKhoans(): void
    {
        // Load tu Stored Procedure
    }

    public function getTreeData(): array
    {
        // Chuyen doi thanh cau truc tree
    }

    public function render(): View
    {
        return view('catalog::gl.danhmuc.danhmuc-taikhoan');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Danhmuc/DanhmucTaikhoanEdit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Danhmuc;

class DanhmucTaikhoanEdit extends Component
{
    public ?string $pTk = null;
    public string $pTenTk = '';
    public ?string $pTkMe = null;
    public string $pTenTkMe = '';
    public int $pBacTk = 0;
    public bool $pBold = false;
    public bool $pTkCn = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pTk' => 'required|string|max:50|unique:DMTAIKHOAN,tk',
        'pTenTk' => 'required|string|max:200',
        'pTkMe' => 'nullable|string|max:50|exists:DMTAIKHOAN,tk',
    ];

    public function mount(?string $tk = null): void
    {
        if ($tk) {
            $this->pTk = $tk;
            $this->pMode = 'edit';
            $this->loadTaiKhoan();
        }
    }

    public function updatedPTkMe($value): void
    {
        if ($value) {
            $tk = DMTAIKHOAN::find($value);
            $this->pTenTkMe = $tk ? $tk->ten_tk : '';
        } else {
            $this->pTenTkMe = '';
        }
    }

    public function calculateBac(): void
    {
        if ($this->pTk) {
            $this->pBacTk = strlen($this->pTk);
            // Auto-set tk_me if not set
            if (empty($this->pTkMe) && $this->pBacTk > 1) {
                $this->pTkMe = DMTAIKHOAN::calculateTkMe($this->pTk);
                $this->updatedPTkMe($this->pTkMe);
            }
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::gl.danhmuc.danhmuc-taikhoan-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/gl/danhmuc/
├── danhmuc-taikhoan.blade.php       (List page - TreeView)
├── danhmuc-taikhoan-edit.blade.php  (Modal edit)
└── _danhmuc-taikhoan-row.blade.php  (Component row)
```

### 6. Routes

```php
// routes/web.php hoac routes/catalog.php
Route::prefix('catalog/gl/danhmuc')
    ->name('catalog.gl.danhmuc.')
    ->group(function () {
        Route::get('/tai-khoan', [DanhmucTaikhoan::class, 'render'])
            ->name('taikhoan');
        Route::get('/tai-khoan/edit/{tk?}', [DanhmucTaikhoanEdit::class, 'render'])
            ->name('taikhoan.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMTAIKHOAN.php | Chinh |
| Model | laravel-simba | CDTK.php | Lien quan (so du dau ky) |
| SP | laravel-simba | AsGLGetDMTK.php | Chinh |
| SP | laravel-simba | AsGLInsDMTK.php | Insert |
| SP | laravel-simba | AsGLUpdDMTK.php | Update |
| SP | laravel-simba | AsGLDelDMTK.php | Delete |
| SP | laravel-simba | AsGLChkDMTK.php | Check trung |
| Component | laravel-catalog | DanhmucTaikhoan.php | List |
| Component | laravel-catalog | DanhmucTaikhoanEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMTAIKHOAN
- [ ] Tao Livewire DanhmucTaikhoan (list - TreeView)
- [ ] Tao Livewire DanhmucTaikhoanEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Implement tree structure logic
- [ ] Test CRUD operations

---

## Ghi chu

- Danh muc tai khoan co cau truc phan cap cha-con
- TK me duoc xac dinh tu do dai ma TK
- Bold tu dong = 1 khi co con
- Khong cho xoa TK co con hoac co phat sinh
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (GL route/report shell)
- **Route:** `gl.task.146` hoặc GL report dynamic registry nếu có metadata.
- **Note:** Shell/read-only; process/write không execute khi chưa audit payload.
