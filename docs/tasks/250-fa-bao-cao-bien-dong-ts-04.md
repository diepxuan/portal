# Task 250: FARptBCTS04

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao bien dong tai san 04 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCTS04.dll
- **Chuc nang:** Bao cao bien dong tai san 04
- **Loai:** Bao cao (Report)
- **Assembly Title:** FARptBCTS04
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCTS04.dll/README.md`

---

## Form classes

### frmFARptBCTS04 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao bien dong tai san

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
| cboNhom_cap1 | AsComboBox | - | Nhom cap 1 |
| cboNhom_cap2 | AsComboBox | - | Nhom cap 2 |
| cboNhom_cap3 | AsComboBox | - | Nhom cap 3 |
| cboKyBc | ComboBox | - | Ky bao cao |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtTieu_De | TextBox | - | Tieu de |

### Nhom cap items

| Value | Text |
|-------|-------|
| Ma_bpsd | Bo phan su dung |
| ma_phi | Phi |
| ma_spct | San pham CT |
| ma_nhts1 | Nhom tai san 1 |
| ma_nhts2 | Nhom tai san 2 |
| ma_nhts3 | Nhom tai san 3 |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_RPT_BCTS04_GET | Lay du lieu bao cao bien dong tai san 04 |

---

## Business Logic

### Business Rules

1. **Nhom 3 cap**:
   - cboNhom_cap1 (required)
   - cboNhom_cap2 (dependent, exclude cap1)
   - cboNhom_cap3 (dependent, exclude cap1+2)

2. **Loc theo 3 cap nhom TS**:
   - MA_NHTS1/2/3

3. **Khoang ngay**:
   - Tu ngay - den ngay

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/BienDongTaisan04.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class BienDongTaisan04 extends Component
{
    const MA_CT = 'FA';

    public string $pMa_Ts = '';
    public string $pMa_Nhts1 = '';
    public string $pMa_Nhts2 = '';
    public string $pMa_Nhts3 = '';
    public string $pMa_Bpsd = '';
    public string $pMa_Phi = '';
    public string $pMa_Spct = '';
    public string $pNhom_cap1 = '';
    public string $pNhom_cap2 = '';
    public string $pNhom_cap3 = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pKyBc = '';
    public string $pTieu_De = '';

    public function updatedPNhomCap1(string $value): void
    {
        // Filter cap2 options
    }

    public function render(): View
    {
        return view('catalog::fa.baocao.bien-dong-taisan-04');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | BienDongTaisan04.php | Filter form |
| SP | laravel-simba | AsFARptBCTS04.php | Data source |
| View | laravel-catalog | bien-dong-taisan-04.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire BienDongTaisan04
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test cascade dropdown
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
