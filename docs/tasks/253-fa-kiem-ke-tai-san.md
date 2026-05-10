# Task 253: Fakkts

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang kiem ke tai san tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** Fakkts.dll
- **Chuc nang:** Kiem ke tai san co dinh (nhap lieu + import Excel)
- **Loai:** Nhap lieu / Kiem ke
- **Assembly Title:** Fakkts
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asiasoft
- **Ma_ct:** FA (Kiem ke)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/Fakkts.dll/README.md`

---

## Form classes

### frmFakkts (Form kiem ke tai san)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Nhap lieu kiem ke & import tu Excel

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| dgvKK | AsDataGridView | Luoi hien thi danh sach kiem ke |
| btnImportExcel | Button | Nut import tu Excel |
| oFDialog | OpenFileDialog | Dialog chon file |

### DataGridView Columns

| Column | Type | Mo ta |
|--------|------|-------|
| dgvcFA_CODE | DataGridViewTextBoxColumn | Ma tai san |
| dgvcQuanlity | DataGridViewAsTextNumericColumn | So luong |
| dgvcDate | DataGridViewAsMaskedTextBoxColumn | Ngay kiem ke |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_KKTS_GET | Lay danh sach kiem ke |
| SP_FA_KKTS_INSERT | Them/Import kiem ke |
| SP_FA_KKTS_UPDATE | Cap nhat kiem ke |
| SP_FA_KKTS_DELETE | Xoa kiem ke |

---

## Business Logic

### Business Rules

1. **Nhap lieu truc tiep**:
   - Nhap ma tai san, so luong, ngay kiem ke
   - Nguồn dữ liệu: DataTable bind voi DataGridView

2. **Import tu Excel**:
   - Sử dụng Microsoft.Office.Interop.Excel
   - OpenFileDialog chọn file
   - Doc dữ liệu vào DataTable/DataGridView

3. **Data management**:
   - Real-time update
   - Save khi can

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/FAKKTS.php
namespace Diepxuan\Simba\Models\FA;

class FAKKTS extends Model
{
    protected $table = 'FAKKTS';
    protected $primaryKey = 'stt_rec';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ts', 'so_luong', 'ngay_kk',
    ];

    public function taiSan()
    {
        return $this->belongsTo(FADMTS::class, 'ma_ts', 'ma_ts');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Kiemke/KiemkeTaisan.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Kiemke;

class KiemkeTaisan extends Component
{
    const MA_CT = 'FA';

    public Collection $pKiemKeList;
    public array $pNewRow = [
        'ma_ts' => '',
        'so_luong' => 0,
        'ngay_kk' => null,
    ];

    public function importExcel(): void
    {
        // Su dung PhpSpreadsheet de doc Excel
    }

    public function saveRow(array $row): void
    {
        // Save vao database
    }

    public function render(): View
    {
        return view('catalog::fa.kiemke.kiemke-taisan');
    }
}
```

### 3. Views

```
resources/views/catalog/fa/kiemke/
├── kiemke-taisan.blade.php      (Main form + grid)
└── _kiemke-taisan-import.blade.php (Import modal)
```

### 4. Routes

```php
Route::get('/catalog/fa/kiemke/kiemke-taisan', [KiemkeTaisan::class, 'render'])
    ->name('catalog.fa.kiemke.kiemke-taisan');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | FAKKTS.php | Chinh |
| Component | laravel-catalog | KiemkeTaisan.php | UI + import |
| SP | laravel-simba | AsFAGetKKTS.php | Get |
| SP | laravel-simba | AsFAInsKKTS.php | Insert |
| View | laravel-catalog | kiemke-taisan.blade.php | UI |
| Library | laravel-common | PhpSpreadsheet | Import Excel |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model FAKKTS
- [ ] Tao Livewire KiemkeTaisan (grid + import)
- [ ] Tao Views (grid + import)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Excel import
- [ ] Test real-time update
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
