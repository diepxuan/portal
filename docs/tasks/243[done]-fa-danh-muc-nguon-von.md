# Task 243: FADMNV

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang danh muc nguon von tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADMNV.dll
- **Chuc nang:** Quan ly danh muc nguon von (chi sua, khong them/xoa)
- **Loai:** Danh muc (DM)
- **Assembly Title:** Danh muc nguon von
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** FA (Danh muc)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADMNV.dll/README.md`

---

## Cau truc du lieu

### Bang: DMNV (Danh muc nguon von)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_nv | varchar | 50 | Ma nguon von (khoa chinh) |
| ten_nv | nvarchar | 200 | Ten nguon von |
| ksd | bit | 1 | Khoa su dung (0: hoat dong, 1: khoa) |

---

## Form classes

### 1. frmFADMNV (Form xem danh sach - han che)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach nguon von
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | AsDataGridView | Luoi hien thi |
| cmdAdd | Button | **An (khong cho them)** |
| cmdEdit | Button | Sua |
| cmdDel | Button | **An (khong cho xoa)** |
| cmdChgCode | Button | **An (khong cho doi ma)** |
| cmdSearch | Button | Tim kiem |
| cmdPrint | Button | In |
| cmdClose | Button | Dong |
| cboFilter | ComboBox | Loc |
| txtValue | TextBox | Gia tri tim kiem |

### 2. frmFADMNVEdit (Form sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Nv | TextBox | ma_nv | Ma nguon von (disabled when edit) |
| txtTen_Nv | TextBox | ten_nv | Ten nguon von |
| chkKsd | CheckBox | ksd | Khoa su dung |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_DMNV_GET | Lay danh sach nguon von |
| SP_FA_DMNV_GETBYID | Lay chi tiet 1 nguon von |
| SP_FA_DMNV_UPDATE | Cap nhat nguon von |
| SP_FA_DMNV_FIND | Tim kiem nguon von |

---

## Business Logic

### Business Rules

1. **Han che thao tac**:
   - cmdAdd.Visible = false: Khong cho phep them
   - cmdDel.Visible = false: Khong cho phep xoa
   - cmdChgCode.Visible = false: Khong cho phep doi ma
   - Chi cho phep sua thong tin (ten, ksd)

2. **Ma nguon von**:
   - Khong cho phep sua
   - Khong cho phep tao moi
   - Khong cho phep xoa

3. **Danh muc he thong**:
   - Danh muc co dinh
   - Chi cho phep chinh sua thong tin mo ta

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/DMNV.php
namespace Diepxuan\Simba\Models\FA;

class DMNV extends Model
{
    protected $table = 'DMNV';
    protected $primaryKey = 'ma_nv';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_nv', 'ten_nv', 'ksd',
    ];

    protected $casts = [
        'ksd' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/Nguonvon.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Danhmuc;

class Nguonvon extends Component
{
    const MA_CT = 'FA';

    public Collection $pNguonVons;
    public string $pSearch = '';
    public ?string $pEditingMaNv = null;

    // Chu y: Khong co chuc nang them/xoa/doi ma

    public function render(): View
    {
        return view('catalog::fa.danhmuc.nguonvon');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/NguonvonEdit.php
class NguonvonEdit extends Component
{
    public ?string $pMa_Nv = null;
    public string $pTen_Nv = '';
    public bool $pKsd = false;
    public ?string $pMode = 'edit'; // Chi co edit mode

    // Khong co insert - chi sua
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMNV.php | Chinh |
| SP | laravel-simba | AsFAGetDMNV.php | Get |
| SP | laravel-simba | AsFAUpdDMNV.php | Update |
| Component | laravel-catalog | Nguonvon.php | List (restricted) |
| Component | laravel-catalog | NguonvonEdit.php | Edit only |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMNV
- [ ] Tao Livewire Nguonvon (list - restricted)
- [ ] Tao Livewire NguonvonEdit (edit only)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test restricted CRUD (edit only)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
