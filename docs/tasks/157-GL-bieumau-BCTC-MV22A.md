# Task 157: GLMAUBCTCTMV22A

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Mau bao cao tai chinh V22A tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLMAUBCTCTMV22A.dll
- **Chuc nang:** Quan ly mau bao cao tai chinh V22A (phuc tap nhat trong dong V22)
- **Loai:** Bieu mau (MAU)
- **Assembly Title:** GLBCTC07V22a
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)
- **Template:** BCTC V22A (Thong tu 200/2014/TT-BTC)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLMAUBCTCTMV22A.dll/README.md`

---

## Cau truc du lieu

### Bang: MAUBCTCMV22A (Mau bao cao tai chinh V22A)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Ma mau QD (khoa chinh) |
| ma_so | varchar | 50 | Ma chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh toan |
| tk_01 | varchar | 50 | Tai khoan 1 (Lookup: TK) |
| tk_02 | varchar | 50 | Tai khoan 2 (Lookup: TK) |
| tk_03 | varchar | 50 | Tai khoan 3 (Lookup: TK) |
| tk_04 | varchar | 50 | Tai khoan 4 (Lookup: TK) |
| tk_05 | varchar | 50 | Tai khoan 5 (Lookup: TK) |
| tk_06 | varchar | 50 | Tai khoan 6 (Lookup: TK) |
| tk_07 | varchar | 50 | Tai khoan 7 (Lookup: TK) |
| tk_08 | varchar | 50 | Tai khoan 8 (Lookup: TK) |
| tk_09 | varchar | 50 | Tai khoan 9 (Lookup: TK) |
| tk_10 | varchar | 50 | Tai khoan 10 (Lookup: TK) |
| tk_11 | varchar | 50 | Tai khoan 11 (Lookup: TK) |
| tk_12 | varchar | 50 | Tai khoan 12 (Lookup: TK) |
| loai_ps | varchar | 10 | Loai phat sinh (NODK/CODK/NOCK/COCK/PSNO/PSCo) |
| nam_ps | varchar | 20 | Nam phat sinh (Nam nay/Nam truoc) |
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

### Nam phat sinh (nam_ps)

| Gia tri | Mo ta |
|---------|-------|
| Nam nay | Phat sinh nam hien tai |
| Nam truoc | Phat sinh nam truoc |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTAIKHOAN | Danh muc tai khoan | FK tk_01...tk_12 -> DMTAIKHOAN.tk |
| GLRpt* | Cac bao cao | Lookup mau |

---

## Form classes

### 1. frmGLMAUBCTCTMV22A (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chi tieu V22A, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma_so/chi_tieu |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmGLMAUBCTCTMV22AEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin chi tieu V22A
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu (AutoComplete, Uppercase) |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu (Multiline) |
| txtCach_tinh | TextBox | cach_tinh | Cong thuc tinh toan |
| txtTaikhoan1 | AsTextBox | tk_01 | Tai khoan 1 (Lookup: TK) |
| txtTaikhoan2 | AsTextBox | tk_02 | Tai khoan 2 (Lookup: TK) |
| txtTaikhoan3 | AsTextBox | tk_03 | Tai khoan 3 (Lookup: TK) |
| txtTaikhoan4 | AsTextBox | tk_04 | Tai khoan 4 (Lookup: TK) |
| txtTaikhoan5 | AsTextBox | tk_05 | Tai khoan 5 (Lookup: TK) |
| txtTaikhoan6 | AsTextBox | tk_06 | Tai khoan 6 (Lookup: TK) |
| txtTaikhoan7 | AsTextBox | tk_07 | Tai khoan 7 (Lookup: TK) |
| txtTaikhoan8 | AsTextBox | tk_08 | Tai khoan 8 (Lookup: TK) |
| txtTaikhoan9 | AsTextBox | tk_09 | Tai khoan 9 (Lookup: TK) |
| txtTaikhoan10 | AsTextBox | tk_10 | Tai khoan 10 (Lookup: TK) |
| txtTaikhoan11 | AsTextBox | tk_11 | Tai khoan 11 (Lookup: TK) |
| txtTaikhoan12 | AsTextBox | tk_12 | Tai khoan 12 (Lookup: TK) |
| cboLoai_ps | ComboBox | loai_ps | Loai phat sinh |
| cboNam_ps | ComboBox | nam_ps | Nam phat sinh |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_MAU_BCTC_V22A_GET | Lay danh sach chi tieu V22A |
| SP_GL_MAU_BCTC_V22A_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_MAU_BCTC_V22A_INSERT | Them chi tieu moi |
| SP_GL_MAU_BCTC_V22A_UPDATE | Cap nhat chi tieu |
| SP_GL_MAU_BCTC_V22A_DELETE | Xoa chi tieu |
| SP_GL_MAU_BCTC_V22A_FIND | Tim kiem chi tieu |
| SP_GL_MAU_BCTC_V22A_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
-- Them chi tieu moi
EXEC SP_GL_MAU_BCTC_V22A_INSERT
    @pMa_cty VARCHAR(50),
    @pMau VARCHAR(50),
    @pMa_so VARCHAR(50),
    @pChi_tieu NVARCHAR(200),
    @pNd_chtieu NVARCHAR(500) = NULL,
    @pCach_tinh NVARCHAR(200) = NULL,
    @pTk_01 VARCHAR(50) = NULL,
    @pTk_02 VARCHAR(50) = NULL,
    @pTk_03 VARCHAR(50) = NULL,
    @pTk_04 VARCHAR(50) = NULL,
    @pTk_05 VARCHAR(50) = NULL,
    @pTk_06 VARCHAR(50) = NULL,
    @pTk_07 VARCHAR(50) = NULL,
    @pTk_08 VARCHAR(50) = NULL,
    @pTk_09 VARCHAR(50) = NULL,
    @pTk_10 VARCHAR(50) = NULL,
    @pTk_11 VARCHAR(50) = NULL,
    @pTk_12 VARCHAR(50) = NULL,
    @pLoai_ps VARCHAR(10) = NULL,
    @pNam_ps VARCHAR(20) = NULL,
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
| In | loai_ps | 'NODK,CODK,NOCK,COCK,PSNO,PSCo' |
| In | nam_ps | 'Nam nay,Nam truoc' |

### Business Rules

1. **Loai phat sinh**:
   - Bat buoc chon 1 trong 6 loai
   - Xac dinh loai du lieu lay tu CCDC

2. **Nam phat sinh**:
   - Nam nay: Lay du lieu nam hien tai
   - Nam truoc: Lay du lieu nam truoc

3. **Tai khoan**:
   - 12 tai khoan (tk_01 - tk_12)
   - Lookup tu DMTAIKHOAN
   - Co the de trong cac tai khoan khong su dung

4. **Mau quyet dinh**:
   - Mac dinh lay tu CompanyInformations.Qd_cdkt

5. **Tuy chon in**:
   - IsPrint: Mac dinh = true khi them moi
   - IsItalic: Mac dinh = false
   - Bold: Mac dinh = false

### So sanh cac phien ban V22

| Dac diem | V22A | V22b | V22c |
|----------|------|------|------|
| So TK | 12 TK | 1 TK | 1 TK |
| Loai PS | 1 combo | 2 combo (DK/CK) | 1 combo |
| Nam PS | Co | Khong | Khong |
| Cong no | Khong | Co | Khong |

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/MAUBCTCMV22A.php
namespace Diepxuan\Simba\Models\GL;

class MAUBCTCMV22A extends Model
{
    protected $table = 'MAUBCTC_V22A';
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
        'tk_01', 'tk_02', 'tk_03', 'tk_04', 'tk_05', 'tk_06',
        'tk_07', 'tk_08', 'tk_09', 'tk_10', 'tk_11', 'tk_12',
        'loai_ps',
        'nam_ps',
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
    public static $loaiPsOptions = [
        'NODK' => 'Du no dau ky',
        'CODK' => 'Du co dau ky',
        'NOCK' => 'Du no cuoi ky',
        'COCK' => 'Du co cuoi ky',
        'PSNO' => 'Phat sinh no',
        'PSCo' => 'Phat sinh co',
    ];

    public static $namPsOptions = [
        'Nam nay' => 'Nam nay',
        'Nam truoc' => 'Nam truoc',
    ];

    // Relationships
    public function taiKhoans()
    {
        return $this->hasMany(DMTAIKHOAN::class, 'tk', 'tk');
    }

    // Accessors
    public function getTkListAttribute(): array
    {
        $list = [];
        for ($i = 1; $i <= 12; $i++) {
            $key = 'tk_' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if (!empty($this->$key)) {
                $list[] = $this->$key;
            }
        }
        return $list;
    }
}
```

### 2. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV22AEdit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV22AEdit extends Component
{
    public ?string $pMau = null;
    public ?string $pMaSo = null;
    public string $pChiTieu = '';
    public string $pNdChtieu = '';
    public string $pCachTinh = '';
    public array $pTkList = array_fill(0, 12, null);
    public ?string $pLoaiPs = null;
    public ?string $pNamPs = null;
    public bool $pIsPrint = true;
    public bool $pIsItalic = false;
    public bool $pBold = false;

    protected $rules = [
        'pMaSo' => 'required|string|max:50',
        'pChiTieu' => 'required|string|max:200',
        'pLoaiPs' => 'required|in:NODK,CODK,NOCK,COCK,PSNO,PSCo',
        'pNamPs' => 'required|in:Nam nay,Nam truoc',
    ];

    public function render(): View
    {
        return view('catalog::gl.bieumau.bctcmv22a-edit');
    }
}
```

### 3. Views

```
resources/views/catalog/gl/bieumau/
├── bctcmv22a.blade.php         (List page)
├── bctcmv22a-edit.blade.php    (Modal edit - 12 TK fields)
```

### 4. Routes

```php
Route::prefix('catalog/gl/bieumau')
    ->name('catalog.gl.bieumau.')
    ->group(function () {
        Route::get('/bctcmv22a', [BCTCMV22A::class, 'render'])->name('bctcmv22a');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | MAUBCTCMV22A.php | Chinh |
| Model | laravel-simba | DMTAIKHOAN.php | Lien quan (FK) |
| Component | laravel-catalog | BCTCMV22A.php | List |
| Component | laravel-catalog | BCTCMV22AEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes
- [ ] Tao Model MAUBCTCMV22A
- [ ] Tao Livewire BCTCMV22A (list)
- [ ] Tao Livewire BCTCMV22AEdit (modal - 12 TK)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTAIKHOAN

---

## Ghi chu

- V22A la phien ban phuc tap nhat trong dong V22
- Co 12 tai khoan, loai phat sinh, nam phat sinh
- Dung cho cac bao cao tai chinh phuc tap can nhieu TK
- Theo Thong tu 200/2014/TT-BTC