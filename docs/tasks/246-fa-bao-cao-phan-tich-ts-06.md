# Task 246: FARptBCPT06

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 06 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT06.dll
- **Chuc nang:** Bao cao phan tich tai san 06
- **Loai:** Bao cao (Report)
- **Assembly Title:** FARptBCPT06
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT06.dll/README.md`

---

## Form classes

### frmFARptBCPT06 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao phan tich tai san

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_BPSD | AsTextBox | MA_BPSD | Ma bo phan su dung |
| txtMa_Phi | AsTextBox | MA_PHI | Ma phi |
| txtMa_SPCT | AsTextBox | MA_SPCT | Ma SPCT |
| cboKyBc | ComboBox | - | Ky bao cao |
| txtNgay1 | DateTimePicker | - | Ngay bat dau |
| txtNgay2 | DateTimePicker | - | Ngay ket thuc |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtTieu_De | TextBox | - | Tieu de |
| cmdOk | Button | - | Xem bao cao |
| cmdExcel | Button | - | Xuat Excel |
| cmdModifyReport | Button | - | Sua mau |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_RPT_BCPT06_GET | Lay du lieu bao cao phan tich tai san 06 |

---

## Business Logic

### Business Rules

1. **3 tieu chi loc**:
   - BPSD (bo phan su dung)
   - Ma phi
   - Ma SPCT

2. **Khoang ngay**:
   - Tu ngay - den ngay

3. **Xuat bao cao**:
   - Xem, in, xuat Excel

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/PhanTichTaisan06.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class PhanTichTaisan06 extends Component
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
        return view('catalog::fa.baocao.phan-tich-taisan-06');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | PhanTichTaisan06.php | Filter form |
| SP | laravel-simba | AsFARptBCPT06.php | Data source |
| View | laravel-catalog | phan-tich-taisan-06.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire PhanTichTaisan06
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
