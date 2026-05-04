# Task 166: CO-DMBOM-DinhMucNguyenVatLieu

## Nhom: CO (Cost Accounting - Ke toan gia thanh)

## Muc tieu
Chuyen doi chuc nang dinh muc nguyen vat lieu (BOM) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** CODMBOM_.dll
- **Chuc nang:** Quan ly dinh muc nguyen vat lieu (Bill of Materials)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Định mức nguyên vật liệu
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** CO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/CODMBOM_.dll/README.md`

---

## Cau truc du lieu

### Bang: COBOM_PH (Dinh muc BOM - Phan header)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_spct | varchar | Ma san pham chi tiet (khoa chinh) |
| ten_spct | nvarchar | Ten san pham chi tiet |
| dvt | varchar | Don vi tinh |
| ghi_chu | nvarchar | Ghi chu |
| ksd | bit | Khoa su dung |

### Bang: COBOM_CT (Dinh muc BOM - Phan chi tiet)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_spct | varchar | Ma san pham chi tiet (FK) |
| ma_vt | varchar | Ma vat tu (FK) |
| so_luong | decimal | So luong dinh muc |
| don_gia_luong | decimal | Don gia nhan cong |
| vt_chinh | bit | Vat tu chinh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| CODDSPCT | Danh muc san pham | FK ma_spct |
| INDMVT | Danh muc vat tu | FK ma_vt |
| CODD1 | Dinh muc chi tiet | Lien quan |

---

## Form classes

### frmCODMBOM (Form chinh)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Quan ly dinh muc BOM (master-detail)
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Spct | AsTextBox | Ma san pham (AutoLookup) |
| lblTen_Spct | Label | Ten san pham |
| txtDvt | TextBox | Don vi tinh |
| txtGhi_Chu | TextBox | Ghi chu |
| dgvDM | AsDataGridView | Luoi danh sach BOM |
| gbChiTiet | GroupBox | GroupBox chi tiet vat tu |
| dgvChiTiet | AsInputDGV | Luoi chi tiet vat tu |

### DataGridView Columns (Chi tiet)

| Column | Type | Mo ta |
|--------|------|-------|
| dgvcMa_vt | TextBox | Ma vat tu |
| dgvcTen_vt | Label | Ten vat tu |
| dgvcSo_luong | Numeric | So luong |
| dgvcDon_gia | Numeric | Don gia |
| dgvcVt_chinh | CheckBox | Vat tu chinh |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asCOGetDMCobomPH | Lay danh sach BOM master |
| asCOInsDMCoBomPH | Them BOM master |
| asCOUpdDMCoBomPH | Cap nhat BOM master |
| asCODelDMCobomPH | Xoa BOM master |
| asCOGetDMCobomCT | Lay chi tiet vat tu |
| asCOInsDMCobomCT | Them chi tiet vat tu |
| asCODelDMCobomCT | Xoa chi tiet vat tu |

### SP_INSERT (reference)

```sql
EXEC asCOInsDMCoBomPH
    @pMa_cty VARCHAR(50),
    @pMa_spct VARCHAR(50),
    @pTen_spct NVARCHAR(200),
    @pDvt VARCHAR(20),
    @pGhi_chu NVARCHAR(500),
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_spct | 'Ma san pham khong duoc trong' |
| Unique | ma_spct | 'Ma san pham da ton tai' |
| Required | ten_spct | 'Ten san pham khong duoc trong' |
| Max length 50 | ma_spct | 'Ma san pham toi da 50 ky tu' |

### Business Rules

1. **Ma san pham:**
   - AutoLookup tu CODDSPCT
   - Hien thi ten san pham tu dong

2. **Chi tiet vat tu:**
   - Nhap danh sach vat tu cho san pham
   - Tinh don gia nhan cong tu dong
   - Danh dau vat tu chinh

3. **Xoa BOM:**
   - Kiem tra khong co phieu xuat nao su dung
   - Neu co phieu xuat -> khong cho xoa

4. **Don gia nhan cong:**
   - Tinh tu dinh muc cong doan
   - Cong don theo cac cong doan

---

## Mapping PHP

### 1. Model

```php
// app/Models/CO/BOMPH.php
namespace Diepxuan\Simba\Models\CO;

class BOMPH extends Model
{
    protected $table = 'COBOM_PH';
    protected $primaryKey = 'ma_spct';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_spct', 'ten_spct', 'dvt', 'ghi_chu', 'ksd'];

    protected $casts = ['ksd' => 'boolean'];

    public function chiTiets()
    {
        return $this->hasMany(BOMCT::class, 'ma_spct', 'ma_spct');
    }
}

// app/Models/CO/BOMCT.php
namespace Diepxuan\Simba\Models\CO;

class BOMCT extends Model
{
    protected $table = 'COBOM_CT';
    protected $primaryKey = ['ma_spct', 'ma_vt'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_spct', 'ma_vt', 'so_luong', 'don_gia_luong', 'vt_chinh'];

    protected $casts = ['so_luong' => 'decimal:4', 'don_gia_luong' => 'decimal:2', 'vt_chinh' => 'boolean'];

    public function bomPh()
    {
        return $this->belongsTo(BOMPH::class, 'ma_spct', 'ma_spct');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCOGetDMCobomPH.php
namespace Diepxuan\Simba\StoredProcedures;

class AsCOGetDMCobomPH extends StoredProcedure
{
    protected $procedure = 'asCOGetDMCobomPH';
    protected $params = ['pMa_cty'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsCOInsDMCoBomPH.php
class AsCOInsDMCoBomPH extends StoredProcedure
{
    protected $procedure = 'asCOInsDMCoBomPH';
    protected $params = ['pMa_cty', 'ma_spct', 'ten_spct', 'dvt', 'ghi_chu', 'ksd'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/CO/Danhmuc/DinhMucBOM.php
namespace Diepxuan\Catalog\Http\Livewire\CO\Danhmuc;

class DinhMucBOM extends Component
{
    const MA_CT = 'CO';

    public Collection $pBomPHs;
    public ?string $pEditingMaSpct = null;

    protected $rules = [
        'pEditingMaSpct' => 'required|string|max:50',
    ];

    public function render(): View
    {
        return view('catalog::co.danhmuc.dinh-muc-bom');
    }
}
```

### 4. Views

```
resources/views/catalog/co/danhmuc/
├── dinh-muc-bom.blade.php      (List + Edit)
└── _dinh-muc-bom-row.blade.php (Component row)
```

### 5. Routes

```php
Route::prefix('catalog/co/danhmuc')
    ->name('catalog.co.danhmuc.')
    ->group(function () {
        Route::get('/dinh-muc-bom', [DinhMucBOM::class, 'render'])
            ->name('dinhmucibom');
    });
```

---

## Dependencies

| Loai | Package | Ghi chu |
|------|---------|---------|
| Model | laravel-simba | BOMPH, BOMCT |
| Model | laravel-simba | CODDSPCT |
| Model | laravel-simba | INDMVT |
| SP Classes | laravel-simba | AsCOGetDMCobom* |
| Component | laravel-catalog | DinhMucBOM |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model BOMPH, BOMCT
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire DinhMucBOM
- [ ] Tao View
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi CODDSPCT
- [ ] Test tinh gia thanh