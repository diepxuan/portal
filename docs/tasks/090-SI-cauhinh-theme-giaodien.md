# Task 090: SITheme

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang cau hinh theme/giao dien tu .NET sang PHP Laravel. Cho phep nguoi dung tuy chinh mau sac, font chu va kieu menu.

## Chi tiet
- **DLL:** SITheme.dll
- **Chuc nang:** Cau hinh theme / Giao dien
- **Loai:** System (SYS)
- **Assembly Title:** SITHEME
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** chinhvd
- **Ma_ct:** SITheme

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SITheme.dll/README.md`

---

## Cau truc du lieu

SITheme luu cau hinh trong file XML, khong dung database.

### File cau hinh: Theme.xml

Vi tri: `{SystemInformations.XMLPath}/Theme.xml`

### Cau truc XML

```xml
<NewDataSet>
  <Default>
    <MENU_TYPE>1</MENU_TYPE>
    <X_COLUMN2>200</X_COLUMN2>
    <MODULE_PANEL_MAX_WIDTH>250</MODULE_PANEL_MAX_WIDTH>
    <MODULE_MENU_BACK_COLOR>Control</MODULE_MENU_BACK_COLOR>
    <MODULE_MENU_FORE_COLOR>Black</MODULE_MENU_FORE_COLOR>
    <MODULE_MENU_SELECTED_FORE_COLOR>White</MODULE_MENU_SELECTED_FORE_COLOR>
    <MODULE_MENU_FONT>Microsoft Sans Serif,8.25,0</MODULE_MENU_FONT>
    <CT_BakgroundColorName>#FFFFFF</CT_BakgroundColorName>
    <CT_AlternatingBackColorName>#FFF8DC</CT_AlternatingBackColorName>
    <DM_BakgroundColorName>#FFFFFF</DM_BakgroundColorName>
    <DM_AlternatingBackColorName>#FFF8DC</DM_AlternatingBackColorName>
    <BC_BakgroundColorName>#FFFFFF</BC_BakgroundColorName>
    <BC_AlternatingBackColorName>#FFF8DC</BC_AlternatingBackColorName>
    <AsTextBox_BakgroundColorName>#FFFFFF</AsTextBox_BakgroundColorName>
  </Default>
  <CustomTheme1>
    <!-- ... -->
  </CustomTheme1>
</NewDataSet>
```

### Bang thuoc tinh theme

| Thuoc tinh | Kieu | Mo ta |
|------------|------|-------|
| MENU_TYPE | int | 1=Tree, 2=Docking Menu |
| X_COLUMN2 | int | Do rong cot |
| MODULE_PANEL_MAX_WIDTH | int | Do rong panel menu |
| MODULE_MENU_BACK_COLOR | string | Mau nen menu |
| MODULE_MENU_FORE_COLOR | string | Mau chu menu |
| MODULE_MENU_SELECTED_FORE_COLOR | string | Mau chu dang chon |
| MODULE_MENU_FONT | string | Font menu (Name,Size,Style) |
| MODULE_MENU_FONT_SIZE | int | Size cua font |
| CT_BakgroundColorName | string | Mau nen chung tu |
| CT_AlternatingBackColorName | string | Mau dong xen ke CT |
| DM_BakgroundColorName | string | Mau nen danh muc |
| DM_AlternatingBackColorName | string | Mau dong xen ke DM |
| BC_BakgroundColorName | string | Mau nen bao cao |
| BC_AlternatingBackColorName | string | Mau dong xen ke BC |
| AsTextBox_BakgroundColorName | string | Mau nen TextBox F5 |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|--------------|
| Theme.xml | File cau hinh | Thu muc System |

---

## Form classes

### 1. frmSITheme (Form cau hinh theme chinh)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Cau hinh giao dien
- **MenuID:** 90.10.40

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboTheme | ComboBox | Danh sach theme |
| btnMoi | Button | Tao theme moi |
| btnXoa | Button | Xoa theme |
| btnMacDinh | Button | Khoi phuc mac dinh |
| dgvAttrs | DataGridView | Bang thuoc tinh |
| btnLuu | Button | Luu cau hinh |
| btnApDung | Button | Ap dung theme |
| btnThoat | Button | Dong form |

### 2. frmSIThemeInputName (Form nhap ten theme)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Nhap ten theme moi

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtName | TextBox | Ten theme |
| btnOK | Button | Dong y |
| btnCancel | Button | Huy |

### 3. OpenListBoxColors (Popup chon mau)
- **Ke thua:** Form
- **Chuc nang:** Popup chon mau sac

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| lstColors | AsListBoxColors | Danh sach mau |

### 4. AsListBoxColors (Custom ListBox)
- **Ke thua:** ListBox
- **Chuc nang:** Hien thi danh sach mau voi preview

---

## Stored Procedures

SITheme khong su dung Stored Procedure. Cau hinh duoc luu truc tiep vao file XML.

| SP Name | Mo ta |
|---------|-------|
| (Khong co SP) | File-based configuration |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ThemeName | 'Ten theme khong duoc trong' |
| Unique | ThemeName | 'Ten theme da ton tai' |
| Cannot delete | ThemeName | 'Khong the xoa theme mac dinh' |

### Business Rules

1. **Theme mac dinh**:
   - "Default" la theme mac dinh, khong the xoa
   - Ton tai san trong file XML
   - Co the khoi phuc ve trang thai ban dau

2. **Tao theme moi**:
   - Sao chep toan bo thuoc tinh tu "Default"
   - Yeu cau nhap ten moi (khong trung ten cu)
   - Luu ngay sau khi tao

3. **Xoa theme**:
   - Khong cho phep xoa "Default"
   - Xoa khoi danh sach va file XML

4. **Luu cau hinh**:
   - Ghi tat ca thuoc tinh vao file XML
   - Su dung format XML cua .NET DataSet
   - Khong can database

5. **Ap dung theme**:
   - Cap nhat config['simba.theme'] = $themeName
   - Luu vao session de nho trang thai
   - Tai lai trang hien tai

6. **Doi mau sac**:
   - Chuyen doi giua ten mau (KnownColor) va ma HTML
   - Su dung `ColorTranslator.FromHtml()` trong .NET
   - Su dung PHP equivalent trong Laravel

7. **Doi font**:
   - Format: "FontName,Size,Style"
   - Style: 0=Regular, 1=Bold, 2=Italic, 3=BoldItalic

---

## Mapping PHP

### 1. ThemeConfig Class

```php
// diepxuan/laravel-catalog/src/Services/ThemeConfig.php
namespace Diepxuan\Catalog\Services;

class ThemeConfig
{
    protected string $themeName;
    protected array $attrs = [];

    // Thuoc tinh mac dinh
    protected static array $defaults = [
        'MENU_TYPE' => '1',
        'X_COLUMN2' => 200,
        'MODULE_PANEL_MAX_WIDTH' => 250,
        'MODULE_MENU_BACK_COLOR' => '#F0F0F0',
        'MODULE_MENU_FORE_COLOR' => '#000000',
        'MODULE_MENU_SELECTED_FORE_COLOR' => '#FFFFFF',
        'MODULE_MENU_FONT' => 'Microsoft Sans Serif',
        'MODULE_MENU_FONT_SIZE' => 8.25,
        'CT_BakgroundColorName' => '#FFFFFF',
        'CT_AlternatingBackColorName' => '#FFF8DC',
        'DM_BakgroundColorName' => '#FFFFFF',
        'DM_AlternatingBackColorName' => '#FFF8DC',
        'BC_BakgroundColorName' => '#FFFFFF',
        'BC_AlternatingBackColorName' => '#FFF8DC',
        'AsTextBox_BakgroundColorName' => '#FFFFFF',
    ];

    public static function list(): array
    {
        // Doc danh sach theme tu Theme.xml
        $xml = new \SimpleXMLElement($this->xmlPath, 0, true);
        return array_keys((array) $xml);
    }

    public static function load(string $themeName): self
    {
        // Doc theme tu Theme.xml
    }

    public function save(): void
    {
        // Ghi theme vao Theme.xml
    }

    public static function delete(string $themeName): bool
    {
        // Xoa theme khoi Theme.xml
    }

    public function getAttr(string $key, $default = null)
    {
        return $this->attrs[$key] ?? $default;
    }

    public function setAttr(string $key, $value): self
    {
        $this->attrs[$key] = $value;
        return $this;
    }

    public function toArray(): array
    {
        return $this->attrs;
    }

    protected function getXmlPath(): string
    {
        return config('simba.xml_path', storage_path('app/xml'))
            . '/Theme.xml';
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/System/Theme.php
namespace Diepxuan\Catalog\Http\Livewire\SI\System;

class Theme extends Component
{
    public array $pThemes = [];
    public string $pSelectedTheme = 'Default';
    public array $pAttrs = [];
    public ?string $pEditingValue = null;

    protected $listeners = ['colorSelected'];

    public function mount(): void
    {
        $this->loadThemes();
        $this->loadConfig();
    }

    public function loadThemes(): void
    {
        $this->pThemes = ThemeConfig::list();
    }

    public function loadConfig(): void
    {
        $config = ThemeConfig::load($this->pSelectedTheme);
        $this->pAttrs = $config->toArray();
    }

    public function updatedPSelectedTheme(): void
    {
        $this->loadConfig();
    }

    public function createNew(): void
    {
        // Hien thi modal nhap ten
    }

    public function saveNew(string $name): void
    {
        if (empty($name) || in_array($name, $this->pThemes)) {
            return;
        }

        ThemeConfig::createFrom('Default', $name);
        $this->pThemes = ThemeConfig::list();
        $this->pSelectedTheme = $name;
        $this->loadConfig();
    }

    public function delete(): void
    {
        if ($this->pSelectedTheme === 'Default') {
            return;
        }

        ThemeConfig::delete($this->pSelectedTheme);
        $this->pThemes = ThemeConfig::list();
        $this->pSelectedTheme = 'Default';
        $this->loadConfig();
    }

    public function save(): void
    {
        $config = ThemeConfig::load($this->pSelectedTheme);
        foreach ($this->pAttrs as $key => $value) {
            $config->setAttr($key, $value);
        }
        $config->save();
        $this->dispatch('notify', 'Da luu cau hinh theme');
    }

    public function apply(): void
    {
        session(['theme' => $this->pSelectedTheme]);
        config(['simba.theme' => $this->pSelectedTheme]);
        // Dispatch event de reload UI
        $this->dispatch('themeApplied', $this->pSelectedTheme);
    }

    public function resetDefault(): void
    {
        $config = ThemeConfig::load('Default');
        $this->pAttrs = $config->toArray();
    }

    public function colorSelected(array $data): void
    {
        $this->pAttrs[$data['key']] = $data['color'];
    }

    public function render(): View
    {
        return view('catalog::si.system.theme');
    }
}
```

### 3. Views

```
resources/views/catalog/si/system/
├── theme.blade.php
├── _theme-color-picker.blade.php
└── _theme-font-picker.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/theme', [Theme::class, 'render'])
            ->name('theme');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Config | laravel-catalog | ThemeConfig.php | File-based |
| Component | laravel-catalog | Theme.php | Form chinh |
| Config | laravel-catalog | simba.php | xml_path |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao ThemeConfig service class
- [ ] Tao Livewire Theme
- [ ] Tao Views (color picker, font picker)
- [ ] Them Routes
- [ ] Test tao theme moi
- [ ] Test xoa theme
- [ ] Test luu cau hinh
- [ ] Test ap dung theme
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
