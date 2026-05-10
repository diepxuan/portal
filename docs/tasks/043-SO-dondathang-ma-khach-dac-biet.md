# Task 043: SOND51dmqdadhd

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang quan ly quyet dinh ap dung hoa don tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SOND51dmqdadhd.dll
- **Chuc nang:** Quan ly quyet dinh ap dung hoa don (Ma khach hang dac biet)
- **Loai:** Danh muc (DM)
- **Assembly Title:** SOQDIHD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** QD (quyet dinh hoa don)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51dmqdadhd.dll/README.md`

---

## Cau truc du lieu

### Bang: DMQDADHD (Danh muc quyet dinh ap dung hoa don)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_qd | varchar | 50 | Ma quyet dinh (khoa chinh) |
| ngay_qd | datetime | 8 | Ngay quyet dinh |
| ngay_ad | datetime | 8 | Ngay ap dung |
| ngay_hl | datetime | 8 | Ngay hieu luc |
| ten_cty | nvarchar | 200 | Ten cong ty |
| dangky_kd | varchar | 50 | So dang ky kinh doanh |
| giam_doc | nvarchar | 100 | Giam doc |
| ma_bp | varchar | 20 | Ma bo phan de nghi |
| ten_bp | nvarchar | 100 | Ten bo phan |
| cq_thue | nvarchar | 200 | Co quan thue quan ly |
| ht_tb | nvarchar | 200 | He thong thiet bi |
| ncc | nvarchar | 200 | Nha cung cap dich vu ky thuat |
| hdmd | nvarchar | 500 | Hoa don muc dich su dung |
| tnbp | nvarchar | 500 | Trach nhiem bo phan |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | Lookup cq_thue, ht_tb |
| DMBP | Danh muc bo phan | FK ma_bp -> DMBP.ma_bp |

---

## Form classes

### 1. frmSOND51dmqdadhd (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach quyet dinh, tim kiem, phan trang
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem theo ma/ten |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmSOND51dmqdadhdEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin quyet dinh ap dung hoa don
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_qd | AsTextBox | ma_qd | Ma quyet dinh (AutoLookup) |
| txtNgay_qd | AsMaskedTextBox | ngay_qd | Ngay quyet dinh (dd/MM/yyyy) |
| txtNgay_ad | AsMaskedTextBox | ngay_ad | Ngay ap dung |
| txtNgay_hl | AsMaskedTextBox | ngay_hl | Ngay hieu luc |
| txtTen_cty | TextBox | ten_cty | Ten cong ty |
| txtDangKy_KD | TextBox | dangky_kd | So dang ky kinh doanh |
| txtGiam_doc | TextBox | giam_doc | Ten giam doc |
| txtMa_bp | AsTextBox | ma_bp | Ma bo phan de nghi (lookup) |
| lblTen_bp | Label | ten_bp | Ten bo phan |
| txtCq_thue | TextBox | cq_thue | Co quan thue quan ly |
| txtHethong_thietbi | TextBox | ht_tb | He thong thiet bi |
| txtNhacungcap_dv | TextBox | ncc | Nha cung cap dich vu |
| txtHoadon_mucdich | TextBox | hdmd | Cac loai hoa don va muc dich su dung (multiline) |
| txtTrachnhiem_bp | TextBox | tnbp | Trach nhiem cac bo phan (multiline) |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_QDADHD_GET | Lay danh sach quyet dinh |
| SP_SO_QDADHD_GETBYID | Lay chi tiet 1 quyet dinh |
| SP_SO_QDADHD_INSERT | Them quyet dinh moi |
| SP_SO_QDADHD_UPDATE | Cap nhat quyet dinh |
| SP_SO_QDADHD_DELETE | Xoa quyet dinh |
| SP_SO_QDADHD_FIND | Tim kiem quyet dinh |
| SP_SO_QDADHD_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach quyet dinh ap dung hoa don
EXEC SP_SO_QDADHD_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_GETBYID (reference)

```sql
-- Lay chi tiet 1 quyet dinh
EXEC SP_SO_QDADHD_GETBYID
    @pMa_cty VARCHAR(50) = '001',
    @pMa_qd VARCHAR(50)
```

### SP_INSERT (reference)

```sql
-- Them quyet dinh moi
EXEC SP_SO_QDADHD_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_qd VARCHAR(50),
    @pNgay_qd DATETIME,
    @pNgay_ad DATETIME,
    @pNgay_hl DATETIME,
    @pTen_cty NVARCHAR(200),
    @pDangky_kd VARCHAR(50),
    @pGiam_doc NVARCHAR(100),
    @pMa_bp VARCHAR(20),
    @pTen_bp NVARCHAR(100),
    @pCq_thue NVARCHAR(200),
    @pHt_tb NVARCHAR(200),
    @pNcc NVARCHAR(200),
    @pHdmd NVARCHAR(500),
    @pTnbp NVARCHAR(500),
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_qd | 'Ma quyet dinh khong duoc trong' |
| Required | ngay_qd | 'Ngay quyet dinh khong duoc trong' |
| Required | ngay_ad | 'Ngay ap dung khong duoc trong' |
| Required | ngay_hl | 'Ngay hieu luc khong duoc trong' |
| Required | ten_cty | 'Ten cong ty khong duoc trong' |
| Required | dangky_kd | 'So dang ky kinh doanh khong duoc trong' |
| Required | giam_doc | 'Giam doc khong duoc trong' |
| Required | ma_bp | 'Ma bo phan de nghi khong duoc trong' |
| Required | cq_thue | 'Co quan thue khong duoc trong' |
| Required | ht_tb | 'He thong thiet bi khong duoc trong' |
| Date valid | ngay_ad | 'Ngay ap dung phai >= ngay quyet dinh' |
| Date valid | ngay_hl | 'Ngay hieu luc phai >= ngay ap dung' |

### Business Rules

1. **Quy trinh lap quyet dinh**:
   - Nhap thong tin quyet dinh tu co quan thue
   - Ngay quyet dinh -> Ngay ap dung -> Ngay hieu luc (tang dan)

2. **Thong tin cong ty**:
   - Tu dong dien thong tin cong ty tu CompanyInformations
   - So DKKD, Giam doc lay tu thong tin mac dinh

3. **Bo phan de nghi**:
   - Lookup tu bang DMBP
   - Tu dong hien thi ten bo phan

4. **Khoa su dung (ksd)**:
   - Mac dinh = 0 (hoat dong)
   - Khi ksd = 1, quyet dinh khong hien thi trong danh sach chon

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMQDADHD.php
namespace Diepxuan\Simba\Models\SO;

class DMQDADHD extends Model
{
    protected $table = 'DMQDADHD';
    protected $primaryKey = 'ma_qd';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_qd', 'ngay_qd', 'ngay_ad', 'ngay_hl',
        'ten_cty', 'dangky_kd', 'giam_doc',
        'ma_bp', 'ten_bp', 'cq_thue',
        'ht_tb', 'ncc', 'hdmd', 'tnbp', 'ksd',
    ];

    protected $casts = [
        'ngay_qd' => 'date',
        'ngay_ad' => 'date',
        'ngay_hl' => 'date',
        'ksd' => 'boolean',
    ];

    // Relationships
    public function boPhan()
    {
        return $this->belongsTo(DMBP::class, 'ma_bp', 'ma_bp');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_qd', 'like', "%{$search}%")
              ->orWhere('ten_cty', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/SoGetDMQDADHD.php
namespace Diepxuan\Simba\StoredProcedures;

class SoGetDMQDADHD extends StoredProcedure
{
    protected $procedure = 'SP_SO_QDADHD_GET';
    protected $params = [
        'pMa_cty',
        'pSearch',
        'pPageIndex',
        'pPageSize',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoInsDMQDADHD.php
class SoInsDMQDADHD extends StoredProcedure
{
    protected $procedure = 'SP_SO_QDADHD_INSERT';
    protected $params = [
        'pMa_cty', 'ma_qd', 'ngay_qd', 'ngay_ad', 'ngay_hl',
        'ten_cty', 'dangky_kd', 'giam_doc',
        'ma_bp', 'ten_bp', 'cq_thue', 'ht_tb',
        'ncc', 'hdmd', 'tnbp', 'ksd',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/SoUpdDMQDADHD.php
// diepxuan/laravel-simba/src/StoredProcedures/SoDelDMQDADHD.php
// diepxuan/laravel-simba/src/StoredProcedures/SoChkDMQDADHD.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Quyetdinhhoadon.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Quyetdinhhoadon extends Component
{
    const MA_CT = 'QD';

    public Collection $pQuyetDinhs;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingMaQd = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadQuyetDinh();
    }

    public function loadQuyetDinh(): void
    {
        // Load tu Stored Procedure
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.quyetdinhhoadon');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/QuyetdinhhoadonEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class QuyetdinhhoadonEdit extends Component
{
    public ?string $pMa_Qd = null;
    public ?string $pNgay_Qd = null;
    public ?string $pNgay_Ad = null;
    public ?string $pNgay_Hl = null;
    public string $pTen_Cty = '';
    public string $pDangKy_Kd = '';
    public string $pGiam_Doc = '';
    public string $pMa_Bp = '';
    public string $pTen_Bp = '';
    public string $pCq_Thue = '';
    public string $pHt_Tb = '';
    public string $pNcc = '';
    public string $pHdmd = '';
    public string $pTnbp = '';
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Qd' => 'required|string|max:50',
        'pNgay_Qd' => 'required|date',
        'pNgay_Ad' => 'required|date|after_or_equal:pNgay_Qd',
        'pNgay_Hl' => 'required|date|after_or_equal:pNgay_Ad',
        'pTen_Cty' => 'required|string|max:200',
        'pDangKy_Kd' => 'required|string|max:50',
        'pGiam_Doc' => 'required|string|max:100',
        'pMa_Bp' => 'required|string|max:20',
        'pCq_Thue' => 'required|string|max:200',
        'pHt_Tb' => 'required|string|max:200',
    ];

    public function mount(?string $maQd = null): void
    {
        if ($maQd) {
            $this->pMa_Qd = $maQd;
            $this->loadQuyetDinh();
        }
    }

    public function updatedPMaBp($value): void
    {
        // Lookup ten bo phan
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.quyetdinhhoadon-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/danhmuc/
├── quyetdinhhoadon.blade.php        (List page)
├── quyetdinhhoadon-edit.blade.php   (Modal edit)
└── _quyetdinhhoadon-row.blade.php   (Component row)
```

### 6. Routes

```php
// routes/catalog.php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/quyet-dinh-hoa-don', [Quyetdinhhoadon::class, 'render'])
            ->name('quyetdinhhoadon');
        Route::get('/quyet-dinh-hoa-don/edit/{maQd?}', [QuyetdinhhoadonEdit::class, 'render'])
            ->name('quyetdinhhoadon.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMQDADHD.php | Chinh |
| Model | laravel-simba | DMBP.php | Lien quan (FK) |
| SP | laravel-simba | SoGetDMQDADHD.php | Chinh |
| SP | laravel-simba | SoInsDMQDADHD.php | Insert |
| SP | laravel-simba | SoUpdDMQDADHD.php | Update |
| SP | laravel-simba | SoDelDMQDADHD.php | Delete |
| SP | laravel-simba | SoChkDMQDADHD.php | Check trung |
| Component | laravel-catalog | Quyetdinhhoadon.php | List |
| Component | laravel-catalog | QuyetdinhhoadonEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model DMQDADHD
- [ ] Tao Livewire Quyetdinhhoadon (list)
- [ ] Tao Livewire QuyetdinhhoadonEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMKH
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
