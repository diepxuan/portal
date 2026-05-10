# Task 251: FARptBCTS05

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao bien dong tai san 05 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCTS05.dll
- **Chuc nang:** Bao cao bien dong tai san 05
- **Loai:** Bao cao (Report)
- **Assembly Title:** FARptBCTS05
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCTS05.dll/README.md`

---

## Form classes

### frmFARptBCTS05 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao bien dong tai san

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_BPSD | AsTextBox | MA_BPSD | Ma bo phan su dung |
| txtMa_Phi | AsTextBox | MA_PHI | Ma phi |
| txtMa_SPCT | AsTextBox | MA_SPCT | Ma SPCT |
| cboKyBc | ComboBox | - | Ky bao cao |
| txtNgay1, txtNgay2 | DateTimePicker | - | Tu ngay - den ngay |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtTieu_De | TextBox | - | Tieu de |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_RPT_BCTS05_GET | Lay du lieu bao cao bien dong tai san 05 |

---

## Business Logic

### Business Rules

1. **3 tieu chi loc**:
   - BPSD (bo phan su dung)
   - Ma phi
   - Ma SPCT

2. **Khoang ngay**:
   - Tu ngay - den ngay

3. **Filter title**:
   - Hien thi ca ma va ten (format: "Ma: [code - name]")

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/BienDongTaisan05.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class BienDongTaisan05 extends Component
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
        return view('catalog::fa.baocao.bien-dong-taisan-05');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | BienDongTaisan05.php | Filter form |
| SP | laravel-simba | AsFARptBCTS05.php | Data source |
| View | laravel-catalog | bien-dong-taisan-05.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire BienDongTaisan05
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
