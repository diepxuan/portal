# Task 286: GLPost2GLKC

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module ket chuyen tu dong tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLPost2GLKC.dll
- **Assembly Title:** Ket chuyen tu dong
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: GLDKCCuoiKy (Ket chuyen cuoi ky)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| id | int | 4 | ID tu tang |
| nam | int | 4 | Nam tai chinh |
| ky | int | 4 | Ky ke toan |
| ngay_ct | datetime | 8 | Ngay chung tu |
| so_ct | varchar | 20 | So chung tu |
| ma_bp | varchar | 20 | Ma bo phan |
| ma_kv | varchar | 20 | Ma khu vuc |
| tk | varchar | 20 | Tai khoan |
| tk_du | varchar | 20 | Tai khoan doi ung |
| ps_no | float | 8 | Phat sinh no |
| ps_co | float | 8 | Phat sinh co |
| trang_thai | int | 4 | Trang thai |

---

## Form classes

### 1. frmGLPost2GLKC (Form xu ly chinh)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Ket chuyen tu dong cuoi ky

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_POST2GLKC_GET | Lay danh sach ket chuyen |
| SP_GL_POST2GLKC_PROCESS | Xu ly ket chuyen tu dong |
| SP_GL_POST2GLKC_INSERT | Them ket chuyen |
| SP_GL_POST2GLKC_UPDATE | Cap nhat ket chuyen |
| SP_GL_POST2GLKC_DELETE | Xoa ket chuyen |

---

## Business Logic

1. **Tu dong:** Tao chung tu ket chuyen dua tren quy tac dinh san
2. **Tai khoan doi ung:** Moi tai khoan co the co nhieu quy tac ket chuyen
3. **Bo phan/Khu vuc:** Ho tro theo bo phan hoac khu vuc
4. **Phat sinh:** Tu dong tao ps_no/ps_co khi xu ly

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/GLPost2GLKC.php
namespace Diepxuan\Simba\Models\GL;

class GLPost2GLKC extends Model
{
    protected $table = 'GLKCCuoiKy';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $connection = 'simba';

    protected $fillable = ['nam', 'ky', 'ngay_ct', 'so_ct', 'ma_bp', 'ma_kv', 'tk', 'tk_du', 'ps_no', 'ps_co', 'trang_thai'];
    protected $casts = ['nam' => 'integer', 'ky' => 'integer', 'ps_no' => 'float', 'ps_co' => 'float', 'trang_thai' => 'integer'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | GLPost2GLKC.php | Chinh |
| Model | laravel-simba | GLDKCCuoiKy.php | Quy tac ket chuyen |
| Model | laravel-simba | DMTK.php | Tai khoan |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model GLPost2GLKC
- [ ] Tao Livewire Components
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (GL route/report shell)
- **Route:** `gl.task.286`
