# Task 152: GLMAUBCTCTMV13

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Mau bao cao tai chinh V13 tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLMAUBCTCTMV13.dll
- **Chuc nang:** Quan ly mau bao cao tai chinh V13
- **Loai:** Bieu mau (MAU)
- **Assembly Title:** GLBCTC07V13
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)
- **Template:** BCTC V13 (Thong tu 200/2014/TT-BTC)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLMAUBCTCTMV13.dll/README.md`

---

## Cau truc du lieu

### Bang: MAUBCTCMV13 (Mau bao cao tai chinh V13)

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

### 1. frmGLMAUBCTCTMV13 (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chi tieu V13, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma_so/chi_tieu |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmGLMAUBCTCTMV13Edit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin chi tieu V13
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu (AutoComplete, Uppercase) |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu (Multiline) |
| txtCach_tinh | TextBox | cach_tinh | Cong thuc tinh toan |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (Lookup: TK) |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_MAU_BCTC_V13_GET | Lay danh sach chi tieu V13 |
| SP_GL_MAU_BCTC_V13_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_MAU_BCTC_V13_INSERT | Them chi tieu moi |
| SP_GL_MAU_BCTC_V13_UPDATE | Cap nhat chi tieu |
| SP_GL_MAU_BCTC_V13_DELETE | Xoa chi tieu |
| SP_GL_MAU_BCTC_V13_FIND | Tim kiem chi tieu |
| SP_GL_MAU_BCTC_V13_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
-- Them chi tieu moi
EXEC SP_GL_MAU_BCTC_V13_INSERT
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

1. **Loai chi tieu**:
   - Chi co 1 tai khoan (tk_01)
   - Khong co truong cong trinh

2. **Mau quyet dinh**:
   - Mac dinh lay tu CompanyInformations.Qd_cdkt

3. **Tuy chon in**:
   - IsPrint: Mac dinh = true khi them moi
   - IsItalic: Mac dinh = false
   - Bold: Mac dinh = false

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/MAUBCTCMV13.php
namespace Diepxuan\Simba\Models\GL;

class MAUBCTCMV13 extends Model
{
    protected $table = 'MAUBCTC_V13';
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
}
```

### 2. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV13Edit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV13Edit extends Component
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
        return view('catalog::gl.bieumau.bctcmv13-edit');
    }
}
```

### 3. Views

```
resources/views/catalog/gl/bieumau/
├── bctcmv13.blade.php         (List page)
├── bctcmv13-edit.blade.php    (Modal edit)
```

### 4. Routes

```php
Route::prefix('catalog/gl/bieumau')
    ->name('catalog.gl.bieumau.')
    ->group(function () {
        Route::get('/bctcmv13', [BCTCMV13::class, 'render'])->name('bctcmv13');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | MAUBCTCMV13.php | Chinh |
| Model | laravel-simba | DMTAIKHOAN.php | Lien quan (FK) |
| Component | laravel-catalog | BCTCMV13.php | List |
| Component | laravel-catalog | BCTCMV13Edit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes
- [ ] Tao Model MAUBCTCMV13
- [ ] Tao Livewire BCTCMV13 (list)
- [ ] Tao Livewire BCTCMV13Edit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTAIKHOAN

---

## Ghi chu

- V13 la mau bao cao don gian voi 1 tai khoan
- Theo Thong tu 200/2014/TT-BTC