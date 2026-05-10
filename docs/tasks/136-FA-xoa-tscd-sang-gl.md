# Task 136: FADelCC2GL

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang xoa but toan phan bo cong cu dung cu sang General Ledger tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADelCC2GL.dll
- **Chuc nang:** Xoa but toan phan bo cong cu dung cu sang GL
- **Loai:** Transfer (Chuyen doi)
- **Assembly Title:** Xoa but toan phan bo cong cu dung cu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (transfer)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADelCC2GL.dll/README.md`

---

## Form classes

### frmFADelCC2GL (Form xoa but toan)
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

### Business Rules

1. **Kiem tra ngay khoa so**: Khong cho phep xoa truoc ngay khoa so
2. **Xoa but toan CCDC**: Xoa but toan phan bo CCDC da post sang GL
3. **Tu dong dong form**: Sau khi thuc hien thanh cong, dong form

### Khac voi FADelTS2GL

| | FADelCC2GL | FADelTS2GL |
|---|------------|------------|
| Doi tuong | Cong cu dung cu | Tai san co dinh |
| Dong form | Co, sau khi thanh cong | Khong |

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Transfers/Xoabuttoanccgl.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Transfers;

class Xoabuttoanccgl extends Component
{
    const MA_CT = 'FA';
    const ACTION = 'DEL_CC2GL';

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

        $this->pIsProcessing = true;
        // Goi SP xoa but toan CCDC
        $this->pIsProcessing = false;
        $this->pStatus = 'success';

        // Dong form sau khi thanh cong
        // return redirect()->back();
    }

    public function render(): View
    {
        return view('catalog::fa.transfers.xoa-but-toan-cc-gl');
    }
}
```

### 2. Routes

```php
Route::get('/xoa-but-toan-cc-gl', [Xoabuttoanccgl::class, 'render'])
    ->name('catalog.fa.transfers.xoa-but-toan-cc-gl');
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
| `FA_DEL_CC2GL` | Xóa bút toán phân bổ CCDC sang GL |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/catalog | GL | Module so cai |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_DEL_CC2GL
- [ ] Tao Livewire Xoabuttoanccgl
- [ ] Tao View xoa-but-toan-cc-gl.blade.php
- [ ] Them Routes
- [ ] Test kiem tra ngay khoa so
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
