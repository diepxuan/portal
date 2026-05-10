# Task 133: FAThoiKHTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang thoi khoan khau hao tai san tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FAThoiKHTS.dll
- **Chuc nang:** Khai bao tam ngung khau hao tai san
- **Loai:** Configuration (Cau hinh)
- **Assembly Title:** Khai bao tam ngung khau hao tai san
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** FA (config)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FAThoiKHTS.dll/README.md`

---

## Cau truc du lieu

### Bang: FAThoiKHTS (Thoi khoan khau hao)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_cty | varchar | Ma cong ty |
| ma_ts | varchar | Ma tai san |
| ten_ts | nvarchar | Ten tai san |
| ngay_dung_kh | datetime | Ngay dung khau hao |
| ngay_kh_lai | datetime | Ngay khau hao lai |
| dien_giai | nvarchar | Dien giai |

---

## Form classes

### 1. frmFAThoiKHTS (Form xem danh sach)
- **Ke thua:** frmDMComplexView

### 2. frmFAThoiKHTSEdit (Form nhap lieu)
- **Ke thua:** frmDMComplexEdit

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_ts | AsTextBox | Ma tai san (MA_TS, AutoLookup) |
| lblTen_ts | Label | Ten tai san (AutoFill) |
| txtNgay_dung_kh | AsMaskedTextBox | Ngay dung KH (dd/MM/yyyy) |
| txtNgay_kh_lai | AsMaskedTextBox | Ngay KH lai (dd/MM/yyyy, optional) |
| txtDien_giai | TextBox | Dien giai |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asFAChkThoiKHTS | Kiem tra trung khai bao |
| asFaDelDungKH | Xoa khai bao |

### SP_CHECK (reference)

```sql
-- Kiem tra trung khai bao
EXEC asFAChkThoiKHTS
    @pMa_cty VARCHAR(50),
    @pMa_ts VARCHAR(50),
    @pNgay_dung_kh DATETIME
-- Returns: So luong ban ghi trung (int)
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ts | 'Ma tai san khong duoc trong' |
| Required | ngay_dung_kh | 'Ngay dung KH khong duoc trong' |
| Date range | ngay_kh_lai >= ngay_dung_kh | 'Ngay KH lai phai >= ngay dung' |
| Unique | ma_ts + ngay_dung_kh | 'Da co khai bao trung' |

### Business Rules

1. **Tu dong fill ten TS**: Khi nhap ma_ts -> hien thi ten_ts
2. **Ngay KH lai optional**: Co the de trong (neu chua co ngay KH lai)
3. **Kiem tra trung**: Khong cho phep trung ma_ts + ngay_dung_kh

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/FAThoiKHTS.php
namespace Diepxuan\Simba\Models\FA;

class FAThoiKHTS extends Model
{
    protected $table = 'FAThoiKHTS';
    protected $primaryKey = ['ma_ts', 'ngay_dung_kh'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cty', 'ma_ts', 'ten_ts', 'ngay_dung_kh', 'ngay_kh_lai', 'dien_giai',
    ];

    protected $casts = [
        'ngay_dung_kh' => 'datetime:d/m/Y',
        'ngay_kh_lai' => 'datetime:d/m/Y',
    ];

    public function taiSan()
    {
        return $this->belongsTo(FADMTS::class, 'ma_ts', 'ma_ts');
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/fa')
    ->name('catalog.fa.')
    ->group(function () {
        Route::get('/thoi-khoan-khau-hao', [Thoikhoankhauhao::class, 'render'])->name('thoi-khoan-khau-hao');
        Route::get('/thoi-khoan-khau-hao/edit', [ThoikhoankhauhaoEdit::class, 'render'])->name('thoi-khoan-khau-hao.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | FAThoiKHTS.php | Chinh |
| Model | laravel-simba | FADMTS.php | Tai san (FK) |
| Component | laravel-catalog | Thoikhoankhauhao.php | List |
| Component | laravel-catalog | ThoikhoankhauhaoEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_FA_THOIKH_GET, asFAChkThoiKHTS
- [ ] Tao Model FAThoiKHTS
- [ ] Tao Livewire Thoikhoankhauhao (list)
- [ ] Tao Livewire ThoikhoankhauhaoEdit (modal)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test kiem tra trung (ma_ts + ngay_dung_kh)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
