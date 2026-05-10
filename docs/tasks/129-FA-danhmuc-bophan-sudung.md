# Task 129: FADMBPSD

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang danh muc bo phan su dung tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADMBPSD.dll
- **Chuc nang:** Danh muc bo phan su dung
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc bo phan su dung
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** FA (danh muc FA)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADMBPSD.dll/README.md`

---

## Cau truc du lieu

### Bang: DMBPSD (Danh muc bo phan su dung)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_bpsd | varchar | 50 | Ma bo phan SD (khoa chinh) |
| ten_bpsd | nvarchar | 200 | Ten bo phan SD |
| ksd | bit | 1 | Khoa su dung |

---

## Form classes

### 1. frmFADMBPSD (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmFADMBPSDEdit (Form them/sua)
- **Ke thua:** frmDMEdit

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Bp | TextBox | ma_bpsd | Ma bo phan |
| txtTen_Bp | TextBox | ten_bpsd | Ten bo phan |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_DMBPSD_GET | Lay danh sach |
| SP_FA_DMBPSD_GETBYID | Lay chi tiet |
| SP_FA_DMBPSD_INSERT | Them |
| SP_FA_DMBPSD_UPDATE | Cap nhat |
| SP_FA_DMBPSD_DELETE | Xoa |
| SP_FA_DMBPSD_FIND | Tim kiem |
| SP_FA_DMBPSD_CHECK | Kiem tra trung ma |

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/DMBPSD.php
namespace Diepxuan\Simba\Models\FA;

class DMBPSD extends Model
{
    protected $table = 'DMBPSD';
    protected $primaryKey = 'ma_bpsd';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_bpsd', 'ten_bpsd', 'ksd'];
    protected $casts = ['ksd' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/fa/danhmuc')
    ->name('catalog.fa.danhmuc.')
    ->group(function () {
        Route::get('/bo-phan-su-dung', [Bophansudung::class, 'render'])->name('bo-phan-su-dung');
        Route::get('/bo-phan-su-dung/edit/{maBpsd?}', [BophansudungEdit::class, 'render'])->name('bo-phan-su-dung.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model DMBPSD
- [ ] Tao Livewire Bophansudung va BophansudungEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
