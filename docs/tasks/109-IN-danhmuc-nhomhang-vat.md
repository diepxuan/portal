# Task 109: INDMNHVAT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang danh muc nhom hang VAT tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** INDMNHVAT.dll
- **Chuc nang:** Danh muc nhom hang VAT
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc nhom hang VAT
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMNHVAT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNHVAT (Danh muc nhom hang VAT)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_nhvat | varchar | 50 | Ma nhom VAT (khoa chinh) |
| ten_nhvat | nvarchar | 200 | Ten nhom VAT |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

---

## Form classes

### 1. frmINDMNHVAT (Form xem danh sach)
- **Ke thua:** frmDMView

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| cmdAdd | Button | Nut them moi |
| cmdEdit | Button | Nut sua |
| cmdDel | Button | Nut xoa |

### 2. frmINDMNHVATEdit (Form them/sua)
- **Ke thua:** frmDMEdit

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_NhVat | TextBox | ma_nhvat | Ma nhom VAT |
| txtTen_NhVat | TextBox | ten_nhvat | Ten nhom VAT |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_DMNHVAT_GET | Lay danh sach nhom VAT |
| SP_IN_DMNHVAT_GETBYID | Lay chi tiet 1 nhom VAT |
| SP_IN_DMNHVAT_INSERT | Them nhom VAT moi |
| SP_IN_DMNHVAT_UPDATE | Cap nhat nhom VAT |
| SP_IN_DMNHVAT_DELETE | Xoa nhom VAT |
| SP_IN_DMNHVAT_FIND | Tim kiem nhom VAT |
| SP_IN_DMNHVAT_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_nhvat | 'Ma nhom VAT khong duoc trong' |
| Max length | ma_nhvat | 'Ma nhom VAT toi da 50 ky tu' |
| Unique | ma_nhvat | 'Ma nhom VAT da ton tai' |
| Required | ten_nhvat | 'Ten nhom VAT khong duoc trong' |

### Business Rules

1. **Ma nhom VAT**: AutoGenerate hoac nhap tay
2. **Khoa su dung**: Mac dinh = 0, ksd=1 an khoi danh sach chon

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/DMNHVAT.php
namespace Diepxuan\Simba\Models\IN;

class DMNHVAT extends Model
{
    protected $table = 'DMNHVAT';
    protected $primaryKey = 'ma_nhvat';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_nhvat', 'ten_nhvat', 'ksd'];
    protected $casts = ['ksd' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/Nhomhangvat.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class Nhomhangvat extends Component
{
    public function render(): View
    {
        return view('catalog::in.danhmuc.nhom-hang-vat');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/NhomhangvatEdit.php
class NhomhangvatEdit extends Component
{
    public ?string $pMaNhvat = null;
    public string $pTenNhvat = '';
    public bool $pKsd = false;

    public function render(): View
    {
        return view('catalog::in.danhmuc.nhom-hang-vat-edit');
    }
}
```

### 3. Routes

```php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/nhom-hang-vat', [Nhomhangvat::class, 'render'])->name('nhom-hang-vat');
        Route::get('/nhom-hang-vat/edit/{maNhvat?}', [NhomhangvatEdit::class, 'render'])->name('nhom-hang-vat.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model DMNHVAT
- [ ] Tao Livewire Nhomhangvat (list)
- [ ] Tao Livewire NhomhangvatEdit (modal)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `in.dict.nhvat`
- **Note:** Route đã có hoặc shell metadata; write/transfer execute chỉ mở khi payload/side effect được audit.
