# Task 145: GLMAUBCTCTMV21

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Mau bao cao tai chinh V21 tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLMAUBCTCTMV21.dll
- **Chuc nang:** Quan ly mau bao cao tai chinh V21
- **Loai:** Bieu mau (MAU)
- **Assembly Title:** GLBCTC07V21
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)
- **Template:** BCTC V21 (Thong tu 200/2014/TT-BTC)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLMAUBCTCTMV21.dll/README.md`

---

## Cau truc du lieu

### Bang: MAUBCTCMV21 (Mau bao cao tai chinh V21)

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

### 1. frmGLMAUBCTCTMV21 (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chi tieu V21, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma_so/chi_tieu |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmGLMAUBCTCTMV21Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin chi tieu V21
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu (AutoComplete, Uppercase) |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu (Multiline) |
| txtCach_tinh | TextBox | cach_tinh | Cong thuc tinh toan |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (Lookup: TK) |
| lblTK | Label | - | Hien thi ten tai khoan |
| txtMauQD | TextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_MAU_BCTC_V21_GET | Lay danh sach chi tieu V21 |
| SP_GL_MAU_BCTC_V21_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_MAU_BCTC_V21_INSERT | Them chi tieu moi |
| SP_GL_MAU_BCTC_V21_UPDATE | Cap nhat chi tieu |
| SP_GL_MAU_BCTC_V21_DELETE | Xoa chi tieu |
| SP_GL_MAU_BCTC_V21_FIND | Tim kiem chi tieu |
| SP_GL_MAU_BCTC_V21_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach chi tieu V21
EXEC SP_GL_MAU_BCTC_V21_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMau VARCHAR(50) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
-- Them chi tieu moi
EXEC SP_GL_MAU_BCTC_V21_INSERT
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

### Business Rules

1. **Ma chi tieu**:
   - Uppercase tu dong
   - AutoComplete tu danh sach
   - Khong cho phep trung trong cung mau

2. **Cong thuc**:
   - Su dung truong "cach_tinh"
   - Co the tham chieu cac tai khoan khac

3. **Mau quyet dinh**:
   - Mac dinh lay tu CompanyInformations.Qd_cdkt
   - Neu de trong thi tu dong gan

4. **Tai khoan**:
   - Lookup tu DMTAIKHOAN
   - Chi 1 tai khoan (tk_01)

5. **Tuy chon in**:
   - IsPrint: Mac dinh = true khi them moi
   - IsItalic: Mac dinh = false
   - Bold: Mac dinh = false

### So sanh voi V20C

| Dac diem | V20C | V21 |
|----------|------|-----|
| So TK | 2 TK (tk_01, tk_02) | 1 TK |
| Loai PS | Co combo | Khong co |
| Do phuc tap | Cao | Don gian |

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/MAUBCTCMV21.php
namespace Diepxuan\Simba\Models\GL;

class MAUBCTCMV21 extends Model
{
    protected $table = 'MAUBCTC_V21';
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
}
```

### 2. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV21.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV21 extends Component
{
    const MA_CT = 'GL';

    public Collection $pChiTieus;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    public function render(): View
    {
        return view('catalog::gl.bieumau.bctcmv21');
    }
}
```

### 3. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV21Edit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV21Edit extends Component
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

    protected $rules = [
        'pMaSo' => 'required|string|max:50',
        'pChiTieu' => 'required|string|max:200',
    ];

    public function render(): View
    {
        return view('catalog::gl.bieumau.bctcmv21-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/gl/bieumau/
├── bctcmv21.blade.php         (List page)
├── bctcmv21-edit.blade.php    (Modal edit)
```

### 5. Routes

```php
Route::prefix('catalog/gl/bieumau')
    ->name('catalog.gl.bieumau.')
    ->group(function () {
        Route::get('/bctcmv21', [BCTCMV21::class, 'render'])->name('bctcmv21');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | MAUBCTCMV21.php | Chinh |
| Model | laravel-simba | DMTAIKHOAN.php | Lien quan (FK) |
| Component | laravel-catalog | BCTCMV21.php | List |
| Component | laravel-catalog | BCTCMV21Edit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes
- [ ] Tao Model MAUBCTCMV21
- [ ] Tao Livewire BCTCMV21 (list)
- [ ] Tao Livewire BCTCMV21Edit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTAIKHOAN

---

## Ghi chu

- Mau BCTC V21 la mau bao cao tai chinh don gian hon V20C
- Chi co 1 tai khoan (tk_01), khong co loai phat sinh
- Theo Thong tu 200/2014/TT-BTC
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
