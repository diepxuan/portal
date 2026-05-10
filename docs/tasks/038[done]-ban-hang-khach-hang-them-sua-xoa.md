# Task 038: SO - CRUD khach hang (them, sua, xoa)

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang CRUD khach hang trong module ban hang tu .NET sang PHP Laravel, dat ket qua tuong duong ARDMKH.

## Chi tiet
- **DLL:** ARDMKH.dll
- **Chuc nang:** Them, sua, xoa khach hang phuc vu ban hang
- **Loai:** Danh muc (DM)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR

## Tai lieu tham khao
- `/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARDMKH.dll/README.md`
- Task 001 (001-ar-danh-muc-khach-hang.md) - da day du

---

## Mo ta bo sung

Day la task CRUD co ban cho khach hang trong nganh SO, su dung chung danh muc voi module AR (Accounts Receivable).

### Khac biet so voi ARDMKH goc

| Khia canh | ARDMKH | SO CRUD KH |
|-----------|--------|------------|
| Pham vi | Toan bo ERP | Chi phuc vu ban hang |
| Truong bo sung | - | Thong tin giao hang, nguoi lien he |
| Lien ket | ARTT (so du) | SO1, SO3 (don hang, hoa don) |

---

## Cau truc du lieu

### Bang: DMKH (Danh muc khach hang)

Xem chi tiet: `001-ar-danh-muc-khach-hang.md`

### Truong bo sung cho SO

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| dia_chi_gh | nvarchar | 500 | Dia chi giao hang |
| nguoi_nhan | nvarchar | 100 | Nguoi nhan hang |
| dt_nguoi_nhan | varchar | 50 | SDT nguoi nhan |
| email_giao_hang | varchar | 100 | Email giao hang |

---

## Business Logic bo sung (cho SO)

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | dia_chi_gh | 'Dia chi giao hang khong duoc trong' |

### Business Rules

1. **Dia chi giao hang mac dinh**: Neu khong nhap, lay dia_chi tu DMKH
2. **Kiem tra no qua han**: Khi tao don hang, kiem tra no qua han cua KH
3. **Chan ban hang**: Neu KH bi chan (trong DMNHKH), khong cho tao don

---

## Mapping PHP

### 1. Model

Su dung chung `app/Models/AR/DMKH.php` (Task 001)

### 2. Livewire bo sung

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Khachhang/SOCreate.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Khachhang;

class SOCreate extends Component
{
    // Them truong giao hang
    public string $pDia_Chi_Gh = '';
    public string $pNguoi_Nhan = '';
    public string $pDt_Nguoi_Nhan = '';
    
    protected $rules = [
        'pDia_Chi_Gh' => 'required|string|max:500',
    ];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKH.php | Dung chung voi AR (Task 001) |
| SP | laravel-simba | AsAR*DMKH.php | Dung chung voi AR |
| Component | laravel-catalog | Khachhang.php | Dung chung voi AR |
| Component | laravel-catalog | SOCreate.php | Rieng cho SO |

---

## Progress Checklist

- [x] Phan tich yeu cau
- [x] Stored Procedures (6 SP classes trong laravel-simba)
- [x] Models (ArDmKh, ArDmNhKh, ArDmPlKh — laravel-simba + laravel-catalog)
- [x] Livewire Components (KhachhangList, KhachhangForm)
- [x] Blade Views (khachhang.blade.php, khachhang-form.blade.php)
- [x] Routes (/banhang/khachhang, create, edit/{id})
- [x] Business Rules (validation, hasTransactions, soft delete)
- [x] Test CRUD co ban
- [x] Merge PR #170 (2026-05-05)

## Trang thai

**HOAN THANH** — 2026-05-05
- PR: https://github.com/diepxuan/portal/pull/170
- Issue: https://github.com/diepxuan/portal/issues/38
- 16 files thay doi: 6 SP classes + 4 Models + 2 Livewire + 2 Views + 1 Routes + 1 Model updated

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
