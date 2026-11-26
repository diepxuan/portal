# Task 231: INRptCD01

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang bao cao cong no vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptCD01.dll
- **Chuc nang:** Bao cao cong no vat tu 01
- **Loai:** Bao cao (Report)
- **Assembly Title:** Bao cao cong no 01
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptCD01.dll/README.md`

---

## Form classes

### frmINRptCD01 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in bao cao cong no vat tu

### Filter Controls

| Control | Type | Mo ta |
|---------|------|-------|
| cboKyBc | ComboBox | Ky bao cao |
| txtNgay1 | DateTimePicker | Ngay bat dau |
| txtNgay2 | DateTimePicker | Ngay ket thuc |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_tkvt | AsTextBox | Ma TK vat tu |
| txtMa_nhvt | AsTextBox | Ma nhom vat tu |
| txtMa_vitri | AsTextBox | Ma vi tri |
| cboDVT | ComboBox | Don vi tinh |
| ChkPsdc | CheckBox | Tinh phat sinh dieu chinh |
| txtMa_plvt1 | AsTextBox | Phan loai VT 1 |
| txtMa_plvt2 | AsTextBox | Phan loai VT 2 |
| txtMa_plvt3 | AsTextBox | Phan loai VT 3 |
| txtOrder1 | TextBox | Thu tu phan loai 1 |
| txtOrder2 | TextBox | Thu tu phan loai 2 |
| txtOrder3 | TextBox | Thu tu phan loai 3 |

### Don vi tinh options

| Gia tri | Mo ta |
|---------|-------|
| 0 | Don vi tinh Kho |
| 1 | Don vi tinh Mua |
| 2 | Don vi tinh Ban |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_CD01_GET | Lay du lieu bao cao cong no vat tu |

---

## Business Logic

### Business Rules

1. **Bao cao cong no**:
   - Ton dau ky
   - Phat sinh nhap trong ky
   - Phat sinh xuat trong ky
   - Ton cuoi ky

2. **Tinh phat sinh dieu chinh**:
   - Khi chkPsdc = true, tinh ca phat sinh dieu chinh

3. **Phan loai VT**:
   - 3 cap phan loai (plvt1, plvt2, plvt3)
   - Thu tu phan loai (order1, order2, order3)

4. **Drilldown (F5)**:
   - Cho phep xem chi tiet vat tu

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/CongNoVatTu.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class CongNoVatTu extends Component
{
    const MA_CT = 'IN';

    public string $pKyBc = '';
    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public string $pMa_Kho = '';
    public string $pMa_Vt = '';
    public string $pMa_Tkvt = '';
    public string $pMa_Nhvt = '';
    public string $pMa_Vitri = '';
    public int $pDvt = 0;
    public bool $pPsdc = false;
    public string $pMa_Plvt1 = '';
    public string $pMa_Plvt2 = '';
    public string $pMa_Plvt3 = '';
    public int $pOrder1 = 0;
    public int $pOrder2 = 0;
    public int $pOrder3 = 0;

    public function render(): View
    {
        return view('catalog::in.baocao.cong-no-vat-tu');
    }
}
```

### 2. Views

```
resources/views/catalog/in/baocao/
├── cong-no-vat-tu.blade.php
└── cong-no-vat-tu-report.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/in/baocao')
    ->name('catalog.in.baocao.')
    ->group(function () {
        Route::get('/cong-no-vat-tu', [CongNoVatTu::class, 'render'])
            ->name('cong-no-vat-tu');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | CongNoVatTu.php | Filter form |
| SP | laravel-simba | AsINRptCD01.php | Data source |
| View | laravel-catalog | cong-no-vat-tu.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire CongNoVatTu (filter form)
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test drilldown F5
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE — component `In\Rpt\Inrptcd01` + route `in.rpt.inrptcd01`, verify browser 2026-11-25 (**2085 dòng dữ liệu thật**)
- **Route:** `in.rpt.inrptcd01`
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `In\Rpt\Inrptcd01` (kế thừa `Rpt\AbstractReport`)
- **View:** `in/rpt/inrptcd01.blade.php` + filter `in/rpt/filters/inrptcd01.blade.php`
- **Route:** `in.rpt.inrptcd01` (menu 14.20.08 — 1 menu duy nhất, **không** suffix)
- **SP:** `asINRptCD01` — 18 tham số
- **Menu:** `14.20.08` — "Nhập xuất tồn: Số lượng và giá trị"

### 🐛 Bug wrapper `AsINRptCD01` — đã sửa (loại 3: tham số SAI, không chỉ thiếu)

Wrapper gửi **2 tham số không tồn tại** trong SP + **thiếu 3 tham số thật**:

| Vấn đề | Chi tiết |
|---|---|
| **Thừa** `pSysMsg1` | SP báo: `@pSysMsg1 is not a parameter for procedure asINRptCD01` |
| **Thừa** `pMa_Cty` | Trùng với `pMa_cty` (khác hoa thường) |
| **Thiếu** `group1`, `group2`, `group3` | 3 tham số nhóm theo cấp |

**Fix:** bỏ `pSysMsg1`/`pMa_Cty`, thêm `group1`/`group2`/`group3` theo đúng thứ tự `procedures.md`.

> Đây là **loại bug thứ 3** ngoài 2 loại đã ghi trong task 376: không chỉ trùng/thiếu,
> mà còn **gửi tham số SP không hề có**.

### 🎉 Verify browser thật — DỮ LIỆU THẬT 2085 dòng

| Kỳ test | Số dòng |
|---|---:|
| **2026-01-01 → 2026-12-31** | **2.085** ✅ |
| 2020-01-01 → 2020-12-31 | **1.426** ✅ |
| 2010-01-01 → 2010-12-31 | 0 |

**25 cột dữ liệu trả về:**
`ma_vt`, `ten_vt`, `dvt`, `tk_vt`, `ten_tk`, `ma_nhvt`, `stt_nhom`, `cap`, `nhom_me`,
`ton_dau`, `du_dau`, `du_dau_nt`, `sl_nhap`, `sl_xuat`, `tien_nhap`, `tien_xuat`,
`tien_nhap_nt`, `tien_xuat_nt`, `ton_cuoi`, `du_cuoi`, `du_cuoi_nt`, `vat_tu`,
`bold`, `has_sysmsg`, `ton_kho`

| Kiểm chứng khác | Kết quả |
|---|---|
| Livewire component | ✅ `catalog::in.rpt.inrptcd01` render thật |
| Sub-component | ✅ `input-indmvt`, `input-indmnhvt`, `input-indmkho` |
| Tab + nút Thực hiện | ✅ có |
| Page error | **0** |

> Đây là báo cáo thứ 2 verify được **dữ liệu thật** (sau task 293), và là báo cáo
> có **nhiều dòng nhất** từ trước tới nay (2085).
