# Task 238: FAChuyenTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang chuyen tai san tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FAChuyenTS.dll
- **Chuc nang:** Chuyen tai san (bo phan, SPCT, phi, tai khoan)
- **Loai:** Chung tu (Voucher)
- **Assembly Title:** FADMTSCD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (Voucher)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FAChuyenTS.dll/README.md`

---

## Cau truc du lieu

### Bang: FACHUYENTS (Chuyen tai san)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | STT record |
| ma_ts | varchar | 50 | Ma tai san |
| ngay | datetime | 8 | Ngay chuyen |
| loai_dt | varchar | 50 | Loai doi tuong chuyen |
| ma_bpsd | varchar | 50 | Ma bo phan su dung (MA_BPSD) |
| ma_spct | varchar | 50 | Ma san pham CT (MA_SPCT) |
| ma_phi | varchar | 50 | Ma phi (MA_PHI) |
| tk_ts | varchar | 20 | TK tai san |
| tk_kh | varchar | 20 | TK khau hao |
| tk_cp | varchar | 20 | TK chi phi |
| dien_giai | nvarchar | 500 | Dien giai |

### Loai chuyen (ComboBox)

| Gia tri | Mo ta |
|---------|-------|
| MA_BPSD | Chuyen bo phan su dung |
| MA_SPCT | Chuyen san pham CT |
| MA_PHI | Chuyen ma phi |
| TK_TS | Chuyen TK tai san |
| TK_KH | Chuyen TK khau hao |
| TK_CP | Chuyen TK chi phi |

---

## Form classes

### 1. frmFAChuyenTS (Form xem danh sach)
- **Ke thua:** frmDMComplexView
- **Chuc nang:** Hien thi danh sach chuyen TS

### 2. frmFAChuyenTSEdit (Form nhap lieu)
- **Ke thua:** frmDMComplexEdit
- **Chuc nang:** Nhap/chinh sua chuyen TS
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Ts | AsTextBox | ma_ts | Ma tai san |
| txtNgay | DateTimePicker | ngay | Ngay chuyen |
| cboLoai_Dt | ComboBox | loai_dt | Loai chuyen |
| txtMa_Bpsd | AsTextBox | ma_bpsd | Ma BPSD |
| txtMa_Spct | AsTextBox | ma_spct | Ma SPCT |
| txtMa_Phi | AsTextBox | ma_phi | Ma phi |
| txtTk_Ts | AsTextBox | tk_ts | TK tai san |
| txtTk_Kh | AsTextBox | tk_kh | TK khau hao |
| txtTk_Cp | AsTextBox | tk_cp | TK chi phi |
| txtDien_Giai | TextBox | dien_giai | Dien giai |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_CHUYENTS_GET | Lay danh sach chuyen TS |
| SP_FA_CHUYENTS_GETBYID | Lay chi tiet 1 chuyen TS |
| SP_FA_CHUYENTS_INSERT | Them chuyen TS |
| SP_FA_CHUYENTS_UPDATE | Cap nhat chuyen TS |
| SP_FA_CHUYENTS_DELETE | Xoa chuyen TS |
| SP_FA_CHUYENTS_FIND | Tim kiem chuyen TS |

---

## Business Logic

### Business Rules

1. **6 loai chuyen**:
   - MA_BPSD: Chuyen bo phan su dung
   - MA_SPCT: Chuyen san pham CT
   - MA_PHI: Chuyen ma phi
   - TK_TS: Chuyen TK tai san
   - TK_KH: Chuyen TK khau hao
   - TK_CP: Chuyen TK chi phi

2. **Dynamic fields**:
   - Enable/disable fields theo loai chuyen
   - Chi cho phep nhap truong tuong ung

3. **Validation**:
   - Ngay chuyen >= ngay tang TS
   - Ngay chuyen <= ngay khoa so

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/FACHUYENTS.php
namespace Diepxuan\Simba\Models\FA;

class FACHUYENTS extends Model
{
    protected $table = 'FACHUYENTS';
    protected $primaryKey = 'stt_rec';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'stt_rec', 'ma_ts', 'ngay', 'loai_dt',
        'ma_bpsd', 'ma_spct', 'ma_phi',
        'tk_ts', 'tk_kh', 'tk_cp', 'dien_giai',
    ];

    public function taiSan()
    {
        return $this->belongsTo(FADMTS::class, 'ma_ts', 'ma_ts');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Chungtu/ChuyenTaisan.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Chungtu;

class ChuyenTaisan extends Component
{
    const MA_CT = 'FA';

    public Collection $pChuyenTsList;
    public string $pMa_Ts = '';
    // ...
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | FACHUYENTS.php | Chinh |
| SP | laravel-simba | AsFAGetChuyenTS.php | Get |
| SP | laravel-simba | AsFAInsChuyenTS.php | Insert |
| Component | laravel-catalog | ChuyenTaisan.php | List/Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model FACHUYENTS
- [ ] Tao Livewire ChuyenTaisan (list + edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test 6 loai chuyen