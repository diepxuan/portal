# Task 135: FADelTS2GL

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang xoa but toan phan bo tai san co dinh sang General Ledger tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADelTS2GL.dll
- **Chuc nang:** Xoa but toan phan bo tai san co dinh sang GL
- **Loai:** Transfer (Chuyen doi)
- **Assembly Title:** Xoa but toan phan bo tai san co dinh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (transfer)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADelTS2GL.dll/README.md`

---

## Form classes

### frmFADelTS2GL (Form xoa but toan)
- **Ke thua:** frmCalc

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | AsComboBox | Ky bao cao (thang) |
| txtNam | AsTextNumeric | Nam tai chinh (readonly) |

### Execute Parameters

| Thu tu | Tham so | Mo ta |
|--------|---------|-------|
| 1 | CompanyID | Ma cong ty |
| 2 | par1 | Tham so menu |
| 3 | txtNam.Value | Nam tai chinh |
| 4 | cboKyBc.Text | Thang bao cao |
| 5 | 0 | Tham so mac dinh |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Check lock date | thang/nam | 'Khong duoc xoa du lieu truoc ngay khoa so' |

### Business Rules

1. **Kiem tra ngay khoa so**: Khong cho phep xoa truoc ngay khoa so
2. **Xoa but toan**: Xoa but toan phan bo TSCĐ da post sang GL
3. **Khong tu dong dong form**: Sau khi thuc hien, form van mo

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Transfers/Xoabuttoantsgl.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Transfers;

class Xoabuttoantsgl extends Component
{
    const MA_CT = 'FA';
    const ACTION = 'DEL_TS2GL';

    public int $pNam;
    public ?int $pKyBc = null;
    public bool $pIsProcessing = false;
    public ?string $pStatus = null;

    public function mount(): void
    {
        $this->pNam = (int) now()->format('Y');
    }

    public function execute(): void
    {
        if ($this->pIsProcessing) return;

        // Kiem tra ngay khoa so
        // $this->validateLockedDate();

        $this->pIsProcessing = true;
        // Goi SP xoa but toan
        $this->pIsProcessing = false;
        $this->pStatus = 'success';
    }

    public function render(): View
    {
        return view('catalog::fa.transfers.xoa-but-toan-ts-gl');
    }
}
```

### 2. Routes

```php
Route::get('/xoa-but-toan-ts-gl', [Xoabuttoantsgl::class, 'render'])
    ->name('catalog.fa.transfers.xoa-but-toan-ts-gl');
```

---

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FAMHTS | Hao mon tai san | Transaction |
| GL1 | Chứng từ GL | Transaction |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_DEL_TS2GL` | Xóa bút toán phân bổ TSCĐ sang GL |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/catalog | GL | Module so cai |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_DEL_TS2GL
- [ ] Tao Livewire Xoabuttoantsgl
- [ ] Tao View xoa-but-toan-ts-gl.blade.php
- [ ] Them Routes
- [ ] Test kiem tra ngay khoa so