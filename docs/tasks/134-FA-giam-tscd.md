# Task 134: FAGiamTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang giam tai san co dinh tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FAGiamTS.dll
- **Chuc nang:** Khai bao giam tai san co dinh
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Khai bao giam tai san co dinh
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (giam)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FAGiamTS.dll/README.md`

---

## Cau truc du lieu

### Bang: FAGiamTS (Khai bao giam tai san)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_cty | varchar | Ma cong ty |
| stt_rec | varchar | So thu tu record |
| ma_ts | varchar | Ma tai san |
| ten_ts | nvarchar | Ten tai san (read-only tu DMTS) |
| t_ng_gia | decimal | Tong nguyen gia (read-only) |
| so_ct_giam | varchar | So chung tu/bien ban |
| ngay_ct_giam | datetime | Ngay chung tu |
| ngay_giam | datetime | Ngay giam |
| ma_giam_ts | varchar | Ma ly do giam (MA_LDTG, tg='G') |

### Thong tin tai san goc (read-only)

| Truong | Mo ta |
|--------|-------|
| ngay_tang | Ngay tang tai san |
| ngay_bdkh | Ngay bat dau khau hao |
| st_kh | So thang khau hao |
| so_luong | So luong |

---

## Form classes

### 1. frmFAGiamTS (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmFAGiamTSEdit (Form nhap lieu)
- **Ke thua:** frmDMEdit

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_ts | AsTextBox | Ma tai san (MA_TS, lookup) |
| txtTen_ts | TextBox | Ten tai san (read-only) |
| txtT_ng_gia | TextBox | Tong nguyen gia (read-only) |
| txtSo_ct_giam | TextBox | So chung tu/bien ban |
| txtNgay_ct_giam | AsMaskedTextBox | Ngay chung tu |
| txtNgay_giam | AsMaskedTextBox | Ngay giam |
| txtMa_giam_ts | AsTextBox | Ma ly do giam (MA_LDTG, tg='G') |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_GIAMTS_GET | Lay danh sach |
| SP_FA_GIAMTS_GETBYID | Lay chi tiet |
| SP_FA_GIAMTS_INSERT | Them |
| SP_FA_GIAMTS_UPDATE | Cap nhat |
| SP_FA_GIAMTS_DELETE | Xoa |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ts | 'Ma tai san khong duoc trong' |
| Required | so_ct_giam | 'So chung tu khong duoc trong' |
| Required | ngay_ct_giam | 'Ngay chung tu khong duoc trong' |
| Required | ngay_giam | 'Ngay giam khong duoc trong' |
| Required | ma_giam_ts | 'Ly do giam khong duoc trong' |
| Date range | ngay_giam >= ngay_tang | 'Ngay giam phai sau ngay tang' |

### Business Rules

1. **Tu dong fill**: Khi chon ma_ts -> tu dong hien thi ten_ts, nguyen_gia, ngay_tang, ngay_bdkh, st_kh
2. **Ngay giam**: Phai >= ngay_tang (ngay tang tai san goc)
3. **Ly do giam**: Lookup voi dieu kien tg='G' (giam)

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/FAGiamTS.php
namespace Diepxuan\Simba\Models\FA;

class FAGiamTS extends Model
{
    protected $table = 'FAGiamTS';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'stt_rec', 'ma_ts', 'ten_ts', 't_ng_gia',
        'so_ct_giam', 'ngay_ct_giam', 'ngay_giam', 'ma_giam_ts',
    ];

    protected $casts = [
        'ngay_ct_giam' => 'datetime',
        'ngay_giam' => 'datetime',
        't_ng_gia' => 'decimal:8',
    ];

    public function taiSan()
    {
        return $this->belongsTo(FADMTS::class, 'ma_ts', 'ma_ts');
    }

    public function lyDoGiam()
    {
        return $this->belongsTo(DMLDTG::class, 'ma_giam_ts', 'ma_ldtg');
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/fa')
    ->name('catalog.fa.')
    ->group(function () {
        Route::get('/giam-tai-san', [Giamtaisan::class, 'render'])->name('giam-tai-san');
        Route::get('/giam-tai-san/edit/{sttRec?}', [GiamtaisanEdit::class, 'render'])->name('giam-tai-san.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model FAGiamTS
- [ ] Tao Livewire Giamtaisan va GiamtaisanEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test AutoFill thong tin tai san goc
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
