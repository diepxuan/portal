# Task 035: SO - Lien ket nhom phan loai cho khach hang

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Bổ sung chuc nang lien ket khach hang voi cac nhom phan loai trong module ban hang.

## Chi tiet
- **Chuc nang:** Quan ly viec gan khach hang vao cac nhom phan loai
- **Loai:** Danh muc con (Sub-DM)
- **Ma_ct:** SO

## Tai lieu tham khao
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARDMKH.dll/README.md`
- Lien quan: Task 001 (ARDMKH), Task 043 (SOND51dmqdadhd)

---

## Cau truc du lieu

### Bang: DMKH_PL (Phan loai khach hang)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_kh | varchar | 50 | Ma khach hang (FK -> DMKH) |
| ma_plkh | varchar | 50 | Ma phan loai KH |
| loai_pl | int | 4 | Loai phan loai (1, 2, 3) |
| ngay_ap_dung | datetime | 8 | Ngay ap dung |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh -> DMKH.ma_kh |
| DMPLKH | Danh muc phan loai KH | FK ma_plkh -> DMPLKH.ma_plkh |

---

## Form classes

### frmSO_LienKetNhomPhanLoai
- **Ke thua:** frmDMSubView
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvPL | DataGridView | Danh sach phan loai |
| cboLoai_PL | ComboBox | Chon loai phan loai (1, 2, 3) |
| txtMa_PlKh | AsTextBox | Ma phan loai (lookup) |
| btnAdd | Button | Them |
| btnDelete | Button | Xoa |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMKH_PL_GET | Lay danh sach phan loai cua KH |
| SP_SO_DMKH_PL_INSERT | Gan phan loai cho KH |
| SP_SO_DMKH_PL_DELETE | Bo phan loai cua KH |

---

## Business Logic

### Business Rules

1. **KH co the thuoc nhieu nhom phan loai**
2. **3 cap phan loai**: Loai 1, Loai 2, Loai 3 (theo cau hinh)
3. **Ap dung cho bao cao**: Loc bao cao theo phan loai KH
4. **Ap dung cho gia ban**: Gia ban co the khac nhau theo nhom phan loai

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMKH_PL.php
class DMKH_PL extends Model
{
    protected $table = 'DMKH_PL';
    protected $primaryKey = ['ma_kh', 'ma_plkh'];
    public $incrementing = false;
    
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
    
    public function phanLoai()
    {
        return $this->belongsTo(DMPLKH::class, 'ma_plkh', 'ma_plkh');
    }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKH.php | Chung voi AR |
| SP | laravel-simba | SoGetDMKH_PL.php | Get list |
| Component | laravel-catalog | Nhomphanloai.php | List + Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau
- [ ] Tao Model DMKH_PL
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
- **Route:** `task.35`
