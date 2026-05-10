# Task 083: SIAbout

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang hien thi thong tin chuong trinh (About) tu .NET sang PHP Laravel. Day la chuc nang chi doc hien thi thong tin he thong cho nguoi dung.

## Chi tiet
- **DLL:** SIAbout.dll
- **Chuc nang:** Thong tin chuong trinh (About)
- **Loai:** System (SYS)
- **Assembly Title:** Thong tin chuong trinh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIAbout

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIAbout.dll/README.md`

---

## Cau truc du lieu

SIAbout la chuc nang hien thi thong tin chi doc, khong co bang du lieu rieng. Thong tin duoc lay tu cau hinh he thong.

### Nguon thong tin

| Nguon | Mo ta |
|-------|-------|
| SystemInformations.UserName | Nguoi dang nhap hien tai |
| CompanyInformations | Thong tin cong ty (ma_cty, ten_cty) |
| DatabaseConfigurations | Cau hinh database (server, data db, sys db) |
| ApplicationInfo | Thong tin phan mem (ten, phien ban) |

---

## Form classes

### frmSIAbout (Form thong tin)
- **Ke thua:** frmCalc
- **Chuc nang:** Hien thi thong tin phan mem (Read-only)
- **MenuID:** 90.10.00

### Controls (Read-only)

| Control | Type | Mo ta |
|---------|------|-------|
| txtUserName | AsMaskedTextBox | Nguoi su dung |
| txtFinancialYear | AsMaskedTextBox | Nam tai chinh |
| txtCompanyID | AsMaskedTextBox | Ma don vi |
| txtCompanyName | AsMaskedTextBox | Ten don vi |
| txtNgay_ks | AsMaskedTextBox | Ngay khoa so |
| txtProductName | AsMaskedTextBox | Ten san pham |
| txtProductVersion | AsMaskedTextBox | Phien ban |
| txtServerName | AsMaskedTextBox | Ten server |
| txtDATADatabaseName | AsMaskedTextBox | Database Data |
| txtSYSDatabaseName | AsMaskedTextBox | Database Sys |
| lblVersion | Label | Bieu tuong phien ban |

---

## Stored Procedures

SIAbout khong su dung Stored Procedure. Thong tin duoc doc truc tiep tu cau hinh.

| SP Name | Mo ta |
|---------|-------|
| (Khong co SP) | Lay truc tiep tu cau hinh |

---

## Business Logic

### Business Rules

1. **Chi doc**:
   - Khong co chuc nang chinh sua
   - Tat ca cac truong chi hien thi
   - Khong co nut Luu

2. **Nguon thong tin**:
   - UserName: `auth()->user()->name` hoac `session('user_name')`
   - FinancialYear: Lay tu cau hinh nam tai chinh
   - CompanyID/CompanyName: Lay tu `config('simba.company.*')`
   - Ngay_ks: Ngay khoa so tu `config('simba.company.ngay_ks')`
   - ProductName/Version: Lay tu `config('app.name')` / `config('app.version')`
   - ServerName: Lay tu `config('database.connections.simba.host')`
   - DataDatabaseName: `config('database.connections.simba.database')`
   - SysDatabaseName: 'Sys' (co dinh)

3. **Hien thi**:
   - Format ngay khoa so: dd/MM/yyyy
   - Format phien ban: x.x.x.x
   - Khong cho phep copy text ( tuy tuy )

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/System/About.php
namespace Diepxuan\Catalog\Http\Livewire\SI\System;

class About extends Component
{
    public string $pUserName = '';
    public string $pFinancialYear = '';
    public string $pCompanyID = '';
    public string $pCompanyName = '';
    public ?string $pNgay_ks = null;
    public string $pProductName = '';
    public string $pProductVersion = '';
    public string $pServerName = '';
    public string $pDataDatabaseName = '';
    public string $pSysDatabaseName = '';

    public function mount(): void
    {
        // Lay tu cau hinh he thong
        $this->pUserName = auth()->user()->name
            ?? session('user_name', 'N/A');
        $this->pFinancialYear = config('simba.company.nam_tc',
            now()->year);
        $this->pCompanyID = config('simba.company.ma_cty', '');
        $this->pCompanyName = config('simba.company.ten_cty', '');
        $this->pNgay_ks = $this->formatDate(
            config('simba.company.ngay_ks')
        );
        $this->pProductName = config('app.name', 'Portal ERP');
        $this->pProductVersion = config('app.version', '1.0.0');
        $this->pServerName = config('database.connections.simba.host', '');
        $this->pDataDatabaseName = config(
            'database.connections.simba.database', ''
        );
        $this->pSysDatabaseName = 'Sys';
    }

    protected function formatDate($date): string
    {
        if (empty($date)) return '';
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }

    public function render(): View
    {
        return view('catalog::si.system.about');
    }
}
```

### 2. Views

```
resources/views/catalog/si/system/
└── about.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/about', [About::class, 'render'])
            ->name('about');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Config | laravel-catalog | simba.php | Cau hinh cong ty |
| Component | laravel-catalog | About.php | Form chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Livewire About
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test hien thi thong tin nguoi dung
- [ ] Test hien thi thong tin cong ty
- [ ] Test hien thi thong tin database
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
