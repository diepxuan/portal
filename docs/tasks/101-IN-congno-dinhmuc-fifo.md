# Task 101: INCDFIFO

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang cong no dinh muc FIFO tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INCDFIFO.dll
- **Chuc nang:** Cong no dinh muc FIFO
- **Loai:** Voucher/Master (Co nhap lieu)
- **Assembly Title:** Công nợ định mức FIFO
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INCDFIFO.dll/README.md`

---

## Cau truc du lieu

### Bang: INCDFIFO (Cong no dinh muc FIFO)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_cty | varchar | 50 | Ma cong ty |
| stt_rec | varchar | 50 | So thu tu record (PK) |
| ma_vt | varchar | 50 | Ma vat tu |
| ten_vt | nvarchar | 200 | Ten vat tu |
| ma_kho | varchar | 50 | Ma kho |
| so_luong | decimal | 18,6 | So luong dinh muc |
| tien | decimal | 18,2 | Tien dinh muc |
| ksd | bit | 1 | Khoa su dung |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_vt -> DMVT.ma_vt |
| DMKHO | Danh muc kho | FK ma_kho -> DMKHO.ma_kho |

---

## Form classes

### 1. frmINCDFIFO (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach cong no dinh muc FIFO
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem theo ma/ten |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmINCDFIFOEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin cong no dinh muc FIFO
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Vt | AsTextBox | ma_vt | Ma vat tu (AutoLookup) |
| txtTen_Vt | Label | - | Ten vat tu |
| txtMa_Kho | AsTextBox | ma_kho | Ma kho (AutoLookup) |
| txtSo_Luong | AsTextNumeric | so_luong | So luong dinh muc |
| txtTien | AsTextNumeric | tien | Tien dinh muc |
| chkKsd | AsCheckBox | ksd | Khoa su dung |
| btnSave | Button | - | Nut luu |
| btnCancel | Button | - | Nut huy |

### 3. frmINCDFIFOFilter (Form loc)
- **Ke thua:** frmDMFilter
- **Chuc nang:** Loc danh sach theo tieu chi

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_INCDFIFO_GET | Lay danh sach cong no dinh muc FIFO |
| SP_IN_INCDFIFO_GETBYID | Lay chi tiet 1 ban ghi |
| SP_IN_INCDFIFO_INSERT | Them moi |
| SP_IN_INCDFIFO_UPDATE | Cap nhat |
| SP_IN_INCDFIFO_DELETE | Xoa |
| SP_IN_INCDFIFO_FIND | Tim kiem |
| SP_IN_INCDFIFO_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Required | ma_kho | 'Ma kho khong duoc trong' |
| Numeric > 0 | so_luong | 'So luong phai lon hon 0' |

### Business Rules

1. **Dinh muc FIFO**: Theo dõi cong no dinh muc theo phuong phap FIFO
2. **Hang nhap truoc xuat truoc**: Gia tri ton = gia nhap cu
3. **Loc nhieu tieu chi**: VT, nhom VT, kho, ngay
4. **Khoa su dung**: Ksd=1 an khoi danh sach chon

## Mapping PHP

### 1. Model

```php
// app/Models/IN/INCDFIFO.php
namespace Diepxuan\Simba\Models\IN;

class INCDFIFO extends Model
{
    protected $table = 'INCDFIFO';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'stt_rec', 'ma_vt', 'ten_vt',
        'ma_kho', 'so_luong', 'tien', 'ksd',
    ];

    protected $casts = [
        'so_luong' => 'decimal:6',
        'tien' => 'decimal:2',
        'ksd' => 'boolean',
    ];

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function kho()
    {
        return $this->belongsTo(DMKHO::class, 'ma_kho', 'ma_kho');
    }

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('ma_vt', 'like', "%{$search}%")
              ->orWhere('ten_vt', 'like', "%{$search}%");
        });
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetINCDFIFO.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetINCDFIFO extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDFIFO_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsINCDFIFO.php
class AsINInsINCDFIFO extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDFIFO_INSERT';
    protected $params = ['pMa_cty', 'stt_rec', 'ma_vt', 'ma_kho', 'so_luong', 'tien', 'ksd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdINCDFIFO.php
class AsINUpdINCDFIFO extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDFIFO_UPDATE';
    protected $params = ['pMa_cty', 'stt_rec', 'ma_vt', 'ma_kho', 'so_luong', 'tien', 'ksd'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelINCDFIFO.php
class AsINDelINCDFIFO extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDFIFO_DELETE';
    protected $params = ['pMa_cty', 'stt_rec'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChkINCDFIFO.php
class AsINChkINCDFIFO extends StoredProcedure
{
    protected $procedure = 'SP_IN_INCDFIFO_CHECK';
    protected $params = ['pMa_cty', 'ma_vt', 'ma_kho'];
}
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/Congnodinhmucfifo.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class Congnodinhmucfifo extends Component
{
    const MA_CT = 'IN';

    public Collection $pDanhSach;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;
    public ?string $pEditingStt_rec = null;

    protected $rules = [
        'pSearch' => 'nullable|string|max:100',
    ];

    public function mount(): void
    {
        $this->loadDanhSach();
    }

    public function loadDanhSach(): void
    {
        // Load tu Stored Procedure SP_IN_INCDFIFO_GET
    }

    public function render(): View
    {
        return view('catalog::in.danhmuc.cong-no-dinh-muc-fifo');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/CongnodinhmucfifoEdit.php
class CongnodinhmucfifoEdit extends Component
{
    public ?string $pStt_rec = null;
    public ?string $pMa_Vt = null;
    public string $pTen_Vt = '';
    public ?string $pMa_Kho = null;
    public float $pSo_Luong = 0;
    public float $pTien = 0;
    public bool $pKsd = false;
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Vt' => 'required|string|max:50',
        'pMa_Kho' => 'required|string|max:50',
        'pSo_Luong' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'pMa_Vt.required' => 'Ma vat tu khong duoc trong',
        'pMa_Kho.required' => 'Ma kho khong duoc trong',
        'pSo_Luong.min' => 'So luong phai lon hon 0',
    ];

    public function mount(?string $sttRec = null): void
    {
        if ($sttRec) {
            $this->pStt_rec = $sttRec;
            $this->loadRecord();
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP_INSERT hoac SP_UPDATE
    }

    public function render(): View
    {
        return view('catalog::in.danhmuc.cong-no-dinh-muc-fifo-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/in/danhmuc/
├── cong-no-dinh-muc-fifo.blade.php        (List page)
├── cong-no-dinh-muc-fifo-edit.blade.php   (Modal edit)
└── _cong-no-dinh-muc-fifo-row.blade.php   (Component row)
```

### 6. Routes

```php
// routes/web.php hoac routes/catalog.php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/cong-no-dinh-muc-fifo', [Congnodinhmucfifo::class, 'render'])
            ->name('congnodinhmucfifo');
        Route::get('/cong-no-dinh-muc-fifo/edit/{sttRec?}', [CongnodinhmucfifoEdit::class, 'render'])
            ->name('congnodinhmucfifo.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | INCDFIFO.php | Chinh |
| Model | laravel-simba | DMVT.php | Lien quan (FK) |
| Model | laravel-simba | DMKHO.php | Lien quan (FK) |
| SP | laravel-simba | AsINGetINCDFIFO.php | Chinh |
| SP | laravel-simba | AsINInsINCDFIFO.php | Insert |
| SP | laravel-simba | AsINUpdINCDFIFO.php | Update |
| SP | laravel-simba | AsINDelINCDFIFO.php | Delete |
| SP | laravel-simba | AsINChkINCDFIFO.php | Check trung |
| Component | laravel-catalog | Congnodinhmucfifo.php | List |
| Component | laravel-catalog | CongnodinhmucfifoEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Model INCDFIFO
- [ ] Tao Livewire Congnodinhmucfifo (list)
- [ ] Tao Livewire CongnodinhmucfifoEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMVT, DMKHO

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `in.dict.cdfifo`
- **Note:** Route đã có hoặc shell metadata; write/transfer execute chỉ mở khi payload/side effect được audit.
