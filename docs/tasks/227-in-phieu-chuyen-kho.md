# Task 227: INVchIN3

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang phieu chuyen kho tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INVchIN3.dll
- **Chuc nang:** Phieu chuyen kho
- **Loai:** Chung tu (Voucher)
- **Assembly Title:** Phieu chuyen kho
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN3 (Phieu chuyen kho)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INVchIN3.dll/README.md`

---

## Cau truc du lieu

### Bang: INCHIENCK (Phieu chuyen kho - Header)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| so_ct | varchar | 50 | So chung tu |
| ngay_ct | datetime | 8 | Ngay chung tu |
| ma_kh | varchar | 50 | Ma khach hang/nha cung cap |
| ten_kh | nvarchar | 200 | Ten KH/NCC |
| dia_chi | nvarchar | 500 | Dia chi |
| nguoi_gd | nvarchar | 200 | Nguoi giao dich |
| dien_giai | nvarchar | 500 | Dien giai |
| ma_nt | varchar | 10 | Ma ngoai te |
| ty_gia | decimal | 18,6 | Ty gia |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| tien | decimal | 18,2 | Tien VND |
| ma_gd | varchar | 50 | Ma giao dich |
| so_pn | varchar | 50 | So phieu nhap (lien ket) |
| stt_rec | varchar | 50 | STT record |

### Bang: INCTCK (Chi tiet chuyen kho)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| stt_rec | varchar | 50 | STT header |
| stt_rec0 | varchar | 50 | STT detail |
| ma_vt | varchar | 50 | Ma vat tu |
| ten_vt | nvarchar | 200 | Ten vat tu |
| dvt | varchar | 20 | Don vi tinh |
| ma_khox | varchar | 50 | Ma kho xuat |
| ma_khon | varchar | 50 | Ma kho nhap |
| so_luong | decimal | 18,6 | So luong chuyen |
| gia_nt | decimal | 18,6 | Gia ngoai te |
| tien_nt | decimal | 18,2 | Tien ngoai te |
| gia | decimal | 18,2 | Gia VND |
| tien | decimal | 18,2 | Tien VND |
| tk_no | varchar | 20 | TK noi |
| tk_vt | varchar | 20 | TK co (vat tu) |
| ma_bp | varchar | 50 | Ma bo phan |
| ma_spct | varchar | 50 | Ma san pham chi tiet |
| ma_phi | varchar | 50 | Ma phi |
| ma_hd | varchar | 50 | Ma hop dong |
| ma_lo | varchar | 50 | Ma lo |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMVT | Danh muc vat tu | FK ma_vt |
| DMKHO | Danh muc kho | FK ma_khox, ma_khon |
| INPHIEUN | Phieu nhap | FK so_pn (tu dong tao) |

---

## Form classes

### 1. frmInVchIN3 (Form nhap lieu chinh)
- **Ke thua:** frmVoucher
- **Chuc nang:** Nhap phieu chuyen kho
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_Ct | TextBox | so_ct | So chung tu |
| txtNgay_Ct | DateTimePicker | ngay_ct | Ngay chung tu |
| txtSo_Pn | TextBox | so_pn | So phieu nhap (auto) |
| txtMa_Kh | AsTextBox | ma_kh | Ma khach hang |
| txtDien_Giai | TextBox | dien_giai | Dien giai |
| cboMa_Nt | ComboBox | ma_nt | Ma ngoai te |
| txtTy_Gia | NumericTextBox | ty_gia | Ty gia |
| txtTien | NumericTextBox | tien | Tien VND |
| dgvDetails | DataGridView | - | Luoi chi tiet |

### 2. frmInVchIN3Find (Form tim kiem)

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_VCHIN3_GET | Lay danh sach phieu chuyen kho |
| SP_IN_VCHIN3_GETBYID | Lay chi tiet 1 phieu |
| SP_IN_VCHIN3_INSERT | Them phieu chuyen kho |
| SP_IN_VCHIN3_UPDATE | Cap nhat phieu chuyen kho |
| SP_IN_VCHIN3_DELETE | Xoa phieu chuyen kho |
| SP_IN_VCHIN3_FIND | Tim kiem phieu chuyen kho |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | so_ct | 'So chung tu khong duoc trong' |
| Required | ma_khox | 'Ma kho xuat khong duoc trong' |
| Required | ma_khon | 'Ma kho nhap khong duoc trong' |

### Business Rules

1. **Tu dong tao phieu nhap**:
   - Khi luu phieu xuat, tu dong tao phieu nhap lien ket
   - So_Pn = so_phieu_nhap_tuong_ung

2. **Kiem tra ton kho**:
   - Kiem tra ton kho tai kho xuat
   - Khong cho xuat vuot ton kho

3. **Gia tri chuyen kho**:
   - Gia tri khong thay doi (gia von)
   - Khong tinh lai loi/nhuan

4. **Kho xuat != Kho nhap**:
   - Kiem tra ma_khox != ma_khon

---

## Mapping PHP

### 1. Models

```php
// app/Models/IN/INCHIENCK.php
namespace Diepxuan\Simba\Models\IN;

class INCHIENCK extends Model
{
    protected $table = 'INCHIENCK';
    protected $primaryKey = 'stt_rec';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    public function chiTiets()
    {
        return $this->hasMany(INCTCK::class, 'stt_rec', 'stt_rec');
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Chungtu/Chuyenkho.php
class Chuyenkho extends Component
{
    const MA_CT = 'IN3';
    // ...
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | INCHIENCK.php | Header |
| Model | laravel-simba | INCTCK.php | Detail |
| SP | laravel-simba | AsINGetChuyenKho.php | Get |
| SP | laravel-simba | AsINInsChuyenKho.php | Insert |
| Component | laravel-catalog | Chuyenkho.php | List/Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Models INCHIENCK, INCTCK
- [ ] Tao Livewire Chuyenkho (list + edit)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test auto create phieu nhap