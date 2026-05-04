# Task 248: FARptBCPT08

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 08 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT08.dll
- **Chuc nang:** Bao cao phan tich tai san 08
- **Loai:** Bao cao (Report)
- **Assembly Title:** FARptBCPT08
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT08.dll/README.md`

---

## Form classes

### frmFARptBCPT08 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao phan tich tai san chi tiet

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_ts | AsTextBox | MA_TS | Ma tai san |
| txtMa_Nhts1 | AsTextBox | MA_NHTS (loai_nh=1) | Ma nhom TS1 |
| txtMa_Nhts2 | AsTextBox | MA_NHTS (loai_nh=2) | Ma nhom TS2 |
| txtMa_Nhts3 | AsTextBox | MA_NHTS (loai_nh=3) | Ma nhom TS3 |
| txtMa_BPSD | AsTextBox | MA_BPSD | Ma BPSD |
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
| SP_FA_RPT_BCPT08_GET | Lay du lieu bao cao phan tich tai san 08 |

---

## Business Logic

### Business Rules

1. **Loc theo 3 cap nhom TS**:
   - MA_NHTS1 (loai_nh=1)
   - MA_NHTS2 (loai_nh=2)
   - MA_NHTS3 (loai_nh=3)

2. **6 tieu chi loc**:
   - Ma TS, 3 nhom TS, BPSD, phi, SPCT

3. **Khoang ngay**:
   - Tu ngay - den ngay

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/PhanTichTaisan08.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class PhanTichTaisan08 extends Component
{
    const MA_CT = 'FA';

    public string $pMa_Ts = '';
    public string $pMa_Nhts1 = '';
    public string $pMa_Nhts2 = '';
    public string $pMa_Nhts3 = '';
    public string $pMa_Bpsd = '';
    public string $pMa_Phi = '';
    public string $pMa_Spct = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pKyBc = '';
    public string $pTieu_De = '';

    public function render(): View
    {
        return view('catalog::fa.baocao.phan-tich-taisan-08');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | PhanTichTaisan08.php | Filter form |
| SP | laravel-simba | AsFARptBCPT08.php | Data source |
| View | laravel-catalog | phan-tich-taisan-08.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire PhanTichTaisan08
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation