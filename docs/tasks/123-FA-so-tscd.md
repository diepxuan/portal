# Task 123: FARptSoTSCD

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang so tai san co dinh tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptSoTSCD.dll
- **Chuc nang:** So tai san co dinh
- **Loai:** Report (Bao cao)
- **Assembly Title:** So tai san co dinh
- **Version:** 12.1.3.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptSoTSCD.dll/README.md`

---

## Form classes

### frmFARptSoTSCD (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_ts | AsTextBox | Ma tai san |
| txtMa_nhts | AsTextBox | Ma nhom tai san |
| txtMa_bpsd | AsTextBox | Ma bo phan su dung |
| cboKyBc | ComboBox | Ky bao cao |
| cboMau_bc | ComboBox | Mau bao cao |
| txtTieu_De | TextBox | Tieu de bao cao |

---

## Business Logic

### Business Rules

1. **So tai san**: Bao cao theo doi TSCĐ theo thoi gian
2. **Loc theo nhieu tieu chi**: Tai san, nhom, bo phan

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/Sotaisanco dinh.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class Sotaisanco dinh extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'SoTSCD';

    public ?string $pMa_cty = '001';
    public ?string $pMa_ts = null;
    public ?string $pMa_nhts = null;
    public ?string $pMa_bpsd = null;
    public ?int $pKyBc = null;
    public ?int $pMau_bc = null;
    public string $pTieuDe = '';

    public function render(): View
    {
        return view('catalog::fa.reports.so-tai-san-co-dinh');
    }
}
```

### 2. Routes

```php
Route::get('/so-tai-san-co-dinh', [Sotaisanco dinh::class, 'render'])
    ->name('catalog.fa.reports.so-tai-san-co-dinh');
```

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FATSO | Tai san co dinh | Master |
| FAMHTS | Hao mon tai san | Transaction |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_SO_TSCD_GET` | Lay du lieu so TSCD |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_SO_TSCD_GET
- [ ] Tao Livewire Sotaisanco dinh
- [ ] Tao View so-tai-san-co-dinh.blade.php
- [ ] Them Routes