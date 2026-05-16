# Task 017: APPost2TT

## Nhom: AP (Accounts Payable - Cong no phai tra)

## Muc tieu
Chuyen doi chuc nang phan bo thanh toan tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** APPost2TT.dll
- **Chuc nang:** Phan bo thanh toan cho hoa don mua hang
- **Loai:** Process (Phan bo)
- **Assembly Title:** ARPost2TT
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/APPost2TT.dll/README.md`

---

## Cau truc du lieu

### Bang: PH (Phieu chi/UNC header - nguon thanh toan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | So thu tu record |
| ma_kh | varchar | 50 | Ma nha cung cap |
| ten_kh | nvarchar | 200 | Ten nha cung cap |
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |
| t_tt | decimal | 18,2 | Tong tien VND |
| t_tt_nt | decimal | 18,2 | Tong tien NT |
| dien_giai | nvarchar | 500 | Dien giai |

### Bang: HD (Hoa don - dich vu phan bo)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec_hd | varchar | 50 | So thu tu hoa don |
| so_ct | varchar | 50 | So hoa don |
| ngay_ct | datetime | 8 | Ngay hoa don |
| tk_pt | varchar | 20 | TK phai tra |
| ma_kh | varchar | 50 | Ma NCC |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,4 | Ty gia |
| t_tt | decimal | 18,2 | Tong tien VND |
| t_tt_nt | decimal | 18,2 | Tong tien NT |
| tien_tt_nt | decimal | 18,2 | Da thanh toan NT |
| du_hd_nt | decimal | 18,2 | Con phai thanh toan NT |
| thanhtoan | decimal | 18,2 | So tien phan bo |
| tien_tt_qd | decimal | 18,2 | Thanh toan quy doi |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| APTT | So du dau ky | Lookup hoa don |
| DMKU | Danh muc khe uoc | Lookup KU |

---

## Form classes

### 1. frmAPPost2TT (Form phan bo chinh)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Hien thi danh sach hoa don, phan bo thanh toan
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboMa_Kh | AsComboBox | Ma nha cung cap |
| txtNgay_Ct | AsMaskedTextBox | Ngay chung tu |
| txtSo_Ct | TextBox | So chung tu |
| cboMa_NT | AsComboBoxNT | Ma ngoai te |
| txtTy_gia | AsTextNumeric | Ty gia |
| txtT_Tien | AsTextNumeric | Tong tien VND |
| txtT_tien_Nt | AsTextNumeric | Tong tien NT |
| dgvHD | DataGridView | Luoi hoa don |
| dgvPhanBo | DataGridView | Luoi phan bo |

### 2. frmAPPost2TTFind (Form tim kiem)
- **Chuc nang:** Tim kiem chung tu phan bo

### 3. frmAPPost2TTResult (Form ket qua)
- **Chuc nang:** Hien thi ket qua phan bo

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AP_POST2TT_GET_HD | Lay danh sach hoa don chua thanh toan |
| SP_AP_POST2TT_GET_PB | Lay danh sach phan bo |
| SP_AP_POST2TT_INSERT | Chen phan bo thanh toan |
| SP_AP_POST2TT_DELETE | Xoa phan bo thanh toan |

### SP_GET_HD (reference)

```sql
-- Lay hoa don chua thanh toan
EXEC SP_AP_POST2TT_GET_HD
    @pMa_cty VARCHAR(50) = '001',
    @pMa_kh VARCHAR(50),
    @pMa_nt VARCHAR(10) = 'VND'
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Ma nha cung cap khong duoc trong' |
| Required | so_ct | 'So chung tu khong duoc trong' |
| Positive | t_tien | 'So tien phan bo phai lon hon 0' |

### Business Rules

1. **Phan bo thanh toan**:
   - Tu dong tinh so tien con lai sau phan bo
   - Kiem tra tong phan bo khong vuot qua so tien thanh toan

2. **Tinh toan tien te**:
   - Chuyen doi NT sang VND theo ty gia
   - Lam tron theo cau hinh he thong

3. **Cap nhat trang thai**:
   - Khi hoan thanh phan bo -> cap nhat trang thai hoa don
   - Theo doi so tien da phan bo

---

## Mapping PHP

### 1. Model

```php
// app/Models/AP/Post2TT.php
namespace Diepxuan\Simba\Models\AP;

class Post2TT extends Model
{
    protected $table = 'APPost2TT';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec',
        'stt_rec_hd',
        'stt_rec_ct',
        'ma_kh',
        'ma_nt',
        'ty_gia',
        'thanhtoan',
        'thanhtoan_nt',
    ];

    protected $casts = [
        'thanhtoan' => 'decimal:2',
        'thanhtoan_nt' => 'decimal:2',
        'ty_gia' => 'decimal:4',
    ];

    // Relationships
    public function hoaDon()
    {
        return $this->belongsTo(APTT::class, 'stt_rec_hd', 'stt_rec');
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsAPGetPost2TTHD.php
namespace Diepxuan\Simba\StoredProcedures;

class AsAPGetPost2TTHD extends StoredProcedure
{
    protected $procedure = 'SP_AP_POST2TT_GET_HD';
    protected $params = ['pMa_cty', 'pMa_kh', 'pMa_nt'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsAPInsPost2TT.php
class AsAPInsPost2TT extends StoredProcedure
{
    protected $procedure = 'SP_AP_POST2TT_INSERT';
    protected $params = ['pMa_cty', 'stt_rec', 'stt_rec_hd', 'thanhtoan'];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AP/PhanboThanhtoan.php
namespace Diepxuan\Catalog\Http\Livewire\AP;

class PhanboThanhtoan extends Component
{
    const MA_CT = 'AP';

    public ?string $pMaKh = null;
    public string $pMaNt = 'VND';
    public float $pTyGia = 1;
    public Collection $pHoaDons;
    public Collection $pPhanBos;

    public function mount(): void
    {
        $this->loadHoaDon();
    }

    public function loadHoaDon(): void
    {
        // Load tu Stored Procedure
    }

    public function phanBo(float $soTien, array $hoaDonIds): void
    {
        // Logic phan bo thanh toan
    }

    public function render(): View
    {
        return view('catalog::ap.phanbo-thanhtoan');
    }
}
```

### 4. Views

```
resources/views/catalog/ap/
├── phanbo-thanhtoan.blade.php      (Form chinh)
└── _phanbo-row.blade.php           (Component row)
```

### 5. Routes

```php
Route::prefix('catalog/ap/phan-bo-thanh-toan')
    ->name('catalog.ap.phanbo.')
    ->group(function () {
        Route::get('/', [PhanboThanhtoan::class, 'render'])
            ->name('index');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | Post2TT.php | Chinh |
| Model | laravel-simba | APTT.php | Hoa don OB |
| Model | laravel-simba | DMKH.php | Khach hang NCC |
| SP | laravel-simba | AsAPGetPost2TTHD.php | Lay HD |
| SP | laravel-simba | AsAPInsPost2TT.php | Chen PB |
| Component | laravel-catalog | PhanboThanhtoan.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem & xac dinh cac bang lien quan
- [ ] Tao Model Post2TT
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire PhanboThanhtoan
- [ ] Tao Views (form + components)
- [ ] Them Routes
- [ ] Test phan bo thanh toan
- [ ] Test integration voi APTT
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.017`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
