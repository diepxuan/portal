# Task 096: SIVchSI1

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang phieu nhap kho (SI1) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIVchSI1.dll
- **Chuc nang:** Phieu nhap kho (System Inventory)
- **Loai:** Voucher (VCH)
- **Assembly Title:** Phieu nhap kho
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN1 (Phieu nhap kho)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIVchSI1.dll/README.md`

---

## Cau truc du lieu

### Bang: IN1H (Phieu nhap kho)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu ban ghi (PK) |
| ma_ct | varchar | Ma chung tu (IN1) |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| ma_kh | varchar | Ma khach hang |
| ten_kh | nvarchar | Ten khach hang |
| nguoi_gd | nvarchar | Nguoi giao dich |
| dia_chi | nvarchar | Dia chi |
| dien_giai | nvarchar | Dien giai |
| ngay_lct | datetime | Ngay lap CT |
| ma_gd | int | Loai phieu nhap (1: TP, 2: Khac) |
| ma_nt | varchar | Ma ngoai te |
| ty_gia | decimal | Ty gia |
| t_tien_nt | decimal | Tong tien NT |
| t_tien | decimal | Tong tien |
| t_so_luong | decimal | Tong so luong |

---

## Form classes

### 1. frmInVchIN1 (Form nhap lieu)
- **Ke thua:** frmVoucher
- **Controls Header:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_kh | AsTextBox | Ma KH |
| txtTen_kh | Label | Ten KH |
| txtNguoi_gd | TextBox | Nguoi giao dich |
| txtDia_chi | TextBox | Dia chi |
| txtDien_giai | TextBox | Dien giai |
| cboMa_nt | ComboBox | Ma ngoai te |
| txtTy_gia | AsTextNumeric | Ty gia |
| cboLoai_phieu | ComboBox | Loai phieu nhap |

- **Controls Footer:**

| Control | Mo ta |
|---------|-------|
| txtT_tien_nt | Tong tien NT |
| txtT_tien | Tong tien |
| txtT_so_luong | Tong so luong |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_IN1H_GET | Lay danh sach |
| SP_SI_IN1H_GETBYID | Lay chi tiet |
| SP_SI_IN1H_INSERT | Them chung tu |
| SP_SI_IN1H_UPDATE | Cap nhat |
| SP_SI_IN1H_DELETE | Xoa |
| SP_SI_IN1H_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kh | 'Khach hang khong duoc trong' |
| Min 0 | so_luong | 'So luong >= 0' |

### Business Rules

1. **Loai phieu nhap**:
   - 1: Phieu nhap thanh pham
   - 2: Phieu nhap khac

2. **Ton kho**:
   - Tang ton kho khi nhap
   - Tinh gia trung binh

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/IN1H.php
namespace Diepxuan\Simba\Models\SI;

class IN1H extends Model
{
    protected $table = 'IN1H';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ct', 'ngay_ct', 'so_ct',
        'ma_kh', 'ten_kh', 'nguoi_gd', 'dia_chi',
        'dien_giai', 'ngay_lct', 'ma_gd',
        'ma_nt', 'ty_gia', 't_tien_nt', 't_tien',
        't_so_luong',
    ];

    public function chiTiets()
    {
        return $this->hasMany(IN1CT::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Voucher/PhieunhapkhoSi.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Voucher;

class PhieunhapkhoSi extends Component
{
    const MA_CT = 'IN1';

    public ?string $pStt_rec = null;
    public ?string $pMa_kh = null;
    public ?string $pNgay_ct = null;
    public int $pMa_gd = 1;
    public ?string $pMa_nt = 'VND';
    public float $pTy_gia = 1;
    public Collection $pChiTiets;

    public function mount(?string $stt_rec = null): void
    {
        $this->pChiTiets = collect([]);
    }

    public function render(): View
    {
        return view('catalog::si.voucher.phieunhapkhsi');
    }
}
```

### 3. Views

```
resources/views/catalog/si/voucher/
├── phieunhapkhsi.blade.php
└── _phieunhapkhsi-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/voucher')
    ->name('catalog.si.voucher.')
    ->group(function () {
        Route::get('/phieu-nhap-kho-si', [PhieunhapkhoSi::class, 'render'])
            ->name('phieunhapkhsi');
        Route::get('/phieu-nhap-kho-si/{stt_rec}', [PhieunhapkhoSi::class, 'render'])
            ->name('phieunhapkhsi.show');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | IN1H.php | Phieu nhap |
| Model | laravel-simba | IN1CT.php | Chi tiet |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Models IN1H, IN1CT
- [ ] Tao Livewire PhieunhapkhoSi
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD