# Task 147: GLCDTK

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang So du dau ky tai khoan tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLCDTK.dll
- **Chuc nang:** Quan ly so du dau ky cac tai khoan (Opening Balance)
- **Loai:** Voucher (Chung tu - Nhap so du)
- **Assembly Title:** So du dau ky cac tai khoan
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** GL (General Ledger)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLCDTK.dll/README.md`

---

## Cau truc du lieu

### Bang: CDTK (Cong no tai khoan - So du dau ky)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| tk | varchar | 50 | Ma tai khoan (khoa chinh) |
| thang | int | 4 | Thang nhap so du |
| nam | int | 4 | Nam nhap so du |
| du_no00 | decimal(18,2) | - | Du no dau nam |
| du_co00 | decimal(18,2) | - | Du co dau nam |
| du_no_nt00 | decimal(18,2) | - | Du no NT dau nam |
| du_co_nt00 | decimal(18,2) | - | Du co NT dau nam |
| du_no | decimal(18,2) | - | Du no dau ky |
| du_co | decimal(18,2) | - | Du co dau ky |
| du_no_nt | decimal(18,2) | - | Du no NT dau ky |
| du_co_nt | decimal(18,2) | - | Du co NT dau ky |
| tk_cn | bit | 1 | Tai khoan cong no |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | FK tk -> DMTAIKHOAN.tk |

---

## Form classes

### 1. frmGLCDTK (Form xem danh sach)
- **Ke thua:** frmOBView (Opening Balance View)
- **Chuc nang:** Hien thi danh sach so du dau ky, loc theo thang/nam
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvCDTK | DataGridView | - | Luoi hien thi so du |
| cboThang | ComboBox | thang | Chon thang (1-12) |
| cboNam | ComboBox | nam | Chon nam |
| btnTinhTong | Button | - | Nut tinh tong |
| btnFilterTk | Button | - | Nut loc tai khoan |

### 2. frmGLCDTKEdit (Form nhap so du)
- **Ke thua:** frmOBEdit (Opening Balance Edit)
- **Chuc nang:** Nhap so du dau ky cho tai khoan
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTk | AsTextBox | tk | Tai khoan (Lookup: TK) |
| lblTen_Tk | Label | - | Hien thi ten tai khoan |
| txtDu_No | AsTextNumeric | du_no | Du no VND |
| txtDu_Co | AsTextNumeric | du_co | Du co VND |
| txtDu_No_Nt | AsTextNumeric | du_no_nt | Du no ngoai te |
| txtDu_Co_Nt | AsTextNumeric | du_co_nt | Du co ngoai te |

### 3. frmGLCDTKFilter (Form chon ky)
- **Chuc nang:** Chon thang/nam nhap so du

### 4. frmGLSdDkTk (Form tinh tong)
- **Chuc nang:** Tinh tong so du theo nhom tai khoan

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_CDTK_GET | Lay danh sach so du dau ky |
| SP_GL_CDTK_GETBYID | Lay chi tiet 1 tai khoan |
| SP_GL_CDTK_INSERT | Nhap so du moi |
| SP_GL_CDTK_UPDATE | Cap nhat so du |
| SP_GL_CDTK_DELETE | Xoa so du |
| SP_GL_CDTK_FIND | Tim kiem so du |
| SP_GL_CDTK_CHECK | Kiem tra trung |
| SP_GL_CDTK_CALC_SUM | Tinh tong so du (asGLCalSumCdTk) |

### SP_GET (reference)

```sql
-- Lay danh sach so du dau ky
EXEC SP_GL_CDTK_GET
    @pMa_cty VARCHAR(50) = '001',
    @pThang INT,
    @pNam INT,
    @pTk VARCHAR(50) = NULL,
    @pTk_cn BIT = NULL
```

### SP_INSERT (reference)

```sql
-- Nhap so du moi
EXEC SP_GL_CDTK_INSERT
    @pMa_cty VARCHAR(50),
    @pTk VARCHAR(50),
    @pThang INT,
    @pNam INT,
    @pDu_no DECIMAL(18,2) = 0,
    @pDu_co DECIMAL(18,2) = 0,
    @pDu_no_nt DECIMAL(18,2) = 0,
    @pDu_co_nt DECIMAL(18,2) = 0,
    @pTk_cn BIT = 0,
    @pStatus INT OUTPUT
```

### SP_CALC_SUM (reference)

```sql
-- Tinh tong so du
EXEC asGLCalSumCdTk
    @pMa_cty VARCHAR(50),
    @pThang INT,
    @pNam INT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | tk | 'Tai khoan khong duoc trong' |
| Required | thang | 'Thang khong duoc trong' |
| Required | nam | 'Nam khong duoc trong' |
| Range | thang | 'Thang phai tu 1 den 12' |
| Range | nam | 'Nam khong hop le' |

### Business Rules

1. **So du dau ky vs dau nam**:
   - Dau nam: du_no00, du_co00 (so du nam truoc)
   - Dau ky: du_no, du_co (so du thang hien tai)
   - Neu thang = 1 thi dau ky = dau nam

2. **Ngoai te**:
   - Dau nam: du_no_nt00, du_co_nt00
   - Dau ky: du_no_nt, du_co_nt

3. **Tai khoan cong no**:
   - TK co tk_cn = 1 moi duoc nhap so du
   - Chi nhap so du mot lan cho mot tai khoan

4. **Kiem tra khoa so**:
   - Khong cho phep sua so du thang da khoa
   - Canh bao neu nhap truoc ky khoa

5. **Tinh tong**:
   - Tong du no = Sum(du_no) theo nhom
   - Tong du co = Sum(du_co) theo nhom
   - Goi asGLCalSumCdTk

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/CDTK.php
namespace Diepxuan\Simba\Models\GL;

class CDTK extends Model
{
    protected $table = 'CDTK';
    protected $primaryKey = ['tk', 'thang', 'nam'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'tk',
        'thang',
        'nam',
        'du_no00',
        'du_co00',
        'du_no_nt00',
        'du_co_nt00',
        'du_no',
        'du_co',
        'du_no_nt',
        'du_co_nt',
        'tk_cn',
    ];

    protected $casts = [
        'thang' => 'integer',
        'nam' => 'integer',
        'du_no00' => 'decimal:2',
        'du_co00' => 'decimal:2',
        'du_no_nt00' => 'decimal:2',
        'du_co_nt00' => 'decimal:2',
        'du_no' => 'decimal:2',
        'du_co' => 'decimal:2',
        'du_no_nt' => 'decimal:2',
        'du_co_nt' => 'decimal:2',
        'tk_cn' => 'boolean',
    ];

    // Relationships
    public function taiKhoan()
    {
        return $this->belongsTo(DMTAIKHOAN::class, 'tk', 'tk');
    }

    // Scopes
    public function scopeByPeriod($query, int $thang, int $nam)
    {
        return $query->where('thang', $thang)->where('nam', $nam);
    }

    public function scopeCongNo($query)
    {
        return $query->where('tk_cn', true);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLGetCDTK.php
namespace Diepxuan\Simba\StoredProcedures;

class AsGLGetCDTK extends StoredProcedure
{
    protected $procedure = 'SP_GL_CDTK_GET';
    protected $params = [
        'pMa_cty',
        'pThang',
        'pNam',
        'pTk',
        'pTk_cn',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGLInsCDTK.php
class AsGLInsCDTK extends StoredProcedure
{
    protected $procedure = 'SP_GL_CDTK_INSERT';
    protected $params = [
        'pMa_cty',
        'tk',
        'thang',
        'nam',
        'du_no',
        'du_co',
        'du_no_nt',
        'du_co_nt',
        'tk_cn',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGLCalSumCDTK.php
class AsGLCalSumCDTK extends StoredProcedure
{
    protected $procedure = 'asGLCalSumCdTk';
    protected $params = [
        'pMa_cty',
        'thang',
        'nam',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGLUpdCDTK.php
// diepxuan/laravel-simba/src/StoredProcedures/AsGLDelCDTK.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Danhmuc/SoduDauky.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Danhmuc;

class SoduDauky extends Component
{
    const MA_CT = 'GL';

    public Collection $pSoDus;
    public int $pThang;
    public int $pNam;
    public ?string $pTk = null;

    public function mount(): void
    {
        $now = now();
        $this->pThang = $now->month;
        $this->pNam = $now->year;
        $this->loadSoDu();
    }

    public function loadSoDu(): void
    {
        // Load tu Stored Procedure
    }

    public function calculateSum(): void
    {
        // Goi SP_CALC_SUM de tinh tong
    }

    public function render(): View
    {
        return view('catalog::gl.danhmuc.sodu-dauky');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Danhmuc/SoduDaukyEdit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Danhmuc;

class SoduDaukyEdit extends Component
{
    public ?string $pTk = null;
    public string $pTenTk = '';
    public int $pThang;
    public int $pNam;
    public string $pDuNo = '0';
    public string $pDuCo = '0';
    public string $pDuNoNt = '0';
    public string $pDuCoNt = '0';

    protected $rules = [
        'pTk' => 'required|string|max:50|exists:DMTAIKHOAN,tk',
        'pThang' => 'required|integer|between:1,12',
        'pNam' => 'required|integer|min:2000',
        'pDuNo' => 'nullable|numeric',
        'pDuCo' => 'nullable|numeric',
    ];

    public function mount(int $thang, int $nam, ?string $tk = null): void
    {
        $this->pThang = $thang;
        $this->pNam = $nam;
        $this->pTk = $tk;
        if ($tk) {
            $this->loadSoDu();
        }
    }

    public function updatedPTk($value): void
    {
        if ($value) {
            $tk = DMTAIKHOAN::find($value);
            $this->pTenTk = $tk ? $tk->ten_tk : '';
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::gl.danhmuc.sodu-dauky-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/gl/danhmuc/
├── sodu-dauky.blade.php         (List page)
├── sodu-dauky-edit.blade.php   (Modal edit)
└── _sodu-dauky-row.blade.php   (Component row)
```

### 6. Routes

```php
Route::prefix('catalog/gl/danhmuc')
    ->name('catalog.gl.danhmuc.')
    ->group(function () {
        Route::get('/so-du-dau-ky', [SoduDauky::class, 'render'])
            ->name('sodudauky');
        Route::get('/so-du-dau-ky/edit/{thang}/{nam}/{tk?}', [SoduDaukyEdit::class, 'render'])
            ->name('sodudauky.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | CDTK.php | Chinh |
| Model | laravel-simba | DMTAIKHOAN.php | Lien quan (FK) |
| SP | laravel-simba | AsGLGetCDTK.php | Chinh |
| SP | laravel-simba | AsGLInsCDTK.php | Insert |
| SP | laravel-simba | AsGLUpdCDTK.php | Update |
| SP | laravel-simba | AsGLDelCDTK.php | Delete |
| SP | laravel-simba | AsGLCalSumCDTK.php | Tinh tong |
| Component | laravel-catalog | SoduDauky.php | List |
| Component | laravel-catalog | SoduDaukyEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, CalSum)
- [ ] Tao Model CDTK
- [ ] Tao Livewire SoduDauky (list)
- [ ] Tao Livewire SoduDaukyEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Implement VND + NT fields
- [ ] Test CRUD operations

---

## Ghi chu

- So du dau ky chi ap dung cho TK cong no (tk_cn = 1)
- Ho tro nhap VND va ngoai te
- Co 2 loai so du: dau nam va dau ky
- Neu thang = 1 thi dau ky = dau nam
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal Mapping 2026-05-15

- Active Simba menu `02.10.14` da map vao route Portal hien huu `system.balance.account-opening`.
- Route duoc khai bao trong `SimbaRouteRegistry` de menu tree link thang vao man hinh so du thay vi generic process shell.
- CRUD/execute van **blocked**: task nay co SP ghi/xoa/tinh tong (`SP_GL_CDTK_*`, `asGLCalSumCdTk`) nen chua duoc coi la hoan thanh khi khong truy cap SQL Server va chua audit day du side effect/payload.

## Portal implementation status

- **Status:** DONE (GL route/report shell)
- **Route:** `gl.task.147` hoặc GL report dynamic registry nếu có metadata.
- **Note:** Shell/read-only; process/write không execute khi chưa audit payload.
