# Task 036: SO - Lien ket danh muc tai khoan cho khach hang

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Bổ sung chuc nang lien ket khach hang voi cac tai khoan ke toan trong module ban hang.

## Chi tiet
- **Chuc nang:** Gan tai khoan ke toan (pha thu, doanh thu, ...) cho khach hang
- **Loai:** Danh muc con (Sub-DM)
- **Ma_ct:** SO

## Tai lieu tham khao
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO1.dll/README.md`
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOVchSO3.dll/README.md`

---

## Cau truc du lieu

### Bang: DMKH_TK (Tai khoan ke toan cua khach hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_kh | varchar | 50 | Ma khach hang (FK -> DMKH) |
| loai_tk | varchar | 20 | Loai TK (PT=Phai thu, DT=Doanh thu, ...) |
| tk | varchar | 20 | Ma tai khoan |
| ten_tk | nvarchar | 200 | Ten tai khoan |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh -> DMKH.ma_kh |
| DSTK | Danh sach tai khoan | FK tk -> DSTK.tk |

---

## Form classes

### frmSO_LienKetTaiKhoan
- **Ke thua:** frmDMSubView
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvTK | DataGridView | Danh sach TK |
| cboLoai_TK | ComboBox | Loai TK |
| txtTk | AsTextBox | Ma TK (lookup DSTK) |
| btnAdd | Button | Them |
| btnDelete | Button | Xoa |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMKH_TK_GET | Lay danh sach TK cua KH |
| SP_SO_DMKH_TK_INSERT | Gan TK cho KH |
| SP_SO_DMKH_TK_DELETE | Bo TK cua KH |

---

## Business Logic

### Business Rules

1. **TK phai thu (PT)**: Tu dong dien vao voucher SO1/SO3 khi chon KH
2. **TK doanh thu (DT)**: Ap dung cho tung dong hang
3. **TK co mac dinh**: Neu KH khong co TK rieng, lay theo cau hinh chung

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMKH_TK.php
class DMKH_TK extends Model
{
    protected $table = 'DMKH_TK';
    protected $primaryKey = ['ma_kh', 'loai_tk'];
    public $incrementing = false;
    
    public function taiKhoan()
    {
        return $this->belongsTo(DSTK::class, 'tk', 'tk');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKH_TK.php | Chinh |
| Model | laravel-simba | DSTK.php | Lien quan |
| SP | laravel-simba | SoGetDMKH_TK.php | Get list |
| Component | laravel-catalog | LienkettaiKhoan.php | List + Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao Model DMKH_TK
- [ ] Tao SP classes
- [ ] Tao Livewire
- [ ] Tao Views + Routes
- [ ] Test CRUD

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
