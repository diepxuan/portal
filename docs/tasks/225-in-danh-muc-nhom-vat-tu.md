# Task 225: INDMNHVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang danh muc nhom vat tu (phan cap) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INDMNHVT.dll
- **Chuc nang:** Quan ly danh muc nhom vat tu (cay phan cap)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc nhom vat tu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMNHVT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNHVT (Danh muc nhom vat tu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_nhvt | varchar | 50 | Ma nhom VT (khoa chinh) |
| ten_nhvt | nvarchar | 200 | Ten nhom VT |
| nhom_me | varchar | 50 | Ma nhom me (phan cap) |
| cap | int | 4 | Cap do trong cay phan cap |
| cong_sl | bit | 1 | Cong so luong (tong hop) |
| tk_vt | varchar | 20 | TK vat tu mac dinh |
| tk_dt | varchar | 20 | TK doanh thu mac dinh |
| tk_dt_nb | varchar | 20 | TK DT noi bo mac dinh |
| tk_gv | varchar | 20 | TK gia von mac dinh |
| tk_tl | varchar | 20 | TK tra lai mac dinh |
| tk_ck | varchar | 20 | TK chiet khau mac dinh |
| ghi_chu | nvarchar | 500 | Ghi chu |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_nhvt -> DMNHVT.ma_nhvt |
| INConfiguration | Cau hinh IN | Lookup default TK |

---

## Form classes

### 1. frmINDMNHVT (Form xem danh sach - cay phan cap)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach nhom VT theo cau truc cay, tim kiem
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma/ten |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |
| treeView | TreeView | - | Cay phan cap nhom VT |

### 2. frmINDMNHVTEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin nhom VT
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_NhVt | AsTextBox | ma_nhvt | Ma nhom VT (AutoLookup) |
| txtTen_NhVt | TextBox | ten_nhvt | Ten nhom VT |
| txtNhom_Me | AsTextBox | nhom_me | Nhom me (phan cap) |
| txtCap | TextBox | cap | Cap do trong cay |
| chkCong_Sl | CheckBox | cong_sl | Cong so luong |
| txtTk_Vt | AsTextBox | tk_vt | TK vat tu mac dinh |
| txtTk_Dt | AsTextBox | tk_dt | TK doanh thu |
| txtTk_DtNb | AsTextBox | tk_dt_nb | TK DT noi bo |
| txtTk_Gv | AsTextBox | tk_gv | TK gia von |
| txtTk_Tl | AsTextBox | tk_tl | TK tra lai |
| txtTk_Ck | AsTextBox | tk_ck | TK chiet khau |
| txtGhi_Chu | TextBox | ghi_chu | Ghi chu |
| chkKsd | CheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_DMNHVT_GET | Lay danh sach nhom VT |
| SP_IN_DMNHVT_GETBYID | Lay chi tiet 1 nhom VT |
| SP_IN_DMNHVT_INSERT | Them nhom VT moi |
| SP_IN_DMNHVT_UPDATE | Cap nhat nhom VT |
| SP_IN_DMNHVT_DELETE | Xoa nhom VT |
| SP_IN_DMNHVT_FIND | Tim kiem nhom VT |
| SP_IN_DMNHVT_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach nhom VT (cay phan cap)
EXEC SP_IN_DMNHVT_GET
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
| Required | ma_nhvt | 'Ma nhom vat tu khong duoc trong' |
| Max length 50 | ma_nhvt | 'Ma nhom vat tu toi da 50 ky tu' |
| Unique | ma_nhvt | 'Ma nhom vat tu da ton tai' |
| Required | ten_nhvt | 'Ten nhom vat tu khong duoc trong' |
| Max length 200 | ten_nhvt | 'Ten nhom vat tu toi da 200 ky tu' |

### Business Rules

1. **Cay phan cap nhom VT**:
   - Nhom me -> Nhom con (nhieu cap)
   - Tu dong tinh cap khi chon nhom me
   - Hien thi cay (TreeView)

2. **Tai khoan mac dinh**:
   - 6 TK mac dinh cho nhom VT (VT, DT, DT NB, GV, TL, CK)
   - Lay tu INConfiguration khi tao moi

3. **Cong so luong (cong_sl)**:
   - Khi = 1: Tong hop so luong tu nhom con
   - Mac dinh = 0

4. **Xoa nhom VT**:
   - Khong cho xoa neu co vat tu thuoc nhom
   - Khong cho xoa neu co nhom con

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/DMNHVT.php
namespace Diepxuan\Simba\Models\IN;

class DMNHVT extends Model
{
    protected $table = 'DMNHVT';
    protected $primaryKey = 'ma_nhvt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nhvt',
        'ten_nhvt',
        'nhom_me',
        'cap',
        'cong_sl',
        'tk_vt',
        'tk_dt',
        'tk_dt_nb',
        'tk_gv',
        'tk_tl',
        'tk_ck',
        'ghi_chu',
        'ksd',
    ];

    protected $casts = [
        'cap' => 'integer',
        'cong_sl' => 'boolean',
        'ksd' => 'boolean',
    ];

    // Relationships
    public function nhomMe()
    {
        return $this->belongsTo(DMNHVT::class, 'nhom_me', 'ma_nhvt');
    }

    public function nhomCons()
    {
        return $this->hasMany(DMNHVT::class, 'nhom_me', 'ma_nhvt');
    }

    public function vatTus()
    {
        return $this->hasMany(DMVT::class, 'ma_nhvt', 'ma_nhvt');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('nhom_me')->orWhere('nhom_me', '');
    }
}
```

### 2. Livewire Component (List - Cay)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/Nhomvattu.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class Nhomvattu extends Component
{
    const MA_CT = 'IN';

    public Collection $pNhomVts;
    public Collection $pTreeData;
    public string $pSearch = '';
    public ?string $pSelectedMaNhvt = null;

    public function loadNhomVT(): void
    {
        // Load tree structure tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::in.danhmuc.nhomvattu');
    }
}
```

### 3. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/NhomvattuEdit.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class NhomvattuEdit extends Component
{
    public ?string $pMa_Nhvt = null;
    public string $pTen_Nhvt = '';
    public ?string $pNhom_Me = null;
    public int $pCap = 0;
    public bool $pCong_Sl = false;
    public string $pTk_Vt = '';
    public string $pTk_Dt = '';
    public string $pTk_DtNb = '';
    public string $pTk_Gv = '';
    public string $pTk_Tl = '';
    public string $pTk_Ck = '';
    public string $pGhi_Chu = '';
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Nhvt' => 'required|string|max:50|unique:DMNHVT,ma_nhvt',
        'pTen_Nhvt' => 'required|string|max:200',
    ];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMNHVT.php | Chinh |
| Model | laravel-simba | DMVT.php | Lien quan (FK) |
| SP | laravel-simba | AsINGetDMNHVT.php | Get |
| SP | laravel-simba | AsINInsDMNHVT.php | Insert |
| SP | laravel-simba | AsINUpdDMNHVT.php | Update |
| SP | laravel-simba | AsINDelDMNHVT.php | Delete |
| Component | laravel-catalog | Nhomvattu.php | List (Tree) |
| Component | laravel-catalog | NhomvattuEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMNHVT
- [ ] Tao Livewire Nhomvattu (tree view)
- [ ] Tao Livewire NhomvattuEdit (modal)
- [ ] Tao Views (tree list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Tree navigation & cap do
