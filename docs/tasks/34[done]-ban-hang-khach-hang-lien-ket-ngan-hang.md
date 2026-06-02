# Task 034: SO - Lien ket ngan hang cho khach hang

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Bổ sung chuc nang lien ket thong tin ngan hang voi khach hang trong module ban hang.

## Chi tiet
- **Chuc nang:** Quan ly thong tin tai khoan ngan hang cua khach hang
- **Loai:** Danh muc con (Sub-DM)
- **Ma_ct:** SO

## Tai lieu tham khao
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARDMKH.dll/README.md`
- Lien quan: Task 001 (ARDMKH - Danh muc khach hang)

---

## Cau truc du lieu

### Bang: DMKH_NH (Thong tin ngan hang khach hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_kh | varchar | 50 | Ma khach hang (FK -> DMKH) |
| stt | int | 4 | So thu tu |
| ten_nh | nvarchar | 200 | Ten ngan hang |
| so_tk | varchar | 50 | So tai khoan |
| ten_chu_tk | nvarchar | 200 | Ten chu tai khoan |
| chi_nhanh | nvarchar | 200 | Chi nhanh ngan hang |
| mac_dinh | bit | 1 | Tai khoan mac dinh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh -> DMKH.ma_kh |

---

## Form classes

### frmSO_LienKetNganHang
- **Ke thua:** frmDMSubView
- **Chuc nang:** Quan ly danh sach tai khoan ngan hang cua KH
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvNH | DataGridView | Danh sach tai khoan |
| btnAdd | Button | Them tai khoan |
| btnEdit | Button | Sua tai khoan |
| btnDelete | Button | Xoa tai khoan |
| chkMacDinh | CheckBox | Dat lam mac dinh |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMKH_NH_GET | Lay danh sach TK ngan hang cua KH |
| SP_SO_DMKH_NH_GETBYID | Lay chi tiet 1 TK |
| SP_SO_DMKH_NH_INSERT | Them TK moi |
| SP_SO_DMKH_NH_UPDATE | Cap nhat TK |
| SP_SO_DMKH_NH_DELETE | Xoa TK |

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | so_tk | 'So tai khoan khong duoc trong' |
| Required | ten_nh | 'Ten ngan hang khong duoc trong' |
| Unique | ma_kh + so_tk | 'So tai khoan da ton tai cho KH nay' |

### Business Rules

1. **Mot KH co nhieu tai khoan ngan hang**
2. **Chi mot tai khoan mac dinh** - Khi dat mac dinh moi, tu dong bo mac dinh cua TK cu
3. **Hien thi trong voucher** - Tai khoan mac dinh hien thi mac dinh trong form thanh toan

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMKH_NH.php
class DMKH_NH extends Model
{
    protected $table = 'DMKH_NH';
    protected $primaryKey = ['ma_kh', 'stt'];
    public $incrementing = false;
    
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
    
    public function scopeDefault($query)
    {
        return $query->where('mac_dinh', true);
    }
}
```

### 2. Livewire

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Khachhang/Nganhang.php
class Nganhang extends Component
{
    public ?string $pMa_Kh = null;
    public Collection $pTaiKhoans;
    
    public function mount(string $maKh): void
    {
        $this->pMa_Kh = $maKh;
        $this->loadTaiKhoans();
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKH_NH.php | Chinh |
| Model | laravel-simba | DMKH.php | Lien quan |
| SP | laravel-simba | SoGetDMKH_NH.php | Get list |
| Component | laravel-catalog | Nganhang.php | List + Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao Model DMKH_NH
- [ ] Tao SP classes
- [ ] Tao Livewire Nganhang
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD
- [ ] Test lien ket voi voucher SO1/SO3

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.34`
