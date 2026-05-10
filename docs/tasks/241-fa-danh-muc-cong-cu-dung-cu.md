# Task 241: FADMCC

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang danh muc cong cu dung cu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADMCC.dll
- **Chuc nang:** Quan ly danh muc cong cu dung cu
- **Loai:** Danh muc (DM)
- **Assembly Title:** FADMCC
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Danh muc)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADMCC.dll/README.md`

---

## Cau truc du lieu

### Bang: DMCC (Danh muc cong cu dung cu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_cc | varchar | 50 | Ma cong cu (khoa chinh) |
| ten_cc | nvarchar | 200 | Ten cong cu |
| dvt | varchar | 20 | Don vi tinh |
| so_luong | decimal | 18,6 | So luong |
| don_gia | decimal | 18,2 | Don gia |
| ng_gia | decimal | 18,2 | Nguyen gia (auto: SL * DG) |
| so_ky | int | 4 | So ky phan bo |
| gt_da_kh | decimal | 18,2 | GT da phan bo |
| gt_cl | decimal | 18,2 | GT con lai |
| kh_ky | decimal | 18,2 | Phan bo 1 ky |
| tk_cc | varchar | 20 | TK phan bo |
| tk_cp | varchar | 20 | TK chi phi |
| ngay_bdkh | datetime | 8 | Ngay bat dau PB |
| ngay_gt_cl | datetime | 8 | Ngay ghi nhan GTCL |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 50 | So chung tu |
| ma_phi | varchar | 50 | Ma phi |
| ma_spct | varchar | 50 | Ma SPCT |
| ma_bpsd | varchar | 50 | Ma bo phan su dung |
| sua_kh | bit | 1 | Cho phep sua PB |
| stt_rec | varchar | 50 | STT record |

---

## Form classes

### 1. frmFADMCC (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach CCDC

### 2. frmFADMCCEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:** Tuong tu FADMTS nhung don gian hon

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_DMCC_GET | Lay danh sach CCDC |
| SP_FA_DMCC_GETBYID | Lay chi tiet 1 CCDC |
| SP_FA_DMCC_INSERT | Them CCDC |
| SP_FA_DMCC_UPDATE | Cap nhat CCDC |
| SP_FA_DMCC_DELETE | Xoa CCDC |
| SP_FA_DMCC_FIND | Tim kiem CCDC |
| SP_FA_DMCC_CHECK | Kiem tra trung ma |

---

## Business Logic

### Business Rules

1. **Tinh toan tu dong**:
   - ng_gia = so_luong * don_gia
   - gt_cl = ng_gia - gt_da_kh
   - kh_ky = gt_cl / so_ky

2. **Phan bo CCDC**:
   - Theo ky (so_ky)
   - Tk phan bo, TK chi phi

3. **Sua phan bo**:
   - sua_kh = 1: Nhap tay kh_ky
   - sua_kh = 0: Tinh tu dong

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/DMCC.php
namespace Diepxuan\Simba\Models\FA;

class DMCC extends Model
{
    protected $table = 'DMCC';
    protected $primaryKey = 'ma_cc';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cc', 'ten_cc', 'dvt', 'so_luong', 'don_gia', 'ng_gia',
        'so_ky', 'gt_da_kh', 'gt_cl', 'kh_ky', 'tk_cc', 'tk_cp',
        'ngay_bdkh', 'ngay_gt_cl', 'ngay_ct', 'so_ct',
        'ma_phi', 'ma_spct', 'ma_bpsd', 'sua_kh', 'stt_rec',
    ];

    protected $casts = [
        'so_luong' => 'decimal:6',
        'don_gia' => 'decimal:2',
        'ng_gia' => 'decimal:2',
        'gt_da_kh' => 'decimal:2',
        'gt_cl' => 'decimal:2',
        'kh_ky' => 'decimal:2',
        'sua_kh' => 'boolean',
    ];
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/Congcu.php
class Congcu extends Component
{
    const MA_CT = 'FA';
    // List component
}

// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/CongcuEdit.php
class CongcuEdit extends Component
{
    // Edit modal component
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMCC.php | Chinh |
| SP | laravel-simba | AsFAGetDMCC.php | Get |
| SP | laravel-simba | AsFAInsDMCC.php | Insert |
| Component | laravel-catalog | Congcu.php | List |
| Component | laravel-catalog | CongcuEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMCC
- [ ] Tao Livewire Congcu (list)
- [ ] Tao Livewire CongcuEdit (modal)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test auto calculation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
