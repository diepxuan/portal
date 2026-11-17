# Task 037: SO - Lien ket ma thanh toan cho khach hang

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Bổ sung chuc nang lien ket ma thanh toan mac dinh voi khach hang trong module ban hang.

## Chi tiet
- **Chuc nang:** Gan hinh thuc thanh toan mac dinh cho khach hang
- **Loai:** Danh muc con (Sub-DM)
- **Ma_ct:** SO

## Tai lieu tham khao
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO1.dll/README.md`
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SODMHTTT.dll/README.md`

---

## Cau truc du lieu

### Bang: DMKH_TT (Dieu khoan thanh toan cua khach hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_kh | varchar | 50 | Ma khach hang (FK -> DMKH) |
| ma_httt | varchar | 20 | Ma hinh thuc thanh toan (FK -> DMHTTT) |
| ma_dktt | varchar | 20 | Ma dieu khoan thanh toan (FK -> DMDKTT) |
| mac_dinh | bit | 1 | Mac dinh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh -> DMKH.ma_kh |
| DMHTTT | Danh muc HTTT | FK ma_httt -> DMHTTT.ma_httt |
| DMDKTT | Danh muc DKTT | FK ma_dktt -> DMDKTT.ma_dktt |

---

## Form classes

### frmSO_LienKetMaThanhToan
- **Ke thua:** frmDMSubView
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvTT | DataGridView | Danh sach DKTT |
| txtMa_Httt | AsTextBox | Ma HTTT (lookup) |
| txtMa_Dktt | AsTextBox | Ma DKTT (lookup) |
| chkMacDinh | CheckBox | Mac dinh |
| btnAdd | Button | Them |
| btnDelete | Button | Xoa |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMKH_TT_GET | Lay danh sach DKTT cua KH |
| SP_SO_DMKH_TT_INSERT | Gan DKTT cho KH |
| SP_SO_DMKH_TT_DELETE | Bo DKTT cua KH |

---

## Business Logic

### Business Rules

1. **Tu dong dien vao voucher**: Khi chon KH, tu dong dien ma_httt va ma_dktt mac dinh
2. **Nhieu DKTT**: KH co the co nhieu dieu khoan thanh toan
3. **Overridable**: Co the thay doi trong voucher

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMKH_TT.php
class DMKH_TT extends Model
{
    protected $table = 'DMKH_TT';
    protected $primaryKey = ['ma_kh', 'ma_httt'];
    public $incrementing = false;
    
    public function hinhThucTT()
    {
        return $this->belongsTo(DMHTTT::class, 'ma_httt', 'ma_httt');
    }
    
    public function scopeDefault($query)
    {
        return $query->where('mac_dinh', true);
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKH_TT.php | Chinh |
| Model | laravel-simba | DMHTTT.php | Lien quan |
| Model | laravel-simba | DMDKTT.php | Lien quan |
| SP | laravel-simba | SoGetDMKH_TT.php | Get list |
| Component | laravel-catalog | Lienketthanhtoan.php | List + Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao Model DMKH_TT
- [ ] Tao SP classes
- [ ] Tao Livewire
- [ ] Tao Views + Routes
- [ ] Test CRUD

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.37`
