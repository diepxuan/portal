# Task 059: IN Inventory Management

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Quan ly hang ton kho trong he thong Simba ERP. Day la task tong quat cho chuc nang quan ly ton kho.

## Chi tiet
- **Nhom:** IN (Inventory)
- **Chuc nang:** Quan ly hang ton kho
- **Loai:** Master (Quan ly tong hop)
- **Ma_ct:** IN

## Tai lieu tham khao
- `docs/decompiled/asia/INDMVT.dll/README.md` - Danh muc vat tu
- `docs/decompiled/asia/INDMKHO.dll/README.md` - Danh muc kho

---

## Cau truc du lieu

### Bang chinh (Ton kho)

| Bang | Mo ta | Loai |
|------|-------|------|
| INVENTORY | Du lieu ton kho hien tai | Transaction |
| INCDVT | So ton dau ky | Opening Balance |
| DMVT | Danh muc vat tu | Master |
| DMKHO | Danh muc kho | Master |
| DMLO | Danh muc lo | Master |
| DMNHVT | Nhom vat tu | Master |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_vt -> DMVT.ma_vt |
| DMKHO | Danh muc kho | FK ma_kho -> DMKHO.ma_kho |
| DMLO | Danh muc lo | FK ma_lo -> DMLO.ma_lo |
| DMNHVT | Nhom vat tu | FK ma_nhvt -> DMNHVT.ma_nhvt |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_INVENTORY_GET | Lay danh sach ton kho |
| SP_IN_INVENTORY_GETBYID | Lay chi tiet ton kho |
| SP_IN_INVENTORY_UPDATE | Cap nhat ton kho |
| SP_IN_INVENTORY_FIND | Tim kiem ton kho |
| SP_IN_TONKHO_TONGHOP | Tong hop ton kho |

### SP_GET (reference)

```sql
-- Lay du lieu ton kho
EXEC SP_IN_INVENTORY_GET
    @pMa_cty VARCHAR(50) = '001',
    @pMa_vt VARCHAR(50) = NULL,
    @pMa_kho VARCHAR(50) = NULL,
    @pMa_nhvt VARCHAR(50) = NULL,
    @pSearch NVARCHAR(100) = NULL,
    @pPageIndex INT = 1,
    @pPageSize INT = 50
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_vt | 'Ma vat tu khong duoc trong' |
| Required | ma_kho | 'Ma kho khong duoc trong' |
| Numeric >= 0 | so_luong | 'So luong phai >= 0' |

### Business Rules

1. **Ton kho thuc te**:
   - Ton dau ky + Phat sinh nhap - Phat sinh xuat = Ton hien tai
   - Cap nhat theo thoi gian thuc

2. **Gia ton kho**:
   - Gia binh quan di dong (BQDD)
   - Gia binh quan thang (TB thang)
   - FIFO (Nhap truoc xuat truoc)

3. **Canh bao ton kho**:
   - Ton toi thieu
   - Ton toi da
   - Canh bao het han (voi hang co han su dung)

4. **Kiem ke**:
   - Chot so ton ke toan
   - So sach voi ton thuc te
   - Xu ly chenh lech kiem ke

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/Inventory.php
namespace Diepxuan\Simba\Models\IN;

class Inventory extends Model
{
    protected $table = 'INVENTORY';
    protected $primaryKey = ['ma_vt', 'ma_kho', 'ma_lo'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_vt', 'ma_kho', 'ma_lo', 'so_luong',
        'gia_bq', 'tien', 'ngay_cap_nhat',
    ];

    protected $casts = [
        'so_luong' => 'decimal:6',
        'gia_bq' => 'decimal:8',
        'tien' => 'decimal:8',
        'ngay_cap_nhat' => 'datetime',
    ];

    public function vatTu()
    {
        return $this->belongsTo(DMVT::class, 'ma_vt', 'ma_vt');
    }

    public function kho()
    {
        return $this->belongsTo(DMKHO::class, 'ma_kho', 'ma_kho');
    }

    public function lo()
    {
        return $this->belongsTo(DMLO::class, 'ma_lo', 'ma_lo');
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('vatTu', function($q) use ($search) {
            $q->where('ma_vt', 'like', "%{$search}%")
              ->orWhere('ten_vt', 'like', "%{$search}%");
        });
    }

    public function scopeByKho($query, string $ma_kho)
    {
        return $query->where('ma_kho', $ma_kho);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetInventory.php
namespace Diepxuan\Simba\StoredProcedures;

class AsINGetInventory extends StoredProcedure
{
    protected $procedure = 'SP_IN_INVENTORY_GET';
    protected $params = ['pMa_cty', 'pMa_vt', 'pMa_kho', 'pMa_nhvt', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdInventory.php
class AsINUpdInventory extends StoredProcedure
{
    protected $procedure = 'SP_IN_INVENTORY_UPDATE';
    protected $params = ['pMa_cty', 'ma_vt', 'ma_kho', 'ma_lo', 'so_luong', 'gia_bq', 'tien'];
}
```

### 3. Inventory Service

```php
// diepxuan/laravel-catalog/src/Services/IN/InventoryService.php
namespace Diepxuan\Catalog\Services\IN;

class InventoryService
{
    public function getInventory(string $maVt, string $maKho, ?string $maLo = null): array
    {
        // Lay thong tin ton kho
    }

    public function updateInventory(string $maVt, string $maKho, float $soLuong): bool
    {
        // Cap nhat ton kho
    }

    public function checkInventory(string $maVt, string $maKho, float $soLuongYeuCau): bool
    {
        // Kiem tra ton kho du hay khong
    }

    public function getTongHop(array $filters): array
    {
        // Tong hop ton kho theo nhieu tieu chi
    }
}
```

### 4. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Hangtonkho.php
namespace Diepxuan\Catalog\Http\Livewire\IN;

class Hangtonkho extends Component
{
    const MA_CT = 'IN';

    public Collection $pInventory;
    public string $pSearch = '';
    public ?string $pMa_Kho = null;
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    public function mount(): void
    {
        $this->loadInventory();
    }

    public function loadInventory(): void
    {
        // Load tu SP_IN_INVENTORY_GET
    }

    public function checkTonKho(string $maVt, string $maKho, float $soLuong): bool
    {
        return InventoryService::checkInventory($maVt, $maKho, $soLuong);
    }

    public function render(): View
    {
        return view('catalog::in.hang-ton-kho');
    }
}
```

### 5. Views

```
resources/views/catalog/in/
├── hang-ton-kho.blade.php           (List page)
├── hang-ton-kho-detail.blade.php    (Detail view)
└── _hang-ton-kho-row.blade.php      (Component row)
```

### 6. Routes

```php
Route::prefix('catalog/in')
    ->name('catalog.in.')
    ->group(function () {
        Route::get('/hang-ton-kho', [Hangtonkho::class, 'render'])
            ->name('hang-ton-kho');
        Route::get('/hang-ton-kho/{maVt}/{maKho}/{maLo?}', [Hangtonkho::class, 'detail'])
            ->name('hang-ton-kho.detail');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | Inventory.php | Ton kho |
| Model | laravel-simba | DMVT.php | Vat tu (FK) |
| Model | laravel-simba | DMKHO.php | Kho (FK) |
| Model | laravel-simba | DMLO.php | Lo (FK) |
| SP | laravel-simba | AsINGetInventory.php | Get |
| SP | laravel-simba | AsINUpdInventory.php | Update |
| Service | laravel-catalog | InventoryService.php | Business logic |
| Component | laravel-catalog | Hangtonkho.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model Inventory
- [ ] Tao InventoryService
- [ ] Tao Livewire Hangtonkho (list)
- [ ] Tao Views (list + detail)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test kiem tra ton kho
- [ ] Test canh bao ton toi thieu/toi da
- [ ] Test tong hop ton kho

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.59`
