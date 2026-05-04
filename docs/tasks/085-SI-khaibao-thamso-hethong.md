# Task 085: SISysvars

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang khai bao tham so he thong tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SISysvars.dll
- **Chuc nang:** Khai bao tham so he thong
- **Loai:** System (SYS)
- **Assembly Title:** SISysvars
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia
- **Ma_ct:** SISysvars

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SISysvars.dll/README.md`

---

## Cau truc du lieu

### Bang: Sysvars (Tham so he thong)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| varName | varchar | Ten bien (khoa chinh) |
| varValue | nvarchar | Gia tri |
| varDescrpt | nvarchar | Mo ta |
| varType | varchar | Kieu du lieu |
| maxlength | int | Do dai toi da |
| isEdit | bit | Cho phep sua |
| moduleid | varchar | Ma module |

---

## Form classes

### frmSISysvars (Form quan ly tham so)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Quan ly tham so he thong

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| dgvVars | DataGridView | Luoi hien thi tham so |
| btnEdit | Button | Nut sua (chuyen doi Edit/Save) |
| btnSave | Button | Nut luu |

### DataGridView Columns

| Column | Mo ta |
|--------|-------|
| varName | Ten bien (an) |
| varDescrpt | Mo ta tham so |
| varValue | Gia tri |
| varType | Kieu du lieu (an) |
| maxlength | Do dai (an) |
| isEdit | Cho phep sua (an) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_SYSVARS_GET | Lay danh sach |
| SP_SI_SYSVARS_GETBYID | Lay chi tiet |
| SP_SI_SYSVARS_UPDATE | Cap nhat gia tri |
| SP_SI_SYSVARS_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| isEdit = 1 | varName | 'Khong cho phep sua tham so nay' |
| Valid type | varType | 'Kieu du lieu khong hop le' |

### Business Rules

1. **Phan loai tham so**:
   - Theo module (moduleid)
   - Chi doc / Cho sua (isEdit)

2. **Kieu du lieu**:
   - String, Number, Boolean, Date...

3. **Refresh cau hinh**:
   - Sau khi luu -> Refresh cau hinh he thong

4. **Mau sac**:
   - Dong khong cho sua: Xam
   - Dong cho sua: Den

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/Sysvars.php
namespace Diepxuan\Simba\Models\SI;

class Sysvars extends Model
{
    protected $table = 'Sysvars';
    protected $primaryKey = 'varName';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'varName',
        'varValue',
        'varDescrpt',
        'varType',
        'maxlength',
        'isEdit',
        'moduleid',
    ];

    protected $casts = [
        'isEdit' => 'boolean',
        'maxlength' => 'integer',
    ];

    public function scopeEditable($query)
    {
        return $query->where('isEdit', true);
    }

    public function scopeByModule($query, string $moduleid)
    {
        return $query->where('moduleid', $moduleid);
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/System/ThamsoHs.php
namespace Diepxuan\Catalog\Http\Livewire\SI\System;

class ThamsoHs extends Component
{
    public Collection $pDanhSach;
    public bool $pIsEditing = false;
    public ?string $pEditingVarName = null;
    public ?string $pEditingValue = null;

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->pDanhSach = Sysvars::orderBy('varDescrpt')->get();
    }

    public function startEdit(string $varName): void
    {
        $var = $this->pDanhSach->firstWhere('varName', $varName);
        if ($var && $var->isEdit) {
            $this->pIsEditing = true;
            $this->pEditingVarName = $varName;
            $this->pEditingValue = $var->varValue;
        }
    }

    public function save(): void
    {
        if (!$this->pEditingVarName) return;

        Sysvars::where('varName', $this->pEditingVarName)
            ->update(['varValue' => $this->pEditingValue]);

        $this->pIsEditing = false;
        $this->loadData();
    }

    public function render(): View
    {
        return view('catalog::si.system.thamsohs');
    }
}
```

### 3. Views

```
resources/views/catalog/si/system/
├── thamsohs.blade.php
└── _thamsohs-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/tham-so-hs', [ThamsoHs::class, 'render'])
            ->name('thamsohs');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | Sysvars.php | Chinh |
| Component | laravel-catalog | ThamsoHs.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model Sysvars
- [ ] Tao Livewire ThamsoHs
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test chi cho sua isEdit = 1
- [ ] Test refresh cau hinh