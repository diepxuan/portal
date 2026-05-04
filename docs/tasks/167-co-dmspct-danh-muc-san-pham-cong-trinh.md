# Task 167: CO-DMSPCT-DanhMucSanPhamCongTrinh

## Nhom: CO (Cost Accounting - Ke toan gia thanh)

## Muc tieu
Chuyen doi chuc nang danh muc san pham cong trinh tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** CODMSPCT.dll
- **Chuc nang:** Quan ly danh muc san pham cong trinh
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc cong trinh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** CO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/CODMSPCT.dll/README.md`

---

## Cau truc du lieu

### Bang: CODMSPCT (Danh muc san pham cong trinh)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_spct | varchar | Ma san pham cong trinh (khoa chinh) |
| ten_spct | nvarchar | Ten san pham cong trinh |
| ma_nhspct | varchar | Ma nhom san pham |
| dvt | varchar | Don vi tinh |
| ghi_chu | nvarchar | Ghi chu |
| ksd | bit | Khoa su dung |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| CODMNHSPCT | Nhom san pham cong trinh | FK ma_nhspct |
| COBOM_PH | Dinh muc BOM | FK ma_spct |
| CODMBOM | Dinh muc BOM (version cu) | FK ma_spct |

---

## Form classes

### frmCODMSPCT (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach san pham cong trinh
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### Chế độ xem

| Tham so | Gia tri | Hanh vi |
|---------|---------|---------|
| par1 | "1" | Che do chi xem (an cac nut thao tac) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_CO_DMSPCT_GET | Lay danh sach SPCT |
| SP_CO_DMSPCT_GETBYID | Lay chi tiet 1 SPCT |
| SP_CO_DMSPCT_INSERT | Them SPCT moi |
| SP_CO_DMSPCT_UPDATE | Cap nhat SPCT |
| SP_CO_DMSPCT_DELETE | Xoa SPCT |

### SP_GET (reference)

```sql
EXEC SP_CO_DMSPCT_GET
    @pMa_cty VARCHAR(50) = '001',
    @pSearch NVARCHAR(100) = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_spct | 'Ma san pham cong trinh khong duoc trong' |
| Unique | ma_spct | 'Ma san pham cong trinh da ton tai' |
| Required | ten_spct | 'Ten san pham cong trinh khong duoc trong' |

### Business Rules

1. **Ma san pham:**
   - AutoGenerate neu de trong
   - Khong cho phep sua khi da co dinh muc

2. **Che do xem:**
   - par1 = "1" -> An cac nut Add/Edit/Delete

3. **Xoa SPCT:**
   - Kiem tra khong co dinh muc BOM
   - Neu co BOM -> khong cho xoa

---

## Mapping PHP

### 1. Model

```php
// app/Models/CO/DMSPCT.php
namespace Diepxuan\Simba\Models\CO;

class DMSPCT extends Model
{
    protected $table = 'CODMSPCT';
    protected $primaryKey = 'ma_spct';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_spct', 'ten_spct', 'ma_nhspct', 'dvt', 'ghi_chu', 'ksd'];

    protected $casts = ['ksd' => 'boolean'];

    public function nhomSpct()
    {
        return $this->belongsTo(DMNHSPCT::class, 'ma_nhspct', 'ma_nhspct');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsCOGetDMSPCT.php
namespace Diepxuan\Simba\StoredProcedures;

class AsCOGetDMSPCT extends StoredProcedure
{
    protected $procedure = 'SP_CO_DMSPCT_GET';
    protected $params = ['pMa_cty', 'pSearch'];
}
```

### 3. Livewire Component

```php
namespace Diepxuan\Catalog\Http\Livewire\CO\Danhmuc;

class SanPhamCongTrinh extends Component
{
    const MA_CT = 'CO';

    public Collection $pSpcts;
    public bool $pReadOnly = false;

    public function mount(bool $readOnly = false): void
    {
        $this->pReadOnly = $readOnly;
        $this->loadSpcts();
    }
}
```

### 4. Views

```
resources/views/catalog/co/danhmuc/
├── san-pham-cong-trinh.blade.php
└── _san-pham-cong-trinh-row.blade.php
```

### 5. Routes

```php
Route::get('/san-pham-cong-trinh', [SanPhamCongTrinh::class, 'render'])
    ->name('catalog.co.danhmuc.sanphamcongttrinh');
Route::get('/san-pham-cong-trinh/view', [SanPhamCongTrinh::class, 'render'])
    ->defaults('readOnly', true)
    ->name('catalog.co.danhmuc.sanphamcongttrinh.view');
```

---

## Dependencies

| Loai | Package | Ghi chu |
|------|---------|---------|
| Model | laravel-simba | DMSPCT |
| Model | laravel-simba | DMNHSPCT |
| Model | laravel-simba | BOMPH |
| SP | laravel-simba | AsCOGetDMSPCT |
| Component | laravel-catalog | SanPhamCongTrinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMSPCT
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire SanPhamCongTrinh
- [ ] Tao View
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMNHSPCT
- [ ] Test che do chi xem