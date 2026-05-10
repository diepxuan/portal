# Task 222: SI-Cong-Cu-He-Thong

## Nhom: SI (System Integration)

## Muc tieu
Chuyen doi chuc nang cong cu he thong tu .NET sang PHP Laravel, dat ket qua tuong duong SiTools.

## Chi tiet
- **DLL:** SiTools.dll
- **Chuc nang:** Cong cu he thong (System Tools)
- **Loai:** Utility (UTL)
- **Assembly Title:** SiTools
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asiasoft

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SiTools.dll/README.md`

---

## Form classes

### frmMainTools (Form chinh)
- **Ke thua:** frmAsiaRoot
- **Tabs:**

| Tab | Mo ta |
|-----|-------|
| tabComanyInfo | Thong tin cong ty |
| tabInterface | Cau hinh giao dien |
| tabMenu | Cau hinh menu |

### Controls tabInterface

| Control | Mo ta |
|---------|-------|
| tbxFont | Font chinh |
| tbxBgColor | Mau nen menu |
| tbxForeColor | Mau chu |
| tbxWPanel | Width panel |
| tbxWColumn | Width column |
| tbxMnSelectedColor | Mau menu selected |
| tbxSubMnForeColor | Mau chu sub menu |
| tbxDetailMnForeColor | Mau chu detail menu |
| tbDetailMnFont | Font detail menu |

### frmCreateCompany (Form tao cong ty)

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/CongcuHethong.php
namespace Diepxuan\Catalog\Http\Livewire\SI\CongcuHethong;

class CongcuHethong extends Component
{
    public string $pActiveTab = 'company';

    public string $pFont = 'Tahoma';
    public string $pBgColor = '#FFFFFF';
    public string $pForeColor = '#000000';
    public int $pWPanel = 200;
    public int $pWColumn = 100;
    public string $pMnSelectedColor = '#3399FF';
    public string $pSubMnForeColor = '#000000';
    public string $pDetailMnForeColor = '#000000';
    public string $pDetailMnFont = 'Tahoma';

    public Collection $pCompanyList;

    public function mount(): void
    {
        $this->loadCompanyList();
        $this->loadSettings();
    }

    public function loadCompanyList(): void
    {
        // Load danh sach cong ty
    }

    public function loadSettings(): void
    {
        // Load tu config
    }

    public function saveSettings(): void
    {
        // Luu vao config
    }

    public function createCompany(): void
    {
        // Tao cong ty moi
    }

    public function render(): View
    {
        return view('catalog::si.congcuhe thong');
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/cong-cu-he-thong', [CongcuHethong::class, 'render'])
            ->name('congcuhe thong');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire component
- [ ] Tao View voi tabs
- [ ] Tao form tao cong ty
- [ ] Them Routes
- [ ] Test quan ly cau hinh
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
