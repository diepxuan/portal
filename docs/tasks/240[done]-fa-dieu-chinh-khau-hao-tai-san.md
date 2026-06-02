# Task 240: FAAdjustKHTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang dieu chinh khau hao tai san tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FAAdjustKHTS.dll
- **Chuc nang:** Dieu chinh khau hao tai san co dinh
- **Loai:** Danh muc / Edit
- **Assembly Title:** Dieu chinh khau hao tai san
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** FA (Edit)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FAAdjustKHTS.dll/README.md`

---

## Form classes

### 1. frmFAAdjustKHTSFilter (Form chon ky/tai san)
- **Ke thua:** frmDMFilter
- **Chuc nang:** Chon thang va tai san

### 2. frmFAAdjustKHTS (Form danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach

### 3. frmFAAdjustKHTSEdit (Form nhap dieu chinh)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap gia tri dieu chinh

### Edit Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_Ts | TextBox | Ma tai san (readonly) |
| txtTen_Ts | TextBox | Ten tai san (readonly) |
| txtMa_Ts_Tgng | TextBox | Ma TS tang giam nguyen gia |
| txtT_Ng_Gia | TextBox | Tong nguyen gia (readonly) |
| txtT_Gt_Da_Kh | TextBox | Tong GT da KH (readonly) |
| txtT_Gt_Cl | TextBox | Tong GT con lai (readonly) |
| chkSua_Kh | CheckBox | Cho phep sua khau hao |
| txtKh_N1 | NumericTextBox | KH nguon von 1 |
| txtKh_N2 | NumericTextBox | KH nguon von 2 |
| txtKh_N3 | NumericTextBox | KH nguon von 3 |
| txtKh_N4 | NumericTextBox | KH nguon von 4 |
| txtT_Kh_Th | TextBox | Tong KH thang (auto) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_ADJUST_KHTS_GET | Lay danh sach dieu chinh |
| SP_FA_ADJUST_KHTS_UPDATE | Cap nhat dieu chinh KH |

---

## Business Logic

### Business Rules

1. **4 nguon von**:
   - nv1, nv2, nv3, nv4
   - Tong KH = kh_n1 + kh_n2 + kh_n3 + kh_n4

2. **Sua khau hao thu cong**:
   - Checkbox cho phep nhap tay
   - Tinh tu dong khi khong sua

3. **Hien thi chi doc**:
   - Nguyen gia (readonly)
   - GT da KH (readonly)
   - GT con lai (readonly)

---

## Mapping PHP

### 1. Model (Adjustment)

```php
// app/Models/FA/FADIEUCHINHKH.php
namespace Diepxuan\Simba\Models\FA;

class FADIEUCHINHKH extends Model
{
    protected $table = 'FADIEUCHINHKH';
    protected $primaryKey = 'stt_rec';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ts', 'ngay', 'thang', 'nam',
        'kh_n1', 'kh_n2', 'kh_n3', 'kh_n4', 't_kh_th',
        'sua_kh',
    ];
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Dieuchinh/DieuChinhKhauHao.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Dieuchinh;

class DieuChinhKhauHao extends Component
{
    const MA_CT = 'FA';

    public string $pKyBc = '';
    public string $pMa_Ts = '';
    public string $pTen_Ts = '';
    public string $pT_Ng_Gia = '';
    public string $pT_Gt_Da_Kh = '';
    public string $pT_Gt_Cl = '';
    public bool $pSua_Kh = false;
    public string $pKh_N1 = '';
    public string $pKh_N2 = '';
    public string $pKh_N3 = '';
    public string $pKh_N4 = '';
    public string $pT_Kh_Th = '';

    public function updatedPSuaKh(bool $value): void
    {
        // Enable/disable input fields
    }

    public function updatedPKhN1(string $value): void
    {
        $this->recalculateTotal();
    }

    public function render(): View
    {
        return view('catalog::fa.dieuchinh.dieu-chinh-khau-hao');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | FADIEUCHINHKH.php | Adjustment |
| SP | laravel-simba | AsFAAdjustKHTS.php | Data source |
| Component | laravel-catalog | DieuChinhKhauHao.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model FADIEUCHINHKH
- [ ] Tao Livewire DieuChinhKhauHao
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test adjustment operations
- [ ] Test recalculate total
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `fa.vch.dieuchinhkh`
- **Note:** Shell/voucher; write blocked until payload audit.
