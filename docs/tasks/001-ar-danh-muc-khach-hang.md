# Task 001: ARDMKH

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang danh muc khach hang tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** ARDMKH.dll
- **Chuc nang:** Quan ly danh muc khach hang
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (danh muc AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARDMKH.dll/README.md`

---

## Cau truc du lieu

### Bang: DMKH (Danh muc khach hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_kh | varchar | 50 | Ma khach hang (khoa chinh) |
| ten_kh | nvarchar | 200 | Ten khach hang |
| dia_chi | nvarchar | 500 | Dia chi |
| ma_so_thue | varchar | 50 | Ma so thue |
| dien_thoai | varchar | 50 | Dien thoai |
| fax | varchar | 50 | Fax |
| email | varchar | 100 | Email |
| ma_nt | varchar | 10 | Ma ngoai te mac dinh |
| tk_cn | varchar | 20 | Tai khoan cong no |
| ma_plkh1 | varchar | 50 | Phan loai KH 1 |
| ma_plkh2 | varchar | 50 | Phan loai KH 2 |
| ma_plkh3 | varchar | 50 | Phan loai KH 3 |
| ma_nhkh | varchar | 50 | Ma nhom khach hang |
| isKh | bit | 1 | La khach hang |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMNHKH | Danh muc nhom KH | FK ma_nhkh -> DMNHKH.ma_nhkh |
| DMPLKH | Danh muc phan loai KH | FK ma_plkh1/2/3 -> DMPLKH.ma_plkh |
| ARTT | So du dau ky | FK ma_kh -> ARTT.ma_kh |
| ARRptBCCN* | Cac bao cao cong no | Lookup ma_kh |

---

## Form classes

### 1. frmARDMKH (Form xem danh sach)
- **Ke thua:** frmDmView
- **Chuc nang:** Hien thi danh sach khach hang, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma/ten |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmARDMKHEdit (Form them/sua)
- **Ke thua:** frmDmEdit
- **Chuc nang:** Nhap, sua thong tin khach hang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang (AutoLookup) |
| txtTen_Kh | TextBox | ten_kh | Ten khach hang |
| txtDia_Chi | TextBox | dia_chi | Dia chi |
| txtMa_So_Thue | TextBox | ma_so_thue | Ma so thue |
| txtDien_Thoai | TextBox | dien_thoai | Dien thoai |
| txtFax | TextBox | fax | Fax |
| txtEmail | TextBox | email | Email |
| cboMa_Nt | AsComboBoxNT | ma_nt | Ngoai te |
| txtTk_Cn | AsTextBox | tk_cn | Tai khoan cong no (AutoLookup) |
| txtMa_PlKh1 | AsTextBox | ma_plkh1 | Phan loai KH 1 (AutoLookup) |
| txtMa_PlKh2 | AsTextBox | ma_plkh2 | Phan loai KH 2 (AutoLookup) |
| txtMa_PlKh3 | AsTextBox | ma_plkh3 | Phan loai KH 3 (AutoLookup) |
| txtMa_NhKh | AsTextBox | ma_nhkh | Nhom khach hang (AutoLookup) |
| chkIsKh | AsCheckBox | isKh | La khach hang |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_DMKH_GET | Lay danh sach khach hang |
| SP_AR_DMKH_GETBYID | Lay chi tiet 1 khach hang |
| SP_AR_DMKH_INSERT | Them khach hang moi |
| SP_AR_DMKH_UPDATE | Cap nhat khach hang |
| SP_AR_DMKH_DELETE | Xoa khach hang |
| SP_AR_DMKH_FIND | Tim kiem khach hang |
| SP_AR_DMKH_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach khach hang
EXEC SP_AR_DMKH_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
-- Lay chi tiet 1 khach hang
EXEC SP_AR_DMKH_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50)
```

### SP_INSERT (reference)

```sql
-- Them khach hang moi
EXEC SP_AR_DMKH_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_kh VARCHAR(50),
    @pTen_kh NVARCHAR(200),
    @pDia_chi NVARCHAR(500),
    @pMa_so_thue VARCHAR(50),
    @pDien_thoai VARCHAR(50),
    @pFax VARCHAR(50),
    @pEmail VARCHAR(100),
    @pMa_nt VARCHAR(10),
    @pTk_cn VARCHAR(20),
    @pMa_plkh1 VARCHAR(50),
    @pMa_plkh2 VARCHAR(50),
    @pMa_plkh3 VARCHAR(50),
    @pMa_nhkh VARCHAR(50),
    @pIsKh BIT = 1,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Max length 50 | ma_kh | 'Ma khach hang toi da 50 ky tu' |
| Unique | ma_kh | 'Ma khach hang da ton tai' |
| Required | ten_kh | 'Ten khach hang khong duoc trong' |
| Max length 200 | ten_kh | 'Ten khach hang toi da 200 ky tu' |
| Email format | email | 'Email khong dung dinh dang' |
| Max length 500 | dia_chi | 'Dia chi toi da 500 ky tu' |

### Business Rules

1. **Ma khach hang**:
   - AutoGenerate neu de trong (AR + stt_rec)
   - Khong cho phep sua khi da co giao dich

2. **Ten khach hang**:
   - Bat buoc nhap
   - Khong phan biet hoa/thuong

3. **Tai khoan cong no**:
   - AutoLookup tu danh muc tai khoan (dk_cn=1)
   - Hien thi ten tai khoan

4. **Phan loai KH**:
   - AutoLookup tu DMPLKH voi loai tuong ung (1, 2, 3)

5. **Nhom khach hang**:
   - AutoLookup tu DMNHKH
   - Hien thi ten nhom

6. **Xoa khach hang**:
   - Kiem tra khong co giao dich lien quan
   - Neu co giao dich -> khong cho xoa

### Lookup Integration

- Tu DMNHKH: Chon nhom KH
- Tu DMPLKH: Chon phan loai KH (loai 1, 2, 3)
- Tu DSTK: Chon tai khoan cong no (tk_cn=1)

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/DMKH.php
namespace Diepxuan\Simba\Models\AR;

class DMKH extends Model
{
    protected $table = 'DMKH';
    protected $primaryKey = 'ma_kh';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_kh',
        'ten_kh',
        'dia_chi',
        'ma_so_thue',
        'dien_thoai',
        'fax',
        'email',
        'ma_nt',
        'tk_cn',
        'ma_plkh1',
        'ma_plkh2',
        'ma_plkh3',
        'ma_nhkh',
        'isKh',
    ];

    protected $casts = [
        'isKh' => 'boolean',
    ];

    // Relationships
    public function nhomKhachHang()
    {
        return $this->belongsTo(DMNHKH::class, 'ma_nhkh', 'ma_nhkh');
    }

    public function phanLoaiKhachHang1()
    {
        return $this->belongsTo(DMPLKH::class, 'ma_plkh1', 'ma_plkh');
    }

    public function phanLoaiKhachHang2()
    {
        return $this->belongsTo(DMPLKH::class, 'ma_plkh2', 'ma_plkh');
    }

    public function phanLoaiKhachHang3()
    {
        return $this->belongsTo(DMPLKH::class, 'ma_plkh3', 'ma_plkh');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('isKh', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_kh', 'like', "%{$search}%")
              ->orWhere('ten_kh', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetDMKH.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetDMKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_DMKH_GET';
    protected $params = [
        'pMa_cty',
        'pSearch',
        'pPageIndex',
        'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARInsDMKH.php
class AsARInsDMKH extends StoredProcedure
{
    protected $procedure = 'SP_AR_DMKH_INSERT';
    protected $params = [
        'pMa_cty',
        'ma_kh',
        'ten_kh',
        'dia_chi',
        'ma_so_thue',
        'dien_thoai',
        'fax',
        'email',
        'ma_nt',
        'tk_cn',
        'ma_plkh1',
        'ma_plkh2',
        'ma_plkh3',
        'ma_nhkh',
        'isKh',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARUpdDMKH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARDelDMKH.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARChkDMKH.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Danhmuc/Khachhang.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Danhmuc;

class Khachhang extends Component
{
    const MA_CT = 'AR';

    public Collection $pKhachHangs;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaKh = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadKhachHang();
    }

    public function loadKhachHang(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::ar.danhmuc.khachhang');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Danhmuc/KhachhangEdit.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Danhmuc;

class KhachhangEdit extends Component
{
    public ?string $pMa_Kh = null;
    public string $pTen_Kh = '';
    public string $pDia_Chi = '';
    public string $pMa_So_Thue = '';
    public string $pDien_Thoai = '';
    public string $pFax = '';
    public string $pEmail = '';
    public string $pMa_Nt = 'VND';
    public ?string $pTk_Cn = null;
    public ?string $pMa_PlKh1 = null;
    public ?string $pMa_PlKh2 = null;
    public ?string $pMa_PlKh3 = null;
    public ?string $pMa_NhKh = null;
    public bool $pIsKh = true;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Kh' => 'required|string|max:50|unique:DMKH,ma_kh',
        'pTen_Kh' => 'required|string|max:200',
        'pEmail' => 'nullable|email|max:100',
    ];

    protected $messages = [
        'pMa_Kh.required' => 'Ma khach hang khong duoc trong',
        'pMa_Kh.unique' => 'Ma khach hang da ton tai',
        'pTen_Kh.required' => 'Ten khach hang khong duoc trong',
    ];

    public function mount(?string $maKh = null): void
    {
        if ($maKh) {
            $this->pMa_Kh = $maKh;
            $this->loadKhachHang();
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::ar.danhmuc.khachhang-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/ar/danhmuc/
├── khachhang.blade.php           (List page)
├── khachhang-edit.blade.php      (Modal edit)
└── _khachhang-row.blade.php      (Component row)
```

### 6. Routes

```php
// routes/web.php hoac routes/catalog.php
Route::prefix('catalog/ar/danhmuc')
    ->name('catalog.ar.danhmuc.')
    ->group(function () {
        Route::get('/khach-hang', [Khachhang::class, 'render'])
            ->name('khachhang');
        Route::get('/khach-hang/edit/{maKh?}', [KhachhangEdit::class, 'render'])
            ->name('khachhang.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKH.php | Chinh |
| Model | laravel-simba | DMNHKH.php | Lien quan (FK) |
| Model | laravel-simba | DMPLKH.php | Lien quan (FK) |
| SP | laravel-simba | AsARGetDMKH.php | Chinh |
| SP | laravel-simba | AsARInsDMKH.php | Insert |
| SP | laravel-simba | AsARUpdDMKH.php | Update |
| SP | laravel-simba | AsARDelDMKH.php | Delete |
| SP | laravel-simba | AsARChkDMKH.php | Check trung |
| Component | laravel-catalog | Khachhang.php | List |
| Component | laravel-catalog | KhachhangEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMKH
- [ ] Tao Livewire Khachhang (list)
- [ ] Tao Livewire KhachhangEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMNHKH, DMPLKH