# Task 068: PODMHTTT

## Nhom: PO (Purchase Order - Don hang mua)

## Muc tieu
Chuyen doi chuc nang danh muc hinh thuc thanh toan mua tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** PODMHTTT.dll
- **Chuc nang:** Danh muc hinh thuc thanh toan mua
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc hinh thuc thanh toan mua
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** PODMHTTT

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/PODMHTTT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMHTTT (Danh muc hinh thuc thanh toan)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_httt | varchar | 50 | Ma hinh thuc (khoa chinh) |
| ten_httt | nvarchar | 200 | Ten hinh thuc |
| tk | varchar | 50 | Tai khoan thanh toan |
| tk_thue_mua | varchar | 50 | Tai khoan thue GTGT mua |
| tk_thue_nk | varchar | 50 | Tai khoan thue NK |
| tk_gtgt_nk_no | varchar | 50 | TK GTGT NK no |
| tk_gtgt_nk_co | varchar | 50 | TK GTGT NK co |
| tk_thue_ttdb | varchar | 50 | TK thue TTDac biet |
| tk_ck | varchar | 50 | TK chiet khau |
| thue_gtgt_tralai | varchar | 50 | TK thue GTGT tra lai |
| ksd | bit | 1 | Khoa su dung |

---

## Form classes

### 1. frmPODMHTTT (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi danh sach |
| txtSearch | TextBox | Tim kiem |
| btnAdd/Edit/Delete | Button | CRUD |

### 2. frmPODMHTTTEdit (Form them/sua)
- **Ke thua:** frmDMComplexEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_httt | AsTextBox | ma_httt | Ma hinh thuc |
| txtTen_httt | TextBox | ten_httt | Ten hinh thuc |
| txtTK | AsTextBox | tk | TK thanh toan |
| lblTen_Tk | Label | - | Ten TK |
| txtThue_mua | AsTextBox | tk_thue_mua | TK thue mua |
| lblTen_Tk_thue_mua | Label | - | Ten TK thue |
| txtThue_NK | AsTextBox | tk_thue_nk | TK thue NK |
| txtTK_NK_no | AsTextBox | tk_gtgt_nk_no | TK NK no |
| txtTK_NK_co | AsTextBox | tk_gtgt_nk_co | TK NK co |
| txtTk_thue_ttdb | AsTextBox | tk_thue_ttdb | TK thue TTDB |
| txtTk_ck | AsTextBox | tk_ck | TK chiet khau |
| txtThue_gtgt_tralai | AsTextBox | thue_gtgt_tralai | TK thue GTGT tra lai |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_PO_DMHTTT_GET | Lay danh sach |
| SP_PO_DMHTTT_GETBYID | Lay chi tiet |
| SP_PO_DMHTTT_INSERT | Them moi |
| SP_PO_DMHTTT_UPDATE | Cap nhat |
| SP_PO_DMHTTT_DELETE | Xoa |
| SP_PO_DMHTTT_FIND | Tim kiem |
| SP_PO_DMHTTT_CHECK | Kiem tra trung ma |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_httt | 'Ma hinh thuc khong duoc trong' |
| Unique | ma_httt | 'Ma da ton tai' |
| Required | ten_httt | 'Ten hinh thuc khong duoc trong' |
| Valid TK | tk | 'Tai khoan khong ton tai' |

### Business Rules

1. **Tai khoan ke toan**:
   - Tat ca cac tai khoan deu la AutoLookup
   - Hien thi ten khi chon ma

2. **Cau hinh mac dinh**:
   - Lay tu POConfiguration
   - TK phai tra, TK thue GTGT, TK thue NK...

3. **Hinh thuc thanh toan**:
   - TM: Tien mat
   - CK: Chuyen khoan
   - LC: Letter of Credit

---

## Mapping PHP

### 1. Model

```php
// app/Models/PO/DMHTTT.php
namespace Diepxuan\Simba\Models\PO;

class DMHTTT extends Model
{
    protected $table = 'DMHTTT';
    protected $primaryKey = 'ma_httt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_httt',
        'ten_httt',
        'tk',
        'tk_thue_mua',
        'tk_thue_nk',
        'tk_gtgt_nk_no',
        'tk_gtgt_nk_co',
        'tk_thue_ttdb',
        'tk_ck',
        'thue_gtgt_tralai',
        'ksd',
    ];

    protected $casts = [
        'ksd' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/PO/Danhmuc/Hinhthuctt.php
namespace Diepxuan\Catalog\Http\Livewire\PO\Danhmuc;

class Hinhthuctt extends Component
{
    const MA_CT = 'PODMHTTT';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::po.danhmuc.hinhthuctt');
    }
}
```

### 3. Views

```
resources/views/catalog/po/danhmuc/
├── hinhthuctt.blade.php
├── hinhthuctt-edit.blade.php
└── _hinhthuctt-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/po/danhmuc')
    ->name('catalog.po.danhmuc.')
    ->group(function () {
        Route::get('/hinh-thuc-tt', [Hinhthuctt::class, 'render'])
            ->name('hinhthuctt');
        Route::get('/hinh-thuc-tt/edit/{ma_httt?}', [HinhthucttEdit::class, 'render'])
            ->name('hinhthuctt.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMHTTT.php | Chinh |
| Component | laravel-catalog | Hinhthuctt.php | List |
| Component | laravel-catalog | HinhthucttEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao SP classes
- [ ] Tao Model DMHTTT
- [ ] Tao Livewire Hinhthuctt
- [ ] Tao Livewire HinhthucttEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test TK AutoLookup