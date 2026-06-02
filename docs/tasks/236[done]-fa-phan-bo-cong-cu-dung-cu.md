# Task 236: FAPostCC2GL

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang phan bo cong cu dung cu sang GL tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FAPostCC2GL.dll
- **Chuc nang:** Phan bo cong cu dung cu sang General Ledger
- **Loai:** Post / Tinh toan
- **Assembly Title:** Phan bo cong cu dung cu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Post)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FAPostCC2GL.dll/README.md`

---

## Form classes

### frmFAPostCC2GL (Form post phan bo CCDC)
- **Ke thua:** frmCalc
- **Chuc nang:** Post phan bo cong cu dung cu sang GL

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | AsComboBox | Chon thang phan bo |
| txtNam | AsTextNumeric | Nam tai chinh (readonly) |
| cmdOK | Button | Nut thuc hien post |
| cmdCancel | Button | Nut huy |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_POST_CC2GL | Post phan bo CCDC sang GL |

---

## Business Logic

### Business Rules

1. **Post phan bo CCDC**:
   - Chon thang can post (qua cboKyBc)
   - Post cac khoan phan bo CCDC den ky cho GL

2. **Tham so**:
   - CompanyID
   - Nam tai chinh
   - Thang phan bo
   - par1 (loai tu MyMenuInfo)

3. **Kiem tra khoa so**:
   - Ngay ket thuc ky > ngay khoa so

---

## Mapping PHP

### 1. Post Service

```php
// diepxuan/laravel-catalog/src/Services/Post/FA/PostCC2GLService.php
namespace Diepxuan\Catalog\Services\Post\FA;

class PostCC2GLService
{
    public function post(
        string $ma_cty,
        int $nam,
        string $thang,
        string $par1 = ''
    ): array {
        // Goi SP post CCDC sang GL
    }

    public function validateLockedPeriod(string $thang): bool
    {
        // Kiem tra ngay khoa so
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Post/PhanBoCongcu.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Post;

class PhanBoCongcu extends Component
{
    const MA_CT = 'FA';

    public string $pKyBc = '';
    public int $pNam = 0;
    public bool $pIsProcessing = false;

    public function mount(): void
    {
        $this->pNam = (int) date('Y');
    }

    public function execute(): void
    {
        // Validate & goi service
    }

    public function render(): View
    {
        return view('catalog::fa.post.phan-bo-congcu');
    }
}
```

### 3. Views

```
resources/views/catalog/fa/post/
├── phan-bo-congcu.blade.php      (Main form)
└── _phan-bo-congcu-result.blade.php (Result)
```

### 4. Routes

```php
Route::get('/catalog/fa/post/phan-bo-congcu', [PhanBoCongcu::class, 'render'])
    ->name('catalog.fa.post.phan-bo-congcu');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Post Service | laravel-catalog | PostCC2GLService.php | Logic |
| Component | laravel-catalog | PhanBoCongcu.php | UI |
| SP | laravel-simba | AsFAPostCC2GL.php | Data source |
| View | laravel-catalog | phan-bo-congcu.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Post Service PostCC2GLService
- [ ] Tao Livewire PhanBoCongcu
- [ ] Tao View form
- [ ] Them Routes
- [ ] Test post execution
- [ ] Test locked period validation
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `fa.transfer.cc2gl`
- **Note:** Shell/voucher; write blocked until payload audit.
