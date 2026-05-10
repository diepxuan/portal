# Task 079: POTAIN

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang danh muc thue dau vao tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** POTAIN.dll
- **Chuc nang:** Danh muc thue dau vao (Thuế GTGT mua vào)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Thuế đầu vào
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** TAI (Thuế đầu vào)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/POTAIN.dll/README.md`

---

## Cau truc du lieu

### Bang: DMTAIN (Danh muc thue dau vao)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_ct | varchar | Ma chung tu (TAI) |
| stt_rec | varchar | So thu tu ban ghi (PK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| so_ct | varchar | So chung tu |
| ngay_ct | datetime | Ngay chung tu |
| ma_nt | varchar | Ma ngoai te |
| ty_gia | decimal | Ty gia |
| t_tien_nt | decimal | Tien NT |
| t_tien | decimal | Tien |
| t_thue_nt | decimal | Thue NT |
| t_thue | decimal | Thue |
| tk_thue | varchar | TK thue |
| dien_giai | nvarchar | Dien giai |

---

## Form classes

### 1. frmPOTaIn (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach thue dau vao
- ** Dac diem**:
   - An txtValue, cboFilter, lblTen, cmdSearch
   - An cmdChgCode
   - Chi cho phep sua/xoa ma_ct = "TAI"

### 2. frmPOTAINEdit (Form them/sua)
- **Chuc nang:** Nhap, sua thong tin thue dau vao

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_TAIN_GET | Lay danh sach |
| SP_PO_TAIN_GETBYID | Lay chi tiet |
| SP_PO_TAIN_INSERT | Them moi |
| SP_PO_TAIN_UPDATE | Cap nhat |
| SP_PO_TAIN_DELETE | Xoa |
| SP_PO_TAIN_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| ma_ct = "TAI" | ma_ct | 'Chi cho phep sua/xoa TAI' |

### Business Rules

1. **Han che sua/xoa**:
   - Chi cho phep sua/xoa ban ghi co ma_ct = "TAI"
   - Ma loi 50139: Khong cho phep sua
   - Ma loi 50140: Khong cho phep xoa

2. **Lien ket voi chung tu**:
   - stt_rec0 lien ket voi chung tu goc (PO3, PO4...)

3. **Tinh toan thue**:
   - Tien = Tien_nt * Ty_gia
   - Thue = Tien * Thue_suat

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/DMTAIN.php
namespace Diepxuan\Simba\Models\PO;

class DMTAIN extends Model
{
    protected $table = 'DMTAIN';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_ct',
        'stt_rec',
        'stt_rec0',
        'so_ct',
        'ngay_ct',
        'ma_nt',
        'ty_gia',
        't_tien_nt',
        't_tien',
        't_thue_nt',
        't_thue',
        'tk_thue',
        'dien_giai',
    ];

    protected $casts = [
        'ngay_ct' => 'datetime',
        'ty_gia' => 'decimal:8',
        't_tien_nt' => 'decimal:8',
        't_tien' => 'decimal:8',
        't_thue_nt' => 'decimal:8',
        't_thue' => 'decimal:8',
    ];

    // Scope: chi lay TAI
    public function scopeThuếĐầuVào($query)
    {
        return $query->where('ma_ct', 'TAI');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Danhmuc/ThueDauvao.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Danhmuc;

class ThueDauvao extends Component
{
    const MA_CT = 'TAI';

    public Collection $pDanhSach;

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->pDanhSach = DMTAIN::thuếĐầuVào()
            ->orderBy('ngay_ct', 'desc')
            ->paginate(50);
    }

    public function render(): View
    {
        return view('catalog::po.danhmuc.thuedauvao');
    }
}
```

### 3. Views

```
resources/views/catalog/po/danhmuc/
├── thuedauvao.blade.php
└── _thuedauvao-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/danhmuc')
    ->name('catalog.po.danhmuc.')
    ->group(function () {
        Route::get('/thue-dau-vao', [ThueDauvao::class, 'render'])
            ->name('thuedauvao');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMTAIN.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMTAIN
- [ ] Tao Livewire ThueDauvao
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test chi hien thi TAI
- [ ] Test khong cho sua ma_ct khac TAI
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
