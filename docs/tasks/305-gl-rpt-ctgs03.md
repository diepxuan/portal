# Task 305: GLRptCTGS03

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Bang ke CTGS03 (theo TK va lo) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLRptCTGS03.dll
- **Assembly Title:** Bang ke hoa don, chung tu hang hoa, dich vu mua vao
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Lookup tk |
| DMLO | Danh muc lo | Lookup lo |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| ngay1, ngay2 | Ngay bat dau/ket thuc |
| tk | Tai khoan loc |
| ma_lo | Ma lo |
| ma_nt | Ma ngoai te |

---

## Form classes

### 1. frmGLRptCTGS03
- **Ke thua:** frmReport
- **Chuc nang:** Bang ke theo TK va lo

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan loc (AutoLookup) |
| txtMa_lo | AsTextBox | Ma lo (AutoLookup) |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1, txtNgay2 | AsMaskedTextBox | Ngay bat dau/ket thuc |
| cboMau_bc | ComboBox | Chon mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| cmdOk, cmdCancel, cmdExcel, cmdModifyReport | Button | Nut dieu khien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_RPT_CTGS03_GET | Lay du lieu bang ke CTGS03 |

### Parameters reference

```sql
EXEC SP_GL_RPT_CTGS03_GET
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pTk VARCHAR(50) = NULL,
    @pMa_lo VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(50) = NULL
```

---

## Business Logic

### Business Rules

1. **Loc theo TK**: Chi tiet theo tai khoan
2. **Loc theo lo**: Chi tiet theo ma lo (hang nhap)
3. **Drill-down**: F7 chi tiet theo lo va TK

---

## Mapping PHP

### 1. Report Service

```php
// diepxuan/laravel-simba/src/Services/GL/CTGS03Service.php
namespace Diepxuan\Simba\Services\GL;

class CTGS03Service
{
    public function getReport(array $params): array;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Baocao/Ctgs03.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Baocao;

class Ctgs03 extends Component
{
    const MA_CT = 'GL';

    public ?string $tk = null;
    public ?string $ma_lo = null;
    public ?Carbon $ngay1 = null;
    public ?Carbon $ngay2 = null;
    public ?string $ma_nt = null;
}
```

### 3. Views

```
resources/views/catalog/gl/baocao/
├── ctgs03.blade.php
└── _ctgs03-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/baocao/ctgs03', [Ctgs03::class, 'render'])
    ->name('catalog.gl.baocao.ctgs03');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | CTGS03Service.php | Chinh |
| Component | laravel-catalog | Ctgs03.php | Livewire |
| Lookup | laravel-simba | DMTK.php | Tai khoan |
| Lookup | laravel-simba | DMLO.php | Lo |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Report Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test bao cao
- [ ] Test loc TK/lo
- [ ] Test drill-down
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE — component `Gl\Rpt\Glrptctgs03` + route `gl.rpt.glrptctgs03`, verify browser 2026-11-25 (**31 dòng dữ liệu thật, 13 cột**)
- **Route:** `gl.rpt.glrptctgs03`
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `Gl\Rpt\Glrptctgs03` (kế thừa `Rpt\AbstractReport`)
- **View:** `gl/rpt/glrptctgs03.blade.php` + filter tương ứng
- **Route:** `gl.rpt.glrptctgs03` — 1 menu duy nhất, không suffix
- **SP:** `asGLRptCTGS03` — **5 tham số**
- **Menu:** `02.20.14` — "Sổ cái chứng từ ghi sổ"

### Đối chiếu 3 nguồn — KHỚP HOÀN TOÀN

| Nguồn | Tham số |
|---|---|
| Form gốc `frmGLRptCTGS03.LoadData()` | CompanyID, Tk, Ngay1, Ngay2, Ma_Nt (**5**) |
| `procedures.md` | pMa_Cty, pTk, pNgay_ct1, pNgay_ct2, pMa_Nt (**5**) |
| Wrapper `AsGLRptCTGS03` | pMa_Cty, pTk, pNgay_ct1, pNgay_ct2, pMa_Nt (**5**) |

Lần này cả 3 nguồn khớp — không cần sửa wrapper.

### Lưu ý về tên tham số

Wrapper dùng `pNgay_ct1`/`pNgay_ct2` (không phải `pNgay1`/`pNgay2`).
Component map từ property `pNgay1`/`pNgay2` sang đúng tên tham số SP.

### Verify browser thật — 31 dòng, 13 cột

| Tài khoản test | Số dòng | Số cột |
|---|---:|---:|
| 112, 131, 331, 511, 632, 642 | **31** | **13** |
| (rỗng) | **31** | 13 |
| 111 | 0 | — |

**13 cột:** `fSort`, `ngay_lo`, `so_lo`, `dien_giai`, `Tk_du`, ...

| Kiểm chứng khác | Kết quả |
|---|---|
| Livewire component | `catalog::gl.rpt.glrptctgs03` render thật |
| Sub-component | `input-taikhoan` |
| Tab + nút Thực hiện | có |
| Page error | **0** |

> Đây là báo cáo GL thứ 2 có dữ liệu thật (sau task 293).
