# Task 114: INDMVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang danh muc vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INDMVT.dll
- **Chuc nang:** Danh muc vat tu
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc vat tu
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (danh muc IN)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMVT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMVT (Danh muc vat tu)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_vt | varchar | 50 | Ma vat tu (khoa chinh) |
| ten_vt | nvarchar | 200 | Ten vat tu |
| dvt | nvarchar | 20 | Don vi tinh |
| ma_nhvt | varchar | 50 | Ma nhom vat tu |
| loai | int | - | Loai vat tu |
| gia_ton | int | - | Phuong phap gia ton |
| ma_kho | varchar | 50 | Kho mac dinh |
| ma_thue | varchar | 50 | Ma thue GTGT |
| tk_vt | varchar | 50 | TK vat tu (kho) |
| tk_dt | varchar | 50 | TK doanh thu |
| tk_dtnb | varchar | 50 | TK doanh thu noi bo |
| tk_gv | varchar | 50 | TK gia von |
| tk_tl | varchar | 50 | TK tra lai |
| tk_ck | varchar | 50 | TK chiet khau |
| sl_min | decimal | - | Ton toi thieu |
| sl_max | decimal | - | Ton toi da |
| gia_nt0 | decimal | - | Gia mua |
| gia_nt2 | decimal | - | Gia ban |
| ts_gtgt | decimal | - | Thue suat GTGT |
| ts_nk | decimal | - | Thue suat NK |
| ts_xk | decimal | - | Thue suat XK |
| ts_ttdb | decimal | - | Thue suat TTDN |
| dvt_mua | nvarchar | 20 | DVT mua |
| dvt_ban | nvarchar | 20 | DVT ban |
| hs_dvtmua | decimal | - | He so DVT mua |
| hs_dvtban | decimal | - | He so DVT ban |
| ton_kho | bit | 1 | Theo doi ton kho |

---

## Form classes

### 1. frmINDMVT (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmINDMVTEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:** txtMa_Vt, txtTen_Vt, cboDvt, txtMa_Nhvt, cboLoai, cboGia_ton, txtMa_kho, txtMa_Thue, cac TK, txtSl_min, txtSl_max, txtGia_nt0, txtGia_nt2, txtTs_Gtgt, cac DVT, chkTon_kho

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_DMVT_GET | Lay danh sach vat tu |
| SP_IN_DMVT_GETBYID | Lay chi tiet 1 vat tu |
| SP_IN_DMVT_INSERT | Them vat tu moi |
| SP_IN_DMVT_UPDATE | Cap nhat vat tu |
| SP_IN_DMVT_DELETE | Xoa vat tu |
| SP_IN_DMVT_FIND | Tim kiem vat tu |
| SP_IN_DMVT_CHECK | Kiem tra trung ma |

---

## Business Logic

### Business Rules

1. **Don vi tinh**: Kho, mua, ban co he so chuyen doi
2. **Gia ton kho**: Phuong phap tinh gia (1=thap hon, 2=NTXT, ...)
3. **Tai khoan**: Tu dong dien tu nhom vat tu khi chon ma_nhvt
4. **Ton kho**: Chi tiet ton kho khi ton_kho=1

---

## Mapping PHP

### 1. Model

```php
// app/Models/IN/DMVT.php
namespace Diepxuan\Simba\Models\IN;

class DMVT extends Model
{
    protected $table = 'DMVT';
    protected $primaryKey = 'ma_vt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_vt', 'ten_vt', 'dvt', 'ma_nhvt', 'loai', 'gia_ton',
        'ma_kho', 'ma_thue', 'tk_vt', 'tk_dt', 'tk_dtnb', 'tk_gv',
        'tk_tl', 'tk_ck', 'sl_min', 'sl_max', 'gia_nt0', 'gia_nt2',
        'ts_gtgt', 'ts_nk', 'ts_xk', 'ts_ttdb', 'dvt_mua', 'dvt_ban',
        'hs_dvtmua', 'hs_dvtban', 'ton_kho',
    ];

    protected $casts = [
        'ton_kho' => 'boolean',
        'sl_min' => 'decimal:8', 'sl_max' => 'decimal:8',
        'gia_nt0' => 'decimal:8', 'gia_nt2' => 'decimal:8',
    ];

    public function nhomVatTu()
    {
        return $this->belongsTo(DMNHVT::class, 'ma_nhvt', 'ma_nhvt');
    }
}
```

### 2. Routes

```php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/vat-tu', [Vattu::class, 'render'])->name('vat-tu');
        Route::get('/vat-tu/edit/{maVt?}', [VattuEdit::class, 'render'])->name('vat-tu.edit');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model DMVT
- [ ] Tao Livewire Vattu va VattuEdit
- [ ] Tao Views (list + edit voi nhieu field)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test AutoLookup tai khoan tu nhom VT
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `in.dmvt`
- **Note:** Route đã có hoặc shell metadata; write/transfer execute chỉ mở khi payload/side effect được audit.
