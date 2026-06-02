# Task 304: GLRptCTGS02

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bang ke hoa don, chung tu hang hoa, dich vu mua vao (CTGS02) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptCTGS02.dll
- **Assembly Title:** Bang ke hoa don, chung tu hang hoa, dich vu mua vao
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | Lookup ma_kh |
| DMVT | Danh muc vat tu | Lookup ma_vt |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| so_ct | So chung tu tu/den |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGLRptCTGS02
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke hoa don, chung tu mua vao (v2)

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| txtSo_ct1, txtSo_ct2 | AsTextBox | So chung tu tu/den |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |
| dgvBC | DataGridView | Luoi hien thi (cho phep edit cot tag) |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CTGS02_GET | Lay du lieu bang ke mua vao v2 |

### Parameters reference

```sql
EXEC SP_GL_RPT_CTGS02_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pSo_ct1 VARCHAR(50) = NULL,
    @pSo_ct2 VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Bang ke mua vao**: Hien thi chi tiet cac chung tu mua hang
2. **Edit tag**: Cho phep edit cot tag trong luoi (dgvBC_CellEnter)
3. **Loc theo ngay**: Theo ngay chung tu
4. **Loc theo so CT**: Theo so chung tu tu/den

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/CTGS02Service.php
namespace Diepxuan\Simba\Services\GL;

class CTGS02Service
{
    public function getReport(array $params): array;
    public function updateTag(array $data): bool;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Ctgs02.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Ctgs02 extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $so_ct1 = null;
    public ?string $so_ct2 = null;
    public ?string $ma_nt = null;
    public array $danhSach = [];
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── ctgs02.blade.php
└── _ctgs02-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/ctgs02', [Ctgs02::class, 'render'])
    ->name('catalog.gl.baocao.ctgs02');
Route::post('/catalog/gl/baocao/ctgs02/update-tag', ...)
    ->name('catalog.gl.baocao.ctgs02.updateTag');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | CTGS02Service.php | Chinh |
| Component | laravel-catalog | Ctgs02.php | Livewire |
| Lookup | laravel-simba | DMKH.php | Khach hang |
| Lookup | laravel-simba | DMVT.php | Vat tu |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao
- [ ] Test edit tag
- [ ] Test export Excel
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
