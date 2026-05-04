# Task 132: FADMNHTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang danh muc nhom tai san tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADMNHTS.dll
- **Chuc nang:** Danh muc nhom tai san (3 cap)
- **Loai:** Danh muc (DM)
- **Assembly Title:** danh muc phan nhom tai san co dinh
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** FA (danh muc FA)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADMNHTS.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNHTS (Danh muc nhom tai san)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_nhts | varchar | 50 | Ma nhom tai san (khoa chinh) |
| ten_nhts | nvarchar | 200 | Ten nhom tai san |
| loai_nh | int | - | Loai nhom (1/2/3) |
| ksd | bit | 1 | Khoa su dung |

### Lookup conditions cho FADMTS

| Field | LookupCode | Condition |
|-------|------------|-----------|
| txtMa_nhts1 | MA_NHTS | loai_nh='1' |
| txtMa_nhts2 | MA_NHTS | loai_nh='2' |
| txtMa_nhts3 | MA_NHTS | loai_nh='3' |

---

## Form classes

### 1. frmFADMNHTS (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmFADMNHTSEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit

---

## Business Logic

### Business Rules

1. **3 cap nhom**: loai_nh = 1, 2, hoac 3
2. **Phan cap**: Nhom 1 -> Nhom 2 -> Nhom 3

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/DMNHTS.php
namespace Diepxuan\Simba\Models\FA;

class DMNHTS extends Model
{
    protected $table = 'DMNHTS';
    protected $primaryKey = 'ma_nhts';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_nhts', 'ten_nhts', 'loai_nh', 'ksd'];
    protected $casts = ['ksd' => 'boolean', 'loai_nh' => 'integer'];
}
```

### 2. Routes

```php
Route::prefix('catalog/fa/danhmuc')
    ->name('catalog.fa.danhmuc.')
    ->group(function () {
        Route::get('/nhom-tai-san', [Nhomtaisan::class, 'render'])->name('nhom-tai-san');
        Route::get('/nhom-tai-san/edit/{maNhts?}', [NhomtaisanEdit::class, 'render'])->name('nhom-tai-san.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model DMNHTS
- [ ] Tao Livewire Nhomtaisan va NhomtaisanEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations voi 3 cap nhom