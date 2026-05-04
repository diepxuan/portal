# Task 112: INDMPLVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang danh muc phan loai vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INDMPLVT.dll
- **Chuc nang:** Danh muc phan loai vat tu
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc phan loai vat tu - IN input
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMPLVT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMPLVT (Danh muc phan loai vat tu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_plvt | varchar | 50 | Ma phan loai VT (khoa chinh) |
| ten_plvt | nvarchar | 200 | Ten phan loai VT |
| loai | int | - | Kieu phan loai (1/2/3) |
| ksd | bit | 1 | Khoa su dung |

---

## Form classes

### 1. frmINDMPLVT (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmINDMPLVTEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Plvt | TextBox | ma_plvt | Ma phan loai |
| txtTen_Plvt | TextBox | ten_plvt | Ten phan loai |
| cboLoai | ComboBox | loai | Kieu (1/2/3) |

---

## Business Logic

### Business Rules

1. **3 kieu phan loai**: Loai 1, 2, 3 (phan cap nhom vat tu)
2. **Khoa su dung**: An khi ksd = 1

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/DMPLVT.php
namespace Diepxuan\Simba\Models\IN;

class DMPLVT extends Model
{
    protected $table = 'DMPLVT';
    protected $primaryKey = 'ma_plvt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_plvt', 'ten_plvt', 'loai', 'ksd'];
    protected $casts = ['ksd' => 'boolean', 'loai' => 'integer'];
}
```

### 2. Routes

```php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/phan-loai-vat-tu', [Phanloaivattu::class, 'render'])->name('phan-loai-vat-tu');
        Route::get('/phan-loai-vat-tu/edit/{maPlvt?}', [PhanloaivattuEdit::class, 'render'])->name('phan-loai-vat-tu.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model DMPLVT
- [ ] Tao Livewire Phanloaivattu va PhanloaivattuEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations