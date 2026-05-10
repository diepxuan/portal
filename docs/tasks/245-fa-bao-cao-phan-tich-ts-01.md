# Task 245: FARptBCPT01

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san 01 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT01.dll
- **Chuc nang:** Bao cao phan tich tai san 01
- **Loai:** Bao cao (Report)
- **Assembly Title:** FARptBCTS02
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT01.dll/README.md`

---

## Form classes

### frmFARptBCPT01 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao phan tich tai san

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_ts | AsTextBox | MA_TS | Ma tai san |
| txtMa_Nhts1 | AsTextBox | MA_NHTS (loai_nh=1) | Ma nhom TS1 |
| txtMa_Nhts2 | AsTextBox | MA_NHTS (loai_nh=2) | Ma nhom TS2 |
| txtMa_Nhts3 | AsTextBox | MA_NHTS (loai_nh=3) | Ma nhom TS3 |
| txtMa_BPSD | AsTextBox | MA_BPSD | Ma bo phan su dung |
| txtMa_Phi | AsTextBox | MA_PHI | Ma phi |
| txtMa_SPCT | AsTextBox | MA_SPCT | Ma SPCT |
| cboTheo_nhom | ComboBox | - | Nhom theo |
| cboKyBc | ComboBox | - | Ky bao cao |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtTieu_De | TextBox | - | Tieu de bao cao |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_RPT_BCPT01_GET | Lay du lieu bao cao phan tich tai san 01 |

---

## Business Logic

### Business Rules

1. **Loc theo 3 cap nhom TS**:
   - MA_NHTS1 (loai_nh=1)
   - MA_NHTS2 (loai_nh=2)
   - MA_NHTS3 (loai_nh=3)

2. **Nhom theo**:
   - BP su dung
   - Ma phi
   - Ma SPCT

3. **Xuat bao cao**:
   - Xem truoc
   - Xuat Excel
   - Sua mau bao cao

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/PhanTichTaisan01.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class PhanTichTaisan01 extends Component
{
    const MA_CT = 'FA';

    public string $pMa_Ts = '';
    public string $pMa_Nhts1 = '';
    public string $pMa_Nhts2 = '';
    public string $pMa_Nhts3 = '';
    public string $pMa_Bpsd = '';
    public string $pMa_Phi = '';
    public string $pMa_Spct = '';
    public string $pKyBc = '';
    public string $pTieu_De = '';

    public function render(): View
    {
        return view('catalog::fa.baocao.phan-tich-taisan-01');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | PhanTichTaisan01.php | Filter form |
| SP | laravel-simba | AsFARptBCPT01.php | Data source |
| View | laravel-catalog | phan-tich-taisan-01.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire PhanTichTaisan01
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
