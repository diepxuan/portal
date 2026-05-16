# Task 159-165: CA-RptTMNH-BaoCaoTienMatNganHang

## Nhom: CA (Cash & Bank - Tien mat & ngan hang)

## Muc tieu
Chuyen doi 7 bao cao tien mat ngan hang (CARptTMNH01-07) tu .NET sang PHP Laravel.

## Chi tiet chung
- **Nhom DLL:** CARptTMNH01.dll - CARptTMNH07.dll
- **Loai:** Report (Bao cao tien mat & ngan hang)
- **Assembly Company:** AsiaErp/UserInterface
- **Ma_ct:** CA

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/CARptTMNH*.dll/README.md`

---

## Bang: RptTMNH (Bang tam bao cao TM/NH)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| tk | varchar | Tai khoan ke toan |
| ten_tk | nvarchar | Ten tai khoan |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| dien_giai | nvarchar | Dien giai |
| ps_no | decimal | Phat sinh no |
| ps_co | decimal | Phat sinh co |
| so_du | decimal | So du |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | FK tk |
| CADMKU | Danh muc ke uoc | Lookup ke uoc |
| CACHNH | Cong no ke uoc | FK ma_ku |

---

## Form classes chung

### frmCARptTMNH* (Base: frmReport)
- **Ke thua:** frmReport
- **Chuc nang:** Hien thi bao cao TM/NH

### Controls chung (ke thua tu frmReport)

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| cboKyBc | AsComboBox | Ky bao cao |
| cboMau_bc | AsComboBox | Mau bao cao |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |
| txtTieu_De | TextBox | Tieu de bao cao |
| cmdOk | Button | Xem bao cao |
| cmdCancel | Button | Huy |
| cmdExcel | Button | Xuat Excel |
| cmdModifyReport | Button | Sua mau bao cao |
| dgvBC | AsDataGridView | Luoi hien thi du lieu |

---

## Chi tiet 7 Bao cao

### 159. CARptTMNH01 - So chi tiet TM/NH
| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan (bat buoc) |
| lblTen_Tk | Label | Ten tai khoan |

### 160. CARptTMNH02 - So quy TM/NH
| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan (bat buoc) |
| lblTen_Tk | Label | Ten tai khoan |

### 161. CARptTMNH03 - So chi tiet vay theo ke uoc
| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan vay (bat buoc) |
| txtMa_ku | AsTextBox | Ma ke uoc |

### 162. CARptTMNH04 - Tong hop theo nhan vien/nhom KH
| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan |
| txtNV | AsTextBox | Nhan vien |
| txtNh_kh | AsTextBox | Nhom khach hang |

### 163. CARptTMNH05 - Tinh hinh vay noi theo ke uoc
| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_ku | AsTextBox | Ma ke uoc (bat buoc) |

### 164. CARptTMNH06 - So chi tiet vay (Crystal Report)
| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_TK | AsTextBox | Tai khoan (bat buoc) |
| txtMa_ku | AsTextBox | Ma ke uoc (an) |
| crvReportViewer | CrystalReportViewer | Crystal Report viewer |

### 165. CARptTMNH07 - Tong hop vay noi theo TK va ke uoc
| Control | Type | Mo ta |
|---------|------|-------|
| txtTk | AsTextBox | Tai khoan (bat buoc) |
| txtMa_ku | AsTextBox | Ma ke uoc |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_CA_RPTTMNH01_GET | Lay du lieu so chi tiet TM/NH |
| SP_CA_RPTTMNH02_GET | Lay du lieu so quy TM/NH |
| SP_CA_RPTTMNH03_GET | Lay du lieu chi tiet vay theo KU |
| SP_CA_RPTTMNH04_GET | Lay du lieu tong hop theo NV/NH KH |
| SP_CA_RPTTMNH05_GET | Lay du lieu tinh hinh vay theo KU |
| SP_CA_RPTTMNH06_GET | Lay du lieu so chi tiet vay |
| SP_CA_RPTTMNH07_GET | Lay du lieu tong hop vay noi |

### Parameters chung

```sql
EXEC SP_CA_RPTTMNHxx_GET
    @pMa_cty VARCHAR(50) = '001',
    @pTk VARCHAR(50) = NULL,
    @pNgay1 DATETIME = NULL,
    @pNgay2 DATETIME = NULL,
    @pMa_ku VARCHAR(50) = NULL,
    @pMa_nt VARCHAR(10) = 'VND',
    @pIsNT BIT = 0
```

---

## Business Logic chung

### Validate Rules

| Rule | Message |
|------|---------|
| Required TK | 'Tai khoan khong duoc trong' |
| Valid date range | 'Ngay khong hop le' |

### Business Rules

1. **Bao cao TM/NH (01, 02):**
   - Bat buoc nhap tai khoan
   - Hien thi so chi tiet/quy cua TK

2. **Bao cao vay (03, 05, 06, 07):**
   - Lac theo ke uoc (neu co)
   - Hien thi chi tiet vay no/theo ke uoc

3. **Bao cao tong hop (04):**
   - Loc theo nhan vien va nhom KH
   - Tong hop thu chi theo NV phu trach

4. **Tien te:**
   - Ho tro VND va ngoai te
   - Tu dong tinh ty gia neu can

---

## Mapping PHP

### 1. Livewire Components

```php
// CARptTMNH01 - So chi tiet TM/NH
namespace Diepxuan\Catalog\Http\Livewire\CA\Reports;

class RptTMNH01 extends Component
{
    const MA_CT = 'CA';
    public ?string $pTk = null;
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public bool $pIsNT = false;

    protected function getSPClass(): string
    {
        return AsCAGetRptTMNH01::class;
    }
}

// CARptTMNH02 - So quy TM/NH
class RptTMNH02 extends Component { /* ... */ }

// CARptTMNH03 - Chi tiet vay theo KU
class RptTMNH03 extends Component { /* ... */ }

// CARptTMNH04 - Tong hop theo NV/NH KH
class RptTMNH04 extends Component { /* ... */ }

// CARptTMNH05 - Tinh hinh vay theo KU
class RptTMNH05 extends Component { /* ... */ }

// CARptTMNH06 - So chi tiet vay (Crystal)
class RptTMNH06 extends Component { /* ... */ }

// CARptTMNH07 - Tong hop vay noi
class RptTMNH07 extends Component { /* ... */ }
```

### 2. Stored Procedure Classes

```php
namespace Diepxuan\Simba\StoredProcedures;

class AsCAGetRptTMNH01 extends StoredProcedure
{
    protected $procedure = 'SP_CA_RPTTMNH01_GET';
    protected $params = ['pMa_cty', 'pTk', 'pNgay1', 'pNgay2', 'pMa_nt', 'pIsNT'];
}

class AsCAGetRptTMNH02 extends StoredProcedure { /* ... */ }
class AsCAGetRptTMNH03 extends StoredProcedure { /* ... */ }
class AsCAGetRptTMNH04 extends StoredProcedure { /* ... */ }
class AsCAGetRptTMNH05 extends StoredProcedure { /* ... */ }
class AsCAGetRptTMNH06 extends StoredProcedure { /* ... */ }
class AsCAGetRptTMNH07 extends StoredProcedure { /* ... */ }
```

### 3. Views

```
resources/views/catalog/ca/reports/
├── rpt-tmnh-01.blade.php    (So chi tiet TM/NH)
├── rpt-tmnh-02.blade.php    (So quy TM/NH)
├── rpt-tmnh-03.blade.php    (Chi tiet vay theo KU)
├── rpt-tmnh-04.blade.php    (Tong hop theo NV/NH KH)
├── rpt-tmnh-05.blade.php    (Tinh hinh vay theo KU)
├── rpt-tmnh-06.blade.php    (So chi tiet vay - Crystal)
├── rpt-tmnh-07.blade.php    (Tong hop vay noi)
└── _rpt-tmnh-filter.blade.php (Filter component chung)
```

### 4. Routes

```php
Route::prefix('catalog/ca/bao-cao')
    ->name('catalog.ca.baocao.')
    ->group(function () {
        Route::get('/rpt-tmnh-01', [RptTMNH01::class, 'render'])->name('rpttm01');
        Route::get('/rpt-tmnh-02', [RptTMNH02::class, 'render'])->name('rpttm02');
        Route::get('/rpt-tmnh-03', [RptTMNH03::class, 'render'])->name('rpttm03');
        Route::get('/rpt-tmnh-04', [RptTMNH04::class, 'render'])->name('rpttm04');
        Route::get('/rpt-tmnh-05', [RptTMNH05::class, 'render'])->name('rpttm05');
        Route::get('/rpt-tmnh-06', [RptTMNH06::class, 'render'])->name('rpttm06');
        Route::get('/rpt-tmnh-07', [RptTMNH07::class, 'render'])->name('rpttm07');
    });
```

---

## Dependencies

| Loai | Package | Ghi chu |
|------|---------|---------|
| SP Classes | laravel-simba | AsCAGetRptTMNH* |
| Model | laravel-simba | DMTK |
| Model | laravel-simba | CADMKU |
| Components | laravel-catalog | RptTMNH01-07 |
| Voucher | CA - Vouchers | Nguon du lieu |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Stored Procedure classes (7 SPs)
- [ ] Tao Livewire RptTMNH01 (So chi tiet TM/NH)
- [ ] Tao Livewire RptTMNH02 (So quy TM/NH)
- [ ] Tao Livewire RptTMNH03 (Chi tiet vay theo KU)
- [ ] Tao Livewire RptTMNH04 (Tong hop theo NV/NH KH)
- [ ] Tao Livewire RptTMNH05 (Tinh hinh vay theo KU)
- [ ] Tao Livewire RptTMNH06 (So chi tiet vay - Crystal)
- [ ] Tao Livewire RptTMNH07 (Tong hop vay noi)
- [ ] Tao Views cho 7 bao cao
- [ ] Them Routes
- [ ] Test CRUD & Export Excel
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route shell / dictionary coverage exists)
- **Source:** `docs/project/simba-router-menu-matrix.md`, `SimbaRouteRegistry` / registry tương ứng.
- **Note:** Không code lại route đã có; execute SP/write vẫn chỉ mở khi metadata payload đã audit đủ.
