# Task 237: FAPostTS2GL

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang phan bo tai san co dinh sang GL tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FAPostTS2GL.dll
- **Chuc nang:** Phan bo tai san co dinh sang General Ledger
- **Loai:** Post / Tinh toan
- **Assembly Title:** Phan bo tai san co dinh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Post)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FAPostTS2GL.dll/README.md`

---

## Form classes

### 1. frmFAPostTS2GLFilter (Form chon ky)
- **Ke thua:** frmDMFilter
- **Chuc nang:** Chon thang post

### 2. frmFAPostTS2GL (Form danh sach & thuc hien)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach & post

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | AsComboBox | Chon thang phan bo |
| txtNam | AsTextNumeric | Nam tai chinh |
| dgvDM | DataGridView | Danh sach tai san can post |
| cmdPost | Button | Nut phan bo |

### Grid Columns

| Column | Mo ta |
|--------|-------|
| ma_ts | Ma tai san |
| ten_ts | Ten tai san |
| tk_cp | TK chi phi |
| tk_kh | TK khau hao |
| khau_hao | Gia tri khau hao |
| ma_phi | Ma phi |
| ma_spct | Ma SPCT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_POST_TS2GL_GET | Lay danh sach tai san can post |
| SP_FA_POST_TS2GL | Post khau hao TS sang GL |
| SP_FA_DEL_POST_GL_CT | Xoa du lieu post cu |

---

## Business Logic

### Business Rules

1. **Post khau hao TS**:
   - Xoa du lieu post cu (asFADelPostGlCt)
   - Insert du lieu moi (asFAPost2GlCt)

2. **Tham so**:
   - CompanyID
   - par1 (loai)
   - Nam
   - Thang

3. **Chi tiet post**:
   - TK chi phi
   - TK khau hao
   - Gia tri khau hao
   - Ma phi, ma SPCT

---

## Mapping PHP

### 1. Post Service

```php
// diepxuan/laravel-catalog/src/Services/Post/FA/PostTS2GLService.php
namespace Diepxuan\Catalog\Services\Post\FA;

class PostTS2GLService
{
    public function getPendingList(
        string $ma_cty,
        int $nam,
        string $thang,
        string $par1 = ''
    ): Collection {
        // Lay danh sach TS can post
    }

    public function execute(
        string $ma_cty,
        int $nam,
        string $thang,
        string $par1 = ''
    ): array {
        // Xoa & insert post GL
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Post/PhanBoTaisan.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Post;

class PhanBoTaisan extends Component
{
    const MA_CT = 'FA';

    public string $pKyBc = '';
    public int $pNam = 0;
    public Collection $pPendingList;
    public bool $pIsProcessing = false;

    public function mount(): void
    {
        $this->pNam = (int) date('Y');
    }

    public function loadPending(): void
    {
        // Load tu service
    }

    public function execute(): void
    {
        // Post to GL
    }

    public function render(): View
    {
        return view('catalog::fa.post.phan-bo-taisan');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Post Service | laravel-catalog | PostTS2GLService.php | Logic |
| Component | laravel-catalog | PhanBoTaisan.php | UI |
| SP | laravel-simba | AsFAPostTS2GL.php | Data source |
| View | laravel-catalog | phan-bo-taisan.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Post Service PostTS2GLService
- [ ] Tao Livewire PhanBoTaisan
- [ ] Tao View form + grid
- [ ] Them Routes
- [ ] Test get pending list
- [ ] Test post execution