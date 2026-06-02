# Task 051: SOND51mhd

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc mau hoa don tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SOND51mhd.dll
- **Chuc nang:** Quan ly danh muc mau hoa don (Khổ/bảng in hóa đơn)
- **Loai:** Danh muc (DM)
- **Assembly Title:** SOKBMHD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** MH (Mau hoa don)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51mhd.dll/README.md`

---

## Cau truc du lieu

### Bang: DMMHD (Danh muc mau hoa don)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_loai | varchar | 20 | Ma loai hoa don (khoa chinh) |
| ten_mau | nvarchar | 200 | Ten mau hoa don |
| loai_in | varchar | 1 | Loai in (T: Tu in, P: Dat in) |
| kh_hd | varchar | 10 | Ky hieu hoa don |
| kh_nam | varchar | 10 | Ky hieu nam |
| lien | int | 2 | So lien hoa don (2-9) |
| so_hd | int | 4 | So hoa don |
| mau_so | varchar | 50 | Mau so (auto: ma_loai + lien + "/" + so_hd) |
| so_seri | varchar | 50 | So seri (auto: kh_hd + "/" + kh_nam + loai_in) |
| so_dong | int | 2 | So dong tren hoa don |
| ghi_chu | nvarchar | 500 | Ghi chu |
| ksd | bit | 1 | Khoa su dung |

### Bang: DMMHDLIEN (Chi tiet lien hoa don)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_loai | varchar | Ma loai (FK) |
| lien | int | So lien |
| mota | varchar | Mo ta (VD: "Lien 1: Giao khach hang") |

---

## Form classes

### 1. frmSOND51mhd (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach mau hoa don
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvDM | DataGridView | Luoi hien thi danh sach |
| txtSearch | TextBox | Tim kiem |
| btnAdd | Button | Nut them moi |
| btnEdit | Button | Nut sua |
| btnDelete | Button | Nut xoa |

### 2. frmSOND51mhdEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Chuc nang:** Nhap, sua thong tin mau hoa don
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_loai | AsTextBox | ma_loai | Ma loai hoa don |
| txtTen_mau | TextBox | ten_mau | Ten mau hoa don |
| cboLoai_in | ComboBox | loai_in | Loai in (T/P) |
| txtKh_hd | AsTextBox | kh_hd | Ky hieu hoa don |
| txtKh_nam | AsTextNumeric | kh_nam | Ky hieu nam |
| txtLien | AsTextNumeric | lien | So lien (2-9) |
| txtSo_hd | AsTextNumeric | so_hd | So hoa don |
| txtMau_so | TextBox | mau_so | Mau so (auto, readonly) |
| txtSo_seri | TextBox | so_seri | So seri (auto, readonly) |
| txtSo_dong | AsTextNumeric | so_dong | So dong |
| dgvLien | DataGridView | - | Chi tiet lien hoa don |
| txtGhi_chu | TextBox | ghi_chu | Ghi chu |
| btnSave | Button | - | Nut luu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_MHD_GET | Lay danh sach mau hoa don |
| SP_SO_MHD_GETBYID | Lay chi tiet 1 mau hoa don |
| SP_SO_MHD_INSERT | Them mau hoa don moi |
| SP_SO_MHD_UPDATE | Cap nhat mau hoa don |
| SP_SO_MHD_DELETE | Xoa mau hoa don |
| SP_SO_MHD_FIND | Tim kiem |
| SP_SO_MHD_CHECK | Kiem tra trung ma |

---

## Business Logic

### Auto-generate Fields

```php
// Mau so: ma_loai + lien + "/" + so_hd (with leading zeros)
// VD: "01/0001" neu ma_loai="01", lien=1, so_hd=1

// So seri: kh_hd + "/" + kh_nam + loai_in
// VD: "AA/2024T" neu kh_hd="AA", kh_nam="2024", loai_in="T"
```

### Validation Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_loai | 'Ma loai hoa don khong duoc trong' |
| Required | ten_mau | 'Ten mau khong duoc trong' |
| Required | loai_in | 'Loai in khong duoc trong' |
| Required | kh_hd | 'Ky hieu hoa don khong duoc trong' |
| Required | kh_nam | 'Ky hieu nam khong duoc trong' |
| Required | so_dong | 'So dong khong duoc trong' |
| Range | lien | 'So lien phai tu 2-9' |
| Min | so_hd | 'So hoa don phai >= 1' |
| Min | kh_nam | 'Ky hieu nam phai >= 1' |
| Motilien | mota | 'Mo ta lien phai bat dau bang "Lien X:"' |

### Default Lien Descriptions

| Lien | Mo ta mac dinh |
|------|----------------|
| 1 | Lien 1: Giao khach hang |
| 2 | Lien 2: Luu cot nha cung cap |
| 3+ | Lien 3: ... |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMMHD.php
namespace Diepxuan\Simba\Models\SO;

class DMMHD extends Model
{
    protected $table = 'DMMHD';
    protected $primaryKey = 'ma_loai';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_loai', 'ten_mau', 'loai_in', 'kh_hd',
        'kh_nam', 'lien', 'so_hd', 'mau_so', 'so_seri',
        'so_dong', 'ghi_chu', 'ksd',
    ];

    protected $casts = [
        'lien' => 'integer',
        'so_hd' => 'integer',
        'so_dong' => 'integer',
        'ksd' => 'boolean',
    ];

    // Relationships
    public function chiTietLien()
    {
        return $this->hasMany(DMMHDLien::class, 'ma_loai', 'ma_loai');
    }

    // Auto-generate
    public function generateMauSo(): string
    {
        $lienStr = str_pad($this->lien, 2, '0', STR_PAD_LEFT);
        $soHdStr = str_pad($this->so_hd, 4, '0', STR_PAD_LEFT);
        return "{$this->ma_loai}{$lienStr}/{$soHdStr}";
    }

    public function generateSoSeri(): string
    {
        return "{$this->kh_hd}/{$this->kh_nam}{$this->loai_in}";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ksd', false);
    }
}

// app/Models/SO/DMMHDLien.php
class DMMHDLien extends Model
{
    protected $table = 'DMMHDLIEN';
    protected $primaryKey = ['ma_loai', 'lien'];
    public $incrementing = false;
    protected $connection = 'simba';
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/Mauhoadon.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Danhmuc;

class Mauhoadon extends Component
{
    const MA_CT = 'MH';

    public Collection $pMauHoadons;
    public string $pSearch = '';

    public function mount(): void
    {
        $this->loadMauHoadon();
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.mauhoadon');
    }
}

// diepxuan/laravel-catalog/src/Http/Livewire/SO/Danhmuc/MauhoadonEdit.php
class MauhoadonEdit extends Component
{
    public ?string $pMa_Loai = null;
    public string $pTen_Mau = '';
    public string $pLoai_In = 'T';
    public string $pKh_Hd = '';
    public int $pKh_Nam = 0;
    public int $pLien = 2;
    public int $pSo_Hd = 1;
    public string $pMau_So = '';
    public string $pSo_Seri = '';
    public int $pSo_Dong = 10;
    public string $pGhi_Chu = '';
    public array $pChiTietLien = [];
    public ?string $pMode = 'create';

    protected $rules = [
        'pMa_Loai' => 'required|string|max:20',
        'pTen_Mau' => 'required|string|max:200',
        'pLoai_In' => 'required|in:T,P',
        'pKh_Hd' => 'required|string|max:10',
        'pKh_Nam' => 'required|integer|min:1',
        'pLien' => 'required|integer|min:2|max:9',
        'pSo_Hd' => 'required|integer|min:1',
        'pSo_Dong' => 'required|integer|min:1',
    ];

    public function updatedPMaLoai($value): void { $this->regenerateCodes(); }
    public function updatedPLien($value): void { $this->regenerateCodes(); $this->updateLienGrid(); }
    public function updatedPSoHd($value): void { $this->regenerateCodes(); }
    public function updatedPKhHd($value): void { $this->regenerateCodes(); }
    public function updatedPKhNam($value): void { $this->regenerateCodes(); }
    public function updatedPLoaiIn($value): void { $this->regenerateCodes(); }

    protected function regenerateCodes(): void
    {
        // Auto-generate mau_so and so_seri
    }

    protected function updateLienGrid(): void
    {
        // Sync chi tiet lien grid
    }

    public function render(): View
    {
        return view('catalog::so.danhmuc.mauhoadon-edit');
    }
}
```

### 3. Views

```
resources/views/catalog/so/danhmuc/
├── mauhoadon.blade.php
├── mauhoadon-edit.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/so/danhmuc')
    ->name('catalog.so.danhmuc.')
    ->group(function () {
        Route::get('/mau-hoa-don', [Mauhoadon::class, 'render'])
            ->name('mauhoadon');
        Route::get('/mau-hoa-don/edit/{maLoai?}', [MauhoadonEdit::class, 'render'])
            ->name('mauhoadon.edit');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMMHD.php | Chinh |
| Model | laravel-simba | DMMHDLien.php | Chi tiet lien |
| SP | laravel-simba | SoGetDMMHD.php | Get list |
| SP | laravel-simba | SoInsDMMHD.php | Insert |
| SP | laravel-simba | SoInsDMMHDLien.php | Insert lien |
| Component | laravel-catalog | Mauhoadon.php | List |
| Component | laravel-catalog | MauhoadonEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMMHD, DMMHDLien
- [ ] Tao Livewire Mauhoadon
- [ ] Tao Livewire MauhoadonEdit (voi lien grid)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Auto-generate mau_so, so_seri
- [ ] Test Integration voi SOND51phhd
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `task.339`
