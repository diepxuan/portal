# Task 249: FARptBCPT10

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao phan tich tai san va cong cu 10 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCPT10.dll
- **Chuc nang:** Bao cao phan tich tai san & cong cu 10
- **Loai:** Bao cao (Report)
- **Assembly Title:** FARptBCPT10
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCPT10.dll/README.md`

---

## Form classes

### frmFARptBCPT10 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao phan tich TS & CCDC

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| cboTheo_nhom | ComboBox | - | Nhom theo (BP/PHI/SPCT) |
| txtMa_BPSD | AsTextBox | MA_BPSD | Ma BPSD |
| txtMa_cc | AsTextBox | MA_CC | Ma cong cu |
| txtMa_phi | AsTextBox | MA_phi | Ma phi |
| txtMa_spct | AsTextBox | MA_SPCT | Ma SPCT |
| txtTK_PB | AsTextBox | TK | TK phan bo |
| txtTK_CP | AsTextBox | TK | TK chi phi |
| txtNgay1 | AsMaskedTextBox | - | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | - | Ngay ket thuc |
| cboKyBc | ComboBox | - | Ky bao cao |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtTieu_De | TextBox | - | Tieu de |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_RPT_BCPT10_GET | Lay du lieu bao cao phan tich TS/CC 10 |

---

## Business Logic

### Business Rules

1. **Bao cao tich hop TS + CCDC**:
   - Phan tich ca tai san va cong cu
   - Tich hop tai khoan (TK_PB, TK_CP)

2. **Nhom theo**:
   - BP su dung
   - Ma phi
   - Ma SPCT

3. **Tai khoan**:
   - TK phan bo (TK_PB)
   - TK chi phi (TK_CP)

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/PhanTichTsCc10.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class PhanTichTsCc10 extends Component
{
    const MA_CT = 'FA';

    public int $pTheo_nhom = 0;
    public string $pMa_Bpsd = '';
    public string $pMa_Cc = '';
    public string $pMa_Phi = '';
    public string $pMa_Spct = '';
    public string $pTk_Pb = '';
    public string $pTk_Cp = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pKyBc = '';
    public string $pTieu_De = '';

    public function render(): View
    {
        return view('catalog::fa.baocao.phan-tich-ts-cc-10');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | PhanTichTsCc10.php | Filter form |
| SP | laravel-simba | AsFARptBCPT10.php | Data source |
| View | laravel-catalog | phan-tich-ts-cc-10.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire PhanTichTsCc10
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
