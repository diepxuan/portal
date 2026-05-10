# Task 201: SO-Bang-Ke-Chung-Tu-Ban-Hang-01

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bang ke chung tu ban hang (BK01) tu .NET sang PHP Laravel, dat ket qua tuong duong SORptBK01.

## Chi tiet
- **DLL:** SORptBK01.dll
- **Chuc nang:** Bang ke chung tu ban hang (Sale Voucher Register)
- **Loai:** Report (RPT)
- **Assembly Title:** Asia Enterprise
- **Version:** 14.1.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO (tat ca loai chung tu SO)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SORptBK01.dll/README.md`

---

## Cau truc du lieu

### Du lieu master-detail (2 DataGridView)

#### Bang: PH (Phieu - Master)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record |
| ngay_ct | datetime | Ngay chung tu |
| so_ct | varchar | So chung tu |
| ma_kh | varchar | Ma khach hang |
| ten_kh | nvarchar | Ten khach hang |
| t_tien_nt2 | decimal | Tong tien NT |
| t_tien2 | decimal | Tong tien VND |
| t_thue_nt | decimal | Tong thue NT |
| t_thue | decimal | Tong thue VND |
| t_tt_nt | decimal | Tong thanh toan NT |
| t_tt | decimal | Tong thanh toan VND |

#### Bang: CT (Chi tiet - Detail)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| stt_rec | varchar | So thu tu record (FK) |
| stt_rec0 | varchar | So thu tu chi tiet |
| ma_vt | varchar | Ma vat tu |
| ten_vt | nvarchar | Ten vat tu |
| dvt | nvarchar | Don vi tinh |
| ma_kho | varchar | Ma kho |
| so_luong | decimal | So luong |
| gia_nt2 | decimal | Gia NT |
| tien_nt2 | decimal | Tien NT |
| ts_gtgt | decimal | Thue suat GTGT |
| thue_gtgt_nt | decimal | Thue NT |
| gia2 | decimal | Gia VND |
| tien2 | decimal | Tien VND |
| ma_nvkd | varchar | Ma nhan vien kinh doanh |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| PH (SO1-SO5) | Cac phieu ban hang | PK stt_rec |
| CT (SO2-SO4) | Chi tiet ban hang | FK stt_rec |
| DMKH | Khach hang | FK ma_kh |
| DMVT | Vat tu | FK ma_vt |
| DMKHO | Kho | FK ma_kho |
| DMNHKH | Nhom khach hang | Lookup |
| DMPLVT | Phan loai vat tu | Lookup |

---

## Form classes

### frmSORptBK01 (Form bao cao chinh)
- **Ke thua:** frmReport2DGV
- **Chuc nang:** Hien thi bang ke 2 DataGridView: phieu (ph) va chi tiet (ct)
- **Controls:**

#### TabFilter

| Control | Type | Mo ta |
|---------|------|-------|
| cboMau_bc | ComboBox | Chon mau bao cao |
| cboKyBc | ComboBox | Chon ky bao cao |
| txtNgay1 | AsMaskedTextBox | Ngay bat dau |
| txtNgay2 | AsMaskedTextBox | Ngay ket thuc |
| txtTieu_De | TextBox | Tieu de bao cao |
| txtSo_ct1 | TextBox | So chung tu tu |
| txtSo_ct2 | TextBox | So chung tu den |
| cboLoaiPhieu | AsComboBox | Loai phieu (SO1-SO5) |
| cboTrang_Thai | AsComboBox | Trang thai |
| txtMa_kh | AsTextBox | Ma khach hang |
| txtMa_Nhkh | AsTextBox | Nhom khach hang |
| txtMa_Plkh1 | AsTextBox | Phan loai KH 1 |
| txtMa_Plkh2 | AsTextBox | Phan loai KH 2 |
| txtMa_Plkh3 | AsTextBox | Phan loai KH 3 |
| txtMa_hd | AsTextBox | Ma hop dong |
| txtMa_nhhd | AsTextBox | Nhom hop dong |
| txtMa_vt | AsTextBox | Ma vat tu |
| txtMa_nhvt | AsTextBox | Nhom vat tu |
| txtMa_plvt1 | AsTextBox | Phan loai VT 1 |
| txtMa_plvt2 | AsTextBox | Phan loai VT 2 |
| txtMa_plvt3 | AsTextBox | Phan loai VT 3 |
| txtMa_kho | AsTextBox | Ma kho |
| txtMa_bp | AsTextBox | Ma bo phan |
| txtMa_nvkd | AsTextBox | Ma nhan vien kinh doanh |
| txtMA_HTTT | AsTextBox | Hinh thuc thanh toan |
| txtMA_DKTT | AsTextBox | Dieu khoan thanh toan |
| txtMa_vitri | AsTextBox | Ma vi tri |
| txtMaLo | AsTextBox | Ma lo |
| txtMa_spct | AsTextBox | Ma san pham chi tiet |
| txtMa_Nt | AsTextBox | Ma ngoai te |
| optVND | RadioButton | Tien VND |
| optNt | RadioButton | Tien ngoai te |
| crvReportViewer | CrystalReportViewer | Viewer bao cao |

#### Labels hien thi ten (AutoLookup)

| Label | Mo ta |
|-------|-------|
| lblTen_KH | Ten khach hang |
| lblTen_nhkh | Ten nhom khach hang |
| lblTen_lkh1-lkh3 | Ten phan loai KH |
| lblTen_vt | Ten vat tu |
| lblTen_Nhvt | Ten nhom vat tu |
| lblTen_plvt1-plvt3 | Ten phan loai VT |
| lblTen_kho | Ten kho |
| lblTen_bp | Ten bo phan |
| lblTen_nvkd | Ten nhan vien KD |
| lblTenHTTT | Ten HTTT |
| lblTen_TT | Ten dieu khoan TT |
| lblTen_lo | Ten lo |
| lblTen_spct | Ten san pham CT |

#### DataGridViews

| Control | Mo ta |
|---------|-------|
| dgvBCPh | Grid hien thi danh sach phieu |
| dgvBCCt | Grid hien thi chi tiet (loc theo phieu) |

### Layout Grid

```
SplitContainer (scGrid)
├── dgvBCPh (tren) - Danh sach phieu
└── dgvBCCt (duoi) - Chi tiet phieu duoc chon
```

---

## Business Logic

### InitOtherComponents()

```csharp
ArrayList arrayList = new ArrayList();
arrayList.Add(CompanyInformations.CompanyID);
arrayList.Add(MyMenuInfo.moduleid);
arrayList.Add("0");  // Khong loc theo loai CT
arrayList.Add(SystemInformations.CurrentCultureName);

ArrayList arrayList2 = CBO<lstVoucherInfo>.FillCollection(
    Commons.GetDataReader("asSIGetDmSo_ct", arrayList.ToArray()));
arrayList2.Add(new lstVoucherInfo("", "Tat ca")); // Them option "Tat ca"
cboLoaiPhieu.DataSource = arrayList2;
```

### LoadData()

```csharp
DataSet dataSet = MyController.GetDataSet(arrayList.ToArray());

// Set nguon cho 2 grid
set_MyDGVPhSource(isSet2Print: true, dataSet.Tables[1]);  // Phieu
set_MyDGVCtSource(isSet2Print: true, dataSet.Tables[0]);  // Chi tiet
```

### dgvBCPh_RowEnter()

Loc chi tiet theo phieu duoc chon:

```csharp
((DataTable)dgvBCCt.DataSource).DefaultView.RowFilter =
    "stt_rec='" + ((DataTable)dgvBCPh.DataSource).DefaultView[e.RowIndex]["stt_rec"].ToString() + "'";
```

### GetFilterTitle()

Xay dung chuoi tieu de loc tu cac dieu kien da chon.

### Loc theo loai phieu

- Tat ca chung tu SO1, SO2, SO3, SO4, SO5
- Hoac chi mot loai cu the

---

## Mapping PHP

### 1. Model (Data Transfer)

```php
// app/Models/SO/SORptBK01.php
namespace Diepxuan\Simba\Models\SO;

class SORptBK01 extends Model
{
    protected $connection = 'simba';

    // No table - su dung SP

    public static function getBangKe(array $params): array
    {
        // Goi SP_SO_BK01_GET
        return [
            'ph' => [], // Phieu master
            'ct' => [], // Chi tiet detail
        ];
    }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetRptBK01.php
class AsSOGetRptBK01 extends StoredProcedure
{
    protected $procedure = 'SP_SO_BK01_GET';
    protected $params = [
        'pMa_cty', 'pMa_ct_list', 'pNgay1', 'pNgay2',
        'pSo_ct1', 'pSo_ct2',
        'pMa_kh', 'pMa_nhkh', 'pMa_plkh1', 'pMa_plkh2', 'pMa_plkh3',
        'pMa_hd', 'pMa_nhhd',
        'pMa_vt', 'pMa_nhvt', 'pMa_plvt1', 'pMa_plvt2', 'pMa_plvt3',
        'pMa_kho', 'pMa_bp', 'pMa_nvkd',
        'pMa_httt', 'pMa_dktt',
        'pMa_vitri', 'pMa_lo', 'pMa_spct',
        'pMa_nt', 'pIsNt',
    ];
}
```

### 3. Livewire Component (Report)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Bangkebanhang01.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Bangkebanhang01;

class Bangkebanhang01 extends Component
{
    public string $pTieuDe = 'Bang ke chung tu ban hang';
    public ?string $pNgay1 = null;
    public ?string $pNgay2 = null;
    public string $pMaCtList = ''; // Comma-separated: SO1,SO2,SO3,SO4,SO5
    public string $pSoCt1 = '';
    public string $pSoCt2 = '';
    public ?string $pMaKh = null;
    public ?string $pMaNhkh = null;
    public ?string $pMaPlkh1 = null;
    public ?string $pMaPlkh2 = null;
    public ?string $pMaPlkh3 = null;
    public ?string $pMaHd = null;
    public ?string $pMaNhhd = null;
    public ?string $pMaVt = null;
    public ?string $pMaNhvt = null;
    public ?string $pMaPlvt1 = null;
    public ?string $pMaPlvt2 = null;
    public ?string $pMaPlvt3 = null;
    public ?string $pMaKho = null;
    public ?string $pMaBp = null;
    public ?string $pMaNvkd = null;
    public ?string $pMaHttt = null;
    public ?string $pMaDktt = null;
    public ?string $pMaVitri = null;
    public ?string $pMaLo = null;
    public ?string $pMaSpct = null;
    public string $pMaNt = 'VND';
    public bool $pIsNt = false;

    public Collection $pPhieuList;
    public Collection $pChiTietList;

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        // Goi SP lay du lieu 2 bang
        $data = AsSOGetRptBK01::execute($this->buildParams());
        $this->pPhieuList = collect($data['ph']);
        $this->pChiTietList = collect($data['ct']);
    }

    public function rowEnter(int $rowIndex): void
    {
        $sttRec = $this->pPhieuList[$rowIndex]['stt_rec'] ?? '';
        $this->pChiTietFiltered = $this->pChiTietList->where('stt_rec', $sttRec);
    }

    protected function buildParams(): array
    {
        return [
            'pMa_cty' => auth()->user()->ma_cty,
            'pMa_ct_list' => $this->pMaCtList,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pSo_ct1' => $this->pSoCt1,
            'pSo_ct2' => $this->pSoCt2,
            // ... cac param khac
        ];
    }

    public function render(): View
    {
        return view('catalog::so.bangkebanhang01');
    }
}
```

### 4. Views

```html
<!-- resources/views/catalog/so/bangkebanhang01.blade.php -->
<div>
    <!-- Filter controls -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label>Tu ngay</label>
            <input type="date" wire:model="pNgay1" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Den ngay</label>
            <input type="date" wire:model="pNgay2" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Loai phieu</label>
            <select wire:model="pMaCtList" class="form-select">
                <option value="">Tat ca</option>
                <option value="SO1">Phieu xuat ban le</option>
                <option value="SO3">Hoa don ban hang</option>
                <option value="SO5">Hoa don dich vu</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Tien</label>
            <div class="btn-group">
                <button class="btn btn-sm {{ !$pIsNt ? 'btn-primary' : 'btn-outline-secondary' }}"
                    wire:click="$set('pIsNt', false)">VND</button>
                <button class="btn btn-sm {{ $pIsNt ? 'btn-primary' : 'btn-outline-secondary' }}"
                    wire:click="$set('pIsNt', true)">NT</button>
            </div>
        </div>
    </div>

    <!-- Master Grid (Phieu) -->
    <div class="mb-3">
        <h6>Danh sach phieu</h6>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Ngay CT</th>
                    <th>So CT</th>
                    <th>Khach hang</th>
                    <th>Tien</th>
                    <th>Thue</th>
                    <th>Thanh toan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pPhieuList as $i => $ph)
                <tr wire:click="rowEnter({{ $i }})"
                    class="{{ isset($selectedIndex) && $selectedIndex === $i ? 'table-primary' : '' }}">
                    <td>{{ $ph['ngay_ct'] }}</td>
                    <td>{{ $ph['so_ct'] }}</td>
                    <td>{{ $ph['ten_kh'] }}</td>
                    <td class="text-right">{{ number_format($ph['t_tien2']) }}</td>
                    <td class="text-right">{{ number_format($ph['t_thue2']) }}</td>
                    <td class="text-right">{{ number_format($ph['t_tt2']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Detail Grid (Chi tiet) -->
    <div>
        <h6>Chi tiet</h6>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Ma VT</th>
                    <th>Ten VT</th>
                    <th>DVT</th>
                    <th>Kho</th>
                    <th>So luong</th>
                    <th>Gia</th>
                    <th>Tien</th>
                    <th>Thue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pChiTietFiltered as $ct)
                <tr>
                    <td>{{ $ct['ma_vt'] }}</td>
                    <td>{{ $ct['ten_vt'] }}</td>
                    <td>{{ $ct['dvt'] }}</td>
                    <td>{{ $ct['ma_kho'] }}</td>
                    <td class="text-right">{{ number_format($ct['so_luong'], 2) }}</td>
                    <td class="text-right">{{ number_format($ct['gia2']) }}</td>
                    <td class="text-right">{{ number_format($ct['tien2']) }}</td>
                    <td class="text-right">{{ number_format($ct['thue_gtgt']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Export buttons -->
    <div class="mt-3">
        <button class="btn btn-primary" wire:click="exportExcel">Export Excel</button>
        <button class="btn btn-secondary" wire:click="exportPdf">Export PDF</button>
    </div>
</div>
```

### 5. Routes

```php
Route::prefix('catalog/so')
    ->name('catalog.so.')
    ->group(function () {
        Route::get('/bang-ke-ban-hang-01', [Bangkebanhang01::class, 'render'])
            ->name('bangkebanhang01');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SORptBK01.php | Data transfer |
| SP | laravel-simba | AsSOGetRptBK01.php | Get data |
| Component | laravel-catalog | Bangkebanhang01.php | Report component |
| View | laravel-catalog | bangkebanhang01.blade.php | Report view |
| Filter | laravel-catalog | BangKeBanHangFilters.php | Filter components |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure class AsSOGetRptBK01
- [ ] Tao Livewire Bangkebanhang01 component
- [ ] Tao View voi 2 DataGridView (master-detail)
- [ ] Implement rowEnter de loc chi tiet
- [ ] Them filter controls (ngay, loai phieu, KH, VT, kho...)
- [ ] Them Routes
- [ ] Test export Excel/PDF
- [ ] Test filter va loc chi tiet
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
