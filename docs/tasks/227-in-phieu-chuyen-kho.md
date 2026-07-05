# Task 227: INVchIN3

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang phieu chuyen kho tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INVchIN3.dll
- **Chuc nang:** Phieu chuyen kho
- **Loai:** Chung tu (Voucher)
- **Assembly Title:** Phieu chuyen kho
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN3 (Phieu chuyen kho)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INVchIN3.dll/README.md`

---

## Cau truc du lieu

### Bang: INCHIENCK (Phieu chuyen kho - Header)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| ma_kh | varchar | 50 | Ma khach hang/nha cung cap |
| ten_kh | nvarchar | 200 | Ten KH/NCC |
| dia_chi | nvarchar | 500 | Dia chi |
| nguoi_gd | nvarchar | 200 | Nguoi giao dich |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,6 | Ty gia |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| tien | decimal | 18,2 | Tien VND |
| ma_gd | varchar | 50 | Ma giao dich |
| so_pn | varchar | 50 | So phieu nhap (lien ket) |
| stt_rec | varchar | 50 | STT record |

### Bang: INCTCK (Chi tiet chuyen kho)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | STT header |
| stt_rec0 | varchar | 50 | STT detail |
| ma_vt | varchar | 50 | Ma vat tu |
| ten_vt | nvarchar | 200 | Ten vat tu |
| dvt | varchar | 20 | Don vi tinh |
| ma_khox | varchar | 50 | Ma kho xuat |
| ma_khon | varchar | 50 | Ma kho nhap |
| so_luong | decimal | 18,6 | So luong chuyen |
| gia_nt | decimal | 18,6 | Gia ngoai te |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| gia | decimal | 18,2 | Gia VND |
| tien | decimal | 18,2 | Tien VND |
| tk_no | varchar | 20 | TK noi |
| tk_vt | varchar | 20 | TK co (vat tu) |
| ma_bp | varchar | 50 | Ma bo phan |
| ma_spct | varchar | 50 | Ma san pham chi tiet |
| ma_phi | varchar | 50 | Ma phi |
| ma_hd | varchar | 50 | Ma hop dong |
| ma_lo | varchar | 50 | Ma lo |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_vt |
| DMKHO | Danh muc kho | FK ma_khox, ma_khon |
| INPHIEUN | Phieu nhap | FK so_pn (tu dong tao) |

---

## Form classes

### 1. frmInVchIN3 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap phieu chuyen kho
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_Ct | TextBox | so_ct | So chung tu |
| txtNgay_Ct | DateTimePicker | ngay_ct | Ngay chung tu |
| txtSo_Pn | TextBox | so_pn | So phieu nhap (auto) |
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang |
| txtDien_Giai | TextBox | dien_giai | Dien giai |
| cboMa_Nt | ComboBox | ma_nt | Ma ngoai te |
| txtTy_Gia | NumericTextBox | ty_gia | Ty gia |
| txtTien | NumericTextBox | tien | Tien VND |
| dgvDetails | DataGridView | - | Luoi chi tiet |

### 2. frmInVchIN3Find (Form tim kiem)

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_VCHIN3_GET | Lay danh sach phieu chuyen kho |
| SP_IN_VCHIN3_GETBYID | Lay chi tiet 1 phieu |
| SP_IN_VCHIN3_INSERT | Them phieu chuyen kho |
| SP_IN_VCHIN3_UPDATE | Cap nhat phieu chuyen kho |
| SP_IN_VCHIN3_DELETE | Xoa phieu chuyen kho |
| SP_IN_VCHIN3_FIND | Tim kiem phieu chuyen kho |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | so_ct | 'So chung tu khong duoc trong' |
| Required | ma_khox | 'Ma kho xuat khong duoc trong' |
| Required | ma_khon | 'Ma kho nhap khong duoc trong' |

### Business Rules

1. **Tu dong tao phieu nhap**:
   - Khi luu phieu xuat, tu dong tao phieu nhap lien ket
   - So_Pn = so_phieu_nhap_tuong_ung

2. **Kiem tra ton kho**:
   - Kiem tra ton kho tai kho xuat
   - Khong cho xuat vuot ton kho

3. **Gia tri chuyen kho**:
   - Gia tri khong thay doi (gia von)
   - Khong tinh lai loi/nhuan

4. **Kho xuat != Kho nhap**:
   - Kiem tra ma_khox != ma_khon

---

## Mapping PHP

### 1. Models

```php
// app/Models/IN/INCHIENCK.php
namespace Diepxuan\Simba\Models\IN;

class INCHIENCK extends Model
{
    protected $table = 'INCHIENCK';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    public function chiTiets()
    {
        return $this->hasMany(INCTCK::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetChuyenKho.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetChuyenKho extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN3_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsChuyenKho.php
class AsINInsChuyenKho extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN3_INSERT';
    protected $params = [
        'pMa_cty', 'stt_rec', 'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh',
        'dia_chi', 'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia',
        'tien_nt', 'tien', 'ma_gd', 'so_pn',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdChuyenKho.php
class AsINUpdChuyenKho extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN3_UPDATE';
    protected $params = [
        'pMa_cty', 'stt_rec', 'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh',
        'dia_chi', 'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia',
        'tien_nt', 'tien', 'ma_gd', 'so_pn',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINDelChuyenKho.php
class AsINDelChuyenKho extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN3_DELETE';
    protected $params = ['pMa_cty', 'stt_rec'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINChkChuyenKho.php
class AsINChkChuyenKho extends StoredProcedure
{
    protected $procedure = 'SP_IN_VCHIN3_CHECK';
    protected $params = ['pMa_cty', 'so_ct'];
}
```

### 3. Models

```php
// app/Models/IN/INCHIENCK.php
namespace Diepxuan\Simba\Models\IN;

class INCHIENCK extends Model
{
    protected $table = 'INCHIENCK';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'so_ct', 'ngay_ct', 'ma_kh', 'ten_kh', 'dia_chi',
        'nguoi_gd', 'dien_giai', 'ma_nt', 'ty_gia', 'tien_nt', 'tien',
        'ma_gd', 'so_pn', 'stt_rec',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:6',
        'tien_nt' => 'decimal:2',
        'tien' => 'decimal:2',
    ];

    public function chiTiets()
    {
        return $this->hasMany(INCTCK::class, 'stt_rec', 'stt_rec');
    }
}

// app/Models/IN/INCTCK.php
class INCTCK extends Model
{
    protected $table = 'INCTCK';
    protected $primaryKey = 'stt_rec0';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'stt_rec0', 'ma_vt', 'ten_vt', 'dvt',
        'ma_khox', 'ma_khon', 'so_luong', 'gia_nt', 'tien_nt',
        'gia', 'tien', 'tk_no', 'tk_vt', 'ma_bp', 'ma_spct',
        'ma_phi', 'ma_hd', 'ma_lo',
    ];

    public function phieu()
    {
        return $this->belongsTo(INCHIENCK::class, 'stt_rec', 'stt_rec');
    }

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function khoXuat()
    {
        return $this->belongsTo(DMKHO::class, 'ma_khox', 'ma_kho');
    }

    public function khoNhap()
    {
        return $this->belongsTo(DMKHO::class, 'ma_khon', 'ma_kho');
    }
}
```

### 4. Livewire Component (Edit Modal)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Chungtu/ChuyenkhoEdit.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Chungtu;

class ChuyenkhoEdit extends Component
{
    public ?string $pSttRec = null;
    public string $pSoCt = '';
    public ?Carbon $pNgayCt = null;
    public ?string $pMaKh = null;
    public string $pDienGiai = '';
    public ?string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public Collection $pChiTiets;
    public ?string $pMode = 'create';

    protected $rules = [
        'pSoCt' => 'required|string|max:50',
        'pNgayCt' => 'required|date',
        'pChiTiets' => 'required|min:1',
    ];

    public function mount(?string $sttRec = null): void
    {
        $this->pNgayCt = now();
        $this->pChiTiets = collect([]);
        if ($sttRec) {
            $this->pSttRec = $sttRec;
            $this->loadPhieu();
        }
    }

    public function validateKho(): bool
    {
        // Kiem tra ma_khox != ma_khon
        foreach ($this->pChiTiets as $ct) {
            if ($ct['ma_khox'] === $ct['ma_khon']) {
                return false;
            }
        }
        return true;
    }

    public function submit(): void
    {
        $this->validate();
        if (!$this->validateKho()) {
            session()->flash('error', 'Kho xuat va kho nhap khong duoc trung');
            return;
        }
        if (!$this->checkTonKho()) {
            session()->flash('error', 'So luong vuot ton kho');
            return;
        }
        // Goi SP_INSERT hoac SP_UPDATE (tu dong tao phieu nhap)
    }

    public function render(): View
    {
        return view('catalog::in.chungtu.chuyen-kho-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/in/chungtu/
├── chuyen-kho.blade.php              (List page)
├── chuyen-kho-edit.blade.php         (Edit modal + detail grid)
├── chuyen-kho-find.blade.php         (Search form)
└── _chuyen-kho-row.blade.php         (Component row)
```

### 6. Routes

```php
Route::prefix('catalog/in/chungtu')
    ->name('catalog.in.chungtu.')
    ->group(function () {
        Route::get('/chuyen-kho', [Chuyenkho::class, 'render'])
            ->name('chuyen-kho');
        Route::get('/chuyen-kho/edit/{sttRec?}', [ChuyenkhoEdit::class, 'render'])
            ->name('chuyen-kho.edit');
        Route::get('/chuyen-kho/search', [ChuyenkhoFind::class, 'render'])
            ->name('chuyen-kho.search');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | INCHIENCK.php | Header |
| Model | laravel-simba | INCTCK.php | Detail |
| Model | laravel-simba | DMVT.php | Vat tu (FK) |
| Model | laravel-simba | DMKHO.php | Kho (FK xuat + nhap) |
| SP | laravel-simba | AsINGetChuyenKho.php | Get |
| SP | laravel-simba | AsINInsChuyenKho.php | Insert |
| SP | laravel-simba | AsINUpdChuyenKho.php | Update |
| SP | laravel-simba | AsINDelChuyenKho.php | Delete |
| SP | laravel-simba | AsINChkChuyenKho.php | Check trung |
| Component | laravel-catalog | Chuyenkho.php | List |
| Component | laravel-catalog | ChuyenkhoEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes (Get, Insert, Update, Delete, Check)
- [ ] Tao Models INCHIENCK, INCTCK
- [ ] Tao Livewire Chuyenkho (list)
- [ ] Tao Livewire ChuyenkhoEdit (form nhap lieu + detail grid)
- [ ] Tao Livewire ChuyenkhoFind (search)
- [ ] Tao Views (list + edit + search)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test auto create phieu nhap
- [ ] Test kiem tra kho xuat != kho nhap
- [ ] Test kiem tra ton kho
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `in.vch.in3`
- **Note:** Shell/voucher; write blocked until payload audit.
