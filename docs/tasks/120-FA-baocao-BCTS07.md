# Task 120: FARptBCTS07

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao cao bien dong tai san 07 tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FARptBCTS07.dll
- **Chuc nang:** Bao cao bien dong tai san 07
- **Loai:** Report (Bao cao)
- **Assembly Title:** FARptBCTS07
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FARptBCTS07.dll/README.md`

---

## Form classes

### frmFARptBCTS07 (Form bao cao)
- **Ke thua:** frmReport

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay | AsMaskedTextBox | Ngay bao cao |
| txtMa_TS | AsTextBox | Ma tai san |
| txtMa_nhts1 | AsTextBox | Ma nhom TS cap 1 |
| txtMa_nhts2 | AsTextBox | Ma nhom TS cap 2 |
| txtMa_nhts3 | AsTextBox | Ma nhom TS cap 3 |
| txtMa_Bp | AsTextBox | Ma bo phan |
| txtMa_Phi | AsTextBox | Ma phi |
| txtMa_Spct | AsTextBox | Ma SPCT |
| cboNhom_cap1 | AsComboBox | Nhom cap 1 |
| cboNhom_cap2 | AsComboBox | Nhom cap 2 |
| cboNhom_cap3 | AsComboBox | Nhom cap 3 |

### Nhom cap (GroupItem)

| Gia tri | Hien thi |
|---------|----------|
| "" | Khong nhom |
| "ma_bpsd" | Bo phan su dung |
| "ma_phi" | Phi |
| "ma_spct" | San pham cong trinh |
| "ma_nhts1" | Nhom tai san 1 |
| "ma_nhts2" | Nhom tai san 2 |
| "ma_nhts3" | Nhom tai san 3 |

---

## Business Logic

### Business Rules

1. **Nhom 3 cap**: Chon cach nhom cho cap 1, 2, 3
2. **Loai bo trung**: Khi chon cap2, loai bo gia tri da chon o cap1
3. **Bao cao tai ngay**: Khong phai bao cao theo ky ma la tai thoi diem

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Reports/BaocaoBiendo ng07.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Reports;

class Baocaobiendo ng07 extends Component
{
    const MA_CT = 'FA';
    const REPORT_TYPE = 'BCTS07';

    public ?Carbon $pNgay = null;
    public ?string $pMa_TS = null;
    public ?string $pMa_nhts1 = null;
    public ?string $pMa_nhts2 = null;
    public ?string $pMa_nhts3 = null;
    public ?string $pMa_Bp = null;
    public ?string $pMa_Phi = null;
    public ?string $pMa_Spct = null;
    public array $pNhomOptions = [];
    public ?string $pCap1 = '';
    public ?string $pCap2 = '';
    public ?string $pCap3 = '';

    public function mount(): void
    {
        $this->pNhomOptions = [
            '' => 'Khong nhom',
            'ma_bpsd' => 'Bo phan su dung',
            'ma_phi' => 'Phi',
            'ma_spct' => 'San pham cong trinh',
            'ma_nhts1' => 'Nhom tai san 1',
            'ma_nhts2' => 'Nhom tai san 2',
            'ma_nhts3' => 'Nhom tai san 3',
        ];
    }

    public function updatedPCap1($value): void
    {
        // Loc cap2, cap3: loai bo gia tri da chon o cap1
    }

    public function render(): View
    {
        return view('catalog::fa.reports.baocao-bien-dong-07');
    }
}
```

### 2. Routes

```php
Route::get('/bao-cao-bien-dong-07', [Baocaobiendo ng07::class, 'render'])
    ->name('catalog.fa.reports.bien-dong-07');
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
| `FA_BCTS07_GET` | Lay du lieu bien dong 07 |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/reporting | CrystalReport | Xem bao cao |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_BCTS07_GET
- [ ] Tao Livewire Baocaobiendo ng07
- [ ] Tao View baocao-bien-dong-07.blade.php
- [ ] Them Routes
- [ ] Test logic nhom 3 cap