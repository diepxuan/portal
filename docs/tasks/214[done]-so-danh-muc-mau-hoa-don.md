# Task 214: SO-Danh-Muc-Mau-Hoa-Don

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang danh muc mau hoa don tu .NET sang PHP Laravel, dat ket qua tuong duong SOND51dmmhd.

## Chi tiet
- **DLL:** SOND51dmmhd.dll
- **Chuc nang:** Danh muc mau hoa don (Invoice Template Category)
- **Loai:** Danh muc (DM)
- **Assembly Title:** SOKBMHD
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51dmmhd.dll/README.md`

---

## Cau truc du lieu

### Bang: dmmhd (Danh muc mau hoa don)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_loai | varchar | 20 | Ma loai hoa don (khoa chinh) |
| ten_loai | nvarchar | 255 | Ten loai hoa don (read-only) |
| so_lien | int | 1 | So lien (2-9) |
| so_hd | int | 3 | So hoa don (001-999) |
| mau_so | varchar | 20 | Mau so (format: XXN/XXX) |
| ten_mau | nvarchar | 255 | Ten mau hoa don |
| loai_in | varchar | 1 | Loai in (T: Tu in, P: Dat in) |
| kh_hd | varchar | 10 | Ky hieu hoa don |
| kh_nam | int | 2 | Nam ky hieu (2 chu so) |
| so_seri | varchar | 20 | So seri (format: XX/XXT) |
| so_dong | int | 2 | So dong tren hoa don |
| ghi_chu | nvarchar | 255 | Ghi chu |

### Bang: dmmhd_lien (Chi tiet lien hoa don)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_loai | varchar | Ma loai hoa don (FK) |
| lien | int | So lien (1-9) |
| mota | nvarchar | Mo ta lien (VD: "Liên 1: Lưu") |

---

## Form classes

### 1. frmSOND51dmmhd (Form xem danh sach)
- **Ke thua:** frmDMView
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| dgvMauHD | DataGridView | Hien thi danh sach |

### 2. frmSOND51dmmhdEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

#### Thong tin co ban

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtTen_loai | TextBox | ten_loai | Ten loai (readonly) |
| txtMa_loai | AsTextBox | ma_loai | Ma loai (readonly) |
| txtSo_lien | AsTextNumeric | so_lien | So lien (2-9) |
| txtSo_hd | AsTextNumeric | so_hd | So hoa don |
| lblMau_so | Label | mau_so | Mau so (auto) |
| txtTen_mau | TextBox | ten_mau | Ten mau hoa don |

#### Loai in

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| chkTu_in | RadioButton | loai_in | Tu in (T) |
| chkDat_in | RadioButton | loai_in | Dat in (P) |

#### Ky hieu

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtKh_hd | AsTextBox | kh_hd | Ky hieu (2 ky tu) |
| txtKh_nam | AsTextNumeric | kh_nam | Nam (2 so) |
| lblSo_seri | Label | so_seri | So seri (auto) |

#### Khac

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtSo_dong | TextBox | so_dong | So dong |
| txtGhi_chu | TextBox | ghi_chu | Ghi chu |

#### Chi tiet lien (DataGridView)

| Control | Type | Mo ta |
|---------|------|-------|
| adgvLien | AsInputDGV | Danh sach lien |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SO_DMMHD_GET | Lay danh sach |
| SP_SO_DMMHD_GETBYID | Lay chi tiet |
| SP_SO_DMMHD_INSERT | Them moi |
| SP_SO_DMMHD_UPDATE | Cap nhat |
| SP_SO_DMMHD_DELETE | Xoa |

### SP_INSERT (reference)

```sql
EXEC SP_SO_DMMHD_INSERT
    @pMa_cty VARCHAR(50),
    @pMa_loai VARCHAR(20),
    @pSo_lien INT,
    @pSo_hd INT,
    @pMau_so VARCHAR(20),
    @pTen_mau NVARCHAR(255),
    @pLoai_in VARCHAR(1),
    @pKh_hd VARCHAR(10),
    @pKh_nam INT,
    @pSo_seri VARCHAR(20),
    @pSo_dong INT,
    @pGhi_chu NVARCHAR(255),
    @pStatus INT OUTPUT
```

---

## Business Logic

### Tao mau so tu dong

```csharp
// Format: [Ma loai][So lien]/[So HD 3 chu so]
Mau_so = String.Format("{0:D3}", ma_loai) + so_lien.ToString() + "/" + String.Format("{0:D3}", so_hd)
// VD: ma_loai=1, so_lien=2, so_hd=1 -> "012/001"
```

### Tao so seri tu dong

```csharp
// Format: [Ky hieu]/[Nam][Loai in]
So_seri = kh_hd + "/" + kh_nam.ToString("D2") + loai_in
// VD: kh_hd="AA", kh_nam=11, loai_in="T" -> "AA/11T"
```

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | so_lien | 'So lien khong duoc trong' |
| Range 2-9 | so_lien | 'So lien 2-9' |
| Required | so_hd | 'So hoa don khong duoc trong' |
| Range >= 1 | so_hd | 'So hoa don >= 1' |
| Required | ten_mau | 'Ten mau khong duoc trong' |
| Required | kh_hd | 'Ky hieu khong duoc trong' |
| Required | kh_nam | 'Nam ky hieu >= 1' |

### Chi tiet lien

| Rule | Field | Message |
|------|-------|---------|
| Min rows | adgvLien | So lien >= 2 |
| Required | mota | 'Mo ta lien khong duoc trong' |
| Pattern | mota | 'Phai bat dau "Liên X:"' |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMmhd.php
namespace Diepxuan\Simba\Models\SO;

class DMmhd extends Model
{
    protected $table = 'dmmhd';
    protected $primaryKey = 'ma_loai';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    const LOAI_TU_IN = 'T';
    const LOAI_DAT_IN = 'P';

    protected $fillable = [
        'ma_loai', 'ten_loai', 'so_lien', 'so_hd',
        'mau_so', 'ten_mau', 'loai_in', 'kh_hd',
        'kh_nam', 'so_seri', 'so_dong', 'ghi_chu',
    ];

    protected $casts = [
        'so_lien' => 'integer',
        'so_hd' => 'integer',
        'kh_nam' => 'integer',
        'so_dong' => 'integer',
    ];

    public function liens()
    {
        return $this->hasMany(DMmhdLien::class, 'ma_loai', 'ma_loai');
    }

    public function generateMauSo(): string
    {
        return str_pad($this->ma_loai, 3, '0', STR_PAD_LEFT)
            . $this->so_lien . '/'
            . str_pad($this->so_hd, 3, '0', STR_PAD_LEFT);
    }

    public function generateSoSeri(): string
    {
        return $this->kh_hd . '/'
            . str_pad($this->kh_nam, 2, '0', STR_PAD_LEFT)
            . $this->loai_in;
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Mauhoadon.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Mauhoadon;

class Mauhoadon extends Component
{
    public Collection $pList;

    public function render(): View
    {
        return view('catalog::so.mauhoadon');
    }
}
```

### 3. Livewire Component (Edit)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/MauhoadonEdit.php
namespace Diepxuan\Catalog\Http\Livewire\SO\MauhoadonEdit;

class MauhoadonEdit extends Component
{
    public string $pMaLoai = '';
    public string $pTenLoai = '';
    public int $pSoLien = 2;
    public int $pSoHd = 1;
    public string $pMauSo = '';
    public string $pTenMau = '';
    public string $pLoaiIn = 'T';
    public string $pKhHd = '';
    public int $pKhNam = 0;
    public string $pSoSeri = '';
    public int $pSoDong = 20;
    public string $pGhiChu = '';

    public array $pLiens = [];

    protected $rules = [
        'pSoLien' => 'required|integer|min:2|max:9',
        'pSoHd' => 'required|integer|min:1',
        'pTenMau' => 'required|string|max:255',
        'pKhHd' => 'required|string|max:10',
        'pKhNam' => 'required|integer|min:1',
    ];

    public function updatedPMaLoai(): void
    {
        // Load thong tin loai hoa don
    }

    public function updatedPSoLien(): void
    {
        $this->updateMauSo();
        $this->generateLiens();
    }

    public function updatedPSoHd(): void
    {
        $this->updateMauSo();
    }

    public function updatedPKhHd(): void
    {
        $this->updateSoSeri();
    }

    public function updatedPKhNam(): void
    {
        $this->updateSoSeri();
    }

    public function updatedPLoaiIn(): void
    {
        $this->updateSoSeri();
    }

    protected function updateMauSo(): void
    {
        if ($this->pMaLoai && $this->pSoLien && $this->pSoHd) {
            $this->pMauSo = str_pad($this->pMaLoai, 3, '0', STR_PAD_LEFT)
                . $this->pSoLien . '/'
                . str_pad($this->pSoHd, 3, '0', STR_PAD_LEFT);
        }
    }

    protected function updateSoSeri(): void
    {
        if ($this->pKhHd && $this->pKhNam) {
            $this->pSoSeri = $this->pKhHd . '/'
                . str_pad($this->pKhNam, 2, '0', STR_PAD_LEFT)
                . $this->pLoaiIn;
        }
    }

    protected function generateLiens(): void
    {
        $this->pLiens = [];
        for ($i = 1; $i <= $this->pSoLien; $i++) {
            $this->pLiens[] = [
                'lien' => $i,
                'mota' => "Liên {$i}: " . ($i == 1 ? 'Lưu' : ($i == 2 ? 'Giao khách' : "Liên {$i}")),
            ];
        }
    }

    public function submit(): void
    {
        $this->validate();
        // Goi SP
    }

    public function render(): View
    {
        return view('catalog::so.mauhoadon-edit');
    }
}
```

### 4. Views

```
resources/views/catalog/so/
├── mauhoadon/
│   ├── index.blade.php
│   ├── edit.blade.php
```

### 5. Routes

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
| Model | laravel-simba | DMmhd.php | Chinh |
| Model | laravel-simba | DMmhdLien.php | Chi tiet lien |
| Component | laravel-catalog | Mauhoadon.php | List |
| Component | laravel-catalog | MauhoadonEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMmhd, DMmhdLien
- [ ] Tao Livewire Mauhoadon (list)
- [ ] Tao Livewire MauhoadonEdit (edit)
- [ ] Tao auto-generate mau so & so seri
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test auto-generate khi thay doi
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `so.dict.mhd`
- **Note:** Voucher/report/dictionary route shell; write execute chỉ mở khi payload audit đủ.
