# Task 247: FARptBCPT07

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 07 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT07.dll
- **Chuc nang:** Bao cao phan tich tai san 07
- **Loai:** Bao cao (Report)
- **Assembly Title:** FARptBCPT07
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT07.dll/README.md`

---

## Form classes

### frmFARptBCPT07 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao phan tich tai san (theo nguon von)

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_BPSD | AsTextBox | MA_BPSD | Ma bo phan su dung |
| txtMa_Phi | AsTextBox | MA_PHI | Ma phi |
| txtMa_SPCT | AsTextBox | MA_SPCT | Ma SPCT |
| txtNgay1 | AsMaskedTextBox | - | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | - | Ngay ket thuc |
| cboKyBc | ComboBox | - | Ky bao cao |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtTieu_De | TextBox | - | Tieu de |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_RPT_BCPT07_GET | Lay du lieu bao cao phan tich tai san 07 |

---

## Business Logic

### Business Rules

1. **Bao cao theo nguon von**:
   - Phan tich theo 4 nguon von (strNV1-4)
   - Hien thi theo BPSD, phi, SPCT

2. **Khoang ngay**:
   - Tu ngay - den ngay

3. **Xuat bao cao**:
   - Xem, in, xuat Excel

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/PhanTichTaisan07.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class PhanTichTaisan07 extends Component
{
    const MA_CT = 'FA';

    public string $pMa_Bpsd = '';
    public string $pMa_Phi = '';
    public string $pMa_Spct = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pKyBc = '';
    public string $pTieu_De = '';

    public function render(): View
    {
        return view('catalog::fa.baocao.phan-tich-taisan-07');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | PhanTichTaisan07.php | Filter form |
| SP | laravel-simba | AsFARptBCPT07.php | Data source |
| View | laravel-catalog | phan-tich-taisan-07.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire PhanTichTaisan07
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `fa.rpt.bcpt07`
- **Note:** Shell/voucher; write blocked until payload audit.
