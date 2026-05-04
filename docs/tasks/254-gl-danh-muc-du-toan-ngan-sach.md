# Task 254: GLBudget

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module quan ly du toan ngan sach tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLBudget.dll
- **Assembly Title:** GLBudget
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** -
- **Ma_ct:** GL

## Cau truc du lieu

### Bang: GLBudget (Bang du toan ngan sach)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| tk | varchar | 20 | Tai khoan |
| tk_du | varchar | 20 | Tai khoan doi ung |
| ma_bp | varchar | 50 | Ma bo phan |
| ma_phi | varchar | 50 | Ma phi |
| ma_spct | varchar | 50 | Ma san pham chi tiet |
| t1-t12 | decimal | - | Gia tri du toan thang 1-12 |
| ps_no | decimal | - | Phat sinh noi |
| ps_co | decimal | - | Phat sinh co |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk -> DMTK.tk |
| DMBP | Danh muc bo phan | FK ma_bp -> DMBP.ma_bp |
| DMPhi | Danh muc phi | FK ma_phi -> DMPhi.ma_phi |
| DMSPCT | Danh muc SPCT | FK ma_spct -> DMSPCT.ma_spct |

---

## Form classes

### 1. frmGLBudget (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach du toan ngan sach
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDanhMuc | DataGridView | Luoi hien thi |
| txtSearch | TextBox | Tim kiem |

### 2. frmGLBudgetEdit (Form nhap lieu)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap du toan ngan sach 12 thang
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTk | AsTextBox | tk | Tai khoan (lookup TK) |
| txtTk_Du | AsTextBox | tk_du | Tai khoan doi ung |
| txtMa_Bp | AsTextBox | ma_bp | Ma bo phan |
| txtMa_Phi | AsTextBox | ma_phi | Ma phi |
| txtMa_Spct | AsTextBox | ma_spct | Ma SPCT |
| txtT1 - txtT12 | AsTextNumeric | t1 - t12 | Gia tri thang 1-12 |
| txtPs_No | AsTextNumeric | ps_no | Phat sinh noi |
| txtPs_Co | AsTextNumeric | ps_co | Phat sinh co |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asGLGetBudget | Lay danh sach du toan |
| asGLGetSample0Budget | Lay so lieu mau thang 0 |
| asGLGetSample1Budget | Lay so lieu mau chi tiet |
| asGetSttRec | Lay so thu tu ghi so |

### asGLGetBudget (reference)

```sql
EXEC asGLGetBudget
    @pMa_cty VARCHAR(50) = '001',
    @pTk VARCHAR(20) = NULL,
    @pMa_bp VARCHAR(50) = NULL,
    @pMa_phi VARCHAR(50) = NULL,
    @pMa_spct VARCHAR(50) = NULL,
    @pNam INT = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | tk | 'Tai khoan khong duoc trong' |
| Lookup valid | tk | 'Tai khoan khong ton tai' |

### Business Rules

1. **Du toan 12 thang:**
   - Nhap gia tri cho tung thang (t1-t12)
   - Ho tro nhieu phuong phap dieu chinh: gia tri co dinh, phan chia deu, luy ke theo %, sao nguyen so lieu mau

2. **Tai khoan doi ung:**
   - TK duoc chon phai la tai khoan chi tiet (chi_tiet = 1)
   - Khong bat buoc nhap

3. **Phan tich chi phi:**
   - Ma bo phan (ma_bp)
   - Ma phi (ma_phi)
   - Ma san pham chi tiet (ma_spct)

4. **Phat sinh noi/co:**
   - Tu dong tinh tong phat sinh nợ/có tu 12 thang
   - Ho tro hien thi theo ngay/thang

---

## Mapping PHP

### 1. Model

```php
// diepxuan/laravel-simba/src/Models/GL/GLBudget.php
namespace Diepxuan\Simba\Models\GL;

class GLBudget extends Model
{
    protected $table = 'GLBudget';
    protected $primaryKey = ['tk', 'ma_bp', 'ma_phi', 'ma_spct'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'tk', 'tk_du', 'ma_bp', 'ma_phi', 'ma_spct',
        't1', 't2', 't3', 't4', 't5', 't6',
        't7', 't8', 't9', 't10', 't11', 't12',
        'ps_no', 'ps_co',
    ];

    // Relationships
    public function taiKhoan()
    {
        return $this->belongsTo(DMTK::class, 'tk', 'tk');
    }

    public function boPhan()
    {
        return $this->belongsTo(DMBP::class, 'ma_bp', 'ma_bp');
    }
}
```

### 2. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Dutoan/Index.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Dutoan;

class Index extends Component
{
    const MA_CT = 'GL';

    public Collection $pBudgets;
    public string $pSearch = '';
    public ?string $pTk = null;
    public ?int $pNam = null;

    public function render(): View
    {
        return view('catalog::gl.dutoan.index');
    }
}
```

### 3. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Dutoan/Edit.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Dutoan;

class Edit extends Component
{
    public ?string $pTk = null;
    public ?string $pTk_Du = null;
    public ?string $pMa_Bp = null;
    public ?string $pMa_Phi = null;
    public ?string $pMa_Spct = null;
    public array $pThang = array_fill(1, 12, 0);
    public float $pPs_No = 0;
    public float $pPs_Co = 0;

    protected $rules = [
        'pTk' => 'required|exists:DMTK,tk',
    ];

    public function updatedPThang($value, $key): void
    {
        $this->calculateTotal();
    }

    private function calculateTotal(): void
    {
        $this->pPs_No = array_sum(array_slice($this->pThang, 0, 6));
        $this->pPs_Co = array_sum(array_slice($this->pThang, 6, 6));
    }

    public function submit(): void { /* ... */ }
    public function render(): View { return view('catalog::gl.dutoan.edit'); }
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | GLBudget.php | Chinh |
| Model | laravel-simba | DMTK.php | Tai khoan |
| Model | laravel-simba | DMBP.php | Bo phan |
| Component | laravel-catalog | GL/Dutoan/Index.php | List |
| Component | laravel-catalog | GL/Dutoan/Edit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Model GLBudget
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire Index (danh sach)
- [ ] Tao Livewire Edit (nhap lieu 12 thang)
- [ ] Tao Views (list + edit)
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test Integration voi DMTK, DMBP