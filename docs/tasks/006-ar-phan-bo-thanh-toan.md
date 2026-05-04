# Task 006: ARPost2TT

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang phan bo thanh toan tu .NET sang PHP Laravel, dat ket qua tuong duong ARPost2TT.

## Chi tiet
- **DLL:** ARPost2TT.dll
- **Chuc nang:** Phan bo cac khoan thanh toan tu khach hang vao cac hoa don cong no tuong ung
- **Loai:** Phan bo thanh toan (Post to Transaction)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARPost2TT.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| ARTT | So du dau ky | FK ma_kh, chua hoa don dau ky |
| ARPost2TT | Bang phan bo thanh toan | Header phan bo |
| ARPost2TTCT | Chi tiet phan bo | Chi tiet tung dong |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ma_kh |
| ARTT | Hoa don | Lookup ma_hd, tinh du_hd_nt |
| DMTK | Tai khoan | Lookup ma_tk |

---

## Form classes

### 1. frmARPost2TT (Form phan bo thanh toan)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Nhap thong tin phan bo thanh toan, xem danh sach hoa don, xu ly phan bo
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Kh | AsTextBox | Ma khach hang (AutoLookup) |
| lblTen_Kh | Label | Ten khach hang |
| txtMa_Tk | AsTextBox | Tai khoan cong no (AutoLookup) |
| lblTen_Tk | Label | Ten tai khoan |
| dgvHoaDon | DataGridView | Danh sach hoa don chua thanh toan |
| txtTien_TT | AsTextNumeric | So tien thanh toan |
| btnProcess | Button | Nut xu ly phan bo |
| btnSave | Button | Nut luu |
| btnCancel | Button | Nut huy |

### 2. frmARPost2TTFind (Form tim kiem)
- **Ke thua:** (khong xac dinh)
- **Chuc nang:** Tim kiem phan bo thanh toan

### 3. frmARPost2TTResult (Form ket qua)
- **Ke thua:** (khong xac dinh)
- **Chuc nang:** Hien thi ket qua phan bo

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_POST2TT_GETHD | Lay danh sach hoa don chua thanh toan |
| SP_AR_POST2TT_GET | Lay danh sach phan bo thanh toan |
| SP_AR_POST2TT_INSERT | Tao phan bo thanh toan moi |
| SP_AR_POST2TT_DELETE | Xoa phan bo thanh toan |
| SP_AR_POST2TT_FIND | Tim kiem phan bo |
| SP_AR_POST2TT_PROCESS | Xu ly phan bo tu dong |

### SP_GETHD (reference)

```sql
-- Lay danh sach hoa don chua thanh toan
EXEC SP_AR_POST2TT_GETHD
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50),
    @pMa_tk VARCHAR(50) = NULL
```

### SP_PROCESS (reference)

```sql
-- Xu ly phan bo tu dong
EXEC SP_AR_POST2TT_PROCESS
    @pMa_cty VARCHAR(50),
    @pMa_kh VARCHAR(50),
    @pMa_tk VARCHAR(50) = NULL,
    @pTien_tt DECIMAL(18,2),
    @pMa_nt VARCHAR(10) = 'VND',
    @pTy_gia DECIMAL(18,4) = 1,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Quy trinh phan bo thanh toan

1. **Chon khach hang**:
   - AutoLookup tra ve danh sach KH hoat dong
   - Hien thi ten KH sau khi chon

2. **Hien thi danh sach hoa don**:
   - Lay cac hoa don cua KH co du_hd_nt > 0
   - Sap xep theo ngay hoa don (cu nhat truoc)
   - Hien thi: so_ct, ngay_ct, tong_tt_nt, da_tt_nt, con_phai

3. **Nhap so tien thanh toan**:
   - Nhap so tien khach hang tra
   - Kiem tra so tien hop le (khong am)

4. **Phan bo tu dong** (FIFO - First In First Out):
   - Uu tien hoa don cu nhat (ngay_ct nho nhat)
   - Phan bo cho den khi het so tien thanh toan
   - Khong phan bo vuot qua so con phai thu cua hoa don

5. **Luu ket qua**:
   - Tao phan bo thanh toan vao bang ARPost2TT
   - Cap nhat lai tien_tt_nt trong ARTT

### Tinh toan

```
So tien con phai thu hoa don = du_hd_nt - da_tt_nt
So tien phan bo toi da = min(So tien TT, So tien con phai)
```

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma khach hang khong duoc trong' |
| Valid customer | ma_kh | 'Ma khach hang khong ton tai' |
| Positive amount | tien_tt | 'So tien thanh toan phai lon hon 0' |
| Not exceed | tien_tt | 'So tien vuot qua so du phai thu' |

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/ARPost2TT.php
namespace Diepxuan\Simba\Models\AR;

class ARPost2TT extends Model
{
    protected $table = 'ARPost2TT';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec',
        'ngay_ct',
        'so_ct',
        'ma_kh',
        'ma_tk',
        'ma_nt',
        'ty_gia',
        'tong_tien_nt',
        'tong_tien',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'tong_tien_nt' => 'decimal:2',
        'tong_tien' => 'decimal:2',
        'ty_gia' => 'decimal:4',
    ];

    // Relationships
    public function chiTiet()
    {
        return $this->hasMany(ARPost2TTCT::class, 'stt_rec', 'stt_rec');
    }

    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
}

// app/Models/AR/ARPost2TTCT.php
class ARPost2TTCT extends Model
{
    protected $table = 'ARPost2TTCT';
    protected $primaryKey = ['stt_rec', 'stt_rec_hd'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec',
        'stt_rec_hd',
        'ps_no_nt',
        'ps_no',
    ];
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARGetPost2TTHD.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARGetPost2TTHD extends StoredProcedure
{
    protected $procedure = 'SP_AR_POST2TT_GETHD';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pMa_tk',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARProcessPost2TT.php
class AsARProcessPost2TT extends StoredProcedure
{
    protected $procedure = 'SP_AR_POST2TT_PROCESS';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pMa_tk',
        'pTien_tt',
        'pMa_nt',
        'pTy_gia',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARInsPost2TT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsARDelPost2TT.php
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Phanbo/ThanhToan.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Phanbo;

class ThanhToan extends Component
{
    const MA_CT = 'AR';

    public ?string $pMaKh = null;
    public ?string $pTenKh = null;
    public ?string $pMaTk = null;
    public ?string $pTenTk = null;
    public float $pTienTt = 0;
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public Collection $pHoaDonList;
    public array $pAllocationResults = [];

    public function mount(): void
    {
        $this->pHoaDonList = collect();
    }

    public function updatedPMaKh($value): void
    {
        if ($value) {
            $kh = DMKH::find($value);
            $this->pTenKh = $kh?->ten_kh;
            $this->loadHoaDonChuaThanhToan();
        }
    }

    public function loadHoaDonChuaThanhToan(): void
    {
        $sp = new AsARGetPost2TTHD();
        $this->pHoaDonList = $sp->execute([
            'pMa_cty' => '001',
            'pMa_kh' => $this->pMaKh,
            'pMa_tk' => $this->pMaTk,
        ]);
    }

    public function processAllocation(): void
    {
        $sp = new AsARProcessPost2TT();
        $results = $sp->execute([
            'pMa_cty' => '001',
            'pMa_kh' => $this->pMaKh,
            'pMa_tk' => $this->pMaTk,
            'pTien_tt' => $this->pTienTt,
            'pMa_nt' => $this->pMaNt,
            'pTy_gia' => $this->pTyGia,
        ]);
        $this->pAllocationResults = $results;
        $this->loadHoaDonChuaThanhToan(); // Refresh
    }

    public function render(): View
    {
        return view('catalog::ar.phanbo.thanh-toan');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/phanbo/
├── thanh-toan.blade.php        (Form phan bo chinh)
├── thanh-toan-results.blade.php (Ket qua phan bo)
└── _hoa-don-row.blade.php      (Dong hoa don)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/phanbo')
    ->name('catalog.ar.phanbo.')
    ->group(function () {
        Route::get('/thanh-toan', [ThanhToan::class, 'render'])
            ->name('thanh-toan');
        Route::post('/thanh-toan/process', [ThanhToan::class, 'processAllocation'])
            ->name('thanh-toan.process');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ARPost2TT.php | Header phan bo |
| Model | laravel-simba | ARPost2TTCT.php | Chi tiet phan bo |
| Model | laravel-simba | ARTT.php | Hoa don goc |
| Model | laravel-simba | DMKH.php | Lookup KH |
| SP | laravel-simba | AsARGetPost2TTHD.php | Lay HD chua TT |
| SP | laravel-simba | AsARProcessPost2TT.php | Xu ly phan bo |
| SP | laravel-simba | AsARInsPost2TT.php | Tao phan bo |
| Component | laravel-catalog | ThanhToan.php | Form phan bo |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Model ARPost2TT, ARPost2TTCT
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire ThanhToan
- [ ] Tao Views (phan bo form)
- [ ] Them Routes
- [ ] Implement logic phan bo FIFO
- [ ] Test phan bo thanh toan