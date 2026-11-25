# Task 232: INRptCTVT02

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang the kho - so chi tiet vat tu tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INRptCTVT02.dll
- **Chuc nang:** The kho - So chi tiet vat tu (in tat ca)
- **Loai:** Bao cao (Report)
- **Assembly Title:** The kho-so chi tiet vat tu (in tat ca)
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Công ty phần mềm Asia
- **Ma_ct:** IN (Report)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INRptCTVT02.dll/README.md`

---

## Form classes

### frmINRptCTVT02 (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Xem/in the kho/so chi tiet vat tu (in tat ca)

### Filter Controls

| Control | Type | Lookup | Mo ta |
|---------|------|--------|-------|
| txtMa_vt | AsTextBox | MA_VT | Ma vat tu |
| txtMa_nhvt | AsTextBox | MA_NHVT | Ma nhom vat tu |
| txtMa_tkvt | AsTextBox | TK_VT | Ma TK vat tu |
| txtMa_kho | AsTextBox | MA_KHO | Ma kho |
| txtMa_vitri | AsTextBox | MA_VTRI | Ma vi tri |
| cboDVT | ComboBox | - | Don vi tinh |
| chkPS_dc | AsCheckBox | - | Hien thi phat sinh dieu chinh |
| crvReportViewer | CrystalReportViewer | - | Xem bao cao |

### Label hien thi ten

| Label | Mo ta |
|-------|-------|
| lblMa_vt | Ma vat tu |
| lblTen_vt | Ten vat tu |
| lblNhom_vt | Nhom vat tu |
| lblTen_nhvt | Ten nhom VT |
| lblMa_tkvt | Ma TKVT |
| lblTen_tkvt | Ten TKVT |
| lblMa_kho | Ma kho |
| lblTen_kho | Ten kho |
| lblMa_vitri | Ma vi tri |
| lblTen_vitri | Ten vi tri |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_IN_RPT_CTVT02_GET | Lay du lieu the kho - so chi tiet vat tu (in tat ca) |

---

## Business Logic

### Business Rules

1. **The kho / So chi tiet vat tu**:
   - Chi tiet nhap/xuat/ton cua tung vat tu
   - In tat ca cac vat tu theo tieu chi loc

2. **Tinh nang in tat ca**:
   - In theo dõi cho tất cả vật tư
   - Không cần chọn từng vật tư riêng lẻ

3. **Don vi tinh**:
   - Chon don vi tinh hien thi

4. **Phat sinh dieu chinh**:
   - Tuy chon hien thi phat sinh dieu chinh

---

## Mapping PHP

### 1. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Baocao/TheKhoSoChiTiet.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Baocao;

class TheKhoSoChiTiet extends Component
{
    const MA_CT = 'IN';

    public string $pMa_Vt = '';
    public string $pMa_Nhvt = '';
    public string $pMa_Tkvt = '';
    public string $pMa_Kho = '';
    public string $pMa_Vitri = '';
    public int $pDvt = 0;
    public bool $pPs_dc = false;

    public function render(): View
    {
        return view('catalog::in.baocao.the-kho-so-chi-tiet');
    }
}
```

### 2. Views

```
resources/views/catalog/in/baocao/
├── the-kho-so-chi-tiet.blade.php
└── the-kho-so-chi-tiet-report.blade.php
```

### 3. Routes

```php
Route::prefix('catalog/in/baocao')
    ->name('catalog.in.baocao.')
    ->group(function () {
        Route::get('/the-kho-so-chi-tiet', [TheKhoSoChiTiet::class, 'render'])
            ->name('the-kho-so-chi-tiet');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | TheKhoSoChiTiet.php | Filter form |
| SP | laravel-simba | AsINRptCTVT02.php | Data source |
| View | laravel-catalog | the-kho-so-chi-tiet.blade.php | UI |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire TheKhoSoChiTiet (filter form)
- [ ] Tao View filter form
- [ ] Integrate report viewer
- [ ] Them Routes
- [ ] Test report generation
- [ ] Test in tat ca
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE — component `In\Rpt\Inrptctvt02142032` + route `in.rpt.inrptctvt02142032`, verify browser 2026-11-25 (**3369 dòng dữ liệu thật**)
- **Route:** `in.rpt.inrptctvt02142032` (suffix `142032` vì 2 menu cùng DLL)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.

## Portal implementation (2026-11-25)

- **Component:** `In\Rpt\Inrptctvt02142032` (kế thừa `Rpt\AbstractReport`)
- **View:** `in/rpt/inrptctvt02142032.blade.php` + filter tương ứng
- **Route:** `in.rpt.inrptctvt02142032` — **có suffix** `142032`
- **SP:** `asINRptCTVT02` — 13 tham số
- **Menu:** `14.20.32` — "Thẻ kho/Sổ chi tiết vật tư (in tất cả)"

### Route có suffix — vì 2 menu cùng DLL

`sysMenu` có 2 menu active cùng `INRptCTVT02`:

| MenuID | Route name |
|---|---|
| `14.20.05` | `in.rpt.inrptctvt02**142005**` |
| `14.20.32` | `in.rpt.inrptctvt02**142032**` |

→ Component phải tên `Inrptctvt02142032`, không phải `Inrptctvt02`.

### 🐛 Bug wrapper `AsINRptCTVT02` — đã sửa

Wrapper gửi **2 tham số không tồn tại** trong SP:

| Tham số thừa | Loại |
|---|---|
| `pSysMsg1` | Tham số thông báo .NET, không phải SP |
| `pMa_nt0` | Biến thể lạ (có `pMa_nt` rồi, thêm `pMa_nt0`) |

→ SP báo: `Procedure or function asINRptCTVT02 has too many arguments specified`

**Fix:** bỏ 2 tham số này, giữ đúng 13 tham số theo `procedures.md`.

### 🎉 Verify browser thật — 3369 dòng, 24 cột

| Kỳ test | Số dòng | Số cột |
|---|---:|---:|
| **2026-01-01 → 2026-12-31** | **3.369** | **24** |
| 2020-01-01 → 2020-12-31 | **1.864** | 24 |

**24 cột:** `tag`, `ma_vt`, `ten_vt`, `dvt`, `ma_nhvt`, `stt_nhom`, `cap`, `nhom_me`,
`ton_dau`, `du_dau`, `du_dau_nt`, `sl_nhap`, `sl_xuat`, `tien_nhap`, `tien_xuat`,
`tien_nhap_nt`, `tien_xuat_nt`, `ton_cuoi`, `du_cuoi`, `du_cuoi_nt`,
`vat_tu`, `bold`, `has_sysmsg`, `ma_nt`

Dòng đầu: `ma_vt = "PRODUCT"`, `ten_vt = "Hang Hoa"` — dữ liệu thật.

| Kiểm chứng khác | Kết quả |
|---|---|
| Livewire component | ✅ `catalog::in.rpt.inrptctvt02142032` render thật |
| Tab + nút Thực hiện | ✅ có |
| Page error | **0** |

> Đây là báo cáo có **nhiều dòng nhất** từ trước tới nay (3369).
