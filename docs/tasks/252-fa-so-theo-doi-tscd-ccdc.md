# Task 252: FARptSoSD

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang so theo doi TSCD va CCDC tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptSoSD.dll
- **Chuc nang:** So theo doi TSCD va CCDC tai noi su dung
- **Loai:** Bao cao (Report)
- **Assembly Title:** So theo doi TSCD va CCDC tai noi su dung
- **Version:** 12.1.3.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptSoSD.dll/README.md`

---

## Form classes

### frmFARptSoSD (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in so theo doi TSCD & CCDC

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_ts | AsTextBox | MA_TS | Ma tai san |
| txtMa_cc | AsTextBox | MA_CC | Ma cong cu dung cu |
| txtMa_bpsd | AsTextBox | MA_BPSD | Ma bo phan su dung |
| cboKyBc | ComboBox | - | Ky bao cao |
| cboMau_bc | ComboBox | - | Mau bao cao |
| txtTieu_De | TextBox | - | Tieu de |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_RPT_SOSD_GET | Lay du lieu so theo doi TSCD & CCDC |

---

## Business Logic

### Business Rules

1. **Theo doi ca TSCD va CCDC**:
   - ma_ts: TSCD (tai san co dinh)
   - ma_cc: CCDC (cong cu dung cu)

2. **Bo phan su dung**:
   - Theo doi theo noi su dung

3. **Xuat bao cao**:
   - Xem, in, xuat Excel
   - Co xu ly Exception (try-catch)

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Baocao/SoTheoDoiTsCc.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Baocao;

class SoTheoDoiTsCc extends Component
{
    const MA_CT = 'FA';

    public string $pMa_Ts = '';
    public string $pMa_Cc = '';
    public string $pMa_Bpsd = '';
    public string $pKyBc = '';
    public string $pTieu_De = '';

    public function render(): View
    {
        return view('catalog::fa.baocao.so-theo-doi-ts-cc');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | SoTheoDoiTsCc.php | Filter form |
| SP | laravel-simba | AsFARptSoSD.php | Data source |
| View | laravel-catalog | so-theo-doi-ts-cc.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire SoTheoDoiTsCc
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
