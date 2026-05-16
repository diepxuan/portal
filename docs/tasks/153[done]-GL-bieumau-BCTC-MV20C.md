# Task 153: GLMAUBCTCTMV20C

## Nhom: GL (General Ledger - So cai tong hop)

## Muc tieu
Chuyen doi chuc nang Mau bao cao tai chinh V20C tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** GLMAUBCTCTMV20C.dll
- **Chuc nang:** Quan ly mau bao cao tai chinh V20C
- **Loai:** Bieu mau (MAU)
- **Assembly Title:** GLBCTC07V20c
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL (General Ledger)
- **Template:** BCTC V20C (Thong tu 200/2014/TT-BTC)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/GLMAUBCTCTMV20C.dll/README.md`

---

## Cau truc du lieu

### Bang: MAUBCTCMV20C (Mau bao cao tai chinh V20C)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| mau | varchar | 50 | Ma mau QD (khoa chinh) |
| ma_so | varchar | 50 | Ma chi tieu |
| chi_tieu | nvarchar | 200 | Ten chi tieu |
| nd_chtieu | nvarchar | 500 | Noi dung chi tieu |
| cach_tinh | nvarchar | 200 | Cong thuc tinh toan |
| tk_01 | varchar | 50 | Tai khoan 1 (Lookup: TK) |
| tk_02 | varchar | 50 | Tai khoan 2 (Lookup: TK) |
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
| DMTAIKHOAN | Danh muc tai khoan | FK tk_01, tk_02 -> DMTAIKHOAN.tk |
| GLRpt* | Cac bao cao | Lookup mau |

---

## Form classes

### 1. frmGLMAUBCTCTMV20C (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chi tieu V20C, tim kiem, phan trang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| dgvDM | DataGridView | - | Luoi hien thi danh sach |
| txtSearch | TextBox | - | Tim kiem theo ma_so/chi_tieu |
| btnAdd | Button | - | Nut them moi |
| btnEdit | Button | - | Nut sua |
| btnDelete | Button | - | Nut xoa |

### 2. frmGLMAUBCTCTMV20CEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap, sua thong tin chi tieu V20C
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_chtieu | AsTextBox | ma_so | Ma chi tieu (AutoComplete, Uppercase) |
| txtChi_tieu | TextBox | chi_tieu | Ten chi tieu |
| txtNd_chtieu | TextBox | nd_chtieu | Noi dung chi tieu (Multiline) |
| txtCach_tinh | TextBox | cach_tinh | Cong thuc tinh toan |
| txtTaikhoan1 | AsTextBox | tk_01 | Tai khoan 1 (Lookup: TK) |
| lblTK1 | Label | - | Hien thi ten tai khoan 1 |
| txtTaikhoan2 | AsTextBox | tk_02 | Tai khoan 2 (Lookup: TK) |
| lblTK2 | Label | - | Hien thi ten tai khoan 2 |
| cboLoai_ps | ComboBox | loai_ps | Loai phat sinh |
| txtMauQD | AsTextBox | mau | Mau quyet dinh |
| ChkIs_print | CheckBox | IsPrint | Co in |
| ChkIs_italic | CheckBox | IsItalic | In nghieng |
| chkKsd | AsCheckBox | bold | In dam |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_MAU_BCTC_V20C_GET | Lay danh sach chi tieu V20C |
| SP_GL_MAU_BCTC_V20C_GETBYID | Lay chi tiet 1 chi tieu |
| SP_GL_MAU_BCTC_V20C_INSERT | Them chi tieu moi |
| SP_GL_MAU_BCTC_V20C_UPDATE | Cap nhat chi tieu |
| SP_GL_MAU_BCTC_V20C_DELETE | Xoa chi tieu |
| SP_GL_MAU_BCTC_V20C_FIND | Tim kiem chi tieu |
| SP_GL_MAU_BCTC_V20C_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
-- Them chi tieu moi
EXEC SP_GL_MAU_BCTC_V20C_INSERT
    @pMa_cty VARCHAR(50),
    @pMau VARCHAR(50),
    @pMa_so VARCHAR(50),
    @pChi_tieu NVARCHAR(200),
    @pNd_chtieu NVARCHAR(500) = NULL,
    @pCach_tinh NVARCHAR(200) = NULL,
    @pTk_01 VARCHAR(50) = NULL,
    @pTk_02 VARCHAR(50) = NULL,
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
| In | loai_ps | 'NODK,CODK,NOCK,COCK,PSNO,PSCo' |

### Business Rules

1. **Loai phat sinh**:
   - Bat buoc chon 1 trong 6 loai
   - Xac dinh loai du lieu lay tu CCDC

2. **Tai khoan**:
   - 2 tai khoan (tk_01, tk_02)
   - Lookup tu DMTAIKHOAN

3. **Mau quyet dinh**:
   - Mac dinh lay tu CompanyInformations.Qd_cdkt

4. **Tuy chon in**:
   - IsPrint: Mac dinh = true khi them moi
   - IsItalic: Mac dinh = false
   - Bold: Mac dinh = false

### So sanh V20C vs V21

| Dac diem | V20C | V21 |
|----------|------|-----|
| So TK | 2 TK (tk_01, tk_02) | 1 TK |
| Loai PS | Co combo | Khong co |
| Do phuc tap | Cao | Don gian |

---

## Mapping PHP

### 1. Model

```php
// app/Models/GL/MAUBCTCMV20C.php
namespace Diepxuan\Simba\Models\GL;

class MAUBCTCMV20C extends Model
{
    protected $table = 'MAUBCTC_V20C';
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
        'tk_02',
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
    public static $loaiPsOptions = [
        'NODK' => 'Du no dau ky',
        'CODK' => 'Du co dau ky',
        'NOCK' => 'Du no cuoi ky',
        'COCK' => 'Du co cuoi ky',
        'PSNO' => 'Phat sinh no',
        'PSCo' => 'Phat sinh co',
    ];

    // Relationships
    public function taiKhoan1()
    {
        return $this->belongsTo(DMTAIKHOAN::class, 'tk_01', 'tk');
    }

    public function taiKhoan2()
    {
        return $this->belongsTo(DMTAIKHOAN::class, 'tk_02', 'tk');
    }
}
```

### 2. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Bieumau/BCTCMV20CEdit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Bieumau;

class BCTCMV20CEdit extends Component
{
    public ?string $pMau = null;
    public ?string $pMaSo = null;
    public string $pChiTieu = '';
    public string $pNdChtieu = '';
    public string $pCachTinh = '';
    public ?string $pTk01 = null;
    public string $pTenTk1 = '';
    public ?string $pTk02 = null;
    public string $pTenTk2 = '';
    public ?string $pLoaiPs = null;
    public bool $pIsPrint = true;
    public bool $pIsItalic = false;
    public bool $pBold = false;

    protected $rules = [
        'pMaSo' => 'required|string|max:50',
        'pChiTieu' => 'required|string|max:200',
        'pLoaiPs' => 'required|in:NODK,CODK,NOCK,COCK,PSNO,PSCo',
    ];

    public function updatedPTk01($value): void
    {
        if ($value) {
            $tk = DMTAIKHOAN::find($value);
            $this->pTenTk1 = $tk ? $tk->ten_tk : '';
        }
    }

    public function updatedPTk02($value): void
    {
        if ($value) {
            $tk = DMTAIKHOAN::find($value);
            $this->pTenTk2 = $tk ? $tk->ten_tk : '';
        }
    }

    public function render(): View
    {
        return view('catalog::gl.bieumau.bctcmv20c-edit');
    }
}
```

### 3. Views

```
resources/views/catalog/gl/bieumau/
├── bctcmv20c.blade.php         (List page)
├── bctcmv20c-edit.blade.php    (Modal edit)
```

### 4. Routes

```php
Route::prefix('catalog/gl/bieumau')
    ->name('catalog.gl.bieumau.')
    ->group(function () {
        Route::get('/bctcmv20c', [BCTCMV20C::class, 'render'])->name('bctcmv20c');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | MAUBCTCMV20C.php | Chinh |
| Model | laravel-simba | DMTAIKHOAN.php | Lien quan (FK) |
| Component | laravel-catalog | BCTCMV20C.php | List |
| Component | laravel-catalog | BCTCMV20CEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes
- [ ] Tao Model MAUBCTCMV20C
- [ ] Tao Livewire BCTCMV20C (list)
- [ ] Tao Livewire BCTCMV20CEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTAIKHOAN

---

## Ghi chu

- V20C co 2 tai khoan va loai phat sinh
- Phuc tap hon V21 nhung don gian hon V22A
- Theo Thong tu 200/2014/TT-BTC
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (GL route/report shell)
- **Route:** `gl.task.153` hoặc GL report dynamic registry nếu có metadata.
- **Note:** Shell/read-only; process/write không execute khi chưa audit payload.
