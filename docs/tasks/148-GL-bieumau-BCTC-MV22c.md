# Task 148: GLMAUBCTCTMV22c

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Mau bao cao tai chinh V22c tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLMAUBCTCTMV22c.dll
- **Chuc nang:** Quan ly mau bao cao tai chinh V22c
- **Loai:** Bieu mau (MAU)
- **Assembly Title:** GLBCTC07V22c
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)
- **Template:** BCTC V22c (Thong tu 200/2014/TT-BTC)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLMAUBCTCTMV22c.dll/README.md`

---

## Cau truc du lieu

### Bang: MAUBCTCMV22C (Mau bao cao tai chinh V22c)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Ma mau QD (khoa chinh) |
| ma_so | varchar | 50 | Ma chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh toan |
| tk_01 | varchar | 50 | Tai khoan (Lookup: TK) |
| loai_ps | varchar | 10 | Loai phat sinh (NODK/CODK/NOCK/COCK/PSNO/PSCo) |
| IsPrint | bit | 1 | Co in hay khong |
| IsItalic | bit | 1 | In nghieng |
| bold | bit | 1 | In dam |

### Loai phat sinh (loai_ps)

| Gia tri | Mo ta |
|---------|-------|
| NODK | Du no dau ky |
| CODK | Du co dau ky |
| NOCK | Du no cuoi ky |
| COCK | Du co cuoi ky |
| PSNO | Phat sinh no |
| PSCo | Phat sinh co |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | FK tk_01 -> DMTAIKHOAN.tk |
| GLRpt* | Cac bao cao | Lookup mau |

---

## Form classes

### 1. frmGLMAUBCTCTMV22c (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chi tieu V22c, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma_so/chi_tieu |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmGLMAUBCTCTMV22cEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin chi tieu V22c
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu (AutoComplete, Uppercase) |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu (Multiline) |
| txtCach_tinh | TextBox | cach_tinh | Cong thuc tinh toan |
| txtTaikhoan | AsTextBox | tk_01 | Tai khoan (Lookup: TK) |
| cboLoai_ps | ComboBox | loai_ps | Loai phat sinh |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_MAU_BCTC_V22C_GET | Lay danh sach chi tieu V22c |
| SP_GL_MAU_BCTC_V22C_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_MAU_BCTC_V22C_INSERT | Them chi tieu moi |
| SP_GL_MAU_BCTC_V22C_UPDATE | Cap nhat chi tieu |
| SP_GL_MAU_BCTC_V22C_DELETE | Xoa chi tieu |
| SP_GL_MAU_BCTC_V22C_FIND | Tim kiem chi tieu |
| SP_GL_MAU_BCTC_V22C_CHECK | Kiem tra trung ma |

### SP_GET (reference)

```sql
-- Lay danh sach chi tieu V22c
EXEC SP_GL_MAU_BCTC_V22C_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMau VARCHAR(50) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

### SP_INSERT (reference)

```sql
-- Them chi tieu moi
EXEC SP_GL_MAU_BCTC_V22C_INSERT
    @pMa_cty VARCHAR(50),
    @pMau VARCHAR(50),
    @pMa_so VARCHAR(50),
    @pChi_tieu NVARCHAR(200),
    @pNd_chtieu NVARCHAR(500) = NULL,
    @pCach_tinh NVARCHAR(200) = NULL,
    @pTk_01 VARCHAR(50) = NULL,
    @pLoai_ps VARCHAR(10) = NULL,
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
| In | loai_ps | 'NODK,CODK,NOCK,COCK,PSNO,PSCo' |

### Business Rules

1. **Loai phat sinh**:
   - Bat buoc chon 1 trong 6 loai
   - Xac dinh loai du lieu lay tu CCDC

2. **Tai khoan**:
   - Chi 1 tai khoan (tk_01)
   - Lookup tu DMTAIKHOAN

3. **Mau quyet dinh**:
   - Mac dinh lay tu CompanyInformations.Qd_cdkt

4. **Tuy chon in**:
   - IsPrint: Mac dinh = true khi them moi
   - IsItalic: Mac dinh = false
   - Bold: Mac dinh = false

### So sanh cac phien ban V22

| Dac diem | V22A | V22b | V22c |
|----------|------|------|------|
| So TK | 12 TK | 1 TK | 1 TK |
| Loai PS | 1 combo | 2 combo | 1 combo |
| Nam PS | Co | Khong | Khong |
| Cong no | Khong | Co | Khong |

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/MAUBCTCMV22C.php
namespace Diepxuan\Simba\Models\GL;

class MAUBCTCMV22C extends Model
{
    protected $table = 'MAUBCTC_V22C';
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
        'loai_ps',
        'IsPrint',
        'IsItalic',
        'bold',
    ];

    protected $casts = [
        'IsPrint' => 'boolean',
        'IsItalic' => 'boolean',
        'bold' => 'boolean',
    ];

    // Constants
    const LOAI_PS_NODK = 'NODK';
    const LOAI_PS_CODK = 'CODK';
    const LOAI_PS_NOCK = 'NOCK';
    const LOAI_PS_COCK = 'COCK';
    const LOAI_PS_PSNO = 'PSNO';
    const LOAI_PS_PSCO = 'PSCo';

    public static $loaiPsOptions = [
        'NODK' => 'Du no dau ky',
        'CODK' => 'Du co dau ky',
        'NOCK' => 'Du no cuoi ky',
        'COCK' => 'Du co cuoi ky',
        'PSNO' => 'Phat sinh no',
        'PSCo' => 'Phat sinh co',
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
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV22CEdit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV22CEdit extends Component
{
    public ?string $pMau = null;
    public ?string $pMaSo = null;
    public string $pChiTieu = '';
    public string $pNdChtieu = '';
    public string $pCachTinh = '';
    public ?string $pTk01 = null;
    public string $pTenTk = '';
    public ?string $pLoaiPs = null;
    public bool $pIsPrint = true;
    public bool $pIsItalic = false;
    public bool $pBold = false;

    protected $rules = [
        'pMaSo' => 'required|string|max:50',
        'pChiTieu' => 'required|string|max:200',
        'pLoaiPs' => 'required|in:NODK,CODK,NOCK,COCK,PSNO,PSCo',
    ];

    public function render(): View
    {
        return view('catalog::gl.bieumau.bctcmv22c-edit');
    }
}
```

### 3. Views

```
resources/views/catalog/gl/bieumau/
├── bctcmv22c.blade.php         (List page)
├── bctcmv22c-edit.blade.php    (Modal edit)
```

### 4. Routes

```php
Route::prefix('catalog/gl/bieumau')
    ->name('catalog.gl.bieumau.')
    ->group(function () {
        Route::get('/bctcmv22c', [BCTCMV22C::class, 'render'])->name('bctcmv22c');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | MAUBCTCMV22C.php | Chinh |
| Model | laravel-simba | DMTAIKHOAN.php | Lien quan (FK) |
| Component | laravel-catalog | BCTCMV22C.php | List |
| Component | laravel-catalog | BCTCMV22CEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes
- [ ] Tao Model MAUBCTCMV22C
- [ ] Tao Livewire BCTCMV22C (list)
- [ ] Tao Livewire BCTCMV22CEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTAIKHOAN

---

## Ghi chu

- V22c la phien ban don gian nhat trong dong V22
- Chi co 1 tai khoan va 1 loai phat sinh
- Theo Thong tu 200/2014/TT-BTC