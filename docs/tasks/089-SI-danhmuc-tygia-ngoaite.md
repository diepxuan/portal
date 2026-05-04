# Task 089: SIDMTGNT

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang danh muc ty gia ngoai te tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMTGNT.dll
- **Chuc nang:** Danh muc ty gia ngoai te
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc ty gia ngoai te
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** SIDMTGNT

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMTGNT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMTGNT (Danh muc ty gia)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_nt | varchar | Ma ngoai te (3 ky tu) |
| ngay_tg | datetime | Ngay ap dung |
| ty_gia | decimal | Ty gia |
| ghi_chu | nvarchar | Ghi chu |

---

## Form classes

### 1. frmSIDMTGNT (Danh sach ty gia)
- **Ke thua:** frmAsiaRoot
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvTyGia | DataGridView | Luoi ty gia |
| txtSearch | TextBox | Tim kiem theo ngay |
| cboCurrency | ComboBox | Chon loai tien |
| btnAdd | Button | Them ty gia |
| btnEdit | Button | Sua ty gia |

### 2. frmSIDMTGNTEdit (Them/sua ty gia)
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_nt | AsTextBox | ma_nt | Ma ngoai te |
| txtTyGia | AsTextNumeric | ty_gia | Ty gia |
| txtNgay | DateTimePicker | ngay_tg | Ngay ap dung |
| txtGhiChu | TextBox | ghi_chu | Ghi chu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_DMTGNT_GET | Lay danh sach |
| SP_SI_DMTGNT_GETBYID | Lay chi tiet |
| SP_SI_DMTGNT_INSERT | Them moi |
| SP_SI_DMTGNT_UPDATE | Cap nhat |
| SP_SI_DMTGNT_DELETE | Xoa |
| SP_SI_DMTGNT_FIND | Tim kiem |
| SP_SI_DMTGNT_GETCURRENT | Lay ty gia hien tai |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_nt | 'Ma ngoai te khong duoc trong' |
| Required | ngay_tg | 'Ngay khong duoc trong' |
| Required, > 0 | ty_gia | 'Ty gia > 0' |
| Unique | (ma_nt, ngay_tg) | 'Da ton tai ty gia ngay nay' |

### Business Rules

1. **Ty gia theo ngay**:
   - Moigay co nhieu ty gia
   - Lay ty gia gan nhat <= ngay

2. **Tu dong lay ty gia**:
   - Neu khong co ty gia ngay -> Lay ty gia truoc do

3. **Tinh toan**:
   - Tien = Tien_nt * Ty_gia

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/DMTGNT.php
namespace Diepxuan\Simba\Models\SI;

class DMTGNT extends Model
{
    protected $table = 'DMTGNT';
    protected $primaryKey = ['ma_nt', 'ngay_tg'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nt',
        'ngay_tg',
        'ty_gia',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_tg' => 'datetime',
        'ty_gia' => 'decimal:8',
    ];

    public function ngoaiTe()
    {
        return $this->belongsTo(DMNT::class, 'ma_nt', 'ma_nt');
    }

    // Lay ty gia hien tai cho 1 loai tien
    public static function getCurrentRate(string $ma_nt, ?Carbon $date = null): ?float
    {
        $date = $date ?? now();
        return static::where('ma_nt', $ma_nt)
            ->where('ngay_tg', '<=', $date)
            ->orderBy('ngay_tg', 'desc')
            ->value('ty_gia');
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Tygia.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Tygia extends Component
{
    public ?string $pMa_nt = null;
    public ?string $pTu_ngay = null;
    public ?string $pDen_ngay = null;

    public Collection $pDanhSach;
    public Collection $pCurrencies;

    public function mount(): void
    {
        $this->pCurrencies = DMNT::active()->get();
    }

    public function loadData(): void
    {
        $query = DMTGNT::query();
        if ($this->pMa_nt) {
            $query->where('ma_nt', $this->pMa_nt);
        }
        if ($this->pTu_ngay) {
            $query->where('ngay_tg', '>=', $this->pTu_ngay);
        }
        if ($this->pDen_ngay) {
            $query->where('ngay_tg', '<=', $this->pDen_ngay);
        }
        $this->pDanhSach = $query->orderBy('ngay_tg', 'desc')->get();
    }

    public function render(): View
    {
        return view('catalog::si.danhmuc.tygia');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── tygia.blade.php
├── tygia-edit.blade.php
└── _tygia-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/ty-gia', [Tygia::class, 'render'])
            ->name('tygia');
        Route::get('/ty-gia/edit/{ma_nt?}/{ngay_tg?}', [TygiaEdit::class, 'render'])
            ->name('tygia.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMTGNT.php | Chinh |
| Model | laravel-simba | DMNT.php | Ngoai te |
| Component | laravel-catalog | Tygia.php | List |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMTGNT
- [ ] Tao Livewire Tygia
- [ ] Tao Livewire TygiaEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test tu dong lay ty gia