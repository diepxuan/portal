# Task 063: PODMCP

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang danh muc chuong trinh mua hang tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** PODMCP.dll
- **Chuc nang:** Danh muc chuong trinh mua hang
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc chuong trinh mua hang
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PODMCP (danh muc PO)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PODMCP.dll/README.md`

---

## Cau truc du lieu

### Bang: DMCPMH (Danh muc chuong trinh mua hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_cp | varchar | 50 | Ma chuong trinh (khoa chinh) |
| ten_cp | nvarchar | 200 | Ten chuong trinh |
| tt_pb | nvarchar | 500 | Thong tin phan bo |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| POMHCT | Chi tiet chuong trinh mua | FK ma_cp -> DMCPMH.ma_cp |
| POMHRp* | Bao cao | Lookup ma_cp |

---

## Form classes

### 1. frmPODMCP (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach chuong trinh mua hang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma/ten |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmPODMCPEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin chuong trinh mua hang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_cp | AsTextBox | ma_cp | Ma chuong trinh (AutoLookup) |
| txtTen_cp | TextBox | ten_cp | Ten chuong trinh |
| cbott_pb | TextBox | tt_pb | Thong tin phan bo |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_DMCP_GET | Lay danh sach chuong trinh mua |
| SP_PO_DMCP_GETBYID | Lay chi tiet 1 chuong trinh |
| SP_PO_DMCP_INSERT | Them chuong trinh moi |
| SP_PO_DMCP_UPDATE | Cap nhat chuong trinh |
| SP_PO_DMCP_DELETE | Xoa chuong trinh |
| SP_PO_DMCP_FIND | Tim kiem chuong trinh |
| SP_PO_DMCP_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach chuong trinh mua
EXEC SP_PO_DMCP_GET
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
| Required | ma_cp | 'Ma chuong trinh khong duoc trong' |
| Max length 50 | ma_cp | 'Ma chuong trinh toi da 50 ky tu' |
| Unique | ma_cp | 'Ma chuong trinh da ton tai' |
| Required | ten_cp | 'Ten chuong trinh khong duoc trong' |
| Max length 200 | ten_cp | 'Ten chuong trinh toi da 200 ky tu' |

### Business Rules

1. **Ma chuong trinh**:
   - AutoGenerate neu de trong (CP + stt_rec)
   - Khong cho phep sua khi da co chi tiet

2. **Ten chuong trinh**:
   - Bat buoc nhap
   - Khong phan biet hoa/thuong

3. **Khoa su dung (ksd)**:
   - Mac dinh = 0 (hoat dong)

4. **Xoa chuong trinh**:
   - Kiem tra khong co chi tiet lien quan

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/DMCPMH.php
namespace Diepxuan\Simba\Models\PO;

class DMCPMH extends Model
{
    protected $table = 'DMCPMH';
    protected $primaryKey = 'ma_cp';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cp',
        'ten_cp',
        'tt_pb',
        'ksd',
    ];

    protected $casts = [
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
            $q->where('ma_cp', 'like', "%{$search}%")
              ->orWhere('ten_cp', 'like', "%{$search}%");
        });
    }
}
```

### 2. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Danhmuc/Chuongtrinhmh.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Danhmuc;

class Chuongtrinhmh extends Component
{
    const MA_CT = 'PODMCP';

    public Collection $pDanhSach;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    public function render(): View
    {
        return view('catalog::po.danhmuc.chuongtrinhmh');
    }
}
```

### 3. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Danhmuc/ChuongtrinhmhEdit.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Danhmuc;

class ChuongtrinhmhEdit extends Component
{
    public ?string $pMa_cp = null;
    public string $pTen_cp = '';
    public string $pTt_pb = '';
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_cp' => 'required|string|max:50|unique:DMCPMH,ma_cp',
        'pTen_cp' => 'required|string|max:200',
    ];

    public function render(): View
    {
        return view('catalog::po.danhmuc.chuongtrinhmh-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/po/danhmuc/
├── chuongtrinhmh.blade.php
├── chuongtrinhmh-edit.blade.php
└── _chuongtrinhmh-row.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/po/danhmuc')
    ->name('catalog.po.danhmuc.')
    ->group(function () {
        Route::get('/chuong-trinh-mh', [Chuongtrinhmh::class, 'render'])
            ->name('chuongtrinhmh');
        Route::get('/chuong-trinh-mh/edit/{ma_cp?}', [ChuongtrinhmhEdit::class, 'render'])
            ->name('chuongtrinhmh.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMCPMH.php | Chinh |
| Component | laravel-catalog | Chuongtrinhmh.php | List |
| Component | laravel-catalog | ChuongtrinhmhEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMCPMH
- [ ] Tao Livewire Chuongtrinhmh (list)
- [ ] Tao Livewire ChuongtrinhmhEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi PO modules
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
