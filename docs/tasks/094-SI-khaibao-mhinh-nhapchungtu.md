# Task 094: SIDMCT

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang khai bao man hinh nhap chung tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIDMCT.dll
- **Chuc nang:** Khai bao man hinh nhap chung tu
- **Loai:** Danh muc (DM)
- **Assembly Title:** Khai bao man hinh nhap chung tu
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** SIDMCT

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIDMCT.dll/README.md`

---

## Cau truc du lieu

### Bang: Voucher (Danh muc chung tu)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_ct | varchar | Ma chung tu (khoa chinh) |
| ten_ct | nvarchar | Ten chung tu |
| ma_ct_me | varchar | Ma chung tu me |
| phan_he | varchar | Phan he |
| tk_no | varchar | TK no mac dinh |
| tk_co | varchar | TK co mac dinh |
| ma_nt | varchar | Ma ngoai te |
| vn_prefix | varchar | Phan dau so CT |
| vn_sequence | int | Phan tu tang |
| vn_postfix | varchar | Phan cuoi so CT |
| vn_pattern | varchar | Ky tu mau |
| vn_width | int | Do rong so CT |
| so_lien | int | So lien in |
| stt_nkc | int | STT nhat ky chung |
| stt_ntxt | int | STT nhap truoc xuat truoc |
| loc_nsd | bit | Loc theo nguoi su dung |
| vv | bit | Su dung ma hop dong |
| phi | bit | Su dung ma phi |
| bp | bit | Su dung ma bo phan |
| spct | bit | Su dung ma SPCT |
| lo | bit | Su dung ma lo |
| trung_so_ct | int | Kiem tra trung so CT (0/1/2) |

---

## Form classes

### 1. frmSIDMCT (Form xem danh sach)
- **Ke thua:** frmDMView

### 2. frmSIDMCTEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_ct | AsTextBox | ma_ct | Ma chung tu |
| txtTen_ct | TextBox | ten_ct | Ten chung tu |
| txtMa_ct_me | AsTextBox | ma_ct_me | Ma CT me |
| cboPhan_he | ComboBox | phan_he | Phan he |
| txtTk_no | AsTextBox | tk_no | TK no |
| txtTk_co | AsTextBox | tk_co | TK co |
| cboMa_nt | ComboBox | ma_nt | Ma ngoai te |
| txtVn_prefix | TextBox | vn_prefix | Prefix |
| txtVn_sequence | AsTextNumeric | vn_sequence | Sequence |
| txtVn_postfix | TextBox | vn_postfix | Postfix |
| txtVn_width | AsTextNumeric | vn_width | Do rong |
| txtSo_lien | AsTextNumeric | so_lien | So lien |
| txtStt_nkc | AsTextNumeric | stt_nkc | STT NKC |
| chkLoc_nsd | CheckBox | loc_nsd | Loc NSD |
| chkUse_ma_hd | CheckBox | vv | Su dung HD |
| chkUse_ma_phi | CheckBox | phi | Su dung phi |
| chkUse_ma_bp | CheckBox | bp | Su dung BP |
| chkUse_ma_spct | CheckBox | spct | Su dung SPCT |
| chkUse_ma_lo | CheckBox | lo | Su dung lo |
| cboTrung_so_ct | ComboBox | trung_so_ct | Trung so CT |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_VOUCHER_GET | Lay danh sach |
| SP_SI_VOUCHER_GETBYID | Lay chi tiet |
| SP_SI_VOUCHER_INSERT | Them moi |
| SP_SI_VOUCHER_UPDATE | Cap nhat |
| SP_SI_VOUCHER_DELETE | Xoa |
| SP_SI_VOUCHER_FIND | Tim kiem |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ct | 'Ma chung tu khong duoc trong' |
| Unique | ma_ct | 'Ma da ton tai' |
| Required | ten_ct | 'Ten chung tu khong duoc trong' |
| Valid TK | tk_no/tk_co | 'Tai khoan khong ton tai' |

### Business Rules

1. **So chung tu tu dong**:
   - Format: prefix + sequence (padded) + postfix
   - Vi du: CT-{YYYY}{MM}-0001

2. **Kiem tra trung**:
   - 0: Cho phep trung
   - 1: Theo thang
   - 2: Theo nam

3. **Cac truong tuy chon**:
   - Ma hop dong
   - Ma phi
   - Ma bo phan
   - Ma SPCT
   - Ma lo

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/Voucher.php
namespace Diepxuan\Simba\Models\SI;

class Voucher extends Model
{
    protected $table = 'Voucher';
    protected $primaryKey = 'ma_ct';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_ct',
        'ten_ct',
        'ma_ct_me',
        'phan_he',
        'tk_no',
        'tk_co',
        'ma_nt',
        'vn_prefix',
        'vn_sequence',
        'vn_postfix',
        'vn_pattern',
        'vn_width',
        'so_lien',
        'stt_nkc',
        'stt_ntxt',
        'loc_nsd',
        'vv',
        'phi',
        'bp',
        'spct',
        'lo',
        'trung_so_ct',
    ];

    protected $casts = [
        'vn_sequence' => 'integer',
        'vn_width' => 'integer',
        'so_lien' => 'integer',
        'stt_nkc' => 'integer',
        'stt_ntxt' => 'integer',
        'loc_nsd' => 'boolean',
        'vv' => 'boolean',
        'phi' => 'boolean',
        'bp' => 'boolean',
        'spct' => 'boolean',
        'lo' => 'boolean',
        'trung_so_ct' => 'integer',
    ];

    public function scopeByModule($query, string $phan_he)
    {
        return $query->where('phan_he', $phan_he);
    }

    public function generateSoCt(): string
    {
        // Sinh so chung tu
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Danhmuc/Chungtu.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Danhmuc;

class Chungtu extends Component
{
    const MA_CT = 'SIDMCT';

    public Collection $pDanhSach;

    public function render(): View
    {
        return view('catalog::si.danhmuc.chungtu');
    }
}
```

### 3. Views

```
resources/views/catalog/si/danhmuc/
├── chungtu.blade.php
├── chungtu-edit.blade.php
└── _chungtu-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/danhmuc')
    ->name('catalog.si.danhmuc.')
    ->group(function () {
        Route::get('/chung-tu', [Chungtu::class, 'render'])
            ->name('chungtu');
        Route::get('/chung-tu/edit/{ma_ct?}', [ChungtuEdit::class, 'render'])
            ->name('chungtu.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | Voucher.php | Chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model Voucher
- [ ] Tao Livewire Chungtu
- [ ] Tao Livewire ChungtuEdit
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test sinh so CT tu dong
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
