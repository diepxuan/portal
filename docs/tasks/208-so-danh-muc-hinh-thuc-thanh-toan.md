# Task 208: SO-Danh-Muc-Hinh-Thuc-Thanh-Toan

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc hinh thuc thanh toan tu .NET sang PHP Laravel, dat ket qua tuong duong SODMHTTT.

## Chi tiet
- **DLL:** SODMHTTT.dll
- **Chuc nang:** Danh muc hinh thuc thanh toan (Payment Method Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMHTTT.dll/README.md`

---

## Cau truc du lieu

### Bang: dmhttt (Danh muc hinh thuc thanh toan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_httt | varchar | 20 | Ma hinh thuc thanh toan (khoa chinh) |
| ten_httt | nvarchar | 255 | Ten hinh thuc thanh toan |
| tk | varchar | 20 | Tai khoan phai thu (lookup) |
| tk_thue_gtgt_ban | varchar | 20 | TK thue GTGT ban hang |
| tk_ck | varchar | 20 | TK chiet khau thanh toan |
| loai | varchar | 10 | Loai HTTT (TM/CK/TM_CK) |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Tai khoan ke toan | FK tk, tk_thue_gtgt_ban, tk_ck -> DMTK |
| DMKH | Khach hang | FK ma_httt (mac dinh) |

---

## Form classes

### 1. frmSODMHTTT (Form xem danh sach)
- **Ke thua:** frmCategoryList
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvcMa_Httt | DataGridViewColumn | Ma HTTT |
| dgvcTen_Httt | DataGridViewColumn | Ten HTTT |
| dgvcTk | DataGridViewColumn | TK phai thu |
| dgvcTk_Thue_Gtgt_Ban | DataGridViewColumn | TK thue GTGT |
| dgvcTk_Ck | DataGridViewColumn | TK chiet khau |
| dgvcLoai | DataGridViewColumn | Loai |

### 2. frmSODMHTTTEdit (Form them/sua)
- **Ke thua:** frmCategoryEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Httt | AsTextBox | ma_httt | Ma HTTT |
| txtTen_Httt | TextBox | ten_httt | Ten HTTT |
| txtTk | AsTextBox | tk | TK phai thu (AutoLookup) |
| lblTen_Tk | Label | - | Ten TK hien thi |
| txtTk_Thue_Gtgt_Ban | AsTextBox | tk_thue_gtgt_ban | TK thue GTGT |
| txtTk_Ck | AsTextBox | tk_ck | TK chiet khau |
| cboLoai | ComboBox | loai | Loai HTTT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMHTTT_GET | Lay danh sach |
| SP_SO_DMHTTT_GETBYID | Lay chi tiet |
| SP_SO_DMHTTT_INSERT | Them moi |
| SP_SO_DMHTTT_UPDATE | Cap nhat |
| SP_SO_DMHTTT_DELETE | Xoa |
| SP_SO_DMHTTT_FIND | Tim kiem |
| SP_SO_DMHTTT_CHECK | Kiem tra trung |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMHTTT_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_httt VARCHAR(20),
    @pTen_httt NVARCHAR(255),
    @pTk VARCHAR(20),
    @pTk_Thue_Gtgt_Ban VARCHAR(20),
    @pTk_Ck VARCHAR(20),
    @pLoai VARCHAR(10),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Cac loai HTTT

| Ma | Ten | Mo ta |
|----|-----|-------|
| TM | Tien mat | Thanh toan bang tien mat |
| CK | Chuyen khoan | Thanh toan qua ngan hang |
| TM_CK | Tien mat/Chuyen khoan | Ket hop ca hai |

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_httt | 'Ma HTTT khong duoc trong' |
| Unique | ma_httt | 'Ma HTTT da ton tai' |
| Required | ten_httt | 'Ten HTTT khong duoc trong' |
| Lookup valid | tk | 'Tai khoan khong ton tai' |
| Lookup valid | tk_thue_gtgt_ban | 'Tai khoan thue khong ton tai' |

### Business Rules

1. **Khi chon HTTT tren hoa don**:
   - Tu dong lay tk (TK phai thu KH)
   - Tu dong lay tk_thue_gtgt_ban (TK thue GTGT dau ra)
   - Tu dong lay tk_ck (TK chiet khau thanh toan neu co)

2. **HTTT mac dinh cho KH**:
   - Moi khach hang co the co HTTT mac dinh
   - Khi tao hoa don, HTTT mac dinh tu KH

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMhttt.php
namespace Diepxuan\Simba\Models\SO;

class DMhttt extends Model
{
    protected $table = 'dmhttt';
    protected $primaryKey = 'ma_httt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const LOAI_TM = 'TM';
    const LOAI_CK = 'CK';
    const LOAI_TM_CK = 'TM_CK';

    protected $fillable = [
        'ma_httt',
        'ten_httt',
        'tk',
        'tk_thue_gtgt_ban',
        'tk_ck',
        'loai',
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'tk', 'tk');
    }

    public function taiKhoanThue()
    {
        return $this->belongsTo(DMTK::class, 'tk_thue_gtgt_ban', 'tk');
    }

    public function taiKhoanCk()
    {
        return $this->belongsTo(DMTK::class, 'tk_ck', 'tk');
    }

    public function scopeTienMat($query)
    {
        return $query->where('loai', self::LOAI_TM);
    }

    public function scopeChuyenKhoan($query)
    {
        return $query->where('loai', self::LOAI_CK);
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetDMhttt.php
class AsSOGetDMhttt extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMHTTT_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOInsDMhttt.php
class AsSOInsDMhttt extends StoredProcedure
{
    protected $procedure = 'SP_SO_DMHTTT_INSERT';
    protected $params = ['pMa_cty', 'pMa_httt', 'pTen_httt', 'pTk', 'pTk_Thue_Gtgt_Ban', 'pTk_Ck', 'pLoai'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsSOUpdDMhttt.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSODelDMhttt.php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOChkDMhttt.php
```

### 3. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Hinhthucthanhtoan.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Hinhthucthanhtoan;

class Hinhthucthanhtoan extends Component
{
    public Collection $pList;
    public string $pSearch = '';

    public function mount(): void
    {
        $this->loadList();
    }

    public function render(): View
    {
        return view('catalog::so.hinhthucthanhtoan');
    }
}
```

### 4. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/HinhthucthanhtoanEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\HinhthucthanhtoanEdit;

class HinhthucthanhtoanEdit extends Component
{
    public ?string $pMaHttt = null;
    public string $pTenHttt = '';
    public string $pTk = '';
    public string $pTenTk = '';
    public string $pTkThueGtgtBan = '';
    public string $pTkCk = '';
    public string $pLoai = 'TM';
    public ?string $pMode = 'create';

    protected $rules = [
        'pMaHttt' => 'required|string|max:20',
        'pTenHttt' => 'required|string|max:255',
        'pTk' => 'required|string|exists:dmtk,tk',
        'pLoai' => 'required|in:TM,CK,TM_CK',
    ];

    public function mount(?string $maHttt = null): void
    {
        if ($maHttt) {
            $this->pMaHttt = $maHttt;
            $this->loadData();
        }
    }

    public function updatedPTk($value): void
    {
        $tk = DMTK::where('tk', $value)->where('chi_tiet', 1)->first();
        $this->pTenTk = $tk->ten_tk ?? '';
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.hinhthucthanhtoan-edit');
    }
}
```

### 5. Views

```
resources/views/catalog/so/
├── hinhthucthanhtoan/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 6. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/hinh-thuc-thanh-toan', [Hinhthucthanhtoan::class, 'render'])
            ->name('hinhthucthanhtoan');
        Route::get('/hinh-thuc-thanh-toan/edit/{maHttt?}', [HinhthucthanhtoanEdit::class, 'render'])
            ->name('hinhthucthanhtoan.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMhttt.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |
| SP | laravel-simba | AsSOGetDMhttt.php | Get list |
| SP | laravel-simba | AsSOInsDMhttt.php | Insert |
| SP | laravel-simba | AsSOUpdDMhttt.php | Update |
| SP | laravel-simba | AsSODelDMhttt.php | Delete |
| Component | laravel-catalog | Hinhthucthanhtoan.php | List |
| Component | laravel-catalog | HinhthucthanhtoanEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMhttt
- [ ] Tao Livewire Hinhthucthanhtoan (list)
- [ ] Tao Livewire HinhthucthanhtoanEdit (edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Lookup tai khoan
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
