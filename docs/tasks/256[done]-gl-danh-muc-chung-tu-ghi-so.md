# Task 256: GLDMCTGS

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module danh muc chung tu ghi so (CTGS) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLDMCTGS.dll
- **Assembly Title:** GLDMCTGS
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: DMCTGS (Danh muc chung tu ghi so)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_ct | varchar | 10 | Ma chung tu (khoa chinh) |
| ten_ct | nvarchar | 200 | Ten chung tu |
| tk | varchar | 20 | Tai khoan mac dinh |
| so_hieu | varchar | 50 | So hieu chung tu |
| ksd | bit | 1 | Khoa su dung |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk -> DMTK.tk |

---

## Form classes

### 1. frmGLDMCTGS (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach chung tu ghi so
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi |
| txtSearch | TextBox | Tim kiem |

### 2. frmGLDMCTGSEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin chung tu ghi so
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Ct | AsTextBox | ma_ct | Ma chung tu |
| txtTen_Ct | TextBox | ten_ct | Ten chung tu |
| txtTk | AsTextBox | tk | Tai khoan (lookup TK) |
| txtSo_Hieu | TextBox | so_hieu | So hieu chung tu |
| chkKsd | AsCheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_DMCTGS_GET | Lay danh sach chung tu ghi so |
| SP_GL_DMCTGS_GETBYID | Lay chi tiet 1 chung tu |
| SP_GL_DMCTGS_INSERT | Them chung tu ghi so |
| SP_GL_DMCTGS_UPDATE | Cap nhat chung tu ghi so |
| SP_GL_DMCTGS_DELETE | Xoa chung tu ghi so |
| SP_GL_DMCTGS_FIND | Tim kiem chung tu ghi so |
| SP_GL_DMCTGS_CHECK | Kiem tra trung ma |

### SP_INSERT (reference)

```sql
EXEC SP_GL_DMCTGS_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_ct VARCHAR(10),
    @pTen_ct NVARCHAR(200),
    @pTk VARCHAR(20),
    @pSo_hieu VARCHAR(50),
    @pKsd BIT = 0,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_ct | 'Ma chung tu khong duoc trong' |
| Max length 10 | ma_ct | 'Ma chung tu toi da 10 ky tu' |
| Unique | ma_ct | 'Ma chung tu da ton tai' |
| Required | ten_ct | 'Ten chung tu khong duoc trong' |
| Max length 200 | ten_ct | 'Ten chung tu toi da 200 ky tu' |

### Business Rules

1. **Ma chung tu:**
   - Khong cho phep sua sau khi tao
   - Khong cho phep xoa neu co chung tu su dung

2. **Tai khoan mac dinh:**
   - Lookup tu bang DMTK
   - Hien thi ten tai khoan

3. **Khoa su dung:**
   - Mac dinh = 0 (hoat dong)
   - Khi ksd = 1, chung tu khong hien thi trong danh sach chon

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/DMCTGS.php
namespace Diepxuan\Simba\Models\GL;

class DMCTGS extends Model
{
    protected $table = 'DMCTGS';
    protected $primaryKey = 'ma_ct';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_ct', 'ten_ct', 'tk', 'so_hieu', 'ksd'];
    protected $casts = ['ksd' => 'boolean'];

    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'tk', 'tk');
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Danhmuc/Chungtughiso.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Danhmuc;

class Chungtughiso extends Component
{
    const MA_CT = 'GL';

    public Collection $pDanhMuc;
    public string $pSearch = '';
}
```

### 3. Views

```
resources/views/catalog/gl/danhmuc/
├── chungtughiso.blade.php
└── chungtughiso-edit.blade.php
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMCTGS.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |
| Component | laravel-catalog | GL/Danhmuc/Chungtughiso.php | List |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMCTGS
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
- **Route:** `gl.task.256`
