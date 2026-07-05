# Task 244: FADMTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang danh muc tai san co dinh tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADMTS.dll
- **Chuc nang:** Quan ly danh muc tai san co dinh
- **Loai:** Danh muc (DM)
- **Assembly Title:** ARDMKH
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Danh muc)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADMTS.dll/README.md`

---

## Cau truc du lieu

### Bang: FADMTS (Danh muc tai san co dinh)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_ts | varchar | 50 | Ma tai san (khoa chinh) |
| ten_ts | nvarchar | 200 | Ten tai san |
| dvt | varchar | 20 | Don vi tinh |
| ma_ncc | varchar | 50 | Nha cung cap |
| nuoc_sx | nvarchar | 100 | Nuoc san xuat |
| cong_suat | nvarchar | 100 | Cong suat |
| nam_sx | int | 4 | Nam san xuat |
| so_luong | decimal | 18,6 | So luong |
| ngay_dc_sd | datetime | 8 | Ngay dua vao su dung |
| ngay_tang | datetime | 8 | Ngay tang |
| ma_tg_ts | varchar | 50 | Ma ly do tang |
| ngay_bdkh | datetime | 8 | Ngay bat dau KH |
| ngay_gt_cl | datetime | 8 | Ngay ghi nhan GTCL |
| ngay_dc | datetime | 8 | Ngay dinh chi |
| ld_dc | nvarchar | 500 | Ly do dinh chi |
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| st_kh | int | 4 | So thang khau hao |
| tl_kh | decimal | 18,6 | Ty le khau hao |
| tk_ts | varchar | 20 | TK tai san |
| tk_kh | varchar | 20 | TK khau hao |
| tk_cp | varchar | 20 | TK chi phi |
| ma_bpsd | varchar | 50 | Ma bo phan su dung |
| ma_spct | varchar | 50 | Ma SPCT |
| ma_phi | varchar | 50 | Ma phi |
| ma_nhts1 | varchar | 50 | Ma nhom TS 1 |
| ma_nhts2 | varchar | 50 | Ma nhom TS 2 |
| ma_nhts3 | varchar | 50 | Ma nhom TS 3 |
| ng_gia_n1 | decimal | 18,2 | Nguyen gia nguon von 1 |
| ng_gia_n2 | decimal | 18,2 | Nguyen gia nguon von 2 |
| ng_gia_n3 | decimal | 18,2 | Nguyen gia nguon von 3 |
| ng_gia_n4 | decimal | 18,2 | Nguyen gia nguon von 4 |
| gt_kh_n1 | decimal | 18,2 | GT khau hao nguon von 1 |
| gt_kh_n2 | decimal | 18,2 | GT khau hao nguon von 2 |
| gt_kh_n3 | decimal | 18,2 | GT khau hao nguon von 3 |
| gt_kh_n4 | decimal | 18,2 | GT khau hao nguon von 4 |
| gt_cl_n1 | decimal | 18,2 | GT con lai nguon von 1 |
| gt_cl_n2 | decimal | 18,2 | GT con lai nguon von 2 |
| gt_cl_n3 | decimal | 18,2 | GT con lai nguon von 3 |
| gt_cl_n4 | decimal | 18,2 | GT con lai nguon von 4 |
| kh_th_n1 | decimal | 18,2 | KH thang nguon von 1 |
| kh_th_n2 | decimal | 18,2 | KH thang nguon von 2 |
| kh_th_n3 | decimal | 18,2 | KH thang nguon von 3 |
| kh_th_n4 | decimal | 18,2 | KH thang nguon von 4 |
| sua_kh | bit | 1 | Cho phep sua KH |
| stt_rec | varchar | 50 | STT record |

### Bang: FADMLK (Danh muc linh kien - Sub table)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_cty | varchar | Ma cong ty |
| ma_ts | varchar | Ma tai san |
| ma_lk | varchar | Ma linh kien |
| ten_lk | nvarchar | Ten linh kien |
| dvt | varchar | Don vi tinh |
| so_luong | decimal | So luong |
| gia_tri | decimal | Gia tri |
| ksd | bit | Khoa su dung |

---

## Form classes

### 1. frmFADMTS (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach tai san

### 2. frmFADMTSEdit (Form them/sua - 3 tabs)
- **Ke thua:** frmDMEdit
- **Tabs:**

| Tab | Controls |
|-----|----------|
| tabTTC | Thong tin chung: ma_ts, ten_ts, dvt, ncc, nuoc_sx, cong_suat, nam_sx, so_luong... |
| tabTTKH | Thong tin KH: st_kh, tl_kh, tk_ts, tk_kh, tk_cp, ng_gia_n1-4, gt_kh_n1-4... |
| tabPT_LK | Phu tung, linh kien: grid linh kien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_DMTS_GET | Lay danh sach tai san |
| SP_FA_DMTS_GETBYID | Lay chi tiet 1 tai san |
| SP_FA_DMTS_INSERT | Them tai san |
| SP_FA_DMTS_UPDATE | Cap nhat tai san |
| SP_FA_DMTS_DELETE | Xoa tai san |
| SP_FA_DMTS_FIND | Tim kiem tai san |
| SP_FA_DMTS_CHECK | Kiem tra trung ma |

---

## Business Logic

### Business Rules

1. **3 tabs thong tin**:
   - TTC: Thong tin chung
   - TTKH: Thong tin khau hao (4 nguon von)
   - PT_LK: Phu tung linh kien

2. **4 nguon von**:
   - nv1, nv2, nv3, nv4
   - Tong ng_gia = sum(nv1..nv4)
   - Tong gt_kh = sum(gt_kh_n1..4)
   - Tong gt_cl = sum(gt_cl_n1..4)

3. **Khau hao**:
   - Tinh tu ngay_bdkh
   - Theo thang (st_kh) hoac ty le (tl_kh)
   - sua_kh cho phep nhap tay

4. **Linh kien**:
   - Grid danh sach linh kien
   - Thuoc ve tai san nao

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/FADMTS.php
namespace Diepxuan\Simba\Models\FA;

class FADMTS extends Model
{
    protected $table = 'FADMTS';
    protected $primaryKey = 'ma_ts';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_ts', 'ten_ts', 'dvt', 'ma_ncc', 'nuoc_sx', 'cong_suat', 'nam_sx',
        'so_luong', 'ngay_dc_sd', 'ngay_tang', 'ma_tg_ts', 'ngay_bdkh',
        'ngay_gt_cl', 'ngay_dc', 'ld_dc', 'so_ct', 'ngay_ct',
        'st_kh', 'tl_kh', 'tk_ts', 'tk_kh', 'tk_cp',
        'ma_bpsd', 'ma_spct', 'ma_phi',
        'ma_nhts1', 'ma_nhts2', 'ma_nhts3',
        'ng_gia_n1', 'ng_gia_n2', 'ng_gia_n3', 'ng_gia_n4',
        'gt_kh_n1', 'gt_kh_n2', 'gt_kh_n3', 'gt_kh_n4',
        'gt_cl_n1', 'gt_cl_n2', 'gt_cl_n3', 'gt_cl_n4',
        'kh_th_n1', 'kh_th_n2', 'kh_th_n3', 'kh_th_n4',
        'sua_kh', 'stt_rec',
    ];

    protected $casts = [
        'so_luong' => 'decimal:6',
        'tl_kh' => 'decimal:6',
        'sua_kh' => 'boolean',
    ];

    public function linhKiens()
    {
        return $this->hasMany(FADMLK::class, 'ma_ts', 'ma_ts');
    }
}

// app/Models/FA/FADMLK.php
class FADMLK extends Model
{
    protected $table = 'FADMLK';
    protected $primaryKey = ['ma_ts', 'ma_lk'];
    public $incrementing = false;
    protected $connection = 'simba';
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/Taisan.php
class Taisan extends Component
{
    const MA_CT = 'FA';
}

// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/TaisanEdit.php
class TaisanEdit extends Component
{
    public string $pTab = 'ttc';

    // Tab TTC fields
    // Tab TTKH fields (4 nguon von)
    // Tab PT_LK (grid linh kien)
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | FADMTS.php | Chinh |
| Model | laravel-simba | FADMLK.php | Linh kien |
| SP | laravel-simba | AsFAGetDMTS.php | Get |
| SP | laravel-simba | AsFAInsDMTS.php | Insert |
| Component | laravel-catalog | Taisan.php | List |
| Component | laravel-catalog | TaisanEdit.php | Edit (3 tabs) |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Models FADMTS, FADMLK
- [ ] Tao Livewire Taisan (list)
- [ ] Tao Livewire TaisanEdit (3 tabs)
- [ ] Tao Views (3 tabs)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test 4 nguon von & linh kien
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `fa.dict.ts`
- **Note:** Shell/voucher; write blocked until payload audit.
