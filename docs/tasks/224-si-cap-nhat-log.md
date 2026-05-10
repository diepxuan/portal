# Task 224: SI-Cap-Nhat-Log

## Nhom: SI (System Integration)

## Muc tieu
Chuyen doi chuc nang cap nhat log tu .NET sang PHP Laravel, dat ket qua tuong duong SiUpdateLog.

## Chi tiet
- **DLL:** SiUpdateLog.dll
- **Chuc nang:** Quan ly log cap nhat & tao package update (Update Log Management)
- **Loai:** Utility (UTL)
- **Assembly Title:** WindowsApplication1
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SiUpdateLog.dll/README.md`

---

## Form classes

### frmSiUpdateLog (Form chinh)
- **Ke thua:** frmDMView
- **Controls:**

| Control | Mo ta |
|---------|-------|
| frmSiUpdateLogEdit | Form chinh sua log |
| frmCreateConnection | Form tao ket noi |
| frmFilterOjectToUpdate | Form loc doi tuong update |
| frmHistory | Form xem lich su |
| frmLookup | Form tra cuu |

### frmSiUpdateLogEdit
- **Controls:**

| Control | Mo ta |
|---------|-------|
| &Tao File | Tao file zip |
| &History | Xem lich su |

---

## Business Logic

### Tao package update (Zip)

1. Chon cac doi tuong can update:
   - Files (DLL, RPT)
   - Database Objects (Functions, SP, Views)
2. Xuat SQL script cho DB objects:
   ```sql
   -- Functions: TYPE IN (N'FN', N'IF', N'TF', N'FS', N'FT')
   -- SP: TYPE IN (N'P', N'PC')
   ```
3. Tao file Readme.txt
4. Nen thanh file .zip

### Cu truc file zip

```
/Readme.txt
/TSQL/*.sql
/_Dlls/*.dll
/Reports/*.rpt
/Reports/NT/*.rpt
```

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/UpdateLog.php
namespace Diepxuan\Simba\Models\SI;

class UpdateLog extends Model
{
    protected $connection = 'simba';

    protected $fillable = [
        'bug_number',
        'product_name',
        'description',
        'note',
        'created_at',
    ];

    public static function createPackage(array $objects): string
    {
        // Tao file zip package
    }

    public static function exportSqlScript(array $dbObjects): string
    {
        // Xuat SQL script
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/CapnhatLog.php
namespace Diepxuan\Catalog\Http\Livewire\SI\CapnhatLog;

class CapnhatLog extends Component
{
    public Collection $pList;

    public function mount(): void
    {
        $this->loadList();
    }

    public function loadList(): void
    {
        // Load tu database
    }

    public function createPackage(array $selectedObjects): string
    {
        return UpdateLog::createPackage($selectedObjects);
    }

    public function exportSql(): string
    {
        return UpdateLog::exportSqlScript($this->pSelectedDbObjects);
    }

    public function render(): View
    {
        return view('catalog::si.capnhatlog');
    }
}
```

### 3. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/cap-nhat-log', [CapnhatLog::class, 'render'])
            ->name('capnhatlog');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model UpdateLog
- [ ] Tao Livewire component
- [ ] Tao View
- [ ] Implement zip creation
- [ ] Implement SQL script export
- [ ] Them Routes
- [ ] Test tao package update
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
