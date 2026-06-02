# Task 355: INDMVT_ - Danh mục vật tư (BOM)

## Nhóm: IN (Inventory - Tồn kho)

## Mục tiêu
Chuyển đổi chức năng danh mục vật tư (phiên bản có BOM) từ .NET sang PHP Laravel, đạt kết quả tương đương.

## Chi tiết
- **DLL:** INDMVT_.dll
- **Chức năng:** Quản lý danh mục vật tư với hỗ trợ BOM (Bill of Materials)
- **Loại:** Danh mục (DM) + BOM
- **Assembly Title:** Danh mục bộ phận
- **Version:** 9.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC

## Tài liệu tham khảo
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INDMVT_.dll/README.md`

---

## Cấu trúc dữ liệu

### Bảng: INDVVT (Danh mục vật tư - phiên bản BOM)

| Trường | Kiểu | Chiều dài | Mô tả |
|--------|------|-----------|-------|
| ma_vt | varchar | 50 | Mã vật tư (khóa chính) |
| ten_vt | nvarchar | 200 | Tên vật tư |
| ma_nhvt | varchar | 50 | Mã nhóm vật tư |
| dvt | varchar | 20 | Đơn vị tính |
| loai | int | 1 | Loại vật tư |
| ton_kho | bit | 1 | Theo dõi tồn kho |
| gia_ton | int | 1 | Phương pháp tính giá tồn |
| ma_nhvat | varchar | 50 | Mã nhóm VAT |
| tk_vt | varchar | 20 | TK vật tư |
| tk_dt | varchar | 20 | TK doanh thu |
| tk_dt_nb | varchar | 20 | TK doanh thu nội bộ |
| tk_gv | varchar | 20 | TK giá vốn |
| tk_tl | varchar | 20 | TK trả lại |
| tk_ck | varchar | 20 | TK chiết khấu |
| ts_gtgt | decimal | 10,2 | Thuế suất GTGT |
| ts_ttdb | decimal | 10,2 | Thuế suất TTĐB |
| ts_nk | decimal | 10,2 | Thuế suất nhập khẩu |
| ts_xk | decimal | 10,2 | Thuế suất xuất khẩu |
| ma_thue | varchar | 50 | Mã thuế |
| sl_min | decimal | 18,4 | Tồn kho tối thiểu |
| sl_max | decimal | 18,4 | Tồn kho tối đa |
| ma_kho | varchar | 50 | Mã kho mặc định |
| dvt_mua | varchar | 20 | Đơn vị tính mua |
| dvt_ban | varchar | 20 | Đơn vị tính bán |
| hs_dvtmua | decimal | 10,4 | Hệ số quy đổi mua |
| hs_dvtban | decimal | 10,4 | Hệ số quy đổi bán |
| gia_nt0 | decimal | 18,4 | Giá mua mặc định |
| gia_nt2 | decimal | 18,4 | Giá bán mặc định |

### Bảng: MA_BOM (Bill of Materials)

| Trường | Kiểu | Chiều dài | Mô tả |
|--------|------|-----------|-------|
| ma_vt | varchar | 50 | Mã vật tư cha (khóa chính) |
| ma_lk | varchar | 50 | Mã linh kiện (khóa chính) |
| so_luong | decimal | 18,4 | Số lượng linh kiện |
| he_so | decimal | 10,4 | Hệ số quy đổi |
| dvt_lk | varchar | 20 | Đơn vị tính linh kiện |

### Table Navigation

| Bảng | Mô tả | Relationship |
|------|-------|---------------|
| DMNHVT | Danh mục nhóm vật tư | FK ma_nhvt -> DMNHVT.ma_nhvt |
| DMNHVAT | Danh mục nhóm VAT | FK ma_nhvat -> DMNHVAT.ma_nhvat |
| DMKHO | Danh mục kho | FK ma_kho -> DMKHO.ma_kho |
| DMTK | Danh mục tài khoản | FK tk_* -> DMTK.ma_tk |
| MA_BOM | BOM linh kiện | FK ma_vt -> INDVVT.ma_vt |
| MA_THUE | Danh mục thuế | FK ma_thue -> MA_THUE.ma_thue |

---

## Form classes

### 1. frmINDMVT (Form xem danh sách)
- **Kế thừa:** frmDMView
- **Chức năng:** Hiển thị danh sách vật tư, tìm kiếm
- **GetData:** CompanyID, "", "0", CurrentCultureName

### 2. frmINDMVTEdit (Form thêm/sửa)
- **Kế thừa:** frmDMEdit
- **Chức năng:** Nhập, sửa thông tin vật tư + quản lý BOM

#### Controls chính

| Control | Type | DataField | Mô tả |
|---------|------|-----------|-------|
| txtMa_Vt | TextBox | ma_vt | Mã vật tư |
| txtTen_Vt | TextBox | ten_vt | Tên vật tư |
| txtMa_Nhvt | AsTextBox | ma_nhvt | Nhóm vật tư (AutoLookup) |
| cboDvt | ComboBox | dvt | Đơn vị tính (Cái, Chiếc, Con, Cặp, Bộ, Đôi) |
| cboLoai | ComboBox | loai | Loại vật tư |
| chkTon_kho | AsCheckBox | ton_kho | Theo dõi tồn kho |
| cboGia_ton | ComboBox | gia_ton | Phương pháp tính giá tồn |
| txtMa_nhvat | AsTextBox | ma_nhvat | Nhóm VAT (AutoLookup) |
| txtTk_Vt | AsTextBox | tk_vt | TK vật tư (AutoLookup) |
| txtTk_Dt | AsTextBox | tk_dt | TK doanh thu (AutoLookup) |
| txtTk_DtNb | AsTextBox | tk_dt_nb | TK doanh thu nội bộ (AutoLookup) |
| txtTk_Gv | AsTextBox | tk_gv | TK giá vốn (AutoLookup) |
| txtTk_Tl | AsTextBox | tk_tl | TK trả lại (AutoLookup) |
| txtTk_Ck | AsTextBox | tk_ck | TK chiết khấu (AutoLookup) |
| txtTs_Gtgt | AsTextNumeric | ts_gtgt | Thuế suất GTGT |
| txtTs_ttdb | AsTextNumeric | ts_ttdb | Thuế suất TTĐB |
| txtTs_Nk | AsTextNumeric | ts_nk | Thuế suất NK |
| txtTs_Xk | AsTextNumeric | ts_xk | Thuế suất XK |
| txtMa_Thue | AsTextBox | ma_thue | Mã thuế (AutoLookup) |
| txtSl_min | AsTextNumeric | sl_min | Tồn tối thiểu |
| txtSl_max | AsTextNumeric | sl_max | Tồn tối đa |
| txtMa_kho | AsTextBox | ma_kho | Kho mặc định (AutoLookup) |
| cboDvt_mua | AsComboBox | dvt_mua | ĐVT mua |
| cboDvt_ban | AsComboBox | dvt_ban | ĐVT bán |
| txtHs_dvtmua | AsTextNumeric | hs_dvtmua | Hệ số quy đổi mua |
| txtHs_dvtban | AsTextNumeric | hs_dvtban | Hệ số quy đổi bán |
| txtGia_nt0 | AsTextNumeric | gia_nt0 | Giá mua |
| txtGia_nt2 | AsTextNumeric | gia_nt2 | Giá bán |

#### BOM Section (GroupBox: gbLinhKien)

| Control | Type | DataField | Mô tả |
|---------|------|-----------|-------|
| adgvBoM | AsInputDGV | MA_BOM | Grid linh kiện BOM |
| txtMa_lk | AsTextBox | ma_lk | Mã linh kiện (AutoLookup) |
| txtTen_lk | TextBox | ten_lk | Tên linh kiện |
| txtDvtLk | TextBox | dvt_lk | ĐVT linh kiện |
| txtSo_luong | AsTextNumeric | so_luong | Số lượng |
| txtHe_so | AsTextNumeric | he_so | Hệ số |
| cmdAddPart | Button | - | Thêm linh kiện |
| cmdDeleteLk | Button | - | Xóa linh kiện |
| cmdBo | Button | - | Bỏ qua |

#### DataGridView BOM Columns

| Column | Type | DataPropertyName | Mô tả |
|--------|------|------------------|-------|
| dgvcMa_Lk | DataGridViewTextBoxColumn | ma_lk | Mã linh kiện |
| dgvcTen_lk | DataGridViewTextBoxColumn | ten_lk | Tên linh kiện |
| dgvcDvt | DataGridViewTextBoxColumn | dvt_lk | Đơn vị tính |
| dgvcSo_luong | DataGridViewAsTextNumericColumn | so_luong | Số lượng |
| dgvcHe_so | DataGridViewAsTextNumericColumn | he_so | Hệ số quy đổi |

---

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| SP_IN_DMVAT_GET | Lấy danh sách vật tư |
| SP_IN_DMVAT_GETBYID | Lấy chi tiết 1 vật tư |
| SP_IN_DMVAT_INSERT | Thêm vật tư mới |
| SP_IN_DMVAT_UPDATE | Cập nhật vật tư |
| SP_IN_DMVAT_DELETE | Xóa vật tư |
| SP_IN_DMVAT_FIND | Tìm kiếm vật tư |
| SP_MA_BOM_GET | Lấy danh sách BOM cho 1 vật tư |
| SP_MA_BOM_INSERT | Thêm linh kiện BOM |
| SP_MA_BOM_DELETE | Xóa linh kiện BOM |

### SP_INSERT (reference)

```sql
EXEC SP_IN_DMVAT_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_vt VARCHAR(50),
    @pTen_vt NVARCHAR(200),
    @pMa_nhvt VARCHAR(50),
    @pDvt VARCHAR(20),
    @pLoai INT,
    @pTon_kho BIT,
    @pGia_ton INT,
    @pMa_nhvat VARCHAR(50),
    @pTk_vt VARCHAR(20),
    @pTk_dt VARCHAR(20),
    @pTk_dt_nb VARCHAR(20),
    @pTk_gv VARCHAR(20),
    @pTk_tl VARCHAR(20),
    @pTk_ck VARCHAR(20),
    @pTs_gtgt DECIMAL(10,2),
    @pTs_ttdb DECIMAL(10,2),
    @pTs_nk DECIMAL(10,2),
    @pTs_xk DECIMAL(10,2),
    @pMa_thue VARCHAR(50),
    @pSl_min DECIMAL(18,4),
    @pSl_max DECIMAL(18,4),
    @pMa_kho VARCHAR(50),
    @pDvt_mua VARCHAR(20),
    @pDvt_ban VARCHAR(20),
    @pHs_dvtmua DECIMAL(10,4),
    @pHs_dvtban DECIMAL(10,4),
    @pGia_nt0 DECIMAL(18,4),
    @pGia_nt2 DECIMAL(18,4),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_vt | 'Mã vật tư không được trống' |
| Max length 50 | ma_vt | 'Mã vật tư tối đa 50 ký tự' |
| Unique | ma_vt | 'Mã vật tư đã tồn tại' |
| Required | ten_vt | 'Tên vật tư không được trống' |
| Required | dvt | 'Đơn vị tính không được trống' |
| Required | ma_nhvt | 'Nhóm vật tư không được trống' |

### Business Rules

1. **Mã vật tư**:
   - AutoGenerate nếu để trống (VT + stt_rec)
   - Không cho phép sửa khi đã có giao dịch

2. **Tài khoản kế toán**:
   - AutoLookup từ DMTK
   - Hiển thị tên tài khoản

3. **BOM (Bill of Materials)**:
   - Quản lý trong transaction (thêm/sửa/xóa vật tư + BOM cùng lúc)
   - Grid nhập liệu linh kiện (AsInputDGV)
   - AutoLookup mã linh kiện từ INDVVT
   - Validate: linh kiện không được trùng trong cùng 1 BOM
   - cmdAddPart: thêm dòng mới vào grid
   - cmdDeleteLk: xóa dòng đã chọn
   - DictionaryController cho MA_BOM

4. **Đơn vị tính**:
   - Mặc định: Cái, Chiếc, Con, Cặp, Bộ, Đôi
   - Hỗ trợ ĐVT mua/bán khác nhau với hệ số quy đổi

5. **Xóa vật tư**:
   - Kiểm tra không có giao dịch liên quan
   - Kiểm tra không có BOM con (vật tư cha của BOM khác)

---

## Mapping PHP

### 1. Model - Vật tư

```php
// app/Models/IN/INDVVT.php
namespace Diepxuan\Simba\Models\IN;

class INDVVT extends Model
{
    protected $table = 'INDVVT';
    protected $primaryKey = 'ma_vt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_vt', 'ten_vt', 'ma_nhvt', 'dvt', 'loai', 'ton_kho',
        'gia_ton', 'ma_nhvat', 'tk_vt', 'tk_dt', 'tk_dt_nb',
        'tk_gv', 'tk_tl', 'tk_ck', 'ts_gtgt', 'ts_ttdb',
        'ts_nk', 'ts_xk', 'ma_thue', 'sl_min', 'sl_max',
        'ma_kho', 'dvt_mua', 'dvt_ban', 'hs_dvtmua', 'hs_dvtban',
        'gia_nt0', 'gia_nt2',
    ];

    protected $casts = [
        'ton_kho' => 'boolean',
        'loai' => 'integer',
        'gia_ton' => 'integer',
        'ts_gtgt' => 'decimal:2',
        'ts_ttdb' => 'decimal:2',
        'ts_nk' => 'decimal:2',
        'ts_xk' => 'decimal:2',
        'sl_min' => 'decimal:4',
        'sl_max' => 'decimal:4',
        'hs_dvtmua' => 'decimal:4',
        'hs_dvtban' => 'decimal:4',
        'gia_nt0' => 'decimal:4',
        'gia_nt2' => 'decimal:4',
    ];

    public function nhomVatTu()
    {
        return $this->belongsTo(DMNHVT::class, 'ma_nhvt', 'ma_nhvt');
    }

    public function kho()
    {
        return $this->belongsTo(DMKHO::class, 'ma_kho', 'ma_kho');
    }

    public function boms()
    {
        return $this->hasMany(MABOM::class, 'ma_vt', 'ma_vt');
    }
}
```

### 2. Model - BOM

```php
// app/Models/IN/MABOM.php
namespace Diepxuan\Simba\Models\IN;

class MABOM extends Model
{
    protected $table = 'MA_BOM';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_vt', 'ma_lk', 'so_luong', 'he_so', 'dvt_lk'];

    protected $casts = [
        'so_luong' => 'decimal:4',
        'he_so' => 'decimal:4',
    ];

    public function vatTu()
    {
        return $this->belongsTo(INDVVT::class, 'ma_vt', 'ma_vt');
    }

    public function linhKien()
    {
        return $this->belongsTo(INDVVT::class, 'ma_lk', 'ma_vt');
    }
}
```

### 3. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetDMVAT.php
class AsINGetDMVAT extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMVAT_GET';
    protected $params = ['pMa_cty', 'pSearch', 'pPageIndex', 'pPageSize'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINInsDMVAT.php
class AsINInsDMVAT extends StoredProcedure
{
    protected $procedure = 'SP_IN_DMVAT_INSERT';
    // ... params
}

// diepxuan/laravel-simba/src/StoredProcedures/AsINUpdDMVAT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsINDelDMVAT.php
// diepxuan/laravel-simba/src/StoredProcedures/AsINGetMABOM.php
// diepxuan/laravel-simba/src/StoredProcedures/AsINInsMABOM.php
// diepxuan/laravel-simba/src/StoredProcedures/AsINDelMABOM.php
```

### 4. Livewire Component (List)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/Vattubom.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class Vattubom extends Component
{
    const MA_CT = 'IN';

    public Collection $pVatTus;
    public string $pSearch = '';
    public int $pPageIndex = 1;
    public int $pPageSize = 50;

    public function loadVatTu(): void
    {
        // Load từ Stored Procedure SP_IN_DMVAT_GET
    }

    public function render(): View
    {
        return view('catalog::in.danhmuc.vattubom');
    }
}
```

### 5. Livewire Component (Edit + BOM)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Danhmuc/VattubomEdit.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Danhmuc;

class VattubomEdit extends Component
{
    public ?string $pMa_Vt = null;
    public string $pTen_Vt = '';
    public ?string $pMa_Nhvt = null;
    public string $pDvt = '';
    public int $pLoai = 1;
    public bool $pTon_kho = true;
    public int $pGia_ton = 1;
    // ... (các field còn lại)
    public array $pBoM = []; // BOM linh kiện

    protected $rules = [
        'pMa_Vt' => 'required|string|max:50',
        'pTen_Vt' => 'required|string|max:200',
        'pDvt' => 'required|string|max:20',
        'pMa_Nhvt' => 'required|string|max:50',
    ];

    public function submit(): void
    {
        $this->validate();
        DB::transaction(function () {
            // Insert/Update vật tư
            // Insert/Update/Delete BOM (so sánh mảng cũ/mới)
        });
    }

    public function addBomLine(): void
    {
        $this->pBoM[] = ['ma_lk' => '', 'ten_lk' => '', 'dvt_lk' => '', 'so_luong' => 0, 'he_so' => 1];
    }

    public function deleteBomLine(int $index): void
    {
        unset($this->pBoM[$index]);
        $this->pBoM = array_values($this->pBoM);
    }

    public function render(): View
    {
        return view('catalog::in.danhmuc.vattubom-edit');
    }
}
```

### 6. Views

```
resources/views/catalog/in/danhmuc/
├── vattubom.blade.php              (List page)
├── vattubom-edit.blade.php         (Modal edit + BOM grid)
└── _vattubom-bom-row.blade.php     (BOM row component)
```

### 7. Routes

```php
Route::prefix('catalog/in/danhmuc')
    ->name('catalog.in.danhmuc.')
    ->group(function () {
        Route::get('/vattu-bom', [Vattubom::class, 'render'])
            ->name('vattubom');
        Route::get('/vattu-bom/edit/{maVt?}', [VattubomEdit::class, 'render'])
            ->name('vattubom.edit');
    });
```

---

## Dependencies

| Loại | Package | File | Ghi chú |
|------|---------|------|---------|
| Model | laravel-simba | INDVVT.php | Chính |
| Model | laravel-simba | MABOM.php | BOM |
| Model | laravel-simba | DMNHVT.php | Liên quan (FK) |
| Model | laravel-simba | DMKHO.php | Liên quan (FK) |
| Model | laravel-simba | DMTK.php | Liên quan (FK) |
| SP | laravel-simba | AsINGetDMVAT.php | Chính |
| SP | laravel-simba | AsINInsDMVAT.php | Insert |
| SP | laravel-simba | AsINUpdDMVAT.php | Update |
| SP | laravel-simba | AsINDelDMVAT.php | Delete |
| SP | laravel-simba | AsINGetMABOM.php | BOM GET |
| SP | laravel-simba | AsINInsMABOM.php | BOM Insert |
| SP | laravel-simba | AsINDelMABOM.php | BOM Delete |
| Component | laravel-catalog | Vattubom.php | List |
| Component | laravel-catalog | VattubomEdit.php | Edit + BOM |

---

## Progress Checklist

- [ ] Phân tích yêu cầu & review task này
- [ ] Tạo Stored Procedure classes (Get, Insert, Update, Delete, BOM)
- [ ] Tạo Model INDVVT + MABOM
- [ ] Tạo Livewire Vattubom (list)
- [ ] Tạo Livewire VattubomEdit (modal + BOM grid)
- [ ] Tạo Views (list + edit + BOM row)
- [ ] Thêm Routes
- [ ] Test CRUD vật tư
- [ ] Test CRUD BOM (thêm/xóa linh kiện)
- [ ] Test transaction (lưu vật tư + BOM cùng lúc)
- [ ] Test Integration với DMNHVT, DMKHO, DMTK

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.355`
