# Task 285: GLPost2DGTG

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module danh gia ty gia cuoi ky tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLPost2DGTG.dll
- **Assembly Title:** Danh gia ty gia cuoi ky
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: Danh gia ty gia cuoi ky (Khong co bang SQL)

Module xu ly danh gia ty gia cuoi ky, khong luu tru bang SQL.
Du lieu nguon tu: GLChungTu, DMNgoaiTe

---

## Form classes

### 1. frmGLPost2DGTG (Form xu ly chinh)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Danh gia ty gia cuoi ky cho cac tai khoan co ngoai te

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_POST2DGTG_GET | Lay danh sach ty gia cuoi ky |
| SP_GL_POST2DGTG_PROCESS | Xu ly danh gia ty gia |

---

## Business Logic

1. **Quy trinh:** Xu ly cuoi ky danh gia lai ty gia cho cac tai khoan ngoai te
2. **Dieu kien:** Chi xu ly voi tai khoan co chi_tiet=1 va co ngoai te
3. **Ty gia cuoi ky:** Lay tu ngan hang hoac nhap tay
4. **Phat sinh:** Tao chung tu dinh khoan loi chenh lech ty gia

---

## Mapping PHP

### 1. Service Class

```php
// diepxuan/laravel-simba/src/Services/GL/Post2DGTGService.php
namespace Diepxuan\Simba\Services\GL;

class Post2DGTGService
{
    public function process(string $ngay_ct, array $ty_gia_custom = []): array;
    public function getExchangeRates(string $date): Collection;
    public function calculateDifference(string $tk, float $ty_gia_cu, float $ty_gia_moi): float;
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | Post2DGTGService.php | Chinh |
| Model | laravel-simba | GLChungTu.php | Chung tu |
| Model | laravel-simba | DMNgoaiTe.php | Ngoai te |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Service class
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
