# Task 088: SIGroupInfo

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang quan ly nhom nguoi dung va phan quyen tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIGroupInfo.dll
- **Chuc nang:** Danh muc bo phan / Nhom nguoi dung
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc bo phan
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SIGroupInfo

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIGroupInfo.dll/README.md`

---

## Cau truc du lieu

### Bang: SIGroupInfo (Nhom nguoi dung)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| GroupName | varchar | Ten nhom (khoa chinh) |
| FullName | nvarchar | Ten day du |
| Grand | bit | Quyen phan quyen (Admin) |
| KSD | bit | Khoa su dung |

### Bang: SIGroupRight (Phan quyen nhom)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| GroupName | varchar | Ten nhom (FK) |
| MenuID | varchar | Ma menu |
| ViewRight | bit | Quyen xem |
| InsertRight | bit | Quyen them |
| UpdateRight | bit | Quyen sua |
| DeleteRight | bit | Quyen xoa |

---

## Form classes

### 1. frmSIGroupInfo (Danh sach nhom)
- **Ke thua:** frmAsiaRoot
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvGroup | DataGridView | Luoi nhom |
| btnAdd | Button | Them nhom |
| btnEdit | Button | Sua nhom |
| btnDelete | Button | Xoa nhom |
| btnSetRights | Button | Phan quyen |

### 2. frmSIGroupInfoEdit (Them/sua nhom)
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtGroupName | TextBox | GroupName | Ten nhom |
| txtFullName | TextBox | FullName | Ten day du |
| chkGrand | CheckBox | Grand | Quyen phan quyen |
| chkKSD | CheckBox | KSD | Khoa su dung |

### 3. frmSiSetRights (Phan quyen)
- Hien thi TreeView menu
- Checkbox Xem/Them/Sua/Xoa

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_GROUPINFO_GET | Lay danh sach nhom |
| SP_SI_GROUPINFO_GETBYID | Lay chi tiet |
| SP_SI_GROUPINFO_INSERT | Them nhom |
| SP_SI_GROUPINFO_UPDATE | Cap nhat nhom |
| SP_SI_GROUPINFO_DELETE | Xoa nhom |
| SP_SI_GROUPRIGHT_GET | Lay quyen nhom |
| SP_SI_GROUPRIGHT_SAVE | Luu quyen nhom |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | GroupName | 'Ten nhom khong duoc trong' |
| Unique | GroupName | 'Ten nhom da ton tai' |
| Required | FullName | 'Ten day du khong duoc trong' |

### Business Rules

1. **Phan quyen**:
   - Theo MenuID
   - 4 quyen: Xem, Them, Sua, Xoa

2. **Quyen Admin**:
   - Grand = 1: Co quyen phan quyen

3. **Xoa nhom**:
   - Kiem tra khong co user thuoc nhom

---

## Mapping PHP

### 1. Models

```php
// app/Models/SI/SIGroupInfo.php
namespace Diepxuan\Simba\Models\SI;

class SIGroupInfo extends Model
{
    protected $table = 'SIGroupInfo';
    protected $primaryKey = 'GroupName';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'GroupName',
        'FullName',
        'Grand',
        'KSD',
    ];

    protected $casts = [
        'Grand' => 'boolean',
        'KSD' => 'boolean',
    ];

    public function rights()
    {
        return $this->hasMany(SIGroupRight::class, 'GroupName', 'GroupName');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'GroupName', 'GroupName');
    }
}

// app/Models/SI/SIGroupRight.php
class SIGroupRight extends Model
{
    protected $table = 'SIGroupRight';
    protected $primaryKey = ['GroupName', 'MenuID'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'GroupName',
        'MenuID',
        'ViewRight',
        'InsertRight',
        'UpdateRight',
        'DeleteRight',
    ];

    protected $casts = [
        'ViewRight' => 'boolean',
        'InsertRight' => 'boolean',
        'UpdateRight' => 'boolean',
        'DeleteRight' => 'boolean',
    ];
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Nhomnd.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Nhomnd extends Component
{
    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.nhomnd');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/NhomndEdit.php
class NhomndEdit extends Component
{
    public ?string $pGroupName = null;
    public string $pFullName = '';
    public bool $pGrand = false;
    public bool $pKSD = false;

    public function render(): View
    {
        return view('catalog::si.danhmuc.nhomnd-edit');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/NhomndRights.php
class NhomndRights extends Component
{
    public ?string $pGroupName = null;
    public Collection $pMenuTree;
    public Collection $pRights;

    public function mount(string $groupName): void
    {
        $this->pGroupName = $groupName;
        $this->loadMenuTree();
        $this->loadRights();
    }

    public function render(): View
    {
        return view('catalog::si.danhmuc.nhomnd-rights');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── nhomnd.blade.php
├── nhomnd-edit.blade.php
└── nhomnd-rights.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/nhom-nd', [Nhomnd::class, 'render'])
            ->name('nhomnd');
        Route::get('/nhom-nd/edit/{groupName?}', [NhomndEdit::class, 'render'])
            ->name('nhomnd.edit');
        Route::get('/nhom-nd/rights/{groupName}', [NhomndRights::class, 'render'])
            ->name('nhomnd.rights');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SIGroupInfo.php | Nhom |
| Model | laravel-simba | SIGroupRight.php | Quyen |
| Component | laravel-catalog | Nhomnd.php | List |
| Component | laravel-catalog | NhomndRights.php | Phan quyen |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Models SIGroupInfo, SIGroupRight
- [ ] Tao Livewire Nhomnd, NhomndEdit
- [ ] Tao Livewire NhomndRights
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test phan quyen