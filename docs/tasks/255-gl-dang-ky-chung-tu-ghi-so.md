# Task 255: GLDKCTGS

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module dang ky chung tu ghi so (CTGS) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLDKCTGS.dll
- **Assembly Title:** GLDKCTGS
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: DMDKyCTGS (Danh muc dang ky chung tu ghi so)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_ct | varchar | 10 | Ma chung tu |
| ten_ctgs | nvarchar | 200 | Ten chung tu ghi so |
| so_hieu | varchar | 50 | So hieu chung tu |
| ngay | datetime | - | Ngay chung tu |
| ky_bc | varchar | 10 | Ky bao cao |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMCTGS | Danh muc chung tu ghi so | FK ma_ct -> DMCTGS.ma_ct |

---

## Form classes

### 1. frmGLDKCTGS (Form chinh)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Dang ky chung tu ghi so theo ky bao cao
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| dgvDKCTGS | DataGridView | Danh sach chung tu |
| cmdThucHien | Button | Thuc hien dang ky |
| cmdThoat | Button | Thoat |

### DataGridView Columns

| Column | Mo ta |
|--------|-------|
| Chon | Checkbox chon chung tu |
| Ma_CT | Ma chung tu |
| TK | Tai khoan |
| Ten_CTGS | Ten chung tu ghi so |
| So_hieu | So hieu chung tu |
| Ngay | Ngay chung tu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asGLGetDMDKyCTGS | Lay danh sach chung tu can dang ky |
| asGLDkyCTGS | Dang ky chung tu ghi so |

### asGLGetDMDKyCTGS (reference)

```sql
EXEC asGLGetDMDKyCTGS
    @pMa_cty VARCHAR(50) = '001',
    @pKy_bc VARCHAR(10) = NULL,
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ky_bc | 'Ky bao cao khong duoc trong' |
| Valid date range | ngay1, ngay2 | 'Ngay khong hop le' |

### Business Rules

1. **Dang ky theo ky bao cao:**
   - Chon ky (thang/quy/nam)
   - Tu dong lay ngay bat dau va ngay ket thuc theo ky

2. **Chon chung tu dang ky:**
   - Checkbox chon nhieu chung tu
   - Chon tat ca hoac bo chon tat ca

3. **Thuc hien dang ky:**
   - Cap nhat trang thai da dang ky cho chung tu
   - Ghi nhan ngay dang ky

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Chungtughiso/Dangky.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Chungtughiso;

class Dangky extends Component
{
    const MA_CT = 'GL';

    public ?string $pKyBc = null;
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public Collection $pChungtus;
    public array $pSelected = [];

    public function mount(): void
    {
        $this->loadKyBc();
    }

    public function loadChungtus(): void
    {
        // Load tu Stored Procedure asGLGetDMDKyCTGS
    }

    public function register(): void
    {
        // Goi asGLDkyCTGS
    }

    public function render(): View
    {
        return view('catalog::gl.chungtughiso.dangky');
    }
}
```

### 2. Views

```
resources/views/catalog/gl/chungtughiso/
├── dangky.blade.php      (Form dang ky)
└── _chungtu-row.blade.php (Component row)
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | GL/Chungtughiso/Dangky.php | Chinh |
| Model | laravel-simba | DMCTGS.php | Chung tu ghi so |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire Dangky component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test chuc nang dang ky