# Task 220: SI-Thong-Tin-San-Pham

## Nhom: SI (System Integration)

## Muc tieu
Chuyen doi chuc nang thong tin san pham tu .NET sang PHP Laravel, dat ket qua tuong duong SiInfomationProduct.

## Chi tiet
- **DLL:** SiInfomationProduct.dll
- **Chuc nang:** Thong tin san pham & quan ly ban quyen (Product Info & License)
- **Loai:** Utility (UTL)
- **Assembly Title:** WindowsApplication1
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** AsiaHN

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SiInfomationProduct.dll/README.md`

---

## Form classes

### frmSiInfomationProduct (Form chinh)
- **Ke thua:** frmAsiaRoot
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| lblProductName | Label | Ten san pham |
| lblProductVersion | Label | Phien ban |
| lblCompanyName | Label | Ten cong ty |
| lblBuild | Label | Build number |
| lblBuildCreateDate | Label | Ngay tao build |
| lblCap_pheh | Label | Thong tin cap phep |
| lblActive | Label/LinkLabel | Trang thai kich hoat |
| lblData | Label | Thong tin database |
| lblServer | Label | Server |
| llbWeb | LinkLabel | Website (www.simba.vn) |
| lblEmail | LinkLabel | Email (info@simba.vn) |
| llbAsiaSoftWebsite | LinkLabel | Website AsiaSoft |
| llbAsiaSoftEmail | LinkLabel | Email AsiaSoft |

### frmRegister (Form dang ky)
- **Chuc nang:** Dang ky/kich hoat san pham

---

## Business Logic

### Hien thi thong tin

- Ten san pham: SIMBA ERP
- Phien ban: from config
- Build number: auto-generated
- Ngay tao build

### Registry Keys

| Key | Mo ta |
|-----|-------|
| RegSubKeyName | Subkey chua license |
| f_sProductKey | Product key |
| f_sUserName | Ten nguoi dung |
| f_isRegisted | Trang thai dang ky |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/ProductInfo.php
namespace Diepxuan\Simba\Models\SI;

class ProductInfo extends Model
{
    protected $connection = 'simba';

    public static function getProductName(): string
    {
        return 'SIMBA ERP';
    }

    public static function getVersion(): string
    {
        return config('simba.version', '14.1.0.0');
    }

    public static function getCompany(): string
    {
        return 'Asia Software Development JSC';
    }

    public static function isLicensed(): bool
    {
        return config('simba.licensed', false);
    }

    public static function getLicenseInfo(): array
    {
        return [
            'product_key' => config('simba.product_key'),
            'user_name' => config('simba.user_name'),
            'is_registered' => config('simba.registered', false),
        ];
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Thongtinsanpham.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Thongtinsanpham;

class Thongtinsanpham extends Component
{
    public string $pProductName;
    public string $pVersion;
    public string $pCompany;
    public string $pBuild;
    public string $pBuildDate;
    public string $pLicenseStatus;
    public string $pDatabase;
    public string $pServer;
    public bool $pIsLicensed;

    public function mount(): void
    {
        $this->pProductName = ProductInfo::getProductName();
        $this->pVersion = ProductInfo::getVersion();
        $this->pCompany = ProductInfo::getCompany();
        $this->pBuild = config('simba.build', '1.0.0');
        $this->pBuildDate = config('simba.build_date', now()->format('Y-m-d'));
        $this->pLicenseStatus = ProductInfo::isLicensed() ? 'Activated' : 'Not Activated';
        $this->pIsLicensed = ProductInfo::isLicensed();

        $db = DB::connection('simba');
        $this->pDatabase = $db->getDatabase();
        $this->pServer = $db->getConfig('host');
    }

    public function openRegister(): void
    {
        $this->emit('openRegisterModal');
    }

    public function openWebsite(): void
    {
        // Open www.simba.vn
    }

    public function render(): View
    {
        return view('catalog::si.thongtinsanpham');
    }
}
```

### 3. Views

```
resources/views/catalog/si/
├── thongtinsanpham/
│   ├── index.blade.php
│   └── register.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/thong-tin-san-pham', [Thongtinsanpham::class, 'render'])
            ->name('thongtinsanpham');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire component
- [ ] Tao View hien thi thong tin
- [ ] Tao register form
- [ ] Them Routes
- [ ] Test hien thi thong tin san pham
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `si.info.product`
- **Note:** Shell hoặc route hiện hữu; side-effect blocked nếu chưa audit payload.
